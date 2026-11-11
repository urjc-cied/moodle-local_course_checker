<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

namespace coursechecker_structure;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/completionlib.php');

use completion_info;
use core_text;
use local_course_checker\config;
use local_course_checker\db\model\check;
use local_course_checker\model\check_plugin_interface;
use local_course_checker\resolution_link_helper;
use local_course_checker\translation_manager;
use moodle_url;
use stdClass;

/**
 * Checking that a course keeps the structure of the template (the reference course) of its category.
 *
 * @package    coursechecker_structure
 * @copyright  2026 URJCx
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class checker implements check_plugin_interface {
    /** Config setting path for the template course, shared with the other checks. */
    const REFERENCE_COURSE = 'local_course_checker/referencecourseid';
    /** Config setting path for the format that starts the name of a module section. */
    const MODULE_FORMAT = 'coursechecker_structure/moduleformat';
    /** Default value for the format that starts the name of a module section. */
    const MODULE_FORMAT_DEFAULT = 'N.';
    /** Config setting path for the text that the name of an exam contains. */
    const EXAM_TEXT = 'coursechecker_structure/examtext';
    /** Default value for the text that the name of an exam contains. */
    const EXAM_TEXT_DEFAULT = 'Examen';
    /** Config setting path for the name of the forum whose description must have its own rules of use. */
    const RULES_FORUM = 'coursechecker_structure/rulesforum';
    /** Default value for the name of the forum whose description must have its own rules of use. */
    const RULES_FORUM_DEFAULT = 'Foro social';
    /** Language component of this checker. */
    const COMPONENT = 'coursechecker_structure';
    /** Forum settings that must match the template, with the language string of their label. */
    const FORUM_SETTINGS = [
        'type' => ['forumtype', 'forum'],
        'maxbytes' => ['maxattachmentsize', 'forum'],
        'maxattachments' => ['maxattachments', 'forum'],
        'forcesubscribe' => ['subscriptionmode', 'forum'],
        'trackingtype' => ['trackingtype', 'forum'],
        'rsstype' => ['rsstype', 'forum'],
        'rssarticles' => ['rssarticles', 'forum'],
        'warnafter' => ['warnafter', 'forum'],
        'blockafter' => ['blockafter', 'forum'],
        'blockperiod' => ['blockperiod', 'forum'],
        'displaywordcount' => ['displaywordcount', 'forum'],
        'lockdiscussionafter' => ['lockdiscussionafter', 'forum'],
        'assessed' => ['aggregatetype', 'rating'],
        'scale' => ['scale', 'moodle'],
        'grade_forum' => ['grade_forum_title', 'forum'],
        'completiondiscussions' => ['completiondiscussions', 'forum'],
        'completionreplies' => ['completionreplies', 'forum'],
        'completionposts' => ['completionposts', 'forum'],
    ];
    /** Course module settings of a forum that must match the template. */
    const MODULE_SETTINGS = [
        'visible' => ['visible', 'moodle'],
        'groupmode' => ['groupmode', 'group'],
        'completion' => ['completion', 'completion'],
        'completionview' => ['structure_completionview', self::COMPONENT],
    ];
    /** Course module settings with ids of each course, where only being in use can be compared. */
    const MODULE_SETTINGS_IN_USE = [
        'groupingid' => ['grouping', 'group'],
        'availability' => ['accessrestrictions', 'availability'],
    ];

    /** Parts of the course completion with their aggregation, indexed by the language string of their label. */
    const COMPLETION_AGGREGATIONS = [
        'structure_completion_overall' => null,
        'structure_completion_activities' => COMPLETION_CRITERIA_TYPE_ACTIVITY,
    ];

    /** @var check The result of the check. */
    protected check $check;
    /** @var bool Whether a failure or a warning has been reported. */
    protected bool $hasissues = false;

    /**
     * Runs the checker.
     *
     * @param stdClass $course
     * @param check $check
     * @return void
     * @throws \coding_exception
     * @throws \moodle_exception
     */
    public function run(stdClass $course, check $check): void {
        global $DB;

        $this->check = $check;
        $this->hasissues = false;
        $link = resolution_link_helper::get_link_to_course_view_page($course->id);
        $title = translation_manager::generate('structure_course', self::COMPONENT);

        $templateid = (int) config::get(self::REFERENCE_COURSE, SITEID);
        if ($course->id == $templateid) {
            $check->add_info($title, $link, translation_manager::generate('structure_is_template', self::COMPONENT));
            return;
        }
        if ($templateid <= SITEID || !$DB->record_exists('course', ['id' => $templateid])) {
            $check->add_error($title, $link, translation_manager::generate('structure_template_missing', self::COMPONENT));
            return;
        }
        $template = get_course($templateid);
        if (!$this->in_template_category($course, $template)) {
            $check->add_info($title, $link, translation_manager::generate('structure_not_applicable', self::COMPONENT));
            return;
        }

        $moduleformat = trim((string) config::get(self::MODULE_FORMAT, self::MODULE_FORMAT_DEFAULT));
        $examtext = trim((string) config::get(self::EXAM_TEXT, self::EXAM_TEXT_DEFAULT));
        if (strrpos($moduleformat, 'N') === false) {
            $check->add_error($title, $link, translation_manager::generate(
                'structure_format_invalid',
                self::COMPONENT,
                ['format' => $moduleformat]
            ));
            return;
        }

        $pattern = $this->get_module_pattern($moduleformat);
        $structure = $this->get_template_structure($this->get_sections($template), $pattern, $moduleformat);
        if ($structure === null) {
            $check->add_error($title, $link, translation_manager::generate(
                'structure_template_invalid',
                self::COMPONENT,
                ['format' => $moduleformat]
            ));
            return;
        }

        $sections = $this->get_sections($course);
        [$fixed, $modules] = $this->check_sections($sections, $structure, $pattern, $moduleformat, $title, $link);
        $this->check_forums($structure, $fixed);
        $this->check_exams($fixed, $modules, $examtext);
        $this->check_course_completion($course, $template, $examtext);

        if (!$this->hasissues) {
            $check->add_successful($title, $link, translation_manager::generate(
                'structure_success',
                self::COMPONENT,
                ['order' => $structure->order]
            ));
        }
    }

    /**
     * Check that the course is in the category of the template, or in one of its subcategories.
     *
     * @param stdClass $course
     * @param stdClass $template
     * @return bool
     */
    protected function in_template_category(stdClass $course, stdClass $template): bool {
        global $DB;

        $path = (string) $DB->get_field('course_categories', 'path', ['id' => $course->category]);
        return strpos($path . '/', '/' . $template->category . '/') !== false;
    }

    /**
     * Get the structure required by the template: the fixed sections around a single block of modules.
     *
     * @param stdClass[] $sections Sections of the template.
     * @param string $pattern Regular expression of a module name.
     * @param string $format Format of a module name.
     * @return stdClass|null The structure, or null if the template has no single block of modules.
     */
    protected function get_template_structure(array $sections, string $pattern, string $format): ?stdClass {
        $start = [];
        $end = [];
        $hasmodules = false;
        foreach ($sections as $section) {
            if (preg_match($pattern, $this->strip_decoration($section->name))) {
                if ($end) {
                    return null;
                }
                $hasmodules = true;
            } else if ($hasmodules) {
                $end[] = $section;
            } else {
                $start[] = $section;
            }
        }
        if (!$hasmodules) {
            return null;
        }

        $name = fn(stdClass $section): string => $this->strip_decoration($section->name);
        return (object) [
            'start' => $start,
            'end' => $end,
            'order' => implode(', ', array_merge(array_map($name, $start), ["{$format} …"], array_map($name, $end))),
        ];
    }

    /**
     * Check the sections of the course against the structure of the template.
     *
     * @param stdClass[] $sections
     * @param stdClass $structure
     * @param string $pattern
     * @param string $format
     * @param string $coursetitle
     * @param string $courselink
     * @return array The fixed sections found indexed by normalised name, and a list of [module number, section].
     */
    protected function check_sections(
        array $sections,
        stdClass $structure,
        string $pattern,
        string $format,
        string $coursetitle,
        string $courselink
    ): array {
        // Each kind of section has a rank: the ranks of the sections of a course can never go down.
        $modulerank = count($structure->start);
        $ranks = [];
        foreach ($structure->start as $rank => $section) {
            $ranks[$this->normalise($section->name)] = $rank;
        }
        foreach ($structure->end as $position => $section) {
            $ranks[$this->normalise($section->name)] = $modulerank + 1 + $position;
        }

        $fixed = [];
        $modules = [];
        $lastrank = -1;
        $lastmodule = 0;
        foreach ($sections as $section) {
            $link = $this->get_section_link($section);
            $key = $this->normalise($section->name);
            if (isset($ranks[$key])) {
                if (isset($fixed[$key])) {
                    $this->add_failed($section->name, $link, 'structure_section_duplicate', ['name' => $section->name]);
                    continue;
                }
                $fixed[$key] = $section;
                $rank = $ranks[$key];
            } else if (preg_match($pattern, $this->strip_decoration($section->name), $matches)) {
                $rank = $modulerank;
                $number = (int) $matches[1];
                if ($number !== $lastmodule + 1) {
                    $this->add_failed($section->name, $link, 'structure_module_number', [
                        'name' => $section->name,
                        'number' => $number,
                        'expected' => $lastmodule + 1,
                    ]);
                }
                $lastmodule = $number;
                $modules[] = [$number, $section];
            } else {
                $this->add_failed($section->name, $link, 'structure_section_unexpected', [
                    'name' => $section->name,
                    'format' => $format,
                    'order' => $structure->order,
                ]);
                continue;
            }

            if ($rank < $lastrank) {
                $this->add_failed($section->name, $link, 'structure_section_order', [
                    'name' => $section->name,
                    'order' => $structure->order,
                ]);
            } else {
                $lastrank = $rank;
            }
        }

        foreach (array_merge($structure->start, $structure->end) as $section) {
            if (!isset($fixed[$this->normalise($section->name)])) {
                $this->add_failed($coursetitle, $courselink, 'structure_section_missing', [
                    'name' => $this->strip_decoration($section->name),
                ]);
            }
        }
        if (empty($modules)) {
            $this->add_failed($coursetitle, $courselink, 'structure_modules_missing', ['format' => $format]);
        }
        return [$fixed, $modules];
    }

    /**
     * Check that the forums of the fixed sections of the template are in the course, with the same settings.
     *
     * Other forums of the course are ignored. A missing section has already been reported.
     *
     * @param stdClass $structure
     * @param stdClass[] $fixed Fixed sections of the course, indexed by normalised name.
     */
    protected function check_forums(stdClass $structure, array $fixed): void {
        foreach (array_merge($structure->start, $structure->end) as $templatesection) {
            $section = $fixed[$this->normalise($templatesection->name)] ?? null;
            if ($section === null) {
                continue;
            }
            foreach ($templatesection->modules as $templateforum) {
                if ($templateforum->modname !== 'forum') {
                    continue;
                }
                $name = $this->strip_decoration($templateforum->name);
                $matches = array_filter(
                    $section->modules,
                    fn($cm) => $cm->modname === 'forum' && $this->normalise($cm->name) === $this->normalise($name)
                );
                $a = ['name' => $name, 'section' => $this->strip_decoration($section->name)];
                if (empty($matches)) {
                    $this->add_failed($name, $this->get_section_link($section), 'structure_forum_missing', $a);
                } else if (count($matches) > 1) {
                    $this->add_failed($name, $this->get_section_link($section), 'structure_forum_duplicate', $a);
                } else {
                    $this->compare_forum($templateforum, reset($matches), $name);
                }
            }
        }
    }

    /**
     * Compare the settings of a forum with the forum of the template.
     *
     * The description is not a setting: it is only checked in the forum that must have rules of use.
     *
     * @param \cm_info|stdClass $templatecm
     * @param \cm_info|stdClass $cm
     * @param string $name
     */
    protected function compare_forum($templatecm, $cm, string $name): void {
        $templateforum = $this->get_forum($templatecm);
        $forum = $this->get_forum($cm);
        $settings = [];
        foreach (self::FORUM_SETTINGS as $field => $label) {
            $settings[] = [$label, $templateforum->$field ?? '', $forum->$field ?? ''];
        }
        foreach (self::MODULE_SETTINGS as $field => $label) {
            $settings[] = [$label, $templatecm->$field ?? '', $cm->$field ?? ''];
        }
        foreach (self::MODULE_SETTINGS_IN_USE as $field => $label) {
            $settings[] = [
                $label,
                translation_manager::generate(empty($templatecm->$field) ? 'no' : 'yes', 'moodle'),
                translation_manager::generate(empty($cm->$field) ? 'no' : 'yes', 'moodle'),
            ];
        }

        $link = resolution_link_helper::get_link_to_modedit_or_view_page('forum', $cm->id);
        foreach ($settings as [$label, $expected, $actual]) {
            if ((string) $expected !== (string) $actual) {
                $this->add_failed($name, $link, 'structure_forum_setting', [
                    'name' => $name,
                    'setting' => translation_manager::generate($label[0], $label[1]),
                    'expected' => (string) $expected,
                    'actual' => (string) $actual,
                ]);
            }
        }

        $rulesforum = (string) config::get(self::RULES_FORUM, self::RULES_FORUM_DEFAULT);
        if ($rulesforum !== '' && $this->normalise($rulesforum) === $this->normalise($name)) {
            $this->check_forum_rules($forum, $name, $link);
        }
    }

    /**
     * Check that the description of a forum has rules of use. They can be the same as in the template.
     *
     * @param stdClass $forum
     * @param string $name
     * @param string $link
     */
    protected function check_forum_rules(stdClass $forum, string $name, string $link): void {
        if ($this->get_plain_text($forum->intro) === '') {
            $this->add_failed($name, $link, 'structure_forum_rules_empty', ['name' => $name]);
        }
    }

    /**
     * Check that each module has one exam, and that no exam is outside the modules. The name of the exam is not checked.
     *
     * @param stdClass[] $fixed Fixed sections of the course.
     * @param array $modules List of [module number, section].
     * @param string $examtext Text that the name of an exam contains.
     */
    protected function check_exams(array $fixed, array $modules, string $examtext): void {
        $isexam = $this->get_exam_filter($examtext);

        foreach ($modules as [$number, $section]) {
            $exams = array_values(array_filter($section->modules, $isexam));
            $link = $this->get_section_link($section);
            if (empty($exams)) {
                $this->add_failed($section->name, $link, 'structure_exam_missing', [
                    'number' => $number,
                    'text' => $examtext,
                ]);
            } else if (count($exams) > 1) {
                $this->add_failed($section->name, $link, 'structure_exam_duplicate', [
                    'number' => $number,
                    'names' => implode(', ', array_map(fn($cm) => $cm->name, $exams)),
                ]);
            } else {
                $exam = $exams[0];
                $examlink = resolution_link_helper::get_link_to_modedit_or_view_page('quiz', $exam->id);
                if (empty($exam->visible)) {
                    $this->add_warning($exam->name, $examlink, 'structure_exam_hidden', ['name' => $exam->name]);
                }
            }
        }

        foreach ($fixed as $section) {
            foreach (array_filter($section->modules, $isexam) as $exam) {
                $this->add_failed(
                    $exam->name,
                    resolution_link_helper::get_link_to_modedit_or_view_page('quiz', $exam->id),
                    'structure_exam_outside',
                    ['name' => $exam->name, 'section' => $this->strip_decoration($section->name)]
                );
            }
        }
    }

    /**
     * Check that the course completion requires the exams, in the same way as the template.
     *
     * It uses all the exams of the course, so that it does not depend on the sections being correct.
     *
     * @param stdClass $course
     * @param stdClass $template
     * @param string $format
     */
    protected function check_course_completion(stdClass $course, stdClass $template, string $examtext): void {
        $link = (new moodle_url('/course/completion.php', ['id' => $course->id]))->out(false);
        $title = translation_manager::generate('structure_completion', self::COMPONENT);
        $criteria = $this->get_completion_activities($course);
        $isexam = $this->get_exam_filter($examtext);

        $valid = true;
        $exams = 0;
        foreach (get_fast_modinfo($course)->get_cms() as $cm) {
            if ($isexam($cm)) {
                $exams++;
                if (!in_array((int) $cm->id, $criteria, true)) {
                    $valid = false;
                    $this->add_failed($title, $link, 'structure_completion_exam_missing', ['name' => $cm->name]);
                }
            }
        }

        foreach ($criteria as $cmid) {
            $cm = get_fast_modinfo($course)->cms[$cmid] ?? null;
            if ($cm === null || !$isexam($cm)) {
                $this->add_warning($title, $link, 'structure_completion_other', ['name' => $cm->name ?? "#{$cmid}"]);
            }
        }

        foreach (self::COMPLETION_AGGREGATIONS as $label => $criteriatype) {
            $expected = $this->get_completion_aggregation($template, $criteriatype);
            $actual = $this->get_completion_aggregation($course, $criteriatype);
            if ($expected !== $actual) {
                $valid = false;
                $this->add_failed($title, $link, 'structure_completion_aggregation', [
                    'setting' => translation_manager::generate($label, self::COMPONENT),
                    'expected' => translation_manager::generate("structure_completion_method_{$expected}", self::COMPONENT),
                    'actual' => translation_manager::generate("structure_completion_method_{$actual}", self::COMPONENT),
                ]);
            }
        }

        if ($valid && $exams > 0) {
            $this->check->add_successful($title, $link, translation_manager::generate(
                'structure_completion_success',
                self::COMPONENT,
                ['count' => $exams]
            ));
        }
    }

    /**
     * Get the course modules that are required by the course completion.
     *
     * @param stdClass $course
     * @return int[]
     */
    protected function get_completion_activities(stdClass $course): array {
        global $DB;

        return array_map('intval', $DB->get_fieldset_select(
            'course_completion_criteria',
            'moduleinstance',
            'course = ? AND criteriatype = ?',
            [$course->id, COMPLETION_CRITERIA_TYPE_ACTIVITY]
        ));
    }

    /**
     * Get how the requirements of the course completion are combined.
     *
     * @param stdClass $course
     * @param int|null $criteriatype Kind of criteria, or null for the whole course completion.
     * @return int COMPLETION_AGGREGATION_ALL or COMPLETION_AGGREGATION_ANY.
     */
    protected function get_completion_aggregation(stdClass $course, ?int $criteriatype): int {
        return (int) (new completion_info($course))->get_aggregation_method($criteriatype);
    }

    /**
     * Get the function that tells if an activity is an exam: a quiz whose name contains the text, ignoring case and accents.
     *
     * @param string $examtext
     * @return callable
     */
    protected function get_exam_filter(string $examtext): callable {
        $simplify = fn(string $text): string => core_text::strtolower(core_text::specialtoascii(trim($text)));
        $text = $simplify($examtext);
        return fn($cm): bool => $cm->modname === 'quiz' && $text !== '' && strpos($simplify($cm->name), $text) !== false;
    }

    /**
     * Get the sections of a course in order, with their activities.
     *
     * Sections delegated to an activity (subsections) are not part of the main structure of the course.
     *
     * @param stdClass $course
     * @return stdClass[] Objects with the id and name of the section, and its modules as cm_info objects.
     */
    protected function get_sections(stdClass $course): array {
        $modinfo = get_fast_modinfo($course);
        $sections = [];
        foreach ($modinfo->get_listed_section_info_all() as $section) {
            $modules = [];
            foreach ($modinfo->sections[$section->section] ?? [] as $cmid) {
                $modules[] = $modinfo->cms[$cmid];
            }
            $sections[] = (object) [
                'id' => $section->id,
                'name' => trim(strip_tags(get_section_name($course, $section))),
                'modules' => $modules,
            ];
        }
        return $sections;
    }

    /**
     * Get the forum of a course module.
     *
     * @param \cm_info|stdClass $cm
     * @return stdClass
     */
    protected function get_forum($cm): stdClass {
        global $DB;

        return $DB->get_record('forum', ['id' => $cm->instance], '*', MUST_EXIST);
    }

    /**
     * Get the link to edit a section.
     *
     * @param stdClass $section
     * @return string
     */
    protected function get_section_link(stdClass $section): string {
        return (new moodle_url('/course/editsection.php', ['id' => $section->id]))->out(false);
    }

    /**
     * Report a failure.
     *
     * @param string $title
     * @param string $link
     * @param string $identifier
     * @param array $a
     */
    protected function add_failed(string $title, string $link, string $identifier, array $a): void {
        $this->hasissues = true;
        $this->check->add_failed($title, $link, translation_manager::generate($identifier, self::COMPONENT, $a));
    }

    /**
     * Report a warning.
     *
     * @param string $title
     * @param string $link
     * @param string $identifier
     * @param array $a
     */
    protected function add_warning(string $title, string $link, string $identifier, array $a): void {
        $this->hasissues = true;
        $this->check->add_warning($title, $link, translation_manager::generate($identifier, self::COMPONENT, $a));
    }

    /**
     * Build the regular expression of a module name from its format, where the last "N" stands for the number.
     *
     * @param string $format For example "N." or "Módulo N:".
     * @return string
     */
    protected function get_module_pattern(string $format): string {
        $position = strrpos($format, 'N');
        $before = preg_quote(substr($format, 0, $position), '/');
        $after = preg_quote(substr($format, $position + 1), '/');
        return '/^' . $before . '(\d+)' . $after . '\s+\S/iu';
    }

    /**
     * Remove the symbols that can start a name, such as emojis.
     *
     * @param string $name
     * @return string
     */
    protected function strip_decoration(string $name): string {
        return preg_replace('/^[^\p{L}\p{N}]+/u', '', trim($name));
    }

    /**
     * Get the visible text of some HTML, so that changes that are only in the markup do not count as different text.
     *
     * @param string|null $html
     * @return string
     */
    protected function get_plain_text(?string $html): string {
        $text = html_entity_decode(preg_replace('/<[^>]*>/', ' ', (string) $html), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        return core_text::strtolower(trim(preg_replace('/[\s\x{00A0}]+/u', ' ', $text)));
    }

    /**
     * Get the form of a name used to compare it: without leading symbols and ignoring case.
     *
     * @param string $name
     * @return string
     */
    protected function normalise(string $name): string {
        return core_text::strtolower($this->strip_decoration($name));
    }
}

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

/**
 * Checking quizzes inside the course if the sumgrade matches the grade.
 *
 * @package    coursechecker_quiz
 * @copyright  2025 Simon Gisler, Fernfachhochschule Schweiz (FFHS) <simon.gisler@ffhs.ch>
 * @copyright  2025 Stefan Dani, Fernfachhochschule Schweiz (FFHS) <stefan.dani@ffhs.ch>
 * @copyright  based on work by 2020 Christoph Karlen, Fernfachhochschule Schweiz (FFHS) <christoph.karlen@ffhs.ch>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace coursechecker_quiz;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/completionlib.php');

use coding_exception;
use context_module;
use core_question\local\bank\random_question_loader;
use core_text;
use local_course_checker\config;
use local_course_checker\db\model\check;
use local_course_checker\mod_type_interface;
use local_course_checker\model\check_plugin_interface;
use local_course_checker\resolution_link_helper;
use local_course_checker\translation_manager;
use mod_quiz\question\bank\qbank_helper;
use mod_quiz\question\display_options;
use moodle_url;
use qubaid_list;
use stdClass;

/**
 * {@inheritDoc}
 */
class checker implements check_plugin_interface, mod_type_interface {
    /**
     * Defines the path to the setting regex_whitelist.
     */
    const WHITELISTREGEX = 'coursechecker_quiz/regex_whitelist';
    /**
     * Defines the default of the setting regex_whitelist.
     */
    const WHITELISTREGEX_DEFAULT = "/Ejercicios de preparación para el examen/i";
    /**
     * The German default of the setting regex_whitelist in earlier versions.
     */
    const WHITELISTREGEX_OLD_DEFAULT = "/Aufgaben zur Prüfungsvorbereitung/i";
    /**
     * Defines the path to the setting that requires the maximum grade to be the total of marks of the questions.
     */
    const GRADE_SUM_ENABLED = 'coursechecker_quiz/gradesum_enabled';
    /**
     * Defines the default of the setting that requires the maximum grade to be the total of marks of the questions.
     */
    const GRADE_SUM_ENABLED_DEFAULT = 0;
    /**
     * Defines the path to the setting that enables the random question validation.
     */
    const RANDOM_ENABLED = 'coursechecker_quiz/randomquestions_enabled';
    /**
     * Defines the default of the setting that enables the random question validation.
     */
    const RANDOM_ENABLED_DEFAULT = 1;
    /**
     * Defines the path to the setting with the text that the name of a quiz must contain to validate its random questions.
     */
    const RANDOM_NAMEFILTER = 'coursechecker_quiz/randomquestions_namefilter';
    /**
     * Defines the default of the setting with the text that the name of a quiz must contain to validate its random questions.
     */
    const RANDOM_NAMEFILTER_DEFAULT = 'Examen';
    /**
     * Defines the path to the setting with the required number of random questions.
     */
    const RANDOM_REQUIRED = 'coursechecker_quiz/randomquestions_required';
    /**
     * Defines the default of the setting with the required number of random questions.
     */
    const RANDOM_REQUIRED_DEFAULT = 10;
    /**
     * Defines the path to the setting that requires a category named like the quiz.
     */
    const RANDOM_MATCHCATEGORY = 'coursechecker_quiz/randomquestions_matchcategory';
    /**
     * Defines the default of the setting that requires a category named like the quiz.
     */
    const RANDOM_MATCHCATEGORY_DEFAULT = 0;
    /**
     * Defines the path to the setting that accepts subcategories of the category named like the quiz.
     */
    const RANDOM_INCLUDESUBCATEGORIES = 'coursechecker_quiz/randomquestions_includesubcategories';
    /**
     * Defines the default of the setting that accepts subcategories of the category named like the quiz.
     */
    const RANDOM_INCLUDESUBCATEGORIES_DEFAULT = 1;
    /**
     * Defines the path to the setting with the gradebook category required by the name of a quiz.
     */
    const GRADECATEGORY_RULES = 'coursechecker_quiz/gradecategory_rules';
    /**
     * Defines the default of the setting with the gradebook category required by the name of a quiz.
     */
    const GRADECATEGORY_RULES_DEFAULT = "Actividad de comprensión|Actividades de comprensión\n" .
        "Examen|Actividades de evaluación";
    /**
     * The default of the setting with the gradebook category required by the name of a quiz in earlier versions.
     */
    const GRADECATEGORY_RULES_OLD_DEFAULT = "Actividad de comprensión|Actividades de comprensión\n" .
        "Actividad de evaluación|Actividades de evaluación\n" .
        "Examen|Actividades de evaluación";
    /**
     * Defines the path to the setting that requires exams without opening and closing dates.
     */
    const EXAM_NODATES = 'coursechecker_quiz/exam_nodates';
    /**
     * Defines the path to the setting that requires exams with a time limit.
     */
    const EXAM_TIMELIMIT = 'coursechecker_quiz/exam_timelimit';
    /**
     * Defines the path to the setting with the grade to pass of the exams.
     */
    const EXAM_GRADEPASS = 'coursechecker_quiz/exam_gradepass';
    /**
     * Defines the default of the setting with the grade to pass of the exams.
     */
    const EXAM_GRADEPASS_DEFAULT = '50';
    /**
     * Defines the path to the setting with the attempts allowed in the exams.
     */
    const EXAM_ATTEMPTS = 'coursechecker_quiz/exam_attempts';
    /**
     * Defines the default of the setting with the attempts allowed in the exams.
     */
    const EXAM_ATTEMPTS_DEFAULT = '3';
    /**
     * Defines the path to the setting with the grading method of the exams.
     */
    const EXAM_GRADEMETHOD = 'coursechecker_quiz/exam_grademethod';
    /**
     * Defines the default of the setting with the grading method of the exams (highest grade).
     */
    const EXAM_GRADEMETHOD_DEFAULT = '1';
    /**
     * Defines the path to the setting that enables the validation of the delays between attempts of the exams.
     */
    const EXAM_DELAY_ENABLED = 'coursechecker_quiz/exam_delay_enabled';
    /**
     * Defines the path to the setting with the delay between the first and second attempts of the exams.
     */
    const EXAM_DELAY1 = 'coursechecker_quiz/exam_delay1';
    /**
     * Defines the path to the setting with the delay between later attempts of the exams.
     */
    const EXAM_DELAY2 = 'coursechecker_quiz/exam_delay2';
    /**
     * Defines the default of the settings with the delays between attempts of the exams (2 days).
     */
    const EXAM_DELAY_DEFAULT = 2 * DAYSECS;
    /**
     * Grading methods of a quiz, with the language string of their name in mod_quiz.
     */
    const GRADEMETHODS = [1 => 'gradehighest', 2 => 'gradeaverage', 3 => 'attemptfirst', 4 => 'attemptlast'];
    /**
     * Defines the path to the setting that enables the validation of the review options of the exams.
     */
    const EXAM_REVIEW_ENABLED = 'coursechecker_quiz/exam_review_enabled';
    /**
     * Defines the path to the setting with the review options that the exams must show after an attempt.
     */
    const EXAM_REVIEW_OPTIONS = 'coursechecker_quiz/exam_reviewoptions';
    /**
     * Defines the default of the setting with the review options that the exams must show after an attempt.
     */
    const EXAM_REVIEW_OPTIONS_DEFAULT = ['maxmarks' => 1, 'marks' => 1, 'overallfeedback' => 1];
    /**
     * Defines the path to the setting with the moments of the review that are validated.
     */
    const EXAM_REVIEW_TIMES = 'coursechecker_quiz/exam_reviewtimes';
    /**
     * Defines the default of the setting with the moments of the review that are validated.
     */
    const EXAM_REVIEW_TIMES_DEFAULT = ['immediately' => 1, 'open' => 1];
    /**
     * Moments of the review after an attempt, with their bit in the review options and the language string of their name.
     */
    const REVIEW_TIMES = [
        'immediately' => [display_options::IMMEDIATELY_AFTER, 'reviewimmediately'],
        'open' => [display_options::LATER_WHILE_OPEN, 'reviewopen'],
        'closed' => [display_options::AFTER_CLOSE, 'reviewclosed'],
    ];
    /**
     * Review options of a quiz, with the language string of their name.
     */
    const REVIEW_OPTIONS = [
        'attempt' => ['theattempt', 'quiz'],
        'correctness' => ['whethercorrect', 'question'],
        'maxmarks' => ['maxmarks', 'quiz'],
        'marks' => ['marks', 'quiz'],
        'specificfeedback' => ['specificfeedback', 'question'],
        'generalfeedback' => ['generalfeedback', 'question'],
        'rightanswer' => ['rightanswer', 'question'],
        'overallfeedback' => ['overallfeedback', 'quiz'],
    ];
    /**
     * Defines the path to the setting that requires an overall feedback in the exams.
     */
    const EXAM_OVERALLFEEDBACK = 'coursechecker_quiz/exam_overallfeedback';
    /**
     * Defines the path to the setting that requires the activity completion of the exams.
     */
    const EXAM_COMPLETION = 'coursechecker_quiz/exam_completion';
    /**
     * @var check The result of the check.
     */
    protected check $check;
    /**
     * @var stdClass[]|null Question categories of the course question banks, indexed by id.
     */
    protected ?array $coursecategories = null;
    /**
     * @var bool[] Settings with an invalid value that were already reported, indexed by name.
     */
    protected array $invalidsettings = [];

    /**
     * Runs the checker.
     *
     * @param stdClass $course
     * @param check $check
     * @return void
     * @throws \core\exception\moodle_exception
     * @throws \moodle_exception
     * @throws coding_exception
     */
    public function run(stdClass $course, check $check): void {
        $this->check = $check;

        // Get all quiz activities in the course.
        $modinfo = get_fast_modinfo($course);
        $instances = get_all_instances_in_courses(self::MOD_TYPE_QUIZ, [$course->id => $course]);
        $regex = config::get(self::WHITELISTREGEX, self::WHITELISTREGEX_DEFAULT);
        $gradecategoryrules = $this->get_grade_category_rules();
        $gradecategories = $gradecategoryrules ? $this->get_quiz_grade_categories($course->id) : [];
        $randomenabled = (bool) config::get(self::RANDOM_ENABLED, self::RANDOM_ENABLED_DEFAULT);
        $randomnamefilter = (string) config::get(self::RANDOM_NAMEFILTER, self::RANDOM_NAMEFILTER_DEFAULT);
        foreach ($instances as $mod) {
            // Get cm_info object to use for target and resolution link.
            $cm = $modinfo->get_cm($mod->coursemodule);
            $title = resolution_link_helper::get_target($cm);
            $resolutionlink = (new moodle_url('/mod/quiz/edit.php', ['cmid' => $cm->id]))->out(false);
            // For all quizzes we like to check if the "Maximum grade" and the "Total of marks" are the same numbers.
            if ($regex && preg_match($regex, $mod->name)) {
                $this->check->add_info(
                    $title,
                    $resolutionlink,
                    translation_manager::generate('quiz_in_whitelist', 'coursechecker_quiz')
                );
            } else {
                if (config::get(self::GRADE_SUM_ENABLED, self::GRADE_SUM_ENABLED_DEFAULT)) {
                    $this->check_quiz_maximum_grade($mod, $resolutionlink, $title);
                }
                // An empty name filter makes every quiz an exam.
                $isexam = trim($randomnamefilter) === '' || $this->name_contains($mod->name, $randomnamefilter);
                if ($isexam && $randomenabled) {
                    $this->check_random_questions($mod, $cm->id, $modinfo, $resolutionlink, $title);
                }
                if ($isexam) {
                    $this->check_exam_settings($mod, $cm, $title);
                }
                $this->check_grade_category($mod, $gradecategoryrules, $gradecategories, $title);
            }
        }
    }

    /**
     * Check the settings required in the exams. Each rule can be disabled in the settings of this check.
     *
     * @param stdClass $mod
     * @param \cm_info $cm
     * @param string $title
     * @throws coding_exception
     */
    protected function check_exam_settings(stdClass $mod, \cm_info $cm, string $title): void {
        $link = (new moodle_url('/course/modedit.php', ['update' => $cm->id]))->out(false);
        $errors = array_merge(
            $this->get_exam_timing_errors($mod),
            $this->get_exam_grade_errors($mod),
            $this->get_exam_delay_errors($mod),
            $this->get_exam_review_errors($mod),
            $this->get_exam_feedback_errors($mod),
            $this->get_exam_completion_errors($cm)
        );
        foreach ($errors as $error) {
            $this->check->add_failed($title, $link, $error);
        }
        if (empty($errors)) {
            $this->check->add_successful($title, $link, translation_manager::generate('exam_settings_success', 'coursechecker_quiz'));
        }
    }

    /**
     * Get the errors of the timing of an exam: no opening and closing dates, and a time limit.
     *
     * Labels joined in a list are translated when the check runs, because only whole values are translated later.
     *
     * @param stdClass $mod
     * @return string[]
     */
    protected function get_exam_timing_errors(stdClass $mod): array {
        $errors = [];
        if (config::get(self::EXAM_NODATES, 1) && ($mod->timeopen || $mod->timeclose)) {
            $dates = [];
            foreach (['timeopen' => 'quizopen', 'timeclose' => 'quizclose'] as $field => $identifier) {
                if ($mod->$field) {
                    $dates[] = get_string($identifier, 'quiz') . ': ' . userdate($mod->$field);
                }
            }
            $errors[] = translation_manager::generate('exam_dates_error', 'coursechecker_quiz', ['dates' => implode(', ', $dates)]);
        }
        if (config::get(self::EXAM_TIMELIMIT, 1) && empty($mod->timelimit)) {
            $errors[] = translation_manager::generate('exam_timelimit_error', 'coursechecker_quiz');
        }
        return $errors;
    }

    /**
     * Get the errors of the grade of an exam: grade to pass, attempts allowed and grading method.
     *
     * An empty value in the settings disables the rule, and an invalid one is reported as an error of the check.
     *
     * @param stdClass $mod
     * @return string[]
     */
    protected function get_exam_grade_errors(stdClass $mod): array {
        global $DB;
        $component = 'coursechecker_quiz';
        $errors = [];

        $gradepass = trim((string) config::get(self::EXAM_GRADEPASS, self::EXAM_GRADEPASS_DEFAULT));
        $expected = unformat_float($gradepass, true);
        if ($gradepass !== '' && $expected === false) {
            $this->report_invalid_setting('exam_gradepass', $gradepass);
        } else if ($gradepass !== '') {
            $current = (float) $DB->get_field('grade_items', 'gradepass', [
                'courseid' => $mod->course, 'itemtype' => 'mod', 'itemmodule' => 'quiz',
                'iteminstance' => $mod->id, 'itemnumber' => 0,
            ]);
            if (abs($current - $expected) > 0.00001) {
                $errors[] = translation_manager::generate('exam_gradepass_error', $component, [
                    'expected' => format_float($expected, 2),
                    'current' => format_float($current, 2),
                ]);
            }
        }

        $attempts = trim((string) config::get(self::EXAM_ATTEMPTS, self::EXAM_ATTEMPTS_DEFAULT));
        if ($attempts !== '' && !ctype_digit($attempts)) {
            $this->report_invalid_setting('exam_attempts', $attempts);
        } else if ($attempts !== '' && (int) $mod->attempts !== (int) $attempts) {
            // Zero attempts means unlimited attempts.
            $label = fn(int $value): string => $value ? (string) $value : translation_manager::generate('unlimited', 'moodle');
            $errors[] = translation_manager::generate('exam_attempts_error', $component, [
                'expected' => $label((int) $attempts),
                'current' => $label((int) $mod->attempts),
            ]);
        }

        $method = (int) config::get(self::EXAM_GRADEMETHOD, self::EXAM_GRADEMETHOD_DEFAULT);
        if (isset(self::GRADEMETHODS[$method]) && (int) $mod->grademethod !== $method) {
            $current = self::GRADEMETHODS[(int) $mod->grademethod] ?? null;
            $errors[] = translation_manager::generate('exam_grademethod_error', $component, [
                'expected' => translation_manager::generate(self::GRADEMETHODS[$method], 'quiz'),
                'current' => $current ? translation_manager::generate($current, 'quiz') : (string) $mod->grademethod,
            ]);
        }
        return $errors;
    }

    /**
     * Get the errors of the delays between attempts of an exam. A delay of 0 means that it must be disabled.
     *
     * @param stdClass $mod
     * @return string[]
     */
    protected function get_exam_delay_errors(stdClass $mod): array {
        if (!config::get(self::EXAM_DELAY_ENABLED, 1)) {
            return [];
        }
        $errors = [];
        $label = fn(int $seconds): string => $seconds ? format_time($seconds) : get_string('disabled', 'admin');
        foreach (['delay1' => [self::EXAM_DELAY1, 'delay1st2nd'], 'delay2' => [self::EXAM_DELAY2, 'delaylater']] as $field => [$setting, $identifier]) {
            $expected = (int) config::get($setting, self::EXAM_DELAY_DEFAULT);
            if ((int) $mod->$field !== $expected) {
                $errors[] = translation_manager::generate('exam_delay_error', 'coursechecker_quiz', [
                    'setting' => get_string($identifier, 'quiz'),
                    'expected' => $label($expected),
                    'current' => $label((int) $mod->$field),
                ]);
            }
        }
        return $errors;
    }

    /**
     * Get the errors of the review options of an exam.
     *
     * In each validated moment after the attempt, the required options must be shown and the others must not.
     * What is shown during the attempt is not checked, because the quiz always shows the attempt then.
     *
     * @param stdClass $mod
     * @return string[]
     */
    protected function get_exam_review_errors(stdClass $mod): array {
        if (!config::get(self::EXAM_REVIEW_ENABLED, 1)) {
            return [];
        }
        $required = $this->get_multicheckbox(self::EXAM_REVIEW_OPTIONS, self::EXAM_REVIEW_OPTIONS_DEFAULT);
        $times = $this->get_multicheckbox(self::EXAM_REVIEW_TIMES, self::EXAM_REVIEW_TIMES_DEFAULT);

        $errors = [];
        foreach (self::REVIEW_TIMES as $time => [$bit, $timeidentifier]) {
            if (!in_array($time, $times, true)) {
                continue;
            }
            $missing = [];
            $extra = [];
            foreach (self::REVIEW_OPTIONS as $option => [$identifier, $component]) {
                $shown = (bool) ((int) ($mod->{'review' . $option} ?? 0) & $bit);
                $isrequired = in_array($option, $required, true);
                if ($isrequired && !$shown) {
                    $missing[] = get_string($identifier, $component);
                } else if (!$isrequired && $shown) {
                    $extra[] = get_string($identifier, $component);
                }
            }
            foreach (['exam_review_missing' => $missing, 'exam_review_extra' => $extra] as $identifier => $options) {
                if ($options) {
                    $errors[] = translation_manager::generate($identifier, 'coursechecker_quiz', [
                        'time' => get_string($timeidentifier, 'quiz'),
                        'options' => implode(', ', $options),
                    ]);
                }
            }
        }
        return $errors;
    }

    /**
     * Get the selected keys of a setting with several checkboxes.
     *
     * @param string $setting
     * @param array $default
     * @return string[]
     */
    protected function get_multicheckbox(string $setting, array $default): array {
        $value = config::get($setting, $default);
        return is_array($value) ? array_keys(array_filter($value)) : array_values(array_filter(explode(',', (string) $value)));
    }

    /**
     * Get the error of an exam without overall feedback. Any text in any grade boundary is enough.
     *
     * @param stdClass $mod
     * @return string[]
     */
    protected function get_exam_feedback_errors(stdClass $mod): array {
        global $DB;

        if (!config::get(self::EXAM_OVERALLFEEDBACK, 1)) {
            return [];
        }
        foreach ($DB->get_fieldset_select('quiz_feedback', 'feedbacktext', 'quizid = ?', [$mod->id]) as $text) {
            if (trim(html_entity_decode(strip_tags((string) $text), ENT_QUOTES | ENT_HTML5, 'UTF-8'), " \t\n\r\0\x0B\u{00A0}") !== '') {
                return [];
            }
        }
        return [translation_manager::generate('exam_overallfeedback_error', 'coursechecker_quiz')];
    }

    /**
     * Get the errors of the activity completion of an exam: it must be automatic, with view and passing grade.
     *
     * @param \cm_info $cm
     * @return string[]
     */
    protected function get_exam_completion_errors(\cm_info $cm): array {
        if (!config::get(self::EXAM_COMPLETION, 1)) {
            return [];
        }
        $missing = [];
        if ($cm->completion != COMPLETION_TRACKING_AUTOMATIC || empty($cm->completionview)) {
            $missing[] = get_string('exam_completion_view', 'coursechecker_quiz');
        }
        if ($cm->completion != COMPLETION_TRACKING_AUTOMATIC || empty($cm->completionpassgrade)) {
            $missing[] = get_string('completionpassgrade', 'completion');
        }
        return $missing ? [translation_manager::generate('exam_completion_error', 'coursechecker_quiz', [
            'conditions' => implode(', ', $missing),
        ])] : [];
    }

    /**
     * Report a setting of this check with an invalid value, once per run.
     *
     * @param string $setting
     * @param string $value
     */
    protected function report_invalid_setting(string $setting, string $value): void {
        if (isset($this->invalidsettings[$setting])) {
            return;
        }
        $this->invalidsettings[$setting] = true;
        $this->check->add_error('', '', translation_manager::generate('exam_setting_invalid', 'coursechecker_quiz', [
            'setting' => translation_manager::generate($setting, 'coursechecker_quiz'),
            'value' => $value,
        ]));
    }

    /**
     * Check whether a quiz name contains a text, ignoring case and accents.
     *
     * @param string $name
     * @param string $text
     * @return bool
     */
    protected function name_contains(string $name, string $text): bool {
        // Accents are ignored as well: a name without them is still the same kind of quiz.
        $simplify = fn(string $value): string => core_text::strtolower(core_text::specialtoascii(trim(strip_tags($value))));
        return strpos($simplify($name), $simplify($text)) !== false;
    }

    /**
     * Get the gradebook category required by each text that a quiz name can contain.
     *
     * A line that is not "text|category" is reported, because it would leave quizzes unchecked without notice.
     *
     * @return array List of [text, category].
     * @throws coding_exception
     */
    protected function get_grade_category_rules(): array {
        $rules = [];
        $config = (string) config::get(self::GRADECATEGORY_RULES, self::GRADECATEGORY_RULES_DEFAULT);
        foreach (preg_split('/\R/u', $config) as $line) {
            if (trim($line) === '') {
                continue;
            }
            $parts = array_map('trim', explode('|', $line));
            if (count($parts) === 2 && $parts[0] !== '' && $parts[1] !== '') {
                $rules[] = $parts;
            } else {
                $this->check->add_error('', '', translation_manager::generate(
                    'quiz_gradecategory_rule_invalid',
                    'coursechecker_quiz',
                    ['line' => trim($line)]
                ));
            }
        }
        return $rules;
    }

    /**
     * Get the gradebook category of the quizzes of a course.
     *
     * @param int $courseid
     * @return stdClass[] Objects with the name of the category and its parent, indexed by quiz id.
     */
    protected function get_quiz_grade_categories(int $courseid): array {
        global $DB;

        return $DB->get_records_sql(
            "SELECT gi.iteminstance, gc.fullname, gc.parent
               FROM {grade_items} gi
               JOIN {grade_categories} gc ON gc.id = gi.categoryid
              WHERE gi.courseid = :courseid AND gi.itemtype = 'mod' AND gi.itemmodule = 'quiz' AND gi.itemnumber = 0",
            ['courseid' => $courseid]
        );
    }

    /**
     * Check that a quiz is in the gradebook category required by its name. Other quizzes are ignored.
     *
     * @param stdClass $mod
     * @param array $rules List of [text, category].
     * @param stdClass[] $gradecategories Gradebook categories indexed by quiz id.
     * @param string $title
     * @throws coding_exception
     */
    protected function check_grade_category(stdClass $mod, array $rules, array $gradecategories, string $title): void {
        $expected = null;
        foreach ($rules as [$text, $category]) {
            if ($this->name_contains($mod->name, $text)) {
                $expected = $category;
                break;
            }
        }
        if ($expected === null) {
            return;
        }

        $link = (new moodle_url('/grade/edit/tree/index.php', ['id' => $mod->course]))->out(false);
        $current = $gradecategories[$mod->id] ?? null;
        $lower = fn(string $name): string => core_text::strtolower(trim($name));
        if (!empty($current->parent) && $lower($current->fullname) === $lower($expected)) {
            $this->check->add_successful($title, $link, translation_manager::generate(
                'quiz_gradecategory_success',
                'coursechecker_quiz',
                ['category' => $expected]
            ));
            return;
        }
        // The top category of the gradebook has no real name: it is the course itself.
        $this->check->add_failed($title, $link, translation_manager::generate(
            'quiz_gradecategory_error',
            'coursechecker_quiz',
            [
                'category' => $expected,
                'current' => empty($current->parent) ?
                    translation_manager::generate('quiz_gradecategory_none', 'coursechecker_quiz') : $current->fullname,
            ]
        ));
    }

    /**
     * Check the number of random questions, their categories and whether these contain enough questions.
     *
     * @param stdClass $mod
     * @param int $cmid
     * @param \course_modinfo $modinfo
     * @param string $link
     * @param string $title
     * @throws coding_exception
     */
    protected function check_random_questions(
        stdClass $mod,
        int $cmid,
        \course_modinfo $modinfo,
        string $link,
        string $title
    ): void {
        $this->coursecategories ??= $this->get_course_categories($modinfo);
        $slots = qbank_helper::get_question_structure($mod->id, context_module::instance($cmid));
        $randomslots = array_filter($slots, fn($slot) => !empty($slot->random));
        $component = 'coursechecker_quiz';
        $required = (int) config::get(self::RANDOM_REQUIRED, self::RANDOM_REQUIRED_DEFAULT);
        $matchcategory = (bool) config::get(self::RANDOM_MATCHCATEGORY, self::RANDOM_MATCHCATEGORY_DEFAULT);
        $randomcount = count($randomslots);
        $fixedcount = count($slots) - $randomcount;
        $valid = true;

        if ($randomcount !== $required) {
            $valid = false;
            $this->check->add_failed($title, $link, translation_manager::generate(
                'quiz_random_count_error',
                $component,
                ['random' => $randomcount, 'fixed' => $fixedcount, 'required' => $required]
            ));
        } else if ($fixedcount > 0) {
            $this->check->add_warning($title, $link, translation_manager::generate(
                'quiz_random_fixed_warning',
                $component,
                ['fixed' => $fixedcount]
            ));
        }

        // Slots with the same filter draw from the same questions, so they have to be counted together.
        $groups = [];
        foreach ($randomslots as $slot) {
            $filter = $slot->filtercondition['filter'] ?? [];
            $key = json_encode($filter);
            $groups[$key] ??= ['filter' => $filter, 'slots' => 0];
            $groups[$key]['slots']++;
        }

        if ($matchcategory && !$this->check_categories_match($mod->name, $groups, $link, $title)) {
            $valid = false;
        }
        if (!$this->check_enough_questions($groups, $randomcount, $link, $title)) {
            $valid = false;
        }

        if ($valid) {
            $identifier = $matchcategory ? 'quiz_random_success_category' : 'quiz_random_success';
            $this->check->add_successful($title, $link, translation_manager::generate(
                $identifier,
                $component,
                ['required' => $required, 'name' => strip_tags($mod->name)]
            ));
        }
    }

    /**
     * Check that the random questions only use the category named like the quiz.
     *
     * @param string $quizname
     * @param array $groups Random slots grouped by filter.
     * @param string $link
     * @param string $title
     * @return bool True if all the random questions use the expected categories.
     * @throws coding_exception
     */
    protected function check_categories_match(string $quizname, array $groups, string $link, string $title): bool {
        $includesubcategories = (bool) config::get(
            self::RANDOM_INCLUDESUBCATEGORIES,
            self::RANDOM_INCLUDESUBCATEGORIES_DEFAULT
        );
        $name = strip_tags($quizname);
        $expected = $this->get_expected_category_ids($quizname, $includesubcategories);
        if (empty($expected)) {
            $this->check->add_failed($title, $link, translation_manager::generate(
                'quiz_category_missing',
                'coursechecker_quiz',
                ['name' => $name]
            ));
            return false;
        }

        $wrongslots = 0;
        $wrongcategories = [];
        foreach ($groups as $group) {
            $categoryids = $this->get_filter_category_ids($group['filter']);
            $subcategories = !empty($group['filter']['category']['filteroptions']['includesubcategories']);
            $unexpected = array_diff($categoryids, $expected);
            if (empty($categoryids) || $unexpected || ($subcategories && !$includesubcategories)) {
                $wrongslots += $group['slots'];
                $wrongcategories = array_merge($wrongcategories, $unexpected ?: $categoryids);
            }
        }
        if ($wrongslots === 0) {
            return true;
        }

        $identifier = $includesubcategories ? 'quiz_category_mismatch_subcategories' : 'quiz_category_mismatch';
        $this->check->add_failed($title, $link, translation_manager::generate(
            $identifier,
            'coursechecker_quiz',
            ['count' => $wrongslots, 'name' => $name, 'categories' => $this->get_category_names($wrongcategories)]
        ));
        return false;
    }

    /**
     * Check that there are enough questions to build an attempt, with the same loader used to start a quiz attempt.
     *
     * @param array $groups Random slots grouped by filter.
     * @param int $randomcount Number of random questions in the quiz.
     * @param string $link
     * @param string $title
     * @return bool True if there are enough questions.
     * @throws coding_exception
     */
    protected function check_enough_questions(array $groups, int $randomcount, string $link, string $title): bool {
        $loader = new random_question_loader(new qubaid_list([]));
        $valid = true;
        $allquestionids = [];
        foreach ($groups as $group) {
            $questions = $loader->get_filtered_questions($group['filter'], 0, 0, ['id']);
            $allquestionids += $questions;
            if (count($questions) < $group['slots']) {
                $valid = false;
                $this->check->add_failed($title, $link, translation_manager::generate(
                    'quiz_category_insufficient',
                    'coursechecker_quiz',
                    [
                        'categories' => $this->get_category_names($this->get_filter_category_ids($group['filter'])),
                        'available' => count($questions),
                        'needed' => $group['slots'],
                    ]
                ));
            }
        }
        // Filters can overlap (e.g. a category and its subcategory), so each one may be enough but not all of them together.
        if ($valid && count($allquestionids) < $randomcount) {
            $valid = false;
            $this->check->add_failed($title, $link, translation_manager::generate(
                'quiz_questions_insufficient',
                'coursechecker_quiz',
                ['available' => count($allquestionids), 'needed' => $randomcount]
            ));
        }
        return $valid;
    }

    /**
     * Get the ids of the course question bank categories named like the quiz.
     *
     * Case and surrounding spaces are ignored.
     *
     * @param string $quizname
     * @param bool $includesubcategories Whether to include all the subcategories of the matching categories.
     * @return int[]
     */
    protected function get_expected_category_ids(string $quizname, bool $includesubcategories): array {
        $normalise = fn(string $name): string => core_text::strtolower(trim(strip_tags($name)));
        $expected = [];
        foreach ($this->coursecategories as $category) {
            // Each question bank has a hidden "top" category, which is not a real category.
            if ($category->parent != 0 && $normalise($category->name) === $normalise($quizname)) {
                $expected[] = (int) $category->id;
            }
        }
        if (!$includesubcategories) {
            return $expected;
        }

        for ($i = 0; $i < count($expected); $i++) {
            foreach ($this->coursecategories as $category) {
                if ($category->parent == $expected[$i] && !in_array((int) $category->id, $expected, true)) {
                    $expected[] = (int) $category->id;
                }
            }
        }
        return $expected;
    }

    /**
     * Load the question categories of the question banks of the course.
     *
     * @param \course_modinfo $modinfo
     * @return stdClass[] Categories indexed by id.
     */
    protected function get_course_categories(\course_modinfo $modinfo): array {
        global $DB;

        $contextids = [];
        foreach ($modinfo->get_instances_of('qbank') as $cm) {
            $contextids[] = $cm->context->id;
        }
        if (empty($contextids)) {
            return [];
        }
        return $DB->get_records_list('question_categories', 'contextid', $contextids, '', 'id, name, parent');
    }

    /**
     * Get the category ids of a random question filter.
     *
     * @param array $filter
     * @return int[]
     */
    protected function get_filter_category_ids(array $filter): array {
        return array_map('intval', $filter['category']['values'] ?? []);
    }

    /**
     * Get a readable list of category names.
     *
     * @param int[] $categoryids
     * @return string
     */
    protected function get_category_names(array $categoryids): string {
        global $DB;

        $categoryids = array_unique($categoryids);
        if (empty($categoryids)) {
            return '-';
        }
        // A random question can use a category from outside the course, or one that no longer exists.
        $names = $DB->get_records_list('question_categories', 'id', $categoryids, '', 'id, name');
        $labels = array_map(fn($id) => isset($names[$id]) ? trim(strip_tags($names[$id]->name)) : "#{$id}", $categoryids);
        return implode(', ', $labels);
    }

    /**
     * Check quiz maximum grade.
     *
     * @param stdClass $mod
     * @param string $link
     * @param string|null $title
     * @throws coding_exception
     */
    protected function check_quiz_maximum_grade(stdClass $mod, string $link = '', ?string $title = null): void {
        if ($mod->grade != $mod->sumgrades) {
            $message = translation_manager::generate(
                'quiz_grade_sum_error',
                'coursechecker_quiz',
                [
                    'grade' => $mod->grade,
                    'sumgrades' => $mod->sumgrades,
                ]
            );
            $this->check->add_failed($title, $link, $message);
        } else {
            $message = translation_manager::generate(
                'quiz_grade_sum_success',
                'coursechecker_quiz'
            );
            $this->check->add_successful($title, $link, $message);
        }
    }
}

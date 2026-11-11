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

namespace coursechecker_referencesettings;

use coding_exception;
use context_course;
use dml_exception;
use core_course\external\course_summary_exporter;
use core_text;
use local_course_checker\config;
use local_course_checker\db\model\check;
use local_course_checker\model\check_plugin_interface;
use local_course_checker\resolution_link_helper;
use local_course_checker\translation_manager;
use moodle_exception;
use moodle_url;
use stdClass;

/**
 * Checking the course settings compared to a reference course
 *
 * @package    coursechecker_referencesettings
 * @copyright  2025 Simon Gisler, Fernfachhochschule Schweiz (FFHS) <simon.gisler@ffhs.ch>
 * @copyright  2025 Stefan Dani, Fernfachhochschule Schweiz (FFHS) <stefan.dani@ffhs.ch>
 * @copyright  based on work by 2019 Liip SA <elearning@liip.ch>
 * @copyright  based on work by 2019 Christoph Karlen, Fernfachhochschule Schweiz (FFHS) <christoph.karlen@ffhs.ch>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class checker implements check_plugin_interface {
    /** Config path for the reference course ID. */
    const REFERENCE_COURSE = 'local_course_checker/referencecourseid';
    /** Default value for the reference course ID. */
    const REFERENCE_COURSE_DEFAULT = 1;
    /** Config path for the reference course settings (e.g., checklist of options). */
    const REFERENCE_COURSE_SETTINGS = 'coursechecker_referencesettings/checklist';
    /** Default value for the reference course settings. */
    const REFERENCE_COURSE_SETTINGS_DEFAULT = [
        'format' => 1,
        'theme' => 1,
        'lang' => 1,
        'calendartype' => 1,
        'newsitems' => 1,
        'showgrades' => 1,
        'showreports' => 1,
        'showactivitydates' => 1,
        'legacyfiles' => 1,
        'maxbytes' => 1,
        'pdfexportfont' => 1,
        'enablecompletion' => 1,
        'showcompletionconditions' => 1,
        'groupmode' => 1,
        'groupmodeforce' => 1,
        'defaultgroupingid' => 1,
    ];
    /** Course settings that can be compared, with the language string of their label. */
    const SETTING_LABELS = [
        // General.
        'category' => ['category', 'moodle'],
        'visible' => ['visible', 'moodle'],
        'startdate' => ['startdate', 'moodle'],
        // Summary.
        'summary' => ['summary', 'moodle'],
        // Course Format.
        'format' => ['format', 'moodle'],
        // Appearance.
        'theme' => ['forcetheme', 'moodle'],
        'lang' => ['forcelanguage', 'moodle'],
        'calendartype' => ['forcecalendartype', 'calendar'],
        'newsitems' => ['newsitemsnumber', 'moodle'],
        'showgrades' => ['showgrades', 'moodle'],
        'showreports' => ['showreports', 'moodle'],
        'showactivitydates' => ['showactivitydates', 'moodle'],
        // Files and uploads.
        'legacyfiles' => ['courselegacyfiles', 'moodle'],
        'maxbytes' => ['maximumupload', 'moodle'],
        'pdfexportfont' => ['pdfexportfont', 'course'],
        // Completion Tracking.
        'enablecompletion' => ['enablecompletion', 'completion'],
        'showcompletionconditions' => ['showcompletionconditions', 'completion'],
        // Groups.
        'groupmode' => ['groupmode', 'group'],
        'groupmodeforce' => ['groupmodeforce', 'group'],
        'defaultgroupingid' => ['defaultgrouping', 'group'],
    ];
    /** Config path for requiring a course image. */
    const REQUIRE_IMAGE = 'coursechecker_referencesettings/requireimage';
    /** Default value for requiring a course image. */
    const REQUIRE_IMAGE_DEFAULT = 1;
    /** Config path for requiring a start date and no end date. */
    const REQUIRE_START_DATE_ONLY = 'coursechecker_referencesettings/requirestartdateonly';
    /** Default value for requiring a start date and no end date. */
    const REQUIRE_START_DATE_ONLY_DEFAULT = 1;
    /** Config path for requiring the gradebook categories of the reference course. */
    const REQUIRE_GRADE_CATEGORIES = 'coursechecker_referencesettings/requiregradecategories';
    /** Default value for requiring the gradebook categories of the reference course. */
    const REQUIRE_GRADE_CATEGORIES_DEFAULT = 1;
    /** Config path for comparing the settings of the gradebook categories with the reference course. */
    const COMPARE_GRADE_CATEGORY_SETTINGS = 'coursechecker_referencesettings/comparegradecategorysettings';
    /** Default value for comparing the settings of the gradebook categories with the reference course. */
    const COMPARE_GRADE_CATEGORY_SETTINGS_DEFAULT = 1;
    /** Names of the aggregation methods of the gradebook, in the grades language file. */
    const GRADE_AGGREGATIONS = [
        0 => 'aggregatemean',
        2 => 'aggregatemedian',
        4 => 'aggregatemin',
        6 => 'aggregatemax',
        8 => 'aggregatemode',
        10 => 'aggregateweightedmean',
        11 => 'aggregateweightedmean2',
        12 => 'aggregateextracreditmean',
        13 => 'aggregatesum',
    ];
    /** Names of the grade types, in the grades language file. */
    const GRADE_TYPES = [0 => 'typenone', 1 => 'typevalue', 2 => 'typescale', 3 => 'typetext'];
    /** Names of the grade display types, in the grades language file (0 is the default of the site). */
    const GRADE_DISPLAY_TYPES = [
        1 => 'real',
        2 => 'percentage',
        3 => 'letter',
        12 => 'realpercentage',
        13 => 'realletter',
        21 => 'percentagereal',
        23 => 'percentageletter',
        31 => 'letterreal',
        32 => 'letterpercentage',
    ];
    /** Config path for enabling filtering of reference course settings. */
    const REFERENCE_COURSE_FILTER_ENABLED = 'coursechecker_referencesettings/filter';
    /** Default value for enabling the reference course filter. */
    const REFERENCE_COURSE_FILTER_ENABLED_DEFAULT = false;
    /** Config path for enabling comparison of course format options. */
    const REFERENCE_COURSE_FORMAT_OPTION_ENABLED = 'coursechecker_referencesettings/formatoptions';
    /** Default value for enabling course format option comparison. */
    const REFERENCE_COURSE_FORMAT_OPTION_ENABLED_DEFAULT = false;

    /**
     * @var check The result of the check.
     */
    protected check $check;

    /** @var int $referencecourseid from checker settings */
    protected int $referencecourseid;

    /** @var array $referencecourseid from checker settings */
    protected array $referencesettings = [];

    /** @var array|bool $referencefilterenabled from checker settings */
    protected array|bool $referencefilterenabled;

    /** @var array|bool $referenceformatoptionsenabled from checker settings */
    protected array|bool $referenceformatoptionsenabled;

    /**
     * Runs the check
     *
     * @param stdClass $course
     * @param check $check
     * @throws coding_exception
     * @throws dml_exception
     * @throws moodle_exception
     */
    public function run(stdClass $course, check $check): void {
        // Get active setting checks from configuration.
        $this->init();

        // Initialize check result array.
        $this->check = $check;

        // Get current and reference course configuration.
        $currentcourse = $course;
        $referencecourse = get_course($this->referencecourseid);

        // Check settings like Category, Format, Force Language. See plugin settings for complete list.
        $this->compare_default_course_settings($course, $referencecourse, $currentcourse);

        // Check if the course filters have the same settings as the template reference course.
        $this->compare_course_level_filters($currentcourse, $referencecourse);

        // Compare the course format options.
        $this->compare_course_format_options($currentcourse, $referencecourse);

        // Compare the categories of the gradebook.
        $this->compare_grade_categories($currentcourse, $referencecourse);

        // The template is only the model of the other courses: these rules are for the courses made from it.
        if ($currentcourse->id != $referencecourse->id) {
            $this->check_course_image($currentcourse);
            $this->check_course_dates($currentcourse);
        }
    }

    /**
     * Checks that the gradebook has exactly the categories of the reference course, if required.
     *
     * Only the names are compared, ignoring case, and then the settings of each category, if enabled.
     *
     * @param stdClass $course
     * @param stdClass $referencecourse
     */
    protected function compare_grade_categories(stdClass $course, stdClass $referencecourse): void {
        if (!config::get(self::REQUIRE_GRADE_CATEGORIES, self::REQUIRE_GRADE_CATEGORIES_DEFAULT)) {
            return;
        }
        $component = 'coursechecker_referencesettings';
        $link = (new moodle_url('/grade/edit/tree/index.php', ['id' => $course->id]))->out(false);
        $normalise = fn(string $name): string => core_text::strtolower(trim($name));

        $missing = [];
        foreach ($this->get_grade_category_names($referencecourse->id) as $name) {
            $missing[$normalise($name)] = $name;
        }
        $expected = implode(', ', $missing);

        $valid = true;
        foreach ($this->get_grade_category_names($course->id) as $name) {
            // A category is only accepted once, so a repeated one is reported as not being in the reference course.
            if (isset($missing[$normalise($name)])) {
                unset($missing[$normalise($name)]);
            } else {
                $valid = false;
                $this->check->add_failed('', $link, translation_manager::generate(
                    'referencesettings_gradecategory_extra',
                    $component,
                    ['name' => $name, 'expected' => $expected]
                ));
            }
        }
        foreach ($missing as $name) {
            $valid = false;
            $this->check->add_failed('', $link, translation_manager::generate(
                'referencesettings_gradecategory_missing',
                $component,
                ['name' => $name]
            ));
        }
        if ($valid) {
            $this->check->add_successful('', $link, translation_manager::generate(
                'referencesettings_gradecategories_success',
                $component,
                ['expected' => $expected]
            ));
        }
        if (config::get(self::COMPARE_GRADE_CATEGORY_SETTINGS, self::COMPARE_GRADE_CATEGORY_SETTINGS_DEFAULT)) {
            $this->compare_grade_category_settings($course, $referencecourse);
        }
    }

    /**
     * Compares the settings of each gradebook category, and of the course total, with the reference course.
     *
     * Categories are matched by name, ignoring case. Missing and extra categories are reported by compare_grade_categories().
     *
     * @param stdClass $course
     * @param stdClass $referencecourse
     */
    protected function compare_grade_category_settings(stdClass $course, stdClass $referencecourse): void {
        $component = 'coursechecker_referencesettings';
        $link = (new moodle_url('/grade/edit/tree/index.php', ['id' => $course->id]))->out(false);
        $current = $this->get_grade_categories($course->id);

        foreach ($this->get_grade_categories($referencecourse->id) as $key => $reference) {
            if (!isset($current[$key])) {
                continue;
            }
            $name = $key === '' ? translation_manager::generate('coursetotal', 'grades') : $reference->fullname;
            $referencevalues = $this->get_grade_category_settings($reference, $reference);
            $currentvalues = $this->get_grade_category_settings($current[$key], $reference);
            $valid = true;
            foreach ($referencevalues as $setting => [$label, $value]) {
                if ($value === $currentvalues[$setting][1]) {
                    continue;
                }
                $valid = false;
                $this->check->add_failed('', $link, translation_manager::generate(
                    'referencesettings_gradecategory_setting_failing',
                    $component,
                    [
                        'setting' => $label,
                        'category' => $name,
                        'comparison' => translation_manager::generate('referencesettings_comparison', $component, [
                            'settingvaluereference' => $value,
                            'settingvaluecurrent' => $currentvalues[$setting][1],
                        ]),
                    ]
                ));
            }
            if ($valid) {
                $this->check->add_successful('', $link, translation_manager::generate(
                    'referencesettings_gradecategory_settings_success',
                    $component,
                    ['category' => $name]
                ));
            }
        }
    }

    /**
     * Get the settings of a gradebook category that are compared, with their label and a readable value.
     *
     * The weight of a category depends on how its parent aggregates the grades, which the reference course defines.
     * Weights calculated by the gradebook are only compared when one of them was set by hand.
     *
     * @param stdClass $category Category with the settings of its grade item and the aggregation of its parent.
     * @param stdClass $reference The same category in the reference course.
     * @return array Readable [label, value] indexed by setting.
     */
    protected function get_grade_category_settings(stdClass $category, stdClass $reference): array {
        $label = fn(string $identifier): string => translation_manager::generate($identifier, 'grades');
        $yesno = fn($value): string => translation_manager::generate($value ? 'yes' : 'no', 'moodle');
        $named = fn(array $names, $value): string => isset($names[(int) $value]) ? $label($names[(int) $value]) : (string) $value;
        $number = fn($value): string => format_float((float) $value, 2, false, true);

        $settings = [
            'aggregation' => [$label('aggregation'), $named(self::GRADE_AGGREGATIONS, $category->aggregation)],
            'aggregateonlygraded' => [$label('aggregateonlygraded'), $yesno($category->aggregateonlygraded)],
            'aggregateoutcomes' => [$label('aggregateoutcomes'), $yesno($category->aggregateoutcomes)],
            'droplow' => [$label('droplow'), (string) (int) $category->droplow],
            'keephigh' => [$label('keephigh'), (string) (int) $category->keephigh],
            'gradetype' => [$label('gradetype'), $named(self::GRADE_TYPES, $category->gradetype)],
            'grademax' => [$label('grademax'), $number($category->grademax)],
            'grademin' => [$label('grademin'), $number($category->grademin)],
            'gradepass' => [$label('gradepass'), $number($category->gradepass)],
            'hidden' => [$label('hidden'), $yesno($category->itemhidden)],
            'display' => [$label('gradedisplaytype'), $category->display ?
                $named(self::GRADE_DISPLAY_TYPES, $category->display) : translation_manager::generate('default', 'moodle')],
            'decimals' => [$label('decimalpoints'), $category->decimals === null ?
                translation_manager::generate('default', 'moodle') : (string) (int) $category->decimals],
        ];
        $parentaggregation = (int) $reference->parentaggregation;
        if ($parentaggregation === 10) {
            $settings['aggregationcoef'] = [$label('aggregationcoefweight'), $number($category->aggregationcoef)];
        } else if (in_array($parentaggregation, [12, 13], true)) {
            $settings['aggregationcoef'] = [$label('aggregationcoefextra'), $yesno((float) $category->aggregationcoef)];
        }
        if ($parentaggregation === 13 && ($reference->weightoverride || $category->weightoverride)) {
            $settings['aggregationcoef2'] = [$label('weight'), $number($category->aggregationcoef2 * 100) . '%'];
        }
        return $settings;
    }

    /**
     * Get the gradebook categories of a course with the settings of their grade item.
     *
     * @param int $courseid
     * @return stdClass[] Indexed by name in lower case; the top category, which is the course total, has an empty key.
     */
    protected function get_grade_categories(int $courseid): array {
        global $DB;

        $records = $DB->get_records_sql(
            "SELECT gc.id, gc.fullname, gc.parent, gc.aggregation, gc.aggregateonlygraded, gc.aggregateoutcomes,
                    gc.droplow, gc.keephigh, gi.gradetype, gi.grademax, gi.grademin, gi.gradepass, gi.hidden AS itemhidden,
                    gi.display, gi.decimals, gi.aggregationcoef, gi.aggregationcoef2, gi.weightoverride,
                    p.aggregation AS parentaggregation
               FROM {grade_categories} gc
               JOIN {grade_items} gi ON gi.iteminstance = gc.id AND gi.courseid = gc.courseid
                    AND gi.itemtype IN ('course', 'category')
          LEFT JOIN {grade_categories} p ON p.id = gc.parent
              WHERE gc.courseid = :courseid
           ORDER BY gc.path",
            ['courseid' => $courseid]
        );
        $categories = [];
        foreach ($records as $record) {
            $key = empty($record->parent) ? '' : core_text::strtolower(trim($record->fullname));
            // A repeated category is already reported, so only the first one is compared.
            $categories[$key] ??= $record;
        }
        return $categories;
    }

    /**
     * Get the names of the gradebook categories of a course, without the top category, which is the course itself.
     *
     * @param int $courseid
     * @return string[]
     */
    protected function get_grade_category_names(int $courseid): array {
        global $DB;

        return $DB->get_fieldset_select(
            'grade_categories',
            'fullname',
            'courseid = ? AND parent IS NOT NULL ORDER BY path',
            [$courseid]
        );
    }

    /**
     * Checks that the course has a course image, if required.
     *
     * @param stdClass $course
     */
    protected function check_course_image(stdClass $course): void {
        if (!config::get(self::REQUIRE_IMAGE, self::REQUIRE_IMAGE_DEFAULT)) {
            return;
        }
        $link = resolution_link_helper::get_link_to_course_edit_page($course);
        if (course_summary_exporter::get_course_image($course)) {
            $this->check->add_successful('', $link, translation_manager::generate(
                'referencesettings_image_success',
                'coursechecker_referencesettings'
            ));
        } else {
            $this->check->add_failed('', $link, translation_manager::generate(
                'referencesettings_image_missing',
                'coursechecker_referencesettings'
            ));
        }
    }

    /**
     * Checks that the course has a start date and no end date, if required.
     *
     * @param stdClass $course
     */
    protected function check_course_dates(stdClass $course): void {
        if (!config::get(self::REQUIRE_START_DATE_ONLY, self::REQUIRE_START_DATE_ONLY_DEFAULT)) {
            return;
        }
        $link = resolution_link_helper::get_link_to_course_edit_page($course);
        $valid = true;
        if (empty($course->startdate)) {
            $valid = false;
            $this->check->add_failed('', $link, translation_manager::generate(
                'referencesettings_startdate_missing',
                'coursechecker_referencesettings'
            ));
        }
        if (!empty($course->enddate)) {
            $valid = false;
            $this->check->add_failed('', $link, translation_manager::generate(
                'referencesettings_enddate_set',
                'coursechecker_referencesettings',
                ['enddate' => userdate($course->enddate, get_string('strftimedate', 'langconfig'))]
            ));
        }
        if ($valid) {
            $this->check->add_successful('', $link, translation_manager::generate(
                'referencesettings_dates_success',
                'coursechecker_referencesettings'
            ));
        }
    }

    /**
     * Get the value of a setting used to compare it.
     *
     * The default grouping is an id of each course, so only whether there is one can be compared.
     *
     * @param string $setting
     * @param stdClass $course
     * @return mixed
     */
    protected function get_setting_value(string $setting, stdClass $course): mixed {
        return $setting === 'defaultgroupingid' ? (int) !empty($course->$setting) : $course->$setting;
    }

    /**
     * Get the translatable label of a setting.
     *
     * @param string $setting
     * @return string
     */
    protected function get_setting_label(string $setting): string {
        return isset(self::SETTING_LABELS[$setting]) ?
            translation_manager::generate(self::SETTING_LABELS[$setting][0], self::SETTING_LABELS[$setting][1]) : $setting;
    }

    /**
     * Initialize checker by setting it up with the configuration
     *
     * @throws dml_exception
     */
    public function init(): void {
        // Load settings.
        $this->referencecourseid = (int) config::get(self::REFERENCE_COURSE, self::REFERENCE_COURSE_DEFAULT);
        $referencesettings = config::get(self::REFERENCE_COURSE_SETTINGS, self::REFERENCE_COURSE_SETTINGS_DEFAULT);
        if (is_array($referencesettings)) {
            $this->referencesettings = array_keys($referencesettings);
        } else {
            $this->referencesettings = explode(',', $referencesettings);
        }
        $this->referencefilterenabled = config::get(
            self::REFERENCE_COURSE_FILTER_ENABLED,
            self::REFERENCE_COURSE_FILTER_ENABLED_DEFAULT
        );
        $this->referenceformatoptionsenabled = config::get(
            self::REFERENCE_COURSE_FORMAT_OPTION_ENABLED,
            self::REFERENCE_COURSE_FORMAT_OPTION_ENABLED_DEFAULT
        );
    }

    /**
     * Compares default course settings between the current and reference course.
     * Adds results to the check object and updates its status.
     *
     * @param stdClass $course The course object used for linking.
     * @param stdClass $referencecourse The reference course object.
     * @param stdClass $currentcourse The current course object.
     */
    protected function compare_default_course_settings(stdClass $course, stdClass $referencecourse, stdClass $currentcourse): void {
        // Run comparison for every attribute.
        foreach ($this->referencesettings as $setting) {
            // Does the attribute exist on both courses?
            if (!property_exists($referencecourse, $setting) || !property_exists($currentcourse, $setting)) {
                $message = translation_manager::generate(
                    'referencesettings_settingismissing',
                    'coursechecker_referencesettings',
                    ['setting' => $setting]
                );
                $this->check->add_failed('', '', $message);
                continue;
            }

            // Get link to course edit page.
            $link = resolution_link_helper::get_link_to_course_edit_page($course);

            // What are the differences? (if any).
            $comparison = $this->get_comparison_string($setting, $referencecourse, $currentcourse);

            // When the settings are not equal.
            if ($this->get_setting_value($setting, $referencecourse) != $this->get_setting_value($setting, $currentcourse)) {
                $message = translation_manager::generate(
                    'referencesettings_failing',
                    'coursechecker_referencesettings',
                    [
                        'setting' => $this->get_setting_label($setting),
                        'comparison' => $comparison,
                    ]
                );
                $this->check->add_failed('', $link, $message);
                continue;
            }

            // When everything is okay.
            $message = translation_manager::generate(
                'referencesettings_success',
                'coursechecker_referencesettings',
                ['setting' => $this->get_setting_label($setting)]
            );
            $this->check->add_successful('', $link, $message);
        }
    }

    /**
     * Generates a translated string comparing a setting between the reference and current course.
     *
     * @param string $setting The name of the setting to compare.
     * @param stdClass $referencecourse The reference course object.
     * @param stdClass $currentcourse The current course object.
     * @return string The translated comparison string.
     */
    private function get_comparison_string(string $setting, stdClass $referencecourse, stdClass $currentcourse): string {
        return translation_manager::generate(
            'referencesettings_comparison',
            'coursechecker_referencesettings',
            [
                'settingvaluereference' => $this->get_setting_value($setting, $referencecourse),
                'settingvaluecurrent' => $this->get_setting_value($setting, $currentcourse),
            ]
        );
    }

    /**
     * Compares enabled filters between current and reference courses.
     * Reports mismatches and sets check status accordingly.
     *
     * @param stdClass $currentcourse The current course object.
     * @param stdClass $referencecourse The reference course object.
     * @throws coding_exception
     */
    protected function compare_course_level_filters(stdClass $currentcourse, stdClass $referencecourse): void {
        if (!$this->referencefilterenabled) {
            return;
        }

        // Get the course context for the current course and the reference course.
        $currentcontext = context_course::instance($currentcourse->id);
        $referencecontext = context_course::instance($referencecourse->id);

        // Get the list of available filters.
        $currentavailablefilters = filter_get_available_in_context($currentcontext);
        $referenceavailablefilters = filter_get_available_in_context($referencecontext);

        // Count occurring errors.
        $occurringfilterproblems = 0;

        // Get link to course filter page.
        $link = resolution_link_helper::get_link_to_course_filter_page($currentcontext);

        // Count all errors.
        foreach ($referenceavailablefilters as $filterkey => $referencefilterinfo) {
            if (!isset($currentavailablefilters[$filterkey])) {
                $message = translation_manager::generate(
                    'referencefilter_filternotsetincurrentcourse',
                    'coursechecker_referencesettings',
                    ['filterkey' => $filterkey]
                );
                $this->check->add_failed('', $link, $message);
                continue;
            }
            if ($currentavailablefilters[$filterkey]->localstate != $referencefilterinfo->localstate) {
                // What are the differences? (if any).
                $comparison = $this->get_filter_comparison_string($referencefilterinfo, $currentavailablefilters[$filterkey]);
                $message = translation_manager::generate(
                    'referencefilter_failing',
                    'coursechecker_referencesettings',
                    ['filterkey' => $filterkey,
                        'comparison' => $comparison]
                );
                $this->check->add_failed('', $link, $message);

                $occurringfilterproblems++;
            }
        }

        // When everything is okay.
        if ($occurringfilterproblems === 0) {
            $message = translation_manager::generate(
                'referencefilter_success',
                'coursechecker_referencesettings'
            );

            $this->check->add_successful('', $link, $message);
        }
    }

    /**
     * Generates a translated string comparing a filter setting between two courses.
     *
     * @param object $filterinforeference The filter info from the reference course.
     * @param object $filterinfocurrent The filter info from the current course.
     * @return string The translated filter comparison string.
     */
    private function get_filter_comparison_string(object $filterinforeference, object $filterinfocurrent): string {
        return translation_manager::generate(
            'referencefilter_comparison',
            'coursechecker_referencesettings',
            [
                'filtervaluereference' => $filterinforeference->localstate,
                'filtervaluecurrent' => $filterinfocurrent->localstate,
            ]
        );
    }

    /**
     * Compares format options between the current and reference course.
     * Reports differences and marks the check as failed if mismatches are found.
     *
     * @param stdClass $currentcourse The current course object.
     * @param stdClass $referencecourse The reference course object.
     * @throws coding_exception
     */
    protected function compare_course_format_options(stdClass $currentcourse, stdClass $referencecourse): void {
        global $PAGE, $COURSE;
        if (!$this->referenceformatoptionsenabled) {
            return;
        }
        $occurringoptionproblems = 0;

        $PAGE->set_course($currentcourse);
        $current = course_get_format($COURSE)->get_format_options();
        $PAGE->set_course($referencecourse);
        $reference = course_get_format($COURSE)->get_format_options();
        $link = resolution_link_helper::get_link_to_course_edit_page($currentcourse);

        foreach ($reference as $optionkey => $value) {
            if (!isset($current[$optionkey])) {
                continue;
            }
            if ($value == $current[$optionkey]) {
                continue;
            }
            $comparison = translation_manager::generate(
                'referencesettings_comparison',
                'coursechecker_referencesettings',
                ['settingvaluereference' => $value, 'settingvaluecurrent' => $current[$optionkey]]
            );
            $message = translation_manager::generate(
                'referenceformatoptions_failing',
                'coursechecker_referencesettings',
                ['optionkey' => $optionkey, 'comparison' => $comparison]
            );
            $this->check->add_failed('', $link, $message);

            $occurringoptionproblems++;
        }

        // When everything is okay.
        if ($occurringoptionproblems === 0) {
            $message = translation_manager::generate(
                'referenceformatoptions_success',
                'coursechecker_referencesettings'
            );
            $this->check->add_successful('', $link, $message);
        }
    }
}

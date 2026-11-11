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
 * Strings for component 'coursechecker_referencesettings'.
 *
 * @package    coursechecker_referencesettings
 * @copyright  2025 Simon Gisler, Fernfachhochschule Schweiz (FFHS) <simon.gisler@ffhs.ch>
 * @copyright  based on work by 2019 Liip SA <elearning@liip.ch>
 * @copyright  based on work by 2019 Adrian Perez, Fernfachhochschule Schweiz (FFHS) <adrian.perez@ffhs.ch>
 * @copyright  based on work by 2020 Christoph Karlen, Fernfachhochschule Schweiz (FFHS) <christoph.karlen@ffhs.ch>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Reference settings check';
$string['pluginname_help'] = 'This check compares the selected general course settings with a reference course and can additionally compare course-level filter states and course-format options. Only configured setting groups are checked; unavailable selected course properties are reported as failures. It can also require a course image and a start date without an end date; these two rules do not apply to the reference course. It also compares the names and the settings of the gradebook categories.';
$string['privacy:metadata'] = 'This check does not store any personal data. Its results are stored by the Course Checker plugin.';

// String specific for the reference course settings checker.
$string['referencesettings_comparison'] =
        ' (Reference course: "{$a->settingvaluereference}" | Current course: "{$a->settingvaluecurrent}")';
$string['referencesettings_settingismissing'] = '"{$a->setting}" is not an available course setting.';
$string['referencesettings_failing'] = 'The setting "{$a->setting}" is not correct {$a->comparison}';
$string['referencesettings_success'] = 'The setting "{$a->setting}" is correct';
$string['referencesettings_checklist'] = 'Reference course checker settings checklist';
$string['referencesettings_checklist_help'] = 'Please select one or multiple settings to check with the reference course.';

// String specific for the reference course settings checker filters.
$string['referencefilter_comparison'] =
        ' (Reference course: "{$a->filtervaluereference}" | Current course: "{$a->filtervaluecurrent}")';
$string['referencefilter_failing'] = 'The filter "{$a->filterkey}" is not correct {$a->comparison}';
$string['referencefilter_success'] = 'All filters are correctly set in current course';
$string['referencefilter_enabled'] = 'Reference settings filter check enabled';
$string['referencefilter_enabled_help'] = 'Please enable this to compare all course filter with the reference course.';
$string['referencefilter_filternotsetincurrentcourse'] = 'The filter "{$a->filterkey}" is missing in the current course.';
$string['referenceformatoptions_failing'] = 'The format option "{$a->optionkey}" is not correct {$a->comparison}';
$string['referenceformatoptions_success'] = 'All format options are correctly set in current course';
$string['referenceformatoptions_enabled'] = 'Reference settings format options check enabled';
$string['referenceformatoptions_enabled_help'] =
        'Please enable this to compare all course format options with the reference course.';
// Course image and dates.
$string['referencesettings_dates_success'] = 'The course has a start date and no end date';
$string['referencesettings_enddate_set'] = 'The course has an end date ({$a->enddate}). It must only have a start date.';
$string['referencesettings_gradecategories_success'] = 'The gradebook has the categories of the reference course: {$a->expected}.';
$string['referencesettings_gradecategory_extra'] = 'The gradebook category "{$a->name}" is not expected: the gradebook must have only the categories of the reference course ({$a->expected}).';
$string['referencesettings_gradecategory_missing'] = 'The category "{$a->name}" is missing from the gradebook.';
$string['referencesettings_image_missing'] = 'The course has no course image.';
$string['referencesettings_image_success'] = 'The course has a course image';
$string['referencesettings_requiregradecategories'] = 'Require the gradebook categories';
$string['referencesettings_requiregradecategories_help'] = 'The gradebook must have exactly the categories of the reference course, compared by name. Case is ignored.';
$string['referencesettings_comparegradecategorysettings'] = 'Compare the settings of the gradebook categories';
$string['referencesettings_comparegradecategorysettings_help'] = 'Compares with the reference course the settings of each gradebook category with the same name and of the course total: aggregation, empty grades, outcomes, dropped or kept grades, grade type, maximum, minimum and passing grades, visibility, display type, decimals and weight or extra credit. Only applies if the gradebook categories are required.';
$string['referencesettings_gradecategory_setting_failing'] = 'The setting "{$a->setting}" of the gradebook category "{$a->category}" is not correct{$a->comparison}';
$string['referencesettings_gradecategory_settings_success'] = 'The gradebook category "{$a->category}" has the same settings as the reference course.';
$string['referencesettings_requireimage'] = 'Require a course image';
$string['referencesettings_requireimage_help'] = 'Checks that the course has an image. It does not apply to the reference course.';
$string['referencesettings_requirestartdateonly'] = 'Require only a start date';
$string['referencesettings_requirestartdateonly_help'] = 'Checks that the course has a start date and no end date. It does not apply to the reference course.';
$string['referencesettings_startdate_missing'] = 'The course has no start date.';

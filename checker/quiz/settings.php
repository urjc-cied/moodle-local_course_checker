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
 * @copyright  2026 Stefan Dani, Fernfachhochschule Schweiz (FFHS) <stefan.dani@ffhs.ch>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use coursechecker_quiz\checker;
use local_course_checker\admin\admin_setting_regex;
use local_course_checker\admin\admin_setting_restrictedint;

defined('MOODLE_INTERNAL') || die();

/** @var admin_settingpage $settings */

$settings->add(new admin_setting_regex(
    checker::WHITELISTREGEX,
    get_string('regex_whitelist', 'coursechecker_quiz'),
    get_string('regex_whitelist_desc', 'coursechecker_quiz'),
    checker::WHITELISTREGEX_DEFAULT
));

$settings->add(new admin_setting_configcheckbox(
    checker::GRADE_SUM_ENABLED,
    get_string('gradesum_enabled', 'coursechecker_quiz'),
    get_string('gradesum_enabled_desc', 'coursechecker_quiz'),
    checker::GRADE_SUM_ENABLED_DEFAULT
));

$settings->add(new admin_setting_heading(
    'coursechecker_quiz/exam_heading',
    get_string('exam_heading', 'coursechecker_quiz'),
    get_string('exam_heading_desc', 'coursechecker_quiz')
));

$settings->add(new admin_setting_configtext(
    checker::RANDOM_NAMEFILTER,
    get_string('randomquestions_namefilter', 'coursechecker_quiz'),
    get_string('randomquestions_namefilter_desc', 'coursechecker_quiz'),
    checker::RANDOM_NAMEFILTER_DEFAULT,
    PARAM_TEXT
));

$settings->add(new admin_setting_configcheckbox(
    checker::EXAM_NODATES,
    get_string('exam_nodates', 'coursechecker_quiz'),
    get_string('exam_nodates_desc', 'coursechecker_quiz'),
    1
));

$settings->add(new admin_setting_configcheckbox(
    checker::EXAM_TIMELIMIT,
    get_string('exam_timelimit', 'coursechecker_quiz'),
    get_string('exam_timelimit_desc', 'coursechecker_quiz'),
    1
));

$settings->add(new admin_setting_configtext(
    checker::EXAM_GRADEPASS,
    get_string('exam_gradepass', 'coursechecker_quiz'),
    get_string('exam_gradepass_desc', 'coursechecker_quiz'),
    checker::EXAM_GRADEPASS_DEFAULT,
    PARAM_TEXT
));

$settings->add(new admin_setting_configtext(
    checker::EXAM_ATTEMPTS,
    get_string('exam_attempts', 'coursechecker_quiz'),
    get_string('exam_attempts_desc', 'coursechecker_quiz'),
    checker::EXAM_ATTEMPTS_DEFAULT,
    PARAM_TEXT
));

$grademethods = ['0' => get_string('exam_notchecked', 'coursechecker_quiz')];
foreach (checker::GRADEMETHODS as $value => $identifier) {
    $grademethods[(string) $value] = get_string($identifier, 'quiz');
}
$settings->add(new admin_setting_configselect(
    checker::EXAM_GRADEMETHOD,
    get_string('exam_grademethod', 'coursechecker_quiz'),
    get_string('exam_grademethod_desc', 'coursechecker_quiz'),
    checker::EXAM_GRADEMETHOD_DEFAULT,
    $grademethods
));

$settings->add(new admin_setting_configcheckbox(
    checker::EXAM_DELAY_ENABLED,
    get_string('exam_delay_enabled', 'coursechecker_quiz'),
    get_string('exam_delay_enabled_desc', 'coursechecker_quiz'),
    1
));

$settings->add(new admin_setting_configduration(
    checker::EXAM_DELAY1,
    get_string('delay1st2nd', 'quiz'),
    get_string('exam_delay_desc', 'coursechecker_quiz'),
    checker::EXAM_DELAY_DEFAULT,
    DAYSECS
));

$settings->add(new admin_setting_configduration(
    checker::EXAM_DELAY2,
    get_string('delaylater', 'quiz'),
    get_string('exam_delay_desc', 'coursechecker_quiz'),
    checker::EXAM_DELAY_DEFAULT,
    DAYSECS
));

$settings->add(new admin_setting_configcheckbox(
    checker::EXAM_REVIEW_ENABLED,
    get_string('exam_review_enabled', 'coursechecker_quiz'),
    get_string('exam_review_enabled_desc', 'coursechecker_quiz'),
    1
));

$reviewoptions = [];
foreach (checker::REVIEW_OPTIONS as $option => [$identifier, $component]) {
    $reviewoptions[$option] = get_string($identifier, $component);
}
$settings->add(new admin_setting_configmulticheckbox(
    checker::EXAM_REVIEW_OPTIONS,
    get_string('exam_reviewoptions', 'coursechecker_quiz'),
    get_string('exam_reviewoptions_desc', 'coursechecker_quiz'),
    checker::EXAM_REVIEW_OPTIONS_DEFAULT,
    $reviewoptions
));

$reviewtimes = [];
foreach (checker::REVIEW_TIMES as $time => [$bit, $identifier]) {
    $reviewtimes[$time] = get_string($identifier, 'quiz');
}
$settings->add(new admin_setting_configmulticheckbox(
    checker::EXAM_REVIEW_TIMES,
    get_string('exam_reviewtimes', 'coursechecker_quiz'),
    get_string('exam_reviewtimes_desc', 'coursechecker_quiz'),
    checker::EXAM_REVIEW_TIMES_DEFAULT,
    $reviewtimes
));

$settings->add(new admin_setting_configcheckbox(
    checker::EXAM_OVERALLFEEDBACK,
    get_string('exam_overallfeedback', 'coursechecker_quiz'),
    get_string('exam_overallfeedback_desc', 'coursechecker_quiz'),
    1
));

$settings->add(new admin_setting_configcheckbox(
    checker::EXAM_COMPLETION,
    get_string('exam_completion', 'coursechecker_quiz'),
    get_string('exam_completion_desc', 'coursechecker_quiz'),
    1
));

$settings->add(new admin_setting_heading(
    'coursechecker_quiz/randomquestions_heading',
    get_string('randomquestions_heading', 'coursechecker_quiz'),
    get_string('randomquestions_heading_desc', 'coursechecker_quiz')
));

$settings->add(new admin_setting_configcheckbox(
    checker::RANDOM_ENABLED,
    get_string('randomquestions_enabled', 'coursechecker_quiz'),
    get_string('randomquestions_enabled_desc', 'coursechecker_quiz'),
    checker::RANDOM_ENABLED_DEFAULT
));

$required = new admin_setting_restrictedint(
    checker::RANDOM_REQUIRED,
    get_string('randomquestions_required', 'coursechecker_quiz'),
    get_string('randomquestions_required_desc', 'coursechecker_quiz'),
    checker::RANDOM_REQUIRED_DEFAULT
);
$required->set_minimum(1);
$settings->add($required);

$settings->add(new admin_setting_configcheckbox(
    checker::RANDOM_MATCHCATEGORY,
    get_string('randomquestions_matchcategory', 'coursechecker_quiz'),
    get_string('randomquestions_matchcategory_desc', 'coursechecker_quiz'),
    checker::RANDOM_MATCHCATEGORY_DEFAULT
));

$settings->add(new admin_setting_configcheckbox(
    checker::RANDOM_INCLUDESUBCATEGORIES,
    get_string('randomquestions_includesubcategories', 'coursechecker_quiz'),
    get_string('randomquestions_includesubcategories_desc', 'coursechecker_quiz'),
    checker::RANDOM_INCLUDESUBCATEGORIES_DEFAULT
));

$settings->add(new admin_setting_heading(
    'coursechecker_quiz/gradecategory_heading',
    get_string('gradecategory_heading', 'coursechecker_quiz'),
    get_string('gradecategory_heading_desc', 'coursechecker_quiz')
));

$settings->add(new admin_setting_configtextarea(
    checker::GRADECATEGORY_RULES,
    get_string('gradecategory_rules', 'coursechecker_quiz'),
    get_string('gradecategory_rules_desc', 'coursechecker_quiz'),
    checker::GRADECATEGORY_RULES_DEFAULT,
    PARAM_TEXT
));

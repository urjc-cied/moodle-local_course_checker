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
 * Strings for component 'coursechecker_quiz'.
 *
 * @package    coursechecker_quiz
 * @copyright  2025 Simon Gisler, Fernfachhochschule Schweiz (FFHS) <simon.gisler@ffhs.ch>
 * @copyright  based on work by 2019 Liip SA <elearning@liip.ch>
 * @copyright  based on work by 2019 Adrian Perez, Fernfachhochschule Schweiz (FFHS) <adrian.perez@ffhs.ch>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Quiz check';
$string['pluginname_help'] = 'This check can compare the maximum grade with the total question marks for every quiz in the course (disabled by default) and validates that each quiz is in the gradebook category that corresponds to its name. For exams, that is, quizzes whose name contains the configured text (by default "Examen"), it also validates the timing, the time limit, the grade, the attempts, the review options, the overall feedback, the activity completion, the configured number of random questions and that there are enough questions available. Quizzes whose names match the configured whitelist regular expression are not checked.';
$string['privacy:metadata'] = 'This check does not store any personal data. Its results are stored by the Course Checker plugin.';

$string['regex_whitelist'] = 'Regex quiz title whitelist';
$string['regex_whitelist_desc'] = 'Enter a regex pattern. Quizzes matching this title pattern will be whitelisted and skip the check.';
$string['quiz_in_whitelist'] = 'The quiz was not verified because it matches the whitelist pattern.';
$string['quiz_grade_sum_error'] = 'Maximum grade ({$a->grade}) and Total of marks ({$a->sumgrades}) should be the same number in this quiz';
$string['quiz_grade_sum_success'] = 'This quiz is configured correctly';
$string['quiz_activity'] = 'Activity: {$a->name}  ({$a->modname})';

// Random questions.
$string['gradecategory_heading'] = 'Gradebook categories';
$string['gradecategory_heading_desc'] = 'Gradebook category each quiz must be in, according to its name. Quizzes that match no rule and those on the whitelist are not checked.';
$string['gradecategory_rules'] = 'Rules by quiz name';
$string['gradecategory_rules_desc'] = 'One rule per line with the format text|category. If the name of the quiz contains the text, it must be in that gradebook category. The first matching rule applies, ignoring case and accents. Leave it blank to not apply this validation.';
$string['quiz_gradecategory_error'] = 'The quiz must be in the gradebook category "{$a->category}", but it is in "{$a->current}".';
$string['quiz_gradecategory_none'] = 'No category';
$string['quiz_gradecategory_rule_invalid'] = 'The rule "{$a->line}" is not valid: it must have the format text|category. Correct it in the settings of this check.';
$string['quiz_gradecategory_success'] = 'The quiz is in the gradebook category "{$a->category}".';
$string['randomquestions_heading'] = 'Random questions';
$string['randomquestions_heading_desc'] = 'Rules that the quizzes whose name contains the configured text must meet, except those on the whitelist.';
$string['randomquestions_enabled'] = 'Validate random questions';
$string['randomquestions_enabled_desc'] = 'Validate the random questions of the quizzes and that there are enough questions available to start an attempt.';
$string['randomquestions_namefilter_desc'] = 'Quizzes whose name contains this text, anywhere, are exams: the exam and random question rules apply to them. Case and accents are ignored. Leave it empty to apply them to every quiz.';
$string['randomquestions_namefilter'] = 'Text that identifies the exams';
$string['randomquestions_required'] = 'Required random questions';
$string['randomquestions_required_desc'] = 'Exact number of random questions that each validated quiz must have.';
$string['randomquestions_matchcategory'] = 'Require a category named like the quiz';
$string['randomquestions_matchcategory_desc'] = 'The random questions must use the category of the course question bank that has the same name as the quiz. Case and surrounding spaces are ignored.';
$string['randomquestions_includesubcategories'] = 'Accept subcategories';
$string['randomquestions_includesubcategories_desc'] = 'The random questions can also use any subcategory of the category named like the quiz.';
$string['quiz_random_count_error'] = 'The quiz has {$a->random} random question(s) and {$a->fixed} fixed question(s), but it must have {$a->required} random questions.';
$string['quiz_random_fixed_warning'] = 'The quiz also has {$a->fixed} fixed question(s) in addition to the required random questions.';
$string['quiz_category_missing'] = 'The course question bank has no category named "{$a->name}".';
$string['quiz_category_mismatch'] = '{$a->count} random question(s) do not use the category "{$a->name}". They use: {$a->categories}.';
$string['quiz_category_mismatch_subcategories'] = '{$a->count} random question(s) do not use the category "{$a->name}" or its subcategories. They use: {$a->categories}.';
$string['quiz_category_insufficient'] = 'Not enough questions in {$a->categories}: {$a->available} available, but the quiz needs {$a->needed}.';
$string['quiz_questions_insufficient'] = 'Not enough different questions for the quiz: {$a->available} available, but it needs {$a->needed}.';
$string['quiz_random_success'] = 'The quiz has {$a->required} random questions and enough questions available.';
$string['quiz_random_success_category'] = 'The quiz has {$a->required} random questions from the category "{$a->name}" and enough questions available.';

// Exams.
$string['exam_heading'] = 'Exams';
$string['exam_heading_desc'] = 'Rules that the exams must meet, that is, the quizzes whose name contains the configured text, except those on the whitelist. Each rule can be disabled.';
$string['exam_nodates'] = 'No timing dates';
$string['exam_nodates_desc'] = 'Exams must not have an opening or closing date.';
$string['exam_timelimit'] = 'Require a time limit';
$string['exam_timelimit_desc'] = 'Exams must have a time limit, of any length.';
$string['exam_gradepass'] = 'Grade to pass';
$string['exam_gradepass_desc'] = 'Grade to pass that the exams must have. Leave it empty to not check it.';
$string['exam_attempts'] = 'Attempts allowed';
$string['exam_attempts_desc'] = 'Number of attempts that the exams must allow (0 is unlimited). Leave it empty to not check it.';
$string['exam_grademethod'] = 'Grading method';
$string['exam_grademethod_desc'] = 'Grading method that the exams must use.';
$string['exam_notchecked'] = 'Do not check';
$string['exam_review_enabled'] = 'Validate the review options';
$string['exam_review_enabled_desc'] = 'Validate what students see when they review an attempt of the exam.';
$string['exam_reviewoptions'] = 'Review options shown';
$string['exam_reviewoptions_desc'] = 'Options that must be shown in the validated moments; the others must not be shown in those moments.';
$string['exam_overallfeedback'] = 'Require overall feedback';
$string['exam_overallfeedback_desc'] = 'Exams must have text in at least one grade boundary of the overall feedback.';
$string['exam_completion'] = 'Require activity completion';
$string['exam_completion_desc'] = 'Exams must be completed automatically when the activity is viewed and a passing grade is obtained.';
$string['exam_dates_error'] = 'The exam must not have timing dates. It has: {$a->dates}.';
$string['exam_timelimit_error'] = 'The exam has no time limit.';
$string['exam_gradepass_error'] = 'The grade to pass must be {$a->expected}, but it is {$a->current}.';
$string['exam_attempts_error'] = 'The attempts allowed must be {$a->expected}, but they are: {$a->current}.';
$string['exam_grademethod_error'] = 'The grading method must be "{$a->expected}", but it is "{$a->current}".';
$string['exam_review_missing'] = 'In "{$a->time}", the review options must show: {$a->options}.';
$string['exam_review_extra'] = 'In "{$a->time}", the review options must not show: {$a->options}.';
$string['exam_overallfeedback_error'] = 'The exam has no overall feedback.';
$string['exam_completion_view'] = 'View the activity';
$string['exam_completion_error'] = 'The activity completion must be automatic and require: {$a->conditions}.';
$string['exam_settings_success'] = 'The exam has the required settings.';
$string['exam_setting_invalid'] = 'The value "{$a->value}" of the setting "{$a->setting}" is not valid. Correct it in the settings of this check.';
$string['exam_reviewtimes'] = 'Review moments validated';
$string['exam_reviewtimes_desc'] = 'Moments after the attempt in which the review options are validated. What is shown during the attempt is not checked.';
$string['exam_delay_enabled'] = 'Validate the delays between attempts';
$string['exam_delay_enabled_desc'] = 'Exams must enforce the delays between attempts configured below.';
$string['exam_delay_desc'] = 'Delay that the exam must have. With 0, the delay must be disabled.';
$string['exam_delay_error'] = '"{$a->setting}" must be {$a->expected}, but it is: {$a->current}.';
$string['gradesum_enabled'] = 'Require the maximum grade to equal the total of marks';
$string['gradesum_enabled_desc'] = 'Every quiz must have a maximum grade equal to the sum of the marks of its questions (for example 10 and 10). Disable it if the maximum grade is rescaled, for example to 100.';

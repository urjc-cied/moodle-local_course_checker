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
 * Strings for component 'coursechecker_structure'.
 *
 * @package    coursechecker_structure
 * @copyright  2026 URJCx
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Course structure check';
$string['pluginname_help'] = 'This check compares the course with the template, which is the reference course of the course checker. It applies to courses in the category of the template and its subcategories. It validates the fixed sections and their order, with a variable number of numbered modules; that the forums of the fixed sections of the template exist with the same settings; and that each module has its exam. Leading symbols such as emojis and case are ignored when comparing sections and forums. Forum descriptions are not compared; the forum that must have rules of use cannot have an empty description. Subsections are not checked and other course items are ignored. It also validates that the exams are required for course completion, combined as in the template; another required activity is a warning.';
$string['privacy:metadata'] = 'This check does not store any personal data. Its results are stored by the Course Checker plugin.';

$string['structure_completion'] = 'Course completion';
$string['structure_completion_activities'] = 'Activities completed';
$string['structure_completion_aggregation'] = 'The course completion does not match the template in "{$a->setting}": the template has "{$a->expected}" and this course has "{$a->actual}".';
$string['structure_completion_exam_missing'] = 'The exam "{$a->name}" is not among the activities required for course completion.';
$string['structure_completion_method_1'] = 'All must be met';
$string['structure_completion_method_2'] = 'Any one is enough';
$string['structure_completion_other'] = 'The activity "{$a->name}" is in the course completion, but only the exams should be there.';
$string['structure_completion_overall'] = 'Course completion requirements';
$string['structure_completion_success'] = 'The {$a->count} exams of the course are in the course completion.';
$string['structure_completionview'] = 'Require viewing the activity';
$string['structure_course'] = 'Course structure';
$string['structure_exam_duplicate'] = 'Module {$a->number} has more than one exam: {$a->names}. It must have only one.';
$string['structure_exam_hidden'] = 'The exam "{$a->name}" is hidden.';
$string['structure_exam_missing'] = 'The exam of module {$a->number} is missing: a quiz with "{$a->text}" in its name.';
$string['structure_exam_outside'] = 'The exam "{$a->name}" is in the section "{$a->section}". It must be inside its module.';
$string['structure_format_invalid'] = 'The format "{$a->format}" is not valid: it must contain N, which stands for the module number. Correct it in the settings of this check.';
$string['structure_forum_duplicate'] = 'The forum "{$a->name}" is repeated in the section "{$a->section}".';
$string['structure_forum_missing'] = 'The forum "{$a->name}" is missing from the section "{$a->section}".';
$string['structure_forum_rules_empty'] = 'The description of the {$a->name} does not include rules of use.';
$string['structure_forum_setting'] = 'The forum "{$a->name}" does not match the template in "{$a->setting}": the template has "{$a->expected}" and this course has "{$a->actual}".';
$string['structure_is_template'] = 'This course is the template the other courses are compared with, so it is not checked.';
$string['structure_module_number'] = 'The section "{$a->name}" has the number {$a->number}, but the number {$a->expected} was expected. Modules must be numbered consecutively starting from 1.';
$string['structure_modules_missing'] = 'The course has no module sections. Their names must start with the format "{$a->format}".';
$string['structure_not_applicable'] = 'This course is not in the category of the template, so it is not checked.';
$string['structure_section_duplicate'] = 'The section "{$a->name}" is repeated.';
$string['structure_section_missing'] = 'The section "{$a->name}" is missing.';
$string['structure_section_order'] = 'The section "{$a->name}" is out of order. The expected order is: {$a->order}.';
$string['structure_section_unexpected'] = 'The section "{$a->name}" is not part of the structure. A module section must start with the format "{$a->format}" followed by its name. The expected order is: {$a->order}.';
$string['structure_setting_moduleformat'] = 'Module format';
$string['structure_setting_moduleformat_desc'] = 'How the name of a module section must start, where N stands for its number. It must be followed by a space and the name of the module. For example, "N." accepts "1. Introduction to the topic". The other sections of the template are required in all courses.';
$string['structure_setting_rulesforum'] = 'Forum with rules of use';
$string['structure_setting_rulesforum_desc'] = 'Name of the forum whose description must include rules of use. An empty description shows a failure; it can have the same text as the template. Leave it blank to not apply this rule.';
$string['structure_success'] = 'The course follows the structure of the template: {$a->order}.';
$string['structure_template_invalid'] = 'The template cannot be used: it must have a single block of module sections with the format "{$a->format}". Correct it or review the settings of this check.';
$string['structure_template_missing'] = 'There is no valid template. Select the reference course in the general settings of the course checker.';
$string['structure_setting_examtext'] = 'Text that identifies the exams';
$string['structure_setting_examtext_desc'] = 'Every quiz whose name contains this text, anywhere, is an exam. Case and accents are ignored. The rest of the name is not checked.';

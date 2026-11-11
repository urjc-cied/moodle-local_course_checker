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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Upgrade steps for coursechecker_quiz.
 *
 * @package    coursechecker_quiz
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use coursechecker_quiz\checker;

/**
 * Upgrade the plugin.
 *
 * @param int $oldversion
 * @return bool
 */
function xmldb_coursechecker_quiz_upgrade($oldversion) {
    if ($oldversion < 2026110600) {
        // Replace the German default of the whitelist, but keep a value set by an administrator.
        if (get_config('coursechecker_quiz', 'regex_whitelist') === checker::WHITELISTREGEX_OLD_DEFAULT) {
            set_config('regex_whitelist', checker::WHITELISTREGEX_DEFAULT, 'coursechecker_quiz');
        }
        // The random questions no longer have to use the category named like the quiz.
        set_config('randomquestions_matchcategory', 0, 'coursechecker_quiz');
        upgrade_plugin_savepoint(true, 2026110600, 'coursechecker', 'quiz');
    }
    if ($oldversion < 2026110702) {
        // Quizzes named "Actividad de evaluación" are not used: exams are the evaluation activities.
        $rules = str_replace("\r\n", "\n", (string) get_config('coursechecker_quiz', 'gradecategory_rules'));
        if ($rules === checker::GRADECATEGORY_RULES_OLD_DEFAULT) {
            set_config('gradecategory_rules', checker::GRADECATEGORY_RULES_DEFAULT, 'coursechecker_quiz');
        }
        upgrade_plugin_savepoint(true, 2026110702, 'coursechecker', 'quiz');
    }
    return true;
}

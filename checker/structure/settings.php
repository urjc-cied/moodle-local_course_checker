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
 * Settings for checking the structure of the course sections.
 *
 * @package    coursechecker_structure
 * @copyright  2026 URJCx
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use coursechecker_structure\checker;

defined('MOODLE_INTERNAL') || die();

/** @var admin_settingpage $settings */
$settings;

$settings->add(new admin_setting_configtext(
    checker::MODULE_FORMAT,
    new lang_string('structure_setting_moduleformat', 'coursechecker_structure'),
    new lang_string('structure_setting_moduleformat_desc', 'coursechecker_structure'),
    checker::MODULE_FORMAT_DEFAULT,
    PARAM_TEXT
));
$settings->add(new admin_setting_configtext(
    checker::EXAM_TEXT,
    new lang_string('structure_setting_examtext', 'coursechecker_structure'),
    new lang_string('structure_setting_examtext_desc', 'coursechecker_structure'),
    checker::EXAM_TEXT_DEFAULT,
    PARAM_TEXT
));
$settings->add(new admin_setting_configtext(
    checker::RULES_FORUM,
    new lang_string('structure_setting_rulesforum', 'coursechecker_structure'),
    new lang_string('structure_setting_rulesforum_desc', 'coursechecker_structure'),
    checker::RULES_FORUM_DEFAULT,
    PARAM_TEXT
));

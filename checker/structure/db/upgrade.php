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
 * Upgrade steps for coursechecker_structure.
 *
 * @package    coursechecker_structure
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Upgrade the plugin.
 *
 * @param int $oldversion
 * @return bool
 */
function xmldb_coursechecker_structure_upgrade($oldversion) {
    if ($oldversion < 2026111100) {
        // The exact name of the exams is no longer checked: only the text that identifies them.
        unset_config('examformat', 'coursechecker_structure');
        upgrade_plugin_savepoint(true, 2026111100, 'coursechecker', 'structure');
    }
    return true;
}

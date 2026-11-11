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
 * Upgrade steps for coursechecker_userdata.
 *
 * @package    coursechecker_userdata
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Upgrade the plugin.
 *
 * @param int $oldversion
 * @return bool
 */
function xmldb_coursechecker_userdata_upgrade($oldversion) {
    if ($oldversion < 2026110600) {
        // Replace the German default of the forum whitelist, but keep a value set by an administrator.
        if (get_config('coursechecker_userdata', 'forum_whitelist_regex') === '/Modulentwicklungsforum/i') {
            set_config('forum_whitelist_regex', '/Foro de desarrollo del módulo/i', 'coursechecker_userdata');
        }
        upgrade_plugin_savepoint(true, 2026110600, 'coursechecker', 'userdata');
    }
    return true;
}

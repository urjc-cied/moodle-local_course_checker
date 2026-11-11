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

namespace local_course_checker\external;

use context_course;
use core_external\external_api;
use core_external\external_function_parameters;
use core_external\external_single_structure;
use core_external\external_value;
use local_course_checker\db\database_manager as dbm;
use local_course_checker\task\queue_check_task;
use local_course_checker\task\run_checker;

/**
 * Tells whether the checks of a course are still running, so that the report page can reload itself when they finish.
 *
 * @package    local_course_checker
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class get_progress extends external_api {
    /**
     * Parameters of the function.
     *
     * @return external_function_parameters
     */
    public static function execute_parameters(): external_function_parameters {
        return new external_function_parameters([
            'courseid' => new external_value(PARAM_INT, 'Course id'),
        ]);
    }

    /**
     * Get the progress of the checks of a course.
     *
     * @param int $courseid
     * @return array
     */
    public static function execute(int $courseid): array {
        ['courseid' => $courseid] = self::validate_parameters(self::execute_parameters(), ['courseid' => $courseid]);
        $context = context_course::instance($courseid);
        self::validate_context($context);
        require_capability('local/course_checker:view', $context);
        return self::get_course_progress($courseid);
    }

    /**
     * Get the progress of the checks of a course from the queued tasks.
     *
     * Failed tasks waiting to be retried are not counted, as on the report page.
     *
     * @param int $courseid
     * @return array queued: the checks are being prepared; pending: checks that have not finished yet.
     */
    public static function get_course_progress(int $courseid): array {
        $queued = !empty(dbm::planned_adhoc_tasks('\\' . queue_check_task::class, $courseid));
        $tasks = dbm::planned_adhoc_tasks('\\' . run_checker::class, $courseid);
        $pending = count(array_filter($tasks, fn($task) => $task->faildelay == 0));
        return ['inprogress' => $queued || $pending > 0, 'queued' => $queued, 'pending' => $pending];
    }

    /**
     * Description of the result.
     *
     * @return external_single_structure
     */
    public static function execute_returns(): external_single_structure {
        return new external_single_structure([
            'inprogress' => new external_value(PARAM_BOOL, 'Whether the checks are still running'),
            'queued' => new external_value(PARAM_BOOL, 'Whether the checks are still being prepared'),
            'pending' => new external_value(PARAM_INT, 'Number of checks that have not finished yet'),
        ]);
    }
}

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
 * Shows the progress of the running checks and reloads the report when they finish.
 *
 * @module     local_course_checker/progress
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
import Ajax from 'core/ajax';
import {getString} from 'core/str';

const INTERVAL = 4000;

/**
 * Show a text in the progress region.
 *
 * @param {HTMLElement} region
 * @param {Object} progress
 */
const showProgress = async(region, progress) => {
    if (!progress.inprogress) {
        region.textContent = await getString('progress_done', 'local_course_checker');
    } else if (progress.queued) {
        region.textContent = await getString('progress_queued', 'local_course_checker');
    } else {
        region.textContent = await getString('progress_pending', 'local_course_checker', progress.pending);
    }
};

/**
 * Ask for the progress until the checks finish, and then reload the page to show the results.
 *
 * @param {number} courseid
 */
export const init = (courseid) => {
    const region = document.querySelector('[data-region="local_course_checker-progress"]');
    const poll = () => {
        Ajax.call([{methodname: 'local_course_checker_get_progress', args: {courseid}}])[0]
            .then(async(progress) => {
                if (region) {
                    await showProgress(region, progress);
                }
                if (progress.inprogress) {
                    setTimeout(poll, INTERVAL);
                } else {
                    window.location.reload();
                }
                return progress;
            })
            .catch(() => setTimeout(poll, INTERVAL * 3));
    };
    setTimeout(poll, INTERVAL);
};

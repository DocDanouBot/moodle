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
 * Bulk user action add on to suspend and unsuspend the users.
 *
 * @package     tool_bulksuspendunsuspend
 * @copyright   2024 Lern.link
 * @author      Danou Nauck
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

function tool_bulksuspendunsuspend_bulk_user_actions() {

    return [
        'tool_bulksuspendunsuspend_suspend' =>
            new action_link(
                new moodle_url('/admin/tool/bulksuspendunsuspend/suspend.php'),
                get_string('suspenduser', 'admin')
            ),
        'tool_bulksuspendunsuspend_unsuspend' =>
            new action_link(
                new moodle_url('/admin/tool/bulksuspendunsuspend/unsuspend.php'),
                get_string('unsuspenduser', 'admin')
            ),
    ];
}

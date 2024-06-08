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
 * Resend new accont email to users 
 *
 * @package     tool_resendnewaccountemail
 * @copyright   2021 Daniel Neis Araujo <daniel@adapta.online>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../../config.php');
require_once($CFG->dirroot . '/admin/user/lib.php');
require_once($CFG->libdir.'/adminlib.php');

admin_externalpage_setup('userbulk');
require_capability('moodle/user:create', context_system::instance());

$return = $CFG->wwwroot.'/'.$CFG->admin.'/user/user_bulk.php';

if (empty($SESSION->bulk_users)) {
    redirect($return);
}

$form = new \tool_resendnewaccountemail\form\dateselector();

if ($data = $form->get_data()) {

    $task = new tool_resendnewaccountemail\task\sendemail();
    $task->set_custom_data(['bulk_users' => $SESSION->bulk_users]);
    if ($data->nextruntime > time()) {
        $task->set_next_run_time($data->nextruntime);
    }
    \core\task\manager::reschedule_or_queue_adhoc_task($task);
    redirect(new moodle_url('/admin/tool/resendnewaccountemail/index.php'), get_string('changessaved'));
} else {
    list($in, $params) = $DB->get_in_or_equal($SESSION->bulk_users);
    $userlist = $DB->get_records_select_menu('user', "id $in", $params, 'fullname', 'id,'.$DB->sql_fullname().' AS fullname', 0, MAX_BULK_USERS);
    $usernames = '<ul>';
    foreach ($userlist as $u) {
        $usernames .= '<li>' . $u . '</li>';
    }
    $usernames .= '</ul>';
    echo $OUTPUT->header();
    echo get_string('resendcheck', 'tool_resendnewaccountemail', $usernames);
    $form->display();
    echo $OUTPUT->footer();
}

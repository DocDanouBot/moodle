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
 * List queued adhoc tasks.
 *
 * @package     tool_resendnewaccountemail
 * @copyright   2023 Daniel Neis Araujo
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../../config.php');
require_once($CFG->dirroot . '/admin/user/lib.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->libdir.'/tablelib.php');

admin_externalpage_setup('userbulk');
require_capability('moodle/user:create', context_system::instance());

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('taskslist', 'tool_resendnewaccountemail'));

// Show a table of queued adhoc tasks.
$table = new flexible_table('adhoctasks');
$table->define_columns(['nextruntime', 'customdata', 'timecreated', 'edit']);
$table->define_headers([
    get_string('datetosend', 'tool_resendnewaccountemail'),
    get_string('customdata', 'tool_resendnewaccountemail'),
    get_string('timecreated'),
    get_string('edit')
]);
$table->define_baseurl($PAGE->url);
$table->set_attribute('id', 'adhoctasks');
$table->set_attribute('class', 'admintable generaltable');
$table->setup();

$tasks = $DB->get_records('task_adhoc', ['classname' => '\\tool_resendnewaccountemail\\task\\sendemail']);
foreach ($tasks as $t) {
    list($in, $params) = $DB->get_in_or_equal(array_values((array)(json_decode($t->customdata)->bulk_users)));
    $userlist = $DB->get_records_select_menu('user', "id $in", $params, 'fullname', 'id,'.$DB->sql_fullname().' AS fullname', 0, MAX_BULK_USERS);
    $usernames = '<ul>';
    foreach ($userlist as $u) {
        $usernames .= '<li>' . $u . '</li>';
    }
    $usernames .= '</ul>';
    $editurl = new moodle_url('/admin/tool/resendnewaccountemail/edit.php', ['id' => $t->id]);
    $editlink = html_writer::link($editurl, $OUTPUT->pix_icon('t/edit', get_string('edit')));

    $nextruntime = userdate($t->nextruntime);
    $attr = ['data-action' => 'deletetask', 'data-id' => $t->id, 'data-nextruntime' => $nextruntime, 'class' => 'ml-1'];
    $deletelink = html_writer::link('#', $OUTPUT->pix_icon('i/trash', get_string('delete')), $attr);

    $table->add_data([$nextruntime, $usernames, userdate($t->timecreated), $editlink . $deletelink]);
}
$PAGE->requires->js_call_amd('tool_resendnewaccountemail/delete_task', 'initModal', []);

$table->print_html();

echo $OUTPUT->footer();

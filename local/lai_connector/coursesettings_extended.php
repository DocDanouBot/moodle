<?php
// This file is part of Moodle - http://moodle.org/
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

define('NO_OUTPUT_BUFFERING', true); // The progress bar may be used here.

global $USER, $OUTPUT, $CFG, $PAGE, $DB;

use local_lai_connector\exceptions\lai_exception;

require_once __DIR__ . DIRECTORY_SEPARATOR . '../../config.php';
require_once($CFG->dirroot . '/local/lai_connector/classes/coursesettings_extended.php');

$courseid = required_param('course', PARAM_INT);
// Does the course really exist after all?
if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    throw new lai_exception('exception_lai_missing', $courseid);
}

$context = context_course::instance($course->id);
require_login($course);
require_capability('local/lai_connector:assetadd', $context);

// General Page setup.
$PAGE->set_context($context);
$PAGE->set_url($CFG->wwwroot.'/local/lai_connector/coursesettings_extended.php', array('course' => $courseid));
$PAGE->set_pagelayout('admin');
$PAGE->set_title(get_string("setting_courseext_pagetitle",  "local_lai_connector"));
$PAGE->set_heading(get_string("setting_courseext_header",  "local_lai_connector"));

$baseurl = $CFG->wwwroot."/local/lai_connector/coursesettings_extended.php";


// Now comes all the output.
echo $OUTPUT->header();
$fieldsToUpdate = array('userID' => $USER->id);
$result = \local_lai_connector\coursesettings_extended::updateSettings($course->id, $fieldsToUpdate, $context);
if ($result) {
    $statusmsg = get_string("settings_course_saved", "local_lai_connector");
    echo $OUTPUT->notification($statusmsg, 'notifysuccess');
}
echo $OUTPUT->footer();

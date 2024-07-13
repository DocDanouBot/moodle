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

/**
 * @package     local_lai_connector
 * @copyright   lern.link GmbH
 * @author      Danou Nauck
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

global $CFG, $DB, $PAGE, $USER;
require_once('../../config.php');
require_once($CFG->libdir.'/filelib.php');

// If the brain_id is empty it is created a new one.
$brainid = optional_param('brainid', "", PARAM_RAW);

// Some initializations.
$strplugin = get_string('pluginname', 'local_lai_connector');
$context = context_system::instance();
require_login();


if ($brainid == "") { // We create a new tarsus_brain.
    $strpagetitle = get_string('form_edit_pagetitle_new', 'local_lai_connector');
    $tarsusbrain = new \stdClass();
} else { // We edit an existing tarsus_brain, defined by brain_id.
    $strpagetitle = get_string('form_edit_pagetitle_edit', 'local_lai_connector');
    $tarsusbrain = new \local_lai_connector\tarsus_brain($brainid);
}


// Configuration of the page.
$editentryurl = new moodle_url('/local/lai_connector/edit_tarsus_brain.php');
$brainsmainurl = new moodle_url('/local/lai_connector/brains.php');
$PAGE->set_url($editentryurl);
$PAGE->set_context($context);
$PAGE->set_heading($strpagetitle);
$PAGE->set_title($strpagetitle);

// We use our own renderer.
$renderer = $PAGE->get_renderer('local_lai_connector');

// New form instance to create or edit a facility.
$form = new \local_lai_connector\forms\edit_brain();
$form->set_data($tarsusbrain);

// We can go back to the manage page.
if ($formdata = $form->is_cancelled()) {
    redirect($brainsmainurl);
}

// Save or update the facility.
if ($formdata = $form->get_data()) {
    // We don't handle save and update in the same way.
    $a = new \stdClass();
    if (!empty($formdata->brainid)) {
        $tarsusbrain = \local_lai_connector\util::update_tarsus_brain($formdata);
        $a->brainid = "<span style='font-weight:bold;'>" . $formdata->brainid . "</span>";
        $strtarsusbrainupdated = get_string('tarsus_brain_updated', 'local_lai_connector', $a);
    } else {
        $tarsusbrain = \local_lai_connector\util::create_tarsus_brain($formdata);
        $a->brainid = "<span style='font-weight:bold;'>" . $formdata->brainid . "</span>";
        $strtarsusbrainupdated = get_string('tarsus_brain_created', 'local_lai_connector',$a);
    }
    \core\notification::SUCCESS($strtarsusbrainupdated);
    redirect($brainsmainurl);
}

echo $renderer->header();
$form->display();
echo $renderer->footer();

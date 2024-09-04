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

/** curatedata page for this plugin
 *
 * @package     local_lai_connector
 * @copyright   lern.link GmbH
 * @author      Danou Nauck
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
$context = context_system::instance();

global $PAGE, $OUTPUT, $DB, $CFG, $USER;

// Check access.
require_login(null, false);
require_capability('local/lai_connector:viewcuratedatapage', $context);

// Set up $PAGE.
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
$pageheading = '<a href="/local/lai_connector/index.php" target="_self">'.get_string('indexpage_title', 'local_lai_connector').'</a>';
$pageheading .= ' | ' . get_string('curatedatapage_title', 'local_lai_connector');
$PAGE->set_title(get_string('curatedatapage_title', 'local_lai_connector'));
$PAGE->set_heading($pageheading, false, false);
$PAGE->set_url(new moodle_url('/local/lai_connector/curatedata.php'));
$PAGE->requires->css('/local/lai_connector/styles.css');
$PAGE->requires->jquery();
$PAGE->requires->jquery_plugin('ui');
$PAGE->requires->jquery_plugin('ui-css');

// Load the lib.js to allow ajax communication with server
# $PAGE->requires->js_call_amd('local_lai_connector/ajaxbuttons', 'init');

$tarsusBitsConfig = explode(',',strtolower( $CFG->local_lai_connector_tarsus_bits));
$initparams =['userid' => $USER->id, 'bitssettings' => $tarsusBitsConfig];
$PAGE->requires->js_call_amd('local_lai_connector/script', 'init',$initparams);

// Define and start the AI connector
$api = \local_lai_connector\ai_connector::get_instance();
$brains =  $api->list_brains();

// Define empty Array
$subpages = array();

$templatedata['indexpageurl'] =  new moodle_url('/local/lai_connector/index.php');
$templatedata['token'] = \local_lai_connector\ai_connector::get_instance()::get_api_token();
$templatedata['brains'] = $brains;

// Output content.
echo $OUTPUT->header();
echo $OUTPUT->render_from_template('local_lai_connector/page_curatedata', $templatedata);

# echo("tarsusBitsConfig");
# var_dump($tarsusBitsConfig);

/*
$courseid = 2;
$table = 'local_lai_connector_assets';
$db_results = $DB->get_records($table, ['courseid' => $courseid],'','id, brainid, bittype, userid, resourceid, assetid,cmid,timecreated,timemodified');

$temparray = (array) $db_results;
foreach ($temparray as $key => $value) {
    if (isset($value->cmid) && ($value->cmid > 0)) {
        // Sort it, so we have the cmids as keys
        $newarray[$value->cmid] = (array) $value;
    }

}
$tarsus['cmids'] = (array) $newarray;
$tarsus['enabled'] = true;
$returnarray['content'] =  $tarsus;
# return $returnarray;

echo("<pre>");
print_r($returnarray);
echo("</pre>");
*/


echo $OUTPUT->footer();

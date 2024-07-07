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
 * Index page for this plugin
 * @package     local_lai_connector
 * @copyright   lern.link GmbH
 * @author      Danou Nauck
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
$context = context_system::instance();

global $PAGE, $OUTPUT;

// Check access.
require_login(null, false);
require_capability('local/lai_connector:viewindexpage', $context);

// Set up $PAGE.
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
$PAGE->set_title(get_string('indexpage_title', 'local_lai_connector'));
$PAGE->set_heading($PAGE->title);
$PAGE->set_url(new moodle_url('/local/lai_connector/index.php'));

// Define empty Array
$subpages = array();

// What kind of subpages or additional pages do we display according to the rights of the user.
if (has_capability('local/lai_connector:settingsview', $PAGE->context)) {
    $subpages[] = array(
        'subpagelink' => new moodle_url('/local/lai_component/show_subpage.php'),
        'subpagename' => get_string('indexpage_subbrains_title', 'local_lai_connector'),
        'subpageinfo' => get_string('indexpage_subbrains_info', 'local_lai_connector'));
}

$templatedata['indexpages'] = $subpages;

// Output content.
echo $OUTPUT->header();
echo $OUTPUT->render_from_template('local_lai_connector/page_index', $templatedata);
echo $OUTPUT->footer();

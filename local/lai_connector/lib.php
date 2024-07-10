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

defined('MOODLE_INTERNAL') || die;

function local_lai_connector_extend_navigation_course(\navigation_node $navigation, $course, $context) {
    if (has_capability('local/lai_connector:assetadd', $context)) {
        $navigation->add(
            get_string("link_mainmenu_coursesettings", "local_lai_connector"),
            new \moodle_url('/local/lai_connector/coursesettings_extended.php', array('course' => $course->id)),
            \navigation_node::TYPE_SETTING,
            null,
            null,
            new \pix_icon('i/settings', '')
        );
    }
}

function local_lai_connector_extend_navigation(\global_navigation $navigation) {  //REFACTORED//
    global $CFG;
    $showlainodes = \local_lai_connector\util::show_lai_menu();
    if (is_siteadmin() || $showlainodes) {

        $context = \context_system::instance();

        if (has_capability('local/lai_connector:viewindexpage', $context)
            && ($CFG->local_lai_connector_activate_component == 1)) {
            $node = $navigation->add(
                get_string('link_mainmenu_index', 'local_lai_connector'),
                new \moodle_url('/local/lai_connector/index.php'),
                \navigation_node::NODETYPE_LEAF,
                get_string('link_mainmenu_index', 'local_lai_connector'),
                'local_lai_connector_index');
        }

    }
}

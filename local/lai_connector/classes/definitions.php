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

/** This is a definition file which stores all the constants used in the local_lai_connector
 *
 * @package     local_lai_connector
 * @copyright   lern.link GmbH
 * @author      Danou Nauck
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_lai_connector;

defined('MOODLE_INTERNAL') || die;

class definitions
{
    // Options for the API Connectors to different AI Providers
    // usage:
    // $allAIAPIs = \local_lai_connector\definitions::LOCAL_LAI_CONNECTOR_AVAILABLE_APIS;
    const LOCAL_LAI_CONNECTOR_AVAILABLE_APIS = array(
        'ANY'     => array('id' => 0, 'name' => 'Random', 'icon' => 'fa-user-o', 'color' => 'transparent', 'disabled' => true ),
        'TARSUS'  => array('id' => 1, 'name' => 'TARSUS', 'icon' => 'i/course', 'color' => '#090', 'disabled' => false ),
        'CHATGPT' => array('id' => 2, 'name' => 'chatGPT', 'icon' => 'e/template', 'color' => '#900', 'disabled' => false ),
        'CLAUDE'  => array('id' => 3, 'name' => 'CLAUDE', 'icon' => 'i/user', 'color' => '#009', 'disabled' => false ),
    );

    // Constants used for finding date threshold from config
    // usage: $time_constants = \local_lai_connector\definitions::LL_TIME_CONSTANTS['SECONDS_PER_WEEK']
    const LL_TIME_CONSTANTS = array(
        'SECONDS_PER_MINUTE' => 60,
        'SECONDS_PER_HOUR'   => 3600,
        'SECONDS_PER_DAY'    => 86400,
        'SECONDS_PER_WEEK'   => 604800,
        'SECONDS_PER_MONTH'  => 2592000,
        'SECONDS_PER_YEAR'   => 31536000,
    );

}
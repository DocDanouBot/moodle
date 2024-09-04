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

    // Options for the different BIT Types the Brains is accepting
    // usage:
    // $allBitTypes = \local_lai_connector\definitions::LOCAL_LAI_CONNECTOR_TRACK_BITS_TYPES;
    const LOCAL_LAI_CONNECTOR_TRACK_BITS_TYPES = array(
        'TEXT'          => 1,
        'DOCUMENT'      => 2,
        'QUESTION'      => 3,
        'QUESTION_OPEN' => 4,
        'QUESTION_BOOL' => 5,
        'IMAGE'         => 6,
        'AUDIO'         => 7,
        'VIDEO'         => 8,
        'URL'           => 9,
    );


    // Options for the different BIT Types the Brains is accepting
    // usage:
    // $allBitTypes = \local_lai_connector\definitions::LOCAL_LAI_CONNECTOR_TRACKABLE_ACTIVITY_TYPES;
    const LOCAL_LAI_CONNECTOR_TRACKABLE_ACTIVITY_TYPES = array(
        'ASSIGN'  => array('mod_id' => 1, 'mod_name' => 'mod_assign', 'linkToBittype' => 0, 'disabled' => true ),
        'BIGBLUEBUTTONBN'  => array('mod_id' => 2, 'mod_name' => 'mod_bigbluebuttonbn', 'linkToBittype' => 0, 'disabled' => true ),
        'BOOK'  => array('mod_id' => 3, 'mod_name' => 'mod_book', 'linkToBittype' => 0, 'disabled' => true ),
        'CHAT'  => array('mod_id' => 4, 'mod_name' => 'mod_chat', 'linkToBittype' => 0, 'disabled' => true ),
        'CHOICE'  => array('mod_id' => 5, 'mod_name' => 'mod_choice', 'linkToBittype' => 0, 'disabled' => true ),
        'DATA'  => array('mod_id' => 6, 'mod_name' => 'mod_data', 'linkToBittype' => 0, 'disabled' => true ),
        'FEEDBACK'  => array('mod_id' => 7, 'mod_name' => 'mod_feedback', 'linkToBittype' => 0, 'disabled' => true ),
        'FOLDER'  => array('mod_id' => 8, 'mod_name' => 'mod_folder', 'linkToBittype' => 0, 'disabled' => true ),
        'FORUM'  => array('mod_id' => 9, 'mod_name' => 'mod_forum', 'linkToBittype' => 0, 'disabled' => true ),
        'GLOSSARY'  => array('mod_id' => 10, 'mod_name' => 'mod_glossary', 'linkToBittype' => 0, 'disabled' => true ),
        'H5PACTIVITY'  => array('mod_id' => 11, 'mod_name' => 'mod_h5pactivity', 'linkToBittype' => 0, 'disabled' => true ),
        'IMSCP'  => array('mod_id' => 12, 'mod_name' => 'mod_imscp', 'linkToBittype' => 0, 'disabled' => true ),
        'LABEL'  => array('mod_id' => 13, 'mod_name' => 'mod_label', 'linkToBittype' => 1, 'disabled' => false ),
        'LESSON'  => array('mod_id' => 14, 'mod_name' => 'mod_lesson', 'linkToBittype' => 0, 'disabled' => true ),
        'LTI'  => array('mod_id' => 15, 'mod_name' => 'mod_lti', 'linkToBittype' => 0, 'disabled' => true ),
        'PAGE'  => array('mod_id' => 16, 'mod_name' => 'mod_page', 'linkToBittype' => 0, 'disabled' => false ),
        'QUIZ'  => array('mod_id' => 17, 'mod_name' => 'mod_quiz', 'linkToBittype' => 0, 'disabled' => true ),
        'RESOURCE'  => array('mod_id' => 18, 'mod_name' => 'mod_resource', 'linkToBittype' => 2, 'disabled' => false ),
        'SCORM'  => array('mod_id' => 19, 'mod_name' => 'mod_scorm', 'linkToBittype' => 0, 'disabled' => true ),
        'SURVEY'  => array('mod_id' => 20, 'mod_name' => 'mod_survey', 'linkToBittype' => 0, 'disabled' => true ),
        'URL'  => array('mod_id' => 21, 'mod_name' => 'mod_url', 'linkToBittype' => 9, 'disabled' => false ),
        'WIKI'  => array('mod_id' => 22, 'mod_name' => 'mod_wiki', 'linkToBittype' => 0, 'disabled' => true ),
        'WORKSHOP'  => array('mod_id' => 23, 'mod_name' => 'mod_workshop', 'linkToBittype' => 0, 'disabled' => true ),
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
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
 * @package     block_lai_sandbox
 * @copyright   lern.link GmbH
 * @author      Danou Nauck
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('AJAX_SCRIPT', 1);
global $CFG, $COURSE;

require_once('../../../config.php');

require_login();
$action = required_param('action', PARAM_ALPHAEXT);
$courseid = optional_param('courseid', 0, PARAM_INT);
$api = \local_lai_connector\ai_connector::get_instance();
$token =  $api::get_api_token();

switch ($action) {
    case "generateAPIToken":
        $result = $api->validate_api_token();
        $returndata = array(
            'result' => $result,
            'function' => "generateAPIToken"
        );
        echo json_encode($returndata);
        break;
    case "getToken":
        $status = "Alive";
        $returndata = array(
            'token' => $token,
            'status' => $status,
            'function' => "getToken"
        );
        echo json_encode($returndata);
        break;
    case "addCourseToBrain":
        $result = $api->add_course_to_brain($courseid);
        $returndata = array(
            'token' => $token,
            'result' => $result,
            'courseid' => $courseid,
            'function' => "addCourseToBrain"
        );
        echo json_encode($returndata);
        break;
    case "addElementToBrain":
        $returndata = array(
            'token' => $token,
            'status' => "ON",
            'function' => "addElementToBrain"
        );
        echo json_encode($returndata);
        break;
    case "createNewBrain":
        $brainname = required_param('brainname', PARAM_ALPHAEXT);
        $userid = required_param('userid', PARAM_INT);
        $result = $api->create_new_brain($brainname);
        // We save a copy of the content also in our local db. there we can also store lost of additional data.
        $savedintolocaldb = \local_lai_connector\tarsus_brain::create_new_brain($brainname, $userid);
        $returndata = array(
            'result' => $result,
            'localdb' => $savedintolocaldb,
            'function' => "createNewBrain"
        );
        echo json_encode($returndata);
        break;
    case "deleteBrain":
        $brainname = required_param('brainname', PARAM_ALPHAEXT);
        $result = $api->delete_brain($brainname);
        // We delete the copy of the content also from our local db. just to clean everything up.
        $deletedfromlocaldb = \local_lai_connector\tarsus_brain::delete_brain($brainname);
        $returndata = array(
            'result' => $result,
            'localdb' => $deletedfromlocaldb,
            'function' => "deleteBrain"
        );
        echo json_encode($returndata);
        break;
    case "showAllBrains":
        $result = $api->list_brains();
        $returndata = array(
            'token' => $token,
            'result' => $result,
            'function' => "showAllBrains"
        );
        echo json_encode($returndata);
        break;
    case "showBrainsQuotas":
        $brainname = required_param('newbrainname', PARAM_ALPHAEXT);
        $result = $api->get_brain_usage($brainname);
        $returndata = array(
            'token' => $token,
            'result' => $result,
            'function' => "showBrainsQuotas"
        );
        echo json_encode($returndata);
        break;
    case "listCloneVoices":
        $result = $api->get_clone_voices();
        $returndata = array(
            'token' => $token,
            'result' => $result,
            'function' => "listCloneVoices"
        );
        echo json_encode($returndata);
        break;
    case "getHotKeywords":
        $result = $api->get_hot_keywords();
        $returndata = array(
            'token' => $token,
            'result' => $result,
            'function' => "getHotKeywords"
        );
        echo json_encode($returndata);
        break;
}

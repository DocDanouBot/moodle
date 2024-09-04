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
$brainname = optional_param('brainname', '',PARAM_ALPHAEXT);
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
        $currentuserid = required_param('userid', PARAM_INT);
        $result = $api->add_course_to_brain($courseid,$brainname,$currentuserid);
        $returndata = array(
            'token' => $token,
            'result' => $result,
            'courseid' => $courseid,
            'function' => "addCourseToBrain"
        );
        echo json_encode($returndata);
        break;
    case "addElementToBrain":
        $activityname = strtoupper(required_param('moduletype', PARAM_ALPHAEXT));
        $currentuserid = required_param('userid', PARAM_INT);
        $cmid = required_param('cmid', PARAM_INT);

        $result = \local_lai_connector\tarsus_track_element::create($brainname, $activityname, $cmid, $courseid, $currentuserid);
        $returndata = array(
            'token' => $token,
            'result' => $result,
            'courseid' => $courseid,
            'status' => "ON",
            'function' => "addElementToBrain"
        );

        $url = new moodle_url('/course/view.php', ['id' => $courseid]);
        header('Location: '.$url);
        echo json_encode($returndata);
        break;

    case "removeElementFromBrain":
        $activityname = strtoupper(required_param('moduletype', PARAM_ALPHAEXT));
        $currentuserid = required_param('userid', PARAM_INT);
        $cmid = required_param('cmid', PARAM_INT);
        $brainname = "lernlinkbrain";
        $result = \local_lai_connector\tarsus_track_element::untrack($brainname, $activityname, $cmid, $courseid, $currentuserid);
        $returndata = array(
            'token' => $token,
            'result' => $result,
            'courseid' => $courseid,
            'status' => "DELETED",
            'function' => "removeElementFromBrain"
        );

        // echo ("DONE delete");

        $url = new moodle_url('/course/view.php', ['id' => $courseid]);
        header('Location: '.$url);
        # echo json_encode($returndata);
        break;
    case "createNewBrain":
        $result = $api->create_new_brain($brainname);
        $returndata = array(
            'result' => $result,
            'function' => "createNewBrain"
        );
        echo json_encode($returndata);
        break;
    case "deleteBrain":
        $result = $api->delete_brain($brainname);
        $returndata = array(
            'result' => $result,
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

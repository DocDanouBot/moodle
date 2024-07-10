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
global $CFG;

require_once(dirname(__FILE__).'/../../config.php');

require_login();
$action = required_param('action', PARAM_ALPHAEXT);

switch ($action) {
    case "getToken":
        $api = \local_lai_connector\ai_connector::get_instance();
        $token =  $api->get_api_token();
        $status = "Alive";

        $returndata = array(
            'token' => $token,
            'status' => $status,
        );
        echo json_encode($returndata);
        break;
    case "dropToken":
        $token = "Token DEAD";

        $returndata = array(
            'token' => $token,
            'status' => "OFF"
        );
        echo json_encode($returndata);
        break;
}

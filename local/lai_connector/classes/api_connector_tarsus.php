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

namespace local_lai_connector;
defined('MOODLE_INTERNAL') || die();

global $CFG;

// In this subclass we modually define all the nessessary elements to access the TARSUS API
use pix_icon;
use stdClass;
use moodle_url;
use local_lai_connector\event\brain_deleted;
use local_lai_connector\event\brain_saved;
use local_lai_connector\event\brain_updated;
use local_lai_connector\event\nugged_entry_created;
use local_lai_connector\event\nugged_entry_deleted;
use local_lai_connector\exceptions\lai_exception;
use local_lai_connector\exceptions\tarsus_brain_exception;

class api_connector_tarsus
{
    /**
     * Singleton instance of this class. We cache the instance in this Class.
     * so we can use it again without re-creating it.
     *
     * @var  $_self
     */
    private static $_self;

    /** @var Where is the API connector being found
     *
     */
    private $_api_baseurl;



    /* Get the API token from the API server.
     * This is the token that is used to authenticate the API calls.
     * The token is returned as a string.
     *
     * @return string
     */
    private $_api_key = "";



    //* Component constructor.
    public function __construct() {
        global $CFG;

        // We need to check, if the API is available.
        $this->_api_baseurl = $CFG->local_lai_connector_tarsus_api_url;
        $this->_api_key = $CFG->local_lai_connector_tarsus_api_key;

    }


    /**
     * Factory method to get an instance of the AI connector. We use this method to get the instance.
     * of the AI connector ONLY once! We do not want to redo the job many times, if we need the API.
     * again and again in multiple spots on the same page. Thus we -basically- cache it in the protected $_self variable.
     *
     * @return the TARSUS Connector
     * @throws \lai_exception
     */
    public static function get_instance() {
        global $CFG;

        # We also need to check, that the self->id is NOT the same as before,
        # otherwise in a loop he would always return the first element he cached
        if ((!self::$_self)) {
            self::$_self = new self();
        }

        return self::$_self;
    }



    /**
     * Get a descriptive name for this AI Connection
     *
     * @return string
     */
    public function get_name(): string {
        // The name of the API
        return get_string('api_tarsus_mainname', 'local_lai_connector');
    }

    // The URL to the API of the connector
    public function get_api_url(): moodle_url {
        return new moodle_url('/local/lai_connector/api_tarsus.php');
    }


    // get the current token from the API settings
    public static function get_api_token(): string
    {
        global $CFG;
        // Prepare the customer data array.
        return $CFG->local_lai_connector_tarsus_api_key;
    }

    // hand in the company info to get a valid token for the API
    /*
     * yeah die erste resonse war hier:
     * {"result":
     * "{"api":
     * {"active":false,
     * "api_key":"856f67f4-c0dd-4e63-a1eb-3da60dc59343",
     * "message":"Request api key activation by mailing us with: Danou@web-wizards.it",
     * "organisation_address":"21 vjal Portomaso, Appartment 2121",
     * "organisation_email":"Danou@web-wizards.it",
     * "organisation_name":"Web-Wizards.it"}}"}
     */
    public function validate_api_token(): string {
        global $CFG;

        // Prepare the customer data array.
        $postfieldarray['legal_billing_organisation_name'] = $CFG->local_lai_connector_tarsus_customer_name;
        $postfieldarray['legal_billing_organisation_address'] = $CFG->local_lai_connector_tarsus_customer_address;
        $postfieldarray['legal_billing_organisation_email'] = $CFG->local_lai_connector_tarsus_customer_email;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->_api_baseurl . '/auth/key/generate',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postfieldarray));

        $response = curl_exec($curl);

        curl_close($curl);
        return  $response;
    }


    public function list_brains() {
        global $CFG;
        $curl = curl_init();

        $postfieldarray['api_key'] = $this->_api_key;

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->_api_baseurl . '/brain/awareness/list/memories',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => $postfieldarray,
        ));

        $response = curl_exec($curl);

        # print_r($response);
        # die($response);

        curl_close($curl);
        return $response;
    }

    public function create_new_brain($brain_id = 'customer-demo') {
        global $CFG;
        $curl = curl_init();

        $postfieldarray['api_key'] = $this->_api_key;
        $postfieldarray['brain_id'] = $brain_id;
        $postfieldarray['language'] = 'en';

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->_api_baseurl . '/brain/awareness/create/memory',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postfieldarray,
        ));

        $braincreated = curl_exec($curl);

        curl_close($curl);

        $userid = 1234;
        // We save a copy of the content also in our local db. there we can also store lost of additional data.
        $savedintolocaldb = \local_lai_connector\tarsus_brain::create_new_brain($brain_id, $userid);

        return $braincreated;
    }

    public function delete_brain($brain_id) {
        $curl = curl_init();

        $postfieldarray['api_key'] = $this->_api_key;
        $postfieldarray['brain_id'] = $brain_id;

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->_api_baseurl . '/brain/awareness/delete/memory',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_POSTFIELDS => $postfieldarray,
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $userid = 1234;
        // We delete the copy of the content also from our local db. just to clean everything up.
        $deletedfromlocaldb = \local_lai_connector\tarsus_brain::delete_brain($brain_id, $userid);

        return $response;
    }


    /** Gets a long list of nodes that werde used. It takes some time, therefore we should cache it in our DB
     * It looks like this
     *
     * {"awareness":
     * {"usage":[
     * {"ai_credits":0,"api":"assistance","brain_id":"designerbrain","count":0,"end_timestamp":0,"service":"openQuestionEvaluation","start_timestamp":0},
     * {"ai_credits":0,"api":"assistance","brain_id":"designerbrain","count":0,"end_timestamp":0,"service":"questionAnalytics","start_timestamp":0},
     * {"ai_credits":0,"api":"assistance","brain_id":"designerbrain","count":0,"end_timestamp":0,"service":"oqGeneration","start_timestamp":0},
     * {"ai_credits":0,"api":"assistance","brain_id":"designerbrain","count":0,"end_timestamp":0,"service":"mcqGeneration","start_timestamp":0},
     * {"ai_credits":0,"api":"assistance","brain_id":"designerbrain","count":0,"end_timestamp":0,"service":"tfqGeneration","start_timestamp":0},
     * {"ai_credits":0,"api":"assistance","brain_id":"designerbrain","count":0,"end_timestamp":0,"service":"mcqDistractorGeneration","start_timestamp":0},
     * {"ai_credits":0,"api":"assistance","brain_id":"designerbrain","count":0,"end_timestamp":0,"service":"audioGeneration","start_timestamp":0},
     * {"ai_credits":0,"api":"automation","brain_id":"designerbrain","count":0,"end_timestamp":0,"service":"oqGeneration","start_timestamp":0},
     * {"ai_credits":0,"api":"automation","brain_id":"designerbrain","count":0,"end_timestamp":0,"service":"mcqGeneration","start_timestamp":0},
     * {"ai_credits":0,"api":"automation","brain_id":"designerbrain","count":0,"end_timestamp":0,"service":"tfqGeneration","start_timestamp":0},
     * {"ai_credits":0,"api":"automation","brain_id":"designerbrain","count":0,"end_timestamp":0,"service":"objectiveValidation","start_timestamp":0},
     * {"ai_credits":0,"api":"automation","brain_id":"designerbrain","count":0,"end_timestamp":0,"service":"summaryGeneration","start_timestamp":0},
     * {"ai_credits":0,"api":"automation","brain_id":"designerbrain","count":0,"end_timestamp":0,"service":"bitsGeneration","start_timestamp":0},
     * {"ai_credits":0,"api":"automation","brain_id":"designerbrain","count":0,"end_timestamp":0,"service":"blockGeneration","start_timestamp":0}
     * ]}}
     *
     * @param $brainid
     * @param $start_timestamp
     * @param $end_timestamp
     * @return bool|string
     */
    public function get_brain_usage($brainid = 'customer-demo', $start_timestamp = 0, $end_timestamp = 0) {
        global $CFG;
        $curl = curl_init();

        $postfieldarray['api_key'] = $this->_api_key;
        $postfieldarray['brain_id'] = $brainid;
        $postfieldarray['start_timestamp'] = $start_timestamp;
        $postfieldarray['end_timestamp'] = $end_timestamp;

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->_api_baseurl . '/brain/awareness/get/usage',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS =>  $postfieldarray,
        ));

        $brainusage = curl_exec($curl);

        curl_close($curl);
        return $brainusage;
    }

    public function add_course_to_brain($courseid) {
        global $CFG;
        // adding_course_to_brain($courseid);
        $result = "No Usage for course id " . $courseid ;
        return $result;
    }


    public function get_clone_voices() {
        global $CFG;
    }

    public function get_hot_keywords($start_timestamp = 0, $end_timestamp = 0, $brainid = 'customer-demo') {
        global $CFG;
        $curl = curl_init();

        $postfieldarray['api_key'] = $this->_api_key;
        $postfieldarray['brain_id'] = $brainid;
        $postfieldarray['start_timestamp'] = $start_timestamp;
        $postfieldarray['end_timestamp'] = $end_timestamp;

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->_api_baseurl . '/brain/advisory/get/hot-keywords',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>  $postfieldarray,
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }
}


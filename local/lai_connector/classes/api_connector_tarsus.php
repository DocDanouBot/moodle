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

class api_connector_tarsus
{


    /**
     * Singleton instance of this class. We cache the instance in this Class.
     * so we can use it again without re-creating it.
     *
     * @var  $_self
     */
    private static $_self;

    /* Get the API token from the API server.
     * This is the token that is used to authenticate the API calls.
     * The token is returned as a string.
     *
     * @return string
     */
    public $_api_token = "";

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
    public function validate_api_token(): string {
        global $CFG;

        // Prepare the customer data array.
        $postfieldarray['legal_billing_organisation_name'] = $CFG->local_lai_connector_tarsus_customer_name;
        $postfieldarray['legal_billing_organisation_address'] = $CFG->local_lai_connector_tarsus_customer_address;
        $postfieldarray['legal_billing_organisation_email'] = $CFG->local_lai_connector_tarsus_customer_email;


        $baseurl = $CFG->local_lai_connector_tarsus_api_url;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $baseurl.'/auth/key/generate',
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
        #echo $response;
        #return $response;

        $this->_api_token = $response;
        echo $this->_api_token;
        return $this->_api_token;
    }


    public static function list_brains() {
        global $CFG;
        $curl = curl_init();
        $baseurl = $CFG->local_lai_connector_tarsus_api_url;

        curl_setopt_array($curl, array(
            CURLOPT_URL => $baseurl.'/brain/awareness/list/memories',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => array('api_key' => $CFG->local_lai_connector_tarsus_api_key),
        ));

        $response = curl_exec($curl);

        # print_r($response);
        # die($response);

        curl_close($curl);
        return $response;
    }


    public static function get_brain_usage($brainid) {
        global $CFG;
        $curl = curl_init();
        $baseurl = $CFG->local_lai_connector_tarsus_api_url;

        curl_setopt_array($curl, array(
            CURLOPT_URL => $baseurl.'/brain/awareness/get/usage',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => array('api_key' => $CFG->local_lai_connector_tarsus_api_key,'brain_id' => $brainid,'start_timestamp' => '1706698560','end_timestamp' => '1712527199'),
        ));

        $brainusage = curl_exec($curl);

        curl_close($curl);
        return $brainusage;
    }

    public function add_course_to_brain($courseid) {
        // adding_course_to_brain($courseid);
        $result = "No Usage for course id " . $courseid ;
        return $result;
    }

}

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

    /* Get the API token from the API server.
     * This is the token that is used to authenticate the API calls.
     * The token is returned as a string.
     *
     * @return string
     */
    public $_api_token = "";

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

    // get the current token from the API
    public function get_api_token(): string {
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

        $this->_api_token = "TARSUS_API_TOKEN";
        echo $this->_api_token;
        return $this->_api_token;
    }

}

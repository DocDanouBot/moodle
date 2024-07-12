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

use pix_icon;
use stdClass;
use moodle_url;

class ai_connector {
    /*
    *  The whole foreign API referenced into this class to be uses as object
    */
    private $_api;

    /*
     *  The var that saves the name of the currently used API.
     */
    private static $_api_provider = NULL;

    /*
    *  The var that saves the ID of the currently used API.
    */
    private static $_api_provider_id;

    /*
     *  The var that saves the name of the currently used API.
     */
    private static $_api_key = '';

    /*
     *  The var that saves the name of the currently used API.
     */
    private static $_api_url = '';

    /*
    *  The var that saves the icon we might use with the API.
    */
    private static $_api_icon = '';

    /*
    *  The var that saves the additional colorcoding for this API
    */
    private static $_api_color = '';

    /**
     * Singleton instance of this class. We cache the instance in this Class.
     * so we can use it again without re-creating it.
     *
     * @var AI_Connector $_self
     */
    private static $_self;

    //* Component constructor.
    public function __construct() {
        global $CFG;

        // Which API are we currently using? Check from main component
        // We need to get the stuph from the config settings
        if(isset($CFG->local_lai_connector_current_api) && $CFG->local_lai_connector_current_api != '') {
            // Just define something that we can see, if we did NOT find the according API.
            self::$_api_provider = "NONE";
            self::$_api_key   = "EMPTY";
            self::$_api_url   = "UNKNOWN";
            self::$_api_icon  = "fa-question-circle";
            self::$_api_color = "#999999";
            // Get the API ID from the config settings.
            $apiID = $CFG->local_lai_connector_current_api;
            // Get all the available APIs from the const definitions file
            $allAIAPIs = \local_lai_connector\definitions::LOCAL_LAI_CONNECTOR_AVAILABLE_APIS;
            // Lets check all possible options.
            foreach ($allAIAPIs as $thisAIAPI) {
                // oh well, we found the API we are looking for!
                if ($thisAIAPI['id'] == $apiID) {
                    // Is the API also activated?
                    if ($thisAIAPI['disabled'] !== true) {
                        // lowersize the string to fit it for automation later on.
                        $apiproviderstring = strtolower($thisAIAPI['name']);
                        self::$_api_provider = $thisAIAPI['name'];
                        // save the ID so we can use instances from now an.
                        self::$_api_provider_id = $thisAIAPI['id'];
                        // We need to assemble the whole string before concatting it to $CFG.
                        $apikeystring = "local_lai_connector_". $apiproviderstring . "_api_key";
                        // assign the value to the private Class var
                        self::$_api_key = $CFG->$apikeystring;
                        // One more assembly before concatting the string to $CFG.
                        $apiurlstring = "local_lai_connector_". $apiproviderstring . "_api_url";
                        // assign the value to the private Class var
                        self::$_api_url = $CFG->$apiurlstring;
                        // Now we fill in the other values directly from the constant array:
                        self::$_api_icon  = $thisAIAPI['icon'];
                        self::$_api_color = $thisAIAPI['color'];

                        $this->_api = \local_lai_connector\api_connector_tarsus::get_instance();

                        break;
                    } else {
                        // This API is sadly disabled in the constant setting. check definitions.php
                        self::$_api_provider = "DISABLED";
                        self::$_api_key   = "NONE";
                        self::$_api_url   = "NONE";
                        self::$_api_icon  = "fa-exclamation-circle";
                        self::$_api_color = "#FF0000";
                    }
                }
            }
        }
    }

    /**
     * Factory method to get an instance of the AI connector. We use this method to get the instance.
     * of the AI connector ONLY once! We do not want to redo the job many times, if we need the API.
     * again and again in multiple spots on the same page. Thus we -basically- cache it in the protected $_self variable.
     *
     * @param $new_api_provider_id
     * @return thw whole LAI Connector
     * @throws \lai_exception
     */
    public static function get_instance($new_api_provider_id = null) {
        global $CFG;

        if (is_null($new_api_provider_id)) {
            // Nothing set? Lets see if there is an existing config value.
            if(isset($CFG->local_lai_connector_current_api) && $CFG->local_lai_connector_current_api > 0) {
                // Do we find a setting already in config? Than use it!
                $local_api_provider_id = $CFG->local_lai_connector_current_api;
            } else {
                // There was no other config value? So Fall back to TARSUS.
                $local_api_provider_id = 1; # Fallback to TARSUS
            }
        } else {
            $local_api_provider_id = $new_api_provider_id;
        }

        # We also need to check, that the self->id is NOT the same as before,
        # otherwise in a loop he would always return the first element he cached
        if ((!self::$_self) || (self::$_api_provider_id != $local_api_provider_id)) {
            self::$_self = new self($local_api_provider_id);
        }

        return self::$_self;
    }


    /**
     * Get the name of the currently used API.
     *
     * @return string The name of the currently used API.
     */
    public static function get_api_provider():string {
        return self::$_api_provider;
    }

    /**
     * Get the Key of the currently used API.
     *
     * @return string The key of the currently used API.
     */
    public static function get_api_key():string {
        return self::$_api_key;
    }

    /**
     * Get the URI of the currently used API.
     *
     * @return string The URL of the currently used API.
     */
    public static function get_api_url():string {
        return self::$_api_url;
    }

    /**
     * Get the styling color of the currently used API.
     *
     * @return string The Color of the currently used API.
     */
    public static function get_api_color():string {
        return self::$_api_color;
    }

    /**
     * Get the addditional icon the currently used API.
     *
     * @return icon The icon of the currently used API.
     */
    public static function get_api_icon():string {
        # return new pix_icon(self::$_api_icon, self::get_api_provider());
        return "someicon from get_api_icon()";
    }

    /**
     * Set the name of the currently used API.
     *
     * @param string $api_provider The name of the API.
     */
    public static function set_api_provider($api_provider) {
        self::$_api_provider = $api_provider;
    }

    public static function get_api_token():string {
        $api_token = \local_lai_connector\api_connector_tarsus::get_api_token();
        #$dynamicfunction = '\local_lai_connector\api_connector_'.strtolower(self::$_api_provider).'::get_api_token()';
       # if (function_exists($dynamicfunction)) {
        #    $api_token = $dynamicfunction();
        #} else {
        #    $api_token = "The function $dynamicfunction does not exist.";
        #}

        #$api_token = call_user_func($dynamicfunction);
        return $api_token;
    }


    public function validate_api_token():string {
        $api_token = \local_lai_connector\api_connector_tarsus::validate_api_token();
        return $api_token;
    }

    public function list_brains() {
        $allbrains = \local_lai_connector\api_connector_tarsus::list_brains();
        return $allbrains;
    }

    public function get_brain_usage($brainid) {
        $brainusage = \local_lai_connector\api_connector_tarsus::get_brain_usage($brainid);
        return $brainusage;
    }

    public function add_course_to_brain($courseid) {
        $addresult = $this->_api->add_course_to_brain($courseid);
        return $addresult;
    }
}

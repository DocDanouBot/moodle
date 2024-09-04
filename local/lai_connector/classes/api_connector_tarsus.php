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
use local_lai_connector\tarsus_brain;
use local_lai_connector\tarsus_track_element;
use local_lai_connector\event\brain_deleted;
use local_lai_connector\event\brain_saved;
use local_lai_connector\event\brain_updated;
use local_lai_connector\event\nugged_entry_created;
use local_lai_connector\event\nugged_entry_deleted;
use local_lai_connector\exceptions\lai_exception;
use local_lai_connector\exceptions\tarsus_brain_exception;
use local_lai_connector\exceptions\tarsus_track_element_exception;
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


    /** We save the name of the first (and currently only) brain, that we have.
     * @var string
     */
    private $_api_brainid = "";

    //* Component constructor.
    public function __construct() {
        global $CFG;

        // We need to check, if the API is available.
        $this->_api_baseurl = $CFG->local_lai_connector_tarsus_api_url;
        $this->_api_key = $CFG->local_lai_connector_tarsus_api_key;
        $allbrainsresponsejson = $this->list_brains(); // show and get all the brains available.
        $parsedbrains = json_decode($allbrainsresponsejson, true); // parse the response json into an array.


        $allbrains = $parsedbrains['awareness']['brain_ids'];
        $firstbrain = reset($allbrains); // get the first brain.
        $newestbrain = end($allbrains); // get the first brain.
        #echo("<hr><br>allbrains: ");
        #var_dump($allbrains);
        #die ("gameover");

        # var_dump($firstbrain['id']); // this is the brainid of the first brain. // Yes, this works as expected
        $this->_api_brainid = $newestbrain['id']; // get the first brain id.
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

    /**
     * Get the identifier for the currently used brain
     *
     * @return string
     */
    public function get_brainid(): string {
        // The current in use BrainID of the API
        return $this->_api_brainid;
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

        // Execute the API call.
        $response = curl_exec($curl);

        curl_close($curl);
        return  $response;
    }


    /** List all the Brains that are connected to this customer
     *  Basically it will return a longer list, but it should be reduced to one, as we are only supposed to use
     *  only one brain per customer.
     *
     * @return bool|string
     */
    public function list_brains() {
        global $CFG;
        $curl = curl_init();

        // Set all the nessessary vars for the query into this Array.
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

        // Execute the API call.
        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public function create_new_brain($brainid = 'customer-demo') {
        global $CFG;
        $curl = curl_init();

        // Set all the nessessary vars for the query into this Array.
        $postfieldarray['api_key'] = $this->_api_key;
        $postfieldarray['brain_id'] = $brainid;
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

        // Execute the API call.
        $braincreated = curl_exec($curl);

        curl_close($curl);


        // We save a copy of the content also in our local db. there we can also store lost of additional data.
        $savedintolocaldb = \local_lai_connector\tarsus_brain::create_new_brain($brainid);

        return $braincreated;
    }

    public function delete_brain($brainid) {
        $curl = curl_init();

        // Set all the nessessary vars for the query into this Array.
        $postfieldarray['api_key'] = $this->_api_key;
        $postfieldarray['brain_id'] = $brainid;

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

        // Execute the API call.
        $response = curl_exec($curl);

        curl_close($curl);

        // We delete the copy of the content also from our local db. just to clean everything up.

        $deletedfromlocaldb = \local_lai_connector\tarsus_brain::delete_brain($brainid);

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
    public function get_brain_usage($brainid = '', $start_timestamp = 0, $end_timestamp = 0) {
        global $CFG;
        $curl = curl_init();

        $brainusage = array();

        if ($brainid == "") {
            // If the brain is not set, we get the first avalable one
            $brainid = $this->_api_brainid;
        }

        if ($end_timestamp == 0) {
            // In case that we did not enter any timestamps, we will automatically look at the last half year.
            $end_timestamp = time();
            $start_timestamp = $end_timestamp - (\local_lai_connector\definitions::LL_TIME_CONSTANTS['SECONDS_PER_YEAR'] / 2);
        }

        if ($start_timestamp == 0) {
            // In case that we did not enter any timestamps, we will automatically look the beginning time of this brain, not before
            $selectedbrain =  \local_lai_connector\tarsus_brain::get_instance($brainid);
            $start_timestamp = $selectedbrain->timecreated;
        }

        // Set all the nessessary vars for the query into this Array.
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

        // Execute the API call.
        $brain_json = curl_exec($curl);

        // Now quickly format the json into an associative array.
        /* Beispielformat
        {
            "awareness": {
            "usage": [
            {
                "ai_credits": 0,
                "api": "assistance",
                "brain_id": "lernlinkbrain",
                "count": 0,
                "end_timestamp": 1922314520,
                "service": "openQuestionEvaluation",
                "start_timestamp": 1000000
            }
        }
        */

        $brain_decoded = json_decode($brain_json);
        $brainelements = $brain_decoded->awareness->usage;

        foreach ($brainelements as $brainelement) {

            // Lets mapp the data and add some extra on the service
            $datanode = new \stdClass();
            $datanode->brain_credits = $brainelement->ai_credits;
            $datanode->brain_type = $brainelement->api;
            $datanode->brain_service = $brainelement->service;
            $datanode->brain_count = $brainelement->count;
            $datanode->brain_starttime = date("d.m.Y H:s", $brainelement->start_timestamp);
            $datanode->brain_endtime = date("d.m.Y H:s", $brainelement->end_timestamp);
            $brainusage[] = $datanode;
        }

        curl_close($curl);
        return $brainusage;
    }

    public function get_clone_voices() {
        global $CFG;
    }

    public function get_hot_keywords($start_timestamp = 0, $end_timestamp = 0, $brainid = '') {
        global $CFG;
        $curl = curl_init();

        if ($brainid == "") {
            // If the brain is not set, we get the first avalable one
            $brainid = $this->_api_brainid;
        }

        if ($end_timestamp == 0) {
            // In case that we did not enter any timestamps, we will automatically look at the last half year.
            $end_timestamp = time();
            $start_timestamp = $end_timestamp - (\local_lai_connector\definitions::LL_TIME_CONSTANTS['SECONDS_PER_YEAR'] / 2);
        }

        // Set all the nessessary vars for the query into this Array.
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

        // Execute the API call.
        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    /** Add a course to the brain. This is the main function to analyse the whole course.
     * and add all the elements individually to the given brain. But first we analyse all sections and have to
     * map all subsections and activities to different track_bits functions. these Track functions will eventually
     * add the final elements to the brain.
     *
     * @param $brainid
     * @param $courseid
     * @return string
     * @throws \dml_exception
     * @throws lai_exception
     */
    public function add_course_to_brain($courseid = 0, $brainid = "", $currentuserid = 0) {
        global $DB, $USER;
        $result = "";

        if($currentuserid == 0) {
            // Use the standard User if nobody else is set
            $currentuserid = $USER->id;
        }

        // first we should get the course
        if (!$course = $DB->get_record('course', array('id' => $courseid))) {
            throw new lai_exception('exception_lai_missing', $courseid);
        }

        if ($brainid == "") {
            // If the brain is not set, we get the first avalable one
            $brainid = $this->_api_brainid;
        }

        // We need the sections first and all their titles and descriptions. So we can feed it all to the brain
        $sections = $DB->get_records('course_sections', ['course' => $course->id], 'section ASC', 'id,section,summary,sequence,visible');


        // Now we should get all the different modules element
        $allcms = $DB->get_records('course_modules', array('course' => $course->id, 'deletioninprogress' => 0),'','id,module,instance,section');
        $allmodules = $DB->get_records('modules', array(), '','id,name');


        // we could use these transformers to see in the console, what the arrays are like
        #$result = json_encode($allcms);
        #$result .= json_encode($allmodules);

        // Save them in a long list
        // and map them individually to different kind of Brain elements.
        $mappingresult = \local_lai_connector\util::map_cm_to_tarsus_brain($allcms,$allmodules);

        // Now we have got all the elements of this course and need to insert them into the brain

        foreach ($sections as $section) {
            // We add all the section titles and descriptions to the brain.
            // Section Titles and Descriptions are just Text-Bits with the following format
            /*
            $this->track_text_bits($brainid, $title, $text, $resource_id,
                $asset_id = '', $asset_type = '', $user_id = '',
                $user_role = '', $group_ids = '', $poison_index = false);
            */

            // The Sections themselves do NOT have a CMID thus we use 0 for it initally.
            // Preset is NULL, so with a 0 we can see that it is a section and not an activity,
            $cmid = -1;

            // So first we need this unique $resource_id identifier. So first we create an logging entry in our own DB table
            // WORKS //
            $trackedelement = \local_lai_connector\tarsus_track_element::create($brainid, 'TEXT', $cmid, $courseid, $currentuserid);

            // As we can have html elements with audio / video or images, we need to map them to the right track_bits.
            if (isset($section->summary) && (strlen($section->summary) > 0)) {
                $parsedhtmlcode = $this->parse_html_code($section->summary, $brainid, $courseid, $currentuserid, $cmid);
                # $result .= "htmlcode_from_section: " . $parsedhtmlcode;
            }
            // As we have the resource ID now, we add the Section Title and Description to the brain
            // WORKS // $this->track_text_bits($brainid,$section->name,$parsedhtmlcode, $trackedelement->resourceid, $trackedelement->assetid, null, $trackedelement->userid);

            //Next we go through the sequence of all added activities to this course, according to their ordering.
            $activityordering = explode(',',$section->sequence);
            foreach ($activityordering as $cmid) {
                $currentmodule = $mappingresult[$cmid];
                # $result .=  "activityordering: " . implode('|', $activityordering);
                $result .=  "      This CmID: ". $cmid ." and moduleid "  . $currentmodule['moduleid'];
                # ". implode('*', $mappingresult);
                #$currentcm = $currentelement['cmid'];
                #$currentmoduleinstance = $currentelement['instanceid'];
                # \local_lai_connector\util::map_moduletype_to_bittype($currentmodule['moduleid']);
                $currentbittype =  \local_lai_connector\util::map_moduletype_to_bittype($currentmodule['moduleid']);
                $result .=  " currentbittype: ". $currentbittype . "   ";
                switch ($currentbittype) {
                    case 'TEXT LABEL':
                        $result .= $this->track_module_label($cmid, $brainid, $courseid, $currentuserid);
                        break;
                    case 'TEXT PAGE':
                        $result .= $this->track_module_page($cmid, $brainid, $courseid, $currentuserid);
                        break;
                    case 'QUESTION':
                        $result .= $this->track_question($cmid, $brainid, $courseid, $currentuserid);
                        break;
                }

            }
        }




        // adding_course_to_brain($courseid);
        # $result = "No Usage for course id " . $courseid ;
        return $result ; #. "mappingresult" . implode('|', $mappingresult);
    }


    /** Add a single element to the brain
     *
     * @param $brainid
     * @param $courseid
     * @return string
     * @throws \dml_exception
     * @throws lai_exception
     */
    public function add_element_to_brain($courseid = 0, $brainid = "", $currentuserid = 0) {

        // NOT WORKING


        /*
        global $DB, $USER;
        $result = "";

        if($currentuserid == 0) {
            // Use the standard User if nobody else is set
            $currentuserid = $USER->id;
        }

        // first we should get the course
        if (!$course = $DB->get_record('course', array('id' => $courseid))) {
            throw new lai_exception('exception_lai_missing', $courseid);
        }

        if ($brainid == "") {
            // If the brain is not set, we get the first avalable one
            $brainid = $this->_api_brainid;
        }


        $currentmodule = $mappingresult[$cmid];
        # $result .=  "activityordering: " . implode('|', $activityordering);
        $result .= "      This CmID: " . $cmid . " and moduleid " . $currentmodule['moduleid'];
        # ". implode('*', $mappingresult);
        # $currentcm = $currentelement['cmid'];
        # $currentmoduleinstance = $currentelement['instanceid'];
        # \local_lai_connector\util::map_moduletype_to_bittype($currentmodule['moduleid']);
        $currentbittype = \local_lai_connector\util::map_moduletype_to_bittype($currentmodule['moduleid']);
        $result .= " currentbittype: " . $currentbittype . "   ";
        switch ($currentbittype) {
            case 'TEXT LABEL':
                $result .= $this->track_module_label($cmid, $brainid, $courseid, $currentuserid);
                break;
            case 'TEXT PAGE':
                $result .= $this->track_module_page($cmid, $brainid, $courseid, $currentuserid);
                break;
            case 'QUESTION':
                $result .= $this->track_question($cmid, $brainid, $courseid, $currentuserid);
                break;

        }

        // adding_course_to_brain($courseid);
        # $result = "No Usage for course id " . $courseid ;
        return $result ; #. "mappingresult" . implode('|', $mappingresult);
        */
    }


    public function parse_html_code($htmlcode, $brainid, $courseid, $currentuserid, $cmid = 0) {

        // some inits
        $consoleoutput = "";

            /* Beispielcode

            <img class="img-fluid" style="float: left;" src="@@PLUGINFILE@@/ramen_answer.png" alt="Ramen" width="386" height="369">
            Hier<span style="font-size: 1rem; text-align: initial;"> ist ein einleitungstext für die</span>
            <span style="font-size: 1rem; text-align: initial;">erste Section des Kurses 2. Ganz wichtig.</span></p>
            <video controls="controls">
                <source src="@@PLUGINFILE@@/7994298057416214-video.webm">@@PLUGINFILE@@/7994298057416214-video.webm}}
            </video>
            <audio controls="controls">
                <source src="@@PLUGINFILE@@/8103195400286511-audio.mp4">@@PLUGINFILE@@/8103195400286511-audio.mp4}}
            </audio>

             */

        // creates new instance of DOMDocument class
        $dom = new \domDocument;

        // load the html from you variable (@ because figure will throw a warning)
        @$dom->loadHTML($htmlcode);

        // Copy it to work with it and reduce differnt types of html tags
        $result = $htmlcode;

        // -------------------------------- L I N K S  --------------------------------------------
        // stores all elements of a href
        $ahrefs = $dom->getElementsByTagName('a');
        if ($ahrefs->length > 0) {
            // we found links
            // WORKS // $consoleoutput .= " We found links " . $ahrefs->length . " ";
            for ($i = 0; ++$i <= $ahrefs->length; ) {

                $ahref = $ahrefs->item($i-1);
                $url = $ahref->getAttribute('href'); // The URL Ancor
                $linktext = $ahref->nodeValue;

                // WORKS // $consoleoutput .= " Link: " .$url . " Text: " .$linktext;

                // So first we need this unique $resource_id identifier. So first we create an logging entry in our own DB table
                $trackedelement = \local_lai_connector\tarsus_track_element::create($brainid, 'URL',  $cmid, $courseid, $currentuserid, null,  $url);

                // As we have the resource ID now, we add the Section Title and Description to the brain
                // $this->track_url_bits($brainid, $url, $trackedelement->resourceid, $url, null, $trackedelement->userid);

                // Now we take each and every a href an put it into the replacer to strip only the a href but leave the inner html for later use
                $result = \local_lai_connector\util::replace_first_tags_with_content($result, "<a>", $linktext);
            }

        }


        // --------------------------------- I M A G E --------------------------------------------
        // refresh the code after we cleaned it from a hrefs
        @$dom->loadHTML($result);
        // stores all elements of image
        $images = $dom->getElementsByTagName('img');
        if ($images->length > 0) {
            // we found images

            $consoleoutput .= " We found images " . $images->length . " ";

            for ($i = $images->length; --$i >= 0; ) {
                $image = $images->item($i);
                $imgsrc = $image->getAttribute('src'); // The URL Ancor

                $consoleoutput .= " ImgSrc: " .$imgsrc . " Text: " .$images->item($i)->nodeValue;

                // So first we need this unique $resource_id identifier. So first we create an logging entry in our own DB table
                $trackedelement = \local_lai_connector\tarsus_track_element::create($brainid, 'IMAGE', $cmid, $courseid, $currentuserid);

                // As we have the resource ID now, we add the Section Title and Description to the brain
                $this->track_image_bits($brainid, $url, $trackedelement->resourceid, $imgsrc, null, $trackedelement->userid);

            }

            $result = \local_lai_connector\util::strip_tags_content($result, "<img>", true);
        }

        // --------------------------------- A U D I O --------------------------------------------
        // refresh the code after we cleaned it from a hrefs
        @$dom->loadHTML($result);
        // stores all elements of video
        $audios = $dom->getElementsByTagName('audio');
        if ($audios->length > 0) {
            // we found audio

            $consoleoutput .= " We found audios " . $audios->length . " ";

            for ($i = $audios->length; --$i >= 0;) {
                $audio = $audios->item($i);
                $audiosource = $audio->nodeValue;
                #getElementsByTagName('source');
                $audiosrc = $audios->item($i)->getAttribute('src'); // The URL Ancor
                $consoleoutput .= " Audiourl: " . $audiosrc . " Alttext: " . $audios->item($i)->nodeValue;
                // So first we need this unique $resource_id identifier. So first we create an logging entry in our own DB table
                $trackedelement = \local_lai_connector\tarsus_track_element::create($brainid, 'AUDIO', $cmid, $courseid, $currentuserid);

                // As we have the resource ID now, we add the Section Title and Description to the brain
                // $this->track_audio_bits($brainid, $audiosource, $trackedelement->resourceid, $audiosrc, null, $trackedelement->userid);

            }

        }

        // --------------------------------- V I D E O --------------------------------------------
        // refresh the code after we cleaned it from a hrefs
        @$dom->loadHTML($result);
        // stores all elements of video
        $videos = $dom->getElementsByTagName('video');
        if ($videos->length > 0) {
            // we found videos

            $consoleoutput .= " We found videos " . $videos->length . " ";

            for ($i = $videos->length; --$i >= 0;) {
                $video = $videos->item($i);
                $videosource = $video->nodeValue;
                #getElementsByTagName('source');
                $videosrc = $videos->item($i)->getAttribute('src'); // The URL Ancor
                $consoleoutput .= " Videourl: " . $videosrc . " Alttext: " . $videos->item($i)->nodeValue;
                // So first we need this unique $resource_id identifier. So first we create an logging entry in our own DB table
                $trackedelement = \local_lai_connector\tarsus_track_element::create($brainid, 'VIDEO', $cmid, $courseid, $currentuserid );

                // As we have the resource ID now, we add the Section Title and Description to the brain

                // $this->track_video_bits($brainid, $videosource, $trackedelement->resourceid, $videosrc, null, $trackedelement->userid);

            }
            $result = \local_lai_connector\util::strip_tags_content($result, "<video>", true);
        }

        // For DEV Purposes into console
        // return $consoleoutput;

        // Real return value of clean html code
        // ready to enter it as plain text into the brain
        return $result;
    }

    /** This function is expecally made to track the module LABEL
     * @param $cmid
     * @param $brainid
     * @param $courseid
     * @return string
     * @throws \dml_exception
     * @throws \moodle_exception
     */
    public function track_module_label($cmid, $brainid, $courseid,$currentuserid) {
        // some inits
        $consoleoutput = "";

        $modinfo = get_fast_modinfo($courseid);
        $cminfo = $modinfo->get_cm($cmid);
        $modtitle = $cminfo->name;
        $modbody = $cminfo->content;

        // So we parse and clean the html code. just in case there are much more Pictures, Videos, Sounds or anything inside the html code.
        $parsedhtmlcode = "";
        if ($modbody != "") {
            $parsedhtmlcode = $this->parse_html_code($modbody, $brainid, $courseid, $currentuserid, $cmid);
        }

        // For Dev purposes only
        // $consoleoutput .= "htmlcode_from_TEXT LABEL: " . $modtitle . " Body: " . $modbody. " PARSED HTML: ". $parsedhtmlcode;

        // An now we have a clean title and a clean body and we can add this element and plain text
        // So first we need this unique $resource_id identifier. So first we create an logging entry in our own DB table
        // WORKS //
        $trackedelement = \local_lai_connector\tarsus_track_element::create($brainid, 'TEXT', $cmid, $courseid, $currentuserid);

        // As we have the resource ID now, we add the Section Title and Description to the brain
        // WORKS //
        $this->track_text_bits($brainid,$modtitle,$parsedhtmlcode, $trackedelement->resourceid, $trackedelement->assetid, null, $trackedelement->userid);


        // returns
        return $consoleoutput;
    }

    /** This function is expecally made to track the module PAGE
     * @param $cmid
     * @param $brainid
     * @param $courseid
     * @return string
     * @throws \dml_exception
     * @throws \moodle_exception
     */
    public function track_module_page($cmid, $brainid, $courseid, $currentuserid) {
        // some inits
        $consoleoutput = "";

        $modinfo = get_fast_modinfo($courseid);
        $cminfo = $modinfo->get_cm($cmid);
        $modtitle = $cminfo->name;
        $modbody = $cminfo->content;

        // So we parse and clean the html code. just in case there are much more Pictures, Videos, Sounds or anything inside the html code.
        $parsedhtmlcode = "";
        if ($modbody != "") {
            $parsedhtmlcode = $this->parse_html_code($modbody, $brainid, $courseid, $currentuserid, $cmid);
        }

        $consoleoutput .= "htmlcode_from_TEXT PAGE: " . $modtitle . " Body: " . $modbody. " PARSED HTML: ". $parsedhtmlcode;

        // An now we have a clean title and a clean body and we can add this element and plain text
        // So first we need this unique $resource_id identifier. So first we create an logging entry in our own DB table
        // WORKS //
        $trackedelement = \local_lai_connector\tarsus_track_element::create($brainid, 'TEXT', $cmid, $courseid, $currentuserid);

        // As we have the resource ID now, we add the Section Title and Description to the brain
        // WORKS //
        $this->track_text_bits($brainid,$modtitle,$parsedhtmlcode, $trackedelement->resourceid, $trackedelement->assetid, null, $trackedelement->userid);

        // returns
        return $consoleoutput;
    }


    /** This function is expecally made to track the module FORUM
     * @param $cmid
     * @param $brainid
     * @param $courseid
     * @return string
     * @throws \dml_exception
     * @throws \moodle_exception
     */
    public function track_question($cmid, $brainid, $courseid, $currentuserid) {
        // some inits
        $consoleoutput = "";

        $modinfo = get_fast_modinfo($courseid);
        $cminfo = $modinfo->get_cm($cmid);
        $modtitle = $cminfo->name;
        $modbody = $cminfo->content;

        // So we parse and clean the html code. just in case there are much more Pictures, Videos, Sounds or anything inside the html code.
        $parsedhtmlcode = "";
        if ($modbody != "") {
            $parsedhtmlcode = $this->parse_html_code($modbody, $brainid, $courseid, $currentuserid, $cmid);
        }



        //*************************************** Ideen
        /*
        quiz_has_feedback($quiz)



        // Es gibt da eine sehr hilfreiche CALCULATE FUnktion hier:
        $qubaids = quiz_statistics_qubaids_condition($quiz->id, $groupstudentsjoins, $whichattempts);
        $qcalc = new \core_question\statistics\questions\calculator($questions, $progress);

        // Oder auch hier:
        $report = new \quiz_statistics_report();
        $questions = $report->load_and_initialise_questions_for_calculations($quiz);


        */
        //*****************************************

        $consoleoutput .= "htmlcode_from_QUESTION: " . $modtitle . " Body: " . $modbody. " PARSED HTML: ". $parsedhtmlcode;

        // An now we have a clean title and a clean body and we can add this element and plain text
        // So first we need this unique $resource_id identifier. So first we create an logging entry in our own DB table
        // WORKS //
        $trackedelement = \local_lai_connector\tarsus_track_element::create($brainid, 'TEXT', $cmid, $courseid, $currentuserid);

        // As we have the resource ID now, we add the Section Title and Description to the brain
        // WORKS // $this->track_text_bits($brainid,$modtitle,$parsedhtmlcode, $trackedelement->resourceid, $trackedelement->assetid, null, $trackedelement->userid);

        // returns
        return $consoleoutput;
    }


    /** This function is expecally made to track the module FORUM
     * @param $cmid
     * @param $brainid
     * @param $courseid
     * @return string
     * @throws \dml_exception
     * @throws \moodle_exception
     */
    public function track_forum($cmid, $brainid, $courseid) {
        // some inits
        $consoleoutput = "";



        // How to get the forum elements
        $post = $this->get_post($id);
        $forum = $this->get_forum($post->forum);
        $discussion = $this->get_discussion($post->discussion);
        $cminfo = $this->get_cm('forum', $forum->id, $forum->course);
        $cm = $cminfo->get_course_module_record();



        $modinfo = get_fast_modinfo($courseid);
        $cminfo = $modinfo->get_cm($cmid);
        $modtitle = $cminfo->name;
        $modbody = $cminfo->content;


        // So we parse and clean the html code. just in case there are much more Pictures, Videos, Sounds or anything inside the html code.
        $parsedhtmlcode = "";
        if ($modbody != "") {
        #    $parsedhtmlcode = $this->parse_html_code($modbody, $brainid, $courseid, $currentuserid, $cmid);
        }

        # $consoleoutput .= "htmlcode_from_TEXT PAGE: " . $modtitle . " Body: " . $modbody. " PARSED HTML: ". $parsedhtmlcode;

        // An now we have a clean title and a clean body and we can add this element and plain text
        // So first we need this unique $resource_id identifier. So first we create an logging entry in our own DB table
        // WORKS // $trackedelement = \local_lai_connector\tarsus_track_element::create($brainid, 'QUESTION', $cmid, $courseid, $currentuserid);

        // As we have the resource ID now, we add the Section Title and Description to the brain
        // WORKS // $this->track_text_bits($brainid,$modtitle,$parsedhtmlcode, $trackedelement->resourceid, $trackedelement->assetid, null, $trackedelement->userid);

        // returns
        return $consoleoutput;
    }


    // --------------------------------- T R A C K     E L E M E N T S --------------------------------------------
    /** Track some basic plain texts and their titles into the brain
     * @param $brainid
     * @param $title
     * @param $text
     * @param $resource_id
     * @param $asset_id
     * @param $asset_type
     * @param
     * */
    public function track_text_bits($brainid, $title, $text, $resource_id,
                                    $asset_id = '', $asset_type = '', $user_id = '',
                                    $user_role = '', $group_ids = '', $poison_index = false) {
        global $DB;
        $curl = curl_init();

        /** structure definition */
        /*
        array('api_key' => '7517fd28-8cb4-4304-b9f0-0312b8c92ef1',
            'brain_id' => 'customer-demo',
            'text' => 'Artificial Intelligence is somthing a lot of people cannot understand if they are on another planet.',
            'title' => 'My Text Title',
            'resource_id' => 'text-id-123',
            'ignore_language' => 'false',
            'asset_id' => 'myAssetID',
            'asset_type' => 'MyAssetType',
            'shop_url' => 'https://your-shop.url'),
        */

        // Set all the nessessary vars for the query into this Array.
        $postfieldarray['api_key'] = $this->_api_key;
        $postfieldarray['brain_id'] = $brainid;
        $postfieldarray['title'] = $title;
        $postfieldarray['text'] = $text;
        $postfieldarray['resource_id'] = $resource_id; // marketing-definition-text - This text must be assigned a unique identifier.
        $postfieldarray['ignore_language'] = false; // Should stay false to let the brain determine the language
        $postfieldarray['asset_id'] = $asset_id; // optional marketing-course;
        $postfieldarray['asset_type'] = $asset_type; // optional MyAssetType;
        $postfieldarray['user_id'] = $user_id; // optional max-musterman-id;
        $postfieldarray['user_role'] = $user_role; // optional Marketing BSc. Student;
        $postfieldarray['group_ids'] = $group_ids; // optional ['group-a', 'group-b']
        $postfieldarray['poison_index'] = $poison_index; // optional,

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->_api_baseurl . '/brain/access/track/text-bits',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postfieldarray,
        ));

        // Execute the API call.
        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }


    /** Track some basic a url into the TARSUS brain
     * @param $brainid
     * @param $url
     * @param $resource_id
     * @param $asset_id
     * @param $asset_type
     */
    public function track_url_bits($brainid, $url, $resource_id,
                                    $asset_id = '', $asset_type = '', $user_id = '',
                                    $user_role = '', $group_ids = '', $poison_index = false) {
        global $DB;
        $curl = curl_init();

        /** structure definition */
        /*
        array('api_key' => '7517fd28-8cb4-4304-b9f0-0312b8c92ef1',
            'brain_id' => 'customer-demo',
            'url' => 'https://en.wikipedia.org/wiki/Artificial_intelligence',
            'resource_id' => 'https://en.wikipedia.org/wiki/Artificial_intelligence',
            'ignore_language' => 'false',
            'asset_id' => 'myAssetID',
            'asset_type' => 'MyAssetType',
            'shop_url' => 'https://your-shop.url'),
        */

        // Set all the nessessary vars for the query into this Array.
        $postfieldarray['api_key'] = $this->_api_key;
        $postfieldarray['brain_id'] = $brainid;
        $postfieldarray['url'] = $url;
        $postfieldarray['resource_id'] = $resource_id; // marketing-definition-text - This text must be assigned a unique identifier.
        $postfieldarray['ignore_language'] = false; // Should stay false to let the brain determine the language
        $postfieldarray['asset_id'] = $asset_id; // optional marketing-course;
        $postfieldarray['asset_type'] = $asset_type; // optional MyAssetType;
        $postfieldarray['user_id'] = $user_id; // optional max-musterman-id;
        $postfieldarray['user_role'] = $user_role; // optional Marketing BSc. Student;
        $postfieldarray['group_ids'] = $group_ids; // optional ['group-a', 'group-b']
        $postfieldarray['poison_index'] = $poison_index; // optional,

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->_api_baseurl . '/brain/access/track/url-bits',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postfieldarray,
        ));

        // Execute the API call.
        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    /** Track some basic a images into the TARSUS brain
     * @param $brainid
     * @param $imagecontent
     * @param $resource_id
     * @param $asset_id
     * @param $asset_type
     */
    public function track_image_bits($brainid, $imagecontent, $resource_id, $imagetitle, $imagealt = '',
                                   $asset_id = '', $asset_type = '', $user_id = '',
                                   $user_role = '', $group_ids = '', $poison_index = false) {
        global $DB;
        $curl = curl_init();

        /** structure definition */
        /*
        array('api_key' => '7517fd28-8cb4-4304-b9f0-0312b8c92ef1',
            'brain_id' => 'customer-demo',
            'image_content'=> new CURLFILE('/Users/zz/Downloads/ezgif.com-video-to-gif.gif'),
            'text' => 'Some text related to the image',
            'title' => 'Image Title',
            'resource_id' => 'ImageID',
            'ignore_language' => 'false',
            'asset_id' => 'myAssetID',
            'asset_type' => 'MyAssetType', ));
        */

        if ($imagealt == '') {
            // Make sure to set anything if the var is empty.
            $imagealt = $imagetitle;
        }

        // Set all the nessessary vars for the query into this Array.
        $postfieldarray['api_key'] = $this->_api_key;
        $postfieldarray['brain_id'] = $brainid;
        $postfieldarray['image_content'] =  new \CURLFILE($imagecontent);
        $postfieldarray['title'] = $imagetitle;
        $postfieldarray['text'] = $imagealt;
        $postfieldarray['resource_id'] = $resource_id; // marketing-definition-text - This text must be assigned a unique identifier.
        $postfieldarray['ignore_language'] = false; // Should stay false to let the brain determine the language
        $postfieldarray['asset_id'] = $asset_id; // optional marketing-course;
        $postfieldarray['asset_type'] = $asset_type; // optional MyAssetType;
        $postfieldarray['user_id'] = $user_id; // optional max-musterman-id;
        $postfieldarray['user_role'] = $user_role; // optional Marketing BSc. Student;
        $postfieldarray['group_ids'] = $group_ids; // optional ['group-a', 'group-b']
        $postfieldarray['poison_index'] = $poison_index; // optional,

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->_api_baseurl . '/brain/access/track/image-bits',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postfieldarray,
        ));

        // Execute the API call.
        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }


    /** Track some basic a image from an URL into the TARSUS brain
     * @param $brainid
     * @param $imageurl
     * @param $resource_id
     * @param $asset_id
     * @param $asset_type
     */
    public function track_image_url_bits($brainid, $imageurl, $resource_id, $imagetitle, $imagealt = '',
                                     $asset_id = '', $asset_type = '', $user_id = '',
                                     $user_role = '', $group_ids = '', $poison_index = false) {
        global $DB;
        $curl = curl_init();

        /** structure definition */
        /*
        array('api_key' => '7517fd28-8cb4-4304-b9f0-0312b8c92ef1',
            'brain_id' => 'customer-demo',
            'image_content'=> new CURLFILE('/Users/zz/Downloads/ezgif.com-video-to-gif.gif'),
            'text' => 'Some text related to the image',
            'title' => 'Image Title',
            'resource_id' => 'ImageID',
            'ignore_language' => 'false',
            'asset_id' => 'myAssetID',
            'asset_type' => 'MyAssetType', ));
        */

        if ($imagealt == '') {
            // Make sure to set anything if the var is empty.
            $imagealt = $imagetitle;
        }

        // Set all the nessessary vars for the query into this Array.
        $postfieldarray['api_key'] = $this->_api_key;
        $postfieldarray['brain_id'] = $brainid;
        $postfieldarray['image_url'] = $imageurl;
        $postfieldarray['title'] = $imagetitle;
        $postfieldarray['text'] = $imagealt;
        $postfieldarray['resource_id'] = $resource_id; // marketing-definition-text - This text must be assigned a unique identifier.
        $postfieldarray['ignore_language'] = false; // Should stay false to let the brain determine the language
        $postfieldarray['asset_id'] = $asset_id; // optional marketing-course;
        $postfieldarray['asset_type'] = $asset_type; // optional MyAssetType;
        $postfieldarray['user_id'] = $user_id; // optional max-musterman-id;
        $postfieldarray['user_role'] = $user_role; // optional Marketing BSc. Student;
        $postfieldarray['group_ids'] = $group_ids; // optional ['group-a', 'group-b']
        $postfieldarray['poison_index'] = $poison_index; // optional,

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->_api_baseurl . '/brain/access/track/image-url-bits',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postfieldarray,
        ));

        // Execute the API call.
        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    /** Track some basic video into the TARSUS brain
     * @param $brainid
     * @param $videocontent
     * @param $resource_id
     * @param $videotitle
     * @param $videoalt
     * @param $asset_id
     * @param $asset_type
     */
    public function track_video_bits($brainid, $videocontent, $resource_id, $videotitle, $videoalt = '',
                                     $asset_id = '', $asset_type = '', $user_id = '',
                                     $user_role = '', $group_ids = '', $poison_index = false) {
        global $DB;
        $curl = curl_init();

        /** structure definition */
        /*
        array('api_key' => '7517fd28-8cb4-4304-b9f0-0312b8c92ef1',
            'brain_id' => 'customer-demo',
            'video_content'=> new CURLFILE('/Users/zz/Downloads/RPReplay-Final1698357926 (1).MP4'),
            'resource_id' => 'Video Resource Id',
             'title' => 'Your title',
            'text' => 'Your Text'
            'ignore_language' => 'false',
            'asset_id' => 'myAssetID',
            'asset_type' => 'MyAssetType',
        */

        if ($videoalt == '') {
            // Make sure to set anything if the var is empty.
            $videoalt = $videotitle;
        }

        // Set all the nessessary vars for the query into this Array.
        $postfieldarray['api_key'] = $this->_api_key;
        $postfieldarray['brain_id'] = $brainid;
        $postfieldarray['video_content'] = new \CURLFILE($videocontent);
        $postfieldarray['title'] = $videotitle;
        $postfieldarray['text'] = $videoalt;
        $postfieldarray['resource_id'] = $resource_id; // marketing-definition-text - This text must be assigned a unique identifier.
        $postfieldarray['ignore_language'] = false; // Should stay false to let the brain determine the language
        $postfieldarray['asset_id'] = $asset_id; // optional marketing-course;
        $postfieldarray['asset_type'] = $asset_type; // optional MyAssetType;
        $postfieldarray['user_id'] = $user_id; // optional max-musterman-id;
        $postfieldarray['user_role'] = $user_role; // optional Marketing BSc. Student;
        $postfieldarray['group_ids'] = $group_ids; // optional ['group-a', 'group-b']
        $postfieldarray['poison_index'] = $poison_index; // optional,

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->_api_baseurl . '/brain/access/track/video-bits',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postfieldarray,
        ));

        // Execute the API call.
        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }


    /** Track some basic video from an URL into the TARSUS brain
     * @param $brainid
     * @param $videourl
     * @param $videosource
     * @param $resource_id
     * @param $videotitle
     * @param $videoalt
     * @param $asset_id
     * @param $asset_type
     */
    public function track_video_url_bits($brainid, $videourl, $videosource, $resource_id, $videotitle, $videoalt = '',
                                     $asset_id = '', $asset_type = '', $user_id = '',
                                     $user_role = '', $group_ids = '', $poison_index = false) {
        global $DB;
        $curl = curl_init();

        /** structure definition */
        /*
        array('api_key' => '7517fd28-8cb4-4304-b9f0-0312b8c92ef1',
            'brain_id' => 'customer-demo',
            'video_url' => 'https://youtu.be/YfZ0zk5Zzcw',
            'video_source' => 'youtube'
            'resource_id' => 'Video Resource Id',
             'title' => 'Your title',
            'text' => 'Your Text'
            'ignore_language' => 'false',
            'asset_id' => 'myAssetID',
            'asset_type' => 'MyAssetType',
        */

        if ($videoalt == '') {
            // Make sure to set anything if the var is empty.
            $videoalt = $videotitle;
        }

        // Set all the nessessary vars for the query into this Array.
        $postfieldarray['api_key'] = $this->_api_key;
        $postfieldarray['brain_id'] = $brainid;
        $postfieldarray['video_url'] = $videourl;
        $postfieldarray['video_source'] = $videosource;
        $postfieldarray['title'] = $videotitle;
        $postfieldarray['text'] = $videoalt;
        $postfieldarray['resource_id'] = $resource_id; // marketing-definition-text - This text must be assigned a unique identifier.
        $postfieldarray['ignore_language'] = false; // Should stay false to let the brain determine the language
        $postfieldarray['asset_id'] = $asset_id; // optional marketing-course;
        $postfieldarray['asset_type'] = $asset_type; // optional MyAssetType;
        $postfieldarray['user_id'] = $user_id; // optional max-musterman-id;
        $postfieldarray['user_role'] = $user_role; // optional Marketing BSc. Student;
        $postfieldarray['group_ids'] = $group_ids; // optional ['group-a', 'group-b']
        $postfieldarray['poison_index'] = $poison_index; // optional,

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->_api_baseurl . '/brain/access/track/video-url-bits',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postfieldarray,
        ));

        // Execute the API call.
        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }
}

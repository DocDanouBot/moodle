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

use pix_icon;
use stdClass;
use moodle_url;
use local_lai_connector\tarsus_brain;


/**
 * Utility class for the local_lai_connector plugin.
 */
class util
{

    /** Check if the menu should be displayed at all
     * @param
     * @return mixed
     * @throws \lai_exception
     */
    public static function show_lai_menu() {
        global $CFG;

        $returnboolean = ((has_capability('local/lai_connector:viewindexpage', \context_system::instance())
                && (isset($CFG->local_lai_connector_activate_component) &&
                    $CFG->local_lai_connector_activate_component == 1)) ||
            false);
        return $returnboolean;
    }

    /** Maps elements for this course to modules with their instances and return and associative array.
     * @param array $allcms
     * @param array $allmodules
     * @return array
     * @throws \lai_exception
     */
    public static function map_cm_to_tarsus_brain($allcms, $allmodules) {
        $allmappingentries = array();
        foreach ($allcms as $cmid=>$cm) {
            $mappingentry = array();
            // We always need the CMID, so we better memoize it too,
            $mappingentry['cmid'] = $cm->id;
            // Than we map the id of the module to query it later
            $mappingentry['moduleid'] =  $allmodules[$cm->module]->id;
            // Than we map the name of the module to query it later
            $mappingentry['module'] =  $allmodules[$cm->module]->name;
            // Than we need the real instanceID from the CMID to find it in the other DB
            $mappingentry['instanceid'] = $cm->instance;
            $allmappingentries[$cm->id] = $mappingentry;

            // For print and dev purposes only
            // $allmappingentries[$cm->id] = implode('-', $mappingentry);
        }
        // Return the array with all mapping entries
        // The structure is like this:
        // CMID - moduleid - moduletype - instanceid
        // "result":"
        // 1-9-forum-1|
        // 2-19-scorm-1|
        // 3-17-quiz-1|
        // 10-24-individualfeedback-1|
        // 11-7-feedback-1"

        return $allmappingentries;
    }


    public static function map_moduletype_to_bittype($moduleid) {
        $allBitTypes = \local_lai_connector\definitions::LOCAL_LAI_CONNECTOR_TRACK_BITS_TYPES;

        // ModuleID -> ModuleName
        /**
            1 -> assign
            2 -> bigbluebuttonbn
            3 -> book
            4 -> chat
            5 -> choice
            6 -> data
            7 -> feedback
            8 -> folder
            9 -> forum
            10 -> glossary
            11 -> h5pactivity
            12 -> imscp
            13 -> label
            14 -> lesson
            15 -> lti
            16 -> page
            17 -> quiz
            18 -> resource
            19 -> scorm
            20 -> survey
            21 -> url
            22 -> wiki
            23 -> workshop
            24 -> individualfeedback
         * */

        // Now we look for the correct event we need to trigger, depending on the BitType
        switch ($moduleid) {
            case 1:
                return "TEXT";
                break;
            case 5:
                return "QUESTION_BOOL";
                break;
            case 7:
                return "QUESTION_OPEN";
                break;
            case 9:
                return "FORUM";
                break;
            case 13:
                return "TEXT LABEL";
                break;
            case 16:
                return "TEXT PAGE";
                break;
            case 17:
                return "QUESTION";
                break;
            case 18:
                return "FILE";
                break;
            case 19:
                return "SCORM";
                break;
            case 21:
                return "URL";
                break;
            case 24:
                return "QUESTION_OPEN";
                break;
            default:
                return "NONE";
                break;
        }
    }

    /** Returns an array with all trackable activities which we can use in the settings.php
     *
     */
    public static function get_trackable_activities($withDefaults = false)
    {
        global $DB;

        // The 23 standard moodle ModuleID -> ModuleName
        /**
         * 1 -> assign
         * 2 -> bigbluebuttonbn
         * 3 -> book
         * 4 -> chat
         * 5 -> choice
         * 6 -> data
         * 7 -> feedback
         * 8 -> folder
         * 9 -> forum
         * 10 -> glossary
         * 11 -> h5pactivity
         * 12 -> imscp
         * 13 -> label
         * 14 -> lesson
         * 15 -> lti
         * 16 -> page
         * 17 -> quiz
         * 18 -> resource
         * 19 -> scorm
         * 20 -> survey
         * 21 -> url
         * 22 -> wiki
         * 23 -> workshop
         * */

        $returnArray = array();
        $allAvailableActivityTypes = \local_lai_connector\definitions::LOCAL_LAI_CONNECTOR_TRACKABLE_ACTIVITY_TYPES;

        foreach ($allAvailableActivityTypes as $activityType => $thisAvailableActivityType) {
            if($withDefaults == true) {
                if (!$thisAvailableActivityType['disabled']) {
                    $returnArray[$activityType] = get_string('modulename', $thisAvailableActivityType['mod_name']);
                }
            } else {
                $returnArray[$activityType] = get_string('modulename', $thisAvailableActivityType['mod_name']);
            }
        }

        // Now eventually we need to add also the extra activities, that are not standard
        if ($withDefaults == false) {
            // Only go in there if we do NOT get the available defaults, to save a DB Query
            $allModules = $DB->get_records('modules');
            foreach ($allModules as $thisModule) {
                if (!array_key_exists(strtoupper($thisModule->name), $returnArray)) {
                    // Map the correct activity name to the array-key
                    $returnArray[strtoupper($thisModule->name)] = get_string('modulename', 'mod_'.$thisModule->name);
                }
            }
        }

        return $returnArray;
    }

    /** Creates a new tarsus_brain using the tarsus_brain class
     * @param stdClass $formdata
     * @return tarsus_brain
     * @throws \moodle_exception
     * @throws exceptions
     */
    public static function create_tarsus_brain(\stdClass $formdata)
    {
        $tarsus_brain = \local_lai_connector\tarsus_brain::create($formdata->brain_id, $formdata->brainname, $formdata->braindescription);
        return $tarsus_brain;
    }


    /** Updates an existing tarsus_brain using the tarsus_brain class
     * @param stdClass $formdata
     * @return tarsus_brain
     * @throws \moodle_exception
     * @throws exceptions\tarsus_brain_exception
     */
    public static function update_tarsus_brain(\stdClass $formdata)
    {
        $tarsus_brain = new \local_lai_connector\tarsus_brain($formdata->brainid);
        $tarsus_brain->update($formdata);
        return $tarsus_brain;
    }

    /** Since not all UTF-8 characters are accepted in an XML document.
     * you’ll need to strip any such characters out from any XML that you generate.
     * @param $string
     * @return array|string|string[]|null
     */
    public static function utf8_for_xml($string)
    {
        return preg_replace('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u',
            ' ', $string);
    }

    // Removes the given html tags wit invert is true.
    // so we can use this function to reduce html text by images and video
    public static
    function strip_tags_content($text, $tags = '', $invert = FALSE) {
        preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
        $tags = array_unique($tags[1]);

        if(is_array($tags) AND count($tags) > 0) {
            if($invert == FALSE) {
                return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
            } else {
                return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text);
            }
        } elseif($invert == FALSE) {
            return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
        }
        return $text;
    }

    // Removes the given html tags and puts in its place just the inner content
    public static
    function replace_first_tags_with_content($text, $tags, $content) {
        preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
        $tags = array_unique($tags[1]);

        if(is_array($tags) AND count($tags) > 0) {
            return preg_replace('@<(' . implode('|', $tags) . ')\b.*?>.*?</\1>@si', $content, $text, 1);
        }
        return $text;
    }

}


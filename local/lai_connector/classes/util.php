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
            // First we map the id of the module to query it later
            $mappingentry['moduleid'] =  $allmodules[$cm->module]->id;
            // Than we map the name of the module to query it later
            $mappingentry['module'] =  $allmodules[$cm->module]->name;
            // Than we need the real instanceID from the CMID to find it in the other DB
            $mappingentry['instanceid'] = $cm->instance;
            $allmappingentries[] = $mappingentry;
            # $allmappingentries[] = implode('-', $mappingentry);
        }
        return $allmappingentries;
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

}


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

namespace local_lai_connector\output\templatedata;

defined('MOODLE_INTERNAL') || die('Direct access to this script is forbidden.'); // It must be included from a Moodle page.

use templatable;
use renderer_base;
use moodle_url;

/**
 * Class to prepare template data
 *
 */
class page_brains implements templatable {

    /** @var \object $content The content object. */
    public $content;

    /** @var array of multiple brains elements. Added up with additional data from other sources */
    public $brains;

    /**
     * Constructor
     *
     * @param  \stdClass $content
     */
    public function __construct($content) {
        // init empty var
        $allbrains = array();
        $brainsobject = new \stdClass();

        // Save all the other content for later
        $this->content = $content;

        // Generate static content for testing

        $brainsawareness = json_decode($content['brains']);
        if(isset($brainsawareness->awareness)) {
            $brainsobject = $brainsawareness->awareness;
        }

        // Initialize the API from TARSUS. We need to get the Brain quotas later on
        // $api = \local_lai_connector\api_connector_tarsus::get_instance();
        if(isset($brainsobject->brain_ids) && is_array($brainsobject->brain_ids)) {
            foreach ($brainsobject->brain_ids as $brain) {
                // For each element build a new object node and add additional data from another query to it.

                // Therefore we must also fetch the additional data from our database
                $localbrain = \local_lai_connector\tarsus_brain::get_instance($brain->id);
                // And mapp this data also into the $newbrainobject
                $newbrainobjekt = new \stdClass();
                $newbrainobjekt->brainname = $localbrain->brainname;
                $newbrainobjekt->braindescription = $localbrain->braindescription;
                $newbrainobjekt->braindate = date("d.m.Y H:s", $localbrain->timecreated);
                $newbrainobjekt->brainquota = "extra page"; // $api->get_brain_usage($brain->id); // this curl takes too long, makes no sense to do it here.
                $newbrainobjekt->brainid = $brain->id;
                $allbrains[] = $newbrainobjekt;
            }
        }
        $this->brains = $allbrains;
    }

    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @param renderer_base $output The base renderer object
     * @return object
     */
    public function export_for_template(renderer_base $output) {
        $content = $this->content;
        $content['brains'] = $this->brains;
        return $content;
    }

}

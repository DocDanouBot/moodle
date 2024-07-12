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

    /** @var brains elements. */
    public $brains;

    /**
     * Constructor
     *
     * @param  \stdClass $content
     */
    public function __construct($content) {
        // init empty var
        $allbrains = array();

        // Save all the other content for later
        $this->content = $content;

        // Generate static content for testing

        $brainsawareness = json_decode($content['brains']);
        $brainsobject = $brainsawareness->awareness;

        echo("<br>brainsobject<br>");
        var_dump($brainsobject);

        foreach ($brainsobject->brain_ids as $brain) {
            echo("<hr>");
            $newbrainobjekt = new \stdClass();
            $newbrainobjekt->brainname = "First Name ";
            $newbrainobjekt->brainquota = "First Quota ";
            $newbrainobjekt->brainid = $brain->id;
            # $newbrainobjekt->braindeleteurl = "First Quota ";
            $allbrains[] = $newbrainobjekt;
            var_dump($brain->id);
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

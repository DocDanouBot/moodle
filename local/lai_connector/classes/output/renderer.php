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

namespace local_lai_connector\output;

# use local_lai_connector\output\templatedata\page_reports;

defined('MOODLE_INTERNAL') || die();

/**
 * Renderer for the local plugin local_lai_connector
 */
class renderer extends \plugin_renderer_base {

    /**
     * Just making sure, that the doctype is definetly set, so we do not get any debug messages.
     */
    public function header() {
        global $OUTPUT;
        // Set the standard
        $this->page->theme->doctype = 'html5';

        // Print the page heading.
        echo $OUTPUT->header();
    }

    /**
     * render_facility - Renders one facility
     *
     * @param  \stdClass $content
     * @return string
     */
    public function render_brains($content) {
        $templatedata = new \local_lai_connector\output\templatedata\page_brains($content);

         echo("<br><br><br><hr>");
         var_dump($templatedata);
        $output = $this->render_from_template('local_lai_connector/page_brains',
            $templatedata->export_for_template($this));
        return $output;
    }

}

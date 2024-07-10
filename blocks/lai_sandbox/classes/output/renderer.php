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
 * @package     block_lai_sandbox
 * @copyright   lern.link GmbH
 * @author      Danou Nauck
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_lai_sandbox\output;

defined('MOODLE_INTERNAL') || die('Direct access to this script is forbidden.'); // It must be included from a Moodle page.

/**
 * Renderer for the local plugin local_iubh_facility
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
     * render_facility - Renders one set of AJAX Buttons
     *
     * @param  \stdClass $content
     * @return string
     */
    public function render_sandbox_buttons($content) {
        $templatedata = $content;
        return $this->render_from_template('block_lai_sandbox/block_open_sandbox', $templatedata);
    }


}

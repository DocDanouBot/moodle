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
 * Front-end class.
 *
 * @package availability_minduration
 * @copyright   lern.link GmbH
 * @author      Danou Nauck
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace availability_minduration;

defined('MOODLE_INTERNAL') || die();

class frontend extends \core_availability\frontend {


    protected function get_javascript_init_params($course, \cm_info $cm = null,
                                                  \section_info $section = null) {

        // Change to JS array format and return.
        // $jsarray = array();
        // $context = \context_course::instance($course->id);
        $jsarray = $this->get_javascript_strings();
        return array($jsarray);
    }

    /**Get the nessessary javascript strings.
     * @return string[]
     */
    protected function get_javascript_strings() {
        return array(1 => 'requires_0min',2 => 'requires_60min',  3 => 'requires_120min', 4 => 'requires_180min', 0 => 'label_access');
    }

    protected function allow_add($course, \cm_info $cm = null, \section_info $section = null) {
        return true;
    }
}

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
 * @package     local_iubh_turnitin
 * @author      Danou Nauck <Danou@Nauck.eu>
 * @copyright   Nauck IT Consulting 2021
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_iubh_turnitin\output\templatedata;

defined('MOODLE_INTERNAL') || die();

use templatable;
use renderer_base;
use moodle_url;

/**
 * Class to prepare template data
 *
 */
class confirmation_box implements templatable {

    /** @var \object $content The block content object. */
    protected $content;

    /**
     * Constructor
     *
     * @param  \stdClass $content
     */
    public function __construct($content) {
        $this->content = $content;
    }

    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @param renderer_base $output The base renderer object
     * @return object
     */
    public function export_for_template(renderer_base $output) {
        $content = $this->content;
        return $content;
    }
}

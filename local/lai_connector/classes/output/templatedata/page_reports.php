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
 * Report page Lai Connector report.
 *
 * @package     local_lai_connector
 * @copyright   lern.link GmbH
 * @author      Danou Nauck
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


namespace local_lai_connector\output\templatedata;

defined('MOODLE_INTERNAL') || die();

use templatable;
use renderer_base;
use moodle_url;

/**
 * Class to prepare template data
 *
 */
class page_reports implements templatable {

    /** @var \object $content The block content object. */
    protected $content;

    /**
     * Constructor
     */
    public function __construct($data) {
        $this->content = $data;
    }

    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @param renderer_base $output The base renderer object
     *
     * @return object
     */
    public function export_for_template(renderer_base $output) {
        global $DB;
        $content = $this->content;

        return $content;
    }
}

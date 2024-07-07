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

class api_connector_tarsus
{

    /**
     * Get a descriptive name for this AI Connection
     *
     * @return string
     */
    public function get_name(): string {
        // The name of the API
        return get_string('api_tarsus_mainname', 'local_lai_connector');
    }

    // The URL to the API of the connector
    public function get_api_url(): moodle_url {
        if (isset())
        $CFG-
        return new moodle_url('/local/lai_connector/api_tarsus.php');
    }


}

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

class ai_connector
{
    /*
     *  The var that saves the name of the currently used API.
     */
    private static $_api_provider = '';

    /**
     * Get the name of the currently used API.
     *
     * @return string The name of the currently used API.
     */
    public static function get_api_provider() {
        return self::$_api_provider;
    }

    /**
     * Set the name of the currently used API.
     *
     * @param string $api_provider The name of the API.
     */
    public static function set_api_provider($api_provider) {
        self::$_api_provider = $api_provider;
    }

}

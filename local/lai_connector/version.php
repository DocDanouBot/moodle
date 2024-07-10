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
 * Versionfile
 *
 * @package     local_lai_connector
 * @copyright   lern.link GmbH
 * @author      Danou Nauck
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

$plugin = new stdClass();
$plugin->version      = 2024060604;
$plugin->requires     = 2022041900; // Moodle 4.0 release and upwards.
$plugin->name         = 'LernLink AI Connector';
$plugin->component    = 'local_lai_connector';
$plugin->release      = '4.0.1 (build 2022090102)';
$plugin->maturity     = MATURITY_ALPHA;
$plugin->dependencies = array();
$plugin->cron         = 0;
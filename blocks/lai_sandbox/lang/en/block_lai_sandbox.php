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

/** english language file.
 *
 * @package     block_lai_sandbox
 * @copyright   lern.link GmbH
 * @author      Danou Nauck
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

$string['pluginname'] = 'LAI test area';
$string['plugin_title'] = 'Your test area for the LAI interface';
$string['privacy:metadata'] = 'The LernLink AI Sandbox block does not store any personal data';

// Rights and Roles
$string['lai_sandbox:myaddinstance'] = 'May add the LAI test area to your own dashboard';
$string['lai_sandbox:addinstance'] = 'May add the LAI test area to the page';
$string['lai_sandbox:viewsandbox'] = 'May display the LAI test area';

// info for the main page in frontend.
$string['admin_not_available'] = 'There is currently no further information. You can change the settings <a href="/admin/settings.php?section=blocksettinglai_sandbox">here</a>.';
$string['admin_title'] = 'LAI test area';
$string['admin_view_open'] = 'Open the LAI test area';
$string['admin_view_close'] = 'Close the LAI test area';

// All texts in frontend.
$string['ajax_title_get_token'] = 'Get a token';
$string['ajax_title_drop_token'] = 'Drop the token';

// strings for the settings page.
$string['setting_laisandbox'] = 'Settings for the sandbox block from the LAI component';
$string['setting_laisandbox_help'] = 'Here you can make all settings for the block';
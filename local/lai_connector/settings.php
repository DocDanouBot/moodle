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
 * Settings
 *
 * @package     local_lai_connector
 * @copyright   lern.link GmbH
 * @author      Danou Nauck
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;
global $CFG, $DB;



if ($hassiteconfig) {

    $settings = new theme_boost_admin_settingspage_tabs('local_lai_connector', get_string('pluginname', 'local_lai_connector'));

    /* All general settings */
    $setting = new admin_settingpage('local_lai_connector_general',
        get_string('setting_general_tab_title', 'local_lai_connector'));

    $setting->add(new admin_setting_heading('headerconnectorgeneral',
        get_string('setting_general_title', 'local_lai_connector'),
        get_string('setting_general_title_help', 'local_lai_connector')));

    // Show Button within course to create entries?
    $name = 'local_lai_connector_activate_component';
    $title = get_string('setting_activate_component', 'local_lai_connector');
    $hint = get_string('setting_activate_component_help', 'local_lai_connector');
    $default = false;
    $setting->add(new admin_setting_configcheckbox($name, $title, $hint, $default));

    // API Key for TARSUS
    $name = 'local_lai_connector_apikey_tarsus';
    $title = get_string('setting_apikey_tarsus', 'local_lai_connector');
    $hint = get_string('setting_apikey_tarsus_help', 'local_lai_connector');
    $default = '7517fd28-8cb4-4304-b9f0-0312b8c92ef1'; // Default Api Key
    $setting->add(new admin_setting_configtext($name, $title, $hint, $default));

    $settings->add($setting);

    /* -------------------------------------------------------------------- */

    /* Main Brain settings */
    $setting = new admin_settingpage('local_lai_connector_mainbrain',
        get_string('setting_mainbrain_tab_title', 'local_lai_connector'));

    $setting->add(new admin_setting_heading('headerconnectormainbrain',
        get_string('setting_mainbrain_title', 'local_lai_connector'),
        get_string('setting_mainbrain_title_help', 'local_lai_connector')));

    $settings->add($setting);

    /* -------------------------------------------------------------------- */

    /* Sub Brain settings */
    $setting = new admin_settingpage('local_lai_connector_subbrain',
        get_string('setting_subbrain_tab_title', 'local_lai_connector'));

    $setting->add(new admin_setting_heading('headerconnectorsubbrain',
        get_string('setting_subbrain_title', 'local_lai_connector'),
        get_string('setting_subbrain_title_help', 'local_lai_connector')));

    $settings->add($setting);


    /* -------------------------------------------------------------------- */

    /* Tasks settings */
    $setting = new admin_settingpage('local_lai_connector_tasks',
        get_string('setting_tasks_tab_title', 'local_lai_connector'));

    $setting->add(new admin_setting_heading('headerconnectortasks',
        get_string('setting_tasks_title', 'local_lai_connector'),
        get_string('setting_tasks_title_help', 'local_lai_connector')));

    $settings->add($setting);





    $ADMIN->add('localplugins', $settings);
}

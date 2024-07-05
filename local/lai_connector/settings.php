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

    $settings = new theme_boost_admin_settingspage_tabs('local_iubh_turnitin', get_string('pluginname', 'local_iubh_turnitin'));

    /* All general settings */
    $setting = new admin_settingpage('local_iubh_turnitin_general',
        get_string('setting_general_title', 'local_iubh_turnitin'));

    $setting->add(new admin_setting_heading('headerturnitingeneral',
        get_string('setting_general', 'local_iubh_turnitin'),
        get_string('setting_general_help', 'local_iubh_turnitin')));

    // Show Button within course to create entries?
    $name = 'local_iubh_turnitin_showcreateentrybutton';
    $title = get_string('setting_createbutton_show', 'local_iubh_turnitin');
    $hint = get_string('setting_createbutton_show_help', 'local_iubh_turnitin');
    $default = false;
    $setting->add(new admin_setting_configcheckbox($name, $title, $hint, $default));

    // Date of execution of Cron Job / Task
    $name = 'local_iubh_turnitin_taskpushtoarchive_days';
    $title = get_string('setting_tasks_pushtoarchive_day', 'local_iubh_turnitin');
    $hint = get_string('setting_tasks_pushtoarchive_day_help', 'local_iubh_turnitin');
    $default = 29;
    $setting->add(new admin_setting_configtext($name, $title, $hint, $default));


    // This Tasks aktivated?
    $name = 'local_iubh_turnitin_tasks_generatelogs_active';
    $title = get_string('setting_tasks_generatelogs_active', 'local_iubh_turnitin');
    $hint = get_string('setting_tasks_generatelogs_active_help', 'local_iubh_turnitin');
    $default = 1;
    $setting->add(new admin_setting_configcheckbox($name, $title, $hint, $default));

    $settings->add($setting);


    $ADMIN->add('localplugins', $settings);
}

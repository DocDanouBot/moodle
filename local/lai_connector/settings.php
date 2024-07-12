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
    # require_once($CFG->dirroot. '/local/lai_connector/lib.js');
    # $PAGE->requires->js(new moodle_url('/h5p/js/embed.js'));

    $settings = new theme_boost_admin_settingspage_tabs('local_lai_connector', get_string('pluginname', 'local_lai_connector'));

    /* All general settings */
    $setting = new admin_settingpage('local_lai_connector_general',
        get_string('setting_general_tab_title', 'local_lai_connector'));

    $setting->add(new admin_setting_heading('headerconnectorgeneral',
        get_string('setting_general_title', 'local_lai_connector'),
        get_string('setting_general_title_help', 'local_lai_connector') . get_string('setting_general_title_url', 'local_lai_connector')));

    // Activate component?
    $name = 'local_lai_connector_activate_component';
    $title = get_string('setting_activate_component', 'local_lai_connector');
    $hint = get_string('setting_activate_component_help', 'local_lai_connector');
    $default = false;
    $setting->add(new admin_setting_configcheckbox($name, $title, $hint, $default));

    // Options for the API interface to different providers
    $availableapioptions = array(
        1 => get_string('api_tarsus_mainname', 'local_lai_connector'),
        2 => get_string('api_chatgpt_mainname', 'local_lai_connector'),
        3 => get_string('api_claude_mainname', 'local_lai_connector'),
    );
    // We want a select-box where the user can select the currently used API component.
    $name    = 'local_lai_connector_current_api';
    $title   = get_string('setting_current_api', 'local_lai_connector');
    $hint    = get_string('setting_current_api_help', 'local_lai_connector');
    $default = 1;
    $setting->add(new \admin_setting_configselect($name, $title, $hint, $default, $availableapioptions));

    // API Key for chatGPT
    $name = 'local_lai_connector_chatgpt_api_key';
    $title = get_string('setting_chatgpt_apikey', 'local_lai_connector');
    $hint = get_string('setting_chatgpt_apikey_help', 'local_lai_connector');
    $default = 'chatGPT-KEY-NOT-VALID'; // Default chatgpt Api Key
    $setting->add(new admin_setting_configtext($name, $title, $hint, $default));
    $setting->hide_if('local_lai_connector_chatgpt_api_key', 'local_lai_connector_current_api', 'neq', '2');

    // API URL for chatGPT
    $name = 'local_lai_connector_chatgpt_api_url';
    $title = get_string('setting_chatgpt_apiurl', 'local_lai_connector');
    $hint = get_string('setting_chatgpt_apiurl_help', 'local_lai_connector');
    $default = 'https://api.openai.com/v1/models'; // Default chatgpt Api URL
    $setting->add(new admin_setting_configtext($name, $title, $hint, $default));
    $setting->hide_if('local_lai_connector_chatgpt_api_url', 'local_lai_connector_current_api', 'neq', '2');

    // API Key for CLAUDE
    $name = 'local_lai_connector_claude_api_key';
    $title = get_string('setting_claude_apikey', 'local_lai_connector');
    $hint = get_string('setting_claude_apikey_help', 'local_lai_connector');
    $default = 'CLAUDE-KEY-NOT-VALID'; // Default CLAUDE Api Key
    $setting->add(new admin_setting_configtext($name, $title, $hint, $default));
    $setting->hide_if('local_lai_connector_claude_api_key', 'local_lai_connector_current_api', 'neq', '3');

    // API URL for CLAUDE
    $name = 'local_lai_connector_claude_api_url';
    $title = get_string('setting_claude_apiurl', 'local_lai_connector');
    $hint = get_string('setting_claude_apiurl_help', 'local_lai_connector');
    $default = 'https://api.anthropic.com/v1/messages'; // Default CLAUDE Api URL
    $setting->add(new admin_setting_configtext($name, $title, $hint, $default));
    $setting->hide_if('local_lai_connector_claude_api_url', 'local_lai_connector_current_api', 'neq', '3');

    // API Key for TARSUS
    $name = 'local_lai_connector_tarsus_api_key';
    $title = get_string('setting_tarsus_apikey', 'local_lai_connector');
    $hint = get_string('setting_tarsus_apikey_help', 'local_lai_connector');
    $default = '7517fd28-8cb4-4304-b9f0-0312b8c92ef1'; // Default TARSUS Api Key
    $setting->add(new admin_setting_configtext($name, $title, $hint, $default));
    $setting->hide_if('local_lai_connector_tarsus_api_key', 'local_lai_connector_current_api', 'neq', '1');

    // API URI for TARSUS
    $name = 'local_lai_connector_tarsus_api_url';
    $title = get_string('setting_tarsus_apiurl', 'local_lai_connector');
    $hint = get_string('setting_tarsus_apiurl_help', 'local_lai_connector');
    $default = 'https://brain.flexudy.com/api/v1'; // Default TARSUS Api URL
    $setting->add(new admin_setting_configtext($name, $title, $hint, $default));
    $setting->hide_if('local_lai_connector_tarsus_api_url', 'local_lai_connector_current_api', 'neq', '1');

    $settings->add($setting);

    /* -------------------------------------------------------------------- */

    /* General TARSUS settings and customer information */
    $setting = new admin_settingpage('local_lai_connector_tarsus',
        get_string('setting_tarsus_tab_title', 'local_lai_connector'));

    // Hide this element. Only show, if TARSUS is selected and in use
    $setting->hide_if('local_lai_connector_tarsus', 'local_lai_connector_current_api', 'neq', '1');

    $setting->add(new admin_setting_heading('headerconnectormainbrain',
        get_string('setting_tarsus_title', 'local_lai_connector'),
        get_string('setting_tarsus_title_help', 'local_lai_connector')));

    // Customer Name for TARSUS API.
    $name = 'local_lai_connector_tarsus_customer_name';
    $title = get_string('setting_tarsus_customer_name', 'local_lai_connector');
    $hint = get_string('setting_tarsus_customer_name_help', 'local_lai_connector');
    $default = 'lern.link GmbH'; // Default Customer Name for billing
    $setting->add(new admin_setting_configtext($name, $title, $hint, $default));
    $setting->hide_if('local_lai_connector_tarsus_customer_name', 'local_lai_connector_current_api', 'neq', '1');

    // Customer address for TARSUS API.
    $name = 'local_lai_connector_tarsus_customer_address';
    $title = get_string('setting_tarsus_customer_address', 'local_lai_connector');
    $hint = get_string('setting_tarsus_customer_address_help', 'local_lai_connector');
    $default = 'Kirchenstrasse 4, D-82211 Herrsching'; // Default Customer postal adress for billing
    $setting->add(new admin_setting_configtext($name, $title, $hint, $default));
    $setting->hide_if('local_lai_connector_tarsus_customer_address', 'local_lai_connector_current_api', 'neq', '1');

    // Customer Email for TARSUS API.
    $name = 'local_lai_connector_tarsus_customer_email';
    $title = get_string('setting_tarsus_customer_email', 'local_lai_connector');
    $hint = get_string('setting_tarsus_customer_email_help', 'local_lai_connector');
    $default = 'support@lernlink.de'; // Default Customer email for billing
    $setting->add(new admin_setting_configtext($name, $title, $hint, $default));
    $setting->hide_if('local_lai_connector_tarsus_customer_email', 'local_lai_connector_current_api', 'neq', '1');

    $html = html_writer::div(get_string('setting_tarsus_apikey_generate_description', 'local_lai_connector'), '') ."<br>";
    $attributes = array('id' => 'tarsus_ajax_generateapitoken');
    $actionbutton = $html . html_writer::div(get_string('setting_tarsus_apikey_generate', 'local_lai_connector'), 'btn btn-primary', $attributes) ."<br><br><br>";
    $completeparagraph = new admin_setting_description('tarsusbutton_startapi', null, $actionbutton);
    $setting->add($completeparagraph);

    #$link = '<div style="text-align: center"><button class="btn btn-primary">'.get_string('setting_courseext_addnow_action', 'local_lai_connector').'</button></div>';
    #$settings->add(new admin_setting_heading('newbuttontarsus', get_string('local_lai_connector', 'game'), $link));



    $settings->add($setting);

    /* -------------------------------------------------------------------- */

    /* Mainbrain and Sub Brain settings */
    $setting = new admin_settingpage('local_lai_connector_tarsus_brains',
        get_string('setting_tarsus_brain_tab_title', 'local_lai_connector'));

    // Hide this element. Only show, if TARSUS is selected and in use
    $setting->hide_if('local_lai_connector_tarsus_brains', 'local_lai_connector_current_api', 'neq', '1');

    $setting->add(new admin_setting_heading('headerconnectorsubbrain',
        get_string('setting_tarsus_brain_title', 'local_lai_connector'),
        get_string('setting_tarsus_brain_title_help', 'local_lai_connector')));

    $settings->add($setting);

    /* -------------------------------------------------------------------- */

    /* chatGPT settings */
    $setting = new admin_settingpage('local_lai_connector_chatgpt',
        get_string('setting_chatgpt_tab_title', 'local_lai_connector'));

    // Hide this element. Only show, if chatgpt is selected and in use
    $setting->hide_if('local_lai_connector_chatgpt', 'local_lai_connector_current_api', 'neq', '2');

    $setting->add(new admin_setting_heading('headerconnectorsubbrain',
        get_string('setting_chatgpt_title', 'local_lai_connector'),
        get_string('setting_chatgpt_title_help', 'local_lai_connector')));

    $settings->add($setting);


    /* -------------------------------------------------------------------- */

    /* Tasks settings */
    $setting = new admin_settingpage('local_lai_connector_tasks',
        get_string('setting_tasks_tab_title', 'local_lai_connector'));

    $setting->add(new admin_setting_heading('headerconnectortasks',
        get_string('setting_tasks_title', 'local_lai_connector'),
        get_string('setting_tasks_title_help', 'local_lai_connector')));

    // Activate Tasks?
    $name = 'local_lai_connector_activate_tasks';
    $title = get_string('setting_activate_tasks', 'local_lai_connector');
    $hint = get_string('setting_activate_tasks_help', 'local_lai_connector');
    $default = false;
    $setting->add(new admin_setting_configcheckbox($name, $title, $hint, $default));


    $settings->add($setting);





    $ADMIN->add('localplugins', $settings);
}

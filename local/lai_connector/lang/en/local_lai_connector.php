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

/** English language file
 *
 * @package     local_lai_connector
 * @copyright   lern.link GmbH
 * @author      Danou Nauck
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
$string['pluginname'] = 'LernLink AI Connector';
$string['pluginname_admin'] = 'LernLink AI Connector Administration';
$string['privacy:metadata'] = 'The LernLink AI Connector component does not store any personal data';

// info for the main menu navigation.
$string['link_mainmenu_index'] = 'LAI main page';
$string['link_mainmenu_coursesettings'] = 'Add course to TARSUS';

// Texts for the general AI Connector interface.
$string['aic_mainpage'] = 'AI Connector Modular interface';
$string['aic_current_api'] = 'Currently activated AI: ';
$string['aic_current_url'] = 'Current URL: ';
$string['aic_current_key'] = 'Current key: ';

// Texts for the API connecting to chatGPT.
$string['api_chatgpt_mainname'] = 'chatGPT';

// Texts for the API connecting to CLAUDE.
$string['api_claude_mainname'] = 'CLAUDE3';

// Texts for the API connecting to TARSUS.
$string['api_tarsus_mainname'] = 'TARSUS';
$string['api_tarsus_v1'] = 'Version 1.0';
$string['api_tarsus_v2'] = 'Version 2.0';

// Rights and Roles $string['lai_connector:viewindexpage'] = 'Can visit the main page of the component ';
$string['lai_connector:viewbrainpage'] = 'Can visit the page with the component`s brains';
$string['lai_connector:viewbrainquotaspage'] = 'Can visit the page with the brains quotas.';
$string['lai_connector: viewcuratedatapage'] = 'Can visit the content curation page.';
$string['lai_connector:settingsview'] = 'Can see the settings of the component ';
$string['lai_connector:settingsmanage'] = 'Can change the settings of the component';
$string['lai_connector:brainadd'] = 'Can add a new brain ';
$string['lai_connector:braindelete'] = 'Can delete a specific brain';
$string['lai_connector:brainview' ] = 'Can see the overview of all brains';
$string['lai_connector:assetadd'] = 'Can add additional assets and resources to the Brain';
$string['lai_connector:assetmydelete'] = 'Can delete his own assets and resources from the Brain';
$string['lai_connector: assetdelete'] = 'Can delete all available assets and resources from the brain';

// Events and related texts:
$string['event_brain_created'] = 'Event: A Tarsus Brain was created.';
$string['event_brain_updated'] = 'Event: A Tarsus Brain was updated.';
$string['event_brain_deleted'] = 'Event: A Tarsus Brain was deleted.';
$string['event_nugged_entry_created'] = 'Event: A single nugget was created.';$string['event_nugged_entry_deleted'] = 'Event: A single nugget was deleted.';
$string['event_coursesettings_extended_updated'] = 'Event: The extended course settings for TARSUS import have been updated.';
$string['track_text_bits_created'] = ' Event: A text bit was added to the brain.';
$string['track_text_bits_deleted'] = 'Event: A text bit was removed from the brain.';
$string['track_url_bits_created'] = 'Event: A URL- Bit was added to the brain.';
$string['track_url_bits_deleted'] = 'Event: A URL bit was removed from the brain.';
$string['event_track_image_url_bits_created'] = 'Event: A URL referenced image bit was added to the brain.';
$string['event_track_image_url_bits_deleted'] = 'Event: A URL referenced image bit was removed from the brain.';
$string['track_question_bits_created'] = 'Event: A question bit was added to the brain.';
$string['track_question_bits_deleted'] = 'Event: A question bit was removed from the brain.';
$string['track_question_open_bits_created' ] = 'Event: An open question bit was added to the brain.';
$string['track_question_open_bits_deleted'] = 'Event: An open question bit was removed from the brain.';
$string['track_question_bool_bits_created'] = 'Event: A boolean question bit was added to the brain.';
$string['track_question_bool_bits_deleted'] = 'Event: A boolean question bit was removed from the brain.';
$string[ 'track_document_bits_created'] = 'Event: A document bit was added to the brain.';
$string['track_document_bits_deleted'] = 'Event: A document bit was removed from the brain.';
$string['track_image_bits_created'] = 'Event: An image bit was added to the brain.';
$string['track_image_bits_deleted'] = 'Event: An image bit was removed from the brain.';
$string['track_audio_bits_created'] = 'Event: An audio bit was added to the brain.';
$string['track_audio_bits_deleted'] = 'Event: An audio bit was removed from the brain.';
$string['track_video_bits_created '] = 'Event: A video bit was added to the brain.';
$string['track_video_bits_deleted'] = 'Event: A video bit was removed from the brain.';
$string['track_video_url_bits_created'] = 'Event : A URL referenced video bit was added to the brain.';
$string['track_video_url_bits_deleted'] = 'Event: A URL referenced video bit was removed from the brain.';

// info for the main page.
$string['indexpage_title'] = 'LAI main page';
$string['brainpage_title'] = 'Main page for Brains';
$string['brainpage_description'] = 'Here you can find all Brains';
$string['brainquotaspage_title'] = 'Overview of Brain Quotas';
$string['brainquotaspage_description'] = 'Here you can find all information about the uses of Brains';
$string['curatedatapage_title'] = 'Curate content';
$string['curatedatapage_description'] = 'Main page for curating content';

// Info for the frontend. Edit Menu in the Course overview.
$string['frontend_cm_tarsus_status'] = 'The Tarsus status of this element';
$string['frontend_cm_tarsus_status_submitted'] = 'This element has already been added to the brain';
$string['frontend_cm_tarsus_status_submit'] = 'Add this element to the brain now';
$string['frontend_cm_tarsus_status_delete'] = 'Delete this element from the brain';
$string['frontend_cm_tarsus_status_norights'] = 'You do not have the right to change this status.';

// Javascript texts and modal window texts
$string['js_curatecontent'] = 'Curate content?';
$string['js_content_submitted_self'] = 'You have already submitted this content yourself. On date: ';
$string['js_content_submitted_not'] = 'This content has not been submitted yet. Do you want to curate this activity now? ';
$string['js_content_submitted'] = ' has already submitted this content, with date on: ';
$string['js_modal_title'] = 'How do you want to work with this content?';
$string['js_modal_title_add'] = 'Add this content to the Brain?';
$string['js_modal_title_remove'] = 'Remove this content again?';
$string['js_modal_content_include'] = 'Add this content to the brain.';
$string['js_modal_content_include_now'] = 'Add content';
$string['js_modal_content_include_tooltip'] = 'If you click here, this content will be added to the TARSUS Brain!';
$string['js_modal_content_exclude'] = 'Remove this content from the Brain.';
$string['js_modal_content_exclude_now'] = 'Remove content!';
$string['js_modal_content_exclude_tooltip'] = 'If you click here, this content will be removed from the TARSUS Brain!';
$string['js_modal_checkbox'] = 'Do you want to copy user data? (Eg. glossary/wiki/database entries)';
$string['js_modal_confirm_backup'] = 'Confirm';
$string['js_modal_confirm_delete'] = 'Delete';

// strings for the report comp_brain page.
$string['report_allbrains_brainname'] = 'Name of the brain';
$string['report_allbrains_brainid'] = 'BrainID';
$string['report_allbrains_braindescription'] = 'Description';
$string['report_allbrains_braincreationdate'] = 'Created on';
$string['report_allbrains_brainsize'] = 'Size of the brain';
$string['report_allbrains_create_new_brain'] = 'Create new brain';
$string['report_allbrains_brainaction'] = 'Action';
$string['report_allbrains_no_results'] = 'Sorry, no brains were found, or you do not have the necessary rights to see them.';
$string['report_allbrains_currenttoken'] = 'Your current token: ';
$string['report_allbrains_email_von_pascal'] = 'Email from Pascal: Creating a brain is extremely expensive and can generate thousands of euros in costs. Please only create one brain and work with it. In the future, it is planned that you will create a brain for each individual customer, because customers will pay for each brain.<br><br><i>Cheers Pascal Zoleko</i>';
$string['report_allbrains_brainservice'] = 'The service used';
$string['report_allbrains_braintype'] = 'Api Type';
$string['report_allbrains_braincredits'] = 'Credits';
$string['report_allbrains_braincount'] = 'Count';
$string['report_allbrains_brainstarttime'] = 'Report start time';
$string['report_allbrains_brainendtime'] = 'Report end time';

// strings for the report comp_brainquotas page.
$string['report_brainquotas_no_results'] = 'Sorry, no data usage statistics or brain quotas were found, or you do not have the necessary rights to see them.';

// Info for the different forms.
$string['form_edit_pagetitle_new'] = 'Create a new TARSUS Brain';
$string['form_edit_pagetitle_edit'] = 'Edit this TARSUS Brain';
$string['form_edit_brainid'] = 'TARSUS name of the brain';
$string['form_edit_brainid_help'] = 'This name connects the brain with the TARSUS API. It must be unique and cannot be changed';
$string['form_edit_brainname'] = 'Internal brain name from Lernlink';
$string['form_edit_brainname_help'] = 'You can choose this name freely and later adapt and change it as your client requires for the system`s multi-client capability';
$string['form_edit_braindescription'] = 'Internal description of the brain';
$string['form_edit_braindescription_help'] = 'Here is an area for some free text. You can leave further notes about the brain here.';

// Different buttons for the API call page. as a sandbox test.
$string['button_api_title_indexpage'] = 'Select the area to configure';
$string['button_api_call_featurebutton'] = 'Button to the next page';
$string['button_api_call_featurebutton_description'] = 'What can you set here';
$string['button_api_title_testarea'] = 'Test area with demo buttons';
$string['button_api_call_testbutton'] = 'API test button';
$string['button_api_call_resultarea'] = 'Results area';
$string['button_api_call_generateapitoken'] = 'Request API token';
$string['button_api_call_createbrain'] = 'Create Brain';
$string['button_api_call_createbrain_label'] = 'Enter new Brain name: ';
$string['button_api_call_deletebrain'] = 'Delete Brain';
$string['button_api_call_editbrain'] = 'Edit Brain';
$string['button_api_call_listbrain'] = 'Show all Brains';
$string['button_api_call_listbrainquota'] = 'Show Brain data usage';
$string['button_api_call_listclonevoices'] = 'Show all available voices';
$string['button_api_call_gethotkeywords'] = 'Get all hotkeywords';
$string['button_subpage_brains'] = 'Brains configuration';
$string['button_subpage_brains_description'] = 'Here you can view, configure, create and delete all Brains.';
$string['button_subpage_brainquotas'] = 'Brain Quotas overview';
$string['button_subpage_brainquotas_description'] = 'Here you can view and evaluate the usage statistics of the Brains.';
$string['button_subpage_curatedata'] = 'Curate content';
$string['button_subpage_curatedata_description'] = 'Here you can create, delete and curate content of the Brains.';
$string['button_subpage_none'] = 'There are no subpages available for you to configure. You probably do not have enough rights and must first adjust your role authorization.';

// strings class tarsus_brain.
$string['tarsus_brain_created'] = 'The TARSUS Brain {$a->brainid} was created successfully.';
$string['tarsus_brain_updated'] = 'The TARSUS Brain {$a->brainid} was updated successfully.';
$string['tarsus_brain_update_error'] = 'The TARSUS Brain {$a->brainid} could not be updated.';
$string['tarsus_brain_deleted'] = 'The TARSUS Brain {$a->brainid} was deleted successfully.';
$string['tarsus_brain_not_deleted'] = 'The TARSUS Brain {$a->brainid} could not be deleted.';
$string['except_dberror_delete_brain'] = 'Error: This BRAIN could not be deleted from the DB.';
$string['except_dberror_delete_trackedbit'] = 'Error: This tracked information BIT could not be deleted from the DB.';
$string['tarsus_track_element_created'] = 'The TARSUS Tracked Element of type {$a->bittype} with the ResourceID {$a->resourceid} was created successfully.';
$string['tarsus_track_element_deleted'] = 'The TARSUS Tracked Element of type {$a->bittype} with the ResourceID {$a->resourceid} was deleted successfully.';
$string['tarsus_track_element_not_deleted'] = 'The TARSUS Tracked Element of type {$a->bittype} with resource ID {$a->resourceid} could not be deleted.';

// strings for the explain comp_legend page.
$string['legend_comp_title'] = 'Legend for explanation';
$string['legend_comp_main'] = 'Main element';
$string['legend_comp_description'] = 'Description';
$string['legend_comp_noneavailable'] = 'Sorry, a legend is not available.';

// strings for the extended frontend settings page.
$string['setting_courseext_pagetitle'] = 'Course content in TARSUS Brain';
$string['setting_courseext_header'] = 'Add content of this course to TARSUS?';
$string['setting_courseext_description'] = 'In this area you can configure whether you want to add some or all of the activities and content of the course to the TARSUS Brain. If you only activate this function but do not yet run it, you can add each individual activity to the Brain individually on the main course page in edit mode or remove it from the Brain later.';
$string['setting_courseext_enable'] = 'Check the box to enable TARSUS indexing for this course.';
$string['setting_courseext_saved'] = 'The TARSUS settings for this course have been saved.';
$string['setting_courseext_addnow_title'] = 'Add ALL course content to TARSUS now?';
$string['setting_courseext_addnow_description'] = 'You can either add all available activities, documents and elements to TARSUS Brain now. Then press the button below. Or you can go back to the course page and individually add some special content or remove it from TARSUS.';
$string['setting_courseext_addnow_action'] = 'Add now!';

// strings for the settings page.
$string['setting_activate_component'] = 'Activate LAI component?';
$string['setting_activate_component_help'] = 'Do you want to activate the AI ​​component of LernLink? Then select the checkbox.';
$string['setting_activate_tasks'] = 'Activate LAI tasks?';
$string['setting_activate_tasks_help'] = 'Do you want to activate the tasks of the AI ​​component of LernLink? Then select the checkbox.';
$string['setting_current_api'] = 'Which API do you currently want to use?';
$string['setting_current_api_help'] = 'Select the API you currently want to use.';
$string['setting_chatgpt_apikey'] = 'API key for the chatGPT interface';
$string['setting_chatgpt_apikey_help'] = 'Enter your personal API key for the chatGPT interface here so that the system can receive data from chatGPT.';
$string['setting_chatgpt_apiurl'] = 'URL to the chatGPT API';
$string['setting_chatgpt_apiurl_help'] = 'Enter the general URL to the chatGPT API here so that the system can receive data from chatGPT.';
$string['setting_chatgpt_tab_title'] = 'chatGPT Settings';
$string['setting_chatgpt_title'] = 'Configuration for the chatGPT interface';
$string['setting_chatgpt_title_help'] = 'All settings for the chatGPT interface are made on this page';
$string['setting_claude_apikey'] = 'API key for the CLAUDE interface';
$string['setting_claude_apikey_help'] = 'Enter your personal API key for the CLAUDE interface here so that the system can receive data from CLAUDE.';
$string['setting_claude_apiurl'] = 'URL to the CLAUDE API';
$string['setting_claude_apiurl_help'] = 'Enter the general URL to the CLAUDE API here so that the system can receive data from CLAUDE.';
$string['setting_tarsus_apikey'] = 'API key for the TARSUS interface';
$string['setting_tarsus_apikey_help'] = 'Enter your personal API key for the TARSUS interface here so that the system can receive data from TARSUS.';
$string['setting_tarsus_apikey_generate'] = 'Request API key for TARSUS';
$string['setting_tarsus_apikey_generate_description'] = 'To use the TARSUS API, you must first request an API key. This must first be activated by TARSUS. This is a paid service from TARSUS';$string['setting_tarsus_apiurl'] = 'URL to the TARSUS API';
$string['setting_tarsus_apiurl_help'] = 'Enter the general URL to the TARSUS API here so that the system can receive data from TARSUS. The complete API description can be found at <a href="https://documenter.getpostman.com/view/23991933/2s9YJXYQT2" target="_blank">https://documenter.getpostman.com/view/23991933/2s9YJXYQT2</a>.';
$string['setting_general_tab_title'] = 'General configuration overviewht';
$string['setting_general_title'] = 'LAI Configuration Overview';
$string['setting_general_title_help'] = 'On this page you can change all necessary basic parameters of the plugin. For further settings please switch TABs. ';
$string['setting_general_title_url'] = 'You can also see the plugin homepage <a href="/local/lai_connector/index.php" target="_blank">here</a>: <a href="/local/lai_connector/index.php" target="_blank">/local/lai_connector/index.php</a>';
$string['setting_tarsus_tab_title'] = 'TARSUS Config';
$string['setting_tarsus_title'] = 'General TARSUS Configuration Overview';
$string['setting_tarsus_title_help'] = 'On this page, all settings for the main brain are made. Sie können auch auf der <a href="/local/lai_connector/index.php" target="_blank">Startseite des Plugins</a> weitere Einstellungen vornehmen. </a>';
$string['setting_tarsus_customer_name'] = 'The company name of the customer / user';
$string['setting_tarsus_customer_name_help'] = 'Enter the name of the customer / user used for the LAI system';
$string['setting_tarsus_customer_address'] = 'The company address of the customer / user';
$string['setting_tarsus_customer_address_help'] = 'Enter the company address of the customer / user used for the LAI system';
$string['setting_tarsus_customer_email'] = 'The email address of the customer / user';
$string['setting_tarsus_customer_email_help'] = 'Enter the email address of the customer / user used for the LAI system';
$string['setting_tarsus_brain_tab_title'] = 'TARSUS Brains';
$string['setting_tarsus_brain_title'] = 'Main and additional brains configuration overview';
$string['setting_tarsus_brain_title_help'] = 'On this page, all settings for the main brain and the subordinate brains are made';
$string['setting_tarsus_bits_tab_title'] = 'TARSUS BITS';
$string['setting_tarsus_bits_title'] = 'General TARSUS BITS configuration';
$string['setting_tarsus_bits_title_help'] = 'On this page, all settings for the BITS that we can read into TARSUS are made. You can also make further settings on the <a href="/local/lai_connector/index.php" target="_blank">home page of the plugin</a>. </a>';$string['setting_tasks_tab_title'] = 'Tasks';
$string['setting_tarsus_bits_usage'] = 'Which activities can be curated';
$string['setting_tarsus_bits_usage_help'] = 'Since we do not yet have a parser for all activities, the activity types that can be invited to the TARSUS Brain in the frontend can be activated here. The other activities do not get an ADD icon.';
$string['setting_tasks_title'] = 'Tasks and cronjobs configuration overview';
$string['setting_tasks_title_help'] = 'On this page, you configure the tasks and cronjobs required for the LAI system';

$string['abc'] = '';
$string['abc'] = '';
$string['abc'] = '';
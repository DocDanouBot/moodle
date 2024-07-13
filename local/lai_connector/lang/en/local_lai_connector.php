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

defined('MOODLE_INTERNAL') || the;

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

// Rights and Roles
$string['lai_connector:viewindexpage'] = 'Can visit the main page of the component ';
$string['lai_connector:viewbrainpage'] = 'Darf die Seite mit den Brains der Komponente besuchen ';
$string['lai_connector:viewbrainquotaspage'] = 'Darf die Seite mit den Brains Quotas besuchen.';
$string['lai_connector:viewcuratedatapage'] = 'Darf die Seite zum Kuratieren der Inhalte besuchen.';
$string['lai_connector:settingsview'] = 'Can see the settings of the component ';
$string['lai_connector:settingsmanage'] = 'Can change the settings of the component';
$string['lai_connector:brainadd'] = 'Can add a new brain ';
$string['lai_connector:braindelete'] = 'Can delete a specific brain';
$string['lai_connector:brainview'] = 'Can see the overview of all brains';
$string['lai_connector:assetadd'] = 'Darf weitere Assets und Ressource dem Brain hinzufügen';
$string['lai_connector:assetmydelete'] = 'Darf seine eigenen Assets und Ressource aus dem Brain löschen';
$string['lai_connector:assetdelete'] = 'Darf alle verfügbaren Assets und Ressource aus dem Brain löschen';

// Events and related texts:
$string['event_brain_created'] = 'Event: Ein Tarsus Brain wurde erstellt.';
$string['event_brain_updated'] = 'Event: Ein Tarsus Brain wurde aktualisiert.';
$string['event_brain_deleted'] = 'Event: Ein Tarsus Brain wurde gelöscht.';
$string['event_nugged_entry_created'] = 'Event: A single nugget was created.';
$string['event_nugged_entry_deleted'] = 'Event: A single nugget was deleted.';
$string['event_coursesettings_extended_updated'] = 'Event: Die erweiterten Kurseinstellungen zum TARSUS import wurden aktualisiert.';

// info for the main page.
$string['indexpage_title'] = 'LAI main page';
$string['brainpage_title'] = 'Hauptseite für Brains';
$string['brainpage_description'] = 'Hier finden sie alle Brains';
$string['brainquotaspage_title'] = 'Übersicht über Brain Quotas';
$string['brainquotaspage_description'] = 'Hier finden sie alle Informationen zu den Nutzungen der Brains';
$string['curatedatapage_title'] = 'Inhalte kuratieren';
$string['curatedatapage_description'] = 'Hauptseite für das Kuratieren von Inhalten';

// Info for the frontend. Edit Menu in the Course overview.
$string['frontend_cm_tarsus_status'] = 'Der Tarsus status von diesem Element';
$string['frontend_cm_tarsus_status_submitted'] = 'Dieses Element wurde dem Brain bereits hinzugefügt';
$string['frontend_cm_tarsus_status_submit'] = 'Dieses Element dem Brain jetzt hinzufügen';
$string['frontend_cm_tarsus_status_delete'] = 'Dieses Element aus dem Brain löschen';
$string['frontend_cm_tarsus_status_norights'] = 'Sie haben nicht das Recht, diesen Status zu ändern.';

// strings for the report comp_brain page.
$string['report_allbrains_brainname'] = 'Name of the brain';
$string['report_allbrains_brainid'] = 'BrainID';
$string['report_allbrains_braindescription'] = 'Beschreibung';
$string['report_allbrains_braincreationdate'] = 'Created on';
$string['report_allbrains_brainsize'] = 'Size of the brain';
$string['report_allbrains_create_new_brain'] = 'Neues Brain anlegen';
$string['report_allbrains_brainaction'] = 'Action';
$string['report_allbrains_no_results'] = 'Sorry, no brains were found, or you do not have the necessary rights to see them.';
$string['report_allbrains_currenttoken'] = 'Ihr aktueller Token: ';
$string['report_allbrains_email_von_pascal'] = 'Email von Pascal: Die Erstellung eines Brains kostet extrem viel Geld und kann tausende von Euros an Kosten erzeugen. Bitte nur ein Brain erzeugen und damit arbeiten. In der Zukunft ist es gedacht, dass ihr für jeden einzelnen Kunden ein Brain erzeugt, denn die Kunden werden für jedes Brain zahlen.<br><br><i>Cheers Pascal Zoleko</i>';

// strings for the report comp_brainquotas page.
$string['report_brainquotas_no_results'] = 'Entschuldigung, es wurden keine Datennutzungsstatistiken oder Brainsquotas gefunden, oder sie haben nicht die nötigen Rechte diese zu sehen.';

// Info for the different forms.
$string['form_edit_pagetitle_new'] = 'Ein neues TARSUS Brain anlegen';
$string['form_edit_pagetitle_edit'] = 'Dieses TARSUS Brain bearbeiten';
$string['form_edit_brainid'] = 'TARSUS Name des Brain';
$string['form_edit_brainid_help'] = 'Dieser Name verbindet das Brain mit der API von TARSUS. Er muss unique sein und darf nicht geändert werden';
$string['form_edit_brainname'] = 'Interner Brain-name von Lernlink';
$string['form_edit_brainname_help'] = 'Diesen Namen können Sie frei wählen und später auch anpassen und verändern, ganz wie es Ihr Mandant für die Mandantenfähigkeit des Systems benötigt';
$string['form_edit_braindescription'] = 'Interne Beschreibung des Brains';
$string['form_edit_braindescription_help'] = 'Hier ist ein Bereich für einigen Freitext. Sie können hier weitere Notizen zum Brain hinterlassen.';

// Different buttons for the API call page. as a sandbox test.
$string['button_api_title_indexpage'] = 'Wähle den Bereich zum Konfigurieren';
$string['button_api_call_featurebutton'] = 'Knopf zur nächsten Seite';
$string['button_api_call_featurebutton_description'] = 'Was können Sie hier einstellen';
$string['button_api_title_testarea'] = 'Testbereich mit Demoknöpfen';
$string['button_api_call_testbutton'] = 'API Testknopf';
$string['button_api_call_resultarea'] = 'Ergebnisbereich';
$string['button_api_call_generateapitoken'] = 'Beantrage API Token';
$string['button_api_call_createbrain'] = 'Erstelle Brain';
$string['button_api_call_createbrain_label'] = 'Neuen Brainnamen eingeben: ';
$string['button_api_call_deletebrain'] = 'Lösche Brain';
$string['button_api_call_editbrain'] = 'Brain bearbeiten';
$string['button_api_call_listbrain'] = 'Zeige alle Brains';
$string['button_api_call_listbrainquota'] = 'Zeige Brain Datenverbrauch';
$string['button_api_call_listclonevoices'] = 'Zeige alle verfügbaren Stimmen';
$string['button_api_call_gethotkeywords'] = 'Hole alle vielbenutzten Schlagworte';
$string['button_subpage_brains'] = 'Brains Konfiguration';
$string['button_subpage_brains_description'] = 'Hier können sie alle Brains einsehen, konfigurieren, anlegen und löschen.';
$string['button_subpage_brainquotas'] = 'Brain Quotas Übersicht';
$string['button_subpage_brainquotas_description'] = 'Hier können Sie die Nutzungsstatistiken der Brains einsehen und evaluieren.';
$string['button_subpage_curatedata'] = 'Inhalte kuratieren';
$string['button_subpage_curatedata_description'] = 'Hier können sie Inhalte der Brains, anlegen, löschen und kuratieren.';
$string['button_subpage_none'] = 'Es stehen Ihnen keine Unterseiten zum Konfigurieren zur Verfügung. Wahrscheinlich haben sie nicht genügend Rechte und müssen erst Ihre Rollenberechtigung anpassen.';

// strings class tarsus_brain.
$string['tarsus_brain_created'] = 'Das TARSUS Brain {$a->brainid} wurde erfolgreich erstellt.';
$string['tarsus_brain_updated'] = 'Das TARSUS Brain {$a->brainid} wurde erfolgreich aktualisiert.';
$string['tarsus_brain_update_error'] = 'Das TARSUS Brain {$a->brainid} konnte nicht aktualisiert werden.';
$string['tarsus_brain_deleted'] = 'Das TARSUS Brain {$a->brainid} wurde erfolgreich gelöscht.';
$string['tarsus_brain_not_deleted'] = 'Das TARSUS Brain {$a->brainid} konnte nicht gelöscht werden.';
$string['except_dberror_delete_brain'] = 'Fehler: Dieses BRAIN konnte nicht aus der DB gelöscht werden.';

// strings for the explain comp_legend page.
$string['legend_comp_title'] = 'Legend for explanation';
$string['legend_comp_main'] = 'Main element';
$string['legend_comp_description'] = 'Description';
$string['legend_comp_noneavailable'] = 'Sorry, a legend is not available.';

// strings for the extended frontend settings page.
$string['setting_courseext_pagetitle'] = 'Kursinhalte ins TARSUS Brain';
$string['setting_courseext_header'] = 'Inhalte dieses Kurses zu TARSUS hinzufügen?';
$string['setting_courseext_description'] = 'In diesem Bereich können sie konfigurieren, ob sie dem TARSUS Brain einige oder alle Aktivitäten und Inhalte des Kurses hinzufügen wollen. Wenn sie diese Funktion nur aktivieren, aber noch nicht ausführen, können sie auf der Haupt Kursseite im Bearbeitungsmodus jede einzelne Aktivität individuell dem Brain hinzufügen oder aus dem Brain später wieder entfernen.';
$string['setting_courseext_enable'] = 'Checkbox aktivieren, um die TARSUS indizierung für diesen Kurs zu aktivieren.';
$string['setting_courseext_saved'] = 'Die TARSUS-Einstellungen dieses Kurses wurden gespeichert.';
$string['setting_courseext_addnow_title'] = 'Jetzt ALLE Kursinhaltes zu TARSUS hinzufügen?';
$string['setting_courseext_addnow_description'] = 'Sie können entweder jetzt alle verfügbaren Aktivitäten, Dokumente und Elemente ins TARSUS Brain hinzufügen. Dann drücken sie untenstehnden Knopf. Oder Sie gehen zurück zur Kursseite und können dort individuell einige spezielle Inhalte hinzufügen oder auch wieder von TARSUS entfernen.';
$string['setting_courseext_addnow_action'] = 'Jetzt hinzufügen!';

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
$string['setting_tarsus_apikey_generate'] = 'Beantrage API Key für TARSUS';
$string['setting_tarsus_apikey_generate_description'] = 'Um die API von TARSUS benutzen zu können, müssen sie erst einen API Key beantragen. Dieser muss erst von TARSUS freigeschaltet werden. Dies ist eine kostenpflichtige Dienstleistung von TARSUS';
$string['setting_tarsus_apiurl'] = 'URL to the TARSUS API';
$string['setting_tarsus_apiurl_help'] = 'Enter the general URL to the TARSUS API here so that the system can receive data from TARSUS. The complete API description can be found at <a href="https://documenter.getpostman.com/view/23991933/2s9YJXYQT2" target="_blank">https://documenter.getpostman.com/view/23991933/2s9YJXYQT2</a>.';
$string['setting_general_tab_title'] = 'General configuration overviewht';
$string['setting_general_title'] = 'LAI Configuration Overview';
$string['setting_general_title_help'] = 'On this page you can change all necessary basic parameters of the plugin. For further settings please switch TABs. ';
$string['setting_general_title_url'] = 'You can also see the plugin homepage <a href="/local/lai_connector/index.php" target="_blank">here</a>: <a href="/local/lai_connector/index.php" target="_blank">/local/lai_connector/index.php</a>';
$string['setting_tarsus_tab_title'] = 'TARSUS Config';
$string['setting_tarsus_title'] = 'General TARSUS Configuration Overview';
$string['setting_tarsus_title_help'] = 'On this page, all settings for the main brain are made';
$string['setting_tarsus_customer_name'] = 'The company name of the customer / user';
$string['setting_tarsus_customer_name_help'] = 'Enter the name of the customer / user used for the LAI system';
$string['setting_tarsus_customer_address'] = 'The company address of the customer / user';
$string['setting_tarsus_customer_address_help'] = 'Enter the company address of the customer / user used for the LAI system';
$string['setting_tarsus_customer_email'] = 'The email address of the customer / user';
$string['setting_tarsus_customer_email_help'] = 'Enter the email address of the customer / user used for the LAI system';
$string['setting_tarsus_brain_tab_title'] = 'TARSUS Brains';
$string['setting_tarsus_brain_title'] = 'Main and additional brains configuration overview';
$string['setting_tarsus_brain_title_help'] = 'On this page, all settings for the main brain and the subordinate brains are made';
$string['setting_tasks_tab_title'] = 'Tasks';
$string['setting_tasks_title'] = 'Tasks and cronjobs configuration overview';
$string['setting_tasks_title_help'] = 'On this page, you configure the tasks and cronjobs required for the LAI system';

$string['abc'] = '';
$string['abc'] = '';
$string['abc'] = '';
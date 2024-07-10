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

/** Deutsche Sprachdatei
 *
 * @package     local_lai_connector
 * @copyright   lern.link GmbH
 * @author      Danou Nauck
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

$string['pluginname'] = 'LernLink AI Connector';
$string['pluginname_admin'] = 'LernLink AI Connector Verwaltung';
$string['privacy:metadata'] = 'Die Komponente LernLink AI Connector speichert keine personenbezogenen Daten';

// info for the main menu navigation.
$string['link_mainmenu_index'] = 'LAI Hauptseite';
$string['link_mainmenu_coursesettings'] = 'Kurs zu TARSUS hinzufügen';

// Texts for the general AI Connector interface.
$string['aic_mainpage'] = 'AI Connector Modular interface';
$string['aic_current_api'] = 'Aktuell aktivierte KI: ';
$string['aic_current_url'] = 'Aktuelle URL: ';
$string['aic_current_key'] = 'Aktueller Key: ';

// Texts for the API connecting to chatGPT.
$string['api_chatgpt_mainname'] = 'chatGPT';

// Texts for the API connecting to CLAUDE.
$string['api_claude_mainname'] = 'CLAUDE3';

// Texts for the API connecting to TARSUS.
$string['api_tarsus_mainname'] = 'TARSUS';

// Rights and Roles
$string['lai_connector:viewindexpage'] = 'Darf die Hauptseite der Komponente besuchen ';
$string['lai_connector:settingsview'] = 'Darf die Einstellungen der Komponente sehen ';
$string['lai_connector:settingsmanage'] = 'Darf die Einstellungen der Komponente ändern';
$string['lai_connector:brainadd'] = 'Darf ein neues Brain hinzufügen ';
$string['lai_connector:braindelete'] = 'Darf ein bestimmtes Brain löschen ';
$string['lai_connector:brainview'] = 'Darf die Übersicht über alle Brains sehen';
$string['lai_connector:assetadd'] = 'Darf weitere Assets und Ressource dem Brain hinzufügen';
$string['lai_connector:assetmydelete'] = 'Darf seine eigenen Assets und Ressource aus dem Brain löschen';
$string['lai_connector:assetdelete'] = 'Darf alle verfügbaren Assets und Ressource aus dem Brain löschen';

// Events and related texts:
$string['event_nugged_entry_created'] = 'Event: Ein einzelner Nugget wurde erstellt.';
$string['event_nugged_entry_deleted'] = 'Event: Ein einzelner Nugget wurde gelöscht.';
$string['event_coursesettings_extended_updated'] = 'Event: Die erweiterten Kurseinstellungen zum TARSUS import wurden aktualisiert.';

// info for the main page.
$string['indexpage_title'] = 'LAI Hauptseite';
$string['indexpage_subbrains_title'] = 'Hauptseite für Subbrains';
$string['indexpage_subbrains_info'] = 'Hier finden sie alle Unterbrains';

// strings for the report comp_brain page.
$string['report_allbrains_brainname'] = 'Name des Brains';
$string['report_allbrains_brainid'] = 'BrainID';
$string['report_allbrains_braincreationdate'] = 'Erstellt am';
$string['report_allbrains_brainsize'] = 'Größe des Brains';
$string['report_allbrains_no_results'] = 'Entschuldigung, Es wurden keine Brains gefunden, oder sie haben nicht die nötigen Rechte diese zu sehen.';

// strings for the explain comp_legend page.
$string['legend_comp_title'] = 'Legende zur Erklärung';
$string['legend_comp_main'] = 'Hauptelement';
$string['legend_comp_description'] = 'Beschreibung';
$string['legend_comp_noneavailable'] = 'Tschuldigung, eine Legende ist nicht verfügbar.';

// strings for the extended frontend settings page.
$string['setting_courseext_pagetitle'] = 'Kursinhalteins TARSUS Brain';
$string['setting_courseext_header'] = 'Inhalte dieses Kurses zu TARSUS hinzufügen?';
$string['setting_courseext_description'] = 'In diesem Bereich können sie konfigurieren, ob sie dem TARSUS Brain einige oder alle Aktivitäten und Inhalte des Kurses hinzufügen wollen. Wenn sie diese Funktion nur aktivieren, aber noch nicht ausführen, können sie auf der Haupt Kursseite im Bearbeitungsmodus jede einzelne Aktivität individuell dem Brain hinzufügen oder aus dem Brain später wieder entfernen.';

// strings for the Backend settings page.
$string['setting_activate_component'] = 'Aktiviere LAI Komponente?';
$string['setting_activate_component_help'] = 'Wollen sie die KI Komponente von LernLink aktivieren. Dann wählen Sie die Checkbox.';
$string['setting_activate_tasks'] = 'Aktiviere LAI Tasks?';
$string['setting_activate_tasks_help'] = 'Wollen sie die Tasks der KI Komponente von LernLink aktivieren. Dann wählen Sie die Checkbox.';
$string['setting_current_api'] = 'Welche API wollen Sie derzeit nutzen';
$string['setting_current_api_help'] = 'Wählen Sie die API aus, die sie akutell benutzen wollen.';
$string['setting_chatgpt_apikey'] = 'API Key für die chatGPT Schnittstelle';
$string['setting_chatgpt_apikey_help'] = 'Tragen Sie hier Ihren persönlichen API Key für die chatGPT Schnittstelle ein, damit das System von chatGPT Daten empfangen kann.';
$string['setting_chatgpt_apiurl'] = 'URL zu der chatGPT API';
$string['setting_chatgpt_apiurl_help'] = 'Tragen Sie hier die allgemeine URL zur chatGPT API ein, damit das System von chatGPT Daten empfangen kann.';
$string['setting_chatgpt_tab_title'] = 'chatGPT Settings';
$string['setting_chatgpt_title'] = 'Konfiguration für das chatGPT-Interface';
$string['setting_chatgpt_title_help'] = 'Auf dieser Seite werden alle Einstellungen zu dem chatGPT Interface vorgenommen';
$string['setting_claude_apikey'] = 'API Key für die CLAUDE Schnittstelle';
$string['setting_claude_apikey_help'] = 'Tragen Sie hier Ihren persönlichen API Key für die CLAUDE Schnittstelle ein, damit das System von CLAUDE Daten empfangen kann.';
$string['setting_claude_apiurl'] = 'URL zu der CLAUDE API';
$string['setting_claude_apiurl_help'] = 'Tragen Sie hier die allgemeine URL zur CLAUDE API ein, damit das System von CLAUDE Daten empfangen kann.';
$string['setting_tarsus_apikey'] = 'API Key für die TARSUS Schnittstelle';
$string['setting_tarsus_apikey_help'] = 'Tragen Sie hier Ihren persönlichen API Key für die TARSUS Schnittstelle ein, damit das System von TARSUS Daten empfangen kann.';
$string['setting_tarsus_apiurl'] = 'URL zu der TARSUS API';
$string['setting_tarsus_apiurl_help'] = 'Tragen Sie hier die allgemeine URL zur TARSUS API ein, damit das System von TARSUS Daten empfangen kann. Die komplette API Beschreibung findet sich unter <a href="https://documenter.getpostman.com/view/23991933/2s9YJXYQT2" target="_blank">https://documenter.getpostman.com/view/23991933/2s9YJXYQT2</a>.';
$string['setting_general_tab_title'] = 'Allgemeine Konfigurationsübersicht';
$string['setting_general_title'] = 'LAI Konfigurationsübersicht';
$string['setting_general_title_help'] = 'Auf dieser Seite können Sie alle notwendigen grundlegenden Parameter des Plugins ändern. Für weitere Einstellungen wechseln Sie bitte die TABs. ';
$string['setting_general_title_url'] = 'Sie können auch die Startseite des Plugins <a href="/local/lai_connector/index.php" target="_blank">hier</a> sehen: <a href="/local/lai_connector/index.php" target="_blank">/local/lai_connector/index.php</a>';
$string['setting_tarsus_tab_title'] = 'TARSUS Konfig';
$string['setting_tarsus_title'] = 'Allgemeine TARSUS Konfigurationsübersicht';
$string['setting_tarsus_title_help'] = 'Auf dieser Seite werden alle Einstellungen zu dem Interface von TARSUS vorgenommen';
$string['setting_tarsus_customer_name'] = 'Der Firmenname des Kunden / Anwenders';
$string['setting_tarsus_customer_name_help'] = 'Tragen Sie hier den Namen des Kunden / Anwenders ein, der für das LAI-System verwendet wird';
$string['setting_tarsus_customer_address'] = 'Die Firmenanschrift des Kunden / Anwenders';
$string['setting_tarsus_customer_address_help'] = 'Tragen Sie hier die Firmenanschrift des Kunden / Anwenders ein, der für das LAI-System verwendet wird';
$string['setting_tarsus_customer_email'] = 'Die E-Mail-Adresse des Kunden / Anwenders';
$string['setting_tarsus_customer_email_help'] = 'Tragen Sie hier die E-Mail-Adresse des Kunden / Anwenders ein, der für das LAI-System verwendet wird';
$string['setting_tarsus_brain_tab_title'] = 'TARSUS Brains';
$string['setting_tarsus_brain_title'] = 'Haupt- und zusätzliche Brains Konfigurationsübersicht';
$string['setting_tarsus_brain_title_help'] = 'Auf dieser Seite werden alle Einstellungen zum Hauptbrain und zu dem untergeordneten Wissesnständen vorgenommen';
$string['setting_tasks_tab_title'] = 'Tasks';
$string['setting_tasks_title'] = 'Tasks und Cronjobs Konfigurationsübersicht';
$string['setting_tasks_title_help'] = 'Auf dieser Seite konfigurieren Sie die Tasks und Cronjobs, die für das LAI-System benötigt werden';

$string['abc'] = '';
$string['abc'] = '';
$string['abc'] = '';



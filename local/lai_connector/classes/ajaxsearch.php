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

global $OUTPUT, $CFG, $PAGE, $SESSION, $DB, $USER, $FULLME;

require_once( __DIR__ . "/../../../config.php");
defined('MOODLE_INTERNAL') or die('Direct access to this script is forbidden.');


/**
 * Loads the data required to search the VR Rooms dynamically
 *
 * @param int $searchstring The course id to check.
 * @return data
 */
$gradethreshold = optional_param('grade', 0, PARAM_INT);
$plagiatthreshold = optional_param('plagiat', 0, PARAM_INT);
$lastmonths = optional_param('months', 3, PARAM_INT);
$cleanrecords = array();

require_login(0, false);
$PAGE->set_context(context_system::instance());

# echo("<br><br><br>AJAX lastmonths<pre>");
# print_r( $lastmonths);
# echo("</pre>");

# Get all rooms from all facilities
$cleanrecords = \local_lai_connector\util::get_lazy_student_data($lastmonths);

# echo json_encode($cleanrecords);


$returnhtml = "";
# Build the header
$returnhtml .= "<div class='lazystudentheader'>";
$returnhtml .= "<div class='studentname'>" .get_string('report_lazystudent_studentname', 'local_lai_connector'). "</div>";
$returnhtml .= "<div class='studentwork'>" .get_string('report_lazystudent_studentwork', 'local_lai_connector'). "</div>";
$returnhtml .= "<div class='studentgrade'>" .get_string('report_lazystudent_studentgrade', 'local_lai_connector'). "</div>";
$returnhtml .= "<div class='studentplagiat'>" .get_string('report_lazystudent_studentplagiat', 'local_lai_connector'). "</div>";
$returnhtml .= "</div>";

if (sizeof($cleanrecords) < 1) {
    $returnhtml .= "<div class='notfound'>";
    $returnhtml .= "<strong>".get_string('report_lazystudent_not_found', 'local_lai_connector')."</strong>";
    $returnhtml .= "</div>";
} else {
    foreach ($cleanrecords as $index => $cleanrecord) {
        if ($index == 'fromtimestamp') {
            $temphtml = "<div id='infoblock'><div class='dateblock'>".get_string('report_lazystudent_starttime', 'local_lai_connector').": ".date('d.m.Y',$cleanrecord) . "</div><div class='spacer'></div>";
            $temphtml .= "<div class='studentblock'>".get_string('report_lazystudent_studentamount', 'local_lai_connector').": &nbsp; <div id='numberofstudents'></div></div></div>";
            $returnhtml = $temphtml . $returnhtml;
        } else {
            $benotungsentwurfCSS = null;
            $verylowCSS = null;
            if (($cleanrecord->tiis_grade == '--')) {
                # Wir haben nur "--" also einen Benotungsentwurf dort stehen
                $benotungsentwurfCSS = ' benotungsentwurf';
            }

            # Check if the user has less than half of the nessessary score in Grades
            if ($cleanrecord->tiis_grade < ($gradethreshold / 2)) {
                # Wir haben nur "--" also einen Benotungsentwurf dort stehen
                $verylowCSS = \local_iubh_generic\definitions::IU_TURNITIN_REPORTS['INFOCLASS_LOWGRADE'];
                if ($cleanrecord->tiis_plagiat > ((100 - $plagiatthreshold) / 2) + $plagiatthreshold) {
                    # Check if the user has less than half of the nessessary score
                    # also in plagiat
                    $verylowCSS = \local_iubh_generic\definitions::IU_TURNITIN_REPORTS['INFOCLASS_LASTTRY'];
                }
            }

            if ($cleanrecord->tiis_plagiat > ((100 - $plagiatthreshold) / 2) + $plagiatthreshold) {
                # Wir haben nur "--" also einen Benotungsentwurf dort stehen
                $verylowCSS = \local_iubh_generic\definitions::IU_TURNITIN_REPORTS['INFOCLASS_HIGHPLAGIAT'];
                if ($cleanrecord->tiis_grade < ($gradethreshold / 2)) {
                    $verylowCSS = \local_iubh_generic\definitions::IU_TURNITIN_REPORTS['INFOCLASS_LASTTRY'];
                }
            }

            $returnhtml .= "<div class='lazystudent ".$verylowCSS."'";
            if (is_int((int)$cleanrecord->tiis_plagiat)) {
                $returnhtml .= " data-plagiat='" . $cleanrecord->tiis_plagiat . "'";
            }
            if (is_int((int)$cleanrecord->tiis_grade)) {
                $returnhtml .= " data-grade='" . $cleanrecord->tiis_grade . "'";
            }
            $returnhtml .= ">";

            # Name des Studenten
            $returnhtml .= "<div class='studentname ".$benotungsentwurfCSS."'>";
            $studenturl = new \moodle_url('/user/profile.php', array('id' => $cleanrecord->user_id));
            $returnhtml .= "<a href=" . $studenturl . " target='_blank' title=Profil von " . $cleanrecord->user_firstname . " " . $cleanrecord->user_lastname . " in neuem Fenster öffnen'>";
            $returnhtml .= $cleanrecord->user_firstname . " " . $cleanrecord->user_lastname . "</a>";
            $returnhtml .= "</div>";

            # eingereichte Arbeit des Studenten
            $returnhtml .= "<div class='studentwork".$benotungsentwurfCSS."'>";
            # Ins Prüfungscenter.
            # $documenturl = "https://ev.turnitin.com/app/carta/de/?o=" . $cleanrecord->tiis_id . "&lang=de";
            $documenturl = new \moodle_url('/mod/turnitintooltwo/view.php', array('id' => $cleanrecord->activity_link));
            $returnhtml .= "<a href='" . $documenturl . "' target='_blank' title='" . get_string('table_header_visit_student_document', 'block_iu_tutor_tasks') . ": ".$cleanrecord->tiis_title."'>";

            $dokumententitle = (strlen($cleanrecord->tiis_title) > 40) ? (substr($cleanrecord->tiis_title, 0 ,40) . "..."): $cleanrecord->tiis_title;
            $returnhtml .= $dokumententitle . "</a>";
            $returnhtml .= "</div>";

            # Note des Studenten
            $returnhtml .= "<div class='studentgrade'>";
            $returnhtml .= "Note " . \local_lai_connector\util::calculate_grade_from_score($cleanrecord->tiis_grade) . " (" . $cleanrecord->tiis_grade . " Punkte)";
            $returnhtml .= "</div>";

            # Plagiat des Studenten
            $returnhtml .= "<div class='studentplagiat'>";
            $returnhtml .= $cleanrecord->tiis_plagiat;
            $returnhtml .= "</div>";

            $returnhtml .= "</div>";
        }
    }
}

# echo json_encode($returnhtml);

echo $returnhtml;
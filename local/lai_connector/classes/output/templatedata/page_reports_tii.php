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
 * Report page turnitin report.
 *
 * @package    local_iubh_turnitin
 * @author     Danou Nauck <Danou@Nauck.eu>
 * @copyright  Nauck IT Consulting 2020
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


namespace local_iubh_turnitin\output\templatedata;

defined('MOODLE_INTERNAL') || die();

use mod_h5pactivity\output\result\truefalse;
use templatable;
use renderer_base;
use moodle_url;
use local_iubh_generic\course_extended;


/**
 * Class to prepare template data
 *
 */
class page_reports_tii implements templatable {

    /** @var \object $content The block content object. */
    protected $content;

    /**
     * Constructor
     */
    public function __construct($data) {
        $data->legend = \local_iubh_generic\course_extended::generate_tii_legend_data();
        $this->content = $data;
    }

    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @param renderer_base $output The base renderer object
     *
     * @return object
     */
    public function export_for_template(renderer_base $output) {
        global $DB;
        $content = $this->content;
        $cleantiicourses = array();
        $showNoLinks = false;

        // Only proceed, if there are any sets of data
        if (!empty($content->tiicourses) && (sizeof($content->tiicourses) >= 1)) {

            if (sizeof($content->tiicourses) == 1) {
                $showNoLinks = true;
            }
            if (isset($content->selected_pf))  {
                # We selected a PF before, so we need to add stuph to the links
                $courseInPF = $content->selected_pf;
            } else {
                $courseInPF = null;
            }

            foreach ($content->tiicourses as $course) {

                #echo("page_reports_tii.php function export_for_template course<pre>");
                #print_r($course);
                #echo("</pre>");

                $courseurl = new moodle_url('/course/view.php', array('id' => $course->id));

                $courseurldetailview = new moodle_url('/local/iubh_turnitin/show_iubh_turnitin_reports.php', array('selected_course' => $course->id, 'course_in_pf' => $courseInPF));

                $obj = [
                    'courseid'               => $course->id,
                    'coursename'             => $course->fullname,
                    'courseshortname'        => $course->shortname,
                    'courseurl'              => $courseurl,
                    'coursedetailurl'        => $courseurldetailview,
                    'startdate'              => date('d.m.Y h:m:s', $course->startdate),
                    'turnitinelements'       => $course->turnitin_amount,
                    'participants'           => $course->participants_amount,
                    'participants_handed_in' => $course->turnitin_amount_handed_in,
                    'parentclass'            => '',
                ];
                if ($showNoLinks) {
                    $obj['shownolinks']      = true;
                }


                if (isset($course->vlo_groups_with_user_grades) && isset($course->vlo_groups_with_user_grades->activities)  && sizeof($course->vlo_groups_with_user_grades->activities)>0) {
                    $obj['parentclass'] = 'parent';
                    $course->vlo_groups_with_user_grades->parentclass_tii = 'parent_tii';
                    $obj['activities'] = $course->vlo_groups_with_user_grades->activities;

                    if (isset($course->vlo_groups_with_user_grades->vlrs)) {
                        $course->vlo_groups_with_user_grades->parentclass_vlr = 'parent_vlr';
                        $obj['vlrs'] = $course->vlo_groups_with_user_grades->vlrs;
                    }

                }

                $cleantiicourses[] = $obj;

            }
        }


        $content->cleantiicourses = $cleantiicourses;

        # echo("cleantiicourses<pre>");
        # print_r($cleantiicourses);
        # echo("</pre>");

        return $content;
    }
}

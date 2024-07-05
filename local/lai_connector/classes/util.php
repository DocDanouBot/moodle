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
 * @package   local_iubh_turnitin
 * @copyright 2020 Danou Nauck <Danou@Nauck.eu>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_lai_connector;
defined('MOODLE_INTERNAL') || die();

global $CFG;

use pix_icon;
use stdClass;
use moodle_url;

class util
{


    /** Getting all the courses that have TII elements
     * and limit them by min ./. max values
     * @param
     * @return mixed
     * @throws \dml_exception
     */
    public static function get_cached_tii_course_ids()
    {
        global $DB;
        $cache = \cache::make('local_iubh_turnitin', 'tiicourses');
        $cache_key = "tiicourse-ids";
        $cache_data = $cache->get($cache_key);
        if ($cache_data !== false) {
            # echo("<br><br><h3>Show existing TII Course IDs from cache</h3>");
            # echo("<br>tiicourseidsarray<pre>");
            # print_r($cache_data['turnitin-tiicourse-ids']);
            # echo("</pre>");
            return $cache_data['turnitin-tiicourse-ids'];
        } else {
            # echo("<br><br><h3>Building new array of TII Course IDs</h3>");
            $tiicourseidsarray = array();
            $params['sectionid'] = 0;
            $sql = "
                SELECT DISTINCT tii.course as id
                           FROM {turnitintooltwo} tii
                       ORDER BY id ASC";
            $courses = $DB->get_records_sql($sql, $params);
            foreach ($courses as $onecourse) {
                $course_ext = \local_iubh_generic\course_extended::get_instance($onecourse->id);

                # take all course ids to cache them into memory
                $course_obj = new \stdClass();
                $course_obj->id = $course_ext->id;
                $course_obj->fullname = $course_ext->fullname;
                $course_obj->shortname = $course_ext->shortname;
                $course_obj->startdate = $course_ext->startdate;
                $course_obj->category = $course_ext->category;
                $course_obj->pfs = $course_ext->get_pfs();
                $course_obj->turnitin_amount = $course_ext->get_turnitin_amount() ;
                $course_obj->participants_amount = $course_ext->get_participants_amount() ;
                $course_obj->turnitin_amount_handed_in = $course_ext->get_turnitin_amount_handed_in(false);

                #$course_obj->vlo_groups_with_user_grades = $course_ext->get_vlo_groups_with_user_grades(false, false);

                $tiicourseidsarray[$course_ext->id] = $course_obj;
            }

            usort($tiicourseidsarray, function($a, $b) {return strcmp($a->fullname, $b->fullname); });
            # echo("<br><br><h3>Rebuild cache for TII Course IDs</h3>");
            #echo("<br>tiicourseidsarray<pre>");
            #print_r($tiicourseidsarray);
            #echo("</pre>");
            $cache->set($cache_key, array('turnitin-tiicourse-ids' => $tiicourseidsarray));
            return $tiicourseidsarray;
        }
    }

    /** We need for an ajax request a bunch of information on bad students
     *
     */
    public static function get_lazy_student_data($amountofmonth) {
        global $DB;
        $fromtimestamp = time() - ($amountofmonth * \local_iubh_generic\definitions::IU_TIME_CONSTANTS['SECONDS_PER_MONTH']);
        $params['fromtime'] = $fromtimestamp;

        # Get the amount only from the currently published CM Table within the course
        $sql = "SELECT tiis.id AS tiis_id, 
                       tiis.submission_objectid AS tiis_objectid,
                       IFNULL (tiis.submission_grade, '--') AS tiis_grade,
                       tiis.submission_modified AS tiis_modified,
                       IFNULL (tiis.submission_score,'--') AS tiis_plagiat,
                       tiis.submission_title AS tiis_title,
                       tiis.submission_attempts AS tiis_student_read_date,
                       tiis.userid AS user_id,
                       tiis.turnitintooltwoid AS tiiid,
                       u.firstname AS user_firstname,
                       u.lastname AS user_lastname,
                       u.idnumber AS user_idnumber,
                       cm.id AS activity_link,
                       tii.course AS course_id
                  FROM {turnitintooltwo_submissions} tiis
                  JOIN {user} u ON u.id = tiis.userid
                  JOIN {course_modules} cm ON cm.instance = tiis.turnitintooltwoid
                  JOIN {turnitintooltwo} tii ON tii.id = tiis.turnitintooltwoid
                 WHERE tiis.submission_modified >= :fromtime
                   AND tiis.submission_score != '--'
                   AND tiis.submission_grade != '--'
                   AND cm.module = 27
                   AND cm.course = tii.course
                      ";

        $alldata =  $DB->get_records_sql($sql, $params);
        $alldata['fromtimestamp'] = $fromtimestamp;
        /**
         *     [120921] => stdClass Object
        (
        [tiis_id] => 120921
        [tiis_objectid] => 1635246089
        [tiis_grade] => 79
        [tiis_modified] => 1629803804
        [tiis_plagiat] => 94
        [tiis_title] => Erfurt-10190075-Völker
        [tiis_student_read_date] => 0
        [user_id] => 38878
        [user_firstname] => Marie Kristin
        [user_lastname] => Hopf
        [user_idnumber] => 10142562
        )
         */

        return $alldata;
    }


}

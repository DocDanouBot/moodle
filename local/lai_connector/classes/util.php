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

namespace local_lai_connector;
defined('MOODLE_INTERNAL') || die();

global $CFG;

use pix_icon;
use stdClass;
use moodle_url;

class util
{

    /** Check if the menu should be displayed at all
     * @param
     * @return mixed
     * @throws \dml_exception
     */
    public static function show_lai_menu() {
        global $CFG;

        $returnboolean = ((has_capability('local/lai_connector:viewindexpage', \context_system::instance())
                && (isset($CFG->local_lai_connector_activate_component) &&
                    $CFG->local_lai_connector_activate_component == 1)) ||
            false);
        return $returnboolean;
    }

    /** Getting all the courses that have TII elements
     * and limit them by min ./. max values
     * @param
     * @return mixed
     * @throws \dml_exception
     */
    public static function get_cached_tii_course_ids()
    {
        global $DB;
        $cache = \cache::make('local_lai_connector', 'tiicourses');
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

}

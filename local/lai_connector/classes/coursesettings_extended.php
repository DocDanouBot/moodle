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

global $CFG;
require_once($CFG->dirroot . '/local/lai_connector/classes/event/coursesettings_extended_updated.php');

class coursesettings_extended {

    /*
     *  DB functions for saving specific course settings
     */
    public static function updateSettings($courseId, $fieldsToUpdate, $context)
    {
        global $DB;
        $fieldsToUpdate['courseid'] = $courseId;
        $fieldsToUpdate['timeupdated'] = time();
        $table = 'local_lai_connector_courses';
        $r = self::getSettings($courseId);
        if ($r === false) {
            $insertId = $DB->insert_record($table, $fieldsToUpdate);
            $event = \local_lai_connector\event\coursesettings_extended_updated::create(
                array('context' => $context, 'objectid' => $insertId, 'other' => $fieldsToUpdate)
            );
        } else {
            $fieldsToUpdate['id'] = $r->id;
            $event = \local_lai_connector\event\coursesettings_extended_updated::create(
                array('context' => $context, 'objectid' => $r->id, 'other' => $fieldsToUpdate)
            );
            $DB->update_record($table, $fieldsToUpdate);
        }
        $event->trigger();
        return true;
    }

    /*
     * Getting settings for course
     */
    public static function getSettings($courseId)
    {
        global $DB;
        $table = 'local_lai_connector_courses';
        return $DB->get_record($table, ['course' => $courseId], $fields = '*', $strictness = IGNORE_MISSING);
    }



}

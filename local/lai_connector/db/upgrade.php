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
 * version information
 *
 * @package    local_iubh_turnitin
 * @copyright  2022 Danou Nauck <Danou@Nauck.eu>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') or die;

function xmldb_local_iubh_turnitin_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2023012001) {
        $sql = "select * from {modules} WHERE name = 'turnitintooltwo'";
        $moduleInfo = $DB->get_record_sql($sql);  # $moduleInfo->id ==  27

        $DB->execute("UPDATE {course_modules} set completion=0 where module=?", array($moduleInfo->id));
        upgrade_plugin_savepoint(true, 2023012001, 'local', 'iubh_turnitin');
    }

    return true;
}

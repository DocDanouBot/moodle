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
 * upgrade definitions
 *
 * @package     local_lai_connector
 * @copyright   lern.link GmbH
 * @author      Danou Nauck
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') or die;

function xmldb_local_lai_connector_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2024070010) {

        // A new table for the local_lai_connector_courses to save the TARSUS state of each course
        $table = new xmldb_table('local_lai_connector_brains');
        if ($dbman->table_exists($table)) {
            // lets make sure that we start from scratch, so we drop the table.
            $dbman->drop_table($table);
        }
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE);
        $table->add_field('brainid',XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, "", 'id');
        $table->add_field('brainname',XMLDB_TYPE_CHAR, '255', null, null, null, null, 'brainid');
        $table->add_field('braindescription',XMLDB_TYPE_CHAR, '255', null, null, null, null, 'brainname');
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0', 'braindescription');
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0', 'userid');
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0', 'timecreated');
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
        // Define key brainid to be added as a unique key to local_lai_connector_courses.
        $table->add_key('brainid', XMLDB_KEY_UNIQUE, array('brainid'));
        // Define key userid (foreign) to be added to local_lai_connector_courses.
        $table->add_key('userid', XMLDB_KEY_FOREIGN, ['userid'], 'user', ['id']);
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // A new table for the local_lai_connector_courses to save the TARSUS state of each course
        $table = new xmldb_table('local_lai_connector_courses');
        if ($dbman->table_exists($table)) {
            // lets make sure that we start from scratch, so we drop the table.
            $dbman->drop_table($table);
        }
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE);
        $table->add_field('courseid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0', 'id');
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0', 'courseid');
        $table->add_field('enabled',XMLDB_TYPE_INTEGER,'1',null, XMLDB_NOTNULL, null, '0','userid');
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0', 'enabled');
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0', 'timecreated');
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
        $table->add_key('course', XMLDB_KEY_UNIQUE, array('courseid'));
        // Define key courseid (foreign) to be added to local_lai_connector_courses.
        $table->add_key('courseid', XMLDB_KEY_FOREIGN, ['courseid'], 'course', ['id']);
        // Define key userid (foreign) to be added to local_lai_connector_courses.
        $table->add_key('userid', XMLDB_KEY_FOREIGN, ['userid'], 'user', ['id']);
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // A new table for the local_lai_connector to save all the assets that have been added to TARSUS
        $table = new xmldb_table('local_lai_connector_assets');
        if ($dbman->table_exists($table)) {
            // lets make sure that we start from scratch, so we drop the table.
            $dbman->drop_table($table);
        }
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE);
        $table->add_field('brainid',XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, "", 'id');
        $table->add_field('courseid', XMLDB_TYPE_INTEGER, '10', null, null, null, null, 'brainid');
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '10', null, null, null, null, 'courseid');
        $table->add_field('resourceid', XMLDB_TYPE_CHAR, '64', null, XMLDB_NOTNULL, null, '', 'userid');
        $table->add_field('assetid', XMLDB_TYPE_TEXT, null, null, null, null, null, 'resourceid');
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0', 'assetid');
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0', 'timecreated');
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
        // Define key brainid (foreign) to be added to local_lai_connector_courses.
        $table->add_key('brainid', XMLDB_KEY_FOREIGN, ['brainid'], 'user', ['local_lai_connector_brains']);
        // Define key courseid (foreign) to be added to local_lai_connector_courses.
        $table->add_key('courseid', XMLDB_KEY_FOREIGN, ['courseid'], 'course', ['id']);
        // Define key userid (foreign) to be added to local_lai_connector_courses.
        $table->add_key('userid', XMLDB_KEY_FOREIGN, ['userid'], 'user', ['id']);
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        upgrade_plugin_savepoint(true, 2024070010, 'local', 'lai_connector');
    }

    if ($oldversion < 2024070013) {
        // A new field to memorize the type of traced bit
        $table = new xmldb_table('local_lai_connector_assets');
        $field = new xmldb_field('bittype', XMLDB_TYPE_CHAR, '15', null, null, null, "", 'brainid');

        // Conditionally launch add field
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        upgrade_plugin_savepoint(true, 2024070013, 'local', 'lai_connector');
    }

    if ($oldversion < 2024080000) {
        // A new field to memorize the type of traced bit
        $table = new xmldb_table('local_lai_connector_assets');
        $field = new xmldb_field('cmid', XMLDB_TYPE_INTEGER, '8', null, null, null, null, 'assetid');

        // Conditionally launch add field
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        upgrade_plugin_savepoint(true, 2024080000, 'local', 'lai_connector');
    }

    return true;
}

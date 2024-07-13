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

// In this subclass we modually define all the nessessary elements to access the TARSUS API
use pix_icon;
use stdClass;
use moodle_url;
use local_lai_connector\event\brain_deleted;
use local_lai_connector\event\brain_saved;
use local_lai_connector\event\brain_updated;
use local_lai_connector\event\nugged_entry_created;
use local_lai_connector\event\nugged_entry_deleted;
use local_lai_connector\exceptions\lai_exception;
use local_lai_connector\exceptions\tarsus_brain_exception;


/**
 * This is a subclass to generate DB entries into the own table called "local_lai_connector_brains".
 * Also we trigger events and can later save additional data to the same table.
 */
class tarsus_brain
{
    // lets define all the regular vars we also have in the DB local_lai_connector_brains table.
    // so that this class has all the properties of the same table records.

    // The regular incremental id is the primary key.
    public $id;

    // The reference to the name of TARSUS API.
    public $brainid = "";

    // The reference for the factory to see, if we already have an entry.
    protected static $_brainid = "";

    // Some natural name we gave interternally at lernlink.
    public $brainname = "";

    // Some natural language description of the db entry, Inner purpose only.
    public $braindescription = "";

    // Which user was creating or updating the entry. Its a foreign key to mdl_users.
    public $userid = 0;

    // just a timestamp.
    public $timecreated = 0;

    // Well, just another timestamp.
    public $timemodified = 0;

    /**
     * Singleton instance of this class. We cache the instance in this Class.
     * so we can use it again without re-creating it.
     *
     * @var  $_self
     */
    private static $_self;

    //* Component constructor. Still empty at the time.
    public function __construct($brainid)
    {
        global $DB;
        $table = 'local_lai_connector_brains';

        if(!$record = $DB->get_record($table, array('brainid' => $brainid))) {
            // Safety fallback, we did not find the corresponding entry of the given TARSUS DB within our DB.
            // Therefore we quickly create it to continue smoothly
            $record = \local_lai_connector\tarsus_brain::create($brainid);
            // throw new tarsus_brain_exception('except_brain_not_found', $brain_id);
        }

        $this->id = $record->id;
        $this->brainid = $record->brainid;

        // We need to save it also statically so that the factory sees it when we try to build yet another instance.
        // of the very same brainid.
        self::$_brainid = $brainid;

        if($record->brainname != "") {
            $this->brainname = $record->brainname;
        }
        if($record->braindescription != "") {
            $this->braindescription = $record->braindescription;
        }
        $this->userid = $record->userid;
        $this->timecreated = $record->timecreated;
        $this->timemodified = $record->timemodified;
    }


    /**
     * Factory method to get an instance of the AI connector. We use this method to get the instance.
     * of the AI connector ONLY once! We do not want to redo the job many times, if we need the API.
     * again and again in multiple spots on the same page. Thus we -basically- cache it in the protected $_self variable.
     *
     * @return the TARSUS Connector
     * @throws \lai_exception
     */
    public static function get_instance($brainid = null)
    {
        global $CFG;

        # We also need to check, that the self->id is NOT the same as before,
        # otherwise in a loop he would always return the first element he cached
        if ((!self::$_self) || (self::$_brainid != $brainid)) {
            self::$_self = new self($brainid);
        }

        return self::$_self;
    }


    /** regular static funtion to add a new entry into our own database.
     * @param $brainid
     * @param $brainname
     * @param $braindescription
     * @param $userid
     * @return self
     * @throws \dml_exception
     * @throws tarsus_brain_exception
     */
    public static function create($brainid, $brainname = "", $braindescription = '', $userid = null ) {
        global $DB, $USER;

        $currenttime = time();
        $table = 'local_lai_connector_brains';

        $data = new \stdClass;
        $data->brainid = $brainid;
        if($brainname != "") {
            $data->brainname = strip_tags($data->brainname, '<a>');
        }
        if($braindescription != "") {
            $data->braindescription = strip_tags($data->braindescription, '<a>');
        }
        if ($userid > 0) {
            $data->userid = $userid;
        } else {
            // We had no userid set, so we take the global userid
            $data->userid  = $USER->id;
        }
        $data->timecreated  = $currenttime;
        $data->timemodified  = 0;

        //TODO catch this or not?
        $id = $DB->insert_record($table, $data);

        return new self($brainid);
    }


    /**
     * Updates the public values of the instance
     *
     * Values that can be changed:
     * * name
     * *
     *
     * @param $data
     * @throws \moodle_exception
     */
    public function update(\stdClass $data) {
        global $DB;

        $update = false;

        if(!empty($data->brainid)) {
            if($data->brainid != $this->brainid) {
                $this->brainid = $data->brainid;
                $update = true;
            }
        }

        if(!empty($data->brainname)) {
            if($data->brainname != $this->brainname) {
                $this->brainname = strip_tags($data->brainname, '<a>');
                $update = true;
            }
        }

        if(!empty($data->braindescription)) {
            if($data->braindescription != $this->braindescription) {
                $this->braindescription = strip_tags($data->braindescription, '<a>');
                $update = true;
            }
        }

        if($update) {
            $this->timeupdated = time();

            try {
                //TODO catch this?
                $table = 'local_lai_connector_brains';
                $DB->update_record($table, $this);
            } catch(\Exception $e) {
                $a = new \stdClass();
                $a->brainid = "<span style='font-weight:bold;'>" . $data->brainid . "</span>";

                $redirecturl = new \moodle_url('/local/lai_connector/edit_tarsus_brain.php', array('brain_id'=>$this->brainid));
                $redirectmessageerror = get_string('tarsus_brain_update_error', 'local_lai_connector', $a) . "<br>". $e->error;
                redirect($redirecturl, $redirectmessageerror, null, \core\output\notification::NOTIFY_ERROR);
                exit;
            }
        }
    }


    /** General function to insert an AI brain into the database if none exists by the same unique name.
     * Otherwise we find the same entry and add new data to it, like the new userid that triggered the update.
     * as well as the timestamp of the update and maybe more additional information in the future.
     * @param $brain_id
     * @param $userid
     * @return mixed|stdClass
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public static function create_new_brain($brain_id, $userid)
    {
        global $DB;
        // we always need a context for events and anything.
        $context = 1;
        $table = 'local_lai_connector_brains';

        // Is there already a record with this brainid identifier? Than update it, otherwise create it.
        if ($existingrecord = $DB->get_record($table, array('brainid' => $brain_id), '*', IGNORE_MULTIPLE)) {
            $existingrecord->userid = $userid;
            $existingrecord->timemodified = time();
            $successfullyupdated = $DB->update_record($table, $existingrecord);

            // Did the update run smoothly?
            if ($successfullyupdated) {
                // What should we memorize and track in the event?
                $fieldsToEvent['userid'] = $userid;
                $fieldsToEvent['timemodified'] = $existingrecord->timemodified;
                $event = \local_lai_connector\event\brain_updated::create(
                    array('context' => $context, 'objectid' => $existingrecord->id, 'other' => $fieldsToEvent)
                );
                $event->trigger();
            }
            // Now just return the given record
            return $existingrecord;
        } else {
            // we have not yet found a record with this brainid, so we create it.
            $newrecord = new stdClass();
            $newrecord->brainid = $brain_id;
            $newrecord->userid = $userid;
            $newrecord->timecreated = time();
            $newrecord->timemodified = 0;  // This entry is brand new, it has never been modified.

            // We recycle this id in the event later.
            $newrecord->id = $DB->insert_record($table, $newrecord);

            // What should we memorize and track in the event?
            $fieldsToEvent['userid'] = $newrecord->userid;
            $fieldsToEvent['timecreated'] = $newrecord->timecreated;
            $event = \local_lai_connector\event\brain_created::create(
                array('context' => $context, 'objectid' => $newrecord->id, 'other' => $fieldsToEvent)
            );
            $event->trigger();
            return $newrecord;
        }
    }

    /** one of these basic functions to clean our database from old unused entries.
     * On successful delete, we add also an event to it.
     * @param $brain_id
     * @param $userid
     * @return void
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public function delete($brain_id, $userid)
    {
        global $DB;

        $table = 'local_lai_connector_brains';
        $params = array('brainid' => $brain_id);

        // Is there already a record with this brainid identifier? Than update it, otherwise create it.
        if ($existingrecord = $DB->get_record($table, $params, '*', IGNORE_MULTIPLE)) {
            // Maybe we dont really need the line above, the line below should be sufficiant.
            $a = new \stdClass();
            $a->brainid = "<span style='font-weight:bold;'>" . $this->brainid . "</span>";

            $transaction = $DB->start_delegated_transaction();
            try {
                $DB->delete_records($table, $params);
                \core\notification::success(get_string('tarsus_brain_deleted', 'local_lai_connector', $a));

                // Successfully deleted, so we save everything in an event.
                // we always need a context for events and anything.
                $context = 1;
                // What should we memorize and track in the event?
                $fieldsToEvent['userid'] = $userid;
                $fieldsToEvent['timedeleted'] = time();

                $event = \local_lai_connector\event\brain_deleted::create(
                    array('context' => $context, 'objectid' => $existingrecord->id, 'other' => $fieldsToEvent)
                );

                // Send the event to the DB
                $event->trigger();
            }
            catch(\Exception $e) {
                \core\notification::error(get_string('tarsus_brain_not_deleted', 'local_lai_connector', $a));

                // Lets spit out all the information we have.
                $my_e = new tarsus_brain_exception(
                    'except_dberror_delete_brain',
                    $this->id,
                    (get_string('tarsus_brain_not_deleted', 'local_lai_connector', $a)
                        . $e->getMessage() . "\n" . $e->getTraceAsString())
                );
                $transaction->rollback($my_e);
            }

            $transaction->allow_commit();
        }
    }

    /** just a static re-rooting into the class to dynamically delete the given brain.
     * @param $brain_id
     * @return bool
     */
    public static function delete_brain($brainid) {
        $tarsus_brain = new \local_lai_connector\tarsus_brain($brainid);
        return $tarsus_brain->delete();
    }

}

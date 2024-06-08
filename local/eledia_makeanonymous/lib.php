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
 * This local plugin anonymizes data of deleted users, 
 * optinally with a delay time.
 *
 * @package local_eledia_makeanonymous
 * @author Matthias Schwabe <support@eledia.de>
 * @copyright 2013 & 2014 eLeDia GmbH
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Called from event observer.
 */
function start_anonymous($userid) {
    global $DB;

    $config = get_config('local_eledia_makeanonymous');

    if ($config->enable == '1') {

        $user = $DB->get_record('user', array('id' => $userid));

        if ($config->delay == '0') {
            make_anonymous($user);
        } else {
            store_to_table($user);
        }
    }
}

/**
 * The function which anonymizes the deleted user.
 */
function make_anonymous($user) {
    global $DB;

    $config = get_config('local_eledia_makeanonymous');

    $updateuser = $user;

    $updateuser->deleted      = 1;
    $updateuser->idnumber     = '';
    $updateuser->picture      = 0;
    $updateuser->firstname    = $config->deletedfirstname;
    $updateuser->lastname     = $config->deletedsurname;
    $updateuser->country      = $config->deletedcountry;
    $updateuser->city         = $config->deletedcity;
    $updateuser->username     = 'deletedUser_'.md5($user->username.time());
    $updateuser->email        = $updateuser->username.'@delet.ed';
    $updateuser->emailstop    = 1;
    $updateuser->auth         = $config->deletedauth;

    $updateuser->mnethostid = 0;
    $updateuser->icq = '';
    $updateuser->skype = '';
    $updateuser->yahoo = '';
    $updateuser->aim = '';
    $updateuser->msn = '';
    $updateuser->phone1 = '';
    $updateuser->phone2 = '';
    $updateuser->institution = '';
    $updateuser->department = '';
    $updateuser->address = '';
    $updateuser->lang = '';
    $updateuser->timezone = '';
    $updateuser->lastip = '0.0.0.0';
    $updateuser->secret = '';
    $updateuser->url = '';
    $updateuser->description = '';
    $updateuser->imagealt = '';

    $updateuser->timemodified = '0';
    $updateuser->firstaccess = '0';
    $updateuser->lastaccess = '0';
    $updateuser->lastlogin = '0';
    $updateuser->currentlogin = '0';
    $updateuser->timecreated = '0';

    $updateuser->lastnamephonetic = '';
    $updateuser->firstnamephonetic = '';
    $updateuser->middlename = '';
    $updateuser->alternatename = '';

    $DB->update_record('user', $updateuser);
}

/**
 * Stores deleted users into a table to anonymize them
 * after a certain delay time.
 */
function store_to_table($user) {
    global $DB;

    $record = new stdClass();
    $record->userid = $user->id;
    $record->timedeleted = time();
    $DB->insert_record('local_eledia_makeanonymous', $record, false, false);
}

/**
 * Called from scheduled task.
 */
function anonymize_task() {
    global $DB;

    $config = get_config('local_eledia_makeanonymous');

    if ($config->enable == '1') {

        $timenow = time();

        $delay = $config->delay * 60; // Minutes to seconds.
        $delaytime = $timenow - $delay;

        $sql = ("SELECT userid
                 FROM {local_eledia_makeanonymous}
                 WHERE timedeleted < ?");
        $params = array($delaytime);
        $userids = $DB->get_records_sql($sql, $params);

        foreach ($userids as $userid) {

            $id = $userid->userid;
            $user = $DB->get_record('user', array('id' => $id));
            make_anonymous($user);
        }

        $DB->delete_records_select('local_eledia_makeanonymous', "timedeleted < ?", array($delaytime));

        return true;
    }
}

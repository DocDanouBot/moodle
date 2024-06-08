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

require_once('../../config.php');
require_once('lib.php');

defined('MOODLE_INTERNAL') || die;

global $CFG, $DB, $PAGE;

$PAGE->set_url('/local/eledia_makeanonymous/anonymizeold.php');

require_login();
$context = context_system::instance();
$PAGE->set_context($context);

if (has_capability('moodle/site:config', $context)) {

    $sql = ("SELECT id,
                    username
             FROM {user}
             WHERE deleted = 1");
    $deletedusers = $DB->get_records_sql($sql);

    $toanonymize = array();
    foreach ($deletedusers as $user) {
        if (substr($user->username, 0, 12) != 'deletedUser_') {
            make_anonymous($user);
        }
    }

    redirect($CFG->wwwroot.'/admin/settings.php?section=local_eledia_makeanonymous');
}

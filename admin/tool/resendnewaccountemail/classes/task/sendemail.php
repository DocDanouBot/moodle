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

namespace tool_resendnewaccountemail\task;

/**
 * Ad hoc task to send new password email.
 *
 * @package    tool_resendnewaccountemail
 * @copyright  2023 Daniel Neis Araujo
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class sendemail extends \core\task\adhoc_task {

    /**
     * Return the task's name as shown in admin screens.
     *
     * @return string
     */
    public function get_name() {
        return get_string('sendnotificationstask', 'tool_resendnewaccountemail');
    }

    public function execute() {
        global $DB;
        // Only reset password if user may actually change the password.
        $authsavailable = get_enabled_auth_plugins();
        $changeable = array();

        foreach($authsavailable as $authplugin) {
            if (!$auth = get_auth_plugin($authplugin)) {
                continue;
            }
            if ($auth->is_internal() and $auth->can_change_password()) {
                $changeable[$authplugin] = true;
            }
        }
        $bulkusers = (array)($this->get_custom_data()->bulk_users);
        list($in, $params) = $DB->get_in_or_equal($bulkusers);
        $rs = $DB->get_recordset_select('user', "id $in", $params);
        $context = \context_system::instance();
        foreach ($rs as $user) {
            if (!empty($changeable[$user->auth])) {
                if (setnew_password_and_mail($user)) {
                    $params = ['context' => $context, 'objectid' => $user->id, 'userid' => $user->id];
                    $event = \tool_resendnewaccountemail\event\email_sent::create($params);
                    $event->trigger();
                    unset_user_preference('create_password', $user);
                    set_user_preference('auth_forcepasswordchange', 1, $user);
                }
            } else {
                echo get_string('resendnot', 'tool_resendnewaccountemail', (object)['name' => fullname($user, true), 'auth' => $user->auth]);
                mtrace();
            }
        }
        $rs->close();
    }
}

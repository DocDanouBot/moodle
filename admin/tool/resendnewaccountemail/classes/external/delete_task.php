<?php
// This file is part of the tool_resendnewaccountemail plugin for Moodle - http://moodle.org/
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

namespace tool_resendnewaccountemail\external;

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/externallib.php");

/**
 * Delete task
 *
 * @package     tool_resendnewaccountemail
 * @copyright   2023 Daniel Neis AraujoG
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class delete_task extends \external_api {

    /**
     * Returns the execute() parameters.
     *
     * @return \external_function_parameters
     */
    public static function execute_parameters() {
        return new \external_function_parameters(
            array(
                'id' => new \external_value(PARAM_INT, 'Task id')
            )
        );
    }

    /**
     * Handles delete task
     *
     * @param int $taskid
     */
    public static function execute($taskid) {
        global $DB;
        $params = self::validate_parameters(self::execute_parameters(), ['id' => $taskid]);
        self::validate_context(\context_system::instance());
        return $DB->delete_records('task_adhoc', ['id' => $params['id']]);
    }

    /**
     * Returns the execute result value.
     *
     * @return \external_value
     */
    public static function execute_returns() {
        return new \external_value(PARAM_BOOL, 'success');
    }
}

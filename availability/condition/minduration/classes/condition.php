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
 * PZ access condition.
 *
 * @package availability_minduration
 * @copyright   lern.link GmbH
 * @author      Danou Nauck
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace availability_minduration;

defined('MOODLE_INTERNAL') || die();


class condition extends \core_availability\condition
{

    const HAS_MINDURATION_0 = 0;
    const HAS_MINDURATION_60 = 60;
    const HAS_MINDURATION_120 = 120;
    const HAS_MINDURATION_180 = 180;

    /** @var int Expected access type selected */
    protected $accesstype;

    /**
     * Constructor.
     *
     * @param \stdClass $structure Data structure from JSON decode
     * @throws \coding_exception If invalid data structure.
     */
    public function __construct($structure)
    {
        global $CFG;

        // Get expected access type.
        if (!empty($structure->e)) {
            $this->accesstype = $structure->e;
        } else {
            throw new \coding_exception('Missing or invalid ->e for access condition');
        }
    }

    public function save()
    {
        return (object)array('type' => 'minduration', 'e' => $this->accesstype);
    }

    /**
     * Returns a JSON object which corresponds to a condition of this type.
     *
     * Intended for unit testing, as normally the JSON values are constructed
     * by JavaScript code.
     *
     * @param int $accesstype Expected access type
     * @return stdClass Object representing condition
     */
    public static function get_json($accesstype)
    {
        return (object)array('type' => 'minduration', 'e' => (int)$accesstype);
    }

    protected function get_debug_string()
    {
        return '#' . $this->accesstype;
    }

    public function is_available($not, \core_availability\info $info, $grabthelot, $userid)
    {
        $allow = false;
        $courseid = $info->get_course()->id;

        if ($this->accesstype == SELF::HAS_MINDURATION_0) {
            $allow = true;
        }

        if (($this->accesstype == SELF::HAS_MINDURATION_60) && (SELF::check_participation_for_course($userid,$courseid,$this->accesstype))) {
            $allow = true;
        }

        if (($this->accesstype == SELF::HAS_MINDURATION_120) && (SELF::check_participation_for_course($userid,$courseid,$this->accesstype))) {
            $allow = true;
        }

        if (($this->accesstype == SELF::HAS_MINDURATION_180) && (SELF::check_participation_for_course($userid,$courseid,$this->accesstype))) {
            $allow = true;
        }

        if ($not) {
            $allow = !$allow;
        }

        return $allow;
    }

    public function get_description($full, $not, \core_availability\info $info)
    {

        # Definition of new states from IDSS-1270
        switch ($this->accesstype) {
            case self::HAS_MINDURATION_0:
                $str = 'requires_0min';
                break;
            case self::HAS_MINDURATION_60:
                $str = 'requires_60min';
                break;
            case self::HAS_MINDURATION_120:
                $str ='requires_120min';
                break;
            case self::HAS_MINDURATION_180:
                $str ='requires_180min';
                break;
            default:
                $str ='requires_180min';
                break;
        }

        return get_string($str, 'availability_minduration');
    }

    private static function check_participation_for_course($userid, $courseid, $minduration)
    {
        global $DB;
        $sql = "SELECT 
                    userid
                FROM
                    {course_modules}
                WHERE
                    {course_modules}.course = $courseid
                    AND userid = $userid";
        $hasSubission = $DB->record_exists_sql($sql);
        return $hasSubission;
    }
}

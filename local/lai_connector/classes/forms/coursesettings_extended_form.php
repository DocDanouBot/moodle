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

namespace local_lai_connector\forms;

defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->libdir . "/formslib.php");

/**
 * @see https://docs.moodle.org/dev/Form_API
 * Class CourseSettingsForm
 *
 */
class CourseSettingsExtendedTarsusForm extends \moodleform
{
    protected $permissions;

    public function __construct($action, $permissions)
    {
        $this->permissions = $permissions;
        parent::__construct($action);
    }

    /**
     * Form definition
     *
     * @throws coding_exception
     */
    public function definition()
    {
        // The instance to the mform object.
        $mform =& $this->_form; // Don't forget the underscore

        if (!empty($this->permissions['coursesettings_tarsus_enable']) && $this->permissions['coursesettings_tarsus_enable'] === true) {
            $mform->addElement('header', 'first_tarsus_header', get_string('setting_courseext_header', 'local_lai_connector'));
            $mform->addElement('html', get_string('setting_courseext_description', 'local_lai_connector'));
            $mform->addElement('html', '<br><br>');
            $mform->addElement('checkbox', 'enabled', get_string('setting_courseext_enable', 'local_lai_connector'));
            $mform->addElement('html', '<br>');
        }
        if (!empty($this->permissions['coursesettings_tarsus_addnow']) && $this->permissions['coursesettings_tarsus_addnow'] === true) {
            $mform->addElement('header', 'second_tarsus_header', get_string('setting_courseext_addnow_title', 'local_lai_connector'));
            $mform->addElement('html', get_string('setting_courseext_addnow_description', 'local_lai_connector'));
            $mform->addElement('html', '<br>');
            $mform->addElement('html', '<div style="text-align: center"><span class="btn btn-primary" id="tarsus_ajax_add_course_to_brain">'.get_string('setting_courseext_addnow_action', 'local_lai_connector').'</span> <span id="tarsus_ajax_add_course_to_brain_result"> </span></div>');
            $mform->addElement('html', '<br>');

            $this->add_action_buttons(true);
        }
    }

    public function set_data($defaultvalues)    {
        if (is_object($defaultvalues)) {
            $defaultvalues = (array)$defaultvalues;
        }

        if ($defaultvalues['enabled'] <= 0) {

            $defaultvalues['enabled'] = 1;

            parent::set_data($defaultvalues); // Now set the prepared data with the parent method.
        }
    }

    /**
     * Returns the data the user has submitted.
     *
     * @return \stdClass The post data.
     */
    public function get_data($data = null) {
        if (is_object($data)) {
            $data = (array)$data;
        }

        if ($data == null) {
            $data = parent::get_data();
        }

        return $data;
    }


}

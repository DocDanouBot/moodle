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
class CourseSettingsExtendedForm extends \moodleform
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
        global $PAGE;
        // The instance to the mform object.
        $mform =& $this->_form; // Don't forget the underscore


        if (!empty($this->permissions['coursesettings_tarsus_enable']) && $this->permissions['coursesettings_tarsus_enable'] === true) {
            $mform->addElement('header', 'first_tarsus_header', get_string('setting_courseext_header', 'local_lai_connector'));
            $mform->addElement('html', get_string('setting_courseext_description', 'local_lai_connector').'<br><br>');
            $mform->addElement('checkbox', 'enabled', get_string('setting_courseext_enable', 'local_lai_connector'));
            $mform->addElement('html', '<br>');

        }

        # echo( "Element value " . $mform->getElementValue('enabled') . "<hr>");
        # var_dump($mform);

        // Deactivate this whole section as it is not ready and fully functional yet
        /*
        if (!empty($this->permissions['coursesettings_tarsus_addnow']) && $this->permissions['coursesettings_tarsus_addnow'] === true) {
            $mform->addElement('header', 'second_tarsus_header', get_string('setting_courseext_addnow_title', 'local_lai_connector'));
            $mform->setExpanded('second_tarsus_header');
            $mform->addElement('static', 'second_tarsus_text', '', get_string('setting_courseext_addnow_description', 'local_lai_connector'), ['class' => 'breitesfenster']);

            $mform->addElement('button', 'addto_tarsus_button', get_string('setting_courseext_addnow_action', 'local_lai_connector'));
            // Add js.
            # $mform->addElement('hidden', 'buttonelementconfiguration', '', array('id' => 'tool_lp_scaleconfiguration'));
            #$mform->setType('buttonelementconfiguration', PARAM_RAW);
            # $PAGE->requires->js_call_amd('tool_lp/scaleconfig', 'init', array('#id_scaleid','#tool_lp_scaleconfiguration', '#id_buttonelement'));

            $this->add_action_buttons(true);
        }
        */
    }

    public function definition_after_data() {
        parent::definition_after_data();
        $mform =& $this->_form;
        $course_checkbox =& $mform->getElement('enabled');

        if (!isset($course_checkbox->_attributes['checked'])) {
            $mform->removeElement('second_tarsus_header');
            $mform->removeElement('second_tarsus_text');
            $mform->removeElement('addto_tarsus_button');
        }
        // Example 2
        # $mform->insertElementBefore( $mform->createElement('submit', 'cancel', get_string('cancel')), 'course_text');

    } // definition_after_data


    /**
     * Set the data in this form to show on start.
     *
     * @param \stdClass|array $defaultvalues The data we want to set.
     */
    public function set_data($data = null) {
        global $DB, $COURSE;

        if (is_object($data)) {
            $defaultvalues = (array)$data;
        } else {
            $checkbox = $DB->get_record('local_lai_connector_courses', array('courseid' => $COURSE->id), 'enabled', IGNORE_MULTIPLE);
            // Lets get this stupid value from DB
            $defaultvalues = array(
                'enabled' => $checkbox->enabled, # $data->enabled,
            );
        }
        parent::set_data($defaultvalues); // Now set the prepared data with the parent method.
    }

    /**
     * Returns the data the user has submitted.
     *
     * @return \stdClass The post data.
     */
    public function get_data() {
        $data = parent::get_data();
        return $data;
    }

}

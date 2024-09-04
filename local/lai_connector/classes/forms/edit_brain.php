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

require_once($CFG->libdir.'/formslib.php');

class edit_brain extends \moodleform {

    /**
     * Define the elements in this form.
     */
    public function definition() {

        // The instance to the mform object.
        $mform =& $this->_form;

        $mform->addElement('header', 'general', get_string('general'));

        // With this element we can see if a training is edited or created.
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform->addElement('hidden', 'userid');
        $mform->setType('userid', PARAM_INT);
        $mform->addElement('hidden', 'timecreated');
        $mform->setType('timecreated', PARAM_INT);
        $mform->addElement('hidden', 'timemodified');
        $mform->setType('timemodified', PARAM_INT);

        // The internal Tarsus identifier of the brain.
        $mform->addElement('text', 'brainid', get_string('form_edit_brainid', 'local_lai_connector'));
        $mform->addHelpButton('brainid', 'form_edit_brainid', 'local_lai_connector');
        $mform->setType('brainid', PARAM_TEXT);
        // Disable brainid if there is already a value set. Because this is the connector to the real TARSUS Brain.
        $mform->disabledIf('brainid', 'brainid', 'eq', "testbrain");
        #$mform->addRule('brainid', null, 'required', null, 'client');
        #$mform->addRule('brainid', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');


        // The Lernlink name of the brain
        $mform->addElement('text', 'brainname', get_string('form_edit_brainname', 'local_lai_connector'));
        $mform->addHelpButton('brainname', 'form_edit_brainname', 'local_lai_connector');
        $mform->setType('brainname', PARAM_TEXT);
        $mform->addRule('brainname', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');

        // The Lernlink name of the brain
        $mform->addElement('text', 'braindescription', get_string('form_edit_braindescription', 'local_lai_connector'));
        $mform->addHelpButton('braindescription', 'form_edit_braindescription', 'local_lai_connector');
        $mform->setType('braindescription', PARAM_TEXT);
        $mform->addRule('braindescription', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');

        // The buttons.
        $this->add_action_buttons(true, get_string('savechanges'));
    }


    /**
     * Set the data in this form to show on start.
     *
     * @param \stdClass|array $defaultvalues The data we want to set.
     */
    public function set_data($tarsusbrain) {
        if ($tarsusbrain instanceof \local_lai_connector\tarsus_brain) {

            $defaultvalues = array(
                'id' => $tarsusbrain->id,
                'brainid' => $tarsusbrain->brainid,
                'brainname' => $tarsusbrain->brainname,
                'braindescription' => $tarsusbrain->braindescription,
                'userid'  => $tarsusbrain->userid,
                'timecreated' => $tarsusbrain->timecreated,
                'timemodified' => $tarsusbrain->timemodified,
            );
        } else {
            // We want an array!
            $defaultvalues = (array) $tarsusbrain;
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
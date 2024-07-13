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
        global $CFG, $DB, $OUTPUT;

        // The instance to the mform object.
        $mform =& $this->_form;


        // Prepare some strings.
        $strformtitle = get_string('form_edit_brain_title', 'local_lai_connector');

        $mform->addElement('header', 'general', get_string('general'));

        // With this element we can see if a training is edited or created.
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        // The internal title of the related training.
        $mform->addElement('text', 'title', $strrelatedtrainingtitle);
        $mform->setType('title', PARAM_TEXT);
        $mform->addRule('title', null, 'required', null, 'client');

        // The list of related trainings in DE.
        $mform->addElement('text', 'trainingslist_de', $strrelatedtrainingslistde);
        $mform->setType('trainingslist_de', PARAM_TEXT);
        $mform->addRule('trainingslist_de', null, 'required', null, 'client');
        $mform->addHelpButton('trainingslist_de', 'trainingslist_de', 'local_lai_connector');

        // The list of related trainings in EN.
        $mform->addElement('text', 'trainingslist_en', $strrelatedtrainingslisten);
        $mform->setType('trainingslist_en', PARAM_TEXT);
        $mform->addHelpButton('trainingslist_en', 'trainingslist_en', 'local_lai_connector');


        # Area to add Tags to Training
        $tag_names = \local_eledia_cp_create_training\util::get_all_available_tags();

        $tag_checkboxes=array();
        $i = 0;
        foreach ($tag_names as $index => $tag) {
            # version 1 with dynamic id's
            $tags[] =  $mform->createElement('advcheckbox', 'tags['.$i.']', $tag, null, array('group' => 1), array(null, $index));
            $i++;
        }
        $mform->addGroup($tags, 'tagcheckboxgroup', get_string('iubh_turnitin_associated_tags', 'local_lai_connector'),array(''), false);
        $mform->addHelpButton('tagcheckboxgroup', 'iubh_turnitin_associated_tags', 'local_lai_connector');

        # $mform->setType('tagcheckboxgroup', PARAM_BOOL);
        # $mform->addRule('tagcheckboxgroup', get_string('training_tagcheckboxgroup_validation', 'local_eledia_cp_create_training'), 'required', null, 'client');

        // The buttons.
        $this->add_action_buttons(true, get_string('savechanges'));

    }


    /**
     * Returns the data the user has submitted.
     *
     * @return \stdClass The post data.
     */
    public function get_data() {
        $data = parent::get_data();

        // We have to assemble the data from the editor.
        if ($data) {
            $data->content_de = $data->content_de_editor['text'];
            $data->content_en = $data->content_en_editor['text'];
            $data->content_format = $data->content_de_editor['format'];
        }
        return $data;
    }

    /**
     * Validates the data which are submitted by the user. All errors are collected in the $errors array.
     *
     * @param \stdClass $data
     * @param \stdClass $files
     * @return array The error strings to print out on the form page
     */
    public function validation($data, $files) {
        global $DB;

        $errors = parent::validation($data, $files);

        if (isset($data['tags']) and is_array($data['tags'])) {
            foreach ($data['tags'] as $key => $value) {
                if ($value == 0) {
                    unset($data['tags'][$key]);
                }
            }
        }
        return $errors;
    }

    

}

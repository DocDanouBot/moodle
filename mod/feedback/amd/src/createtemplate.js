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
 * Javascript module for saving a new template.
 *
 * @module      mod_bycsfeedback/createtemplate
 * @copyright   2021 Peter Dias
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Forked and Extended version of the feedback plugin for
 * BayernCloudSchule (ByCS) by Lern.link GmbH
 *
 * @package    mod_bycsfeedback
 * @author     Danou Nauck danou.nauck@lernlink.de
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


define('mod_feedback/createtemplate',['core_form/modalform','core/notification', 'core/str', 'core/toast'],
    function(ModalForm, Notification, {getString}, { add}) {

        const selectors = {
            modaltrigger: '[data-action="createtemplate"]',
        };

        /**
         * Initialize module
         */

        return {
            /**
             * Initialize the settings of the block
             */
            init: function (data) {

                const trigger = document.querySelector(selectors.modaltrigger);

                trigger.addEventListener('click', event => {
                    event.preventDefault();
                    const ele = event.currentTarget;

                    const modalForm = new ModalForm({
                        modalConfig: {
                            title: getString('save_as_new_template', 'mod_bycsfeedback'),
                        },
                        formClass: 'mod_bycsfeedback\\form\\create_template_form',
                        args: {
                            id: ele.dataset.dataid
                        },
                        saveButtonText: getString('save', 'core')
                    });

                    // Show a toast notification when the form is submitted.
                    modalForm.addEventListener(modalForm.events.FORM_SUBMITTED, event => {
                        if (event.detail.result) {
                            getString('template_saved', 'mod_bycsfeedback').then(add).catch();
                        } else {
                            getString('saving_failed', 'mod_bycsfeedback').then(string => {
                                return Notification.addNotification({
                                    type: 'error',
                                    message: string
                                });
                            }).catch();
                        }
                    });

                    modalForm.show();
                });
            }
        };
    }

);

// import ModalForm from 'core_form/modalform';
// import Notification from 'core/notification';
// import {getString} from 'core/str';
// import {add as addToast} from 'core/toast';

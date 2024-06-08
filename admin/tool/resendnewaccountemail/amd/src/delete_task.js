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
 * Module to delete task
 *
 * @module     tool_resendnewaccountemail
 * @copyright  2023 Daniel Neis Araujo
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
import jQuery from 'jquery';
import Ajax from 'core/ajax';
import ModalFactory from 'core/modal_factory';
import ModalEvents from 'core/modal_events';
import Url from 'core/url';
import {get_string as getString} from 'core/str';

/**
 * Initialize delete task form as SAVE_CANCEL form.
 */
export const initModal = () => {

    var DELETE_TASK = '[data-action=deletetask]';

    jQuery(DELETE_TASK).click(function(e) {
        e.preventDefault();
        var taskId = jQuery(this).data('id');
        var nextRunTime = jQuery(this).data('nextruntime');
        ModalFactory.create({
            type: ModalFactory.types.SAVE_CANCEL,
            title: getString('deletetask', 'tool_resendnewaccountemail'),
            body:  getString('deletetaskconfirm', 'tool_resendnewaccountemail', nextRunTime),
        })
        .then(function(modal) {
            modal.setSaveButtonText(getString('delete'));
            var root = modal.getRoot();
            root.on(ModalEvents.save, function() {
                var request = {
                    methodname: 'tool_resendnewaccountemail_delete_task',
                    args: {
                        id: taskId,
                    }
                };
                Ajax.call([request])[0].then(function() {
                    window.location.href = Url.relativeUrl('admin/tool/resendnewaccountemail/index.php', null, false);
                }).fail(Notification.exception);
            });
            modal.show();
        });
    });
};


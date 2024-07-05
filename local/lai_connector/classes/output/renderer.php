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
 * @package     local_iubh_turnitin
 * @author      Danou Nauck <Danou@Nauck.eu>
 * @copyright   Nauck IT Consulting 2020
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_iubh_turnitin\output;

use local_iubh_turnitin\output\templatedata\page_reports_earlysubmissions;
use local_iubh_turnitin\output\templatedata\page_reports_tii;
use local_iubh_turnitin\output\templatedata\page_reports_vlr;
use local_iubh_turnitin\output\templatedata\page_tutor_open_tasks;

defined('MOODLE_INTERNAL') || die();

/**
 * Renderer for the local plugin local_iubh_turnitin
 */
class renderer extends \plugin_renderer_base {

    public function render_turnitin_reports_tii($data) {
        $templatedata = new page_reports_tii($data);
        $output = $this->render_from_template('local_iubh_turnitin/page_reports_tii',
            $templatedata->export_for_template($this));
        return $output;
    }

}

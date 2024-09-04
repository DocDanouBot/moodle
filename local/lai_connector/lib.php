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

defined('MOODLE_INTERNAL') || die;

function local_lai_connector_extend_navigation_course(\navigation_node $navigation, $course, $context) {
    global $PAGE, $CFG, $USER;
    if (has_capability('local/lai_connector:assetadd', $context)) {

        $tarsusBitsConfig = explode(',',strtolower( $CFG->local_lai_connector_tarsus_bits));
        $initparams =['userid' => $USER->id, 'bitssettings' => $tarsusBitsConfig];
        $PAGE->requires->jquery();
        $PAGE->requires->js_call_amd('local_lai_connector/script', 'init()', $initparams);
        $PAGE->requires->css('/local/lai_connector/styles.css');

        $PAGE->requires->strings_for_js(
            ['yes', 'no', 'ok', 'cancel', 'error', 'edit', 'delete'],
            'moodle'
        );
        $PAGE->requires->strings_for_js(
            [
                'js_content_submitted_self',
                'js_content_submitted_not',
                'js_content_submitted',
                'js_curatecontent',
                'js_modal_checkbox',
                'js_modal_confirm_backup',
                'js_modal_confirm_delete',
                'js_modal_title',
                'js_modal_title_add',
                'js_modal_title_remove',
                'js_modal_content_include',
                'js_modal_content_include_now',
                'js_modal_content_include_tooltip',
                'js_modal_content_exclude',
                'js_modal_content_exclude_now',
                'js_modal_content_exclude_tooltip',
            ],
            'local_lai_connector'
        );

        $navigation->add(
            get_string("link_mainmenu_coursesettings", "local_lai_connector"),
            new \moodle_url('/local/lai_connector/coursesettings_extended.php', array('course' => $course->id)),
            \navigation_node::TYPE_SETTING,
            null,
            null,
            new \pix_icon('i/settings', '')
        );
        // $PAGE->requires->js_call_amd('local_lai_connector/script', 'init');
    }
}

function local_lai_connector_extend_navigation(\global_navigation $navigation) {  //REFACTORED//
    global $CFG;
    $showlainodes = \local_lai_connector\util::show_lai_menu();
    if (is_siteadmin() || $showlainodes) {

        $context = \context_system::instance();

        if (has_capability('local/lai_connector:viewindexpage', $context)
            && ($CFG->local_lai_connector_activate_component == 1)) {
            $node = $navigation->add(
                get_string('link_mainmenu_index', 'local_lai_connector'),
                new \moodle_url('/local/lai_connector/index.php'),
                \navigation_node::NODETYPE_LEAF,
                get_string('link_mainmenu_index', 'local_lai_connector'),
                'local_lai_connector_index');
        }

    }
}


/**
 * Hier ein Versuch die Basisklasse zu klonen und zu erweitern. Mal schaun, ob das so geht
 */

class buildtarsusicon extends core_courseformat\output\local\content\cm
{
    /**
     * Constructor.
     *
     * @param course_format $format the course format
     * @param section_info $section the section info
     * @param cm_info $mod the course module ionfo
     * @param array $displayoptions optional extra display options
     */
    public function __construct(course_format $format, section_info $section, cm_info $mod, array $displayoptions = []) {
        parent::__construct($format, $section, $mod, $displayoptions);
        $this->tarsussettingclass = $format->get_output_classname('content\\cm\\tarsussetting');
    }

    protected function add_tarsus_data(stdClass &$data, renderer_base $output): bool {
        $tarsussetting = new $this->tarsussettingclass($this->format, $this->section, $this->mod);
        $data->tarsussettinginfo = $tarsussetting->export_for_template($output);
        return !empty($data->tarsussettinginfo);
    }

    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @param renderer_base $output typically, the renderer that's calling this function
     * @return stdClass data context for a mustache template
     */
    public function export_for_template(renderer_base $output): stdClass {
        global $PAGE;

        $data = parent::export_for_template($output);

        // Add partial data segments.
        $haspartials = [];

        $haspartials['tarsussetting'] = $this->add_tarsus_data($data, $output);
        $this->add_format_data($data, $haspartials, $output);

        return $data;
    }


}


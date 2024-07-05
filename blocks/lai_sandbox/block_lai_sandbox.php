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
 * @package     block_lai_sandbox
 * @copyright   lern.link GmbH
 * @author      Danou Nauck
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

global $CFG;

class block_lai_sandbox extends block_base {

    /*
     * Does the user is in the manager role?
     */
    private $_managerview = false;

    /*
     * Should we print some echos to the screen due to development purposes
     */
    private $_printinfos = false;

    public function init() {
        global $CFG, $USER;
        $this->title = get_string('pluginname', 'block_lai_sandbox');
        $this->_managerview = is_siteadmin(); # has_capability('local/iubh_generic:managerview', \context_system::instance());
        $this->_showaccordiontoggle = true;

        # Only Print infos on localhost or dev, AND if setting is active
        # $this->_printinfos = (($CFG->local_iubh_auth_devmode == true) && (\local_iubh_generic\util::is_localhost() || \local_iubh_generic\util::is_dev_server()));
        $this->_printinfos = true;
    }

    /**
     * Check if block has config, YES, we do!
     */
    public function has_config() {
        return true;
    }

    /**
     * Allow multiple blocks
     */
    public function instance_allow_multiple() {
        return false;
    }

    /** Here comes the actual work for the Block to build the sandbox
     * @return stdClass|stdObject|null
     * @throws coding_exception
     * @throws dml_exception
     * @throws moodle_exception
     */
    public function get_content() {
        global $DB, $PAGE, $USER,  $CFG ;

        if ($this->content !== null) {
            return $this->content;
        }


        $this->title = get_string('plugin_title', 'block_lai_sandbox');

        if ($this->_managerview) {
            $this->page->requires->js('/blocks/lai_sandbox/lib.js');

            # Managers can get their own mask later on
            $this->title = null;
            $this->_showaccordiontoggle = true;
            $content =  '<h4>'.get_string('admin_title', 'block_lai_sandbox').'</h4>';
            $content .= get_string('admin_not_available', 'block_lai_sandbox');

            $content = self::build_admin_box($content);
        }  else {
            $content = null;
            return null;
        }

        $this->content = new stdClass;
        $this->content->text = $content;
        if  ($this->_showaccordiontoggle) {
            $this->content->text .= self::build_javascript_strings();
        }
        return $this->content;
    }


    /** Generates dynamically the html content for the boxes
     * @param $strBox
     * @return html array
     * @throws coding_exception
     */
    private function build_admin_box ($innerContent) {
        global $CFG;
        $returnstring = '<!-- block_lai_sandbox -->';

        if ($this->_showaccordiontoggle) {
            $returnstring .= '<div class="admincontainer">
            <div id="lai_sandbox_admin_toggle"><span id="lai_sandbox_admin_header">' . get_string('admin_view_open', 'block_lai_sandbox') . '</span>
                <i id="lai_sandbox_admin_icon" class="fa fa-angle-down toggler"></i>
            </div>
            <div id="lai_sandbox_content"';

            if($this->_showaccordiontoggle) {
                $returnstring .= " class='norightsblock'";
            }

            $returnstring .= '>';
        }

        $returnstring .= $innerContent;

        if ($this->_showaccordiontoggle) {
            $returnstring .= '</div></div><!-- END block_lai_sandbox -->';
        }
        return $returnstring;
    }

    /** sourcing the JS Strings
     * @return string
     * @throws coding_exception
     */
    private function build_javascript_strings() {
        global $CFG;
        $someJStexts = '<script type="text/javascript">
            string_lai_sandbox_view_open = "'. get_string("admin_view_open", "block_lai_sandbox"). '";
            string_lai_sandbox_view_close = "'. get_string("admin_view_close", "block_lai_sandbox"). '";
</script>';

        return $someJStexts;
    }

    /*
    * Add custom html attributes to aid with theming and styling
    *
    * @return array
    */
    function html_attributes() {
        $attributes = parent::html_attributes();
        if ($this->_managerview) {
            $attributes['class'] .= ' managerview';
        }
        return $attributes;
    }

}

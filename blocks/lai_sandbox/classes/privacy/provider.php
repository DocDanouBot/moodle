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
<<<<<<<< HEAD:report/themeusage/classes/privacy/provider.php
 * Privacy Subsystem implementation for report_themeusage.
 *
 * @package    report_themeusage
 * @copyright  2023 David Woloszyn <david.woloszyn@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace report_themeusage\privacy;

/**
 * Privacy Subsystem for report_themeusage implementing null_provider.
 *
 * @package    report_themeusage
 * @copyright  2023 David Woloszyn <david.woloszyn@moodle.com>
========
 * Privacy Subsystem implementation for block_lai_sandbox.
 *
 * @package     block_lai_sandbox
 * @copyright   lern.link GmbH
 * @author      Danou Nauck
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_lai_sandbox\privacy;

defined('MOODLE_INTERNAL') || die();

/**
 * Privacy Subsystem for block_lai_sandbox implementing null_provider.
 *
 * @author     Danou Nauck <Danou@Nauck.eu>
>>>>>>>> MT-5615_KI_grundlagen_schaffen:blocks/lai_sandbox/classes/privacy/provider.php
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider implements \core_privacy\local\metadata\null_provider {

    /**
     * Get the language string identifier with the component's language
     * file to explain why this plugin stores no data.
     *
     * @return  string
     */
    public static function get_reason(): string {
        return 'privacy:metadata';
    }
}

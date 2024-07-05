<?php

/**
 * Versioning
 *
 * @package     block_iu_tutor_tasks
 * @author      Danou Nauck <Danou@Nauck.eu>
 * @copyright   Nauck IT Consulting 2021
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->component = 'block_lai_sandbox';
$plugin->version  = 2024060100; // The version of this plugin (@@major@@@@@@@@@@@@@@@@@@@@@minor@@)
$plugin->requires = 2022041900;
$plugin->maturity  = MATURITY_ALPHA;
$plugin->dependencies = array(
    'local_lai_connector'     => 2020112400,
);

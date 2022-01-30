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
 * Settings for local_tepuy.
 *
 * @package   local_tepuy
 * @copyright 2019 David Herney - cirano
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) {

    $generalsettings = null;

    // For general settings. Not used yet.
    //$generalsettings = new admin_settingpage('local_tepuy', get_string('pluginname', 'local_tepuy'));

    $plugins = core_plugin_manager::instance()->get_plugins_of_type('tepuycomponents');

    if ($plugins) {

        $ADMIN->add('localplugins', new admin_category('localtepuysettingscomponents',
                                            get_string('pluginname', 'local_tepuy')));

        if ($generalsettings) {
            $ADMIN->add('localtepuysettingscomponents', $generalsettings);
        }

        foreach ($plugins as $plugin) {

            $include = $CFG->dirroot . "/local/tepuy/components/{$plugin->name}/settings.php";

            if (!file_exists($include)) {
                continue;
            }

            $componentsettings = new admin_settingpage('localtepuysettingstepuycomponents' . $plugin->name,
                                                get_string('pluginname', 'tepuycomponents_' .$plugin->name), 'moodle/site:config');

            include($CFG->dirroot . "/local/tepuy/components/{$plugin->name}/settings.php");

            if (!empty($componentsettings)) {
                $ADMIN->add('localtepuysettingscomponents', $componentsettings);
            }
        }
    }

}
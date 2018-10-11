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
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle. If not, see <http://www.gnu.org/licenses/>.

/**
 * Defines a new administration page to configure the block.
 *
 * Settings page is an external page because we want to retrieve the available custom properties configured in
 * OpenVeo. Moodle default admin pages don't offer enough control to do it.
 *
 * @package block_openveo_videos
 * @copyright 2018 Veo-labs
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Ensure current user has "moodle/site:config" capability on system context.
if ($hassiteconfig) {

    // Create the settings page.
    $settingspage = new admin_externalpage(
            'block_openveo_videos',
            get_string('settingslinktitle', 'block_openveo_videos'),
            "$CFG->wwwroot/blocks/openveo_videos/openveo_videos_settings.php"
    );

    // Add pages to the admin tree (admin_root class) in 'blocks' category.
    $ADMIN->add('blocksettings', $settingspage);

    // Remove default block settings page defined by Moodle.
    $settings = null;

}

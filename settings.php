<?php
// This file is part of OpenVeo - http://www.veo-labs.com/suite-logicielle-openveo

/**
 * Defines a new administration page to configure the block.
 *
 * Settings page is an external page because we want to retrieve the available custom properties configured in
 * OpenVeo. Moodle default admin pages don't offer enough control to do it.
 *
 * @package block_openveo_videos
 * @copyright 2015, veo-labs <info@veo-labs.com>
 * @license AGPL
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

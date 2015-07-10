<?php
// This file is part of OpenVeo - http://www.veo-labs.com/suite-logicielle-openveo
//
// TODO : Add License information here

/**
 * Defines block's global configuration.
 *
 * @package block_openveo_videos
 * @copyright 2015, veo-labs <info@veo-labs.com>
 * @license TODO
 */

defined('MOODLE_INTERNAL') || die;

// Web service configuration fieldset
$settings->add(new admin_setting_heading(
            'headerconfig',
            get_string('genconfheader', 'block_openveo_videos'),
            get_string('genconfdesc', 'block_openveo_videos')
        ));

// Server host
$settings->add(new admin_setting_configtext(
            'openveo_videos/serverhost',
            get_string('genconfserverhostlabel', 'block_openveo_videos'),
            get_string('genconfserverhostdesc', 'block_openveo_videos'),
            '',
            PARAM_RAW
        ));

// Server port
$settings->add(new admin_setting_configtext(
            'openveo_videos/serverport',
            get_string('genconfserverportlabel', 'block_openveo_videos'),
            get_string('genconfserverportdesc', 'block_openveo_videos'),
            '',
            PARAM_INT
        ));

// Client id
$settings->add(new admin_setting_configtext(
            'openveo_videos/clientid',
            get_string('genconfclientidlabel', 'block_openveo_videos'),
            get_string('genconfclientiddesc', 'block_openveo_videos'),
            '',
            PARAM_ALPHANUM
        ));

// Client secret
$settings->add(new admin_setting_configtext(
            'openveo_videos/clientsecret',
            get_string('genconfclientsecretlabel', 'block_openveo_videos'),
            get_string('genconfclientsecretdesc', 'block_openveo_videos'),
            '',
            PARAM_ALPHANUM
        ));

// Advanced settings fieldset
$settings->add(new admin_setting_heading(
            'openveo_videos/advancedconfig',
            get_string('genconfadvancedconfigheader', 'block_openveo_videos'),
            get_string('genconfadvancedconfigdesc', 'block_openveo_videos')
        ));

// Token path
$settings->add(new admin_setting_configtext(
            'openveo_videos/tokenpath',
            get_string('genconftokenpathlabel', 'block_openveo_videos'),
            get_string('genconftokenpathdesc', 'block_openveo_videos'),
            'ws/token',
            PARAM_SAFEPATH
        ));

// Videos path
$settings->add(new admin_setting_configtext(
            'openveo_videos/videospath',
            get_string('genconfvideospathlabel', 'block_openveo_videos'),
            get_string('genconfvideospathdesc', 'block_openveo_videos'),
            'ws/publish/videos',
            PARAM_SAFEPATH
        ));
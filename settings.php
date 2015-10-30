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

// Application configuration fieldset
$settings->add(new admin_setting_heading(
            'openveo_videos/headerconfig',
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

// Web service configuration fieldset
$settings->add(new admin_setting_heading(
            'openveo_videos/wsheaderconfig',
            get_string('genconfwsheader', 'block_openveo_videos'),
            get_string('genconfwsdesc', 'block_openveo_videos')
        ));

// Web Service server host
$settings->add(new admin_setting_configtext(
            'openveo_videos/wsserverhost',
            get_string('genconfwsserverhostlabel', 'block_openveo_videos'),
            get_string('genconfwsserverhostdesc', 'block_openveo_videos'),
            '',
            PARAM_RAW
        ));

// Web Service server port
$settings->add(new admin_setting_configtext(
            'openveo_videos/wsserverport',
            get_string('genconfwsserverportlabel', 'block_openveo_videos'),
            get_string('genconfwsserverportdesc', 'block_openveo_videos'),
            '',
            PARAM_INT
        ));

// Client id
$settings->add(new admin_setting_configtext(
            'openveo_videos/wsclientid',
            get_string('genconfwsclientidlabel', 'block_openveo_videos'),
            get_string('genconfwsclientiddesc', 'block_openveo_videos'),
            '',
            PARAM_ALPHANUM
        ));

// Client secret
$settings->add(new admin_setting_configtext(
            'openveo_videos/wsclientsecret',
            get_string('genconfwsclientsecretlabel', 'block_openveo_videos'),
            get_string('genconfwsclientsecretdesc', 'block_openveo_videos'),
            '',
            PARAM_ALPHANUM
        ));

// Advanced settings fieldset
$settings->add(new admin_setting_heading(
            'openveo_videos/advancedconfig',
            get_string('genconfadvheader', 'block_openveo_videos'),
            get_string('genconfadvdesc', 'block_openveo_videos')
        ));

// Videos path
$settings->add(new admin_setting_configtext(
            'openveo_videos/videospath',
            get_string('genconfadvvideospathlabel', 'block_openveo_videos'),
            get_string('genconfadvvideospathdesc', 'block_openveo_videos'),
            'publish/videos',
            PARAM_SAFEPATH
        ));

// Videos path
$settings->add(new admin_setting_configtext(
            'openveo_videos/videoproperty',
            get_string('genconfadvvideoproplabel', 'block_openveo_videos'),
            get_string('genconfadvvideopropdesc', 'block_openveo_videos'),
            'moodle',
            PARAM_SAFEPATH
        ));
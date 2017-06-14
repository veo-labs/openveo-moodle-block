<?php
// This file is part of OpenVeo - http://www.veo-labs.com/suite-logicielle-openveo

/**
 * Defines block's global configuration.
 *
 * @package block_openveo_videos
 * @copyright 2015, veo-labs <info@veo-labs.com>
 * @license AGPL
 */

defined('MOODLE_INTERNAL') || die;

// Get the list of videos
require_once('require_openveo.php');
use Openveo\Client\Client as OpenveoClient;

// Retrieve block configuration
$wsserverurl = rtrim(get_config('openveo_videos', 'wsserverurl'), '/');
$wsservercertificate = get_config('openveo_videos', 'wsservercertificate');
$clientid = get_config('openveo_videos', 'wsclientid');
$clientsecret = get_config('openveo_videos', 'wsclientsecret');

$properties;
$choices = array();
try {

    // Make an authentication to the OpenVeo Web Service
    $client = new OpenveoClient($wsserverurl, $clientid, $clientsecret, $wsservercertificate);

    // Get all videos associated to the course
    $response = $client->get('/publish/properties');
    if(isset($response->entities)) {
        $properties = $response->entities;
        for ($i = 0; $i < count($properties); $i++){
            $choices[$properties[$i]->id] = $properties[$i]->name;
        }
    }
} catch(Exception $e) {

}

// Application configuration fieldset
$settings->add(new admin_setting_heading(
            'openveo_videos/headerconfig',
            get_string('genconfheader', 'block_openveo_videos'),
            get_string('genconfdesc', 'block_openveo_videos')
        ));

// Server host
$settings->add(new admin_setting_configtext(
            'openveo_videos/serverurl',
            get_string('genconfserverurllabel', 'block_openveo_videos'),
            get_string('genconfserverurldesc', 'block_openveo_videos'),
            '',
            PARAM_RAW
        ));

// Web service configuration fieldset
$settings->add(new admin_setting_heading(
            'openveo_videos/wsheaderconfig',
            get_string('genconfwsheader', 'block_openveo_videos'),
            get_string('genconfwsdesc', 'block_openveo_videos')
        ));

// Web Service server url
$settings->add(new admin_setting_configtext(
            'openveo_videos/wsserverurl',
            get_string('genconfwsserverurllabel', 'block_openveo_videos'),
            get_string('genconfwsserverurldesc', 'block_openveo_videos'),
            '',
            PARAM_RAW
        ));

// Web Service server certificate path
$settings->add(new admin_setting_configtext(
            'openveo_videos/wsservercertificate',
            get_string('genconfwsservercertificatelabel', 'block_openveo_videos'),
            get_string('genconfwsservercertificatedesc', 'block_openveo_videos'),
            '',
            PARAM_RAW
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
            get_string(!empty($choices) ? 'genconfadvdesc' : 'genconfadvdescbadparams', 'block_openveo_videos')
        ));

if(!empty($choices)){

    // Videos property
    $settings->add(new admin_setting_configselect(
                'openveo_videos/videoproperty',
                get_string('genconfadvvideoproplabel', 'block_openveo_videos'),
                get_string('genconfadvvideopropdesc', 'block_openveo_videos'),
                null,
                $choices
            ));

}

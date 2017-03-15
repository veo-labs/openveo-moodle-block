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
$wsserverhost = get_config('openveo_videos', 'wsserverhost');
$wsserverport = get_config('openveo_videos', 'wsserverport');
$clientid = get_config('openveo_videos', 'wsclientid');
$clientsecret = get_config('openveo_videos', 'wsclientsecret');

$properties;
$choices = array();
try {
    $url = 'http://'.$wsserverhost.':'.$wsserverport.'/publish/properties';

    // Make an authentication to the OpenVeo Web Service
    $client = new OpenveoClient($clientid, $clientsecret, $wsserverhost, $wsserverport);

    // Get all videos associated to the course
    $response = $client->get($url);
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
            80,
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
            8080,
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

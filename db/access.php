<?php
// This file is part of OpenVeo - http://www.veo-labs.com/suite-logicielle-openveo
//
// TODO : Add License information here

/**
 * Defines openveo_videos plugin permissions.
 *
 * Permissions :
 * - addinstance : permission to add the block to a page
 * - edit : permission to edit block videos
 *
 * @package block_openveo_videos
 * @copyright 2015, veo-labs <info@veo-labs.com>
 * @license TODO
 */
defined('MOODLE_INTERNAL') || die;

$capabilities = array(

    'block/openveo_videos:addinstance' => array(
        'riskbitmask' => RISK_SPAM | RISK_XSS,
        'captype' => 'write',
        'contextlevel' => CONTEXT_BLOCK,
        'archetypes' => array(
            'coursecreator' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        ),

        'clonepermissionsfrom' => 'moodle/site:manageblocks'
    ),

    'block/openveo_videos:edit' => array(
        'riskbitmask' => RISK_SPAM,
        'captype' => 'write',
        'contextlevel' => CONTEXT_BLOCK,
        'archetypes' => array(
            'coursecreator' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        )
    ),

 );

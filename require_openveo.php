<?php
// This file is part of OpenVeo - http://www.veo-labs.com/suite-logicielle-openveo

/**
 * Requires OpenVeo REST client library.
 *
 * @package block_openveo_videos
 * @copyright 2015, veo-labs <info@veo-labs.com>
 * @license AGPL
 */

$libAutoload = 'lib/openveo-rest-php-client/autoload_dist.php';
if(file_exists(__DIR__.'/'.$libAutoload))
    require_once($libAutoload);
else
    throw new moodle_exception('OpenVeo REST Client not installed');
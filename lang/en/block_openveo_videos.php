<?php
// This file is part of OpenVeo - http://www.veo-labs.com/suite-logicielle-openveo
//
// TODO : Add License information here

/**
 * Defines english translations of the plugin.
 *
 * @package block_openveo_videos
 * @copyright 2015, veo-labs <info@veo-labs.com>
 * @license TODO
 */

$string['pluginname'] = 'OpenVeo videos';

// Instance configuration form
$string['inconfblocktitlelabel'] = 'Videos';
$string['inconfblocktitlelabel_help'] = 'The title of the block as it will appear on top of the block.';

// Block
$string['blockvideodate'] = 'Video on {$a->month}/{$a->day}/{$a->year}';
$string['blockvideoslink'] = 'See all videos';

// Page listing videos
$string['listtitle'] = 'All videos of course "{$a}"';
$string['listsettingstitle'] = 'Block title';
$string['listsettingslink'] = 'See all videos';
$string['listinvalidcourse'] = 'The course you\'re looking for does not exist';
$string['listaccessrefused'] = 'You don\'t have permission to access this page';
$string['listtablepictureheader'] = 'Picture';
$string['listtablenameheader'] = 'Name';
$string['listtabledateheader'] = 'Date';
$string['listtableactionheader'] = 'Action';
$string['listvideodate'] = '{$a->month}/{$a->day}/{$a->year}';
$string['listvideovalidate'] = 'Validate';
$string['listvideounvalidate'] = 'Unvalidate';
$string['listvalidatedvideostitle'] = 'Video(s) validated';
$string['listnotvalidatedvideostitle'] = 'Video(s) to validate';

// Player
$string['playertitle'] = '{$a}';
$string['playerinvalidvideo'] = 'You don\'t have permission to access this video';
$string['playeraccessrefused'] = 'You don\'t have permission to access this page';
$string['playerinvalidcourse'] = 'The course you\'re looking for does not exist';

// Capabilities
$string['openveo_videos:addinstance'] = 'Add a new OpenVeo videos block';
$string['openveo_videos:edit'] = 'Edit videos associated to a course';

// Settings page.
$string['settingstitle'] = 'OpenVeo Videos Block settings';
$string['settingslinktitle'] = 'OpenVeo Videos';
$string['settingsvideocustompropertylabel'] = 'OpenVeo custom property';
$string['settingsvideocustomproperty'] = 'OpenVeo custom property';
$string['settingsvideocustomproperty_help'] = 'Choose the OpenVeo custom property holding the Moodle course id. You can then associate an OpenVeo video to a course by setting the course id in this custom property.';
$string['settingsvideocustompropertychoose'] = 'Choose...';
$string['settingssubmitlabel'] = 'Save changes';

// Errors.
$string['errorlocalpluginnotconfigured'] = 'Local plugin "OpenVeo API" is not configured.';
$string['errornocustomproperties'] = 'No custom property configured in OpenVeo Publish.';

// Events.
$string['eventgettingcustompropertiesfailed'] = 'Getting custom properties failed';

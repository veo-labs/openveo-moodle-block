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

// Global server configuration form
$string['genconfheader'] = 'Server configuration';
$string['genconfdesc'] = 'Configure access to the OpenVeo server. Courses videos are stored in the OpenVeo server.';
$string['genconfserverhostlabel'] = 'Server host';
$string['genconfserverhostdesc'] = 'The OpenVeo HTTP server host without the protocol nor slashes (e.g. 127.0.0.1)';
$string['genconfserverportlabel'] = 'Server port';
$string['genconfserverportdesc'] = 'HTTP server port (e.g. 3000)';

// Global Web Service configuration form
$string['genconfwsheader'] = 'Web Service configuration';
$string['genconfwsdesc'] = 'Configure access to the OpenVeo Web Service. Courses videos are stored in the OpenVeo server. Moodle OpenVeo videos block uses OpenVeo Web Service to request all videos associated to a course. All fields must be populated to retrieve the list of videos from OpenVeo Web Service. If you haven\'t all the information to complete the form, please contact the OpenVeo administrator.';
$string['genconfwsserverhostlabel'] = 'Web Service server host';
$string['genconfwsserverhostdesc'] = 'The OpenVeo Web Service HTTP server host without the protocol nor slashes (e.g. 127.0.0.1)';
$string['genconfwsserverportlabel'] = 'Web Service server port';
$string['genconfwsserverportdesc'] = 'The OpenVeo Web Service HTTP server port (e.g. 3000)';
$string['genconfwsclientidlabel'] = 'Client id';
$string['genconfwsclientiddesc'] = 'Moodle client id to access OpenVeo web service (e.g 7c6892011e67ca05be3754137308a01a27ade9f3)';
$string['genconfwsclientsecretlabel'] = 'Client secret';
$string['genconfwsclientsecretdesc'] = 'Moodle client secret to access OpenVeo web service (e.g 128f5fd5d980fa7f261bc1592f7f3a44c0e5fc42)';

// Global advanced configuration form
$string['genconfadvheader'] = 'Web Service advanced configuration';
$string['genconfadvdesc'] = 'These settings must be modified only by an OpenVeo administrator. Changing these settings may broke the block.';
$string['genconfadvtokenpathlabel'] = 'Token path';
$string['genconfadvtokenpathdesc'] = 'The Web Service path to get a token';
$string['genconfadvvideospathlabel'] = 'Videos path';
$string['genconfadvvideospathdesc'] = 'The Web Service path to get the list of videos';

// Instance configuration form
$string['inconfblocktitlelabel'] = 'OpenVeo videos';
$string['inconfblocktitlelabel_help'] = 'The title of the block as it will appear on top of the block.';

// Block
$string['blockvideodate'] = 'Video on {$a->month}/{$a->day}/{$a->year}';
$string['blockvideoslink'] = 'See all videos';

// Page listing videos
$string['listtitle'] = 'All videos of course "{$a}"';
$string['listsettingstitle'] = 'OpenVeo videos';
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

// Capabilities
$string['openveo_videos:addinstance'] = 'Add a new OpenVeo videos block';
$string['openveo_videos:viewlist'] = 'View the list of videos of a course while not enrolled';
$string['openveo_videos:editlist'] = 'Edit the list of videos of a course';
$string['openveo_videos:viewblock'] = 'View the block while not enrolled';
$string['openveo_videos:viewvideo'] = 'View the video while not enrolled and video not validated';
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
 * Presents a video using OpenVeo player.
 *
 * It requires a course id, a video id and a user associated to the course to proceed
 *
 * @package block_openveo_videos
 * @copyright 2018 Veo-labs
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
global $DB, $OUTPUT, $PAGE, $USER, $CFG, $FULLSCRIPT;

/**
 * Renders the player using embedded OpenVeo player.
 *
 * @param string $videourl The url of the OpenVeo player
 */
function block_openveo_videos_render_player($videourl) {
    global $CFG;
    ob_start();
    require_once(__DIR__.'/templates/player.tpl.php');
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

// Requires params "courseid" and "videoid" to continue.
$courseid = required_param('courseid', PARAM_INT);
$videoid = required_param('videoid', PARAM_TEXT);

// Retrieve course information.
if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('playerinvalidcourse', 'block_openveo_videos');
}

// Checks if user has access to the page or not.
require_login($course);
$context = context_course::instance($COURSE->id);
$isEnrolled = is_enrolled($context);
$hasCapabilityToEdit = has_capability('block/openveo_videos:edit', $context);

// User can't see this page.
// Only enrolled or block editors can see the player.
if (!$isEnrolled && !$hasCapabilityToEdit) {
    print_error('playeraccessrefused', 'block_openveo_videos');
}

$video = $DB->get_record('block_openveo_videos', array('videoid' => $videoid, 'courseid' => $COURSE->idnumber));

// Checks if video is validated.
// Video does not exist or user can't see it.
if (((!$video && !$hasCapabilityToEdit) || ($video && $video->isvalidated == 0 && !$hasCapabilityToEdit))) {
    print_error('playerinvalidvideo', 'block_openveo_videos');
}

// Retrieve OpenVeo serveur configuration.
$serverurl = rtrim(get_config('local_openveo_api', 'cdnurl'), '/');

// Build video url.
$videourl = "$serverurl/publish/video/$videoid?fullscreen";

// Set page url to call when returning to this page.
$PAGE->set_url('/blocks/openveo_videos/player.php', array('courseid' => $courseid, 'videoid' => $videoid));

// Include player css.
$PAGE->requires->css('/blocks/openveo_videos/css/player.css');

// Set page layout.
$PAGE->set_pagelayout('standard');

// Set page title.
$PAGE->set_heading(get_string('playertitle', 'block_openveo_videos', $course->shortname));

// Set breadcrumb.
$settingsnode = $PAGE->settingsnav->add(get_string('listsettingstitle', 'block_openveo_videos'));
$editurl = new moodle_url('/blocks/openveo_videos/view.php', array('courseid' => $courseid));
$editnode = $settingsnode->add(get_string('listsettingslink', 'block_openveo_videos'), $editurl);
$editnode->make_active();

echo $OUTPUT->header();
echo block_openveo_videos_render_player($videourl);
echo $OUTPUT->footer();

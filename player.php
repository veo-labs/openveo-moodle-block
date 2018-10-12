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

use block_openveo_videos\output\player_page;

global $DB, $OUTPUT, $PAGE;

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

$renderer = $PAGE->get_renderer('block_openveo_videos');
$playerpage = new player_page($videoid, $courseid, $PAGE);

$PAGE->set_heading(get_string('playertitle', 'block_openveo_videos', $course->shortname));

echo $OUTPUT->header();
echo format_text($renderer->render($playerpage), FORMAT_HTML);
echo $OUTPUT->footer();

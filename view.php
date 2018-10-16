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
 * Presents the list of videos.
 *
 * It requires a course id to proceed and user associated to the course.
 *
 * @package block_openveo_videos
 * @copyright 2018 Veo-labs
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');

// Include OpenVeo REST PHP client autoloader.
require_once($CFG->dirroot . '/local/openveo_api/lib.php');

use Openveo\Client\Client;
use block_openveo_videos\local\videos_provider;
use block_openveo_videos\output\manage_page;

global $DB, $OUTPUT, $PAGE, $USER, $CFG, $FULLSCRIPT;

// Requires param "courseid" to continue.
$courseid = required_param('courseid', PARAM_INT);

// Retrieve course information.
if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('listinvalidcourse', 'block_openveo_videos');
}

// Checks if user has access to the page or not.
require_login($course);
$context = context_course::instance($COURSE->id);
$isEnrolled = is_enrolled($context);
$hasCapabilityToEdit = has_capability('block/openveo_videos:edit', $context);

// User can't see this page.
// Only enrolled or block editors can see the list.
if (!$isEnrolled && !$hasCapabilityToEdit) {
    print_error('listaccessrefused', 'block_openveo_videos');
}

// Handles actions.
$action = optional_param('action', null, PARAM_TEXT);
$videoid = optional_param('videoid', null, PARAM_TEXT);
$videosprovider = new videos_provider($DB);

if (!empty($action) && !empty($videoid) && $hasCapabilityToEdit) {
    if ($action === 'validate') {
        $videosprovider->validate_course_video($course->idnumber, $videoid);
    } else if($action === 'unvalidate') {
        $videosprovider->unvalidate_course_video($course->idnumber, $videoid);
    }
}

$renderer = $PAGE->get_renderer('block_openveo_videos');
$managepage = new manage_page($course, $PAGE, "{$CFG->wwwroot}/blocks/openveo_videos", $videosprovider, $hasCapabilityToEdit);

echo $OUTPUT->header();
echo $renderer->render($managepage);
echo $OUTPUT->footer();

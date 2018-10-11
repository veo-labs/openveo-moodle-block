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

global $DB, $OUTPUT, $PAGE, $USER, $CFG, $FULLSCRIPT;

/**
 * Renders the list of videos.
 *
 * @param string $tableofvideos Table of validated videos as HTML
 * @param string $tableofvideostovalidate Table of not validated videos as HTML
 * @param bool $hasCapabilityToEdit true if the actual user can edit the list (validate / unvalidate)
 */
function block_openveo_videos_render_list($tableofvideos, $tableofvideostovalidate, $hasCapabilityToEdit) {
    global $CFG;
    $pluginPath = "{$CFG->wwwroot}/blocks/openveo_videos/";
    ob_start();
    require_once(__DIR__.'/templates/list.tpl.php');
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

/**
 * Validates / unvalidates a video.
 *
 * @param string $courseextid The external id of the course
 * @param string $videoid The id of the video
 * @param bool $validate true to validate the video, false to unvalidate
 */
function block_openveo_videos_update_video($courseextid, $videoid, $validate) {
    global $DB;
    $video = $DB->get_record('block_openveo_videos', array('videoid' => $videoid, 'courseid' => $courseextid));

    if (!$video) {

        // Insert.
        $record = new stdClass();
        $record->courseid = $courseextid;
        $record->videoid = $videoid;
        $record->isvalidated = $validate ? 1 : 0;

        $newrecord = $DB->insert_record('block_openveo_videos', $record);
    } else if (($video->isvalidated == 0 && $validate) || ($video->isvalidated == 1 && !$validate)) {

        // Update.
        $record = new stdClass();
        $record->id = $video->id;
        $record->isvalidated = $validate ? 1 : 0;
        $DB->update_record('block_openveo_videos', $record);

  }
}

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

if (!empty($action) && !empty($videoid) && $hasCapabilityToEdit) {
    if ($action === 'validate') {
        block_openveo_videos_update_video($course->idnumber, $videoid, true);
    } else if($action === 'unvalidate') {
        block_openveo_videos_update_video($course->idnumber, $videoid, false);
    }
}

// Retrieve block configuration.
$wsserverurl = get_config('local_openveo_api', 'webserviceurl');
$clientid = get_config('local_openveo_api', 'webserviceclientid');
$clientsecret = get_config('local_openveo_api', 'webserviceclientsecret');
$wsservercertificate = get_config('local_openveo_api', 'webservicecertificatefilepath');
$videoproperty = get_config('block_openveo_videos', 'videocustomproperty');

$pluginPath = "{$CFG->wwwroot}/blocks/openveo_videos/";
$tableofvideostovalidate = new html_table();
$tableofvideosvalidated = new html_table();

try {
    $param = [
        'sortBy' => 'date',
        'sortOrder' => 'asc',
        'states' => 12,
        'properties' => [
            $videoproperty => $course->idnumber
        ]
    ];
    $query = http_build_query($param, '', '&');

    // Make an authentication to the OpenVeo Web Service.
    $client = new Client($wsserverurl, $clientid, $clientsecret, $wsservercertificate);

    // Get all videos associated to the course.
    $response = $client->get("/publish/videos?$query");

    // Retrieve already validated videos.
    $validatedvideos = $DB->get_records('block_openveo_videos', array('isvalidated' => 1, 'courseid' => $course->idnumber));

    if (isset($response->entities)) {
        $videos = $response->entities;
        $tableheaders = array(
            get_string('listtablepictureheader', 'block_openveo_videos'),
            get_string('listtablenameheader', 'block_openveo_videos'),
            get_string('listtabledateheader', 'block_openveo_videos')
        );

        if ($hasCapabilityToEdit) {
            $tableheaders[] = get_string('listtableactionheader', 'block_openveo_videos');
            $tableofvideostovalidate->head = $tableheaders;
        }

        // Initializes both tables with validated and not validaded videos.
        $tableofvideosvalidated->head = $tableheaders;

        // Iterate through videos.
        foreach ($videos as $video) {
            $row = array();
            $videovalidated = false;

            // Checks if video is validated.
            if (!empty($validatedvideos)) {
                foreach ($validatedvideos as $validatedvideo) {
                    if (($validatedvideo->videoid === $video->id && $validatedvideo->isvalidated == 1)) {
                        $videovalidated = true;
                        break;
                    }
                }
            }

            // Image.
            $videopath = "{$pluginPath}player.php?courseid=$courseid&videoid{$video->id}";
            $videoThumb = isset($video->thumbnail) ? html_writer::tag('img', '', array('src' => $video->thumbnail, 'alt' => $video->title)) : '';

            $rowHtml = "<a href=\"$videopath\" title=\"{$video->title}\">";

            if (!empty($videoThumb)) {
                $rowHtml .= $videoThumb;
            } else {
                $rowHtml .= '<div class="ov-placeholder"></div>';
            }

            $rowHtml .= '<div class="ov-play"><div><div><div class="ov-play-icon"></div></div></div></div>';
            $row[] = $rowHtml;

            // Name.
            $row[] = $video->title;

            // Date.
            // Build video date.
            $viveomoodledate = usergetdate($video->date / 1000);
            $videodate = new StdClass();
            $videodate->day = ($viveomoodledate['mday'] < 10) ? "0{$viveomoodledate['mday']}" : $viveomoodledate['mday'];
            $videodate->month = ($viveomoodledate['mon'] < 10) ? "0{$viveomoodledate['mon']}" : $viveomoodledate['mon'];
            $videodate->year = $viveomoodledate['year'];
            $row[] = get_string('listvideodate', 'block_openveo_videos', $videodate);

            if ($videovalidated) {

                // Insert video in validated table.
                // Action.
                if ($hasCapabilityToEdit) {
                    $row[] = html_writer::link("$FULLSCRIPT?courseid=$courseid&action=unvalidate&videoid={$video->id}", get_string('listvideounvalidate', 'block_openveo_videos'));
                }

                $tableofvideosvalidated->data[] = $row;
            } else if ($hasCapabilityToEdit) {

                // Insert video in not validated table.
                // Action.
                $row[] = html_writer::link("$FULLSCRIPT?courseid=$courseid&action=validate&videoid={$video->id}", get_string('listvideovalidate', 'block_openveo_videos'));

                $tableofvideostovalidate->data[] = $row;
            }

        }
    }
} catch(Exception $e) {

    // TODO Log the error.

}

// Set page url to call when returning to this page.
$PAGE->set_url('/blocks/openveo_videos/view.php', array('courseid' => $courseid));

// Include page css.
$PAGE->requires->css('/blocks/openveo_videos/css/list.css');

// Set page layout.
$PAGE->set_pagelayout('standard');

// Set page title.
$PAGE->set_heading(get_string('listtitle', 'block_openveo_videos', $course->shortname));

// Set breadcrumb.
$settingsnode = $PAGE->settingsnav->add(get_string('listsettingstitle', 'block_openveo_videos'));
$editurl = new moodle_url('/blocks/openveo_videos/view.php', array('courseid' => $courseid));
$editnode = $settingsnode->add(get_string('listsettingslink', 'block_openveo_videos'), $editurl);
$editnode->make_active();

echo $OUTPUT->header();
echo block_openveo_videos_render_list(html_writer::table($tableofvideosvalidated), html_writer::table($tableofvideostovalidate), $hasCapabilityToEdit);
echo $OUTPUT->footer();

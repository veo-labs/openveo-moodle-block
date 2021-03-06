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
 * openveo_videos block definition.
 *
 * @package block_openveo_videos
 * @copyright 2018 Veo-labs
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Include OpenVeo REST PHP client autoloader.
require_once($CFG->dirroot . '/local/openveo_api/lib.php');

use Openveo\Client\Client;
use block_openveo_videos\output\openveo_videos_block;

/**
 * Defines a new block presenting OpenVeo videos associated to a course.
 *
 * The block presents the last published video for the course and a link to access the complete list of videos associated to the course.
 *
 * @package block_openveo_videos
 * @copyright 2018 Veo-labs
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_openveo_videos extends block_base {

    /**
     * Initializes block's default title.
     */
    public function init() {
        $this->title = get_string('pluginname', 'block_openveo_videos');
    }

    /**
     * Sets block content (title, text and footer).
     *
     * If current user does not have the permission to visualize the bloc it won't be displayed
     *
     * @return stdClass A PHP object with title, text and footer properties
     */
    public function get_content() {
        global $COURSE, $CFG, $DB, $PAGE;

        // Content already generated.
        if ($this->content !== NULL) {
            return $this->content;
        }

        $this->content = null;
        $courseid = $COURSE->id;
        $context = context_course::instance($courseid);
        $renderer = $PAGE->get_renderer('block_openveo_videos');

        // Checks if user has the permission to see the block and its content.
        $isEnrolled = is_enrolled($context);
        $hasCapabilityToEdit = has_capability('block/openveo_videos:edit', $context);

        // User has the permission to see the block.
        // All enrolled users can see the block.
        // If a user is not enrolled, he can not see the block unless he can edit it.
        if (!empty($courseid) && ($isEnrolled || $hasCapabilityToEdit)) {
            $this->content = new StdClass();
            $serverurl = rtrim(get_config('local_openveo_api', 'webserviceurl'), '/');
            $clientid = get_config('local_openveo_api', 'webserviceclientid');
            $clientsecret = get_config('local_openveo_api', 'webserviceclientsecret');
            $servercertificate = get_config('local_openveo_api', 'webservicecertificatefilepath');
            $videoproperty = get_config('block_openveo_videos', 'videocustomproperty');

            try {
                $param = [
                    'sortBy' => 'date',
                    'sortOrder' => 'asc',
                    'states' => 12,
                    'properties' => [
                        $videoproperty => $COURSE->idnumber
                    ]
                ];
                $query = http_build_query($param, '', '&');

                // Make an authentication to the OpenVeo Web Service.
                $client = new Client($serverurl, $clientid, $clientsecret, $servercertificate);

                $response = $client->get("/publish/videos?$query");

                $validatedvideos = $DB->get_records('block_openveo_videos', array('isvalidated' => 1, 'courseid' => $COURSE->idnumber));

                // Got a list of videos.
                if (isset($response->entities) && !empty($response->entities)) {
                    $videos = $response->entities;
                    $videovalidated = false;
                    $focusedvideo = null;

                    // There is, at least, one validated video.
                    if (!empty($validatedvideos)) {

                        // Iterate through videos.
                        foreach ($videos as $video) {

                            // Search video in validated videos.
                            foreach ($validatedvideos as $validatedvideo) {
                                if ($validatedvideo->isvalidated == 1 && $validatedvideo->videoid === $video->id) {
                                    $focusedvideo = $video;
                                    $videovalidated = true;
                                    break;
                                }
                            }

                            if ($videovalidated) {
                                break;
                            }
                        }
                    }

                    $openveovideosblock = null;

                    if (!empty($focusedvideo) && $videovalidated) {

                        // Got a video for the block.
                        // Display block.

                        $openveovideosblock = new openveo_videos_block($focusedvideo, $courseid, "{$CFG->wwwroot}/blocks/openveo_videos");
                        $this->content->text = $renderer->render($openveovideosblock);

                    } else if ($hasCapabilityToEdit) {

                        // No video for the block but there are videos associated to the course.
                        // Display an empty block with a link to the list of videos.

                        $openveovideosblock = new openveo_videos_block(null, $courseid, "{$CFG->wwwroot}/blocks/openveo_videos");
                        $this->content->text = $renderer->render($openveovideosblock);

                    }

                }
            } catch(Exception $e) {

                // TODO Log the error.

            }

        }

        return $this->content;
    }

    /**
     * Sets block's title using block's instance configuration.
     */
    public function specialization() {
        if (isset($this->config)) {
            if (empty($this->config->title)) {
                $this->title = get_string('pluginname', 'block_openveo_videos');
            } else {
                $this->title = $this->config->title;
            }
        }
    }

    /**
     * Restricts access to the block.
     *
     * Block can be added only on a course page.
     *
     * @return array A list of formats with a boolean as value
     */
    public function applicable_formats() {
        return array('course-view' => true);
    }

    /**
     * Allows multiple instances of the block.
     *
     * @return bool true to allow multiple instances
     */
    public function instance_allow_multiple() {
        return true;
    }

    /**
     * Informs Moodle that the block has a global configuration file.
     *
     * @return bool true to tell Moodle about the settings.php file
     */
    function has_config() {
        return true;
    }

}

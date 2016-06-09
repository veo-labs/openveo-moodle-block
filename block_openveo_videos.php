<?php
// This file is part of OpenVeo - http://www.veo-labs.com/suite-logicielle-openveo

/**
 * openveo_videos block definition.
 *
 * @package block_openveo_videos
 * @copyright 2015, veo-labs <info@veo-labs.com>
 * @license AGPL
 */

require_once('require_openveo.php');
use Openveo\Client\Client as OpenveoClient;

/**
 * Defines a new block presenting OpenVeo videos associated to a course.
 *
 * The block presents the last published video for the course and a link to access the complete list of videos associated to the course.
 *
 * @package block_openveo_videos
 * @copyright 2015, veo-labs <info@veo-labs.com>
 * @license AGPL
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
     * @return StdClass A PHP object with title, text and footer properties
     */
    public function get_content() {
        global $COURSE, $CFG, $DB;

        // Content already generated
        if($this->content !== NULL) {
            return $this->content;
        }

        $this->content = null;
        $courseid = $COURSE->id;
        $context = context_course::instance($courseid);

        // Checks if user has the permission to see the block and its
        // content
        $isEnrolled = is_enrolled($context);
        $hasCapabilityToEdit = has_capability('block/openveo_videos:edit', $context);

        // User has the permission to see the block
        // All enrolled users can see the block
        // If a user is not enrolled, he can not see the block unless he can edit it
        if(!empty($courseid) && ($isEnrolled || $hasCapabilityToEdit)) {
            $this->content = new StdClass();

            // Retrieve block configuration
            $serverhost = get_config('openveo_videos', 'wsserverhost');
            $serverport = get_config('openveo_videos', 'wsserverport');
            $clientid = get_config('openveo_videos', 'wsclientid');
            $clientsecret = get_config('openveo_videos', 'wsclientsecret');
            $videoproperty = get_config('openveo_videos', 'videoproperty');

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
                $url = 'http://' . $serverhost . ':' . $serverport . '/publish/videos?' . $query;

                // Make an authentication to the OpenVeo Web Service
                $client = new OpenveoClient($clientid, $clientsecret, $serverhost, $serverport);

                $response = $client->get($url);

                $validatedvideos = $DB->get_records('block_openveo_videos', array('isvalidated' => 1, 'courseid' => $COURSE->idnumber));

                // Got a list of videos
                if(isset($response->entities) && !empty($response->entities)) {
                    $videos = $response->entities;
                    $videovalidated = false;
                    $video = null;

                    // There is, at least, one validated video
                    if(!empty($validatedvideos)) {

                        // Iterate through videos
                        for($i = 0 ; $i < sizeof($videos) ; $i++) {

                            // Search video in validated videos
                            foreach($validatedvideos as $validatedvideo) {
                                if($validatedvideo->isvalidated == 1 && $validatedvideo->videoid === $videos[$i]->id) {
                                    $video = $videos[$i];
                                    $videovalidated = true;
                                    break;
                                }
                            }

                            if($videovalidated)
                                break;
                        }
                    }

                    // Url for the list of videos associated to this course id
                    $videosurl = $CFG->wwwroot.'/blocks/openveo_videos/view.php?courseid='.$courseid;

                    if(!empty($video) && $videovalidated) {

                        // Got a video for the block
                        // Display block

                        // Path to the video
                        $videopath = $CFG->wwwroot.'/blocks/openveo_videos/player.php?courseid='.$courseid.'&videoid='.$video->id;

                        // Video thumbnail
                        $thumbnailpath = isset($video->thumbnail) ? $video->thumbnail : null;

                        // Build video date
                        $videomoodledate = usergetdate($video->date/1000);
                        $videodate = new StdClass();
                        $videodate->day = ($videomoodledate['mday'] < 10) ? '0'.$videomoodledate['mday'] : $videomoodledate['mday'];
                        $videodate->month = ($videomoodledate['mon'] < 10) ? '0'.$videomoodledate['mon'] : $videomoodledate['mon'];
                        $videodate->year = $videomoodledate['year'];

                        // Build content
                        $this->content->text = $this->render_block($video->title, $video->description, $videodate, $videosurl, $videopath, $thumbnailpath, $videovalidated);

                    } else if($hasCapabilityToEdit) {

                        // No video for the block but there are videos associated to the course
                        // Display an empty block with a link to the list of videos

                        $this->content->text = $this->render_block(null, null, null, $videosurl);
                    }
                }
            }
            catch(Exception $e) {

                // TODO Log the error

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
     * Informs Moodle that the block has a global ocnfiguration file.
     *
     * @return bool true to tell Moodle about the settings.php file
     */
    function has_config() {
        return true;
    }

    /**
     * Removes block general configuration when uninstalling.
     */
    function before_delete() {
        set_config('serverhost', null, 'openveo_videos');
        set_config('serverport', null, 'openveo_videos');
        set_config('clientid', null, 'openveo_videos');
        set_config('clientsecret', null, 'openveo_videos');
        set_config('wsserverhost', null, 'openveo_videos');
        set_config('wsserverport', null, 'openveo_videos');
        set_config('wsclientid', null, 'openveo_videos');
        set_config('wsclientsecret', null, 'openveo_videos');
        set_config('videoproperty', null, 'openveo_videos');
    }

    /**
     * Renders the block using the block template.
     *
     * @param string $videotitle The video title
     * @param string $videodescription The video description
     * @param stdClass $videodate The video date with day, month and year
     * @param string $videosurl Url to the list of videos associated to the course
     * @param string $videopath The url to the video
     * @param string $videothumb The url to the video thumbnail
     * @param bool $videovalidated true if video is validated, false otherwise
     */
    private function render_block($videotitle = null, $videodescription = null, $videodate = null, $videosurl = null, $videopath = null, $videothumb = null, $videovalidated = false) {
        global $CFG;
        $pluginPath = $CFG->wwwroot.'/blocks/openveo_videos/';
        $serverhost = get_config('openveo_videos', 'serverhost');
        $serverport = get_config('openveo_videos', 'serverport');
        ob_start();
        require_once(__DIR__.'/templates/block.tpl.php');
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

}
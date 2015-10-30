<?php
// This file is part of OpenVeo - http://www.veo-labs.com/suite-logicielle-openveo
//
// TODO : Add License information here

/**
 * openveo_videos block definition.
 *
 * @package block_openveo_videos
 * @copyright 2015, veo-labs <info@veo-labs.com>
 * @license TODO
 */

            
require 'vendor/autoload.php';
use Openveo\Client\Client as OpenveoClient;
/**
 * Defines a new block presenting OpenVeo videos associated to a course.
 *
 * The block presents the last published video for the course and a link to access the complete list of videos associated to the course. 
 *
 * @package block_openveo_videos
 * @copyright 2015, veo-labs <info@veo-labs.com>
 * @license TODO 
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
        $hasCapability = has_capability('block/openveo_videos:viewblock', $context);
        
        // User has the permission to see the block
        if(!empty($courseid) && ($isEnrolled || $hasCapability)){
            $this->content = new StdClass();

            // Retrieve block configuration
            $serverhost = get_config('openveo_videos', 'wsserverhost');
            $serverport = get_config('openveo_videos', 'wsserverport');
            $clientid = get_config('openveo_videos', 'wsclientid');
            $clientsecret = get_config('openveo_videos', 'wsclientsecret');
            $videospath = get_config('openveo_videos', 'videospath');
            $videoproperty = get_config('openveo_videos', 'videoproperty');
          
            try{
                $param = [
                    'limit' => 1,
                    'sortBy' => 'date',
                    'sortOrder' => 'asc',
                    'properties' => [
                        $videoproperty => $COURSE->idnumber
                    ]
                ];
                $query = http_build_query($param, '', '&');
                $url = 'http://' . $serverhost . ':' . $serverport . '/' . $videospath . '?' . $query;

                // Make an authentication to the OpenVeo Web Service
                $client = new OpenveoClient($clientid, $clientsecret, $serverhost, $serverport);

                $response = $client->get($url);
                $videos = $response->{'videos'};
                
                $validatedvideos = $DB->get_records('block_openveo_videos', array('isvalidated' => 1, 'courseid' => $COURSE->idnumber));

                // Got a list of videos
                if(isset($videos) && !empty($videos)){
                    // TODO Put some cache here

                    // Get first video date
                    $video = $videos[0];

                    $videovalidated = false;

                    // Checks if video is validated
                    if(!empty($validatedvideos)){
                        foreach($validatedvideos as $validatedvideo){
                            if(($validatedvideo->videoid === $video->id && $validatedvideo->isvalidated == 1)){
                                $videovalidated = true;
                                break;
                            }
                        }
                    }

                    if($videovalidated || has_capability('block/openveo_videos:viewblock', $context)){

                        // Url for the list of videos associated to this course id
                        $videosurl = $CFG->wwwroot.'/blocks/openveo_videos/view.php?courseid='.$courseid;

                        // Path to the video
                        $videopath = $CFG->wwwroot.'/blocks/openveo_videos/player.php?courseid='.$courseid.'&videoid='.$video->id;

                        // Build video date
                        $viveomoodledate = usergetdate($video->metadata->date);
                        $videodate = new StdClass();
                        $videodate->day = ($viveomoodledate['mday'] < 10) ? '0'.$viveomoodledate['mday'] : $viveomoodledate['mday'];
                        $videodate->month = ($viveomoodledate['mon'] < 10) ? '0'.$viveomoodledate['mon'] : $viveomoodledate['mon'];
                        $videodate->year = $viveomoodledate['year'];
                        
                        // Build content
                        $this->content->text = $this->render_block($video->title, $video->description, $videodate, $videosurl, $videopath, $video->thumbnail, $videovalidated);
                    }
                } 
            }
            catch(RestClientException $e){
                // TODO Log the error when Moodle has a good way to do it
            }
            catch(OpenveoWSException $e){
                // TODO Log the error when Moodle has a good way to do it
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
     * Renders the block using the block template.
     * 
     * @param string $videotitle The video title 
     * @param string $videodescription The video description 
     * @param stdClass $videodate The video date with day, month and year
     * @param string $videosurl Url to the list of videos associated to the course
     * @param string $videopath The url to the video
     * @param bool $videovalidated true if video is validated, false otherwise
     */
    private function render_block($videotitle, $videodescription, $videodate, $videosurl, $videopath, $videothumb, $videovalidated) {
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
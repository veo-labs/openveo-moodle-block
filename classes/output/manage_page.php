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
 * Defines the management page.
 *
 * @package block_openveo_videos
 * @copyright 2018 Veo-labs
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_openveo_videos\output;

defined('MOODLE_INTERNAL') || die();

// Include OpenVeo REST PHP client autoloader.
require_once($CFG->dirroot . '/local/openveo_api/lib.php');

use stdClass;
use Exception;
use renderable;
use templatable;
use renderer_base;
use moodle_page;
use moodle_url;
use moodle_exception;
use Openveo\Client\Client;
use Openveo\Exception\ClientException;
use local_openveo_api\event\requesting_openveo_failed;
use block_openveo_videos\event\getting_openveo_course_videos;
use block_openveo_videos\local\videos_provider;

/**
 * Defines the management page.
 *
 * The management page displays and manages the list of OpenVeo videos associated to a course.
 * If hascapabilitytoedit is set to true then all OpenVeo videos associated to the course are displayed separated into two categories: validated videos and not validated videos.
 * Validated videos are videos visible for all Moodle users, not validated videos are only available for users having required capabilities. With hascapabilitytoedit set to true, it
 * is also possible to validate / unvalidate a video.
 * If hascapabilitytoedit is set to false then only validated videos are displayed without the possibility to unvalidate them.
 *
 * @package block_openveo_videos
 * @copyright 2018 Veo-labs
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class manage_page implements renderable, templatable {

    /**
     * The Moodle page.
     *
     * @var moodle_page
     */
    protected $page;

    /**
     * Indicates if user has the permission to validate / unvalidate videos or not.
     *
     * @var bool
     */
    protected $hascapabilitytoedit;

    /**
     * The list of validated videos.
     *
     * @var array
     */
    protected $validatedvideos;

    /**
     * The list of not validated videos.
     *
     * @var array
     */
    protected $notvalidatedvideos;

    /**
     * Creates a player_page.
     *
     * @param stdClass $course The course
     * @param moodle_page $page The Moodle page
     * @param string $pluginbaseurl The base URL of the OpenVeo Videos Block plugin
     * @param videos_provider $videoprovider The validated / not validated videos provider
     * @param bool $hascapabilitytoedit true if to be able to validate / unvalidate videos
     */
    public function __construct(stdClass $course, moodle_page &$page, string $pluginbaseurl, videos_provider $videoprovider, bool $hascapabilitytoedit) {
        $this->hascapabilitytoedit = $hascapabilitytoedit;
        $webserviceurl = rtrim(get_config('local_openveo_api', 'webserviceurl'), '/');
        $webserviceclientid = get_config('local_openveo_api', 'webserviceclientid');
        $webserviceclientsecret = get_config('local_openveo_api', 'webserviceclientsecret');
        $webserviceservercertificate = get_config('local_openveo_api', 'webservicecertificatefilepath');
        $videocustomproperty = get_config('block_openveo_videos', 'videocustomproperty');

        // Create an OpenVeo web service client.
        try {
            $this->client = new Client($webserviceurl, $webserviceclientid, $webserviceclientsecret, $webserviceservercertificate);
        } catch(ClientException $e) {
            throw new moodle_exception('errorlocalpluginnotconfigured', 'block_openveo_videos');
        }

        $openveovideos = $this->get_openveo_course_videos($course->idnumber, $videocustomproperty);
        $this->validatedvideos = array();
        $this->notvalidatedvideos = array();

        if (sizeof($openveovideos) > 0) {

            // Retrieve already validated videos.
            try {
                $validatedvideoids = $videoprovider->get_course_validated_videos($course->idnumber);
            } catch(Exception $e) {
                throw new moodle_exception('errorgettingvalidatedvideosfailed', 'block_openveo_videos', null, $course->idnumber);
            }

            // Iterate through videos.
            foreach ($openveovideos as $openveovideo) {
                $videovalidated = !empty($openveovideo) && in_array($openveovideo->id, $validatedvideoids);
                $video = new stdClass();

                // Thumbnail.
                $video->title = $openveovideo->title;
                $video->url = "$pluginbaseurl/player.php?courseid={$course->id}&videoid={$openveovideo->id}";
                $video->thumbnailurl = isset($openveovideo->thumbnail) ? $openveovideo->thumbnail : null;

                // Date.
                // Build video date.
                $viveomoodledate = usergetdate($openveovideo->date / 1000);
                $videodate = new StdClass();
                $videodate->day = ($viveomoodledate['mday'] < 10) ? "0{$viveomoodledate['mday']}" : $viveomoodledate['mday'];
                $videodate->month = ($viveomoodledate['mon'] < 10) ? "0{$viveomoodledate['mon']}" : $viveomoodledate['mon'];
                $videodate->year = $viveomoodledate['year'];
                $video->date = get_string('listvideodate', 'block_openveo_videos', $videodate);

                if ($videovalidated) {

                    // Video validated.
                    // Insert video in the list of validated videos and set unvalidate action.
                    $video->actionlabel = get_string('listvideounvalidate', 'block_openveo_videos');
                    $video->actionlink = "$pluginbaseurl/view.php?courseid={$course->id}&action=unvalidate&videoid={$openveovideo->id}";
                    $this->validatedvideos[] = $video;

                } else {

                    // Video not validated.
                    // Insert video in the list of not validated videos and set validate action.
                    $video->actionlabel = get_string('listvideovalidate', 'block_openveo_videos');
                    $video->actionlink = "$pluginbaseurl/view.php?courseid={$course->id}&action=validate&videoid={$openveovideo->id}";
                    $this->notvalidatedvideos[] = $video;

                }
            }

        }

        // Set page information.
        $this->page = $page;
        $this->page->set_url('/blocks/openveo_videos/view.php', array('courseid' => $course->id));
        $this->page->requires->css('/blocks/openveo_videos/css/list.css');
        $this->page->set_pagelayout('standard');
        $this->page->set_heading(get_string('listtitle', 'block_openveo_videos', $course->shortname));

        // Set breadcrumb.
        $settingsnode = $this->page->settingsnav->add(get_string('listsettingstitle', 'block_openveo_videos'));
        $editurl = new moodle_url('/blocks/openveo_videos/view.php', array('courseid' => $course->id));
        $editnode = $settingsnode->add(get_string('listsettingslink', 'block_openveo_videos'), $editurl);
        $editnode->make_active();

    }

    /**
     * Exports page data to be exposed to the template.
     *
     * @see templatable
     * @param renderer_base $output Used to do a final render of any components that need to be rendered for export
     * @return stdClass Data to expose to the template
     */
    public function export_for_template(renderer_base $output) : stdClass {
        $validated = new stdClass();
        $notvalidated = new stdClass();
        $validated->picturecolumnlabel = $notvalidated->picturecolumnlabel = get_string('listtablepictureheader', 'block_openveo_videos');
        $validated->namecolumnlabel = $notvalidated->namecolumnlabel = get_string('listtablenameheader', 'block_openveo_videos');
        $validated->datecolumnlabel = $notvalidated->datecolumnlabel = get_string('listtabledateheader', 'block_openveo_videos');
        $validated->actioncolumnlabel = $notvalidated->actioncolumnlabel = get_string('listtableactionheader', 'block_openveo_videos');
        $validated->videos = $this->validatedvideos;
        $notvalidated->videos = $this->notvalidatedvideos;

        $data = new stdClass();
        $data->validatedvideostitle = get_string('listvalidatedvideostitle', 'block_openveo_videos');
        $data->notvalidatedvideostitle = get_string('listnotvalidatedvideostitle', 'block_openveo_videos');
        $data->validated = $validated;
        $data->notvalidated = $notvalidated;
        $data->hascapabilitytoedit = $this->hascapabilitytoedit;

        return $data;
    }

    /**
     * Gets OpenVeo videos corresponding to the course.
     *
     * @param int $courseexternalid The course external id (idnumber field from "course" table)
     * @param string $videocustomproperty The id of the video custom property holding the course external id
     * @return array The list of OpenVeo videos
     */
    protected function get_openveo_course_videos(int $courseexternalid, string $videocustomproperty) {
        try {
            $query = http_build_query(
                    $param = [
                        'sortBy' => 'date',
                        'sortOrder' => 'asc',
                        'states' => 12,
                        'properties' => [
                            $videocustomproperty => $courseexternalid
                        ]
                    ],
                    '',
                    '&'
            );

            $response = $this->client->get("/publish/videos?$query");
            return isset($response->entities) ? $response->entities : array();
        } catch(ClientException $e) {
            $this->send_getting_openveo_course_videos_failed_event($e->getMessage(), $courseexternalid, $this->page->url);
        } catch(Exception $e) {
            $this->send_requesting_openveo_failed_event($e->getMessage());
        }
        return array();
    }

    /**
     * Sends a "requesting_openveo_failed" event.
     *
     * @param string $message The error message
     */
    protected function send_requesting_openveo_failed_event(string $message) {
        $event = requesting_openveo_failed::create(array(
            'context' => $this->page->context,
            'other' => array(
                'message' => $message
            )
        ));
        $event->trigger();
    }

    /**
     * Sends a "getting_openveo_course_videos" event.
     *
     * @param string $message The error message
     * @param int $courseexternalid The course external id (idnumber field from "course" table)
     * @param string $url The management page url
     */
    protected function send_getting_openveo_course_videos_failed_event(string $message, int $courseexternalid, string $url) {
        $event = getting_openveo_course_videos::create(array(
            'context' => $this->page->context,
            'other' => array(
                'message' => $message,
                'id' => $courseexternalid,
                'url' => $url
            )
        ));
        $event->trigger();
    }

}

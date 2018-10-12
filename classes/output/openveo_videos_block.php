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
 * Defines an OpenVeo Videos block.
 *
 * @package block_openveo_videos
 * @copyright 2018 Veo-labs
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_openveo_videos\output;

defined('MOODLE_INTERNAL') || die();

use renderable;
use templatable;
use stdClass;
use renderer_base;

/**
 * Defines an OpenVeo Videos block.
 *
 * An OpenVeo Videos block is caracterised by a focused video, a course id and a link to the course videos.
 *
 * @package block_openveo_videos
 * @copyright 2018 Veo-labs
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class openveo_videos_block implements renderable, templatable {

    /**
     * The block focused video.
     *
     * @var stdClass
     */
    protected $focusedvideo;

    /**
     * The id of the course the block belongs to.
     *
     * @var int
     */
    protected $courseid;

    /**
     * The OpenVeo Videos Block plugin base URL.
     *
     * @var string
     */
    protected $pluginbaseurl;

    /**
     * Creates a new openveo_videos_block.
     *
     * @param stdClass $focusedvideo The focused video with properties "title", "date", "id" and "thumbnail"
     * @param int $courseid The course id the block belongs to
     * @param string $pluginbaseurl The base URL of the OpenVeo Videos Block plugin
     */
    public function __construct(stdClass $focusedvideo = null, int $courseid, string $pluginbaseurl) {
        $this->focusedvideo = $focusedvideo;
        $this->courseid = $courseid;
        $this->pluginbaseurl = $pluginbaseurl;
    }

    /**
     * Exports openveo_videos_block data to be exposed to a template.
     *
     * @see templatable
     * @param renderer_base $output Used to do a final render of any components that need to be rendered for export
     * @return stdClass Data to expose to the template
     */
    public function export_for_template(renderer_base $output) : stdClass {
        $data = new stdClass();

        if (isset($this->focusedvideo)) {

            // Build focused video date.
            $videomoodledate = usergetdate($this->focusedvideo->date / 1000);
            $videodate = new StdClass();
            $videodate->day = ($videomoodledate['mday'] < 10) ? "0{$videomoodledate['mday']}" : $videomoodledate['mday'];
            $videodate->month = ($videomoodledate['mon'] < 10) ? "0{$videomoodledate['mon']}" : $videomoodledate['mon'];
            $videodate->year = $videomoodledate['year'];

            $data->focusedvideotitle = $this->focusedvideo->title;
            $data->focusedvideourl = "{$this->pluginbaseurl}/player.php?courseid={$this->courseid}&videoid={$this->focusedvideo->id}";
            $data->focusedvideothumbnailurl = isset($this->focusedvideo->thumbnail) ? $this->focusedvideo->thumbnail : null;
            $data->focusedvideodate = get_string('blockvideodate', 'block_openveo_videos', $videodate);

        }

        $data->videoslinkurl = "{$this->pluginbaseurl}/view.php?courseid={$this->courseid}";
        $data->videoslinklabel = get_string('blockvideoslink', 'block_openveo_videos');

        return $data;
    }

}

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
 * Defines the player page.
 *
 * @package block_openveo_videos
 * @copyright 2018 Veo-labs
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_openveo_videos\output;

defined('MOODLE_INTERNAL') || die();

use stdClass;
use renderable;
use templatable;
use renderer_base;
use moodle_page;
use moodle_url;

/**
 * Defines the player page.
 *
 * The player page only displays a simple external link to the OpenVeo video.
 * If OpenVeo Moodle Player plugin is installed, external link will be replaced by the OpenVeo Player.
 *
 * @package block_openveo_videos
 * @copyright 2018 Veo-labs
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class player_page implements renderable, templatable {

    /**
     * The OpenVeo video URL.
     *
     * @var string
     */
    protected $videourl;

    /**
     * The Moodle page.
     *
     * @var moodle_page
     */
    protected $page;

    /**
     * Creates a player_page.
     *
     * @param string $videoid The OpenVeo video id
     * @param int $courseid The course id the video belongs to
     * @param moodle_page $page The Moodle page
     */
    public function __construct(string $videoid, int $courseid, moodle_page &$page) {
        $serverurl = rtrim(get_config('local_openveo_api', 'cdnurl'), '/');

        // Player dimension is set to 100% width and 600px height but it isn't applied as Moodle does not support percentage when using the mediaplugin filter.
        // Etiher Moodle mediaplugin filter should call embed_url when filtering a "a" tag or the Moodle media manager should handle percentage when parsing alternatives.
        $this->videourl = "$serverurl/publish/video/$videoid?d=100%x600";

        $this->page = $page;

        // Set page information.
        $this->page->set_url('/blocks/openveo_videos/player.php', array('courseid' => $courseid, 'videoid' => $videoid));
        $this->page->requires->css('/blocks/openveo_videos/css/player.css');
        $this->page->set_pagelayout('standard');

        // Set breadcrumb.
        $settingsnode = $this->page->settingsnav->add(get_string('listsettingstitle', 'block_openveo_videos'));
        $editurl = new moodle_url('/blocks/openveo_videos/view.php', array('courseid' => $courseid));
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
        $data = new stdClass();
        $data->videourl = $this->videourl;
        return $data;
    }

}

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
 * Template to render the content of the block.
 *
 * @param string $videopath The path to the video
 * @param string $videotitle The video title
 * @param string $videodescription The video description
 * @param stdClass $videodate The video date in user's format
 * @param string $videosurl Url to the list of videos associated to the course
 * @param bool $videovalidated true if video is validated, false otherwise
 * @param string $pluginPath Root url of the plugin
 * @package block_openveo_videos
 * @copyright 2018 Veo-labs
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

?>
<div class="ov-block-content">
  <?php if($videovalidated): ?>
    <h4><?php print $videotitle; ?></h4>
    <a href="<?php print $videopath; ?>" title="<?php print $videotitle; ?>">
        <?php if(!empty($videothumb)): ?>
          <img src="<?php print $videothumb; ?>" alt="<?php print $videotitle; ?>" />
      <?php else: ?>
        <div class="ov-placeholder"></div>
        <?php endif; ?>
      <div class="ov-play">
        <div>
          <div>
            <div class="ov-play-icon"></div>
          </div>
        </div>
      </div>
    </a>
    <div class="mdl-right"><?php print get_string('blockvideodate', 'block_openveo_videos', $videodate); ?></div>
  <?php endif; ?>
  <hr>
  <a href="<?php print $videosurl; ?>"><?php print get_string('blockvideoslink', 'block_openveo_videos'); ?></a>
</div>
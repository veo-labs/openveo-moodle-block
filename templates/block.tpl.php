<?php
// This file is part of OpenVeo - http://www.veo-labs.com/suite-logicielle-openveo
//
// TODO : Add License information here

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
 * @copyright 2015, veo-labs <info@veo-labs.com>
 * @license TODO
 */

?>
<style>
  .ov-block-content .placeholder{
    background-image: url('<?php print $pluginPath.'images/no-image-500.gif';?>');
  }
</style>
<div class="ov-block-content">
  <?php if($videovalidated): ?>
    <h4><?php print $videotitle; ?></h4>
    <a href="<?php print $videopath; ?>" title="<?php print $videotitle; ?>">
      <div class='placeholder'>
        <?php if(!empty($videothumb)): ?>
          <img src="<?php print 'http://'.$serverhost.':'.$serverport.$videothumb; ?>" alt="<?php print $videotitle; ?>" />
        <?php endif; ?>
        <div class='play'></div>
      </div>
    </a>
    <div class="mdl-right"><?php print get_string('blockvideodate', 'block_openveo_videos', $videodate); ?></div>
  <?php endif; ?>
  <hr>
  <a href="<?php print $videosurl; ?>"><?php print get_string('blockvideoslink', 'block_openveo_videos'); ?></a>
</div>
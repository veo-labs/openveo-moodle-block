<?php
// This file is part of OpenVeo - http://www.veo-labs.com/suite-logicielle-openveo
//
// TODO : Add License information here

/**
 * Template to render the video player.
 *
 * @param string $videourl The url of the video
 * @copyright 2015, veo-labs <info@veo-labs.com>
 * @license TODO
 */
?>
<?php if(!empty($videourl)): ?>
  <div class="ov-player-content">
    <iframe allowfullscreen="true" src="<?php print $videourl; ?>"></iframe>
  </div>
<?php endif; ?>
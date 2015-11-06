<?php
// This file is part of OpenVeo - http://www.veo-labs.com/suite-logicielle-openveo
//
// TODO : Add License information here

/**
 * Template to render the list of videos.
 *
 * @param string $tableofvideos The list of validated videos as HTML
 * @package block_openveo_videos
 * @param string $tableofvideostovalidate The list of videos to validate as HTML
 * @param bool $hasCapabilityToEdit true if user can edit the list of videos, false otherwise
 * @copyright 2015, veo-labs <info@veo-labs.com>
 * @license TODO
 */
?>
<?php if($hasCapabilityToEdit): ?>
  <h3><?php print get_string('listvalidatedvideostitle', 'block_openveo_videos'); ?></h3>
<?php endif; ?>

<div class="ov-list-content">
  <?php echo $tableofvideos; ?>
</div>

<?php if($hasCapabilityToEdit): ?>
  <h3><?php print get_string('listnotvalidatedvideostitle', 'block_openveo_videos'); ?></h3>
  <div class="ov-list-content">
    <?php echo $tableofvideostovalidate; ?>
  </div>
<?php endif; ?>

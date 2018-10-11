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
 * Template to render the list of videos.
 *
 * @param string $tableofvideos The list of validated videos as HTML
 * @package block_openveo_videos
 * @param string $tableofvideostovalidate The list of videos to validate as HTML
 * @param bool $hasCapabilityToEdit true if user can edit the list of videos, false otherwise
 * @copyright 2018 Veo-labs
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
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

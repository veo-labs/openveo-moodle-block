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
 * Defines block's instances configuration form.
 *
 * @package block_openveo_videos
 * @copyright 2018 Veo-labs
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_openveo_videos_edit_form extends block_edit_form {

    /**
     * Creates form fields specific to this type of block.
     *
     * @param MoodleQuickForm $mform The pear quick form form being built.
     */
    protected function specific_definition($mform) {

        // Fieldset.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        // Title.
        $mform->addElement('text', 'config_title', get_string('inconfblocktitlelabel', 'block_openveo_videos'));
        $mform->addHelpButton('config_title', 'inconfblocktitlelabel', 'block_openveo_videos');
        $mform->setDefault('config_title', get_string('inconfblockdefaulttitle', 'block_openveo_videos'));
        $mform->setType('config_title', PARAM_TEXT);

    }

}

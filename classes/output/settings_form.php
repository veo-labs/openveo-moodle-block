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
 * Defines the settings form to configure OpenVeo Videos block.
 *
 * @package block_openveo_videos
 * @copyright 2018 Veo-labs
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_openveo_videos\output;

defined('MOODLE_INTERNAL') || die();

use moodleform;

/**
 * Defines the Moodle settings form to configure OpenVeo Videos block.
 *
 * Settings form configures general properties common to all OpenVeo Videos blocks.
 *
 * @package block_openveo_videos
 * @copyright 2018 Veo-labs
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class settings_form extends moodleform {

    /**
     * Builds the formular.
     *
     * Formular is an HTML_QuickForm instance from Pear library {@link https://pear.php.net} while added elements
     * are instances of HTML_QuickForm_element. You might want to refer to Pear documentation if Moodle
     * documentation on forms is not enough.
     */
    public function definition() {

        // Custom property to create relation between courses and OpenVeo.
        array_unshift($this->_customdata['videocustomproperty']['options'], get_string(
                "settingsvideocustompropertychoose",
                'block_openveo_videos'
        ));
        $this->_form->addElement(
                'select',
                'videocustomproperty',
                get_string('settingsvideocustompropertylabel', 'block_openveo_videos'),
                $this->_customdata['videocustomproperty']['options']
        );
        $this->_form->addHelpButton(
                'videocustomproperty',
                'settingsvideocustomproperty',
                'block_openveo_videos'
        );
        if (!empty($this->_customdata['videocustomproperty']['value'])) {
            $this->_form->setDefault('videocustomproperty', $this->_customdata['videocustomproperty']['value']);
        }

        $this->add_action_buttons(false, get_string('settingssubmitlabel', 'block_openveo_videos'));
    }

}

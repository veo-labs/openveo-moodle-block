<?php
// This file is part of OpenVeo - http://www.veo-labs.com/suite-logicielle-openveo
//
// TODO : Add License information here

/**
 * Defines block's instances configuration form.
 *
 * @package block_openveo_videos
 * @copyright 2015, veo-labs <info@veo-labs.com>
 * @license TODO
 */
class block_openveo_videos_edit_form extends block_edit_form {
    
    /**
     * Creates form fields specific to this type of block.
     * 
     * @param MoodleQuickForm $mform The pear quick form form being built.
     */    
    protected function specific_definition($mform) {
        
        // Create a fieldset with a legend
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));
        
        // Add an input text element to form
        $mform->addElement('text', 'config_title', get_string('inconfblocktitlelabel', 'block_openveo_videos'));
        
        // Add help button
        $mform->addHelpButton('config_title', 'inconfblocktitlelabel', 'block_openveo_videos');
        
        // Set input text default value
        $mform->setDefault('config_title', get_string('inconfblocktitlelabel', 'block_openveo_videos'));
        
        // Clean title to plain text while submitting
        $mform->setType('config_title', PARAM_TEXT);
    }
    
}
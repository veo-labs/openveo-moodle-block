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
 * Defines the settings page for the plugin.
 *
 * @package block_openveo_videos
 * @copyright 2018 Veo-labs
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_openveo_videos\output;

defined('MOODLE_INTERNAL') || die();

// Include OpenVeo REST PHP client autoloader.
require_once($CFG->dirroot . '/local/openveo_api/lib.php');

use Exception;
use renderable;
use templatable;
use renderer_base;
use stdClass;
use context_system;
use moodle_exception;
use Openveo\Client\Client;
use Openveo\Exception\ClientException;
use local_openveo_api\event\requesting_openveo_failed;
use block_openveo_videos\event\getting_custom_properties_failed;

/**
 * Defines the settings page.
 *
 * The settings page holds a formular to configure blocks.
 *
 * @package block_openveo_videos
 * @copyright 2018 Veo-labs
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class settings_page implements renderable, templatable {

    /**
     * The settings form.
     *
     * @var settings_form
     */
    protected $form;

    /**
     * The translated title of the page.
     *
     * @var string
     */
    protected $pagetitle;

    /**
     * The OpenVeo web service client.
     *
     * @var Openveo\Client\Client
     */
    protected $client;

    /**
     * Creates a settings_page holding blocks configuration.
     *
     * It also retrieve the list of configured custom properties from OpenVeo Publish.
     *
     * @param string $pagetitle The translated page title
     */
    public function __construct(string $pagetitle) {
        $this->pagetitle = $pagetitle;
        $url = get_config('local_openveo_api', 'webserviceurl');
        $clientid = get_config('local_openveo_api', 'webserviceclientid');
        $clientsecret = get_config('local_openveo_api', 'webserviceclientsecret');
        $certificatefilepath = get_config('local_openveo_api', 'webservicecertificatefilepath');
        $defaultvideocustomproperty = get_config('block_openveo_videos', 'videocustomproperty');

        // Create an OpenVeo web service client.
        try {
            $this->client = new Client($url, $clientid, $clientsecret, $certificatefilepath);
        } catch(ClientException $e) {
            throw new moodle_exception('errorlocalpluginnotconfigured', 'block_openveo_videos');
        }

        // Get custom properties.
        $customproperties = $this->get_openveo_custom_properties();

        if (sizeof($customproperties) <= 0) {

            // No custom property configured in OpenVeo Publish. Abort.

            throw new moodle_exception('errornocustomproperties', 'block_openveo_videos');

        }

        $custompropertiesoptions = array();
        foreach ($customproperties as $customproperty) {
            $custompropertiesoptions[$customproperty->id] = $customproperty->name;
        }

        // Create settings form.
        $defaults = array(
            'videocustomproperty' => array(
                'value' => $defaultvideocustomproperty,
                'options' => $custompropertiesoptions
            ),
        );
        $this->form = new settings_form(null, $defaults);

        // Handle form submission.
        $data = $this->form->get_data();
        if (isset($data)) {

            // Formular has been submitted and is validated.

            set_config('videocustomproperty', $data->videocustomproperty, 'block_openveo_videos');

        }
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
        $data->title = $this->pagetitle;
        $data->form = $this->form->render();
        return $data;
    }

    /**
     * Gets the list of custom properties defined in OpenVeo Publish.
     *
     * @return array The list of custom properties from OpenVeo Publish
     */
    protected function get_openveo_custom_properties() : array {
        try {
            $response = $this->client->get('/publish/properties');
            return isset($response->entities) ? $response->entities : array();
        } catch(ClientException $e) {
            $this->send_getting_custom_properties_failed_event($e->getMessage());
        } catch(Exception $e) {
            $this->send_requesting_openveo_failed_event($e->getMessage());
        }
        return array();
    }

    /**
     * Sends a "requesting_openveo_failed" event.
     *
     * @param string $message The error message
     */
    protected function send_requesting_openveo_failed_event(string $message) {
        $event = requesting_openveo_failed::create(array(
            'context' => context_system::instance(),
            'other' => array(
                'message' => $message
            )
        ));
        $event->trigger();
    }

    /**
     * Sends a "getting_custom_properties_failed" event.
     *
     * @param string $message The error message
     */
    protected function send_getting_custom_properties_failed_event(string $message) {
        $event = getting_custom_properties_failed::create(array(
            'context' => context_system::instance(),
            'other' => array(
                'message' => $message
            )
        ));
        $event->trigger();
    }

}

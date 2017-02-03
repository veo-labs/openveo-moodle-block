# OpenVeo Moodle Block

OpenVeo Moodle Block is a Moodle block plugin which communicate with [Openveo Publish](https://github.com/veo-labs/openveo-publish) services.

OpenVeo Moodle Block adds the following features :

- Add a video block on a course to see the latest video avalaible on [Openveo Publish](https://github.com/veo-labs/openveo-publish) related to a course ID
- List all videos [Openveo Publish](https://github.com/veo-labs/openveo-publish) related to a course ID
- Administrate published videos inside moodle to add a validation level
- Display the Openveo Player with slides and chapters sync in a moodle page

# Getting Started

## Prerequisites
- Install Openveo CMS with Openveo Publish 2.x.x
- Install Moodle version >2.9.6
- Download a zip file from the latest stable [Openveo Rest Client](https://github.com/veo-labs/openveo-rest-php-client) dependency

## Installation
- Download a zip file from this repository.
- Unzip it in a temporary named **openveo_videos** folder.
- Unzip the **openveo-rest-php-client.zip** file in **openveo_videos/lib** folder in order to have dependency sources in **openveo_videos/lib/openveo-rest-php-client/** folder.
- Move your **openveo_videos** folder to **MOODLE_PATH_ROOT/blocks/openveo_videos**  where MOODLE_PATH_ROOT is your Moodle installation folder.
- In your Moodle site (as admin) go to Settings > Site administration > Notifications : you should get a message saying the plugin is installed.

If you experience troubleshooting during installation, please refer on the [Moodle installation plugin documentation](https://docs.moodle.org/29/en/Installing_plugins), "Installing manually at the server" section.

# Contributors

Maintainer : [Veo-Labs](http://www.veo-labs.com/)

# License

[AGPL](http://www.gnu.org/licenses/agpl-3.0.en.html)

# OpenVeo Moodle Block

OpenVeo Moodle Block is a Moodle block plugin which communicates with [Openveo Publish](https://github.com/veo-labs/openveo-publish) web service.

OpenVeo Moodle Block adds the following features:

- Add a video block on a course to see the latest video avalaible on [Openveo Publish](https://github.com/veo-labs/openveo-publish) related to a course ID
- List all published videos from [Openveo Publish](https://github.com/veo-labs/openveo-publish) related to a course ID
- Administrate published videos inside Moodle to add a validation level
- Display the OpenVeo Player with slides and chapters sync in a Moodle page

# Getting Started

## Prerequisites
- Install Openveo CMS with Openveo Publish 4.x.x
- Install Moodle version >2.9.6

## Installation
- Download a zip file from this repository
- Unzip it and rename **openveo-moodle-block-\*** directory into **openveo_videos**
- Download latest stable [OpenVeo Rest PHP client](https://github.com/veo-labs/openveo-rest-php-client) as a zip file
- Unzip the **openveo-rest-php-client.zip** file in **openveo_videos/lib** folder
- Rename **openveo_videos/lib/openveo-rest-php-client-\*** into **openveo_videos/lib/openveo-rest-php-client**
- Move your **openveo_videos** folder into **MOODLE_ROOT_PATH/blocks/** where MOODLE_ROOT_PATH is your Moodle installation folder
- In your Moodle site (as admin) go to **Site administration > Notifications**: you should get a message saying the plugin is installed

If you experience troubleshooting during installation, please refer to the [Moodle installation plugin documentation](https://docs.moodle.org/29/en/Installing_plugins), "Installing manually at the server" section.

# Contributors

Maintainer: [Veo-Labs](http://www.veo-labs.com/)

# License

[AGPL](http://www.gnu.org/licenses/agpl-3.0.en.html)

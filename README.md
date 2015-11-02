# OpenVeo Moodle Block

OpenVeo Moodle Block is a Moodle block plugin which communicate with [Openveo Publish](http://veo-labs.github.io/openveo-publish/1.0.1) services.

OpenVeo Moodle Block adds the following features :

- Add a video block on a course to see the latest video avalaible on [Openveo Publish](http://veo-labs.github.io/openveo-publish/1.0.1) related to a course ID
- List all videos [Openveo Publish](http://veo-labs.github.io/openveo-publish/1.0.1) related to a course ID
- Administrate published videos inside moodle to add a validation level
- Display the Openveo Player with slides and chapters sync in a moodle page

# Getting Started

## Prerequisites
[Composer](https://getcomposer.org/)(>1.0.0-alpha9) - Needed to install [Openveo Rest Client](https://github.com/veo-labs/openveo-rest-php-client) dependency

## Installation
- Download a zip file from the repository.
- Unzip it in a temporary named "openveo_videos" folder.
- In a command line, go in "openveo_videos" folder and launch:
```
composer install
```
- Move your "openveo_videos" folder to "MOODLE_PATH_ROOT/blocks/openveo_videos"
- In your Moodle site (as admin) go to Settings > Site administration > Notifications : you should get a message saying the plugin is installed.

If you experience troubleshooting during installation, please refer on the [Moodle installation plugin documentation](https://docs.moodle.org/29/en/Installing_plugins), "Installing manually at the server" section.

# Contributors

Maintainer : [Veo-Labs](http://www.veo-labs.com/)

# License

[AGPL](http://www.gnu.org/licenses/agpl-3.0.en.html)

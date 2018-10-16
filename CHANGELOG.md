# 5.0.0 / YYYY-MM-DD

## BREAKING CHANGES

- OpenVeo Videos Block now requires OpenVeo Moodle API plugin to be installed
- OpenVeo Videos Block now requires PHP >= 7
- The player page won't display the player anymore unless OpenVeo Moodle Player plugin is installed. If OpenVeo Moodle Player is not installed a link to the OpenVeo video will be displayed instead

## NEW FEATURES

- An OpenVeo icon is now displayed next to the plugin name in administration interface
- Set player page title and header to the video title instead of the course name
- Set manage page title (&lt;title&gt; tag)

## BUG FIXES

- License is now in compliance with Moodle license

# 4.0.1 / 2017-11-14

## BUG FIXES

- Fix web service client id field which didn't accept underscores nor hyphens while OpenVeo could generate ids with these characters

# 4.0.0 / 2017-06-14

## BREAKING CHANGES

- Configuration of OpenVeo and OpenVeo Web Service now excepts the full url instead of the host and port

## NEW FEATURES

- Add HTTPS support for OpenVeo Web Service. It is now possible to connect to the OpenVeo Web Service using HTTPS. Navigate to OpenVeo Videos block configuration to specify the OpenVeo Web Service certificate.

## DEPENDENCIES

- **openveo-rest-php-client** has been updated from 1.0.2 to **2.0.0**

# 3.0.0 / 2017-05-04

## BREAKING CHANGES

- Drop support for OpenVeo Publish &lt;3.0.0

## BUG FIXES

- Fix french translations for OpenVeo server port configuration
- Fix infinite configuration page when installing the bloc without having a single OpenVeo Publish custom property or with wrong Web Service configuration

# 2.0.1 / 2017-02-03

## BUG FIXES

- List of videos' thumbnails in the block were not displayed when the Web Service server wasn't exposed. It now uses the OpenVeo application server to get the thumbnails.

# 2.0.0 / 2016-06-10

- Set compatibility to Openveo Publish 2.x.x
- Lose Openveo Publish 1.x.x compatibility

# 1.0.1 / 2016-02-18

- Add compatibility for OpenVeo 1.2.0.
- Correct bug when trying to visualize a video before it was first validated

# 1.0.0 / 2015-11-24

Firt stable version of [OpenVeo](https://github.com/veo-labs/openveo-core) Moodle Block plugin.

Adds the following features :

- Add a video block on a course to see the latest video avalaible on [Openveo Publish](https://github.com/veo-labs/openveo-publish) related to a course ID
- List all video related to a course ID
- Administrate published video inside Moodle to add a validation level
- Display the Openveo Player with slides and chapters sync in a Moodle page

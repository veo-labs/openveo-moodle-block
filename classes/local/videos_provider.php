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
 * Defines a provider to manage validated / not validated videos.
 *
 * @package block_openveo_videos
 * @copyright 2018 Veo-labs
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_openveo_videos\local;

defined('MOODLE_INTERNAL') || die();

use stdClass;
use moodle_database;

/**
 * Defines a provider to manage validated / not validated videos stored in block_openveo_videos table.
 *
 * @package block_openveo_videos
 * @copyright 2018 Veo-labs
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class videos_provider {

    /**
     * The database instance.
     *
     * @var moodle_database
     */
    protected $database;

    /**
     * Creates a videos_provider.
     *
     * @param moodle_database $database The database instance
     */
    public function __construct(moodle_database $database) {
        $this->database = $database;
    }

    /**
     * Gets course validated videos.
     *
     * @param int $courseexternalid The course external id (idnumber field from "course" table)
     * @return array The list of OpenVeo video ids
     * @throws dml_exception A DML specific exception is thrown for any errors
     */
    public function get_course_validated_videos(int $courseexternalid) : array {
        $validatedvideos = $this->database->get_records('block_openveo_videos', array('isvalidated' => 1, 'courseid' => $courseexternalid));
        return array_values(array_map(function($validatedvideo) { return $validatedvideo->videoid; }, $validatedvideos));
    }

    /**
     * Gets course video.
     *
     * @param int $courseexternalid The course external id (idnumber field from "course" table)
     * @param string $videoid The OpenVeo video id
     * @return stdClass The course video
     * @throws dml_exception A DML specific exception is thrown for any errors
     */
    public function get_course_video(int $courseexternalid, string $videoid) {
        return $this->database->get_record('block_openveo_videos', array('videoid' => $videoid, 'courseid' => $courseexternalid));
    }

    /**
     * Validates a course video.
     *
     * @param int $courseexternalid The course external id (idnumber field from "course" table)
     * @param string $videoid The OpenVeo video id
     * @throws dml_exception A DML specific exception is thrown for any errors
     */
    public function validate_course_video(int $courseexternalid, string $videoid) {
        $this->update_course_video_validity($courseexternalid, $videoid, true);
    }

    /**
     * Unvalidates a course video.
     *
     * @param int $courseexternalid The course external id (idnumber field from "course" table)
     * @param string $videoid The OpenVeo video id
     * @throws dml_exception A DML specific exception is thrown for any errors
     */
    public function unvalidate_course_video(int $courseexternalid, string $videoid) {
        $this->update_course_video_validity($courseexternalid, $videoid, false);
    }

    /**
     * Validates / unvalidates a course video.
     *
     * @param int $courseexternalid The course external id (idnumber field from "course" table)
     * @param string $videoid The OpenVeo video id
     * @param bool $shouldbevalidated true to validate the course video, false to unvalidate
     * @throws dml_exception A DML specific exception is thrown for any errors
     */
    protected function update_course_video_validity(int $courseexternalid, string $videoid, bool $shouldbevalidated) {
        $video = $this->get_course_video($courseexternalid, $videoid);

        if (empty($video)) {

            // Insert.
            $record = new stdClass();
            $record->courseid = $courseexternalid;
            $record->videoid = $videoid;
            $record->isvalidated = $shouldbevalidated ? 1 : 0;

            $this->database->insert_record('block_openveo_videos', $record);
        } else if (($video->isvalidated == 0 && $shouldbevalidated) || ($video->isvalidated == 1 && !$shouldbevalidated)) {

            // Update.
            $record = new stdClass();
            $record->id = $video->id;
            $record->isvalidated = $shouldbevalidated ? 1 : 0;
            $this->database->update_record('block_openveo_videos', $record);

        }
    }

}

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
 * Defines french translations of the plugin.
 *
 * @package block_openveo_videos
 * @copyright 2018 Veo-labs
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Vidéos OpenVeo';

// Instance configuration form
$string['inconfblocktitlelabel'] = 'Vidéos';
$string['inconfblocktitlelabel_help'] = 'Le titre du bloc tel qu\'il apparaîtra en haut du bloc.';

// Block
$string['blockvideodate'] = 'Vidéo du {$a->day}/{$a->month}/{$a->year}';
$string['blockvideoslink'] = 'Voir toutes les vidéos';

// Page listing videos
$string['listtitle'] = 'Toutes les vidéos du cours "{$a}"';
$string['listsettingstitle'] = 'Titre du bloc';
$string['listsettingslink'] = 'Voir toutes les vidéos';
$string['listinvalidcourse'] = 'Le cours que vous recherchez n\'existe pas';
$string['listaccessrefused'] = 'Vous n\'avez pas la permission d\'accéder à cette page';
$string['listtablepictureheader'] = 'Vignette';
$string['listtablenameheader'] = 'Nom';
$string['listtabledateheader'] = 'Date';
$string['listtableactionheader'] = 'Action';
$string['listvideodate'] = '{$a->day}/{$a->month}/{$a->year}';
$string['listvideovalidate'] = 'Valider';
$string['listvideounvalidate'] = 'Dépublier';
$string['listvalidatedvideostitle'] = 'Vidéo(s) validée(s)';
$string['listnotvalidatedvideostitle'] = 'Vidéo(s) à valider';

// Player
$string['playertitle'] = '{$a}';
$string['playerinvalidvideo'] = 'Vous n\'avez pas la permission d\'accéder à cette vidéo';
$string['playeraccessrefused'] = 'Vous n\'avez pas la permission d\'accéder à cette page';
$string['playerinvalidcourse'] = 'Le cours que vous recherchez n\'existe pas';

// Capabilities
$string['openveo_videos:addinstance'] = 'Ajouter un nouveau block OpenVeo vidéos';
$string['openveo_videos:edit'] = 'Editer les vidéos associées à un cours';

// Settings page.
$string['settingstitle'] = 'OpenVeo Videos Bloc configuration';
$string['settingslinktitle'] = 'OpenVeo Videos';
$string['settingsvideocustompropertylabel'] = 'Propriété personnalisée OpenVeo';
$string['settingsvideocustomproperty'] = 'Propriété personnalisée OpenVeo';
$string['settingsvideocustomproperty_help'] = 'Choisissez la propriété personnalisée OpenVeo qui contient l\'id du cours Moodle. Vous pouvez ensuite associer une vidéo OpenVeo à un cours en précisant l\'id du cours dans cette propriété personnalisée.';
$string['settingsvideocustompropertychoose'] = 'Choisir...';
$string['settingssubmitlabel'] = 'Enregistrer les modifications';

// Errors.
$string['errorlocalpluginnotconfigured'] = 'Le plugin local "OpenVeo API" n\'est pas configuré.';
$string['errornocustomproperties'] = 'Aucune propriété personnalisée n\'est configurée sur OpenVeo Publish.';

// Events.
$string['eventgettingcustompropertiesfailed'] = 'Récupération des propriétés personnalisées echouée';

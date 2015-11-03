<?php
// This file is part of OpenVeo - http://www.veo-labs.com/suite-logicielle-openveo
//
// TODO : Add License information here

/**
 * Defines french translations of the plugin.
 *
 * @package block_openveo_videos
 * @copyright 2015, veo-labs <info@veo-labs.com>
 * @license TODO
 */

$string['pluginname'] = 'Vidéos OpenVeo';

// Global server configuration form
$string['genconfheader'] = 'Configuration du serveur';
$string['genconfdesc'] = 'Configurer l\'accès au serveur OpenVeo. Les vidéos de cours sont stockées sur le serveur OpenVeo.';
$string['genconfserverhostlabel'] = 'Adresse du serveur';
$string['genconfserverhostdesc'] = 'L\'adresse du serveur HTTP d\'OpenVeo sans le protocol (ex : 127.0.0.1)';
$string['genconfserverhostlabel'] = 'Adresse du serveur';
$string['genconfserverhostdesc'] = 'L\'adresse du serveur HTTP d\'OpenVeo sans le protocol (ex : 127.0.0.1)';

// Global Web Service configuration form
$string['genconfwsheader'] = 'Configuration du Web Service';
$string['genconfwsdesc'] = 'Configurer l\'accès au Web Service OpenVeo. Les vidéos de cours sont stockées sur le serveur OpenVeo. Le plugin "OpenVeo videos" pour Moodle utilise le Web Service OpenVeo afin de récupérer les vidéos associées à un cours. Tous les champs doivent être renseignés pour récupérer la liste des vidéos sur le serveur OpenVeo. Si vous n\'avez pas toutes les informations nécessaires pour remplir le formulaire, merci de contacter l\'administrateur d\'OpenVeo.';
$string['genconfwsserverhostlabel'] = 'Adresse du Web Service';
$string['genconfwsserverhostdesc'] = 'L\'adresse du Web Service HTTP d\'OpenVeo sans le protocol (ex : 127.0.0.1)';
$string['genconfwsserverportlabel'] = 'Port du Web Service';
$string['genconfwsserverportdesc'] = 'Le port du Web Service HTTP d\'OpenVeo (ex : 3001)';
$string['genconfwsclientidlabel'] = 'Identifiant client';
$string['genconfwsclientiddesc'] = 'Identifiant client du plugin pour accéder au Web Service OpenVeo (ex :  7c6892011e67ca05be3754137308a01a27ade9f3)';
$string['genconfwsclientsecretlabel'] = 'Secret client';
$string['genconfwsclientsecretdesc'] = 'Secret client du plugin pour accéder au Web Service OpenVeo (ex : 128f5fd5d980fa7f261bc1592f7f3a44c0e5fc42)';

// Global advanced configuration form
$string['genconfadvheader'] = 'Configuration avancée du Web Service';
$string['genconfadvdesc'] = 'Ces paramètres ne doivent être modifiés que par un administrateur OpenVeo. Changer ces paramètres peut empêcher le bon fonctionnement du bloc.';
$string['genconfadvvideospathlabel'] = 'Chemin vidéos';
$string['genconfadvvideospathdesc'] = 'Le point d\'entrée Web Service pour obtenir la liste des vidéos';
$string['genconfadvvideoproplabel'] = 'Propriété vidéo';
$string['genconfadvvideopropdesc'] = 'La propriété de la video Openveo pour filtrer les vidéos';

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

// Capabilities
$string['openveo_videos:addinstance'] = 'Ajouter un nouveau block OpenVeo vidéos';
$string['openveo_videos:viewlist'] = 'Voir la list des vidéos associées à un cours sans être enrolé';
$string['openveo_videos:editlist'] = 'Editer la liste des vidéos d\'un cours';
$string['openveo_videos:viewblock'] = 'Voir le bloc sans être enrolé';
$string['openveo_videos:viewvideo'] = 'Voir une vidéo sans être enrolé et sans que la vidéo soit validée';
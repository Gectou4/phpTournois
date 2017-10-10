<?php 
global $db;

$req = "CREATE TABLE `${dbprefix}article` (
  `id` int(11) NOT NULL auto_increment,
  `article` varchar(255) NOT NULL default '',
  `pseudo` varchar(50) NOT NULL default '',
  `regle` varchar(50) default NULL,
  `arrive` varchar(50) default NULL,
  `ingred` varchar(255) default NULL,
  `prix` varchar(10) default NULL,
  `cid` varchar(10) default NULL,
  `idj` int(11) default NULL,
  `pev` char(2) default NULL,
  PRIMARY KEY  (`id`)
)CHARACTER SET utf8 COLLATE utf8_general_ci;";
if(!$db->query($req)){die($db->getError());}


$req = "CREATE TABLE `${dbprefix}forum` (
  `id` int(11) NOT NULL auto_increment,
  `date` int(11) NOT NULL default '0',
  `cattitle` varchar(128) NOT NULL default '',
  `idcat` int(11) NOT NULL default '0',
  `title` varchar(128) NOT NULL default '',
  `topic` varchar(128) NOT NULL default '',
  `topid` int(11) NOT NULL default '0',
  `cattopic` int(11) NOT NULL default '0',
  `topic_date` int(11) NOT NULL default '0',
  `descri` varchar(255) NOT NULL default '',
  `reserved` varchar(132) NOT NULL default '',
  `nsujet` int(11) NOT NULL default '0',
  `nmessage` int(11) NOT NULL default '0',
  `last_post_author` varchar(255) NOT NULL default '',
  `last_post_date` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
)CHARACTER SET utf8 COLLATE utf8_general_ci;";
if(!$db->query($req)){die($db->getError());}

$req = "CREATE TABLE `${dbprefix}forum_message` (
  `id` int(11) NOT NULL auto_increment,
  `auteur` int(11) NOT NULL default '0',
  `date` int(11) NOT NULL default '0',
  `topid` int(11) NOT NULL default '0',
  `topic` varchar(128) NOT NULL default '',
  `message` text,
  `edit` enum('O','N') NOT NULL default 'N',
  `edit_date` int(11) NOT NULL default '0',
  `edit_by` varchar(128) NOT NULL default '',
  `cattopic` int(11) NOT NULL default '0',
  `locking` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
)CHARACTER SET utf8 COLLATE utf8_general_ci;";
if(!$db->query($req)){die($db->getError());}

$req = "CREATE TABLE `${dbprefix}lad_comment` (
  `id` int(11) NOT NULL auto_increment,
  `contenu` text,
  `auteur` varchar(60) NOT NULL default '',
  `date` int(11) NOT NULL default '0',
  `match_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
)CHARACTER SET utf8 COLLATE utf8_general_ci;";
if(!$db->query($req)){die($db->getError());}

$req = "CREATE TABLE `${dbprefix}lad_part` (
  `ladder_id` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `pts` int(11) NOT NULL default '0',
  `lvl` int(2) NOT NULL default '0',
  `w` int(11) NOT NULL default '0',
  `l` int(11) NOT NULL default '0',
  `d` int(11) NOT NULL default '0',
  `fairplay` float NOT NULL default '5',
  `rank` int(11) NOT NULL default '0',
  `s` decimal(11,0) NOT NULL default '0',
  `pourcent` int(11) NOT NULL default '0',
  `status` char(1) NOT NULL default '',
  `joueur_id` int(11) NOT NULL default '0',
  `mort` int(11) NOT NULL default '0',
  `round_w` int(11) NOT NULL default '0',
  `round_l` int(11) NOT NULL default '0',
  `death` int(11) NOT NULL default '0',
  `total_match` int(11) NOT NULL default '0',
  `team` varchar(50) NOT NULL default '',
  `teamid` int(11) NOT NULL default '0'
)CHARACTER SET utf8 COLLATE utf8_general_ci;";
if(!$db->query($req)){die($db->getError());}



$req = "CREATE TABLE `${dbprefix}ladder_data` (
  `id` int(11) NOT NULL auto_increment,
  `ladder_name` varchar(255) NOT NULL default '',
  `ladder_type` enum('1','2') NOT NULL default '1',
  `jeux` varchar(255) NOT NULL default '',
  `reglement` text,
  `status` char(1) NOT NULL default '',
  `pourcent` int(11) NOT NULL default '0',
  `maps` varchar(255) NOT NULL,
  `def_pts` int(11) NOT NULL default '1000',
  `pourcent_type` int(1) NOT NULL default '0',
  `close` int(1) NOT NULL default '0',
  `manche` int(5) NOT NULL default '1',
  `f_frag_win` int(11) NOT NULL default '0',
  `f_frag_loose` int(11) NOT NULL default '0',
  `f_round_win` int(11) NOT NULL default '0',
  `f_round_loose` int(11) NOT NULL default '0',
  `f_manche_win` int(11) NOT NULL default '0',
  `f_manche_loose` int(11) NOT NULL default '0',
  `s_frag` int(1) NOT NULL default '1',
  `s_round` int(1) NOT NULL default '1',
  `s_manche` int(1) NOT NULL default '1',
  `f_manche_null` int(11) NOT NULL default '0',
  `new_data` int(1) NOT NULL default '0',
  `mail` int(11) NOT NULL default '1',
  PRIMARY KEY  (`id`)
)CHARACTER SET utf8 COLLATE utf8_general_ci;";
if(!$db->query($req)){die($db->getError());}



$req = "CREATE TABLE `${dbprefix}ladder_match` (
  `id` int(11) NOT NULL auto_increment,
  `j1` varchar(60) NOT NULL default '',
  `j2` varchar(60) NOT NULL default '',
  `s1` int(11) NOT NULL default '0',
  `s2` int(11) NOT NULL default '0',
  `valide` enum('A','B','C','D','V','X') NOT NULL default 'A',
  `ladder_name` varchar(255) NOT NULL default '',
  `date` varchar(15) NOT NULL default '0',
  `rapport` text,
  `fpj1` int(11) NOT NULL default '5',
  `fpj2` int(11) NOT NULL default '5',
  `ladder_id` int(11) NOT NULL default '0',
  `maps` varchar(255) NOT NULL default '',
  `date_up` int(11) NOT NULL default '0',
  `server` varchar(255) NOT NULL default '',
  `date_x` int(11) NOT NULL default '0',
  `manche` int(5) NOT NULL default '1',
  `save_j1` text,
  `t1_id` int(11) NOT NULL default '0',
  `t2_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
)CHARACTER SET utf8 COLLATE utf8_general_ci;";
if(!$db->query($req)){die($db->getError());}

$req = "CREATE TABLE `${dbprefix}listarticle` (
  `id` int(11) NOT NULL auto_increment,
  `article` varchar(255) NOT NULL default '',
  `prix` varchar(50) NOT NULL default '',
  `ingred` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
)CHARACTER SET utf8 COLLATE utf8_general_ci;";
if(!$db->query($req)){die($db->getError());}

$req = "CREATE TABLE `${dbprefix}menu` (
  `id` int(11) NOT NULL auto_increment,
  `titre` varchar(12) NOT NULL default '',
  `orde` int(11) NOT NULL default '0',
  `align` enum('G','D') NOT NULL default 'G',
  PRIMARY KEY  (`id`)
)CHARACTER SET utf8 COLLATE utf8_general_ci;";
if(!$db->query($req)){die($db->getError());}

$req = "CREATE TABLE `${dbprefix}mods` (
  `MODEnLigneA` varchar(32) NOT NULL default '#FF0000',
  `MODEnLigneN` varchar(32) NOT NULL default '#000044',
  `MODEnLigneM` varchar(32) NOT NULL default '#00FF00',
  `MODEnLigneW` varchar(32) NOT NULL default '#2222FF',
  `age` int(11) NOT NULL default '1',
  `ville` int(11) NOT NULL default '1',
  `nom` int(11) NOT NULL default '1',
  `prenom` int(11) NOT NULL default '1',
  `customtheme` int(11) NOT NULL default '1',
  `Osteamid` int(11) NOT NULL default '1',
  `pagescript` int(11) NOT NULL default '1',
  `topdl` int(1) NOT NULL default '0',
  `topplayer` int(1) NOT NULL default '0',
  `lastresult` int(1) NOT NULL default '0',
  `MODEnLigneMo` varchar(32) NOT NULL default '#556699',
  `lastnews` int(1) NOT NULL default '0',
  `forcing` int(1) NOT NULL default '0',
  `plan` int(11) NOT NULL default '1',
  `rangforum` enum('0','1') NOT NULL default '0',
  `lastnews_header` int(1) NOT NULL default '0',
  `bbcode` int(1) NOT NULL default '1',
  `admin` text,
  `serverteam` int(1) NOT NULL default '1',
  `m_team_valid` int(1) NOT NULL default '0',
  `m_team_valid_num` int(11) NOT NULL default '5',
  `auto_valid_team` int(1) NOT NULL default '0'
)CHARACTER SET utf8 COLLATE utf8_general_ci;";
if(!$db->query($req)){die($db->getError());}
$req = "CREATE TABLE `${dbprefix}multinews` (
  `id` int(11) NOT NULL auto_increment,
  `lang` char(2) NOT NULL default 'UK',
  `titre` varchar(50) NOT NULL default '',
  `contenu` text,
  PRIMARY KEY  (`id`)
)CHARACTER SET utf8 COLLATE utf8_general_ci;";
if(!$db->query($req)){die($db->getError());}

$req = "CREATE TABLE `${dbprefix}page` (
  `id` int(11) NOT NULL auto_increment,
  `auteur` int(11) NOT NULL default '0',
  `contenu` text,
  `date` int(11) NOT NULL default '0',
  `rubrique` varchar(64) NOT NULL default '0',
  `npage` int(11) NOT NULL default '0',
  `nmenu` varchar(32) NOT NULL default '0',
  `titre` varchar(32) NOT NULL default '',
  `orde` int(11) NOT NULL default '0',
  `acces` varchar(4) NOT NULL default '0',
  `lien` varchar(120) NOT NULL default '',
  PRIMARY KEY  (`id`)
)CHARACTER SET utf8 COLLATE utf8_general_ci;";
if(!$db->query($req)){die($db->getError());}


$req = "CREATE TABLE `${dbprefix}plan` (
  `place` int(11) NOT NULL default '0',
  `status` int(11) NOT NULL default '0',
  PRIMARY KEY  (`place`)
)CHARACTER SET utf8 COLLATE utf8_general_ci;";
if(!$db->query($req)){die($db->getError());}

$req = "		
ALTER TABLE `${dbprefix}shoutbox` CHANGE `auteur` `pseudo` varchar(32) NOT NULL default 'Invité';
ALTER TABLE `${dbprefix}mods` ADD `news2` int(1) NOT NULL default '0';

ALTER TABLE `${dbprefix}config` CHANGE `information` `information` TEXT DEFAULT NULL ,
CHANGE `reglement` `reglement` TEXT DEFAULT NULL ,
CHANGE `decharge` `decharge` TEXT DEFAULT NULL ;

ALTER TABLE `${dbprefix}config` ADD `shoutbox` int(11) NOT NULL default '1',
ADD `shoutlimit` int(11) NOT NULL default '20',
ADD `shoutboxc` int(11) NOT NULL default '255',
ADD `article` varchar(5) NOT NULL default 'off',
ADD `article_config` varchar(10) NOT NULL default '1',
ADD `enligne` int(1) NOT NULL default '1',
ADD `poulewin` int(11) NOT NULL default '3',
ADD `poulenull` int(11) NOT NULL default '2',
ADD `pouleloose` int(11) NOT NULL default '1',
ADD `poulefor` int(11) NOT NULL default '0',
ADD `ladder` int(11) NOT NULL default '1',
ADD `commande` int(1) NOT NULL default '0',
ADD `faq` int(11) NOT NULL default '1',
ADD `support` int(1) NOT NULL default '0',
ADD `bbcodehelp` text NOT NULL ;

ALTER TABLE `${dbprefix}equipes` ADD `carton` varchar(20) NOT NULL default 'aucun',
ADD `sanction` varchar(255) default NULL,
ADD `remarque` text,
ADD `servername` varchar(64) NOT NULL default '',
ADD `serverip` varchar(32) NOT NULL default '',
ADD `id_s` int(11) NOT NULL default '0' ;

ALTER TABLE `${dbprefix}faq` ADD `idcat` int(11) NOT NULL default '1',
ADD `title` varchar(128) NOT NULL default '',
ADD `text` text,
ADD `description` text NOT NULL ;

ALTER TABLE `${dbprefix}news` ADD `icone2` varchar(20) NOT NULL default '';
ALTER TABLE `${dbprefix}news` ADD `contenu_2` text NOT NULL ;
ALTER TABLE `${dbprefix}news` ADD `titre_2` varchar(50) NOT NULL default '';

ALTER TABLE `${dbprefix}matchs` ADD `up` int(11) NOT NULL;

ALTER TABLE `${dbprefix}sessions` ADD `tournois` int(11) NOT NULL default '0';
ALTER TABLE `${dbprefix}sessions` ADD lang varchar(32) NOT NULL default 'english';
ALTER TABLE `${dbprefix}sessions` ADD UNIQUE `id_sess` ( `id` ( 32 ) );

ALTER TABLE `${dbprefix}joueurs` CHANGE `ext_steam` `steam` varchar(50) default NULL;
ALTER TABLE `${dbprefix}joueurs` ADD `theme` varchar(50) NOT NULL default '',
ADD `rang` varchar(4) NOT NULL default '',
ADD `modo` enum('N','O') NOT NULL default 'N',
ADD `grade` varchar(26) NOT NULL default 'z',
ADD `last_forum_join` int(11) NOT NULL default '0',
ADD `forum_post` int(11) NOT NULL default '0',
ADD `forum_userrank` varchar(128) NOT NULL default '',
ADD `carton` varchar(20) NOT NULL default 'aucun',
ADD `sanction` varchar(255) default NULL,
ADD `remarque` text,
ADD `jointeam` int(1) NOT NULL default '1',
ADD `allowmp` int(1) NOT NULL default '1';
";
$a = explode(';', $req);
foreach($a as $q) {
		if(trim($q)=="") break;
		if(!$db->query($q))
			die($db->getError());
	} 

$db->exec();

		$db->insert("${dbprefix}mods (admin)");
		$db->values("'Laisser ici vos notes personnels ou entre admins.'");
		$db->exec();
		$db->insert("${dbprefix}plan (place,status)");
		$db->values("1, 0");
		$db->exec();		
		$db->insert("${dbprefix}plan (place,status)");
		$db->values("2, 0");
		$db->exec();
		$db->insert("${dbprefix}plan (place,status)");
		$db->values("3, 0");
		$db->exec();
		$db->insert("${dbprefix}plan (place,status)");
		$db->values("4, 0");
		$db->exec();
		$db->insert("${dbprefix}plan (place,status)");
		$db->values("5, 0");
		$db->exec();
		$db->insert("${dbprefix}plan (place,status)");
		$db->values("6, 0");
		$db->exec();
		$db->insert("${dbprefix}plan (place,status)");
		$db->values("7, 0");
		$db->exec();
		$db->insert("${dbprefix}plan (place,status)");
		$db->values("8, 0");
		$db->exec();
		$db->insert("${dbprefix}plan (place,status)");
		$db->values("9, 0");
		$db->exec();
		$db->insert("${dbprefix}plan (place,status)");
		$db->values("10, 0");
		$db->exec();
		$db->insert("${dbprefix}plan (place,status)");
		$db->values("11, 0");
		$db->exec();
		$db->insert("${dbprefix}plan (place,status)");
		$db->values("12, 0");
		$db->exec();
		$db->insert("${dbprefix}plan (place,status)");
		$db->values("13, 0");
		$db->exec();
		$db->insert("${dbprefix}plan (place,status)");
		$db->values("14, 0");
		$db->exec();
		$db->insert("${dbprefix}plan (place,status)");
		$db->values("15, 0");
		$db->exec();
		$db->insert("${dbprefix}plan (place,status)");
		$db->values("16, 0");
		$db->exec();
		$db->insert("${dbprefix}plan (place,status)");
		$db->values("17, 0");
		$db->exec();
		$db->insert("${dbprefix}plan (place,status)");
		$db->values("18, 0");
		$db->exec();
		$db->insert("${dbprefix}plan (place,status)");
		$db->values("19, 0");
		$db->exec();
		$db->insert("${dbprefix}plan (place,status)");
		$db->values("20, 0");
		$db->exec();
		$db->insert("${dbprefix}plan (place,status)");
		$db->values("21, 0");
		$db->exec();
		$db->insert("${dbprefix}plan (place,status)");
		$db->values("22, 1");
		$db->exec();
		$db->insert("${dbprefix}plan (place,status)");
		$db->values("23, 0");
		$db->exec();
		$db->insert("${dbprefix}plan (place,status)");
		$db->values("24, 0");
		$db->exec();
		$db->insert("${dbprefix}plan (place,status)");
		$db->values("25, 0");
		$db->exec();
		$db->insert("${dbprefix}plan (place,status)");
		$db->values("26, 0");
		$db->exec();
		$db->insert("${dbprefix}plan (place,status)");
		$db->values("27, -1");
		$db->exec();
		$db->insert("${dbprefix}plan (place,status)");
		$db->values("28, -1");
		$db->exec();
		$db->insert("${dbprefix}plan (place,status)");
		$db->values("29, -1");
		$db->exec();
		$db->insert("${dbprefix}plan (place,status)");
		$db->values("30, -1");
		$db->exec();
		$db->insert("${dbprefix}jeux (id,nom,sigle,icon)");
		$db->values("30, 'Perfect Dark 2', 'Pdark', 'pdark.gif'");
		$db->exec();
		$db->insert("${dbprefix}jeux (id,nom,sigle,icon)");
		$db->values("31, 'Counter-Strike:Source', 'CS:S', 'css.gif'");
		$db->exec();
		$db->insert("${dbprefix}jeux (id,nom,sigle,icon)");
		$db->values("32, 'Counter-Strike:Zero', 'CS:Z', 'czs.gif'");
		$db->exec();
		$db->insert("${dbprefix}jeux (id,nom,sigle,icon)");
		$db->values("33, 'Pro evolution Soccer 4', 'PES4', 'pes4.gif'");
		$db->exec();
		$db->insert("${dbprefix}jeux (id,nom,sigle,icon)");
		$db->values("34, 'Fifa 2005', 'F2005', 'fifa2005.gif'");
		$db->exec();
		$db->insert("${dbprefix}jeux (id,nom,sigle,icon)");
		$db->values("35, 'Day of Defeat:Source', 'DOD:S', 'dods.gif'");
		$db->exec();
		$db->insert("${dbprefix}jeux (id,nom,sigle,icon)");
		$db->values("36, 'Unreal Tournament 2007', 'ut2k7', 'ut2k7.gif'");
		$db->exec();
		$db->insert("${dbprefix}maps (id,nom,jeux)");
		$db->values("43, 'ns_nancy', 31");
		$db->exec();
		$db->insert("${dbprefix}maps (id,nom,jeux)");
		$db->values("44, 'ns_eclipse', 31");
		$db->exec();
		$db->insert("${dbprefix}maps (id,nom,jeux)");
		$db->values("45, 'ns_eon', 31");
		$db->exec();
		$db->insert("${dbprefix}maps (id,nom,jeux)");
		$db->values("46, 'ns_lost', 31");
		$db->exec();
		$db->insert("${dbprefix}maps (id,nom,jeux)");
		$db->values("42, 'ns_origin', 31");
		$db->exec();
		$db->insert("${dbprefix}maps (id,nom,jeux)");
		$db->values("47, 'ns_ayumi', 31");
		$db->exec();
		$db->insert("${dbprefix}maps (id,nom,jeux)");
		$db->values("48, 'ns_nothing', 31");
		$db->exec();
		$db->insert("${dbprefix}maps (id,nom,jeux)");
		$db->values("49, 'ns_tanith', 31");
		$db->exec();
		$db->insert("${dbprefix}maps (id,nom,jeux)");
		$db->values("50, 'ns_hera', 31");
		$db->exec();
		$db->insert("${dbprefix}maps (id,nom,jeux)");
		$db->values("51, 'ns_metal', 31");
		$db->exec();
		$db->insert("${dbprefix}maps (id,nom,jeux)");
		$db->values("52, 'ns_altair', 31");
		$db->exec();
		$db->insert("${dbprefix}maps (id,nom,jeux)");
		$db->values("53, 'ns_bast', 31");
		$db->exec();
		$db->insert("${dbprefix}maps (id,nom,jeux)");
		$db->values("54, 'ns_veil', 31");
		$db->exec();
		$db->insert("${dbprefix}joueurs (id,pseudo,nom,prenom,email,age,origine,ville,icq,aim,msn,yim,ext_processeur,ext_memoire,ext_cartegraphique,ext_ip,passwd,admin,newseur,langue,etat,datelogin,dateinscription,steam,avatar,avatar_type,theme,rang,modo,grade,last_forum_join,forum_post,forum_userrank,carton,sanction,remarque,jointeam,allowmp )");
		$db->values("-2, 'support_phpt', 'none', 'none', 'contact@phptournois.com', '99', 'FR', 'none', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4443eae168a942dc63edfbd4d563e444', 'O', 'N', NULL, 'C', 1104925932, NULL, 'steam_0:0:000000', 'null.gif', 'N', '', '', 'N', 'abcdefghijklmnopqrstuvwxyz', 0, 2, 'phpT Dev Team', 'aucun', NULL, 'Special protected user for mod : tech support', 0, 0");
		$db->exec();
		$db->insert("${dbprefix}forum (id,date,cattitle,idcat,title,topic,topid,cattopic,topic_date,descri,reserved,nsujet,nmessage,last_post_author,last_post_date)");
		$db->values("38, 0, 'Remarque, suggestions !', 0, '', '', 0, 1, 0, 'Cette catégorie est accessible à [color=red][b]TOUS[/b][/color].', 'u', 0, 0, '', 0");
		$db->exec();
		$db->insert("${dbprefix}forum (id,date,cattitle,idcat,title,topic,topid,cattopic,topic_date,descri,reserved,nsujet,nmessage,last_post_author,last_post_date)");
		$db->values("39, 0, 'Modo & Newseur', 0, '', '', 0, 2, 0, 'Accessible uniquement aux modos newseurs et admin', 'mn', 0, 0, '', 0");
		$db->exec();
		$db->insert("${dbprefix}forum (id,date,cattitle,idcat,title,topic,topid,cattopic,topic_date,descri,reserved,nsujet,nmessage,last_post_author,last_post_date)");
		$db->values("40, 0, '', 0, '', 'Bonjour', 1, 1, 1113227281, '', '', 0, 0, '', 0");
		$db->exec();
		$db->insert("${dbprefix}forum (id,date,cattitle,idcat,title,topic,topid,cattopic,topic_date,descri,reserved,nsujet,nmessage,last_post_author,last_post_date)");
		$db->values("41, 0, '', 0, '', 'Bienvenue sur cette discution privée', 2, 2, 1113227411, '', '', 0, 0, '', 0");
		$db->exec();
		$db->insert("${dbprefix}forum_message (id,auteur,date,topid,topic,message,edit,edit_date,edit_by,cattopic,locking)");
		$db->values("97, -2, 1113227281, 1, 'Bonjour', 'Bienvenue sur le forum :)', 'N', 0, '', 1, 0");
		$db->exec();
		$db->insert("${dbprefix}forum_message (id,auteur,date,topid,topic,message,edit,edit_date,edit_by,cattopic,locking)");
		$db->values("98, -2, 1113227411, 2, 'Bienvenue sur cette discution privée', 'Vous voila entre personnel du staff :)\r\n\r\nBonne beta et bon tournois !', 'N', 0, '', 2, 0");
		$db->exec();

$db->exec();
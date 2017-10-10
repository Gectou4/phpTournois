<?php

$req = "
ALTER TABLE `${dbprefix}config` ADD commande int(1) NOT NULL default '0';
ALTER TABLE `${dbprefix}config` DROP `ladV`;
ALTER TABLE `${dbprefix}config` DROP `ladP`;
ALTER TABLE `${dbprefix}config` DROP `ladN`;
ALTER TABLE `${dbprefix}matchs` ADD `up` int(11) NOT NULL;
ALTER TABLE `${dbprefix}mods` ADD `news2` int(1) NOT NULL default '0';
ALTER TABLE `${dbprefix}news` ADD contenu_2 text NOT NULL ;
ALTER TABLE `${dbprefix}news` ADD titre_2 varchar(50) NOT NULL default '';
ALTER TABLE `${dbprefix}sessions` ADD tournois int(50) NOT NULL default '0';
ALTER TABLE `${dbprefix}sessions` ADD lang varchar(32) NOT NULL default 'english';
ALTER TABLE `${dbprefix}sessions` ADD UNIQUE `id_sess` ( `id` ( 32 ) );

DROP TABLE `${dbprefix}ladder`;
DROP TABLE `${dbprefix}ladder_match`;
DROP TABLE `${dbprefix}ladder_data`;

CREATE TABLE `${dbprefix}lad_part` (
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
) CHARACTER SET utf8 COLLATE utf8_general_ci;



CREATE TABLE `${dbprefix}ladder_data` (
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
) CHARACTER SET utf8 COLLATE utf8_general_ci;

INSERT INTO `${dbprefix}jeux` VALUES (21, 'Perfect Dark 2', 'Pdark', 'pdark.gif');
INSERT INTO `${dbprefix}jeux` VALUES (31, 'Counter-Strike:Source', 'CS:S', 'css.gif');
INSERT INTO `${dbprefix}jeux` VALUES (32, 'Counter-Strike:Zero', 'CS:Z', 'czs.gif');
INSERT INTO `${dbprefix}jeux` VALUES (33, 'Pro evolution Soccer 4', 'PES4', 'pes4.gif');
INSERT INTO `${dbprefix}jeux` VALUES (34, 'Fifa 2005', 'F2005', 'fifa2005.gif');
INSERT INTO `${dbprefix}jeux` VALUES (35, 'Day of Defeat:Source', 'DOD:S', 'dods.gif');
INSERT INTO `${dbprefix}jeux` VALUES (36, 'Unreal Tournament 2007', 'ut2k7', 'ut2k7.gif');

ALTER TABLE `${dbprefix}flood` CHANGE `mod` `mode` varchar(255) NOT NULL default '';

CREATE TABLE `${dbprefix}ladder_match` (
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
) CHARACTER SET utf8 COLLATE utf8_general_ci;

INSERT INTO `${dbprefix}maps` VALUES (42, 'ns_origin', 31);
INSERT INTO `${dbprefix}maps` VALUES (43, 'ns_nancy', 31);
INSERT INTO `${dbprefix}maps` VALUES (44, 'ns_eclipse', 31);
INSERT INTO `${dbprefix}maps` VALUES (45, 'ns_eon', 31);
INSERT INTO `${dbprefix}maps` VALUES (46, 'ns_lost', 31);
INSERT INTO `${dbprefix}maps` VALUES (47, 'ns_ayumi', 31);
INSERT INTO `${dbprefix}maps` VALUES (48, 'ns_nothing', 31);
INSERT INTO `${dbprefix}maps` VALUES (49, 'ns_tanith', 31);
INSERT INTO `${dbprefix}maps` VALUES (50, 'ns_hera', 31);
INSERT INTO `${dbprefix}maps` VALUES (51, 'ns_metal', 31);
INSERT INTO `${dbprefix}maps` VALUES (52, 'ns_altair', 31);
INSERT INTO `${dbprefix}maps` VALUES (53, 'ns_bast', 31);
INSERT INTO `${dbprefix}maps` VALUES (54, 'ns_veil', 31);

CREATE TABLE `${dbprefix}multinews` (
  `id` int(11) NOT NULL auto_increment,
  `lang` char(2) NOT NULL default 'UK',
  `titre` varchar(50) NOT NULL default '',
  `contenu` text,
  PRIMARY KEY  (`id`)
) CHARACTER SET utf8 COLLATE utf8_general_ci;
";
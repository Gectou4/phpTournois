<?php



$req ="

			CREATE TABLE `${dbprefix}administre` (
			  `tournois` int(11) NOT NULL default '0',
			  `joueur` int(11) NOT NULL default '0',
			  PRIMARY KEY  (`tournois`,`joueur`)
			) ;
			
			CREATE TABLE `${dbprefix}appartient` (
			  `joueur` int(11) NOT NULL default '0',
			  `equipe` int(11) NOT NULL default '0',
			  `jeux` int(11) NOT NULL default '0',
			  `status` int(11) NOT NULL default '2',
			  PRIMARY KEY  (`joueur`,`equipe`,`jeux`)
			) ;
			
			CREATE TABLE `${dbprefix}article` (
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
			) ;
			
			

			CREATE TABLE `${dbprefix}compteur` (
			  `id` varchar(32) NOT NULL default '',
			  `date` int(11) NOT NULL default '0',
			  `joueur` int(11) NOT NULL default '0',
			  `type` int(11) NOT NULL default '0',
			  PRIMARY KEY  (`id`)
			) ;



			INSERT INTO `${dbprefix}compteur` VALUES ('e8929d403e0f990121bc07275aae1ab3', 1125841362, 1, 2);



			CREATE TABLE `${dbprefix}config` (
			  `nomsite` varchar(50) default NULL,
			  `urlsite` varchar(50) default NULL,
			  `logo` varchar(20) default NULL,
			  `pagestart` varchar(50) default NULL,
			  `emailcontact` varchar(50) default NULL,
			  `emailinscription` varchar(50) default NULL,
			  `default_lang` varchar(20) NOT NULL default 'francais',
			  `default_theme` varchar(20) NOT NULL default 'phptournois',
			  `news` int(11) NOT NULL default '1',
			  `messagerie` int(11) NOT NULL default '1',
			  `forum` int(11) NOT NULL default '0',
			  `contact` int(11) NOT NULL default '0',
			  `download` int(11) NOT NULL default '0',
			  `galerie` int(11) NOT NULL default '1',
			  `liens` int(11) NOT NULL default '0',
			  `sponsors` int(11) NOT NULL default '0',
			  `partenaires` int(11) NOT NULL default '0',
			  `livredor` int(11) NOT NULL default '0',
			  `serveur` int(1) NOT NULL default '0',
			  `commande` int(1) NOT NULL default '0',
			  `horloge` int(11) NOT NULL default '0',
			  `irc` int(11) NOT NULL default '1',
			  `ircserver` varchar(50) default 'euroserv.fr.quakenet.org',
			  `ircport` int(11) default '6667',
			  `ircpassword` varchar(20) default NULL,
			  `ircchannels` varchar(100) default '#phptournois #lan #lan.cs #lan.q3',
			  `mail` enum('N','M','S') NOT NULL default 'M',
			  `smtpserver` varchar(50) default NULL,
			  `smtpuser` varchar(50) default NULL,
			  `smtppassword` varchar(20) default NULL,
			  `inscription_joueur` int(11) NOT NULL default '0',
			  `inscription_joueur_email` int(11) NOT NULL default '1',
			  `inscription_joueur_pre` int(11) NOT NULL default '1',
			  `inscription_equipe` int(11) NOT NULL default '1',
			  `inscription_equipe_pre` int(11) NOT NULL default '1',
			  `gzip` int(11) NOT NULL default '0',
			  `information` text,
			  `reglement` text,
			  `decharge` text,
			  `places` int(11) NOT NULL default '0',
			  `avatar` enum('N','J','E','A') NOT NULL default 'A',
			  `avatar_gallerie` int(11) NOT NULL default '0',
			  `avatar_remote` int(11) NOT NULL default '1',
			  `avatar_upload` int(11) NOT NULL default '1',
			  `avatar_x_max` int(11) NOT NULL default '80',
			  `avatar_y_max` int(11) NOT NULL default '80',
			  `avatar_filesize_max` int(11) NOT NULL default '10000',
			  `shoutbox` int(11) NOT NULL default '1',
			  `shoutlimit` int(11) NOT NULL default '20',
			  `shoutboxc` int(11) NOT NULL default '255',
			  `article` varchar(5) NOT NULL default 'off',
			  `article_config` varchar(10) NOT NULL default '1',
			  `enligne` int(1) NOT NULL default '1',
			  `poulewin` int(11) NOT NULL default '3',
			  `poulenull` int(11) NOT NULL default '2',
			  `pouleloose` int(11) NOT NULL default '1',
			  `poulefor` int(11) NOT NULL default '0',
			  `ladder` int(11) NOT NULL default '1',
			  `faq` int(11) NOT NULL default '1',
			  `support` int(1) NOT NULL default '0'
			) ;



			INSERT INTO `${dbprefix}config` VALUES (
			'', 
			'', 
			'logo.gif', 
			'accueil', 
			'', 
			'', 
			'francais', 
			'phptournois', 
			1, 
			1, 
			1, 
			1, 
			1, 
			1, 
			1, 
			0, 
			1, 
			1, 
			1, 
			1, 
			1, 
			1,
			'euroserv.fr.quakenet.org', 
			6667, 
			'', 
			'#phptournois #lan #lan.cs #lan.q3', 
			'N', 
			'', 
			'', 
			'', 
			1, 
			0, 
			0, 
			1, 
			0, 
			1, 
			'page info à écrire dans le panel configuration',
			'page reglement à écrire dans le panel configuration',
			'page decharge à écrire dans le panel configuration', 
			200, 
			'A', 
			0, 
			1, 
			1, 
			80, 
			80, 
			100000, 
			1, 
			20, 
			255, 
			'off', 
			'1', 
			1, 
			3, 
			2, 
			1, 
			0, 
			1, 
			1, 
			0);



			CREATE TABLE `${dbprefix}download` (
			  `id` int(11) NOT NULL auto_increment,
			  `nom` varchar(50) NOT NULL default '',
			  `description` varchar(255) default NULL,
			  `url` varchar(150) NOT NULL default '',
			  `taille` int(11) NOT NULL default '0',
			  `categorie` varchar(30) default NULL,
			  `hits` int(11) NOT NULL default '0',
			  `date` int(11) NOT NULL default '0',
			  PRIMARY KEY  (`id`)
			) ;


			CREATE TABLE `${dbprefix}equipes` (
			  `id` int(11) NOT NULL auto_increment,
			  `nom` varchar(50) default NULL,
			  `tag` varchar(20) default NULL,
			  `tagetendu` varchar(20) default NULL,
			  `email` varchar(50) default NULL,
			  `url` varchar(50) default NULL,
			  `irc` varchar(20) default NULL,
			  `passwd` varchar(32) NOT NULL default '',
			  `ext_devise` varchar(100) default NULL,
			  `origine` char(2) NOT NULL default 'FR',
			  `manager` int(11) default NULL,
			  `dateinscription` int(11) NOT NULL default '0',
			  `avatar` varchar(255) NOT NULL default 'null.gif',
			  `avatar_type` enum('N','G','U','R') NOT NULL default 'N',
			  `etat` enum('C','A','V') NOT NULL default 'A',
			  `carton` varchar(20) NOT NULL default 'aucun',
			  `sanction` varchar(255) default NULL,
			  `remarque` text,
			  `servername` varchar(64) NOT NULL default '',
			  `serverip` varchar(32) NOT NULL default '',
			  `id_s` int(11) NOT NULL default '0',
			  PRIMARY KEY  (`id`)
			) ;



			CREATE TABLE `${dbprefix}events` (
			  `id` int(11) NOT NULL auto_increment,
			  `equipe` int(11) NOT NULL default '0',
			  `joueur` int(11) NOT NULL default '0',
			  `titre` varchar(100) NOT NULL default '',
			  `contenu` text,
			  `date` int(11) NOT NULL default '0',
			  PRIMARY KEY  (`id`)
			) ;


			CREATE TABLE `${dbprefix}faq` (
			  `id` int(11) NOT NULL auto_increment,
			  `question` text,
			  `reponse` text,
			  `categorie` varchar(30) default NULL,
			  `rang` int(11) NOT NULL default '1',
			  `date` int(11) NOT NULL default '0',
			  `idcat` int(11) NOT NULL default '1',
			  `title` varchar(128) NOT NULL default '',
			  `text` text,
			  `description` text,
			  PRIMARY KEY  (`id`)
			) ;


			CREATE TABLE `${dbprefix}flood` (
			  `id` int(11) NOT NULL auto_increment,
			  `ip` varchar(15) NOT NULL default '',
			  `date` int(11) NOT NULL default '0',
			  `mod` varchar(255) NOT NULL default '',
			  KEY `id` (`id`)
			) ;



			CREATE TABLE `${dbprefix}forum` (
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
			) ;



			INSERT INTO `${dbprefix}forum` VALUES (38, 0, 'Remarque, suggestions !', 0, '', '', 0, 1, 0, 'Cette catégorie est accessible à [color=red][b]TOUS[/b][/color].', 'u', 0, 0, '', 0);
			INSERT INTO `${dbprefix}forum` VALUES (39, 0, 'Modo & Newseur', 0, '', '', 0, 2, 0, 'Accesible uniquement aux modos newseurs et admin', 'mn', 0, 0, '', 0);
			INSERT INTO `${dbprefix}forum` VALUES (40, 0, '', 0, '', 'Bonjour', 1, 1, 1113227281, '', '', 0, 0, '', 0);
			INSERT INTO `${dbprefix}forum` VALUES (41, 0, '', 0, '', 'Bienvenue sur cette discution privé', 2, 2, 1113227411, '', '', 0, 0, '', 0);



			CREATE TABLE `${dbprefix}forum_message` (
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
			) ;



			INSERT INTO `${dbprefix}forum_message` VALUES (97, -2, 1113227281, 1, 'Bonjour', 'Bienvenue sur le forum :)', 'N', 0, '', 1, 0);
			INSERT INTO `${dbprefix}forum_message` VALUES (98, -2, 1113227411, 2, 'Bienvenue sur cette discution privé', 'Vous voila entre personnel du staff :)\r\n\r\nBonne beta et bon tournois !', 'N', 0, '', 2, 0);



			CREATE TABLE `${dbprefix}horaires_tournois` (
			  `tournois` int(11) NOT NULL default '0',
			  `type` enum('L','W','P') NOT NULL default 'L',
			  `tour` int(11) default NULL,
			  `finale` int(11) default NULL,
			  `date` int(11) NOT NULL default '0'
			) ;



			INSERT INTO `${dbprefix}horaires_tournois` VALUES (6, 'P', 1, NULL, 1107019500);
			INSERT INTO `${dbprefix}horaires_tournois` VALUES (6, 'P', 2, NULL, 1107019500);
			INSERT INTO `${dbprefix}horaires_tournois` VALUES (6, 'P', 3, NULL, 1107020700);
			INSERT INTO `${dbprefix}horaires_tournois` VALUES (6, 'P', 4, NULL, 1107024600);
			INSERT INTO `${dbprefix}horaires_tournois` VALUES (6, 'P', 5, NULL, 1107025200);


			CREATE TABLE `${dbprefix}jeux` (
			  `id` int(11) NOT NULL auto_increment,
			  `nom` varchar(50) NOT NULL default '',
			  `sigle` varchar(20) NOT NULL default '',
			  `icone` varchar(20) NOT NULL default 'null.gif',
			  PRIMARY KEY  (`id`)
			) ;


			INSERT INTO `${dbprefix}jeux` VALUES (1, 'ALL', '', 'null.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (2, 'Counter-Strike', 'CS', 'cs.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (3, 'Unreal Tournament 2003', 'UT2K3', 'ut.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (4, 'Quake 3', 'Q3', 'q3.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (5, 'Starcraft Broodwar', 'ST BW', 'bw.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (6, 'Warcraft 3', 'W3', 'w3.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (7, 'FIFA', 'FIFA', 'fifa.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (8, 'Raven Shield', 'RvS', 'rs.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (9, 'Day of Defeat', 'DoD', 'dod.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (10, 'Battlefield1942', 'BF1942', 'bf42.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (11, 'Medal of Honor Allied Assault', 'MoHAA', 'moa.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (12, 'Half-Life', 'HL', 'hl.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (13, 'Serious Sam', 'SS', 'sam.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (14, 'C&C: Renegade', 'C&C', 'ccren.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (15, 'Age of Mythology', 'AoM', 'aom.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (16, 'Blobby Volley', 'BV', 'bv.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (17, 'Serious Sam 2', 'SS2', 'sam2.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (18, 'Soldier of Fortune 2', 'SoF2', 'sof2.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (19, 'Tribes 2', 'T2', 't2.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (20, 'Tony Hawks''s Pro Skater 3', 'THPS3', 'thps3.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (22, 'Unreal Tournament 2004', 'UT2K4', 'ut2k4.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (23, 'Halo', 'HALO', 'halo.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (24, 'Enemy Territory', 'ET', 'et.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (25, 'Tactical Ops', 'TO', 'to.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (26, 'Call of Duty', 'CoD', 'cod.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (27, 'TetriNET', 'TN', 'tn.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (28, 'Need For Speed', 'NFS', 'nfs.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (29, 'Warcraft 3 Frozen Throne', 'W3FT', 'w3ft.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (30, 'Natural Selection', 'NS', 'ns2.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (21, 'Perfect Dark 2', 'Pdark', 'pdark.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (31, 'Counter-Strike:Source', 'CS:S', 'css.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (32, 'Counter-Strike:Zero', 'CS:Z', 'czs.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (33, 'Pro evolution Soccer 4', 'PES4', 'pes4.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (34, 'Fifa 2005', 'F2005', 'fifa2005.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (35, 'Day of Defeat:Source', 'DOD:S', 'dods.gif');
			INSERT INTO `${dbprefix}jeux` VALUES (36, 'Unreal Tournament 2007', 'ut2k7', 'ut2k7.gif');



			CREATE TABLE `${dbprefix}joueurs` (
			  `id` int(11) NOT NULL default '0',
			  `pseudo` varchar(20) NOT NULL default '',
			  `nom` varchar(20) default NULL,
			  `prenom` varchar(20) default NULL,
			  `email` varchar(100) default NULL,
			  `age` char(2) default NULL,
			  `origine` char(2) NOT NULL default 'FR',
			  `ville` varchar(50) default NULL,
			  `icq` varchar(20) default NULL,
			  `aim` varchar(20) default NULL,
			  `msn` varchar(20) default NULL,
			  `yim` varchar(20) default NULL,
			  `ext_processeur` varchar(50) default NULL,
			  `ext_memoire` varchar(50) default NULL,
			  `ext_cartegraphique` varchar(50) default NULL,
			  `ext_ip` varchar(20) default NULL,
			  `passwd` varchar(32) default NULL,
			  `admin` enum('N','O') NOT NULL default 'N',
			  `newseur` enum('O','N') NOT NULL default 'N',
			  `langue` varchar(10) default NULL,
			  `etat` enum('C','M','P','I') NOT NULL default 'C',
			  `datelogin` int(11) NOT NULL default '0',
			  `dateinscription` int(11) default NULL,
			  `steam` varchar(50) default NULL,
			  `avatar` varchar(255) NOT NULL default 'null.gif',
			  `avatar_type` enum('N','G','U','R') NOT NULL default 'N',
			  `theme` varchar(50) NOT NULL default '',
			  `rang` varchar(4) NOT NULL default '',
			  `modo` enum('N','O') NOT NULL default 'N',
			  `grade` varchar(26) NOT NULL default 'z',
			  `last_forum_join` int(11) NOT NULL default '0',
			  `forum_post` int(11) NOT NULL default '0',
			  `forum_userrank` varchar(128) NOT NULL default '',
			  `carton` varchar(20) NOT NULL default 'aucun',
			  `sanction` varchar(255) default NULL,
			  `remarque` text,
			  `jointeam` int(1) NOT NULL default '1',
			  `allowmp` int(1) NOT NULL default '1',
			  PRIMARY KEY  (`id`),
			  UNIQUE KEY `pseudo` (`pseudo`)
			) ;


			INSERT INTO `${dbprefix}joueurs` VALUES (-2, 'support_phpt', 'none', 'none', 'contact@phptournois.com', '99', 'FR', 'none', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4443eae168a942dc63edfbd4d563e444', 'O', 'N', NULL, 'C', 1104925932, NULL, 'steam_0:0:000000', 'null.gif', 'N', '', '', 'N', 'abcdefghijklmnopqrstuvwxyz', 0, 2, 'phpT Dev Team', 'aucun', NULL, 'Special protected user for mod : tech support', 0, 0);
			INSERT INTO `${dbprefix}joueurs` VALUES (-1, 'retroproj', '', '', NULL, NULL, 'FR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'cbbbe46cfbcdbdf4c63d2746c51a6d91', 'N', 'N', 'francais', 'C', 1077754832, 0, NULL, '', 'U', '', '', 'N', 'z', 0, 0, '', 'aucun', NULL, '', 0, 0);
			INSERT INTO `${dbprefix}joueurs` VALUES (1, 'admin', '', '', NULL, NULL, 'FR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 'O', 'O', 'francais', 'I', 1077754832, 0, NULL, '', 'U', '', '', 'N', 'abcdefghijklmnopqrstuvwxyz', 0, 0, '', 'aucun', NULL, '', 1, 1);


			CREATE TABLE `${dbprefix}lad_comment` (
			  `id` int(11) NOT NULL auto_increment,
			  `contenu` text,
			  `auteur` varchar(60) NOT NULL default '',
			  `date` int(11) NOT NULL default '0',
			  `match_id` int(11) NOT NULL default '0',
			  PRIMARY KEY  (`id`)
			) ;



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
			) ;



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
			) ;



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
			) ;





			CREATE TABLE `${dbprefix}liens` (
			  `id` int(11) NOT NULL auto_increment,
			  `nom` varchar(50) NOT NULL default '',
			  `description` varchar(255) default NULL,
			  `url` varchar(150) NOT NULL default '',
			  `categorie` varchar(30) default NULL,
			  `hits` int(11) NOT NULL default '0',
			  `image` varchar(20) default NULL,
			  `date` int(11) NOT NULL default '0',
			  PRIMARY KEY  (`id`)
			) ;


			INSERT INTO `${dbprefix}liens` VALUES (1, 'phpTournois', 'LE site web de phpTournois ! yeah', 'http://www.phptournois.net', '', 0, 'phptournois.gif', 1072915200);



			CREATE TABLE `${dbprefix}listarticle` (
			  `id` int(11) NOT NULL auto_increment,
			  `article` varchar(255) NOT NULL default '',
			  `prix` varchar(50) NOT NULL default '',
			  `ingred` varchar(255) NOT NULL default '',
			  PRIMARY KEY  (`id`)
			) ;



			CREATE TABLE `${dbprefix}livredor` (
			  `id` int(11) NOT NULL auto_increment,
			  `auteur` varchar(20) NOT NULL default 'Invité',
			  `contenu` text,
			  `date` int(11) NOT NULL default '0',
			  PRIMARY KEY  (`id`)
			) ;



			INSERT INTO `${dbprefix}livredor` VALUES (1, 'admin', 'yop les gentils monsieurs, un ptit post sur notre forum pour nous dire si vous aimez utiliser phpTournois... \r\nca nous ferait très plaisir pour prendre le dev des prochaines versions à coeur :wub:', 1066557163);



			CREATE TABLE `${dbprefix}manches` (
			  `id` int(11) NOT NULL auto_increment,
			  `matchi` int(11) NOT NULL default '0',
			  `map` varchar(30) default NULL,
			  `score1` int(11) NOT NULL default '0',
			  `score2` int(11) NOT NULL default '0',
			  `status` enum('C','A','D','T') NOT NULL default 'C',
			  PRIMARY KEY  (`id`)
			) ;



			CREATE TABLE `${dbprefix}manches_report` (
			  `id` int(11) NOT NULL default '0',
			  `matchi` int(11) NOT NULL default '0',
			  `equipe` int(11) NOT NULL default '0',
			  `score1` int(11) NOT NULL default '0',
			  `score2` int(11) NOT NULL default '0',
			  `statusequipe` enum('F1','F2') default NULL,
			  PRIMARY KEY  (`id`)
			) ;



			CREATE TABLE `${dbprefix}maps` (
			  `id` int(11) NOT NULL auto_increment,
			  `nom` char(20) NOT NULL default '',
			  `jeux` int(11) NOT NULL default '1',
			  PRIMARY KEY  (`id`)
			) ;



			INSERT INTO `${dbprefix}maps` VALUES (14, 'de_dust2', 2);
			INSERT INTO `${dbprefix}maps` VALUES (11, 'de_train', 2);
			INSERT INTO `${dbprefix}maps` VALUES (10, 'de_inferno', 2);
			INSERT INTO `${dbprefix}maps` VALUES (9, 'de_nuke', 2);
			INSERT INTO `${dbprefix}maps` VALUES (8, 'de_aztec', 2);
			INSERT INTO `${dbprefix}maps` VALUES (15, 'de_dust', 2);
			INSERT INTO `${dbprefix}maps` VALUES (13, 'de_prodigy', 2);
			INSERT INTO `${dbprefix}maps` VALUES (16, 'de_cbble', 2);
			INSERT INTO `${dbprefix}maps` VALUES (17, 'dod_anzio', 9);
			INSERT INTO `${dbprefix}maps` VALUES (32, 'dod_jagd', 9);
			INSERT INTO `${dbprefix}maps` VALUES (33, 'dod_zalec', 9);
			INSERT INTO `${dbprefix}maps` VALUES (30, 'dod_caen', 9);
			INSERT INTO `${dbprefix}maps` VALUES (21, 'dod_avalanche', 9);
			INSERT INTO `${dbprefix}maps` VALUES (31, 'dod_flash', 9);
			INSERT INTO `${dbprefix}maps` VALUES (29, 'dod_kalt', 9);
			INSERT INTO `${dbprefix}maps` VALUES (24, 'Lost Temple', 6);
			INSERT INTO `${dbprefix}maps` VALUES (25, 'Plunder Isle', 6);
			INSERT INTO `${dbprefix}maps` VALUES (26, 'Gnoll Wood', 6);
			INSERT INTO `${dbprefix}maps` VALUES (27, 'Tranquil Paths', 6);
			INSERT INTO `${dbprefix}maps` VALUES (34, 'dod_glider', 9);
			INSERT INTO `${dbprefix}maps` VALUES (35, 'dod_chemille', 9);
			INSERT INTO `${dbprefix}maps` VALUES (37, 'Santiago Bernabeu', 16);
			INSERT INTO `${dbprefix}maps` VALUES (38, 'Default', 25);
			INSERT INTO `${dbprefix}maps` VALUES (39, 'pro-q3tourney4', 4);
			INSERT INTO `${dbprefix}maps` VALUES (40, 'pro-q3dm6', 4);
			INSERT INTO `${dbprefix}maps` VALUES (41, 'ztn3dm1', 4);
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



			CREATE TABLE `${dbprefix}maps_tournois` (
			  `tournois` int(11) NOT NULL default '0',
			  `type` enum('L','W','P') NOT NULL default 'L',
			  `tour` int(11) default NULL,
			  `finale` int(11) default NULL,
			  `manche` int(11) NOT NULL default '0',
			  `map` varchar(32) NOT NULL default ''
			) ;



			CREATE TABLE `${dbprefix}matchs` (
			  `id` int(11) NOT NULL auto_increment,
			  `equipe1` int(11) NOT NULL default '0',
			  `equipe2` int(11) NOT NULL default '0',
			  `type` enum('P','W','L','O','A') NOT NULL default 'P',
			  `poule` int(11) default NULL,
			  `tour` int(11) default NULL,
			  `finale` int(11) default NULL,
			  `numero` int(11) default NULL,
			  `tournois` int(11) NOT NULL default '0',
			  `serveur` int(11) default '0',
			  `passwd` varchar(10) default NULL,
			  `date` int(11) default NULL,
			  `up` int(11) default NULL,
			  `info` text,
			  `report1` text,
			  `report2` text,
			  `status` enum('C','A','D','V','F','T') NOT NULL default 'C',
			  `report` int(11) NOT NULL default '0',
			  `statusequipe` enum('F1','F2','D1','D2') default NULL,
			  PRIMARY KEY  (`id`),
			  UNIQUE KEY `tournois` (`tournois`,`type`,`finale`,`numero`)
			) ;



			CREATE TABLE `${dbprefix}matchs_commentaires` (
			  `id` int(11) NOT NULL auto_increment,
			  `matchi` int(11) NOT NULL default '0',
			  `auteur` int(11) NOT NULL default '0',
			  `contenu` text,
			  `date` int(11) NOT NULL default '0',
			  PRIMARY KEY  (`id`)
			) ;



			CREATE TABLE `${dbprefix}menu` (
			  `id` int(11) NOT NULL auto_increment,
			  `titre` varchar(12) NOT NULL default '',
			  `orde` int(11) NOT NULL default '0',
			  `align` enum('G','D') NOT NULL default 'G',
			  PRIMARY KEY  (`id`)
			) ;



			CREATE TABLE `${dbprefix}messages` (
			  `id` int(11) NOT NULL auto_increment,
			  `emetteur` int(11) NOT NULL default '0',
			  `destinataire` int(11) NOT NULL default '0',
			  `titre` varchar(50) NOT NULL default '',
			  `message` text,
			  `date` int(11) NOT NULL default '0',
			  `lu` int(1) NOT NULL default '0',
			  UNIQUE KEY `id` (`id`)
			) ;



			CREATE TABLE `${dbprefix}mods` (
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
			  `auto_valid_team` int(1) NOT NULL default '0',
			  `news2` int(1) NOT NULL default '0'
			) ;



			INSERT INTO `${dbprefix}mods` VALUES ('#FF0000', '#000099', '#555555', '#000044', 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, '#00AA00', 0, 0, 1, '1', 0, 0, 'Laissé ici vos notes personnels ou entre admins.', 1, 1, 5, 0, 0);


			CREATE TABLE `${dbprefix}multinews` (
			  `id` int(11) NOT NULL auto_increment,
			  `lang` char(2) NOT NULL default 'UK',
			  `titre` varchar(50) NOT NULL default '',
			  `contenu` text,
			  PRIMARY KEY  (`id`)
			) ;

			CREATE TABLE `${dbprefix}news` (
			  `id` int(11) NOT NULL auto_increment,
			  `auteur` int(11) NOT NULL default '0',
			  `icone` varchar(20) NOT NULL default 'all.gif',
			  `titre` varchar(50) NOT NULL default '',
			  `titre_2` varchar(50) NOT NULL default '',
			  `contenu` text,
			  `contenu_2` text,
			  `date` int(11) NOT NULL default '0',
			  `icone2` varchar(20) NOT NULL default '',
			  PRIMARY KEY  (`id`)
			) ;


			INSERT INTO `${dbprefix}news` VALUES (
			1, 
			1, 
			'all.gif', 
			'phpTournois modded  !!', 
			'phpTournois modded  !!', 
			'Bienvenue à vous sur cette modded de phpTournois 3.5\r\n\r\n\r\nIL risque d''y avoir quelque petit bug si et làc''est pour ça que c''est une beta ^^\r\n\r\n\r\n- > l''exportateur de tournois en page html est en étdue (il me faut l''aide de li0n qui semble avoir disparut c''est dernier temps ^^)\r\n\r\n-> le LADDER est le principal objet de cette ''beta'' je suis consient qu''il bug méchament c''est pour cela que je diffuse cette beta pour le tester concrétement.\r\n\r\n-> Pour le reste ily''à sans doute plein de petite option que j''ai oublier d''ajouter si c''est le cas faite le moi savoir ^^\r\n\r\n-> Si vous faite des ''thème'' pendant cette beta soummettez les moi, ils seront inclues dans le zip final ^^\r\nPensez au fichier de license du thème avec un petit lien vers votre site/lan :)', 
			'Bienvenue à vous sur cette modded de phpTournois 3.5\r\n\r\n\r\nIL risque d''y avoir quelque petit bug si et làc''est pour ça que c''est une beta ^^\r\n\r\n\r\n- > l''exportateur de tournois en page html est en étdue (il me faut l''aide de li0n qui semble avoir disparut c''est dernier temps ^^)\r\n\r\n-> le LADDER est le principal objet de cette ''beta'' je suis consient qu''il bug méchament c''est pour cela que je diffuse cette beta pour le tester concrétement.\r\n\r\n-> Pour le reste ily''à sans doute plein de petite option que j''ai oublier d''ajouter si c''est le cas faite le moi savoir ^^\r\n\r\n-> Si vous faite des ''thème'' pendant cette beta soummettez les moi, ils seront inclues dans le zip final ^^\r\nPensez au fichier de license du thème avec un petit lien vers votre site/lan :)', 
			".time().",
			'dr_cube_manga8.gif');



			CREATE TABLE `${dbprefix}news_commentaires` (
			  `id` int(11) NOT NULL auto_increment,
			  `news` int(11) NOT NULL default '0',
			  `auteur` int(11) NOT NULL default '0',
			  `contenu` text,
			  `date` int(11) NOT NULL default '0',
			  PRIMARY KEY  (`id`)
			) ;


			CREATE TABLE `${dbprefix}page` (
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
			) ;


			CREATE TABLE `${dbprefix}partenaires` (
			  `id` int(11) NOT NULL auto_increment,
			  `nom` varchar(50) NOT NULL default '',
			  `url` varchar(150) NOT NULL default '',
			  `image` varchar(64) NOT NULL default '',
			  `rang` int(11) NOT NULL default '0',
			  `date` int(11) NOT NULL default '0',
			  PRIMARY KEY  (`id`)
			) ;



			INSERT INTO `${dbprefix}partenaires` VALUES (2, 'phpTournois', 'http://www.phptournois.net', 'phptournois.gif', 0, 1081253456);
			INSERT INTO `${dbprefix}partenaires` VALUES (4, 'G4iens', 'http://alphasis.free.fr', 'G4iens.gif', 1, 1113227785);



			CREATE TABLE `${dbprefix}participe` (
			  `tournois` int(11) NOT NULL default '0',
			  `equipe` int(11) NOT NULL default '0',
			  `poule` int(11) default NULL,
			  `status` enum('P','F','D') default 'P',
			  `seed` int(11) default NULL,
			  `date` int(11) NOT NULL default '0',
			  PRIMARY KEY  (`tournois`,`equipe`)
			) ;



			CREATE TABLE `${dbprefix}plan` (
			  `place` int(11) NOT NULL default '0',
			  `status` int(11) NOT NULL default '0',
			  PRIMARY KEY  (`place`)
			) ;

			 

			INSERT INTO `${dbprefix}plan` VALUES (1, 0);
			INSERT INTO `${dbprefix}plan` VALUES (2, 0);
			INSERT INTO `${dbprefix}plan` VALUES (3, 0);
			INSERT INTO `${dbprefix}plan` VALUES (4, 0);
			INSERT INTO `${dbprefix}plan` VALUES (5, 0);
			INSERT INTO `${dbprefix}plan` VALUES (6, 0);
			INSERT INTO `${dbprefix}plan` VALUES (7, 0);
			INSERT INTO `${dbprefix}plan` VALUES (8, 0);
			INSERT INTO `${dbprefix}plan` VALUES (9, 0);
			INSERT INTO `${dbprefix}plan` VALUES (10, 2);
			INSERT INTO `${dbprefix}plan` VALUES (11, 0);
			INSERT INTO `${dbprefix}plan` VALUES (12, 0);
			INSERT INTO `${dbprefix}plan` VALUES (13, 0);
			INSERT INTO `${dbprefix}plan` VALUES (14, 0);
			INSERT INTO `${dbprefix}plan` VALUES (15, 0);
			INSERT INTO `${dbprefix}plan` VALUES (16, 0);
			INSERT INTO `${dbprefix}plan` VALUES (17, 0);
			INSERT INTO `${dbprefix}plan` VALUES (18, 0);
			INSERT INTO `${dbprefix}plan` VALUES (19, 0);
			INSERT INTO `${dbprefix}plan` VALUES (20, 0);
			INSERT INTO `${dbprefix}plan` VALUES (21, 0);
			INSERT INTO `${dbprefix}plan` VALUES (22, 1);
			INSERT INTO `${dbprefix}plan` VALUES (23, 0);
			INSERT INTO `${dbprefix}plan` VALUES (24, 0);
			INSERT INTO `${dbprefix}plan` VALUES (25, 0);
			INSERT INTO `${dbprefix}plan` VALUES (26, 0);
			INSERT INTO `${dbprefix}plan` VALUES (27, -1);
			INSERT INTO `${dbprefix}plan` VALUES (28, -1);
			INSERT INTO `${dbprefix}plan` VALUES (29, -1);
			INSERT INTO `${dbprefix}plan` VALUES (30, -1);



			CREATE TABLE `${dbprefix}serveurs` (
			  `id` int(11) NOT NULL auto_increment,
			  `nom` varchar(64) NOT NULL default '',
			  `adresse` varchar(32) NOT NULL default '',
			  `port` int(11) NOT NULL default '0',
			  `origine` char(2) NOT NULL default 'FR',
			  `jeux` int(11) NOT NULL default '0',
			  `protocole` varchar(10) default NULL,
			  `rcon` varchar(20) default NULL,
			  `stats` varchar(150) default NULL,
			  PRIMARY KEY  (`id`)
			) ;



			CREATE TABLE `${dbprefix}serveurs_tournois` (
			  `tournois` int(11) NOT NULL default '0',
			  `serveur` int(11) NOT NULL default '0',
			  PRIMARY KEY  (`tournois`,`serveur`)
			) ;



			CREATE TABLE `${dbprefix}sessions` (
			  `id` varchar(32) NOT NULL default '0',
			  `joueur` int(11) NOT NULL default '0',
			  `tournois` int(11) NOT NULL default '0',
			  `date` int(11) NOT NULL default '0',
			  `last_used` int(11) NOT NULL default '0',
			  `ip` varchar(32) NOT NULL default '',
			  `lang` varchar(32) NOT NULL default '',
			  `vars` blob NOT NULL,
			  UNIQUE KEY `id_sess` (`id`),
			  KEY `id` (`id`)
			) ;

			CREATE TABLE `${dbprefix}shoutbox` (
			  `id` int(11) NOT NULL auto_increment,
			  `pseudo` varchar(32) NOT NULL default 'Invité',
			  `contenu` text,
			  `ip` varchar(15) NOT NULL default '',
			  `date` int(11) NOT NULL default '0',
			  KEY `id` (`id`)
			) ;


			CREATE TABLE `${dbprefix}sponsors` (
			  `id` int(11) NOT NULL auto_increment,
			  `nom` varchar(50) NOT NULL default '',
			  `description` text,
			  `url` varchar(150) NOT NULL default '',
			  `image` varchar(64) NOT NULL default '',
			  `rang` int(11) NOT NULL default '0',
			  PRIMARY KEY  (`id`)
			) ;



			INSERT INTO `${dbprefix}sponsors` VALUES (1, 'Cacolac', '', 'http://www.cacolac.com', 'cacolac.jpg', 1);
			INSERT INTO `${dbprefix}sponsors` VALUES (2, 'Champomy', NULL, 'http://www.champomy.com', 'champomy.gif', 4);
			INSERT INTO `${dbprefix}sponsors` VALUES (3, 'Supertimor', NULL, 'http://www.chez.com/supertimor/', 'supertimor.jpg', 3);
			INSERT INTO `${dbprefix}sponsors` VALUES (5, 'Pere Dodu', NULL, 'http://www.peredodujeux.com', 'peredodu.gif', 5);
			INSERT INTO `${dbprefix}sponsors` VALUES (6, 'Ricard', '', 'http://www.ricard.fr', 'ricard.gif', 0);
			INSERT INTO `${dbprefix}sponsors` VALUES (7, 'Chocapic', NULL, 'http://www.multimania.com/blofang/choco.htm', 'chocapic.jpg', 7);
			INSERT INTO `${dbprefix}sponsors` VALUES (8, 'Durex', '', 'http://www.durex.com', 'durex.gif', 8);
			INSERT INTO `${dbprefix}sponsors` VALUES (9, 'Jean Floc''h', NULL, 'http://www.jean-floch.fr', 'jeanfloch.gif', 3);
			        

			CREATE TABLE `${dbprefix}stats` (
			  `nom` text,
			  `type` varchar(32) NOT NULL default '',
			  `count` int(11) NOT NULL default '0'
			) ;

			
			INSERT INTO `${dbprefix}stats` VALUES ('Internet Explorer', 'browser', 0);
			INSERT INTO `${dbprefix}stats` VALUES ('Netscape', 'browser', 0);
			INSERT INTO `${dbprefix}stats` VALUES ('Opera', 'browser', 0);
			INSERT INTO `${dbprefix}stats` VALUES ('Lynx', 'browser', 0);
			INSERT INTO `${dbprefix}stats` VALUES ('WebTV', 'browser', 0);
			INSERT INTO `${dbprefix}stats` VALUES ('Konqueror', 'browser', 0);
			INSERT INTO `${dbprefix}stats` VALUES ('Moteurs de recherche', 'browser', 0);
			INSERT INTO `${dbprefix}stats` VALUES ('Autres', 'browser', 0);
			INSERT INTO `${dbprefix}stats` VALUES ('Windows', 'os', 0);
			INSERT INTO `${dbprefix}stats` VALUES ('Mac', 'os', 0);
			INSERT INTO `${dbprefix}stats` VALUES ('Linux', 'os', 0);
			INSERT INTO `${dbprefix}stats` VALUES ('FreeBSD', 'os', 0);
			INSERT INTO `${dbprefix}stats` VALUES ('SunOS', 'os', 0);
			INSERT INTO `${dbprefix}stats` VALUES ('IRIX', 'os', 0);
			INSERT INTO `${dbprefix}stats` VALUES ('BeOS', 'os', 0);
			INSERT INTO `${dbprefix}stats` VALUES ('OS/2', 'os', 0);
			INSERT INTO `${dbprefix}stats` VALUES ('Aix', 'os', 0);
			INSERT INTO `${dbprefix}stats` VALUES ('Autres', 'os', 0);
			INSERT INTO `${dbprefix}stats` VALUES ('visites', 'compteur', 0);
			INSERT INTO `${dbprefix}stats` VALUES ('pages vues', 'compteur', 0);



			CREATE TABLE `${dbprefix}tournois` (
			  `id` int(11) NOT NULL auto_increment,
			  `nom` varchar(50) NOT NULL default '',
			  `type` enum('T','C','E') NOT NULL default 'T',
			  `jeux` int(11) NOT NULL default '1',
			  `poules` int(11) default '4',
			  `winner` int(11) default '8',
			  `looser` int(11) default '8',
			  `elimination` enum('S','D') NOT NULL default 'S',
			  `modeequipe` enum('J','E') NOT NULL default 'E',
			  `modescore` enum('A','J','M4','AB') NOT NULL default 'A',
			  `modematchscore` enum('R','F','RF') NOT NULL default 'F',
			  `modeinscription` enum('J','A') NOT NULL default 'A',
			  `manchesmax` int(11) NOT NULL default '1',
			  `information` varchar(32) default NULL,
			  `dotation` varchar(32) default NULL,
			  `reglement` varchar(32) default NULL,
			  `places` int(11) NOT NULL default '0',
			  `stats` varchar(150) default NULL,
			  `modefichier` enum('N','A','C') NOT NULL default 'N',
			  `modecommentaire` enum('O','N') NOT NULL default 'O',
			  `status` enum('C','I','G','P','H','F','T') NOT NULL default 'C',
			  PRIMARY KEY  (`id`),
			  UNIQUE KEY `nom` (`nom`)
			);



			";
?>
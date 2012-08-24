<?php
/*
   +---------------------------------------------------------------------+
   | phpTournois                                                         |
   +---------------------------------------------------------------------+
   +---------------------------------------------------------------------+
   | phpTournoisG4 ©2005 by Gectou4 <Gectou4 Gectou4@hotmail.com>        |
   +---------------------------------------------------------------------+
         This version is based on phpTournois 3.5 realased by :
   | Copyright(c) 2001-2004 Li0n, RV, Gougou (http://www.phptournois.com)|
   +---------------------------------------------------------------------+
   | This file is part of phpTournois.                                   |
   |                                                                     |
   | phpTournois is free software; you can redistribute it and/or modify |
   | it under the terms of the GNU General Public License as published by|
   | the Free Software Foundation; either version 2 of the License, or   |
   | (at your option) any later version.                                 |
   |                                                                     |
   | phpTournois is distributed in the hope that it will be useful,      |
   | but WITHOUT ANY WARRANTY; without even the implied warranty of      |
   | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the       |
   | GNU General Public License for more details.                        |
   |                                                                     |
   | You should have received a copy of the GNU General Public License   |
   | along with AdminBot; if not, write to the Free Software Foundation, |
   | Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA       |
   |                                                                     |
   +---------------------------------------------------------------------+
   | Authors: Li0n  <li0n@phptournois.com>                               |
   |          RV <rv@phptournois.com>                                    |
   |          Gougou                                                     |
   +---------------------------------------------------------------------+
*/

if ($op == "update") {

global $db,$dbprefix;

		echo '<b> Suivi d\'install : </b><br>';
		
		$sql = "ALTER TABLE ${dbprefix}config ADD `rangforum` enum('0', '1') DEFAULT '0' NOT NULL"; 
		$req = mysql_query($sql) or die('<font color="red"><b>ERREUR : rangforum n\'a pus être ajouté à la table config </b></font><br>');
		echo '<font color="green"><b> rangforum ajouté à la table config </b></font><br>';
		
		$sql2 = "ALTER TABLE ${dbprefix}joueurs ADD `last_forum_join` INT( 11 ) DEFAULT '0' NOT NULL "; 
		$req2 = mysql_query($sql2) or die('<font color="red"><b>ERREUR : last_forum_join n\'a pus être ajouté à la table joueurs </b></font><br>');
		echo '<font color="green"><b> last_forum_join ajouté à la table joueurs</b></font><br>';
		
		$sql3 = "ALTER TABLE ${dbprefix}joueurs ADD `forum_post` INT( 11 ) DEFAULT '0' NOT NULL "; 
		$req3 = mysql_query($sql3) or die('<font color="red"><b>ERREUR : forum_post n\'a pus être ajouté à la table joueurs </b></font><br>');
		echo '<font color="green"><b> forum_post ajouté à la table joueurs </b></font><br>';
		
		$sql4 = "ALTER TABLE ${dbprefix}joueurs ADD `forum_userrank` VARCHAR( 128 ) DEFAULT 'noob du forum' NOT NULL  "; 
		$req4 = mysql_query($sql4) or die('<font color="red"><b>ERREUR : forum_userrank n\'a pus être ajouté à la table  joueur</b></font><br>');
		echo '<font color="green"><b> forum_userrank ajouté à la table joueurs </b></font><br>';
		
		$sql5 = "ALTER TABLE ${dbprefix}forum_message ADD `cattopic` INT( 11 ) DEFAULT '0' NOT NULL "; 
		$req5 = mysql_query($sql5) or die('<font color="red"><b>ERREUR : cattopic n\'a pus être ajouté à la table forum_message </b></font><br>');
		echo '<font color="green"><b> cattopic ajouté à la table forum_message </b></font><br>';
		
		$sql6 = "ALTER TABLE ${dbprefix}forum ADD `reserved` VARCHAR( 132 ) NOT NULL "; 
		$req6 = mysql_query($sql6) or die('<font color="red"><b>ERREUR : reserved n\'a pus être ajouté à la table forum </b></font><br>');
		echo '<font color="green"><b> reserved ajouté à la table forum </b></font><br>';
			
	
		
		$db->select("topid,cattopic");
		$db->from("${dbprefix}forum");
		$res=$db->exec();
		
		
		while ($ud = $db->fetch($res)) {
		
		$db->update("${dbprefix}forum_message");
		$db->set("cattopic = '".$ud->cattopic."'");
		$db->where("topid = ".$ud->cattopic."");
		$db->exec();
		echo '<font color="green"><b> UPDATE de cattopic '.$ud->cattopic.' du topid : '.$ud->cattopic.' Effectué avec succé !</b></font><br>';
		
		
		}
		
		echo 'La mise à jour à été effectué, vérifier quand même que tous c\'est bien passé.<br>
		pensez à supprimer ce fichier de votre ftp.';
	}	


echo '<br><br><a href="?page=mod_install&op=update"><b>cliquer ici pour lancer la MAJ</b></a><br>Elle sera achevé une fois la page suivante avec le texte de succée affiché.';
?>

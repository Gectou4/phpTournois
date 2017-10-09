<?php
/*
   +---------------------------------------------------------------------+
   | phpTournois                                                         |
   +---------------------------------------------------------------------+
   +---------------------------------------------------------------------+
  | phpTournoisG4 �2005 by Gectou4 <Gectou4 Gectou4@hotmail.com>        |
   +---------------------------------------------------------------------+
         This version is based on phpTournois 3.5 realased by :
   | Copyright(c) 2001-2004 Li0n, RV, Gougou (http://www.phptournois.net)|
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
   | Authors: Li0n  <li0n@phptournois.net>                               |
   |          RV <rv@phptournois.net>                                    |
   |          Gougou                                                     |
   +---------------------------------------------------------------------+
*/

if (preg_match("/block_joueur.php/i", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}

global $config,$s_joueur,$s_theme,$db,$dbprefix;
global $strJoueur,$strPseudo,$strSeRappeler,$strPassword,$strConnecter,$strPasConnecte,$strConnexion,$strConnecte,$strDeconnexion,$strMaFiche,$strMonEquipe,$strMesEquipes,$strMessagerie,$strLireMessage,$strEcrireMessage,$strMessageNouveau,$strSInscrire,$strOubliPass,$strCreerEquipe,$strRejoindreUneEquipe;

/*** menu Joueur ***/
theme_openblock("<img src=\"themes/$s_theme/images/icon_joueur.gif\" align=\"absmiddle\" alt=\"joueur\"> $strJoueur ");

if (empty($s_joueur)) {
	
	if(isset($_COOKIE['data'])) {
		$data_info = $_COOKIE['data'];
		$data_info = base64_decode($data_info);
		$user_data = explode('|',$data_info);
		$checked = 'checked';
		/*** transmition des variables via donn&eacute;e du cookie ***/
  $pseudo=$user_data[0];
  $passwd=$user_data[1];
	}
	else {
		$user_data = array('','');
		$checked = '';		
	}
	
	echo '<form name="login" method="post" action="?page=login&op=login">';
	echo "<div style=\"text-align:center\"><span class=\"warning\" style=\"align:center\">$strPasConnecte</span></div>";
	echo "<a href=\"?page=login\">$strConnexion</a><br />";
		
	echo '<table cellspacing="0" cellpadding="0" border="0" width="100%">';
	echo '<tr>';
	echo "<td class=\"textfiche\">$strPseudo :<br />";
	echo "<input type=\"text\" name=\"pseudo\" value=\"$user_data[0]\" size=\"15\"></td>";
	echo '</tr>';
	echo '<tr>';
	echo "<td class=\"textfiche\">$strPassword :<br />";
	echo "<input type=\"password\" name=\"passwd\" value=\"$user_data[1]\" size=\"15\"></td>";
	echo '</tr>';
	echo '<tr>';
	echo "<td class=\"text\" colspan=\"2\" style=\"text-align:center\"><input type=\"checkbox\" name=\"remember\" size=\"10\" value=\"1\" checked=\"$checked\" style=\"border: 0px;background-color:transparent;\"><small>$strSeRappeler</small></td>";
	echo '</tr>';
	echo '<tr>';
	echo "<td class=\"footerfiche\" style=\"text-align:center\" colspan=\"2\"><input type=\"submit\" value=\"$strConnecter\"></td>";
	echo '</tr>';
	echo '</form>';
	echo '</table><br />';
	echo '<div align="center">';
	if($config['inscription_joueur']) {
		$nbinscrits=nb_joueurs_inscrit();
		$nbplaces=$config['places'];

		if($nbinscrits < $nbplaces) 
			echo "<a href=\"?page=joueurs&op=inscription\"><span style=\"color=:red;font_weight:bold\">$strSInscrire</span></a><br />";
	}
	echo "<a href=\"?page=joueurs&op=envoi_passwd\">$strOubliPass</a>";
	echo '</div>';
}
else {
	echo "<span class=\"connecte\">&nbsp; $strConnecte : ".nom_joueur($s_joueur)."</span><br />";
	echo "<ul><li class=\"lir\"><a href=\"?page=login&op=logout\">$strDeconnexion</a><br />";

	/** login diff du retroproj **/
	if($s_joueur != -1) {
		echo "<li class=\"lib\"><a href=\"?page=joueurs&id=$s_joueur\">$strMaFiche</a><br />";
		$mesequipes=equipes_joueur($s_joueur);
				
		if(count($mesequipes)==1) {
			echo '<li class="lib"><a href="?page=equipes&id='.$mesequipes[0]['id']."\">$strMonEquipe ".stripslashes($mesequipes[0]['tag']).'</a><br />';
		}
		elseif(count($mesequipes)>1) {
			echo "<br /><img src=\"themes/$s_theme/images/icon_equipes.gif\" align=absmiddle> <u>$strMesEquipes</u> :<br />";
		
			for($i=0;$i<count($mesequipes);$i++) {
				echo '<li class="lib"><a href="?page=equipes&id='.$mesequipes[$i]['id'].'">'.stripslashes($mesequipes[$i]['tag']).'</a><br />';
			}
		}
		if($config['inscription_equipe']) {
			echo "<li class=\"lib\"><a href=\"?page=equipes&op=inscription\"><font color=\"red\"><b>$strCreerEquipe</b></font></a><br />";
		}
		echo "<li class=\"lib\"><a href=\"?page=equipes&op=rejoindre\">$strRejoindreUneEquipe</a><br />";


		if($config['messagerie']) {
			$nb_new_message=nb_new_message($s_joueur);
			if($nb_new_message>0) $img='icon_messagerie_g.gif';
			else $img='icon_messagerie.gif';
			echo "<br />&nbsp; <img src=\"themes/$s_theme/images/$img\" align=\"absmiddle\" alt\"\"> <u>$strMessagerie</u> :<br />";
			echo "<li class=\"lib\"><a href=\"?page=messagerie\">$strLireMessage (<span style=\"font-weight:bold;\">".$nb_new_message.'</span>)</a><br />';
			echo "<li class=\"lib\"><a href=\"?page=messagerie&op=ecrire\">$strEcrireMessage</a>";
		}
	}
	echo "</ul>";
}

 global $config,$strRechecrher,$strDans,$strJoueurs,$strEquipes,$strNews,$strForum,$strSID,$strOK;
 
  echo '<table cellspacing="0" cellpadding="1" border="0">';
  echo '<tr><form method="post" action="?page=search&op=searching">';
  echo '<td class="textfiche" colspan="2"><input type="text" name="search" maxlength="20" value="'.$strRechecrher.'" onfocus="this.value=\'\'"></td></tr>';
  echo "<tr><td class=\"titlefiche\">$strDans :</td>";
  echo '<td class="textfiche">';
  echo "<select name=\"howto\">";
  echo "<option value=\"joueur\">$strJoueurs</option>";
  echo "<option value=\"equipe\">$strEquipes</option>";
  if ($strNews) {
  echo "<option value=\"new\">$strNews</option>";
  }
  if ($strForum) {
  echo "<option value=\"forum\">$strForum</option>";	
  }
  if ($strSID) {
  echo "<option value=\"steam\">$strSID</option>";
  }  
  echo "</select><input type=\"submit\" class=\"action\" value=\"$strOK\"></td>";
  echo '</tr>';
  echo "<tr><td class=\"textfiche\" colspan=\"2\" align=\"center\"><span class=\"info\"><img src=\"themes/$s_theme/images/p_ip.gif\" align=\"absmiddle\" alt=\"ip\"> ".$_SERVER['REMOTE_ADDR']."</span></td></tr></form>";
  echo '</table>';


theme_closeblock();


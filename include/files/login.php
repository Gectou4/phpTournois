<?php
/*
   +---------------------------------------------------------------------+
   | phpTournois                                                         |
   +---------------------------------------------------------------------+
   +---------------------------------------------------------------------+
   | phpTournoisG4 ©2005 by Gectou4 <Gectou4 Gectou4@hotmail.com>        |
   +---------------------------------------------------------------------+
         This version is based on phpTournois 3.5 realased by :
   +---------------------------------------------------------------------+
   | phpTournoisG4 ©2004 by Gectou4 <le_gardien_prime@hotmail.com>       |
   +---------------------------------------------------------------------+
         This version is based on phpTournois 3.5 realased by :
   +---------------------------------------------------------------------+
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
if (eregi("login.php", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}

/******************************************************** 
 * Connexion
 */
if ($op == "login") {

/*
	$login_agree = "ok";

	if ($config['support']=="1" AND ($pseudo=="Support_phpT" || $pseudo=="support_phpt")) {
	$login_agree = "ok";
	} else if ($config['support']!="1" AND ($pseudo=="Support_phpT" || $pseudo=="support_phpt")) {
    $login_agree = "no";
	}
	
	if ($login_agree == "ok") {
	$db->select("id,langue,admin");
	$db->from("${dbprefix}joueurs");
	$db->where("pseudo = '$pseudo'");
	$db->where("passwd = md5('$passwd')");
	$db->where("passwd != ''");
	$db->where("passwd is not null");
	$db->where("(etat in ('P','I','C') or id = -1 or id = -2 )");
	$db->exec();

	if ($db->num_rows() != 0) {
		$joueur = $db->fetch();

		// creation de la session
		/*
		SessionNew(session_id(),$joueur->id);		
		SessionSetVar("s_joueur",$joueur->id);
		SessionSetVar("s_type","1");

		if(eregi('a',$joueur->grade)||eregi('b',$joueur->grade)) {
			SessionSetVar("s_type","2");
		}

		if($joueur->langue) {
			SessionSetVar("s_lang",$joueur->langue);
		}

		/*** enregistrer ses infos ***
		if(isset($remember)) {			
			$data_info="$pseudo|$passwd";
			$data_info=base64_encode($data_info);
			setcookie("data","$data_info",time()+9999999);
		}
		else {
			setcookie("data","",time()-9999999);
		}
*/
		// update de la date de login
		/*
		$db->update("${dbprefix}joueurs");
		$db->set("datelogin = '".time()."'");
		$db->where("id = '$joueur->id'");
		$db->exec();
		
		js_goto("?page=index");
	}
	else {
		js_goto("?page=login&erreur=1");
	}

	}
	else {
		js_goto("?page=login&erreur=1");
	}*/
	js_goto("?page=index");
}
/******************************************************** 
 * Deconnexion
 */
elseif ($op == "logout") {
/*
	$db->delete("${dbprefix}compteur");
	$db->where("joueur = '".$s_joueur."'");
	$db->exec();
	/*
	setcookie('CUID',"", time() - 3600);
	
	//on vide l'entr&eacute;e enregistr&eacute;e dans la table
	$db->delete("${dbprefix}compteur");
	$db->where("id = '".session_id()."'");
	$db->exec();
	
	session_unset();
	session_destroy();
	setcookie("data","",time()-9999999);	
*/	
	js_goto("?page=index");

}
/******************************************************** 
 * Formulaire de connexion
 */
else {
		
 	echo "<p class=title>.:: $strConnexion ::.</p>";
 	
 	if(isset($erreur)) echo "<span class=warning>$strErreurLogin</span>";
	
	if(isset($_COOKIE['data'])) {
		$data_info = $_COOKIE['data'];
		$data_info = base64_decode($data_info);
		$user_data = explode('|',$data_info);
		$checked = 'checked';
	}
	else {
		$user_data = array('','');
		$checked = '';		
	}
	
	/*** formulaire ***/
	echo "<form method=post>";
	echo "<input type=hidden name=op value=login>";

	echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
	echo "<table cellspacing=1 cellpadding=0 border=0>";
	echo "<tr><td class=headerfiche>$strLogin</td></tr>";
	echo "<tr><td>";

	echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
	echo "<tr>";
	echo "<td class=titlefiche>$strPseudo : </td>";
	echo "<td class=text><input type=text name=pseudo value=\"$user_data[0]\" size=20></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class=titlefiche>$strPassword :</td>";
	echo "<td class=text><input type=password name=passwd value=\"$user_data[1]\" size=20></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class=text colspan=2 align=center><input type=checkbox name=remember size=10 value=1 $checked style=\"border: 0px;background-color:transparent;\"><small>$strSeRappeler</small></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class=footerfiche align=center colspan=2><input type=submit value=\"$strConnecter\"></td>";
	echo "</tr>";
	echo "</table>";

	echo "</td></tr></table>";	
	echo "</td></tr></table>";
	echo "</form>";
	
	if($config['inscription_joueur']) {
		$nbinscrits=nb_joueurs_inscrit();
		$nbplaces=$config['places'];

		if($nbinscrits < $nbplaces) 
			echo "<a href=\"?page=joueurs&op=inscription\"  class=action><b><font color=\"red\">$strSInscrire</font></b></a><br>";
	}
	echo '<a href="?page=joueurs&op=envoi_passwd" class="action">'.$strOubliPass.'</a>';
	
	echo "<br><br><img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";

}

?>

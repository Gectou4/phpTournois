<?php
/*
   +---------------------------------------------------------------------+
   | phpTournois                                                         |
   +---------------------------------------------------------------------+
   +---------------------------------------------------------------------+
   | phpTournoisG4 ©2005 by Gectou4 <Gectou4 Gectou4@hotmail.com>        |
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
/*** verification securite ***/
if (eregi("mods.php", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}

if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['c']!='c') {js_goto($PHP_SELF);} 

/******************************************************** 
 * Modification de la configuration
 */
if ($op == "modify") {
	
	$str='';
	$erreur=0;
	
	if($erreur==1) {		
		show_erreur_saisie($str);			
	}
	else {		
		  	
		$db->update("${dbprefix}mods");
		$db->set("MODEnLigneA='$MODEnLigneA',MODEnLigneN='$MODEnLigneN',MODEnLigneM='$MODEnLigneM',MODEnLigneW='$MODEnLigneW',MODEnLigneMo='$MODEnLigneMo'");
		$db->set("nom='$nom',prenom='$prenom',age='$age',ville='$ville',customtheme='$customtheme',forcing='$forcing',plan='$plan',rangforum='$rangforum'");
		$db->set("Osteamid='$Osteamid',pagescript='$pagescript',topdl='$topdl',bbcode='$bbcode',topplayer='$topplayer',lastresult='$lastresult',lastnews='$lastnews'");
		$db->set("lastnews_header='$lastnews_header',serverteam='$serverteam',m_team_valid='$m_team_valid',m_team_valid_num='$m_team_valid_num',auto_valid_team='$auto_valid_team'");
		$db->set("news2='$news2'");
		$db->exec();
	
		/*** redirection ***/
		js_goto("?page=mods&op=pcmods");
	}

}
/********************************************************
 * Affichage admin
 */
else if ($op == "pcmods") {

	echo "<p class=title>.:: $strMODS ::.<br><font size=2>$strMODSC</font></p>";

	$db->select("*");
	$db->from("${dbprefix}mods");
	$db->exec();
	$modsp = $db->fetch();

	echo "<form name=formulaire method=post action=?page=mods&op=modify>";
	//echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
	//echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td class=textfichemods align='center'>";
	
	/*** table de la config ***/
	echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
	echo "<table cellspacing=1 cellpadding=0 border=0>";
	echo "<tr><td class=modsfiche>&nbsp; $strMODEnLigne &nbsp;</td></tr>";
	echo "<tr><td>";
	echo "<table cellspacing=0 cellpadding=2 border=0 width=100%>";
	echo "<tr><td class=partfiche colspan=4></td></tr>";

	/*** enligne A ***/
	echo "<tr><td class=titlefichemods>$strMODEnLigneA :</td>";
	echo "<td class=textfichemods><input type=text name=MODEnLigneA value=\"$modsp->MODEnLigneA\" size=10>";
	echo "</td><td width='64' height='10' bgcolor='$modsp->MODEnLigneA'>&nbsp;</td><td class=textfiche></td></tr>";
	
	/*** enligne Mo ***/
	echo "<tr><td class=titlefichemods>$strMODEnLigneMo :</td>";
	echo "<td class=textfichemods><input type=text name=MODEnLigneMo value=\"$modsp->MODEnLigneMo\" size=10>";
	echo "</td><td width='64' height='10' bgcolor='$modsp->MODEnLigneMo'>&nbsp;</td><td class=textfiche></td></tr>";
	
	/*** enligne N ***/
	echo "<tr><td class=titlefichemods>$strMODEnLigneN :</td>";
	echo "<td class=textfichemods><input type=text name=MODEnLigneN value=\"$modsp->MODEnLigneN\" size=10>";
	echo "</td><td width='64' height='10' bgcolor='$modsp->MODEnLigneN'>&nbsp;</td><td class=textfiche></td></tr>";
	
	/*** enligne M ***/
	echo "<tr><td class=titlefichemods>$strMODEnLigneM :</td>";
	echo "<td class=textfichemods><input type=text name=MODEnLigneM value=\"$modsp->MODEnLigneM\" size=10>";
	echo "</td><td name='em' id='em' width='64' height='10' bgcolor='$modsp->MODEnLigneM'>&nbsp;</td><td class=textfiche></td></tr>";
	
	/*** enligne W ***/
	echo "<tr><td class=titlefichemods>$strMODEnLigneW :</td>";
	echo "<td class=textfichemods><input type=text name=MODEnLigneW value=\"$modsp->MODEnLigneW\" size=10>";
	echo "</td><td width='64' height='10' bgcolor='$modsp->MODEnLigneW'>&nbsp;</td><td class=textfiche></td></tr>";
	echo "<tr><td class=footerfichemods colspan=4><hr><input type=submit value=\"$strModifier\"></td></tr>";


	echo "</table>";
	echo "</td></tr></table>";
	//echo "</td></tr></table>";
	
	
	/*** tableau Mod profil ***/
	//echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
	echo "<table cellspacing=1 cellpadding=0 border=0>";
	echo "<tr><td class=modsfiche width='100%'>$strModsProfil</td></tr>";
	echo "<tr><td>";
	echo "<table cellspacing=0 cellpadding=2 border=0 width=100%>";
	echo "<tr><td class=partfiche colspan=2></td></tr>";

	/*** Nom ***/
	echo "<tr><td class=titlefichemods>$strNom : (see only by admin)</td>";
	echo "<td class=textfichemods>";
	echo "<input type=radio name=nom value=1 style=\"border: 0px;background-color:#66CC66;\"";if ($modsp->nom == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=nom value=0 style=\"border: 0px;background-color:#FF6666;\"";if ($modsp->nom == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";
	
	/*** Prenom ***/
	echo "<tr><td class=titlefichemods>$strPrenom : (see only by admin)</td>";
	echo "<td class=textfichemods>";
	echo "<input type=radio name=prenom value=1 style=\"border: 0px;background-color:#66CC66;\"";if ($modsp->prenom == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=prenom value=0 style=\"border: 0px;background-color:#FF6666;\"";if ($modsp->prenom == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";
	
	/*** Age ***/
	echo "<tr><td class=titlefichemods>$strAge :</td>";
	echo "<td class=textfichemods>";
	echo "<input type=radio name=age value=1 style=\"border: 0px;background-color:#66CC66;\"";if ($modsp->age == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=age value=0 style=\"border: 0px;background-color:#FF6666;\"";if ($modsp->age == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";
	
	/*** Ville ***/
	echo "<tr><td class=titlefichemods>$strVille :</td>";
	echo "<td class=textfichemods>";
	echo "<input type=radio name=ville value=1 style=\"border: 0px;background-color:#66CC66;\"";if ($modsp->ville == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=ville value=0 style=\"border: 0px;background-color:#FF6666;\"";if ($modsp->ville == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";
	echo "<tr><td class=footerfichemods colspan=2><hr><input type=submit value=\"$strModifier\"></td></tr>";


	echo "</table>";
	echo "</td></tr></table>";
	//echo "</td></tr></table>";
	
	/*** tableau security ***/
	
	echo "<table cellspacing=1 cellpadding=0 border=0>";
	echo "<tr><td class=modsfiche width='100%'>$strFtitle_sec</td></tr>";
	echo "<tr><td>";
	echo "<table cellspacing=0 cellpadding=2 border=0 width=100%>";
	echo "<tr><td class=partfiche colspan=2></td></tr>";
		
	/*** Ville ***/
	echo "<tr><td class=titlefichemods>$strFtitle :</td>";
	echo "<td class=textfichemods>";
	echo "<input type=radio name=forcing value=1 style=\"border: 0px;background-color:#66CC66;\"";if ($modsp->forcing == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=forcing value=0 style=\"border: 0px;background-color:#FF6666;\"";if ($modsp->forcing == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";
	
	echo "<tr><td class=footerfichemods colspan=2><hr><input type=submit value=\"$strModifier\"></td></tr>";
	echo "</table>";
	echo "</td></tr></table>";
	
	/*** tableau Mod 'top' ***/
	//echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
	echo "<table cellspacing=1 cellpadding=0 border=0>";
	echo "<tr><td class=modsfiche width='100%'>$strtop10_mod</td></tr>";
	echo "<tr><td>";
	echo "<table cellspacing=0 cellpadding=2 border=0 width=100%>";
	echo "<tr><td class=partfiche colspan=2></td></tr>";

	/*** Top10dl ***/
	echo "<tr><td class=titlefichemods>$strtop10dl : </td>";
	echo "<td class=textfichemods>";
	echo "<input type=radio name=topdl value=1 style=\"border: 0px;background-color:#66CC66;\"";if ($modsp->topdl == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=topdl value=0 style=\"border: 0px;background-color:#FF6666;\"";if ($modsp->topdl == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";
	
	/*** 10player ***/
	echo "<tr><td class=titlefichemods>$strtop10player : </td>";
	echo "<td class=textfichemods>";
	echo "<input type=radio name=topplayer value=1 style=\"border: 0px;background-color:#66CC66;\"";if ($modsp->topplayer == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=topplayer value=0 style=\"border: 0px;background-color:#FF6666;\"";if ($modsp->topplayer == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";
	
	/*** lastresult ***/
	echo "<tr><td class=titlefichemods>$strlastresult : </td>";
	echo "<td class=textfichemods>";
	echo "<input type=radio name=lastresult value=1 style=\"border: 0px;background-color:#66CC66;\"";if ($modsp->lastresult == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=lastresult value=0 style=\"border: 0px;background-color:#FF6666;\"";if ($modsp->lastresult == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";
	
	/*** lastnews ***/
	echo "<tr><td class=titlefichemods>$strlastnews : </td>";
	echo "<td class=textfichemods>";
	echo "<input type=radio name=lastnews value=1 style=\"border: 0px;background-color:#66CC66;\"";if ($modsp->lastnews == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=lastnews value=0 style=\"border: 0px;background-color:#FF6666;\"";if ($modsp->lastnews == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";
	
	/*** lastnews_header ***/
	echo "<tr><td class=titlefichemods>$strlastnews_header : </td>";
	echo "<td class=textfichemods>";
	echo "<input type=radio name=lastnews_header value=1 style=\"border: 0px;background-color:#66CC66;\"";if ($modsp->lastnews_header == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=lastnews_header value=0 style=\"border: 0px;background-color:#FF6666;\"";if ($modsp->lastnews_header == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";

	echo "<tr><td class=footerfichemods colspan=2><hr><input type=submit value=\"$strModifier\"></td></tr>";
	
	echo "</table>";
	echo "</td></tr></table>";
	
	/*** tableau Divers ***/
	//echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
	echo "<table cellspacing=1 cellpadding=0 border=0>";
	echo "<tr><td class=modsfiche>$strMODDiver</td></tr>";
	echo "<tr><td>";
	echo "<table cellspacing=0 cellpadding=2 border=0 width=100%>";
	echo "<tr><td class=partfiche colspan=2></td></tr>";

	/*** Theme custom ***/
	echo "<tr><td class=titlefichemods bordercolor=red>$strCustTheme :</td>";
	echo "<td class=textfichemods>";
	echo "<input type=radio name=customtheme value=1 style=\"border: 0px;background-color:#66CC66;\"";if ($modsp->customtheme == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=customtheme value=0 style=\"border: 0px;background-color:#FF6666;\"";if ($modsp->customtheme == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";
	
	/*** Script HTML ***/
	echo "<tr><td class=titlefichemods>$strpagescript :</td>";
	echo "<td class=textfichemods>";
	echo "<input type=radio name=pagescript value=1 style=\"border: 0px;background-color:#66CC66;\"";if ($modsp->pagescript == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=pagescript value=0 style=\"border: 0px;background-color:#FF6666;\"";if ($modsp->pagescript == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";
	
	/*** SteamID MOD ***/
	echo "<tr><td class=titlefichemods>$strSteamIDO :</td>";
	echo "<td class=textfichemods>";
	echo "<input type=radio name=Osteamid value=1 style=\"border: 0px;background-color:#66CC66;\"";if ($modsp->Osteamid == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=Osteamid value=0 style=\"border: 0px;background-color:#FF6666;\"";if ($modsp->Osteamid == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";
	
	/*** Plan de Salle ***/
	echo "<tr><td class=titlefichemods>$strPlanSalle :</td>";
	echo "<td class=textfichemods>";
	echo "<input type=radio name=plan value=1 style=\"border: 0px;background-color:#66CC66;\"";if ($modsp->plan == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=plan value=0 style=\"border: 0px;background-color:#FF6666;\"";if ($modsp->plan == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";
	
	/***News 2***/
	if ($config['default_lang']=="english") {
	echo "<tr><td class=titlefichemods>$strNewsUK : <br />(your site is already in english)</td>";
	echo "<td class=textfichemods>";
	echo "<input type=radio name=news2 value=1 style=\"border: 0px;background-color:#66CC66;\" DISABLED> $strOui ";
	echo "<input type=radio name=news2 value=0 style=\"border: 0px;background-color:#FF6666;\" CHECKED> $strNon";
	echo "</td></tr>";
	} else {
	echo "<tr><td class=titlefichemods>$strNewsUK :</td>";
	echo "<td class=textfichemods>";
	echo "<input type=radio name=news2 value=1 style=\"border: 0px;background-color:#66CC66;\"";if ($modsp->news2 == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=news2 value=0 style=\"border: 0px;background-color:#FF6666;\"";if ($modsp->news2 == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";
	}
	
	/***Forum post ***/
	echo "<tr><td class=titlefichemods>$strForumnbpost : </td>";
	echo "<td class=textfichemods>";
	echo "<input type=radio name=rangforum value=1 style=\"border: 0px;background-color:#66CC66;\"";if ($modsp->rangforum == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=rangforum value=0 style=\"border: 0px;background-color:#FF6666;\"";if ($modsp->rangforum == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";
	
	/*** Server Team ***/
	echo "<tr><td class=titlefichemods>$strServerTeam : </td>";
	echo "<td class=textfichemods>";
	echo "<input type=radio name=serverteam value=1 style=\"border: 0px;background-color:#66CC66;\"";if ($modsp->serverteam == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=serverteam value=0 style=\"border: 0px;background-color:#FF6666;\"";if ($modsp->serverteam == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";
	
	echo "<tr><td class=footerfichemods colspan=2><hr><input type=submit value=\"$strModifier\"></td></tr>";
	
	echo "</table>";
	echo "</td></tr></table>";
	
	/*** tableau valids ***/
	//echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
	echo "<table cellspacing=1 cellpadding=0 border=0>";
	echo "<tr><td class=modsfiche>$strTABmanaging</td></tr>";
	echo "<tr><td>";
	echo "<table cellspacing=0 cellpadding=2 border=0 width=100%>";
	echo "<tr><td class=partfiche colspan=2></td></tr>";
	
	/*** Auto valid def  ***/
	echo "<tr><td class=titlefichemods>$strAuto_valid_def : </td>";
	echo "<td class=textfichemods>";
	echo "<input type=radio name=auto_valid_team value=1 style=\"border: 0px;background-color:#66CC66;\"";if ($modsp->auto_valid_team == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=auto_valid_team value=0 style=\"border: 0px;background-color:#FF6666;\"";if ($modsp->auto_valid_team == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";
	
	/*** Manager peut valider team  ***/
	echo "<tr><td class=titlefichemods>$strManag_team : </td>";
	echo "<td class=textfichemods>";
	echo "<input type=radio name=m_team_valid value=1 style=\"border: 0px;background-color:#66CC66;\"";if ($modsp->m_team_valid == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=m_team_valid value=0 style=\"border: 0px;background-color:#FF6666;\"";if ($modsp->m_team_valid == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";
	
	/*** Nombre requi pour valider une equipe ***/
	echo "<tr><td class=titlefichemods>$strManag_team_num :</td>";
	echo "<td class=textfichemods><input type=text name=m_team_valid_num  value=\"$modsp->m_team_valid_num \" size=2>";
	echo "</td></tr>";

	
	echo "<tr><td class=footerfichemods colspan=2><hr><input type=submit value=\"$strModifier\"></td></tr>";
	
	echo "</table>";
	echo "</td></tr></table>";
	
	
	/*** tableau BBcode ***/
	//echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
	echo "<table cellspacing=1 cellpadding=0 border=0>";
	echo "<tr><td class=modsfiche>---</td></tr>";
	echo "<tr><td>";
	echo "<table cellspacing=0 cellpadding=2 border=0 width=100%>";
	echo "<tr><td class=partfiche colspan=2></td></tr>";
	
	/***bbcode ***/
	echo "<tr><td class=titlefichemods>$strbbcode : </td>";
	echo "<td class=textfichemods>";
	echo "<input type=radio name=bbcode value=1 style=\"border: 0px;background-color:#000044;\"";if ($modsp->bbcode == "1") echo " CHECKED";echo "> $strphpBB ";
	echo "<input type=radio name=bbcode value=0 style=\"border: 0px;background-color:#0000AA;\"";if ($modsp->bbcode == "0") echo " CHECKED";echo "> $streditor";
	echo "</td></tr>";
	
	echo "<tr><td class=footerfichemods colspan=2><hr><input type=submit value=\"$strModifier\"></td></tr>";

	
	echo "</table>";
	echo "</td></tr></table>";
	echo "</td></tr></table>";
	
	
	//end 
	//echo "</td></tr></table>";
	//echo "</td></tr></table>";
	echo "</form>";

	echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";
} 
else if ($op == "admin") {
	
	echo "<table border=0 cellpadding=0 width='70%' cellspacing=0 class=bordure1><tr><td>";
	echo "<table cellspacing=1 cellpadding=0 border=0>";
	echo "<tr><td class=modsfiche>&nbsp;&nbsp;&nbsp; $strMODSPANEL &nbsp;&nbsp;&nbsp;</td></tr>";
	echo "<tr><td>";
	echo "<table cellspacing=0 cellpadding=2 border=0 width=100%>";
	echo "<tr><td class=partfiche colspan=4></td></tr>";

	echo "<tr><td width='5%' class=textfichemods2>&nbsp;</td><td class=textfichemods2><li class=\"lib\"><a href=\"?page=page&op=listm\">$strModPage</a></td>";
	echo "<td class=textfichemods2><li class=\"lib\"><a href=\"?page=page&op=add\">$strAddPage</a></td>";
	echo "</td><td width='5%' class=textfichemods2>&nbsp;</td></tr>";
	
	echo "<tr><td width='5%' class=textfichemods2>&nbsp;</td><td class=textfichemods2><li class=\"lib\"><a href=\"?page=menu&op=add\">$strAddMenu</a></td>";
	echo "<td class=textfichemods2><li class=\"lib\"><a href=\"?page=mods&op=pcmods\">$strPCMODS</a></td>";
	echo "</td><td width='5%' class=textfichemods2>&nbsp;</td></tr>";
	
	echo "</table>";
	
	echo "<tr><td class=modsfiche>&nbsp;</td></tr>";
	
	echo "</td></tr></table>";
	echo "</td></tr></table>";
}


?>

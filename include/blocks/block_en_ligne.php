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

if (eregi("block_en_ligne.php", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}
//HTML EDITED
global $config,$s_joueur,$s_theme,$db,$dbprefix;
global $strQuiEnLigne,$strEnLigne,$strPublicEnLigne,$strVisiteurs,$strMembres,$strTotal,$strAdmins;
global $compteur, $strNoUserOnline;

theme_openblock_enligne();

	
	$sess_out = time() - 120;	
	//normalement la db est cleaner par member.class.php
    $db->select("distinct joueur");
	$db->from("${dbprefix}sessions");
	$db->where("date >= '$sess_out'");
	$res = $db->exec();
	

	
if($db->num_rows($res)!=0) {
	//echo '<hr>';

	echo "<div align='left'>";
	//echo '<table cellspacing="0" cellpadding=2 border=0 bgcolor="#7E99C9" align=left>';
	//echo '<tr><td class=textmenu valign=top>';
	echo "<img src=\"themes/$s_theme/images/icon_connect.gif\" align=\"absmiddle\" alt=\"\"> $strEnLigne : <br />";
	
	$membr="0";
	$virgule="wait";
	while($joueur = $db->fetch($res)) {
	$membr++;
	
	if ($virgule=="ok") {echo",&nbsp;";}
	else if ($virgule=="wait") {$virgule="ok";}
	
	echo show_enligne($joueur->joueur);
	if ($membr=="10") {
	echo '<br />';
	$membr="0";
	}
	
	}
	//echo '</td></tr>';
	//echo '</table>';
	echo "</div>";
	echo '<br />';
	
	
	echo "<img src=\"themes/$s_theme/images/icon_registered.gif\" align=\"absmiddle\" alt=\"\"> $strPublicEnLigne : ";
	echo "$strVisiteurs : ".$compteur['nb_anonyme']." | ";
	echo "$strMembres : ".$compteur['nb_enregistre']." | ";
	echo "$strAdmins : ".$compteur['nb_admin']." | ";
	echo "$strTotal : ".$compteur['nb_total']."&nbsp;";
	
	//echo "<hr>";
	
}
// mettre color qui convient...
if (!$membr){
theme_closeblock_enligne("$strNoUserOnline");	
}else{
theme_closeblock_enligne("<img src=\"themes/$s_theme/images/icon_enligne.gif\" align=\"absmiddle\" alt=\"enligne\"> $strQuiEnLigne");
}
?>

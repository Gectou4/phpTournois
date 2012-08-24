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

if (eregi("block_admin.php", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}
//HTML EDITED
global $strModPage,$strAddPage,$strAddMenu; 
global $config,$s_theme,$grade;
global $strAdmin,$strNews,$strPlanSalle,$strJoueurs,$strEquipes,$strTournois,$strLadder,$strJeux,$strMod,$strAc_cmdmenu,$strMaps,$strServeurs,$strSponsors,$strPartenaires,$strDownloads,$strLiens,$strLivreDor,$strConfiguration,$strMailing,$strM4Admin,$strABAdmin;

if($grade['o']=='o') {
	theme_openblock("<img src=\"themes/$s_theme/images/icon_admin.gif\" align=\"absmiddle\" alt=\"admin\"> $strAdmin");
	
	echo "<ul>";
	if($config['news']) echo "<li class=\"lib\"><a href=\"?page=news&amp;op=admin\">$strNews</a><br>";
	echo "<li class=\"lib\"><a href=\"?page=joueurs&amp;op=admin\">$strJoueurs</a><br>";
	echo "<li class=\"lib\"><a href=\"?page=equipes&amp;op=admin\">$strEquipes</a><br>";
	echo "<li class=\"lib\"><a href=\"?page=tournois&amp;op=admin\">$strTournois</a><br>";
	if($mods['plan']) echo "<li class=\"lib\"><a href=\"?page=plan&amp;op=admin\">$strPlanSalle</a><br>";
	echo "<li class=\"lib\"><a href=\"?page=jeux&amp;op=admin\">$strJeux</a><br>";
	echo "<li class=\"lib\"><a href=\"?page=maps&amp;op=admin\">$strMaps</a><br>";
	//echo "<li class=\"lib\"><a href=\"?page=page&amp;op=add\">$strAddPage</a><br>";
	//echo "<li class=\"lib\"><a href=\"?page=page&amp;op=listm\">$strModPage</a><br>";
	//echo "<li class=\"lib\"><a href=\"?page=menu&amp;op=add\">$strAddMenu</a><br>";
	if($config['serveur']) echo "<li class=\"lib\"><a href=\"?page=serveurs&amp;op=admin\">$strServeurs</a><br>";
	if($config['sponsors']) echo "<li class=\"lib\"><a href=\"?page=sponsors&amp;op=admin\">$strSponsors</a><br>";
	if($config['partenaires']) echo "<li class=\"lib\"><a href=\"?page=partenaires&amp;op=admin\">$strPartenaires</a><br>";
	if($config['download']) echo "<li class=\"lib\"><a href=\"?page=download&amp;op=admin\">$strDownloads</a><br>";
	if($config['liens']) echo "<li class=\"lib\"><a href=\"?page=liens&amp;op=admin\">$strLiens</a><br>";
	if($config['livredor']) echo "<li class=\"lib\"><a href=\"?page=livredor&amp;op=admin\">$strLivreDor</a><br>";
	echo "<li class=\"lir\"><a href=\"?page=configuration\">$strConfiguration</a><br>";
	echo "<li class=\"lir\"><a href=\"?page=mods&amp;op=admin\">$strMod</a><br>";
	echo "<li class=\"lib\"><a href=\"?page=faq&amp;op=admin\">FAQ</a><br>";
	echo "<li class=\"lib\"><a href=\"?page=mailing&amp;op=admin\">$strMailing</a><br>";
	
	
	if($config['m4url'] || $config['aburl']) echo "<hr width=\"95%\">";
	if($config['m4url']) echo "<li class=\"lib\"><a href=\"".$config['m4url']."\" target=\"_blank\">$strM4Admin</a><br>";
	if($config['aburl']) echo "<li class=\"lib\"><a href=\"".$config['aburl']."\" target=\"_blank\">$strABAdmin</a><br>";
	echo "<li class=\"lib\"><a href=\"?page=ac_spe&amp;op=admin\">$strAc_cmdmenu</a><br>";
	echo "<li class=\"lib\"><a href=\"?page=ladder&op=add_lad&ad=ad\">$strLadder</a><br>";
	echo "</ul>";
	theme_closeblock();	
}
?>

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

if (preg_match("/block_partenaires.php/i", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}

global $db,$dbprefix,$config,$s_joueur,$s_theme,$strPartenaires,$strSuite;

if($config['partenaires']) {
		
	$db->select("*");
	$db->from("${dbprefix}partenaires");
	$db->order_by("rang LIMIT 5");
	$partenaires=$db->exec();
	
	if($db->num_rows($partenaires) != 0) {
		
		theme_openblock("<img src=\"themes/$s_theme/images/icon_partenaires.gif\" align=\"absmiddle\" alt=\"partenaires\"> $strPartenaires");
		echo "<div align=\"center\">";
	
		while($partenaire = $db->fetch($partenaires)) {
			echo '<img src="images/story-7px.gif" width="7" height="3" alt=""><br />';
			echo "<a target=\"_blank\" href=\"$partenaire->url\"><img src=\"images/partenaires/$partenaire->image\" title=\"$partenaire->nom\" border=\"0\" alt=\"$partenaire->nom\"></a><br />";
			echo '<img src="images/story-7px.gif" width="7" height="3" alt=""><br />';
		}	
			
		echo "<a href=\"?page=partenaires\">$strSuite</a>";
		echo "</div>";
		
		theme_closeblock();
	}
}

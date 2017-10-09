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

if (preg_match("/block_admin_tournois.php/i", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}
//HTML EDITED
global $config,$s_joueur,$s_theme,$s_tournois,$nom_tournois,$status_tournois,$type_tournois,$db,$dbprefix;
global $strAdmin,$strInscriptions,$strCloturerInscriptions,$strInscriptions,$strPoules,$strValiderPoules,$strMatchsPoules,$strTerminerPoules,$strTerminerTournois,$strHoraires,$strMaps,$strServeurs,$strFinales,$strValiderFinales,$strMatchsFinales,$strMatchsActifs,$strMatchsEnCours,$strAdminTournois;
global $strCloturerLesInscriptions,$strValiderLesPoules,$strTerminerLesPoules,$strValiderLesFinales,$strTerminerLeTournois,$grade;

if(($grade['a']=='a' || $grade['b']=='b' || $grade['t']=='t' || admin_tournois($s_joueur,$s_tournois)) && $status_tournois != 'T' && $s_tournois) {
	
	theme_openblock("<img src=\"themes/$s_theme/images/icon_admintournois.gif\" align=\"absmiddle\" alt=\"admin\"> $strAdmin");
	echo '<a href="?page=tournois&amp;op=modify&amp;id='.$s_tournois.'">';
    echo show_tournois($s_tournois,1)."</a><br />";
	echo "<ul><li class=\"lib\"><a href=\"?page=inscriptions&amp;op=admin\">$strInscriptions</a><br />";

	if($status_tournois == "I") {
		echo "<br /><li class=\"lir\"><a href=\"javascript:cloturer_inscriptions('$strCloturerLesInscriptions')\">$strCloturerInscriptions</a><br />";
	}
	elseif($status_tournois == "G") {
		echo "<li class=\"lib\"><a href=\"?page=poules&amp;op=admin\">$strPoules</a><br />";
		echo "<br /><li class=\"lir\"><a href=\"javascript:valider_poules('$strValiderLesPoules')\">$strValiderPoules</a><br />";
	}
	elseif($status_tournois == "P") {
		echo "<li class=\"lib\"><a href=\"?page=matchs_poules&amp;op=admin\">$strMatchsPoules</a><br />";
		echo "<li class=\"lib\"><a href=\"?page=matchs_liste&amp;op=admin&amp;status=A\">$strMatchsActifs</a><br />";
		echo "<li class=\"lib\"><a href=\"?page=matchs_liste&amp;op=admin&amp;status=D\">$strMatchsEnCours</a><br />";

		if($type_tournois == 'T') echo "<br /><li class=\"lir\"><a href=\"javascript:terminer_poules('$strTerminerLesPoules')\">$strTerminerPoules</a><br />";
		else echo "<br /><li class=\"lir\"><a href=\"javascript:terminer_tournois('$strTerminerLeTournois')\">$strTerminerTournois</a><br />";

		echo "<br /><li class=\"lib\"><a href=\"?page=horaires_tournois\">$strHoraires</a><br />";
		echo "<li class=\"lib\"><a href=\"?page=maps_tournois\">$strMaps</a><br />";
		echo "<li class=\"lib\"><a href=\"?page=serveurs_tournois\">$strServeurs</a><br />";
	}
	elseif($status_tournois == "H") {
		echo "<li class=\"lib\"><a href=\"?page=finales&amp;op=admin\">$strFinales</a><br />";
		echo "<br /><li class=lir><a href=\"javascript:valider_finales('$strValiderLesFinales')\">$strValiderFinales</a><br />";
	}
	elseif($status_tournois == "F")  {
		echo "<li class=\"lib\"><a href=\"?page=matchs_finales&amp;op=admin&amp;x=0\">$strMatchsFinales</a><br />";
		echo "<li class=\"lib\"><a href=\"?page=matchs_liste&amp;op=admin&amp;status=A\">$strMatchsActifs</a><br />";
		echo "<li class=\"lib\"><a href=\"?page=matchs_liste&amp;op=admin&amp;status=D\">$strMatchsEnCours</a><br />";

		echo "<br /><li class=\"lir\"><a href=\"javascript:terminer_tournois('$strTerminerLeTournois')\">$strTerminerTournois</a><br />";

		echo "<br /><li class=\"lib\"><a href=\"?page=horaires_tournois\">$strHoraires</a><br />";
		echo "<li class=\"lib\"><a href=\"?page=maps_tournois\">$strMaps</a><br />";
		echo "<li class=\"lib\"><a href=\"?page=serveurs_tournois\">$strServeurs</a><br />";
	}
	echo "</ul>";
	theme_closeblock();
}

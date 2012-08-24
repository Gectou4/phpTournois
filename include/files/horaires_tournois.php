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

if (eregi("horaires_tournois.php", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}

/*** test de la session ***/
if(empty($s_tournois)) js_goto("?page=index");

/*** verification securite ***/
verif_admin_tournois($s_joueur,$s_tournois,$grade['a'],$grade['b'],$grade['t']);

/********************************************************
 * Enregistrement des Maps du tournois
 */
if ($op == "modify") {
	
	// si il y a des horaires selection&eacute;s
	if(count($_POST)!=0) {

 		foreach ($_POST as $key => $value) {
	
			preg_match("/^([A-Z])([0-9]+)$/", $key,$keylist);
			list(,$type,$tour) = $keylist;
	
			if(($type=='P' || $type=='L' || $type=='W')) {

				if($type=='W') {
					$finale=$tour;
					$numero="";
				}
				elseif($type=='L') {
					$finale=substr($tour, 0, -1);
					$numero=substr($tour, -1);
				}


				if(preg_match("/([0-9]{2}|[0-9]{4}).([0-9]{2}).([0-9]{2}|[0-9]{4})[^0-9]*([0-9]{2}):([0-9]{2})/i",$value,$datetmp)) {
					$timestamp=mktime($datetmp[4],$datetmp[5],0,$datetmp[MONTH_POS],$datetmp[DAY_POS],$datetmp[YEAR_POS]);

					// Check des mois/jours/ann&eacute;es pour la date saisie
					if(!checkdate($datetmp[MONTH_POS],$datetmp[DAY_POS],$datetmp[YEAR_POS]) && $datetmp[YEAR_POS]>=1970)
						$timestamp='';

				}
				elseif(preg_match("/([0-9]{2}):([0-9]{2})/i",$value,$datetmp)) {
					$timestamp=mktime($datetmp[1],$datetmp[2],0,date("m",time()),date("d",time()),date("Y",time()));
				}
				else
					$timestamp='';

				/*** mise a jour des horaires du tournois ***/
				/*** le record existe ? ***/
				$db->select("date");
				$db->from("${dbprefix}horaires_tournois");
				$db->where("tournois = $s_tournois");
				$db->where("type = '$type'");
				if($type=='P') $db->where("tour = $tour");
				else $db->where("finale = $finale$numero");
				$res=$db->exec();

				if($db->num_rows($res)==0) {
					$db->insert("${dbprefix}horaires_tournois (tournois,type,tour,finale,date)");
					if($type=='P') $db->values("$s_tournois,'$type',$tour,NULL,'$timestamp'");
					else $db->values("$s_tournois,'$type',NULL,$finale$numero,'$timestamp'");
					$db->exec();
				}
				else {
					$db->update("${dbprefix}horaires_tournois");
					$db->set("date = '$timestamp'");
					$db->where("tournois = $s_tournois");
					if($type=='P') $db->where("tour = $tour");
					else $db->where("finale = $finale$numero");
					$db->exec();
				}

				/*** mise a jour des horaires des matchs ***/
				$db->update("${dbprefix}matchs");
				$db->set("date = '$timestamp'");
				$db->where("tournois = $s_tournois");
				$db->where("type = '$type'");
				if($type=='P') $db->where("tour = $tour");
				elseif($type=='W') $db->where("finale = $finale");
				elseif($type=='L') {
					$db->where("finale = $finale");
					if($numero==2) $db->where("numero > $finale");
					else $db->where("numero <= $finale");
				}
				$db->where("(status = 'C' OR status = 'A')");
				$db->exec();
			}
		}
	}

	/*** redirection ***/
	js_goto("?page=horaires_tournois");

}
/********************************************************
 * Affichage admin
 */
else {

	echo "<p class=title>.:: $strAdminHoraires - $nom_tournois ::.</p>";

	echo "<form method=post action=?page=horaires_tournois&op=modify>";

	/*** Poules ***/
	if(($type_tournois=='T' || $type_tournois=='C') && $status_tournois=='P') {

		echo "<table border=0 cellpadding=0 cellspacing=0>";
		echo "<tr><td class=title align=center>$strPoules</td></tr>";
		echo "</table>";
		echo "<table cellspacing=1 cellpadding=2 border=0 class=bordure1>";
		echo "<tr><td class=headerliste>$strTour</td><td class=headerliste>$strDate</td></tr>";

		//calcul du nombre de tour
		$nb_tours_max=0;
		for($i=1;$i<=$nb_poules_tournois;$i++) {
			$nb_tours_poule = nb_tours($i, $s_tournois);
			if($nb_tours_poule>$nb_tours_max)
				$nb_tours_max=$nb_tours_poule;
		}

		for($i=1;$i<=$nb_tours_max;$i++) {

			echo "<tr><td class=textliste align=center><b>$i</b></td>";

			$db->select("*");
			$db->from("${dbprefix}horaires_tournois");
			$db->where("tournois = $s_tournois");
			$db->where("type = 'P'");
			$db->where("tour = $i");
			$res = $db->exec();
			$horaire = $db->fetch($res);

			$date=strftime(DATESTRING, $horaire->date);
			if(!$horaire->date) $date='';

			echo "<td class=textliste><input type=text name=P${i} value='$date' maxlength=20 size=20></td>";

			echo "</tr>";
		}
		echo "</table>";		
	}


	/*** finales W ***/
	if(($type_tournois=='T' || $type_tournois=='E') && $status_tournois=='F') {

		echo "<table><tr><td valign=top align=center >";

		echo "<table border=0 cellpadding=0 cellspacing=0 >";
		echo "<tr><td class=title align=center>$strFinales Winner</td></tr>";
		echo "</table>";
		echo "<table cellspacing=1 cellpadding=2 border=0 class=bordure1>";
		echo "<tr><td class=headerliste>$strFinales</td><td class=headerliste>$strDate</td></tr>";

		$finale=$nb_finales_winner_tournois;

		for($i=1;$i<=(log($nb_finales_winner_tournois)/log(2))+1;$i++) {

			if($finale>1)
				echo "<tr><td class=textliste align=center><b>1/$finale</b></td>";
			else
				echo "<tr><td class=textliste align=center><b>$strFinale</b></td>";


			$db->select("*");
			$db->from("${dbprefix}horaires_tournois");
			$db->where("tournois = $s_tournois");
			$db->where("type = 'W'");
			$db->where("finale = $finale");
			$res = $db->exec();
			$horaire = $db->fetch($res);

			$date=strftime(DATESTRING, $horaire->date);
			if(!$horaire->date) $date='';

			echo "<td class=textliste><input type=text name=W${finale} value='$date' maxlength=20 size=20></td>";

			echo "</tr>";

			$finale=floor($finale/2);
		}

		echo "</table>";
		echo "</td>";


		/*** finales L ***/
		if( $modeelimination_tournois=='D') {

			echo "<td valign=top align=center >";

			echo "<table border=0 cellpadding=0 cellspacing=0>";
			echo "<tr><td class=title align=center>$strFinales Looser</td></tr>";
			echo "</table>";
			echo "<table cellspacing=1 cellpadding=2 border=0 class=bordure1>";
			echo "<tr><td class=headerliste>$strFinales</td><td class=headerliste>$strDate</td></tr>";

			$finale=$nb_finales_looser_tournois/2;

			for($i=1;$i<=(log($nb_finales_looser_tournois/2)/log(2))+1;$i++) {

				if($finale>1)
					echo "<tr><td class=textliste align=center><b>1/$finale $strTour 1</b></td>";
				else
					echo "<tr><td class=textliste align=center><b>$strFinale $strTour 1</b></td>";

				$db->select("*");
				$db->from("${dbprefix}horaires_tournois");
				$db->where("tournois = $s_tournois");
				$db->where("type = 'L'");
				$db->where("finale = ".$finale."1");
				$res = $db->exec();
				$horaire = $db->fetch($res);

				$date=strftime(DATESTRING, $horaire->date);
				if(!$horaire->date) $date='';

				echo "<td class=textliste><input type=text name=L${finale}1 value='$date' maxlength=20 size=20></td>";

				echo "</tr>";

				if($finale>1)
					echo "<tr><td class=textliste align=center><b>1/$finale $strTour 2</b></td>";
				else
					echo "<tr><td class=textliste align=center><b>$strFinale $strTour 2</b></td>";

				$db->select("*");
				$db->from("${dbprefix}horaires_tournois");
				$db->where("tournois=$s_tournois");
				$db->where("type = 'L'");
				$db->where("finale = ".$finale."2");
				$res = $db->exec();
				$horaire = $db->fetch($res);

				$date=strftime(DATESTRING, $horaire->date);
				if(!$horaire->date) $date='';

				echo "<td class=textliste><input type=text name=L${finale}2 value='$date' maxlength=20 size=20></td>";

				echo "</tr>";

				$finale=floor($finale/2);
			}

			echo "</table>";
			echo "<td>";
			echo "</tr><tr>";
			echo "<td colspan=2 align=center valign=top><br>";

			/***  Grandfinal ***/
			echo "<table border=0 cellpadding=0 cellspacing=0 align=center>";
			echo "<tr><td class=title align=center>$strGrandFinal</td></tr>";
			echo "</table>";
			echo "<table cellspacing=1 cellpadding=2 border=0 class=bordure1>";
			echo "<tr><td class=headerliste>$strDate</td></tr>";

			$db->select("*");
			$db->from("${dbprefix}horaires_tournois");
			$db->where("tournois=$s_tournois");
			$db->where("type = 'W'");
			$db->where("finale = 0");
			$res = $db->exec();
			$horaire = $db->fetch($res);

			$date=strftime(DATESTRING, $horaire->date);
			if(!$horaire->date) $date='';

			echo "<td class=textliste><input type=text name=W0 value='$date' maxlength=20 size=20></td>";

			echo "</tr></table>";

			echo "</td>";
		}
		echo "</tr></table>";
	}

	echo "<table align=center>";
	echo "<tr><td align=center><input type=submit value=\"$strValider\"></td></tr>";
	echo "</table>";
	echo "</form>";
	
	show_consignes($strHorairesTournoisConsignes);

	echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";

}


?>

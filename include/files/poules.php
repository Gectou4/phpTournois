<?php
/*
   +---------------------------------------------------------------------+
   | phpTournois                                                         |
   | phpTournoisG4 ©2005 by Gectou4 <Gectou4 Gectou4@hotmail.com>        |
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
if (preg_match("/poules.php/i", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}

/*** test de la session ***/
if(empty($s_tournois)) js_goto("?page=index");

/********************************************************
 * MOD CUSTOM POULE POINTS
 */

	$db->select("poulewin, poulenull, pouleloose");
	$db->from("${dbprefix}config");
	$res = $db->exec();
	
		while ($poulepts = $db->fetch($res)) {
		$cust_ptsw=$poulepts->poulewin;
		$cust_ptsl=$poulepts->pouleloose;
		$cust_ptsn=$poulepts->poulenull;
		$cust_ptslfor=$poulepts->poulefor;
		}
	
/********************************************************
 * END MOD CUSTOM POULE POINTS
 */
	
	
/********************************************************
 * Ajouter un equipe a une poule
 */
if ($op == "add") {

	/*** verification securite ***/
	verif_admin_tournois($s_joueur,$s_tournois,$grade['a'],$grade['b'],$grade['t']);
	
	$db->update("${dbprefix}participe");
	$db->set("poule = $poule");
	$db->where("equipe = $idequipeX");
	$db->where("tournois = $s_tournois");
	$db->exec();
	
	/*** redirection ***/
	js_goto("?page=poules&op=admin");
}


/******************************************************** 
 * Retirer un equipe d'une poule
 */
if ($op == "delete") {
	
	/*** verification securite ***/
	verif_admin_tournois($s_joueur,$s_tournois,$grade['a'],$grade['b'],$grade['t']);
	
	$db->update("${dbprefix}participe");
	$db->set("poule = null");
	$db->where("equipe = $idequipeX");
	$db->where("tournois = $s_tournois");
	$db->exec();
	
	/*** redirection ***/
	js_goto("?page=poules&op=admin");
}


/******************************************************** 
 * Affecter les equipes au hasard
 */
elseif ($op == "random") {
	
	/*** verification securite ***/
	verif_admin_tournois($s_joueur,$s_tournois,$grade['a'],$grade['b'],$grade['t']);
	
	$poule = 1;
	
	$db->select("equipe");
	$db->from("${dbprefix}participe");
	$db->where("status = 'P'");
	$db->where("poule is null");
	$db->where("tournois = $s_tournois");
	$db->order_by("rand()");
	$res = $db->exec();
	
	while ($equipe = $db->fetch($res)) {
		$db->update("${dbprefix}participe");
		$db->set("poule = $poule");
		$db->where("equipe = $equipe->equipe");
		$db->where("tournois = $s_tournois");
		$db->exec();
		
		if ($poule == $nb_poules_tournois)
			$poule = 1;
		else
			$poule++;
	}
	
	/*** redirection ***/
	js_goto("?page=poules&op=admin");
}

/******************************************************** 
 * Affecter les equipes avec le seed
 */
elseif ($op == "seed") {
	
	/*** verification securite ***/
	verif_admin_tournois($s_joueur,$s_tournois,$grade['a'],$grade['b'],$grade['t']);
	

	$poule = 0;
	$sens='+';
	
	$db->select("equipe, IFNULL(seed,10000) as seed");
	$db->from("${dbprefix}participe");
	$db->where("status = 'P'");
	$db->where("poule is null");
	$db->where("tournois = $s_tournois");
	$db->order_by("seed,rand()");
	$res = $db->exec();
	
	while ($equipe = $db->fetch($res)) {
		if ($sens=='+') $poule++;
		if ($sens=='-') $poule--;

		$db->update("${dbprefix}participe");
		$db->set("poule = $poule");
		$db->where("equipe = $equipe->equipe");
		$db->where("tournois = $s_tournois");
		$db->exec();
		
		if ($poule == 1 && $sens=='-') {
			$sens='+';
			$poule-=1;
		}
		if ($poule == $nb_poules_tournois && $sens=='+') {
			$sens='-';
			$poule+=1;
		}
	}
	
	/*** redirection ***/
	js_goto("?page=poules&op=admin");
}


/******************************************************** 
 * Remettre les poules a zero
 */
elseif ($op == "reset") {
	
	/*** verification securite ***/
	verif_admin_tournois($s_joueur,$s_tournois,$grade['a'],$grade['b'],$grade['t']);
	
	$db->update("${dbprefix}participe");
	$db->set("poule = null");
	$db->where("tournois = $s_tournois");
	$db->exec();
	
	/*** redirection ***/
	js_goto("?page=poules&op=admin");
}


/******************************************************** 
 * Affichage admin
 */
elseif ($op == "admin") {

	/*** verification securite ***/
	verif_admin_tournois($s_joueur,$s_tournois,$grade['a'],$grade['b'],$grade['t']);
	
	$str='';
	$erreur=0;

	if(!$nb_poules_tournois) {
		$erreur=1;
		$str.="- ".$strElementsPoulesInvalides."<br>";		
	}

	if($erreur==1) {		
		$str.="<br><form method=post action='?page=tournois&op=modify&id=$s_tournois'><input type=submit class=action value=\"$strModifier\"></form>";
		show_erreur_saisie($str);			
	}
	else {
	
		echo "<p class=title>.:: $strAdminPoules ::.</p>";
	
		echo "<table cellspacing=1 cellpadding=2 border=0><tr>";
		echo "<td><form method=post action='?page=poules&op=random'><input type=submit class=action value=\"$strAssignerAleatoirement\"></td></form>";
		echo "<td><form method=post action='?page=poules&op=seed'><input type=submit class=action value=\"$strAssignerInscriptionSeed\"></td></form>";
		echo "<td><form method=post action='?page=poules&op=reset'><input type=submit class=action value=\"$strRemettreAZero\"></td></form>";
		echo "</tr></table>";
	
		echo "<table class=liste>";
		$i=0;
	
		for ($p = 1; $p <= $nb_poules_tournois ; $p++) {
			if($i%$config['col_poules']==0) echo "<tr valign=top>";

			echo "<td >";
			echo "<table cellspacing=0 cellpadding=0 border=0 align=center>";
			echo "<tr><td class=title align=center><a name=\"$p\">$strPoule $p</a></td></tr>";
			echo "</table>";	
			echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1>";
			echo "<tr><td>";
			echo "<table cellspacing=1 cellpadding=2 border=0>";
			echo "<tr><td class=headerliste width=120+>".${"str$EquipesX"}."</td></tr>";
	
			$db->select("id, IFNULL(seed,10000) as seed");
			$db->from("${dbprefix}$equipesX, ${dbprefix}participe");
			$db->where("${dbprefix}$equipesX.id = ${dbprefix}participe.equipe");
			$db->where("poule = $p");
			$db->where("status = 'P'");
			$db->where("tournois = $s_tournois");
			$db->order_by("seed, $champX");
			$res=$db->exec();
		
			while ($participant = $db->fetch($res)) {
				echo "<tr><td class=textliste>";
				echo "<div style=\"clear: both\"><div style=\"float: left\">".$show($participant->id ,$op,'',$participant->seed)."</div>";
				echo "<div style=\"float: right\">&nbsp;<a href=?page=poules&op=delete&idequipeX=".$participant->id.">[$strS]</a></div>";
				echo "</div></td></tr>";
			}
			
			$db->select("id, $champX, IFNULL(seed,10000) as seed");
			$db->from("${dbprefix}$equipesX, ${dbprefix}participe");
			$db->where("${dbprefix}$equipesX.id = ${dbprefix}participe.equipe");
			$db->where("poule IS null");
			$db->where("status = 'P'");
			$db->where("tournois = $s_tournois");
			$db->order_by("seed,$champX");
			$lists=$db->exec();
			
			if ($db->num_rows($lists) != 0) {
				echo "<form method=post>";
				echo "<tr><td class=textliste>";
				echo "<input type=hidden name=op value=add>";
				echo "<input type=hidden name=poule value=$p>";
				echo "<select name=idequipeX>";
	
				while ($participant = $db->fetch($lists)) {
					echo "<option value=".$participant->id.">".$participant->$champX;
					if($participant->seed && $participant->seed!=10000) echo "&nbsp;(#".$participant->seed.")";
				}
				echo "</select>";
				echo "<input type=submit value=$strAjouter>";
				echo "</td></tr>";
				echo "</form>";
			}
			echo "</table>";
			echo "</td></tr></table>";
			echo "</td>";

			if($i%$config['col_poules'] == $config['col_poules']-1) echo "</tr>";

			$i++;

		}
		echo "</table>";
	
		echo "<table cellspacing=1 cellpadding=2 border=0><tr>";
		echo "<td><form><input type=button value=\"$strValiderPoules\" onclick=\"javascript:valider_poules('$strValiderLesPoules')\"></form></td>";
		echo "</tr></table>";
	}
}


/********************************************************
 * Affichage normal
 */
else { 
	
	echo "<p class=title>.:: $strResultatsPoules ::.</p>";

	echo "<table cellspacing=0 cellpadding=2 border=0><tr>";
	echo "<tr>";	
	echo "<td class=\"text\" align=\"center\">$strPoules :</td>";
		
	for($i = 1; $i <= $nb_poules_tournois; $i++) {
		echo "<td class=text align=center><a href=?page=poules&x=$i>$i</a> - </td>";
	}
	echo "<td class=header align=center><small><a href=?page=poules>$strToutes</small></a>";
	echo "</tr></table><br>";

	echo "<table class=liste>";
	$i=0;

	for ($p = 1; $p <= $nb_poules_tournois ; $p++) {

		if($x) {
			if($x!=$p) continue;
			$p=$x;
			$config['col_poules']=1;
		}

		if($i%$config['col_poules']==0) echo "<tr valign=top>";

		echo "<td>";

		// contruction du tableau de poules non trié
		$db->select("id, $champX, status, IFNULL(seed,10000) as seed");
		$db->from("${dbprefix}$equipesX, ${dbprefix}participe");
		$db->where("${dbprefix}$equipesX.id = ${dbprefix}participe.equipe");
		$db->where("poule = $p");
		$db->where("status = 'P'");	
		$db->where("tournois = $s_tournois");
  		$db->order_by("seed,$champX");
		$res1 = $db->exec();

		$j=0;
		$tab_poule=array();

		while($participant = $db->fetch($res1)) {

			$db->select("id");
			$db->from("${dbprefix}matchs");
			$db->where("${dbprefix}matchs.status = 'T'");
			$db->where("poule = $p");
			$db->where("tournois = $s_tournois");
			$db->where("(equipe1 = $participant->id OR equipe2 = $participant->id)");
			$matchsid=$db->exec();

			$nb_joues = $nb_gagnes = $nb_nuls = $nb_perdus = $avg = $nb_pts = 0;

			while($matchid = $db->fetch($matchsid)) {
				$nb_joues++;

				$moi = $adv = $score_moi = $score_adv = $frags_moi = $frags_adv = 0;
				
				$match=match($matchid->id);

				if($match->statusequipe=="F1" || $match->statusequipe=="D1") $perdant=1;
				elseif($match->statusequipe=="F2" || $match->statusequipe=="D2") $perdant=2;
				else $perdant = 0;

				if($match->equipe1 == $participant->id) {
					$avg += $match->frags1;
					$avg -= $match->frags2;

					$moi=1;
					$adv=2;
					$score_moi=$match->score1;
					$score_adv=$match->score2;
					$frags_moi=$match->frags1;
					$frags_adv=$match->frags2;
				}
				elseif($match->equipe2 == $participant->id) {
					$avg += $match->frags2;
					$avg -= $match->frags1;

					$moi=2;
					$adv=1;
					$score_moi=$match->score2;
					$score_adv=$match->score1;
					$frags_moi=$match->frags2;
					$frags_adv=$match->frags1;
				}

				if($score_moi > $score_adv) {
					if($perdant==$moi){
						$nb_perdus++;
						$nb_pts+=$cust_ptsfor;}
					else {
						$nb_gagnes++;
						$nb_pts+=$cust_ptsw;
					}
				}
				elseif($score_moi < $score_adv) {
					if($perdant==$adv) {
						$nb_gagnes++;
						$nb_pts+=$cust_ptsw;
					}
					else
						$nb_perdus++;
						$nb_pts+=$cust_ptsl;
				}
				else {
					if($perdant==$moi){
						$nb_perdus++;
						$nb_pts+=$cust_ptsfor;}
					elseif($perdant==$adv) {
						$nb_gagnes++;
						$nb_pts+=$cust_ptsw;
					}
					else {
						if($match->modematchscore=='RF' && $frags_moi > $frags_adv) {
							$nb_gagnes++;
							$nb_pts+=$cust_ptsw;
						}
						elseif($match->modematchscore=='RF' && $frags_moi < $frags_adv) {
							$nb_perdus++;
							$nb_pts+=$cust_ptsl;
						}
						else {
							$nb_nuls++;
							$nb_pts+=$cust_ptsn;
						}
					}
				}
			}

			// affectation de ces valeurs dans un tableau avant triage
			$tab_poule['id'][$j]=$participant->id;
			$tab_poule['equipe'][$j]=$participant->$champX;
			$tab_poule['nb_pts'][$j]=$nb_pts;
			$tab_poule['nb_joues'][$j]=$nb_joues;
			$tab_poule['nb_gagnes'][$j]=$nb_gagnes;
			$tab_poule['nb_nuls'][$j]=$nb_nuls;
			$tab_poule['nb_perdus'][$j]=$nb_perdus;
			$tab_poule['avg'][$j]=$avg;
			$tab_poule['status'][$j]=$participant->status;
			$tab_poule['seed'][$j]=$participant->seed;
			$j++;
  		}
		
		//trie du tableau de la poule
		@array_multisort($tab_poule['nb_pts'], SORT_NUMERIC, SORT_DESC,$tab_poule['avg'], SORT_NUMERIC, SORT_DESC,$tab_poule['nb_joues'],$tab_poule['nb_gagnes'],$tab_poule['nb_nuls'],$tab_poule['nb_perdus'],$tab_poule['seed'],SORT_NUMERIC, SORT_ASC,$tab_poule['equipe'],$tab_poule['id'],$tab_poule['status']);

		//affichage de la poule
		echo "<a name=\"$p\"></a>";
		echo "<table border=0 cellpadding=0 cellspacing=0 align=center>";
		echo "<tr><td class=title>$strPoule $p [<a class=action href=\"?page=matchs_poules&status=T&x=$p$op\">$strMatchs</a>]</td></tr>";
		echo "</table>";
		
		if(count($tab_poule)>0) {
			echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
			echo "<table cellspacing=1 cellpadding=2 border=0>";
			echo "<tr>";
			echo "<td class=headerliste>#</td>";
			echo "<td width=120 class=headerliste>".${'str'.$EquipeX}."</td>";
			echo "<td class=headerliste>$strPts</td>";
			echo "<td class=headerliste>$strJ</td>";
			echo "<td class=headerliste>$strG</td>";
			echo "<td class=headerliste>$strN</td>";
			echo "<td class=headerliste>$strP</td>";
			echo "<td class=headerliste>$strAvg</td>";
			echo "</tr>";
	
			for($k=0;$k<count($tab_poule['id']);$k++) {
				echo "<tr>";
				echo "<td class=textliste align=center>";
				if($k+1 == 1) echo "<img src=images/p1.gif height=12>";
				elseif($k+1 == 2) echo "<img src=images/p2.gif height=12>";
				elseif($k+1 == 3) echo "<img src=images/p3.gif height=12>";
				else echo $k+1;
				echo "</td>";
				echo "<td class=textliste align=left width=120>";
				if ($tab_poule['status'][$k] == "D") echo $show($tab_poule['id'][$k],$op,'D',$tab_poule['seed'][$k]);
				elseif ($tab_poule['status'][$k] == "F") echo $show($tab_poule['id'][$k],$op,'F',$tab_poule['seed'][$k]);
				else echo $show($tab_poule['id'][$k],$op,'',$tab_poule['seed'][$k]);
				echo "</td>";
	
				echo "<td class=textliste align=center>".$tab_poule['nb_pts'][$k]."</td>";
				echo "<td class=textliste align=center>".$tab_poule['nb_joues'][$k]."</td>";
				echo "<td class=textliste align=center>".$tab_poule['nb_gagnes'][$k]."</td>";
				echo "<td class=textliste align=center>".$tab_poule['nb_nuls'][$k]."</td>";
				echo "<td class=textliste align=center>".$tab_poule['nb_perdus'][$k]."</td>";
				if ($tab_poule['avg'][$k] > 0)
					echo "<td class=text align=center>+".$tab_poule['avg'][$k]."</td>";
				else
					echo "<td class=text align=center>".$tab_poule['avg'][$k]."</td>";
				echo "</tr>";
			}
			echo "</table>";
			echo "</td></tr></table>";
		}
		else {
			echo '<table cellspacing="0" cellpadding="0" border="0">';
   			echo '<tr><td><img src="images/spacer.gif" height="2" alt=""></td></tr>';
			echo '<tr><td class="info" align="center" width="200">'.$strPasDeTableau.'</td></tr>';
			echo '</table>';			
		}
						
		echo "</td>";

		if($i%$config['col_poules'] == $config['col_poules']-1) echo "</tr>";

		$i++;

	}
	echo "</table>";

	echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";
	
	
}

?>

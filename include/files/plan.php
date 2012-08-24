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
   | Authors: W3G wywiwygok@free.fr                               		 |
   | Version: 1.0														 |
   +---------------------------------------------------------------------+
*/

$fichier_plan = "include/html/plan/PlanNantarena_5.1.htm"; // Nom du fichier de plan de salles

/*** verification s&eacute;curite ***/
if (eregi("plan.php", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}

if ($op == "do_reserve"){
	if($grade['z']!='z') js_goto("?page=index");
	if(!$id_equipe){
		show_erreur_saisie($strEquipeNonDefini);
	}
	else{/* verifier si l'&eacute;quipe n'a pas reserv&eacute; un autre emplacement */
		$db->select("status");
		$db->from("${dbprefix}plan");
		$db->where("status = '$id_equipe'");
		$res = $db->exec();
		$resultat = $db->fetch($res);
	
		if (!$resultat){	
			$db->update("${dbprefix}plan");	
			$db->set("status = '$id_equipe'");
			$db->where("place = '$place'");
			$db->exec();

			js_goto("?page=plan");	
		}
		else{
	 		show_erreur_saisie($strEquipePresente);
		}
	}	
}
elseif ( $op == "reserve"){
	
	/*** verification s&eacute;curite ***/
	if($grade['z']!='z') js_goto("?page=index");
		
	/* si c l'admin, doit choisir l'equipe dans un menu d&eacute;roulant */
	if ($grade['a']=='a'||$grade['b']=='b'||$grade['k']=='k' or joueur_inscrit($s_joueur)){
	echo "<p class=title>.:: ".$strChoixEmplacement." ::.</p>";

	echo "<form method=post action=?page=plan&op=do_reserve>";

	/*** table d'affichage des &eacute;quipes ***/
	echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
	echo "<table cellspacing=1 cellpadding=0 border=0 class=fiche>";
	echo "<tr><td>";
	echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";

	/*** &eacute;quipes ***/
	echo "<tr><td class=titlefiche width=33%>$strTag <font color=red></font> :</td>";
	echo "<td class=textfiche>";		
	echo "<input type=hidden name=place value=$place>";
	echo "<select name=id_equipe value=''>";
	
	/* Affiche toutes les &eacute;quipes  */
	if ($grade['a']=='a'||$grade['b']=='b'||$grade['k']=='k'){
		$db->select("id, tag");
		$db->from("${dbprefix}equipes");
		$db->where("etat <> 'C'");
		$db->order_by("tag");
		$res=$db->exec();

		while ($equipe = $db->fetch($res)) {
			echo "<option value=$equipe->id>$equipe->tag";
		}
	}
	else{
		$mesequipes=equipes_manager($s_joueur);
		if (count($mesequipes)){
			for($i=0;$i<count($mesequipes);$i++) {
				echo "<option value=".$mesequipes[$i]['id'].">".stripslashes($mesequipes[$i]['tag']);
			}
		}
		else {
			$equipes=equipes_joueur($s_joueur);
			if(count($equipes)){
				show_erreur_saisie($strJoueurNonManager);
			}
			else{
				/* doit rejoindre une &eacute;quipe */
				js_goto("?page=equipes&op=rejoindre");	
			}
		}
	}
	
	echo "</select></td></tr>";
	
	echo "<tr><td class=footerfiche align=center colspan=2><input type=submit value=\"$strValider\"></td></tr>";
	echo "</table>";

	echo "</td></tr></table>";
	echo "</td></tr></table>";
	echo "</form>";

	show_consignes($strSelectionEquipeConsignes);

	echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";
	}
	/* si c un joueur, v&eacute;rifier qu'il appartient à une &eacute;quipe */
	else{
			js_goto("?page=equipe&op=rejoindre");
	}
}
elseif( $op == "libere"){

	/* pour l'instant, seul l'administrateur master/normal/de salle peut lib&eacute;rer une place */
	if ($grade['a']=='a'||$grade['b']=='b'||$grade['k']=='k') {
		$db->update("${dbprefix}plan");
		$db->set("status = '0'");
		$db->where("place = '$place'");
		$db->exec();
	}
	js_goto("?page=plan");
}
else{
	
	if ($op=='admin'&& ($grade['a']!='a'&&$grade['b']!='b'&&$grade['k']!='k')) {js_goto('?page=news');} 
	/* Titre de la page */
	if (($grade['a']=='a'||$grade['b']=='b'||$grade['k']=='k')&&($op=='admin')) echo "<p class=title>.:: ".$strAdministrationReservation." ::.</p>";
	else echo "<p class=title>.:: ".$strPlanSalle." ::.</p>";

	/* Affiche le plan des &eacute;quipes */
	$fp = fopen($fichier_plan,"r");
	$data = fread($fp,50000);
	
	$db->select("status, place");
	$db->from("${dbprefix}plan");
	$res = $db->exec();
	
	while ($reserve = $db->fetch($res))
	{
		switch($reserve->status){
			case "0": /* Emplacement libre */ 
					if ($grade['a']=='a'||$grade['b']=='b'||$grade['k']=='k') {
						$etat = "<a href=?page=plan&op=reserve&place=".($reserve->place).">&nbsp;Libre&nbsp;</a>";
					}
					else if ($grade['z']=='z') {
						$etat = "<a href=?page=plan&op=reserve&place=".($reserve->place).">&nbsp;Libre&nbsp;</a>";
					}
					else{
						$etat = "<font color=black>&nbsp;Libre&nbsp;</font>";
					}
					break;
			case "-1": /* Emplacement non disponible */
					$etat = "<font color=black></font>";
					break;
			default: if (($grade['a']=='a'||$grade['b']=='b'||$grade['k']=='k')&&$op=='admin'){
   						$etat = "<a href=?page=plan&op=libere&place=".($reserve->place).">&nbsp;".tag_equipe($reserve->status)."&nbsp;</a>";
					}
					else if ($grade['z']=='z') {
						$etat = "<a href=?page=equipes&id=".($reserve->status).">&nbsp;".tag_equipe($reserve->status)."&nbsp;</a>";
					}
					else{
						$etat = "<font color=red>&nbsp;".tag_equipe($reserve->status)."&nbsp;</font>";
					}
		}
		
		$data = str_replace("{".($reserve->place)."}",$etat,$data);
	}
	
	/*  Affiche la page avec les modifications  */
	echo $data;		
}

?>


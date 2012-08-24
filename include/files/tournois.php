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
if (eregi("tournois.php", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}
global $garde;
/********************************************************
 * Ajouter un tournois
 */
if ($op == "add") {

	/*** verification securite ***/
	if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['t']!='t') {js_goto($PHP_SELF);} 
	
	$str='';
	$erreur=0;
	
	if(!$nom) {
		$erreur=1;
		$str.="- $strElementsNomInvalide<br>";		
	}
	if(!is_numeric($nbplaces) || $nbplaces <=0 ) {
		$erreur=1;
		$str.="- $strErreurNbPlaces<br>";		
	}	

	if($erreur==1) {		
		show_erreur_saisie($str);			
	}
	else {
		
		$nom=remove_XSS($nom);

		$db->insert("${dbprefix}tournois (nom,type,jeux,poules,winner,looser,elimination,modeequipe,modescore,modematchscore,modeinscription,status,places)");
		$db->values("'$nom','$type',$jeux,0,0,0,'S','$modeequipe','A','$modematchscore','A','I',$nbplaces");
		$db->exec();
		$id=$db->insert_id();
	
		/*** redirection ***/
		js_goto("?page=tournois&op=modify&id=$id");
	}
}

/******************************************************** 
 * Modification d'un tournois
 */
elseif($op == "do_modify") {
	
	/*** verification securite ***/
	verif_admin_tournois($s_joueur,$s_tournois,$grade['a'],$grade['b'],$grade['t']);

	if(is_numeric($id)) {

		if($stats=='http://') $stats='';
		
		$db->update("${dbprefix}tournois");
		$db->set("modescore = '$modescore'");
		$db->set("modeinscription = '$modeinscription'");
		$db->set("modefichier = '$modefichier'");
		$db->set("modecommentaire = '$modecommentaire'");
		$db->set("manchesmax = '$manchesmax'");
		$db->set("places = '$places'");
		$db->set("information = '$information'");
		$db->set("dotation = '$dotation'");
		$db->set("reglement = '$reglement'");
		$db->set("stats = '$stats'");
		$db->set("jeux = $jeux");
		$db->where("id = $id");
		$db->exec();
	}

	/*** redirection ***/
	js_goto("?page=tournois&op=modify&id=$id");
}

/********************************************************
 * Supprimmer un tournois
 */
elseif ($op == "delete") {

	/*** verification securite ***/
	if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['t']!='t') {js_goto($PHP_SELF);} 
	
	if(modescore_tournois($id)=='M4') {
		$dbm4 = new database;
		$dbm4->debug($m4dbdebug);
		$dbm4->connect($m4dbhost,$m4dbuser,$m4dbpass,$m4dbname);
	}
	
	if(modescore_tournois($id)=='AB') {
		$dbab = new database;
		$dbab->debug($abdbdebug);
		$dbab->connect($abdbhost,$abdbuser,$abdbpass,$abdbname);
	}

	if(is_numeric($id)) {

		/*** select de tous les matchs ***/
		$db->select("id");
		$db->from("${dbprefix}matchs");
		$db->where("tournois = $id");
		$res=$db->exec();

		while($match = $db->fetch($res)) {

			/*** select de toute les manches ***/
			$db->select("id");
			$db->from("${dbprefix}manches");
			$db->where("matchi = $match->id");
			$res2=$db->exec();

			while($manche = $db->fetch($res2)) {

				// suppression de la manche dans m4
				if(modescore_tournois($id)=='M4') {
					$dbm4->delete("m4_match");
					$dbm4->where("numero = $manche->id");
					$dbm4->exec();
				}

				// suppression de la manche dans AB
				if(modescore_tournois($id)=='AB') {
					$dbm4->delete("adb_match_tbl");
					$dbm4->where("match_id = $manche->id");
					$dbm4->exec();
				}

				// suppression de la manche dans phptournois
				$db->delete("${dbprefix}manches");
				$db->where("id = $manche->id");
				$db->exec();
			}

		}

		$db->delete("${dbprefix}participe");
		$db->where("tournois = $id");
		$db->exec();

		$db->delete("${dbprefix}administre");
		$db->where("tournois = $id");
		$db->exec();

		$db->delete("${dbprefix}matchs");
		$db->where("tournois = $id");
		$db->exec();

		$db->delete("${dbprefix}maps_tournois");
		$db->where("tournois = $id");
		$db->exec();

		$db->delete("${dbprefix}serveurs_tournois");
		$db->where("tournois = $id");
		$db->exec();

		$db->delete("${dbprefix}tournois");
		$db->where("id = $id");
		$db->exec();

		if ($id == $s_tournois) {
			session_unregister("s_tournois");
			unset($s_tournois);
		}
	}

	/*** redirection ***/
	js_goto("?page=tournois&op=admin");

}
/********************************************************
 * Changer le nombre de poules d'un tournois
 */
elseif ($op == "poules") {

	/*** verification securite ***/
	if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['t']!='t') {js_goto($PHP_SELF);} 

	if(is_numeric($id)) {

		/*** mise a jour des poules ***/
		$db->update("${dbprefix}tournois");
		$db->set("poules = '$value'");
		$db->where("id = $id");
		$db->exec();

		/*** effacement des matchs de poules ***/
		$db->select("id");
		$db->from("${dbprefix}matchs");
		$db->where("type = 'P'");
		$db->where("tournois = $id");
		$res=$db->exec();

		while($match = $db->fetch($res)) {
			$db->delete("${dbprefix}manches");
			$db->where("matchi = $match->id");
			$db->exec();
		}

		$db->delete("${dbprefix}matchs");
		$db->where("tournois = $id");
		$db->where("type = 'P'");
		$db->exec();

		/*** effacement des poules ***/
		$db->update("${dbprefix}participe");
		$db->set("poule = null");
		$db->where("tournois = $id");
		$db->exec();
	}

	/*** redirection ***/
	js_goto("?page=tournois&op=modify&id=$id");
}


/********************************************************
 * Changer le nombre de finales winner d'un tournois
 */
elseif ($op == "winner") {

	/*** verification securite ***/
	if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['t']!='t') {js_goto($PHP_SELF);} 

	if(is_numeric($id)) {

		/*** mise a jour du winner ***/
		$db->update("${dbprefix}tournois");
		$db->set("winner = '$value'");
		$db->where("id = $id");
		$db->exec();
		

		/*** effacement des match de la phase finale winner ***/
		$db->select("id");
		$db->from("${dbprefix}matchs");
		$db->where("type = 'W' and finale != 0");
		$db->where("tournois = $id");
		$res=$db->exec();

		while($match = $db->fetch($res)) {
			$db->delete("${dbprefix}manches");
			$db->where("matchi = $match->id");
			$db->exec();
		}

		$db->delete("${dbprefix}matchs");
		$db->where("tournois = $id");
		$db->where("type = 'W' and finale!=0");
		$db->exec();
	}

	/*** redirection ***/
	js_goto("?page=tournois&op=modify&id=$id");

}
/********************************************************
 * Changer le nombre de finales looser d'un tournois
 */
elseif ($op == "looser") {

	/*** verification securite ***/
	if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['t']!='t') {js_goto($PHP_SELF);} 

	if(is_numeric($id)) {

		/*** mise a jour du looser ***/
		$db->update("${dbprefix}tournois");
		$db->set("looser = '$value'");
		$db->where("id = $id");
		$db->exec();

		/*** effacement des match de la phase finale looser ***/
		$db->select("id");
		$db->from("${dbprefix}matchs");
		$db->where("(type = 'L' or (type = 'W' and finale=0))");
		$db->where("tournois = $id");
		$db->exec();

		while($match = $db->fetch()) {
			$db->delete("${dbprefix}manches");
			$db->where("matchi = $match->id");
			$db->exec();
		}

		$db->delete("${dbprefix}matchs");
		$db->where("(type = 'L'  or (type = 'W' and finale=0))");
		$db->where("tournois = $id");
		$db->exec();
	}

	/*** redirection ***/
	js_goto("?page=tournois&op=modify&id=$id");

}
/********************************************************
 * Changer le type de l'arbre des finales d'un tournois
 */
elseif ($op == "elimination") {

	/*** verification securite ***/
	if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['t']!='t') {js_goto($PHP_SELF);} 

	if(is_numeric($id)) {

		$db->update("${dbprefix}tournois");
		$db->set("elimination = '$value'");
		$db->where("id = $id");
		$db->exec();
	}

	/*** redirection ***/
	js_goto("?page=tournois&op=modify&id=$id");
	
}
/********************************************************
 * Changer le status d'un tournois
 */
elseif ($op == "status") {

	/*** verification securite ***/
	if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['t']!='t') {js_goto($PHP_SELF);} 

	if(is_numeric($id)) {
		$db->update("${dbprefix}tournois");
		$db->set("status = '$value'");
		$db->where("id = $id");
		$db->exec();
	}

	/*** redirection ***/
	js_goto("?page=tournois&op=admin");
}


/********************************************************
 * Cloturer les inscriptions du tournois en cours
 */
elseif ($op == "cloturer_inscriptions") {

	/*** test de la session ***/
	if(empty($s_tournois)) js_goto("?page=index");

	/*** verification securite ***/
	verif_admin_tournois($s_joueur,$s_tournois,$grade['a'],$grade['b'],$grade['t']);

	/*** verification du nombre d'equipes inscrites ***/
	if(nb_inscrits_tournois($s_tournois)==0 || nb_inscrits_tournois($s_tournois) > nb_places_tournois($s_tournois)) {
		js_goto("?page=inscriptions&op=admin");
	}

	/*** changement du status du tournois ***/
	if($type_tournois == 'E') $new_status='H';
	else $new_status='G';

	$db->update("${dbprefix}tournois");
	$db->set("status = '$new_status'");
	$db->where("id = $s_tournois");
	$db->exec();

	/*** inscription des teams dans m4 ***/
	if($modescore_tournois=='M4') {
		$dbm4 = new database;
		$dbm4->debug($m4dbdebug);
		$dbm4->connect($m4dbhost,$m4dbuser,$m4dbpass,$m4dbname);
		
		$db->select("id, tag");
		$db->from("${dbprefix}equipes, ${dbprefix}participe");
		$db->where("${dbprefix}equipes.id = ${dbprefix}participe.equipe");
		$db->where("tournois = $s_tournois");
		$db->order_by("id");
		$res = $db->exec();

		while ($equipes = $db->fetch($res)) {

			/*** suppression de l'equipe dans m4 (eviter les conflits d'id) ***/
			$dbm4->delete("m4_clan");
			$dbm4->where("numero = $equipes->id");
			$dbm4->exec();
			
			/*** insertion de l'equipe inscrites dans m4 ***/
			$dbm4->insert("m4_clan (numero,nom)");
			$dbm4->values("$equipes->id,'$equipes->tag'");
			$dbm4->exec();
		}
	}


	/*** redirection ***/
	if(type_tournois($s_tournois)=='E') js_goto("?page=finales&op=admin");
	else js_goto("?page=poules&op=admin");
}

/********************************************************
 * Valider la cr&eacute;ation des poules du tournois en cours
 */
elseif ($op == "valider_poules") {

	/*** test de la session ***/
	if(empty($s_tournois)) js_goto("?page=index");

	/*** verification securite ***/
	verif_admin_tournois($s_joueur,$s_tournois,$grade['a'],$grade['b'],$grade['t']);

	$db->update("${dbprefix}tournois");
	$db->set("status = 'P'");
	$db->where("id = $s_tournois");
	$db->exec();

	/*** redirection ***/
	js_goto("?page=matchs_poules&op=generate");
}

/********************************************************
 * Terminer les matchs poules tournois en cours
 */
elseif ($op == "terminer_poules") {

	/*** test de la session ***/
	if(empty($s_tournois)) js_goto("?page=index");

	/*** verification securite ***/
	verif_admin_tournois($s_joueur,$s_tournois,$grade['a'],$grade['b'],$grade['t']);

	$db->update("${dbprefix}tournois");
	$db->set("status = 'H'");
	$db->where("id = $s_tournois");
	$db->exec();

	/*** redirection ***/
	js_goto("?page=finales&op=admin");
}

/*****************************************************
 * Valider la cr&eacute;ation des finales du tournois en cours
 */
elseif ($op == "valider_finales") {

	/*** test de la session ***/
	if(empty($s_tournois)) js_goto("?page=index");

	/*** verification securite ***/
	verif_admin_tournois($s_joueur,$s_tournois,$grade['a'],$grade['b'],$grade['t']);

	$db->update("${dbprefix}tournois");
	$db->set("status = 'F'");
	$db->where("id = $s_tournois");
	$db->exec();

	/*** redirection ***/
	js_goto("?page=matchs_finales&op=generate");
}

/********************************************************
 * Terminer le tournois en cours
 */
elseif ($op == "terminer_tournois") {

	/*** test de la session ***/
	if(empty($s_tournois)) js_goto("?page=index");

	/*** verification securite ***/
	verif_admin_tournois($s_joueur,$s_tournois,$grade['a'],$grade['b'],$grade['t']);

	$db->update("${dbprefix}tournois");
	$db->set("status = 'T'");
	$db->where("id = $s_tournois");
	$db->exec();

	/*** redirection ***/
	js_goto("?page=matchs_finales");
}

/********************************************************
 * Modifier un tournois 
 */
elseif ($op == "modify") {

	/*** verification securite ***/
	verif_admin_tournois($s_joueur,$s_tournois,$grade['a'],$grade['b'],$grade['t']);

	$db->select("${dbprefix}tournois.*,sigle,icone");
	$db->from("${dbprefix}tournois LEFT JOIN ${dbprefix}jeux on (${dbprefix}tournois.jeux = ${dbprefix}jeux.id)");
	$db->where("${dbprefix}tournois.id = $id");
	$db->exec();
	$tournois = $db->fetch();
				
	echo "<p class=title>.:: $strAdminTournois - $tournois->nom ::.</p>";

	echo "<form method=post action=?page=tournois&op=do_modify>";
	echo "<input type=hidden name=id value=$id>";
	echo '<input type="hidden" value="'.$strChangerElimination.'" name="str_txt" id="str_txt">';

	echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
	echo "<table cellspacing=1 cellpadding=0 border=0 class=fiche>";
	echo "<tr><td class=headerfiche>$strModifierTournois</td></tr>";
	echo "<tr><td>";
	echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";

	/*nom*/
	echo "<tr><td class=titlefiche>$strNom :</td>";
	echo "<td class=textfiche><b>".stripslashes($tournois->nom)."</b></td></tr>";

	/*status*/
	echo "<tr><td class=titlefiche>$strStatus :</td>";
	if ($tournois->status == "I") echo "<td class=textfiche>$strInscriptions</td></tr>";
	if ($tournois->status == "G") echo "<td class=textfiche>$strGenerationPoules</td></tr>";
	if ($tournois->status == "P") echo "<td class=textfiche>$strPhasePoules</td></tr>";
	if ($tournois->status == "H") echo "<td class=textfiche>$strGenerationFinales</td></tr>";
	if ($tournois->status == "F") echo "<td class=textfiche>$strPhaseFinales</td></tr>";
	if ($tournois->status == "T") echo "<td class=textfiche>$strTermine</td></tr>";

	/*type*/
	echo "<tr><td class=titlefiche>$strType :</td>";
	if ($tournois->type == "T") echo "<td class=textfiche>$strTournois</td></tr>";
	if ($tournois->type == "C") echo "<td class=textfiche>$strChampionnat</td></tr>";
	if ($tournois->type == "E") echo "<td class=textfiche>$strCoupe</td></tr>";
	
	/*jeux*/
	echo "<tr><td class=titlefiche>$strJeu :</td>";
	if($tournois->status=='I') {
		echo "<td class=textfiche><select name=jeux>";
		$db->select("id, sigle");
		$db->from("${dbprefix}jeux");
		$db->order_by("sigle");
		$jeux=$db->exec();
		while($jeu = $db->fetch($jeux)) {
			echo "<option value=$jeu->id";if($tournois->jeux==$jeu->id) echo " SELECTED";echo ">$jeu->sigle";
		}
		echo "</select></td>";
	}
	else {
		echo "<td class=textfiche>";
		echo "<input type=hidden name=jeux value=$tournois->jeux>";
		if($tournois->icone) echo "<img src=\"images/jeux/$tournois->icone\" align=absmiddle>&nbsp;";
		echo "$tournois->sigle</td>";

	}
	/*nbdeplaces*/
	echo "<tr><td class=titlefiche>$strNbPlaces :</td>";
	echo "<td class=textfiche><input type=text name=places value=\"$tournois->places\" size=4></td></tr>";

	/*mode equipe*/
	echo "<tr><td class=titlefiche>$strModeEquipe :</td><td class=textfiche>";
	echo "<input DISABLED type=radio name=modeequipe value=E style=\"border: 0px;background-color:transparent;\"";if ($tournois->modeequipe == "E") echo " CHECKED";echo ">$strEquipes";
	echo "<input DISABLED type=radio name=modeequipe value=J style=\"border: 0px;background-color:transparent;\"";if ($tournois->modeequipe == "J") echo " CHECKED";echo ">$strJoueur";
	echo "</td></tr>";

	/*mode match score*/
	echo "<tr><td class=titlefiche>$strModeMatchScore :</td><td class=textfiche>";
	echo "<input DISABLED type=radio name=modematchscore value=F style=\"border: 0px;background-color:transparent;\"";if ($tournois->modematchscore == "F") echo " CHECKED";echo ">$strFragAverage ";
	echo "<input DISABLED type=radio name=modematchscore value=R style=\"border: 0px;background-color:transparent;\"";if ($tournois->modematchscore == "R") echo " CHECKED";echo ">$strRoundAverage ";
	echo "<input DISABLED type=radio name=modematchscore value=RF style=\"border: 0px;background-color:transparent;\"";if ($tournois->modematchscore == "RF") echo " CHECKED";echo ">$strRoundAverageFragAverage";
	echo "</td></tr>";

	/*mode inscription*/
	echo "<tr><td class=titlefiche>$strModeInscription :</td><td class=textfiche>";
	echo "<input type=radio name=modeinscription value=A style=\"border: 0px;background-color:transparent;\"";if ($tournois->modeinscription == "A") echo " CHECKED";echo ">$strAdministrateur";
	echo "<input type=radio name=modeinscription value=J style=\"border: 0px;background-color:transparent;\"";if ($tournois->modeinscription == "J") echo " CHECKED";echo ">$strJoueur";
	echo "</td></tr>";	

	/*mode scoring*/
	if ($tournois->modeequipe=='J') $disabled=' DISABLED';
	else $disabled='';
	echo "<td class=titlefiche>$strModeScore :</td><td class=textfiche>";
	echo "<input type=radio name=modescore value=A style=\"border: 0px;background-color:transparent;\"";if ($tournois->modescore == "A") echo " CHECKED";echo ">$strAdministrateur";
	echo "<input type=radio name=modescore value=J style=\"border: 0px;background-color:transparent;\"";if ($tournois->modescore == "J") echo " CHECKED";echo ">$strJoueur";
	echo "<input type=radio name=modescore value=M4 style=\"border: 0px;background-color:transparent;\"";if ($tournois->modescore == "M4") echo " CHECKED";echo " $disabled>$strM4";
	echo "<input type=radio name=modescore value=AB style=\"border: 0px;background-color:transparent;\"";if ($tournois->modescore == "AB") echo " CHECKED";echo " $disabled>$strAdminBot";
	echo "</td></tr>";
	
	/*nbmanchesmax*/
	echo "<tr><td class=titlefiche>$strManchesMax :</td>";
	echo "<td class=textfiche><input type=text name=manchesmax value=\"$tournois->manchesmax\" size=2></td></tr>";
	
	/*nbpoules*/
	if($tournois->type == 'T' || $tournois->type == 'C') {
		echo "<tr><td class=titlefiche>$strNbPoules :</td>";
		echo "<td class=textfiche><input type=text name=poules value=\"$tournois->poules\" size=2 onchange=\"javascript:poules_tournois(form.id.value,this.value,'$strChangerPoules')\"";
		if($tournois->status == 'P' || $tournois->status == 'H' || $tournois->status == 'F' || $tournois->status == 'T' ) echo " DISABLED";
		echo "></td></tr>";
	}
	
	/*nbfinales et type*/
	if($tournois->type == 'T' || $tournois->type == 'E') {
		echo "<tr><td class=titlefiche>$strNbWinner :</td>";
		echo "<td class=textfiche>";
		echo "<select name=finales onchange=\"javascript:finales_winner(form.id.value,this.value,'$strChangerFinales')\"";
		if($tournois->status == 'F' || $tournois->status == 'T' ) echo " DISABLED";
		echo ">";
		echo "<option value=0";if ($tournois->winner == "0") echo " SELECTED";echo ">";
		for($i=1;$i<=8;$i++) {
			echo "<option value=".pow(2,$i);if ($tournois->winner == pow(2,$i)) echo " SELECTED";echo "> 1/".pow(2,$i)."";
		}
		echo "</select></td></tr>";

		echo "<tr><td class=titlefiche>$strFinalesType :</td>";
		echo "<td class=textfiche>";
		//echo '<select name="finales_type" onchange="javascript:if (confirm(this.value)) {location.href = \'?page=tournois&id=\'+form.id.value+\'&op=elimination&value=\'+this.value+\'\'}"';
		//Fix java error with old line here :( error is not logic Oo because select "finales" work verywell ))
		echo '<select name="finales_type" onchange="javascript:finales_elimination(form.id.value,this.value, form.str_txt.value)"';
		if($tournois->status == 'F' || $tournois->status == 'T' ) echo " DISABLED";
		echo ">";
		echo "<option value=S";if ($tournois->elimination == "S") echo " SELECTED";echo "> $strSimpleElimination";
		echo "<option value=D";if ($tournois->elimination == "D") echo " SELECTED";echo "> $strDoubleElimination";
		echo "</select></td></tr>";

		if($tournois->elimination == "D") {
			echo "<tr><td class=titlefiche>$strNbLooser :</td>";
			echo "<td class=textfiche>";
			echo "<select name=finales onchange=\"javascript:finales_looser(form.id.value,this.value,'$strChangerLooser')\"";
			if($tournois->status == 'F' || $tournois->status == 'T' ) echo " DISABLED";
			echo ">";
			echo "<option value=0";if ($tournois->looser == "0") echo " SELECTED";echo ">";
			for($i=1;$i<=log($tournois->winner)/log(2);$i++) {
				echo "<option value=".pow(2,$i);if ($tournois->looser == pow(2,$i)) echo " SELECTED";echo "> 1/".pow(2,$i)."";
			}
			echo "</select></td></tr>";
		}
	}	
	
	/*informations*/
	echo "<tr><td class=titlefiche>$strPageInformations :</td>";
	echo "<td class=textfiche><input type=text name=information value=\"$tournois->information\" size=15></td></tr>";
	/*dotations*/
	echo "<tr><td class=titlefiche>$strPageDotations :</td>";
	echo "<td class=textfiche><input type=text name=dotation value=\"$tournois->dotation\" size=15></td></tr>";
	/*reglement*/
	echo "<tr><td class=titlefiche>$strPageReglement :</td>";
	echo "<td class=textfiche><input type=text name=reglement value=\"$tournois->reglement\" size=15></td></tr>";
	/*stats*/
	echo "<tr><td class=titlefiche>$strPageStats :</td>";
	if(!$tournois->stats) $tournois->stats='http://';
	echo "<td class=textfiche><input type=text name=stats value=\"$tournois->stats\" size=40></td></tr>";

	/*mode upload*/
	echo "<td class=titlefiche>$strModeFichier :</td><td class=textfiche>";
	echo "<input type=radio name=modefichier value=A style=\"border: 0px;background-color:transparent;\"";if ($tournois->modefichier == "A") echo " CHECKED";echo ">$strAdministrateur";
	echo "<input type=radio name=modefichier value=C style=\"border: 0px;background-color:transparent;\"";if ($tournois->modefichier == "C") echo " CHECKED";echo ">$strManager";
	echo "<input type=radio name=modefichier value=N style=\"border: 0px;background-color:transparent;\"";if ($tournois->modefichier == "N") echo " CHECKED";echo ">$strNon";
	echo "</td></tr>";

	/*mode commentaire*/
	echo "<td class=titlefiche>$strModeCommentaire :</td><td class=textfiche>";
	echo "<input type=radio name=modecommentaire value=O style=\"border: 0px;background-color:transparent;\"";if ($tournois->modecommentaire == "O") echo " CHECKED";echo ">$strOui ";
	echo "<input type=radio name=modecommentaire value=N style=\"border: 0px;background-color:transparent;\"";if ($tournois->modecommentaire == "N") echo " CHECKED";echo ">$strNon";
	echo "</td></tr>";

	echo "<tr><td class=footerfiche colspan=2 align=center><input type=submit value=\"$strModifier\">&nbsp;<input type=button value=\"$strRetour\" onclick=\"document.location='?page=tournois&op=admin'\"></td></tr>";
	echo "</table>";
	echo "</td></tr></table>";
	echo "</td></tr></table>";

	echo "</form>";

	show_consignes($strTournoisModifyConsignes);	
	
}
/********************************************************
 * Selectionner un tournois 
 */
 else if($op=="select") {
	global $Sess;
	//SessionDelVar("s_tournois");
	$s_tournois = $id;
	$Sess->tournois($id,$s_joueur);
	//SessionSetVar("s_tournois",$s_tournois);

	$status = status_tournois($s_tournois);

	if ($status == "I") {
		js_goto("?page=inscriptions");
	}
	elseif ($status == "P" || $status == 'F') {
		js_goto("?page=matchs_liste&status=D");
	}
	elseif ($status == "T" && $type_tournois== "C") {
		js_goto("?page=matchs_poules");
	}
	elseif ($status == "T" && ($type_tournois== "E" || $type_tournois=="T")) {
		js_goto("?page=matchs_finales&x=0");
	}
	else {
		js_goto("?page=news");
	}
}
/********************************************************
 * Affichage normal + admin
 */
else {
		
	/*** verification securite ***/
	//if($op == "admin") verif_admin_tournois($s_joueur,$s_tournois);
	if($op == "admin") verif_admin_tournois($s_joueur,$s_tournois,$grade['a'],$grade['b'],$grade['t']);

	
	if($op == "admin") echo "<p class=title>.:: $strAdminTournois ::.</p>";
	else echo "<p class=title>.:: $strTournois ::.</p>";

	$db->select("${dbprefix}tournois.*,sigle,icone");
	$db->from("${dbprefix}tournois LEFT JOIN ${dbprefix}jeux on (${dbprefix}tournois.jeux= ${dbprefix}jeux.id)");
	$db->order_by("nom");
	$res=$db->exec();

	if ($db->num_rows($res) != 0) {
	
		echo "<table cellspacing=0 cellpadding=0 border=0>";
		echo "<tr><td class=title>". nb_tournois() ." $strTournois</td></tr>";
		echo "</table>";

		echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
		echo "<table cellspacing=1 cellpadding=2 border=0 width=100%>";
		echo "<tr>";
		echo "<td class=headerliste width=200>$strTournois</td>";
		echo "<td class=headerliste>$strType</td>";
		echo "<td class=headerliste>$strJeu</td>";
		echo "<td class=headerliste>$strAdmins</td>";
		echo "<td class=headerliste>$strInscrits</td>";
		echo "<td class=headerliste width=1%>$strStatus</td>";
		echo "</tr>";

		while($tournois = $db->fetch($res)) {

			echo "<tr>";
			echo "<form>";
			echo "<input type=hidden name=id value=$tournois->id>";
			echo "<td class=textliste><div style=\"clear: both\"><div style=\"float: left\">".show_tournois($tournois->id).'</div>';
			if($op=='admin' && (admin_tournois($s_joueur,$tournois->id) || $grade['a']=='a'||$grade['b']=='b')) {
				echo "<div style=\"float: right;\"><a href=?page=tournois&op=modify&id=$tournois->id>[$strE]</a>";
				if ($tournois->status == "T")
					echo "&nbsp;<a href=?page=tournois&op=delete&id=$tournois->id onclick=\"return confirm('$strConfirmEffacerTournois');\">[$strS]</a>";
				echo "</div>";
			}
			echo "</div></td>";

			if ($tournois->type == "T") echo "<td class=textliste align=center>$strTournois</td>";
			if ($tournois->type == "C") echo "<td class=textliste align=center>$strChampionnat</td>";
			if ($tournois->type == "E") echo "<td class=textliste align=center>$strCoupe</td>";

			echo "<td class=textliste align=center>$tournois->sigle</td>";

			$db->select("id");
			$db->from("${dbprefix}joueurs,${dbprefix}administre");
			$db->where("${dbprefix}joueurs.id = ${dbprefix}administre.joueur");
			$db->where("tournois = $tournois->id");
			$db->order_by("pseudo");
			$res2 = $db->exec();

			echo "<td class=textliste>";
			while($joueur = $db->fetch($res2)) {
				echo show_joueur($joueur->id);
			}
			echo "</td>";

			$nbinscrits=nb_inscrits_tournois($tournois->id);
			$nbplaces=nb_places_tournois($tournois->id);
			
			if($tournois->modeequipe == 'E') $equipeX="$strEquipes";
			elseif($tournois->modeequipe == 'J') $equipeX="$strJoueurs";
	
			echo "<td class=textliste align=center>";
			if($nbinscrits > $nbplaces) echo "<font color=red>$nbinscrits</font> / $nbplaces";
			else echo "$nbinscrits / $nbplaces";
			echo " $equipeX</td>";

			echo "<td class=textliste align=center>";

			if($op=='admin' && (admin_tournois($s_joueur,$tournois->id) || $grade['a']=='a'||$grade['b']=='b')) {
				echo "<select name=status ONCHANGE=\"status_tournois(form.id.value,this.value,'$strChangerStatusTournois')\">";
				echo "<option value=I";if ($tournois->status == "I") echo " SELECTED";echo "> $strInscriptions";

				if($tournois->type == 'T' || $tournois->type == 'C') {
					echo "<option value=G";if ($tournois->status == "G") echo " SELECTED";echo "> $strGenerationPoules";
					echo "<option value=P";if ($tournois->status == "P") echo " SELECTED";echo "> $strPhasePoules";
				}
				if($tournois->type == 'T' || $tournois->type == 'E') {
					echo "<option value=H";if ($tournois->status == "H") echo " SELECTED";echo "> $strGenerationFinales";
					echo "<option value=F";if ($tournois->status == "F") echo " SELECTED";echo "> $strPhaseFinales";
				}

				echo "<option value=T";if ($tournois->status == "T") echo " SELECTED";echo "> $strTermine";
				echo "</select>";
			}
			else {
				if ($tournois->status == "I") echo "$strInscriptions";
				if ($tournois->status == "G") echo "$strGenerationPoules";
				if ($tournois->status == "P") echo "$strPhasePoules";
				if ($tournois->status == "H") echo "$strGenerationFinales";
				if ($tournois->status == "F") echo "$strPhaseFinales";
				if ($tournois->status == "T") echo "$strTermine";
			}

			echo "</td>";
			echo "</form>";
			echo "</tr>";
		}

		echo "</table>";
		echo "</td></tr></table>";
	}
	else {
		echo "<table cellspacing=2 cellpadding=2 border=0>";
		echo "<tr><td class=title>$strPasDeTournoi</td></tr>";
		echo "</table><br>";
	}


	if(($grade['a']=='a'||$grade['b']=='b') && $op=='admin') {

		/*** administration des admins des tournois ***/
		echo "<form method=post action=?page=admin>";
		echo "<table cellspacing=0 cellpadding=0 border=0><tr>";
		echo "<td><input type=submit class=action value=\"$strAdministrateursTournois\"></td>";
		echo "</tr></table>";
		echo "</form>";

		/*** ajout d'un tournois ***/
		echo "<form method=post action=?page=tournois&op=add> ";
		echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
		echo "<table cellspacing=1 cellpadding=0 border=0>";
		echo "<tr><td class=headerfiche colspan=2>$strAjouterTournois</td></tr>";
		echo "<tr><td>";
		echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
		echo "<tr>";
		echo "<td class=titlefiche>$strNom <font color=red><b>*</b></font> :</td>";
		echo "<td class=textfiche><input type=text name=nom size=40></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class=titlefiche>$strType <font color=red><b>*</b></font> :</td>";
		echo "<td class=textfiche><select name=type><option value=T>$strTournois<option value=C>$strChampionnat<option value=E>$strCoupe</select></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class=titlefiche>$strJeu :</td>";
		echo "<td class=textfiche><select name=jeux>";
		$db->select("id, sigle");
		$db->from("${dbprefix}jeux");
		$db->order_by("sigle");
		$db->exec();
		while($jeux = $db->fetch()) {
			echo "<option value=$jeux->id>$jeux->sigle";
		}
		echo "</select></td></tr>";	
		echo "<tr>";
		echo "<td class=titlefiche>$strModeEquipe <font color=red><b>*</b></font> :</td>";
		echo "<td class=textfiche>";
		echo "<input type=radio name=modeequipe value=E CHECKED style=\"border: 0px;background-color:transparent;\">$strEquipes";
		echo "<input type=radio name=modeequipe value=J style=\"border: 0px;background-color:transparent;\">$strJoueurs";
		echo "</td></tr>";
		echo "<td class=titlefiche>$strModeMatchScore <font color=red><b>*</b></font> :</td>";
		echo "<td class=textfiche>";
		echo "<input type=radio name=modematchscore value=F CHECKED style=\"border: 0px;background-color:transparent;\">$strFragAverage";
		echo "<input type=radio name=modematchscore value=R style=\"border: 0px;background-color:transparent;\">$strRoundAverage";
		echo "<input type=radio name=modematchscore value=RF style=\"border: 0px;background-color:transparent;\">$strRoundAverageFragAverage";
		echo "</td></tr>";
		echo "<td class=titlefiche>$strNbPlaces :</td>";
		echo "<td class=textfiche>";	
		echo "<input type=text name=nbplaces value=\"\" size=4>";
		echo "</td></tr>";
		echo "<tr><td class=footerfiche colspan=2 align=center><input type=submit value=\"$strAjouter\"></td></tr>";
		echo "</table>";
		echo "</td></tr></table>";
		echo "</td></tr></table>";
		echo "</form>";

		show_consignes($strTournoisConsignes);
	}
	
	echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";
	
	
}

?>

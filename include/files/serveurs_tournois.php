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
if (eregi("serveurs_tournois.php", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}
/*** test de la session ***/
if(empty($s_tournois)) js_goto("?page=index");

/*** verification securite ***/
verif_admin_tournois($s_joueur,$s_tournois,$grade['a'],$grade['b'],$grade['t']);

/********************************************************
 * Modifier les serveurs utilis&eacute;s au tournois en cours
 */
if ($op == "modify") {

	/*** verification securite ***/
	verif_admin_tournois($s_joueur,$s_tournois,$grade['a'],$grade['b'],$grade['t']);
	
	$db->delete("${dbprefix}serveurs_tournois");
	$db->where("tournois = $s_tournois");
	$db->exec();
	
	if(count($tab_serveurs)!=0) {
	
		foreach ($tab_serveurs as $idserveur) {
			$db->insert("${dbprefix}serveurs_tournois (serveur,tournois)");
			$db->values("$idserveur,$s_tournois");
			$db->exec();
		}
	}

	/*** modification des serveurs dans les matchs de poules ***/
	$index_srv=$index_srv_poule=0;

	for($p=1;$p<=nb_poules($s_tournois);$p++)
	{
		$nb_tours = nb_tours($p, $s_tournois);;

		$index_srv=$index_srv_poule;

		for($t=1; $t<=$nb_tours; $t++)
		{
			$index_srv_poule=$index_srv;

			$db->select("id");
			$db->from("${dbprefix}matchs");
			$db->where("type = 'P'");
			$db->where("poule = $p");
			$db->where("tour = $t");
			$db->where("tournois = $s_tournois");
			$db->order_by("id");
			$res1 = $db->exec();

			while($match = $db->fetch($res1)) {
				$index_srv_poule++;

				$index_real_srv=$index_srv_poule % count($tab_serveurs);
				if($index_real_srv==0) $index_real_srv=count($tab_serveurs);

				$serveur=$tab_serveurs[$index_real_srv-1];

				/*** update du serveur du match  ***/
				$db->update("${dbprefix}matchs");
				$db->set("serveur = '$serveur'");
				$db->where("id = ".$match->id);
				$db->where("(status = 'C' or status = 'A')");
				$db->exec();
			}
		}
	}
	
	/*** modification des serveurs dans les matchs de finales winner***/
	$finales_winner=$nb_finales_winner_tournois;
		
	while ($finales_winner>=1) {		
		for($i=1;$i<=$finales_winner;$i++) {
			
			$index_real_srv =$i % count($tab_serveurs);
			if($index_real_srv==0) $index_real_srv=count($tab_serveurs);

			$serveur=$tab_serveurs[$index_real_srv-1];
			
			$db->update("${dbprefix}matchs");
			$db->set("serveur = '$serveur'");
			$db->where("type = 'W'");
			$db->where("finale = $finales_winner");
			$db->where("numero = $i");
			$db->where("tournois = $s_tournois");
			$db->where("(status = 'C' or status = 'A')");
			$db->exec();
		}
		$finales_winner=$finales_winner/2;
	}

	/*** modification des serveurs dans les matchs de finales looser***/
	$finales_looser=$nb_finales_looser_tournois/2;

	while ($finales_looser>=1) {
		for($i=1;$i<=($finales_looser)*2;$i++) {
							
			$index_real_srv=($i+$finales_looser) % count($tab_serveurs);
			if($index_real_srv==0) $index_real_srv=count($tab_serveurs);
			
			$serveur=$tab_serveurs[$index_real_srv-1];
			
			$db->update("${dbprefix}matchs");
			$db->set("serveur = '$serveur'");
			$db->where("type = 'L'");
			$db->where("finale = $finales_looser");
			$db->where("numero = $i");
			$db->where("tournois = $s_tournois");
			$db->where("(status = 'C' or status = 'A')");
			$db->exec();		
		}
		$finales_looser=$finales_looser/2;
	}

	/*** modification des serveurs dans le match de grand final ***/
	$serveur=$tab_serveurs[0];
	
	$db->update("${dbprefix}matchs");
	$db->set("serveur = '$serveur'");
	$db->where("type = 'W'");
	$db->where("finale = 0");
	$db->where("numero = 1");
	$db->where("tournois = $s_tournois");
	$db->where("(status = 'C' or status = 'A')");
	$db->exec();	
	

	/*** redirection ***/
	js_goto("?page=serveurs_tournois&op=admin");

}

/******************************************************** 
 * Affichage admin
 */
else {

 	echo "<p class=title>.:: $strAdminServeurs - ".nom_tournois($s_tournois)." ::.</p>";
	
	echo "<table cellspacing=0 cellpadding=0 border=0>";
	echo "<tr><td class=title>". nb_serveurs_tournois($s_tournois) ." $strServeurs</td></tr>";
	echo "</table>";

	/*** Inscription des serveurs au tournois***/
	$db->select("${dbprefix}serveurs.id, ${dbprefix}serveurs.nom,adresse,port,origine,protocole,sigle,icone");
	$db->from("${dbprefix}serveurs, ${dbprefix}jeux, ${dbprefix}tournois");
	$db->where("${dbprefix}serveurs.jeux = ${dbprefix}jeux.id");
	$db->where("${dbprefix}serveurs.jeux = ${dbprefix}tournois.jeux");
	$db->where("${dbprefix}tournois.id = $s_tournois");
	$db->order_by("${dbprefix}serveurs.id");
	$serveurs = $db->exec();

	/** reinit des colonne a 1 ***/
	if ($db->num_rows($serveurs) < $config['col_serveurs'])
		$config['col_serveurs']=1;

	if ($db->num_rows($serveurs) != 0) {
		$i=0;
		while($serveur = $db->fetch($serveurs)) {
			$tab_serveurs[$i]=$serveur;
			$i++;
		}
		
		echo "<table class=liste><tr valign=top>";
		echo "<form name='liste' method=post action=?page=serveurs_tournois&op=modify>";		

		for($i=0;$i<$config['col_serveurs'];$i++) {
			echo "<td>";
			echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
			echo "<table cellspacing=1 cellpadding=2 border=0>";
			echo "<td class=headerliste>#</td><td class=headerliste>$strJeu</td><td class=headerliste>$strNom</td><td class=headerliste>$strAdresse</td><td class=headerliste>$strInscrit</td>";

			for($j=$i;$j<count($tab_serveurs);$j=$j+$config['col_serveurs']) {
				
				/** nom **/
				if($tab_serveurs[$j]->nom)
					$servername=$tab_serveurs[$j]->nom;
				else
					$servername="N/A";

				echo "<tr>";
				echo "<td class=textliste align=center>".$tab_serveurs[$j]->id."</td>";
				echo "<td class=textliste align=center><img src=\"images/jeux/".$tab_serveurs[$j]->icone."\" border=0 align=absmiddle></td>";
				echo "<td class=textliste><img src=\"images/flags/".$tab_serveurs[$j]->origine.".gif\" border=0 align=absmiddle> $servername</td>";
				echo "<td class=textliste>".$tab_serveurs[$j]->adresse.":".$tab_serveurs[$j]->port."</td>";
				echo "<td class=textliste align=center><input type=checkbox name=tab_serveurs[] value=\"".$tab_serveurs[$j]->id."\" style=\"border=0px;background-color:transparent;\"";if (utilise_serveur($tab_serveurs[$j]->id, $s_tournois)) echo " CHECKED";echo ">";
				echo "</td>";
				echo "</tr>";

			}
			echo "</table>";
			echo "</td></tr></table>";
			echo "</td>";
		}
		echo "</tr></table>";
	
		echo "<table cellspacing=1 cellpadding=2 border=0>";
		echo "<tr><td class=text align=center><a href=javascript:select_all('liste')>$strToutSelectionner<a/> - <a href=javascript:unselect_all('liste')>$strToutDeselectionner<a/></td></tr>";
		echo "<tr><td class=text align=center><input type=submit value=\"$strValider\"></td></tr>";
		echo "</table><br>";
		echo "</form>";
		
	}
	else {
		echo "<table cellspacing=2 cellpadding=2 border=0>";
		echo "<tr><td class=title>$strPasDeServeur</td></tr>";
		echo "</table><br>";
		
	}
	
	show_consignes($strServeursTournoisConsignes);
		
	echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";


}

?>

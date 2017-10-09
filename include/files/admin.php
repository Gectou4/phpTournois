<?php
/*
   +---------------------------------------------------------------------+
   | phpTournois                                                         |
   +---------------------------------------------------------------------+
   +---------------------------------------------------------------------+
   | phpTournoisG4 �2004 by Gectou4 <le_gardien_prime@hotmail.com>       |  
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

/*** verification securite ***/
if (preg_match("/admin.php/i", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}

if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['t']!='t') {js_goto($PHP_SELF);} 
//verif_admin_general($s_joueur);

/********************************************************
 * Ajout d'un administrateur a un tournois
 */
if ($op == "add") {
	$db->insert("${dbprefix}administre (tournois,joueur)");
	$db->values("$id,$joueur");
	$db->exec();
}

/******************************************************** 
 * Suppression d'un administration a un tournois
 */
elseif ($op == "delete") {
	$db->delete("${dbprefix}administre");
	$db->where("joueur = $joueur");
	$db->where("tournois = $id");
	$db->exec();
}

/******************************************************** 
 * Affichage admin
 */
 
echo "<p class=title>.:: $strAdministrateursTournois ::.</p>";

$db->select("${dbprefix}tournois.id,${dbprefix}tournois.nom,sigle,icone");
$db->from("${dbprefix}tournois,${dbprefix}jeux");
$db->where("${dbprefix}tournois.jeux = ${dbprefix}jeux.id");
$db->order_by("${dbprefix}tournois.nom");
$tournois = $db->exec();

if ($db->num_rows($tournois) != 0) {
	$i=0;
	while ($tournoi = $db->fetch($tournois)) {
		$tab_tournois[$i]=$tournoi;
		$i++;
	}

	echo "<table border=0 class=liste><tr valign=top>";

	for($i=0;$i<$config['col_administrateurs'];$i++) {
		echo "<td>";
	
		for($j=$i;$j<count($tab_tournois);$j=$j+$config['col_administrateurs']) {
			echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1 width=120>";
			echo "<tr><td>";
			echo "<table cellspacing=1 cellpadding=2 border=0 width=100%>";
			echo "<tr><td class=headerliste>";if($tab_tournois[$j]->icone) echo "<img src=\"images/jeux/".$tab_tournois[$j]->icone."\" align=absmiddle>&nbsp;".$tab_tournois[$j]->nom."&nbsp;&nbsp;$strAdmins</td></tr>";

			$db->select("id");
			$db->from("${dbprefix}joueurs,${dbprefix}administre");
			$db->where("${dbprefix}joueurs.id = ${dbprefix}administre.joueur");
			$db->where("tournois = ".$tab_tournois[$j]->id);
			$db->order_by("pseudo");
			$res2 = $db->exec();
				
			while($joueur = $db->fetch($res2)) {
				echo "<tr><td class=textliste>";
				echo "<div style=\"clear: both\"><div style=\"float: left\">".show_joueur($joueur->id,'admin')."</div>";
				echo "<div style=\"float: right\">&nbsp;<a href=?page=admin&op=delete&joueur=$joueur->id&id=".$tab_tournois[$j]->id.">[$strS]</a></div>";
				echo "</div></td></tr>";
			}
			
			echo "<form method=post action=?page=admin>";
			echo "<tr><td class=textliste>";
			echo "<input type=hidden name=op value=add>";
			echo "<input type=hidden name=id value=".$tab_tournois[$j]->id.">";
			echo "<select name=joueur>";

			$db->select("pseudo,id");
			$db->from("	${dbprefix}joueurs");
			$db->where("etat <> 'C'");
			$db->order_by("pseudo");
			$res2 = $db->exec();
			
			while($joueur = $db->fetch($res2)) {
				if(!admin_tournois($joueur->id,$tab_tournois[$j]->id)) {
					echo "<option value=$joueur->id>$joueur->pseudo";
				}
			}
			echo "</select>";
			echo "<input type=submit value=$strAjouter>";
			echo "</td></tr>";
			echo "</form>";
			echo "</table>";
			echo "</td></tr></table>";
		}

		echo "</td>";
	}
	echo "</tr></table>";

	echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=\"?page=tournois&op=admin\" class=action>$strRetour</a><br>";
}

?>

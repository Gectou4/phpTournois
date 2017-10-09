<?php
/*
   +---------------------------------------------------------------------+
   | phpTournois                                                         |
   | phpTournoisG4 �2005 by Gectou4 <Gectou4 Gectou4@hotmail.com>        |
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

if (preg_match("/block_tournois.php/i", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}

global $config,$s_joueur,$s_theme,$s_tournois,$status_tournois,$modeequipe_tournois,$type_tournois,$modescore_tournois,$modeinscription_tournois,$db,$dbprefix;
global $strTournois,$strStatus,$strInscriptions,$strConfirmIncrireTeam,$strConfirmSIncrire,$strGenerationPoules,$strPhasePoules,$strGenerationFinales,$strPhaseFinales,$strTermine,$strInformations,$strDotations,$strReglement,$strStatistiques;
global $strCalendrier,$strMatchsActifs,$strMatchsEnCours,$strTableauxPoules,$strMatchsPoules,$strMatchsFinales,$strResultats,$strRapporterResultats;
global $EquipesX,$strJoueursInscrits,$strEquipesInscrits,$strInscrire,$strSInscrire,$strMatchsTermines,$strMatchs,$strConfirmDesincrire,$strSeDesinscrire,$strDesinscrire,$strConfirmDesincrireTeam;
global $strTournoisTermines, $strTournoisEnCours, $strarbitre;

if(isset($show_tournois_status) && $show_tournois_status!='') {
	//termin&eacute;
	if($show_tournois_status=='T') {
		$str_tournois = $strTournoisTermines;
		$status='T';
	}
	//encours
	else {
		$str_tournois = $strTournoisEnCours;	 	
		$status='E';
	}	
}
else {
	$str_tournois=$strTournois;
	$status='';	
}

$db->select("id,status,reglement,information,dotation,stats");
$db->from("${dbprefix}tournois");
if($status=='T') $db->where("status = 'T'");
if($status=='E') $db->where("status <> 'T'");
$db->order_by("${dbprefix}tournois.nom");

$res = $db->exec();

if($db->num_rows($res)!=0) {
	$t=0;
	theme_openblock("$str_tournois");
	
	while($tournois = $db->fetch($res)) {
			
		if ($s_tournois == $tournois->id) {
			//if($t!=0) echo '<hr width="95%">';
			echo show_tournois($tournois->id,1);echo '<br />';
			echo '<hr width="95%">';
			//echo '<br /><div style="margin-left:5px">';	
			echo "<img src=\"themes/$s_theme/images/icon_status.gif\" align=\"absmiddle\"> <u>$strStatus</u>:<span style=\"font-wight:bold;\"> ";
			if($status_tournois == 'I') echo $strInscriptions;
			if($status_tournois == 'G') echo $strGenerationPoules;
			if($status_tournois == 'P') echo $strPhasePoules;
			if($status_tournois == 'H') echo $strGenerationFinales;
			if($status_tournois == 'F') echo $strPhaseFinales;
			if($status_tournois == 'T') echo $strTermine;
			echo '</span><dl>';
			if($tournois->information) 	echo "<li class=\"lib\"><a href=\"?page=informations&amp;id=$s_tournois\">$strInformations</a></li>";
			if($tournois->dotation) 	echo "<li class=\"lib\"><a href=\"?page=dotations&amp;id=$s_tournois\">$strDotations</a></li>";
			if($tournois->reglement) 	echo "<li class=\"lib\"><a href=\"?page=reglements&amp;id=$s_tournois\">$strReglement</a></li>";
			if($tournois->stats) 		echo "<li class=\"lib\"><a href=\"$tournois->stats\" target=\"_blank\">$strStatistiques</a></li>";
			echo '<li class="lib"><a href="?page=inscriptions">'.${'str'.$EquipesX.'Inscrits'}.'</a></li>';
	
			/*** le tournois est en inscription manuel ***/
			if($modeinscription_tournois == 'J' && $status_tournois == 'I') {
				
				/*** si il y a assez de places ***/
				$nbinscrits=nb_inscrits_tournois($s_tournois);
				$nbplaces=nb_places_tournois($s_tournois);
	
				if($nbinscrits < $nbplaces) {
					
					/*** le tournois est par equipe (le manager ki inscrit) ***/
					if($modeequipe_tournois == 'E' && $s_joueur) {
						$mesequipes=equipes_manager($s_joueur);
											
						for($i=0;$i<count($mesequipes);$i++) {
							if(!participe($mesequipes[$i]['id'],$s_tournois) && equipe_valide($mesequipes[$i]['id'])) {
								echo "<li class=\"lib\"><a href=\"?page=inscriptions&amp;op=sinscire&amp;id=$s_tournois&amp;equipe=".$mesequipes[$i]['id']."\" onclick=\"return confirm('$strConfirmIncrireTeam');\"><span style=\"color:red\">$strInscrire ".$mesequipes[$i]['tag']."</span></a></li>";
							}
							elseif(participe($mesequipes[$i]['id'],$s_tournois)) {
								echo "<li class=\"lib\"><a href=\"?page=inscriptions&amp;op=desinscire&amp;id=$s_tournois&amp;equipe=".$mesequipes[$i]['id']."\" onclick=\"return confirm('$strConfirmDesincrireTeam');\"><span style=\"color:red\">$strDesinscrire ".$mesequipes[$i]['tag']."</span></a></li>";
							}
						}
					}
					/*** le tournois est par joueur (le joueur ki inscrit) ***/
					elseif($modeequipe_tournois == 'J' && $s_joueur) {
						if(!participe($s_joueur,$s_tournois) && joueur_inscrit($s_joueur)) {
							echo "<li class=\"lib\"><a href=\"?page=inscriptions&amp;op=sinscire&amp;id=$s_tournois\" onclick=\"return confirm('$strConfirmSIncrire');\"><span style=\"color:red\">$strSInscrire</span></a></li>";
						}
						elseif(participe($s_joueur,$s_tournois)) {
							echo "<li class=\"lib\"><a href=\"?page=inscriptions&amp;op=desinscire&amp;id=$s_tournois\" onclick=\"return confirm('$strConfirmDesincrire');\"><span style=\"color:red\">$strSeDesinscrire</span></a></li>";
						}
					}
				}
			}
			//echo '</dl><br /><dl>';
	
			/** select de la poule si le joueur est actif dans le tournois**/
			if($modeequipe_tournois == 'E' && !empty($s_joueur)) {
				$equipes = equipes_joueur($s_joueur);
	
				for($i=0;$i<count($equipes);$i++) {
					$p='';
					$p=poule_participe($equipes[$i]['id'],$s_tournois);
					if($p) break;
				}
			}
			elseif(!empty($s_joueur)){
				$p=poule_participe($s_joueur,$s_tournois);
			}
	
			if(isset($p) && $p != '') $p_str="&amp;x=$p";
			else $p_str='';
	
			/*** match **/
			if($status_tournois == 'P' || $status_tournois == 'F' || $status_tournois == 'T') {
				echo "<br /><img src=\"themes/$s_theme/images/icon_matchs.gif\" align=absmiddle> <u>$strMatchs</u>:<br />";
				echo '<div style="margin-left:5px">';
				echo "<li class=\"lir\"><a href=\"?page=arbitre\">$strarbitre</a></li>";
				if($status_tournois != 'T') {
					echo "<li class=\"lib\"><a href=\"?page=matchs_calendrier\">$strCalendrier</a></li>";
					echo "<li class=\"lib\"><a href=\"?page=matchs_liste&amp;status=A\">$strMatchsActifs</a></li>";
					echo "<li class=\"lib\"><a href=\"?page=matchs_liste&amp;status=D\">$strMatchsEnCours</a></li>";
					if($modescore_tournois=='J' && $s_joueur) echo "<li class=\"lib\"><a href=\"?page=matchs_report\">$strRapporterResultats</a></li>";
				}
				echo "<li class=\"lib\"><a href=\"?page=matchs_liste&amp;status=T\">$strMatchsTermines</a></li>";
				echo '</div>';
			}
	
			/*** resultats ***/
			if($type_tournois == 'T') {
	   			if($status_tournois == 'P' ||  $status_tournois == 'H' ) {
					echo "<br /><img src=\"themes/$s_theme/images/icon_resultats.gif\" align=absmiddle> <u>$strResultats</u>:<br />";
					echo '<div style="margin-left:5px">';
					echo "<li class=\"lib\"><a href=\"?page=poules$p_str\">$strTableauxPoules</a></li>";
					echo "<li class=\"lib\"><a href=\"?page=matchs_poules$p_str\">$strMatchsPoules</a></li>";
					echo '</div>';
				}
				if($status_tournois == 'F' || $status_tournois == 'T') {
					echo "<br /><img src=\"themes/$s_theme/images/icon_resultats.gif\" align=absmiddle> <u>$strResultats</u>:<br />";
					echo '<div style="margin-left:5px">';
					echo "<li class=\"lib\"><a href=\"?page=poules$p_str\">$strTableauxPoules</a></li>";
					echo "<li class=\"lib\"><a href=\"?page=matchs_poules$p_str\">$strMatchsPoules</a></li>";
					echo "<li class=\"lib\"><a href=\"?page=matchs_finales&amp;x=0\">$strMatchsFinales</a></li>";
					echo '</div>';
				}
			}
			else if($type_tournois == 'C') {
				if($status_tournois == 'P' || $status_tournois == 'T') {
					echo "<br /><img src=\"themes/$s_theme/images/icon_resultats.gif\" align=absmiddle> <u>$strResultats</u>:<br />";
					echo '<div style="margin-left:5px">';
					echo "<li class=\"lib\"><a href=\"?page=poules$p_str\">$strTableauxPoules</a></li>";
					echo "<li class=\"lib\"><a href=\"?page=matchs_poules$p_str\">$strMatchsPoules</a></li>";
					echo '</div>';
				}
			}
			else if($type_tournois == 'E') {
				if($status_tournois == 'F' || $status_tournois == 'T') {			
					echo "<br /><img src=\"themes/$s_theme/images/icon_resultats.gif\" align=absmiddle> <u>$strResultats</u>:<br />";
					echo '<div style="margin-left:5px">';
					echo "<li class=\"lib\"><a href=\"?page=matchs_finales&amp;x=0\">$strMatchsFinales</a></li>";
					echo '</div>';
				}
			}
			echo "</dl>";
			//echo '<br />';
			if($t<$db->num_rows($res)-1) echo '<hr width="95%">';
	
		}
		else {
			echo show_tournois($tournois->id).'<br />';
		}
		$t++;
	}
	theme_closeblock();
}

?>

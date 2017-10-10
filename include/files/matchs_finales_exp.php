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
if (preg_match("/matchs_finales_exp.php/i", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}
/*** test de la session ***/
if(empty($s_tournois)) js_goto("index.php");


/********************************************************
 * Generer tous les matchs
 */

		
	/*** verification securite ***/
	verif_admin_tournois($s_joueur,$s_tournois,$grade['a'],$grade['b'],$grade['t']);
	
	if(!isset($status)) $status='';
	if(!isset($x)) $x='';

	// calcul global des parametres de l'arbre
	$nb_x_total = log($nb_finales_winner_tournois)/log(2);
	if($modeelimination_tournois=='D') $nb_x_total++;

	//echo "nb_x_total: $nb_x_total|";

	// calcul des decalages au debut (suivant le type d'arbre)
	if(is_numeric($x)) {
		if($modeelimination_tournois=='S') {
			$delta=$config['x_delta_simple'];
		}
		else {
			$delta=$config['x_delta_double'];
		}

		if($x <= 0) $x=0;
		elseif($x >= $nb_x_total) $x=$nb_x_total;

		$nb_finales_winner=$nb_finales_winner_tournois/pow(2,(int)$x);
	}
	else {
		$nb_finales_winner=$nb_finales_winner_tournois;
	}

	//	echo " nb_finales_winner : $nb_finales_winner|";

	$nb_row_winner = $nb_finales_winner*2;

	$nb_col = 2*(log($nb_finales_winner)/log(2)+1);  // 1 col match + 1 col img

	if($modeelimination_tournois=='D') $nb_col++; // 1 de plus pour la grande finale

	// calcul des decalages a la fin
	if(is_numeric($x)) {		
		
		if($nb_col-$delta > 0) $nb_col = $delta*2;
	}	

	//echo " nb_col :$nb_col|";

	// cacul du nombre de lignes
	if($modeelimination_tournois=='S') {
		$nb_row=$nb_row_winner-1;
		$last_finale=1;
	}
	else {
		$nb_row_looser=$nb_finales_looser_tournois-1;
		$nb_row=$nb_row_winner+$nb_row_looser;
		$last_finale=0;
	}
	$export .="<!-- DEBUT DE LA GENERATION DE L'ARBRE -->";
	// affichage winner/looser
	
	if($op) $op_str="&op=$op";
	else $op_str='';
	
	// affichage du navigateur
	$export ="
        <br>
		<table cellspacing='0' cellpadding='0' border='0'>
		<tr>";
	
	//les headers
	$finale = $nb_finales_winner;
	for ($f=0; $f < $nb_col; $f++) {
		if ($f%2 == 0) {
			if($finale > 1)
				$export .= "<td class=\"info\" align=\"center\"><b><u>1/$finale $strFinale</u></b></td>";
			elseif ($finale == 1) {	
				$export .= "<td class=\"info\" align=\"center\"><b><u>$strFinale</u></b></td>";
				
				if($modeelimination_tournois=='S') {
					$id_grandfinale=id_match_finale('W',1,1,$s_tournois,$op,$status);
														
					if(match_fini($id_grandfinale)) $export .= "<td class=\"info\" colspan=\"2\" align=\"center\"><b><u>$strVainqueur</u></b></td>";
				}
			}
			else  {
				
				if($modeelimination_tournois=='D') {				
					$export .= "<td class=\"info\" align=\"center\"><b><u>$strGrandFinal</u></b></td>";
					$id_grandfinale=id_match_finale('W',0,1,$s_tournois,$op,$status);
															
					if(match_fini($id_grandfinale)) $export .= "<td class=\"info\" colspan=\"2\" align=\"center\"><b><u>$strVainqueur</u></b></td>";
					
				}
			}
			$finale /= 2;
		}	
		else 
			$export .= '<td align="center"><img src="images/spacer.gif"></td>'; 
		
	}
	$export .= "</tr>
			<tr><td align=\"center\" colspan=\"$nb_col\">&nbsp;</td></tr>";

	// l'arbre:
	// parcours par ligne du tableau
	for ($e = 1 ; $e <= $nb_row ; $e++) {
		$finale = $nb_finales_winner;

		//if($e==$nb_row_winner+1) echo "<tr colspan='".($nb_col+2)."'><td background=images/arbre_ligneH.gif align=center><img src=images/arbre_ligneH.gif></td></tr>";

		$export .= '<table cellspacing="0" cellpadding="0" border="0"><tr>';	

		// parcours par colonne du tableau
		for ($f=1; $f < $nb_col/2+1; $f++) {

			$finale=floor($finale);
			//${"numero$finale"}='';
			//echo $finale;

			// WINNER
			if($e<=$nb_row_winner) {
				
				// case pleine winner 
				if(($e) % pow(2, $f) == pow(2, $f-1)) {
				
					$numero = ++${"numero$finale"};

					if ($finale >= $last_finale) {
					
						// case match winner
						$export .= '<td align="left">
								<table cellspacing="0" cellpadding="0" border="0" width="100%">
								<tr><td class="info" align="center">';						
						$id=id_match_finale('W',$finale,$numero,$s_tournois,$op,$status);
						show_match_finale_exp($id,$op);						
						$export .= "</td>";						
						
						if ($numero %2 == 1 )
							$export .= '<td background="images/arbre_ligneH.gif" style="background-repeat: repeat-x;background-position: bottom;" width=100%><img src="images/spacer.gif"></td>';
						else
							$export .= '<td background="images/arbre_ligneH.gif" style="background-repeat: repeat-x;background-position: top;" width=100%><img src="images/spacer.gif"></td>';

						$export .= '</tr></table>';
						$export .=  '</td>';
						// end case match

						// calcul du tree (et du vaingeur si besoin est)
						if($finale>1) {
							if ($numero %2 == 1 )
								$export .=  '<td background="images/arbre_coinhaut.gif" style="background-repeat: no-repeat;background-position: bottom;"><img src="images/spacer.gif"></td>';
							else 
								$export .= '<td background="images/arbre_coinbas.gif" style="background-repeat: no-repeat;background-position: top;"><img src="images/spacer.gif"></td>';
						}
						elseif($finale==1) {
							if ($modeelimination_tournois=='S') {
								
								$id_finale_winner=id_match_finale('W',1,1,$s_tournois,$op,$status);
															
								if(match_fini($id_finale_winner)) {									
									$equipe_g=equipe_gagnante($id_finale_winner);
									
									$export .= '<td background=images/arbre_ligneH.gif style="background-position: center;"><img src=images/spacer.gif></td>';
									$export .= '<td valign="middle">';
									$export .= '<table cellspacing="2" cellpadding="5" width="100%" border="0" height="30">';
									$export .= '<tr>';
									$export .= '<td class="header" width="120"><img src="images/smallcup.gif" align="absmiddle"> '.$show($equipe_g,$op,'').'</td>';
									$export .= '</tr>';
									$export .= '</table>';
									$export .= '</td>';
								}
							}
							else
								$export .= '<td background="images/arbre_coinhaut.gif" style="background-repeat: no-repeat;background-position: bottom;"><img src="images/spacer.gif"></td>';
						}
						elseif($finale==0) {
						
							$id_grandfinale=id_match_finale('W',0,1,$s_tournois,$op,$status);
															
							if(match_fini($id_grandfinale)) {									
								$equipe_g=equipe_gagnante($id_grandfinale);
								
								$export .= '<td background=images/arbre_ligneH.gif style="background-position: center;"><img src=images/spacer.gif></td>';
								$export .= '<td valign=middle>';
								$export .= '<table cellspacing="2" cellpadding="5" width="100%" border="0" height="30">';
								$export .= '<tr>';
								$export .= '<td class="header" width="120" nowrap><img src="images/smallcup.gif" align="absmiddle"> '.$show($equipe_g,$op,'').'</td>';
								$export .= '</tr>';
								$export .= '</table>';
								$export .= '</td>';
							}										
						}						
					}				
				}
				// case T
				else if(($e) % pow(2, $f+1) == pow(2, $f)) {
					if(!($finale==1 && $modeelimination_tournois=='S')) {
						$export .= '<td align="center"><img src="images/spacer.gif"></td>';
						$export .= '<td align="right" background="images/arbre_ligneV.gif"><img src="images/arbre_T.gif"></td>';
					}
					else {
						$export .= '<td align="center"><img src="images/spacer.gif"></td>';
						$export .= '<td align="center"><img src="images/spacer.gif"></td>';
					}
				}
				// case |
				else if(${"numero$finale"}%2==1) {
					if(!($finale==1 && $modeelimination_tournois=='S')) {
						$export .= '<td height="40" align="center"><img src="images/spacer.gif"></td>';
						$export .= '<td background="images/arbre_ligneV.gif" style="background-repeat: repeat-y;"><img src="images/spacer.gif"></td>';
					}
					else {
						$export .= '<td height="40" align="center"><img src="images/spacer.gif"></td>';
						$export .= '<td height="40" align="center"><img src="images/spacer.gif"></td>';
					}
				}
				// case vide
				else { 
					$export .= '<td align="center" height="40"><img src="images/spacer.gif"></td>'; 
					$export .= '<td align="center" height="40"><img src="images/spacer.gif"></td>'; 
				}			
			}

			// LOOSER			
			else {
			
				// skip des 1ere cases (pour decaler le looser)
				if($finale>$nb_finales_looser_tournois/2) {
					$export .= '<td align="center"><img src="images/spacer.gif"></td>'; 
					$export .= '<td align="center"><img src="images/spacer.gif"></td>';
				}
				else {					
					// changement du referentiel
					$col=log($nb_finales_winner/$nb_finales_looser_tournois)/log(2)+1;
				
					// case pleine looser 
					if(($e-$nb_row_winner) % pow(2, $f-$col) == pow(2, $f-1-$col)) {
						if ($finale >= 1) {
							$numero = ++${"numeroL$finale"};
							$numero2= $numero+$finale;
										
							$export .= '<td align=left>';

							// case match looser 1
							$export .= '<table cellspacing="0" cellpadding="0" border="0" width="100%"><tr>';
							$export .= '<td>';
							$id=id_match_finale('L',$finale,$numero,$s_tournois,$op,$status);
							show_match_finale_exp($id,$op);
							$export .= '</td>';
							// end case match 1

							$export .= '<td valign="bottom"><img src="images/arbre_ligneH2.gif"></td>';

							 // case match looser 2
							$export .= '<td align="left">';
							$id=id_match_finale('L',$finale,$numero2,$s_tournois,$op,$status);
							show_match_finale_exp($id,$op);
							$export .= '</td>';
							
							// end match
							$export .= '</td>';
							if ($numero %2 == 1 )
								$export .= '<td background="images/arbre_ligneH.gif" style="background-repeat: repeat-x;background-position: bottom;" width=100%><img src="images/spacer.gif"></td>';
							else
								$export .= '<td background="images/arbre_ligneH.gif" style="background-repeat: repeat-x;background-position: top;" width=100%><img src="images/spacer.gif"></td>';
							$export .= '</tr></table>';
							// end case match 2
							
							$export .= '</td>';
							// calcul du tree apres un match

							if($finale>1) {
								if ($numero %2 == 1 )
									$export .= '<td background="images/arbre_coinhaut.gif" style="background-repeat: no-repeat;background-position: bottom;"><img src="images/spacer.gif"></td>';
								else 
									$export .= '<td background="images/arbre_coinbas.gif" style="background-repeat: no-repeat;background-position: top;"><img src="images/spacer.gif"></td>';
							}
							else if($finale==1) $export .= '<td background="images/arbre_coinbas.gif" style="background-repeat: no-repeat;background-position: top;"><img src="images/spacer.gif"></td>';
						}			
					}
					// case T
					else if(($e-$nb_row_winner) % pow(2, $f+1-$col) == pow(2, $f-$col)) {
						$export .= '<td height="40" align="center"><img src="images/spacer.gif"></td>';
						$export .= '<td align="right" background="images/arbre_ligneV.gif"><img src="images/arbre_T.gif"></td>';				
					}
					//case |
					else if((${"numeroL$finale"}%2==1 && $finale>1) || (${"numeroL$finale"}%2==0 && $finale==1)) {
						$export .= '<td height="40" align="center"><img src="images/spacer.gif"></td>';
						$export .= '<td background="images/arbre_ligneV.gif" style="background-repeat: repeat-y;"><img src=images/spacer.gif></td>';					
					}
					else { 
						$export .= '<td height="40" align="center"><img src="images/spacer.gif"></td>'; 
						$export .= '<td height="40" align="center"><img src="images/spacer.gif"></td>'; 
					}
				}				
			}

			//$finale /= 2;
			$finale=$finale/2;
		}
	
	$export .= '</table>';
	$export .= '<!-- FIN DE LA GENERATION DE L\'ARBRE -->';

}

//if(!file_exists("export/$s_tournois.php")){
	fwrite( fopen("include/export/f_$s_tournois.html","w"), $export);
   // fclose("export/$s_tournois.php");
	//}else{
	
	//}
	echo '<br><div align=""center>'.$strEXPORT_done.$s_tournois.'.html</div><br><br>'.$strEXPORT_done2.' <br><code>&lt;a href="?page=e&id=f_'.$s_tournois.'"&gt;'.$strEXPORT_name.'&lt;/a&gt;</code><br>';
	//echo $export;
?>

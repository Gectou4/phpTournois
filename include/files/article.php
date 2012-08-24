<?php
/*
   +---------------------------------------------------------------------+
   | page : article.php                                                  |
   | phpTournois ADDONS | Module name : "aricles & commandes" V 4.0      |
   | MOD Author : Gectou4 <Gectou4@hotmail.com>                 |
   +---------------------------------------------------------------------+
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

 if (eregi("article.php", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}

 	  global $config,$s_joueur,$s_theme,$db,$dbprefix,$db,$dbprefix;
 	  $pseudodrr=''.nom_joueur($s_joueur).'';
	


?>
<script language="JavaScript" type="text/JavaScript">
<!--
function unsee()
{
but.style.visibility="hidden"
-->
}

</script>
	
	<?php 
	echo'<p align="center"><br><b><img src="images/G4/pizza.jpg" border="0" width="300" height="200"><br>';
  	echo "$strAc_tuveupi";
	echo'</b></p>';

/////////////////////////Reception des MAJ//////////////////////////////

//-----// Enregistrement commande Joueur
	
	if ($_POST['commandes'] == "oui") 
	{
	$article_pseudo=''.nom_joueur($s_joueur).'';
	if ($article_pseudo != "")
	{
	$c_id=$_POST['commandearticle']; 
	$sqlc3 = "SELECT id FROM ${dbprefix}joueurs WHERE pseudo='$article_pseudo'";
	$reqc3 = mysql_query($sqlc3) or die('Erreur SQL !<br>'.$sqlc3.'<br>'.mysql_error());
	while($datacid3 = mysql_fetch_array($reqc3)) 
   	 				{$idj = $datacid3['id'];}
	$sqlc2 = "SELECT article_config FROM ${dbprefix}config";
	$reqc2 = mysql_query($sqlc2) or die('Erreur SQL !<br>'.$sqlc2.'<br>'.mysql_error());
	while($datacid = mysql_fetch_array($reqc2)) 
   	 				{$cid = $datacid['article_config'];}
	$sqlc = "SELECT * FROM ${dbprefix}listarticle WHERE id='$c_id'"; 
	$reqc = mysql_query($sqlc) or die('Erreur SQL !<br>'.$sqlc.'<br>'.mysql_error());
	while($datac = mysql_fetch_array($reqc)) 
   	 				{
					$article_id = $datac['id'];
					$article_article = $datac['article'];
					$article_ingred = $datac['ingred'];
					$article_prix = $datac['prix'];
					}	
	$db->insert ("${dbprefix}article (article, pseudo, regle, arrive, ingred, prix, cid, idj)");
	$db->values("'$article_article','$article_pseudo','N','N','$article_ingred','$article_prix','$cid', '$idj'");
	$db->exec();
	
		
		
		echo '<br></p>';
		echo '<table width="309" border=0 cellpadding=0 cellspacing=15 bordercolor="#669900">';
      	echo '<tr> ';
    	
     	echo '<td width="300" align="center" bgcolor="#CCFFCC" class=text style="border: 3px dashed"><b>'; 
        echo '<font color="#009900">';
		echo "$strAc_comvalide";
		echo '</font></b></td></tr></table><br><br>';

	}
	}

//---------- ANNULER article ---------
		

		
	if ($_GET['del'] != "") 
	{
	$del_pseudo=''.nom_joueur($s_joueur).'';
	if ($del_pseudo != "")
	{
 	$del_id = $_GET['del'];
	$sqldel = "DELETE FROM `${dbprefix}article` WHERE id='$del_id'"; 
	$reqdel = mysql_query($sqldel) or die('Erreur SQL !<br>'.$sqldel.'<br>'.mysql_error());
	//exec(reqdel);
	
	
	echo '<br><table width="318" border=0 cellpadding=0 cellspacing=15><tr> ';
 	echo '<td width="300" align="center" bgcolor="#CCFFCC" class=text style="border: 3px dashed"><b> ';
    echo '<font color="#990000">';
	echo "$strAc_comannulee";
	echo '</font></b></td>';
	echo '</tr>';
	echo '</table><br><br>';
	
	}
	}
	
/////////////////////////END Reception des MAJ//////////////////////////////

/********************************************************
 * Commande de article !!!
 */
//----------------------------------------------- 
	// commander une article 
	
	//-----// Formulaire
	$db->select("*");
	$db->from("${dbprefix}listarticle");
	$db->order_by('prix');
	$res=$db->exec();
	 
	//////////////////////////////////////////////////////////////////////////////////////////////////////
		$sqlst = "SELECT article FROM ${dbprefix}config"; 
		$reqst = mysql_query($sqlst) or die('Erreur SQL !<br>'.$sqlst.'<br>'.mysql_error());
	while($datast = mysql_fetch_array($reqst)) {$status=$datast['article'];}
	if ($status == "on") { $s_test="on";
	
	
	
	
	if ($pseudodrr!=""){
		echo '<div id="but"><form action="?page=article" method="post" enctype="multipart/form-data" name="formx">';
		echo '<p>';
		echo '<select name="commandearticle">';
    
	if ($_POST['commandes'] == "oui") 
	{echo '<font color="navy"><b>'; echo "$strAc_again";
	}else{
	echo '<font color="blue"><b>'; echo "$strAc_noagain";
	} 
	
	while($data = mysql_fetch_array($res)) 
   	 				{
      echo '<option value="'.$data['id'].'">'.$data['article'].' - '.$data['ingred'].' - '.$data['prix'].'€</option>';
   				 } 
	  echo '</select>';
	  echo '<input type="hidden" name="commandes" value="oui">';
	  echo '<input type="submit" value="';
	  echo "$strAc_commander";
	  echo '" onclik="javascript:unsee()"></from>';
	  echo '</b></font></div>';
 
		}				
	}else if ($status=="off"){ $s_test="off";  
	
	echo '<br><br><center><table width="509" border=0 cellpadding=0 cellspacing=15 bordercolor="#669900"><tr>';	
    echo '<td width="500" align="center" bgcolor="#CCFFCC" class=text style="border: 3px dashed"><p>&nbsp;</p>';
    echo ' <p><b><font color="#FF0000">';
	echo "$strAc_notactive";
	echo '</font></b></p>';
    echo '<p><b><font color="#FF0000">';
	echo "$strAc_nottime";
	echo '</font></b></p>';
    echo '<p><b><font color="#FF0000">';
	echo "$strAc_smilies";
	echo '</font></b></p>';
    echo '<p>&nbsp;</p></td></tr>';
	echo '</table><br><br></center>';
	
}else if ($status=="ok"){ $s_test="ok"; 

		echo '<br><br><center><table width="509" border=0 cellpadding=0 cellspacing=15 bordercolor="#669900">';
    	echo '<tr> <td width="500" align="center" bgcolor="#CCFFCC" class=text style="border: 3px dashed"><p>&nbsp;</p>';
        echo '<p><b><font color="#009900">';
		echo "$strAc_cmddejapass";
		echo '<br>';
        echo "$strAc_wewait";
		echo '<br>';
		echo "$strAc_nolatetotakeit";
		echo '<br>';
        echo "$strAc_nocmdactual";
		echo '</font></b>-</p><p>&nbsp;</p></td>';
	    echo '</tr></table><br><br></center>';

}
			
 //-----------------------------------------------
 //-----------------------------------------------
 //--D&eacute;ja commander ?
	
	echo '<br><p>';
	echo '<table width="461" border="1" cellpadding="1">';
  	echo '<tr bordercolor="#000000" bgcolor="#000033"> ';
    echo '<td colspan="3"> <div align="center"><font color="#FFFFFF"><b>';
	echo "$strAc_pannier";
	echo '</b></font></div></td>';
  	echo '</tr>';
  	echo '<tr bordercolor="#000000" bgcolor="#999999">'; 
    echo '<td width="399"> <div align="center"><font color="#FFFFFF"><b>';
	echo "$strAc_arti";
	echo '</b></font></div></td>';
    echo '<td width="40"> <div align="center"><font color="#FFFFFF"><b>';
	echo "$strAc_euro";
	echo '</b></font></div></td>';
    echo '<td width="40" valign="middle" align="center">';
	echo "$strAc_jecpukoimettre";
	echo '</td>';	
  	echo '</tr></form>';
   
		$sqln12 = "SELECT article_config FROM ${dbprefix}config"; 
		$reqn12 = mysql_query($sqln12) or die('Erreur SQL !<br>'.$sqln12.'<br>'.mysql_error());
		while($datad12 = mysql_fetch_array($reqn12)) 
   	 				{$ccid = $datad12['article_config'];}
	
		$sqln = "SELECT * FROM ${dbprefix}article ORDER BY id"; 
		$reqn = mysql_query($sqln) or die('Erreur SQL !<br>'.$sqln.'<br>'.mysql_error());
	$i=0;
	$ok="no";
	while($datad = mysql_fetch_array($reqn)) 
   	 				{
					$i++;
					$did = $datad['id'];
					$tcid = $datad['cid'];
					$name_article = $datad['article'];
					$pseudo_test = $datad['pseudo'];
					if ($tcid < $ccid) {$passer ="o";}
				
					
					if ($pseudo_test == $pseudodrr) 
						{
						
						// article commander pas payer pas arriver
									 
								
						//=> commande pas passer
						if ($datad['regle'] == "N" AND $datad['arrive'] == "N") {
	
							print ('<tr><td width="399" valign="middle">'.$datad['article'].' - '.$datad['ingred'].'');
							
							if ($passer != "O"){
							
							print('</td>
							<td width="40"><div align="center">'.$datad['prix'].'</div></td>
							<td width="40" valign="middle" align="center"><a href="?page=article&del='.$did.'');
							if($ad_ok=='ok'){echo"&op=admin";}
							print('"> 
							<img src="images/G4/non.gif" alt="'.$strAC_annulercommande.'" border="0"><img alt="'.$strAC_annulercommande.'" src="images/G4/non.gif" border="0"></a></div> 
							</form></td></tr>');
							}
							//=> commande passer
							else if ($passer == "O"){print('<br><font color="red" size="-1"><center><b>commande N°'.$tcid.'</b></center></font></td>
							<td width="40"><div align="center">'.$datad['prix'].'</div></td>
							<td width="40" valign="middle" align="center"><img src="images/G4/non.gif" alt="'.$strAC_impossibleannuler.'" border="0"><img alt="'.$strAC_impossibleannuler.'" src="images/G4/non.gif" border="0"></div>						  </td></tr>'); 
							}
							$ok="ok";
							
							
						// article commander payer pas arriver
									
																	 
						}if($datad['regle'] == "O" AND $datad['arrive'] == "N") {
								print ('<tr><td width="399" valign="middle">'.$datad['article'].' - '.$datad['ingred'].' <br><center><font size="-1" color="green">- '.$strAC_regle.' - '.$strAC_Attentede.' '.$strAc_cmdnum.''.$tcid.'</font><center></td><td width="40"><div align="center">'.$strAC_regle.'</div></td> 
								<td width="40" valign="middle" align="center"><img alt="'.$strAC_commandepaye.'" src="images/G4/ok.gif" border="0"><img alt="'.$strAC_commandepasarrivee.'" src="images/G4/non.gif" border="0"></td></tr>');
							
							$ok="ok";
						
						// article commander payer arriver
									//alert('message')
									//=> ok
						}if($datad['regle'] == "O" AND $datad['arrive'] == "O") {
							
							print ('<tr><td width="399" valign="middle"><b><font color="red">'.$strAC_livre.' : </font></b>'.$datad['article'].' - '.$datad['ingred'].'</td>
							<td width="40"><div align="center">'.$strAC_regle.'</div></td>
							<td width="40" valign="middle" align="center"><a href="?page=article&del='.$did.'');
							if($ad_ok=='ok'){echo"&op=admin";}
							print('"><img src="images/G4/ok.gif" alt="'.$strAC_merci.'" border="0"><img src="images/G4/ok.gif" alt="'.$strAC_merci.'" border="0"></a></div></td></tr>');
							$ok="ok";
							
						// article commander pas payer arriver
									
						//=> commande passer
						}if ($datad['regle'] == "N" AND $datad['arrive'] == "O") {
							
							print ('<tr><td width="399" valign="middle">'.$datad['article'].' - '.$datad['ingred'].'
							<br><center><font color="red" size="-1"><b>'.$strAC_articlearrivee.'</b></font></td>
							<td width="40"><div align="center">'.$datad['prix'].'</div></td>
							<td width="40" valign="middle" align="center"><img alt="'.$strAC_commandepaspaye.'" src="images/G4/non.gif" border="0"><img alt="'.$strAC_commandearrivee.'" src="images/G4/ok.gif" border="0"></div>
						  	</td>
 							</tr>');
							$ok="ok"; 
							}
							
						}// end if
					
					}//en while 1
					if ($ok != "ok") {
						echo '<tr>';
						echo '<td width="399"> <div align="center"><font color="red"><b>'; 
						if ($pseudodrr=="")
							{
							echo "$strAc_youneedloginfirst";
							}else{
							echo "$strAc_nocmdsry";
							}
						echo '</b></font></div></td>';
						echo '<td width="46"> <div align="center">&iquest;</div></td>';
						echo '<td width="40" align="center">-</td></tr>';
 							} 
						echo '</table>';
						echo '<font size="-2"><em>"<font color="#FF0000">';
						echo "$strAc_artfin";

	//////////////////////////ADMIN
		//$sqla = "SELECT admin FROM ${dbprefix}joueurs WHERE pseudo='$pseudodrr'"; 
		//$reqa = mysql_query($sqla) or die('Erreur SQL !<br>'.$sqla.'<br>'.mysql_error());
		//while($dataa = mysql_fetch_array($reqa)) 
   	 	//{$admin=$dataa['admin'];}
	/*** verification securite ***/
	if ($grade['a']=='a'||$grade['b']=='b') {
	//if ($admin=="O")
	//{
	echo '<br><br><a href="?page=ac_spe&op=admin"><b>- ';
	echo "$strAc_youareadmin";
	echo ' -</b></a><br><br>';
	}					
	?>





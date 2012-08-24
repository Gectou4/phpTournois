<?php
/*
   +---------------------------------------------------------------------+
   | phpTournois                                                         |
   +---------------------------------------------------------------------+
   +---------------------------------------------------------------------+
   | phpTournoisG4 ©2005 by Gectou4 <Gectou4 Gectou4@hotmail.com>        |
   +---------------------------------------------------------------------+
         This version is based on phpTournois 3.5 realased by :
   | Copyright(c) 2001-2004 Li0n, RV, Gougou (http://www.phptournois.com)|
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
   | Authors: Li0n  <li0n@phptournois.com>                               |
   |          RV <rv@phptournois.com>                                    |
   |          Gougou                                                     |
   +---------------------------------------------------------------------+
*/

/*
   +---------------------------------------------------------------------------------------------------------------+
   |  Modifications par  JT-tronix <JT-tronix JT-tronix@hotmail.com>  01/01/06-21:00                               |
   +---------------------------------------------------------------------------------------------------------------+
   | 30/12/05 => ligne 5060 : virgule manquante                                                                    |
   | 31/12/05 => ligne 1924 : 'status' remplacer par 'valide' dans les criteres de selections                      |
   | 31/12/05 => correction du bug du ladder fermé après sa création                                               |
   | 31/12/05 => correction du bug des maps supprimée lors d'une modification du ladder                            |
   | 01/01/06 => cocher/decocher les cases round/manche/frags si elles étaient utilisée                            |
   | 01/01/06 => correction du bug qui empechait la modification des points gagnés/perdus                          |
   | 01/01/06 => correction du bug des dates et des heures de choix du matchs : minutes                            |
   |                       commence à 00 et fini à 59 (au lieu de 01 et 60 avant), modification du                 |
   |                       code entier, il n'y a plus la date immédiate mise en premier et selectionné,            |
   |                       mais elle est toujours selectionnées, mais dans l'ordre de la liste.                    |
   |                      + autres corrections mineures sur la date                                                |
   | 01/01/06 => correction du bug des minutes qui ne pouvait être '00'                                            |
   +---------------------------------------------------------------------------------------------------------------+
*/
/*
   +---------------------------------------------------------------------------------------------------------------+
   |  Modifications par  W@RRIOR <pccg_warrior@hotmail.com>  09/09/08                                              |
   +---------------------------------------------------------------------------------------------------------------+
   | 22/03/08 => Ajout de requete et modification de l'affichage des joeurs et team dans le ladder  pour travailler|                                                                   |
   |             avec des id et non le champ name                                                                  |
   | 25/03/08 => correction de l'affichage satus des matchs du ladder afin qu'il affiche ceux de la team/joueurs   |
   | 09/09/08 => Correction de la requete de selection  pour le calcul du classement, elle reprener tous les ladder|
   |             et non le ladde courant                                                                           |
   +---------------------------------------------------------------------------------------------------------------+
*/

if (eregi("ladder.php", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}


//
// ################# [  ADMIN ]  ################
//
if ($op=="admin" && ($grade['a']!='a'&&$grade['b']!='b'&&$grade['u']!='u')) {js_goto('?page=login');} 
if ($ad=="ad" && ($grade['a']!='a'&&$grade['b']!='b'&&$grade['u']!='u')) {js_goto('?page=login');} 
//
// Ajout d'un ladder
//
if ($op == "add_lad") {

if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['u']!='u') {js_goto('?page=login');} 

	echo '
	<form method="post" name="formulaire" id="formulaire" action="?page=ladder&op=do_add_lad">
	
	<table border="0" cellpadding="0" cellspacing="0" class="bordure2">
	<tr>
		<td>
			<table cellspacing="1" cellpadding="0" border="0" width="100%">';
			
			/////
			echo '<tr>
					<td class="modsfiche">&nbsp; '.$strMODAddlad.' &nbsp;</td>
				</tr>
				<tr>
					<td>
						<table cellspacing="0" cellpadding="2" border="0" width="100%">';
	

							/*** name ***/
							echo '<tr>
									<td class="titlefiche">'.$strLadName.' :</td>
									<td class="textfiche"><input type="text" name="ladder_name" id="ladder_name" maxlength="40"></td>';
	
							/*** Jeux ***/
									echo '
									<td class="titlefiche">'.$strLadjeux.' :</td>
									<td class="textfiche">
									<select name="jeux" id="jeux">';
									$fd = opendir("images/jeux");
									while($file = readdir($fd)) {
										if ($file != "." && $file != "..") {			
											echo "<option value=\"$file\">$file";
										}
									}
									echo "</select>";
									closedir($fd);
									echo "</td>";
			
									/*** type ***/
									echo '
									<td class="titlefiche">'.$strLadType.' :</td>
									<td class="textfiche">
									<select name="ladder_type" id="ladder_type">
									<option value="1">'.$strJoueur.'</option>
									<option value="2">'.$strEquipe.'</option>
									</select>
									</td>
								</tr>';

	
	
							echo '<tr>
									<td class="titlefiche">'.$strLadDefpts.' :</td>
									<td class="textfiche"><input type="text" name="def_pts" id=def_pts" value="1000"></td>

									<td class="titlefiche">'.$strLadpourcent.' :</td>
									<td class="textfiche"><input type="text" size="3" name="pourcent" id="pourcent" value="0">
									<select name="pourcent_type" id="pourcent_type">
									<option value="1">'.$strOui.'</option>
									<option value="0">'.$strNon.'</option>
									</select>
									</td>
	
									<td class="titlefiche">'.$strLadMaps.' :</td>
									<td class="textfiche">
									<select name="maps" id="maps">
									<option value="0">'.$strNon.'</option>
									<option value="1">'.$strOui.'</option>
									</select>
									</td>
								</tr>';
	
					



					echo '
								<tr>
								<td class="titlefiche"  align="right">'.$strMail.' :</td>
									<td class="textfiche" align="left" ><select id="mail" name="mail">
									<option value="1" selected>'.$strOui.'</option>
									<option value="0">'.$strNon.'</option>
									</select>
									
									</td>
									<td class="titlefiche"  align="right">'.$strLadclosemode.' :</td>
									<td class="textfiche" align="left" colspan="3"><select name="close">
									<option value="0" selected>'.$strLadopen.'</option>
									<option value="1">'.$strLadclose.'</option>
									</select>
									<input type="button" value="'.$strAdminMaps.'" onclick="document.location=\'?page=ladder&op=maps&oldop='.$op.'&lad_id='.$lad_id.'\';" />
									
									</td>
								</tr>
						</table>
					</td>
				</tr>';
echo '<tr><td class="headerfiche">'.$strLAD_fact.'</td></tr><tr><td>
	<table cellspacing="0" cellpadding="3" border="0" width="100%">
	
	
	<tr>
	<td class="titlefiche">Point de round :</td>
	<td class="textfiche"><input type="checkbox" value="1" id="s_round" name="s_round" onclick="javascript:if(this.checked==true){document.formulaire.f_round_win.disabled=false;document.formulaire.f_round_loose.disabled=false;}else{document.formulaire.s_manche.checked=false;document.formulaire.f_round_win.disabled=true;document.formulaire.f_round_loose.disabled=true;document.formulaire.f_manche_win.disabled=true;document.formulaire.f_manche_loose.disabled=true;document.formulaire.f_manche_null.disabled=true;}" /></td>
	<td class="titlefiche">Point round gagner :</td>
	<td class="textfiche"><input type="text" name="f_round_win" id="f_round_win" size="1" value="3" disabled/></td>
	<td class="titlefiche">Point round perdu :</td>
	<td class="textfiche"><input type="text" name="f_round_loose"  id="f_round_loose" size="1" value="-3" disabled/></td>
	</td></tr>
	
	<tr>
	<td class="titlefiche">Point de frag :</td>
	<td class="textfiche"><input type="checkbox" value="1" name="s_frag" id="s_frag" onclick="javascript:if(this.checked==true){document.formulaire.f_frag_win.disabled=false;document.formulaire.f_frag_loose.disabled=false;}else{document.formulaire.f_frag_win.disabled=true;document.formulaire.f_frag_loose.disabled=true;}" /></td>
	<td class="titlefiche">Point de frag :</td>
	<td class="textfiche"><input type="text" name="f_frag_win" size="1" value="1" id="f_frag_win" disabled/></td>
	<td class="titlefiche">Point de death :</td>
	<td class="textfiche"><input type="text" name="f_frag_loose" size="1" value="-1"  id="f_frag_loose" disabled/>
	</td></tr>
	
	<tr>
	<td class="titlefiche">Point de Manche :</td>
	<td class="textfiche"><input type="checkbox" value="1" name="s_manche" id="s_manche" onclick="javascript:if(this.checked==true){document.formulaire.s_round.checked=true;document.formulaire.f_manche_win.disabled=false;document.formulaire.f_manche_loose.disabled=false;document.formulaire.f_manche_null.disabled=false;document.formulaire.f_round_win.disabled=false;document.formulaire.f_round_loose.disabled=false;}else{document.formulaire.f_manche_win.disabled=true;document.formulaire.f_manche_loose.disabled=true;document.formulaire.f_manche_null.disabled=true;}" />
	<td class="titlefiche" colspan="4" >Point de victoire : <input type="text" id="f_manche_win" name="f_manche_win" size="1" value="5" disabled/>
	&nbsp;&nbsp;Point de défaite :
	<input type="text" name="f_manche_loose" id="f_manche_loose" size="1" value="-5" disabled/>
	&nbsp;&nbsp;Point de null :
	<input type="text" name="f_manche_null" size="1" id="f_manche_null" value="1" disabled/>&nbsp;&nbsp;
	</td>
	
	</td></tr>
	
	</table></td></tr>
	';
			echo '
				<tr>
					<td class="headerfiche">'.$strRegLad.'</td>
				</tr>
				<tr>
					<td>
						<table cellspacing="0" cellpadding="3" border="0" width="100%">
							<tr>
								<td class="textfiche" colspan="2" align="center">';buttonBB('reglement');echo '</td>
								</tr>
							<tr>
								<td colspan="2" class="textfiche" align="center"><textarea cols="80" rows="10" name="reglement" ID="reglement" wrap="virtual" ONSELECT="storeCaret(this);" ONCLICK="storeCaret(this);" ONKEYUP="storeCaret(this);"></textarea></td>
							</tr>
							<tr>
								<td class="footerfiche" colspan="2" align="center"><input type="submit" value="'.$strAjouter.'"></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	</table>
	</form>';
	
	show_consignes($strLadderADD);
}
//
//  Requete d'ajout du ladder
//
else if ($op == "do_add_lad") {
if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['u']!='u') {js_goto('?page=login');}  
	
	$str='';
	$erreur=0;
	
	/*$db->select("ladder_name");
	$db->from("${dbprefix}ladder_data WHERE ladder_name='$ladder_name'");
	$db->exec();
	$lad_mod=$db->fetch();
	
	if ($lad_mod->ladder_name==$ladder_name) {
	$erreur=1;
	$str=$strLadalreadyexist;
	}*/
	
	if (!$ladder_name) {
	$erreur=1;
	$str=$strLad_needname;
	}
	if (!$reglement) {
	$erreur=1;
	$str=$strLad_needrules;
	}
	
	if($erreur==1) {		
		show_erreur_saisie($str);			
	}
	else {		
		  	
		$db->insert("${dbprefix}ladder_data (id,ladder_name,ladder_type,jeux,reglement,pourcent,maps,def_pts,pourcent_type,close,s_manche,s_round,s_frag,f_round_win,f_round_loose,f_frag_win,f_frag_loose,f_manche_win,f_manche_loose,f_manche_null,mail)");
		$db->values("'','$ladder_name','$ladder_type','$jeux','$reglement','$pourcent','$maps','$def_pts','$pourcent_type','$close','$s_manche','$s_round','$s_frag','$f_round_win','$f_round_loose','$f_frag_win','$f_frag_loose','$f_manche_win','$f_manche_loose','$f_manche_null','$mail'");
		$db->exec();
		
		/*** redirection ***/
		js_goto("?page=ladder");
	}

}
//
// Admin fait un match
//
else if ($op == "admin_versus") {
if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['u']!='u') {js_goto('?page=login');} 
			$name='Admin';
			
			$rapport_end='
			'.$rapport.'<hr>Log date: '.strftime(DATESTRING1, $date).'
			'.$strJoueur.' : '.$name.' '.$strLAD_is_imp.' 
			<hr>';
			
		$date_up=time();
		
		
		if($type_lad == '2'){
					$db->select("t1_id");
					$db->from("${dbprefix}lad_part WHERE ladder_id='$lad_id' AND joueur_id ='$j1v'");
					$db->exec();
					$lad_t1=$db->fetch();
					
					$db->select("t1_id");
					$db->from("${dbprefix}lad_part WHERE ladder_id='$lad_id' AND joueur_id ='$j1v'");
					$db->exec();
					$lad_t2=$db->fetch();
					
					$t1_id=$lad_t1->t1_id;
					$t2_id=$lad_t2->t2_id;
		}else{
		$t1_id='';
		$t2_id='';
		}
								$nb_manche_d=sizeof($maps);
								for($i=0;$i<sizeof($maps);$i++) 
										{ 
											
											if ($i < sizeof($maps)-1) {
											$map_s .=$maps[$i].',';
											} else {
											$map_s .=$maps[$i];
											}
											
										}	
			
			$date_match=$j.'/'.$m.'/'.$a.'-'.$h.':'.$min;
			$date_x=$a.$m.$j.$h.$min;
			$date=time();
			
			if ($server) {$server=remove_XSS($server);}else{$server="/";}
			if (!$map_s) {$map_s="/";}
		
		
		$db->insert("${dbprefix}ladder_match (rapport,valide,date_up,j1,j2,t1_id,t2_id,maps,date,date_x,server,ladder_id,manche)");
		$db->values("'$rapport_end','B','$date','$j1v','$j2v','$t1_id','$t2_id','$map_s','$date_match','$date_x','$server','$lad_id','$nb_manche_d'");
		$db->exec();
		
		$db->insert("${dbprefix}messages (emetteur,destinataire,titre,message,date)");
		$db->values("'$j1v','$j2v','Ladder : $strLAD_incom2 ','$rapport_end','$date'");
		$db->exec();
		
		$db->insert("${dbprefix}messages (emetteur,destinataire,titre,message,date)");
		$db->values("'$j2v','$j1v','Ladder : $strLAD_incom2 ','$rapport_end','$date'");
		$db->exec();
		
		
		
		
		$db->select("mail");
		$db->from("${dbprefix}ladder_data");
		$db->where("id = '$lad_id'");
		$db->exec();
		$lad_while=$db->fetch();
		
		/*** génération de l'email de confirmation ***/
		if ($lad_while->mail) {
		
		if($type_lad == '1') {
		$db->select("email");
		$db->from("${dbprefix}joueurs");
		$db->where("id = '$j1v'");
		$db->exec();
		$lad_j1=$db->fetch();
		$email1=$lad_j1->email;
		
		$db->select("email");
		$db->from("${dbprefix}joueurs");
		$db->where("id = '$j2v'");
		$db->exec();
		$lad_j2=$db->fetch();
		$email2=$lad_j2->email;
		
		}else{
		$db->select("email");
		$db->from("${dbprefix}equipes");
		$db->where("manager = '$j1v'");
		$db->exec();
		$lad_j1=$db->fetch();
		$email1=$lad_j1->email;
		
		$db->select("email");
		$db->from("${dbprefix}equipes");
		$db->where("manager = '$j2v'");
		$db->exec();
		$lad_j2=$db->fetch();
		$email2=$lad_j2->email;
		}
		
		$link="<a href=\"".$config['urlsite']."/?page=laddder&op=agree&lad_id=".$lad_id."&m_id=".$m_id."\" target=\"_blank\">".$config['urlsite']."/?page=laddder&op=agree&lad_id=".$lad_id."&m_id=".$m_id."</a>";
		
			$to = $email2;
			$from = $config['nomsite'];
			$subject = $strLAD_incom2;
			$body = $rapport_end;

			$mail = new phpTMailer();
			$mail->From = $from;
			$mail->FromName = "";
			$mail->AddAddress($to);
			$mail->Subject = $subject;
			$mail->Body = $body;
			
			$to = $email1;

			$mail = new phpTMailer();
			$mail->From = $from;
			$mail->FromName = "";
			$mail->AddAddress($to);
			$mail->Subject = $subject;
			$mail->Body = $body;
		}
		
		/*** redirection ***/
		js_goto("?page=ladder&lad_id=$id");

}
//
// Tableau de MAJ d'un ladder
//
else if ($op == "mod_lad") {

if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['u']!='u') {js_goto('?page=login');} 

	$db->select("*");
	$db->from("${dbprefix}ladder_data WHERE id='$lad_id'");
	$db->exec();
	$lad_mod=$db->fetch();
	
	echo $strLAD_impose;
	if ($lad_mod->ladder_type == '1') {
					
					$db->select("*");
					$db->from("${dbprefix}lad_part WHERE ladder_id='$lad_id'");
					$res=$db->exec();
					
					$db->select("*");
					$db->from("${dbprefix}lad_part WHERE ladder_id='$lad_id'");
					$res2=$db->exec();
					
					echo '<hr><form method="post" name="formulaire1" action="?page=ladder&op=admin_versus&lad_id='.$lad_id.'">';
					
					echo '<select name="j1v">';
					while ($lad_w=$db->fetch($res)){
					
					echo '<option value="'.$lad_w->joueur_id.'">'.nom_joueur($lad_w->joueur_id).'</option>';
					
					}
					echo '</select>&nbsp;-&nbsp;';
					echo '<select name="j2v">';
					while ($lad_w2=$db->fetch($res2)){
					
					echo '<option value="'.$lad_w2->joueur_id.'">'.nom_joueur($lad_w2->joueur_id).'</option>';
	
					}
					echo '</select><br>'.$strDate.'
					
					<select name="j">';
for($i=1;$i<32;$i++) 
{ 	
	if($i==date("d"))$select='selected';else $select='';	
	if($i<10)										
	echo '<option value="0'.$i.'" '.$select.'>0'.$i.'</option>';
	else
	echo '<option value="'.$i.'" '.$select.'>'.$i.'</option>';
}
echo '
</select>/ 
<select name="m">';
for($i=1;$i<13;$i++) 
{ 	
	if($i==date("m"))$select='selected';else $select='';	
	if($i<10)										
	echo '<option value="0'.$i.'" '.$select.'>0'.$i.'</option>';
	else
	echo '<option value="'.$i.'" '.$select.'>'.$i.'</option>';
}
echo '
</select>/
<select name="a">';
for($i=0;$i<100;$i++) 
{ 	
	if($i==date("y"))$select='selected';else $select='';	
	if($i<10)										
	echo '<option value="0'.$i.'" '.$select.'>0'.$i.'</option>';
	else
	echo '<option value="'.$i.'" '.$select.'>'.$i.'</option>';
}
echo '
</select> - <select name="h">';
for($i=0;$i<24;$i++) 
{ 	
	if($i==date("H"))$select='selected';else $select='';
	if($i<10)
	echo '<option value="0'.$i.'" '.$select.'>0'.$i.'</option>';
	else
	echo '<option value="'.$i.'" '.$select.'>'.$i.'</option>';										
}
echo '
</select> : <select name="min">';
for($i=0;$i<60;$i++) 
{ 	
	if($i==date("i"))$select='selected';else $select='';
	if($i<10)
	echo '<option value="0'.$i.'" '.$select.'>0'.$i.'</option>';
	else
	echo '<option value="'.$i.'" '.$select.'>'.$i.'</option>';										
}
								  echo '</select> '.$strServeur.' <input type="text" name="server" id="server" value="xxx.xxx.xxx.xxx:yyyyy" onclick="javascript:this.value=\'\';"><br>
					
					<input type="hidden" name="type_lad" value="1"><input type="submit" value="'.$strValider.'">';
					echo '</form><hr>';
					
	}else{
	
					$db->select("*");
					$db->from("${dbprefix}lad_part WHERE ladder_id='$lad_id'");
					$res=$db->exec();
					
					echo '<hr><form method="post" name="formulaire1" action="?page=ladder&op=admin_versus&lad_id='.$lad_id.'">';
					
					echo '<select name="j1v">';
					while ($lad_w=$db->fetch($res)){
					
					echo '<option value="'.$lad_w->joueur_id.'">'.nom_equipe($lad_w->teamid).'</option>';
					
					}
					echo '</select>';
					echo '<select name="j2v">';
					while ($lad_w=$db->fetch($res)){
					
					echo '<option value="'.$lad_w->joueur_id.'">'.nom_equipe($lad_w->teamid).'</option>';
					
					}
					echo '</select>';
					echo '<br>'.$strDate.'
					<select name="j">';
for($i=1;$i<32;$i++) 
{ 	
	if($i==date("d"))$select='selected';else $select='';	
	if($i<10)										
	echo '<option value="0'.$i.'" '.$select.'>0'.$i.'</option>';
	else
	echo '<option value="'.$i.'" '.$select.'>'.$i.'</option>';
}
echo '
</select>/ 
<select name="m">';
for($i=1;$i<13;$i++) 
{ 	
	if($i==date("m"))$select='selected';else $select='';	
	if($i<10)										
	echo '<option value="0'.$i.'" '.$select.'>0'.$i.'</option>';
	else
	echo '<option value="'.$i.'" '.$select.'>'.$i.'</option>';
}
echo '
</select>/
<select name="a">';
for($i=0;$i<100;$i++) 
{ 	
	if($i==date("y"))$select='selected';else $select='';	
	if($i<10)										
	echo '<option value="0'.$i.'" '.$select.'>0'.$i.'</option>';
	else
	echo '<option value="'.$i.'" '.$select.'>'.$i.'</option>';
}
echo '
</select> - <select name="h">';
for($i=0;$i<24;$i++) 
{ 	
	if($i==date("H"))$select='selected';else $select='';
	if($i<10)
	echo '<option value="0'.$i.'" '.$select.'>0'.$i.'</option>';
	else
	echo '<option value="'.$i.'" '.$select.'>'.$i.'</option>';										
}
echo '
</select> : <select name="min">';
for($i=0;$i<60;$i++) 
{ 	
	if($i==date("i"))$select='selected';else $select='';
	if($i<10)
	echo '<option value="0'.$i.'" '.$select.'>0'.$i.'</option>';
	else
	echo '<option value="'.$i.'" '.$select.'>'.$i.'</option>';										
}			
								  echo '</select>'.$strServeur.' <input type="text" name="server" id="server" value="xxx.xxx.xxx.xxx:yyyyy" onclick="javascript:this.value=\'\';"><br>
					
					<input type="hidden" name="type_lad" value="2"><input type="submit" value="'.$strOK.'"></form><hr>';
	}

	echo '<form method="post" name="formulaire" action="?page=ladder&op=do_mod_lad">
	
	<table border="0" cellpadding="0" cellspacing="0" class="bordure2"><tr><td>
	<table cellspacing="1" cellpadding="0" border="0" width="100%">';
			
	/////
	echo '<tr><td class="modsfiche">&nbsp; '.$strLadNameMod.' &nbsp;</td></tr>
	<tr>
		<td>
	
		<table cellspacing="0" cellpadding="2" border="0" width="100%">';
		
		/*** name ***/
			echo '
			<tr>
				<td class="titlefiche">'.$strLadName.' :</td>
				<td class="textfiche"><input type="text" name="ladder_name" maxlength="40" value="'.$lad_mod->ladder_name.'">
					<input type="hidden" name="id" value="'.$lad_id.'">
				</td>';
		
			/*** Jeux ***/
			echo '
				<td class="titlefiche">'.$strLadjeux.' :</td>
				<td class="textfiche">
					<select name="jeux">';
					echo "<option value=\"".$lad_mod->jeux."\" selected>".$lad_mod->jeux."</option>";
					$fd = opendir("images/jeux");
					while($file = readdir($fd)) {
						if ($file != "." && $file != "..") {			
							echo "<option value=\"$file\">$file";
						}
					}
					echo "</select>";
					closedir($fd);
				echo "</td>";
			
			/*** type ***/
			echo '
				<td class="titlefiche">'.$strLadType.' :</td>
				<td class="textfiche">
					<select name="ladder_type">';
					if ($lad_mod->ladder_type=="1") {echo "<option value=\"1\" selected>$strJoueur</option>";}
					else if ($lad_mod->ladder_type=="2") {echo "<option value=\"2\" selected>$strEquipe</option>";}
					echo '
					<option value="1">'.$strJoueur.'</option>
					<option value="2">'.$strEquipe.'</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td class="titlefiche">'.$strLadDefpts.' :</td>
				<td class="textfiche"><input type="text" name="def_pts" value="'.$lad_mod->def_pts.'"></td>
				
				<td class="titlefiche">'.$strLadpourcent.' :</td>
				<td class="textfiche"><input type="text" name="pourcent" size="3" value="'.$lad_mod->pourcent.'"><select name="pourcent_type">';
						
						if ($lad_mod->pourcent_type) {
								echo '<option value="1" selected>'.$strOui.'</option>
								<option value="0">'.$strNon.'</option>';
								} else {
								echo '
								<option value="0" selected>'.$strNon.'</option>
								<option value="1">'.$strOui.'</option>';
								}
								
					echo '</select>';
					echo '</select>';
			
			
					if($lad_mod->maps==''){
						$optmaps='
						<option value="0">'.$strNon.'</option>
						<option value="1">'.$strOui.'</option>';
					}else{
						$optmaps='
						<option value="1">'.$strOui.'</option>
						<option value="0">'.$strNon.'</option>';
					}
						echo '
						<td class="titlefiche">'.$strLadMaps.' :</td>
						<td class="textfiche">
						<select name="maps">'.$optmaps.'</select>
						
				</td>
			</tr>
			<tr>

				<td class="titlefiche"  align="right">'.$strMail.' :</td>
				<td class="textfiche" align="left" ><select name="mail">
					<option value="1" selected>'.$strOui.'</option>
					<option value="0">'.$strNon.'</option>
					</select>							
				</td>
											
				<td class="titlefiche" align="left">'.$strLadclosemode.' :</td>
				<td class="textfiche" align="left" colspan="3">
					<select name="close">';
					
					if ($lad_mod->close) {
						echo '<option value="1" selected>'.$strLadclose.'</option>
						<option value="0">'.$strLadopen.'</option>';
					} else {
					
						echo '
						<option value="1">'.$strLadclose.'</option>
						<option value="0" selected>'.$strLadopen.'</option>';
					}
					
					echo '</select>
					<input type="button" value="'.$strAdminMaps.'" onclick="document.location=\'?page=ladder&op=maps&oldop='.$op.'&lad_id='.$lad_id.'\';" />
				</td>
			</tr>
		</table>

		</td>
	</tr>';
	////
	if($lad_mod->s_frag==1){$sfrag='checked="checked"';$disablefrag='';}else{$sfrag='';$disablefrag='disabled';}
if($lad_mod->s_round==1){$sround='checked="checked"';$disableround='';}else{$sround='';$disableround='disabled';}
if($lad_mod->s_manche==1){$smanche='checked="checked"';$disablemanche='';}else{$smanche='';$disablemanche='disabled';}
	echo '
	<tr><td>
	<table cellspacing="0" cellpadding="2" border="0" width="100%">
	<tr>
	<td class="titlefiche">Point de round :</td>
	<td class="textfiche"><input type="checkbox" value="1" name="s_round" id="s_round" '.$sround.' onclick="javascript:if(this.checked==true){document.formulaire.f_round_win.disabled=false;document.formulaire.f_round_loose.disabled=false;}else{document.formulaire.f_round_win.disabled=true;document.formulaire.f_round_loose.disabled=true;}" /></td>
	<td class="titlefiche">Point round gagner :</td>
	<td class="textfiche"><input type="text" name="f_round_win"  id="f_round_win"  size="1" value="'.$lad_mod->f_round_win.'" '.$disableround.'/></td>
	<td class="titlefiche">Point round perdu :</td>
	<td class="textfiche"><input type="text" name="f_round_loose" id="f_round_loose" size="1" value="'.$lad_mod->f_round_loose.'" '.$disableround.'/></td>
	</td></tr>
	
	<tr>
	<td class="titlefiche">Point de frag :</td>
	<td class="textfiche"><input type="checkbox" value="1" name="s_frag" id="s_frag" '.$sfrag.' onclick="javascript:if(this.checked==true){document.formulaire.f_frag_win.disabled=false;document.formulaire.f_frag_loose.disabled=false;}else{document.formulaire.f_frag_win.disabled=true;document.formulaire.f_frag_loose.disabled=true;}" /></td>
	<td class="titlefiche">Point de frag :</td>
	<td class="textfiche"><input type="text" name="f_frag_win" size="1"  id="f_frag_win" value="'.$lad_mod->f_frag_win.'" '.$disablefrag.'/></td>
	<td class="titlefiche">Point de death :</td>
	<td class="textfiche"><input type="text" name="f_frag_loose" size="1" id="f_frag_loose" value="'.$lad_mod->f_frag_loose.'" '.$disablefrag.'/>
	</td></tr>
	
	<tr>
	<td class="titlefiche">Point de Manche :</td>
	<td class="textfiche"><input type="checkbox" value="1" id="s_manche" name="s_manche" '.$smanche.' onclick="javascript:if(this.checked==true){document.formulaire.f_manche_win.disabled=false;document.formulaire.f_manche_loose.disabled=false;document.formulaire.f_manche_null.disabled=false;}else{document.formulaire.f_manche_win.disabled=true;document.formulaire.f_manche_loose.disabled=true;document.formulaire.f_manche_null.disabled=true;}" />
	<td class="titlefiche" colspan="4" >Point de victoire : <input type="text" name="f_manche_win" id="f_manche_win" size="1" value="'.$lad_mod->f_manche_win.'" '.$disablemanche.'/>
	&nbsp;&nbsp;Point de défaite :
	<input type="text" name="f_manche_loose"  id="f_manche_loose" size="1" value="'.$lad_mod->f_manche_loose.'" '.$disablemanche.'/>
	&nbsp;&nbsp;Point de null :
	<input type="text" name="f_manche_null" id="f_manche_null" size="1" value="'.$lad_mod->f_manche_null.'" '.$disablemanche.'/>&nbsp;&nbsp;
	</td>
	
	</td></tr>
	</table>
	</td>
	</tr>
	<tr><td class="headerfiche">'.$strRegLad.'</td></tr>
	<tr><td>
			
			<table cellspacing="0" cellpadding="3" border="0" width="100%">
			<tr>
			<td class="textfiche" colspan="2" align="center">';buttonBB('reglement');echo '</td>
			</tr>
			<tr>
			<td class="textfiche" colspan="2" align="center"><textarea cols="80" rows="10" name="reglement" ID="reglement" wrap="virtual" ONSELECT="storeCaret(this);" ONCLICK="storeCaret(this);" ONKEYUP="storeCaret(this);">'.$lad_mod->reglement.'</textarea></td>
			</tr>
			<tr><td class="footerfiche" colspan="2" align="center"><input type="submit" value="'.$strModifier.'"></td></tr>
			</table>
			</td></tr></table>
			</td></tr></table>
	</form>';
	
	show_consignes($strLadderADD);
}
//
//  Requete de modification du ladder
//
else if ($op == "do_mod_lad") {
if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['u']!='u') {js_goto('?page=login');}  
	
	$str='';
	$erreur=0;
	
	/*$db->select("ladder_name");
	$db->from("${dbprefix}ladder_data WHERE ladder_name='$ladder_name'");
	$db->exec();
	$lad_mod=$db->fetch();
	
	if ($lad_mod->ladder_name==$ladder_name) {
	$erreur=1;
	$str=$strLadalreadyexist;
	}*/
	
	if (!$ladder_name) {
	$erreur=1;
	$str=$strLad_needname;
	}
	if (!$reglement) {
	$erreur=1;
	$str=$strLad_needrules;
	}
	
	if($erreur==1) {		
		show_erreur_saisie($str);			
	}
	else {		
		 
		$db->update("${dbprefix}ladder_data");
		$db->set("ladder_name='$ladder_name',ladder_type='$ladder_type',jeux='$jeux',reglement='$reglement',pourcent='$pourcent',maps='$maps',def_pts='$def_pts',pourcent_type='$pourcent_type',close='$close',mail='$mail'");
		$db->set("s_frag='$s_frag',s_round='$s_round',s_manche='$s_manche',f_frag_win='$f_frag_win',f_frag_loose='$f_frag_loose',f_round_win='$f_round_win',f_round_loose='$f_round_loose',f_manche_win='$f_manche_win',f_manche_loose='$f_manche_loose',f_manche_null='$f_manche_null'");
		$db->where("id = $id ");
		$db->exec();
		
		/*** redirection ***/
		js_goto("?page=ladder&lad_id=$id");
	}

}
//
// Tableau de MAJ d'un rapport
//
else if ($op == "mod_rep") {

if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['u']!='u') {js_goto('?page=login');} 

	$db->select("${dbprefix}ladder_data.*,${dbprefix}ladder_match.rapport");
	$db->from("${dbprefix}ladder_data LEFT JOIN ${dbprefix}ladder_match on (${dbprefix}ladder_data.id = ${dbprefix}ladder_match.ladder_id)");
	$db->where("${dbprefix}ladder_data.id = $lad_id AND ${dbprefix}ladder_match.ladder_id = $lad_id AND ${dbprefix}ladder_match.id = $m_id");
	$db->exec();
	//$lad_while= $db->fetch();
	$lad_mod=$db->fetch();

	echo '<form method="post" name="formulaire" action="?page=ladder&op=do_mod_rep">
	
	<table border="0" cellpadding="0" cellspacing="0" class="bordure2"><tr><td>
	<table cellspacing="1" cellpadding="0" border="0">';
		////
			echo '<tr><td class="headerfiche">'.$strRapport.'</td></tr>

			<tr>
			<td class="textfiche" align="center"><textarea cols="80" rows="10" name="rapport" ID="rapport" wrap="virtual" >'.$lad_mod->rapport.'</textarea></td>
			</tr>
			<tr><td class="footerfiche" calign="center"><input type="hidden" name="m_id" value="'.$m_id.'"><input type="hidden" name="lad_id" value="'.$lad_id.'"><input type="submit" value="'.$strModifier.'"></td></tr>

			</td></tr></table>
			</td></tr></table>
	</form>';
	

}
//
//  Requete de modification du rapport
//
else if ($op == "do_mod_rep") {
if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['u']!='u') {js_goto('?page=login');}  
	
	$str='';
	$erreur=0;
	
	/*$db->select("ladder_name");
	$db->from("${dbprefix}ladder_data WHERE ladder_name='$ladder_name'");
	$db->exec();
	$lad_mod=$db->fetch();
	
	if ($lad_mod->ladder_name==$ladder_name) {
	$erreur=1;
	$str=$strLadalreadyexist;
	}*/

	
	if($erreur==1) {		
		show_erreur_saisie($str);			
	}
	else {		
		 
		$db->update("${dbprefix}ladder_match");
		$db->set("rapport='$rapport'");
		$db->where("id = $m_id AND ladder_id = $lad_id ");
		$db->exec();
		
		/*** redirection ***/
		js_goto("?page=ladder&lad_id=$lad_id&m_id=$m_id&op=report_lad");
	}

}
//
// Requête d'effacement du ladder
//
else if ($op == "del_lad") {
if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['u']!='u') {js_goto('?page=login');} 
	
	
		$db->delete("${dbprefix}ladder_data WHERE id = '$lad_id'");
		$db->exec();

		$db->delete("${dbprefix}ladder WHERE ladder_id = '$lad_id'");
		$db->exec();
		
		$db->delete("${dbprefix}ladder_match WHERE ladder_id = '$lad_id'");
		$db->exec();
		
		$db->delete("${dbprefix}lad_comment WHERE ladder_id = '$lad_id'");
		$db->exec();
	
		
		/*** redirection ***/
		js_goto("?page=ladder");
	

}
//
// Requête d'effacement du ladder
//
else if ($op == "del_m") {
if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['u']!='u') {js_goto('?page=login');} 
	
	
		$db->delete("${dbprefix}ladder_match WHERE ladder_id = '$lad_id' AND m_id = '$m_id'");
		$db->exec();

	
		
		/*** redirection ***/
		js_goto("?page=ladder");
	

}
//
// ################# [  /ADMIN ]  ################
//

//
// ################# [  AFFICHAGE ]  ################
//

//
//Joindre un ladder
//
else if ($op == "join_lad" && is_numeric($lad_id)) {

		
		$db->select("ladder_type,def_pts");
		$db->from("${dbprefix}ladder_data WHERE id='$lad_id'");
		$db->exec();
		$lad_mod=$db->fetch();
		
		if ($lad_mod->ladder_type == '1') {
		// def pts
		$s_j = show_joueur ($s_joueur,"","","","left","player_lad_name");
		
		
		if ($lad_mod->def_pts!=NULL||$lad_mod->def_pts!=0||$lad_mod->def_pts!='0') {$define_pts=$lad_mod->def_pts;}else {$define_pts=0;}
		
		$db->insert("${dbprefix}lad_part (ladder_id,name,pts,joueur_id)");
		$db->values("'$lad_id','$s_j','$define_pts','$s_joueur'");
		$db->exec();
		
		/*** redirection ***/
		js_goto("?page=ladder&lad_id=$lad_id&op=player_lad");
		} else if ($lad_mod->ladder_type == '2' AND empty($step2)) {
		
			if ($grade['x'] != 'x')
			{
				show_warning($strLAD_yournotmanager);
			} else {
			
				$db->select("nom");
				$db->from("${dbprefix}equipes WHERE manager='$s_joueur'");
				$res=$db->exec();
				
				echo '<br>'.$strLAD_whosteam.'<br>
				<form method="post" action="?page=ladder&op=join_lad&step2=oui&lad_id='.$lad_id.'">
				<select name="team">';
				
				while ($lad_mod=$db->fetch($res)){
					echo '
						<option value="'.$lad_mod->nom.'">'.$lad_mod->nom.'</option>
					';
				}
				echo '</select><input type="submit" value="'.$strValider.'">
				</form>';
			}
		}else if ($lad_mod->ladder_type == '2' AND !empty($step2)) {
		
		
			if ($grade['x'] != 'x')
			{
				js_goto("?page=loggin");
			}else {
			
				$db->select("id");
				$db->from("${dbprefix}equipes WHERE manager='$s_joueur' AND nom='$team'");
				$db->exec();
				$teamid=$db->fetch();
				$s_j = show_equipe ($teamid->id,"","","","left","player_lad_name");
				
			$db->insert("${dbprefix}lad_part (ladder_id,name,pts,joueur_id,team,teamid)");
			$db->values("'$lad_id','$s_j','$define_pts','$s_joueur','$team','$teamid->id'");
			$db->exec();
			}
			/*** redirection ***/
		js_goto("?page=ladder&lad_id=$lad_id&op=player_lad");
		}
		
		
}

//
//Quitter un ladder
//
else if ($op == "left_lad" && is_numeric($lad_id)) {

		
		$db->delete("${dbprefix}ladder_match");
		$db->where("(j1 = $s_joueur or j2 = $s_joueur) AND ladder_id = $lad_id");
		$db->exec();
		
		$db->delete("${dbprefix}lad_part");
		$db->where("joueur_id = $s_joueur and ladder_id = $lad_id");
		$db->exec();
		
		js_goto("?page=ladder&op=$oldop&lad_id=$lad_id");

}

//
// Ajout d'un duel
//
else if ($op == "duel") {


			


	echo '
	<form method="post" name="formulaire" action="?page=ladder&op=do_duel">
	
	<table border="0" cellpadding="0" cellspacing="0" class="bordure2">
	<tr>
		<td>
			<table cellspacing="1" cellpadding="0" border="0" width="100%">';
			
			/////
			echo '<tr>
					<td class="modsfiche">&nbsp; '.$strLadduel.' &nbsp;</td>
				</tr>
				<tr>
					<td>
						<table cellspacing="0" cellpadding="2" border="0" width="100%">';
	

									/*** date ***/
									echo '<tr>
									<td class="titlefiche">'.$strDate.' <small><small>(jj/mm/aa hh:mm)</small></small>:</td>
									<td class="textfiche">
									<select name="j">';
for($i=1;$i<32;$i++) 
{ 	
	if($i==date("d"))$select='selected';else $select='';	
	if($i<10)										
	echo '<option value="0'.$i.'" '.$select.'>0'.$i.'</option>';
	else
	echo '<option value="'.$i.'" '.$select.'>'.$i.'</option>';
}
echo '
</select>/ 
<select name="m">';
for($i=1;$i<13;$i++) 
{ 	
	if($i==date("m"))$select='selected';else $select='';	
	if($i<10)										
	echo '<option value="0'.$i.'" '.$select.'>0'.$i.'</option>';
	else
	echo '<option value="'.$i.'" '.$select.'>'.$i.'</option>';
}
echo '
</select>/
<select name="a">';
for($i=0;$i<100;$i++) 
{ 	
	if($i==date("y"))$select='selected';else $select='';	
	if($i<10)										
	echo '<option value="0'.$i.'" '.$select.'>0'.$i.'</option>';
	else
	echo '<option value="'.$i.'" '.$select.'>'.$i.'</option>';
}
echo '
</select> - <select name="h">';
for($i=0;$i<24;$i++) 
{ 	
	if($i==date("H"))$select='selected';else $select='';
	if($i<10)
	echo '<option value="0'.$i.'" '.$select.'>0'.$i.'</option>';
	else
	echo '<option value="'.$i.'" '.$select.'>'.$i.'</option>';										
}
echo '
</select> : <select name="min">';
for($i=1;$i<60;$i++) 
{ 	
	if($i==date("i"))$select='selected';else $select='';
	if($i<10)
	echo '<option value="0'.$i.'" '.$select.'>0'.$i.'</option>';
	else
	echo '<option value="'.$i.'" '.$select.'>'.$i.'</option>';										
}
									echo '
									</select></td>
									
									
									<td class="titlefiche" rowspan="2">'.$strMaps.' :<br>'.$strLad_cltr.'</td>
									<td class="textfiche" rowspan="2">
									<select name="maps[]" style="width:120" MULTIPLE SIZE="5" >';
										$db->select("maps");
										$db->from("${dbprefix}ladder_data");
										$db->where("${dbprefix}ladder_data.id = $lad_id");
										$db->exec();
										$lad_while=$db->fetch();
										$map_array=array();
										$map_array=split(',',$lad_while->maps);
									for($i=0;$i<sizeof($map_array);$i++) 
									{ 	
										if ($map_array[$i] != 0 || $map_array[$i] != NULL){
										echo '<option value="'.$map_array[$i].'">'.$map_array[$i].'</option>';		
										}else{
										echo '<option value="no_map">no_map</option>';
										}										
									}			
								  echo '</select></td></tr>
								  <tr>';
	
							/*** servers ***/
							// prendre le truc IP port ou lister les server dispo ...
									echo '
									<td class="titlefiche">'.$strServeur.' :</td>
									<td class="textfiche">
									<input type="text" name="server" id="server" value="xxx.xxx.xxx.xxx:yyyyy" onclick="javascript:this.value=\'\';">
									
									<input type="hidden" name="lad_id" value="'.$lad_id.'">
									<input type="hidden" name="adv" value="'.$d.'">';
								
									
									echo '</td></tr>
						</table>
					</td>
				</tr>';

			echo '
				<tr>
					<td class="headerfiche">'.$strMessage.'</td>
				</tr>
				<tr>
					<td>
						<table cellspacing="0" cellpadding="3" border="0" width="100%">
							
							<tr>
								<td colspan="2" class="textfiche" align="center"><textarea cols="80" rows="10" name="message" ID="message" wrap="virtual" ></textarea></td>
							</tr>
							<tr>
								<td class="footerfiche" colspan="2" align="center"><input type="submit" value="'.$strOK.'"></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	</table>
	</form>';
		

}
//
//  Requete d'ajout de duel
//
else if ($op == "do_duel") {
	
	$str='';
	$erreur=0;
	//echo $adv.'HHHHHHH';
	/*$db->select("ladder_name");
	$db->from("${dbprefix}ladder_data WHERE ladder_name='$ladder_name'");
	$db->exec();
	$lad_mod=$db->fetch();
	
	if ($lad_mod->ladder_name==$ladder_name) {
	$erreur=1;
	$str=$strLadalreadyexist;
	}*/
	
	if (!$message) {
	$erreur=1;
	$str=$strLadnothingcont;
	}
	if (!$j) {
	$erreur=1;
	$str=$strLad_needj;
	}
	if (!$m) {
	$erreur=1;
	$str=$strLad_needm;
	}
	if (!$a) {
	$erreur=1;
	$str=$strLad_needa;
	}
	if (!$h) {
	$erreur=1;
	$str=$strLad_needh;
	}
	if (!$min) {
	$erreur=1;
	$str=$strLad_needmin;
	}
	
	if($erreur==1) {		
		show_erreur_saisie($str);			
	}
	else {		
			$nb_manche_d=sizeof($maps);
									for($i=0;$i<sizeof($maps);$i++) 
										{ 
											
											if ($i < sizeof($maps)-1) {
											$map_s .=$maps[$i].',';
											} else {
											$map_s .=$maps[$i];
											}
											
										}	
			
			$date_match=$j.'/'.$m.'/'.$a.'-'.$h.':'.$min;
			$date_x=$a.$m.$j.$h.$min;
			$date=time();
			
			if ($server) {$server=remove_XSS($server);}else{$server="/";}
			if (!$map_s) {$map_s="/";}
			$name = nom_joueur($s_joueur);
			
			$message=remove_XSS($message);
			$rapport='
			<hr>Log date: '.strftime(DATESTRING1, $date).'
			'.$strJoueur.' : '.$name.'
			'.$message=remove_XSS($message).' : '.$date_match.'
			'.$strServeur.' : '.$server.'
			'.$strMaps.' :  '.$map_s.'
			<hr>'.$name.':<br />'.$message.'
			<hr>';
		
		$db->select("ladder_type");
		$db->from("${dbprefix}ladder_data");
		$db->where("id = '$lad_id'");
		$db->exec();
		$lad_type=$db->fetch();
		
		$type_lad = $lad_type->ladder_type;
		
		if ($lad_type->ladder_type == '2'){
			
		$db->select("teamid");
		$db->from("${dbprefix}lad_part");
		$db->where("ladder_id = '$lad_id' and joueur_id = $s_joueur ");
		$db->exec();
		$lad_t1=$db->fetch();
		
		$t1_id=$lad_t1->teamid;
		
		//ici on reçoit l'id team il faut l'id manager
		$db->select("joueur_id");
		$db->from("${dbprefix}lad_part");
		$db->where("ladder_id = '$lad_id' and teamid = $adv");
		$db->exec();
		$lad_t2=$db->fetch();
		
		$t2_id=$adv;
		$adv=$lad_t2->joueur_id;
			
		} else {
		$t1_id='';
		$t2_id='';
		}
		
		$db->insert("${dbprefix}ladder_match (id,j1,j2,valide,date,date_up,server,ladder_id,maps,rapport,date_x,t1_id,t2_id,manche)");
		$db->values("'','$s_joueur','$adv','D','$date_match','$date','$server','$lad_id','$map_s','$rapport','$date_x','$t1_id','$t2_id','$nb_manche_d'");
		$db->exec();
		
		
		
		$db->select("id");
		$db->from("${dbprefix}ladder_match");
		$db->where("ladder_id = '$lad_id' AND j1 = '$s_joueur' AND j2 = '$adv' AND valide = 'D' AND date_up = '$date'");
		$db->exec();
		$lad_while=$db->fetch();
		
		$rapport_msg=$rapport.'<br/><br />'.$strLAD_msgMatch.'<br /><a href="?page=ladder&op=agree&lad_id='.$lad_id.'&m_id='.$lad_while->id.'">[URL]</a>';
		$rapport_mail=$rapport.'<br/><br />'.$strLAD_msgMatch.'<br /><a href="'.$config["urlsite"].'?page=ladder&op=agree&lad_id='.$lad_id.'&m_id='.$lad_while->id.'"><i>'.$config["urlsite"].'?page=ladder&op=agree&lad_id='.$lad_id.'&m_id='.$lad_while->id.'</i></a>';
		
		$db->insert("${dbprefix}messages (emetteur,destinataire,titre,message,date)");
		$db->values("'$s_joueur','$adv','Ladder : $strLAD_incom','$rapport_msg','$date'");
		$db->exec();
		
		
		
		$db->select("mail");
		$db->from("${dbprefix}ladder_data");
		$db->where("id = '$lad_id'");
		$db->exec();
		$lad_while=$db->fetch();
		
		/*** génération de l'email de confirmation ***/
		if ($lad_while->mail) {
		
		if($type_lad == '1') {
		$db->select("email");
		$db->from("${dbprefix}joueurs");
		$db->where("id = '$s_joueur'");
		$db->exec();
		$lad_j1=$db->fetch();
		$email1=$lad_j1->email;
		
		$db->select("email");
		$db->from("${dbprefix}joueurs");
		$db->where("id = '$adv'");
		$db->exec();
		$lad_j2=$db->fetch();
		$email2=$lad_j2->email;
		
		}else{
		$db->select("email");
		$db->from("${dbprefix}equipes");
		$db->where("manager = '$j1v'");
		$db->exec();
		$lad_j1=$db->fetch();
		$email1=$lad_j1->email;
		
		$db->select("email");
		$db->from("${dbprefix}equipes");
		$db->where("manager = '$j2v'");
		$db->exec();
		$lad_j2=$db->fetch();
		$email2=$lad_j2->email;
		}
		
		$link="<a href=\"".$config['urlsite']."/?page=laddder&op=agree&lad_id=".$lad_id."&m_id=".$m_id."\" target=\"_blank\">".$config['urlsite']."/?page=laddder&op=agree&lad_id=".$lad_id."&m_id=".$m_id."</a>";
		
			$to = $email1;
			$from = $config['nomsite'];
			$subject = $strLAD_incom;
			$body = $rapport_mail;

			$mail = new phpTMailer();
			$mail->From = $from;
			$mail->FromName = "";
			$mail->AddAddress($to);
			$mail->Subject = $subject;
			$mail->Body = $body;
			
			$to = $email2;

			$mail = new phpTMailer();
			$mail->From = $from;
			$mail->FromName = "";
			$mail->AddAddress($to);
			$mail->Subject = $subject;
			$mail->Body = $body;

			if(!$mail->Send())
			{
				show_erreur("$strErreurMessageEnvoi<br><br>$mail->ErrorInfo");
			}
		}
		
		/*** redirection ***/
	js_goto("?page=ladder&op=match_lad&lad_id=$lad_id");
	}

}
//
// agree mod
//
else if ($op == "agree") {
	$db->select("*");
	$db->from("${dbprefix}ladder_match WHERE ladder_id='$lad_id' AND id='$m_id'");
	$db->exec();
	$lad_while=$db->fetch();
	
	$date=$lad_while->date;
	$server=$lad_while->server;
	$rapport=$lad_while->rapport;
	$maps=array();
	$maps=$lad_while->maps;
	$adv=$lad_while->j1;
	$anti_triche=$lad_while->j2;
	
	if (($anti_triche != $s_joueur OR $lad_while->valide != 'D') AND $ad!='ad') {
	$erreur=1;
	$str=$strLAD_youdontabletodothis;
		
		$db->select("id");
		$db->from("${dbprefix}joueurs WHERE grade LIKE '%a%' or grade LIKE '%b%' ");
		$db->exec();
		$res=$db->exec();
		
		$rapport_admin='<hr>'.$strLAD_admin.'<br />IP :'. $_SERVER['REMOTE_ADDR'].'<br/>Name :'.nom_joueur($s_joueur).'<br />Date :'.strftime(DATESTRING1, time()).'<hr>'.$str_phptteam.'<hr>';
			
			while ($lad_while = $db->fetch($res)) {
		
			$db->insert("${dbprefix}messages (emetteur,destinataire,titre,message,date)");
			$db->values("'-2','".$lad_while->id."','Ladder : $strLAD_admin_title','$rapport_admin','$date'");
			$db->exec();
			
			}
		
	if($erreur==1) {		
		show_erreur($str);			
	}
	
	} else {
	
	$j=preg_replace("!([0-9]{2}?)/([0-9]{2}?)/([0-9]{2}?)-([0-9]{2}?):([0-9]{2}?)!", "$1", $date);
	$m=preg_replace("!([0-9]{2}?)/([0-9]{2}?)/([0-9]{2}?)-([0-9]{2}?):([0-9]{2}?)!", "$2", $date);
	$y=preg_replace("!([0-9]{2}?)/([0-9]{2}?)/([0-9]{2}?)-([0-9]{2}?):([0-9]{2}?)!", "$3", $date);
	$h=preg_replace("!([0-9]{2}?)/([0-9]{2}?)/([0-9]{2}?)-([0-9]{2}?):([0-9]{2}?)!", "$4", $date);
	$min=preg_replace("!([0-9]{2}?)/([0-9]{2}?)/([0-9]{2}?)-([0-9]{2}?):([0-9]{2}?)!", "$5", $date);
		
	echo '
	<script language="javascript">
	function ja_dis() {
	document.formulaire.j.disabled=false;
	document.formulaire.m.disabled=false;
	document.formulaire.a.disabled=false;
	document.formulaire.h.disabled=false;
	document.formulaire.min.disabled=false;
	document.formulaire.elements[5].disabled=false;
	document.formulaire.server.disabled=false;
	document.formulaire.choix1.checked=false;
	document.formulaire.choix3.checked=false;

	alert("'.$strLAD_refalert.'");
	}
	
	function ja_ag() {
	document.formulaire.j.disabled=true;
	document.formulaire.m.disabled=true;
	document.formulaire.a.disabled=true;
	document.formulaire.h.disabled=true;
	document.formulaire.min.disabled=true;
	document.formulaire.elements[5].disabled=true;
	document.formulaire.server.disabled=true;
	document.formulaire.choix2.checked=false;
	document.formulaire.choix3.checked=false;

	}
	function ja_re() {
	document.formulaire.j.disabled=true;
	document.formulaire.m.disabled=true;
	document.formulaire.a.disabled=true;
	document.formulaire.h.disabled=true;
	document.formulaire.min.disabled=true;
	document.formulaire.elements[5].disabled=true;
	document.formulaire.server.disabled=true;
	document.formulaire.choix2.checked=false;
	document.formulaire.choix1.checked=false;

	alert("'.$strLAD_refusealert.'");
	}
	
	</script>
	<form method="post" name="formulaire" action="?page=ladder&op=do_agree_duel&ad='.$ad.'">
	
	<table border="0" cellpadding="0" cellspacing="0" class="bordure2">
	<tr>
		<td>
			<table cellspacing="1" cellpadding="0" border="0" width="100%">';
			
			/////
			echo '<tr>
					<td class="modsfiche">&nbsp; '.$strLad_agree.' &nbsp;</td>
				</tr>
				<tr>
					<td>
					
						<table cellspacing="0" cellpadding="2" border="0" width="100%">';
	

									/*** date ***/
									echo '<tr>
									<td class="titlefiche">'.$strDate.' <small><small>(jj/mm/aa hh:mm)</small></small>:</td>
									<td class="textfiche">
									<select name="j" disabled>';
for($i=1;$i<32;$i++) 
{ 	
	if($i==date("d"))$select='selected';else $select='';	
	if($i<10)										
	echo '<option value="0'.$i.'" '.$select.'>0'.$i.'</option>';
	else
	echo '<option value="'.$i.'" '.$select.'>'.$i.'</option>';
}
echo '
</select>/ 
<select name="m" disabled>';
for($i=1;$i<13;$i++) 
{ 	
	if($i==date("m"))$select='selected';else $select='';	
	if($i<10)										
	echo '<option value="0'.$i.'" '.$select.'>0'.$i.'</option>';
	else
	echo '<option value="'.$i.'" '.$select.'>'.$i.'</option>';
}
echo '
</select>/
<select name="a" disabled>';
for($i=0;$i<100;$i++) 
{ 	
	if($i==date("y"))$select='selected';else $select='';	
	if($i<10)										
	echo '<option value="0'.$i.'" '.$select.'>0'.$i.'</option>';
	else
	echo '<option value="'.$i.'" '.$select.'>'.$i.'</option>';
}
echo '
</select> - <select name="h" disabled>';
for($i=0;$i<24;$i++) 
{ 	
	if($i==date("H"))$select='selected';else $select='';
	if($i<10)
	echo '<option value="0'.$i.'" '.$select.'>0'.$i.'</option>';
	else
	echo '<option value="'.$i.'" '.$select.'>'.$i.'</option>';										
}
echo '
</select> : <select name="min" disabled>';
for($i=0;$i<60;$i++) 
{ 	
	if($i==date("i"))$select='selected';else $select='';
	if($i<10)
	echo '<option value="0'.$i.'" '.$select.'>0'.$i.'</option>';
	else
	echo '<option value="'.$i.'" '.$select.'>'.$i.'</option>';										
}
									echo '
									</select></td>
									
									
									<td class="titlefiche" rowspan="2">'.$strMaps.' :<br>'.$strLad_cltr.'</td>
									<td class="textfiche" rowspan="2">
									<select name="map_s[]" id="map_s[]" style="width:120" MULTIPLE SIZE="5" DISABLED>';
										$db->select("maps");
										$db->from("${dbprefix}ladder_data");
										$db->where("${dbprefix}ladder_data.id = $lad_id");
										$db->exec();
										$lad_while=$db->fetch();
										$map_array=array();
										$map_array=split(',',$lad_while->maps);
									for($i=0;$i<sizeof($map_array);$i++) 
									{ 	
									//pregmatch de $maps pour trouver les map == si c le cas selected=true
									echo '<option value="'.$map_array[$i].'">'.$map_array[$i].'</option>';									
									}			
								  echo '</select></td></tr>
								  <tr>';
	
							/*** servers ***/
							// prendre le truc IP port ou lister les server dispo ...
									echo '
									<td class="titlefiche">'.$strServeur.' :</td>
									<td class="textfiche">
									<input type="text" name="server" id="server" value="'.$server.'" onclick="javascript:this.value=\'\';" DISABLED>
									
									<input type="hidden" name="lad_id" id="lad_id" value="'.$lad_id.'">
									<input type="hidden" name="adv" id="adv" value="'.$adv.'">
									<input type="hidden" name="m_id" id="m_id" value="'.$m_id.'">';
									
									echo '</td></tr>
						</table>
					
					</td>
				</tr>
				';

			echo '
				<tr>
					<td class="headerfiche">'.$strMessage.'</td>
				</tr>
				<tr>
					<td>
						<table cellspacing="0" cellpadding="3" border="0" width="100%">
							
							<tr>
								<td colspan="2" class="textfiche" align="left">
								'.nl2br($rapport).'<br />
								</td>
							</tr>
							
						</table>
					</td>

				<tr>
					<td>
						<table cellspacing="0" cellpadding="3" border="0" width="100%">
							
							<tr>
								<td colspan="2" class="headerfiche" align="center">'.$strLAD_reply.'</td>
							</tr>
							<tr>
								<td colspan="2" class="textfiche" align="center"><textarea cols="80" rows="10" name="message" ID="message" wrap="virtual" ></textarea></td>
							</tr>
							<tr>
							<td class="footerfiche" colspan="2" align="center">'.$strLADagree.' <input type="checkbox" id="choix1" name="choix1" value="agree" onclick="javascript:ja_ag();" CHECKED> | '.$strLAD_other_prupose.' <input type="checkbox" name="choix2" id="choix2" value="disagree" onclick="javascript:ja_dis();"> | '.$strLAD_refusal.' <input type="checkbox"  name="choix3" id="choix3" value="refuse" onclick="javascript:ja_re();" /></td>
							</tr>
							<tr>
								<td class="footerfiche" colspan="2" align="center"><input type="submit" value="'.$strOK.'"></td>
							</tr>
						</table>
					</td>
				</tr>
				</tr>
			</table>
		</td>
	</tr>
	</table>
	<textarea cols="80" rows="10" style="visibility:hidden;" name="rapport" ID="rapport" wrap="virtual" >'.$rapport.'</textarea>
	</form>';
	}//anti triche	

}

//
// Suppression d'un match
//
else if ($op == "del_match") {

		if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['u']!='u') {js_goto('?page=login');} 

		if (is_numeric($m_id) and is_numeric($lad_id)) {
		$db->delete("${dbprefix}ladder_match");
		$db->where("id = $m_id");
		$db->exec();
		}
		
		js_goto("?page=ladder&op=match_lad&lad_id=$lad_id");
 }
 //
// Suppression d'un match par un joueur
//
else if ($op == "del_match_j") {

	//	if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['u']!='u') {js_goto('?page=login');} 
		
		$m_id_w=$_POST['m_id'];
		if (is_numeric($m_id_w) and is_numeric($lad_id)) {
		$db->delete("${dbprefix}ladder_match");
		$db->where("id = $m_id_w");
		$db->exec();
		}
		
		js_goto("?page=ladder&op=match_lad&lad_id=$lad_id");
 }
 
//
// Validation de confirmation / contestation / annulation
//
else if ($op == "do_agree_duel") {
	
	$str='';
	$erreur=0;
	
									for($i=0;$i<sizeof($map_s);$i++) 
										{ 
											
											if ($i < sizeof($map_s)-1) {
											$maps .=$map_s[$i].',';
											} else {
											$maps .=$map_s[$i];
											}
											
										}	
										
										if($ad=='ad'){
										$name = 'Admin';
			
										$db->select("*");
										$db->from("${dbprefix}ladder_match WHERE ladder_id='$lad_id' AND id='$m_id'");
										$db->exec();
										$lad_while=$db->fetch();
																			
										$sender=$lad_while->j2;
										}else{
										$name = nom_joueur($s_joueur);
										$sender=$s_joueur;
										}
										
		$db->select("ladder_type");
		$db->from("${dbprefix}ladder_data");
		$db->where("id = '$lad_id'");
		$db->exec();
		$lad_while=$db->fetch();
		$type_lad = $lad_while->ladder_type;
	
	if ($choix3 == "refuse") {
			$date_match=$j.'/'.$m.'/'.$a.'-'.$h.':'.$min;
			$date_x=$a.$m.$j.$h.$min;
			$date=time();
			
			if ($server) {$server=remove_XSS($server);}else{$server="/";}
			if (!$maps) {$maps="/";}
			
			
			
			$rapport_end='
			'.$rapport.'<hr>Log date: '.strftime(DATESTRING1, $date).'
			'.$strJoueur.' : '.$name.' '.$strLAD_is_disagree2;
			if ($message!="") {
			$message=remove_XSS($message);
			$rapport_end.=$name.':<br />'.$message.'<hr>';
			}			
		
		
		$db->delete("${dbprefix}ladder_match");
		$db->where("id = $m_id");
		$db->exec();
		
		$db->insert("${dbprefix}messages (emetteur,destinataire,titre,message,date)");
		$db->values("'$sender','$adv','Ladder : $strLAD_incom4','$rapport_end','$date'");
		$db->exec();

		$db->select("mail");
		$db->from("${dbprefix}ladder_data");
		$db->where("id = '$lad_id'");
		$db->exec();
		$lad_while=$db->fetch();
		
		/*** génération de l'email de confirmation ***/
		if ($lad_while->mail) {
		
		
		if($type_lad == '1') {
		$db->select("email");
		$db->from("${dbprefix}joueurs");
		$db->where("id = '$sender'");
		$db->exec();
		$lad_j1=$db->fetch();
		$email1=$lad_j1->email;
		
		$db->select("email");
		$db->from("${dbprefix}joueurs");
		$db->where("id = '$adv'");
		$db->exec();
		$lad_j2=$db->fetch();
		$email2=$lad_j2->email;
		
		}else{
		$db->select("email");
		$db->from("${dbprefix}equipes");
		$db->where("manager = '$j1v'");
		$db->exec();
		$lad_j1=$db->fetch();
		$email1=$lad_j1->email;
		
		$db->select("email");
		$db->from("${dbprefix}equipes");
		$db->where("manager = '$j2v'");
		$db->exec();
		$lad_j2=$db->fetch();
		$email2=$lad_j2->email;
		}
		
		
		$link="<a href=\"".$config['urlsite']."/?page=laddder&op=agree&lad_id=".$lad_id."&m_id=".$m_id."\" target=\"_blank\">".$config['urlsite']."/?page=laddder&op=agree&lad_id=".$lad_id."&m_id=".$m_id."</a>";
		
			$to = $email1;
			$from = $config['nomsite'];
			$subject = $strLAD_incom4;
			$body = $rapport_mail;

			$mail = new phpTMailer();
			$mail->From = $from;
			$mail->FromName = "";
			$mail->AddAddress($to);
			$mail->Subject = $subject;
			$mail->Body = $body;
			
			$to = $email2;

			$mail = new phpTMailer();
			$mail->From = $from;
			$mail->FromName = "";
			$mail->AddAddress($to);
			$mail->Subject = $subject;
			$mail->Body = $body;

			if(!$mail->Send())
			{
				show_erreur("$strErreurMessageEnvoi<br><br>$mail->ErrorInfo");
			}
		}
		
		/*** redirection ***/
		js_goto("?page=ladder&op=match_lad&lad_id=$lad_id");
		
	} 
	
	if ($choix2 == "disagree"){
	if (!$message) {
	$erreur=1;
	$str=$strLadnothingcont;
	}
	if (!$j) {
	$erreur=1;
	$str=$strLad_needj;
	}
	if (!$m) {
	$erreur=1;
	$str=$strLad_needm;
	}
	if (!$a) {
	$erreur=1;
	$str=$strLad_needa;
	}
	if (!$h) {
	$erreur=1;
	$str=$strLad_needh;
	}
	if (!$min) {
	$erreur=1;
	$str=$strLad_needmin;
	}
	}
	
	if($erreur==1) {		
		show_erreur_saisie($str);			
	}
	else {		
		  	
	if ($choix2 == "disagree"){
		    $date_match=$j.'/'.$m.'/'.$a.'-'.$h.':'.$min;
			$date_x=$a.$m.$j.$h.$min;
			$date=time();
			
			if ($server) {$server=remove_XSS($server);}else{$server="/";}
			if (!$maps) {$maps="/";}
			
			
			$rapport_end='
			'.$rapport.'<hr>Log date: '.strftime(DATESTRING1, $date).'
			'.$strJoueur.' : '.$name.' '.$strLAD_is_disagree.'
			'.$strLAD_MDate.' : '.$date_match.'
			'.$strServeur.' : '.$server.'
			'.$strMaps.' :  '.$maps;
			if ($message!="") {
			$message=remove_XSS($message);
			$rapport_end.=$name.':<br />'.$message.'<hr>';
			}			
		
		$db->update("${dbprefix}ladder_match");
		$db->set("rapport='$rapport',valide='D',j1='$s_joueur',j2='$adv',date='$date_match',date_up='$date',server='$server',maps='$maps',rapport='$rapport_end',date_x='$date_x'");
		$db->where("id = $m_id AND ladder_id = $lad_id ");
		$db->exec();
		
		$db->insert("${dbprefix}messages (emetteur,destinataire,titre,message,date)");
		$db->values("'$sender','$adv','Ladder : $strLAD_incom3','$rapport','$date'");
		$db->exec();
		
		//mail
		$db->select("mail");
		$db->from("${dbprefix}ladder_data");
		$db->where("id = '$lad_id'");
		$db->exec();
		$lad_while=$db->fetch();
		
		/*** génération de l'email de confirmation ***/
		if ($lad_while->mail) {
		
		if($type_lad == '1') {
		$db->select("email");
		$db->from("${dbprefix}joueurs");
		$db->where("id = '$sender'");
		$db->exec();
		$lad_j1=$db->fetch();
		$email1=$lad_j1->email;
		
		$db->select("email");
		$db->from("${dbprefix}joueurs");
		$db->where("id = '$adv'");
		$db->exec();
		$lad_j2=$db->fetch();
		$email2=$lad_j2->email;
		
		}else{
		$db->select("email");
		$db->from("${dbprefix}equipes");
		$db->where("manager = '$j1v'");
		$db->exec();
		$lad_j1=$db->fetch();
		$email1=$lad_j1->email;
		
		$db->select("email");
		$db->from("${dbprefix}equipes");
		$db->where("manager = '$j2v'");
		$db->exec();
		$lad_j2=$db->fetch();
		$email2=$lad_j2->email;
		}
		
		$link="<a href=\"".$config['urlsite']."/?page=laddder&op=agree&lad_id=".$lad_id."&m_id=".$m_id."\" target=\"_blank\">".$config['urlsite']."/?page=laddder&op=agree&lad_id=".$lad_id."&m_id=".$m_id."</a>";
		
			$to = $email1;
			$from = $config['nomsite'];
			$subject = $strLAD_incom3; 
			$body = $rapport;

			$mail = new phpTMailer();
			$mail->From = $from;
			$mail->FromName = "";
			$mail->AddAddress($to);
			$mail->Subject = $subject;
			$mail->Body = $body;
			
			$to = $email2;

			$mail = new phpTMailer();
			$mail->From = $from;
			$mail->FromName = "";
			$mail->AddAddress($to);
			$mail->Subject = $subject;
			$mail->Body = $body;

			if(!$mail->Send())
			{
				show_erreur("$strErreurMessageEnvoi<br><br>$mail->ErrorInfo");
			}
		}
		} else if ($choix1 == "agree") { // le joueur est d'accord
		
			
			$rapport_end='
			'.$rapport.'<hr>Log date: '.strftime(DATESTRING1, $date).'
			'.$strJoueur.' : '.$name.' '.$strLAD_is_agree.' 
			<hr>';
			if ($message!="") {
			$message=remove_XSS($message);
			$rapport_end.=$name.':<br />'.$message.'<hr>';
			}
		$date_up=time();
		$db->update("${dbprefix}ladder_match");
		$db->set("rapport='$rapport_end',valide='B',date_up='$date_up'");
		$db->where("id = $m_id AND ladder_id = $lad_id ");
		$db->exec();
		
		$db->insert("${dbprefix}messages (emetteur,destinataire,titre,message,date)");
		$db->values("'$sender','$adv','Ladder : $strLAD_incom2 ','$rapport_end','$date'");
		$db->exec();
		
		$db->select("mail");
		$db->from("${dbprefix}ladder_data");
		$db->where("id = '$lad_id'");
		$db->exec();
		$lad_while=$db->fetch();
		
		/*** génération de l'email de confirmation ***/
		if ($lad_while->mail) {
		
		if($type_lad == '1') {
		$db->select("email");
		$db->from("${dbprefix}joueurs");
		$db->where("id = '$sender'");
		$db->exec();
		$lad_j1=$db->fetch();
		$email1=$lad_j1->email;
		
		$db->select("email");
		$db->from("${dbprefix}joueurs");
		$db->where("id = '$adv'");
		$db->exec();
		$lad_j2=$db->fetch();
		$email2=$lad_j2->email;
		
		}else{
		$db->select("email");
		$db->from("${dbprefix}equipes");
		$db->where("manager = '$j1v'");
		$db->exec();
		$lad_j1=$db->fetch();
		$email1=$lad_j1->email;
		
		$db->select("email");
		$db->from("${dbprefix}equipes");
		$db->where("manager = '$j2v'");
		$db->exec();
		$lad_j2=$db->fetch();
		$email2=$lad_j2->email;
		}
		
		$link="<a href=\"".$config['urlsite']."/?page=laddder&op=agree&lad_id=".$lad_id."&m_id=".$m_id."\" target=\"_blank\">".$config['urlsite']."/?page=laddder&op=agree&lad_id=".$lad_id."&m_id=".$m_id."</a>";
		
			$to = $email1;
			$from = $config['nomsite'];
			$subject = $strLAD_incom2;
			$body = $rapport_end;

			$mail = new phpTMailer();
			$mail->From = $from;
			$mail->FromName = "";
			$mail->AddAddress($to);
			$mail->Subject = $subject;
			$mail->Body = $body;
			
			$to = $email2;
			
			$mail = new phpTMailer();
			$mail->From = $from;
			$mail->FromName = "";
			$mail->AddAddress($to);
			$mail->Subject = $subject;
			$mail->Body = $body;


			if(!$mail->Send())
			{
				show_erreur("$strErreurMessageEnvoi<br><br>$mail->ErrorInfo");
			}
		}
		}
	
		
		/*** redirection ***/
		js_goto("?page=ladder&op=match_lad&lad_id=$lad_id&m_id=$m_id");
	}

}
//
// Gestion des MAPS
//
else if ($op == "maps" && is_numeric($lad_id)) {

		if ($grade['a']!='a' ||$grade['b']!='b' ||$grade['u']!='u' ) {js_goto('?page=login');}
										echo '<br>'.$strAdminMaps.'<br>'.$strLADAdminMaps;
	
										$db->select("${dbprefix}jeux.id");
										$db->from("${dbprefix}jeux LEFT JOIN ${dbprefix}ladder_data on (${dbprefix}ladder_data.jeux = ${dbprefix}jeux.icone)");
										$db->where("${dbprefix}ladder_data.id = $lad_id");
										$db->exec();
										$lad_while=$db->fetch();					
										
										
										
									echo '<form method="post" name="formulaire" action="?page=ladder&op=do_maps&oldop='.$oldop.'&lad_id='.$lad_id.'">
									
									<br><select name="maps[]" style="width:150" multiple="multiple" SIZE="10">';
										
										$db->select("nom");
										$db->from("${dbprefix}maps");
										
										if ($lad_while->id == '') {
										$db->where("jeux = $lad_while->id");
										}
										
										$res=$db->exec();
										
										$db->select("maps");
										$db->from("${dbprefix}ladder_data");
										$db->where("${dbprefix}ladder_data.id = $lad_id");
										$db->exec();
										$lad_map=$db->fetch();
										$map_array=array();
										$map_array=split(',',$lad_map->maps);
																			
									while ($lad_while=$db->fetch($res))
									{ 	
										/*for($i=0;$i<sizeof($map_array);$i++) 
										{ 
											$dis_lad='';
											if ($map_array[$i] == $lad_while->nom) {
											$dis_lad='selected="selected"';
											}	
																						
										}	*/										
										if (preg_match( "`".$lad_while->nom."`si", $lad_map->maps )){
										echo '<option value="'.$lad_while->nom.'" selected="selected">'.$lad_while->nom.'</option>';
										} else {
										echo '<option value="'.$lad_while->nom.'" >'.$lad_while->nom.'</option>';									
										}	
									}
									
								  echo '</select><br>			  
								  
								  <input type="submit" value="'.$strValider.'" />
								  </form>
								  <br>';
								  for($i=0;$i<sizeof($map_array);$i++) 
										{ 
											if ($map_array[$i] != 0 || $map_array[$i] != NULL) {
											echo $map_array[$i].'<br>';	
											}																						
										}
								  echo '<br>
								  ';

}
//
// Gestion des MAPS INCREMENTATION
//
else if ($op == "do_maps" && is_numeric($lad_id)) {

		if ($grade['a']!='a' ||$grade['b']!='b' ||$grade['u']!='u' ) {js_goto('?page=login');}


									for($i=0;$i<sizeof($maps);$i++) 
										{ 
											
											if ($i < sizeof($maps)-1) {
											$map_s .=$maps[$i].',';
											} else {
											$map_s .=$maps[$i];
											}
											
										}	
		
		$db->update("${dbprefix}ladder_data");
		$db->set("maps='$map_s'");
		$db->where("id = $lad_id ");
		$db->exec();
		
		
		/*** redirection ***/
		js_goto("?page=ladder&lad_id=$lad_id&op=$oldop");

}
//
// Tableau de présentation du ladder
//
else if ($op == "check_lad" && is_numeric($lad_id)) {
										
										//test d'appartenance
										if ($s_joueur) {
										$db->select("ladder_id,joueur_id");
										$db->from("${dbprefix}lad_part");
										$db->where("ladder_id = $lad_id AND joueur_id = $s_joueur");
										$res=$db->exec();	
										if ($db->num_rows($res) != 0) {$lad_ap="oui";} else {$lad_ap="non";}
										} else {
										$lad_ap="no";
										}
										

	//faire un JOIN avec player et match
	$db->select("*");
	$db->from("${dbprefix}ladder_data WHERE id='$lad_id'");
	$db->exec();
	$lad_while=$db->fetch();
	if ($lad_while->close) {$close="A";}else{$close=NULL;}
	$lad_type=$lad_while->ladder_type;
	
	
	// calculer selon le type de pourcent le nb_team 
	// chercher pour le nb_point
	
	
	echo '

					<table class="lad_table"  border="0" cellpadding="0" cellspacing="0">
						
						  <tbody>
						
							<tr class="ladder_back">
						
							  <td class="ladder_onglet" style="width: 9px; height: 26px;"></td>
						
							   <td class="ladder_onglet" style="height: 26px; text-align: left; vertical-align: bottom; width: 200x;" rowspan="1" colspan="2">';
							  if ($lad_while->ladder_type=='1'||$lad_while->ladder_type==1) {
							  echo '<a href="?page=ladder&op=player_lad&lad_id='.$lad_while->id.'"><img  alt="player" src="themes/'.$s_theme.'/images/onglet_player.gif" align="top" border="0" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_player.gif\';"  onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_player_s.gif\';"/></a>';
							  }
							  else {
							  echo '<a href="?page=ladder&op=player_lad&lad_id='.$lad_while->id.'"><img  alt="player" src="themes/'.$s_theme.'/images/onglet_team.gif" align="top" border="0" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_team.gif\';"  onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_team_s.gif\';"/></a>';
							  }
							  echo '<a href="?page=ladder&op=match_lad&lad_id='.$lad_while->id.'"><img alt="match" src="themes/'.$s_theme.'/images/onglet_match_s.gif" align="top" border="0" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_match_s.gif\';"  onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_match.gif\';" /></a><a href="?page=ladder&op=rules_lad&lad_id='.$lad_while->id.'"><img alt="rule" src="themes/'.$s_theme.'/images/onglet_rule_s.gif" align="top" border="0" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_rule_s.gif\';"  onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_rule.gif\';"/></a></td>
						
							  <td class="ladder_onglet" style="width: 9px;"></td>
						
							  <td class="ladder_onglet" style="height: 26px; width: 45px;"></td>
						
							  <td class="ladder_onglet" style="width: 33px; height: 26px;"></td>
						
							  <td class="ladder_onglet" style="width: 33px; height: 26px;"></td>
							  
							  <td class="ladder_onglet" style="width: 26px; height: 26px;"></td>
							  
							  <td class="ladder_onglet" style="width: 26px; height: 26px;"></td>
							  
							  <td class="ladder_onglet" style="width: 26px; height: 26px;"></td>
						
							  <td class="ladder_onglet" style="width: 26px; height: 26px;"></td>
						
							  <td class="ladder_onglet" style="height: 26px; width: 33px;"></td>
						
							  <td class="ladder_onglet" style="height: 26px; width: 49px;"></td>
						
							 <td class="ladder_onglet" style="height: 13px; text-align: left; vertical-align: bottom;" rowspan="1" colspan="2">';
							  
							  if ($op=="admin" || ($grade['a']=='a'||$grade['b']=='b'||$grade['u']=='u')){
							  echo '<a href="?page=ladder&op=mod_lad&lad_id='.$lad_while->id.'"><img alt="edit" src="themes/'.$s_theme.'/images/onglet_e.gif" align="top" border="0" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_e_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_e.gif\';" /></a><a href="?page=ladder&op=del_lad&lad_id='.$lad_while->id.'"><img alt="delete" src="themes/'.$s_theme.'/images/onglet_x.gif" align="top" border="0" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_x_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_x.gif\';" /></a>';
							  }
							 
							  echo '</td>
						
							  <td></td>
						
							</tr>
						
							<tr class="ladder_back">
							  <td class="ladder_header_s" style="width: 9px; height: 26px;"> </td>
						
							  <td class="ladder_header_r" style="height: 26px; text-align: center; width: 48px;" background="images/onglet_repeat.gif"><img style="width: 18px; height: 18px;" alt="nsicon" src="images/jeux/'.$lad_while->jeux.'" align="middle" /> </td>
						
							  <td class="ladder_header_r" style="height: 26px; width: 172px;"><span style="font-weight: bold; color: rgb(255, 255, 255);">'.$lad_while->ladder_name.'</span> </td>
						
							  <td class="ladder_header_r_txt" style="height: 26px; text-align: center;"> [E] </td>
						
							  <td class="ladder_header_r_txt" style="height: 26px; text-align: center; width: 45px; "> [P] </td>
						
							  <td class="ladder_header_r_txt" style="width: 33px; height: 26px; text-align: center; " > [W] </td>
						
							  <td class="ladder_header_r_txt" style="width: 33px; height: 26px; text-align: center; " > [L] </td>
						
							  <td class="ladder_header_r_txt" style="width: 33px; height: 26px; text-align: center;"> [D] </td>
							  
							  <td class="ladder_header_r_txt" style="width: 33px; height: 26px; text-align: center;"> [R] </td>
							  
							  <td class="ladder_header_r_txt" style="width: 33px; height: 26px; text-align: center;"> [A] </td>
							  
							  <td class="ladder_header_r_txt" style="width: 33px; height: 26px; text-align: center;"> [/] </td>
						
							  <td class="ladder_header_r_txt" style="height: 26px; text-align: center; width: 33px;" > [S] </td>
						
							  <td class="ladder_header_r_txt" style="height: 26px; text-align: center;  width: 49px;" > [F] </td>
						
							  <td class="ladder_header_r_txt" style="height: 26px; width: 78px;" > </td>
						
							  <td class="ladder_header_e" style="width: 9px; height: 26px;" background="themes/phptG4/images/onglet_end.gif"> </td>
						
							</tr>';
							
	$lad_while= $db->fetch();
	$db->select("*");
	$db->from("${dbprefix}lad_part");
	$db->where("ladder_id= $lad_id ");
	$db->order_by("pts DESC LIMIT 0,3");
	$res=$db->exec();
	
										
	
	
			
			$i=0;
			$lad_test_1='';
			while ($lad_while = $db->fetch($res)) {
			$i++;
			
			if($lad_while->death==''||$lad_while->death==0||$lad_while->death=='0'){$div='1';}else{$div=$lad_while->death;}
			$ratio=round($lad_while->mort / $div, 2);
			
			
			if ($lad_while->rank != $i) {
		
			
			$rank = $i;
					
			
			} else {
			$rank = $lad_while->rank;
			
			}
			$lvl = $lad_while->lvl;
			
											
											$type_by_opo = '';
											if ($p_type == '1' AND $s_joueur == $lad_while->joueur_id) {
											
												$delta = ceil((nb_player($lad_id) * $p_value) / 100);
													$obj=2*($delta+1);
													$start=$rank-$delta;
													$type_by_opo = '1';
											
											} 
										
			
							echo '
							
							<tr class="ladder_line" onmouseout="javascript:this.bgColor=\'#3c3c46\';" style="cursor: pointer;" onmouseover="javascript:this.bgColor=\'#999999\';" bgcolor="#3c3c46">

										  <td class="ladder_border"></td>
									
										  ';
										  if ($rank == "1") {
										   echo'  <td class="player_lad"><img style="width: 16px; height: 13px;" alt="'.$i.'" src="themes/'.$s_theme.'/images/smallcup.gif" /> </td>';
										  } else if ($rank == "2") {
										   echo'  <td class="player_lad"><img style="width: 16px; height: 13px;" alt="'.$i.'" src="themes/'.$s_theme.'/images/smallcup_silver.gif" /> </td>';
										  } else if ($rank == "3") {
										   echo'  <td class="player_lad"><img style="width: 16px; height: 13px;" alt="'.$i.'" src="themes/'.$s_theme.'/images/smallcup_bronze.gif" /> </td>';
										  } else {
										  echo'  <td class="player_lad"> -'.$rank.'- </td>';
											}
											if ($lad_type == '1'){
											$lad_joueurs="";
											$db->select("*");
											$db->from("${dbprefix}joueurs");
											$db->where("id= $lad_while->joueur_id ");
											$res_joueurs=$db->exec();
											$lad_joueurs=	$db->fetch($res_joueurs);
											echo '
										  <td class="player_lad_name">&nbsp;<img src="images/flags/'.$lad_joueurs->origine.'.gif" border="0" align="absmiddle" alt="'.$lad_joueurs->origine.'"> <a href="?page=joueurs&id='.$lad_while->joueur_id.'" ><span class="player_lad_name">'.$lad_joueurs->pseudo.' ('.$lad_joueurs->ext_cartegraphique.')</span></a>
										  </td>';
										  }else{
										  $lad_team="";										
											$db->select("*");
											$db->from("${dbprefix}equipes");
											$db->where("id= $lad_while->teamid ");
											$res_team=$db_team->exec();
											$lad_team=	$db->fetch($res_team);	
										  echo '
										  <td class="player_lad_name">&nbsp;<a href="?page=equipes&id='.$lad_while->teamid.'" ><span class="player_lad_name">'.$lad_team->nom.'</span> </a>
										  </td>';
										  }
											
											if ($lvl == "1") {
											echo '<td class="player_lad"><img style="width: 15px; height: 15px;" alt="plus" src="images/evo-.gif" /></td>';
											}
											else if ($lvl == "2") {
											echo '<td class="player_lad"><img style="width: 15px; height: 15px;" alt="plus" src="images/evo+.gif" /></td>';
											} else {
										    echo '<td class="player_lad"><img style="width: 15px; height: 15px;" alt="plus" src="images/evo=.gif" /></td>';
											}
											echo '
										  <td class="player_lad" >&nbsp;'.$lad_while->pts.'&nbsp;</td>
									
										  <td class="player_lad">&nbsp;'.$lad_while->w.'&nbsp;</td>
									
										  <td class="player_lad">&nbsp;'.$lad_while->l.'&nbsp;</td>
									
										  <td class="player_lad">&nbsp;'.$lad_while->d.'&nbsp;</td>
										  
										  <td class="player_lad">&nbsp;'.$lad_while->round_w.'&nbsp;</td>
										   
										  <td class="player_lad">&nbsp;'.$lad_while->round_l.'&nbsp;</td>
											
										  <td class="player_lad">&nbsp;'.$ratio.'&nbsp;</td>
									
										  <td class="player_lad">&nbsp;'.$lad_while->s.'&nbsp;</td>
									
										  <td class="player_lad">&nbsp;'.$lad_while->fairplay.'&nbsp;</td>';
											
											
											
											if ($lad_type == '1') {
											$adversaire=$lad_while->joueur_id;
											}else{
											$adversaire=$lad_while->teamid;
											}
											
											if ($lad_while->joueur_id =$s_joueur AND $s_joueur != '' OR $lad_ap!='no')
											{
											echo '<form method="post" id="'.$i.'" name="'.$i.'" action="?page=ladder&op=duel&lad_id='.$lad_id.'&d='.$lad_while->joueur_id.'">
							
											
										  <td class="player_lad">&nbsp;<input type="image" name="subm'.$i.'" id="subm'.$i.'" src="themes/'.$s_theme.'/images/duel.gif">&nbsp;<input type="hidden" name="lad_id" value="'.$lad_id.'">
											<input type="hidden" name="d" value="'.$adversaire.'"></td>
											
											</form>';
											} else {
											echo'<td class="player_lad">&nbsp;<input type="image" src="themes/'.$s_theme.'/images/dueloff.gif">&nbsp;</td>';
											}
											
										  echo '<td class="ladder_border"></td>

									</tr>';
								}if ($i==0) {
							echo '
							 <tr class="ladder_line" onmouseout="javascript:this.bgColor=\'#3c3c46\';" style="cursor: pointer;" onmouseover="javascript:this.bgColor=\'#999999\';" bgcolor="#3c3c46">

								  <td class="ladder_border"></td>
							
								  <td class="player_lad" colspan="13">'.$strLAD_nodata_for_player.'</td>
							
									<td class="ladder_border"></td>
							
							</tr>';
							}

   echo' 
							<tr class="ladder_back">
							  <td class="ladder_header_s" > </td>
						
							  <td class="ladder_header_r" ></td>
						
							  <td class="ladder_header_name"><small>['.$strLAD_lastmatch.']</small></td>
							  
							  <td colspan="11" class="ladder_header_r"></td>
							  <td class="ladder_header_e" > </td>
						
							</tr>';
							
	$lad_while= $db->fetch();
	$db->select("*");
	$db->from("${dbprefix}ladder_match");
	$db->where("ladder_id= $lad_id");
	$db->where("valide= 'B'");
	$db->order_by("date_x LIMIT 0,10");
	$res=$db->exec();
			
			$i_l_2=0;
			while ($lad_while = $db->fetch($res)) {
			$i_l_2++;
			//$date=strftime(DATESTRING1, $lad_while->date);
			$date=$lad_while->date;
			$date_up=strftime(DATESTRING1, $lad_while->date_up);
						
							echo '
							 <tr class="ladder_line" onmouseout="javascript:this.bgColor=\'#3c3c46\';" style="cursor: pointer;" onmouseover="javascript:this.bgColor=\'#999999\';" bgcolor="#3c3c46">

								  <td class="ladder_border"></td>
							
								  <td class="player_lad">  <img src="themes/'.$s_theme.'/images/status_'.$lad_while->valide.'.gif" boder="0" alt="'.${$lad_while->valide}.'" title="'.${$lad_while->valide}.'" />
								  </td>
							
								  <td class="player_lad_name" colspan="2">';
								  
								  if ($lad_type == '1') {
								 echo show_joueur($lad_while->j1,"","","","left","player_lad_name").'&nbsp;&nbsp;&nbsp;<span class="player_lad_name">Vs</span>&nbsp;&nbsp;&nbsp;&nbsp;'.show_joueur($lad_while->j2,"","","","right","player_lad_name").' &nbsp;&nbsp;&nbsp;';
								  } else{
								 echo show_equipe($lad_while->t1_id,"","","","left","player_lad_name").'&nbsp;&nbsp;&nbsp;<span class="player_lad_name">Vs</span>&nbsp;&nbsp;&nbsp;&nbsp;'.show_equipe($lad_while->t2_id,"","","","right","player_lad_name").' &nbsp;&nbsp;&nbsp;';
								  }
								  echo '</td>';
							
									if ($lad_while->s1 > $lad_while->s2) {
									echo '<td colspan="3" class="player_lad">
									<table border="0" cellpadding="0" cellspacing="0"><tr>
									<td class="winmatch" width="15" align="center">'.$lad_while->s1.'</td>
									<td class="player_lad" width="10" align="center"> - </td>
									<td class="loosematch" width="15" align="center">'.$lad_while->s2.'</td>
									</td></tr></table>
									</td>';
									} else if ($lad_while->s2 > $lad_while->s1) {
									echo '<td colspan="3" class="player_lad">
									<table border="0" cellpadding="0" cellspacing="0"><tr>
									<td class="loosematch" width="15" align="center">'.$lad_while->s1.'</td>
									<td class="player_lad" width="10" align="center"> - </td>
									<td class="winmatch" width="15" align="center">'.$lad_while->s2.'</td>
									</td></tr></table>
									</td>';
									} else {
									echo '<td colspan="3" class="player_lad">
									<table border="0" cellpadding="0" cellspacing="0"><tr>
									<td class="nullmatch" width="15" align="center">'.$lad_while->s1.'</td>
									<td class="player_lad" width="10" align="center"> - </td>
									<td class="nullmatch" width="15" align="center">'.$lad_while->s2.'</td>
									</td></tr></table>
									</td>';
									}
								  
								   echo ' <td colspan="5" class="lad_date" >'.$date.'&nbsp;&nbsp; - &nbsp;&nbsp;('.$date_up.')</td>
							
								  <td class="player_lad" colspan="2" align="right">
								  <a href="?page=ladder&op=match_report&lad_id='.$lad_id.'&m_id='.$lad_while->id.'"><img src="themes/'.$s_theme.'/images/search.gif" alt="'.$strRechercher.'" border="0" /></a>
								  <a href="?page=ladder&op=report_lad&lad_id='.$lad_id.'&m_id='.$lad_while->id.'"><img src="themes/'.$s_theme.'/images/report.gif" alt="'.$strLADRapport.'" border="0" /></a>';
								  if ($op=="admin" || ($grade['a']=='a'||$grade['b']=='b'||$grade['u']=='u')) {
								  echo '<a href="?page=ladder&op=del_match&lad_id='.$lad_id.'&m_id='.$lad_while->id.'"><img src="themes/'.$s_theme.'/images/lad_delete.gif" alt="'.$strEffacer.'" border="0" /></a>';
								  echo '<a href="?page=ladder&op=match_report&lad_id='.$lad_id.'&m_id='.$lad_while->id.'&ad=ad"><img src="themes/'.$s_theme.'/images/lad_edit.gif" alt="'.$strEditer.'" border="0" /></a>';
								  }
								  echo '
								</td>
							
								<td class="ladder_border"></td>
							
							</tr>';
							}
							if ($i_l_2==0) {
							echo '
							 <tr class="ladder_line" onmouseout="javascript:this.bgColor=\'#3c3c46\';" style="cursor: pointer;" onmouseover="javascript:this.bgColor=\'#999999\';" bgcolor="#3c3c46">

								  <td class="ladder_border"></td>
							
								  <td class="player_lad" colspan="13">'.$strLAD_nodata_for_match.'</td>
							
									<td class="ladder_border"></td>
							
							</tr>';
							}

      echo' 
							<tr class="ladder_back">
							  <td class="ladder_header_s" > </td>
						
							  <td class="ladder_header_r" ></td>
						
							  <td class="ladder_header_name"><small>['.$strLAD_lastresult.']</small></td>
							  
							  <td colspan="11" class="ladder_header_r"></td>
							  <td class="ladder_header_e" > </td>
						
							</tr>';
							
							$lad_while= $db->fetch();
	$db->select("*");
	$db->from("${dbprefix}ladder_match");
	$db->where("ladder_id= $lad_id");
	$db->where("valide= 'V'");
	$db->order_by("date_x LIMIT 0,10");
	$res=$db->exec();
			
			$i_l_3=0;

			while ($lad_while = $db->fetch($res)) {
			
			$i_l_2++;
			//$date=strftime(DATESTRING1, $lad_while->date);
			$date=$lad_while->date;
			$date_up=strftime(DATESTRING1, $lad_while->date_up);
						
							echo '
							 <tr class="ladder_line" onmouseout="javascript:this.bgColor=\'#3c3c46\';" style="cursor: pointer;" onmouseover="javascript:this.bgColor=\'#999999\';" bgcolor="#3c3c46">

								  <td class="ladder_border"></td>
							
								  <td class="player_lad">  <img src="themes/'.$s_theme.'/images/status_'.$lad_while->valide.'.gif" boder="0" alt="'.${$lad_while->valide}.'" title="'.${$lad_while->valide}.'" />
								  </td>
							
								  <td class="player_lad_name" colspan="2">';
								  
								  if ($lad_type == '1') {
								 echo show_joueur($lad_while->j1,"","","","left","player_lad_name").'&nbsp;&nbsp;&nbsp;<span class="player_lad_name">Vs</span>&nbsp;&nbsp;&nbsp;&nbsp;'.show_joueur($lad_while->j2,"","","","right","player_lad_name").' &nbsp;&nbsp;&nbsp;';
								  } else{
								 echo show_equipe($lad_while->t1_id,"","","","left","player_lad_name").'&nbsp;&nbsp;&nbsp;<span class="player_lad_name">Vs</span>&nbsp;&nbsp;&nbsp;&nbsp;'.show_equipe($lad_while->t2_id,"","","","right","player_lad_name").' &nbsp;&nbsp;&nbsp;';
								  }
								  echo '</td>';
								  
									if ($lad_while->s1 > $lad_while->s2) {
									echo '<td colspan="3" class="player_lad">
									<table border="0" cellpadding="0" cellspacing="0"><tr>
									<td class="winmatch" width="15" align="center">'.$lad_while->s1.'</td>
									<td class="player_lad" width="10" align="center"> - </td>
									<td class="loosematch" width="15" align="center">'.$lad_while->s2.'</td>
									</td></tr></table>
									</td>';
									} else if ($lad_while->s2 > $lad_while->s1) {
									echo '<td colspan="3" class="player_lad">
									<table border="0" cellpadding="0" cellspacing="0"><tr>
									<td class="loosematch" width="15" align="center">'.$lad_while->s1.'</td>
									<td class="player_lad" width="10" align="center"> - </td>
									<td class="winmatch" width="15" align="center">'.$lad_while->s2.'</td>
									</td></tr></table>
									</td>';
									} else {
									echo '<td colspan="3" class="player_lad">
									<table border="0" cellpadding="0" cellspacing="0"><tr>
									<td class="nullmatch" width="15" align="center">'.$lad_while->s1.'</td>
									<td class="player_lad" width="10" align="center"> - </td>
									<td class="nullmatch" width="15" align="center">'.$lad_while->s2.'</td>
									</td></tr></table>
									</td>';
									}
								  
								   echo ' <td colspan="5" class="lad_date" >'.$date.'&nbsp;&nbsp; - &nbsp;&nbsp;('.$date_up.')</td>
							
								  <td class="player_lad" colspan="2" align="right">
								  <a href="?page=ladder&op=match_report&lad_id='.$lad_id.'&m_id='.$lad_while->id.'"><img src="themes/'.$s_theme.'/images/search.gif" alt="'.$strRechercher.'" border="0" /></a>
								  <a href="?page=ladder&op=report_lad&lad_id='.$lad_id.'&m_id='.$lad_while->id.'"><img src="themes/'.$s_theme.'/images/report.gif" alt="'.$strLADRapport.'" border="0" /></a>';
								  if ($op=="admin" || ($grade['a']=='a'||$grade['b']=='b'||$grade['u']=='u')) {
								  echo '<a href="?page=ladder&op=del_match&lad_id='.$lad_id.'&m_id='.$lad_while->id.'"><img src="themes/'.$s_theme.'/images/lad_delete.gif" alt="'.$strEffacer.'" border="0" /></a>';
								  echo '<a href="?page=ladder&op=match_report&lad_id='.$lad_id.'&m_id='.$lad_while->id.'&ad=ad"><img src="themes/'.$s_theme.'/images/lad_edit.gif" alt="'.$strEditer.'" border="0" /></a>';
								  }
								  echo '
								</td>
							
								<td class="ladder_border"></td>
							
							</tr>';
							}
							if ($i_l_2==0) {
							echo '
							 <tr class="ladder_line" onmouseout="javascript:this.bgColor=\'#3c3c46\';" style="cursor: pointer;" onmouseover="javascript:this.bgColor=\'#999999\';" bgcolor="#3c3c46">

								  <td class="ladder_border"></td>
							
								  <td class="player_lad" colspan="13">'.$strLAD_nodata_for_result.'</td>
							
									<td class="ladder_border"></td>
							
							</tr>';
							}
							echo'<tr class="ladder_back">

											<td class="ladder_header_s" style="width: 9px; height: 26px;" ></td>
	
											<td class="ladder_header_r" colspan="2" rowspan="1" style="width: 172px;">';
															
										
										if ($close and $lad_ap!='no') {
										echo '&nbsp;&nbsp;<img align="bottom" alt="closed" src="themes/'.$s_theme.'/images/lock.gif" align="top" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/lock_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/lock.gif\';"/></td>';
										} else if ($lad_ap=='oui' and $lad_ap!='no') {
										echo '&nbsp;&nbsp;<a href="?page=ladder&lad_id='.$lad_id.'&op=see_mylad"><img border="0" align="bottom" alt="status" src="themes/'.$s_theme.'/images/status.gif" align="top" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/status_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/status.gif\';"/></a></td>';
										}else if ($lad_ap!='no') {
										echo '&nbsp;&nbsp;<a href="?page=ladder&lad_id='.$lad_id.'&op=join_lad"><img border="0" align="bottom" alt="open" src="themes/'.$s_theme.'/images/join.gif" align="top" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/join_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/join.gif\';" /></a></td>';
										}
											echo '<td class="ladder_header_r" style="width: 16px;" ></td>
										
											<td class="ladder_header_r" style="width: 45px;" ></td>
										
											<td class="ladder_header_r" style="width: 33px;" ></td>
										
											<td class="ladder_header_r" style="width: 33px;" ></td>
										
											<td class="ladder_header_r" style="width: 33px;" ></td>
										
											<td class="ladder_header_r" style="width: 33px;" </td>
										
											<td class="ladder_header_r" colspan="5" rowspan="1" style="text-align: right;"></td>
										
											<td class="ladder_header_e" style="width: 9px;" ></td>
								
										</tr>

  </tbody>
</table>';
if ($type_by_opo == '1'){
			?><script language="javascript">
			
			function sup_em_all(obj,s_t){
			
				o_j = obj+s_t
				for (var j=s_t;j<o_j;j++) {
				document.forms[j].elements[0].src='themes/<?php echo $s_theme ?>/images/dueloff.gif';
				document.forms[j].action='';
				
				}
			}
			sup_em_all(<?php echo $obj; ?>,<?php echo $start; ?>);
			</script><?php
			}
}
//
//END  Tableau de présentation du ladder
//
//
// Tableau mylad
//
else if ($op == "see_mylad" && is_numeric($lad_id)) {
										
																				

	
	$db->select("*");
	$db->from("${dbprefix}ladder_data WHERE id='$lad_id'");
	$db->exec();
	$lad_while=$db->fetch();
	if ($lad_while->close) {$close="A";}else{$close=NULL;}
	$lad_type=$lad_while->ladder_type;

	
	
	echo '

					<table class="lad_table"  border="0" cellpadding="0" cellspacing="0">
						
						  <tbody>
						
							<tr class="ladder_back">
						
							  <td class="ladder_onglet" style="width: 9px; height: 26px;"></td>
						
							   <td class="ladder_onglet" style="height: 26px; text-align: left; vertical-align: bottom; width: 200x;" rowspan="1" colspan="2">';
							  if ($lad_while->ladder_type=='1'||$lad_while->ladder_type==1) {
							  echo '<a href="?page=ladder&op=player_lad&lad_id='.$lad_while->id.'"><img  alt="player" src="themes/'.$s_theme.'/images/onglet_player_s.gif" align="top" border="0" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_player_s.gif\';"  onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_player.gif\';"/></a>';
							  }
							  else {
							  echo '<a href="?page=ladder&op=player_lad&lad_id='.$lad_while->id.'"><img  alt="player" src="themes/'.$s_theme.'/images/onglet_team_s.gif" align="top" border="0" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_team_s.gif\';"  onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_team.gif\';"/></a>';
							  }
							  echo '<a href="?page=ladder&op=match_lad&lad_id='.$lad_while->id.'"><img alt="match" src="themes/'.$s_theme.'/images/onglet_match_s.gif" align="top" border="0" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_match_s.gif\';"  onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_match.gif\';" /></a><a href="?page=ladder&op=rules_lad&lad_id='.$lad_while->id.'"><img alt="rule" src="themes/'.$s_theme.'/images/onglet_rule_s.gif" align="top" border="0" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_rule_s.gif\';"  onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_rule.gif\';"/></a></td>
						
							  <td class="ladder_onglet" style="width: 9px;"></td>
						
							  <td class="ladder_onglet" style="height: 26px; width: 45px;"></td>
						
							  <td class="ladder_onglet" style="width: 33px; height: 26px;"></td>
						
							  <td class="ladder_onglet" style="width: 33px; height: 26px;"></td>
							  
							  <td class="ladder_onglet" style="width: 26px; height: 26px;"></td>
								
							  <td class="ladder_onglet" style="width: 26px; height: 26px;"></td>
							  
							   <td class="ladder_onglet" style="width: 26px; height: 26px;"></td>
						
							  <td class="ladder_onglet" style="height: 26px; width: 33px;"></td>
						
							  <td class="ladder_onglet" style="height: 26px; width: 49px;"></td>
						
							 <td class="ladder_onglet" style="height: 13px; text-align: left; vertical-align: bottom;" rowspan="1" colspan="2">';
							  
							  if ($op=="admin" || ($grade['a']=='a'||$grade['b']=='b'||$grade['u']=='u')){
							  echo '<a href="?page=ladder&op=mod_lad&lad_id='.$lad_while->id.'"><img alt="edit" src="themes/'.$s_theme.'/images/onglet_e.gif" align="top" border="0" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_e_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_e.gif\';" /></a><a href="?page=ladder&op=del_lad&lad_id='.$lad_while->id.'"><img alt="delete" src="themes/'.$s_theme.'/images/onglet_x.gif" align="top" border="0" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_x_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_x.gif\';" /></a>';
							  }
							 
							  echo '</td>
						
							  <td></td>
						
							</tr>
						
							';
							
	

   echo' 					
   <tr class="ladder_back">
							  <td class="ladder_header_s" > </td>
						
							  <td class="ladder_header_r" ></td>
						
							  <td class="ladder_header_name"><small>['.$strLAD_my_match_p.']</small></td>
							  
							  <td colspan="11" class="ladder_header_r"></td>
							  <td class="ladder_header_e" > </td>
						
							</tr>';
							
	$lad_while= $db->fetch();
	$db->select("*");
	$db->from("${dbprefix}ladder_match");
	$db->where("ladder_id= $lad_id");
	$db->where("(j1= $s_joueur or j2= $s_joueur)and valide= 'D'");
	$db->order_by("date_x DESC");
	$res=$db->exec();
			
			$i_l_4=0;
			while ($lad_while = $db->fetch($res)) {
			
			//$date=strftime(DATESTRING1, $lad_while->date);
			
			
			
			$date=$lad_while->date;
			$date_up=strftime(DATESTRING1, $lad_while->date_up);
						
						if ($lad_while->j2 != $s_joueur ){
							$i_l_4++;
							echo '
							 <tr class="ladder_line" onmouseout="javascript:this.bgColor=\'#3c3c46\';" style="cursor: pointer;" onmouseover="javascript:this.bgColor=\'#999999\';" bgcolor="#3c3c46">

								  <td class="ladder_border"></td>
							
								  <td class="player_lad">&nbsp;&nbsp;<img src="themes/'.$s_theme.'/images/status_'.$lad_while->valide.'.gif" boder="0" alt="'.${$lad_while->valide}.'" title="'.${$lad_while->valide}.'" />
								  </td>
							
								  <td class="player_lad_name" colspan="2">';
								  
								  if ($lad_type == '1') {
								 echo show_joueur($lad_while->j1,"","","","left","player_lad_name").'&nbsp;&nbsp;&nbsp;<span class="player_lad_name">Vs</span>&nbsp;&nbsp;&nbsp;&nbsp;'.show_joueur($lad_while->j2,"","","","right","player_lad_name").' &nbsp;&nbsp;&nbsp;';
								  } else{
								 echo show_equipe($lad_while->t1_id,"","","","left","player_lad_name").'&nbsp;&nbsp;&nbsp;<span class="player_lad_name">Vs</span>&nbsp;&nbsp;&nbsp;&nbsp;'.show_equipe($lad_while->t2_id,"","","","right","player_lad_name").' &nbsp;&nbsp;&nbsp;';
								  }
								  echo '</td>';
								  
									if ($lad_while->s1 > $lad_while->s2) {
									echo '<td colspan="3" class="player_lad">
									<table border="0" cellpadding="0" cellspacing="0"><tr>
									<td class="winmatch" width="15" align="center">'.$lad_while->s1.'</td>
									<td class="player_lad" width="10" align="center"> - </td>
									<td class="loosematch" width="15" align="center">'.$lad_while->s2.'</td>
									</td></tr></table>
									</td>';
									} else if ($lad_while->s2 > $lad_while->s1) {
									echo '<td colspan="3" class="player_lad">
									<table border="0" cellpadding="0" cellspacing="0"><tr>
									<td class="loosematch" width="15" align="center">'.$lad_while->s1.'</td>
									<td class="player_lad" width="10" align="center"> - </td>
									<td class="winmatch" width="15" align="center">'.$lad_while->s2.'</td>
									</td></tr></table>
									</td>';
									} else {
									echo '<td colspan="3" class="player_lad">
									<table border="0" cellpadding="0" cellspacing="0"><tr>
									<td class="nullmatch" width="15" align="center">'.$lad_while->s1.'</td>
									<td class="player_lad" width="10" align="center"> - </td>
									<td class="nullmatch" width="15" align="center">'.$lad_while->s2.'</td>
									</td></tr></table>
									</td>';
									}
								  
								   echo ' <td colspan="5" class="lad_date" >'.$date.'&nbsp;&nbsp; - &nbsp;&nbsp;('.$date_up.')</td>
							
								  <td class="player_lad" colspan="2" align="right">
								  <a href="?page=ladder&op=match_report&lad_id='.$lad_id.'&m_id='.$lad_while->id.'"><img src="themes/'.$s_theme.'/images/search.gif" alt="'.$strRechercher.'" border="0" /></a>
								  <a href="?page=ladder&op=report_lad&lad_id='.$lad_id.'&m_id='.$lad_while->id.'"><img src="themes/'.$s_theme.'/images/report.gif" alt="'.$strLADRapport.'" border="0" /></a>';
								  if ($lad_while->j2 == $s_joueur){
								  	Echo '
								  <a href="?page=ladder&op=agree&lad_id='.$lad_id.'&m_id='.$lad_while->id.'"><img alt="agree" src="themes/'.$s_theme.'/images/lad_val.gif" border="0" /></a>';
									}
								  if ($op=="admin" || ($grade['a']=='a'||$grade['b']=='b'||$grade['u']=='u')) {
								  echo '<a href="?page=ladder&op=del_match&lad_id='.$lad_id.'&m_id='.$lad_while->id.'"><img src="themes/'.$s_theme.'/images/lad_delete.gif" alt="'.$strEffacer.'" border="0" /></a>';
									echo '<a href="?page=ladder&op=match_report&lad_id='.$lad_id.'&m_id='.$lad_while->id.'&ad=ad"><img src="themes/'.$s_theme.'/images/lad_edit.gif" alt="'.$strEditer.'" border="0" /></a>';
								 }
								  echo '
								&nbsp;</td>
							
								<td class="ladder_border"></td>
							
							</tr>';
							}
							}
							if ($i_l_4==0) {
							echo '
							 <tr class="ladder_line" onmouseout="javascript:this.bgColor=\'#3c3c46\';" style="cursor: pointer;" onmouseover="javascript:this.bgColor=\'#999999\';" bgcolor="#3c3c46">

								  <td class="ladder_border"></td>
							
								  <td class="player_lad" colspan="13">'.$strLAD_nodata_for_match.'</td>
							
									<td class="ladder_border"></td>
							
							</tr>';
							}
   
							echo '<tr class="ladder_back">
							  <td class="ladder_header_s" > </td>
						
							  <td class="ladder_header_r" ></td>
						
							  <td class="ladder_header_name"><small>['.$strLAD_myunmatch.']</small></td>
							  
							  <td colspan="11" class="ladder_header_r"></td>
							  <td class="ladder_header_e" > </td>
						
							</tr>';
							
	$lad_while= $db->fetch();
	$db->select("*");
	$db->from("${dbprefix}ladder_match");
	$db->where("ladder_id= $lad_id");
	$db->where("(j1= $s_joueur or j2= $s_joueur) and (valide= 'X' or valide = 'A')");
	$db->order_by("date_x DESC");
	$res=$db->exec();
			
			$i_l_2=0;
			while ($lad_while = $db->fetch($res)) {
			
			//$date=strftime(DATESTRING1, $lad_while->date);
			
			
			
			$date=$lad_while->date;
			$date_up=strftime(DATESTRING1, $lad_while->date_up);
						
						if (($lad_while->j1 == $s_joueur && $lad_while->valide=='X') || ($lad_while->j2 == $s_joueur && $lad_while->valide=='A')){
							$i_l_2++;
							echo '
							 <tr class="ladder_line" onmouseout="javascript:this.bgColor=\'#3c3c46\';" style="cursor: pointer;" onmouseover="javascript:this.bgColor=\'#999999\';" bgcolor="#3c3c46">

								  <td class="ladder_border"></td>
							
								  <td class="player_lad">&nbsp;&nbsp;<img src="themes/'.$s_theme.'/images/status_'.$lad_while->valide.'.gif" boder="0" alt="'.${$lad_while->valide}.'" title="'.${$lad_while->valide}.'" />
								  </td>
							
								  <td class="player_lad_name" colspan="2">';
								  
								  if ($lad_type == '1') {
								 echo show_joueur($lad_while->j1,"","","","left","player_lad_name").'&nbsp;&nbsp;&nbsp;<span class="player_lad_name">Vs</span>&nbsp;&nbsp;&nbsp;&nbsp;'.show_joueur($lad_while->j2,"","","","right","player_lad_name").' &nbsp;&nbsp;&nbsp;';
								  } else{
								 echo show_equipe($lad_while->t1_id,"","","","left","player_lad_name").'&nbsp;&nbsp;&nbsp;<span class="player_lad_name">Vs</span>&nbsp;&nbsp;&nbsp;&nbsp;'.show_equipe($lad_while->t2_id,"","","","right","player_lad_name").' &nbsp;&nbsp;&nbsp;';
								  }
								  echo '</td>';
								  
									if ($lad_while->s1 > $lad_while->s2) {
									echo '<td colspan="3" class="player_lad">
									<table border="0" cellpadding="0" cellspacing="0"><tr>
									<td class="winmatch" width="15" align="center">'.$lad_while->s1.'</td>
									<td class="player_lad" width="10" align="center"> - </td>
									<td class="loosematch" width="15" align="center">'.$lad_while->s2.'</td>
									</td></tr></table>
									</td>';
									} else if ($lad_while->s2 > $lad_while->s1) {
									echo '<td colspan="3" class="player_lad">
									<table border="0" cellpadding="0" cellspacing="0"><tr>
									<td class="loosematch" width="15" align="center">'.$lad_while->s1.'</td>
									<td class="player_lad" width="10" align="center"> - </td>
									<td class="winmatch" width="15" align="center">'.$lad_while->s2.'</td>
									</td></tr></table>
									</td>';
									} else {
									echo '<td colspan="3" class="player_lad">
									<table border="0" cellpadding="0" cellspacing="0"><tr>
									<td class="nullmatch" width="15" align="center">'.$lad_while->s1.'</td>
									<td class="player_lad" width="10" align="center"> - </td>
									<td class="nullmatch" width="15" align="center">'.$lad_while->s2.'</td>
									</td></tr></table>
									</td>';
									}
								  
								   echo ' <td colspan="5" class="lad_date" >'.$date.'&nbsp;&nbsp; - &nbsp;&nbsp;('.$date_up.')</td>
							
								  <td class="player_lad" colspan="2" align="right">
								  <a href="?page=ladder&op=match_report&lad_id='.$lad_id.'&m_id='.$lad_while->id.'"><img src="themes/'.$s_theme.'/images/search.gif" alt="'.$strRechercher.'" border="0" /></a>
								  <a href="?page=ladder&op=report_lad&lad_id='.$lad_id.'&m_id='.$lad_while->id.'"><img src="themes/'.$s_theme.'/images/report.gif" alt="'.$strLADRapport.'" border="0" /></a>';
								  if ($op=="admin" || ($grade['a']=='a'||$grade['b']=='b'||$grade['u']=='u')) {
								  echo '<a href="?page=ladder&op=del_match&lad_id='.$lad_id.'&m_id='.$lad_while->id.'"><img src="themes/'.$s_theme.'/images/lad_delete.gif" alt="'.$strEffacer.'" border="0" /></a>';
								  echo '<a href="?page=ladder&op=match_report&lad_id='.$lad_id.'&m_id='.$lad_while->id.'&ad=ad"><img src="themes/'.$s_theme.'/images/lad_edit.gif" alt="'.$strEditer.'" border="0" /></a>';
								  }
								  echo '
								&nbsp;</td>
							
								<td class="ladder_border"></td>
							
							</tr>';
							}
							}
							if ($i_l_2==0) {
							echo '
							 <tr class="ladder_line" onmouseout="javascript:this.bgColor=\'#3c3c46\';" style="cursor: pointer;" onmouseover="javascript:this.bgColor=\'#999999\';" bgcolor="#3c3c46">

								  <td class="ladder_border"></td>
							
								  <td class="player_lad" colspan="13">'.$strLAD_nodata_for_match.'</td>
							
									<td class="ladder_border"></td>
							
							</tr>';
							}

      echo' 
							<tr class="ladder_back">
							  <td class="ladder_header_s" > </td>
						
							  <td class="ladder_header_r" ></td>
						
							  <td class="ladder_header_name"><small>['.$strLAD_myvmatch.']</small></td>
							  
							  <td colspan="11" class="ladder_header_r"></td>
							  <td class="ladder_header_e" > </td>
						
							</tr>';
							
	$lad_while= $db->fetch();
	$db->select("*");
	$db->from("${dbprefix}ladder_match");
	$db->where("ladder_id= $lad_id");
	$db->where("(j1= $s_joueur or j2= $s_joueur) and valide= 'B'");
	$db->order_by("date_x DESC");
	$res=$db->exec();
			
			$i_l_2=0;
			while ($lad_while = $db->fetch($res)) {
			$i_l_2++;
			//$date=strftime(DATESTRING1, $lad_while->date);
			
			
			
			$date=$lad_while->date;
			$date_up=strftime(DATESTRING1, $lad_while->date_up);
						
							echo '
							 <tr class="ladder_line" onmouseout="javascript:this.bgColor=\'#3c3c46\';" style="cursor: pointer;" onmouseover="javascript:this.bgColor=\'#999999\';" bgcolor="#3c3c46">

								  <td class="ladder_border"></td>
							
								  <td class="player_lad">&nbsp;&nbsp;<img src="themes/'.$s_theme.'/images/status_'.$lad_while->valide.'.gif" boder="0" alt="'.${$lad_while->valide}.'" title="'.${$lad_while->valide}.'" />
								  </td>
							
								  <td class="player_lad_name" colspan="2">';
								  
								  if ($lad_type == '1') {
								 echo show_joueur($lad_while->j1,"","","","left","player_lad_name").'&nbsp;&nbsp;&nbsp;<span class="player_lad_name">Vs</span>&nbsp;&nbsp;&nbsp;&nbsp;'.show_joueur($lad_while->j2,"","","","right","player_lad_name").' &nbsp;&nbsp;&nbsp;';
								  } else{
								 echo show_equipe($lad_while->t1_id,"","","","left","player_lad_name").'&nbsp;&nbsp;&nbsp;<span class="player_lad_name">Vs</span>&nbsp;&nbsp;&nbsp;&nbsp;'.show_equipe($lad_while->t2_id,"","","","right","player_lad_name").' &nbsp;&nbsp;&nbsp;';
								  }
								  echo '</td>';
								  
									if ($lad_while->s1 > $lad_while->s2) {
									echo '<td colspan="3" class="player_lad">
									<table border="0" cellpadding="0" cellspacing="0"><tr>
									<td class="winmatch" width="15" align="center">'.$lad_while->s1.'</td>
									<td class="player_lad" width="10" align="center"> - </td>
									<td class="loosematch" width="15" align="center">'.$lad_while->s2.'</td>
									</td></tr></table>
									</td>';
									} else if ($lad_while->s2 > $lad_while->s1) {
									echo '<td colspan="3" class="player_lad">
									<table border="0" cellpadding="0" cellspacing="0"><tr>
									<td class="loosematch" width="15" align="center">'.$lad_while->s1.'</td>
									<td class="player_lad" width="10" align="center"> - </td>
									<td class="winmatch" width="15" align="center">'.$lad_while->s2.'</td>
									</td></tr></table>
									</td>';
									} else {
									echo '<td colspan="3" class="player_lad">
									<table border="0" cellpadding="0" cellspacing="0"><tr>
									<td class="nullmatch" width="15" align="center">'.$lad_while->s1.'</td>
									<td class="player_lad" width="10" align="center"> - </td>
									<td class="nullmatch" width="15" align="center">'.$lad_while->s2.'</td>
									</td></tr></table>
									</td>';
									}
								  
								   echo ' <td colspan="5" class="lad_date" >'.$date.'&nbsp;&nbsp; - &nbsp;&nbsp;('.$date_up.')</td>
							
								  <td class="player_lad" colspan="2" align="right">
								  <a href="?page=ladder&op=match_report&lad_id='.$lad_id.'&m_id='.$lad_while->id.'"><img src="themes/'.$s_theme.'/images/search.gif" alt="'.$strRechercher.'" border="0" /></a>
								  <a href="?page=ladder&op=report_lad&lad_id='.$lad_id.'&m_id='.$lad_while->id.'"><img src="themes/'.$s_theme.'/images/report.gif" alt="'.$strLADRapport.'" border="0" /></a>';
								  if ($op=="admin" || ($grade['a']=='a'||$grade['b']=='b'||$grade['u']=='u')) {
								  echo '<a href="?page=ladder&op=del_match&lad_id='.$lad_id.'&m_id='.$lad_while->id.'"><img src="themes/'.$s_theme.'/images/lad_delete.gif" alt="'.$strEffacer.'" border="0" /></a>';
								   echo '<a href="?page=ladder&op=match_report&lad_id='.$lad_id.'&m_id='.$lad_while->id.'&ad=ad"><img src="themes/'.$s_theme.'/images/lad_edit.gif" alt="'.$strEditer.'" border="0" /></a>';
								 
								  }
								  echo '
								&nbsp;</td>
							
								<td class="ladder_border"></td>
							
							</tr>';
							
							}
							if ($i_l_2==0) {
							echo '
							 <tr class="ladder_line" onmouseout="javascript:this.bgColor=\'#3c3c46\';" style="cursor: pointer;" onmouseover="javascript:this.bgColor=\'#999999\';" bgcolor="#3c3c46">

								  <td class="ladder_border"></td>
							
								  <td class="player_lad" colspan="13">'.$strLAD_nodata_for_match.'</td>
							
									<td class="ladder_border"></td>
							
							</tr>';
							}
							
							      echo' 
							<tr class="ladder_back">
							  <td class="ladder_header_s" > </td>
						
							  <td class="ladder_header_r" ></td>
						
							  <td class="ladder_header_name"><small>['.$strLAD_mytmatch.']</small></td>
							  
							  <td colspan="11" class="ladder_header_r"></td>
							  <td class="ladder_header_e" > </td>
						
							</tr>';
							
	$lad_while= $db->fetch();
	$db->select("*");
	$db->from("${dbprefix}ladder_match");
	$db->where("ladder_id= $lad_id");
	$db->where("(j1= $s_joueur or j2= $s_joueur) and valide= 'V' ");
	$db->order_by("date_x DESC");
	$res=$db->exec();
			
			$i_l_2=0;
			while ($lad_while = $db->fetch($res)) {
			$i_l_2++;
			//$date=strftime(DATESTRING1, $lad_while->date);
			
			
			
			$date=$lad_while->date;
			$date_up=strftime(DATESTRING1, $lad_while->date_up);
						
							echo '<form method="post" action="?page=ladder&op=del_match_j">
							 <tr class="ladder_line" onmouseout="javascript:this.bgColor=\'#3c3c46\';" style="cursor: pointer;" onmouseover="javascript:this.bgColor=\'#999999\';" bgcolor="#3c3c46">

								  <td class="ladder_border"></td>
							
								  <td class="player_lad">&nbsp;&nbsp;<img src="themes/'.$s_theme.'/images/status_'.$lad_while->valide.'.gif" boder="0" alt="'.${$lad_while->valide}.'" title="'.${$lad_while->valide}.'" />
								  </td>
							
								  <td class="player_lad_name" colspan="2">';
								  
								  if ($lad_type == '1') {
								 echo show_joueur($lad_while->j1,"","","","left","player_lad_name").'&nbsp;&nbsp;&nbsp;<span class="player_lad_name">Vs</span>&nbsp;&nbsp;&nbsp;&nbsp;'.show_joueur($lad_while->j2,"","","","right","player_lad_name").' &nbsp;&nbsp;&nbsp;';
								  } else{
								 echo show_equipe($lad_while->t1_id,"","","","left","player_lad_name").'&nbsp;&nbsp;&nbsp;<span class="player_lad_name">Vs</span>&nbsp;&nbsp;&nbsp;&nbsp;'.show_equipe($lad_while->t2_id,"","","","right","player_lad_name").' &nbsp;&nbsp;&nbsp;';
								  }
								  echo '</td>'; 
								  
									if ($lad_while->s1 > $lad_while->s2) {
									echo '<td colspan="3" class="player_lad">
									<table border="0" cellpadding="0" cellspacing="0"><tr>
									<td class="winmatch" width="15" align="center">'.$lad_while->s1.'</td>
									<td class="player_lad" width="10" align="center"> - </td>
									<td class="loosematch" width="15" align="center">'.$lad_while->s2.'</td>
									</td></tr></table>
									</td>';
									} else if ($lad_while->s2 > $lad_while->s1) {
									echo '<td colspan="3" class="player_lad">
									<table border="0" cellpadding="0" cellspacing="0"><tr>
									<td class="loosematch" width="15" align="center">'.$lad_while->s1.'</td>
									<td class="player_lad" width="10" align="center"> - </td>
									<td class="winmatch" width="15" align="center">'.$lad_while->s2.'</td>
									</td></tr></table>
									</td>';
									} else {
									echo '<td colspan="3" class="player_lad">
									<table border="0" cellpadding="0" cellspacing="0"><tr>
									<td class="nullmatch" width="15" align="center">'.$lad_while->s1.'</td>
									<td class="player_lad" width="10" align="center"> - </td>
									<td class="nullmatch" width="15" align="center">'.$lad_while->s2.'</td>
									</td></tr></table>
									</td>';
									}
								  
								   echo ' <td colspan="5" class="lad_date" >'.$date.'&nbsp;&nbsp; - &nbsp;&nbsp;('.$date_up.')</td>
							
								  <td class="player_lad" colspan="2" align="right">
								  <a href="?page=ladder&op=match_report&lad_id='.$lad_id.'&m_id='.$lad_while->id.'"><img src="themes/'.$s_theme.'/images/search.gif" alt="'.$strRechercher.'" border="0" /></a>
								  <a href="?page=ladder&op=report_lad&lad_id='.$lad_id.'&m_id='.$lad_while->id.'"><img src="themes/'.$s_theme.'/images/report.gif" alt="'.$strLADRapport.'" border="0" /></a>';
								
								 echo '<input type="hidden" name="m_id" value="'.$lad_while->id.'"><input type="hidden" name="lad_id" value="'.$lad_id.'">';
								 
								  echo '<input type="image" src="themes/'.$s_theme.'/images/lad_delete.gif" alt="'.$strEffacer.'" border="0" />';
							
								  if ($op=="admin" || ($grade['a']=='a'||$grade['b']=='b'||$grade['u']=='u')) {
								   echo '<a href="?page=ladder&op=match_report&lad_id='.$lad_id.'&m_id='.$lad_while->id.'&ad=ad"><img src="themes/'.$s_theme.'/images/lad_edit.gif" alt="'.$strEditer.'" border="0" /></a>';
								 }
								  echo '
								&nbsp;</td>
							
								<td class="ladder_border"></td>
							
							</tr></form>';
							
							}
							if ($i_l_2==0) {
							echo '
							 <tr class="ladder_line" onmouseout="javascript:this.bgColor=\'#3c3c46\';" style="cursor: pointer;" onmouseover="javascript:this.bgColor=\'#999999\';" bgcolor="#3c3c46">

								  <td class="ladder_border"></td>
							
								  <td class="player_lad" colspan="13">'.$strLAD_nodata_for_match.'</td>
							
									<td class="ladder_border"></td>
							
							</tr>';
							}
							
							
							echo'<tr class="ladder_back">

											<td class="ladder_header_s" style="width: 9px; height: 26px;" ></td>
	
											<td class="ladder_header_r" colspan="2" rowspan="1" style="width: 172px;">
											
											<td class="ladder_header_r" style="width: 16px;" ></td>
										
											<td class="ladder_header_r" style="width: 45px;" ></td>
										
											<td class="ladder_header_r" style="width: 33px;" ></td>
										
											<td class="ladder_header_r" style="width: 33px;" ></td>
										
											<td class="ladder_header_r" style="width: 33px;" ></td>
										
											<td class="ladder_header_r" style="width: 33px;" </td>
										
											<td class="ladder_header_r" colspan="5" rowspan="1" style="text-align: right;"></td>
										
											<td class="ladder_header_e" style="width: 9px;" ></td>
								
										</tr>

  </tbody>
</table>';
}
//
// Affichage des ladder/MATCH
//
else if ($op == "match_lad" && is_numeric($lad_id)) {

										//test d'appartenance
										if ($s_joueur) {
										$db->select("ladder_id,joueur_id");
										$db->from("${dbprefix}lad_part");
										$db->where("ladder_id = $lad_id AND joueur_id = $s_joueur");
										$res=$db->exec();	
										if ($db->num_rows($res) != 0) {$lad_ap="oui";} else {$lad_ap="non";}
										} else {
										$lad_ap="no";
										}
	$db->select("*");
	$db->from("${dbprefix}ladder_data");
	$db->where("id='$lad_id'");
	$res=$db->exec();
			
			while ($lad_while = $db->fetch($res)) {
			if ($lad_while->close) {$close="A";}else{$close=NULL;}
			$lad_type=$lad_while->ladder_type;
			
			

					echo '
					<table class="lad_table"  border="0" cellpadding="0" cellspacing="0">
						
						  <tbody>
						
							<tr class="ladder_back">
						
							  <td class="ladder_onglet" style="width: 9px; height: 26px;"></td>
						
							   <td class="ladder_onglet" style="height: 26px; text-align: left; vertical-align: bottom; width: 200x;" rowspan="1" colspan="2">';
							  if ($lad_while->ladder_type=='1'||$lad_while->ladder_type==1) {
							  echo '<a href="?page=ladder&op=player_lad&lad_id='.$lad_while->id.'"><img  alt="player" src="themes/'.$s_theme.'/images/onglet_player_s.gif" align="top" border="0" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_player_s.gif\';"  onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_player.gif\';"/></a>';
							  }
							  else {
							  echo '<a href="?page=ladder&op=player_lad&lad_id='.$lad_while->id.'"><img  alt="player" src="themes/'.$s_theme.'/images/onglet_team_s.gif" align="top" border="0" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_team_s.gif\';"  onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_team.gif\';"/></a>';
							  }
							  echo '<a href="?page=ladder&op=match_lad&lad_id='.$lad_while->id.'"><img alt="match" src="themes/'.$s_theme.'/images/onglet_match.gif" align="top" border="0" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_match.gif\';"  onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_match_s.gif\';" /></a><a href="?page=ladder&op=rules_lad&lad_id='.$lad_while->id.'"><img alt="rule" src="themes/'.$s_theme.'/images/onglet_rule_s.gif" align="top" border="0" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_rule_s.gif\';"  onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_rule.gif\';"/></a></td>
						
							  <td class="ladder_onglet" style="height: 26px; width: 45px;"></td>
						
							  <td class="ladder_onglet" style="width: 33px; height: 26px;"></td>
						
							  <td class="ladder_onglet" style="width: 33px; height: 26px;"></td>
						
							  <td class="ladder_onglet" style="width: 26px; height: 26px;"></td>
						
							  <td class="ladder_onglet" style="height: 26px; width: 33px;"></td>
						
							  <td class="ladder_onglet" style="height: 26px; width: 49px;"></td>
						
							 <td class="ladder_onglet" style="height: 13px; text-align: left; vertical-align: bottom;" rowspan="1" colspan="2">';
							  
							  if ($op=="admin" || ($grade['a']=='a'||$grade['b']=='b'||$grade['u']=='u')){
							  echo '<a href="?page=ladder&op=mod_lad&lad_id='.$lad_while->id.'"><img alt="edit" src="themes/'.$s_theme.'/images/onglet_e.gif" align="top" border="0" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_e_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_e.gif\';" /></a><a href="?page=ladder&op=del_lad&lad_id='.$lad_while->id.'"><img alt="delete" src="themes/'.$s_theme.'/images/onglet_x.gif" align="top" border="0" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_x_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_x.gif\';" /></a>';
							  }
							 
							  echo '</td>
						
							  <td class="ladder_back"></td>
						
							</tr>
							<tr class="ladder_back">
							  <td class="ladder_header_s" > </td>
						
							  <td class="ladder_header_r" style="height: 26px; text-align: center; width: 48px;" background="images/onglet_repeat.gif"><img style="width: 18px; height: 18px;" alt="nsicon" src="images/jeux/'.$lad_while->jeux.'" align="middle" /></td>
						
							  <td class="ladder_header_name" style="height: 26px; font-weight: bold; width: 170px;">'.$lad_while->ladder_name.' </td>
							  
							  <td colspan="8" class="ladder_header_r"></td>
							  <td class="ladder_header_e"> </td>
						
							</tr>';
							}//while
	$lad_while= $db->fetch();
	$db->select("*");
	$db->from("${dbprefix}ladder_match");
	$db->where("ladder_id= $lad_id ");
	$db->order_by("date_x DESC");
	$res=$db->exec();
			
			$i=0;
			while ($lad_while = $db->fetch($res)) {
			//if ($lad_while->ladder_id!='' || $lad_while->ladder_id!=NULL){$lad_test="1";}
			$i++;
			//$date=strftime(DATESTRING1, $lad_while->date);
			$date=$lad_while->date;
			$date_up=strftime(DATESTRING1, $lad_while->date_up);
						
							echo '
							 <tr class="ladder_line" onmouseout="javascript:this.bgColor=\'#3c3c46\';" style="cursor: pointer;" onmouseover="javascript:this.bgColor=\'#999999\';" bgcolor="#3c3c46">

								  <td class="ladder_border"></td>
							
								  <td class="player_lad">  <img src="themes/'.$s_theme.'/images/status_'.$lad_while->valide.'.gif" boder="0" alt="'.${$lad_while->valide}.'" title="'.${$lad_while->valide}.'" />
								  </td>
							
								  <td class="player_lad_name">';
								  
								  if ($lad_type == '1') {
								 echo show_joueur($lad_while->j1,"","","","left","player_lad_name").'&nbsp;&nbsp;&nbsp;<span class="player_lad_name">Vs</span>&nbsp;&nbsp;&nbsp;&nbsp;'.show_joueur($lad_while->j2,"","","","right","player_lad_name").' &nbsp;&nbsp;&nbsp;';
								  } else{
								 echo show_equipe($lad_while->t1_id,"","","","left","player_lad_name").'&nbsp;&nbsp;&nbsp;<span class="player_lad_name">Vs</span>&nbsp;&nbsp;&nbsp;&nbsp;'.show_equipe($lad_while->t2_id,"","","","right","player_lad_name").' &nbsp;&nbsp;&nbsp;';
								  }
								  echo '</td>';
								  
									if ($lad_while->s1 > $lad_while->s2) {
									echo '<td colspan="2" class="player_lad">
									<table border="0" cellpadding="0" cellspacing="0"><tr>
									<td class="winmatch" width="15" align="center">'.$lad_while->s1.'</td>
									<td class="player_lad" width="10" align="center"> - </td>
									<td class="loosematch" width="15" align="center">'.$lad_while->s2.'</td>
									</td></tr></table>
									</td>';
									} else if ($lad_while->s2 > $lad_while->s1) {
									echo '<td colspan="2" class="player_lad">
									<table border="0" cellpadding="0" cellspacing="0"><tr>
									<td class="loosematch" width="15" align="center">'.$lad_while->s1.'</td>
									<td class="player_lad" width="10" align="center"> - </td>
									<td class="winmatch" width="15" align="center">'.$lad_while->s2.'</td>
									</td></tr></table>
									</td>';
									} else {
									echo '<td colspan="2" class="player_lad">
									<table border="0" cellpadding="0" cellspacing="0"><tr>
									<td class="nullmatch" width="15" align="center">'.$lad_while->s1.'</td>
									<td class="player_lad" width="10" align="center"> - </td>
									<td class="nullmatch" width="15" align="center">'.$lad_while->s2.'</td>
									</td></tr></table>
									</td>';
									}
								  
								   echo ' <td colspan=4" class="lad_date" >'.$date.'&nbsp;&nbsp; - &nbsp;&nbsp;('.$date_up.')</td>
							
								  <td class="player_lad" colspan="2">
								  <a href="?page=ladder&op=match_report&lad_id='.$lad_id.'&m_id='.$lad_while->id.'"><img src="themes/'.$s_theme.'/images/search.gif" alt="'.$strRechercher.'" border="0" /></a>
								  <a href="?page=ladder&op=report_lad&lad_id='.$lad_id.'&m_id='.$lad_while->id.'"><img src="themes/'.$s_theme.'/images/report.gif" alt="'.$strLADRapport.'" border="0" /></a>';
								  if ($op=="admin" || ($grade['a']=='a'||$grade['b']=='b'||$grade['u']=='u')) {
								  echo '<a href="?page=ladder&op=del_match&lad_id='.$lad_id.'&m_id='.$lad_while->id.'"><img src="themes/'.$s_theme.'/images/lad_delete.gif" alt="'.$strEffacer.'" border="0" /></a>';
								   echo '<a href="?page=ladder&op=match_report&lad_id='.$lad_id.'&m_id='.$lad_while->id.'&ad=ad"><img src="themes/'.$s_theme.'/images/lad_edit.gif" alt="'.$strEditer.'" border="0" /></a>';
								 
								  }
								  echo '
								</td>
							
								<td class="ladder_border"></td>
							
							</tr>';
								}
								
								if ($i==0){
								echo' <tr class="ladder_line" onmouseout="javascript:this.bgColor=\'#3c3c46\';" style="cursor: pointer;" onmouseover="javascript:this.bgColor=\'#999999\';" bgcolor="#3c3c46">

								  <td class="ladder_border"></td>
							
								 
								
								   <td colspan="10" class="player_lad" align="center">';
									echo '- '. $strLAD_nodata_match.' - ';
								   echo'</td>
							
																	
										<td class="ladder_border"></td>
									
									</tr>';
								}		
								
								
									echo '<tr class="ladder_back">

											<td class="ladder_header_s" style="width: 9px; height: 26px;" ></td>
	
											<td class="ladder_header_r" colspan="2" rowspan="1" style="width: 172px;">';
															
										
										if ($close and $lad_ap!='no') {
										echo '&nbsp;&nbsp;<img align="bottom" alt="closed" src="themes/'.$s_theme.'/images/lock.gif" align="top" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/lock_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/lock.gif\';"/></td>';
										} else if ($lad_ap=='oui' and $lad_ap!='no') {
										echo '&nbsp;&nbsp;<a href="?page=ladder&lad_id='.$lad_id.'&op=see_mylad"><img border="0" align="bottom" alt="status" src="themes/'.$s_theme.'/images/status.gif" align="top" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/status_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/status.gif\';"/></a></td>';
										}else if ($lad_ap!='no') {
										echo '&nbsp;&nbsp;<a href="?page=ladder&lad_id='.$lad_id.'&op=join_lad"><img border="0" align="bottom" alt="open" src="themes/'.$s_theme.'/images/join.gif" align="top" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/join_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/join.gif\';" /></a></td>';
										}
											echo '<td class="ladder_header_r" style="width: 16px;" ></td>
										
											<td class="ladder_header_r" style="width: 45px;" ></td>
										
											<td class="ladder_header_r" style="width: 33px;" ></td>
										
											<td class="ladder_header_r" style="width: 33px;" ></td>
										
											<td class="ladder_header_r" style="width: 33px;" ></td>
										
											<td class="ladder_header_r" style="width: 33px;" </td>
										
											<td class="ladder_header_r" colspan="2" rowspan="1" style="text-align: right;">
											';
											echo '&nbsp;&nbsp;<a href="?page=ladder&op=player_lad&lad_id='.$lad_id.'" onClick="javascript:alerter(\'?page=ladder&lad_id='.$lad_id.'&op=left_lad\',\''.$strLAD_wanttoleft.'\');"><img border="0" align="bottom" alt="left" src="themes/'.$s_theme.'/images/left.gif" align="top" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/left_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/left.gif\';" /></a>&nbsp;&nbsp;';
											echo '
											</td>
										
											<td class="ladder_header_e" style="width: 9px;" ></tdé>
								
										</tr>
								
									</tbody>
								</table>						
								';
								

			

}

//
// Affichage des ladder/PLAYER
//
else if ($op == "player_lad" && is_numeric($lad_id)) {

	$lad_test="0";
										//test d'appartenance
										if ($s_joueur) {
										$db->select("ladder_id,joueur_id");
										$db->from("${dbprefix}lad_part");
										$db->where("ladder_id = $lad_id AND joueur_id = $s_joueur");
										$res=$db->exec();	
										if ($db->num_rows($res) != 0) {$lad_ap="oui";} else {$lad_ap="non";}
										} else {
										$lad_ap="no";
										}
	
	//left join lad_part et ladder_data
	//$db->select("${dbprefix}ladder_data.*,${dbprefix}lad_part.*");
	//$db->from("${dbprefix}ladder_data LEFT JOIN ${dbprefix}lad_part on (${dbprefix}ladder_data.id = ${dbprefix}lad_part.ladder_id)");
	//$db->where("${dbprefix}ladder_data.id = $lad_id");
	//$db->exec();
	//$lad_while= $db->fetch();
	$db->select("*");
	$db->from("${dbprefix}ladder_data");
	$db->where("id='$lad_id'");
	$res=$db->exec();
			
			while ($lad_while = $db->fetch($res)) {
			if ($lad_while->close) {$close="A";}else{$close=NULL;}
			$new_data=$lad_while->new_data;
			$p_type=$lad_while->pourcent_type;
			$p_value=$lad_while->pourcent;
			$lad_type=$lad_while->ladder_type;
			
											
			

					echo '
					<table class="lad_table"  border="0" cellpadding="0" cellspacing="0">
						
						  <tbody>
						
							<tr class="ladder_back">
						
							  <td class="ladder_onglet" style="width: 9px; height: 26px;"></td>
						
							   <td class="ladder_onglet" style="height: 26px; text-align: left; vertical-align: bottom; width: 200x;" rowspan="1" colspan="2">';
							  if ($lad_while->ladder_type=='1'||$lad_while->ladder_type==1) {
							  echo '<a href="?page=ladder&op=player_lad&lad_id='.$lad_while->id.'"><img  alt="player" src="themes/'.$s_theme.'/images/onglet_player.gif" align="top" border="0" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_player.gif\';"  onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_player_s.gif\';"/></a>';
							  }
							  else {
							  echo '<a href="?page=ladder&op=player_lad&lad_id='.$lad_while->id.'"><img  alt="player" src="themes/'.$s_theme.'/images/onglet_team.gif" align="top" border="0" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_team.gif\';"  onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_team_s.gif\';"/></a>';
							  }
							  echo '<a href="?page=ladder&op=match_lad&lad_id='.$lad_while->id.'"><img alt="match" src="themes/'.$s_theme.'/images/onglet_match_s.gif" align="top" border="0" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_match_s.gif\';"  onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_match.gif\';" /></a><a href="?page=ladder&op=rules_lad&lad_id='.$lad_while->id.'"><img alt="rule" src="themes/'.$s_theme.'/images/onglet_rule_s.gif" align="top" border="0" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_rule_s.gif\';"  onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_rule.gif\';"/></a></td>
						
							  <td class="ladder_onglet" style="width: 9px;"></td>
						
							  <td class="ladder_onglet" style="height: 26px; width: 45px;"></td>
						
							  <td class="ladder_onglet" style="width: 33px; height: 26px;"></td>
						
							  <td class="ladder_onglet" style="width: 33px; height: 26px;"></td>
							  
							  <td class="ladder_onglet" style="width: 26px; height: 26px;"></td>
							  
							  <td class="ladder_onglet" style="width: 26px; height: 26px;"></td>
							  
							  <td class="ladder_onglet" style="width: 26px; height: 26px;"></td>
						
							  <td class="ladder_onglet" style="width: 26px; height: 26px;"></td>
						
							  <td class="ladder_onglet" style="height: 26px; width: 33px;"></td>
						
							  <td class="ladder_onglet" style="height: 26px; width: 49px;"></td>
						
							 <td class="ladder_onglet" style="height: 13px; text-align: left; vertical-align: bottom;" rowspan="1" colspan="2">';
							  
							  if ($op=="admin" || ($grade['a']=='a'||$grade['b']=='b'||$grade['u']=='u')){
							  echo '<a href="?page=ladder&op=mod_lad&lad_id='.$lad_while->id.'"><img alt="edit" src="themes/'.$s_theme.'/images/onglet_e.gif" align="top" border="0" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_e_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_e.gif\';" /></a><a href="?page=ladder&op=del_lad&lad_id='.$lad_while->id.'"><img alt="delete" src="themes/'.$s_theme.'/images/onglet_x.gif" align="top" border="0" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_x_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_x.gif\';" /></a>';
							  }
							 
							  echo '</td>
						
							  <td></td>
						
							</tr>
							<tr class="ladder_back">
							  <td class="ladder_header_s" style="width: 9px; height: 26px;"> </td>
						
							  <td class="ladder_header_r" style="height: 26px; text-align: center; width: 48px;" background="images/onglet_repeat.gif"><img style="width: 18px; height: 18px;" alt="nsicon" src="images/jeux/'.$lad_while->jeux.'" align="middle" /> </td>
						
							  <td class="ladder_header_r" style="height: 26px; width: 172px;"><span style="font-weight: bold; color: rgb(255, 255, 255);">'.$lad_while->ladder_name.'</span> </td>
						
							  <td class="ladder_header_r_txt" style="height: 26px; text-align: center;"> [E] </td>
						
							  <td class="ladder_header_r_txt" style="height: 26px; text-align: center; width: 45px; "> [P] </td>
						
							  <td class="ladder_header_r_txt" style="width: 33px; height: 26px; text-align: center; " > [W] </td>
						
							  <td class="ladder_header_r_txt" style="width: 33px; height: 26px; text-align: center; " > [L] </td>
						
							  <td class="ladder_header_r_txt" style="width: 33px; height: 26px; text-align: center;"> [D] </td>
							  
							  <td class="ladder_header_r_txt" style="width: 33px; height: 26px; text-align: center;"> [R] </td>
							  
							  <td class="ladder_header_r_txt" style="width: 33px; height: 26px; text-align: center;"> [A] </td>
							  
							  <td class="ladder_header_r_txt" style="width: 33px; height: 26px; text-align: center;"> [/] </td>
						
							  <td class="ladder_header_r_txt" style="height: 26px; text-align: center; width: 33px;" > [S] </td>
						
							  <td class="ladder_header_r_txt" style="height: 26px; text-align: center;  width: 49px;" > [F] </td>
						
							  <td class="ladder_header_r_txt" style="height: 26px; width: 78px;" > </td>
						
							  <td class="ladder_header_e" style="width: 9px; height: 26px;" background="themes/phptG4/images/onglet_end.gif"> </td>
						
							</tr>';
							}//while
	$lad_while= $db->fetch();
	$db->select("*");
	$db->from("${dbprefix}lad_part");
	$db->where("ladder_id= $lad_id ");
	$db->order_by("pts DESC");
	$res=$db->exec();
	
	
			
			$i=0;
			while ($lad_while = $db->fetch($res)) {
			//if ($lad_while->ladder_id!='' || $lad_while->ladder_id!=NULL){$lad_test="1";}
			$i++;
			
			if($lad_while->death==''||$lad_while->death==0||$lad_while->death=='0'){$div='1';}else{$div=$lad_while->death;}
			$ratio=round($lad_while->mort / $div, 2);
			
			
			if ($lad_while->rank != $i) {
			
			
			if ($lad_while->rank >  $i AND $new_data == '1') {

				$lvl='2';
				
				$db->update("${dbprefix}ladder_data");
				$db->set("new_data='0'");
				$db->where("id = $lad_id");
				$db->exec();
				
				$db->update("${dbprefix}lad_part");
				$db->set("lvl='$lvl'");
				$db->where("ladder_id = $lad_id AND joueur_id = $lad_while->joueur_id");
				$db->exec();
			
			}else if ($lad_while->rank <  $i AND $new_data == '1'){
				
				$lvl='1';
				
				$db->update("${dbprefix}ladder_data");
				$db->set("new_data='0'");
				$db->where("id = $lad_id");
				$db->exec();
				
				$db->update("${dbprefix}lad_part");
				$db->set("lvl='$lvl'");
				$db->where("ladder_id = $lad_id AND joueur_id = $lad_while->joueur_id");
				$db->exec();
			
			}else if ($new_data == '1'){
			
				$lvl='0';
				
				$db->update("${dbprefix}ladder_data");
				$db->set("new_data='0'");
				$db->where("id = $lad_id");
				$db->exec();
				
				$db->update("${dbprefix}lad_part");
				$db->set("lvl='$lvl'");
				$db->where("ladder_id = $lad_id AND joueur_id = $lad_while->joueur_id");
				$db->exec();
			
			} else {
			$lvl = $lad_while->lvl;
			}
			
			$rank = $i;
					

			

			$db->update("${dbprefix}lad_part");
			$db->set("rank='$i',lvl='$lvl'");
			$db->where("ladder_id = $lad_id AND joueur_id = $lad_while->joueur_id");
			$db->exec();
			
			
			} else {
			$rank = $lad_while->rank;
			$lvl='0';
			}
			
											
											$type_by_opo = '';
											if ($p_type == '1' AND $s_joueur == $lad_while->joueur_id) {
											
												$delta = ceil((nb_player($lad_id) * $p_value) / 100);
													$obj=2*($delta+1);
													$start=$rank-$delta;
													$type_by_opo = '1';
											
											} 
										
			
							echo '
							
							<tr class="ladder_line" onmouseout="javascript:this.bgColor=\'#3c3c46\';" style="cursor: pointer;" onmouseover="javascript:this.bgColor=\'#999999\';" bgcolor="#3c3c46">

										  <td class="ladder_border"></td>
									
										  ';
										  if ($rank == "1") {
										   echo'  <td class="player_lad"><img style="width: 16px; height: 13px;" alt="'.$i.'" src="themes/'.$s_theme.'/images/smallcup.gif" /> </td>';
										  } else if ($rank == "2") {
										   echo'  <td class="player_lad"><img style="width: 16px; height: 13px;" alt="'.$i.'" src="themes/'.$s_theme.'/images/smallcup_silver.gif" /> </td>';
										  } else if ($rank == "3") {
										   echo'  <td class="player_lad"><img style="width: 16px; height: 13px;" alt="'.$i.'" src="themes/'.$s_theme.'/images/smallcup_bronze.gif" /> </td>';
										  } else {
										  echo'  <td class="player_lad"> -'.$rank.'- </td>';
											}
											
											if ($lad_type == '1'){
											$lad_joueurs="";
											$db->select("*");
											$db->from("${dbprefix}joueurs");
											$db->where("id= $lad_while->joueur_id ");
											$res_joueurs=$db->exec();
											$lad_joueurs= $db->fetch($res_joueurs);
											echo '
										  <td class="player_lad_name">&nbsp;<img src="images/flags/'.$lad_joueurs->origine.'.gif" border="0" align="absmiddle" alt="'.$lad_joueurs->origine.'"> <a href="?page=joueurs&id='.$lad_while->joueur_id.'" ><span class="player_lad_name">'.$lad_joueurs->pseudo.' ('.$lad_joueurs->ext_cartegraphique.')</span></a>
										  </td>';
										  }else{
										  $lad_team="";
											$db->select("*");
											$db->from("${dbprefix}equipes");
											$db->where("id= $lad_while->teamid ");
											$res_team=$db->exec();	
											$lad_team= $db->fetch($res_team);
										  echo '
										  <td class="player_lad_name">&nbsp;<a href="?page=equipes&id='.$lad_while->teamid.'" ><span class="player_lad_name">'.$lad_team->nom.'</span> </a>
										  </td>';
										  }
											
											if ($lvl == "1") {
											echo '<td class="player_lad"><img style="width: 15px; height: 15px;" alt="plus" src="images/evo-.gif" /></td>';
											}
											else if ($lvl == "2") {
											echo '<td class="player_lad"><img style="width: 15px; height: 15px;" alt="plus" src="images/evo+.gif" /></td>';
											} else {
										    echo '<td class="player_lad"><img style="width: 15px; height: 15px;" alt="plus" src="images/evo=.gif" /></td>';
											}
											echo '
										  <td class="player_lad" >&nbsp;'.$lad_while->pts.'&nbsp;</td>
									
										  <td class="player_lad">&nbsp;'.$lad_while->w.'&nbsp;</td>
									
										  <td class="player_lad">&nbsp;'.$lad_while->l.'&nbsp;</td>
									
										  <td class="player_lad">&nbsp;'.$lad_while->d.'&nbsp;</td>
										  
										  <td class="player_lad">&nbsp;'.$lad_while->round_w.'&nbsp;</td>
										   
										  <td class="player_lad">&nbsp;'.$lad_while->round_l.'&nbsp;</td>
											
										  <td class="player_lad">&nbsp;'.$ratio.'&nbsp;</td>
									
										  <td class="player_lad">&nbsp;'.$lad_while->s.'&nbsp;</td>
									
										  <td class="player_lad">&nbsp;'.$lad_while->fairplay.'&nbsp;</td>';
											
											if ($lad_type == '1') {
											$adversaire=$lad_while->joueur_id;
											}else{
											$adversaire=$lad_while->teamid;
											}
											
											
											if ($lad_ap=='oui' and $lad_ap!='no' AND $s_joueur != '')
											{
											echo '<form method="post" name="'.$i.'" id="'.$i.'" action="?page=ladder&op=duel&lad_id='.$lad_id.'&d='.$lad_while->joueur_id.'">
							
											
										  <td class="player_lad">&nbsp;<input type="image" name="subm'.$i.'"  id="subm'.$i.'" src="themes/'.$s_theme.'/images/duel.gif">&nbsp;<input type="hidden" name="lad_id" value="'.$lad_id.'">
											<input type="hidden" name="d" value="'.$adversaire.'"></td>
											
											</form>';
											} else {
											echo'<td class="player_lad">&nbsp;<input type="image" src="themes/'.$s_theme.'/images/dueloff.gif">&nbsp;</td>';
											}
											
										  echo '<td class="ladder_border"></td>

									</tr>';
								}
								if ($i==0){
								echo' <tr class="ladder_line" onmouseout="javascript:this.bgColor=\'#3c3c46\';" style="cursor: pointer;" onmouseover="javascript:this.bgColor=\'#999999\';" bgcolor="#3c3c46">

								  <td class="ladder_border"></td>
							
								 
								
								   <td colspan="13" class="player_lad" align="center">';
									echo '- '. $strLAD_nodata_player.' - ';
								   echo'</td>
							
																	
										<td class="ladder_border"></td>
									
									</tr>';
								}	
									echo '<tr class="ladder_back">

											<td class="ladder_header_s" style="width: 9px; height: 26px;" ></td>
	
											<td class="ladder_header_r" colspan="2" rowspan="1" style="width: 172px;">';
															
										
										if ($close and $lad_ap!='no') {
										echo '&nbsp;&nbsp;<img align="bottom" alt="closed" src="themes/'.$s_theme.'/images/lock.gif" align="top" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/lock_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/lock.gif\';"/></td>';
										} else if ($lad_ap=='oui' and $lad_ap!='no') {
										echo '&nbsp;&nbsp;<a href="?page=ladder&lad_id='.$lad_id.'&op=see_mylad"><img border="0" align="bottom" alt="status" src="themes/'.$s_theme.'/images/status.gif" align="top" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/status_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/status.gif\';"/></a></td>';
										}else if ($lad_ap!='no') {
										echo '&nbsp;&nbsp;<a href="?page=ladder&lad_id='.$lad_id.'&op=join_lad"><img border="0" align="bottom" alt="open" src="themes/'.$s_theme.'/images/join.gif" align="top" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/join_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/join.gif\';" /></a></td>';
										}
											echo '<td class="ladder_header_r" style="width: 16px;" ></td>
										
											<td class="ladder_header_r" style="width: 45px;" ></td>
										
											<td class="ladder_header_r" style="width: 33px;" ></td>
										
											<td class="ladder_header_r" style="width: 33px;" ></td>
										
											<td class="ladder_header_r" style="width: 33px;" ></td>
										
											<td class="ladder_header_r" style="width: 33px;" </td>
										
											<td class="ladder_header_r" colspan="5" rowspan="1" style="text-align: right;">';
											echo '&nbsp;&nbsp;<a href="?page=ladder&op=player_lad&lad_id='.$lad_id.'" onClick="javascript:alerter(\'?page=ladder&lad_id='.$lad_id.'&op=left_lad\',\''.$strLAD_wanttoleft.'\');"><img border="0" align="bottom" alt="left" src="themes/'.$s_theme.'/images/left.gif" align="top" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/left_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/left.gif\';" /></a>&nbsp;&nbsp;';
										
											echo '</td>
											
											<td class="ladder_header_e" style="width: 9px;" ></td>
								
										</tr>
								
									</tbody>
								</table>						
								';
								
			
				
			
			
			if ($type_by_opo == '1'){
			?><script language="javascript">
			
			function sup_em_all(obj,s_t){
			
				o_j = obj+s_t
				for (var j=s_t;j<o_j;j++) {
				document.forms[j].elements[0].src='themes/<?php echo $s_theme ?>/images/dueloff.gif';
				document.forms[j].action='';
				
				}
			}
			sup_em_all(<?php echo $obj; ?>,<?php echo $start; ?>);
			</script><?php
			}

}
//
// Affichage des ladder/RULES
//
else  if ($op == "rules_lad" && is_numeric($lad_id)) {
	$lad_test="0";
	
										//test d'appartenance
										if ($s_joueur) {
										$db->select("ladder_id,joueur_id");
										$db->from("${dbprefix}lad_part");
										$db->where("ladder_id = $lad_id AND joueur_id = $s_joueur");
										$res=$db->exec();	
										if ($db->num_rows($res) != 0) {$lad_ap="oui";} else {$lad_ap="non";}
										} else {
										$lad_ap="no";
										}
	//left join lad_part et ladder_data
	$db->select("*");
	$db->from("${dbprefix}ladder_data");
	$db->where("id = $lad_id");
	$db->exec();
	$lad_while= $db->fetch();
	//$db->select("*");
	//$db->from("${dbprefix}lad_part");
	//$db->where("id='$lad_id'");
	//$res=$db->exec();
			
			//while ($lad_while = $db->fetch($res)) {
			
			if ($lad_while->reglement!='' || $lad_while->reglement!=NULL){$lad_test="1";}

					echo '
					<table class="lad_table"  border="0" cellpadding="0" cellspacing="0">
						
						  <tbody>
						
							<tr class="ladder_back">
						
							  <td class="ladder_onglet" style="width: 9px; height: 26px;"></td>
						
							  <td class="ladder_onglet" style="height: 13px; text-align: left; vertical-align: bottom;" rowspan="1" colspan="2">';
							  if ($lad_while->ladder_type=='1'||$lad_while->ladder_type==1) {
							  echo '<a href="?page=ladder&op=player_lad&lad_id='.$lad_while->id.'"><img  alt="player" src="themes/'.$s_theme.'/images/onglet_player_s.gif" align="top" border="0" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_player.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_player_s.gif\';"/></a>';
							  }
							  else {
							  echo '<a href="?page=ladder&op=player_lad&lad_id='.$lad_while->id.'"><img alt="player" src="themes/'.$s_theme.'/images/onglet_team_s.gif" align="top" border="0" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_team.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_team_s.gif\';" /></a>';
							  }
							  echo '<a href="?page=ladder&op=match_lad&lad_id='.$lad_while->id.'"><img alt="match" src="themes/'.$s_theme.'/images/onglet_match_s.gif" align="top" border="0" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_match.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_match_s.gif\';"/></a><a href="?page=ladder&op=rules_lad&lad_id='.$lad_while->id.'"><img alt="rule" src="themes/'.$s_theme.'/images/onglet_rule.gif" align="top" border="0" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_rule_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_rule.gif\';"/></a></td>
						
							  <td class="ladder_onglet" style="width: 9px;"></td>
						
							  <td class="ladder_onglet" style="height: 26px; width: 45px;"></td>
						
							  <td class="ladder_onglet" style="width: 33px; height: 26px;"></td>
						
							  <td class="ladder_onglet" style="width: 33px; height: 26px;"></td>
						
							  <td class="ladder_onglet" style="width: 26px; height: 26px;"></td>
						
							  <td class="ladder_onglet" style="height: 26px; width: 33px;"></td>
						
							  <td class="ladder_onglet" style="height: 26px; width: 49px;"></td>
						
							 <td class="ladder_onglet" style="height: 13px; text-align: left; vertical-align: bottom;" rowspan="1" colspan="2">';
							  
							  if ($op=="admin" || ($grade['a']=='a'||$grade['b']=='b'||$grade['u']=='u')){
							  echo '<a href="?page=ladder&op=mod_lad&lad_id='.$lad_while->id.'"><img alt="edit" src="themes/'.$s_theme.'/images/onglet_e.gif" align="top" border="0" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_e_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_e.gif\';" /></a><a href="?page=ladder&op=del_lad&lad_id='.$lad_while->id.'"><img alt="delete" src="themes/'.$s_theme.'/images/onglet_x.gif" align="top" border="0" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_x_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_x.gif\';" /></a>';
							  }
							  echo '</td>
						
							  <td></td>
						
							</tr>
						
							<tr class="ladder_back">
							  <td class="ladder_header_s" style="width: 9px; height: 26px;"> </td>
						
							  <td class="ladder_header_r" style="height: 26px; text-align: center; width: 48px;" background="images/onglet_repeat.gif"><img style="width: 18px; height: 18px;" alt="nsicon" src="images/jeux/'.$lad_while->jeux.'" align="middle" /> </td>
						
							  <td class="ladder_header_r" style="height: 26px; width: 172px;"><span style="font-weight: bold; color: rgb(255, 255, 255);">'.$lad_while->ladder_name.'</span> </td>
						
							  <td class="ladder_header_r_txt" style="height: 26px; text-align: center;"> </td>
						
							  <td class="ladder_header_rule" colspan="4" style="text-align: center; vertical-align: center; width: 45px; "> '.$strReglement.' </td>
											
							  <td class="ladder_header_r_txt" style="height: 26px; text-align: center; width: 33px;" >  </td>
						
							  <td class="ladder_header_r_txt" style="height: 26px; text-align: center;  width: 49px;" >  </td>
						
							  <td class="ladder_header_r_txt" style="height: 26px; width: 78px;" ></td>
						
							  <td class="ladder_header_e" style="width: 9px; height: 26px;" background="themes/phptG4/images/onglet_end.gif"> </td>
						
							</tr>
							<tr class="ladder_line" bgcolor="#3c3c46">

								  <td class="lad_site_back" ></td>
							
								  <td colspan="10" class="lad_rule">
								  <table  border="0" cellpadding="5" cellspacing="5"><tr><td class="lad_rule">
								'; 
								
								
								if ($lad_while->reglement != "")				
								{echo BBcode($lad_while->reglement);}else{echo '- '. $strLAD_nodata_rule.' - ';}	
								
								
								
								echo '<br /><br /></td>
								  </td></tr></table></td>
							
								  <td class="lad_site_back"></td>

									</tr>
									<tr class="ladder_back">

										<td class="ladder_header_s" style="width: 9px; height: 26px;" ></td>
	
											<td class="ladder_header_r" colspan="2" rowspan="1" style="width: 172px;"> &nbsp;';
										
										if ($close and $lad_ap!='no' and $s_joueur) {
										echo '&nbsp;&nbsp;<img align="bottom" alt="closed" src="themes/'.$s_theme.'/images/lock.gif" align="top" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/lock_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/lock.gif\';"/></td>';
										} else if ($lad_ap=='oui' and $lad_ap!='no' and $s_joueur) {
										echo '&nbsp;&nbsp;<a href="?page=ladder&lad_id='.$lad_id.'&op=see_mylad"><img border="0" align="bottom" alt="status" src="themes/'.$s_theme.'/images/status.gif" align="top" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/status_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/status.gif\';"/></a></td>';
										}else if ($lad_ap!='no' and $s_joueur) {
										echo '&nbsp;&nbsp;<a href="?page=ladder&lad_id='.$lad_id.'&op=join_lad"><img border="0" align="bottom" alt="open" src="themes/'.$s_theme.'/images/join.gif" align="top" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/join_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/join.gif\';" /></a></td>';
										}
										echo '</td>
										
											<td class="ladder_header_r" style="width: 16px;" ></td>
										
											<td class="ladder_header_r" style="width: 45px;" ></td>
										
											<td class="ladder_header_r" style="width: 33px;" ></td>
										
											<td class="ladder_header_r" style="width: 33px;" ></td>
										
											<td class="ladder_header_r" style="width: 33px;" ></td>
										
											<td class="ladder_header_r" style="width: 33px;" </td>
										
											<td class="ladder_header_r" colspan="2" rowspan="1" style="text-align: right;">';
											echo '&nbsp;&nbsp;<a href="?page=ladder&op=player_lad&lad_id='.$lad_id.'" onClick="javascript:alerter(\'?page=ladder&lad_id='.$lad_id.'&op=left_lad\',\''.$strLAD_wanttoleft.'\');"><img border="0" align="bottom" alt="left" src="themes/'.$s_theme.'/images/left.gif" align="top" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/left_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/left.gif\';" /></a>&nbsp;&nbsp;';
										
											
											echo '</td>
										
											<td class="ladder_header_e" style="width: 9px;" ></td>
								
										</tr>
								
									</tbody>
								</table>						
								';
								//}

		

}
//
// Affichage du rapoprt d'un match
//
else  if ($op == "report_lad" && is_numeric($lad_id) && is_numeric($m_id)) {  
	$lad_test="0";

	//left join lad_part et ladder_data
	$db->select("${dbprefix}ladder_data.*,${dbprefix}ladder_match.rapport");
	$db->from("${dbprefix}ladder_data LEFT JOIN ${dbprefix}ladder_match on (${dbprefix}ladder_data.id = ${dbprefix}ladder_match.ladder_id)");
	$db->where("${dbprefix}ladder_data.id = $lad_id AND ${dbprefix}ladder_match.ladder_id = $lad_id AND ${dbprefix}ladder_match.id = $m_id");
	$db->exec();
	$lad_while= $db->fetch();
			
			//while ($lad_while = $db->fetch($res)) {
			
			if ($lad_while->rapport!='' || $lad_while->rapport!=NULL){$lad_test="1";}

					echo '
					<table class="lad_table"  border="0" cellpadding="0" cellspacing="0">
						
						  <tbody>
						
							<tr class="ladder_back">
						
							  <td class="ladder_onglet" style="width: 9px; height: 26px;"></td>
						
							  <td class="ladder_onglet" style="height: 13px; text-align: left; vertical-align: bottom;" rowspan="1" colspan="2">';
							  if ($lad_while->ladder_type=='1'||$lad_while->ladder_type==1) {
							  echo '<a href="?page=ladder&op=player_lad&lad_id='.$lad_while->id.'"><img  alt="player" src="themes/'.$s_theme.'/images/onglet_player_s.gif" align="top" border="0" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_player.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_player_s.gif\';"/></a>';
							  }
							  else {
							  echo '<a href="?page=ladder&op=player_lad&lad_id='.$lad_while->id.'"><img alt="player" src="themes/'.$s_theme.'/images/onglet_team_s.gif" align="top" border="0" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_team.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_team_s.gif\';" /></a>';
							  }
							  echo '<a href="?page=ladder&op=match_lad&lad_id='.$lad_while->id.'"><img alt="match" src="themes/'.$s_theme.'/images/onglet_match_s.gif" align="top" border="0" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_match.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_match_s.gif\';"/></a><a href="?page=ladder&op=rules_lad&lad_id='.$lad_while->id.'"><img alt="rule" src="themes/'.$s_theme.'/images/onglet_rule_s.gif" align="top" border="0" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_rule.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_rule_s.gif\';"/></a></td>
						
							  <td class="ladder_onglet" style="width: 9px;"></td>
						
							  <td class="ladder_onglet" style="height: 26px; width: 45px;"></td>
						
							  <td class="ladder_onglet" style="width: 33px; height: 26px;"></td>
						
							  <td class="ladder_onglet" style="width: 33px; height: 26px;"></td>
						
							  <td class="ladder_onglet" style="width: 26px; height: 26px;"></td>
						
							  <td class="ladder_onglet" style="height: 26px; width: 33px;"></td>
						
							  <td class="ladder_onglet" style="height: 26px; width: 49px;"></td>
						
							 <td class="ladder_onglet" style="height: 13px; text-align: left; vertical-align: bottom;" rowspan="1" colspan="2">';
							  
							  if ($op=="admin" || ($grade['a']=='a' || $grade['b']=='b' || $grade['u']=='u')){
							  echo '<a href="?page=ladder&op=mod_rep&lad_id='.$lad_while->id.'&m_id='.$m_id.'"><img alt="edit" src="themes/'.$s_theme.'/images/onglet_e.gif" align="top" border="0" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_e_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_e.gif\';" /></a><a href="?page=ladder&op=del_m&lad_id='.$lad_while->id.'&m_id='.$m_id.'"><img alt="delete" src="themes/'.$s_theme.'/images/onglet_x.gif" align="top" border="0" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_x_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_x.gif\';" /></a>';
							  } 
							 	
							  echo '</td>
						
							  <td></td>
						
							</tr>
						
							<tr class="ladder_back">
							  <td class="ladder_header_s" style="width: 9px; height: 26px;"> </td>
						
							  <td class="ladder_header_r" style="height: 26px; text-align: center; width: 48px;" background="images/onglet_repeat.gif"><img style="width: 18px; height: 18px;" alt="nsicon" src="images/jeux/'.$lad_while->jeux.'" align="middle" /> </td>
						
							  <td class="ladder_header_r" style="height: 26px; width: 172px;"><span style="font-weight: bold; color: rgb(255, 255, 255);">'.$lad_while->ladder_name.'</span> </td>
						
							  <td class="ladder_header_r_txt" style="height: 26px; text-align: center;"> </td>
						
							  <td class="ladder_header_rule" colspan="4" style="text-align: center; vertical-align: center; width: 45px; "> '.$strRapport.' </td>
											
							  <td class="ladder_header_r_txt" style="height: 26px; text-align: center; width: 33px;" >  </td>
						
							  <td class="ladder_header_r_txt" style="height: 26px; text-align: center;  width: 49px;" >  </td>
						
							  <td class="ladder_header_r_txt" style="height: 26px; width: 78px;" ></td>
						
							  <td class="ladder_header_e" style="width: 9px; height: 26px;" background="themes/phptG4/images/onglet_end.gif"> </td>
						
							</tr>
							<tr class="ladder_line" bgcolor="#3c3c46">

								  <td class="lad_site_back" ></td>
								  				
								  <td colspan="10" class="lad_rule" ><br />
								  <table  border="0" width="100%" cellpadding="5" cellspacing="5"><tr><td class="lad_rule"><center>
								';echo nl2br($lad_while->rapport);echo '</center><br /><br /></td>
								  </td></tr></table>
													
								  <td class="lad_site_back"></td>

									</tr>
									<tr class="ladder_back">

										<td class="ladder_header_s" style="width: 9px; height: 26px;" ></td>
	
											<td class="ladder_header_r" colspan="2" rowspan="1" style="width: 172px;"> &nbsp;';
										
										//if ($lad_while->close) {
										//echo '&nbsp;&nbsp;<img align="bottom" alt="closed" src="themes/'.$s_theme.'/images/lock.gif" align="top" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/lock_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/lock.gif\';"/></td>';
										//} else if ($lad_ap=='oui') {
										if ($s_joueur){
										echo '&nbsp;&nbsp;<a href="?page=ladder&lad_id='.$lad_id.'&op=see_mylad"><img border="0" align="bottom" alt="status" src="themes/'.$s_theme.'/images/status.gif" align="top" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/status_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/status.gif\';"/></a></td>';
										}
										//}else {
										//echo '&nbsp;&nbsp;<a href="?page=ladder&lad_id='.$lad_id.'&op=join_lad"><img border="0" align="bottom" alt="open" src="themes/'.$s_theme.'/images/join.gif" align="top" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/join_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/join.gif\';" /></a></td>';
										//}
										//echo '</td>';
										
										echo '<td class="ladder_header_r" style="width: 16px;" ></td>
										
											<td class="ladder_header_r" style="width: 45px;" ></td>
										
											<td class="ladder_header_r" style="width: 33px;" ></td>
										
											<td class="ladder_header_r" style="width: 33px;" ></td>
										
											<td class="ladder_header_r" style="width: 33px;" ></td>
										
											<td class="ladder_header_r" style="width: 33px;" </td>
										
											<td class="ladder_header_r" colspan="2" rowspan="1" style="text-align: right;"></td>
										
											<td class="ladder_header_e" style="width: 9px;" ></td>
								
										</tr>
								
									</tbody>
								</table>						
								';
								//}

			if ($lad_test=="0"){echo '- '. $strladnodatafoundlist.' - ';}

}
//
// Affichage du rapport de fin de match
//
else if ($op == "match_report" && is_numeric($lad_id) && is_numeric($m_id)) {
					

	$db->select("${dbprefix}ladder_match.t1_id,${dbprefix}ladder_match.t2_id,${dbprefix}ladder_match.fpj2,${dbprefix}ladder_match.save_j1,${dbprefix}ladder_match.fpj1,${dbprefix}ladder_match.rapport,${dbprefix}ladder_data.ladder_name,${dbprefix}ladder_data.ladder_type,${dbprefix}ladder_data.jeux,${dbprefix}ladder_match.manche,${dbprefix}ladder_match.j1,${dbprefix}ladder_match.j2,${dbprefix}ladder_match.valide,${dbprefix}ladder_match.date,${dbprefix}ladder_match.maps,${dbprefix}ladder_match.server,${dbprefix}ladder_match.s1,${dbprefix}ladder_match.s2,${dbprefix}ladder_data.f_frag_loose,${dbprefix}ladder_data.f_frag_win,${dbprefix}ladder_data.f_round_loose,${dbprefix}ladder_data.f_round_win,${dbprefix}ladder_data.f_manche_loose,${dbprefix}ladder_data.f_manche_win,${dbprefix}ladder_data.s_frag,${dbprefix}ladder_data.s_round,${dbprefix}ladder_data.s_manche,${dbprefix}ladder_data.f_manche_null");
	$db->from("${dbprefix}ladder_data LEFT JOIN ${dbprefix}ladder_match on (${dbprefix}ladder_data.id = ${dbprefix}ladder_match.ladder_id)");
	$db->where("${dbprefix}ladder_data.id = $lad_id AND ${dbprefix}ladder_match.ladder_id = $lad_id AND ${dbprefix}ladder_match.id = $m_id");
	$db->exec();
	$lad_while= $db->fetch();
	
	
	//si le status est en attente de saisie des score et que le visiteur n'est ni J1 ni J2 et qu'il n'est pas admin 
	//Alors désactiver le mod 'formulaire' et laisser simplement les 'écrit'
	if(($s_joueur != $lad_while->j1 AND $s_joueur != $lad_while->j2) AND ($grade['a']!='a' AND $grade['b']!='b' AND $grade['u']!='u') OR $lad_while->valide != 'B')
	{$hide_form=true;}else{$hide_form=false;}
	
	
	
	
	$date = $lad_while->date;	
	$rapport = $lad_while->rapport;	
	$lad_type = $lad_while->ladder_type;
	
	$nb_manche=$lad_while->manche;
	if ($nb_manche=='0' || $nb_manche==0 || $nb_manche==NULL || $nb_manche=='') {$nb_manche=1;}
	
	//if (empty($choice)){$choice='no';}
	
	if (!empty($disagree)){
	
	$hide_form=false;
	$rapport .= '<hr>'.nom_joueur($s_joueur).' '.$strLAD_constest.'<hr>';
	
	$save_j1_split=array();
	$save_j1_split=split('!',$lad_while->save_j1);

	for ($i=0;$i < count($save_j1_split);$i++) {

		$save_j1_split[$i]=split(',',$save_j1_split[$i]);

	}

	
	//$save_j2=split(',',$lad_while->save_j2);
	} else {
	$save_j1_split=array();
	for ($i=0;$i < $nb_manche+10;$i++) {
	
		
		$save_j1_split[0][$i]= '0';
		$save_j1_split[1][$i]= '0';
		$save_j1_split[2][$i]= '0';
		$save_j1_split[3][$i]= '0';
		$save_j1_split[4][$i]= '0';
		$save_j1_split[5][$i]= '0';
		//$save_j1_split[$i][6]=0;

	}
	}	
	//regarder si c un bon array via sql
	//regarder si le joueur est J1 ou J2 et que la valid est A ou X 

			
		if ($s_joueur == '') {$hide_form=true;}

			$map_array=array();
			$map_array=split(',',$lad_while->maps);
			
			if ($map_array[0]== "/") {
				$db->select("maps");
				$db->from("${dbprefix}ladder_data");
				$db->where("id = $lad_id");
				$db->exec();
				$lad_while_m= $db->fetch();
				
				$map_array=array();
				$map_array=split(',',$lad_while_m->maps);
			}
			$j2=$lad_while->j2;
				echo '
					<form method="post" name="formulaire" action="?page=ladder&op=do_match_report&lad_id='.$lad_id.'&m_id='.$m_id.'&ad='.$ad.'">
					<input type="hidden" name="nb_manche" size="1" value="'.$nb_manche.'" />
					<input type="hidden" name="j1" size="1" value="'.$lad_while->j1.'" />
					<input type="hidden" name="j2" size="1" value="'.$lad_while->j2.'" />
					<input type="hidden" name="f_frag_win" size="1" value="'.$lad_while->f_frag_win.'" />
					<input type="hidden" name="f_frag_loose" size="1" value="'.$lad_while->f_frag_loose.'" />
					<input type="hidden" name="f_round_win" size="1" value="'.$lad_while->f_round_win.'" />
					<input type="hidden" name="f_round_loose" size="1" value="'.$lad_while->f_round_loose.'" />
					<input type="hidden" name="f_manche_win" size="1" value="'.$lad_while->f_manche_win.'" />
					<input type="hidden" name="f_manche_loose" size="1" value="'.$lad_while->f_manche_loose.'" />
					<input type="hidden" name="f_manche_null" size="1" value="'.$lad_while->f_manche_null.'" />
					<input type="hidden" name="valide" size="1" value="'.$lad_while->valide.'" />
					<input type="hidden" name="s_frag" size="1" value="'.$lad_while->s_frag.'" />
					<input type="hidden" name="s_round" size="1" value="'.$lad_while->s_round.'" />
					<input type="hidden" name="s_manche" size="1" value="'.$lad_while->s_manche.'" />
					<input type="hidden" name="date_match" size="1" value="'.$lad_while->date.'" />
					<input type="hidden" name="save" size="1" value="'.$lad_while->save_j1.'" />
					<input type="hidden" name="fpj1" size="1" value="'.$lad_while->fpj1.'" />
					<input type="hidden" name="fpj2" size="1" value="'.$lad_while->fpj2.'" />
						
						<table class="lad_table"  border="0" cellpadding="0" cellspacing="0">
							
							<tr class="ladder_back">
						
							  <td class="ladder_onglet" style="width: 9px; height: 26px;"></td>
						
							  <td class="ladder_onglet" style="height: 13px; text-align: left; vertical-align: bottom;" rowspan="1" colspan="2">';
							  if ($lad_while->ladder_type=='1'||$lad_while->ladder_type==1) {
							  echo '<a href="?page=ladder&op=player_lad&lad_id='.$lad_id.'"><img  alt="player" src="themes/'.$s_theme.'/images/onglet_player_s.gif" align="top" border="0" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_player.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_player_s.gif\';"/></a>';
							  }
							  else {
							  echo '<a href="?page=ladder&op=player_lad&lad_id='.$lad_id.'"><img alt="player" src="themes/'.$s_theme.'/images/onglet_team_s.gif" align="top" border="0" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_team.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_team_s.gif\';" /></a>';
							  }
							  echo '<a href="?page=ladder&op=match_lad&lad_id='.$lad_id.'"><img alt="match" src="themes/'.$s_theme.'/images/onglet_match_s.gif" align="top" border="0" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_match.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_match_s.gif\';"/></a><a href="?page=ladder&op=rules_lad&lad_id='.$lad_id.'"><img alt="rule" src="themes/'.$s_theme.'/images/onglet_rule_s.gif" align="top" border="0" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_rule.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_rule_s.gif\';"/></a></td>
						
							  <td class="ladder_onglet" style="width: 9px;"></td>
						
							  <td class="ladder_onglet" style="height: 26px; width: 45px;"></td>
						
							  <td class="ladder_onglet" style="width: 33px; height: 26px;"></td>
						
							  <td class="ladder_onglet" style="width: 33px; height: 26px;"></td>
						
							  <td class="ladder_onglet" style="width: 26px; height: 26px;"></td>
						
							  <td class="ladder_onglet" style="height: 26px; width: 33px;"></td>
						
							  <td class="ladder_onglet" style="height: 26px; width: 49px;"></td>
						
							 <td class="ladder_onglet" style="height: 13px; text-align: left; vertical-align: bottom;" rowspan="1" >';
							  
							  if ($op=="admin" || ($grade['a']=='a'||$grade['b']=='b'||$grade['u']=='u')){
							  echo '<a href="?page=ladder&op=mod_rep&lad_id='.$lad_id.'&m_id='.$m_id.'"><img alt="edit" src="themes/'.$s_theme.'/images/onglet_e.gif" align="top" border="0" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_e_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_e.gif\';" /></a><a href="?page=ladder&op=del_m&lad_id='.$lad_id.'&m_id='.$m_id.'"><img alt="delete" src="themes/'.$s_theme.'/images/onglet_x.gif" align="top" border="0" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_x_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_x.gif\';" /></a>';
							  }else {
							  echo '<img src="themes/'.$s_theme.'/images/onglets_'.$lad_while->valide.'.gif" align="top" border="0" alt="'.${$lad_while->valide}.'" /><a href="?page=ladder&op=report_lad&lad_id='.$lad_id.'&m_id='.$m_id.'"><img alt="'.$strRapport.'" src="themes/'.$s_theme.'/images/onglet_rap.gif" align="top" border="0" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_rap_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_rap.gif\';" /></a>';
							  }
							  echo '</td>
						
							  <td></td>
						
							</tr>
						
							<tr class="ladder_back">
							  <td class="ladder_header_s" style="width: 9px; height: 26px;"> </td>
						
							  <td class="ladder_header_r" style="height: 26px; text-align: center; width: 48px;"><img style="width: 18px; height: 18px;" alt="icon" src="images/jeux/'.$lad_while->jeux.'" align="middle" /> </td>
						
							  <td class="ladder_header_r" style="height: 26px; width: 172px;"><span class="lad_name">'.$lad_while->ladder_name.'</span> </td>
						
							  
						
							  <td class="ladder_header_rule" colspan="8" align="right"> '.$strLAD_MatchR.' </td>
											
						
						
							  <td class="ladder_header_e" style="width: 9px; height: 26px;"> </td>
						
							</tr>
							
							<tr class="ladder_line">

								<td class="ladder_border"></td>
							
								<td class="player_lad" colspan="10">  <br />
								
									<table border="0" cellpadding="0" cellspacing="0" align="center">';
									
									if($config['avatar']=='J' || $config['avatar']=='A') {
									
									
									if ($lad_type == '1') {
										$db->select("avatar");
										$db->from("${dbprefix}joueurs");
										$db->where("id=".$lad_while->j1."");
										$db->exec();
										$avatar_j1= $db->fetch();

										$db->select("avatar");
										$db->from("${dbprefix}joueurs");
										$db->where("id=".$lad_while->j2."");
										$db->exec();
										$avatar_j2= $db->fetch();
										}else{
										$db->select("avatar");
										$db->from("${dbprefix}equipes");
										$db->where("id=".$lad_while->t1_id."");
										$db->exec();
										$avatar_j1= $db->fetch();

										$db->select("avatar");
										$db->from("${dbprefix}equipe");
										$db->where("id=".$lad_while->t2_id."");
										$db->exec();
										$avatar_j2= $db->fetch();
										}
										
											if($avatar_j1->avatar AND $avatar_j1->avatar != "null.gif" ) {
											$avatar1='<img src="./images/avatars/'.$avatar_j1->avatar.'" alt="" style="border: 1px solid #000000;padding: 1px;">';
											} else {
											$avatar1 ='<img src="./images/avatars/unknown.gif" alt="" style="border: 1px solid #000000;padding: 1px;">';
											}
											
											if($avatar_j2->avatar  AND $avatar_j2->avatar != "null.gif" ) {
											$avatar2='<img src="./images/avatars/'.$avatar_j2->avatar.'" alt="" style="border: 1px solid #000000;padding: 1px;">';
											}else {
											$avatar2 ='<img src="./images/avatars/unknown.gif" alt="" style="border: 1px solid #000000;padding: 1px;">';
											}
											
										echo '
										<tr>
											<td>
												<table border="0" cellpadding="0" cellspacing="20" align="center" width="100%"><tr>
												<td align="center">'.$avatar1.'</td>
												<td class="player_lad" width="10" align="center"> '.$strVS.' </td>
												<td align="center">'.$avatar2.'</td>
												</td></tr></table>
											</td>
										</tr>';
										}
										
									echo '
										<tr>
											<td class="player_lad"><br />
											';
							
												if ($lad_type == '1') {
										
														if ($lad_while->s1 > $lad_while->s2) {
														echo '<table border="0" cellpadding="0" cellspacing="5" align="center"><tr>
														<td > '.show_joueur($lad_while->j1,"","","","left","player_lad_name").' </td>
														<td class="winmatch" width="15" align="center">'.$lad_while->s1.'</td>
														<td class="player_lad" width="10" align="center"> - </td>
														<td class="loosematch" width="15" align="center">'.$lad_while->s2.'</td>
														<td>'.show_joueur($lad_while->j2,"","","","right","player_lad_name").'</td>												
														</tr></table>
														';
														} else if ($lad_while->s2 > $lad_while->s1) {
														echo '<table border="0" cellpadding="0" cellspacing="5" align="center"><tr>
														<td > '.show_joueur($lad_while->j1,"","","","left","player_lad_name").' </td>
														<td class="loosematch" width="15" align="center">'.$lad_while->s1.'</td>
														<td class="player_lad" width="10" align="center"> - </td>
														<td class="winmatch" width="15" align="center">'.$lad_while->s2.'</td>
														<td>'.show_joueur($lad_while->j2,"","","","right","player_lad_name").'</td>
														</tr></table>
														';
														} else {
														echo '<table border="0" cellpadding="0" cellspacing="5" align="center"><tr>
														<td > '.show_joueur($lad_while->j1,"","","","left","player_lad_name").' </td>
														<td class="nullmatch" width="15" align="center">'.$lad_while->s1.'</td>
														<td class="player_lad" width="10" align="center"> - </td>
														<td class="nullmatch" width="15" align="center">'.$lad_while->s2.'</td>
														<td>'.show_joueur($lad_while->j2,"","","","right","player_lad_name").'</td>
														</tr></table>
														';
														}
													} else {
													
													
														if ($lad_while->s1 > $lad_while->s2) {
														echo '<table border="0" cellpadding="0" cellspacing="5" align="center"><tr>
														<td > '.show_equipe($lad_while->t1_id,"","","","left","player_lad_name").' </td>
														<td class="winmatch" width="15" align="center">'.$lad_while->s1.'</td>
														<td class="player_lad" width="10" align="center"> - </td>
														<td class="loosematch" width="15" align="center">'.$lad_while->s2.'</td>
														<td>'.show_equipe($lad_while->t2_id,"","","","right","player_lad_name").'</td>												
														</tr></table>
														';
														} else if ($lad_while->s2 > $lad_while->s1) {
														echo '<table border="0" cellpadding="0" cellspacing="5" align="center"><tr>
														<td > '.show_equipe($lad_while->t1_id,"","","","left","player_lad_name").' </td>
														<td class="loosematch" width="15" align="center">'.$lad_while->s1.'</td>
														<td class="player_lad" width="10" align="center"> - </td>
														<td class="winmatch" width="15" align="center">'.$lad_while->s2.'</td>
														<td>'.show_equipe($lad_while->t2_id,"","","","right","player_lad_name").'</td>
														</tr></table>
														';
														} else {
														echo '<table border="0" cellpadding="0" cellspacing="5" align="center"><tr>
														<td > '.show_equipe($lad_while->t1_id,"","","","left","player_lad_name").' </td>
														<td class="nullmatch" width="15" align="center">'.$lad_while->s1.'</td>
														<td class="player_lad" width="10" align="center"> - </td>
														<td class="nullmatch" width="15" align="center">'.$lad_while->s2.'</td>
														<td>'.show_equipe($lad_while->t2_id,"","","","right","player_lad_name").'</td>
														</tr></table>
														';
														}
													
													}
								
								echo '
								</td></tr></table>
								<br /> '.$strDate.' : '.$date.' | '.$strServeur.' : '.$lad_while->server.'<br /><br /></td>
								
								<td class="ladder_border"></td>

							</tr>
				';
			// 1 manche = 1 map
			// for nb_manche
	if ($lad_while->valide != 'V' and $lad_while->valide != 'D'){	
	if ($hide_form == false) {
			for ($i=1;$i<$nb_manche+1;$i++){
							
							
							echo '
							<tr class="ladder_back">
								<td class="ladder_header_s" style="width: 9px; height: 26px;"> </td>
						
								
								<td class="ladder_header_r" colspan="2" style="height: 26px; "><span class="lad_name">'.$strManche.' : '.$i.'</span> </td>
						
								<td class="ladder_header_r_txt" style="height: 26px; text-align: center;"> </td>
						
								<td class="ladder_header_rule" colspan="7" align="right"> '.$strMaps.' : ';
								
						if (sizeof($map_array)>>1){

							echo '<select name="mapss" onchange="javascript:document.formulaire.maps'.$i.'.value=this.value">';
									
									$map_test = 1;
									for($j=0;$j<sizeof($map_array);$j++) 
									{ 	
									//pregmatch de $maps pour trouver les map == si c le cas selected=true
									echo '<option value="'.$map_array[$j].'">'.$map_array[$j].'</option>';	
									$map_test++;									
									}	
									

									
							echo '</select><input type="text" name="maps'.$i.'" size="7" value="'.$map_array[0].'" />&nbsp;';
					
						}else {
						
							echo '<input type="hidden" name="maps'.$i.'" size="1" value="'.$map_array[0].'" />'.$map_array[0].'&nbsp;';
						
						}
								
							echo '
								</td>
																
															
								<td class="ladder_header_e" style="width: 9px; height: 26px;"> </td>
						
							</tr>
							';
				// on sait qui gagne kel manche car c score_j1_$i  < ou == ou  > à score_j2_$i
				//round : rs_j1_$i   et rs_j2_$i
												
				
				if ($lad_while->s_round) {
					echo '
							<tr class="ladder_line" >

								<td class="ladder_border"></td>
							
								<td class="player_lad" colspan="10"> '.$strLAD_roundscore.'<br />
								'.show_joueur($lad_while->j1,"","","","left","player_lad_name").'
								<input type="text" name="rs_j1_'.$i.'" size="1" value="'.$save_j1_split[$i-1][4].'" /> 
								-
								<input type="text" name="rs_j2_'.$i.'" size="1" value="'.$save_j1_split[$i-1][5].'" />
								
								'.show_joueur($lad_while->j2,"","","","right","player_lad_name").'
								<br /><br/></td>
								<td class="ladder_border"></td>

							</tr>
					';
				}
				if ($lad_while->s_frag) {
					echo '
							<tr class="ladder_line" >

								<td class="ladder_border"></td>
							
								<td class="player_lad" colspan="10"> '.$strLAD_fragscore.'<br />
								'.show_joueur($lad_while->j1,"","","","left","player_lad_name").'
								<input type="text" name="fs_j1_'.$i.'" size="1" value="'.$save_j1_split[$i-1][0].'" /> 
								-
								<input type="text" name="fs_j2_'.$i.'" size="1" value="'.$save_j1_split[$i-1][2].'" />
								
								'.show_joueur($lad_while->j2,"","","","right","player_lad_name").'
								<br /><br /></td>
								
								<td class="ladder_border"></td>

							</tr>
							<tr class="ladder_line" >

								<td class="ladder_border"></td>
							
								<td class="player_lad" colspan="10"> '.$strLAD_deathscore.'<br />
								'.show_joueur($lad_while->j1,"","","","left","player_lad_name").'
								<input type="text" name="ds_j1_'.$i.'" size="1" value="'.$save_j1_split[$i-1][1].'" /> 
								-
								<input type="text" name="ds_j2_'.$i.'" size="1" value="'.$save_j1_split[$i-1][3].'" />
								
								'.show_joueur($lad_while->j2,"","","","right","player_lad_name").'
								<br /></td>
								
								<td class="ladder_border"></td>

							</tr>
					';
				}

				

			// Manche X : maps Y
			//-if score manche => score manche $I
			//-if score round => score round
			//-if score frag => score frag			
			}//for
			
			//Faire play :
				if($ad=='ad'){
							echo '
								<tr class="ladder_line" >

								<td class="ladder_border"></td>
							
								<td class="player_lad" colspan="10"><br />'.$strLADfairadv_1.' :
								<select name="fairplay_j1">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5" SELECTED>5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
								</select> - <select name="fairplay_j2">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5" SELECTED>5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
								</select> : '.$strLADfairadv_2.'
								<br /></td>
								
								<td class="ladder_border"></td>

							</tr>';
				}else{
				
				echo '
				<tr class="ladder_line" >

								<td class="ladder_border"></td>
							
								<td class="player_lad" colspan="10"><br />'.$strLADfairadv.' :
								<select name="fairplay">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5" SELECTED>5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
								</select>
								<br /></td>
								
								<td class="ladder_border"></td>

							</tr>
				';
				}
			
					echo '
							<tr class="ladder_back">
								<td class="ladder_header_s" style="width: 9px; height: 26px;"> </td>
						
								<td class="ladder_header_rule" colspan="10" align="right"><input value="'.$strValider.'" name="submit" type="submit" /></td>
											
								<td class="ladder_header_e" style="width: 9px; height: 26px;"></td>
						
							</tr>
					</table>
					<textarea cols="80" rows="10" style="visibility:hidden;" name="rapport" ID="rapport" wrap="virtual" >'.$rapport.'</textarea>
					</form>
					';
			} else {
					//if (!empty($ad) AND ($garde['a']!='a' && $garde['b']!='b' && $garde['u']!='u')){js_goto('?page=ladder&op=list_lad');}
					if (((($lad_while->valide == 'A' && $s_joueur == $lad_while->j1) || ($lad_while->valide == 'X' && $s_joueur == $lad_while->j2)) && ( $ad!='ad')) || $s_joueur == ''){
					
					if ($s_joueur == ''){$strLAD_you_must_be_wait_txt='';}else{$strLAD_you_must_be_wait_txt=$strLAD_you_must_be_wait;}
							echo '
							
								
							
							<tr class="ladder_back">
								<td class="ladder_header_s" style="width: 9px; height: 26px;"> </td>
								
							
						
								<td class="ladder_header_rule" colspan="10" align="center">
								'.$strLAD_you_must_be_wait_txt.'
								</td>
								
											
								<td class="ladder_header_e" style="width: 9px; height: 26px;"></td>
						
							</tr>
								</table>
									</form>';
						
					} else {
					
				echo '
								<tr class="ladder_line" >

								<td class="ladder_border"></td>
							
								<td class="player_lad" colspan="10"><br />'.nl2br($rapport).'
								<br /></td>
								
								<td class="ladder_border"></td>

							</tr>
					';
								
								
							if($ad=='ad'){
							
							
							echo '
								<tr class="ladder_line" >

								<td class="ladder_border"></td>
							
								<td class="player_lad" colspan="10"><br />'.$strLADfairadv_1.' :
								<select name="fairplay_j1">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>';
								if(!empty($fpj1) and !empty($fpj2)){
								echo '<option value="'.$fpj1.'" SELECTED>'.$fpj1.'</option>';
								}
								echo'
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
								</select> - <select name="fairplay_j2">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>';
								if(!empty($fpj1) and !empty($fpj2)){
								echo '<option value="'.$fpj2.'" SELECTED>'.$fpj2.'</option>';
								}echo'
								<option value="5" SELECTED>5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
								</select> : '.$strLADfairadv_2.'
								<br /></td>
								
								<td class="ladder_border"></td>

							</tr>';
				}else{
				
				echo '
				<tr class="ladder_line" >

								<td class="ladder_border"></td>
							
								<td class="player_lad" colspan="10"><br />'.$strLADfairadv.' :
								<select name="fairplay">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5" SELECTED>5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
								</select>
								<br /></td>
								
								<td class="ladder_border"></td>

							</tr>
				';
				}
								
								
							echo '
					
							<tr class="ladder_back">
								<td class="ladder_header_s" style="width: 9px; height: 26px;"> </td>
								
								<td class="ladder_header_rule"></td>
						
								<td class="ladder_header_rule" colspan="8" align="center"><small>'.$strLADagree.'&nbsp; 
								 <input type="checkbox" name="agree" value="agree" onclick="javascript:document.formulaire.action=\'?page=ladder&op=do_match_report&lad_id='.$lad_id.'&m_id='.$m_id.'&ad='.$ad.'\';javascript:document.formulaire.disagree.checked=false;javascript:document.formulaire.submit.disabled=false;">&nbsp;-
								 <input type="checkbox" name="disagree" value="disagree" onclick="javascript:document.formulaire.action=\'?page=ladder&op=match_report&lad_id='.$lad_id.'&m_id='.$m_id.'&ad='.$ad.'\';javascript:document.formulaire.agree.checked=false;javascript:document.formulaire.submit.disabled=false;">&nbsp;'.$strLADnotagree.'
								 </td>
								<td class="ladder_header_rule" align="right">
								<input value="'.$strOK.'" name="submit" type="submit" disabled/>
								<input value="1" name="valide_mod" type="hidden" />
								<input value="'.$s_joueur.'" name="valide_mod_j" type="hidden" />
								</small>
								</td>
											
								<td class="ladder_header_e" style="width: 9px; height: 26px;"></td>
						
							</tr>
					</table>
					<textarea cols="80" rows="10" style="visibility:hidden;" name="rapport" ID="rapport" wrap="virtual" >'.$rapport.'</textarea>
					</form>';
			
					}
			}
			}else if ($lad_while->valide == 'D') {
			
					
			echo '<tr class="ladder_line" >

								<td class="ladder_border"></td>
							
								<td class="player_lad" colspan="10"><br />- '.$D.' -<br>
	
								<br /></td>
								
								<td class="ladder_border"></td>

						</tr>
						<tr class="ladder_back">
								<td class="ladder_header_s" style="width: 9px; height: 26px;"> </td>
								
								
						
								<td class="ladder_header_rule" colspan="10" align="center">'; 
								
								if ($j2 == $s_joueur || $ad=='ad') {
								echo '<a href="?page=ladder&op=agree&lad_id='.$lad_id.'&m_id='.$m_id.'&ad='.$ad.'" ><span style="color: rgb(255, 255, 255);">'.$strLAD_valid_this.'</span></a>';
								}
								
								
								echo '</td>
								
											
								<td class="ladder_header_e" style="width: 9px; height: 26px;"></td>
						
							</tr>
					</table>
				</form>';
			
			}else{
				
				echo '		
						<tr class="ladder_line" >

								<td class="ladder_border"></td>
							
								<td class="player_lad" colspan="10"><br />'.$rapport.'
	
								<br /></td>
								
								<td class="ladder_border"></td>

						</tr>
						<tr class="ladder_back">
								<td class="ladder_header_s" style="width: 9px; height: 26px;"> </td>
								
								
						
								<td class="ladder_header_rule" colspan="10" align="center"></td>
								
											
								<td class="ladder_header_e" style="width: 9px; height: 26px;"></td>
						
							</tr>
					</table>
				</form>
				';
			}
}
//
// Traitement des données des résultat du rapport de fin de match, l'usine à gaz quoi Oo
//
else if ($op == "do_match_report" && is_numeric($lad_id) && is_numeric($m_id)) {
//if (!empty($ad) AND ($garde['a']!='a' && $garde['b']!='b' && $garde['u']!='u')){js_goto('?page=INDEX');}
					

										$db->select("*");
										$db->from("${dbprefix}lad_part");
										$db->where("joueur_id=".$j1." and ladder_id =".$lad_id."");
										$db->exec();
										$d_j1= $db->fetch();
										
										$db->select("*");
										$db->from("${dbprefix}lad_part");
										$db->where("joueur_id=".$j2." and ladder_id =".$lad_id."");
										$db->exec();
										$d_j2= $db->fetch();
			$date=time();			
			
		
		if (!empty($agree)) {
				
		if ($ad=='ad'){$ad_txt='(admin)';}else{$ad_txt='';}
		$rapport.='<hr>'.$strLAD_endmatch_agree.' '.$ad_txt.'<br />'.$strDate.' : '.strftime(DATESTRING1, $date).'<hr>';
		
			$save_split=array();
			$save_split=split('!',$save);
		
		$s_j1 = $d_j1->s;
		$s_j2 = $d_j2->s;
		
				for ($i=0;$i < count($save_split);$i++) {
			
						$save_split[$i]=split(',',$save_split[$i]);
			
				}
				for ($i=1;$i<$nb_manche+1;$i++){
				
					$j1_f += $save_split[$i-1][0];
					$j1_d += $save_split[$i-1][1];
					$j2_f += $save_split[$i-1][2];
					$j2_d += $save_split[$i-1][3];
					$j1_r += $save_split[$i-1][4];
					$j2_r += $save_split[$i-1][5];
					
					if ($s_manche != '1' && $s_round != '1'){
					
						if (($j1_f - $j1_d) > ($j2_f - $j2_d)){
						$j1_s ++;
						$j2_s --;
						} else if (($j1_f - $j1_d) < ($j2_f - $j2_d)) {
						$j2_s ++;
						$j1_s --;
						} else {
						$j2_s =0;
						$j1_s =0;
						}
					
					
					}
					
					$p_j1_f += $save_split[$i-1][0]*$f_frag_win;
					$p_j1_d += $save_split[$i-1][1]*$f_frag_loose;
					$p_j2_f += $save_split[$i-1][2]*$f_frag_win;
					$p_j2_d += $save_split[$i-1][3]*$f_frag_loose;
					$p_j1_r_w += $save_split[$i-1][4]*$f_round_win;
					$p_j2_r_w += $save_split[$i-1][5]*$f_round_win;
					$p_j2_r_l += $save_split[$i-1][4]*$f_round_loose;
					$p_j1_r_l += $save_split[$i-1][5]*$f_round_loose;
				
					if ($j1_r > $j2_r) {
					$j1_m_w ++;
					$j1_m_l += 0;
					$j1_m_n += 0;
					$j2_m_w += 0;
					$j2_m_l ++;
					$j2_m_n += 0;
					if ($s_manche == '1' || $s_round == '1'){
					$j1_s ++;
					$j2_s --;
					}
					
					$p_j1_m_w += 1*$f_manche_win;
					$p_j1_m_l += 0;
					$p_j1_m_n += 0;
					$p_j2_m_w += 0;
					$p_j2_m_l += 1*$f_manche_loose;
					$p_j2_m_n += 0;
					}
					
					if ($j1_r < $j2_r) {
					$j1_m_w += 0;
					$j1_m_l ++;
					$j1_m_n += 0;
					$j2_m_w ++;
					$j2_m_l += 0;
					$j2_m_n += 0;
					if ($s_manche == '1' || $s_round == '1'){
					$j2_s ++;
					$j1_s --;
					}
					
					$p_j1_m_w += 0;
					$p_j1_m_l += 1*$f_manche_loose;
					$p_j1_m_n += 0;
					$p_j2_m_w += 1*$f_manche_win;
					$p_j2_m_l += 0;
					$p_j2_m_n += 0;
					}
					
					if ($j1_r == $j2_r) {
					$j1_m_w += 0;
					$j1_m_l += 0;
					$j1_m_n ++;
					$j2_m_w += 0;
					$j2_m_l += 0;
					$j2_m_n ++;
					if ($s_manche == '1' || $s_round == '1'){
					$j1_s =0;
					$j2_s =0;
					}
					
					$p_j1_m_w += 0;
					$p_j1_m_l += 0;
					$p_j1_m_n += 1*$f_manche_null;
					$p_j2_m_w += 0;
					$p_j2_m_l += 0;
					$p_j2_m_n += 1*$f_manche_null;
					}
				
				}
				
		
				
				
			$e_pts_1 = $d_j1->pts + $p_j1_m_w + $p_j1_m_l + $p_j1_m_n + $p_j1_f + $p_j1_f + $p_j1_r_w + $p_j1_r_l;
			$t_j1_m_w += $d_j1->w +$j1_m_w;
			$t_j1_m_l += $d_j1->l +$j1_m_l;
			$t_j1_m_n += $d_j1->d +$j1_m_n;
			$t_j1_k += $d_j1->kill +$j1_f;
			$t_j1_d += $d_j1->death +$j1_d;
			$t_j1_r_w += $d_j1->round_w +$j1_r;
			$t_j1_r_l += $d_j1->round_l +$j2_r;
			$t_m_j1 += $d_j1->total_match + 1;
			
			if($s_j1  == 0){$s_j1 = '0';}
			
			
			$e_pts_2 += $d_j2->pts + $p_j2_m_w + $p_j2_m_l + $p_j2_m_n + $p_j2_f + $p_j2_f + $p_j2_r_w + $p_j2_r_l;
			$t_j2_m_w += $d_j2->w+$j2_m_w;
			$t_j2_m_l += $d_j2->l+$j2_m_l;
			$t_j2_m_n += $d_j2->d+$j2_m_n;
			$t_j2_k += $d_j2->kill +$j2_f;
			$t_j2_d += $d_j2->death +$j2_d;
			$t_j2_r_w += $d_j2->round_w +$j2_r;
			$t_j2_r_l += $d_j2->round_l +$j1_r;
			$t_m_j2 += $d_j2->total_match + 1;
			if($s_j2  == 0){$s_j2 = '0';}
			
			if ($j1 == $s_joueur){
				
				$fair_play_j1 = (($d_j1->fair_play * $d_j1->total_match) + $fpj1) / $t_m_j1;
				$fair_play_j2 = (($d_j2->fair_play * $d_j2->total_match) + $fairplay) / $t_m_j2;
			
			} else if ($j2 == $s_joueur) {
			
				$fair_play_j1 = (($d_j1->fair_play * $d_j1->total_match) + $fairplay) / $t_m_j1;
				$fair_play_j2 = (($d_j2->fair_play * $d_j2->total_match) + $fpj2) / $t_m_j2;
			
			} else if ($ad == 'ad') {
			
				$fair_play_j1 = (($d_j1->fair_play * $d_j1->total_match) + $fairplay_j1) / $t_m_j1;
				$fair_play_j2 = (($d_j2->fair_play * $d_j2->total_match) + $fairplay_j2) / $t_m_j2;
			
			}
			
			$db->update("${dbprefix}lad_part");
			$db->set("pts='$e_pts_1',w='$t_j1_m_w',l='$t_j1_m_l',d='$t_j1_m_n',s='$s_j1',mort='$t_j1_k',death='$t_j1_d',round_w='$t_j1_r_w',round_l='$t_j1_r_l',total_match='$t_m_j1',fairplay='$fair_play_j1'");
			$db->where("ladder_id = '$lad_id' AND joueur_id = '$j1'");
			$db->exec();
			
			$db->update("${dbprefix}lad_part");
			$db->set("pts='$e_pts_2',w='$t_j2_m_w',l='$t_j2_m_l',d='$t_j2_m_n',s='$s_j2',mort='$t_j2_k',death='$t_j2_d',round_w='$t_j2_r_w',round_l='$t_j2_r_l',total_match='$t_m_j2',fairplay='$fair_play_j2'");
			$db->where("ladder_id = '$lad_id' AND joueur_id = '$j2'");
			$db->exec();
			
			$db->update("${dbprefix}ladder_data");
			$db->set("new_data='1'");
			$db->where("id = '$lad_id'");
			$db->exec();
			
			if ($s_round == '1') {
			$db->update("${dbprefix}ladder_match");
			$db->set("s1='$j1_r',s2='$j2_r',valide='V',date_up='$date',rapport='$rapport'");
			$db->where("ladder_id = '$lad_id' AND id = '$m_id'");
			$db->exec();
			} else if ($s_manche == '1'){
			$db->update("${dbprefix}ladder_match");
			$db->set("s1='$1_m_w',s2='$j2_m_w',valide='V',date_up='$date',rapport='$rapport'");
			$db->where("ladder_id = '$lad_id' AND id = '$m_id'");
			$db->exec();
			} else if ($s_frag == '1'){
			$db->update("${dbprefix}ladder_match");
			$db->set("s1='$j1_f',s2='$j2_f',valide='V',date_up='$date',rapport='$rapport'");
			$db->where("ladder_id = '$lad_id' AND id = '$m_id'");
			$db->exec();
			}else if (($p_j2_m_w + $p_j2_m_l + $p_j2_m_n + $p_j2_f + $p_j2_f + $p_j2_r_w + $p_j2_r_l) < ($p_j1_m_w + $p_j1_m_l + $p_j1_m_n + $p_j1_f + $p_j1_f + $p_j1_r_w + $p_j1_r_l)){
			$db->update("${dbprefix}ladder_match");
			$db->set("s1='1',s2='0',valide='V',date_up='$date',rapport='$rapport'");
			$db->where("ladder_id = '$lad_id' AND id = '$m_id'");
			$db->exec();
			}else{
			$db->update("${dbprefix}ladder_match");
			$db->set("s1='0',s2='1',valide='V',date_up='$date',rapport='$rapport'");
			$db->where("ladder_id = '$lad_id' AND id = '$m_id'");
			$db->exec();
			}
		
		} else {
		
				
										
			$log='<hr>'.$strLAD_logresult.'<br />'.$strDate.' : '.strftime(DATESTRING1, $date).'<hr>';
			
			//mod joueur
			$n_j1= nom_joueur($j1);
			$n_j2= nom_joueur($j2);

			
			for ($i=1;$i<$nb_manche+1;$i++){
			

				$log .= '<u><b>'.$strManche.' '.$i.'</b> :</u> '.${maps.$i}.'<br/><br/>';
			
				if ($s_frag) {
					//calcule du total de point de frag
					$p_total_frag_j1_w +=  ${fs_j1_.$i}*$f_frag_win;
					$p_total_frag_j2_w +=  ${fs_j2_.$i}*$f_frag_win;
					$t_total_frag_j1_w +=  ${fs_j1_.$i};
					$t_total_frag_j2_w +=  ${fs_j2_.$i};
									
					//calcule du total de point de death
					$p_total_frag_j1_l +=  (${ds_j1_.$i}*$f_frag_loose);
					$p_total_frag_j2_l +=  (${ds_j2_.$i}*$f_frag_loose);
					$t_total_frag_j1_l +=  ${ds_j1_.$i};
					$t_total_frag_j2_l +=  ${ds_j2_.$i};

					
					
					$save_j1 .= ${fs_j1_.$i}.','.${ds_j1_.$i}.','.${fs_j2_.$i}.','.${ds_j2_.$i}.',';
					//$save_j2 .= ${fs_j2_.$i}.','.${ds_j2_.$i}.',';
					
					$log .= '<u>'.$strFrags.' : </u><br/>';
					$log .= $n_j1.' K['.${fs_j1_.$i}.'] D['.${ds_j1_.$i}.'] - ['.${ds_j2_.$i}.']D ['.${fs_j2_.$i}.']K  '.$n_j2;
					$log .= '<br/><br/>';
				} else {

					
					$save_j1 .= '0,0,0,0,';
					//$save_j2 .= '0,0,0,0';
				
				}
				
				if ($s_round) {
					//calcule du total de point de round
					$p_total_round_j1_w +=  (${rs_j1_.$i}*$f_round_win);
					$p_total_round_j2_w +=  (${rs_j2_.$i}*$f_round_win);
					$t_total_round_j1_w +=  ${rs_j1_.$i};
					$t_total_round_j2_w +=  ${rs_j2_.$i};
					
					//calcule du total de point de round perdu
					$p_total_round_j1_l +=  $t_total_round_j2_w*$f_round_loose;
					$p_total_round_j2_l +=  $t_total_round_j1_w*$f_round_loose;
					$t_total_round_j1_l +=  $t_total_round_j2_w;
					$t_total_round_j2_l +=  $t_total_round_j1_w;

					
					$save_j1 .= ${rs_j1_.$i}.','.${rs_j2_.$i}.'!';
					//$save_j2 .= ${rs_j2_.$i}.','.${rs_j1_.$i};
					
					$log .= '<u>'.$strLAD_round.' : </u><br/>';
					$log .= $n_j1.' W['.${rs_j1_.$i}.'] L['.${rs_j2_.$i}.'] - ['.${rs_j1_.$i}.']L ['.${rs_j2_.$i}.']W  '.$n_j2;
					$log .= '<br/><br/>';
				} else {
				
					
					$save_j1 .= '0,0!';
				
				}
				
				
					//calcule du total de point de manche
					if ($t_total_round_j1_w > $t_total_round_j2_w) {
						
						if ($s_manche) {
								
								$p_total_manche_j1_w += (1*$f_manche_win);
								
						
						} 
								$t_total_manche_j1_w ++;
								$t_total_manche_j2_l ++;
								$t_total_manche_j2_w += 0;
								$t_total_manche_j1_l += 0;
								$t_total_manche_j2_n += 0;
								$t_total_manche_j1_n += 0;
								$s_j1 ++;
								$s_j2 --;
					
					} 

					if ($t_total_round_j1_w < $t_total_round_j2_w) {
						
						if ($s_manche) {
						$p_total_manche_j2_w += (1*$f_manche_win);
						$p_total_manche_j1_l += (1*$f_manche_loose);

						} 
						$t_total_manche_j2_w ++;
						$t_total_manche_j1_l ++;
						$t_total_manche_j1_w += 0;
						$t_total_manche_j2_l += 0;
						$t_total_manche_j2_n += 0;
						$t_total_manche_j1_n += 0;
						$s_j2 ++;
						$s_j1 --;
					
					} 
					
					if ($t_total_round_j1_w == $t_total_round_j2_w) {
						
						if ($s_manche) {
						$p_total_manche_j2_n += (1*$f_manche_null);
						$p_total_manche_j1_n += (1*$f_manche_null);

						} 
						$t_total_manche_j2_n ++;
						$t_total_manche_j1_n ++;
						$t_total_manche_j1_w += 0;
						$t_total_manche_j2_l += 0;
						$t_total_manche_j2_w += 0;
						$t_total_manche_j1_l += 0;
						$s_j1 =0;
						$s_j2 =0;
					}
					

					
					
					if ($t_total_manche_j2_n == 0){$t_total_manche_j2_n='0';}
					if ($t_total_manche_j1_n == 0){$t_total_manche_j1_n='0';}
					if ($t_total_manche_j2_w == 0){$t_total_manche_j2_w='0';}
					if ($t_total_manche_j2_l == 0){$t_total_manche_j2_l='0';}
					if ($t_total_manche_j1_w == 0){$t_total_manche_j1_w='0';}
					if ($t_total_manche_j1_l == 0){$t_total_manche_j1_l='0';}

					
					//$log .= '<u>'.$strManche.' : </u><br/>';
					//$log .= $n_j1.' W['.$t_total_manche_j1_w.'] L['.$t_total_manche_j1_l.'] N['.$t_total_manche_j1_n.'] - ['.$t_total_manche_j2_n.']N ['.$t_total_manche_j2_l.']L ['.$t_total_manche_j2_w.']W  '.$n_j2;
					//$log .= '<br/><br/>';

				
				
				$e_pts_1 += $p_total_round_j1_w+$p_total_frag_j1_w+$p_total_manche_j1_w+$p_total_frag_j1_l+$p_total_round_j1_l+$p_total_manche_j1_l+$p_total_manche_j1_n;
				$e_pts_2 += $p_total_round_j2_w+$p_total_frag_j2_w+$p_total_manche_j2_w+$p_total_frag_j2_l+$p_total_round_j2_l+$p_total_manche_j2_l+$p_total_manche_j2_n;

				
			
			}
			
			/*if(($grade['a']=='a' || $grade['b']=='b' || $grade['u']=='u') && $ad=="ad") {
			
			$e_pts_1 += $d_j1->pts;
			$t_total_manche_j1_w += $d_j1->w;
			$t_total_manche_j1_l += $d_j1->l;
			$t_total_manche_j1_n += $d_j1->d;

			if($s_j1  == 0){$s_j1 = '0';}
			
			$db->update("${dbprefix}lad_part");
			$db->set("pts='$e_pts_1',w='t_total_manche_j1_w',l='t_total_manche_j1_l',d='t_total_manche_j1_n',s='$s_j1'");
			$db->where("ladder_id = $lad_id AND joueur_id = $j1");
			$db->exec();
			
			$e_pts_2 += $d_j2->pts;
			$t_total_manche_j2_w += $d_j2->w;
			$t_total_manche_j2_l += $d_j2->l;
			$t_total_manche_j2_n += $d_j2->d;

			if($s_j2  == 0){$s_j2 = '0';}
			
			$db->update("${dbprefix}lad_part");
			$db->set("pts='$e_pts_2',w='t_total_manche_j2_w',l='t_total_manche_j2_l',d='t_total_manche_j2_n',s='$s_j2'");
			$db->where("ladder_id = $lad_id AND joueur_id = $j2");
			$db->exec();
			
			// valider les valeur du match dans SQL
			}*/
			
			//valide = X = J2 valide / A = J1 valide
			if ($j1 == $s_joueur){$valide='A';}
			else if ($j2==$s_joueur){$valide='X';}
			//if(($grade['a']=='a' || $grade['b']=='b' || $grade['u']=='u')&& $ad=="ad") {$valide = 'V';}
 			
			//si l'admin valide penser ) le checker avant et à traiter les données immédiatements
			
			$rapport .= $log;
			
			if ($j1 == $s_joueur){
			
				$fpj1 = '';
				$fpj2 = $fairplay;
				
			} else if($j2 == $s_joueur){
			
				$fpj2 = '';
				$fpj1 = $fairplay;
				
			} 
			
			if ($ad == 'ad'){
				
				$fpj2 = $fairplay_j2;
				$fpj1 = $fairplay_j1;
			
			}
			
			$db->update("${dbprefix}ladder_match");
			$db->set("save_j1='$save_j1',valide='$valide',rapport='$rapport',date_up='$date',fpj1='$fpj1',fpj2='$fpj2'");
			$db->where("ladder_id = $lad_id AND id = $m_id");
			$db->exec();

	}		

	/*** redirection ***/
	//if($ad=='ad'){
	//js_goto("?page=ladder&op=do_match_report&lad_id=$lad_id&m_id=$m_id&ad=ad&agree=agree&fPj1=$fpj1&fpj2=$fpj2");
	//}else{
	js_goto("?page=ladder&op=report_lad&lad_id=$lad_id&m_id=$m_id");
	//}

}
//
// Affichage des ladder
//
else  {
	
	$lad_test="0";
	
	$db->select("*");
	$db->from("${dbprefix}ladder_data");
	$res=$db->exec();
			
			while ($lad_while = $db->fetch($res)) {
			
			if ($lad_while->ladder_name!='' || $lad_while->ladder_name!=NULL){$lad_test="1";}
			
				//$lad_while->ladder_name
				echo '<br />
						<table class="lad_table"  border="0" cellpadding="0" cellspacing="0">
						
						  <tbody>
						
							<tr class="ladder_back">
						
							  <td class="ladder_onglet" style="width: 9px; height: 26px;"></td>
						
							  <td class="ladder_onglet" style="height: 26px; text-align: left; vertical-align: bottom; width: 200x;" rowspan="1" colspan="2">';
							  if ($lad_while->ladder_type=='1'||$lad_while->ladder_type==1) {
							  echo '<a href="?page=ladder&op=player_lad&lad_id='.$lad_while->id.'"><img  alt="player" src="themes/'.$s_theme.'/images/onglet_player.gif" align="top" border="0" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_player.gif\';"  onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_player_s.gif\';"/></a>';
							  }
							  else {
							  echo '<a href="?page=ladder&op=player_lad&lad_id='.$lad_while->id.'"><img  alt="player" src="themes/'.$s_theme.'/images/onglet_team.gif" align="top" border="0" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_team.gif\';"  onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_team_s.gif\';"/></a>';
							  }
							  echo '<a href="?page=ladder&op=match_lad&lad_id='.$lad_while->id.'"><img alt="match" src="themes/'.$s_theme.'/images/onglet_match.gif" align="top" border="0" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_match.gif\';"  onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_match_s.gif\';" /></a><a href="?page=ladder&op=rules_lad&lad_id='.$lad_while->id.'"><img alt="rule" src="themes/'.$s_theme.'/images/onglet_rule.gif" align="top" border="0" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_rule.gif\';"  onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_rule_s.gif\';"/></a></td>
						
							  <td class="ladder_onglet" style="width: 9px;"></td>
						
							  <td class="ladder_onglet" style="height: 26px; width: 45px;"></td>
						
							  <td class="ladder_onglet" style="width: 33px; height: 26px;"></td>
						
							  <td class="ladder_onglet" style="width: 33px; height: 26px;"></td>
						
							  <td class="ladder_onglet" style="width: 26px; height: 26px;"></td>
						
							  <td class="ladder_onglet" style="height: 26px; width: 33px;"></td>
						
							  <td class="ladder_onglet" style="height: 26px; width: 49px;"></td>
													  
							  <td class="ladder_onglet" style="height: 13px; text-align: left; vertical-align: bottom;" rowspan="1" colspan="2">';
							  
							  if ($op=="admin" || ($grade['a']=='a'||$grade['b']=='b'||$grade['u']=='u')){
							  echo '<a href="?page=ladder&op=mod_lad&lad_id='.$lad_while->id.'"><img alt="edit" src="themes/'.$s_theme.'/images/onglet_e.gif" align="top" border="0" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_e_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_e.gif\';" /></a><a href="?page=ladder&op=del_lad&lad_id='.$lad_while->id.'"><img alt="delete" src="themes/'.$s_theme.'/images/onglet_x.gif" align="top" border="0" onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_x_s.gif\';" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/onglet_x.gif\';" /></a>';
							  }
							  
							  
							  if ($lad_while->ladder_type == '1') {
							  $strtype=$strJoueurs;
							  }else{
							  $strtype=$strEquipes;
							  }
							 
							  
							  echo '</td>
						
							  <td></td>
						
							</tr>
						
							<tr class="ladder_back">
							  <td class="ladder_header_s" style="width: 9px; height: 26px;"> </td>
						
							  <td class="ladder_header_r" style="height: 26px; text-align: center; width: 48px;"><img style="width: 18px; height: 18px;" alt="nsicon" src="images/jeux/'.$lad_while->jeux.'" align="middle" /> </td>
						
							  <td class="ladder_header_r" style="height: 26px; width: 172px;"><span style="font-weight: bold; color: rgb(255, 255, 255);">'.$lad_while->ladder_name.'</span> </td>
						
							  <td class="ladder_header_r_txt">';
							  
									echo '<a href="?page=ladder&op=check_lad&lad_id='.$lad_while->id.'"><img alt="open" src="themes/'.$s_theme.'/images/dev.gif" align="top" border="0" onmouseout="javascript:this.src=\'themes/'.$s_theme.'/images/dev.gif\';"  onmouseover="javascript:this.src=\'themes/'.$s_theme.'/images/dev_s.gif\';" /></a>';
						
								echo ' </td>
						
							  <td class="ladder_header_r_txt" > </td>
						
							  <td class="ladder_header_r_txt"  > </td>
						
							  <td class="ladder_header_r_txt"  > </td>
						
							  <td class="ladder_header_r_txt" > </td>
						
							  <td class="ladder_header_r_txt" > </td>
						
							  <td class="ladder_header_r_txt"  > </td>
						
							  <td class="ladder_header_r_txt" >'.$strtype.' : '.nb_player($lad_while->id).'</td>
						
							  <td class="ladder_header_e" style="width: 9px; height: 26px;" > </td>
						
							</tr>
							</tbody>
						</table>
				<br />';
			}

			if ($lad_test=="0"){echo '- '. $strladnodatafoundlist.' - ';}
				
	
}



//
// ################# [  /AFFICHAGE ]  ################
//
?>
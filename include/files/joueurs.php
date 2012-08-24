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
if (eregi("joueurs.php", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}


/********************************************************
 * Ajout d'un joueur
 */
if($op == "add") {

	/*** verification securite ***/
	if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['j']!='j') {js_goto($PHP_SELF);} 
			
	$str='';
	$erreur=0;
			
	if(!$pseudo) {
		$erreur=1;
		$str.="- $strElementsPseudoInvalide<br>";
	}
	if(id_joueur($pseudo)!=0) {
		$erreur=1;
		$str.="- $strElementsJoueurExistant<br>";
	}

	if($erreur==1) {		
		show_erreur_saisie($str);
	}
	else {

		$date=time();
		$pseudo=remove_XSS($pseudo);

		$db->select("max(id) as id");
		$db->from("${dbprefix}joueurs");
		$db->exec();
		$maxid = $db->fetch();		
		$nextid = $maxid->id + 1;

		if($config['inscription_joueur_pre']) $etat='P';
		else $etat='I';
			
		$db->insert("${dbprefix}joueurs (id, pseudo, origine, admin, langue, etat, dateinscription)");
		$db->values("$nextid,'$pseudo','FR', 'N', '$config[default_lang]', '$etat', '$date'");
		$db->exec();
		
		/*** redirection ***/
		js_goto("?page=joueurs&op=admin&id=$nextid");
	}
}
/********************************************************
* rechercher un d'un joueur par admin
*/
$rech_v = 'v';
if($op == "rech") {
  
$str='';
$erreur=0;
  
if(!$pseudo) {
 $erreur=1;
 $str.="- $strElementsPseudoInvalide<br>";
}
if($erreur==1) {  
 show_erreur_saisie($str);
}
else {
 $db->select("id, pseudo");
 $db->from("${dbprefix}joueurs WHERE pseudo='$pseudo'");
 //$db->where("pseudo = $pseudo"); => mais pk ça marche po !!!
 $res = $db->exec();

 while ($rech_joueur = $db->fetch($res)) {
 $rech_id = $rech_joueur->id;
 $rech_ps = $rech_joueur->pseudo;
 }

 if ($pseudo != $rech_ps){
 //---
 $erreur=1; $str.="- $strRechInvalide";
 if($erreur==1) {show_erreur_saisie($str);} 
 //---
 /*$db->select("id, pseudo");
 $db->from("${dbprefix}joueurs WHERE LIKE pseudo='$pseudo'");

 $res = $db->exec();

 
 $erreur=1; $str.="- $strRechInvalide2<br>";
 if($erreur==1) {show_erreur_saisie($str);} 
 
  echo '<table border=0 cellpadding="0" cellspacing="0" class="bordure2"><tr><td>';
  echo '<table cellspacing="1" cellpadding="0" border="0">';
  echo "<tr><td class=\"headerfiche\">$strRechercherJoueur</td></tr>";
  echo '<tr><td>';
  echo '<table cellspacing="0" cellpadding="3" border="0" width="100%">';
 
 while ($rech_joueur = $db->fetch($res)) {

  echo '<tr>';
  echo "<td class=\"titlefiche\">$strPseudo :</td>";
  echo '<td class="textfiche"><a href="?page=joueurs&id=$rech_joueur->id&op=admin">$rech_joueur->pseudo</a></td>';
  echo '</tr>';
 
 }
 
  echo "<tr><td class=\"footerfiche\" align=\"center\" colspan=\"2\"><input type=\"submit\" class=\"action\" value=\"$strRechecrher\"></td></tr>";
  echo '</table>';
  echo '</td></tr></table>';
  echo '</td></tr></table>';*/
   


  } else {
 
 /*** redirection ***/
 js_goto("?page=joueurs&id=$rech_id&op=admin");
 
 } 
}
}
/********************************************************
* rechercher un d'un joueur par un joueur
*/
if($op == "rechj") {
  
$str='';
$erreur=0;
  
if(!$pseudo) {
 $erreur=1;
 $str.="- $strElementsPseudoInvalide<br>";
}
if($erreur==1) {  
 show_erreur_saisie($str);
}
else {
 $db->select("id, pseudo");
 $db->from("${dbprefix}joueurs WHERE pseudo='$pseudo'");
 $res = $db->exec();

 while ($rech_joueur = $db->fetch($res)) {
 $rech_id = $rech_joueur->id;
 $rech_ps = $rech_joueur->pseudo;
 }

 if ($pseudo != $rech_ps){$erreur=1; $str.="- $strRechInvalide<br>"; 
  
  if($erreur==1) {show_erreur_saisie($str);}
 } else {
 
 /*** redirection ***/ 
 js_goto("?page=joueurs&id=$rech_id");
  
 } 
}
}
/********************************************************
 * Modifier le status d'un joueur
 */
elseif ($op == "status") {

	/*** verification securite ***/
	if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['j']!='j') {js_goto($PHP_SELF);} 
	$date=time();	

	if(is_numeric($id)) {
		$db->update("${dbprefix}joueurs");
		$db->set("etat = '$value'");
		if($value=='P' || $value=='I') $db->set("dateinscription = '$date'");
		$db->where("id = $id");
		$db->exec();

		/*** redirection ***/
		js_goto("?page=joueurs&op=admin&id=$id");
	}
	elseif(count($tab_status)!=0) {
	
		foreach ($tab_status as $idjoueur) {		
			$db->update("${dbprefix}joueurs");
			$db->set("etat = '$status'");
			if($status=='A' || $status=='V') $db->set("dateinscription = '$date'");
			$db->where("id = $idjoueur");
			$db->exec();
		}

		/*** redirection ***/
		js_goto("?page=joueurs&op=admin");
	}
	else 
		js_goto("?page=joueurs&op=admin");


}

/********************************************************
 * Ajout d'un joueur externe
 */
elseif($op == "do_inscription") {

	/*** verification securite ***/
	if(!$config['inscription_joueur']) js_goto("?page=index");
	
	$str='';
	$erreur=0;

	if(!$pseudo) {
		$erreur=1;
		$str="- $strElementsPseudoInvalide<br>";
	}
	if(id_joueur($pseudo)>0) {
		$erreur=1;
		$str.="- $strElementsJoueurExistant<br>";
	}
	if(!$passwd) {
		$erreur=1;
		$str.="- $strElementsPasswordInvalide<br>";
	}
	if($mods['nom']=="1") {
	if(!$nom) {	
		$erreur=1;
		$str.="- $strElementsNomInvalide<br>";
	}
	}
	if($mods['prenom']=="1") {	
	if(!$prenom) {
		$erreur=1;
		$str.="- $strElementsPrenomInvalide<br>";
	}
	}
	if($mods['ville']=="1") {
	if(!$ville) {
		$erreur=1;
		$str.="- $strElementsVilleInvalide<br>";
	}
	}
 	if(!$email || !eregi("^[a-z0-9\._-]+@+[a-z0-9\._-]+\.+[a-z]{2,3}$", $email)) {
 		$erreur=1;
		$str.="- $strElementsEmailInvalide<br>";
	}
	if(email_exist($email)!=0) {
		$erreur=1;
		$str.="- $strElementsEmailExistant<br>";
	}
	if($mods['age']=="1") {
	if(!$age || !is_numeric($age)) {	
		$erreur=1;
		$str.="- $strElementsAgeInvalide<br>";
	}	
	}
	if($mods['Osteamid']=="1") {
	if(!$steamid) { 
		$erreur=1;
		$str.="- $strSIDINV<br>";
	}
	if(!preg_match("#STEAM_[0-9]:[0-9]:[0-9]{4,}#si",$steamid)){ 	
		$erreur=1;
		$str.="- $strSIDINV2<br>";
	}
	
	if (steam_checking($steamid) && $steamid!="STEAM_0:0:00000")
	{
	$erreur=1;
	$str.="- $strSIDINV3<br>";
	}
	
	if ($steamid=="STEAM_0:0:00000" && $nosteam!="nosteam") {
	$erreur=1;
	$str.="- $strSIDINV4<br>";
	}
	
	} 
	else {
	$steamid='';
	}
	
	if($erreur==1) {			
		show_erreur_saisie($str);
	}
	else {
		$date=time();
		$pseudo=remove_XSS($pseudo);
		$nom=remove_XSS($nom);
		$prenom=remove_XSS($prenom);
		$email=remove_XSS($email);
		$age=remove_XSS($age);
		$ville=remove_XSS($ville);
		$steamid=strtoupper(remove_XSS($steamid));

		$db->select("max(id) as id");
		$db->from("${dbprefix}joueurs");
		$db->exec();
		$maxid = $db->fetch();		
		$nextid = $maxid->id + 1;	

		$db->insert("${dbprefix}joueurs (id, pseudo, passwd, nom, prenom, email, age, ville, origine, langue, dateinscription, steam)");
  		$db->values("$nextid, '$pseudo', md5('$passwd'), '$nom', '$prenom', '$email', '$age', '$ville', '$origine', '$langue', '$date', '$steamid'");
		$db->exec();

		/*** g&eacute;n&eacute;ration de l'email de confirmation ***/
		$link="<a href=\"".$config['urlsite']."/?page=joueurs&op=activation&key=".urlencode(base64_encode($nextid+10000))."\" target=\"_blank\">$strConfirm</a>";
		$array1=array("%nomsite%","%urlsite%","%login%","%password%","%email%","%link%");
		$array2=array($config['nomsite'],$config['urlsite'],$pseudo,$passwd,$email,$link);

		if($config['inscription_joueur_email'] && $config['mail']!='N') {
		
		if($config['inscription_joueur_email'] && $config['mail']!='S' && $config['smtpserver']!='' && $config['smtpuser']!='') {
		

			$to = $email;
			$from = $config['emailinscription'];
			$subject = $strInscriptionConfirmSubjectEmail;
			$subject = str_replace($array1, $array2, $subject);
			$body = $strInscriptionConfirmMessageEmail;
			$body = str_replace($array1, $array2, $body);

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
			else {
				$db->update("${dbprefix}joueurs");
				$db->set("etat = 'M'");
				$db->where("id = $nextid ");
				$db->exec();

				show_notice(str_replace($array1, $array2, $strInscriptionConfirmMessage));
				echo "<br><form method=post action='?page=index'><input type=submit class=action value=\"$strOK\"></form>";
			}
		} else {
		show_erreur("$strMailNotconfig<br>");
		}
		}
		else {
			// sinon on update direct
			$db->update("${dbprefix}joueurs");
			if($config['inscription_joueur_pre']) $db->set("etat = 'P'");
			else $db->set("etat = 'I'");
			$db->where("id = $nextid ");
			$db->exec();
	
			show_notice(str_replace($array1, $array2, $strInscriptionMessage));
			echo "<br><form method=post action='?page=index'><input type=submit class=action value=\"$strOK\"></form>";
		}		
	}
}

/********************************************************
 * Activation d'un joueur
 */
elseif($op == "activation") {
	
	/*** verification securite ***/
	if(!$config['inscription_joueur']) js_goto("?page=index");
	
	$id = base64_decode(urldecode($key));
	
	if(is_numeric($id)) {
		$id=$id-10000;

		$db->update("${dbprefix}joueurs");
		if($config['inscription_joueur_pre']) $db->set("etat = 'P'");
		else $db->set("etat = 'I'");
		$db->where("id = $id ");
		$db->where("etat = 'M'");
		$res=$db->exec();
								
		show_notice($strInscriptionConfirmMessageOK);
		echo "<br><form method=post action='?page=login'><input type=submit class=action value=\"$strOK\"></form>";
	}
	else
		show_error($strActivationInvalide);
		
}

/******************************************************** 
 * Supression d'un joueur
 */
elseif($op == "delete") {

	/*** verification securite ***/
	if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['j']!='j') {js_goto($PHP_SELF);} 

	if(is_numeric($id)) {
		$db->delete("${dbprefix}joueurs");
		$db->where("id = $id");
		$db->exec();
	
	// ajout  de @angelius : suppressions des messages des joueurs: 
	 $db->delete("${dbprefix}messages");
	 $db->where("destinataire = $id");
	 $db->exec();
	
	 $db->delete("${dbprefix}appartient");
	 $db->where("joueur = $id");
	 $db->exec();
	 //end
	}

	/*** redirection ***/
	js_goto("?page=joueurs&op=admin");
}

/********************************************************
 * Modification d'une fiche par un joueur
 */
elseif($op == "modify_fiche") {
		
	$str='';
	$erreur=0;
	
	if(!is_numeric($s_joueur) || $s_joueur != $id) {
		$erreur=1;
		$str.="- $strElementsJoueurInvalide<br>";
	}
	if(!$email || !eregi("^[a-z0-9\._-]+@+[a-z0-9\._-]+\.+[a-z]{2,3}$", $email)) {
 		$erreur=1;
		$str.="- $strElementsEmailInvalide<br>";
	}
	
	if($erreur==1) {		
		show_erreur_saisie($str);			
	}
	else {

		$email=remove_XSS($email);
		$icq=remove_XSS($icq);
		$aim=remove_XSS($aim);
		$msn=remove_XSS($msn);
		$yim=remove_XSS($yim);

		$db->update("${dbprefix}joueurs");
		$db->set("email='$email', icq='$icq', aim='$aim', msn='$msn', yim='$yim', langue='$langue',jointeam='$jointeam',allowmp='$allowmp'");

		foreach ($_POST as $key => $value) {
			if(preg_match("/^ext_([0-9a-zA-Z]+)$/", $key,$keylist)) {
				$value=remove_XSS($value);
				$db->set("$keylist[0]='$value'");
			}
		}
		$db->where("id = $s_joueur");
		$db->exec();

		//SessionSetVar("s_lang",$langue);
		
		/*** redirection ***/
		js_goto("?page=joueurs&id=$s_joueur");
	}	
}

/********************************************************
 * Modification d'un joueur
 */
elseif($op == "modify_admin") {

	/*** verification securite ***/
	if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['j']!='j') {js_goto($PHP_SELF);} 
	
	$str='';
	$erreur=0;

	if(!is_numeric($id)) {
		$erreur=1;
		$str.="- $strElementsJoueurInvalide<br>";
	}
	if(!$pseudo) {
		$erreur=1;
		$str="- $strElementsPseudoInvalide<br>";
	}
	if($mods['nom']=="1") {
	if(!$nom) {
		$erreur=1;
		$str.="- $strElementsNomInvalide<br>";
	}
	}
	if($mods['prenom']=="1") {
	if(!$prenom) {
		$erreur=1;
		$str.="- $strElementsPrenomInvalide<br>";
	}
	}
	if($mods['ville']=="1") {
	if(!$ville) {
		$erreur=1;
		$str.="- $strElementsVilleInvalide<br>";
	}
	}
 	if(!$email || !eregi("^[a-z0-9\._-]+@+[a-z0-9\._-]+\.+[a-z]{2,3}$", $email)) {
 		$erreur=1;
		$str.="- $strElementsEmailInvalide<br>";
	}
	if($mods['age']=="1") {
	if(!$age || !is_numeric($age)) {	
		$erreur=1;
		$str.="- $strElementsAgeInvalide<br>";
	}
	}
	if($mods['Osteamid']=="1") {
	if(!$steamid) { 
		$erreur=1;
		$str.="- $strSIDINV<br>";
	}
	if(!preg_match("#STEAM_[0-9]:[0-9]:[0-9]{4,}#si",$steamid)){ 	
		$erreur=1;
		$str.="- $strSIDINV2<br>";
	}
	
	if ($steamid=="STEAM_0:0:00000" && nosteam!="nosteam") {
	$erreur=1;
	$str.="- $strSIDINV4<br>";
	}
	
	} 
	else {
	$steamid='';
	}
	if($erreur==1) {
		show_erreur_saisie($str);
	}
	else {
		$date=time();
		$pseudo=remove_XSS($pseudo);
		$nom=remove_XSS($nom);
		$prenom=remove_XSS($prenom);
		$email=remove_XSS($email);
		$age=remove_XSS($age);
		$ville=remove_XSS($ville);
		$steamid=strtoupper((remove_XSS($steamid)));

		$icq=remove_XSS($icq);
		$aim=remove_XSS($aim);
		$msn=remove_XSS($msn);
		$yim=remove_XSS($yim);

		$db->update("${dbprefix}joueurs");
		$db->set("pseudo='$pseudo', nom='$nom', prenom='$prenom', email='$email', carton='$carton', sanction='$sanction', age='$age', ville='$ville',origine='$origine'");
		$db->set("icq='$icq', aim='$aim', msn='$msn', yim='$yim'");
		$db->set("admin='$admin', newseur='$newseur', modo='$modo', etat='$etat', langue='$langue'");
		$db->set("steam='$steamid',forum_userrank='$forum_userrank',remarque='$remarque',jointeam='$jointeam',allowmp='$allowmp'");
		if($etat=='P' || $etat=='I') $db->set("dateinscription = '$date'");

		foreach ($_POST as $key => $value) {
			if(preg_match("/^ext_([0-9a-zA-Z]+)$/", $key,$keylist)) {
				$value=remove_XSS($value);
				$db->set("$keylist[0]='$value'");
			}
		}

		$db->where("id = $id");
		$db->exec();
		
		/*** redirection ***/
		js_goto("?page=joueurs&op=admin&id=$id");
	}
}

/********************************************************
 * Modification du password
 */
elseif($op == "change_passwd") {

	/*** test de la session ***/
	if(empty($s_joueur)) js_goto("?page=index");

	echo "<p class=title>.:: $strModifPass ::.</p>\n";

	echo "<form method=post action=?page=joueurs&op=do_change_passwd>";
	echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
	echo "<table cellspacing=1 cellpadding=0 border=0>";
	echo "<tr><td>";
	echo "<table cellspacing=0 cellpadding=2 border=0 width=100%>";
	echo "<TR>";
	echo "<TD class=titlefiche align=center>$strAncienPass :</TD>";
	echo "<TD class=textfiche><INPUT TYPE=\"password\" NAME=\"pass\" size=10></TD>";
	echo "</TR>";
	echo "<TR>";
	echo "<TD class=titlefiche align=center>$strNouveauPass :</TD>";
	echo "<TD class=textfiche><INPUT TYPE=\"password\" NAME=\"nv_pass\" size=10></TD>";
	echo "</TR>";
	echo "<TR>";
	echo "<TD class=titlefiche align=center>$strConfirm :</font></TD>";
	echo "<TD class=textfiche><INPUT TYPE=\"password\" NAME=\"nv_pass2\" size=10></TD>";
	echo "</TR>";
	echo "<tr><td class=footerfiche align=center colspan=2><input type=submit class=action value=\"$strModifier\"></td></tr>";

	echo "</table>";
	echo "</td></tr></table>";
	echo "</td></tr></table>";
	echo "</form>";
	
	echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";
}

/********************************************************
 * Envoi du password
 */
elseif($op == "envoi_passwd") {

	echo "<p class=title>.:: $strEnvoiPass ::.</p>\n";

	echo "<form method=post action=?page=joueurs&op=do_envoi_passwd>";
	echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
	echo "<table cellspacing=1 cellpadding=0 border=0>";
	echo "<tr><td>";
	echo "<table cellspacing=0 cellpadding=2 border=0 width=100%>";
	echo "<tr>";
	echo "<td class=titlefiche align=center>$strPseudo :</TD>";
	echo "<td class=textfiche><INPUT TYPE=text NAME=pseudo size=20></TD>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class=titlefiche align=center>$strCodeConfirmation :</TD>";
	echo "<td class=textfiche><INPUT TYPE=text NAME=code size=20></TD>";
	echo "</tr>";
	echo "<tr><td class=footerfiche align=center colspan=2><input type=submit class=action value=\"$strValider\"></td></tr>";

	echo "</table>";
	echo "</td></tr></table>";
	echo "</td></tr></table>";
	echo "</form>";

	show_consignes($strPasswordEnvoiConsignes);

	echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";

}

/********************************************************
 * Modification du password
 */
elseif($op == "do_change_passwd") {

	/*** test de la session ***/
	if(empty($s_joueur)) js_goto("?page=index");

	$str='';
	$erreur=0;

	if(isset($pass) && isset($nv_pass) && isset($nv_pass2))
	{
		if($nv_pass!=$nv_pass2)
		{
			$erreur=1;
			$str = "$strNvPassIdent<br>";
		}
		else
		{
			$db->select("id");
			$db->from("${dbprefix}joueurs");
			$db->where("id = $s_joueur");
			$db->where("passwd = md5('$pass')");
			$db->exec();

			if($db->num_rows()!=1)
			{
				$erreur=1;
				$str = "$strAncienPassInvalid<br>";
			}
		}

		if($erreur==1) {
			show_erreur_saisie($str);
		}
		else {
			$db->update("${dbprefix}joueurs");
			$db->set("passwd = md5('$nv_pass')");
			$db->where("id = $s_joueur");
			$db->exec();

			/*** redirection ***/
			js_goto("?page=joueurs&id=$s_joueur");
		}
	}
}


/********************************************************
 * Envoi du mot de passe
 */
elseif($op == "do_envoi_passwd") {

	// si le pseudo n'est pas present
	if(!$pseudo) {
		show_erreur_saisie("- $strElementsPseudoInvalide<br>");
	}
	elseif($config['mail']=='N') {
		show_erreur($strPasDeFonctionMail);		
	}
	else {
		$db->select("id,passwd,email");
		$db->from("${dbprefix}joueurs");
		$db->where("pseudo = '$pseudo'");
		$db->exec();
		$joueur=$db->fetch();

		if($db->num_rows()!=1) {
			show_erreur($strElementsJoueurInvalide);
		}
		else {
			$code_t = substr($joueur->passwd, 0, 8);

			// le code de confirmation n'est pas pr&eacute;sent, on l'envoi d'abord par mail
			if(!$code) {

				// envoi du mail contenant le code
				$array1=array("%nomsite%","%urlsite%","%code%");
				$array2=array($config['nomsite'],$config['urlsite'],$code_t);

				$to = $joueur->email;
				$from = $config['emailcontact'];
				$subject = $strPasswordEmailCode;
				$subject = str_replace($array1, $array2, $subject);
				$body = $strPasswordEmailCodeMessage;
				$body = str_replace($array1, $array2, $body);

				$mail = new phpTMailer();
				$mail->From = $from;
				$mail->FromName = "";
				$mail->AddAddress($to);
				$mail->Subject = $subject;
				$mail->Body = $body;

				if(!$mail->Send()) {
					show_erreur("$strErreurMessageEnvoi<br><br>$mail->ErrorInfo");
				}
				else {
					show_notice($strPasswordMessageCode);
					echo "<br><input type=button class=action value=\"$strOK\" onclick=back()><br>";
				}
			}
			else {
				// le code rentr&eacute; est le bon,
				if($code==$code_t) {

					// g&eacute;n&eacute;ration du nouveau pass
					$nv_pass=make_pass();

					// envoi du mail contenant le nouveau pass
					$array1=array("%nomsite%","%urlsite%","%passwd%");
					$array2=array($config['nomsite'],$config['urlsite'],$nv_pass);
				
					$to = $joueur->email;
					$from = $config['emailcontact'];
					$subject = $strPasswordEmail;
					$subject = str_replace($array1, $array2, $subject);
					$body = $strPasswordEmailMessage;
					$body = str_replace($array1, $array2, $body);

					$mail = new phpTMailer();
					$mail->From = $from;
					$mail->FromName = "";
					$mail->AddAddress($to);
					$mail->Subject = $subject;
					$mail->Body = $body;

					if(!$mail->Send()) {
						show_erreur("$strErreurMessageEnvoi<br><br>$mail->ErrorInfo");
					}
					else {
						// mise a jour du pass dans la base
						$db->update("${dbprefix}joueurs");
						$db->set("passwd = md5('$nv_pass')");
						$db->where("id = $joueur->id");
						$db->exec();

						show_notice($strPasswordMessage);
						echo "<br><form method=post action='?page=login'><input type=submit class=action value=\"$strOK\"></form>";
					}
				}
				else {
					show_erreur($strElementsCodeInvalide);
				}
			}
		}
	}
}

/********************************************************
 * Reset admin du password
 */
elseif($op == "reset_passwd") {

	/*** verification securite ***/
	if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['j']!='j') {js_goto($PHP_SELF);} 
			
	$db->select("id,passwd,email");
	$db->from("${dbprefix}joueurs");
	$db->where("id = '$id'");
	$db->exec();
	$joueur=$db->fetch();

	if($db->num_rows()!=1) {
		show_erreur($strElementsJoueurInvalide);
	}
	else {
		// g&eacute;n&eacute;ration du nouveau pass
		$nv_pass=make_pass();
		$array1=array("%nomsite%","%urlsite%","%passwd%");
		$array2=array($config['nomsite'],$config['urlsite'],$nv_pass);
			
		if($config['mail']!='N') {

			// envoi du mail contenant le nouveau pass				
			$to = $joueur->email;
			$from = $config['emailcontact'];
			$subject = $strPasswordEmail;
			$subject = str_replace($array1, $array2, $subject);
			$body = $strPasswordEmailMessage;
			$body = str_replace($array1, $array2, $body);
	
			$mail = new phpTMailer();
			$mail->From = $from;
			$mail->FromName = "";
			$mail->AddAddress($to);
			$mail->Subject = $subject;
			$mail->Body = $body;
	
			if(!$mail->Send()) {
				show_erreur("$strErreurMessageEnvoi<br><br>$mail->ErrorInfo");
			}
			else {
				// mise a jour du pass dans la base
				$db->update("${dbprefix}joueurs");
				$db->set("passwd = md5('$nv_pass')");
				$db->where("id = $id");
				$db->exec();
	
				show_notice(str_replace($array1, $array2, $strPasswordMessageAdmin));
				echo "<br><input type=button class=action value=\"$strOK\" onclick=back()><br>";
			}	
		}
		else {		
			// mise a jour du pass dans la base direct
			$db->update("${dbprefix}joueurs");
			$db->set("passwd = md5('$nv_pass')");
			$db->where("id = $id");
			$db->exec();

			show_notice(str_replace($array1, $array2, $strPasswordMessageAdmin));
			echo "<br><input type=button class=action value=\"$strOK\" onclick=back()><br>";
		
					
		}	
	}
}

/******************************************************** 
 * Creation d'un joueur externe 
 */ 
elseif($op == "inscription") { 
$isntafile_usesql="no"; 
   /*** verification securite ***/ 
   if(!$config['inscription_joueur']) js_goto("?page=index"); 


   if(!isset($ok) && $config['decharge']) { 
       
      echo "<p class=title>.:: $strConditionsGenerales ::.</p>"; 

      $decharge=$config['decharge']; 

// 
$decharge=str_replace ( "..", "", $decharge); 
if ($isntafile_usesql=="no" && file_exists("./include/html/reglements/$s_lang/$decharge") && !is_dir("./include/html/reglements/$s_lang/$decharge")) { 
   echo "<table border=0><tr><td>"; 
   include("include/html/reglements/$s_lang/$decharge"); 
   echo "</td></tr></table>"; 
} 

 else{ 
// 
      $decharge = BBCode($decharge); 


   if($decharge!=NULL||$decharge!="") { 
       
      echo "<table border=0><tr><td>"; 
      echo $decharge; 
      echo "</td></tr></table>"; 
    
   } 
} 

      echo "<br /><br /><table border=0><tr>"; 
        echo '<td><a href="?page=joueurs&op=inscription&ok=1"><span style="color:green;font-weight:bold;">'.$strJAccepte.'</span></a> -</td>'; 
         echo '<td><a href="?page=index"><span style="color:red;font-weight:bold;">'.$strJeRefuse.'</span></a></td>'; 
         echo "</tr></table><br>"; 
                      
   }//fine isset && config 
   else { 
    
      echo "<p class=title>.:: $strNouveauJoueur ::.</p>";
	
	 	/*** table du joueur ***/
		echo "<form method=post action=?page=joueurs&op=do_inscription name=insjoueur>";
		echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
		echo "<table cellspacing=1 cellpadding=0 border=0 class=fiche>";
		echo "<tr><td class=headerfiche>$strFiche</td></tr>";
		echo "<tr><td>";
		echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
	
		/*** pseudo ***/
		echo "<tr><td class=titlefiche>$strPseudo <font color=red><b>*</b></font> :</td>";
		echo "<td class=textfiche>";
		echo "<input type=text name=pseudo maxlength=20>";
		echo "</td></tr>";
	
		/*** password ***/
		echo "<tr><td class=titlefiche>$strPassword <font color=red><b>*</b></font> :</td>";
		echo "<td class=textfiche>";
		echo "<input type=password name=passwd maxlength=50 size=10>";
		echo "</td></tr>";
	
		/*** nom ***/
		if($mods['nom']=="1") {
		echo "<tr><td class=titlefiche>$strNom <font color=red><b>*</b></font> :</td>";
		echo "<td class=textfiche>";
		echo "<input type=text name=nom maxlength=20>";
		echo "</td></tr>";
		}
	
		/*** prenom ***/
		if($mods['prenom']=="1") {
		echo "<tr><td class=titlefiche>$strPrenom <font color=red><b>*</b></font> :</td>";
		echo "<td class=textfiche>";
		echo "<input type=text name=prenom maxlength=20>";
		echo "</td></tr>";
		}
	
		/*** ville ***/
		if($mods['ville']=="1") {
		echo "<tr><td class=titlefiche>$strVille <font color=red><b>*</b></font> :</td>";
		echo "<td class=textfiche>";
		echo "<input type=text name=ville maxlength=50>";
		echo "</td></tr>";
		}
	
		/*** email **/
		echo "<tr><td class=titlefiche>$strEMail <font color=red><b>*</b></font> :</td>";
		echo "<td class=textfiche>";
		echo "<input type=text name=email maxlength=100 size=30>";
		echo "</td></tr>";
	
		/*** age ***/
		if($mods['age']=="1") {
		echo "<tr><td class=titlefiche>$strAge <font color=red><b>*</b></font> :</td>";
		echo "<td class=textfiche>";
		echo "<input type=text name=age  size=3>";
		echo "</td></tr>";
		}
		
		/*** Steam id ***/
		if($mods['Osteamid']=="1") {
		echo "<tr><td class=titlefiche>$strSID<font color=red><b>*</b></font> :</td>";
		echo "<td class=textfiche>";
		echo "<input type=text name=steamid> <i>STEAM_X:X:XXXXX</i>";
		echo "</td></tr>";
		echo "<tr><td class=titlefiche>-</td>";
		echo "<td class=textfiche>$strSID2";
		echo '<input name="nosteam" type="checkbox"  value="nosteam" onClick=\'if(this.checked) {document.insjoueur.steamid.value="STEAM_0:0:00000"}else{document.insjoueur.steamid.value=""}\'>';
		echo "</td></tr>";
		}
	
	
		/*** origine ***/
		$tab_countrys = file("images/flags/country");
		echo "<tr><td class=titlefiche>$strOrigine <font color=red><b>*</b></font> :</td>";
		echo "<td class=textfiche>";
	
		echo "<select name=origine>";
		for($i=0;$i<count($tab_countrys);$i++) {
			$tab_country=split(',',$tab_countrys[$i]);
			$country_code=$tab_country[0];
			$country_name=$tab_country[1];
			echo "<option value=$country_code";
			if ($country_code == 'FR') echo " SELECTED";
			echo ">$country_name";
		}
		echo "</select>";
		echo "</td></tr>";
	
		/*** langue ***/
		echo "<tr><td class=titlefiche>$strLangue <font color=red><b>*</b></font> :</td>";
		echo "<td class=textfiche>";
	
		echo "<select name=langue>";
		$fd = opendir("lang/");
		while($file = readdir($fd)) {
			if ($file != "." && $file != "..") {
				$file = ereg_replace(".inc.php","",$file);
				echo "<option value=$file";
				if ($file == $config['default_lang']) echo " SELECTED";
				echo ">$file";
			}
		}
		echo "</select>";
		closedir($fd);
		echo "</td></tr>";
	
		echo "<tr><td class=footerfiche align=center colspan=2><input type=submit class=action class=action value=\"$strValider\"></td></tr>";
		echo "</table>";
	
		echo "</td></tr></table>";
		echo "</td></tr></table>";
		echo "</form>";
	
		show_consignes($strInscriptionsJoueursConsignes);
	}
	echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";

}

/********************************************************
 * Affichage admin + normal
 */
else {

	/*** verification securite ***/
	if($op == 'admin') {if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['j']!='j') {js_goto($PHP_SELF);} }

	if($op) $op_str="&op=$op";
	else $op_str='';

	/*** liste des tous les joueurs ***/
	if(empty($id)) {

		$nbinscrits=nb_joueurs_inscrit();
		$nbplaces=$config['places'];
		
		if($op == 'admin') echo "<p class=\"title\">.:: $strAdminJoueurs ::.</p>";
		else echo "<p class=\"title\">.:: $strJoueurs ::.</p>";

		if(nb_joueurs_total($op)!=0) {

			echo '<table cellspacing="0" cellpadding="0" border="0">';
			echo '<tr><td class="title" align="center">';
			echo "<input type=\"button\" value=\"$strInscrits\" onclick=\"location='?page=joueurs$op_str&list=I'\">";
			echo " <input type=\"button\" value=\"$strPreinscrits\" onclick=\"location='?page=joueurs$op_str&list=P'\">";
			if($op == 'admin') echo " <input type=\"button\" value=\"$strCaches\" onclick=\"location='?page=joueurs$op_str&list=C'\">";
			echo " <input type=\"button\" value=\"$strTous\" onclick=\"location='?page=joueurs$op_str'\">";
			
			echo '</td></tr>';
			echo '</table><br>';

			/** gestion des affichages **/
			if(!isset($list)) $list = '';

			if($list == 'I') {
				$tab_etat=array("etat = 'I'");
			}
			elseif($list == 'P') {
				$tab_etat=array("etat = 'P'");
			}
			elseif($op == 'admin' && $list == 'C') {
				$tab_etat=array("(etat = 'C' or etat = 'M')");
			}
			elseif($op == 'admin') {
				$tab_etat=array("(etat = 'C' or etat = 'M' or etat = 'I' or etat = 'P')");
			}
			else {
				$tab_etat=array("etat = 'I'","etat = 'P'");
			}


			for($e=0;$e<count($tab_etat);$e++) {

				$db->select("*");
				$db->from("${dbprefix}joueurs");
				$db->where("$tab_etat[$e]");
				$db->where("id > '0'");
				$db->order_by('pseudo');
				$joueurs=$db->exec();

				/** reinit des colonne a 1 ***/
				if ($db->num_rows($joueurs) < $config['col_joueurs']) $col_joueurs=1;
				else $col_joueurs=$config['col_joueurs'];

				if ($db->num_rows($joueurs) != 0) {
					$i=0;
					$tab_joueurs=array();
					
					while ($joueur = $db->fetch($joueurs)) {
						$tab_joueurs[$i]=$joueur;
						$i++;
					}

					if($tab_etat[$e]=="etat = 'I'") {
						echo '<table cellspacing="0" cellpadding="0" border="0">';
						echo '<tr><td class="title" align="center">';
						if($nbinscrits > $nbplaces)	echo "<font color=\"red\">$nbinscrits</font> / $nbplaces $strJoueurs";
						else echo "$nbinscrits / $nbplaces $strJoueursInscrits";
						echo '</td></tr>';
						echo '</table>';
					}

					if($tab_etat[$e]=="etat = 'P'") {
						echo '<table cellspacing="0" cellpadding="0" border="0">';
						echo '<tr><td class="title" align="center">'. nb_joueurs_preinscrit() ." $strJoueursPreinscrit</td></tr>";
						echo '</table>';
					}

					echo '<table cellspacing=0 cellpadding=0 border=0 class="liste"><tr valign="top">';
					if ($op == 'admin') echo "<form name='liste' method=post action=?page=joueurs&op=status>";
					
					for($i=0;$i<$col_joueurs;$i++) {
						echo '<td>';
						echo '<table border="0" cellpadding="0" cellspacing="0" class="bordure1"><tr><td>';
						echo '<table cellspacing="1" cellpadding="2" border="0">';
						echo "<tr><td class=\"headerliste\">#</td><td width=\"120\" class=\"headerliste\">$strPseudo</td><td class=\"headerliste\">$strVille</td><td class=\"headerliste\">$strAge</td><td class=\"headerliste\">$strStatus</td></tr>";

						for($j=$i;$j<count($tab_joueurs);$j=$j+$col_joueurs) {
							echo '<tr>';
							echo '<td class="textliste" align="center">'.$tab_joueurs[$j]->id.'</td>';
							echo '<td class="textliste">';
							echo '<div style="clear: both"><div style="float: left">'.show_joueur($tab_joueurs[$j]->id,$op);
							//supression de l'étoile
							//if($tab_joueurs[$j]->admin=='O') echo '*'; 
							if ($tab_joueurs[$j]->carton == 'aucun')
							{
							echo "";
							}
							else 
							{
							echo "<A href=\"?page=reglements\" onMouseOver=\"AffBulle('<b>$strCarton ".$tab_joueurs[$j]->carton." </b>: ".$tab_joueurs[$j]->sanction."')\" onMouseOut=\"HideBulle()\"><img src=\"images/cartons/".$tab_joueurs[$j]->carton.".gif\" border=\"0\" align=\"absmiddle\"></A>";
							} 
							echo '</div>';
							if($op == 'admin' && nb_tournois_joueur($tab_joueurs[$j]->id) == 0 && nb_equipes_joueur($tab_joueurs[$j]->id)==0)
								echo '<div style="float: right">&nbsp;<a href="?page=joueurs&op=delete&id='.$tab_joueurs[$j]->id."\" onclick=\"return confirm('$strConfirmEffacerJoueur');\">[$strS]</a></div>";
							echo '</div></td>';
							echo '<td class="textliste" align="center">'.$tab_joueurs[$j]->ville.'</td>';
							echo '<td class="textliste" align="center">'.$tab_joueurs[$j]->age;if($tab_joueurs[$j]->age) echo "&nbsp;$strAn";echo '</td>';
							echo '<td class="textliste" align="center">';
							
							if ($op == 'admin') {							
								echo '<select name="status" onchange="status_joueur('.$tab_joueurs[$j]->id.',this.value,\''.$strChangerStatusJoueur.'\')">';
								echo '<option value="C"';if ($tab_joueurs[$j]->etat == 'C') echo ' SELECTED';echo ">$strCache";
								echo '<option value="M"';if ($tab_joueurs[$j]->etat == 'M') echo ' SELECTED';echo ">$strAttenteMail";
								echo '<option value="P"';if ($tab_joueurs[$j]->etat == 'P') echo ' SELECTED';echo ">$strPreinscrit";
								echo '<option value="I"';if ($tab_joueurs[$j]->etat == 'I') echo ' SELECTED';echo ">$strInscrit";
								echo '</select>';
								echo '<input type=checkbox name=tab_status[] value='.$tab_joueurs[$j]->id.' style="border=0px;background-color:transparent;">';

							}
							else {
								if ($tab_joueurs[$j]->etat == 'P') echo "<font color=\"red\">$strPreinscrit</font>";
								elseif ($tab_joueurs[$j]->etat == 'I') echo "<font color=\"green\">$strInscrit</font>";
							}
							echo '</td></tr>';
						}
						echo '</table>';
						echo '</td></tr></table>';
						echo '</td>';
					}
					echo '</tr></table>';
					
					if ($op == 'admin') {
						echo "<table cellspacing=1 cellpadding=2 border=0>";
						echo "<tr><td class=text align=center><a href=javascript:select_all('liste')>$strToutSelectionner<a/> - <a href=javascript:unselect_all('liste')>$strToutDeselectionner<a/></td></tr>";
						echo "<tr><td class=text align=center>";
						echo '<select name="status">';
						echo "<option value=\"C\">$strCache";
						echo "<option value=\"M\">$strAttenteMail";
						echo "<option value=\"P\">$strPreinscrit";
						echo "<option value=\"I\">$strInscrit";
						echo '</select>';								
						echo "<input type=submit value=\"$strValider\"></td></tr>";
						echo "</form></table>";
					}
				}
				else {
					if($list=='I' || $list=='P' || $list=='C') {
						echo "<table cellspacing=2 cellpadding=2 border=0>";
						echo "<tr><td class=title>$strPasDeJoueur</td></tr>";
						echo "</table>";
					}
				}
			}
			echo "<br>";

			if($op!='admin') {
				show_consignes($strJoueursConsignes);
			}
		}
		else {
			echo "<table cellspacing=2 cellpadding=2 border=0>";
			echo "<tr><td class=title>$strPasDeJoueur</td></tr>";
			echo "</table><br>";
		}

		/*** ajout d'un joueur ***/
 if ($op == 'admin') {
  
  // => Option rehcercher joueur & ajout joueur
   echo '<table border="0" cellpadding="1" cellspacing="1"><tr> <td>';
  // => END Option rehcercher joueur & ajout joueur
  echo '<form method="post" action="?page=joueurs&op=add">';
  echo '<table border=0 cellpadding="0" cellspacing="0" class="bordure2"><tr><td>';
  echo '<table cellspacing="1" cellpadding="0" border="0">';
  echo "<tr><td class=\"headerfiche\">$strAjouterJoueur</td></tr>";
  echo '<tr><td>';
  echo '<table cellspacing="0" cellpadding="3" border="0" width="100%">';
  echo '<tr>';
  echo "<td class=\"titlefiche\">$strPseudo <font color=\"red\"><b>*</b></font> :</td>";
  echo '<td class="textfiche"><input type="hidden" name="rech_sec" value="ok"><input type="text" name="pseudo" maxlength="20"></td>';
  echo '</tr>';
  echo "<tr><td class=\"footerfiche\" align=\"center\" colspan=\"2\"><input type=\"submit\" class=\"action\" value=\"$strAjouter\"></td></tr>";
  echo '</table>';
  echo '</td></tr></table>';
  echo '</td></tr></table>';
  echo '</form>';
  echo'</td><td>&nbsp;</td><td>';
 
 /*** Recherche d'un joueur ***/
 
  echo '<form method="post" action="?page=joueurs&op=rech">';
  echo '<table border=0 cellpadding="0" cellspacing="0" class="bordure2"><tr><td>';
  echo '<table cellspacing="1" cellpadding="0" border="0">';
  echo "<tr><td class=\"headerfiche\">$strRechercherJoueur</td></tr>";
  echo '<tr><td>';
  echo '<table cellspacing="0" cellpadding="3" border="0" width="100%">';
  echo '<tr>';
  echo "<td class=\"titlefiche\">$strPseudo <font color=\"red\"><b>*</b></font> :</td>";
  echo '<td class="textfiche"><input type="text" name="pseudo" maxlength="20"></td>';
  echo '</tr>';
  echo "<tr><td class=\"footerfiche\" align=\"center\" colspan=\"2\"><input type=\"submit\" class=\"action\" value=\"$strRechecrher\"></td></tr>";
  echo '</table>';
  echo '</td></tr></table>';
  echo '</td></tr></table>';
  echo '</form>';
  echo '</td>
     </tr>
   </table>';
   $rech_v=u;

 }
}

		
	

	/*** fiche d'un joueur ***/
	else {

		$joueur = joueur($id);

		echo "<p class=\"title\">.:: $strJoueur $joueur->pseudo::.</p>";
	
		echo '<table cellspacing="0" cellpadding="0" border="0">';
		echo '<tr><td class="title" align="center">';
		echo "<a href=\"?page=joueurs$op_str&id=$id\">$strFiche</a> | <a href=\"?page=joueurs$op_str&section=resultats&id=$id\">$strResultats</a>";
		if($config['messagerie']) echo " | <a href=\"?page=messagerie&op=ecrire&destinataire=$id\">$strContact</a>";
		echo '</td></tr>';
		echo '</table><br>';
		
		if(!isset($section)) {

			if($op=='admin') echo '<form method="post" action="?page=joueurs&op=modify_admin">';
			else echo '<form method="post" action="?page=joueurs&op=modify_fiche">';
			
			echo "<input type=\"hidden\" name=\"id\" value=\"$id\">";
	
			/*** table du joueur ***/
			echo '<table cellpadding="0" cellspacing="0" border="0" class="bordure1" width="350"><tr><td>';
			echo '<table cellspacing="1" cellpadding="0" border="0" class="fiche" width="100%">';
			echo "<tr><td class=\"headerfiche\">$strFiche</td></tr>";
			echo '<tr><td>';

			echo '<table cellspacing="0" cellpadding="2" border="0" width="100%">';

			/*** pseudo ***/
			echo "<tr>";
			echo '<td class="textfiche" colspan="2" align=right>';
			if ($op == 'admin' ){
				echo "$strPseudo :";
				echo "<input type=\"text\" name=\"pseudo\" value=\"".stripslashes($joueur->pseudo)."\" maxlength=\"20\">";
				}
			else {
				echo "<b><font size=5px>$joueur->pseudo</b>";
			}
			
			echo '</td>';
			/*** avatar ***/
			echo '<td class="textfiche" colspan="2" style="vertical-align:top">';
			if($config['avatar']=='J' || $config['avatar']=='A') {
				echo '<span style="float: right;" >'.show_avatar($joueur->avatar_img).'</span>';
			}
			echo '</td></tr>';
	
					
			/*** nom ***/
			if($mods['nom']=="1") {
			if ($op == 'admin') {
				echo "<tr><td width=\"30%\" class=\"titlefiche\">$strNom :</td>";
				echo '<td class="textfiche" colspan="6">';
				echo "<input type=\"text\" name=\"nom\" value=\"".stripslashes($joueur->nom)."\" maxlength=\"20\">";
				echo '</td></tr>';
			}
			}

			/*** prenom ***/
			if($mods['prenom']=="1") {
			if ($op == 'admin') {
				echo "<tr><td class=\"titlefiche\">$strPrenom :</td>";
				echo '<td class="textfiche" colspan="4">';
				echo "<input type=\"text\" name=\"prenom\" value=\"".stripslashes($joueur->prenom)."\" maxlength=\"20\">";
				echo '</td></tr>';
			}
			}
			
			/*** ville ***/
			if($mods['ville']=="1") {
			echo "<tr><td class=\"titlefiche\">$strVille :</td>";
			echo '<td class="textfiche" colspan="4">';
			
			if ($op == 'admin')
				echo "<input type=\"text\" name=\"ville\" value=\"".stripslashes($joueur->ville)."\" size=\"30\">";
			else
				echo $joueur->ville;
			echo '</td></tr>';
			}

			/*** age ***/
			if($mods['age']=="1") {
			echo "<tr><td class=\"titlefiche\">$strAge :</td>";
			echo '<td class="textfiche" colspan="4">';

			if ($op == 'admin')
				echo "<input type=\"text\" name=\"age\" value=\"".stripslashes($joueur->age)."\" size=\"3\">";
			else {
				echo $joueur->age;
				if($joueur->age) echo "&nbsp;$strAn";
			}
			echo '</td></tr>';
			}
			
			/*** origine ***/
			$tab_countrys = file("images/flags/country");
			echo "<tr><td class=\"titlefiche\">$strOrigine :</td>";
			echo '<td class="textfiche" colspan="4">';
	
			if ($op == 'admin') {
				echo '<select name="origine">';
		
				for($i=0;$i<count($tab_countrys);$i++) {
					$tab_country=split(',',$tab_countrys[$i]);
					$country_code=$tab_country[0];
					$country_name=$tab_country[1];
					echo "<option value=\"$country_code\"";
					if ($country_code == $joueur->origine) echo ' SELECTED';
					echo ">$country_name";
				}
				echo '</select>';
			}
			else {
				for($i=0;$i<count($tab_countrys);$i++) {
					$tab_country=split(',',$tab_countrys[$i]);
					$country_code=$tab_country[0];
					$country_name=$tab_country[1];
					if ($country_code == $joueur->origine) break;
				}
				echo "<img src=\"images/flags/$country_code.gif\" align=\"absmiddle\" border=\"0\">&nbsp;$country_name";
			}
			echo '</td></tr>';


			
			/*** email **/
			echo "<tr><td class=\"titlefiche\">$strEMail :</td>";
			echo '<td class="textfiche" colspan="3">';
	
			if ($op == 'admin' || $id == $s_joueur)
				echo "<input type=\"text\" name=\"email\" value=\"$joueur->email\" size=\"40\">";
			elseif($joueur->email)
				echo "<a href=\"mailto:$joueur->email\">$joueur->email</a>";
			echo '</td></tr>';
	

			/*** equipes ***/
			echo "<tr><td class=\"titlefiche\">$strEquipes :</td>";
			echo '<td nowrap class="textfiche" colspan="3">';

			$mesequipes=equipes_joueur($id);
			$teamcou="2";
			for($i=0;$i<count($mesequipes);$i++) {
				$teamcou='1';
				echo show_equipe($mesequipes[$i]['id'],$op).'&nbsp;';
			}		
			if ($teamcou!="1") {echo "- no team -";}
			echo '</td>';
			
			/*** Steamid ***/
			if($mods['Osteamid']=="1") {
		    if ($op == 'admin') {
				echo "<tr><td class=\"titlefiche\">$strSID :</td>";
				echo '<td class="textfiche" colspan="4">';
				echo "<input type=\"text\" name=\"steamid\" value=\"".stripslashes($joueur->steam)."\"> <i>STEAM_X:X:XXXXX</i>";
				echo '</td></tr>';
		    }
			else {
				echo "<tr><td class=\"titlefiche\">$strSID :</td>";
				echo '<td class="textfiche" colspan="4">';
				echo "".stripslashes($joueur->steam)."";
				echo '</td></tr>';
			}
			}
			
			/*** Autoriser ajout team par manager ***/
			if ($op == 'admin' || $id == $s_joueur) {
				echo "<tr><td class=\"titlefiche\">$strAutoajoutTeam :</td>";
				echo '<td class=textfiche colspan=4>';
	
				echo '<select name="jointeam">';
				echo ($joueur->jointeam==1) ? "<option value='1' selected>$strAllowJoinTeam</option>" : "<option value='0'selected>$strUnAllowJoinTeam</option>";
				echo '<option value="1">'.$strAllowJoinTeam.'</option>';
				echo '<option value="0">'.$strUnAllowJoinTeam.'</option>';
				echo '</select>';
				echo '</td></tr>';
			} else {
				echo "<tr><td class=\"titlefiche\">$strAutoajoutTeam :</td>";
				echo '<td class="textfiche" colspan="4">';
				echo ($joueur->jointeam==1) ? $strAllowJoinTeam : $strUnAllowJoinTeam;
				echo '</td></tr>';
			}
			
			/*** Autoriser les MP publique  ***/
			if ($op == 'admin' || $id == $s_joueur) {
				echo "<tr><td class=\"titlefiche\">$strAutoMp :</td>";
				echo '<td class=textfiche colspan=4>';
	
				echo '<select name="allowmp">';
				if ($joueur->allowmp==1) {
				echo "<option value='1' selected>$strAllowPrivateMessage</option>";
				}
				else { 
				echo  "<option value='0' selected>$strUnAllowPrivateMessage</option>";
				}
				echo '<option value="1">'.$strAllowPrivateMessage.'</option>';
				echo '<option value="0">'.$strUnAllowPrivateMessage.'</option>';
				echo '</select>';
				echo '</td></tr>';
			} else {
				echo "<tr><td class=\"titlefiche\">$strAutoMp :</td>";
				echo '<td class="textfiche" colspan="4">';
				echo ($joueur->allowmp==1) ? $strAllowPrivateMessage : $strUnAllowPrivateMessage;
				echo '</td></tr>';
			}
			
			/*** Forum User Rank ***/
			if($strTopic) {
		    if ($op == 'admin') {
				echo "<tr><td class=\"titlefiche\">$strRkforum :</td>";
				echo '<td class="textfiche" colspan="4">';
				echo "<input type=\"text\" name=\"forum_userrank\" value=\"".stripslashes($joueur->forum_userrank)."\">";
				echo '</td></tr>';
		    }
			
			}
			
			/*if ($op == 'admin' ) {
				echo "<tr>";
				echo '<td class="textfiche" colspan="4" align=center>';
				echo '<form method="post" action="?page=rang&op=modify&id_j='.$joueur->id.'">';
				echo "<input type=\"submit\" class=\"action\" value=\"$strEdit_rang\">";
				echo "</form>";
				echo '</td></tr>';
			}
			*/
			/*** admin ***
			if ($op == 'admin' ) {
				echo "<tr><td class=\"titlefiche\">$strAdmin :</td>";
				echo '<td class="textfiche" colspan="3">';
	
				echo '<input type="radio" name="admin" value="O" style="border: 0px;background-color:transparent;"';if ($joueur->admin == 'O') echo ' CHECKED';echo "> $strOui ";
				echo '<input type="radio" name="admin" value="N" style="border: 0px;background-color:transparent;"';if ($joueur->admin == 'N') echo ' CHECKED';echo "> $strNon";
				echo '</td></tr>';
			}
	
			/*** newser ***
			if ($op == 'admin' ) {
				echo "<tr><td class=\"titlefiche\">$strNewseur :</td>";
				echo '<td class="textfiche" colspan="3">';
	
				echo '<input type="radio" name="newseur" value="O" style="border: 0px;background-color:transparent;"';if ($joueur->newseur == 'O') echo ' CHECKED';echo "> $strOui ";
				echo '<input type="radio" name="newseur" value="N" style="border: 0px;background-color:transparent;"';if ($joueur->newseur == 'N') echo ' CHECKED';echo "> $strNon";
				echo '</td></tr>';
			}
			
			/*** modo ***
			if ($op == 'admin' ) {
				echo "<tr><td class=\"titlefiche\">$strModo :</td>";
				echo '<td class="textfiche" colspan="3">';
	
				echo '<input type="radio" name="modo" value="O" style="border: 0px;background-color:transparent;"';if ($joueur->modo == 'O') echo ' CHECKED';echo "> $strOui ";
				echo '<input type="radio" name="modo" value="N" style="border: 0px;background-color:transparent;"';if ($joueur->modo == 'N') echo ' CHECKED';echo "> $strNon";
				echo '</td></tr>';
			}*/
	
			/*** admin ***/
			if ($op == 'admin') {
				echo "<tr><td class=\"titlefiche\">$strAdmin :</td>";
				echo '<td class="textfiche" colspan="3">';
				echo "<input type=\"button\" class=\"action\" value=\"$strResetPass\" onclick=\"location='?page=joueurs&op=reset_passwd&id=$id'\">";
				echo "<input type=\"button\" class=\"action\" value=\"$strEdit_rang\" onclick=\"location='?page=rang&op=edit&id_j=$joueur->id'\">";
				echo '</td></tr>';
			}
			elseif($id == $s_joueur) {
				echo "<tr><td class=\"titlefiche\">$strPassword :</td>";
				echo '<td class="textfiche" colspan="3">';
				echo "<input type=\"button\" class=\"action\" value=\"$strModifPass\" onclick=\"location='?page=joueurs&op=change_passwd'\">";
				echo '</td></tr>';
			}
	
			/*** avatar ***/
			if (($op == 'admin' || $id == $s_joueur) && ($config['avatar']=='J' || $config['avatar']=='A')) {
				echo "<tr><td class=\"titlefiche\">$strAvatar :</td>";
				echo '<td class="textfiche" colspan="3">';
				echo "<input type=\"button\" class=\"action\" value=\"$strModifierAvatar\" onclick=\"location='?page=avatars&id=$id&mode=J'\">";
				echo '</td></tr>';
			}
	
			/*** divers ***/
			if ($op == 'admin' || $id == $s_joueur) {
				echo "<tr><td class=\"titlefiche\">$strICQ :</td>";
				echo '<td class="textfiche">';		
				echo "<input type=\"text\" name=\"icq\" value=\"$joueur->icq\" size=\"15\">";
				echo '</td>';				
				echo "<td class=\"titlefiche\" width=\"25%\">$strAIM :</td>";
				echo '<td class="textfiche" width="25%">';	
				echo "<input type=\"text\" name=\"aim\" value=\"$joueur->aim\" size=\"15\">";
				echo '</td></tr>';				
				echo "<tr><td class=\"titlefiche\">$strYIM :</td>";
				echo '<td class="textfiche" width="25%">';
				echo "<input type=\"text\" name=\"yim\" value=\"$joueur->yim\" size=\"15\">";
				echo '</td>';		
				echo "<td class=\"titlefiche\" width=\"25%\">$strMSN :</td>";
				echo '<td class="textfiche" width="25%">';
				echo "<input type=\"text\" name=\"msn\" value=\"$joueur->msn\" size=\"15\">";
				echo '</td></tr>';
			}
			else {				
				echo "<tr><td class=\"titlefiche\">$strICQ :</td>";
				echo '<td class="textfiche" colspan=3>';
				
				echo '<table cellspacing="0" cellpadding="0" border="0" width="100%"><tr>';
				echo '<td class="textfiche">';				
				if($joueur->icq) echo "<a href=\"http://people.icq.com/whitepages/about_me/1,,,00.html?Uin=".$joueur->icq."\" target=\"_blank\"><img src=\"http://web.icq.com/whitepages/online?icq=$joueur->icq&img=5\" alt=\"$joueur->icq\" border=0></a>";
				else echo 'N/A';				
				echo '</td>';		
				echo "<td class=\"titlefiche\">$strAIM :</td>";
				echo '<td class="textfiche">&nbsp;';
				if($joueur->aim) echo "<a href=\"aim:goim?screenname=".$joueur->aim."&amp;message=Hello\"><img src=\"images/p_aim.gif\" align=\"absmiddle\" border=\"0\" alt=\"$joueur->aim\"></a>";
				else echo 'N/A';				
				echo '</td>';				
				echo "<td class=\"titlefiche\">$strYIM :</td>";
				echo '<td class="textfiche">&nbsp;';
				if($joueur->yim) echo "<a href=\"http://edit.yahoo.com/config/send_webmesg?.target=".$joueur->yim."&amp;.src=pg\" target=\"_blank\"><img src=images/p_yim.gif align=\"absmiddle\" border=\"0\" alt=\"$joueur->yim\"></a>";
				else echo 'N/A';				
				echo '</td>';		
				echo "<td class=\"titlefiche\">$strMSN :</td>";
				echo '<td class="textfiche">&nbsp;';
				if($joueur->msn) echo "<a href=\"mailto: $joueur->msn\"><img src=\"images/p_msn.gif\" align=\"absmiddle\" border=\"0\"  alt=\"$joueur->msn\"></a>";
				else echo 'N/A';
				echo '</tr></table>';
				echo '</td></tr>';
			}
			
			
			/*** custom champs ***/
			$tab_vars=get_object_vars($joueur);
			
			reset($tab_vars);
			while (!is_null($key = key($tab_vars) ) ) {
												
				if(strstr($key,'ext_')) {
					
					echo '<tr><td class="titlefiche">'.${"str".ucfirst(substr($key, 4))}.' :</td>';
					echo '<td class="textfiche" colspan="3">';
			
					if ($op == 'admin' || $id == $s_joueur)
						echo "<input type=\"text\" name=\"$key\" value=\"".stripslashes($tab_vars[$key])."\" size=\"30\" maxlength=\"50\">";
					else
						echo $tab_vars[$key];
			
					echo '</td></tr>';
				}
				next($tab_vars);
			}
	
			/*** langue ***/
			if ($op == 'admin' || $id == $s_joueur) {
				echo "<tr><td class=\"titlefiche\">$strLangue :</td>";
				echo '<td class=textfiche colspan=3>';
	
				echo '<select name="langue">';
				$fd = opendir('lang/');
				while($file = readdir($fd)) {
					if ($file != '.' && $file != '..') {
						$file = ereg_replace('.inc.php','',$file);
						echo "<option value=\"$file\"";
						if ($file == $joueur->langue) echo ' SELECTED';
						echo ">$file";
					}
				}
				closedir($fd);
				echo '</select>';
				echo '</td></tr>';
			}
	
			/*** etat ***/
			/*** Carton ***/
	
			echo "<tr><td class=titlefiche>$strSanctions :</td>";
			echo "<td class=textfiche colspan=3>";
			
			if ($op == 'admin' ) {
			
			echo "<table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td class=textfiche>";
		
			echo "<select name=carton>";
			
			$fd = opendir("images/cartons/");
			while($file = readdir($fd)) {
				if ($file != "." && $file != "..") {
					$file = ereg_replace(".gif","",$file);
					echo "<option value=$file";
					if ($file == $joueur->carton) echo " SELECTED";
					echo ">$file";
				}
			}
			closedir($fd);
			
			echo "</select> ";
			echo $strCarton;
			echo "</td></tr><tr><td class=textfiche>";
			echo "<input type=text size=20 name=sanction value=\"".stripslashes($joueur->sanction)."\">";
			echo $strMotif."</td></tr></table>";
			}
			
		else { 
			if ($joueur->carton == 'aucun')
				{
		echo $strAucune;
				}
			else 
				{
		echo "<A href=\"?page=reglements\" onMouseOver=\"AffBulle('<b>$strCarton $joueur->carton </b>: $joueur->sanction')\" onMouseOut=\"HideBulle()\"><img src=\"images/cartons/$joueur->carton.gif\" border=0 align=absmiddle></A>";
				} 
			 }
		echo "</td></tr>";
			echo "<tr><td class=\"titlefiche\">$strEtat :</td>";
			echo '<td class="textfiche" colspan="3">';
			$date=strftime(DATESTRING1, $joueur->dateinscription);
			$date = "&nbsp;$strLe ".$date;
	
			if ($op == 'admin' ) {
				echo '<select name="etat">';
				echo '<option value="C"';if ($joueur->etat == 'C') echo ' SELECTED';echo ">$strCache";
				echo '<option value="M"';if ($joueur->etat == 'M') echo ' SELECTED';echo ">$strAttenteMail";
				echo '<option value="P"';if ($joueur->etat == 'P') echo ' SELECTED';echo ">$strPreinscrit";
				echo '<option value="I"';if ($joueur->etat == 'I') echo ' SELECTED';echo ">$strInscrit";
				echo "</select>$date";
			}
			else {
				if ($joueur->etat == 'C') echo "<font color=\"orange\"><b>$strCache</b></font>";
				elseif ($joueur->etat == 'M') echo "<font color=\"orange\"><b>$strAttenteMail</b></font>";
				elseif ($joueur->etat == 'P') echo "<font color=\"red\"><b>$strPreinscrit</b></font>$date";
				elseif ($joueur->etat == 'I') echo "<font color=\"green\"><b>$strInscrit</b></font>$date";
			}
			echo '</td></tr>';
	
	
			/*** last visit **/
   			echo "<tr><td class=\"titlefiche\">$strlastvisit </td>";
  			echo '<td class="textfiche" colspan="3">';
			$date=strftime(DATESTRING1, $joueur->datelogin);
 			echo "$date";
  			echo '</td></tr>';
			
			
			
			if ($op == 'admin' || $id == $s_joueur) {
				echo "<tr><td class=\"footerfiche\" align=\"center\" colspan=\"4\"><input type=\"submit\" class=\"action\" value=\"$strModifier\"></td></tr>";
			}
			echo '</table>';	
			
			echo '</td></tr></table>';
			echo '</td></tr></table>';
			
			/*** Remarque ***/
			if ($op == 'admin') {
			echo '<table border=0 cellpadding=0 width="350" cellspacing=0 class=bordure1><tr><td>
			<table cellspacing=1 cellpadding=0 border=0>
			<tr><td class=modsfiche>&nbsp;&nbsp;&nbsp; '.$strRemarque.' &nbsp;&nbsp;&nbsp;</td></tr>
			<tr><td>
			<table cellspacing=0 cellpadding=2 border=0 width=100%>
			<tr><td class=partfiche align="center"><div align="center">';
			echo "<br><textarea cols=60 rows=10 id=remarque name=remarque wrap=virtual>$joueur->remarque</textarea></td></tr>";	
			echo "<tr><td class=footerfichemods colspan=2><hr><input type=submit value=\" - $strOK - \"></td></tr>";
			echo '</td></tr></table>
			<tr><td class=modsfiche>&nbsp;</td></tr>
			</td></tr></table>
			</td></tr></table>';
			}
			
			echo "</form>";
	
			/*** tournois inscrits ***/
			$db->select("${dbprefix}tournois.id,${dbprefix}tournois.nom,status,sigle,icone");
			$db->from("${dbprefix}tournois LEFT JOIN ${dbprefix}jeux on (${dbprefix}tournois.jeux = ${dbprefix}jeux.id)");
			$db->where("modeequipe = 'J'");
			$db->order_by("${dbprefix}tournois.nom");
			$res = $db->exec();
	
			if ($db->num_rows($res) != 0) {
				$inscrit = '';
				$ainscrit = '';

				while($tournois = $db->fetch($res)) {
	
					if(participe($id,$tournois->id)) {
						if($tournois->status!='T') 
							$inscrit.="<img src=\"images/jeux/$tournois->icone\" border=\"0\" align=\"absmiddle\"> $tournois->nom, ";
						else 
							$ainscrit.="<img src=\"images/jeux/$tournois->icone\" border=\"0\" align=\"absmiddle\"> $tournois->nom, ";
					}
				}
				$inscrit=trim($inscrit," ,");
				$ainscrit=trim($ainscrit," ,");
	
				echo '<table cellspacing="0" cellpadding="0" border="0">';
				if($inscrit) echo "<tr><td class=\"title\" align=\"right\"><font color=\"green\">$strTournoisParticipe</font> :&nbsp;&nbsp;</td><td class=\"title\">$inscrit</td></tr>";
				if($ainscrit) echo "<tr><td class=\"title\" align=\"right\"><font color=\"red\">$strTournoisAParticipe</font> :&nbsp;&nbsp;</td><td class=\"title\">$ainscrit</td></tr>";
				echo '</table><br>';
			}
		}
		elseif($section=='resultats') {

			/*** resultats de lu joueur ***/
			$db->select("id, ${dbprefix}participe.status");
			$db->from("${dbprefix}tournois,${dbprefix}participe");
			$db->where("id = tournois");
			$db->where("equipe = $id");
			$db->where("modeequipe = 'J'");
			$db->order_by("nom");
			$res1 = $db->exec();
	
			if ($db->num_rows($res1) != 0) {
	
				echo "<table cellspacing=0 cellpadding=0 border=0>";
	
				while($tournois = $db->fetch($res1)) {
	
					$db->select("id");
					$db->from("${dbprefix}matchs");
					$db->where("(equipe1 = $id or equipe2 = $id)");
					$db->where("status = 'T'");
					$db->where("tournois = $tournois->id");
					$db->order_by("type, tour asc, finale desc, numero asc");
					$res2 = $db->exec();
					
					if ($db->num_rows($res2) != 0) {
	
						echo "<tr><td class=title colspan=5>".show_tournois($tournois->id);
						if ($tournois->status == "F") echo " - <span class=warning>$strForfait</span>";
						if ($tournois->status == "D") echo " - <span class=warning>$strDisqualifie</span>";
						echo "</td></tr>";
		
						while($matchs = $db->fetch($res2)) {
		
							$match=match($matchs->id);
							echo "<tr>";
		
							/*** info1 ***/
							echo "<td class=info><img src=images/spacer.gif></td>";
		
							/*** match ***/
							echo "<td class=info align=center>";
							show_match_poule($match->id);
							echo "</td>";
		
							/*** info2 ***/
							echo "<td class=info>&nbsp;&nbsp;";
							if ($match->type == 'W' || $match->type == 'L') {
								if ($match->finale > 1)
									echo "1/$match->finale $strFinale $match->type $strMatch #$match->numero";
								elseif ($match->finale == 1)
									echo "$strFinale $match->type $strMatch #$match->numero";
								else
									echo "$strGrandFinal $strMatch #$match->numero";
							}
							elseif ($match->type == 'P')
								echo "$strPoule $match->poule - $strTour $match->tour";
							echo "</td>";
		
							echo "</tr>";
		
						}
						echo "<tr><td colspan=5><br></td></tr>";
					}
				}
				echo "</table><br>";
			}
		}
	}
	
	echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";
}
/*** Recherche d'un joueur ***/
 if ($op != "inscription" && $op != "do_inscription" && $op != "inscription" && $op != "modify_fiche" && $op != "change_passwd" && $op != "do_envoi_passw" && $op != "reset_passwd") {
  if ($rech_v != "u") {
   if($op == 'admin') {if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['j']!='j') {js_goto($PHP_SELF);} }
     echo '<form method="post" action="?page=joueurs&op=rech">';
   }else{ echo '<form method="post" action="?page=joueurs&op=rechj">';}         
  echo '<table border=0 cellpadding="0" cellspacing="0" class="bordure2"><tr><td>';
  echo '<table cellspacing="1" cellpadding="0" border="0">';
  echo "<tr><td class=\"headerfiche\">$strRechercherJoueur</td></tr>";
  echo '<tr><td>';
  echo '<table cellspacing="0" cellpadding="3" border="0" width="100%">';
  echo '<tr>';
  echo "<td class=\"titlefiche\">$strPseudo <font color=\"red\"><b>*</b></font> :</td>";
  echo '<td class="textfiche"><input type="text" name="pseudo" maxlength="20"></td>';
  echo '</tr>';
  echo "<tr><td class=\"footerfiche\" align=\"center\" colspan=\"2\"><input type=\"submit\" class=\"action\" value=\"$strRechecrher\"></td></tr>";
  echo '</table>';
  echo '</td></tr></table>';
  echo '</td></tr></table>';
  echo '</form>';
  }


 
?>

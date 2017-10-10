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
if (preg_match("/contact.php/i", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}

if(!$config['contact']) js_goto('?page=index');

/********************************************************
 * Envoi d'un message
 */
if ($op == "envoi") {

	$str='';
	$erreur=0;

	if(!$pseudo) {
		$erreur=1;
		$str="- $strElementsPseudoInvalide<br>";
	}
	if(!$titre) {
		$erreur=1;
		$str.="- $strElementsTitreInvalide<br>";
	}
	if(!$contenu) {
		$erreur=1;
		$str.="- $strElementsContenuInvalide<br>";
	}
	if(!$email || !eregi("^[a-z0-9\._-]+@+[a-z0-9\._-]+\.+[a-z]{2,3}$", $email)) {
 		$erreur=1;
		$str.="- $strElementsEmailInvalide<br>";
	}
	
	if($erreur==1) {		
		show_erreur_saisie($str);		
	}
	else {
		if(is_flood('contact')) {
			show_erreur($strFloodDetect);
		}
		elseif($config['mail']!='N') {
		//if($config['mail']!='N') {
			$no_send_mail = 'non';
			$titre = remove_XSS($titre);
			$contenu = remove_XSS($contenu);
		
			$array1=array("%nomsite%","%urlsite%");
			$array2=array($config['nomsite'],$config['urlsite']);
			$body=$strContactMessageEmail." $pseudo $strAEcrit :<br>".stripslashes($contenu);
			$body = str_replace($array1, $array2, $body);	
							
			$mail = new phpTMailer();
			$mail->From = $email;
			$mail->FromName = $pseudo;
			$mail->AddAddress($config['emailcontact']);
			$mail->Subject = stripslashes($titre);
			$mail->Body    = $body;
	
			if(!$mail->Send())
			{				
				show_erreur("$strErreurMessageEnvoi<br><br>$mail->ErrorInfo");
				$no_send_mail = 'oui';				
			}
			else {
				show_notice($strMessageEnvoi);	
				echo "<br><form method=post action='?page=index'><input type=submit class=action value=\"$strOK\"></form>";					
			}
		}
		else {
			show_erreur($strPasDeFonctionMail);	
			$no_send_mail = 'oui';
		}
		if ($no_send_mail == 'oui') {
			
			$mail_id1 = $config['emailcontact'];
			$mail_id2 = $config['emailinscription'];
			$date=time();
			
			$message = $pseudo.$strContactout.stripslashes($contenu);
			
			if ($mail_id1 == $mail_id2 and $mail_id1 != null and $mail_id1!= '') {
			
				$db->select("DISTINCT id");
				$db->from("${dbprefix}joueurs");
				$db->where("email = '$mail_id1'");
				$res = $db->exec();
				
				while ($destinatire = $db->fetch($res)) {
					$db->insert("${dbprefix}messages (emetteur,destinataire,titre,message,date)");
					$db->values("'-2','$destinatire->id','Contact : $titre','$message','$date'");
					$db->exec();
					
				}
				
				show_erreur($strPMED);
			} else if($mail_id1 != null and $mail_id2 != null) {
			
			
				$db->select("DISTINCT id");
				$db->from("${dbprefix}joueurs");
				$db->where("email = '$mail_id1' or email = '$mail_id2' ");
				$res = $db->exec();
				
				while ($destinatire = $db->fetch($res)) {
					$db->insert("${dbprefix}messages (emetteur,destinataire,titre,message,date)");
					$db->values("'-2','$destinatire->id','Contact : $titre','$message','$date'");
					$db->exec();
					
				}
				show_erreur($strPMED);
			} else {
				show_erreur($strPMED_no);
			}			
		
			
			
		}
	}
}


/********************************************************
 * Affichage normal
 */
else {

	echo "<p class=title>.:: $strContact ::.</p>";
	$array1=array("%email%");
	$array2=array($config['emailcontact']);
	$strContactUp = str_replace($array1, $array2, $strContactUp);
	
	echo "<table cellspacing=0 cellpadding=0 border=0 width=500 align=center>";
	echo "<tr><td class=title><div align=center>$strContactUp</div></td></tr>";
	echo "</table><br>";

	echo "<form method=post name=\"formulaire\" action=?page=contact&op=envoi>";
	echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
	echo "<table cellspacing=1 cellpadding=0 border=0>";
	echo "<tr><td class=headerfiche>$strContact</td></tr>";
	echo "<tr><td>";
	echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
	if(!empty($s_joueur)) {
		$auteur=joueur($s_joueur);
		echo "<input type=hidden name=pseudo value='$auteur->pseudo'>";
		echo "<input type=hidden name=email value='$auteur->email'>";
	}
	else {
		echo "<tr>";
		echo "<td class=titlefiche>$strPseudo :</td>";
		echo "<td class=textfiche><input type=text name=pseudo maxlength=20></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class=titlefiche>$strEMail :</td>";
		echo "<td class=textfiche><input type=text name=email maxlength=40></td>";
		echo "</tr>";
	}
	echo "<tr>";
	echo "<td class=titlefiche>$strTitre :</td>";
	echo "<td class=textfiche><input type=text name=titre maxlength=50 size=50 value=''></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class=titlefiche>$strMessage :</td>";
	echo "<td class=textfiche><textarea cols=50 rows=6 name=contenu wrap=virtual></textarea></td>";
	echo "</tr>";
	echo "<tr><td class=footerfiche colspan=2 align=center><input type=submit value=\"$strEnvoyer\"></td></tr>";
	echo "</table>";
	echo "</td></tr></table>";
	echo "</td></tr></table>";
	echo "</form>";

	echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";

}
?>

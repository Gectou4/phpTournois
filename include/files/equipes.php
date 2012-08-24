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
   | Authors: Li0n  <li0n@phptournois.net>                               |
   |          RV <rv@phptournois.net>                                    |
   |          Gougou                                                     |
   +---------------------------------------------------------------------+
*/
if (eregi("equipes.php", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}
/******************************************************** 
 * Ajout d'une equipe
 */
if($op == "add") {
	
	/*** verification securite ***/
	//verif_admin_general($s_joueur);
	if ($grade['a']!='a' && $grade['b']!='b' && $grade['e']!='e') {js_goto($PHP_SELF);} 
	
		
	$str='';
	$erreur=0;

	if(!$nom) {
		$erreur=1;
		$str.="- $strElementsNomInvalide<br>";
	}
	if(!$tag) {
		$erreur=1;
		$str.="- $strElementsTagInvalide<br>";
	}
	if(id_equipe($tag)!=0) {
		$erreur=1;
		$str.="- $strElementsEquipeExistante<br>";
	}

	if($erreur==1) {		
		show_erreur_saisie($str);		
	}
	else {	
		
		$date=time();
		$nom=remove_XSS($nom);
		$tag=remove_XSS($tag);
		
		$db->select("max(id) as id");
		$db->from("${dbprefix}equipes");
		$db->exec();
		$maxid = $db->fetch();
		$nextid = $maxid->id + 1;

		if($config['inscription_equipe_pre']) $etat='A';
		else $etat='V';
		$nom=str_replace('"',"&quot;",addslashes($nom));
		$tag=str_replace('"',"&quot;",addslashes($tag));

		if ($mods['auto_valid_team']) {$etat = "V";}
		$db->insert("${dbprefix}equipes (id, nom, tag, origine, manager, etat, dateinscription)");
		$db->values("$nextid, '$nom', '$tag', 'FR', 0, '$etat', '$date'");
		$db->exec();
	
		/*** redirection ***/
		js_goto("?page=equipes&op=admin&id=$nextid");
	}
}

/******************************************************** 
 * Suppression d'une equipe
 */
elseif ($op == "delete") {

	/*** verification securite ***/
	//verif_admin_general($s_joueur);
	if ($grade['a']!='a' && $grade['b']!='b' && $grade['e']!='e') {js_goto($PHP_SELF);} 
	
	if(is_numeric($id)) {
		$db->delete("${dbprefix}equipes");
		$db->where("id = $id");
		$db->exec();
	}

	/*** redirection ***/
	js_goto("?page=equipes&op=admin");
}

/********************************************************
 * Ajout d'une equipe externe
 */
elseif($op == "do_inscription") {

	/*** verification securite ***/
	if(!$config['inscription_equipe'] || !$s_joueur) js_goto("?page=index");

	$str='';
	$erreur=0;

	if(!$nom) {
		$erreur=1;
		$str.="- $strElementsNomInvalide<br>";
	}
	if(!$passwd) {
		$erreur=1;
		$str.="- $strElementsPasswordInvalide<br>";
	}
	if(!$tag) {
		$erreur=1;
		$str.="- $strElementsTagInvalide<br>";
	}
	if(id_equipe($tag)>0) {
		$erreur=1;
		$str.="- $strElementsEquipeExistante<br>";
	}
	if(!$email || !eregi("^[a-z0-9\._-]+@+[a-z0-9\._-]+\.+[a-z]{2,3}$", $email)) {
 		$erreur=1;
		$str.="- $strElementsEmailInvalide<br>";
	}
	if(!$origine) {
		$erreur=1;
		$str.="- $strElementsOrigineInvalide<br>";
	}

	if($erreur==1) {
		show_erreur_saisie($str);
	}
	else {

		$date=time();
		$nom=remove_XSS($nom);
		$tag=remove_XSS($tag);
		$email=remove_XSS($email);

		if($config['inscription_equipe_pre']) $etat='A';
		else $etat='V';
		
		$nom=str_replace('"',"&quot;",addslashes($nom));
		$tag=str_replace('"',"&quot;",addslashes($tag));
		$email=str_replace('"',"&quot;",addslashes($email));


$db->insert("${dbprefix}equipes (nom, tag, email, origine, manager, passwd, etat, dateinscription)");
		$db->values("'$nom', '$tag', '$email', '$origine', '$s_joueur', md5('$passwd'), '$etat', '$date'");
		$db->exec();
		$id = $db->insert_id();

		/*** redirection ***/
		js_goto("?page=equipes&id=$id");
	}
}

/********************************************************
 * Rejoindre une equipe
 */
elseif($op == "do_rejoindre") {

	/*** verification securite ***/
	if(!$s_joueur) js_goto("?page=index");

	$str='';
	$erreur=0;

	if(!is_numeric($id)) {
		$erreur=1;
		$str.="- $strElementsEquipeInvalide<br>";
	}
	if(!$passwd) {
		$erreur=1;
		$str.="- $strElementsPasswordInvalide<br>";
	}
	if(!is_numeric($jeux)) {
		$erreur=1;
		$str.="- $strElementsJeuxInvalide<br>";
	}

	if($erreur==1) {
		show_erreur_saisie($str);
	}
	else {

		$db->select("passwd");
		$db->from("${dbprefix}equipes");
		$db->where("id = '$id'");
		$db->where("passwd = md5('$passwd')");
		$res=$db->exec();
		$equipe=$db->fetch($res);

		if($db->num_rows($res)!=1) {
			show_erreur($strElementsPasswordInvalide);
		}
		elseif(equipe_appartient($id,$s_joueur,$jeux)) {
			show_erreur($strErreurJoueurAppartient);
		}
		else {

			$db->insert("${dbprefix}appartient (joueur, equipe, jeux, status)");
			$db->values("$s_joueur, $id, $jeux, '3'");
			$db->exec();
		
		if(!equipe_appartient($id,$s_joueur,1)){
			$db->insert("${dbprefix}appartient (joueur, equipe, jeux, status)");
			$db->values("$s_joueur, $id, '1', '3'");
			$db->exec();
			}

			/*** redirection ***/
			js_goto("?page=equipes&section=membres&id=$id");
		}
	}
}

/********************************************************
 * Ajout d'un joueur
 */
elseif($op == "add_joueur") {

	/*** verification securite ***/
	verif_manager($id,$s_joueur);

	$str='';
	$erreur=0;

	if(!is_numeric($id)) {
		$erreur=1;
		$str.="- $strElementsEquipeInvalide<br>";
	}
	if(!is_numeric($joueur)) {
		$erreur=1;
		$str.="- $strElementsJoueurInvalide<br>";
	}
	if(!is_numeric($jeux)) {
		$erreur=1;
		$str.="- $strElementsJeuxInvalide<br>";
	}

	if($erreur==1) {
		show_erreur($str);
	}
	else {
		$du_j=$joueur;
		if(equipe_appartient($id,$joueur,$jeux)) {
			show_erreur($strErreurJoueurAppartient);
		}
		else {
			$joueur=str_replace('"',"&quot;",addslashes($joueur));

			$db->insert("${dbprefix}appartient (joueur, equipe, jeux, status)");
			$db->values("$joueur, $id, $jeux, $status");
			$db->exec();
		
		if(!equipe_appartient($id,$s_joueur,1)){
			$db->insert("${dbprefix}appartient (joueur, equipe, jeux, status)");
			$db->values("$s_joueur, $id, '1', $status");
			$db->exec();
			}
			
		$db->select("grade");
		$db->from("${dbprefix}joueurs");
		$db->where("id = $du_j");
		$db->exec();
		$joueur_res = $db->fetch();
		
		$ok_up = '';
		
		if (!eregi("y",$joueur_res->grade) && ($status== "1"||$status== "2")) {
		$new_grade=$joueur_res->grade."y";
		$ok_up = 'oui';
		}
		
		/*if (!eregi("y",$joueur_res->grade) && $status== "2") {
		$new_grade=$joueur_res->grade."y";
		$ok_up = 'oui';
		}*/
		
		if ($ok_up=="oui") {
		$db->update("${dbprefix}joueurs");
		$db->set("grade='$new_grade'");
		$db->where("id = $du_j");
		$db->exec();
		}
	echo $ok_up;
	echo $new_grade;
	echo $joueur;
	echo $du_j;
			/*** redirection ***/
			js_goto("?page=equipes&op=$oldop&section=membres&id=$id");
		}
	}
}

/******************************************************** 
 * Suppression d'un joueur
 */
elseif ($op == "delete_joueur") {

	/*** verification securite ***/
	verif_manager($id,$s_joueur);

	$str='';
	$erreur=0;

	if(!is_numeric($id)) {
		$erreur=1;
		$str.="- $strElementsEquipeInvalide<br>";
	}
	if(!is_numeric($joueur)) {
		$erreur=1;
		$str.="- $strElementsJoueurInvalide<br>";
	}
	if(!is_numeric($jeux)) {
		$erreur=1;
		$str.="- $strElementsJeuxInvalide<br>";
	}

	if($erreur==1) {
		show_erreur($str);
	}
	else {
	
		if ($del=="one") {

		$db->delete("${dbprefix}appartient");
		$db->where("equipe = $id");
		$db->where("joueur = $joueur");
		$db->where("jeux = $jeux");
		$db->exec();
		} else 
		if ($del=="all"){
		$db->delete("${dbprefix}appartient");
		$db->where("equipe = $id");
		$db->where("joueur = $joueur");
		$db->exec();
		}

		
		//
		$db->select("joueur,status");
		$db->from("${dbprefix}appartient");
		$db->where("equipe = $id");
		$res=$db->exec();
		
	
		$coun_y_grade = 1;
			
		// on test combien de fois le joueur est ou leader ou wararanger		
		while ($equipe_j = $db->fetch($res)) {
			
			if ($equipe_j->status == 1 || $equipe_j->status == 2) {
			// incr&eacute;mentation de la variable pour sauter la nullit&eacute;.
			$coun_y_grade=$coun_y_grade+1;
			}
			
		}
		//
		
		if ($coun_y_grade <= 1) {
			$db->select("grade");
			$db->from("${dbprefix}joueurs");
			$db->where("id = $joueur");
			$db->exec();
			$joueur_ress = $db->fetch();
			
			if (eregi("y",$joueur_ress->grade)) {
			
			$new_grade = str_replace("y","",$joueur_ress->grade);
			
			$db->update("${dbprefix}joueurs");
			$db->set("grade='$new_grade'");
			$db->where("id = $joueur");
			$db->exec();
			}
		}

		// g&eacute;n&eacute;ration d'un message pour le joueur
		$db->select("nom");
		$db->from("${dbprefix}equipes");
		$db->where("id = $id");
		$db->exec();
		$the_team= $db->fetch();
		
		if($config['mail']!='N') {
		
				
				$mail = new phpTMailer();
				$from = joueur($joueur);
				$mail->From = $from->email;
				$mail->FromName = $from->pseudo;
				$mail->Subject = $strLeaveTeamtitleManager;
				// formatage contenu + pseudo
				$body = addslashes(BBcode($strLeaveTeambodyM1.$the_team->nom.$strLeaveTeambodyM2));
				$mail->Body = str_replace("SRC=\"images/smilies/", "SRC=\"".$config['urlsite']."/images/smilies/", $body);
		
				/*** generation de la messagerie ***/
				$to=joueur($the_manager->manager);
				$mail->AddAddress($to->email);				
				}
				
				
   				$date=time();
				$contenance=addslashes(BBcode($strLeaveTeambodyM1.$the_team->nom.$strLeaveTeambodyM2));
				$db->insert("${dbprefix}messages (emetteur,destinataire,titre,message,date)");
				$db->values("'$s_joueur','$joueur','$titre','$contenance','$date'");
				$db->exec();
		
		/*** redirection ***/
		js_goto("?page=equipes&op=$oldop&section=membres&id=$id");

	}
}

/********************************************************
 * Modifier le status d'une equipe
 */
elseif ($op == "status") {

	/*** verification securite ***/
	//verif_admin_general($s_joueur);
   if ($grade['a']!='a' && $grade['b']!='b' && $grade['e']!='e') {js_goto($PHP_SELF);} 

	$date=time();	

	if(is_numeric($id)) {			
		$db->update("${dbprefix}equipes");
		$db->set("etat = '$value'");
		if($value=='A' || $value=='V') $db->set("dateinscription = '$date'");
		$db->where("id = $id");
		$db->exec();

		/*** redirection ***/
		js_goto("?page=equipes&op=admin&id=$id");
	}
	elseif(count($tab_status)!=0) {
	
		foreach ($tab_status as $idequipe) {		
			$db->update("${dbprefix}equipes");
			$db->set("etat = '$status'");
			if($status=='A' || $status=='V') $db->set("dateinscription = '$date'");
			$db->where("id = $idequipe");	
			$db->exec();
		}

		/*** redirection ***/
		js_goto("?page=equipes&op=admin");
	}
	else 
		js_goto("?page=equipes&op=admin");

}

/******************************************************** 
 * Modification de l'equipe par le manager
 */
elseif ($op == "modify_manager") {
	
	/*** verification securite ***/
	verif_manager($id,$s_joueur);
	
	$str='';
	$erreur=0;
	
	if(!is_numeric($id)) {
		$erreur=1;
		$str.="- $strElementsEquipeInvalide<br>";
	}
	if(!$nom) {
 		$erreur=1;
		$str.="- $strElementsNomInvalide<br>";
	}
	if(!$email || !eregi("^[a-z0-9\._-]+@+[a-z0-9\._-]+\.+[a-z]{2,3}$", $email)) {
 		$erreur=1;
		$str.="- $strElementsEmailInvalide<br>";
	}
	if(!$manager || !is_numeric($manager)) {
 		$erreur=1;
		$str.="- $strElementsManagerInvalide<br>";
		
	}

	if($erreur==1) {
		show_erreur_saisie($str);
	}
	else {

		$nom=remove_XSS($nom);
		$email=remove_XSS($email);
		$url=remove_XSS($url);
		$irc=remove_XSS($irc);
		$manager=remove_XSS($manager);
		$serverip=remove_XSS($serverip);

		if($url=='http://') $url='';
		$nom=str_replace('"',"&quot;",addslashes($nom));
		$email=str_replace('"',"&quot;",addslashes($email));
		$manager=str_replace('"',"&quot;",addslashes($manager));
		$serverip=str_replace('"',"&quot;",addslashes($serverip));
	

		$db->update("${dbprefix}equipes");
		$db->set("nom='$nom', url='$url', irc='$irc', email='$email',manager='$manager',serverip='$serverip'");
		if($passwd) $db->set("passwd = md5('$passwd')");

		foreach ($_POST as $key => $value) {
			if(preg_match("/^ext_([0-9a-zA-Z]+)$/", $key,$keylist)) {
				$value=remove_XSS($value);
				$db->set("$keylist[0]='$value'");
			}	
		}
		$db->where("id = $id");
		$db->exec();
		
		// selection du grade du manager
		$db->select("grade");
		$db->from("${dbprefix}joueurs");
		$db->where("id = $manager");
		$db->exec();
		$joueur_x = $db->fetch();
		
		// si il n'est pas au rang de manager on le lui met
		if (!eregi("x",$joueur_x->grade)) {
		$new_grade1=$joueur_x->grade."x";
		$db->update("${dbprefix}joueurs");
		$db->set("grade='$new_grade1'");
		$db->where("id = $manager");
		$db->exec();
		echo $new_grade1;
		}
		
		// Si on change de manager
		if ($manager != $oldmanager) {
		
		// On cherche si l'ancien manager ne l'&eacute;tait qu'une fois ou plusieur fois !
		$db->select("manager");
		$db->from("${dbprefix}equipes");
		$db->where("manager = $oldmanager");
		$res=$db->exec();
		$row_data_x = mysql_fetch_row($res);
		$coun_x_grade = $row_data_x[0];
		// on incr&eacute;mente de 1 pour supprimer la valeur 0 du tableau et &eacute;vit&eacute; l'annulation de la variable :)
		$coun_x_grade++;

		// si il &eacute;tait pr&eacute;sent une ou moin sde fois dans les r&eacute;sultat c'est qu'il n'est plus manager (du tout)
		if ($coun_x_grade <= 1) {
			
			$db->select("grade");
			$db->from("${dbprefix}joueurs");
			$db->where("id = $oldmanager");
			$db->exec();
			$joueur_res = $db->fetch();
			
			if (eregi("x",$joueur_res->grade)) {
			
			$new_grade = str_replace("x","",$joueur_res->grade);
			
			$db->update("${dbprefix}joueurs");
			$db->set("grade='$new_grade'");
			$db->where("id = $oldmanager");
			$db->exec();
			}
			
		} 
		}
		
		////////////////////////////////////////
		js_goto("?page=equipes&id=$id");
	}	
}

/********************************************************
 * Modification de l'equipe
 */
elseif ($op == "modify_admin") {

	/*** verification securite ***/
	//verif_admin_general($s_joueur);
	if ($grade['a']!='a' && $grade['b']!='b' && $grade['e']!='e') {js_goto($PHP_SELF);} 
	
	$str='';
	$erreur=0;

	if(!is_numeric($id)) {
		$erreur=1;
		$str.="- $strElementsEquipeInvalide<br>";
	}
	if(!$nom) {
		$erreur=1;
		$str.="- $strElementsNomInvalide<br>";
	}
	if(!$tag) {
		$erreur=1;
		$str.="- $strElementsTagInvalide<br>";
	}
	if(!$origine) {
		$erreur=1;
		$str.="- $strElementsOrigineInvalide<br>";
	}
	if(!$manager) {
 		$erreur=1;
		$str.="- $strElementsManagerInvalide<br>";
	}
	if(!$email || !eregi("^[a-z0-9\._-]+@+[a-z0-9\._-]+\.+[a-z]{2,3}$", $email)) {
 		$erreur=1;
		$str.="- $strElementsEmailInvalide<br>";
	}
			
	if($erreur==1) {
		show_erreur_saisie($str);
	}
	else {
		$date=time();
		$nom=remove_XSS($nom);
		$tag=remove_XSS($tag);
		$email=remove_XSS($email);
		$url=remove_XSS($url);
		$irc=remove_XSS($irc);
		$manager=remove_XSS($manager);

		if($url=='http://') $url='';
		$nom=str_replace('"',"&quot;",addslashes($nom));
		$email=str_replace('"',"&quot;",addslashes($email));
		$tag=str_replace('"',"&quot;",addslashes($tag));
		$origine=str_replace('"',"&quot;",addslashes($origine));
		$manager=str_replace('"',"&quot;",addslashes($manager));
	

		$db->update("${dbprefix}equipes");
		$db->set("tag='$tag', nom='$nom', url='$url', irc='$irc', manager='$manager', email='$email', etat='$etat', origine='$origine', carton='$carton', sanction='$sanction',remarque='$remarque',servername='$servername',serverip='$serverip'");
		if($passwd) $db->set("passwd = md5('$passwd')");
		if($etat=='A' || $etat =='V')  $db->set("dateinscription = '$date'");

		
			
		foreach ($_POST as $key => $value) {
			if(preg_match("/^ext_([0-9a-zA-Z]+)$/", $key,$keylist)) {
				$value=remove_XSS($value);
				$db->set("$keylist[0]='$value'");
			}
		}
		$db->where("id = $id");
		$db->exec();
		
		// selection du grade du manager
		$db->select("grade");
		$db->from("${dbprefix}joueurs");
		$db->where("id = $manager");
		$db->exec();
		$joueur_x = $db->fetch();
		
		// si il n'est pas au rang de manager on le lui met
		if (!eregi("x",$joueur_x->grade)) {
		$new_grade1=$joueur_x->grade."x";
		$db->update("${dbprefix}joueurs");
		$db->set("grade='$new_grade1'");
		$db->where("id = $manager");
		$db->exec();
		echo $new_grade1;
		}
		
		// Si on change de manager
		if ($manager != $oldmanager) {
		
		// On cherche si l'ancien manager ne l'&eacute;tait qu'une fois ou plusieur fois !
		$db->select("manager");
		$db->from("${dbprefix}equipes");
		$db->where("manager = $oldmanager");
		$res=$db->exec();
		$row_data_x = mysql_fetch_row($res);
		$coun_x_grade = $row_data_x[0];
		// on incr&eacute;mente de 1 pour supprimer la valeur 0 du tableau et &eacute;vit&eacute; l'annulation de la variable :)
		$coun_x_grade++;

		// si il &eacute;tait pr&eacute;sent une ou moin sde fois dans les r&eacute;sultat c'est qu'il n'est plus manager (du tout)
		if ($coun_x_grade <= 1) {
			
			$db->select("grade");
			$db->from("${dbprefix}joueurs");
			$db->where("id = $oldmanager");
			$db->exec();
			$joueur_res = $db->fetch();
			
			if (eregi("x",$joueur_res->grade)) {
			
			$new_grade = str_replace("x","",$joueur_res->grade);
			
			$db->update("${dbprefix}joueurs");
			$db->set("grade='$new_grade'");
			$db->where("id = $oldmanager");
			$db->exec();
			}
			
		} 
		}

		js_goto("?page=equipes&op=admin&id=$id");
	}	
}

/********************************************************
 * Auto validation de l'&eacute;quipe
 */
elseif ($op == "autoval") {

	/*** verification securite ***/
	if ($grade['x']!='x') {js_goto($PHP_SELF);} 
	
			
			$db->select("COUNT(distinct joueur) FROM ${dbprefix}appartient WHERE equipe = $id ");
			$db->order_by("joueur");
			$res=$db->exec();
			$row_data = mysql_fetch_row($res);
			$data_total = $row_data[0];
			
			if ($data_total >= $mods['m_team_valid_num']) {
			$db->update("${dbprefix}equipes");
			$db->set("etat='V'");
			$db->where("id = $id");
			$db->exec();
			
			echo "
			<br><br>$strOk_validation<br><br>
			<input type=\"button\" class=\"action\" value=\"$strOK\" onclick=\"location='?page=equipes&op=$oldop&id=$id'\"><br><br>";
		
			} else {
			echo "<br><br>$strNOOk_validation<br><br>
			$strREQ_player <span style='color:red'><b>".$mods['m_team_valid_num']."<b></span><br><br>
			<input type=\"button\" class=\"action\" value=\"$strOK\" onclick=\"location='?page=equipes&op=$oldop&id=$id'\"><br><br>";
			
			}
			
	/*
		$db->update("${dbprefix}equipes");
		$db->set("tag='$tag', nom='$nom', url='$url', irc='$irc', manager='$manager', email='$email', etat='$etat', origine='$origine', carton='$carton', sanction='$sanction',remarque='$remarque',servername='$servername',serverip='$serverip'");
		if($passwd) $db->set("passwd = md5('$passwd')");
		if($etat=='A' || $etat =='V')  $db->set("dateinscription = '$date'");

		foreach ($_POST as $key => $value) {
			if(preg_match("/^ext_([0-9a-zA-Z]+)$/", $key,$keylist)) {
				$value=remove_XSS($value);
				$db->set("$keylist[0]='$value'");
			}
		}
		$db->where("id = $id");
		$db->exec();
		
		js_goto("?page=equipes&op=admin&id=$id");*/
		
}
/********************************************************
 * Creation d'une equipe externe
 */
elseif($op == "inscription") {

	/*** verification securite ***/
	if(!$config['inscription_equipe'] || !$s_joueur) js_goto("?page=index");

	echo "<p class=title>.:: $strNouvelleEquipe ::.</p>";

	echo "<form method=post action=?page=equipes&op=do_inscription>";

	/*** table de l'equipe ***/
	echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
	echo "<table cellspacing=1 cellpadding=0 border=0 class=fiche>";
	echo "<tr><td>";
	echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";

	/*** nom ***/
	echo "<tr><td class=titlefiche width=33%>$strNom <font color=red><b>*</b></font> :</td>";
	echo "<td class=textfiche>";
	echo "<input type=text name=nom>";
	echo "</td></tr>";

	/*** tag ***/
	echo "<tr><td class=titlefiche>$strTag <font color=red><b>*</b></font> :</td>";
	echo "<td class=textfiche>";
	echo "<input type=text name=tag>";
	echo "</td></tr>";

	/*** email **/
	echo "<tr><td class=titlefiche>$strEMail <font color=red><b>*</b></font> :</td>";
	echo "<td class=textfiche>";
	echo "<input type=text name=email maxlength=100 size=30>";
	echo "</td></tr>";

	/*** passwd ***/
	echo "<tr><td class=titlefiche>$strPasswordRejoindre <font color=red><b>*</b></font> :</td>";
	echo "<td class=textfiche>";
	echo "<input type=text name=passwd>";
	echo "</td></tr>";

	/*** origine ***/
	$tab_countrys = file("images/flags/country");
	echo "<tr><td class=titlefiche>$strOrigine <font color=red><b>*</b></font> :</td>";
	echo "<td class=textfiche>";
	echo "<select name=origine value=\"\">";

	for($i=0;$i<count($tab_countrys);$i++) {
		$tab_country=split(',',$tab_countrys[$i]);
		$country_code=$tab_country[0];
		$country_name=$tab_country[1];
		echo "<option value=$country_code";
		if ($country_code == 'FR') echo " SELECTED";echo ">$country_name";
	}
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td class=footerfiche align=center colspan=2><input type=submit value=\"$strValider\"></td></tr>";
	echo "</table>";

	echo "</td></tr></table>";
	echo "</td></tr></table>";
	echo "</form>";

	show_consignes($strInscriptionsEquipesConsignes);

	echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";

}
/********************************************************
 * Edit&eacute; status d'un joueur
 */
elseif($op == "do_editstat") {

	/*** verification securite ***/
	verif_manager($id,$s_joueur);

	$str='';
	$erreur=0;

	if(!is_numeric($id)) {
		$erreur=1;
		$str.="- $strElementsEquipeInvalide<br>";
	}
	if(!is_numeric($joueur)) {
		$erreur=1;
		$str.="- $strElementsJoueurInvalide<br>";
	}
	if(!is_numeric($jeux)) {
		$erreur=1;
		$str.="- $strElementsJeuxInvalide<br>";
	}

	if($erreur==1) {
		show_erreur($str);
	}
	else {

			$joueur=str_replace('"',"&quot;",addslashes($joueur));

			$db->update("${dbprefix}appartient");
			$db->set("status = '$status'");
			$db->where("equipe = '$id' && joueur= '$joueur' && jeux=$jeux");
			$db->exec();

			/*** redirection ***/
			js_goto("?page=equipes&op=$oldop&section=membres&id=$id");
		
	}

}
/********************************************************
 * Edit&eacute; status d'un joueur
 */
elseif($op == "edit_stat") {

	echo '<form method=post action=?page=equipes&op=do_editstat>
	
	<input type=hidden name=jeux value='.$jeux.'>
	<input type=hidden name=joueur value='.$joueur.'>
	<input type=hidden name=id value='.$id.'>
	<input type=hidden name=oldop value='.$oldop.'>
	
	<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>
	<table cellspacing=1 cellpadding=0 border=0>
	<tr><td class=headerfiche>&nbsp; '.$strEditerJoueur.' &nbsp;</td></tr>
	<tr><td>
	
	<table cellspacing=0 cellpadding=3 border=0 width=100%>
	<tr><td class=titlefiche>'.$strJoueur.' :</td>
	<td class=textfiche>'.show_joueur($joueur).'&nbsp;</td></tr>
	<tr><td class=titlefiche>'.$strEquipe.' :</td>
	<td class=textfiche>'.show_equipe($id).'&nbsp;</td></tr>
	<tr><td class=titlefiche>'.$strJeux.' :</td>
	<td class=textfiche>&nbsp<img src="images/jeux/'.$icon.'" border=0 align=absmiddle>&nbsp;</td></tr>
	
	<tr><td class=titlefiche>'.$strStatus.' <font color=red><b>*</b></font> :</td>
	<td class=textfiche><select name=status>';
	
	echo '<option value="1"';if ($stat_j=="1"){echo 'selected';}echo '>'.$strLeader.'</option>
	<option value="2"';if ($stat_j=="2"){echo 'selected';}echo'>'.$strWarArranger.'</option>
	<option value="3"';if ($stat_j=="3"){echo 'selected';}echo'>'.$strMembre.'</option>
	<option value="4"';if ($stat_j=="4"){echo 'selected';}echo'>'.$strRecrue.'</option>
	<option value="5"';if ($stat_j=="5"){echo 'selected';}echo'>'.$strInactif.'</option>
	</select></td></tr>
	<tr><td colspan="2" class=footerfichemods colspan=2><hr><input type=submit value=" - '.$strOK.' - "></td></tr>
	</table>	
	</td></tr>
	</table>
	</td></tr></table></form><br>';

	
}
/********************************************************
 * Quitter une &eacute;quipe
 */
elseif($op == "leave") {

	if($is_manager)  {js_goto($PHP_SELF);}
	
		$db->delete("${dbprefix}appartient");
		$db->where("equipe = $id");
		$db->where("joueur = $s_joueur");
		$db->exec();

		//
		$db->select("joueur,status");
		$db->from("${dbprefix}appartient");
		$db->where("equipe = $id");
		$res=$db->exec();
		
	
		$coun_y_grade = 1;
			
		// on test combien de fois le joueur est ou leader ou wararanger		
		while ($equipe_j = $db->fetch($res)) {
			
			if ($equipe_j->status == 1 || $equipe_j->status == 2) {
			// incr&eacute;mentation de la variable pour sauter la nullit&eacute;.
			$coun_y_grade=$coun_y_grade+1;
			}
			
		}
		//
		
		if ($coun_y_grade <= 1) {
			$db->select("grade");
			$db->from("${dbprefix}joueurs");
			$db->where("id = $s_joueur");
			$db->exec();
			$joueur_ress = $db->fetch();
			
			if (eregi("y",$joueur_ress->grade)) {
			
			$new_grade = str_replace("y","",$joueur_ress->grade);
			
			$db->update("${dbprefix}joueurs");
			$db->set("grade='$new_grade'");
			$db->where("id = $s_joueur");
			$db->exec();
			}
		}

		// g&eacute;n&eacute;ration d'un message pour le manager 
		$db->select("manager");
		$db->from("${dbprefix}equipes");
		$db->where("id = $id");
		$db->exec();
		$the_manager = $db->fetch();
		
		
		if($config['mail']!='N') {
		
				
				$mail = new phpTMailer();
				$from = joueur($s_joueur);
				$mail->From = $from->email;
				$mail->FromName = $from->pseudo;
				$mail->Subject = $strLeaveTeamtitle;
				// formatage contenu + pseudo
				$body = BBcode($strLeaveTeambody1.$from->pseudo.$strLeaveTeambody2);
				$mail->Body = str_replace("SRC=\"images/smilies/", "SRC=\"".$config['urlsite']."/images/smilies/", $body);
		
				/*** generation de la messagerie ***/
				$to=joueur($the_manager->manager);
				$mail->AddAddress($to->email);				
				}
				
				
   				$date=time();
				$contenance=BBcode($strLeaveTeambody1.$from->pseudo.$strLeaveTeambody2);
				$db->insert("${dbprefix}messages (emetteur,destinataire,titre,message,date)");
				$db->values("'$s_joueur','$the_manager->manager','$titre','$contenance','$date'");
				$db->exec();

				
		/*** redirection ***/
		js_goto("?page=equipes&id=$id");
	
}
/********************************************************
* Quitter une &eacute;quipe
*/
elseif($op == "leave") {

if($is_manager)  {js_goto($PHP_SELF);}

 $db->delete("${dbprefix}appartient");
 $db->where("equipe = $id");
 $db->where("joueur = $s_joueur");
 $db->exec();
 
  js_goto('?page');

}
/********************************************************
 * Rejoindre une equipe
 */
elseif($op == "rejoindre") {

	/*** verification securite ***/
	if(!$s_joueur) js_goto("?page=index");

	echo "<p class=title>.:: $strRejoindreUneEquipe ::.</p>";

	echo "<form method=post action=?page=equipes&op=do_rejoindre>";

	/*** table de l'equipe ***/
	echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
	echo "<table cellspacing=1 cellpadding=0 border=0 class=fiche>";
	echo "<tr><td>";
	echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";

	/*** equipe ***/
	echo "<tr><td class=titlefiche width=33%>$strTag <font color=red><b>*</b></font> :</td>";
	echo "<td class=textfiche>";
	if(!isset($id)) {
		echo "<select name=id value=''>";

		$db->select("id, tag");
		$db->from("${dbprefix}equipes");
		$db->where("etat <> 'C'");
		$db->order_by("tag");
		$res=$db->exec();

		while ($equipe = $db->fetch($res)) {
			echo '<option value="'.$equipe->id.'">'.stripslashes($equipe->tag).'';
		}
		echo "</select>";
	}
	else {
		echo "<input type=hidden name=id value=$id>".show_equipe($id);
	}
	echo "</td></tr>";

	echo "<tr><td class=titlefiche>$strJeu <font color=red><b>*</b></font> :</td>";
	echo "<td class=textfiche><select name=jeux>";
	$db->select("id, sigle");
	$db->from("${dbprefix}jeux");
	$db->order_by("sigle");
	$db->exec();
	while($jeux = $db->fetch()) {
		echo "<option value=$jeux->id>$jeux->sigle";
	}
	echo "</select></td></tr>";

	/*** passwd ***/
	echo "<tr><td class=titlefiche>$strPassword <font color=red><b>*</b></font> :</td>";
	echo "<td class=textfiche>";
	echo "<input type=password name=passwd>";
	echo "</td></tr>";

	echo "<tr><td class=footerfiche align=center colspan=2><input type=submit value=\"$strValider\"></td></tr>";
	echo "</table>";

	echo "</td></tr></table>";
	echo "</td></tr></table>";
	echo "</form>";

	show_consignes($strRejoindreEquipesConsignes);

	echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";

}
/********************************************************
 * Affichage main + admin
 */
else {
	
	/*** verification securite ***/
	//if($op=="admin") verif_admin_general($s_joueur);
	if($op=="admin"){if ($grade['a']!='a' && $grade['b']!='b' && $grade['e']!='e') {js_goto($PHP_SELF);}}

	if($op) $op_str="&op=$op";
		else $op_str='';


	/*** liste des toutes les equipes ***/
	if (empty($id)) {

		if ($op == "admin") echo "<p class=title>.:: $strAdminEquipes ::.</p>";
		else echo "<p class=title>.:: $strEquipes ::.</p>";

		if(nb_equipes_total($op)!=0) {

			echo '<table cellspacing="0" cellpadding="0" border="0">';
			echo '<tr><td class="title" align="center">';
			echo "<input type=\"button\" value=\"$strValidees\" onclick=\"location='?page=equipes$op_str&list=V'\">";
			echo " <input type=\"button\" value=\"$strEnAttente\" onclick=\"location='?page=equipes$op_str&list=A'\">";
			if($op == 'admin') echo " <input type=\"button\" value=\"$strCachees\" onclick=\"location='?page=equipes$op_str&list=C'\">";
			echo " <input type=\"button\" value=\"$strToutes\" onclick=\"location='?page=equipes$op_str'\">";
			echo '</td></tr>';
			echo '</table><br>';

			/** gestion des affichages **/
			if(!isset($list)) $list = '';

			if($list=='A') {
				$tab_etat=array("etat = 'A'");
			}
			elseif($list=='V') {
				$tab_etat=array("etat = 'V'");
			}
			elseif($op=='admin' && $list=='C') {
				$tab_etat=array("etat = 'C'");
			}
			elseif($op=='admin') {
				$tab_etat=array("(etat = 'A' or etat = 'V' or etat = 'C')");
			}
			else {
				$tab_etat=array("etat = 'V'","etat = 'A'");
			}


			for($e=0;$e<count($tab_etat);$e++) {

				$db->select("id,manager,etat,carton,sanction");
				$db->from("${dbprefix}equipes");
				$db->where("$tab_etat[$e]");
				$db->order_by("tag");
				$equipes=$db->exec();

				/** reinit des colonne a 1 ***/
				if ($db->num_rows($equipes) < $config['col_equipes']) $col_equipes=1;
				else $col_equipes=$config['col_equipes'];

				if ($db->num_rows($equipes) != 0) {
					$i=0;
					$tab_equipes=array();
					
					while($equipe = $db->fetch($equipes)) {
						$tab_equipes[$i]=$equipe;
						$i++;
					}

					if($tab_etat[$e]=="etat = 'V'") {
						echo '<table cellspacing="0" cellpadding="0" border="0">';
						echo '<tr><td class="title" align="center">'. nb_equipes_valide() ." $strEquipeValidee</td></tr>";
						echo '</table>';
					}

					if($tab_etat[$e]=="etat = 'A'") {
						echo '<table cellspacing="0" cellpadding="0" border="0">';
						echo '<tr><td class="title" align="center">'. nb_equipes_attente() ." $strEquipeEnAttente</td></tr>";
						echo '</table>';
					}

					echo "<table cellspacing=0 cellpadding=0 border=0 class=liste><tr valign=top>";
					if ($op == 'admin') echo "<form name='liste' method=post action=?page=equipes&op=status>";
					
					for($i=0;$i<$col_equipes;$i++) {
						echo "<td>";
						echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
						echo "<table cellspacing=1 cellpadding=2 border=0>";
						echo "<tr><td class=headerliste>#</td><td width=120 class=headerliste>$strTag</td><td class=headerliste>$strManager</td><td class=headerliste>$strJoueurs</td><td class=\"headerliste\">$strStatus</td></tr>";

						for($j=$i;$j<count($tab_equipes);$j=$j+$col_equipes) {
							echo "<tr>";
							echo "<td class=textliste align=center>".$tab_equipes[$j]->id."</td>";
							echo "<td class=textliste>";
							echo "<div style=\"clear: both\"><div style=\"float: left\">".show_equipe($tab_equipes[$j]->id,$op)."</div>";
							if ($tab_equipes[$j]->carton == 'aucun')
								{
								echo "";
								}
								else 
								{
								echo "<A href=\"?page=reglements\" onMouseOver=\"AffBulle('<b>Carton ".$tab_equipes[$j]->carton." </b>: ".$tab_equipes[$j]->sanction."')\" onMouseOut=\"HideBulle()\"><img src=\"images/cartons/".$tab_equipes[$j]->carton.".gif\" border=\"0\" align=\"absmiddle\"></A>";
								} 

							if ($op == 'admin' && nb_tournois_equipe($tab_equipes[$j]->id) == 0 && nb_joueurs_equipe($tab_equipes[$j]->id) == 0)
								echo "<div style=\"float: right\">&nbsp;<a href=?page=equipes&op=delete&id=".$tab_equipes[$j]->id." onclick=\"return confirm('$strConfirmEffacerEquipe');\">[$strS]</a></div>";
							echo "</div></td>";
							echo "<td class=textliste>".show_joueur($tab_equipes[$j]->manager,$op)."</td>";
							echo "<td class=textliste align=center>";
							$nbjoueurs_inscrit=nb_joueurs_equipe($tab_equipes[$j]->id,'I');
							$nbjoueurs_preinscrit=nb_joueurs_equipe($tab_equipes[$j]->id,'P');
							if($nbjoueurs_inscrit == 0)	echo "<font color=red>$nbjoueurs_inscrit</font>";
							else echo "$nbjoueurs_inscrit";
							echo " - $nbjoueurs_preinscrit";
							echo "</td>";
							echo '<td class="textliste" align="center">';
							
							if ($op == 'admin') {
								echo '<select name="status" onchange="status_equipe('.$tab_equipes[$j]->id.',this.value,\''.$strChangerStatusEquipe.'\')">';
								echo '<option value="C"';if ($tab_equipes[$j]->etat == 'C') echo ' SELECTED';echo ">$strCachee";
								echo '<option value="A"';if ($tab_equipes[$j]->etat == 'A') echo ' SELECTED';echo ">$strEnAttente";
								echo '<option value="V"';if ($tab_equipes[$j]->etat == 'V') echo ' SELECTED';echo ">$strValidee";
								echo '</select>';
								echo '<input type=checkbox name=tab_status[] value='.$tab_equipes[$j]->id.' style="border=0px;background-color:transparent;">';

							}
							else {
								if ($tab_equipes[$j]->etat == 'A') echo "<font color=\"red\">$strEnAttente</font>";
								elseif ($tab_equipes[$j]->etat == 'V') echo "<font color=\"green\">$strValidee</font>";
							}
							echo '</td></tr>';
						}
						echo "</table>";
						echo "</td></tr></table>";
						echo "</td>";
					}
					echo "</tr></table>";
					
					if ($op == 'admin') {
						echo "<table cellspacing=1 cellpadding=2 border=0>";
						echo "<tr><td class=text align=center><a href=javascript:select_all('liste')>$strToutSelectionner<a/> - <a href=javascript:unselect_all('liste')>$strToutDeselectionner<a/></td></tr>";
						echo "<tr><td class=text align=center>";
						echo '<select name="status">';
						echo "<option value=\"C\">$strCachee";
						echo "<option value=\"A\">$strEnAttente";
						echo "<option value=\"V\">$strValidee";
						echo '</select>';								
						echo "<input type=submit value=\"$strValider\"></td></tr>";
						echo "</form></table>";
					}
				}
				else {
					if($list=='A' || $list=='V' || $list=='C') {
						echo "<table cellspacing=2 cellpadding=2 border=0>";
						echo "<tr><td class=title>$strPasDEquipe</td></tr>";
						echo "</table>";
					}
				}
			}
			echo "<br>";

			if($op!='admin') {
				show_consignes($strEquipesConsignes);
			}
		}
		else {
			echo "<table cellspacing=2 cellpadding=2 border=0>";
			echo "<tr><td class=title>$strPasDEquipe</td></tr>";
			echo "</table><br>";
		}


		/*** ajout d'une equipe ***/
		if ($op == 'admin') {
			echo "<form method=post action=?page=equipes&op=add>";
			echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
			echo "<table cellspacing=1 cellpadding=0 border=0>";
			echo "<tr><td class=headerfiche>$strAjouterEquipe</td></tr>";
			echo "<tr><td>";
			echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
			echo "<tr>";
			echo "<td class=titlefiche>$strNom <font color=red><b>*</b></font> :</td>";
			echo "<td class=textfiche><input type=text name=nom maxlength=32></td></tr>";
			echo "<tr>";
			echo "<td class=titlefiche>$strTag <font color=red><b>*</b></font> :</td>";
			echo "<td class=textfiche><input type=text name=tag maxlength=16></td>";
			echo "</tr>";
			echo "<tr><td class=footerfiche align=center colspan=2><input type=submit value=$strAjouter></td></tr>";
			echo "</table>";
			echo "</td></tr></table>";
			echo "</td></tr></table>";
			echo "</form>";
		}
	}

	/*** fiche d'une equipe ***/
	else {
	
		$equipe = equipe($id);

		if(equipe_manager($id,$s_joueur)) $is_manager=1;
		else $is_manager=0;

		echo "<p class=title>.:: $strEquipe $equipe->tag - $equipe->nom ::.</p>";
			
		echo '<table cellspacing="0" cellpadding="0" border="0">';
		echo '<tr><td class="title" align="center">';
		echo "<a href=\"?page=equipes$op_str&section=fiche&id=$id\">$strFiche</a> | <a href=\"?page=equipes$op_str&section=membres&id=$id\">$strMembres</a> | <a href=\"?page=equipes$op_str&section=resultats&id=$id\">$strResultats</a>";
		echo '</td></tr>';
		echo '</table><br>';
		
		if($section=='') { $all="ok"; }
		
		if ($section=='fiche' || $all=="ok") {

			if($op=='admin') echo "<form method=post action=?page=equipes&op=modify_admin>";
			else echo "<form method=post action=?page=equipes&op=modify_manager>";
			
			echo "<input type=hidden name=id value=$id>
			<input type = 'hidden' value='$equipe->manager' name='oldmanager' >";
			
			/*** table de l'equipe ***/
			echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1 width=300><tr><td>";
			echo "<table cellspacing=1 cellpadding=0 border=0 class=fiche width=100%>";
			echo "<tr><td class=headerfiche>$strFiche</td></tr>";
			echo "<tr><td>";
			echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
	
			/*** nom ***/
			echo "<tr><td width=33% class=titlefiche>$strNom :</td>";
			echo "<td class=textfiche>";
	
			if($is_manager || $op == 'admin')
				echo "<input type=text name=nom value=\"".stripslashes($equipe->nom)."\">";
			else
				echo "<b>$equipe->nom</b>";
			echo "</td>";
			
			echo "<td class=textfiche rowspan=4>";
			if($config['avatar']=='E' || $config['avatar']=='A') {
				echo "<div style=\"float: right;\">".show_avatar($equipe->avatar_img)."</div>";
			}
			echo "</td></tr>";
	
			/*** tag ***/
			echo "<tr><td class=titlefiche>$strTag :</td>";
			echo "<td class=textfiche>";
	
			if ($op == 'admin' || $is_manager) echo "<input type=text name=tag value=\"".stripslashes($equipe->tag)."\">";
			else echo "$equipe->tag";
			echo "</td></tr>";
	
			/*** origine ***/
			$tab_countrys = file("images/flags/country");
			echo "<tr><td class=titlefiche>$strOrigine :</td>";
			echo "<td class=textfiche>";
	
			if ($op == 'admin'  || $is_manager) {
				echo "<select name=origine value='$equipe->origine'>";				
	
				for($i=0;$i<count($tab_countrys);$i++) {
					$tab_country=split(',',$tab_countrys[$i]);
					$country_code=$tab_country[0];
					$country_name=$tab_country[1];
					echo "<option value=$country_code";
					if ($country_code == $equipe->origine) echo " SELECTED";echo ">$country_name";
				}
				echo "</select>";
			}
			else {
				for($i=0;$i<count($tab_countrys);$i++) {
					$tab_country=split(',',$tab_countrys[$i]);
					$country_code=$tab_country[0];
					$country_name=$tab_country[1];
					if ($country_code == $equipe->origine) break;
				}
				echo "<img src=\"images/flags/$country_code.gif\" align=absmiddle>&nbsp;$country_name";
			}
			echo "</td></tr>";
	
			/*** manager***/
			echo "<tr><td class=titlefiche>$strManager :</td>";
			echo "<td class=textfiche>";
	
			if ($op == 'admin' || $is_manager) {
				echo "<select name=manager>";
				echo "<option value=null>";
	
				$db->select("id, pseudo");
				$db->from("${dbprefix}joueurs");
				$db->where(" etat != 'C'");
				$db->order_by("pseudo");
				$db->exec();
	
				while($joueurs = $db->fetch()) {
					echo "<option value=$joueurs->id";if($equipe->manager == $joueurs->id) echo " SELECTED";echo '>'.stripslashes($joueurs->pseudo).'';
				}
				echo "</select>";
			}
			else {
				 echo show_joueur($equipe->manager);
			}
			echo "</td></tr>";
			
			/*** email ***/
			echo "<tr><td class=titlefiche>$strEMail :</td>";
			echo "<td class=textfiche colspan=2>";
			if ($is_manager || $op == 'admin')
			 	echo "<input type=text size=40 name=email value='$equipe->email'>";
			else {
				if($equipe->email) echo "<img src=images/p_mail.gif align=absmiddle> <a href='mailto:$equipe->email'>$equipe->email</a>";
				else echo "N/A";
			}
			echo "</td></tr>";

			/*** password ***/
			if($is_manager || $op == 'admin') {
				echo "<tr><td class=titlefiche>$strPassword :</td>";
				echo "<td class=textfiche colspan=2>";
				echo "<input type=text size=20 name=passwd value=''>";
				echo "</td></tr>";
			}
	
	
			/*** avatar ***/
			if(($is_manager || $op == 'admin') && ($config['avatar']=='E' || $config['avatar']=='A')) {
				echo "<tr><td class=titlefiche>$strAvatar :</td>";
				echo "<td class=textfiche colspan=3>";
				echo "<input type=button value=\"$strModifierAvatar\" onclick=\"location='?page=avatars&id=$id&mode=E'\">";
				echo "</td></tr>";
			}
	
			/*** url ***/
			echo "<tr><td class=titlefiche>$strWWW :</td>";
			echo "<td class=textfiche colspan=2>";
			if($is_manager || $op == 'admin') {
				if(!$equipe->url) $equipe->url='http://';
			 	echo "<input type=text  size=30 name=url value='$equipe->url'>";
			}
			else {
				if($equipe->url) echo "<a href=\"".stripslashes($equipe->url)."\" target=_blank>".stripslashes($equipe->url)."</a>";
				else echo "N/A";
			}
			echo "</td></tr>";
	
			/*** irc ***/
			echo "<tr><td class=titlefiche>$strIrc :</td>";
			echo "<td class=textfiche colspan=2>";
			if($is_manager || $op == 'admin')
				echo "<input type=text size=30 name=irc value=\"".stripslashes($equipe->irc)."\">";
			else {
				if($equipe->irc) echo "$equipe->irc";
				else echo "N/A";
			}
			echo "</td></tr>";
			
			/*** custom champs ***/
			$tab_vars=get_object_vars($equipe);
			
			reset($tab_vars);
			while (!is_null($key = key($tab_vars) ) ) {
												
				if(strstr($key,'ext_')) {
					
					echo "<tr><td class=titlefiche>".${"str".ucfirst(substr($key, 4))}." :</td>";
					echo "<td class=textfiche colspan=2>";
			
					if($is_manager || $op == 'admin')
						echo "<input type=text name=$key value=\"".stripslashes($tab_vars[$key])."\" size=30 maxlength=50>";
					else
						echo $tab_vars[$key];
			
					echo "</td></tr>";
				}
				next($tab_vars);		
			}
			
			/*** SERVER  ***/
			if ($mods['serverteam']) {
			if($is_manager) {
			echo "<tr><td class=titlefiche>$strServerName :</td>";
			echo "<td class=textfiche colspan=2>";
			echo "<input type=text size=30 name=servername value=\"".stripslashes($equipe->servername)."\">";
			echo "</td></tr>";
		
			echo "<tr><td class=titlefiche>$strIp :</td>";
			echo "<td class=textfiche colspan=2>";
			echo "<input type=text size=30 name=serverip value=\"".stripslashes($equipe->serverip)."\">";
			echo "</td></tr>";
			
			
			if($config['serveur']) {
			if ($equipe->servername!=''&&$equipe->serverip!='') {
			echo "<tr><td class=titlefiche></td>";
			echo "<td class=textfiche colspan=2>";
			echo "<input type=\"button\" class=\"action\" value=\"$strADD_t_server\" onclick=\"location='?page=team_serveurs&id_s=$equipe->id_s&id_t=$id'\">";
			echo "</td></tr>";
			}
			}
			} else {
			echo "<tr><td class=titlefiche>$strServerName :</td>";
			echo "<td class=textfiche colspan=2>";
			echo stripslashes($equipe->servername);
			echo "</td></tr>";
		
			echo "<tr><td class=titlefiche>$strIp :</td>";
			echo "<td class=textfiche colspan=2>";
			echo stripslashes($equipe->serverip);
			echo "</td></tr>";
			}
			}
			/*** etat ***/
					/*** Carton ***/
			
			echo "<tr><td class=titlefiche>$strSanctions :</td>";
			echo "<td class=textfiche colspan=2>";
			
			if ($op == 'admin' ) {
			
			echo "<table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td class=textfiche>";
		
			echo "<select name=carton>";
			
			$fd = opendir("images/cartons/");
			while($file = readdir($fd)) {
				if ($file != "." && $file != "..") {
					$file = ereg_replace(".gif","",$file);
					echo "<option value=$file";
					if ($file == $equipe->carton) echo " SELECTED";
					echo ">$file";
				}
			}
			closedir($fd);
			
			echo "</select>";
			echo " Carton";
			echo "</td></tr><tr><td class=textfiche>";
			echo "<input type=text size=20 name=sanction value=\"".stripslashes($equipe->sanction)."\">";
			echo " Motif</td></tr></table>";
			}
			
		else { 
			if ($equipe->carton == 'aucun')
				{
		echo $strAucune;
				}
			else 
				{
		echo "<A href=\"?page=reglements\" onMouseOver=\"AffBulle('<b>Carton $equipe->carton </b>: $equipe->sanction')\" onMouseOut=\"HideBulle()\"><img src=\"images/cartons/$equipe->carton.gif\" border=0 align=absmiddle></A>";
				} 
			 }
		echo "</td></tr>";
			echo "<tr><td class=\"titlefiche\">$strEtat :</td>";
			echo '<td class="textfiche" colspan="3">';
			$date=strftime(DATESTRING1, $equipe->dateinscription);
			$date = "&nbsp;$strLe ".$date;
	
			if ($op == 'admin' ) {
				echo '<select name="etat">';
				echo '<option value="C"';if ($equipe->etat == 'C') echo ' SELECTED';echo ">$strCachee";
				echo '<option value="A"';if ($equipe->etat == 'A') echo ' SELECTED';echo ">$strEnAttente";
				echo '<option value="V"';if ($equipe->etat == 'V') echo ' SELECTED';echo ">$strValidee";
				echo "</select>$date";
			}
			else if (($is_manager) && ($equipe->etat == 'A' || $equipe->etat == 'C') && $mods['m_team_valid']) {
			echo "<input type=\"button\" class=\"action\" value=\"$strValid_My_Team\" onclick=\"location='?page=equipes&id=$equipe->id&op=autoval&oldop=$op'\">";
			}
			else {
				if ($equipe->etat == 'C') echo "<font color=\"orange\"><b>$strCachee</b></font>";
				elseif ($equipe->etat == 'A') echo "<font color=\"red\">$strEnAttente</b></font>$date";
				elseif ($equipe->etat == 'V') echo "<font color=\"green\">$strValidee</b></font>$date";
			}
			echo '</td></tr>';
	
			if($is_manager || $op == 'admin') {
				echo "<tr><td class=footerfiche align=center colspan=3><input type=submit value=\"$strModifier\"></td></tr>";
			}

			echo "</table>";
			echo "</td></tr></table>";	
			echo "</td></tr></table>";
			
			if ((equipe_appartient($id,$s_joueur)) && !$is_manager) {
			echo "<div align='center'><input type=button name=leave value=\"$strLeaveTeam\" onclick=\"javascript:alerter('?page=equipes&op=leave&id=$id','$strLeaveTeamALERT')\"></div>";
			} else {
			echo "<div align='center'><input type=button name=leave value=\"$strLeaveTeam\" disabled><br /><span style='font-size:12'>$strLeaveTeamM</span></div>";
			}

			//echo ($is_manager) ?  "<div align='center'><input type=button name=leave value=\"$strLeaveTeam\" disabled><br /><span style='font-size:12'>$strLeaveTeamM</span></div>" : "<div align='center'><input type=button name=leave value=\"$strLeaveTeam\" onclick=\"javascript:alerter('?page=equipes&op=leave&id=$id','$strLeaveTeamALERT')\"></div>";
			
			/*** Remarque ***/
			if ($op == 'admin') {
			echo '<table border=0 cellpadding=0 width="350" cellspacing=0 class=bordure1><tr><td>
			<table cellspacing=1 cellpadding=0 border=0>
			<tr><td class=modsfiche>&nbsp;&nbsp;&nbsp; '.$strRemarqueEQUIPE.' &nbsp;&nbsp;&nbsp;</td></tr>
			<tr><td>
			<table cellspacing=0 cellpadding=2 border=0 width=100%>
			<tr><td class=partfiche align="center"><div align="center">';
			echo "<br><textarea cols=60 rows=10 id=remarque name=remarque wrap=virtual>$equipe->remarque</textarea></td></tr>";	
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
			$db->where("modeequipe = 'E'");
			$db->order_by("${dbprefix}tournois.nom");
			$res = $db->exec();
	
			if ($db->num_rows($res) != 0) {
				$inscrit = '';
				$ainscrit = '';
	
				while($tournois = $db->fetch($res)) {
	
	
				if(participe($id,$tournois->id)) {
				 if($tournois->status!='T') 
				  $inscrit.="<img src=\"images/jeux/$tournois->icone\" border=0 align=absmiddle> ".stripslashes($tournois->nom).", ";
				 else 
				  $ainscrit.="<img src=\"images/jeux/$tournois->icone\" border=0 align=absmiddle> ".stripslashes($tournois->nom).", ";
				}
				}
				$inscrit=trim($inscrit," ,");
				$ainscrit=trim($ainscrit," ,");
	
				echo "<table cellspacing=0 cellpadding=0 border=0>";
				if($inscrit) echo "<tr><td class=title align=right><font color=green>$strTournoisParticipe</font> :&nbsp;&nbsp;</td><td class=title>$inscrit</td></tr>";
				if($ainscrit) echo "<tr><td class=title align=right><font color=red>$strTournoisAParticipe</font> :&nbsp;&nbsp;</td><td class=title>$ainscrit</td></tr>";
				echo "</table><br>";
			}
		}
		
		/*** joueurs de l'equipes ***/
		if($section=='membres' || $all=="ok") {
			
			$db->select("*");
			$db->from("${dbprefix}jeux");
			$db->order_by("sigle");
			$jeux = $db->exec();
			
			echo '<table cellspacing="0" cellpadding="0" border="0">';
			echo '<tr><td class="title" align="center">'. nb_joueurs_equipe($id) ." $strJoueurs</td></tr>";
			echo '</table>';
	
			if ($db->num_rows($jeux) != 0) {
	
				echo "<table cellspacing=0 cellpadding=0 border=0 class=liste><tr valign=top>";
	
				while($jeu = $db->fetch($jeux)) {
					$db->select("${dbprefix}joueurs.id,${dbprefix}joueurs.carton,${dbprefix}joueurs.sanction,${dbprefix}appartient.status");
					$db->from("${dbprefix}joueurs, ${dbprefix}appartient");
					$db->where("${dbprefix}appartient.equipe = $id");
					$db->where("${dbprefix}appartient.jeux = $jeu->id");
					$db->where("${dbprefix}appartient.joueur = ${dbprefix}joueurs.id");
					$db->order_by("${dbprefix}appartient.status");
					$joueurs=$db->exec();
	
					if ($db->num_rows($joueurs) != 0) {
						echo "<td>";
						echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
						echo "<table cellspacing=1 cellpadding=2 border=0>";
						echo "<tr><td class=headerliste>$strJoueurs $jeu->sigle <img src=\"images/jeux/$jeu->icone\" border=0 align=absmiddle></td></tr>";
	
						while ($joueur = $db->fetch($joueurs)) {
						$status_j=$joueur->status;
							echo "<tr>";
							echo "<td class=textliste width=120>";
							echo "<div style=\"clear: both\"><div style=\"float: left\">";
							if($status_j=='5') echo show_joueur($joueur->id,$op,'I');
							else echo show_joueur($joueur->id,$op);
							if($status_j=='1') echo '<small><sup>*</sup></small>';
							if($status_j=='2') echo '<small><sup>(wa)</sup></small>';
							if($status_j=='4') echo '<small><sup>(r)</sup></small>';
							if ($joueur->carton == 'aucun')
							{
							echo "";
							}
							else 
							{
							echo " <A href=\"?page=reglements\" onMouseOver=\"AffBulle('<b>Carton $joueur->carton </b>: $joueur->sanction')\" onMouseOut=\"HideBulle()\"><img src=images/cartons/$joueur->carton.gif border=0 align=align=absmiddle></A>";
							} 
						
							echo "</div>";
							if($is_manager || $op == 'admin') {
								echo "<div style=\"float: right\">&nbsp;<a href='?page=equipes&op=edit_stat&id=$id&joueur=$joueur->id&jeux=$jeu->id&oldop=$op&stat_j=$status_j&icon=$jeu->icone'>[$strE]</a></div>";
								if($jeux->id=="1"){$opplus="all";}else{$opplus="one";}
								echo "<div style=\"float: right\">&nbsp;<a href=?page=equipes&op=delete_joueur&id=$id&joueur=$joueur->id&jeux=$jeu->id&oldop=$op&del=$opplus onclick=\"return confirm('$strConfirmEffacerJoueur');\">[$strS]</a></div>";
							}
							echo "</div></td></tr>";
						}
						echo "</table>";
						echo "</td></tr></table>";
						echo "</td>";
					}
				}
	
				/* Ajout d'un joueur */
				if($is_manager || $op == 'admin') {
					echo "<td>";
					echo "<form method=post action=?page=equipes&op=add_joueur>";
					echo "<input type=hidden name=oldop value=$op>";
					echo "<input type=hidden name=id value=$id>";
	
					echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
					echo "<table cellspacing=1 cellpadding=0 border=0>";
					echo "<tr><td class=headerfiche>$strAjouterJoueur</td></tr>";
					echo "<tr><td>";
					echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
	
					echo "<tr><td class=titlefiche>$strNom <font color=red><b>*</b></font> :</td><td class=textfiche><select name=joueur>";
					$db->select("id, pseudo");
					$db->from("${dbprefix}joueurs");
					$db->where("(etat = 'I' or etat = 'P')");
					$db->where("(jointeam = '1')");
					$db->order_by("pseudo");
	
					$db->exec();
					while($joueurs = $db->fetch()) {
						echo "<option value=$joueurs->id>".stripslashes($joueurs->pseudo)."";
					}
					echo "</select></td></tr>";
					echo "<tr><td class=titlefiche>$strStatus <font color=red><b>*</b></font> :</td><td class=textfiche><select name=status>";
					echo "<option value=\"1\">$strLeader</option>";
					echo "<option value=\"2\">$strWarArranger</option>";
					echo "<option value=\"3\" selected>$strMembre</option>";
					echo "<option value=\"4\">$strRecrue</option>";
					echo "<option value=\"5\">$strInactif</option>";
					echo "</select></td></tr>";
	
					echo "<tr><td class=titlefiche>$strJeu <font color=red><b>*</b></font> :</td><td class=textfiche><select name=jeux>";
					$db->select("id, sigle");
					$db->from("${dbprefix}jeux");
					$db->order_by("sigle");
					$db->exec();
					while($jeux = $db->fetch()) {
						echo "<option value=$jeux->id>$jeux->sigle";
					}
					echo "</select></td></tr>";
	
					echo "<tr><td class=footerfiche colspan=2 align=center><input type=submit value=\"$strAjouter\"></td></tr>";
					echo "</table>";
	
					echo "</td></tr></table>";			
					echo "</td></tr></table>";
					echo "</form>";
					echo "</td>";
				}
				echo "</tr></table><br>";
			}
		}
		
		/*** resultats de l'equipe ***/
		if($section=='resultats' || $all=="ok") {

			$db->select("id, ${dbprefix}participe.status");
			$db->from("${dbprefix}tournois,${dbprefix}participe");
			$db->where("id = tournois");
			$db->where("equipe = $id");
			$db->where("modeequipe = 'E'");
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

?>

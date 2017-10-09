<?php
/*
   +---------------------------------------------------------------------+
   | phpTournois                                                         |
   +---------------------------------------------------------------------+
   +---------------------------------------------------------------------+
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
if (preg_match("/configuration.php/i", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}

if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['c']!='c') {js_goto($PHP_SELF);} 
//verif_admin_general($s_joueur);

/******************************************************** 
 * Modification de la configuration
 */
if ($op == "modify") {
	
	$str='';
	$erreur=0;
	
	if(!$nomsite) {
		$erreur=1;
		$str.="- $strElementsNomInvalide<br>";		
	}
	if(!is_numeric($places) || $places <=0 ) {
		$erreur=1;
		$str.="- $strErreurNbPlaces<br>";		
	}	

	if($erreur==1) {		
		show_erreur_saisie($str);			
	}
	else {		
		
		if (!isset($inscription_joueur_email)	 && empty($inscription_joueur_email))	$inscription_joueur_email = '0'; 
		if (!isset($inscription_joueur_pre) 	 && empty($inscription_joueur_pre))		$inscription_joueur_pre = '0'; 
		if (!isset($inscription_equipe_pre) 	 && empty($inscription_equipe_pre))		$inscription_equipe_pre = '0'; 

		$db->update("${dbprefix}config");
		$db->set("support='$support',nomsite='$nomsite',urlsite='$urlsite',logo='$logo',pagestart='$pagestart',emailinscription='$emailinscription',emailcontact='$emailcontact',default_lang='$langue',default_theme='$theme'");
		$db->set("inscription_joueur='$inscription_joueur',inscription_joueur_email='$inscription_joueur_email',inscription_joueur_pre='$inscription_joueur_pre',inscription_equipe='$inscription_equipe',inscription_equipe_pre='$inscription_equipe_pre',places='$places',reglement='$reglement',decharge='$decharge',information='$information',sponsors='$sponsors',partenaires='$partenaires'");
		$db->set("galerie='$galerie',download='$download',liens='$liens',forum='$forum',contact='$contact',serveur='$serveur'");
		$db->set("news='$news',messagerie='$messagerie',irc='$irc',livredor='$livredor',horloge='$horloge',gzip='$gzip'");
		$db->set("ircserver='$ircserver',ircport='$ircport',ircpassword='$ircpassword',ircchannels='$ircchannels'");
		$db->set("mail='$mail',smtpserver='$smtpserver',smtpuser='$smtpuser',smtppassword='$smtppassword'");
		$db->set("avatar='$avatar',avatar_upload='$avatar_upload',avatar_remote='$avatar_remote',avatar_gallerie='$avatar_gallerie',avatar_filesize_max='$avatar_filesize_max',avatar_x_max='$avatar_x_max',avatar_y_max='$avatar_y_max'");
		$db->set("shoutbox='$shoutbox',shoutboxc='$shoutboxc',shoutlimit='$shoutlimit'");
		$db->set("ladder='$ladder'");
		$db->set("poulewin='$poulewin', poulenull='$poulenull', pouleloose='$pouleloose',poulefor='$poulefor'");
		$db->set("faq='$faq',commande='$commande'");
		//$db->set("bbcodehelp='$bbcodehelp'");
		$db->exec();
	
		/*** redirection ***/
		js_goto("?page=configuration");
	}

}
/********************************************************
 * Affichage admin
 */
else {

	echo "<p class=title>.:: $strConfiguration ::.</p>";

	$db->select("*");
	$db->from("${dbprefix}config");
	$db->exec();
	$configuration = $db->fetch();

	echo "<form method=post action=?page=configuration&op=modify>";

	/*** table de la config ***/
	echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
	echo "<table cellspacing=1 cellpadding=0 border=0>";
	echo "<tr><td class=headerfiche>$strModifierConfiguration</td></tr>";
	echo "<tr><td>";
	echo "<table cellspacing=0 cellpadding=2 border=0 width=100%>";
	echo "<tr><td class=partfiche colspan=2>$strGeneral :</td></tr>";

	/*** nom ***/
	echo "<tr><td class=titlefiche>$strNom :</td>";
	echo "<td class=textfiche><input type=text name=nomsite value=\"$configuration->nomsite\" size=30>";
	echo "</td></tr>";

	/*** site ***/
	echo "<tr><td class=titlefiche>$strSite :</td>";
	echo "<td class=textfiche><input type=text name=urlsite value=\"$configuration->urlsite\" size=50>";
	echo "</td></tr>";

	/*** logo ***/
	echo "<tr><td class=titlefiche>$strLogo :</td>";
	echo "<td class=textfiche><input type=text name=logo value=\"$configuration->logo\">";
	echo "</td></tr>";

	/*** page de d&eacute;marrage ***/
	$tab_pagestart=array(array('page'=>'accueil', 'nom'=>$strAccueil),array('page'=>'news', 'nom' =>$strNews),array('page'=>'informations', 'nom'=>$strPresentation));
	echo "<tr><td class=titlefiche>$strPageDemarrage :</td>";
	echo "<td class=textfiche>";
	echo "<select name=pagestart>";
	for($i=0;$i<count($tab_pagestart);$i++) {
		echo '<option value='.$tab_pagestart[$i]['page'];
		if($tab_pagestart[$i]['page'] == $configuration->pagestart) echo " SELECTED";
		echo '>'.$tab_pagestart[$i]['nom'];	
	}
	echo "</select>";
	echo "</td></tr>";

	/*** mode d'inscription joueur***/
	echo "<tr><td class=titlefiche>$strInscriptionsJoueurs :</td>";
	echo "<td class=textfiche>";
	echo "<input type=radio name=inscription_joueur value=1 style=\"border: 0px;background-color:transparent;\"";if ($configuration->inscription_joueur == 1) echo " CHECKED";echo "> $strOui";
	echo "<input type=radio name=inscription_joueur value=0 style=\"border: 0px;background-color:transparent;\"";if ($configuration->inscription_joueur == 0) echo " CHECKED";echo "> $strNon";
	echo "&nbsp;<input type=checkbox name=inscription_joueur_email value=1 style=\"border: 0px;background-color:transparent;\"";if ($configuration->inscription_joueur_email == 1) echo " CHECKED";echo "> $strValidationEmail";
	echo "&nbsp;<input type=checkbox name=inscription_joueur_pre value=1 style=\"border: 0px;background-color:transparent;\"";if ($configuration->inscription_joueur_pre == 1) echo " CHECKED";echo "> $strPreInscription";
	echo "</td></tr>";

	/*** mode d'inscription equipe***/
	echo "<tr><td class=titlefiche>$strInscriptionsEquipes :</td>";
	echo "<td class=textfiche>";
	echo "<input type=radio name=inscription_equipe value=1 style=\"border: 0px;background-color:transparent;\"";if ($configuration->inscription_equipe == 1) echo " CHECKED";echo "> $strOui";
	echo "<input type=radio name=inscription_equipe value=0 style=\"border: 0px;background-color:transparent;\"";if ($configuration->inscription_equipe == 0) echo " CHECKED";echo "> $strNon";
	echo "&nbsp;<input type=checkbox name=inscription_equipe_pre value=1 style=\"border: 0px;background-color:transparent;\"";if ($configuration->inscription_equipe_pre == 1) echo " CHECKED";echo "> $strEnAttente";
	echo "</td></tr>";

	/*** NB places ***/
	echo "<tr><td class=titlefiche>$strNbPlaces :</td>";
	echo "<td class=textfiche><input type=text name=places value=\"$configuration->places\" size=5>";
	echo "</td></tr>";

	/*** Email contact ***/
	echo "<tr><td class=titlefiche>$strEmailContact :</td>";
	echo "<td class=textfiche><input type=text name=emailcontact value=\"$configuration->emailcontact\" size=30>";
	echo "</td></tr>";

	/*** Email inscription ***/
	echo "<tr><td class=titlefiche>$strEmailInscription :</td>";
	echo "<td class=textfiche><input type=text name=emailinscription value=\"$configuration->emailinscription\" size=30>";
	echo "</td></tr>";

	/*** Langue default ***/
	echo "<tr><td class=titlefiche>$strLangueDefaut :</td>";
	echo "<td class=textfiche>";

	echo "<select name=langue>";
	$fd = opendir("lang/");
	while($file = readdir($fd)) {
		if ($file != "." && $file != "..") {
			$file = ereg_replace(".inc.php","",$file);
			echo "<option value=$file";
			if ($file == $configuration->default_lang) echo " SELECTED";
			echo ">$file";
		}
	}
	closedir($fd);
	echo "</select>";
	echo "</td></tr>";


	/*** Theme default ***/
	echo "<tr><td class=titlefiche>$strThemeDefaut :</td>";
	echo "<td class=textfiche>";

	echo "<select name=theme>";
	$fd = opendir("themes/");
	while($file = readdir($fd)) {
		if ($file != "." && $file != ".." && is_dir("themes/$file") && file_exists("themes/$file/theme.php")) {
			echo "<option value=$file";
			if ($file == $configuration->default_theme) echo " SELECTED";
			echo ">$file";
		}
	}
	closedir($fd);
	echo "</select>";
	echo "</td></tr>";

	/*** gzip ***/
	echo "<tr><td class=titlefiche>$strGzip :</td>";
	echo "<td class=textfiche>";
	echo "<input type=radio name=gzip value=1 style=\"border: 0px;background-color:transparent;\"";if ($configuration->gzip == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=gzip value=0 style=\"border: 0px;background-color:transparent;\"";if ($configuration->gzip == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";

	echo "<tr><td class=partfiche colspan=2>$strOptions :</td></tr>";

	/*Custom poules Wpoints*/
	echo "<tr><td class=titlefiche>$strCPPW :</td>";
	echo "<td class=textfiche><input type=text name=poulewin value=\"$configuration->poulewin\" size=20></td></tr>";
	
	/*Custom poules Npoints*/
	echo "<tr><td class=titlefiche>$strCPPN :</td>";
	echo "<td class=textfiche><input type=text name=poulenull value=\"$configuration->poulenull\" size=20></td></tr>";
	
	/*Custom poules Lpoints*/
	echo "<tr><td class=titlefiche>$strCPPL :</td>";
	echo "<td class=textfiche><input type=text name=pouleloose value=\"$configuration->pouleloose\" size=20></td></tr>";
	
	/*Custom poules Fpoints*/
	echo "<tr><td class=titlefiche>$strCPPF :</td>";
	echo "<td class=textfiche><input type=text name=poulefor value=\"$configuration->poulefor\" size=20></td></tr>";


	/*information*/
	echo "<tr><td class=titlefiche>$strPagePresentation :</td>";
	echo "<td class=textfiche><textarea cols=40 rows=6 name=information wrap=virtual>";
	echo $configuration->information;
	echo "</textarea></td></tr>";

	/*reglement*/
	echo "<tr><td class=titlefiche>$strPageReglement :</td>";
	echo "<td class=textfiche><textarea cols=40 rows=6 name=reglement wrap=virtual>";
	echo $configuration->reglement;
	echo "</textarea></td></tr>";

	/*decharge*/
	echo "<tr><td class=titlefiche>$strPageDecharge :</td>";
	echo "<td class=textfiche><textarea cols=40 rows=6 name=decharge wrap=virtual>";
	echo $configuration->decharge;
	echo "</textarea></td></tr>";
	
	/*Aide BBcode*/
	//echo "<tr><td class=titlefiche>$strPageDeBBcode :</td>";
	//echo "<td class=textfiche><textarea cols=40 rows=6 name=BBcodehelp wrap=virtual>$configuration->BBcodehelp</textarea></td></tr>";

	
	/*** shoutbox ***/
	echo "<tr><td class=titlefiche>$strShoutbox :</td>";
	echo "<td class=textfiche>";
	echo "<input type=radio name=shoutbox value=1 style=\"border: 0px;background-color:transparent;\"";if ($configuration->shoutbox == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=shoutbox value=0 style=\"border: 0px;background-color:transparent;\"";if ($configuration->shoutbox == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";

	/*** shoutbox limit ***/
	echo "<tr><td class=titlefiche>$strShoutboxlimit :</td>";
	echo "<td class=textfiche><input type=text name=shoutlimit value=\"$configuration->shoutlimit\" size=20></td></tr>";

	/*** shoutbox limit C***/
	echo "<tr><td class=titlefiche>$strShoutboxlimitc :</td>";
	echo "<td class=textfiche><input type=text name=shoutboxc value=\"$configuration->shoutboxc\" size=20></td></tr>";

	/*** news ***/
	echo "<tr><td class=titlefiche>$strNews :</td>";
	echo "<td class=textfiche>";
	echo "<input type=radio name=news value=1 style=\"border: 0px;background-color:transparent;\"";if ($configuration->news == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=news value=0 style=\"border: 0px;background-color:transparent;\"";if ($configuration->news == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";
	
	/*** ladder ***/
	echo "<tr><td class=titlefiche>$strLadder :</td>";
	echo "<td class=textfiche>";
	echo "<input type=radio name=ladder value=1 style=\"border: 0px;background-color:transparent;\"";if ($configuration->ladder == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=ladder value=0 style=\"border: 0px;background-color:transparent;\"";if ($configuration->ladder == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";
	
	/*** messagerie ***/
	echo "<tr><td class=titlefiche>$strMessagerie :</td>";
	echo "<td class=textfiche>";
	echo "<input type=radio name=messagerie value=1 style=\"border: 0px;background-color:transparent;\"";if ($configuration->messagerie == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=messagerie value=0 style=\"border: 0px;background-color:transparent;\"";if ($configuration->messagerie == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";
	
	/*** support ***/
	echo "<tr><td class=titlefiche>$strSupport :</td>";
	echo "<td class=textfiche>";
	echo "<input type=radio name=support value=1 style=\"border: 0px;background-color:transparent;\"";if ($configuration->support == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=support value=0 style=\"border: 0px;background-color:transparent;\"";if ($configuration->support == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";
	
	/*** FAQ ***/
	echo "<tr><td class=titlefiche>$strFaq</td>";
	echo "<td class=textfiche>";
	echo "<input type=radio name=faq value=1 style=\"border: 0px;background-color:transparent;\"";if ($configuration->faq == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=faq value=0 style=\"border: 0px;background-color:transparent;\"";if ($configuration->faq == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";

	/*** serveur ***/
	echo "<tr><td class=titlefiche>$strServeurs :</td>";
	echo "<td class=textfiche>";
	echo "<input type=radio name=serveur value=1 style=\"border: 0px;background-color:transparent;\"";if ($configuration->serveur == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=serveur value=0 style=\"border: 0px;background-color:transparent;\"";if ($configuration->serveur == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";

	/*** download ***/
	echo "<tr><td class=titlefiche>$strDownloads :</td>";
	echo "<td class=textfiche>";
	echo "<input type=radio name=download value=1 style=\"border: 0px;background-color:transparent;\"";if ($configuration->download == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=download value=0 style=\"border: 0px;background-color:transparent;\"";if ($configuration->download == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";

	/*** Liens ***/
	echo "<tr><td class=titlefiche>$strLiens :</td>";
	echo "<td class=textfiche>";
	echo "<input type=radio name=liens value=1 style=\"border: 0px;background-color:transparent;\"";if ($configuration->liens == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=liens value=0 style=\"border: 0px;background-color:transparent;\"";if ($configuration->liens == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";

	/*** Galerie ***/
	echo "<tr><td class=titlefiche>$strGalerie :</td>";
	echo "<td class=textfiche>";
	echo "<input type=radio name=galerie value=1 style=\"border: 0px;background-color:transparent;\"";if ($configuration->galerie == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=galerie value=0 style=\"border: 0px;background-color:transparent;\"";if ($configuration->galerie == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";

	/*** Livre d'or ***/
	echo "<tr><td class=titlefiche>$strLivreDor :</td>";
	echo "<td class=textfiche>";
	echo "<input type=radio name=livredor value=1 style=\"border: 0px;background-color:transparent;\"";if ($configuration->livredor == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=livredor value=0 style=\"border: 0px;background-color:transparent;\"";if ($configuration->livredor == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";

	/*** sponsors ***/
	echo "<tr><td class=titlefiche>$strSponsors :</td>";
	echo "<td class=textfiche>";
	echo "<input type=radio name=sponsors value=1 style=\"border: 0px;background-color:transparent;\"";if ($configuration->sponsors == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=sponsors value=0 style=\"border: 0px;background-color:transparent;\"";if ($configuration->sponsors == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";


	/*** partenaires ***/
	echo "<tr><td class=titlefiche>$strPartenaires :</td>";
	echo "<td class=textfiche>";
	echo "<input type=radio name=partenaires value=1 style=\"border: 0px;background-color:transparent;\"";if ($configuration->partenaires == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=partenaires value=0 style=\"border: 0px;background-color:transparent;\"";if ($configuration->partenaires == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";


	/*** forum ***/
	echo "<tr><td class=titlefiche>$strForum :</td>";
	echo "<td class=textfiche>";
	echo "<input type=radio name=forum value=1 style=\"border: 0px;background-color:transparent;\"";if ($configuration->forum == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=forum value=0 style=\"border: 0px;background-color:transparent;\"";if ($configuration->forum == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";


	/*** contact ***/
	echo "<tr><td class=titlefiche>$strContact :</td>";
	echo "<td class=textfiche>";
	echo "<input type=radio name=contact value=1 style=\"border: 0px;background-color:transparent;\"";if ($configuration->contact == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=contact value=0 style=\"border: 0px;background-color:transparent;\"";if ($configuration->contact == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";

	/*** clock ***/
	echo "<tr><td class=titlefiche>$strHorloge :</td>";
	echo "<td class=textfiche>";
	echo "<input type=radio name=horloge value=1 style=\"border: 0px;background-color:transparent;\"";if ($configuration->horloge == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=horloge value=0 style=\"border: 0px;background-color:transparent;\"";if ($configuration->horloge == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";
	
	/*** commande  ***/
	echo "<tr><td class=titlefiche>$strAc_cmdmenu :</td>";
	echo "<td class=textfiche>";
	echo "<input type=radio name=commande value=1 style=\"border: 0px;background-color:transparent;\"";if ($configuration->commande == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=commande value=0 style=\"border: 0px;background-color:transparent;\"";if ($configuration->commande == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";
	
	/*** sondage *
	echo "<tr><td class=titlefiche>$strSondage :</td>";
	echo "<td class=textfiche>";
	echo "<input type=radio name=sondage value=1 style=\"border: 0px;background-color:transparent;\"";if ($configuration->sondage == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=sondage value=0 style=\"border: 0px;background-color:transparent;\"";if ($configuration->sondage == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";**/

	echo "<tr><td class=partfiche colspan=2>$strOptionsAvatars :</td></tr>";

	/*** avatar ***/
	echo "<tr><td class=titlefiche>$strAvatars :</td>";
	echo "<td class=textfiche>";
	echo "<input type=radio name=avatar value=A style=\"border: 0px;background-color:transparent;\"";if ($configuration->avatar == "A") echo " CHECKED";echo "> $strTous ";
	echo "<input type=radio name=avatar value=J style=\"border: 0px;background-color:transparent;\"";if ($configuration->avatar == "J") echo " CHECKED";echo "> $strJoueurs ";
	echo "<input type=radio name=avatar value=E style=\"border: 0px;background-color:transparent;\"";if ($configuration->avatar == "E") echo " CHECKED";echo "> $strEquipes ";
	echo "<input type=radio name=avatar value=N style=\"border: 0px;background-color:transparent;\"";if ($configuration->avatar == "N") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";

	/*** avatar upload ***/
	echo "<tr><td class=titlefiche width=33%>$strAvatarUpload :</td>";
	echo "<td class=textfiche>";
	echo "<input type=radio name=avatar_upload value=1 style=\"border: 0px;background-color:transparent;\"";if ($configuration->avatar_upload == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=avatar_upload value=0 style=\"border: 0px;background-color:transparent;\"";if ($configuration->avatar_upload == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";

	/*** avatar remote ***/
	echo "<tr><td class=titlefiche>$strAvatarRemote :</td>";
	echo "<td class=textfiche>";
	echo "<input type=radio name=avatar_remote value=1 style=\"border: 0px;background-color:transparent;\"";if ($configuration->avatar_remote == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=avatar_remote value=0 style=\"border: 0px;background-color:transparent;\"";if ($configuration->avatar_remote == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";

	/*** avatar gallerie ***/
	echo "<td class=titlefiche>$strAvatarGallerie :</td>";
	echo "<td class=textfiche>";
	echo "<input type=radio name=avatar_gallerie value=1 style=\"border: 0px;background-color:transparent;\"";if ($configuration->avatar_gallerie == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=avatar_gallerie value=0 style=\"border: 0px;background-color:transparent;\"";if ($configuration->avatar_gallerie == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";

	/*** avatar filesize ***/
	echo "<tr><td class=titlefiche>$strAvatarTailleMax :</td>";
	echo "<td class=textfiche><input type=text name=avatar_filesize_max value=\"$configuration->avatar_filesize_max\" size=5> $strOctets";
	echo "</td></tr>";

	/*** avatar dimensions ***/
	echo "<tr><td class=titlefiche>$strAvatarDimensionsMax :</td>";
	echo "<td class=textfiche><input type=text name=avatar_x_max value=\"$configuration->avatar_x_max\" size=5> x <input type=text name=avatar_y_max value=\"$configuration->avatar_y_max\" size=5> $strPixels";
	echo "</td></tr>";


	echo "<tr><td class=partfiche colspan=2\">$strOptionsIrc :</td></tr>";

	/*** irc ***/
	echo "<tr><td class=titlefiche>$strIrc :</td>";
	echo "<td class=textfiche>";
	echo "<input type=radio name=irc value=1 style=\"border: 0px;background-color:transparent;\"";if ($configuration->irc == "1") echo " CHECKED";echo "> $strOui ";
	echo "<input type=radio name=irc value=0 style=\"border: 0px;background-color:transparent;\"";if ($configuration->irc == "0") echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";

	/*** ircserver   ***/
	echo "<tr><td class=titlefiche width=33%>$strIrcServeur :</td>";
	echo "<td class=textfiche><input type=text name=ircserver value=\"$configuration->ircserver\" size=50>";
	echo "</td></tr>";

	/*** ircport ***/
	echo "<tr><td class=titlefiche>$strIrcPort :</td>";
	echo "<td class=textfiche><input type=text name=ircport value=\"$configuration->ircport\" size=5>";
	echo "</td></tr>";

	/*** ircpassword ***/
	echo "<tr><td class=titlefiche>$strIrcPassword :</td>";
	echo "<td class=textfiche><input type=password name=ircpassword value=\"$configuration->ircpassword\" size=20>";
	echo "</td></tr>";

	/*** ircchannels ***/
	echo "<tr><td class=titlefiche>$strIrcChannels :</td>";
	echo "<td class=textfiche><input type=text name=ircchannels value=\"$configuration->ircchannels\" size=50>";
	echo "</td></tr>";

	echo "<tr><td class=partfiche colspan=2\">$strOptionsMail :</td></tr>";

	/*** Mail ***/
	echo "<tr><td class=titlefiche>$strFonction :</td>";
	echo "<td class=textfiche>";
	echo "<input type=radio name=mail value='M' style=\"border: 0px;background-color:transparent;\"";if ($configuration->mail == 'M') echo " CHECKED";echo "> $strMail ";
	echo "<input type=radio name=mail value='S' style=\"border: 0px;background-color:transparent;\"";if ($configuration->mail == 'S') echo " CHECKED";echo "> $strSmtp";
	echo "<input type=radio name=mail value='N' style=\"border: 0px;background-color:transparent;\"";if ($configuration->mail == 'N') echo " CHECKED";echo "> $strNon";
	echo "</td></tr>";

	/*** smtpserver ***/
	echo "<tr><td class=titlefiche width=33%>$strSmtpServeur :</td>";
	echo "<td class=textfiche><input type=text name=smtpserver value=\"$configuration->smtpserver\" size=50>";
	echo "</td></tr>";

	/*** smtpuser ***/
	echo "<tr><td class=titlefiche>$strSmtpUser :</td>";
	echo "<td class=textfiche><input type=text name=smtpuser value=\"$configuration->smtpuser\" size=20>";
	echo "</td></tr>";

	/*** smtppassword ***/
	echo "<tr><td class=titlefiche>$strSmtpPassword :</td>";
	echo "<td class=textfiche><input type=password name=smtppassword value=\"$configuration->smtppassword\" size=20>";
	echo "</td></tr>";


	echo "<tr><td class=footerfiche align=center colspan=2><input type=submit value=\"$strModifier\"> <input type=button value=\"$strAnnuler\" onclick=back()></td></tr>";

	echo "</table>";
	echo "</td></tr></table>";
	echo "</td></tr></table>";
	echo "</form>";

	show_consignes($strConfigurationConsignes);

	echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";
}


?>

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
      +---------------------------------------------------------------------+
   | Correction: Gwenegan                            |
   +---------------------------------------------------------------------+
*/

// ASCII EDITED

// gestion des dates
define('DAY_POS','1'); // en fr, le position du jour est 1 => 27/xx/xxxx
define('MONTH_POS','2'); // en fr, le position du mois est 2 => xx/02/xxxx
define('YEAR_POS','3'); // en fr, le position de l'ann&eacute;e est 3 => xx/xx/2002

// date d'affichage
define('DATESTRING','%d/%m/%Y %H:%M');
define('DATESTRING1','%d/%m/%Y &agrave; %H:%M');
define('DATESTRING2','%d/%m/%Y');


$strPasDeTableau = "Pas de tableau";

$strJoueursConsignes = '<li>L\'inscription d&eacute;finitive d\'un joueur (passage de l\'&eacute;tat \'pr&eacute;-inscrit\' &agrave; l\'&eacute;tat \'inscrit\') est op&eacute;r&eacute;e par l\'admin sous r&eacute;serve de modalit&eacute;s administratives (paiement, etc).
<li>Seuls les joueurs \'inscrits\' peuvent participer &agrave; des tournois solo.';

$strEquipesConsignes = '<li>La validation d&eacute;finitive d\'une &eacute;quipe (passage de l\'&eacute;tat \'en attente\' &agrave; l\'&eacute;tat \'valid&eacute;e\') est op&eacute;r&eacute;e par l\'admin sous r&eacute;serve de modalit&eacute;s administratives (&eacute;quipe complete, joueurs TOUS inscrits, paiement, etc).
<li>Seules les &eacute;quipes \'valid&eacute;es\' peuvent participer &agrave; des tournois par &eacute;quipes.
<li>Le format de la colonne \'Inscrits\' est "nombre d\'inscrit - nombre de pr&eacute;inscrits"';

$strRapporterConsignes = '<li>Seuls les managers des 2 &eacute;quipes (ou les 2 joueurs solo) peuvent enregistrer OU valider le r&eacute;sultat d\'un match.
(Par exemple, le perdant rapporte le score, et le gagnant le valide ou le conteste)';


$strRejoindreEquipesConsignes = '<li>Les champs marqu&eacute;s  <font color=red>*</font> sont obligatoires.
<li>Veuillez demander le mot de passe au manager de votre &eacute;quipe pour pouvoir la rejoindre.';

$strHorairesTournoisConsignes = '<li>Le format de la date est "jj/mm/aaaa hh:mm" ou juste "hh:mm" pour aujourd\'hui.
<li>L\'affectation des dates ne sera effectu&eacute; que pour les matchs cach&eacute;s ou actifs.';

$strMapsTournoisConsignes = '<li>L\'affectation des maps ne sera effectu&eacute; que pour les matchs cach&eacute;s ou actifs.';

$strServeursTournoisConsignes = '<li>Les serveurs utilisables sont ceux d&eacute;finis dans l\'administration g&eacute;n&eacute;rale pour le jeu du tournoi en question.
<li>L\'affectation des serveurs ne sera effectu&eacute;e que pour les matchs cach&eacute;s ou actifs.';

$strAdminSponsorsConsignes = '<li>Les champs marqu&eacute;s  <font color=red>*</font> sont obligatoires.
<li>Les images des sponsors se trouvent dans le r&eacute;pertoire "images/sponsors".';

$strAdminLiensConsignes = '<li>Les champs marqu&eacute;s  <font color=red>*</font> sont obligatoires.
<li>Les images des liens se trouvent dans le r&eacute;pertoire "images/liens".';

$strAdminJeuxConsignes = '<li>Les champs marqu&eacute;s  <font color=red>*</font> sont obligatoires.
<li>Les images des jeux se trouvent dans le r&eacute;pertoire "images/jeux".';

$strIRCMessage = 'IRC (Internet Relay Chat) est un r&eacute;seau de discussion en temps r&eacute;el.<br /><br />
Vous avez la possibilit&eacute; de nous rejoindre sur le(s) channel(s) %chans% du serveur %serveur% par un logiciel client externe: <a href="irc://%serveur%/%chan%"><img src="images/icon_irc.gif" border="0" align="absmiddle"></a><br /><br />
ou<br /><br />
via l\'applet java directement int&eacute;gr&eacute; &agrave; ce site gr&agrave;ce au lien ci dessous:';

$strUploadFichierConsignes = '<li>Le champ marqu&eacute;  <font color=red>*</font>  est obligatoire.
<li>Taille maximum des fichiers: ';

$strRapporterResultats = 'Rapporter des r&eacute;sultats';
$strMatchAttenteResultats = 'Match en attente de r&eacute;sultat';
$strMatchAttenteValidation = 'Match en attente de validation';
$strTournoisEnCours = 'Tournois en cours';
$strTournoisTermines = 'Tournois termin&eacute;s';
$strValiderScore = 'Valider le score';
$strRefuserScore = 'Refuser le score';
$strValidation = 'Validation';
$strConflit = 'Conflit';
$strAssignerPoules = "Assigner suivant le classement des poules"; 
$strMethodeRandom = 'm&eacute;thode \'al&eacute;atoire\'';
$strMethodeSeed = 'm&eacute;thode \'seed&eacute;e\'';
$strMethodeCroise = 'm&eacute;thode \'crois&eacute;e\'';


$strPageDecharge = 'Page \'d&eacute;charge\'';
$strConditionsGenerales = "Conditions G&eacute;n&eacute;rales";
$strJeRefuse = 'Je refuse';
$strJAccepte = 'J\'accepte';
$strErreurMatchABPresent = 'Match dans la base de donn&eacute;e AB existant!';
$strErreurMatchM4Present = 'Match dans la base de donn&eacute;e M4 existant!';
$strRecupOk = "R&eacute;cup&eacute;ration OK!";
$strDans = 'dans';
$strAuto = 'Auto';
$strRecupMatchAuto = 'R&eacute;cup&eacute;ration automatique des matchs de ';
$strChangerElimination = 'Etes-vous s&ucirc;r de vouloir changer le type d\'arbre de ce tournoi ?';
$strConfirmDesincrireTeam = 'Etes-vous s&ucirc;r de vouloir d&eacute;sinscrire votre team de ce tournoi ?';
$strConfirmDesincrire = 'Etes-vous s&ucirc;r de vouloir vous d&eacute;sinscrire de ce tournoi ?';
$strSeDesinscrire = 'Se d&eacute;sinscrire';
$strDesinscrire = 'D&eacute;sinscrire';
$strAppletPJIRC = 'Applet java PJIRC';
$strPopup = 'Popup';
$strDevenirPartenaire = 'Devenir partenaire';
$strInscriptionsEquipes = 'Inscriptions &eacute;quipes';
$strInscriptionsJoueurs = 'Inscriptions joueurs';
$strInstall = 'Installation';
$strFloodDetect = 'Vous ne pouvez r&eacute;aliser cette op&eacute;ration que toutes les '.$config['flood_time'].' secondes';
$strErreurNbPlaces = 'Le nombre de place doit &ecirc;tre sup&eacute;rieur &agrave; 0';
$strErreurJoueurAppartient = 'Le joueur appartient d&eacute;ja &agrave; cette &eacute;quipe';
$strInscriptionsTournoisConsignes = '<li>Les inscriptions aux tournois ne sont possibles que si votre joueur/&eacute;quipe est inscrit/valid&eacute;e.';
$strRejoindreUneEquipe = 'Rejoindre une &eacute;quipe';
$strRejoindreCetteEquipe = 'Rejoindre cette &eacute;quipe';
$strPasswordRejoindre = 'Password<br />(pour rejoindre)';
$strPasDeFonctionMail = 'D&eacute;sol&eacute; mais la fonction de mail est d&eacute;sactiv&eacute;e';
$strContactMessageEmail = 'Ceci est un message de contact du site %nomsite% où';
$strInstallStage1 = 'Configuration des bases de donn&eacute;es';
$strInstallStage1Consignes = 'Veuillez saisir les param&egrave;tres de vos bases de donn&eacute;es';
$strInstallStage1Consignes2 = 'Cliquez ici pour configurer';
$strInstallStage2 = 'Configuration de phpTournois';
$strInstallStage2Consignes = 'Veuillez saisir le nom et l\'url de votre site et selectionner le type d\'install';
$strInstallStage2Consignes2 = 'Veuillez saisir le login et le mot de passe du compte administrateur';
$strInstallStage3 = 'F&eacute;licitation, phpTournois est correctement install&eacute;.';
$strInstallStage3Consignes = '<div align=left><blockquote>En utilisant phpTournois, vous devez savoir ce qu\'est un logiciel gratuit sous <b>licence GNU/GPL</b>.<br />
Vous vous engagez &agrave; respecter ce qui suit: <br />
<li> Logiciel gratuit ne veut en aucun cas dire que vous pouvez faire n\'importe quoi avec (condition 1)<br />
<li> Il est formellement interdit de retirer toute ou partie des lignes faisant r&eacute;f&eacute;rence &agrave; son concepteur (condition 2)<br />
<li> Plus g&eacute;n&eacute;ralement il est strictement <b>interdit de supprimer ou modifier les copyrights</b> (condition 3) En retirant ces lignes ou en les modifiant vous vous exposez &agrave; des poursuites judiciaires.<br />
<li> Vous <b>devez</b> publier les modifications que vous avez effectu&eacute;es sur le code (sur le forum par exemple) et l\'&eacute;quipe se r&eacute;serve le droit de les r&eacute;utiliser (condition 4)<br />
</blockquote></div>Consultez les fichiers INSTALL, README & LICENCE pour de plus amples informations.<br /><br />Cliquez ici pour aller &agrave; la page d\'accueil de votre site : <a href=index.php>GO !</a>';
$strInstallStage3DelInstall = 'Attention! le fichier install.php n\'a pu &ecirc;tre supprim&eacute;<br /><u>Pour la s&eacute;curit&eacute; de votre site</u> il est <u>imp&eacute;ratif</u> que vous alliez le supprimer manuellement';
$strFichierSqlManquant = 'Fichier SQL manquant';
$strPaypal = 'R&eacute;aliser un don pour ce site via PayPal est rapide, gratuit et s&eacute;curis&eacute; !';
$strPermissionInvalideConfigFile = 'Le fichier de configuration n\'a pas les droits d\'ecriture';
$strOuvertureInvalideConfigFile = 'Ouverture impossible du fichier de configuration';
$strEcritureInvalideConfigFile = 'Ecriture impossible du fichier de configuration';
$strPageDemarrage = 'Page de d&eacute;marrage';
$strDBHost = 'Nom du serveur Mysql';
$strDBUser = 'Utilisateur Mysql';
$strDBPass = 'Mot de passe Mysql';
$strDBName = 'Nom de la base Mysql';
$strDBPrefix = 'Pr&eacute;fixe des tables';
$strVersion = 'Version';
$strPasDeServeur = 'Pas de serveur';
$strPasDEquipe = 'Pas d\'&eacute;quipe';
$strPasDeJoueur = 'Pas de joueur';
$strPasDeTournoi = 'Pas de tournoi';
$strMoi = 'Moi';
$strMatchsTermines = 'Matchs termin&eacute;s';
$strMatchsCaches = 'Matchs cach&eacute;s';
$strElementsManagerInvalide = 'Manager invalide';
$strNouvelleEquipe = 'Nouvelle &eacute;quipe';
$strCachee = 'Cach&eacute;e';
$strCaches = 'Cach&eacute;s';
$strCachees = 'Cach&eacute;es';
$strLeader= 'Leader';
$strWarArranger = 'Waranger';
$strMembre = 'Membre';
$strRecrue = 'Recrue';
$strInactif = 'Inactif';
$strExMembre = 'Ex-membre';
$strModifierDownload = 'Modifier ce t&eacute;l&eacute;chargement';
$strModifierSponsors = 'Modifier ce sponsor';
$strModifierTournois = 'Modifier ce tournoi';
$strModifierLiens = 'Modifier ce lien';
$strModifierPartenaires = 'Modififer ce partenaire';
$strValide = 'Valide';
$strIncomplete = 'Incompl&egrave;te';
$strTableau = 'Tableau';
$strChangerStatusEquipe = 'Voulez-vous changer le statut de cette &eacute;quipe ?';
$strDonation = 'Donation';
$strYIM = 'YIM';
$strFonction = 'Fonction';
$strMail = 'Mail';
$strSmtp = 'Smtp';
$strSmtpServeur = 'Serveur';
$strSmtpUser = 'Utilisateur';
$strSmtpPassword = 'Password';
$strOptionsMail = 'Options Mail';
$strThemeDefaut = 'Th&egrave;me par d&eacute;faut';
$strMessageEnvoi = 'Le message a bien &eacute;t&eacute; envoy&eacute;.';
$strErreurMessageEnvoi = 'Le message n\'a pas pu &ecirc;tre envoy&eacute;.';
$strConfirmIncrireTeam = 'Etes-vous s&ucirc;r de vouloir inscrire votre team &agrave; ce tournoi ?';
$strConfirmSIncrire = 'Etes-vous s&ucirc;r de vouloir vous inscrire &agrave; ce tournoi ?';
$strPreInscription = 'Pr&eacute;-inscription';
$strEnAttente = 'En attente';
$strEquipeValidee = '&eacute;quipes valid&eacute;es';
$strEquipeEnAttente = '&eacute;quipes en attente';
$strValidee = 'Valid&eacute;e';
$strValidees = 'Valid&eacute;es';
$strAttenteMail = 'Attente Mail';
$strSteam = 'Steam';
$strPartenaires = 'Partenaires';
$strWWW = 'Web';
$strAvatar = 'Avatar';
$strAvatars = 'Avatars';
$strModifierAvatar = 'Modifier l\'avatar';
$strConfirmEffacerAvatar = 'Effacer cet avatar?';
$strCreerEquipe = 'Cr&eacute;er une &eacute;quipe';
$strPageGeneree = 'Page g&eacute;n&eacute;r&eacute;e en';
$strSecondes = 'secondes';
$strAvatarUploadLocal = 'Envoyer un avatar local';
$strAvatarUploadRemote = 'Envoyer un avatar distant';
$strAvatarLienRemote = 'Lier un avatar distant';
$strSousCategories = 'Sous cat&eacute;gories';
$strPermissionInvalide = 'Permissions invalides';
$strGalerieInconnue = 'Galerie inconnue';
$strGalerie = 'Galerie';
$strPasDImage = 'Pas d\'image';
$strImageInconnue = 'Image inconnue';
$strImages = 'Images';
$strGDAbsent = 'GD absente sur ce serveur';
$strExtensionNonSupporte = 'Extension non support&eacute;e';
$strNewsEnvoiSubject = '[%nomsite%] Nouveaut&eacute; !';
$strNewsEnvoiMessage = 'Voici une nouvelle en provenance du site <b>%nomsite%</b> qui pourrait vous int&eacute;resser : <br /><br />%link%';
$strNewsEnvoiConfirm = 'Un email vient d\'&ecirc;tre envoy&eacute; &agrave; votre ami !';
$strEnvoyerNews = 'Envoyer cette news';
$strVotreEmail = 'Votre email';
$strSonEmail = 'Email du destinataire';
$strOptionsAvatars = 'Options avatars';
$strAvatarUpload = 'Envoi d\'avatars';
$strAvatarRemote = 'Avatar distant';
$strAvatarGallerie = 'Galerie d\'avatars';
$strAvatarTailleMax = 'Taille maximale';
$strAvatarDimensionsMax = 'Dimensions maximales';
$strPixels = 'pixels';
$strVoirGallerie = 'Voir la galerie';
$strElementsEmailExistant = 'Email existant';
$strAvatarErreurUrl = 'L\'URL sp&eacute;cifi&eacute;e n\'est pas correcte !';
$strAvatarErreurConnexion = 'Le serveur n\'a pas pu se connecter &agrave; l\'URL pour la t&eacute;l&eacute;charger !';
$strAvatarErreurData = 'L\'URL sp&eacute;cifi&eacute;e ne contient pas les bonnes donn&eacute;es !';
$strAvatarErreurWrite = 'Impossible d\'&eacute;crire l\'image sur le serveur !';
$strAvatarErreurFileSize = 'La taille du fichier de l\'image est incorrecte ';
$strAvatarErreurFileType = 'Le type d\'image n\'est pas support&eacute; ';
$strAvatarErreurXYSize = 'Les dimensions de l\'image sont incorrectes ';
$strEnLigne = 'En ligne';
$strAdminsEnLigne = 'Admins en ligne';
$strPublicEnLigne = 'Public en ligne';
$strQuiEnLigne = 'Qui est en ligne';
$strVisiteurs = 'Visiteurs';
$strMembres = 'Membres';
$strTotal = 'Total';
$strSans = 'Sans';
$strArticleDuSite = 'Cet article provient du site';
$strURLArticle = 'L\'URL pour cet article est';
$strSeRappeler = 'Se Rappeler';
$strNvPassIdent = 'Les nouveaux mots de passes doivent &ecirc;tre identiques!';
$strResetPass = 'Reset du mot de passe';
$strOubliPass = 'Mot de passe oubli&eacute; ?';
$strEnvoiPass = 'Envoi du mot de passe par mail';
$strCodeConfirmation = 'Code de confirmation';
$strElementsJoueurInvalide = 'Joueur invalide';
$strElementsEquipeInvalide = 'Equipe invalide';
$strElementsCodeInvalide = 'Code invalide';
$strPasswordEmailCode = '[%nomsite%] Code pour le nouveau mot de passe';
$strPasswordEmailCodeMessage = 'Vous avez demandez l\'envoi d\'un nouveau mot de passe.<br /><br />Voici le code que vous devez rentrer en dessous de votre pseudo : <b>%code%</b><br /><br />PS: si vous n\'etes pas &agrave; l\'origine de cette demande, ignorez ce mail!';
$strPasswordMessageCode = 'Le code pour l\'envoi du nouveau mot de passe vous a &eacute;t&eacute; envoy&eacute; par mail!';
$strPasswordEmail = '[%nomsite%] Nouveau mot de passe';
$strPasswordEmailMessage = 'Voici le nouveau mot de passe pour votre compte : <b>%passwd%</b><br /><br />N\'oubliez pas de vous connecter pour le changer!';
$strPasswordMessage = 'Votre nouveau mot de passe vous a &eacute;t&eacute; envoy&eacute; par mail!';
$strPasswordMessageAdmin = 'Le nouveau mot de passe est : <b>%passwd%</b><br /><br />Il a &eacute;t&eacute; aussi envoy&eacute; par mail &agrave; la personne concern&eacute;e!';
$strPasswordEnvoiConsignes = '<li>Entrez votre pseudo et cliquez sur le bouton envoyer. Un email automatique avec votre code de confirmation vous sera envoy&eacute;. <li>R&eacute;-entrez ensuite votre pseudo et votre code de confirmation et vous recevrez votre nouveau mot de passe par email.';
$strAdminPartenaires = 'Administration des partenaires';
$strAjouterPartenaire = 'Ajouter un partenaire';
$strConfirmEffacerPartenaire = 'Effacer ce partenaire ?';
$strPartenaireDepuisLe = 'Partenaire depuis le';
$strPasDePartenaires = 'Pas de partenaire';
$strPasDeSponsor = 'Pas de sponsor';
$strSponsor = 'Sponsor';
$strEnSavoirPlus = 'En savoir plus...';
$strSite = 'Site';
$strSuite = 'Suite...';
$strCategories = 'Cat&eacute;gories';;
$strPetite = 'petite';
$strGrande = 'grande';
$strErreur404 = 'Erreur 404';
$strErreur404Explain = 'La page que vous avez demand&eacute;e n\'est pas accessible...';
$strLoguePourPoster = 'Par mesure de s&eacute;curit&eacute;, vous devez &ecirc;tre identifi&eacute; pour poster un commentaire';
$strMatchInvalide = 'Match invalide !';
$strCommentairesMatch = 'Commentaires du match';
$strModeCommentaire = 'Commentaires';
$strPasDeCommentaire = 'Pas de commentaire';
$strConfirmEffacerFile = 'Effacer ce fichier ?';
$strAjouteLe = 'Ajout&eacute; le';
$strFichier = 'Fichier';
$strFichierInvalide = 'Fichier invalide';
$strUploaderFichier = 'Uploader un fichier dans ';
$strParticipePourPoster = 'Vous devez &ecirc;tre membre d\'une des 2 &eacute;quipes ou un joueur de ce match pour pouvoir poster des commentaires.';
$strManagerPourUploader = 'Vous devez &ecirc;tre le manager d\'une des 2 &eacute;quipes ou un des joueur de ce match pour pouvoir poster des fichiers.';

$strTournoisParticipe = 'Participe aux tournois';
$strTournoisAParticipe = 'A particip&eacute; aux tournois';
$strModeMatchScore = 'Mode Matchs';
$strFragAverage = 'Points marqu&eacute;s';
$strRoundAverage = 'Manches gagn&eacute;es';
$strRoundAverageFragAverage = 'Manches puis points';


$PHPMAILER_LANG = array();
$PHPMAILER_LANG["provide_address"] = 'Vous devez sp&eacute;cifier au moins une adresse de destination.';
$PHPMAILER_LANG["mailer_not_supported"] =  'ce mailer n\'est pas support&eacute;';
$PHPMAILER_LANG["execute"] = 'Ne peut pas ex&eacute;cuter: ';
$PHPMAILER_LANG["instantiate"] = 'La fonction mail n\'est pas activ&eacute;e dans votre php.';
$PHPMAILER_LANG["authenticate"] = 'Erreur d\'autentification SMTP.';
$PHPMAILER_LANG["from_failed"] = 'L\'adresse suivante est invalide: ';
$PHPMAILER_LANG["recipients_failed"] = 'Erreur SMTP: l\'adresse suivante est invalide: ';
$PHPMAILER_LANG["data_not_accepted"] = 'Erreur SMTP: les donn&eacute;es n\'ont pas &eacute;t&eacute; accept&eacute;es.';
$PHPMAILER_LANG["connect_host"] = 'Erreur SMTP: impossible de se connecter au serveur.';
$PHPMAILER_LANG["file_access"] = 'Fichier attach&eacute; non accessible: ';
$PHPMAILER_LANG["file_open"] = 'Fichier attach&eacute; non accessible: ';
$PHPMAILER_LANG["encoding"] = 'Encodage inconnu: ';





$strM4Admin = 'Interface M4';
$strABAdmin = 'Interface AdminBot';
$strModeFichier = 'Fichiers attach&eacute;s';
$strValidationEmail = 'Validation Email';
$strA = '&agrave;';
$strAEcrit = 'a &eacute;crit';
$strAIM = 'AIM';
$strAccueil = 'Accueil';
$strActif = 'Actif';
$strActivationInvalide = 'Activation impossible';
$strActiverMatch = 'Activer les matchs';
$strAdmin = 'Administration';
$strAdminBot= 'AdminBot-MX';
$strAdminDownloads = 'Administration des downloads';
$strAdminEquipes = 'Administration des Equipes';
$strAdminFinales = 'Administration des Finales';
$strAdminHoraires = 'Administration des horaires';
$strAdminJeux = 'Administration des Jeux';
$strAdminJoueurs = 'Administration des Joueurs';
$strAdminLiens = 'Administration des liens';
$strAdminLivreDor = 'Administration du Livre d\'or';
$strAdminMaps = 'Administration des Maps';
$strAdminMatchsPoules = 'Administration des matchs de poules';
$strAdminNews = 'Administration des news';
$strAdminPoules = 'Administration des Poules';
$strAdminServeurs = 'Administration des Serveurs';
$strAdminSponsors = 'Administration des Sponsors';
$strAdminTournois = 'Administration des Tournois';
$strAdministrateur = 'Admin';
$strAdministrateursTournois = 'Administrateurs des Tournois';
$strAdmins = 'Admins';
$strAdresse = 'Adresse';
$strAge = 'Age';
$strAjouter = 'Ajouter';
$strAjouterCommentaire = 'Ajouter un commentaire';
$strAjouterEquipe = 'Ajouter une &eacute;quipe';
$strAjouterFichier = 'Ajouter un fichier';
$strAjouterJeu = 'Ajouter un jeu';
$strAjouterJoueur = 'Ajouter un joueur';
$strAjouterLien = 'Ajouter un lien';
$strAjouterMap = 'Ajouter une map';
$strAjouterNews = 'Ajouter une news';
$strAjouterServeur = 'Ajouter un serveur';
$strAjouterSignature = 'Ajouter une signature';
$strAjouterSponsor = 'Ajouter un sponsor';
$strAjouterTournois = 'Ajouter un tournoi';
$strAleatoire = 'Al&eacute;atoire';
$strAllowJoinTeam='Autorise d\'&ecirc;tre ajouter &agrave; une &eacute;quipe';
$strAllowPrivateMessage='Autorise de recevoir des MP publique';
$strAn = 'ans';
$strAncienPass = 'Ancien mot de passe';
$strAncienPassInvalid = 'Ancien mot de passe invalide';
$strAnnuler = 'Annuler';
$strAssignerAleatoirement = 'Assigner aleatoirement';
$strAssignerInscriptionSeed = 'Assigner suivant le seed d\'inscription';
$strAutoajoutTeam='Disponibilit&eacute;';
$strAutoMp='Messagerie';
$strAutoStart= 'AutoStart';
$strAutorefresh = 'Auto-refresh';
$strAutoscroll = 'Auto-scroll';
$strAvecDemo = 'd&eacute;mo';
$strAvg = 'Avg';
$strBLACK = 'Noir';
$strBLUE = 'Bleu';
$strBROWN = 'Marron';
$strCYAN = 'Cyan';
$strCache = 'Cach&eacute;';
$strCalendrier = 'Calendrier';
$strCalendrierMatchs = 'Calendrier des matchs';
$strCamps = 'Camps';
$strManager = 'Manager';
$strManagers='Managers';
$strCartegraphique = 'Carte Graphique';
$strCategorie = 'Cat&eacute;gorie';
$strCentrer = 'Centr&eacute;';
$strChampionnat = 'Championnat';
$strChangerDevise = 'Changer la devise';
$strChangerFinales = 'Etes-vous s&ucirc;r de vouloir changer le d&eacute;but des finales ? \n\n(ATTENTION, cette op&eacute;ration efface enti&egrave;rement l\\\'arbre)';
$strChangerLooser = 'Etes-vous s&ucirc;r de vouloir changer le d&eacute;but du looser ? \n\n(ATTENTION, cette op&eacute;ration efface enti&egrave;rement l\\\'arbre du looser)';
$strChangerPoules = 'Etes-vous s&ucirc;r de vouloir changer le nombre de poules ? \n\n(ATTENTION, cette op&eacute;ration efface tous les matchs de poules)';
$strChangerStatusTournois = 'Etes-vous s&ucirc;r de vouloir changer le statut du tournois ? \n(ATTENTION, cette op&eacute;ration n\\\'est recommand&eacute;e que pour les p0wer-admins)';
$strChangerStatusJoueur = 'Etes-vous s&ucirc;r de vouloir le statut de ce joueur ?';
$strChangerStatusParticipe = 'Etes-vous s&ucirc;r de vouloir changer le statut de ce participant ?\n\n(ATTENTION cette op&eacute;ration modifie les matchs et les arbres)';
$strChercherJoueur = 'Chercher un joueur';
$strChoisirAuHasard = 'Choisir au hasard';
$strCloturerInscriptions = 'Clôturer les inscriptions ?';
$strCloturerLesInscriptions = 'Etes-vous s&ucirc;r de vouloir clôturer les inscriptions ?';
$strCode = 'Code';
$strCodePostal = 'CP';
$strCocheforwrite1 = 'R&eacute;-&eacute;crire le fichier config.php ?';
$strCocheforwrite2 = 'R&eacute;-&eacute;crire le fichier config.m4.php ?';
$strCocheforwrite3 = 'R&eacute;-&eacute;crire le fichier config.ab.php ?';
$strColorerCode='Afficher le code syntax&eacute;';
$strCommentaires = 'Commentaires';
$strConfiguration = 'Configuration';
$strConfirm = 'Confirmation';
$strConfirmEffacerCommentaire = 'Effacer ce commentaire ?';
$strConfirmEffacerDownload = 'Effacer ce download ?';
$strConfirmEffacerEquipe = 'Effacer cette &eacute;quipe ?';
$strConfirmEffacerJeux = 'Effacer ce jeux ?';
$strConfirmEffacerJoueur = 'Effacer ce joueur ?';
$strConfirmEffacerLien = 'Effacer ce lien ?';
$strConfirmEffacerMap = 'Effacer cette map ?';
$strConfirmEffacerMessage = 'Effacer ce message ?';
$strConfirmEffacerNews = 'Effacer cette news ?';
$strConfirmEffacerServeur = 'Effacer ce serveur ?';
$strConfirmEffacerSignature = 'Effacer cette signature ?';
$strConfirmEffacerSponsor = 'Effacer ce sponsor ?';
$strConfirmEffacerTournois = 'Effacer ce tournoi ?';
$strConnecte = 'Connect&eacute;';
$strConnecter = 'Se connecter';
$strConnexion = 'Connexion';
$strConnexionImpossible = 'Connexion &agrave; la base de donn&eacute;es impossible!';
$strConsignes = 'Consignes';
$strContact = 'Contact';
$strContactDown = "<u>ClubRezo</u><br />Ecole Polytechnique de l'Universit&eacute; de Nantes<br />rue Christian Pauc<br />44300 Nantes<br />Email : <a href=\"mailto: $config[emailcontact]\"><b><u>$config[emailcontact]</u></b></a>";
$strContactUp = 'Pour nous contacter, vous pouvez utiliser votre client mail favori <a href="mailto: %email%"><img src="images/icon_email.gif" border="0" align="absmiddle"></a> ou remplir le formulaire ci dessous:';
$strContenu = 'Contenu';
$strCouleur = 'Couleur';
$strCoupe = 'Coupe';
$strCreationImpossible = 'Cr&eacute;ation de la base phpTournois impossible!';
$strCreer = 'Cr&eacute;er';
$strCustTheme = 'S&eacute;lecteur de th&egrave;mes';
$strDARKBLUE = 'Bleu fonc&eacute;';
$strDARKED = 'Rouge fonc&eacute;';
$strDate = 'Date';
$strDe = 'De';
$strDeconnexion = 'D&eacute;connexion';
$strDerniersTitres = 'Derniers titres';
$strDescription = 'Description';
$strDestinataire = 'Destinataire';
$strDestinataires = 'Destinataires';
$strDevise = 'Devise';
$strDispute = 'Dispute';
$strDisqualifie = 'Disqualifi&eacute;';
$strDotations = 'Dotations';
$strDoubleElimination='Double';
$strDownloads = 'Downloads';
$strE = 'E';
$strEMail = 'E-Mail';
$strEcrireMessage = 'Ecrire un message';
$strEditerJoueur='Editer le status du joueur';
$strEffacer = 'Effacer';
$strEditer = 'Editer';
$strElementsAdresseInvalide = 'Adresse invalide';
$strElementsAgeInvalide = 'Age invalide';
$strElementsAuteurInvalide = 'Auteur invalide';
$strElementsCatInvalide = 'Ordre invalide';
$strElementsContenuInvalide = 'Contenu invalide';
$strElementsDescriptionInvalide = 'Description invalide';
$strElementsDestinataireInvalide = 'Destinataire invalide';
$strElementsEmailInvalide = 'Email invalide';
$strElementsEquipeExistante = 'Equipe existante';
$strElementsFinalesInvalides = 'Finales \'Winner\' du tournoi invalides';
$strElementsFinalesLooserInvalides = 'Finales \'Looser\' du tournoi invalides';
$strElementsIconeInvalide = 'Icone invalide';
$strElementsImageInvalide = 'Image invalide';
$strElementsIncorects = 'Un ou plusieurs &eacute;l&eacute;ments sont incorrects';
$strElementsJeuxInvalide = 'Jeu invalide';
$strElementsJoueurExistant = 'Joueur existant';
$strElementsServerNameInvalide='Nom du serveur Invalide';
$strElementsServerIpInvalide='IP du serveur invalide';
$strElementsNewsInvalide = 'News invalide';
$strElementsNomInvalide = 'Nom invalide';
$strElementsOrigineInvalide = 'Origine invalide';
$strElementsPasswordInvalide = 'Password invalide';
$strElementsPortInvalide = 'Port invalide';
$strElementsPoulesInvalides = 'Poules du tournoi invalides';
$strElementsPrenomInvalide = 'Pr&eacute;nom invalide';
$strElementsPseudoInvalide = 'Pseudo invalide';
$strElementsSigleInvalide = 'Sigle invalide';
$strElementsTagInvalide = 'Tag invalide';
$strElementsTailleInvalide = 'Taille invalide';
$strElementsTitreInvalide = 'Titre invalide';
$strElementsUrlInvalide = 'URL invalide';
$strElementsVilleInvalide = 'Ville invalide';
$strEmailContact = 'Email de contact';
$strEmailInscription = 'Email d\'inscription';
$strEmetteur = 'Emetteur';
$strEnCours = 'En Cours';
$strEnvoyer = 'Envoyer';
$strEquipe = 'Equipe';
$strEquipes = 'Equipes';
$strEquipesInscrits = 'Equipes inscrites';
$strErreur = 'Erreur';
$strErreurDeSaisie = 'Erreur de saisie !';
$strErreurEquipeManquante = 'Equipes manquantes';
$strErreurLogin = 'Erreur d\'authentification!';
$strErreurMancheActive = 'Pas de manche active! Au moins une manche doit &ecirc;tre cr&eacute;&eacute;e et activ&eacute;e.';
$strErreurMapManquante = 'Map manquante!';
$strErreurMatchABManquant = 'Match dans la base de donn&eacute;e AB manquant!';
$strErreurMatchM4Manquant = 'Match dans la base de donn&eacute;e M4 manquant!';
$strErreurPremiereManche = 'Absence de 1&egrave;re manche active! Veuillez cr&eacute;er et activer au moins une manche pour ce match.';
$strErreurServeurManquant = 'Serveur manquant!';
$strErreurStatusActif = 'Mauvais statut! ce match doit &ecirc;tre activ&eacute; pour pouvoir d&eacute;marrer.';
$strErreurStatusCache = 'Mauvais statut! ce match doit &ecirc;tre cach&eacute; pour &ecirc;tre activ&eacute;.';
$strErreurStatusDemarre = 'Mauvais statut! ce match doit &ecirc;tre d&eacute;marr&eacute; pour pouvoir &ecirc;tre r&eacute;cup&eacute;r&eacute;.';
$strEtat = 'Etat';
$strFiche = 'Fiche';
$strFichiersAttaches = 'Fichiers attach&eacute;s';
$strFichiersAttachesMatch = 'Fichiers attach&eacute;s au match';
$strFinale = 'Finale';
$strFinales = 'Finales';
$strFinalesType = 'Elimination';
$strForfait = 'Forfait';
$strForum = 'Forum';
$strFrags = 'Frags';
$strG = 'G';
$strGREEN = 'Vert';
$strGagne = 'Gagne';
$strGeneral = 'Menu principal';
$strGenerationFinales = 'Validation finales';
$strGenerationPoules = 'Validation poules';
$strGrandFinal = 'Grande Finale';
$strGras = 'Gras';
$strGzip = 'Compression Gzip';
$strHidemenu = 'Hide-menu';
$strHistoriqueNews = 'Historique des news';
$strHits = 'Hits';
$strHoraires = 'Horaires';
$strHorloge = 'Horloge';
$strICQ = 'ICQ';
$strINDIGO = 'Indigo';
$strIp = 'IP';
$strIcone = 'Icone';
$strImage = 'Image';
$strInformations = 'Informations';
$strInscriptionConfirmMessage = 'Votre inscription vient d\'&ecirc;tre prise en compte<br />Vous aller recevoir un email de confirmation contenant un lien d\'activation.<br /><br />A Bientôt, et good frags!!<br /><br />L\'&eacute;quipe organisatrice.';
$strInscriptionConfirmMessageOK = 'Votre inscription est effective<br /><br />N\'oubliez pas de nous faire parvenir les modalit&eacute;s de l\'inscription<br /><br />Vous pouvez vous connecter dans votre espace personnel et configurer votre &eacute;quipe si vous &ecirc;tes le manager<br /><br />A Bientôt, et good frags!!<br /><br />L\'&eacute;quipe organisatrice.';
$strInscriptionConfirmMessageEmail = 'Merci de vous &ecirc;tre inscris &agrave; la \'%nomsite%\'.<br /><br />N\'oubliez pas vos identifiants ci-dessous, ils vous permettront de vous connecter ult&eacute;rieurement:<br />------------------<br /> Login : <b>%login%</b><br /> Pass: <b>%password%</b><br />------------------<br /><br /><font color=red>ATTENTION, cliquez sur le lien pour valider votre enregistrement</font>: %link%<br /><br />Veuillez noter votre mot de passe car, crypt&eacute; dans la base de donn&eacute;es, il ne pourra pas &ecirc;tre r&eacute;cup&eacute;r&eacute;. Vous pourrez cependant en demander un nouveau.<br /><br />A Bientot, et good frags!!<br /><br />L\'&eacute;quipe organisatrice.<br /><br />';
$strInscriptionConfirmSubjectEmail = '[%nomsite%] Confirmation de la pr&eacute;-inscription';
$strInscriptionMessage = 'Votre inscription vient d\'&ecirc;tre prise en compte<br />N\'oubliez pas vos identifiants ci dessous:<br />Login : <b>%login%</b><br />Pass: <b>%password%</b><br /><br />Vous pouvez vous connecter dans votre espace personnel et configurer votre &eacute;quipe si vous &ecirc;tes le manager<br /><br />Veuillez noter votre mot de passe car, crypt&eacute; dans la base de donn&eacute;es, il ne pourra pas &ecirc;tre r&eacute;cup&eacute;r&eacute;. Vous pourrez cependant en demander un nouveau.<br /><br />A Bientôt, et good frags!!<br /><br />L\'&eacute;quipe organisatrice.';
$strInscriptions = 'Inscriptions';
$strInscrire = 'Inscrire';
$strInscrit = 'Inscrit';
$strInscrite = 'Inscrite';
$strInscrits='Inscrits';
$Installtype='Type d\'installation :';
$Installtype2 ='Choix du type d\'installation';
$strIrc = 'Irc';
$strIrcChannels = 'Channels';
$strIrcPassword = 'Password';
$strIrcPort = 'Port';
$strIrcServeur = 'Serveur';
$strItalique = 'Italique';
$strJ = 'J';
$strJeu = 'Jeu';
$strJeux = 'Jeux';
$strJoin = 'Rejoindre';
$strJoinAvecHlla = "Pour rejoindre un serveur avec le lien '$strJoin', vous devez t&eacute;l&eacute;charger .hlla <a href=\"downloads/hlla0704.exe\">>ici<</a> ou sur <a href=\"http://www.hlla.net\" target=_blank><span style=\"vertical-align: middle;\"><img src=images/hlla.gif align=absmidlle border=0></span></a> et l'installer";
$strJoueur = 'Joueur';
$strJoueurs = 'Joueurs';
$strJoueursInscrits = 'Joueurs inscrits';
$strJoueursPreinscrit = 'Joueurs pr&eacute;-inscrits';
$strKOctets = 'Ko';
$strLan = 'Lan';
$strLancerMatch = 'Lancer les matchs';
$strLancerMatchAB = 'Lancer les matchs AdminBot-MX';
$strLancerMatchM4 = 'Lancer les matchs M4';
$strLangue = 'Langue';
$strLangueDefaut = 'Langue d&eacute;faut';
$strLe = 'le';
$strLeaveTeam='Quitter cette &eacute;quipe';
$strLeaveTeamALERT='Souhaitez-vous vraiment quitter cette &eacute;quipe ?';
$strLeaveTeambody1='Bonjour,\nNous vous informons que le membre de votre &eacute;quipe : ';
$strLeaveTeambody2='\n\nA quitt&eacute; d&eacute;lib&eacute;r&eacute;ment votre &eacute;quipe.\n\nMerci de votre attention.';
$strLeaveTeambodyM1='Bonjour,\nNous vous informons que le manager de l\'&eacute;quipe : ';
$strLeaveTeambodyM2='\n\nVous a supprim&eacute; des membres son &eacute;quipe.\n\nMerci de votre attention.';
$strLeaveTeamM='Vous ne pouvez quitter l\'&eacute;quipe tant que vous en &ecirc;tes le manager';
$strLeaveTeamtitle='A quitt&eacute; votre &eacute;quipe !';
$strLeaveTeamtitleManager='Votre manager vous &agrave; supprim&eacute; de son &eacute;quipe';
$strLiens = 'Liens';
$strLireMessage = 'Boite aux lettres';
$strListe = 'Liste';
$strLivreDor = 'Livre d\'or';
$strLogin = 'Login';
$strLogo = 'Logo';
$strLooser = 'Looser';
$strM4 = 'M4';
$strM4ID = 'Clan #';
$strMOctets = 'Mo';
$strMSN = 'MSN';
$strMaFiche = 'Ma fiche';
$strMailing = 'Mailing';
$strMailNotconfig = 'Server SMTP ind&eacute;finie ou user ind&eacute;finie';
$strMaintenance = 'Maintenance';
$strManche = 'manche';
$strManchesMax = 'Nombre Manches';
$strManuel = 'Manuel';
$strMap = 'Map';
$strMaps = 'Maps';
$strMatch = 'Match';
$strMatchs = 'Matchs';
$strMatchsActifs = 'Matchs pr&eacute;vus';
$strMatchsEnCours = 'Matchs en cours';
$strMatchsFinales = 'Phases finales';
$strMatchsPoules = 'Matchs de poules';
$strMemoire = 'M&eacute;moire';
$strMesEquipes = 'Mes &eacute;quipes';
$strMessage = 'Message';
$strMessageLu = 'Messages d&eacute;j&agrave; lus ';
$strMessageNouveau = 'Nouveaux messages';
$strMessagerie = 'Messagerie';
$strMinutes = 'minutes';
$strMode = 'Mode';
$strModeEquipe = 'Mode Equipes';
$strModeInscription='Mode Inscriptions';
$strModeScore = 'Mode Score';
$strModifPass = 'Modifier le mot de passe';
$strModifier = 'Modifier';
$strModifierConfiguration = 'Modifier la configuration';
$strModifierNews = 'Modifier la news';
$strModifierServeur = 'Modifier ce serveur';
$strMods_ladder = 'PC admin des Ladders';
$strMODSPANEL = 'Panel admin des Mods phpT install&eacute;s';
$strModsProfil = 'Mod Affichage Profil';
$strMODDiver = 'Mods Divers';
$strMonEquipe = 'Mon &eacute;quipe';
$strN = 'N';
$strNA = 'N/A';
$strNbLooser = 'D&eacute;but Looser';
$strNbPlaces = 'Nombre de places';
$strNbPoules = 'Nombre Poules';
$strNbWinner = 'D&eacute;but Finales';
$strNews = 'News';
$strNewseur = 'Newseur';
$strNewseurs='Newseurs';
$strNoData = 'Aucune donn&eacute;e n\'est encore enregistr&eacute;e';
$strNom = 'Nom';
$strNomTournois = 'Nom du tournoi';
$strNon = 'Non';
$strNouveauJoueur = 'Nouveau joueur';
$strNouveauPass = 'Nouveau mot de passe';
$strNul = 'Nul';
$strOK = 'OK';
$strOLIVE = 'Olive';
$strORANGE = 'Orange';
$strOctets = 'octets';
$strOptions = 'Options';
$strOptionsIrc = 'Options IRC';
$strOrigine = 'Origine';
$strOui = 'Oui';
$strP = 'P';
$strPageDotations = 'Page \'Dotations\'';
$strPageInformations = 'Page \'Informations\'';
$strPageNotlist = 'Vous n\'avez encore aucune rubrique';
$strPageNotlist2 = 'Vous n\'avez encore aucun menu';
$strPagePresentation = 'Page \'pr&eacute;sentation\'';
$strPageReglement = 'Page \'r&eacute;glement\'';
$strPageStats = 'Page \'statistiques\'';
$strPagesVues = 'Pages vues';
$strParticipants = 'Participants';
$strParticipe = 'Participe';
$strPasConnecte = 'Non connect&eacute;';
$strPasDInformation ='Pas d\'information disponible';
$strPasDeContact = 'Pas de contact';
$strPasDeDotation = 'Pas de dotation disponible';
$strPasDeDownload = 'Pas de download';
$strPasDeFichier = 'Pas de fichier';
$strPasDeLien = 'Pas de lien';
$strPasDeMatch = 'Pas de matchs';
$strPasDeMessage = 'Pas de message';
$strPasDeNews = 'Pas de news disponible';
$strPasDeReglement = 'Pas de r&eacute;glement disponible';
$strPasDeSignature = 'Pas de signature';
$strPassword = 'Password';
$strPCMODS = 'Configurer les mods';
$strPerdu = 'Perdu';
$strPhaseFinales = 'Phases Finales';
$strPhasePoules = 'Matchs de Poules';
$strphpt_type = 'Type d\'utilisation de phpTournois';
$strPing = 'Ping';
$strPolice = 'Police';
$strPort = 'Port';
$strPostePar = 'Post&eacute; par';
$strPoule = 'Poule';
$strPoules = 'Poules';
$strPreinscrit = 'Pr&eacute;-inscrit';
$strPreinscrits='Pr&eacute;-inscrits';
$strPrenom = 'Pr&eacute;nom';
$strPresentation = 'Pr&eacute;sentation';
$strProcesseur = 'Processeur';
$strProlongation = 'Prolongations';
$strPseudo = 'Pseudo';
$strPts = 'Pts';
$strPublierServeurDans = 'Publier dans';
$strQstatProtocole= 'Protocole Qstat';
$strQuitter = 'Quitter';
$strQuote = 'Citation';
$strRED = 'Rouge';
$strRang = 'Rang';
$strRecupMatchAB = 'R&eacute;cup&eacute;rer les matchs AdminBot-MX';
$strRecupMatchM4 = 'R&eacute;cup&eacute;rer les matchs M4';
$strRedigerMessage = 'R&eacute;diger un nouveau message';
$strRegle = 'R&egrave;gle';
$strReglement = 'R&eacute;glement';
$strRemettreAZero = 'Remettre a z&eacute;ro';
$strRepondre = 'R&eacute;pondre';
$strRepondreMessage = 'R&eacute;pondre &agrave; un message';
$strResultats = 'R&eacute;sultats';
$strResultatsFinales = 'R&eacute;sultats des phases finales';
$strResultatsMatchsPoules = 'R&eacute;sultats des matchs de poules';
$strResultatsPoules = 'R&eacute;sultats des poules';
$strRetour = 'Retour';
$strRule= 'R&egrave;gles';
$strS = 'X';
$strSInscrire = 'S\'inscrire';
$strSansDemo = 'sans donn&eacute;es';
$strScore = 'Score';
$strSeed = 'Seed';
$strSemaine = 'Semaine';
$strServeur = 'Serveur';
$strServeurs = 'Serveurs';
$strSigle = 'Sigle';
$strSignature = 'Signature';
$strSimpleElimination='Simple';
$strSouligner = 'Souligner';
$strSponsors = 'Sponsors';
$strSrv = 'Srv';
$strStatistiques = 'Statistiques';
$strStats = 'Stats';
$strStatus = 'Statut';
$strSupprimer = 'Supprimer';
$strSupport = 'Support technique';
$strTableauxPoules = 'Tableaux des poules';
$strTag = 'Tag';
$strTaille = 'Taille';
$strTempsDeConnexion = 'Dur&eacute;e';
$strTermine = 'Termin&eacute;';
$strTerminerLeTournois = 'Etes-vous s&ucirc;r de vouloir terminer le tournoi ?';
$strTerminerLesPoules = 'Etes-vous s&ucirc;r de vouloir terminer les poules ?';
$strTerminerPoules = 'Terminer les poules';
$strTerminerTournois = 'Terminer le tournois';
$strTitre = 'Titre';
$strTitres = 'Titres';
$strTour = 'Tour';
$strTournois = 'Tournois';
$strTous= 'Tous';
$strTout = 'tout';
$strToutDeselectionner = 'Tout d&eacute;s&eacute;lectionner';
$strToutSelectionner = 'Tout s&eacute;lectionner';
$strToutes = 'Toutes';
$strType = 'Type';
$strTypeTournois = 'Type de tournoi';
$strUnAllowJoinTeam='N\'autorise pas d\'&ecirc;tre ajout&eacute; &agrave; une &eacute;quipe';
$strUnAllowPrivateMessage='N\'autorise pas de recevoir des MP publique';
$strUpdate='Mise &agrave; jour';
$strURL = 'URL';
$strUrl = 'Lien';
$strVIOLET = 'Violet';
$strVS = 'VS';
$strVainqueur = 'Vainqueur';
$strValeur = 'Valeur';
$strValider = 'Valider';
$strValiderFinales = 'Valider les finales';
$strValiderLesFinales = 'Etes-vous s&ucirc;r de vouloir valider les finales ?';
$strValiderLesPoules = 'Etes-vous s&ucirc;r de vouloir valider les poules ?';
$strValiderPoules = 'Valider les poules';
$strVille = 'Ville';
$strVisites = 'visites';
$strWHITE = 'Blanc';
$strWeb = 'Site web';
$strWinner = 'Winner';
$strYELLOW = 'Jaune';
$tabJoursSemaine = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
$tabMois = array('Janvier', 'F&eacute;vrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Ao&ucirc;t', 'Septembre', 'Octobre', 'Novembre', 'D&eacute;cembre');




$strServeursConsignes = '<li>Les champs marqu&eacute;s  <font color=red>*</font> sont obligatoires.
<li>Le protocole QStat permet d\'interroger des serveurs de jeux sp&eacute;cifiques (ex: HL->CS) pour connaitre leurs caract&eacute;ristiques (etat,joueurs,pings, etc) et leur nom.
<li>Qstat ne fonctionnera que sur les h&eacute;bergeurs disposant de la fonction \'exec\' dans PHP.
<li>Si vous utiliser M4 ou AdminBot-MX, vous devez obligatoirement cocher \'publier\' pour que cela fonctionne.
<li>Attention, le champ \'Rcon\' est obligatoire si vous utilisez AdminBot-MX.';

$strInscriptionsJoueursConsignes = '<li>Les champs marqu&eacute;s  <font color=red>*</font>  sont obligatoires.
<li>Le mot de passe demand&eacute; vous permettra de vous identifier et ainsi de pouvoir acc&eacute;der &agrave; votre compte par la suite.
<li>Un lien d\'activation de votre compte vous sera envoy&eacute; sur votre email (il ne sera en aucun cas communiqu&eacute; &agrave; un tiers).';

$strInscriptionsEquipesConsignes = '<li>Les champs marqu&eacute;s  <font color=red>*</font>  sont obligatoires.
<li>V&eacute;rifiez bien que votre &eacute;quipe n\'a pas d&eacute;j&agrave; &eacute;t&eacute; inscrite par un autre membre avant d\'en cr&eacute;er une.
<li>Le champ \'Nom\' pr&eacute;cise le nom complet de votre &eacute;quipe  (exemple : All Against Authority ou GoodGame).
<li>Le champ \'Tag\' pr&eacute;cise le nom raccourci de votre &eacute;quipe (exemple : aAa ou GG).
<li>Le manager de cette &eacute;quipe pourra ajouter ses joueurs ou ils pourront le faire grâce au mot de passe.';

$strTournoisModifyConsignes = '<li>Le champ \'mode score\' correspond &agrave; la façon dont vont &ecirc;tre renseign&eacute; les scores. (si par exemple vous utilisez M4, il faudra absolument cocher cette case)<br />
<li>Le champ \'mode inscription\' d&eacute;finit si les joueurs/managers ont le droit de s\'inscrire pendant le statut \'inscription\' du tournoi.<br />
<li>Le champ \'nombre manches\' indique le maximum de round (map) par match.<br />
<li>Les champs \'page X\' d&eacute;signent le nom du fichier Y dans le repertoire /include/html/X/langue/Y (langue = francais, etc..). (si ces champs sont vides, alors ces options seront d&eacute;sactiv&eacute;es dans le menu).<br />
<li>Le champ \'page statistiques\' indique l\'url vers le site web des statitiques pour ce tournoi.
<li>Le champ \'fichiers attach&eacute;s\' indique si des fichiers peuvent &ecirc;tre upload&eacute;s pour chaque matchs.
<li>Le champ \'commentaires\' indique si les joueurs des matchs en question peuvent poster des commentaires.';

$strTournoisConsignes = '<li>Les champs marqu&eacute;s  <font color=red>*</font>  sont obligatoires et ne pourront pas &ecirc;tre modifi&eacute;s par la suite.
<li>Le champ \'type\' indique si le tournoi est de type \'tournois\' (poules + finales), \'championnat\' (poules uniquement) ou \'coupe\' (finales uniquement).<br />
<li>Le champ \'mode &eacute;quipe\' d&eacute;fini le mode de tournoi : par &eacute;quipes, ou de joueurs.<br />
<li>Le champ \'mode matchs\' d&eacute;fini la m&eacute;hode pour comptabiliser les scores ("points gagn&eacute;s" se r&eacute;f&egrave;re aux scores (rounds gagn&eacute;s pour CS, frags marqu&eacute;s pour un duel UT2k4) et que "manches gagn&eacute;es" se r&eacute;f&egrave;re &agrave; la somme des manches par-del&agrave; la comptabilisation des points (un score de 13-10 pour CS correspond &agrave; une manche gagn&eacute;e 1-0 par exemple)).<br />
<li>Le champ \'jeu\' doit &ecirc;tre renseign&eacute; si vous comptez utiliser l\'outil de gestion des maps et des serveurs.';

$strConfigurationConsignes = '<li>Les champs \'inscriptions xxx\' indique si les inscriptions g&eacute;n&eacute;rales des teams/joueurs sont actives ou non.<br />
<li>Le champ \'email inscription\' d&eacute;finit l\'adresse d\'emailing des inscriptions.<br />
<li>Le champ \'email contact\' d&eacute;finit l\'adresse de contact.<br />
<li>Les champs d\'options permettent d\'activer ou de d&eacute;sactiver certaines options suivant vos besoins (A vous de tester !!).<br />
<li>Les champs \'page X\' d&eacute;signent le nom du fichier Y dans le repertoire /include/html/X/langue/Y (langue = francais, etc..). (si ces champs sont vides, alors ces options seront d&eacute;sactiv&eacute;es dans le menu).<br />
<li>Les options IRC permettent de configurer le module d\'IRC, les channels mentionn&eacute;s (s&eacute;par&eacute; par un espace) sont ceux qui seront automatiquement rejoint .<br />';


$strShoutbox= 'Shoutbox';
$strShoutboxlimit = 'Ligne(s) shoutbox';

$strDecroissant='D&eacute;croissant';
$strAvec = 'avec';
$strArchiveshout = 'Archives';
$strCroissant='Croissant';
$strShoutdesc = 'et par ordre';
$strShoutNbcom = 'Commentaires'; 
$strShoutNbpage = 'Page N°';
$strShoutboxlimitc = 'Caract&egrave;res max.';
$shoutoption = 'Options d\'affichage';


/////////////////////MOD
$strServerName='Nom Serveur';
$strADD_t_server='Lister votre serveur sur le site';
$strADMINNOTE='Note entre Admins';
$strRemarque='Remarque entre Admins sur le joueur :';
$strRemarqueEQUIPE='Remarque entre Admins sur l\'&eacute;quipe :';
$strbbcode='Style de BBcode';
$strphpBB='BBcode';
$streditor='Editeur';
$strMODS='Panel ADMIN des MODS';
$strMODSC='Note : chaque bouton modifier traite TOUS les Mods';
$strMod='Mods Panel';
$strServerTeam='Ajouter les serveurs des &eacute;quipes';

// auto validation d'&eacute;quipe par le manager
$strValid_My_Team ='Valider mon Equipe';
$strManag_team ='Manager Valide Equipe';
$strTABmanaging='Mod validation Equipe';
$strManag_team_num ='Nombre de joueurs requis';
$strOk_validation='<b><span style="color:green">Votre &eacute;quipe a bien &eacute;t&eacute; valid&eacute;e</span></b>';
$strNOOk_validation='<b><span style="color:red;font-size:12">Votre &eacute;quipe n\'a put &ecirc;tre valid&eacute;e.<br />Il manque encore des joueurs.<br />Si ce n\'est pas le cas, v&eacute;rifiez que vous &ecirc;tes bien inscrit dans un des jeux<br />Aux quels participe votre &eacute;quipe. Sinon contacter un ADMIN.</span></b>';
$strREQ_player='Nombre de joueurs requis pour valider une &eacute;quipe :';
$strAuto_valid_def='Equipe valid&eacute;e d&egrave;s sa cr&eacute;ation';
// end auto validation d'&eacute;quipe par le manager

$strSIDINV='Merci de fournir un Steamid pour vous enregistrer';
$strSIDINV2='Votre Steam ID doit &ecirc;tre de la forme : STEAM_X:X:XXXXXX';
$strSIDINV3='Ce Steam ID appartient d&eacute;ja &agrave; un joueur inscrit !';
$strSIDINV4='Steam ID invalide (cochez la case pr&eacute;vue &agrave; cet effet)';
$strSID='Steam ID';
$strSID2='Je ne joue pas &agrave; un jeu avec Steam :';
$strSteamIDO = 'Steamid-req';

$strPremium='Premium';


/********************************************************
 * Mod Rechercher un joueur
 */
$strRechercherJoueur='Rechercher un Joueur';
$strRechecrher='Rechercher';
$strRechInvalide='D&eacute;sol&eacute;, aucun joueur n\'a &eacute;t&eacute; trouv&eacute;.';
$strRechInvalide2='D&eacute;sol&eacute;, aucun joueur n\'a &eacute;t&eacute; trouv&eacute;.<br />Les pseudos approchant votre requ&ecirc;te sont : ';
$strAc_rechehlp='Vous pouvez ne mettre qu\'une partie du pseudo ou "<font color="red">*</font>" pour rechercher tous les pseudos';
/********************************************************
 * END Mod rechercher un joueur
 */
 
 /********************************************************
 * Mod commandes
 */
$strAc_cnumid='num&eacute;ro d\'identification de la commande qui est ajout&eacute; en bas dans \'annule expert\'.<br /><font size="-1"><em><i>(Une case &agrave; cocher; une case gris&eacute;e et coch&eacute;e est d&eacute;jà valid&eacute;e)</i></em></font>';
$strAc_R='Cocher les cases, desquels, le client a r&eacute;ceptionn&eacute; (prit) sa commande.';
$strAc_C='Cocher les cases des commandes qui sont arriv&eacute;es.<br />&nbsp;&nbsp;&nbsp;<i><em>(et donc que vos clients peuvent venir chercher)</em></i>';
$strAc_P='Cocher les cases des commandes qui ont &eacute;t&eacute; r&eacute;gl&eacute;es ou sont pay&eacute;es.';
$strAc_A='Cocher les cases des commandes &agrave; supprimer<font color="#FF0000"><strong> d&eacute;finitivement</strong></font>.';
$strAc_euro='&euro;';
$strAc_infocmd='Informations sur la commande N&deg;';
$strAc_acmd='a command&eacute;';
$strAc_nocmd='Pas de commandes';
$strAc_cmdmenu='Commandes';
$strAC_total='Totale';
$strAc_command='commande(s),';
$strAc_annueff='Annuler/effacer cette commande';
$strAc_anu='Mode Expert';
$strAc_readme='(Lisez ci-dessous avant toute modification)<br />Pour valider votre s&eacute;lection cliquer sur [- OK -]';
$strAc_cmddejapasser='la commande général est d&eacute;jà pass&eacute;e';
$strAc_wdoyouwant=', d&eacute;sirez-vous valider ou annuler ?';
$strAc_cmdlancer='Commandes lanc&eacute;es';
$strAc_enlever='Enlever article';
$strAc_ajouter='Ajouter article';
$strAc_lister='lister les commandes (validées/dé-validées)';
$strAc_commandes='Commandes';
$strAc_add='Ajouter';
$strAc_name='Nom';
$strAc_art='Les articles';
$strAc_arti='article';
$strAc_wlisting='Afficher quel listing ?';
$strAc_paiment='Paiement';
$strAc_recep='R&eacute;ception';
$strAc_cmdarriver='Commandes arriv&eacute;es';
$strAc_annulation='Annulation';
$strAc_prix='Prix';
$strAc_cmdnum='Commandes N&deg;';
$strAc_thx='- Merci -';
$strAc_Composition='Composition';
$strAc_histr='Historique des commandes de : ';
$strAc_cmdtrt='Commande trait&eacute;e';
$strAc_areg='(&agrave; r&eacute;gler)';
$strAc_cmdestarrive='- Votre Commande est arriv&eacute;e ! -';
$strAc_rechcmdno='Pas de commandes pass&eacute;es ou conserv&eacute;es';
$strAc_tuveupi='Tu veux une pizza ? ;-)';
$strAc_comvalide='- Commande valid&eacute;e -';
$strAc_comannulee='- Commande annul&eacute;e -';
$strAc_again='En commander une autre ? :';
$strAc_noagain='Commander :';
$strAc_similies=' - ;-) -';
$strAc_nocmdactual='- Nous ne prenons plus de commandes pour le momment -';
$strAc_nolatetotakeit='- Ne tardez pas &agrave; les r&eacute;cup&eacute;rer d&egrave;s qu\'ils arrivent ! -';
$strAc_cmddejapass='- La commande a &eacute;t&eacute; pass&eacute;e.';
$strAc_wewait='- Nous attendons que les &quot;articles&quot; soient livr&eacute;es. -';
$strAc_nottime='-Il n\'est sans doute pas encore l\'heure -';
$strAc_notactive='-Les commandes ne sont pas activ&eacute;es.-';
$strAc_listnick='La recherche a toutefois trouv&eacute;e des pseudos &eacute;quivalents';
$strAc_listnickfailed='La recherche n\'a trouv&eacute;e aucun pseudo &eacute;quivalent &agrave; celui de votre requ&ecirc;te';
$strAC_alertea='Cette action signalera &agrave; tous les clients de cette liste\nQue leur commande est arriv&eacute;e.\n(ils peuvent la r&eacute;cup&eacute;rer et/ou la payer)';
$strAC_alerteregle='Cette action fera que toutes les commandes de cette liste\nSeront consid&eacute;r&eacute;es comme ayant &eacute;t&eacute; pay&eacute;es.';
$strAC_alerteprit='Cette action fera que toutes les commandes de cette liste\nSeront consid&eacute;r&eacute;es comme ayant &eacute;t&eacute; donn&eacute;e aux clients\n';
$strAC_alertedel='ATENTION !!!\nVous allez effacer d&eacute;finitivement\nLa totalit&eacute; de cette commandes';
$strAc_youareadmin='Allez &agrave; la page admin';
$strAc_ifcmdok='Si vos commandes ont &eacute;t&eacute; livr&eacute;es et distribu&eacute;es, cliquez sur "commandes lanc&eacute;es"<br />pour mettre les commandes en OFF';
$strAc_consae='<p align="left"><font size="2">Comment &ccedil;a marche ?, C\'est une bonne question vous me direz ^_^.
<br />H&eacute; Bien... &agrave; la base il fallait cliquer entre une et 4 fois par commande pour modifier son status 
&agrave; \'r&eacute;gl&eacute;\'<br /> Maintenant on peut consulter toutes les commandes.<br /> Les deux cases ci-dessus se 
remplissent toutes seules. La premi&egrave;re va noter les <font color="#0000FF"><strong>ID</strong></font> des commandes 
que vous avez demandez &agrave; effacer.<br />La deuxi&egrave;me va compter le nombre de cases que vous avez coch&eacute;.
<br /><br /><font color="#009900"><strong>En cas d\'erreur (vous ne vouliez pas cliquez sur une case) </strong></font><strong>:
</strong><br /> Il vous suffit de supprimer l\'<font color="#0000FF"><strong>ID </strong><font color="#000000">de la liste et 
le &quot;pipe&quot; (symbole &quot;|&quot;) qui se trouve &agrave; sa droite.</font></font><br />Exemple 2|6|33| vous 
voulez retirer l\'<font color="#0000FF"><strong>ID</strong></font> 6 alors vous mettrez : 2|33|. Enfin retranch&eacute; 1 
dans la case qui suit.<br />Exemple pour 2|6|33| elle affichait \'3\' avec 2|33| vous retranch&eacute; 1 &agrave; 3 ce qui
vous donne 2.<br />Rien ne vous emp&ecirc;che d\'ajouter aussi, n\'oubliez seulement pas d\'incr&eacute;menter la case qui suit ;)</font></p><p align="left"><font size="-1">Si vous trouvez ça trop compliqu&eacute;  cliquez sur <strong>
<font color="#FF0000">RESET</font></strong>. Cela effacera tout :).</font></p><p align="left"><font 
size="-1">Si vous &ecirc;tes dou&eacute; en Javascript et que vous savez coder la fonction inverse de l\'affichage 
n\'&eacute;siter pas &agrave; vous manifester<br />(Gectou4 AT hotmail . com).</font></p><p align="left">
<font size="-1">Bonne LAN ;)</font></p>';
$strAc_artfin='\'??|&iquest;&iquest;</font>\'est le status de votre commande &quot;<font color="#FF0000">??</font>&quot; Si votre 
commande est r&eacute;gl&eacute;e ou non. &quot;<font color="#FF0000">&iquest;&iquest;</font>&quot; 
Si votre commande est arriv&eacute;e ou non.<br /></em></font>';
$strAc_nocmdsry='- Pas de commandes -';
$strAc_youneedloginfirst='Vous devez d\'abord &ecirc;tre logu&eacute;';
$strAc_pannier='Votre &quot;panier&quot;/historique';
$strAc_commander='Commander';
$strAc_jecpukoimettre='??|¿¿';
$strACAlredyExist = 'Article existant';
$strAC_podevirg='utiliser le . à la place de la , pour le prix ! Et utiliser un format numerique';
/********************************************************
 * END Mod commandes
 */
$strlastvisit = 'Derni&egrave;re visite le :';
$custheme='Changez de th&egrave;me';
$strarbitre = 'Admin du tournoi';
$strElementsNpageExistant = 'N° de page existant';
$strElementsNpageInvalide = 'N° de page invalide';
$strElementsMenuLien = 'Si la page est dans un menu il lui faut un lien';
$strElementsMenuLien2 = 'Si la page a un lien il lui faut un menu';
$strElementsOrdeInvalide2 = 'L\'ordre d\'affichage du lien doit &ecirc;tre un chiffre';
$strElementsRubriqueInvalide = 'Rubrique invalide';
$strElementsNmenuInvalide='Menu invalide';
$strAjouterPage='Ajouter une page';
$strRubrique='Rubrique';
$strNpage='N° de la page';
$strNmenu='Menu';
$strLien='Lien';
$strOrdre='Ordre';
$strAcces='Acc&eacute;s';
$strTous='Tous';
$strModifierPageR ='Modifier la page dans quelle rubrique ?';
$strModifierPage='Modifier la page';
$strElementsOdreInvalide='L\'ordre d\'affichage du menu doit &ecirc;tre un chiffre';
$strAlign='Align';
$strGauche='Gauche';
$strDroite='Droite';
$strHide='Cach&eacute;';
$strModifierMenus='Modifier un menu';
$strAjouterMenu='Ajouter un menu';
$strModifierMenu='Modifier le menu';
$strScript='Script';
$strpagescript='Autoriser HTML';
$strAddPage='Ajouter une page';
$strModPage='Modifier page';
$strAddMenu='Gestion des menus';
$strLienex = 'URL de la page';

$strMODEnLigne='Configuration des couleurs "en ligne"';
$strMODEnLigneA='Admin';
$strMODEnLigneN='Newseur';
$strMODEnLigneM='Manager';
$strMODEnLigneW='Waranger';
$strMODEnLigneMo='Modo';

$strCPPW='Pts Gagnant';
$strCPPN='Pts Egalit&eacute;';
$strCPPL='Pts Perdant';
$strCPPF='Pts Forfait';

$strAddPageConsignes = '<li>Titre : celui de la page (pour vous y retrouver quand vous 
 voudrez la modifier).<br />
 <li>Rubrique : Si la page appartient &agrave; une m&ecirc;me rubrique/dossier. 
 (un menu d&eacute;roulant <br />
 vous propose les rubriques existantes).<br />
 <li>N&deg; de page : Ca sert pas vraiment mais &ccedil;a d&eacute;finit 
 parmi la rubrique la premi&egrave;re page et les autres.<br />
 <li>Menu : Le menu dans lequel sera la page (si vide, la page devra 
 &ecirc;tre relier avec un lien via une autre page).&nbsp; <br />
 <li>Lien : Texte du lien dans le menu.<br />
 <li>Ordre : Position du lien dans le menu.&nbsp;<br />
 <li>Acc&eacute;s : D&eacute;finit si la page requiert un rang sp&eacute;cial 
 (membre logu&eacute;, visiteur, admin ou newseur) <br />L\'admin &agrave; acc&eacute; 
 &agrave; toutes les pages.<br />
 <br />
 <li><img src="images/bb_codescript.gif" border="0" /> Apparait si vous autoriser 
 le html dans le panel de configuration.<br />
 Tous script doit &ecirc;tre plac&eacute; entre les balises [script] [/script] 
 pour &ecirc;tre interpr&eacute;t&eacute;.<br />
 &nbsp;';
 //////mod ladder
 $strModsladder='Ladder Admin Panel';
 $strLadder='Ladder';
 $strLadlist='S&eacute;lectionner un ladder';
 $strMODAddlad='Ajouter un ladder';
 $strLadjeux='Jeu';
 $strLadType='Type';
 $strRegLad='R&eacute;glement du ladder';
 $strLadName='Nom du ladder';
 $strMODlistlad='Modifier quel ladder ?';
 $strLadNameMod='Modifier un ladder';
 $strladnodatafoundlist='Il n\'existe encore aucun ladder';
 $strLadduel='Lancer un duel';
 $strLadduel1='Lancer un duel avec le joueur';
 $strLadduele='Lancer un duel avec l\&eacute;quipe';
 $strLadduel2='D&eacute;fier ce joueur';
 $strMODAdddel='Effacer un ladder';
 $strMODAddclose='Fermer un ladder';
 $strLadalreadyexist='Notifier un autre nom, celui-ci est d&eacute;ja utilis&eacute;';
 $strDefier='D&eacute;fier';
 $strfrancaisladmail=' voici son message : ';
 $strfrancaisladmailopp=' Vous avez &eacute;t&eacute; d&eacute;fi&eacute; par ';
 $strLaditsyou='Vous ne pouvez vous d&eacute;fier vous m&ecirc;me !';
 $strEcrireMessageLAD='R&eacute;diger une demande de duel';
 $strLadnothingcont='Aucun message sp&eacute;cifi&eacute; !';
 $lstrladdual=' Duel !';
 $strLADj1='J1 a valid&eacute;';
 $strLADjv='Valider';
 $strLADnotagree='Autre proposition'; // EDITED
 $strLADj2='J2 a valid&eacute;';
 $strEcrireRApLAD='R&eacute;diger un rapport';
 $strLADRapport='Rapport';
 $strLADneednumeric='Les scores doivent &ecirc;tre au format d&eacute;cimal.';
 $strLADneedrap='Vous devez r&eacute;diger un rapport !';
 $strLADcheater='!  !  ! T R I C H E U R  !  !  !';
 $strLADagree='Confirmer';
 $strLADpoints='Points';
 $strLadderV='PtsLad Victoire';
 $strLadderP='PtsLad D&eacute;faite';
 $strLadderN='PtsLad Egalit&eacute;';
 $strLADnotagree='Contester';
 $strLADres='R&eacute;sultats du match';
 $strLADcomment ='Commentaires sur le match '; 
 $strLADNocoment='Aucun commentaire n\'a &eacute;t&eacute; laiss&eacute;.';
 $strLADfairadv='Fair Play de votre adversaire ';
 $strLadMylad='Mes Ladders, Mes matchs';
 $strLADother='';
 $strLADneedvalid='Vous devez Affirmer ou Infirmer le rapport !';
 $strLadVAl='Panel de validation et de status de vos matchs';
 $strPasDeFonctionMailLAD = 'D&eacute;sol&eacute; mais la fonction de mail est d&eacute;sactiv&eacute;e<br />Nous vous invitons &agrave; consulter le profil de l\'utilisateur<br />que vous souhaitez d&eacute;fier dans le cas où il aurait notifi&eacute; d\'autre mail de contact. <br /><br /><b><u>Un message lui &agrave; cependant &eacute;t&eacute; d&eacute;livr&eacute; par la messagerie du site !</u></b>';
 $strPasDeFonctionMailLADT = 'D&eacute;sol&eacute; mais la fonction de mail est d&eacute;sactiv&eacute;e<br />Nous vous invitons &agrave; consulter le profil du manager de l\'&eacute;quipe<br />que vous souhaitez d&eacute;fier dans le cas où il aurait notifi&eacute; d\'autre mail de contact. <br /><br /><b><u>Un message lui &agrave; cependant &eacute;t&eacute; d&eacute;livr&eacute; par la messagerie du site !</u></b>';
 $strLADvalidnotagreeCont='A contest&eacute; votre rapport. Nous vous invitons &agrave; confronter vos r&eacute;sultats,\n&agrave; revalider chacun le match. En cas de litige continue appellez un admin.';
 $strLADvalidnotagree='Validation de ladder REFUSEE';
 $strLADcheckref='Cliquez ici pour allez voir le match en question';
 $strLadermesmail='vous a d&eacute;fi&eacute; dans un Ladder. \nRendez-vous dans la section Ladder/mes matchs ou r&eacute;pondez &agrave; ce message.';
 $strLadMaps = 'Maps';
 $strLadDefpts = 'Points par d&eacute;faut';
 $strLadpourcent = 'Pourcentage';
 $strladpts  = 'par points';
 $strladteam = 'par participant'; 
 $strLad_needname = 'Le ladder doit avoir un nom';
 $strLad_needrules = 'Le ladder doit avoir un r&eacute;glement';
 $strLadderADD = '<li class="lib">le pourcentage, s\'il ne vaut pas 0, d&eacute;finit quel participant le joueur ou l\'&eacute;quipe aura le droit d\'affronter.<br />Si le pourcentage est de 5% alors seules les &eacute;quipes ayant plus ou moins de 5% d\'&eacute;cart de points pourront &ecirc;tre oppos&eacute;es<li class="lib"> "maps" d&eacute;finit si les joueurs doivent pr&eacute;ciser la map sur laquelle ou lesquelles ils joueront.<li class="lib">"point par d&eacute;faut" Permet de classer les &eacute;quipes &agrave; partir d\'un palier. Ainsi les nouveaux arrivants sont g&eacute;n&eacute;ralement "au milieu" et non "en bas" ce qui est plus &eacute;quitable '; 
 $strLadclosemode = 'Statut du ladder';
 $strLadclose = 'Ferm&eacute;';
 $strLadopen = 'Ouvert';
 $strRapport = 'Rapport';
 $strLad_agree='Confirmation de Match';
 $strLAD_refusal='Refuser';
 $strLAD_msgMatch='Vous pouvez accepter, proposer un autre challenge ou refuser &agrave; la page ci-dessous :';
 $strLAD_is_agree = 'a accept&eacute; le challenge';
 $strLAD_is_disagree = 'a propos&eacute; un autre challenge';
 $strLAD_is_disagree2 = 'a refus&eacute; le challenge';
 $strLAD_incom = 'Un concurent vous d&eacute;fit';
 $strLAD_incom2 = 'Votre concurent a accept&eacute; le defi';
 $strLAD_incom3 = 'Votre concurent propose un autre d&eacute;fi';
 $strLAD_incom4 = 'Votre concurent a refus&eacute; le defi';
 $strLAD_admin_title = 'Alerte &agrave; la triche';
 $strLAD_admin = 'Une tentative de validation de match non autoris&eacute;e a &eacute;t&eacute; perp&eacute;tr&eacute;e.<br /><br />(par un joueur non concern&eacute; ou le match &eacute;tait d&eacute;ja valid&eacute; et auquel cas le joueur incrimin&eacute; est arriv&eacute; sur cette page en tapant par url, les donn&eacute;es du match ou a peut-&ecirc;tre recliqu&eacute; sur le lien de validation qui lui a &eacute;t&eacute; soumis)<br /><br/>Afin de pr&eacute;venir tous risques, nous avons pr&eacute;fer&eacute; vous avertir.<br />Voici les donn&eacute;es du joueur concern&eacute; :';
 $strLAD_youdontabletodothis ='Vous n\'&ecirc;tes pas autoris&eacute; &agrave; effectuer cette action.<br />Ceci a &eacute;t&eacute; consid&eacute;r&eacute; comme une tentative de tricherie.<br />Un message avec votre pseudo et IP a &eacute;t&eacute; envoy&eacute; aux admins de ce site';
 $strLAD_refalert = 'Veuillez proposer d\'autres donn&eacute;es avant de valider';
 $strLAD_refusealert = 'Avec cette option la validation du formulaire causera la suppression direct des donn&eacute;es concernant ce challenge.';
 $strLAD_other_prupose = 'Autre proposition';
 $strLAD_reply = 'Votre message :';
 $strLAD_MDate = 'Date du match';
 $strLAD_MatchR = 'Rapport de fin de Match'; 
 $strLAD_roundscore = 'Nombre de rounds gagn&eacute;s par :';
 $strLAD_fragscore = 'Nombre de frags total de :';
 $strLAD_deathscore = 'Nombre de morts total de :';
 $strLAD_logresult = 'R&eacute;sultat de Match';
 $strLAD_round = 'Round';
 $strLAD_constest = 'A contest&eacute; les r&eacute;sultats et propose les suivants :';
 $strLAD_you_must_be_wait = 'Vous devez attendre que votre adversaire ait confirm&eacute;';
 $strLAD_endmatch_agree = 'R&eacute;sultat confirm&eacute;';
 $strLAD_fact = 'Facteurs Statistiques';
 $strLAD_nodata_match = 'Aucun match n\'a &eacute;t&eacute; trouv&eacute;';
 $strLAD_nodata_player = 'Aucun joueur n\'a &eacute;t&eacute; trouv&eacute;';
 $strLAD_nodata_rule = 'Aucun r&eacute;glement';
 $strLAD_nodata_for_match = 'Aucun match propos&eacute; et accept&eacute; n\'a &eacute;t&eacute; trouv&eacute;';
 $strLAD_nodata_for_player = 'Aucun joueur n\'est inscrit';
 $strLAD_nodata_for_result = 'Aucun r&eacute;sultat n\'a &eacute;t&eacute; enregistr&eacute;';
 $strLAD_lastmatch = 'Dernier Match';
 $strLAD_lastresult = 'Dernier r&eacute;sultat';
 $strLAD_yournotmanager = 'Vous n\'&ecirc;tes le manager d\'aucune &eacute;quipe';
 $strLAD_whosteam = 'Quelle &eacute;quipe int&eacute;grer ?';
 $strLAD_myunmatch= 'Mes matchs : n&eacute;cessitant ma validation';
 $strLAD_myvmatch = 'Mes matchs : n&eacute;cessitant des r&eacute;sultats';
 $strLAD_mytmatch = 'Mes matchs : termin&eacute;s';
 $strLAD_valid_this = 'Panneau d\'acceptation / refus';
 $strLAD_my_match_p = 'Mes match : propos&eacute;s';
 $strLAD_impose = 'l\'Admin d&eacute;cide le match entre :';
 $strLAD_is_imp = 'a impos&eacute; le match';
 $strLADfairadv_1='Fairplay adversaire 1';
 $strLADfairadv_2='Fairplay adversaire 2';
 $strLADAdminMaps = '<small>(Garder CLTR enfonc&eacute; pour s&eacute;lectionner plusieurs maps <br />ou désélectionné une map en recliquant sur une map sélectionnée)<br /></small>';
 $strLAD_wanttoleft = 'Voulez-vous quitter ce ladder ?\nToutes vos donn&eacute;es sur ce dernier seront effac&eacute;es';
 //end ladder
 
 //mod FAQ
$str_faq_choose='<font size="2" color=blue><b>Choisissez une cat&eacute;gorie :</b></font>';
$str_faq_admin='.: ADMIN :.';
$str_faq_al1='<font size="2" color="red"><b>Il faut d\'abord qu\'une cat&eacute;gorie existe</b></font><br /><br />';
$str_faq_al2='<font size="2" color="red"><b>Il faut d\'abord qu\'il y ait des questions</b></font><br /><br />';
$str_faq_al3='<font size="2" color="red"><b>Il faut d\'abord au moins 2 cat&eacute;gories</b></font><br /><br />';
$str_faq_al4='<font size="2" color="red"><b>Il faut d\'abord au moins 2 questions</b></font><br /><br />';
$str_faq_al5='<font size="2" color="green"><b>Cat&eacute;gorie effac&eacute;e</b></font><br /><br />';
$str_faq_al6='<font size="2" color="red"><b>Pas de champ vide merci :)</b></font><br /><br />';
$str_faq_actA='Ajouter cat&eacute;gorie';
$str_faq_actB='Ajouter question/r&eacute;ponse';
$str_faq_actC='Modifier Cat&eacute;gorie';
$str_faq_actD='Modifier Question/R&eacute;ponse';
$str_faq_actE='R&eacute;organiser cat&eacute;gorie';
$str_faq_actF='R&eacute;organiser Question/R&eacute;ponse';
$str_faq_actG='Effacer cat&eacute;gorie';
$str_faq_actH='Effacer Question/R&eacute;ponse';
$str_faq_actI='Interchanger Question/R&eacute;ponse';
$str_faq_addq='Question ajout&eacute;e';
$str_faq_addqr='Ajouter une question/r&eacute;ponse :';
$str_faq_in='Dans la cat&eacute;gorie :';
$str_faq_q='Question :';
$str_faq_r='R&eacute;ponse :';
$str_faq_par='Par :';
$str_faq_nothing='Il n\'y a pas de question dans cette cat&eacute;gorie';
$str_faq_inter='Question interchang&eacute;e !';
$str_faq_mettre='Mettre :';
$strFaq='FAQ :';
$str_faq_error='D&eacute;sol&eacute; mais il n\'existe encore aucune cat&eacute;gorie &agrave; consulter';
$strLAD_map_error = 'Vous devez d\'abord avoir d&eacute;finit un jeu pour le ladder';
 //end FAQ
 
 //FORUM 
 $strAjouterReponse='Ajouter une r&eacute;ponse';
 $strModifyReponse='Modifier une r&eacute;ponse';
 $strFLast='dernier message par :';
 $strTopic='Sujet :';
 $strTopicde='Cr&eacute;&eacute; par :';
 $strAjouterCategorie='Ajouter une cat&eacute;gorie';
 $strDesc='Description';
 $strEffcaerCategorie='Effacer cat&eacute;gorie';
 $strFdep='D&eacute;placer les sujets dans '; 
 $strFneedlog='Vous devez &ecirc;tre loguer pour pouvoir<br />cr&eacute;er ou r&eacute;pondre &agrave; un sujet.';
 $strFdelall='Effacer sans d&eacute;placer';
 $strFras='Il n\'existe encore aucune cat&eacute;gorie';
 $strEditeCategorie='Editer la cat&eacute;gorie';
 //v2
 $strFNbpage ='Page N°';
 //$strAvec='avec';
 $strFnbtop='topics';
 $strFnbsub='r&eacute;ponses';
 $strFnbtdd='et par ordre';
 //$strCroissant='Croissant';
 $strDecroissant='D&eacute;croissant';
 $strModo='Modo';
 $strFedit='Message &eacute;dit&eacute; le :';
 $strBy='par';
 //end v2
 $strForumnbpost='Nb. post sur forum';
 $strNbpost='Messages';
 $strRkforum='Titre forum';
 $strAjouterTopic='Ajouter Topic';
 $strWhereDep='D&eacute;placer le sujet dans la cat&eacute;gorie';
 $strDepsujet='D&eacute;placer tout le sujet';
 $strDelsujet='Effacer ce post';
 $strEdsujet='Editer ce post';
 $strReservedTo='Accessible &agrave;';
 $strReservedTonb='<br />Note : les admins acc&egrave;s partout, d&eacute;cocher tout pour une cat&eacute;gorie r&eacute;serv&eacute;e aux admins';
 $strDelCatCookie='Supprimer les cookies de cette cat&eacute;gorie';
 $strIWTL='Fermer ce sujet';
 $strIWTUL='Ouvrir ce sujet';
 $strSujet='Sujet';
 $strMessage='Messages';
 $strDernier='Dernier';
 $strFrasUnacces='Aucune cat&eacute;gorie n\'est pr&eacute;dispos&eacute;e &agrave; votre statut. Loguez-vous si ce n\'est pas encore fait.<br />Sinon contactez un admin en pr&eacute;cisant votre rang (user, manager, modo...).';
 $forum_need_more_ac='<small>Les r&eacute;ponses trouv&eacute;es n&eacute;c&eacute;ssitent un plus haut rang d\'approbation pour &ecirc;tre vues</small>';
 $strPost_id = 'Post n°';
 $strPost_link = 'Vous pouvez utiliser le lien dans le champ de texte ci-dessou pour cr&eacute;er un lien direct &agrave; ce message';
 //END FORUM

$strPageDeBBcode='Page d\'aide au BBcode';

// top 10
$strtop10='MODS "TOP 10" DL';
$strtop10dl='Block downloads';
$strtop10player='10 derniers inscrits';
$strlastresult='5 Derniers resultats';
$strlastnews='10 derni&egrave;res news';
$strlastnews_header='5 derni&egrave;res news en header';
$strlastnews5='5 Derni&egrave;res News';
$strNoresultnow='Pas encore de r&eacute;sultat...';
$strNonewsnow='Pas encore de news';
$strtop10_mod='Mod du type "TOP"';

/* Fichier plan.php */
$strLibre = 'Libre';
$strEquipePresente = 'Equipe d&eacute;j&agrave; pr&eacute;sente dans la salle';
$strEquipeNonDefini = 'Aucune &eacute;quipe n\'a &eacute;t&eacute; s&eacute;lectionn&eacute;e';
$strJoueurNonManager= 'Vous n\'&ecirc;tes manager d\'aucune &eacute;quipe';
$strChoixEmplacement = 'Choisir un emplacement';
$strSelectionEquipeConsignes = '<li>Seuls les managers d\'&eacute;quipe peuvent r&eacute;server les places. L\'emplacement que vous s&eacute;lectionnez est <font color=red>uniquement un souhait</font> de placement.</li>
<li>Si vous souhaitez changer d\'emplacement, contactez l\'admin</li>';
$strAdministrationReservation = 'Administration de Plan de la Salle';
$strPlanSalle = 'Plan de la Salle';

//admin tournois
//special arbitre
$strarbitre = 'Les Arbitres';
$strInscriptionsTournoisArbitre = 'Ne contacter un admin qu\'en cas de n&eacute;cessit&eacute;';

//search
$strTopic='Topic';
$strFLast='De';
$strRechecrher='Rechercher';
$strRechercher='Rechercher';
$strRechercherJoueur='Chercher un joueur';
$strElementsSearchInvalide='El&eacute;ment de recherche non sp&eacute;cifi&eacute;';
$strSearchUnresult='Aucun r&eacute;sultat trouv&eacute;';
$strS_listtnick_error='Aucun joueur n\'a &eacute;t&eacute; trouv&eacute;.';
$strS_listnick='La recherche a toutefois trouv&eacute; des joueurs proches';
$strS_listteam_error='Aucune &eacute;quipe n\'a &eacute;t&eacute; trouv&eacute;e.';
$strS_listteam='La recherche a toutefois trouv&eacute; des &eacute;quipes proches';
$strS_listnews_error='Aucune news n\'a &eacute;t&eacute; trouv&eacute;e.';
$strS_forum_error='Aucun topic n\'a &eacute;t&eacute; trouv&eacute;';
$strS_nomatch = 'D&eacute;sol&eacute; la recherche a &eacute;chou&eacute;e.';
$strRechercherSteam=' Rechercher un Steam ID ';
$strS_listtsteam_error=' Aucun Steam ID n\'a &eacute;t&eacute; trouv&eacute;';
$strS_liststeam='La recherche a toutefois trouv&eacute; des Steam ID proches';
$strElementsSteamInvalide='Vous devez sp&eacute;cifier un Steam ID';
// end search




// RANK
$strRang_a='Est Admin-Master';
$strRang_b='Est Admin';
$strRang_c='Peut modifier config & mod';
$strRang_d='Peut g&eacute;rer les Downloads';
$strRang_e='Peut g&eacute;rer les Equipes';
$strRang_f='Est FAQ-Master';
$strRang_g='Est Web-Master';
$strRang_h='Peut g&eacute;rer les Affili&eacute;s (liens)';
$strRang_i='Peut g&eacute;rer le livre d\'or';
$strRang_j='Peut g&eacute;rer les joueurs';
$strRang_k='Peut g&eacute;rer le plan de salle';
$strRang_l='Peut g&eacute;rer la Malling-list';
$strRang_m='Est Mod&eacute;rateur';
$strRang_n='Est Newser';
$strRang_o='A acc&egrave;s au menu admin';
$strRang_p='G&egrave;re les Partenaires';
$strRang_q='G&egrave;re la Galerie';
$strRang_r='G&egrave;re les Serveurs';
$strRang_s='G&egrave;re les Sponsors';
$strRang_t='G&egrave;re les Tournois/maps/jeux';
$strRang_u='G&egrave;re les Ladders/maps/jeux';
$strRang_v='G&egrave;re M4 et AdminBOT';
$strRang_w='Peut &eacute;diter les Pouvoirs';
$strRang_x='Manager d\'une &eacute;quipe au moins';
$strRang_y='Waranger d\'une &eacute;quipe au moins';
$strRang_z='User (sinon = banni)';
$strEdit_rang='Editer les pouvoirs';
$strRang_wrong='Vous ne pouvez pas &eacute;diter les pouvoirs d\'un Admin-Master <br />si vous n\'en n\'&ecirc;tes pas un !';
//RANK
$strFLOG='Les admins souhaitent que tous les utilisateurs s\'identifient';
$strFtitle_sec='S&eacute;curit&eacute;';
$strFtitle='Forcer le login';

// fix BBcode JAVA
$strL_BBCODE_B_HELP='Texte gras: [b]texte[/b] (alt+b)';
$strL_BBCODE_I_HELP='Texte italique: [i]texte[/i] (alt+i)';
$strL_BBCODE_U_HELP='Texte souligné: [u]texte[/u] (alt+u)';
$strL_BBCODE_Q_HELP='Citation: [quote]texte cité;[/quote] (alt+q)';
$strL_BBCODE_C_HELP='Afficher du code: [code]code[/code] (alt+c)';
$strL_BBCODE_L_HELP='Liste: [list]texte[/list] (alt+l)';
$strL_BBCODE_O_HELP='Liste ordonnée: [list=]texte[/list] (alt+o)';
$strL_BBCODE_P_HELP='Insérer une image: [img]http://image_url/[/img] (alt+p)';
$strL_BBCODE_W_HELP='Insérer un lien: [url]http://url/[/url] ou [url=http://url/]Nom[/url] (alt+w)';
$strL_BBCODE_S_HELP='Couleur du texte: [color=red]texte[/color] Astuce: #FF0000 fonctionne aussi';
$strL_BBCODE_F_HELP='Taille du texte: [size=x-small]texte en petit[/size]';
$strL_BBCODE_A_HELP='Fermer toutes les balises BBCode ouvertes';
$strL_BBCODE_N_HELP='Le BBcode ne sera pas interprété entre ces balises [noBBcode][B]pas en gras[/B][/nobbcode]';
$strL_BBCODE_CLOSE_TAGS='Fermer les balises';
$strL_EMPTY_MESSAGE='Message vide !';
$strL_STYLES_TIP='Astuce: Une mise en forme peut être appliquée au texte sélectionné';
$strAlignHelp='Alignement du texte: [align=center]Texte centr&eacute;[/align]';
$strAlign='Aligner';
$strLeft='A Gauche';
$strRight='A Droite';
$strCenter='Centrer';
$strJustify='Justifier';
$strSurligner='Surligner';
$strSurligner_help='Surligner le texte [bgcolor=red]Text surligné en rouge[/bgcolor]';
// end fox BBcode JAVA

// MOD LEFT TEAM
$strLeaveTeam='Quitter cette &eacute;quipe';
$strLeaveTeamALERT='Souhaitez-vous vraiment quitter cette &eacute;quipe ?';
// END MOD LEFT TEAM

//pc
$strADMINPANEL='Panel d\'administration.';
// end pc

//sondage
$strBaseInexistante='La base de donn&eacute;e n\'existe pas, elle ne pourra donc pas &ecirc;tre mise &agrave; jour.';
$strNoSondage = 'Aucun sondage';
$strSondage = 'Sondage';
$strAllSondage = 'Voir tous';
$strVoter = 'Voter';
$strAdminSondage = 'Sondage Admin Panel';
$strAddSondage = 'Ajouter un sondage';
$strModSondage = 'Modifier un sondage';
$strDelSondage = 'Supprimer un sondage';
$strCloseSondage = 'Fermer un sondage';
$strSondageName = 'Nom du sondage';
$strOptSondage = 'Option du sondage';
$strOption = 'Option';
$strRank = 'Rang';
$strAddOption = 'Ajouter <input type=\'text\' name=\'nb_opt\' value=\'1\' maxlength=\'2\' size=\'2\'> option(s)';
$strNoSondageName = 'Vous devez entrer le nom du sondage';
$strNoSondageOptions = 'Vous devez saisir au moins une option';
$strConfirmDelSondage = 'D&eacute;sirez-vous supprimer le sondage';
$strConfirmCloseSondage = 'D&eacute;sirez-vous fermer le sondage';
$strVoteSondage = 'Voter pour le sondage';
$strSondClosed = '(Ferm&eacute;)';
$strAlreadyVoted = 'Vous avez d&eacute;j&agrave; vot&eacute; sur ce sondage';
$strVote = 'Vote(s)';

//update  & install :
$strConfiguration_general='Configuration g&eacute;n&eacute;rale';
$strSessions_variables='Variables de sessions';
$strFlood_variable='Variable de flood';
$strtable_col='nombre de colonnes pour les tableaux';
$strnumxp='Nombre de ... par page';
$strnb_news_max = 'news';
$strnb_news_commentaires_max = 'commentaire de news';
$strnb_matchs_commentaires_max = 'commentaire de match';
$strnb_livredor_max = 'signature du livre d\'or';
$strnb_gallery_thumb = 'image de galerie';
$strnb_sondage_commentaires_max = 'commentaire de sondage';
$strsess_cookie_min = 'Dur&eacute;e du cookie';
$strsess_gc_days = 'Session (gc) en jours';
$strstats_timeout = 'Dur&eacute;e de conservation des stats';
$strflood_time = 'Temps de flood';
$strx_delta_simple = 'Arbre simple';
$strx_delta_double = 'Arbre double';
$strcol_equipes = 'colonne &eacute;quipes';
$strcol_joueurs = 'colonne joueurs';
$strcol_poules = 'colonne poules';
$strcol_matchs_poules = 'colonne matchs de poule';
$strcol_maps = 'colonne maps';
$strcol_jeux = 'colonne jeux';
$strcol_serveurs = 'colonne serveurs';
$strcol_administrateurs = 'colonnes admins';
$strcol_avatar_gallerie = 'colonnes avatars (galeries)';
$strcol_sponsors = 'colonnes sponsors ';
$strcol_categories = 'colonne cat&eacute;gories';
$strcol_gallery_thumb = 'colonne gallery (thumb)';
$strtm4rulecfg = 'fichier .cfg des r&egrave;gles de M4';
$strm4campscfg = 'type de camps';
$strm4autostartcfg = 'auto-start';
$strm4prolongationcfg = 'prolongation';
$strabrulecfg = 'r&egrave;gles cfg';
$strabcampscfg = 'type de camps';
$strabautostartcfg = 'auto start';
$strabprolongationcfg = 'prolongation';
$strInstallStage3Delupdatel = 'Attention! le fichier update.php n\'a pu &ecirc;tre supprim&eacute;<br /><u>Pour la s&eacute;curit&eacute; de votre site</u> il est <u>imp&eacute;ratif</u> que vous alliez le supprimer manuellement';

//news english
$strNews2='Version Anglaise';
$strElementsTitreInvalide2='Titre de la news Anglaise invalide';
$strElementsContenuInvalide2='Contenu de la news Anglaise invalide';
$strNewsUK='Activer news Anglaise';

$str_phptteam = "Cordialement,<br />l&acute;&eacute;quipe de phpTournois";
$X = 'Attente de confirmation du challeng&eacute;';
$A = 'Attente de confirmation du challengeur';
$B = 'En attente de r&eacute;sultat';
$D = 'Match Propos&eacute;';
$V = 'Match Termin&eacute;';

//Export 
$strEXPORT_tree = 'Exporter l\'arbre du tournois';
$strEXPORT_done = 'Arbre exporter avec succ&eacute;s dans include/export/f_';
$strEXPORT_done2 = 'Utiliser ceci pour fair un lien sur la page export&egrave;e :';
$strEXPORT_name = 'Titre du lien';

$str_phpTG4_v = 'Votre version est :';
$str_phpTG4_vo = 'La derni&egrave;re version est :';

$strTG4JOINT='Joindre une equipe';
$strTG4NT='Nouvelle equipe';
$strTG4MT='Mes equipes';
$strTG4MP='MP';
$strTG4MPB='Nouveau MP reçu';
$strTG4MPNB='Boîte de reception';
$strLinkex='échange de lien!';
$strMessageenvoyez = 'Votre message à été envoyé.';

$strTop10dl = 'Top 10 DL';
$strLastregistred= 'Dernier inscrits';

$strContactout = ', Vous a contact&eacute; par le forumlaire de contact phpTG4.<br />Mais le mail n&#39a pas pus vous &ecirc;tre envoy&eacute;.<br />Voici son message :<br />';
$strPMED = 'Le message &agrave; donc &eacute;t&eacute; envoyez en MP';
$strPMED_no = 'Le message n\'a pas pus &ecirc;tre envoy&eacute; par MP : pas de mail configur&eacute;';
$install_error = 'Vous ne pouvez proc&eacute;der &agrave; une installation tant que le fichier g4.g4 est &agrave; la racine de phpTG4 !';


$strAC_fermerlafenetre  = 'Close window';
$strMotif = 'Reason why'; 
$strAucune = 'None'; 
$strCarton = 'Wildcard';
$strAC_regle = 'Saled';
$strAC_livre  = 'Delivery';
$strAC_annulercommande  = 'Cancel command';
$strAC_impossibleannuler  = 'Cancel unpossible';
$strAC_commandepaspaye  = 'Command not paid';
$strAC_Attentede  = 'Waiting for';
$strAC_commandepasarrivee  = 'Waiting delivery';
$strAC_commandearrivee  = 'Command just arrive';
$strAC_articlearrivee  = 'Product in stock';
$strAC_merci = 'Thanks';
$strPasDeJoueur = 'No Players';

$strPour = 'pour';
$strNoarbitres='Il n\'y a pas d\'arbitres pour ce tournois actuellement';
$strSanctions='Sanctions';
$strNoUserOnline='Aucun joueur en ligne';
?>
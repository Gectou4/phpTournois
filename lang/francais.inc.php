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
define('YEAR_POS','3'); // en fr, le position de l'année est 3 => xx/xx/2002

// date d'affichage
define('DATESTRING','%d/%m/%Y %H:%M');
define('DATESTRING1','%d/%m/%Y à %H:%M');
define('DATESTRING2','%d/%m/%Y');


$strPasDeTableau = "Pas de tableau";

$strJoueursConsignes = '<li>L\'inscription définitive d\'un joueur (passage de l\'état \'pré-inscrit\' à l\'état \'inscrit\') est opérée par l\'admin sous réserve de modalités administratives (paiement, etc).
<li>Seuls les joueurs \'inscrits\' peuvent participer à des tournois solo.';

$strEquipesConsignes = '<li>La validation définitive d\'une équipe (passage de l\'état \'en attente\' à l\'état \'validée\') est opérée par l\'admin sous réserve de modalités administratives (équipe complete, joueurs TOUS inscrits, paiement, etc).
<li>Seules les équipes \'validées\' peuvent participer à des tournois par équipes.
<li>Le format de la colonne \'Inscrits\' est "nombre d\'inscrit - nombre de préinscrits"';

$strRapporterConsignes = '<li>Seuls les managers des 2 équipes (ou les 2 joueurs solo) peuvent enregistrer OU valider le résultat d\'un match.
(Par exemple, le perdant rapporte le score, et le gagnant le valide ou le conteste)';


$strRejoindreEquipesConsignes = '<li>Les champs marqués  <font color=red>*</font> sont obligatoires.
<li>Veuillez demander le mot de passe au manager de votre équipe pour pouvoir la rejoindre.';

$strHorairesTournoisConsignes = '<li>Le format de la date est "jj/mm/aaaa hh:mm" ou juste "hh:mm" pour aujourd\'hui.
<li>L\'affectation des dates ne sera effectué que pour les matchs cachés ou actifs.';

$strMapsTournoisConsignes = '<li>L\'affectation des maps ne sera effectué que pour les matchs cachés ou actifs.';

$strServeursTournoisConsignes = '<li>Les serveurs utilisables sont ceux définis dans l\'administration générale pour le jeu du tournoi en question.
<li>L\'affectation des serveurs ne sera effectuée que pour les matchs cachés ou actifs.';

$strAdminSponsorsConsignes = '<li>Les champs marqués  <font color=red>*</font> sont obligatoires.
<li>Les images des sponsors se trouvent dans le répertoire "images/sponsors".';

$strAdminLiensConsignes = '<li>Les champs marqués  <font color=red>*</font> sont obligatoires.
<li>Les images des liens se trouvent dans le répertoire "images/liens".';

$strAdminJeuxConsignes = '<li>Les champs marqués  <font color=red>*</font> sont obligatoires.
<li>Les images des jeux se trouvent dans le répertoire "images/jeux".';

$strIRCMessage = 'IRC (Internet Relay Chat) est un réseau de discussion en temps réel.<br /><br />
Vous avez la possibilité de nous rejoindre sur le(s) channel(s) %chans% du serveur %serveur% par un logiciel client externe: <a href="irc://%serveur%/%chan%"><img src="images/icon_irc.gif" border="0" align="absmiddle"></a><br /><br />
ou<br /><br />
via l\'applet java directement intégré à ce site gràce au lien ci dessous:';

$strUploadFichierConsignes = '<li>Le champ marqué  <font color=red>*</font>  est obligatoire.
<li>Taille maximum des fichiers: ';

$strRapporterResultats = 'Rapporter des résultats';
$strMatchAttenteResultats = 'Match en attente de résultat';
$strMatchAttenteValidation = 'Match en attente de validation';
$strTournoisEnCours = 'Tournois en cours';
$strTournoisTermines = 'Tournois terminés';
$strValiderScore = 'Valider le score';
$strRefuserScore = 'Refuser le score';
$strValidation = 'Validation';
$strConflit = 'Conflit';
$strAssignerPoules = "Assigner suivant le classement des poules"; 
$strMethodeRandom = 'méthode \'aléatoire\'';
$strMethodeSeed = 'méthode \'seedée\'';
$strMethodeCroise = 'méthode \'croisée\'';


$strPageDecharge = 'Page \'décharge\'';
$strConditionsGenerales = "Conditions Générales";
$strJeRefuse = 'Je refuse';
$strJAccepte = 'J\'accepte';
$strErreurMatchABPresent = 'Match dans la base de donnée AB existant!';
$strErreurMatchM4Present = 'Match dans la base de donnée M4 existant!';
$strRecupOk = "Récupération OK!";
$strDans = 'dans';
$strAuto = 'Auto';
$strRecupMatchAuto = 'Récupération automatique des matchs de ';
$strChangerElimination = 'Etes-vous s&ucirc;r de vouloir changer le type d\'arbre de ce tournoi ?';
$strConfirmDesincrireTeam = 'Etes-vous s&ucirc;r de vouloir désinscrire votre team de ce tournoi ?';
$strConfirmDesincrire = 'Etes-vous s&ucirc;r de vouloir vous désinscrire de ce tournoi ?';
$strSeDesinscrire = 'Se désinscrire';
$strDesinscrire = 'Désinscrire';
$strAppletPJIRC = 'Applet java PJIRC';
$strPopup = 'Popup';
$strDevenirPartenaire = 'Devenir partenaire';
$strInscriptionsEquipes = 'Inscriptions équipes';
$strInscriptionsJoueurs = 'Inscriptions joueurs';
$strInstall = 'Installation';
$strFloodDetect = 'Vous ne pouvez réaliser cette opération que toutes les '.$config['flood_time'].' secondes';
$strErreurNbPlaces = 'Le nombre de place doit &ecirc;tre supérieur à 0';
$strErreurJoueurAppartient = 'Le joueur appartient déja à cette équipe';
$strInscriptionsTournoisConsignes = '<li>Les inscriptions aux tournois ne sont possibles que si votre joueur/équipe est inscrit/validée.';
$strRejoindreUneEquipe = 'Rejoindre une équipe';
$strRejoindreCetteEquipe = 'Rejoindre cette équipe';
$strPasswordRejoindre = 'Password<br />(pour rejoindre)';
$strPasDeFonctionMail = 'Désolé mais la fonction de mail est désactivée';
$strContactMessageEmail = 'Ceci est un message de contact du site %nomsite% où';
$strInstallStage1 = 'Configuration des bases de données';
$strInstallStage1Consignes = 'Veuillez saisir les param&egrave;tres de vos bases de données';
$strInstallStage1Consignes2 = 'Cliquez ici pour configurer';
$strInstallStage2 = 'Configuration de phpTournois';
$strInstallStage2Consignes = 'Veuillez saisir le nom et l\'url de votre site et selectionner le type d\'install';
$strInstallStage2Consignes2 = 'Veuillez saisir le login et le mot de passe du compte administrateur';
$strInstallStage3 = 'Félicitation, phpTournois est correctement installé.';
$strInstallStage3Consignes = '<div align=left><blockquote>En utilisant phpTournois, vous devez savoir ce qu\'est un logiciel gratuit sous <b>licence GNU/GPL</b>.<br />
Vous vous engagez à respecter ce qui suit: <br />
<li> Logiciel gratuit ne veut en aucun cas dire que vous pouvez faire n\'importe quoi avec (condition 1)<br />
<li> Il est formellement interdit de retirer toute ou partie des lignes faisant référence à son concepteur (condition 2)<br />
<li> Plus généralement il est strictement <b>interdit de supprimer ou modifier les copyrights</b> (condition 3) En retirant ces lignes ou en les modifiant vous vous exposez à des poursuites judiciaires.<br />
<li> Vous <b>devez</b> publier les modifications que vous avez effectuées sur le code (sur le forum par exemple) et l\'équipe se réserve le droit de les réutiliser (condition 4)<br />
</blockquote></div>Consultez les fichiers INSTALL, README & LICENCE pour de plus amples informations.<br /><br />Cliquez ici pour aller à la page d\'accueil de votre site : <a href=index.php>GO !</a>';
$strInstallStage3DelInstall = 'Attention! le fichier install.php n\'a pu &ecirc;tre supprimé<br /><u>Pour la sécurité de votre site</u> il est <u>impératif</u> que vous alliez le supprimer manuellement';
$strFichierSqlManquant = 'Fichier SQL manquant';
$strPaypal = 'Réaliser un don pour ce site via PayPal est rapide, gratuit et sécurisé !';
$strPermissionInvalideConfigFile = 'Le fichier de configuration n\'a pas les droits d\'ecriture';
$strOuvertureInvalideConfigFile = 'Ouverture impossible du fichier de configuration';
$strEcritureInvalideConfigFile = 'Ecriture impossible du fichier de configuration';
$strPageDemarrage = 'Page de démarrage';
$strDBHost = 'Nom du serveur Mysql';
$strDBUser = 'Utilisateur Mysql';
$strDBPass = 'Mot de passe Mysql';
$strDBName = 'Nom de la base Mysql';
$strDBPrefix = 'Préfixe des tables';
$strVersion = 'Version';
$strPasDeServeur = 'Pas de serveur';
$strPasDEquipe = 'Pas d\'équipe';
$strPasDeJoueur = 'Pas de joueur';
$strPasDeTournoi = 'Pas de tournoi';
$strMoi = 'Moi';
$strMatchsTermines = 'Matchs terminés';
$strMatchsCaches = 'Matchs cachés';
$strElementsManagerInvalide = 'Manager invalide';
$strNouvelleEquipe = 'Nouvelle équipe';
$strCachee = 'Cachée';
$strCaches = 'Cachés';
$strCachees = 'Cachées';
$strLeader= 'Leader';
$strWarArranger = 'Waranger';
$strMembre = 'Membre';
$strRecrue = 'Recrue';
$strInactif = 'Inactif';
$strExMembre = 'Ex-membre';
$strModifierDownload = 'Modifier ce téléchargement';
$strModifierSponsors = 'Modifier ce sponsor';
$strModifierTournois = 'Modifier ce tournoi';
$strModifierLiens = 'Modifier ce lien';
$strModifierPartenaires = 'Modififer ce partenaire';
$strValide = 'Valide';
$strIncomplete = 'Incompl&egrave;te';
$strTableau = 'Tableau';
$strChangerStatusEquipe = 'Voulez-vous changer le statut de cette équipe ?';
$strDonation = 'Donation';
$strYIM = 'YIM';
$strFonction = 'Fonction';
$strMail = 'Mail';
$strSmtp = 'Smtp';
$strSmtpServeur = 'Serveur';
$strSmtpUser = 'Utilisateur';
$strSmtpPassword = 'Password';
$strOptionsMail = 'Options Mail';
$strThemeDefaut = 'Th&egrave;me par défaut';
$strMessageEnvoi = 'Le message a bien été envoyé.';
$strErreurMessageEnvoi = 'Le message n\'a pas pu &ecirc;tre envoyé.';
$strConfirmIncrireTeam = 'Etes-vous s&ucirc;r de vouloir inscrire votre team à ce tournoi ?';
$strConfirmSIncrire = 'Etes-vous s&ucirc;r de vouloir vous inscrire à ce tournoi ?';
$strPreInscription = 'Pré-inscription';
$strEnAttente = 'En attente';
$strEquipeValidee = 'équipes validées';
$strEquipeEnAttente = 'équipes en attente';
$strValidee = 'Validée';
$strValidees = 'Validées';
$strAttenteMail = 'Attente Mail';
$strSteam = 'Steam';
$strPartenaires = 'Partenaires';
$strWWW = 'Web';
$strAvatar = 'Avatar';
$strAvatars = 'Avatars';
$strModifierAvatar = 'Modifier l\'avatar';
$strConfirmEffacerAvatar = 'Effacer cet avatar?';
$strCreerEquipe = 'Créer une équipe';
$strPageGeneree = 'Page générée en';
$strSecondes = 'secondes';
$strAvatarUploadLocal = 'Envoyer un avatar local';
$strAvatarUploadRemote = 'Envoyer un avatar distant';
$strAvatarLienRemote = 'Lier un avatar distant';
$strSousCategories = 'Sous catégories';
$strPermissionInvalide = 'Permissions invalides';
$strGalerieInconnue = 'Galerie inconnue';
$strGalerie = 'Galerie';
$strPasDImage = 'Pas d\'image';
$strImageInconnue = 'Image inconnue';
$strImages = 'Images';
$strGDAbsent = 'GD absente sur ce serveur';
$strExtensionNonSupporte = 'Extension non supportée';
$strNewsEnvoiSubject = '[%nomsite%] Nouveauté !';
$strNewsEnvoiMessage = 'Voici une nouvelle en provenance du site <b>%nomsite%</b> qui pourrait vous intéresser : <br /><br />%link%';
$strNewsEnvoiConfirm = 'Un email vient d\'&ecirc;tre envoyé à votre ami !';
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
$strAvatarErreurUrl = 'L\'URL spécifiée n\'est pas correcte !';
$strAvatarErreurConnexion = 'Le serveur n\'a pas pu se connecter à l\'URL pour la télécharger !';
$strAvatarErreurData = 'L\'URL spécifiée ne contient pas les bonnes données !';
$strAvatarErreurWrite = 'Impossible d\'écrire l\'image sur le serveur !';
$strAvatarErreurFileSize = 'La taille du fichier de l\'image est incorrecte ';
$strAvatarErreurFileType = 'Le type d\'image n\'est pas supporté ';
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
$strOubliPass = 'Mot de passe oublié ?';
$strEnvoiPass = 'Envoi du mot de passe par mail';
$strCodeConfirmation = 'Code de confirmation';
$strElementsJoueurInvalide = 'Joueur invalide';
$strElementsEquipeInvalide = 'Equipe invalide';
$strElementsCodeInvalide = 'Code invalide';
$strPasswordEmailCode = '[%nomsite%] Code pour le nouveau mot de passe';
$strPasswordEmailCodeMessage = 'Vous avez demandez l\'envoi d\'un nouveau mot de passe.<br /><br />Voici le code que vous devez rentrer en dessous de votre pseudo : <b>%code%</b><br /><br />PS: si vous n\'etes pas à l\'origine de cette demande, ignorez ce mail!';
$strPasswordMessageCode = 'Le code pour l\'envoi du nouveau mot de passe vous a été envoyé par mail!';
$strPasswordEmail = '[%nomsite%] Nouveau mot de passe';
$strPasswordEmailMessage = 'Voici le nouveau mot de passe pour votre compte : <b>%passwd%</b><br /><br />N\'oubliez pas de vous connecter pour le changer!';
$strPasswordMessage = 'Votre nouveau mot de passe vous a été envoyé par mail!';
$strPasswordMessageAdmin = 'Le nouveau mot de passe est : <b>%passwd%</b><br /><br />Il a été aussi envoyé par mail à la personne concernée!';
$strPasswordEnvoiConsignes = '<li>Entrez votre pseudo et cliquez sur le bouton envoyer. Un email automatique avec votre code de confirmation vous sera envoyé. <li>Ré-entrez ensuite votre pseudo et votre code de confirmation et vous recevrez votre nouveau mot de passe par email.';
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
$strCategories = 'Catégories';;
$strPetite = 'petite';
$strGrande = 'grande';
$strErreur404 = 'Erreur 404';
$strErreur404Explain = 'La page que vous avez demandée n\'est pas accessible...';
$strLoguePourPoster = 'Par mesure de sécurité, vous devez &ecirc;tre identifié pour poster un commentaire';
$strMatchInvalide = 'Match invalide !';
$strCommentairesMatch = 'Commentaires du match';
$strModeCommentaire = 'Commentaires';
$strPasDeCommentaire = 'Pas de commentaire';
$strConfirmEffacerFile = 'Effacer ce fichier ?';
$strAjouteLe = 'Ajouté le';
$strFichier = 'Fichier';
$strFichierInvalide = 'Fichier invalide';
$strUploaderFichier = 'Uploader un fichier dans ';
$strParticipePourPoster = 'Vous devez &ecirc;tre membre d\'une des 2 équipes ou un joueur de ce match pour pouvoir poster des commentaires.';
$strManagerPourUploader = 'Vous devez &ecirc;tre le manager d\'une des 2 équipes ou un des joueur de ce match pour pouvoir poster des fichiers.';

$strTournoisParticipe = 'Participe aux tournois';
$strTournoisAParticipe = 'A participé aux tournois';
$strModeMatchScore = 'Mode Matchs';
$strFragAverage = 'Points marqués';
$strRoundAverage = 'Manches gagnées';
$strRoundAverageFragAverage = 'Manches puis points';


$PHPMAILER_LANG = array();
$PHPMAILER_LANG["provide_address"] = 'Vous devez spécifier au moins une adresse de destination.';
$PHPMAILER_LANG["mailer_not_supported"] =  'ce mailer n\'est pas supporté';
$PHPMAILER_LANG["execute"] = 'Ne peut pas exécuter: ';
$PHPMAILER_LANG["instantiate"] = 'La fonction mail n\'est pas activée dans votre php.';
$PHPMAILER_LANG["authenticate"] = 'Erreur d\'autentification SMTP.';
$PHPMAILER_LANG["from_failed"] = 'L\'adresse suivante est invalide: ';
$PHPMAILER_LANG["recipients_failed"] = 'Erreur SMTP: l\'adresse suivante est invalide: ';
$PHPMAILER_LANG["data_not_accepted"] = 'Erreur SMTP: les données n\'ont pas été acceptées.';
$PHPMAILER_LANG["connect_host"] = 'Erreur SMTP: impossible de se connecter au serveur.';
$PHPMAILER_LANG["file_access"] = 'Fichier attaché non accessible: ';
$PHPMAILER_LANG["file_open"] = 'Fichier attaché non accessible: ';
$PHPMAILER_LANG["encoding"] = 'Encodage inconnu: ';





$strM4Admin = 'Interface M4';
$strABAdmin = 'Interface AdminBot';
$strModeFichier = 'Fichiers attachés';
$strValidationEmail = 'Validation Email';
$strA = 'à';
$strAEcrit = 'a écrit';
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
$strAjouterEquipe = 'Ajouter une équipe';
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
$strAleatoire = 'Aléatoire';
$strAllowJoinTeam='Autorise d\'&ecirc;tre ajouter à une équipe';
$strAllowPrivateMessage='Autorise de recevoir des MP publique';
$strAn = 'ans';
$strAncienPass = 'Ancien mot de passe';
$strAncienPassInvalid = 'Ancien mot de passe invalide';
$strAnnuler = 'Annuler';
$strAssignerAleatoirement = 'Assigner aleatoirement';
$strAssignerInscriptionSeed = 'Assigner suivant le seed d\'inscription';
$strAutoajoutTeam='Disponibilité';
$strAutoMp='Messagerie';
$strAutoStart= 'AutoStart';
$strAutorefresh = 'Auto-refresh';
$strAutoscroll = 'Auto-scroll';
$strAvecDemo = 'démo';
$strAvg = 'Avg';
$strBLACK = 'Noir';
$strBLUE = 'Bleu';
$strBROWN = 'Marron';
$strCYAN = 'Cyan';
$strCache = 'Caché';
$strCalendrier = 'Calendrier';
$strCalendrierMatchs = 'Calendrier des matchs';
$strCamps = 'Camps';
$strManager = 'Manager';
$strManagers='Managers';
$strCartegraphique = 'Carte Graphique';
$strCategorie = 'Catégorie';
$strCentrer = 'Centré';
$strChampionnat = 'Championnat';
$strChangerDevise = 'Changer la devise';
$strChangerFinales = 'Etes-vous s&ucirc;r de vouloir changer le début des finales ? \n\n(ATTENTION, cette opération efface enti&egrave;rement l\\\'arbre)';
$strChangerLooser = 'Etes-vous s&ucirc;r de vouloir changer le début du looser ? \n\n(ATTENTION, cette opération efface enti&egrave;rement l\\\'arbre du looser)';
$strChangerPoules = 'Etes-vous s&ucirc;r de vouloir changer le nombre de poules ? \n\n(ATTENTION, cette opération efface tous les matchs de poules)';
$strChangerStatusTournois = 'Etes-vous s&ucirc;r de vouloir changer le statut du tournois ? \n(ATTENTION, cette opération n\\\'est recommandée que pour les p0wer-admins)';
$strChangerStatusJoueur = 'Etes-vous s&ucirc;r de vouloir le statut de ce joueur ?';
$strChangerStatusParticipe = 'Etes-vous s&ucirc;r de vouloir changer le statut de ce participant ?\n\n(ATTENTION cette opération modifie les matchs et les arbres)';
$strChercherJoueur = 'Chercher un joueur';
$strChoisirAuHasard = 'Choisir au hasard';
$strCloturerInscriptions = 'Clôturer les inscriptions ?';
$strCloturerLesInscriptions = 'Etes-vous s&ucirc;r de vouloir clôturer les inscriptions ?';
$strCode = 'Code';
$strCodePostal = 'CP';
$strCocheforwrite1 = 'Ré-écrire le fichier config.php ?';
$strCocheforwrite2 = 'Ré-écrire le fichier config.m4.php ?';
$strCocheforwrite3 = 'Ré-écrire le fichier config.ab.php ?';
$strColorerCode='Afficher le code syntaxé';
$strCommentaires = 'Commentaires';
$strConfiguration = 'Configuration';
$strConfirm = 'Confirmation';
$strConfirmEffacerCommentaire = 'Effacer ce commentaire ?';
$strConfirmEffacerDownload = 'Effacer ce download ?';
$strConfirmEffacerEquipe = 'Effacer cette équipe ?';
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
$strConnecte = 'Connecté';
$strConnecter = 'Se connecter';
$strConnexion = 'Connexion';
$strConnexionImpossible = 'Connexion à la base de données impossible!';
$strConsignes = 'Consignes';
$strContact = 'Contact';
$strContactDown = "<u>ClubRezo</u><br />Ecole Polytechnique de l'Université de Nantes<br />rue Christian Pauc<br />44300 Nantes<br />Email : <a href=\"mailto: $config[emailcontact]\"><b><u>$config[emailcontact]</u></b></a>";
$strContactUp = 'Pour nous contacter, vous pouvez utiliser votre client mail favori <a href="mailto: %email%"><img src="images/icon_email.gif" border="0" align="absmiddle"></a> ou remplir le formulaire ci dessous:';
$strContenu = 'Contenu';
$strCouleur = 'Couleur';
$strCoupe = 'Coupe';
$strCreationImpossible = 'Création de la base phpTournois impossible!';
$strCreer = 'Créer';
$strCustTheme = 'Sélecteur de th&egrave;mes';
$strDARKBLUE = 'Bleu foncé';
$strDARKED = 'Rouge foncé';
$strDate = 'Date';
$strDe = 'De';
$strDeconnexion = 'Déconnexion';
$strDerniersTitres = 'Derniers titres';
$strDescription = 'Description';
$strDestinataire = 'Destinataire';
$strDestinataires = 'Destinataires';
$strDevise = 'Devise';
$strDispute = 'Dispute';
$strDisqualifie = 'Disqualifié';
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
$strElementsIncorects = 'Un ou plusieurs éléments sont incorrects';
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
$strElementsPrenomInvalide = 'Prénom invalide';
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
$strErreurMancheActive = 'Pas de manche active! Au moins une manche doit &ecirc;tre créée et activée.';
$strErreurMapManquante = 'Map manquante!';
$strErreurMatchABManquant = 'Match dans la base de donnée AB manquant!';
$strErreurMatchM4Manquant = 'Match dans la base de donnée M4 manquant!';
$strErreurPremiereManche = 'Absence de 1&egrave;re manche active! Veuillez créer et activer au moins une manche pour ce match.';
$strErreurServeurManquant = 'Serveur manquant!';
$strErreurStatusActif = 'Mauvais statut! ce match doit &ecirc;tre activé pour pouvoir démarrer.';
$strErreurStatusCache = 'Mauvais statut! ce match doit &ecirc;tre caché pour &ecirc;tre activé.';
$strErreurStatusDemarre = 'Mauvais statut! ce match doit &ecirc;tre démarré pour pouvoir &ecirc;tre récupéré.';
$strEtat = 'Etat';
$strFiche = 'Fiche';
$strFichiersAttaches = 'Fichiers attachés';
$strFichiersAttachesMatch = 'Fichiers attachés au match';
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
$strInscriptionConfirmMessage = 'Votre inscription vient d\'&ecirc;tre prise en compte<br />Vous aller recevoir un email de confirmation contenant un lien d\'activation.<br /><br />A Bientôt, et good frags!!<br /><br />L\'équipe organisatrice.';
$strInscriptionConfirmMessageOK = 'Votre inscription est effective<br /><br />N\'oubliez pas de nous faire parvenir les modalités de l\'inscription<br /><br />Vous pouvez vous connecter dans votre espace personnel et configurer votre équipe si vous &ecirc;tes le manager<br /><br />A Bientôt, et good frags!!<br /><br />L\'équipe organisatrice.';
$strInscriptionConfirmMessageEmail = 'Merci de vous &ecirc;tre inscris à la \'%nomsite%\'.<br /><br />N\'oubliez pas vos identifiants ci-dessous, ils vous permettront de vous connecter ultérieurement:<br />------------------<br /> Login : <b>%login%</b><br /> Pass: <b>%password%</b><br />------------------<br /><br /><font color=red>ATTENTION, cliquez sur le lien pour valider votre enregistrement</font>: %link%<br /><br />Veuillez noter votre mot de passe car, crypté dans la base de données, il ne pourra pas &ecirc;tre récupéré. Vous pourrez cependant en demander un nouveau.<br /><br />A Bientot, et good frags!!<br /><br />L\'équipe organisatrice.<br /><br />';
$strInscriptionConfirmSubjectEmail = '[%nomsite%] Confirmation de la pré-inscription';
$strInscriptionMessage = 'Votre inscription vient d\'&ecirc;tre prise en compte<br />N\'oubliez pas vos identifiants ci dessous:<br />Login : <b>%login%</b><br />Pass: <b>%password%</b><br /><br />Vous pouvez vous connecter dans votre espace personnel et configurer votre équipe si vous &ecirc;tes le manager<br /><br />Veuillez noter votre mot de passe car, crypté dans la base de données, il ne pourra pas &ecirc;tre récupéré. Vous pourrez cependant en demander un nouveau.<br /><br />A Bientôt, et good frags!!<br /><br />L\'équipe organisatrice.';
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
$strJoinAvecHlla = "Pour rejoindre un serveur avec le lien '$strJoin', vous devez télécharger .hlla <a href=\"downloads/hlla0704.exe\">>ici<</a> ou sur <a href=\"http://www.hlla.net\" target=_blank><span style=\"vertical-align: middle;\"><img src=images/hlla.gif align=absmidlle border=0></span></a> et l'installer";
$strJoueur = 'Joueur';
$strJoueurs = 'Joueurs';
$strJoueursInscrits = 'Joueurs inscrits';
$strJoueursPreinscrit = 'Joueurs pré-inscrits';
$strKOctets = 'Ko';
$strLan = 'Lan';
$strLancerMatch = 'Lancer les matchs';
$strLancerMatchAB = 'Lancer les matchs AdminBot-MX';
$strLancerMatchM4 = 'Lancer les matchs M4';
$strLangue = 'Langue';
$strLangueDefaut = 'Langue défaut';
$strLe = 'le';
$strLeaveTeam='Quitter cette équipe';
$strLeaveTeamALERT='Souhaitez-vous vraiment quitter cette équipe ?';
$strLeaveTeambody1='Bonjour,\nNous vous informons que le membre de votre équipe : ';
$strLeaveTeambody2='\n\nA quitté délibérément votre équipe.\n\nMerci de votre attention.';
$strLeaveTeambodyM1='Bonjour,\nNous vous informons que le manager de l\'équipe : ';
$strLeaveTeambodyM2='\n\nVous a supprimé des membres son équipe.\n\nMerci de votre attention.';
$strLeaveTeamM='Vous ne pouvez quitter l\'équipe tant que vous en &ecirc;tes le manager';
$strLeaveTeamtitle='A quitté votre équipe !';
$strLeaveTeamtitleManager='Votre manager vous à supprimé de son équipe';
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
$strMailNotconfig = 'Server SMTP indéfinie ou user indéfinie';
$strMaintenance = 'Maintenance';
$strManche = 'manche';
$strManchesMax = 'Nombre Manches';
$strManuel = 'Manuel';
$strMap = 'Map';
$strMaps = 'Maps';
$strMatch = 'Match';
$strMatchs = 'Matchs';
$strMatchsActifs = 'Matchs prévus';
$strMatchsEnCours = 'Matchs en cours';
$strMatchsFinales = 'Phases finales';
$strMatchsPoules = 'Matchs de poules';
$strMemoire = 'Mémoire';
$strMesEquipes = 'Mes équipes';
$strMessage = 'Message';
$strMessageLu = 'Messages déjà lus ';
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
$strMODSPANEL = 'Panel admin des Mods phpT installés';
$strModsProfil = 'Mod Affichage Profil';
$strMODDiver = 'Mods Divers';
$strMonEquipe = 'Mon équipe';
$strN = 'N';
$strNA = 'N/A';
$strNbLooser = 'Début Looser';
$strNbPlaces = 'Nombre de places';
$strNbPoules = 'Nombre Poules';
$strNbWinner = 'Début Finales';
$strNews = 'News';
$strNewseur = 'Newseur';
$strNewseurs='Newseurs';
$strNoData = 'Aucune donnée n\'est encore enregistrée';
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
$strPagePresentation = 'Page \'présentation\'';
$strPageReglement = 'Page \'réglement\'';
$strPageStats = 'Page \'statistiques\'';
$strPagesVues = 'Pages vues';
$strParticipants = 'Participants';
$strParticipe = 'Participe';
$strPasConnecte = 'Non connecté';
$strPasDInformation ='Pas d\'information disponible';
$strPasDeContact = 'Pas de contact';
$strPasDeDotation = 'Pas de dotation disponible';
$strPasDeDownload = 'Pas de download';
$strPasDeFichier = 'Pas de fichier';
$strPasDeLien = 'Pas de lien';
$strPasDeMatch = 'Pas de matchs';
$strPasDeMessage = 'Pas de message';
$strPasDeNews = 'Pas de news disponible';
$strPasDeReglement = 'Pas de réglement disponible';
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
$strPostePar = 'Posté par';
$strPoule = 'Poule';
$strPoules = 'Poules';
$strPreinscrit = 'Pré-inscrit';
$strPreinscrits='Pré-inscrits';
$strPrenom = 'Prénom';
$strPresentation = 'Présentation';
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
$strRecupMatchAB = 'Récupérer les matchs AdminBot-MX';
$strRecupMatchM4 = 'Récupérer les matchs M4';
$strRedigerMessage = 'Rédiger un nouveau message';
$strRegle = 'R&egrave;gle';
$strReglement = 'Réglement';
$strRemettreAZero = 'Remettre a zéro';
$strRepondre = 'Répondre';
$strRepondreMessage = 'Répondre à un message';
$strResultats = 'Résultats';
$strResultatsFinales = 'Résultats des phases finales';
$strResultatsMatchsPoules = 'Résultats des matchs de poules';
$strResultatsPoules = 'Résultats des poules';
$strRetour = 'Retour';
$strRule= 'R&egrave;gles';
$strS = 'X';
$strSInscrire = 'S\'inscrire';
$strSansDemo = 'sans données';
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
$strTempsDeConnexion = 'Durée';
$strTermine = 'Terminé';
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
$strToutDeselectionner = 'Tout désélectionner';
$strToutSelectionner = 'Tout sélectionner';
$strToutes = 'Toutes';
$strType = 'Type';
$strTypeTournois = 'Type de tournoi';
$strUnAllowJoinTeam='N\'autorise pas d\'&ecirc;tre ajouté à une équipe';
$strUnAllowPrivateMessage='N\'autorise pas de recevoir des MP publique';
$strUpdate='Mise à jour';
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
$tabMois = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Ao&ucirc;t', 'Septembre', 'Octobre', 'Novembre', 'Décembre');




$strServeursConsignes = '<li>Les champs marqués  <font color=red>*</font> sont obligatoires.
<li>Le protocole QStat permet d\'interroger des serveurs de jeux spécifiques (ex: HL->CS) pour connaitre leurs caractéristiques (etat,joueurs,pings, etc) et leur nom.
<li>Qstat ne fonctionnera que sur les hébergeurs disposant de la fonction \'exec\' dans PHP.
<li>Si vous utiliser M4 ou AdminBot-MX, vous devez obligatoirement cocher \'publier\' pour que cela fonctionne.
<li>Attention, le champ \'Rcon\' est obligatoire si vous utilisez AdminBot-MX.';

$strInscriptionsJoueursConsignes = '<li>Les champs marqués  <font color=red>*</font>  sont obligatoires.
<li>Le mot de passe demandé vous permettra de vous identifier et ainsi de pouvoir accéder à votre compte par la suite.
<li>Un lien d\'activation de votre compte vous sera envoyé sur votre email (il ne sera en aucun cas communiqué à un tiers).';

$strInscriptionsEquipesConsignes = '<li>Les champs marqués  <font color=red>*</font>  sont obligatoires.
<li>Vérifiez bien que votre équipe n\'a pas déjà été inscrite par un autre membre avant d\'en créer une.
<li>Le champ \'Nom\' précise le nom complet de votre équipe  (exemple : All Against Authority ou GoodGame).
<li>Le champ \'Tag\' précise le nom raccourci de votre équipe (exemple : aAa ou GG).
<li>Le manager de cette équipe pourra ajouter ses joueurs ou ils pourront le faire grâce au mot de passe.';

$strTournoisModifyConsignes = '<li>Le champ \'mode score\' correspond à la façon dont vont &ecirc;tre renseigné les scores. (si par exemple vous utilisez M4, il faudra absolument cocher cette case)<br />
<li>Le champ \'mode inscription\' définit si les joueurs/managers ont le droit de s\'inscrire pendant le statut \'inscription\' du tournoi.<br />
<li>Le champ \'nombre manches\' indique le maximum de round (map) par match.<br />
<li>Les champs \'page X\' désignent le nom du fichier Y dans le repertoire /include/html/X/langue/Y (langue = francais, etc..). (si ces champs sont vides, alors ces options seront désactivées dans le menu).<br />
<li>Le champ \'page statistiques\' indique l\'url vers le site web des statitiques pour ce tournoi.
<li>Le champ \'fichiers attachés\' indique si des fichiers peuvent &ecirc;tre uploadés pour chaque matchs.
<li>Le champ \'commentaires\' indique si les joueurs des matchs en question peuvent poster des commentaires.';

$strTournoisConsignes = '<li>Les champs marqués  <font color=red>*</font>  sont obligatoires et ne pourront pas &ecirc;tre modifiés par la suite.
<li>Le champ \'type\' indique si le tournoi est de type \'tournois\' (poules + finales), \'championnat\' (poules uniquement) ou \'coupe\' (finales uniquement).<br />
<li>Le champ \'mode équipe\' défini le mode de tournoi : par équipes, ou de joueurs.<br />
<li>Le champ \'mode matchs\' défini la méhode pour comptabiliser les scores ("points gagnés" se réf&egrave;re aux scores (rounds gagnés pour CS, frags marqués pour un duel UT2k4) et que "manches gagnées" se réf&egrave;re à la somme des manches par-delà la comptabilisation des points (un score de 13-10 pour CS correspond à une manche gagnée 1-0 par exemple)).<br />
<li>Le champ \'jeu\' doit &ecirc;tre renseigné si vous comptez utiliser l\'outil de gestion des maps et des serveurs.';

$strConfigurationConsignes = '<li>Les champs \'inscriptions xxx\' indique si les inscriptions générales des teams/joueurs sont actives ou non.<br />
<li>Le champ \'email inscription\' définit l\'adresse d\'emailing des inscriptions.<br />
<li>Le champ \'email contact\' définit l\'adresse de contact.<br />
<li>Les champs d\'options permettent d\'activer ou de désactiver certaines options suivant vos besoins (A vous de tester !!).<br />
<li>Les champs \'page X\' désignent le nom du fichier Y dans le repertoire /include/html/X/langue/Y (langue = francais, etc..). (si ces champs sont vides, alors ces options seront désactivées dans le menu).<br />
<li>Les options IRC permettent de configurer le module d\'IRC, les channels mentionnés (séparé par un espace) sont ceux qui seront automatiquement rejoint .<br />';


$strShoutbox= 'Shoutbox';
$strShoutboxlimit = 'Ligne(s) shoutbox';

$strDecroissant='Décroissant';
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
$strRemarqueEQUIPE='Remarque entre Admins sur l\'équipe :';
$strbbcode='Style de BBcode';
$strphpBB='BBcode';
$streditor='Editeur';
$strMODS='Panel ADMIN des MODS';
$strMODSC='Note : chaque bouton modifier traite TOUS les Mods';
$strMod='Mods Panel';
$strServerTeam='Ajouter les serveurs des équipes';

// auto validation d'équipe par le manager
$strValid_My_Team ='Valider mon Equipe';
$strManag_team ='Manager Valide Equipe';
$strTABmanaging='Mod validation Equipe';
$strManag_team_num ='Nombre de joueurs requis';
$strOk_validation='<b><span style="color:green">Votre équipe a bien été validée</span></b>';
$strNOOk_validation='<b><span style="color:red;font-size:12px">Votre équipe n\'a put &ecirc;tre validée.<br />Il manque encore des joueurs.<br />Si ce n\'est pas le cas, vérifiez que vous &ecirc;tes bien inscrit dans un des jeux<br />Aux quels participe votre équipe. Sinon contacter un ADMIN.</span></b>';
$strREQ_player='Nombre de joueurs requis pour valider une équipe :';
$strAuto_valid_def='Equipe validée d&egrave;s sa création';
// end auto validation d'équipe par le manager

$strSIDINV='Merci de fournir un Steamid pour vous enregistrer';
$strSIDINV2='Votre Steam ID doit &ecirc;tre de la forme : STEAM_X:X:XXXXXX';
$strSIDINV3='Ce Steam ID appartient déja à un joueur inscrit !';
$strSIDINV4='Steam ID invalide (cochez la case prévue à cet effet)';
$strSID='Steam ID';
$strSID2='Je ne joue pas à un jeu avec Steam :';
$strSteamIDO = 'Steamid-req';

$strPremium='Premium';


/********************************************************
 * Mod Rechercher un joueur
 */
$strRechercherJoueur='Rechercher un Joueur';
$strRechecrher='Rechercher';
$strRechInvalide='Désolé, aucun joueur n\'a été trouvé.';
$strRechInvalide2='Désolé, aucun joueur n\'a été trouvé.<br />Les pseudos approchant votre requête sont : ';
$strAc_rechehlp='Vous pouvez ne mettre qu\'une partie du pseudo ou "<span style"color:red">*</span>" pour rechercher tous les pseudos';
/********************************************************
 * END Mod rechercher un joueur
 */
 
 /********************************************************
 * Mod commandes
 */
$strAc_cnumid='numéro d\'identification de la commande qui est ajouté en bas dans \'annule expert\'.<br /><small><em><i>(Une case à cocher; une case grisée et cochée est déjà validée)</i></em></small>';
$strAc_R='Cocher les cases, desquels, le client a réceptionné (prit) sa commande.';
$strAc_C='Cocher les cases des commandes qui sont arrivées.<br />&nbsp;&nbsp;&nbsp;<i><em>(et donc que vos clients peuvent venir chercher)</em></i>';
$strAc_P='Cocher les cases des commandes qui ont été réglées ou sont payées.';
$strAc_A='Cocher les cases des commandes à supprimer<font color="#FF0000"><strong> définitivement</strong></font>.';
$strAc_euro='&euro;';
$strAc_infocmd='Informations sur la commande N&deg;';
$strAc_acmd='a commandé';
$strAc_nocmd='Pas de commandes';
$strAc_cmdmenu='Commandes';
$strAC_total='Totale';
$strAc_command='commande(s),';
$strAc_annueff='Annuler/effacer cette commande';
$strAc_anu='Mode Expert';
$strAc_readme='(Lisez ci-dessous avant toute modification)<br />Pour valider votre sélection cliquer sur [- OK -]';
$strAc_cmddejapasser='la commande général est déjà passée';
$strAc_wdoyouwant=', désirez-vous valider ou annuler ?';
$strAc_cmdlancer='Commandes lancées';
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
$strAc_recep='Réception';
$strAc_cmdarriver='Commandes arrivées';
$strAc_annulation='Annulation';
$strAc_prix='Prix';
$strAc_cmdnum='Commandes N&deg;';
$strAc_thx='- Merci -';
$strAc_Composition='Composition';
$strAc_histr='Historique des commandes de : ';
$strAc_cmdtrt='Commande traitée';
$strAc_areg='(à régler)';
$strAc_cmdestarrive='- Votre Commande est arrivée ! -';
$strAc_rechcmdno='Pas de commandes passées ou conservées';
$strAc_tuveupi='Tu veux une pizza ? ;-)';
$strAc_comvalide='- Commande validée -';
$strAc_comannulee='- Commande annulée -';
$strAc_again='En commander une autre ? :';
$strAc_noagain='Commander :';
$strAc_similies=' - ;-) -';
$strAc_nocmdactual='- Nous ne prenons plus de commandes pour le momment -';
$strAc_nolatetotakeit='- Ne tardez pas à les récupérer d&egrave;s qu\'ils arrivent ! -';
$strAc_cmddejapass='- La commande a été passée.';
$strAc_wewait='- Nous attendons que les &quot;articles&quot; soient livrées. -';
$strAc_nottime='-Il n\'est sans doute pas encore l\'heure -';
$strAc_notactive='-Les commandes ne sont pas activées.-';
$strAc_listnick='La recherche a toutefois trouvée des pseudos équivalents';
$strAc_listnickfailed='La recherche n\'a trouvée aucun pseudo équivalent à celui de votre requ&ecirc;te';
$strAC_alertea='Cette action signalera à tous les clients de cette liste\nQue leur commande est arrivée.\n(ils peuvent la récupérer et/ou la payer)';
$strAC_alerteregle='Cette action fera que toutes les commandes de cette liste\nSeront considérées comme ayant été payées.';
$strAC_alerteprit='Cette action fera que toutes les commandes de cette liste\nSeront considérées comme ayant été donnée aux clients\n';
$strAC_alertedel='ATENTION !!!\nVous allez effacer définitivement\nLa totalité de cette commandes';
$strAc_youareadmin='Allez à la page admin';
$strAc_ifcmdok='Si vos commandes ont été livrées et distribuées, cliquez sur "commandes lancées"<br />pour mettre les commandes en OFF';
$strAc_consae='<p align="left">Les deux cases ci-dessus se 
remplissent toutes seules. La premi&egrave;re va noter les <span style="color:#0000FF"><strong>ID</strong></span> des commandes 
que vous avez demandez à effacer.<br />La deuxi&egrave;me va compter le nombre de cases que vous avez coché.
<br /><br />< color="#009900"><strong>En cas d\'erreur (vous ne vouliez pas cliquez sur une case) :
</strong><br /> Il vous suffit de supprimer l\'<span style="color:#0000FF"><strong>ID </strong>de la liste et 
le &quot;pipe&quot; (symbole &quot;|&quot;) qui se trouve à sa droite.</span><br />Exemple 2|6|33| vous 
voulez retirer l\'ID 6 alors vous mettrez : 2|33|. Enfin retranché 1 
dans la case qui suit.<br />Exemple pour 2|6|33| elle affichait \'3\' avec 2|33| vous retranché 1 à 3 ce qui
vous donne 2.<br />Rien ne vous emp&ecirc;che d\'ajouter aussi, n\'oubliez seulement pas d\'incrémenter la case qui suit ;)</p><p align="left"><small>Si vous trouvez cela trop compliqué  cliquez sur <strong>
<span style="""color:#FF0000">RESET</span></strong>. Cela effacera tout :).</small></p><p align="left"><small>Si vous &ecirc;tes doué en Javascript et que vous savez coder la fonction inverse de l\'affichage 
n\'ésiter pas à vous manifester<br />(Gectou4 AT hotmail . com).</small></p><p align="left">
<small>Bonne LAN ;)</small></p>';
$strAc_artfin='\'??|&iquest;&iquest;\'est le status de votre commande &quot;<spans style="color=:#FF0000">??</span>&quot; Si votre 
commande est réglée ou non. &quot;<span style="color=#FF0000">&iquest;&iquest;</span>&quot; 
Si votre commande est arrivée ou non.<br /></em></font>';
$strAc_nocmdsry='- Pas de commandes -';
$strAc_youneedloginfirst='Vous devez d\'abord &ecirc;tre logué';
$strAc_pannier='Votre &quot;panier&quot;/historique';
$strAc_commander='Commander';
$strACAlredyExist = 'Article existant';
$strAC_podevirg='utiliser le . à la place de la , pour le prix ! Et utiliser un format numerique';
/********************************************************
 * END Mod commandes
 */
$strlastvisit = 'Dernière visite le :';
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
$strAcces='Accés';
$strTous='Tous';
$strModifierPageR ='Modifier la page dans quelle rubrique ?';
$strModifierPage='Modifier la page';
$strElementsOdreInvalide='L\'ordre d\'affichage du menu doit &ecirc;tre un chiffre';
$strAlign='Align';
$strGauche='Gauche';
$strDroite='Droite';
$strHide='Caché';
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
$strCPPN='Pts Egalité';
$strCPPL='Pts Perdant';
$strCPPF='Pts Forfait';

$strAddPageConsignes = '<li>Titre : celui de la page (pour vous y retrouver quand vous 
 voudrez la modifier).<br />
 <li>Rubrique : Si la page appartient à une m&ecirc;me rubrique/dossier. 
 (un menu déroulant <br />
 vous propose les rubriques existantes).<br />
 <li>N&deg; de page : Ca sert pas vraiment mais &ccedil;a définit 
 parmi la rubrique la premi&egrave;re page et les autres.<br />
 <li>Menu : Le menu dans lequel sera la page (si vide, la page devra 
 &ecirc;tre relier avec un lien via une autre page).&nbsp; <br />
 <li>Lien : Texte du lien dans le menu.<br />
 <li>Ordre : Position du lien dans le menu.&nbsp;<br />
 <li>Accés : Définit si la page requiert un rang spécial 
 (membre logué, visiteur, admin ou newseur) <br />L\'admin à accé 
 à toutes les pages.<br />
 <br />
 <li><img src="images/bb_codescript.gif" border="0" /> Apparait si vous autoriser 
 le html dans le panel de configuration.<br />
 Tous script doit &ecirc;tre placé entre les balises [script] [/script] 
 pour &ecirc;tre interprété.<br />
 &nbsp;';
 //////mod ladder
 $strModsladder='Ladder Admin Panel';
 $strLadder='Ladder';
 $strLadlist='Sélectionner un ladder';
 $strMODAddlad='Ajouter un ladder';
 $strLadjeux='Jeu';
 $strLadType='Type';
 $strRegLad='Réglement du ladder';
 $strLadName='Nom du ladder';
 $strMODlistlad='Modifier quel ladder ?';
 $strLadNameMod='Modifier un ladder';
 $strladnodatafoundlist='Il n\'existe encore aucun ladder';
 $strLadduel='Lancer un duel';
 $strLadduel1='Lancer un duel avec le joueur';
 $strLadduele='Lancer un duel avec l\équipe';
 $strLadduel2='Défier ce joueur';
 $strMODAdddel='Effacer un ladder';
 $strMODAddclose='Fermer un ladder';
 $strLadalreadyexist='Notifier un autre nom, celui-ci est déja utilisé';
 $strDefier='Défier';
 $strfrancaisladmail=' voici son message : ';
 $strfrancaisladmailopp=' Vous avez été défié par ';
 $strLaditsyou='Vous ne pouvez vous défier vous m&ecirc;me !';
 $strEcrireMessageLAD='Rédiger une demande de duel';
 $strLadnothingcont='Aucun message spécifié !';
 $lstrladdual=' Duel !';
 $strLADj1='J1 a validé';
 $strLADjv='Valider';
 $strLADnotagree='Autre proposition'; // EDITED
 $strLADj2='J2 a validé';
 $strEcrireRApLAD='Rédiger un rapport';
 $strLADRapport='Rapport';
 $strLADneednumeric='Les scores doivent &ecirc;tre au format décimal.';
 $strLADneedrap='Vous devez rédiger un rapport !';
 $strLADcheater='!  !  ! T R I C H E U R  !  !  !';
 $strLADagree='Confirmer';
 $strLADpoints='Points';
 $strLadderV='PtsLad Victoire';
 $strLadderP='PtsLad Défaite';
 $strLadderN='PtsLad Egalité';
 $strLADnotagree='Contester';
 $strLADres='Résultats du match';
 $strLADcomment ='Commentaires sur le match '; 
 $strLADNocoment='Aucun commentaire n\'a été laissé.';
 $strLADfairadv='Fair Play de votre adversaire ';
 $strLadMylad='Mes Ladders, Mes matchs';
 $strLADother='';
 $strLADneedvalid='Vous devez Affirmer ou Infirmer le rapport !';
 $strLadVAl='Panel de validation et de status de vos matchs';
 $strPasDeFonctionMailLAD = 'Désolé mais la fonction de mail est désactivée<br />Nous vous invitons à consulter le profil de l\'utilisateur<br />que vous souhaitez défier dans le cas où il aurait notifié d\'autre mail de contact. <br /><br /><b><u>Un message lui à cependant été délivré par la messagerie du site !</u></b>';
 $strPasDeFonctionMailLADT = 'Désolé mais la fonction de mail est désactivée<br />Nous vous invitons à consulter le profil du manager de l\'équipe<br />que vous souhaitez défier dans le cas où il aurait notifié d\'autre mail de contact. <br /><br /><b><u>Un message lui à cependant été délivré par la messagerie du site !</u></b>';
 $strLADvalidnotagreeCont='A contesté votre rapport. Nous vous invitons à confronter vos résultats,\nà revalider chacun le match. En cas de litige continue appellez un admin.';
 $strLADvalidnotagree='Validation de ladder REFUSEE';
 $strLADcheckref='Cliquez ici pour allez voir le match en question';
 $strLadermesmail='vous a défié dans un Ladder. \nRendez-vous dans la section Ladder/mes matchs ou répondez à ce message.';
 $strLadMaps = 'Maps';
 $strLadDefpts = 'Points par défaut';
 $strLadpourcent = 'Pourcentage';
 $strladpts  = 'par points';
 $strladteam = 'par participant'; 
 $strLad_needname = 'Le ladder doit avoir un nom';
 $strLad_needrules = 'Le ladder doit avoir un réglement';
 $strLadderADD = '<li class="lib">le pourcentage, s\'il ne vaut pas 0, définit quel participant le joueur ou l\'équipe aura le droit d\'affronter.<br />Si le pourcentage est de 5% alors seules les équipes ayant plus ou moins de 5% d\'écart de points pourront &ecirc;tre opposées<li class="lib"> "maps" définit si les joueurs doivent préciser la map sur laquelle ou lesquelles ils joueront.<li class="lib">"point par défaut" Permet de classer les équipes à partir d\'un palier. Ainsi les nouveaux arrivants sont généralement "au milieu" et non "en bas" ce qui est plus équitable ';
 $strLadclosemode = 'Statut du ladder';
 $strLadclose = 'Fermé';
 $strLadopen = 'Ouvert';
 $strRapport = 'Rapport';
 $strLad_agree='Confirmation de Match';
 $strLAD_refusal='Refuser';
 $strLAD_msgMatch='Vous pouvez accepter, proposer un autre challenge ou refuser à la page ci-dessous :';
 $strLAD_is_agree = 'a accepté le challenge';
 $strLAD_is_disagree = 'a proposé un autre challenge';
 $strLAD_is_disagree2 = 'a refusé le challenge';
 $strLAD_incom = 'Un concurent vous défit';
 $strLAD_incom2 = 'Votre concurent a accepté le defi';
 $strLAD_incom3 = 'Votre concurent propose un autre défi';
 $strLAD_incom4 = 'Votre concurent a refusé le defi';
 $strLAD_admin_title = 'Alerte à la triche';
 $strLAD_admin = 'Une tentative de validation de match non autorisée a été perpétrée.<br /><br />(par un joueur non concerné ou le match était déja validé et auquel cas le joueur incriminé est arrivé sur cette page en tapant par url, les données du match ou a peut-&ecirc;tre recliqué sur le lien de validation qui lui a été soumis)<br /><br/>Afin de prévenir tous risques, nous avons préferé vous avertir.<br />Voici les données du joueur concerné :';
 $strLAD_youdontabletodothis ='Vous n\'&ecirc;tes pas autorisé à effectuer cette action.<br />Ceci a été considéré comme une tentative de tricherie.<br />Un message avec votre pseudo et IP a été envoyé aux admins de ce site';
 $strLAD_refalert = 'Veuillez proposer d\'autres données avant de valider';
 $strLAD_refusealert = 'Avec cette option la validation du formulaire causera la suppression direct des données concernant ce challenge.';
 $strLAD_other_prupose = 'Autre proposition';
 $strLAD_reply = 'Votre message :';
 $strLAD_MDate = 'Date du match';
 $strLAD_MatchR = 'Rapport de fin de Match'; 
 $strLAD_roundscore = 'Nombre de rounds gagnés par :';
 $strLAD_fragscore = 'Nombre de frags total de :';
 $strLAD_deathscore = 'Nombre de morts total de :';
 $strLAD_logresult = 'Résultat de Match';
 $strLAD_round = 'Round';
 $strLAD_constest = 'A contesté les résultats et propose les suivants :';
 $strLAD_you_must_be_wait = 'Vous devez attendre que votre adversaire ait confirmé';
 $strLAD_endmatch_agree = 'Résultat confirmé';
 $strLAD_fact = 'Facteurs Statistiques';
 $strLAD_nodata_match = 'Aucun match n\'a été trouvé';
 $strLAD_nodata_player = 'Aucun joueur n\'a été trouvé';
 $strLAD_nodata_rule = 'Aucun réglement';
 $strLAD_nodata_for_match = 'Aucun match proposé et accepté n\'a été trouvé';
 $strLAD_nodata_for_player = 'Aucun joueur n\'est inscrit';
 $strLAD_nodata_for_result = 'Aucun résultat n\'a été enregistré';
 $strLAD_lastmatch = 'Dernier Match';
 $strLAD_lastresult = 'Dernier résultat';
 $strLAD_yournotmanager = 'Vous n\'&ecirc;tes le manager d\'aucune équipe';
 $strLAD_whosteam = 'Quelle équipe intégrer ?';
 $strLAD_myunmatch= 'Mes matchs : nécessitant ma validation';
 $strLAD_myvmatch = 'Mes matchs : nécessitant des résultats';
 $strLAD_mytmatch = 'Mes matchs : terminés';
 $strLAD_valid_this = 'Panneau d\'acceptation / refus';
 $strLAD_my_match_p = 'Mes match : proposés';
 $strLAD_impose = 'l\'Admin décide le match entre :';
 $strLAD_is_imp = 'a imposé le match';
 $strLADfairadv_1='Fairplay adversaire 1';
 $strLADfairadv_2='Fairplay adversaire 2';
 $strLADAdminMaps = '<small>(Garder CLTR enfoncé pour sélectionner plusieurs maps <br />ou désélectionner une map en recliquant sur une map sélectionnée)<br /></small>';
 $strLAD_wanttoleft = 'Voulez-vous quitter ce ladder ?\nToutes vos données sur ce dernier seront effacées';
 //end ladder
 
 //mod FAQ
$str_faq_choose='<font size="2" color=blue><b>Choisissez une catégorie :</b></font>';
$str_faq_admin='.: ADMIN :.';
$str_faq_al1='<font size="2" color="red"><b>Il faut d\'abord qu\'une catégorie existe</b></font><br /><br />';
$str_faq_al2='<font size="2" color="red"><b>Il faut d\'abord qu\'il y ait des questions</b></font><br /><br />';
$str_faq_al3='<font size="2" color="red"><b>Il faut d\'abord au moins 2 catégories</b></font><br /><br />';
$str_faq_al4='<font size="2" color="red"><b>Il faut d\'abord au moins 2 questions</b></font><br /><br />';
$str_faq_al5='<font size="2" color="green"><b>Catégorie effacée</b></font><br /><br />';
$str_faq_al6='<font size="2" color="red"><b>Pas de champ vide merci :)</b></font><br /><br />';
$str_faq_actA='Ajouter catégorie';
$str_faq_actB='Ajouter question/réponse';
$str_faq_actC='Modifier Catégorie';
$str_faq_actD='Modifier Question/Réponse';
$str_faq_actE='Réorganiser catégorie';
$str_faq_actF='Réorganiser Question/Réponse';
$str_faq_actG='Effacer catégorie';
$str_faq_actH='Effacer Question/Réponse';
$str_faq_actI='Interchanger Question/Réponse';
$str_faq_addq='Question ajoutée';
$str_faq_addqr='Ajouter une question/réponse :';
$str_faq_in='Dans la catégorie :';
$str_faq_q='Question :';
$str_faq_r='Réponse :';
$str_faq_par='Par :';
$str_faq_nothing='Il n\'y a pas de question dans cette catégorie';
$str_faq_inter='Question interchangée !';
$str_faq_mettre='Mettre :';
$strFaq='FAQ :';
$str_faq_error='Désolé mais il n\'existe encore aucune catégorie à consulter';
$strLAD_map_error = 'Vous devez d\'abord avoir définit un jeu pour le ladder';
 //end FAQ
 
 //FORUM 
 $strAjouterReponse='Ajouter une réponse';
 $strModifyReponse='Modifier une réponse';
 $strFLast='dernier message par :';
 $strTopic='Sujet :';
 $strTopicde='Créé par :';
 $strAjouterCategorie='Ajouter une catégorie';
 $strDesc='Description';
 $strEffcaerCategorie='Effacer catégorie';
 $strFdep='Déplacer les sujets dans '; 
 $strFneedlog='Vous devez &ecirc;tre loguer pour pouvoir<br />créer ou répondre à un sujet.';
 $strFdelall='Effacer sans déplacer';
 $strFras='Il n\'existe encore aucune catégorie';
 $strEditeCategorie='Editer la catégorie';
 //v2
 $strFNbpage ='Page N°';
 //$strAvec='avec';
 $strFnbtop='topics';
 $strFnbsub='réponses';
 $strFnbtdd='et par ordre';
 //$strCroissant='Croissant';
 $strDecroissant='Décroissant';
 $strModo='Modo';
 $strFedit='Message édité le :';
 $strBy='par';
 //end v2
 $strForumnbpost='Nb. post sur forum';
 $strNbpost='Messages';
 $strRkforum='Titre forum';
 $strAjouterTopic='Ajouter Topic';
 $strWhereDep='Déplacer le sujet dans la catégorie';
 $strDepsujet='Déplacer tout le sujet';
 $strDelsujet='Effacer ce post';
 $strEdsujet='Editer ce post';
 $strReservedTo='Accessible à';
 $strReservedTonb='<br />Note : les admins acc&egrave;s partout, décocher tout pour une catégorie réservée aux admins';
 $strDelCatCookie='Supprimer les cookies de cette catégorie';
 $strIWTL='Fermer ce sujet';
 $strIWTUL='Ouvrir ce sujet';
 $strSujet='Sujet';
 $strMessage='Messages';
 $strDernier='Dernier';
 $strFrasUnacces='Aucune catégorie n\'est prédisposée à votre statut. Loguez-vous si ce n\'est pas encore fait.<br />Sinon contactez un admin en précisant votre rang (user, manager, modo...).';
 $forum_need_more_ac='<small>Les réponses trouvées nécéssitent un plus haut rang d\'approbation pour &ecirc;tre vues</small>';
 $strPost_id = 'Post n°';
 $strPost_link = 'Vous pouvez utiliser le lien dans le champ de texte ci-dessou pour créer un lien direct à ce message';
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
$strNoresultnow='Pas encore de résultat...';
$strNonewsnow='Pas encore de news';
$strtop10_mod='Mod du type "TOP"';

/* Fichier plan.php */
$strLibre = 'Libre';
$strEquipePresente = 'Equipe déjà présente dans la salle';
$strEquipeNonDefini = 'Aucune équipe n\'a été sélectionnée';
$strJoueurNonManager= 'Vous n\'&ecirc;tes manager d\'aucune équipe';
$strChoixEmplacement = 'Choisir un emplacement';
$strSelectionEquipeConsignes = '<li>Seuls les managers d\'équipe peuvent réserver les places. L\'emplacement que vous sélectionnez est <font color=red>uniquement un souhait</font> de placement.</li>
<li>Si vous souhaitez changer d\'emplacement, contactez l\'admin</li>';
$strAdministrationReservation = 'Administration de Plan de la Salle';
$strPlanSalle = 'Plan de la Salle';

//admin tournois
//special arbitre
$strarbitre = 'Les Arbitres';
$strInscriptionsTournoisArbitre = 'Ne contacter un admin qu\'en cas de nécessité';

//search
$strTopic='Topic';
$strFLast='De';
$strRechecrher='Rechercher';
$strRechercher='Rechercher';
$strRechercherJoueur='Chercher un joueur';
$strElementsSearchInvalide='Elément de recherche non spécifié';
$strSearchUnresult='Aucun résultat trouvé';
$strS_listtnick_error='Aucun joueur n\'a été trouvé.';
$strS_listnick='La recherche a toutefois trouvé des joueurs proches';
$strS_listteam_error='Aucune équipe n\'a été trouvée.';
$strS_listteam='La recherche a toutefois trouvé des équipes proches';
$strS_listnews_error='Aucune news n\'a été trouvée.';
$strS_forum_error='Aucun topic n\'a été trouvé';
$strS_nomatch = 'Désolé la recherche a échouée.';
$strRechercherSteam=' Rechercher un Steam ID ';
$strS_listtsteam_error=' Aucun Steam ID n\'a été trouvé';
$strS_liststeam='La recherche a toutefois trouvé des Steam ID proches';
$strElementsSteamInvalide='Vous devez spécifier un Steam ID';
// end search




// RANK
$strRang_a='Est Admin-Master';
$strRang_b='Est Admin';
$strRang_c='Peut modifier config & mod';
$strRang_d='Peut gérer les Downloads';
$strRang_e='Peut gérer les Equipes';
$strRang_f='Est FAQ-Master';
$strRang_g='Est Web-Master';
$strRang_h='Peut gérer les Affiliés (liens)';
$strRang_i='Peut gérer le livre d\'or';
$strRang_j='Peut gérer les joueurs';
$strRang_k='Peut gérer le plan de salle';
$strRang_l='Peut gérer la Malling-list';
$strRang_m='Est Modérateur';
$strRang_n='Est Newser';
$strRang_o='A acc&egrave;s au menu admin';
$strRang_p='G&egrave;re les Partenaires';
$strRang_q='G&egrave;re la Galerie';
$strRang_r='G&egrave;re les Serveurs';
$strRang_s='G&egrave;re les Sponsors';
$strRang_t='G&egrave;re les Tournois/maps/jeux';
$strRang_u='G&egrave;re les Ladders/maps/jeux';
$strRang_v='G&egrave;re M4 et AdminBOT';
$strRang_w='Peut éditer les Pouvoirs';
$strRang_x='Manager d\'une équipe au moins';
$strRang_y='Waranger d\'une équipe au moins';
$strRang_z='User (sinon = banni)';
$strEdit_rang='Editer les pouvoirs';
$strRang_wrong='Vous ne pouvez pas éditer les pouvoirs d\'un Admin-Master <br />si vous n\'en n\'&ecirc;tes pas un !';
//RANK
$strFLOG='Les admins souhaitent que tous les utilisateurs s\'identifient';
$strFtitle_sec='Sécurité';
$strFtitle='Forcer le login';

// fix BBcode JAVA
$strL_BBCODE_B_HELP='Texte gras: [b]texte[/b] (alt+b)';
$strL_BBCODE_I_HELP='Texte italique: [i]texte[/i] (alt+i)';
$strL_BBCODE_U_HELP='Texte soulignéé: [u]texte[/u] (alt+u)';
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
$strAlignHelp='Alignement du texte: [align=center]Texte centré[/align]';
$strAlign='Aligner';
$strLeft='A Gauche';
$strRight='A Droite';
$strCenter='Centrer';
$strJustify='Justifier';
$strSurligner='Surligner';
$strSurligner_help='Surligner le texte [bgcolor=red]Text surligné en rouge[/bgcolor]';
// end fox BBcode JAVA

// MOD LEFT TEAM
$strLeaveTeam='Quitter cette équipe';
$strLeaveTeamALERT='Souhaitez-vous vraiment quitter cette équipe ?';
// END MOD LEFT TEAM

//pc
$strADMINPANEL='Panel d\'administration.';
// end pc

//sondage
$strBaseInexistante='La base de donnée n\'existe pas, elle ne pourra donc pas &ecirc;tre mise à jour.';
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
$strConfirmDelSondage = 'Désirez-vous supprimer le sondage';
$strConfirmCloseSondage = 'Désirez-vous fermer le sondage';
$strVoteSondage = 'Voter pour le sondage';
$strSondClosed = '(Fermé)';
$strAlreadyVoted = 'Vous avez déjà voté sur ce sondage';
$strVote = 'Vote(s)';

//update  & install :
$strConfiguration_general='Configuration générale';
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
$strsess_cookie_min = 'Durée du cookie';
$strsess_gc_days = 'Session (gc) en jours';
$strstats_timeout = 'Durée de conservation des stats';
$strflood_time = 'Temps de flood';
$strx_delta_simple = 'Arbre simple';
$strx_delta_double = 'Arbre double';
$strcol_equipes = 'colonne équipes';
$strcol_joueurs = 'colonne joueurs';
$strcol_poules = 'colonne poules';
$strcol_matchs_poules = 'colonne matchs de poule';
$strcol_maps = 'colonne maps';
$strcol_jeux = 'colonne jeux';
$strcol_serveurs = 'colonne serveurs';
$strcol_administrateurs = 'colonnes admins';
$strcol_avatar_gallerie = 'colonnes avatars (galeries)';
$strcol_sponsors = 'colonnes sponsors ';
$strcol_categories = 'colonne catégories';
$strcol_gallery_thumb = 'colonne gallery (thumb)';
$strtm4rulecfg = 'fichier .cfg des r&egrave;gles de M4';
$strm4campscfg = 'type de camps';
$strm4autostartcfg = 'auto-start';
$strm4prolongationcfg = 'prolongation';
$strabrulecfg = 'r&egrave;gles cfg';
$strabcampscfg = 'type de camps';
$strabautostartcfg = 'auto start';
$strabprolongationcfg = 'prolongation';
$strInstallStage3Delupdatel = 'Attention! le fichier update.php n\'a pu &ecirc;tre supprimé<br /><u>Pour la sécurité de votre site</u> il est <u>impératif</u> que vous alliez le supprimer manuellement';

//news english
$strNews2='Version Anglaise';
$strElementsTitreInvalide2='Titre de la news Anglaise invalide';
$strElementsContenuInvalide2='Contenu de la news Anglaise invalide';
$strNewsUK='Activer news Anglaise';

$str_phptteam = "Cordialement,<br />l&acute;équipe de phpTournois";
$X = 'Attente de confirmation du challengé';
$A = 'Attente de confirmation du challengeur';
$B = 'En attente de résultat';
$D = 'Match Proposé';
$V = 'Match Terminé';

//Export 
$strEXPORT_tree = 'Exporter l\'arbre du tournois';
$strEXPORT_done = 'Arbre exporter avec succés dans include/export/f_';
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

$strContactout = ', Vous a contacté par le forumlaire de contact phpTG4.<br />Mais le mail n&#39a pas pus vous &ecirc;tre envoyé.<br />Voici son message :<br />';
$strPMED = 'Le message à donc été envoyez en MP';
$strPMED_no = 'Le message n\'a pas pus &ecirc;tre envoyé par MP : pas de mail configuré';
$install_error = 'Vous ne pouvez procéder à une installation tant que le fichier g4.g4 est à la racine de phpTG4 !';


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
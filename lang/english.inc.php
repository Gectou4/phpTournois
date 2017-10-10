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
define('DAY_POS','2'); // en fr, le position du jour est 1 => 27/xx/xxxx
define('MONTH_POS','1'); // en fr, le position du mois est 2 => xx/02/xxxx
define('YEAR_POS','3'); // en fr, le position de l'anN°e est 3 => xx/xx/2002

// date d'affichage
define('DATESTRING','%m/%d/%Y %H:%M');
define('DATESTRING1','%m/%d/%Y at %H:%M');
define('DATESTRING2','%m/%d/%Y');

$strPasDeTableau = "No group found";

$strJoueursConsignes = '<li>Definitive registration of a player (from  \'pre-registered\' to \'registered\' state) is done by the admin when all is OK (payment, fee, etc).
<li>Only \'registered\' players could participate to solo tournaments.';

$strEquipesConsignes = '<li>Definitive validation of a team (from \'pre-registered\' to \'registered\' state) is done by the admin when all is OK (complete team, ALL players registered, payment, etc).
<li>Only \'registered\' teams can participate to team tournament.
<li>\'Registered\' column\'s format is "registered players number - pre-registered players number"';

$strRapporterConsignes = '<li>Only the both teams\' managers (or the solo players) could enter or validate the score.
(For example, the looser enters the score, and the winner validates, or the contrary)';

$strRejoindreEquipesConsignes = '<li>Fields marked  <font color=red>*</font> are necessary.
<li>You should ask your team\'s password to your manager to join your team.';

$strHorairesTournoisConsignes = '<li>Date\'s format is "mm/dd/yyyy hh:mm" or just "hh:mm" for today.
<li>Date\'s update will only be done for hidden or active matches.';

$strMapsTournoisConsignes = '<li>Maps update will only be done for hidden or active matches.';

$strServeursTournoisConsignes = '<li>Usable servers are those defined in the general administration for the game of the current tournament.
<li>Servers update will only be done for hidden or active matches.';

$strAdminSponsorsConsignes = '<li>Fields marked  <font color=red>*</font> are necessary.
<li>Sponsors pictures are in folder "images/sponsors".';

$strAdminLiensConsignes = '<li>Fields marked  <font color=red>*</font> are necessary.
<li>Links pictures are in folder "images/liens".';

$strAdminJeuxConsignes = '<li>Fields marked  <font color=red>*</font> are necessary.
<li>Games pictures are in the folder "images/jeux".';

$strIRCMessage = 'IRC (Internet Relay Chat) is a real-time chat network.<br><br>
You can join us on server\'s (%serveur%) channel(s) %chans% with an external software: <a href="irc://%serveur%/%chan%"><img src="images/icon_irc.gif" border="0" align="absmiddle"></a><br><br>
or<br><br>
with the java applet directly included in this site thanks to the link below:';

$strUploadFichierConsignes = '<li>Field marked  <font color=red>*</font>  is necessary.
<li>Maximum file size: ';

$strRapporterResultats = 'Report results';
$strMatchAttenteResultats = 'Matches with pending results';
$strMatchAttenteValidation = 'Matches with pending validation';
$strTournoisEnCours = 'Tournaments in progress';
$strTournoisTermines = 'Tournaments finished';
$strValiderScore = 'Validate score';
$strRefuserScore = 'Refuse score';
$strValidation = 'Validation';
$strConflit = 'Conflict';
$strAssignerPoules = "Assign accordingly to the group's ranking"; 
$strMethodeRandom = '\'random\' method';
$strMethodeSeed = '\'seeded\' method';
$strMethodeCroise = '\'crossed\' method';
$strPageDecharge = '\'discharge\' page';
$strConditionsGenerales = 'General conditions';
$strJeRefuse = 'I refuse';
$strJAccepte = 'I accept';
$strErreurMatchABPresent = 'Match in AB database found!';
$strErreurMatchM4Present = 'Match in M4 database found!';
$strRecupOk = "Recovery OK!";
$strDans = 'in';
$strAuto = 'Auto';
$strRecupMatchAuto = 'Automatic recovery of the matches of ';
$strChangerElimination = 'Are you sure you want to change the tournament tree\\\'s type ?';
$strConfirmDesincrireTeam = 'Are you sure you want to unregister your team from this tournament ?';
$strConfirmDesincrire = 'Are you sure you want to unregister yourself from this tournament ?';
$strSeDesinscrire = 'Unregister';
$strDesinscrire = 'Unregister';
$strAppletPJIRC = 'Java applet PJIRC';
$strPopup = 'Popup';
$strDevenirPartenaire = 'How to become partner';
$strInscriptionsEquipes = 'Teams registration';
$strInscriptionsJoueurs = 'Players registration';
$strInstall = 'Installation';
$strFloodDetect = 'You must wait '.$config['flood_time'].' seconds before you can retry this operation';
$strErreurNbPlaces = 'Number of places must be greater than 0';
$strErreurJoueurAppartient = 'The player is already a member of this team';
$strInscriptionsTournoisConsignes = '<li>Tournament\'s registrations are open only for registered/validated players/teams.';
$strRejoindreUneEquipe = 'Join a team';
$strRejoindreCetteEquipe = 'Join this team';
$strPasswordRejoindre = 'Password<br>(to join)';
$strPasDeFonctionMail = 'Sorry but mail function is deactivated';
$strContactMessageEmail = 'This is a contact message from %nomsite% site where';
$strInstallStage1 = 'Database\'s configuration';
$strInstallStage1Consignes = 'Please enter database\'s parameters';
$strInstallStage1Consignes2 = 'Click here to configure';
$strInstallStage2 = 'phpTournois configuration';
$strInstallStage2Consignes = 'Please enter the name and the url of your site and select the type of installation';
$strInstallStage2Consignes2 = 'Please enter the login and password of the admin account';
$strInstallStage3 = 'Congratulations! phpTournois is correctly installed.';
$strInstallStage3Consignes = '<div align=left><blockquote>When using phpTournois, remember that this is free software released under the <b>QPL License</b>.<br>
So you must repect the following conditions : <br>
<li> Free software doesn\'t mean that you can do what you want with it(1st condition)<br>
<li> It is strictly forbiden to remove completely or partially the lines wich refer to the authors (2nd condition)<br>
<li> It is strictly forbidden to remove or change the copyrights</b> (3rd condition) By removing or modifying this lines, you expose yourselves to justice proceedings.<br>
<li> You <b>must</b> publish the modifications you carried out on the code (in the forum for example) and the team reserve rights as of re-using them (4th condition)<br>
<li> QPL licence prevents you to fork phpTournois (4th condition)<br>
</blockquote></div>Consult the INSTALL & README files for more informations about phpTournois.<br><br>Click here to go to your fresh installation : <a href=index.php>GO !</a>';
$strInstallStage3DelInstall = 'Warning! the file install.php can\'t be deleted<br><u>For your site security,</u> it is <u>STRONGLY RECCOMENDED</u> to delete this file manually';
$strFichierSqlManquant = 'Missing Sql file';
$strPaypal = 'Make a donation to this site via PayPal. It\'s fast and free !';
$strPermissionInvalideConfigFile = 'Configuration file does not have write permission';
$strOuvertureInvalideConfigFile = 'Cannot open configuration file';
$strEcritureInvalideConfigFile = 'Cannot write configuration file';
$strPageDemarrage = 'Start page';
$strDBHost = 'Mysql hostname';
$strDBUser = 'Mysql user';
$strDBPass = 'Mysql password';
$strDBName = 'Mysql database name';
$strDBPrefix = 'Table prefix';
$strVersion = 'Version';
$strPasDeServeur = 'No server found';
$strPasDEquipe = 'No team found';
$strPasDeJoueur = 'No player found';
$strPasDeTournoi = 'No tournament found';
$strMoi = 'Me';
$strMatchsTermines = 'Finished matches';
$strMatchsCaches = 'Hidden matches';
$strElementsManagerInvalide = 'Invalid manager';
$strNouvelleEquipe = 'New team';
$strCachee = 'Hidden';
$strCaches = 'Hidden';
$strCachees = 'Hidden';
$strLeader= 'Leader';
$strWarArranger = 'War arranger';
$strMembre = 'Member';
$strRecrue = 'Newbie';
$strInactif = 'Inactive';
$strExMembre = 'Ex-member';
$strModifierDownload = 'Modify this download';
$strModifierSponsors = 'Modify this sponsor';
$strModifierTournois = 'Modify this tournament';
$strModifierLiens = 'Modify this link';
$strModifierPartenaires = 'Modify this partner';
$strValide = 'Valid';
$strIncomplete = 'Incomplete';
$strTableau = 'Table';
$strChangerStatusEquipe = 'Are you sure you want to change this team\\\'s status ?';
$strDonation = 'Donation';
$strYIM = 'YIM';
$strFonction = 'Function';
$strMail = 'Mail';
$strSmtp = 'Smtp';
$strSmtpServeur = 'Server';
$strSmtpUser = 'SMTP user';
$strSmtpPassword = 'SMTP password';
$strOptionsMail = 'Mail options';
$strThemeDefaut = 'Default theme';
$strMessageEnvoi = 'The message has been sent succesfully.';
$strErreurMessageEnvoi = 'The message cannot be sent.';
$strConfirmIncrireTeam = 'Are you sure you want to register your team at this tournament ?';
$strConfirmSIncrire = 'Are you sure you want to register yourself at this tournament ?';
$strPreInscription = 'Pre-registration';
$strEnAttente = 'Pending';
$strEquipeValidee = 'validated teams';
$strEquipeEnAttente = 'pending teams';
$strValidee = 'Validated';
$strValidees = 'Validated';
$strAttenteMail = 'Pending mail';
$strSteam = 'Steam';
$strPartenaires = 'Partners';
$strWWW = 'Web';
$strAvatar = 'Avatar';
$strAvatars = 'Avatars';
$strModifierAvatar = 'modify this avatar';
$strConfirmEffacerAvatar = 'Delete this avatar ?';
$strCreerEquipe = 'Create a team';
$strPageGeneree = 'Page generated in';
$strSecondes = 'seconds';
$strAvatarUploadLocal = 'Send a local avatar';
$strAvatarUploadRemote = 'Send a remote avatar';
$strAvatarLienRemote = 'Link a remote avatar';
$strSousCategories = 'Sub categories';
$strPermissionInvalide = 'Invalid permissions';
$strGalerieInconnue = 'Unknown gallery';
$strGalerie = 'Gallery';
$strPasDImage = 'No image found';
$strImageInconnue = 'Unknown image';
$strImages = 'Images';
$strGDAbsent = 'Missing GD library on this server';
$strExtensionNonSupporte = 'Extension not allowed';
$strNewsEnvoiSubject = '[%nomsite%] News !!';
$strNewsEnvoiMessage = 'This is a news from <b>%nomsite%</b> site which can be interesting for you : <br><br>%link%';
$strNewsEnvoiConfirm = 'An email has been sent to your friend !';
$strEnvoyerNews = 'Send this news';
$strVotreEmail = 'Your email';
$strSonEmail = 'Friend\'s email';
$strOptionsAvatars = 'Avatar\'s options';
$strAvatarUpload = 'Avatar\'s upload';
$strAvatarRemote = 'Remote avatars';
$strAvatarGallerie = 'Avatars gallery';
$strAvatarTailleMax = 'Max size';
$strAvatarDimensionsMax = 'Max Size';
$strPixels = 'pixels';
$strVoirGallerie = 'Show the gallery';
$strElementsEmailExistant = 'Existing email';
$strAvatarErreurUrl = 'URL is not correct !';
$strAvatarErreurConnexion = 'The server cannot connect to the url for downloading !';
$strAvatarErreurData = 'URL doesn\'t correspond to correct data!';
$strAvatarErreurWrite = 'Write forbidden on this server!';
$strAvatarErreurFileSize = 'The image file size is invalid ';
$strAvatarErreurFileType = 'The image type is invalid ';
$strAvatarErreurXYSize = 'The image dimensions are invalid ';
$strEnLigne = 'Online';
$strAdminsEnLigne = 'Admins online';
$strPublicEnLigne = 'Public online';
$strQuiEnLigne = 'Who is online';
$strVisiteurs = 'Visitors';
$strMembres = 'Members';
$strTotal = 'Total';
$strSans = 'Without';
$strArticleDuSite = 'This article came from the site';
$strURLArticle = 'The URL of this article is';
$strSeRappeler = 'Remember';
$strNvPassIdent = 'The new passwords must be equal!';
$strResetPass = 'Password reset';
$strOubliPass = 'Forgotten password ?';
$strEnvoiPass = 'Request email with password';
$strCodeConfirmation = 'Confirmation code';
$strElementsJoueurInvalide = 'Invalid player';
$strElementsEquipeInvalide = 'Invalid team';
$strELementsCodeInvalide = 'Invalid code';
$strPasswordEmailCode = '[%nomsite%] Code for the new password';
$strPasswordEmailCodeMessage = 'You requested a new password via email.<br><br>You must enter this code just after your nickname : <b>%code%</b><br><br>PS: If you are not at the origin of the password request, please ignore this email!';
$strPasswordMessageCode = 'The code for requesting a new password has been sent to you by email!';
$strPasswordEmail = '[%nomsite%] New password';
$strPasswordEmailMessage = 'This is the new password for your account : <b>%passwd%</b><br><br>Don\'t forget to change it as soon as possible!';
$strPasswordMessage = 'Your new password has been sent to you by email!';
$strPasswordMessageAdmin = 'The new password is : <b>%passwd%</b><br><br>It has been sent to the account owner by email too!';
$strPasswordEnvoiConsignes = '<li>Enter your nickname and click on the \'send\' button. An automatic email with a code will be sent to you. <li>Re-enter your nickname and this code and you will receive a new password by email.';
$strAdminPartenaires = 'Partners administration';
$strAjouterPartenaire = 'Add a partner';
$strConfirmEffacerPartenaire = 'Delete this partner ?';
$strPartenaireDepuisLe = 'Partner since ';
$strPasDePartenaires = 'No partner found';
$strPasDeSponsor = 'No sponsor found';
$strSponsor = 'Sponsor';
$strEnSavoirPlus = 'Read more...';
$strSite = 'Site';
$strSuite = 'Next...';
$strCategories = 'Categories';;
$strPetite = 'small';
$strGrande = 'wide';
$strErreur404 = '404 error !';
$strErreur404Explain = 'The requested page is not reachable...';
$strLoguePourPoster = 'For site security, you must be logged for posting comments';
$strMatchInvalide = 'Invalid match !';
$strCommentairesMatch = 'Matches comments';
$strModeCommentaire = 'Comments';
$strPasDeCommentaire = 'No comment found';
$strConfirmEffacerFile = 'Delete this file ?';
$strAjouteLe = 'Add the';
$strFichier = 'File';
$strFichierInvalide = 'Invalid file';
$strUploaderFichier = 'Upload file in  ';
$strParticipePourPoster = 'You must be a member of one of the 2 teams or a player of this match in order to post comments.';
$strManagerPourUploader = 'You must be the manager of one of the 2 teams or a player of this match in order to post file.';
$strTournoisParticipe = 'Playing tournaments';
$strTournoisAParticipe = 'Played tournaments';
$strModeMatchScore = 'Match mode';
$strFragAverage = 'Pure frags';
$strRoundAverage = 'Pure round';
$strRoundAverageFragAverage = 'Round and frags';


$PHPMAILER_LANG = array();
$PHPMAILER_LANG["provide_address"] = 'You must provide at least one recipient\'s email address.';
$PHPMAILER_LANG["mailer_not_supported"] = ' mailer is not supported.';
$PHPMAILER_LANG["execute"] = 'Could not execute: ';
$PHPMAILER_LANG["instantiate"] = 'Could not instantiate mail function.';
$PHPMAILER_LANG["authenticate"] = 'SMTP Error: Could not authenticate.';
$PHPMAILER_LANG["from_failed"] = 'The following From address failed: ';
$PHPMAILER_LANG["recipients_failed"] = 'SMTP Error: The following recipients failed: ';
$PHPMAILER_LANG["data_not_accepted"] = 'SMTP Error: Data not accepted.';
$PHPMAILER_LANG["connect_host"] = 'SMTP Error: Could not connect to SMTP host.';
$PHPMAILER_LANG["file_access"] = 'Could not access file: ';
$PHPMAILER_LANG["file_open"] = 'File Error: Could not open file: ';
$PHPMAILER_LANG["encoding"] = 'Unknown encoding: ';



$strM4Admin = 'M4';
$strABAdmin = 'AdminBot-MX';
$strValidationEmail = 'Email validation';
$strModeFichier = 'Attached files';
$strA = 'at'; // scheduling: at 19:00 PM
$strAEcrit = 'wrote';
$strAIM = 'AIM';
$strAccueil = 'Home';
$strActif = 'Active';
$strActivationInvalide = 'Invalid Activation';
$strActiverMatch = 'Activate matches';
$strAdmin = 'Admin';
$strAdminBot= 'AdminBot-MX';
$strAdminDownloads = 'Downloads administration';
$strAdminEquipes = 'Teams administration';
$strAdminFinales = 'Finals administration';
$strAdminHoraires = 'Schedule administration';
$strAdminJeux = 'Games administration';
$strAdminJoueurs = 'Players administration';
$strAdminLiens = 'Links administration';
$strAdminLivreDor = 'Guest Book administration';
$strAdminMaps = 'Maps administration';
$strAdminMatchsPoules = 'Group\'s matches administration';
$strAdminNews = 'News administration';
$strAdminPoules = 'Groups administration';
$strAdminServeurs = 'Servers administration';
$strAdminSponsors = 'Sponsors administration';
$strAdminTournois = 'Tournament\'s administration';
$strAdministrateur = 'Admin';
$strAdministrateursTournois = 'Tournament\'s administrators';
$strAdmins = 'Admins';
$strAdresse = 'Address';
$strAge = 'Age';
$strAjouter = 'Add';
$strAjouterCommentaire = 'Add a comment';
$strAjouterEquipe = 'Add team';
$strAjouterFichier = 'Add a file';
$strAjouterJeu = 'Add game';
$strAjouterJoueur = 'Add player';
$strAjouterLien = 'Add a link';
$strAjouterMap = 'Add map';
$strAjouterNews = 'Add a news';
$strAjouterServeur = 'Add a server';
$strAjouterSignature = 'Add a signature';
$strAjouterSponsor = 'Add a sponsor';
$strAjouterTournois = 'Add tournament';
$strAleatoire = 'Random';
$strAllowJoinTeam='Allow to join a team';
$strAllowPrivateMessage='Allow private messages';
$strAn = 'Age';
$strAncienPass = 'Old password';
$strAncienPassInvalid = 'Invalid old password';
$strAnnuler = 'Cancel';
$strAssignerAleatoirement = 'Proceed randomly';
$strAssignerInscriptionSeed = 'Assign accordingly to the inscription seed';
$strAucune='None';
$strAutoajoutTeam='Disponibility;';
$strAutoMp='Mailbox';
$strAutoStart= 'AutoStart';
$strAutorefresh = 'Auto-refresh';
$strAutoscroll = 'Auto-scroll';
$strAvecDemo = 'demo';
$strAvg = 'Avg';
$strBLACK = 'Black';
$strBLUE = 'Blue';
$strBROWN = 'Brown';
$strCYAN = 'Cyan';
$strCache = 'Hidden';
$strCalendrier = 'Calendar';
$strCalendrierMatchs = 'Matches planning';
$strCamps = 'Camps';
$strManager = 'Manager';
$strManagers= 'Managers';
$strCarteGraphique = 'Graphic card';
$strCarton= 'Card';
$strCategorie = 'Category';
$strCentrer = 'Centered';
$strChampionnat = 'Championship';
$strChangerDevise = 'Change the motto';
$strChangerFinales = 'Are you sure you want to change the start of the finals  ? \n\n(WARNING, this operation erases the final tree)';
$strChangerLooser = 'Are you sure you want to change the start of the looser finals ? \n\n(WARNING, this operation erases the looser tree)';
$strChangerPoules = 'Are you sure you want to change the number of groups ? \n\n(WARNING, this operation erases all groups matches)';
$strChangerStatusTournois = 'Are you sure you want to change the tournament\\\'s status ? \n\n(WARNING, this operation is recommended for power admins only)';
$strChangerStatusJoueur = 'Are you sure you want to change this player\\\'s status ?';
$strChangerStatusParticipe = 'Are you sure you want to modify this inscription\\\'s status ? \n\n(WARNING, this operation alters matches and final trees)';
$strChercherJoueur = 'Search a player';
$strChoisirAuHasard = 'Choose randomly';
$strCloturerInscriptions = 'Close registrations ?';
$strCloturerLesInscriptions = 'Are you sure you want to close registrations ?';
$strCode = 'Code';
$strCodePostal = 'Zip Code';
$strCocheforwrite1 = 'Rewrite config.php file ?';
$strCocheforwrite2 = 'Rewrite config.m4.php file ?';
$strCocheforwrite3 = 'Rewrite config.ab.php file ?';
$strColorerCode='Display syntaxed code';
$strCommentaires = 'Comments';
$strConfiguration = 'Configuration';
$strConfirm = 'Confirm';
$strConfirmEffacerCommentaire = 'Delete this comment ?';
$strConfirmEffacerDownload = 'Delete this download ?';
$strConfirmEffacerEquipe = 'Delete this team ?';
$strConfirmEffacerJeux = 'Delete this game ?';
$strConfirmEffacerJoueur = 'Delete this player ?';
$strConfirmEffacerLien = 'Delete this link ?';
$strConfirmEffacerMap = 'Delete this map ?';
$strConfirmEffacerMessage = 'Delete this message ?';
$strConfirmEffacerNews = 'Delete this news ?';
$strConfirmEffacerServeur = 'Delete this server ?';
$strConfirmEffacerSignature = 'Delete this signature ?';
$strConfirmEffacerSponsor = 'Delete this sponsor ?';
$strConfirmEffacerTournois = 'Delete this tournament ?';
$strConnecte = 'Connected';
$strConnecter = 'Log in';
$strConnexion = 'Log in';
$strConnexionImpossible = 'Database connection failed!';
$strConsignes = 'Tips';
$strContact = 'Contact';
$strContactDown = "<u>ClubRezo</u><br>Ecole Polytechnique de l'Université de Nantes<br>rue Christian Pauc<br>44300 Nantes FRANCE<br>Email : <a href=\"mailto: $config[emailcontact]\"><b><u>$config[emailcontact]</u></b></a>";
$strContactUp = 'To contact us, you can use your favorite email client <a href="mailto: %email%"><img src="images/icon_email.gif" border="0" align="absmiddle"></a> or you can fill this form:';
$strContenu = 'Contents';
$strCouleur = 'Color';
$strCoupe = 'Cup';
$strCreationImpossible = 'Creation of phptournois database failed!';
$strCreer = 'Create';
$strCustTheme = 'Theme selector';
$strDARKBLUE = 'Dark blue';
$strDARKED = 'Dark red';
$strDate = 'Date';
$strDe = 'From';
$strDeconnexion = 'Log out';
$strDerniersTitres = 'Last titles';
$strDescription = 'Description';
$strDestinataire = 'Recipient';
$strDestinataires = 'Recipients';
$strDevise = 'Motto';
$strDispute = 'Play';
$strDisqualifie = 'Disqualified';
$strDotations = 'Prizes';
$strDoubleElimination='Double';
$strDownloads = 'Downloads';
$strE = 'E'; // E for Edit
$strEMail = 'E-Mail';
$strEcrireMessage = 'Write a message';
$strEditerJoueur='Edit user status';
$strEffacer = 'Erase';
$strEditer = 'Edit';
$strElementsAdresseInvalide = 'Invalid address';
$strElementsAgeInvalide = 'Invalid age';
$strElementsAuteurInvalide = 'Invalid author';
$strElementsCatInvalide = 'Invalid order';
$strElementsContenuInvalide = 'Invalid content';
$strElementsDescriptionInvalide = 'Invalid description';
$strElementsDestinataireInvalide = 'Invalid recipient';
$strElementsEmailInvalide = 'Invalid email';
$strElementsEquipeExistante = 'Existing team';
$strElementsFinalesInvalides = 'Invalid \'Winner\' finals';
$strElementsFinalesLooserInvalides = 'Invalid \'Looser\' finals';
$strElementsIconeInvalide = 'Invalid icon';
$strElementsImageInvalide = 'Invalid image';
$strElementsIncorects = 'One or more elements are not correct';
$strElementsJeuxInvalide = 'Invalid game';
$strElementsJoueurExistant = 'Existing player';
$strElementsServerNameInvalide='Invalid server name';
$strElementsServerIpInvalide='Invalid Server IP';
$strElementsNewsInvalide = 'Invalid news';
$strElementsNomInvalide = 'Invalid name';
$strElementsOrigineInvalide = 'Invalid origin';
$strElementsPasswordInvalide = 'Invalid Password';
$strElementsPortInvalide = 'Invalid Port';
$strElementsPoulesInvalides = 'Invalid groups';
$strElementsPrenomInvalide = 'Invalid first name';
$strElementsPseudoInvalide = 'Invalid nickname';
$strElementsSigleInvalide = 'Invalid tag';
$strElementsTagInvalide = 'Invalid tag';
$strElementsTailleInvalide = 'invalid size';
$strElementsTitreInvalide = 'Invalid title';
$strElementsUrlInvalide = 'Invalid URL';
$strElementsVilleInvalide = 'Invalid town';
$strEmailContact = 'Contact email';
$strEmailInscription = 'Registration email';
$strEmetteur = 'Sender';
$strEnCours = 'Playing';
$strEnvoyer = 'Send';
$strEquipe = 'Team';
$strEquipes = 'Teams';
$strEquipesInscrits = 'Registered teams';
$strErreur = 'ERROR';
$strErreurDeSaisie = 'Mistake detected !';
$strErreurEquipeManquante = 'Missing teams';
$strErreurLogin = 'Authentication failure!';
$strErreurMancheActive = 'No active round! At least one round must be created and activated.';
$strErreurMapManquante = 'Missing map!';
$strErreurMatchM4Manquant = 'Missing match in AB database!';
$strErreurMatchM4Manquant = 'Missing match in M4 database!';
$strErreurPremiereManche = 'No first round! Please create and activate at least one round for this match.';
$strErreurServeurManquant = 'Missing server!';
$strErreurStatusActif = 'Bad status! this match must be activated to be launched.';
$strErreurStatusCache = 'Bad status! this match must be hidden to be activated.';
$strErreurStatusDemarre = 'Bad status! this match must be launched to be retrieved.';
$strEtat = 'Status';
$strFiche = 'Card';
$strFichiersAttaches = 'Attached files';
$strFichiersAttachesMatch = 'Attached files for match';
$strFinale = 'Final';
$strFinales = 'Finals';
$strFinalesType = 'Elimination';
$strForfait = 'Withdrawn';
$strForum = 'Forum';
$strFrags = 'Frags';
$strG = 'W';
$strGREEN = 'Green';
$strGagne = 'Win';
$strGeneral = 'Menu';
$strGenerationFinales = 'Finals validation';
$strGenerationPoules = 'Groups validation';
$strGrandFinal = 'Grand Final';
$strGras = 'Bold';
$strGzip = 'Gzip Compression';
$strHidemenu = 'Hide-menu';
$strHistoriqueNews = 'News archive';
$strHits = 'Hits';
$strHoraires = 'Schedule';
$strHorloge = 'Clock';
$strICQ = 'ICQ';
$strINDIGO = 'Indigo';
$strIp = 'IP';
$strIcone = 'Icon';
$strImage = 'Image';
$strInformations = 'Informations';
$strInscriptionConfirmMessage = 'Your registration just succeeded<br>You will receive a confirmation e-mail that contains an activation link.<br><br>See you, and good frags!!<br><br>organizing team.';
$strInscriptionConfirmMessageOK = 'Your registration just succeeded<br><br>Don\'t forget to send us the registration fee<br><br>You can connect to your personal zone and configure your team if you are the manager<br><br>See you, and good frags!!<br><br>organizing team.';
$strInscriptionConfirmMessageEmail = 'Thanks for you registration to \'%nomsite%\'.<br><br>Do not forget your identifiers below to log in later:<br>------------------<br> Login : <b>%login%</b><br> Pass: <b>%password%</b><br>------------------<br><br><font color=red>CAREFUL, click on the link to finish your pre-registration</font>: %link%<br><br>See you, and good frags!!<br><br>The organizing team.<br><br>';
$strInscriptionConfirmSubjectEmail = '[%nomsite%] Confirmation of the pre-registration';
$strInscriptionMessage = 'Your registration just succeeded<br>Do not forget your identifiers:<br>Login : <b>%login%</b><br>Pass: <b>%password%</b><br><br>You can connect to your personnal zone and configure your team if you are the manager<br><br>See you, and good frags!!<br><br>The organizing team.';
$strInscriptions = 'Registrations';
$strInscrire = 'Register';
$strInscrit = 'Registered';
$strInscrite = 'Registered';
$strInscrits='Registered';
$Installtype='Installation type:';
$Installtype2 ='Choose installation type';
$strIrc = 'Irc';
$strIrcChannels = 'Channels';
$strIrcPassword = 'Password';
$strIrcPort = 'Port';
$strIrcServeur = 'Server';
$strItalique = 'Italics';
$strJ = 'P'; //Played
$strJeu = 'Game';
$strJeux = 'Games';
$strJoin = 'Join';
$strJoinAvecHlla = "To join the server with the link '$strJoin', you have to download .hlla <a href=\"downloads/hlla0704.exe\">>here<</a> or on <a href=\"http://www.hlla.net\" target=_blank><span style=\"vertical-align: middle;\"><img src=images/hlla.gif align=absmidlle border=0></span></a> and install it";
$strJoueur = 'Player';
$strJoueurs = 'Players';
$strJoueursInscrits = 'Registered players';
$strJoueursPreinscrit = 'Pre-registered players';
$strKOctets = 'Kb';
$strLan = 'Lan';
$strLancerMatch = 'Start matches';
$strLancerMatchAB = 'Start AdminBot-MX matches';
$strLancerMatchM4 = 'Start M4 matches';
$strLangue = 'Language';
$strLangueDefaut = 'Default Language';
$strLe = '';
$strLeaveTeam='Leave this team';
$strLeaveTeamALERT='Do you really want to leave this team ?';
$strLeaveTeambody1='Hello,\nWe inform you, your team member : ';
$strLeaveTeambody2='\n\nleft your team by himself.\n\nThx for your attention.';
$strLeaveTeambodyM1='Hello,\nNWe inform you that the team\'s manager: ';
$strLeaveTeambodyM2='\n\nKicked you from the team.\n\nThx for your attention.';
$strLeaveTeamM='You can\'t leave this team until you manage it';
$strLeaveTeamtitle='Left your team !';
$strLeaveTeamtitleManager='Your manager kicked you from the team';
$strLiens = 'Links';
$strLireMessage = 'Mailbox';
$strListe = 'List';
$strLivreDor = 'Guestbook';
$strLogin = 'Login';
$strLogo = 'Logo';
$strLooser = 'Looser';
$strM4 = 'M4';
$strM4ID = 'Clan #';
$strMOctets = 'Mb';
$strMSN = 'MSN';
$strMaFiche = 'My card';
$strMailing = 'Mailing';
$strMailNotconfig = 'SMTP Server not defined or user not defined';
$strMaintenance = 'DOWN';
$strManche = 'round';
$strManchesMax = 'Number of Rounds';
$strManuel = 'Manual';
$strMap = 'Map';
$strMaps = 'Maps';
$strMatch = 'Match';
$strMatchs = 'Matches';
$strMatchsActifs = 'Scheduled matches';
$strMatchsEnCours = 'Playing matches';
$strMatchsFinales = 'Finals matches';
$strMatchsPoules = 'Groups matches';
$strMemoire = 'Memory';
$strMesEquipes = 'My teams';
$strMessage = 'Message';
$strMessageLu = 'Read messages';
$strMessageNouveau = 'New messages';
$strMessagerie = 'Mail';
$strMinutes = 'minutes';
$strMode = 'Mode';
$strModeEquipe = 'Team mode';
$strModeInscription='Register mode';
$strModeScore = 'Score mode';
$strModifPass = 'Change password';
$strModifier = 'Modify';
$strModifierConfiguration = 'Modify configuration';
$strModifierNews = 'Modify this news';
$strModifierServeur = 'Modify this server';
$strMods_ladder = 'Admin CP of ladder';
$strMODSPANEL = 'Admin panel of installed mods';
$strModsProfil = 'Card Filling Mod';
$strMODDiver = 'Various Mods';
$strMonEquipe = 'My team';
$strMotif='Reason';
$strN = 'E'; //even
$strNA = 'N/A';
$strNbLooser = 'Start looser';
$strNbPlaces = 'Number of seats';
$strNbPoules = 'Groups number';
$strNbWinner = 'Start finals';
$strNews = 'News';
$strNewseur = 'Newser';
$strNewseurs='Newsers';
$strNoData = 'No data registered at this time';
$strNom = 'Name';
$strNomTournois = 'Tournament\'s name';
$strNon = 'No';
$strNouveauJoueur = 'New player';
$strNouveauPass = 'New password';
$strNouvelleEquipe = 'New Team';
$strNul = 'Equality';
$strOK = 'OK';
$strOLIVE = 'Olive';
$strORANGE = 'Orange';
$strOctets = 'bytes';
$strOptions = 'Options';
$strOptionsIrc = 'IRC Options';
$strOrigine = 'Origin';
$strOui = 'Yes';
$strP = 'L'; //Lost
$strPageDotations = '\'Prizes\' page';
$strPageInformations = '\'Informations\' page';
$strPageNotlist = 'You haven\'t any rubrique at this time';
$strPageNotlist2 = 'You haven\'t any menu at this time';
$strPagePresentation = '\'Presentation\' page';
$strPageReglement = '\'Rules\' Page';
$strPageStats = '\'Statistics\' page';
$strPagesVues = 'Seen pages until site is online';
$strParticipants = 'Participants';
$strParticipe = 'Participate';
$strPasConnecte = 'Not logged in';
$strPasDInformation ='No information found';
$strPasDeContact = 'No contact found';
$strPasDeDotation = 'No prize found';
$strPasDeDownload = 'No download found';
$strPasDeFichier = 'No files found';
$strPasDeLien = 'No link found';
$strPasDeMatch = 'No match found';
$strPasDeMessage = 'No message found';
$strPasDeNews = 'No news found';
$strPasDeReglement = 'No rules found';
$strPasDeSignature = 'No signature found';
$strPassword = 'Password';
$strPCMODS = 'Configure mods';
$strPerdu = 'Lost';
$strPhaseFinales = 'Finals matches';
$strPhasePoules = 'Groups matches';
$strphpt_type = 'phpTournois utilisation type';
$strPing = 'Ping';
$strPolice = 'Font';
$strPort = 'Port';
$strPostePar = 'Posted by';
$strPoule = 'Group';
$strPoules = 'Groups';
$strPreinscrit = 'Pre-registered';
$strPreinscrits='Pre-registered';
$strPrenom = 'First Name';
$strPresentation = 'Presentation';
$strProcesseur = 'Processor';
$strProlongation = 'Extended play';
$strPseudo = 'Nickname';
$strPts = 'Pts';
$strPublierServeurDans = 'Publish in';
$strQstatProtocole= 'Protocol Qstat';
$strQuitter = 'Quit';
$strQuote = 'Quote';
$strRED = 'Red';
$strRang = 'Rang';
$strRecupMatchAB = 'Retreive AdminBot-MX matches';
$strRecupMatchM4 = 'Retreive M4 matches';
$strRedigerMessage = 'Write a new message';
$strRegle = 'Rule';
$strReglement = 'Rules';
$strRemettreAZero = 'Reset';
$strRepondre = 'Reply';
$strRepondreMessage = 'Reply to a message';
$strResultats = 'Results';
$strResultatsFinales = 'Finals results';
$strResultatsMatchsPoules = 'Groups matches results';
$strResultatsPoules = 'Groups results';
$strRetour = 'Back';
$strRule= 'Rules';
$strS = 'X';
$strSInscrire = 'Apply';
$strSansDemo = 'empty data';
$strScore = 'Score';
$strSeed = 'Seed';
$strSemaine = 'Week';
$strServeur = 'Server';
$strServeurs = 'Servers';
$strSigle = 'Tag';
$strSignature = 'Signature';
$strSimpleElimination='Simple';
$strSouligner = 'Underlined';
$strSponsors = 'Sponsors';
$strSrv = 'Srv';
$strStatistiques = 'Statistics';
$strStats = 'Stats';
$strStatus = 'Status';
$strSupprimer = 'Delete';
$strSupport = 'Technical Support';
$strTableauxPoules = 'Groups results';
$strTag = 'Tag';
$strTaille = 'Size';
$strTempsDeConnexion = 'Time';
$strTermine = 'Over';
$strTerminerLeTournois = 'Do you want to end the tournament ?';
$strTerminerLesPoules = 'Do you want to end the groups ?';
$strTerminerPoules = 'Finish groups';
$strTerminerTournois = 'Finish the tournament';
$strTitre = 'Title';
$strTitres = 'Titles';
$strTour = 'Turn';
$strTournois = 'Tournament';
$strTous= 'All';
$strTout = 'all';
$strToutDeselectionner = 'Select none';
$strToutSelectionner = 'Select all';
$strToutes = 'All';
$strType = 'Type';
$strTypeTournois = 'Tournament type';
$strUnAllowJoinTeam='Disallow to join any team';
$strUnAllowPrivateMessage='Disallow any private message';
$strUpdate='Up-to-Date';
$strURL = 'URL';
$strUrl = 'Link';
$strVIOLET = 'Purple';
$strVS = 'VS';
$strVainqueur = 'Winner';
$strValeur = 'Value';
$strValider = 'Validate';
$strValiderFinales = 'Validate the finals';
$strValiderLesFinales = 'Do you want to validate the finals ?';
$strValiderLesPoules = 'Do you want to validate the groups ?';
$strValiderPoules = 'Validate the groups';
$strVille = 'City';
$strVisites = 'visits';
$strWHITE = 'White';
$strWeb = 'Web site';
$strWinner = 'Winner';
$strYELLOW = 'Yellow';
$tabJoursSemaine = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
$tabMois = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');




$strServeursConsignes = 'Instructions:<br><li>Fields marked  <font color=red>*</font> are required.
<li>QStat protocol allows to connect to special servers (ex: HL->CS) to know their caracteristics (status,players,pings, etc) and their name.
<li>Qstat works only on webhosters who support \'exec\' function in PHP.
<li>If you use M4 or AdminBot-MX, you have to \'tick\' them in order to insert them in the M4 or Adminbot database.
<li>Careful, \'Rcon\' field is required if you use AdminBot-MX.';

$strInscriptionsJoueursConsignes = 'Instructions:<br><li>Fields marked  <font color=red>*</font> are required. 
<li>Asked password will allow you to authenticate and access to your account later. 
<li>Your e-mail must be valid to validate your account (it will not be given to anyone else).';

$strInscriptionsEquipesConsignes = 'Instructions:<br><li>Fields marked  <font color=red>*</font> are required. 
<li>Verifiy that your team is not already created by another member before creating one.
<li>Field \'Name\' indicates the full name of your team (example : All Against Authority or GoodGame).
<li>Field \'Tag\' indicates the short name of your team (example : aAa or GG).
<li>Team leader can add players in his team or they can do it themselves if they know the password.';

$strTournoisModifyConsignes = '<li>Field \'score mode\' corresponds to the way scores are retrieved. (for example if you use M4, you need to tick it)<br>
<li>Field \'inscription mode\' is used to define if the players/managers can register to the tournament during the registering period.<br>
<li>Field \'number of rounds\' indicates the maximum number of round (map) per match.<br>
<li>Fields \'page X\' are the names of the file Y in the folder /html/X/langue/Y (lang = english, etc..). (if these fields are empty, these options will be disabled in the menu).<br>
<li>Field \'statistics\' indicates the url of the stats web site for this tournament.
<li>Field \'Uploaded file\' indicates if files can be uploaded for each match.
<li>Field \'comments\' indicates if the matches\' players can post comments on them.';

$strTournoisConsignes = "<li>Fields marked  <font color=red>*</font>  are required.
<li>Field 'type' indicates if the tournament is a 'tournament' (groups + finals), 'championship' (only groups) ou 'cup' (only finals).<br>
<li>Field 'team mode' defines the mode of tournament: in team or alone.<br>
<li>Field 'match mode' defines the mode of scoring management.<br>
<li>Field 'game' must be filled if you want to use the tool to manage maps and servers .";

$strConfigurationConsignes = "<li>Field 'registrations' indicates if the general registrations of teams/players are enabled or not.<br>
<li>Field 'registration email ' defines the address to reply to for registrations emails.<br>
<li>Field 'contact email' defines the contact email address.<br>
<li>For the others options, it's up to you !!.<br>
<li>Fields 'page X' are the names of the file Y in the folder /html/X/langue/Y (lang = english, etc..). (if these fields are empty, these options will be disabled in the menu).<br>
<li>IRC options allow you to configure IRC module, channels mentioned (separated by a space) are those performed on connect.<br>";

$strShoutbox= 'Shoutbox';
$strShoutboxlimit = 'Shoutbox line(s)';

$strDecroissant='Decreasing';
$strAvec = 'with';
$strArchiveshout = 'Archives';
$strCroissant='Increasing';
$strShoutdesc = 'and by order';
$strShoutNbcom = 'Comments'; 
$strShoutNbpage = 'Page &#035;';
$strShoutboxlimitc = 'Max caracters.';
$shoutoption = 'Display option';


/////////////////////MOD
$strServerName='Server name';
$strADD_t_server='Display your server on the site';
$strADMINNOTE='Note between admins';
$strRemarque='Comments between admins on the player :';
$strRemarqueEQUIPE='Comments between admins on the team :';
$strbbcode='BBcode style';
$strphpBB='BBcode';
$streditor='Editor';
$strMODS='MODS Admin Panel';
$strMODSC='Note : Each \'modify\' button treats every MOD';
$strMod='Mods Panel';
$strServerTeam='Add teams servers';

// auto validation d'équipe par le manager
$strValid_My_Team ='Validate my team';
$strManag_team ='Manager validates team (if..see line below)';
$strTABmanaging='Mods team validation';
$strManag_team_num ='Number of players needed';
$strOk_validation='<b><span style="color:green">Your team has been validated</span></b>';
$strNOOk_validation='<b><span style="color:red;font-size:12px">Your team could not be validated.<br>There are still players missing.<br>If its not the case, make sure you\'re registered in one of the games<br>in which your team is participating. Otherwise, contact an admin.</span></b>';
$strREQ_player='Number of players needed to validate a team :';
$strAuto_valid_def='Team validated at their creation';
// end auto validation d'équipe par le manager

$strSIDINV='Please enter your SteamID to register ';
$strSIDINV2='Your SteamID must be written like this : STEAM_X:X:XXXXXX';
$strSIDINV3='Your SteamID is being used by another player !';
$strSIDINV4='Invalid SteamID (check the needed box)';
$strSID='SteamID';
$strSID2='I don\'t play online games with Steam :';
$strSteamIDO = 'Steamid required';

$strPremium='Premium';


/********************************************************
 * Mod Rechercher un joueur
 */
$strRechercherJoueur='Find a player';
$strRechecrher='Find';
$strRechInvalide='Sorry, no results found.';
$strRechInvalide2='Sorry, no results found.<br>The similar nicknames found are : ';
$strAc_rechehlp='You can enter only a part of the nickname or "<font color="red">*</font>" to search for every nickname';
/********************************************************
 * END Mod rechercher un joueur
 */
 
 /********************************************************
 * Mod commandes
 */
$strAc_cnumid='Command ID added at the bottom in \'expert mode\'.<br><font size="-1"><em><i>(A gray checked check box is a box already validated)</i></em></font>';
$strAc_R='Check the boxes when the costumer received his items.';
$strAc_C='Check the boxes when the items are ready.<br>&nbsp;&nbsp;&nbsp;<i><em>(So your customers can come and take them)</em></i>';
$strAc_P='Check the boxes of the paid items.';
$strAc_A='Check the boxes of the items to be deleted&nbsp;<font color="#FF0000"><strong>definitively</strong></font>.';
$strAc_euro='$';
$strAc_infocmd='Information on the general order n.';
$strAc_acmd='requested';
$strAc_nocmd='No items';
$strAc_cmdmenu='Orders';
$strAC_total='Total';
$strAc_command='item(s),';
$strAc_annueff='Cancel/delete this order';
$strAc_anu='Expert Mode';
$strAc_readme='( Read under this before adding any modification )<br>To validate your selection, click on [- OK -]';
$strAc_cmddejapasser='The order has already been taken';
$strAc_wdoyouwant=', Do you want to validate or cancel ?';
$strAc_cmdlancer='Order in progress';
$strAc_enlever='Delete item';
$strAc_ajouter='Add item';
$strAc_lister='Read the order (validate/cancel)';
$strAc_commandes='Orders';
$strAc_add='Add';
$strAc_name='Name';
$strAc_art='The items';
$strAc_arti='Item';
$strAc_wlisting='Display which listing ?';
$strAc_paiment='Payment';
$strAc_recep='Delivery';
$strAc_cmdarriver='Order arrived';
$strAc_annulation='Cancellation';
$strAc_prix='Price';
$strAc_cmdnum='Order N.';
$strAc_thx='- Thank you -';
$strAc_Composition='Composition';
$strAc_histr='Order history of : ';
$strAc_cmdtrt='Order taken';
$strAc_areg='(to pay)';
$strAc_cmdestarrive='- Your item has arrived ! -';
$strAc_rechcmdno='No order passed or taken';
$strAc_tuveupi='You want a pizza ? ;-)';
$strAc_comvalide='- Order validated -';
$strAc_comannulee='- Order canceled -';
$strAc_again='Order another ? :';
$strAc_noagain='Order :';
$strAc_similies=' - ;-) -';
$strAc_nocmdactual='- We dont take any more orders for now -';
$strAc_nolatetotakeit='- Take your items right away once they arrived ! -';
$strAc_cmddejapass='- Your order has been taken.';
$strAc_wewait='- We are waiting for the &quot;items&quot; to be delivered. -';
$strAc_nottime='- The order is still in progress-';
$strAc_notactive='-The orders are not activated.-';
$strAc_listnick='Your search found equivalent nicknames';
$strAc_listnickfailed='Your search found no equivalent nicknames to your entry';
$strAC_alertea='This action will signal to every costumers on this list that their orders has arrived.(they can take it and/or pay it)';
$strAC_alerteregle='This action will make every orders on this list considered as paid.';
$strAC_alerteprit='This action will make every orders on this list marqued as delivered';
$strAC_alertedel='Warning !!!You are about to delete the entire content of this order';
$strAc_youareadmin='Go to the admin page';
$strAc_ifcmdok='If your order(s) has been delivered please click on "Order in progress"<br>to put the order to OFF';
$strAc_consae='<p align="left"><font size="2">How does it work ?, is a good question you ll tell me.<br>At the beginning you had to click one to four time per orders to modify its status to  \ treated\ <br> Now we can view all the orders.<br> The two check boxes above 
fill themselves automatically. The first one will write the orders <font color="#0000FF"><strong>ID</strong></font> 
that you asked to delete.<br>The second will count the number of boxes you checked.
<br><br><font color="#009900"><strong>In case of error (you clicked on the wrong check box) </strong></font><strong>:
</strong><bR> All you have to do is delete the <font color="#0000FF"><strong>ID </strong><font color="#000000">from the list and 
the &quot;pipe&quot; (symbole &quot;|&quot;) found on its right.</font></font><br>Example 2|6|33| you
want to remove the <font color="#0000FF"><strong>ID</strong></font> 6 so you set it to : 2|33|. Finally, downgrade the number of the next box by 1.<br>Example, for 2|6|33| it displayed \'3\' with 2|33| you downgrade 1 to 3 which gives 2.<br>You can also add but don\'t forget to increment also the next box</font></p><p align="left"><font size="-1">If you find this too difficult click on  <strong>
<font color="#FF0000">RESET</font></strong>. This will erase everything.</font></p><p align="left">
<font size="-1">Have A Good Lan Party!</font></p>';
$strAc_artfin='\'??|..</font>\'is your item status &quot;<font color="#FF0000">??</font>&quot; If your item has been payed or not. 
If your order has arrived or not.<br></em></font>';
$strAc_nocmdsry='- No items -';
$strAc_youneedloginfirst='You have to be logged in first';
$strAc_pannier='Your bag';
$strAc_commander='Order';
$strACAlredyExist = 'Order already exists';
$strAC_podevirg='use . than , for the prize ! And use numeric format';
$strAC_fermerlafenetre='Close the window';
$strAC_regle='Payed';
$strAC_livre='Ready';
$strAC_annulercommande='Cancel Item';
$strAC_impossibleannuler='The order has passed, can\'t cancel';
$strAC_commandepaye='You have payed your item';
$strAC_commandepaspaye='You haven\'t payed your item yet';
$strAC_commandearrivee='Your item has arrived';
$strAC_commandepasarrivee='Your item has not arrived yet. -Impossible to cancel at this stage of the order-';
$strAC_Attentede='Waiting for';
$strAC_articlearrivee='Your item has arrived !';
$strAC_merci='Thank you for your order';
/********************************************************
 * END Mod commandes
 */
$strlastvisit = 'Last seen on :';
$custheme='Change the theme';
$strarbitre = 'Tournament Administrator';
$strElementsNpageExistant = 'Existing page &#035;';
$strElementsNpageInvalide = 'Invalid page &#035;';
$strElementsMenuLien = 'If the page is in the menu, it needs a link';
$strElementsMenuLien2 = 'If the page has a link, it needs a menu';
$strElementsOrdeInvalide2 = 'The link display order must be a number';
$strElementsRubriqueInvalide = 'Invalid rubric';
$strElementsNmenuInvalide='Invalid menu';
$strAjouterPage='Add a page';
$strRubrique='Rubric';
$strNpage='Page &#035;';
$strNmenu='Menu';
$strLien='Link';
$strOrdre='Order';
$strAcces='Access';
$strTous='All';
$strModifierPageR ='Modify the page in which rubric ?';
$strModifierPage='Modify the page';
$strElementsOdreInvalide='The meny display order must be a number';
$strAlign='Align';
$strGauche='Left';
$strDroite='Right';
$strHide='Hidden';
$strModifierMenus='Modify a menu';
$strAjouterMenu='Add a menu';
$strModifierMenu='Modify the menu';
$strScript='Script';
$strpagescript='Authorize HTML';
$strAddPage='Add a page';
$strModPage='Modify page';
$strAddMenu='Managing the menus';
$strLienex = 'Page URL :';

$strMODEnLigne='"online" colors configuration';
$strMODEnLigneA='Admin';
$strMODEnLigneN='Newser';
$strMODEnLigneM='Manager';
$strMODEnLigneW='War Arranger';
$strMODEnLigneMo='Mod';

$strCPPW='Winning Points';
$strCPPN='Tied Points';
$strCPPL='Losing Points';
$strCPPF='Forfeit Points';

$strAddPageConsignes = '<li>Title : page title (to easily find it when you want to modify it).<br>
 <li>Rubric : If the page is part of the same rubric/folder. 
 (a scrolling menu <br>
 shows you the available rubrics).<br>
 <li>Page # : Doesnt really have any use but it shows the page # within the rubric.<br>
 <li>Menu : The menu that the page will be in (if empty, the page will have to be linked from another page )
 .&nbsp; <br>
 <li>Link : Text of the link in the menu.<br>
 <li>Order : Link position in the menu.&nbsp;<br>
 <li>Access : Defines if the page needs a special rank
 (logged in member, guest, admin ou newseur) to be viewed.<br>The administrators can access every pages.<br>
 <br>
 <li><img src="images/bb_codescript.gif" border="0" /> Appears if you click "authorize the 
 html" in the mods control panel.<br>
 Every script must be placed between buoys [script] [/script] 
 to be interpreted.
 <br>
 &nbsp;';
 //////mod ladder
 $strModsladder='Ladder Admin Panel';
 $strLadder='Ladders';
 $strLadlist='Select a ladder';
 $strMODAddlad='Add a ladder';
 $strLadjeux='Game';
 $strLadType='Type';
 $strRegLad='Ladder rules';
 $strLadName='Ladder name';
 $strMODlistlad='Modify which ladder ?';
 $strLadNameMod='Modify a ladder';
 $strladnodatafoundlist='There isn\'t any existing ladder yet';
 $strLadduel='Start a duel';
 $strLadduel1='Start a duel with this player';
 $strLadduele='Start a duel with this team';
 $strLadduel2='Challenge this player in a duel';
 $strMODAdddel='Delete a ladder';
 $strMODAddclose='Close a ladder';
 $strLadalreadyexist='Insert another name, this one is already taken';
 $strDefier='Challenge';
 $strfrancaisladmail=' His message : ';
 $strfrancaisladmailopp=' You have been challenged by ';
 $strLaditsyou='You cant challenge yourself !';
 $strEcrireMessageLAD='Fill a challenge form';
 $strLadnothingcont='No message specified !';
 $lstrladdual=' Duel !';
 $strLADj1='J1 to be validated';
 $strLADjv='Validate';
 $strLADnotagree='Contest';
 $strLADj2='J2 to be validated';
 $strEcrireRApLAD='Write a report';
 $strLADRapport='Report';
 $strLADneednumeric='The scores must be written in decimal.';
 $strLADneedrap='You have to fill in a report !';
 $strLADcheater='!  !  ! C H E A T E R  !  !  !';
 $strLADagree='Confirm';
 $strLADpoints='Points';
 $strLadderV='PtsLad Win';
 $strLadderP='PtsLad Lost';
 $strLadderN='PtsLad Tie';
 $strLADnotagree='Contest';
 $strLADres='Match scores';
 $strLADcomment ='Comment on the match '; 
 $strLADNocoment='No comment has been made.';
 $strLADfairadv='Your opponent Fair Play ';
 $strLadMylad='My Ladders, My matchs';
 $strLADother='';
 $strLADneedvalid='You have to affirm or cancel the report!';
 $strLadVAl='Status and validation panel for your matches';
 $strPasDeFonctionMailLAD = 'Sorry but the mail option is turned off<br>We invite you to visit the user profile<br>of the player you wish to challenge in the case that he would have modified other contacts mail. <br><br><b><u>A message has been sent to him via our internal mail server. !</u></b>';
 $strPasDeFonctionMailLADT = 'Sorry but the mail option is turned off<br>We invite you to visit the team profile<br>of the team you wish to challenge in the case that he would have modified other contacts mail. <br><br><b><u>A message has been sent to the team via our internal mail server. !</u></b>';
 $strLADvalidnotagreeCont='Has contested your report. Check your results and (both) re-validate the match. In case of prolonged contestations contact an admin';
 $strLADvalidnotagree='Ladder validation rejected';
 $strLADcheckref='Click here to watch the selected match';
 $strLadermesmail='challenged you in a ladder. \nMeet him in the ladder section/my matches or answer his message.';
 $strLadMaps = 'Maps';
 $strLadDefpts = 'Point by default';
 $strLadpourcent = 'Percent';
 $strladpts  = 'by points';
 $strladteam = 'by challenger'; 
 $strLad_needname = 'You must be give a name for your ladder';
 $strLad_needrules = 'You must be give rules for your ladder';
 $strLadderADD = '<li class="lib">percent, if not 0, it is for able balancing challanging.<br>sample : you put 5% by point, all team can\'t challange another if their point is below or under 5% of diffrence<li class="lib"> "maps" If player must be define maps played in report.<li class="lib">"Point bu default" The number of point for the new challenger when he comming into the ladder, so he are on middle and not on bottom of list. It\'s should be the best for balancing'; 
 $strLadclosemode = 'Ladder status';
 $strLadclose = 'Closed';
 $strLadopen = 'Open';
 $strRapport = 'Report';
 $strLad_agree='Match Confirm';
 $strLAD_refusal='Refuse';
 $strLAD_msgMatch='You can accept, propose another challenge or refuse in this page:';
 $strLAD_is_agree = ' has agreed for challenge';
 $strLAD_is_disagree = ' proposed another challenge';
 $strLAD_is_disagree2 = ' has disagreed for challenge';
 $strLAD_incom = ' A challenger incoming !';
 $strLAD_incom2 = 'Your opponent has accepted the challenge';
 $strLAD_incom3 = 'Your opponent has proposed another challenge';
 $strLAD_incom4 = 'Your opponent has refused the challenge';
 $strLAD_admin_title = 'Cheat alert';
 $strLAD_admin = 'Unauthorised match validation have been done.<br /><br />(by wrong player or the match is already validated), through URL browsing.<br />But maybe the challenged player has clicked again on the URL on his Private Message<br /><br/>For your own protection we preferred to contact you (automatically).<br />Check following data about who has cheated :';
 $strLAD_youdontabletodothis ='You aren\'t able to do this.<br>It\'s been considered as a cheating action.<br />One message with your nickname and IP has been sent to all adminisitrators of this website for security';
 $strLAD_refalert = 'Propose other data for this challenge before validation';
 $strLAD_refusealert = 'Be careful. If you validate now with this option all data about this challenge will be destroyed.';
 $strLAD_other_prupose = 'Propose other';
 $strLAD_reply = 'Your message :';
 $strLAD_MDate = 'Date of match';
 $strLAD_MatchR = 'End match report'; 
 $strLAD_roundscore = 'Number of rounds won by :';
 $strLAD_fragscore = 'Number of frags of :';
 $strLAD_deathscore = 'Number of deaths of :';
 $strLAD_logresult = 'Match Result';
 $strLAD_round = 'Round';
 $strLAD_constest = 'Didn\'t approve your result and proposed the following result :';
 $strLAD_you_must_be_wait = 'You must wait your opponent to validate';
 $strLAD_endmatch_agree = 'Results approved';
 $strLAD_fact = 'Statistic Factor';
 $strLAD_map_error = 'You must choose a game before maps';
 $strLAD_nodata_match = 'No match has been found';
 $strLAD_nodata_player = 'No player has been found';
 $strLAD_nodata_rule = 'No rules';
 $strLAD_nodata_for_match = 'No proposed and accepted match has been found';
 $strLAD_nodata_for_player = 'No players are registered to this ladder';
 $strLAD_nodata_for_result = 'No result has been registered';
 $strLAD_lastmatch = 'Last Match';
 $strLAD_lastresult = 'Last Result';
 $strLAD_yournotmanager = 'You aren\'t manager of any team';
 $strLAD_whosteam = 'What team you want to add ?';
 $strLAD_myunmatch= 'My match : need my validation';
 $strLAD_myvmatch = 'My match : need result';
 $strLAD_mytmatch = 'My match : Finished';
 $strLAD_my_match_p = 'My match : proposed';
 $strLAD_valid_this = 'Accept/refuse panel';
 $strLAD_impose = 'Admin decide match between :';
 $strLAD_is_imp = 'forced the match';
 $strLADfairadv_1='Fairplay adv 1';
 $strLADfairadv_2='Fairplay adv 2';
 $strLADAdminMaps = '<small>(Use CLTR for multi selection or to unselect selected maps)</small>';
 $strLAD_wanttoleft = 'Do you want to leave this ladder ?\nYour data will be deleted';
 //end ladder
 
 //mod FAQ
$str_faq_choose='<font size="2" color=blue><b>Choose a category :</b></font>';
$str_faq_admin='.: FAQs ADMIN PANEL:.';
$str_faq_al1='<font size="2" color="red"><b>There has to be at least one category first</b></font><br><br>';
$str_faq_al2='<font size="2" color="red"><b>There has to be at least one question/answer first</b></font><br><br>';
$str_faq_al3='<font size="2" color="red"><b>There have to be at least two categories first</b></font><br><br>';
$str_faq_al4='<font size="2" color="red"><b>There have to be at least two questions/answers first</b></font><br><br>';
$str_faq_al5='<font size="2" color="green"><b>Deleted Category</b></font><br><br>';
$str_faq_al6='<font size="2" color="red"><b>No empty fields please</b></font><br><br>';
$str_faq_actA='Add Category';
$str_faq_actB='Add Question/Answer';
$str_faq_actC='Modify Category';
$str_faq_actD='Modify Question/Answer';
$str_faq_actE='Organize Categories';
$str_faq_actF='Organize Questions/Answers';
$str_faq_actG='Delete Category';
$str_faq_actH='Delete Question/Answer';
$str_faq_actI='Move Question/Answer';
$str_faq_addq='Question/Answer added';
$str_faq_addqr='Add a Question/Answer :';
$str_faq_in='In category :';
$str_faq_q='Question :';
$str_faq_r='Answer :';
$str_faq_par='To :';
$str_faq_nothing='There is no question/answer in this category';
$str_faq_inter='Question/answer moved !';
$str_faq_mettre='Put :';
$strFaq='FAQ :';
$str_faq_error='Sorry but there is no existing category yet';
 //end FAQ
 
 //FORUM 
 $strAjouterReponse='Add an answer';
 $strModifyReponse='Modify an answer';
 $strFLast='Last message from :';
 $strTopic='Topic :';
 $strTopicde='Created by :';
 $strAjouterCategorie='Add a category';
 $strDesc='Description';
 $strEffcaerCategorie='Delete category';
 $strFdep='Move topics in '; 
 $strFneedlog='You have to be logged in to<br>create a topic.';
 $strFdelall='Delete without moving';
 $strFras='There is no existing category yet';
 $strEditeCategorie='Edit the category';
 //v2
 $strFNbpage ='Page &#035;';
 //$strAvec='with';
 $strFnbtop='topics';
 $strFnbsub='answers';
 $strFnbtdd='and by order';
 //$strCroissant='increasing';
 $strDecroissant='decreasing';
 $strModo='Modo';
 $strFedit='Messaged edited on :';
 $strBy='from';
 //end v2
 $strForumnbpost='Number of posts on the forum';
 $strNbpost='Messages';
 $strRkforum='Forum title';
 $strAjouterTopic='Add Topic';
 $strWhereDep='Move topic in the category';
 $strDepsujet='Move all topics';
 $strDelsujet='Delete this post';
 $strEdsujet='Edit this post';
 $strReservedTo='Accessible to';
 $strReservedTonb='<br>note : The administrators can access everything, uncheck everything for an "admin only" category';
 $strDelCatCookie='Delete cookies from this category';
 $strIWTL='Close this topic';
 $strIWTUL='Open this topic';
 $strSujet='Topic';
 $strMessage='Messages';
 $strDernier='Last';
 $strFrasUnacces='No topic can be accessed with your status level. Log in first if its not already done.<br>If you still can\'t access the desired topic, contact an administator with your rank (user, manager, modo...).';
 $forum_need_more_ac='<small>Result need admin/modo or user rank for access</small>';
 $strPost_id = 'Post n.';
 $strPost_link = 'You can use the link in the box below as direct link to this post';
 //END FORUM

$strPageDeBBcode='BBcode help page';

// top 10
$strtop10='MODS "TOP 10" DL';
$strtop10dl='Block downloads';
$strtop10player='10 newest members';
$strlastresult='5 last scores';
$strlastnews='10 last news';
$strlastnews_header='5 last news in header';
$strlastnews5='5 last News';
$strNoresultnow='No scores yet...';
$strNonewsnow='No news yet';
$strtop10_mod='"TOP" Mod';

/* Fichier plan.php */
$strLibre = 'Free';
$strEquipePresente = 'Team already in the challenge room';
$strEquipeNonDefini = 'No team has been selected';
$strJoueurNonManager= 'You are not manager of any team';
$strChoixEmplacement = 'Select a location';
$strSelectionEquipeConsignes = '<li>Only team managers can reserve places. The location you selected is <font color=red>only a wish</font> of position..</li>
<li>If you wish to change the location, contact an administrator</li>';
$strAdministrationReservation = 'Room Administration';
$strPlanSalle = 'Room plan';

//admin tournois
//special arbitre
$strarbitre = 'The referees';
$strInscriptionsTournoisArbitre = 'Contact an admin only if needed';

//search
$strTopic='Topic';
$strFLast='De';
$strRechecrher='Search';
$strRechercher='Search';
$strRechercherJoueur='Search a player';
$strElementsSearchInvalide='Search incomplete';
$strSearchUnresult='No result.';
$strS_listtnick_error='No player found.';
$strS_listnick='Search found these players';
$strS_listteam_error='No team found.';
$strS_listteam='Search found these teams';
$strS_listnews_error='No news found.';
$strS_forum_error='No topic found';
$strS_nomatch = 'Sorry, search failed.';
$strRechercherSteam=' Search a STEAM_ID ';
$strS_listtsteam_error=' No STEAM_ID found.';
$strS_liststeam='Search found these STEAM_IDs';
$strElementsSteamInvalide='You must specify a STEAM_ID';
// end search



// RANK
$strRang_a='Is an Admin-Master';
$strRang_b='Is an Admin';
$strRang_c='Can modify config & mod';
$strRang_d='Can manage Downloads';
$strRang_e='Can manage teams';
$strRang_f='Is a FAQ-Master';
$strRang_g='Can manage pages';
$strRang_h='Can manage affiliates (links)';
$strRang_i='Can manage the guest book';
$strRang_j='Can manage the players';
$strRang_k='Can manage the room plan';
$strRang_l='Can manage the mailing list';
$strRang_m='Is a Moderator';
$strRang_n='Is a Newser';
$strRang_o='Can access the admin menu';
$strRang_p='Manage the partners';
$strRang_q='Manage the gallery';
$strRang_r='Manage the servers';
$strRang_s='Manage the Sponsors';
$strRang_t='Manage the tournaments/maps/ganes';
$strRang_u='Manage the Ladders/maps/games';
$strRang_v='Manage AdminBot and M4';
$strRang_w='Can edit the users ranks';
$strRang_x='Manager of at least one team';
$strRang_y='WarArranger of at least one team';
$strRang_z='User (if not = banned)';
$strEdit_rang='Edit powers';
$strRang_wrong='You cannot edit Admin-Masters powers <br>if your not one yourself !';
//RANK
$strFLOG='Administrators wants everyone to identify themselves.';
$strFtitle_sec='Security';
$strFtitle='Force the login';

// fix BBcode JAVA
$strL_BBCODE_B_HELP='Bold Text: [b]texte[/b] (alt+b)';
$strL_BBCODE_I_HELP='Italic Text: [i]texte[/i] (alt+i)';
$strL_BBCODE_U_HELP='Underlined Text: [u]texte[/u] (alt+u)';
$strL_BBCODE_Q_HELP='Quotation: [quote]quotation text[/quote] (alt+q)';
$strL_BBCODE_C_HELP='Code display: [code]code[/code] (alt+c)';
$strL_BBCODE_L_HELP='List: [list]texte[/list] (alt+l)';
$strL_BBCODE_O_HELP='Orderly List: [list=]texte[/list] (alt+o)';
$strL_BBCODE_P_HELP='Insert an Image: [img]http://image_url/[/img] (alt+p)';
$strL_BBCODE_W_HELP='Insert a Link: [url]http://url/[/url] or [url=http://url/]Nom[/url] (alt+w)';
$strL_BBCODE_S_HELP='Text Color: [color=red]texte[/color] hint: #FF0000 works too';
$strL_BBCODE_F_HELP='Text Size: [size=x-small]small text[/size]';
$strL_BBCODE_A_HELP='Close all the open BBCode Buoys';
$strL_BBCODE_N_HELP='The BBCode wont be interpreted between these buoys [noBBcode][B]not in bold[/B][/nobbcode]';
$strL_BBCODE_CLOSE_TAGS='Close the buoys';
$strL_EMPTY_MESSAGE='There is no content !';
$strL_STYLES_TIP='Hint: Une mise en forme peut être appliquée au texte sélectionné';
$strAlignHelp='Text Alignement: [align=center]Text center[/align]';
$strAlign='Align';
$strLeft='To Left';
$strRight='To Right';
$strCenter='Centrer';
$strJustify='Justified';
$strSurligner='Highlighted';
$strSurligner_help='Highlighting the text [bgcolor=red]Red highlighted text[/bgcolor]';
// end fox BBcode JAVA

// MOD LEFT TEAM
$strLeaveTeam='Quit this team';
$strLeaveTeamALERT='Do you really want to quit this team ?';
// END MOD LEFT TEAM

//pc
$strADMINPANEL='Admin panel';
// end pc

//sondage
$strBaseInexistante='The database doesn\'t exist, So it\'s not updated.';
$strNoSondage = 'No poll';
$strSondage = 'Poll';
$strAllSondage = 'See all';
$strVoter = 'Vote';
$strAdminSondage = 'Poll Admin Panel';
$strAddSondage = 'Add poll';
$strModSondage = 'Modify poll';
$strDelSondage = 'Delete poll';
$strCloseSondage = 'Close poll';
$strSondageName = 'Name of poll';
$strOptSondage = 'Poll\'s option';
$strOption = 'Option';
$strRank = 'Rank';
$strAddOption = 'Add <input type=\'text\' name=\'nb_opt\' value=\'1\' maxlength=\'2\' size=\'2\'> option(s)';
$strNoSondageName = 'You must give a poll name';
$strNoSondageOptions = 'You must select one option';
$strConfirmDelSondage = 'Do you want to delete poll?';
$strConfirmCloseSondage = 'Do you want to close poll?';
$strVoteSondage = 'Vote for this poll';
$strSondClosed = '(closed)';
$strAlreadyVoted = 'You have already voted for this poll';
$strVote = 'Vote';

//update  & install :
$strConfiguration_general='General configuration';
$strSessions_variables='Session variables';
$strFlood_variable='Flood variables';
$strtable_col='Number of columns for the tables';
$strnumxp='Number of ... per pages';
$strnb_news_max = 'News';
$strnb_news_commentaires_max = 'News comments';
$strnb_matchs_commentaires_max = 'Match comments';
$strnb_livredor_max = 'Guests book signature';
$strnb_gallery_thumb = 'Gallery Image';
$strnb_sondage_commentaires_max = 'Survey comments';
$strsess_cookie_min = 'Cookies duration';
$strsess_gc_days = 'Session (gc) in days';
$strstats_timeout = 'Duration of stats backups';
$strflood_time = 'Flood time';
$strx_delta_simple = 'Simple tree';
$strx_delta_double = 'Double tree';
$strcol_equipes = 'Team column';
$strcol_joueurs = 'Players column';
$strcol_poules = 'Groups column';
$strcol_matchs_poules = 'Group Match column';
$strcol_maps = 'Maps column';
$strcol_jeux = 'Games column';
$strcol_serveurs = 'Server column';
$strcol_administrateurs = 'Admins column';
$strcol_avatar_gallerie = 'Avatars column (galleries)';
$strcol_sponsors = 'Sponsors Column ';
$strcol_categories = 'Categories Column';
$strcol_gallery_thumb = 'Gallery Column (thumb)';
$strtm4rulecfg = '.cfg files of M4 rules';
$strm4campscfg = 'Camp types';
$strm4autostartcfg = 'Auto-start';
$strm4prolongationcfg = 'Prolongation';
$strabrulecfg = 'cfg rules';
$strabcampscfg = 'Camp types';
$strabautostartcfg = 'auto start';
$strabprolongationcfg = 'prolongation';
$strInstallStage3Delupdatel = 'Warning! the file update.php can\'t be deleted<br><u>For your site security,</u> it is <u>STRONGLY RECOMMANDED</u> to delete this file manually';

//news english
$strNews2='English version';
$strElementsTitreInvalide2='English news title is not valid';
$strElementsContenuInvalide2='English news body is not valid';
$strNewsUK='Turn on english news';

$str_phptteam = "Cordially,<br>phpTournois Team";
$X = 'Wait opponent agreement';
$A = 'Wait challenger agreement';
$B = 'Wait result';
$D = 'Match Invite';
$V = 'Match Finished';

//export
$strEXPORT_tree = 'Export tree of tournament';
$strEXPORT_done = 'Tree has been exported in include/export/f_';
$strEXPORT_done2 = 'Use this for link export page :';
$strEXPORT_name = 'Link title';

$strTG4JOINT='Join team';
$strTG4NT='New team';
$strTG4MT='My teams';
$strTG4MP='PM';
$strTG4MPB='New PM!';
$strTG4MPNB='PM box';
$strLinkex='Link exchange!';
$strMessageenvoyez = 'Your message has been sent.';

$strTop10dl = 'Top 10 DL';
$strLastregistred= 'last Registered';
$strContactout = ', has contacted ypou through the phpTG4 form.<br />BUT the mail could not have been sent.<br />Here\'s his message :<br />';

$str_phpTG4_v = 'Your version is :';
$str_phpTG4_vo = 'Latest version is :';

$strPMED = 'Message has been sent by PM';
$strPMED_no = 'Message can\'t sent by PM : no mail configured';
$install_error = 'You can\'t install if g4.g4 file is on the root of phpTG4 !';

$strPour = 'for';
$strNoarbitres = 'No referee for this tournament yet';
$strSanctions = 'Penalties';
$strNoUserOnline = 'No user online';
?>

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
      +---------------------------------------------------------------------+
   | Correction: Gwenegan                            |
   +---------------------------------------------------------------------+
*/

// ASCII EDITED

// gestion des dates
define('DAY_POS','1'); // en fr, le position du jour est 1 => 27/xx/xxxx
define('MONTH_POS','2'); // en fr, le position du mois est 2 => xx/02/xxxx
define('YEAR_POS','3'); // en fr, le position de l'ann�e est 3 => xx/xx/2002

// date d'affichage
define('DATESTRING','%d/%m/%Y %H:%M');
define('DATESTRING1','%d/%m/%Y alle %H:%M');
define('DATESTRING2','%d/%m/%Y');

$strPasDeTableau = "Nessun gruppo trovato";

$strJoueursConsignes = '<li>La registrazione definitiva di un giocatore (dallo stato \'pre-iscritto\' allo stato \'iscritto\') &#232; fatta dall\'admin quando tutto &#232; OK.
<li>Solo i giocatori \'iscritti\' possono partecipare ai tornei per singoli.';

$strEquipesConsignes = '<li>La convalida definitiva di un team (dallo stato \'pre-iscritto\' allo stato \'iscritto\') &#232; fatta dall\'admin quando tutto &#232; OK (team completo, TUTTI i giocatori registrati, etc).
<li>Solo i team \'iscritti\' possono partecipare ai tornei a team.
<li>Il formato della colonna \'Iscritti\' &#232; "numero giocatori iscritti - numero giocatori pre-iscritti"';

$strRapporterConsignes = '<li>Solo i managers dei teams (o i giocatori singoli) possono inserire o convalidare il risultato.
(Per esempio, il perdente inserisce il risultato, e il vincitore lo convalida, o il contrario)';

$strRejoindreEquipesConsignes = '<li>I campi contrassegnati cos&#236;<font color=red>*</font> sono necessari.
<li>Dovrete chiedere al manager del vostro team la team password, per potervi unire a loro.';

$strHorairesTournoisConsignes = '<li>Il formato della data &#232; "gg/mm/aaaa oo:mm" o solo "oo:mm" per la data di oggi.
<li>L\'aggiornamento delle date verr&#224; eseguito solo per scontri nascosti o attivi.';

$strMapsTournoisConsignes = '<li>L\'aggiornamento delle mappe verr&#224; eseguito solo per scontri nascosti o attivi.';

$strServeursTournoisConsignes = '<li>I servers utilizzabili sono quelli elencati dall\'amministrazione generale per il gioco del torneo corrente.
<li>L\'aggiornamento dei servers verr&#224; eseguito solo per scontri nascosti o attivi.';

$strAdminSponsorsConsignes = '<li>I campi contrassegnati cos&#236;  <font color=red>*</font> sono necessari.
<li>Le immagini degli sponsors sono nella cartella "images/sponsors".';

$strAdminLiensConsignes = '<li>I campi contrassegnati cos&#236;  <font color=red>*</font> sono necessari.
<li>Le immagini dei link sono nella cartella "images/liens".';

$strAdminJeuxConsignes = '<li>I campi contrassegnati cos&#236;  <font color=red>*</font> sono necessari.
<li>Le immagini dei giochi sono nella cartella "images/jeux".';

$strIRCMessage = 'IRC (Internet Relay Chat) &#232; una rete di chat in tempo reale.<br><br>
Puoi unirti a noi sul/i canale/i %chans% del server (%serveur%) con un software esterno: <a href="irc://%serveur%/%chan%"><img src="images/icon_irc.gif" border="0" align="absmiddle"></a><br><br>
oppure<br><br>
con la java applet direttamente inclusa in questo sito, grazie al link sottostante:';

$strUploadFichierConsignes = '<li>Il campo contrassegnato cos&#236;  <font color=red>*</font>  &#232; necessario.
<li>Dimensioni massime file : ';

$strRapporterResultats = 'Riporta risultati';
$strMatchAttenteResultats = 'Scontri con risultato pendente';
$strMatchAttenteValidation = 'Scontri con convalida pendente';
$strTournoisEnCours = 'Tornei in corso';
$strTournoisTermines = 'Tornei terminati';
$strValiderScore = 'Convalida il punteggio';
$strRefuserScore = 'Rifiuta il punteggio';
$strValidation = 'Convalida';
$strConflit = 'Conflitto';
$strAssignerPoules = "Assegna in base al ranking del gruppo"; 
$strMethodeRandom = 'Metodo \'random\'';
$strMethodeSeed = 'Metodo \'seeded\'';
$strMethodeCroise = 'Metodo \'crossed\'';
$strPageDecharge = 'Pagina \'discharge\'';
$strConditionsGenerales = 'Condizioni generali';
$strJeRefuse = 'Rifiuto';
$strJAccepte = 'Accetto';
$strErreurMatchABPresent = 'Match in AB database trovato!';
$strErreurMatchM4Present = 'Match in M4 database trovato!';
$strRecupOk = "Recupero OK!";
$strDans = 'in';
$strAuto = 'Auto';
$strRecupMatchAuto = 'Recupero automatico degli scontri di ';
$strChangerElimination = 'Sei sicuro di voler cambiare il tipo di albero del torneo ?';
$strConfirmDesincrireTeam = 'Sei sicuro di voler disiscrivere il tuo team da questo torneo ?';
$strConfirmDesincrire = 'Sei sicuro di volerti disiscrivere da questo torneo ?';
$strSeDesinscrire = 'Disiscriverti';
$strDesinscrire = 'Disiscrivere';
$strAppletPJIRC = 'Java applet PJIRC';
$strPopup = 'Popup';
$strDevenirPartenaire = 'Come diventare partner';
$strInscriptionsEquipes = 'Iscrizione teams';
$strInscriptionsJoueurs = 'Iscrizione giocatori';
$strInstall = 'Installazione';
$strFloodDetect = 'Devi aspettare '.$config['flood_time'].' secondi prima di riprovare questa operazione';
$strErreurNbPlaces = 'Il numero dei posti deve essere maggiore di 0';
$strErreurJoueurAppartient = 'Il giocatore &#232; gi&#224; membro di questo team';
$strInscriptionsTournoisConsignes = '<li>Le iscrizioni al torneo sono aperte solo ai giocatori/team registrati/convalidati';
$strRejoindreUneEquipe = 'Unisciti a un team';
$strRejoindreCetteEquipe = 'Unisciti a questo team';
$strPasswordRejoindre = 'Password<br>(per unirsi)';
$strPasDeFonctionMail = 'Ci spiace ma la funzione mail &#232; disattivata';
$strContactMessageEmail = 'Questo &#232; un messaggio di contatto dal sito %nomsite% dove';
$strInstallStage1 = 'Configurazione database';
$strInstallStage1Consignes = 'Perfavore inserire parametri database ';
$strInstallStage1Consignes2 = 'Clicca qui per configurare';
$strInstallStage2 = 'Configurazione phpTournois';
$strInstallStage2Consignes = 'Perfavore inserisci nome e URL del tuo sito e seleziona il tipo di installazione';
$strInstallStage2Consignes2 = 'Perfavore inserisci login e password dell\' account admin';
$strInstallStage3 = 'Congratulazioni! phpTournois &#232; installato correctamente.';
$strInstallStage3Consignes = '<div align=left><blockquote>Quando usi phpTournois, ricordate che questo &#232; free software rilasciato sotto <b>Licenza QPL</b>.<br>
Perci&#242; devi rispettare le seguenti condizioni : <br>
<li> Primo: Free software non vuol dire che puoi farci quello che vuoi<br>
<li> Secondo: &#200; vietatissimo rimuovere o cambiare le righe che si riferiscono agli autori<br>
<li> Terzo: &#200; vietatissimo rimuovere o cambiare i copyrights</b> Rimuovendo o cambiando le righe, ti esponi a procedimenti giudiziari.<br>
<li> Quarto: <b>Devi</b> pubblicare le modifiche apportate al codice (nel forum per esempio) ed il team si riserva il diritto di riutilizzarlo<br>
<li>Quinto: La licenza QPL ti impedisce di fare fork di phpTournois<br>
</blockquote></div>Consult the INSTALL & README files for more informations about phpTournois.<br><br>Clicca qui per andare alla tua installazione nuova di zecca: <a href=index.php>GO !</a>';
$strInstallStage3DelInstall = 'Attenzione! il file install.php non pu&#242; essere cancellato.<br><u>Per la vostra sicurezza,</u> &#232; <u>FORTEMENTE RACCOMMANDATO</u> di cancellare il file manualmente';
$strFichierSqlManquant = 'File Sql mancante';
$strPaypal = 'Fai una donazione a questo sito via PayPal, &#232; veloce e gratuito !';
$strPermissionInvalideConfigFile = 'Il file di configurazione non ha permessi di scrittura!';
$strOuvertureInvalideConfigFile = 'Non posso aprire il file di configurazione';
$strEcritureInvalideConfigFile = 'Non posso scrivere il file di configurazione';
$strPageDemarrage = 'Start page';
$strDBHost = 'Mysql hostname';
$strDBUser = 'Mysql user';
$strDBPass = 'Mysql password';
$strDBName = 'Mysql database';
$strDBPrefix = 'Prefisso tabelle';
$strVersion = 'Versione';
$strPasDeServeur = 'Nessun server trovato';
$strPasDEquipe = 'Nessun team trovato';
$strPasDeJoueur = 'Nessun giocatore trovato';
$strPasDeTournoi = 'Nessun torneo trovato';
$strMoi = 'Me';
$strMatchsTermines = 'Scontri terminati';
$strMatchsCaches = 'Scontri nascosti';
$strElementsManagerInvalide = 'Manager non valido';
$strNouvelleEquipe = 'Nuovo team';
$strCachee = 'Nascosta';
$strCaches = 'Nascosti';
$strCachees = 'Nascoste';
$strLeader= 'Leader';
$strWarArranger = 'War arranger';
$strMembre = 'Membro';
$strRecrue = 'Newbie';
$strInactif = 'Inattivo';
$strExMembre = 'Ex-membro';
$strModifierDownload = 'Modifica questo download';
$strModifierSponsors = 'Modifica questo sponsor';
$strModifierTournois = 'Modifica questo torneo';
$strModifierLiens = 'Modifica questo link';
$strModifierPartenaires = 'Modifica questo partner';
$strValide = 'Valido';
$strIncomplete = 'Incompleto';
$strTableau = 'Tabella';
$strChangerStatusEquipe = 'Sei sicuro di voler cambiare lo status di questo team ?';
$strDonation = 'Donazione';
$strYIM = 'YIM';
$strFonction = 'Funzione';
$strMail = 'Mail';
$strSmtp = 'Smtp';
$strSmtpServeur = 'Server';
$strSmtpUser = 'SMTP user';
$strSmtpPassword = 'SMTP password';
$strOptionsMail = 'Opzioni mail';
$strThemeDefaut = 'Tema di default';
$strMessageEnvoi = 'Il messaggio &#232; stato inviato.';
$strErreurMessageEnvoi = 'Il messaggio non &#232; stato inviato.';
$strConfirmIncrireTeam = 'Sei sicuro di voler iscrivere il tuo team a questo torneo ?';
$strConfirmSIncrire = 'Sei sicuro di volerti iscrivere a questo torneo ?';
$strPreInscription = 'Pre-iscrizione';
$strEnAttente = 'Da convalidare';
$strEquipeValidee = 'teams convalidati';
$strEquipeEnAttente = 'teams da convalidare';
$strValidee = 'Convalidato';
$strValidees = 'Convalidati';
$strAttenteMail = 'mail in attesa';
$strSteam = 'Steam ID';
$strPartenaires = 'Partners';
$strWWW = 'Web';
$strAvatar = 'Avatar';
$strAvatars = 'Avatars';
$strModifierAvatar = 'modifica questo avatar';
$strConfirmEffacerAvatar = 'Cancellare questo avatar ?';
$strCreerEquipe = 'Crea un team';
$strPageGeneree = 'Pagina generata in';
$strSecondes = 'secondi';
$strAvatarUploadLocal = 'Scegli un avatar locale';
$strAvatarUploadRemote = 'Upload un avatar';
$strAvatarLienRemote = 'Link a un avatar remoto';
$strSousCategories = 'Sotto categorie';
$strPermissionInvalide = 'Permesso non valido';
$strGalerieInconnue = 'Galleria sconosciuta';
$strGalerie = 'Galleria';
$strPasDImage = 'Nessuna immagine trovata';
$strImageInconnue = 'Immagine sconosciuta';
$strImages = 'Immagini';
$strGDAbsent = 'Su questo server la libreria GD &#232; mancante';
$strExtensionNonSupporte = 'Estensione non permessa';
$strNewsEnvoiSubject = '[%nomsite%] News !!';
$strNewsEnvoiMessage = 'Questa è una news proveniente dal sito <b>%nomsite%</b> che ti può interessare : <br><br>%link%';
$strNewsEnvoiConfirm = 'Un\' e-mail &#232; stata inviata al tuo amico !';
$strEnvoyerNews = 'Invia questa news';
$strVotreEmail = 'Tua e-mail';
$strSonEmail = 'E-mail del tuo amico';
$strOptionsAvatars = 'Opzioni avatar';
$strAvatarUpload = 'Upload avatar';
$strAvatarRemote = 'Avatar remoti';
$strAvatarGallerie = 'Galleria avatar';
$strAvatarTailleMax = 'Peso massimo file';
$strAvatarDimensionsMax = 'Dimensioni massime';
$strPixels = 'pixels';
$strVoirGallerie = 'Mostra la galleria';
$strElementsEmailExistant = 'E-mail esistente';
$strAvatarErreurUrl = 'URL non corretta !';
$strAvatarErreurConnexion = 'Il server non si pu&#242; connettere all\'URL per il download !';
$strAvatarErreurData = 'L\'URL non corrisponde ai dati corretti';
$strAvatarErreurWrite = 'Scrittura vietata su questo server!';
$strAvatarErreurFileSize = 'Il peso dell\'immagine non &#232; corretto!';
$strAvatarErreurFileType = 'Il tipo di immagine non &#232; valido ';
$strAvatarErreurXYSize = 'Le dimensioni dell\'immagine non sono valide ';
$strEnLigne = 'Online';
$strAdminsEnLigne = 'Admins online';
$strPublicEnLigne = 'Utenti online';
$strQuiEnLigne = 'Chi &#232; online';
$strVisiteurs = 'Visitatori';
$strMembres = 'Membri';
$strTotal = 'Totale';
$strSans = 'Senza';
$strArticleDuSite = 'Questo articolo viene dal sito';
$strURLArticle = 'L\'URL di questo articolo &#232;';
$strSeRappeler = 'Ricordati';
$strNvPassIdent = 'Le nuove passwords devono essere eguali!';
$strResetPass = 'Password reset';
$strOubliPass = 'Dimenticata la password ?';
$strEnvoiPass = 'Richiedi e-mail con password';
$strCodeConfirmation = 'Codice di conferma';
$strElementsJoueurInvalide = 'Giocatore non valido';
$strElementsEquipeInvalide = 'Team non valido';
$strELementsCodeInvalide = 'Codice non valido';
$strPasswordEmailCode = '[%nomsite%] Codice per la nuova password';
$strPasswordEmailCodeMessage = 'Hai richiesto una nuova password via e-mail.<br><br>Devi digitare questo codice subito dopo il tuo nick : <b>%code%</b><br><br>PS: Se non sei l\'origine della richiesta di password, perfavore ignora questa mail!';
$strPasswordMessageCode = 'Il codice per richiedere una nuova password ti &#232; stato inviato per e-mail';
$strPasswordEmail = '[%nomsite%] Nuova password';
$strPasswordEmailMessage = 'Questa è la nuova password per il tuo account : <b>%passwd%</b><br><br>Non dimenticarti di cambiarla il prima possibile!';
$strPasswordMessage = 'La tua nuova password ti &#232; stata inviata per e-mail!';
$strPasswordMessageAdmin = 'La nuova password &#232; : <b>%passwd%</b><br><br>&#200; stata inviata anche al possessore dell\'account via mail!';
$strPasswordEnvoiConsignes = '<li>Inserisci il tuo nick e clicca su \'send\'. Ti verr&#224; inviata un\' e-mail automatica con un codice. <li>Ri-inserisci il tuo nick e questo codice e riceverai una nuova password via e-mail.';
$strAdminPartenaires = 'Amministrazione partners';
$strAjouterPartenaire = 'Aggiungi un partner';
$strConfirmEffacerPartenaire = 'Cancellare questo partner ?';
$strPartenaireDepuisLe = 'Partner dal ';
$strPasDePartenaires = 'Nessun partner trovato';
$strPasDeSponsor = 'Nessuno sponsor trovato';
$strSponsor = 'Sponsor';
$strEnSavoirPlus = 'Leggi di pi&#249;...';
$strSite = 'Sito';
$strSuite = 'Next...';
$strCategories = 'Categorie';
$strPetite = 'piccola';
$strGrande = 'grande';
$strErreur404 = '404 error !';
$strErreur404Explain = 'La pagina richiesta non &#232; raggiungibile';
$strLoguePourPoster = 'Per la sicurezza del sito, devi essere loggato per postare commenti';
$strMatchInvalide = 'Scontro non valido!';
$strCommentairesMatch = 'Commenti allo scontro';
$strModeCommentaire = 'Commenti';
$strPasDeCommentaire = 'Nessun commento trovato';
$strConfirmEffacerFile = 'Cancellare questo file ?';
$strAjouteLe = 'Aggiungi il';
$strFichier = 'File';
$strFichierInvalide = 'File non valido';
$strUploaderFichier = 'Upload file in  ';
$strParticipePourPoster = 'Dovete essere membri di uno dei 2 teams o un giocatore di questo scontro per poter postare commenti.';
$strManagerPourUploader = 'Dovete essere il manager di uno dei 2 teams o un giocatore di questo scontro per poter postare file.';
$strTournoisParticipe = 'Tornei giocati';
$strTournoisParticipePas = 'Tornei non giocati';
$strModeMatchScore = 'Modalit&#224; scontro';
$strFragAverage = 'Solo frags';
$strRoundAverage = 'Solo round';
$strRoundAverageFragAverage = 'Round e frags';


$PHPMAILER_LANG = array();
$PHPMAILER_LANG["provide_address"] = 'Dovete specificare almeno un destinatario';
$PHPMAILER_LANG["mailer_not_supported"] = ' mailer non supportato.';
$PHPMAILER_LANG["execute"] = 'Impossibile eseguire: ';
$PHPMAILER_LANG["instantiate"] = 'Impossibile instanziare la funzione mail.';
$PHPMAILER_LANG["authenticate"] = 'SMTP Error: Impossibile autenticare.';
$PHPMAILER_LANG["from_failed"] = 'Impossibile inviare dai seguenti mittenti: ';
$PHPMAILER_LANG["recipients_failed"] = 'SMTP Error: Impossibile consegnare ai seguenti destinatari: ';
$PHPMAILER_LANG["data_not_accepted"] = 'SMTP Error: Dati non accettati.';
$PHPMAILER_LANG["connect_host"] = 'SMTP Error: Impossibile connettersi all\' host SMTP.';
$PHPMAILER_LANG["file_access"] = 'Impossibile accedere al file: ';
$PHPMAILER_LANG["file_open"] = 'File Error: Impossibile aprire file: ';
$PHPMAILER_LANG["encoding"] = 'Encoding sconosciuto: ';



$strM4Admin = 'M4';
$strABAdmin = 'AdminBot-MX';
$strValidationEmail = 'Convalida e-mail';
$strModeFichier = 'Files allegati';
$strA = 'alle'; // scheduling: at 19:00 PM
$strAEcrit = 'ha scritto';
$strAIM = 'AIM';
$strAccueil = 'Home';
$strActif = 'Attivo';
$strActivationInvalide = 'Attivazione non valida';
$strActiverMatch = 'Attiva scontri';
$strAdmin = 'Admin';
$strAdminBot= 'AdminBot-MX';
$strAdminDownloads = 'Amministrazione downloads';
$strAdminEquipes = 'Amministrazione teams';
$strAdminFinales = 'Amministrazione Finali';
$strAdminHoraires = 'Amministrazione Calendari';
$strAdminJeux = 'Amministrazione Giochi';
$strAdminJoueurs = 'Amministrazione Giocatori';
$strAdminLiens = 'Amministrazione Links';
$strAdminLivreDor = 'Amministrazione Guest Book';
$strAdminMaps = 'Amministrazione Mappe';
$strAdminMatchsPoules = 'Amministrazione scontri gironi';
$strAdminNews = 'Amministrazione News';
$strAdminPoules = 'Amministrazione Gironi';
$strAdminServeurs = 'Amministrazione Servers';
$strAdminSponsors = 'Amministrazione Sponsors';
$strAdminTournois = 'Amministrazione Tornei';
$strAdministrateur = 'Admin';
$strAdministrateursTournois = 'Amministratori torneo';
$strAdmins = 'Admins';
$strAdresse = 'Indirizzo';
$strAge = 'Et&#224;';
$strAjouter = 'Aggiungi';
$strAjouterCommentaire = 'Aggiungi un commento';
$strAjouterEquipe = 'Aggiungi un team';
$strAjouterFichier = 'Aggiungi un file';
$strAjouterJeu = 'Aggiungi un gioco';
$strAjouterJoueur = 'Aggiungi un giocatore';
$strAjouterLien = 'Aggiungi un link';
$strAjouterMap = 'Aggiungi una mappa';
$strAjouterNews = 'Aggiungi una news';
$strAjouterServeur = 'Aggiungi un server';
$strAjouterSignature = 'Aggiungi una firma';
$strAjouterSponsor = 'Aggiungi uno sponsor';
$strAjouterTournois = 'Aggiungi un torneo';
$strAleatoire = 'Casuale';
$strAllowJoinTeam='Permetti di unirsi a team';
$strAllowPrivateMessage='Permetti messaggi privati';
$strAn = 'anni';
$strAncienPass = 'Vecchia password';
$strAncienPassInvalid = 'Vecchia password non valida';
$strAnnuler = 'Annulla';
$strAssignerAleatoirement = 'Procedi in modo casuale';
$strAssignerInscriptionSeed = 'Assegna in base a seeding iscrizioni';
$strAucune='Nessuna';
$strAutoajoutTeam='Disponibilit&#224';
$strAutoMp='Messaggi';
$strAutoStart= 'AutoStart';
$strAutorefresh = 'Auto-refresh';
$strAutoscroll = 'Auto-scroll';
$strAvecDemo = 'demo';
$strAvg = 'Avg';
$strBLACK = 'Nero';
$strBLUE = 'Blu';
$strBROWN = 'Marrone';
$strCYAN = 'Cyan';
$strCache = 'Nascosto';
$strCalendrier = 'Calendario';
$strCalendrierMatchs = 'Pianifica scontri';
$strCamps = 'Campi';
$strManager = 'Manager';
$strManagers= 'Managers';
$strCarteGraphique = 'Scheda video';
$strCarton= 'Cartoncino';
$strCategorie = 'Categoria';
$strCentrer = 'Centra';
$strChampionnat = 'Championship';
$strChangerDevise = 'Cambia il motto';
$strChangerFinales = 'Sei sicuro di voler cambiare l\'inizio delle finali  ? \n\n(ATTENZIONE, questa operazione cancella l\'albero delle finali)';
$strChangerLooser = 'Sei sicuro di voler cambiare l\'inizio delle looser finals ? \n\n(ATTENZIONE, questa operazione cancella l\'albero delle finali della looser bracket)';
$strChangerPoules = 'Sei sicuro di voler cambiare il numero dei gironi ? \n\n(ATTENZIONE, questa operazione cancella tutti gli scontri del girone)';
$strChangerStatusTournois = 'Sei sicuro di voler cambiare lo status del torneo? \n\n(ATTENZIONE, questa operazione &#232; raccomandata solo ai power admins)';
$strChangerStatusJoueur = 'Sei sicuro di voler cambiare lo status di questo giocatore ?';
$strChangerStatusParticipe = 'Sei sicuro di voler modificare lo status di questa iscrizione? \n\n(ATTENZIONE, questa operazione altera scontri e alberi delle finali)';
$strChercherJoueur = 'Cerca un giocatore';
$strChoisirAuHasard = 'Scegli casualmente';
$strCloturerInscriptions = 'Chiudere le iscrizioni ?';
$strCloturerLesInscriptions = 'Sei sicuro di voler chiudere le iscrizioni ?';
$strCode = 'Codice';
$strCodePostal = 'Codice Postale';
$strCocheforwrite1 = 'Riscrivi config.php?';
$strCocheforwrite2 = 'Riscrivi config.m4.php?';
$strCocheforwrite3 = 'Riscrivi config.ab.php?';
$strColorerCode='Mostra syntassi codice';
$strCommentaires = 'Commenti';
$strConfiguration = 'Configurazione';
$strConfirm = 'Conferma';
$strConfirmEffacerCommentaire = 'Cancellare questo commento ?';
$strConfirmEffacerDownload = 'Cancellare questo download ?';
$strConfirmEffacerEquipe = 'Cancellare questo team ?';
$strConfirmEffacerJeux = 'Cancellare questo gioco ?';
$strConfirmEffacerJoueur = 'Cancellare questo giocatore ?';
$strConfirmEffacerLien = 'Cancellare questo link ?';
$strConfirmEffacerMap = 'Cancellare questa mappa ?';
$strConfirmEffacerMessage = 'Cancellare questo messaggio ?';
$strConfirmEffacerNews = 'Cancellare questa news ?';
$strConfirmEffacerServeur = 'Cancellare questo server ?';
$strConfirmEffacerSignature = 'Cancellare questa firma ?';
$strConfirmEffacerSponsor = 'Cancellare questo sponsor ?';
$strConfirmEffacerTournois = 'Cancellare questo torneo ?';
$strConnecte = 'Connesso';
$strConnecter = 'Connettiti';
$strConnexion = 'Connessione';
$strConnexionImpossible =  'Connessione al database fallita!';
$strConsignes = 'Consigli';
$strContact = 'Contatti';
$strContactDown = "<u>ClubRezo</u><br>Ecole Polytechnique de l\'Universit� de Nantes<br>rue Christian Pauc<br>44300 Nantes FRANCE<br>Email : <a href=\"mailto: $config[emailcontact]\"><b><u>$config[emailcontact]</u></b></a>";
$strContactUp = 'Per contattarci, puoi utilizzare il tuo programma di posta preferito <a href="mailto: %email%"><img src="images/icon_email.gif" border="0" align="absmiddle"></a> o compilare questo modulo:';
$strContenu = 'Contenuti';
$strCouleur = 'Colore';
$strCoupe = 'Cup';
$strCreationImpossible = 'Creazione del database phptournois fallita!';
$strCreer = 'Crea';
$strCustTheme = 'Seleziona tema';
$strDARKBLUE = 'Blu scuro';
$strDARKED = 'Rosso scuro';
$strDate = 'Data';
$strDe = 'Da';
$strDeconnexion = 'Disconnessione';
$strDerniersTitres = 'Ultimi titoli';
$strDescription = 'Descrizione';
$strDestinataire = 'Destinatario';
$strDestinataires = 'Destinatari';
$strDevise = 'Motto';
$strDispute = 'Gioca';
$strDisqualifie = 'Squalificato';
$strDotations = 'Premi';
$strDoubleElimination='Doppia';
$strDownloads = 'Downloads';
$strE = 'E'; // E for Edit
$strEMail = 'E-Mail';
$strEcrireMessage = 'Scrivi un messaggio';
$strEditerJoueur='Modifica status giocatore';
$strEffacer = 'Cancella';
$strEditer = 'Modifica';
$strElementsAdresseInvalide = 'Indirizzo non valido';
$strElementsAgeInvalide = 'Et&#224; non valida';
$strElementsAuteurInvalide = 'Autore non valido';
$strElementsCatInvalide = 'Ordine non valido';
$strElementsContenuInvalide = 'Contenuto non valido';
$strElementsDescriptionInvalide = 'Descrizione non valida';
$strElementsDestinataireInvalide = 'Destinatario non valido';
$strElementsEmailInvalide = 'E-mail non valida';
$strElementsEquipeExistante = 'Team esistente ';
$strElementsFinalesInvalides = 'Finali \'Winner\' non valide';
$strElementsFinalesLooserInvalides = 'Finali \'Looser\' non valide';
$strElementsIconeInvalide = 'Icona non valida';
$strElementsImageInvalide = 'Immagine non valida';
$strElementsIncorects = 'Uno o pi&#249; elementi non sono corretti';
$strElementsJeuxInvalide = 'Gioco non valido';
$strElementsJoueurExistant = 'Giocatore esistente';
$strElementsServerNameInvalide='Nome server non valido';
$strElementsServerIpInvalide='Server IP non valido';
$strElementsNewsInvalide = 'News non valida';
$strElementsNomInvalide = 'Nome non valido';
$strElementsOrigineInvalide = 'Origine non valida';
$strElementsPasswordInvalide = 'Password non valida';
$strElementsPortInvalide = 'Porta non valida';
$strElementsPoulesInvalides = 'Gironi non validi';
$strElementsPrenomInvalide = 'Cognome non valido';
$strElementsPseudoInvalide = 'Nickname non valido';
$strElementsSigleInvalide = 'Tag non valida';
$strElementsTagInvalide = 'Tag non valida';
$strElementsTailleInvalide = 'Size non valida';
$strElementsTitreInvalide = 'Titolo non valido';
$strElementsUrlInvalide = 'URL non valida';
$strElementsVilleInvalide = 'Citt&#224; non valida';
$strEmailContact = 'E-mail Contatti';
$strEmailInscription = 'E-mail registrazione';
$strEmetteur = 'Mittente';
$strEnCours = 'In corso';
$strEnvoyer = 'Invia';
$strEquipe = 'Team';
$strEquipes = 'Teams';
$strEquipesInscrits = 'Teams Iscritti';
$strErreur = 'ERRORE';
$strErreurDeSaisie = 'Errore rilevato !';
$strErreurEquipeManquante = 'Teams mancanti';
$strErreurLogin = 'Fallimento autenticazione!';
$strErreurMancheActive = 'Nessun round attivo! Almeno un round deve essere creato e attivato.';
$strErreurMapManquante = 'Mappa mancante!';
$strErreurMatchM4Manquant = 'Scontro mancante nel database AB !';
$strErreurMatchM4Manquant = 'Scontro mancante nel database M4 !';
$strErreurPremiereManche = 'Nessun primo round! Perfavore crea e attiva almeno un round per questo scontro.';
$strErreurServeurManquant = 'Server mancante!';
$strErreurStatusActif = 'Status errato! Questo scontro deve essere attivato per essere lanciato.';
$strErreurStatusCache = 'Status errato! Questo scontro deve essere nascosto per essere attivato.';
$strErreurStatusDemarre = 'Status errato! Questo scontro deve essere lanciato per essere ritirato.';
$strEtat = 'Status';
$strFiche = 'Profilo';
$strFichiersAttaches = 'Files allegati';
$strFichiersAttachesMatch = 'Files allegati allo scontro';
$strFinale = 'Finale';
$strFinales = 'Finali';
$strFinalesType = 'Eliminazione';
$strForfait = 'Abbandona';
$strForum = 'Forum';
$strFrags = 'Frags';
$strG = 'W';
$strGREEN = 'Verde';
$strGagne = 'Vittoria';
$strGeneral = 'Menu';
$strGenerationFinales = 'Convalida Finali';
$strGenerationPoules = 'Convalida Gironi';
$strGrandFinal = 'Gran Finale';
$strGras = 'Grassetto';
$strGzip = 'Compressione Gzip';
$strHidemenu = 'Hide-menu';
$strHistoriqueNews = 'Archivio news';
$strHits = 'Hits';
$strHoraires = 'Calendari';
$strHorloge = 'Orologio';
$strICQ = 'ICQ';
$strINDIGO = 'Indigo';
$strIp = 'IP';
$strIcone = 'Icona';
$strImage = 'Immagine';
$strInformations = 'Informazioni';
$strInscriptionConfirmMessageEmail = 'Grazie per la tua iscrizione a '%nomsite%'.<br><br>Non dimenticarti gli identificatori per il log in:<br>------------------<br> Login : <b>%login%</b><br> Pass: <b>%password%</b><br>------------------<br><br><font color=red>ATTENZIONE: clicca sul link per terminare la tua pre-iscrizione</font>: %link%<br><br>A presto, e buoni frags!!<br><br>Il team.<br><br>';
$strInscriptionConfirmMessage = 'La tua iscrizione ha avuto successo.<br>Riceverai un\' e-mail di conferma che contiene un link di attivazione.<br><br>A presto, e buoni frags!!<br><br>Il team.';
$strInscriptionConfirmMessageOK = 'La tua iscrizione ha avuto successo.<br><br>Non dimenticarti di inviare la somma di iscrizione<br><br>Puoi connetterti alla tua zona personale e configurare un team se sei il manager<br><br>A presto, e buoni frags!!<br><br>Il team.';
$strInscriptionConfirmSubjectEmail = '[%nomsite%] Conferma della pre-iscrizione';
$strInscriptionMessage = 'La tua iscrizione ha avuto successo<br>Non dimenticarti gli identificatori:<br>Login : <b>%login%</b><br>Pass: <b>%password%</b><br><br>Puoi connetterti alla tua zona personale e configurare un team se sei il manager<br><br>A presto, e buoni frags!!<br><br>Il team.';
$strInscriptions = 'Iscrizioni';
$strInscrire = 'Iscrivi';
$strInscrit = 'Iscritto';
$strInscrite = 'Iscritta';
$strInscrits= 'Iscritti';
$Installtype='Tipo installazione:';
$Installtype2 ='Scegli il tipo di installazione';
$strIrc = 'Irc';
$strIrcChannels = 'Canali';
$strIrcPassword = 'Password';
$strIrcPort = 'Porta';
$strIrcServeur = 'Server';
$strItalique = 'Corsivo';
$strJ = 'P'; //Played
$strJeu = 'Gioco';
$strJeux = 'Giochi';
$strJoin = 'Unisciti';
$strJoinAvecHlla = "Per unirti al server col link '$strJoin', devi scaricare .hlla <a href=\"downloads/hlla0704.exe\">>qui<</a> o su <a href=\"http://www.hlla.net\" target=_blank><span style=\"vertical-align: middle;\"><img src=images/hlla.gif align=absmidlle border=0></span></a> e installarlo";
$strJoueur = 'Giocatore';
$strJoueurs = 'Giocatori';
$strJoueursInscrits = 'Giocatori registrati';
$strJoueursPreinscrit = 'Giocatori pre-registrati';
$strKOctets = 'Kb';
$strLan = 'Lan';
$strLancerMatch = 'Inizia scontri';
$strLancerMatchAB = 'Inizia scontri AdminBot-MX';
$strLancerMatchM4 = 'Inizia scontri M4';
$strLangue = 'Lingua';
$strLangueDefaut = 'Lingua Default';
$strLe = 'il'; //il (date)
$strLeaveTeam='Lascia team';
$strLeaveTeamALERT='Davvero vuoi lasciare il team ?';
$strLeaveTeambody1='Salve,\nVi informiamo che il membro del vostro team : ';
$strLeaveTeambody2='\n\nlo ha lasciato di sua volont&#224;.\n\nGrazie per l\' attenzione.';
$strLeaveTeambodyM1='Salve,\nVi informiamo che il manager del team: ';
$strLeaveTeambodyM2='\n\nvi ha espulso dal team.\n\nGrazie per l\' attenzione.';
$strLeaveTeamM='Non puoi lasciare il team finch&#232; lo amministri';
$strLeaveTeamtitle='Ha abbandonato il team !';
$strLeaveTeamtitleManager='Il tuo manager ti ha espulso dal team';
$strLiens = 'Links';
$strLireMessage = 'Mailbox';
$strListe = 'Lista';
$strLivreDor = 'Guestbook';
$strLogin = 'Login';
$strLogo = 'Logo';
$strLooser = 'Sconfitto';
$strM4 = 'M4';
$strM4ID = 'Clan &#035;';
$strMOctets = 'Mb';
$strMSN = 'MSN';
$strMaFiche = 'Profilo';
$strMailing = 'Mailing';
$strMailNotconfig = 'SMTP Server non definito o utente non definito';
$strMaintenance = 'DOWN';
$strManche = 'round';
$strManchesMax = 'Numero di Round';
$strManuel = 'Manuale';
$strMap = 'Mappa';
$strMaps = 'Mappe';
$strMatch = 'Scontro';
$strMatchs = 'Scontri';
$strMatchsActifs = 'Scontri programmati';
$strMatchsEnCours = 'Scontri in corso';
$strMatchsFinales = 'Scontri delle finali';
$strMatchsPoules = 'Scontri dei gironi';
$strMemoire = 'Memoria';
$strMesEquipes = 'I miei teams';
$strMessage = 'Messaggio';
$strMessageLu = 'Messaggi letti';
$strMessageNouveau = 'Nuovi messaggi';
$strMessagerie = 'Mail';
$strMinutes = 'minuti';
$strMode = 'Mode';
$strModeEquipe = 'Team mode';
$strModeInscription='Modo d\'iscrizione';
$strModeScore = 'Tipo di punteggio';
$strModifPass = 'Cambia password';
$strModifier = 'Modifica';
$strModifierConfiguration = 'Modifica la configurazione';
$strModifierNews = 'Modifica questa news';
$strModifierServeur = 'Modifica questo server';
$strMods_ladder = 'Pannello controllo ladder';
$strMODSPANEL = 'Panello mods installate';
$strModsProfil = 'Mod riempimento profilo';
$strMODDiver = 'Mods Varie';
$strMonEquipe = 'Il mio team';
$strMotif='Motivo';
$strN = 'E';
$strNA = 'N/A';
$strNbLooser = 'Inizia sconfitti';
$strNbPlaces = 'Numero di posti';
$strNbPoules = 'Numero gironi';
$strNbWinner = 'Inizia finali';
$strNews = 'News';
$strNewseur = 'Newser';
$strNewseurs='Newsers';
$strNoData = 'Nessun dato finora';
$strNom = 'Nome';
$strNomTournois = 'Nome torneo';
$strNon = 'No';
$strNouveauJoueur = 'Nuovo giocatore';
$strNouveauPass = 'Nuova password';
$strNouvelleEquipe = 'Nuovo Team';
$strNul = 'Eguaglianza';
$strOK = 'OK';
$strOLIVE = 'Oliva';
$strORANGE = 'Arancio';
$strOctets = 'bytes';
$strOptions = 'Opzioni';
$strOptionsIrc = 'Opzioni IRC';
$strOrigine = 'Origine';
$strOui = 'Si';
$strP = 'L'; //Lost
$strPageDotations = 'Pagina \'premi\'';
$strPageInformations = 'Pagina \'informazioni\'';
$strPageNotlist = 'Non hai ancora nessuna rubrica';
$strPageNotlist2 = 'Non hai ancora nessun menu';
$strPagePresentation = 'Pagina \'presentazione\'';
$strPageReglement = 'Pagina \'regole\'';
$strPageStats = 'Pagina \'statistiche\'';
$strPagesVues = 'Pagine visitate da quando il sito &#232; online';
$strParticipants = 'Partecipanti';
$strParticipe = 'Partecipa';
$strPasConnecte = 'Non connesso';
$strPasDInformation ='Nessuna informazione trovata';
$strPasDeContact = 'Nessun contatto trovato';
$strPasDeDotation = 'Nessun premio trovato';
$strPasDeDownload = 'Nessun download trovato';
$strPasDeFichier = 'Nessun file trovato';
$strPasDeLien = 'Nessun link trovato';
$strPasDeMatch = 'Nessuno scontro trovato';
$strPasDeMessage = 'Nessun messaggio trovato';
$strPasDeNews = 'Nessuna news trovata';
$strPasDeReglement = 'Nessuna regola trovata';
$strPasDeSignature = 'Nessuna firma trovata';
$strPassword = 'Password';
$strPCMODS = 'Configura mods';
$strPerdu = 'Perso';
$strPhaseFinales = 'Scontri: finali';
$strPhasePoules = 'Scontri: gironi';
$strphpt_type = 'Tipo d\'utilizzo phpTournois';
$strPing = 'Ping';
$strPolice = 'Font';
$strPort = 'Porta';
$strPostePar = 'Postato da';
$strPoule = 'Girone';
$strPoules = 'Gironi';
$strPreinscrit = 'Pre-iscritto';
$strPreinscrits='Pre-iscritti';
$strPrenom = 'Cognome';
$strPresentation = 'Presentazione';
$strProcesseur = 'Processore';
$strProlongation = 'Gioco prolungato';
$strPseudo = 'Nickname';
$strPts = 'Pts';
$strPublierServeurDans = 'Pubblica in';
$strQstatProtocole= 'Protocollo Qstat';
$strQuitter = 'Abbandona';
$strQuote = 'Citazione';
$strRED = 'Rosso';
$strRang = 'Rang';
$strRecupMatchAB = 'Recupera scontri AdminBot-MX ';
$strRecupMatchM4 = 'Recupera scontri M4';
$strRedigerMessage = 'Scrivi un nuovo messaggio';
$strRegle = 'Regola';
$strReglement = 'Regole';
$strRemettreAZero = 'Reset';
$strRepondre = 'Rispondi';
$strRepondreMessage = 'Rispondi a messaggio';
$strResultats = 'Risultati';
$strResultatsFinales = 'Risultati delle finali';
$strResultatsMatchsPoules = 'Risultati scontri dei gironi';
$strResultatsPoules = 'Risultati dei gironi';
$strRetour = 'Indietro';
$strRule= 'Regole';
$strS = 'X';
$strSInscrire = 'Registrati';
$strSansDemo = 'dati vuoti';
$strScore = 'Risultato';
$strSeed = 'Seed';
$strSemaine = 'Settimana';
$strServeur = 'Server';
$strServeurs = 'Servers';
$strSigle = 'Sigla';
$strSignature = 'Firma';
$strSimpleElimination='Singola';
$strSouligner = 'Sottolineato';
$strSponsors = 'Sponsors';
$strSrv = 'Srv';
$strStatistiques = 'Statistiche';
$strStats = 'Stats';
$strStatus = 'Status';
$strSupprimer = 'Cancella';
$strSupport = 'Supporto tecnico';
$strTableauxPoules = 'Risultati gironi';
$strTag = 'Tag';
$strTaille = 'Size';
$strTempsDeConnexion = 'Tempo conn.';
$strTermine = 'Terminato';
$strTerminerLeTournois = 'Vuoi terminare il torneo ?';
$strTerminerLesPoules = 'Vuoi terminare i gironi ?';
$strTerminerPoules = 'Termina gironi';
$strTerminerTournois = 'Termina il torneo';
$strTitre = 'Titolo';
$strTitres = 'Titoli';
$strTour = 'Turno';
$strTournois = 'Tornei';
$strTous= 'Tutti';
$strTout = 'tutto';
$strToutDeselectionner = 'Deseleziona tutto';
$strToutSelectionner = 'Seleziona tutto';
$strToutes = 'Tutti';
$strType = 'Tipo';
$strTypeTournois = 'Tipo Torneo';
$strUnAllowJoinTeam='Non permettere di unirsi a team';
$strUnAllowPrivateMessage='Disabilita messaggi privati';
$strUpdate='Up-to-Date';
$strURL = 'URL';
$strUrl = 'Link';
$strVIOLET = 'Viola';
$strVS = 'VS';
$strVainqueur = 'Vincitore';
$strValeur = 'Valore';
$strValider = 'Convalida';
$strValiderFinales = 'Convalida finali';
$strValiderLesFinales = 'Vuoi convalidare le finali ?';
$strValiderLesPoules = 'Vuoi convalidare i gironi ?';
$strValiderPoules = 'Convalida i gironi';
$strVille = 'Citt&#224;';
$strVisites = 'visite';
$strWHITE = 'Bianco';
$strWeb = 'Sito Web';
$strWinner = 'Vincitore';
$strYELLOW = 'Giallo';
$tabJoursSemaine = array('Luned&#236;', 'Marted&#236;', 'Mercoled&#236;', 'Gioved&#236;', 'Venerd&#236;', 'Sabato', 'Domenica');
$tabMois = array('Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre');

$strServeursConsignes = 'Istruzioni:<br><li>I campi contrassegnati cos&#236;  <font color=red>*</font> sono necessari.
<li>QStat protocol permette di connettersi a speciali servers (es: HL->CS) per conoscere le loro caratteristiche (status,giocatori,pings, etc) e il loro nome.
<li>Qstat funziona solo su webhoster che supportano la funzione \'exec\' di PHP.
<li>Se usate M4 o AdminBot-MX, dovete mettere un \'tick\' per inserirli nel database M4 or Adminbot.
<li>Attenzione, il campo \'Rcon\', se usate AdminBot-MX, &#232; richiesto.';

$strInscriptionsJoueursConsignes = 'Istruzioni:<br><li>I campi contrassegnati cos�  <font color=red>*</font> sono necessari. 
<li>La password richiesta vi permetter&#224; di autenticarvi e accedere al vostro account in futuro. 
<li>La vostra e-mail deve essere valida per convalidare l\'account (non sar&#224; data a nessun altro).';

$strInscriptionsEquipesConsignes = 'Istruzioni:<br><li>I campi contrassegnati cos&#236;  <font color=red>*</font> sono necessari. 
<li>Prima di creare un team verificate che un altro membro non l\'abbia gi&#224; fatto.
<li>Campo \'Nome\' indicate il nome completo del vostro team (esempio : All Against Authority or GoodGame).
<li>Campo \'Tag\' indicate l\'abbreviazione del vostro team (esempio : aAa or GG).
<li>I team leader possono aggiungere giocatori nel loro team o essi possono farlo da soli se conoscono la password.';

$strTournoisModifyConsignes = '<li>Il campo \'score mode\' corrisponde al modo in cui i risultati sono recuperati. (per esempio se usate M4, dovete segnarlo)<br>
<li>Il campo \'inscription mode\' &#232; usato per definire se i giocatori/managers si possono iscrivere al torneo durante il periodo di iscrizione.<br>
<li>Il campo \'numero di rounds\' indica il massimo numero di round (mappe) per scontro.<br>
<li>I campi \'page X\' sono i nomi del file Y nella cartella /html/X/langue/Y (lang = english, etc..). (se questi campi sono vuoti, queste opzioni saranno disabilitate nel menu).<br>
<li>Il campo \'statistiche\' indica l\'url del web site delle statistiche per questo torneo.
<li>Il campo \'Upload file\' indica se i files possono essere uploadati per ogni scontro.
<li>Il campo \'commenti\' indica se i giocatori degli scontri possono postare commenti.';

$strTournoisConsignes = "<li>I campi contrassegnati cos&#236;  <font color=red>*</font> sono necessari.
<li>Il campo 'type' indica se il torneo &#232; 'tournament' (gironi + finali), 'championship' (solo gironi) o 'cup' (solo finali).<br>
<li>Il campo 'team mode' definisce il tipo di torneo: in team o da soli.<br>
<li>Il campo 'match mode' definisce il modo di gestire lo scoring.<br>
<li>Il campo 'game' deve essere riempito se volete usare l\'utilit&#224; per gestire mappe e servers .";

$strConfigurationConsignes = "<li>Il campo 'registrations' indica se le registrazioni generali di teams/giocatori sono attivate o meno.<br>
<li>Il campo 'registration email ' definisce l'idirizzo a cui rispondere per la mail di iscrizione.<br>
<li>Il campo 'contact email' definisce l'indirizzo di e-mail per i contatti.<br>
<li>Per le altre opzioni, tocca a voi !!.<br>
<li>I campi \'page X\' sono i nomi del file Y nella cartella /html/X/langue/Y (lang = english, etc..). (se questi campi sono vuoti, queste opzioni saranno disabilitate nel menu).<br>
<li>Le opzioni IRC vi permettono di configurare il modulo IRC, i canali menzionati (separati da uno spazio) sono quelli performed on connect.<br>";

$strShoutbox= 'Shoutbox';
$strShoutboxlimit = 'Linee shoutbox';

$strDecroissant='Decreasing';
$strAvec = 'con';
$strArchiveshout = 'Archivio';
$strCroissant='Increasing';
$strShoutdesc = 'ed in ordine';
$strShoutNbcom = 'Commenti'; 
$strShoutNbpage = 'Pagina &#035;';
$strShoutboxlimitc = 'Max caratteri.';
$shoutoption = 'Opzioni display';


/////////////////////MOD
$strServerName='Nome server';
$strADD_t_server='Mostra il tuo server sul sito';
$strADMINNOTE='Note fra admins';
$strRemarque='Commenti fra admins sul giocatore :';
$strRemarqueEQUIPE='Commenti fra admins sul team :';
$strbbcode='Stile BBcode';
$strphpBB='BBcode';
$streditor='Editor';
$strMODS='MODS Admin Panel';
$strMODSC='Nota : Ogni bottone \'modifica\' vale per tutte le MOD';
$strMod='Pannello Mods';
$strServerTeam='Aggiungi servers del team';

// auto validation d'&eacute;quipe par le manager
$strValid_My_Team ='Convalida il mio team';
$strManag_team ='Manager convalida team (se..vedi sotto)';
$strTABmanaging='Mod validazione team';
$strManag_team_num ='Numero di giocatori necessari';
$strOk_validation='<b><span style="color:green">Il tuo team &#232; stato  convalidato</span></b>';
$strNOOk_validation='<b><span style="color:red;font-size:12">Il tuo team non pu&#242; essere convalidato.<br>Mancano ancora giocatori.<br>Se non è cos&#236;, accertati di essere iscritto in uno dei giochi che il team gioca<br>oppure contatta un admin</span></b>';
$strREQ_player='N. di giocatori necessari per convalidare un team :';
$strAuto_valid_def='Teams convalidati alla creazione';
// end auto validation d'&eacute;quipe par le manager

$strSIDINV='Perfavore inserire SteamID per registrarsi ';
$strSIDINV2='Il tuo SteamID deve essere scritto cos&#236; : STEAM_X:X:XXXXXX';
$strSIDINV3='Your SteamID è usato da un altro giocatore !';
$strSIDINV4='SteamID non valido (controlla il campo)';
$strSID='SteamID';
$strSID2='non uso Steam :';
$strSteamIDO = 'Steamid necessario';

$strPremium='Premium';


/********************************************************
 * Mod Rechercher un joueur
 */
$strRechercherJoueur='Cerca player';
$strRechecrher='Cerca';
$strRechInvalide='Sorry, nessun risultato trovato.';
$strRechInvalide2='Sorry, nessun risultato trovato.<br>I nicknames simili trovati sono : ';
$strAc_rechehlp='Inserisci anche solo una parte del nickname o "<font color="red">*</font>" per cercare tutti i nicknames';
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
$strAc_annueff='Cancel/Cancella this order';
$strAc_anu='Expert Mode';
$strAc_readme='( Read under this before adding any modification )<br>To validate your selection, click on [- OK -]';
$strAc_cmddejapasser='The order has already been taken';
$strAc_wdoyouwant=', Do you want to validate or cancel ?';
$strAc_cmdlancer='Order in progress';
$strAc_enlever='Cancella item';
$strAc_ajouter='Aggiungi item';
$strAc_lister='Read the order (validate/cancel)';
$strAc_commandes='Orders';
$strAc_add='Aggiungi';
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
$strAc_listnick='Your ricerca found equivalent nicknames';
$strAc_listnickfailed='Your ricerca found no equivalent nicknames to your entry';
$strAC_alertea='This action will signal to every costumers on this list that their orders has arrived.(they can take it and/or pay it)';
$strAC_alerteregle='This action will make every orders on this list considered as paid.';
$strAC_alerteprit='This action will make every orders on this list marqued as delivered';
$strAC_alertedel='Warning !!!You are about to delete the entire content of this order';
$strAc_youareadmin='Go to the admin page';
$strAc_ifcmdok='If your order(s) has been delivered please click on "Order in progress"<br>to put the order to OFF';
$strAc_consae='<p align="left"><font size="2">How does it work ?, is a good Domanda you ll tell me.<br>At the beginning you had to click one to four time per orders to modify its status to  \ treated\ <br> Now we can view all the orders.<br> The two check boxes above 
fill themselves automatically. The first one will write the orders <font color="#0000FF"><strong>ID</strong></font> 
that you asked to delete.<br>The second will count the number of boxes you checked.
<br><br><font color="#009900"><strong>In case of error (you clicked on the wrong check box) </strong></font><strong>:
</strong><bR> All you have to do is delete the <font color="#0000FF"><strong>ID </strong><font color="#000000">from the list and 
the &quot;pipe&quot; (symbole &quot;|&quot;) found on its right.</font></font><br>Example 2|6|33| you
want to remove the <font color="#0000FF"><strong>ID</strong></font> 6 so you set it to : 2|33|. Finally, downgrade the number of the next box by 1.<br>Example, for 2|6|33| it displayed \'3\' with 2|33| you downgrade 1 to 3 which gives 2.<br>You can also Aggiungi but don\'t forget to increment also the next box</font></p><p align="left"><font size="-1">If you find this too difficult click on  <strong>
<font color="#FF0000">RESET</font></strong>. This will erase everything.</font></p><p align="left">
<font size="-1">Have A Good Lan Party!</font></p>';
$strAc_artfin='\'??|��</font>\'is your item status &quot;<font color="#FF0000">??</font>&quot; If your item has been payed or not. &quot;<font color="#FF0000">��</font>&quot; 
If your order has arrived or not.<br></em></font>';
$strAc_nocmdsry='- No items -';
$strAc_youneedloginfirst='You have to be logged in first';
$strAc_pannier='Your bag';
$strAc_commander='Order';
$strAc_jecpukoimettre='??|��';
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
$strlastvisit = 'Ultima visita :';
$custheme='Cambia tema';
$strarbitre = 'Amministratore Troneo';
$strElementsNpageExistant = 'Pagina esistente &#035;';
$strElementsNpageInvalide = 'Invalida pagina &#035;';
$strElementsMenuLien = 'Se la pagina &#232; nel menu, serve un link';
$strElementsMenuLien2 = 'Se la pagina ha un link, serve un menu';
$strElementsOrdeInvalide2 = 'L\'ordine dei link deve essere un numero';
$strElementsRubriqueInvalide = 'Rubrica non valida';
$strElementsNmenuInvalide='Menu non valido';
$strAjouterPage='Aggiungi pagina';
$strRubrique='Rubrica';
$strNpage='Pagina &#035;';
$strNmenu='Menu';
$strLien='Link';
$strOrdre='Ordine';
$strAcces='Accesso';
$strTous='Tutti';
$strModifierPageR ='Modifica la pagina in quale rubrica ?';
$strModifierPage='Modifica la pagina';
$strElementsOdreInvalide='L\'ordinale dei menu deve essere un numero';
$strAlign='Allinea';
$strGauche='Sinistra';
$strDroite='Destra';
$strHide='Nascosto';
$strModifierMenus='Modifica menu';
$strAjouterMenu='Aggiungi menu';
$strModifierMenu='Modifica menu';
$strScript='Script';
$strpagescript='Authorizza HTML';
$strAddPage='Aggiungi pagina';
$strModPage='Modifica pagina';
$strAddMenu='Gestione menu';
$strLienex = 'URL pagina:';

$strMODEnLigne='configurazione colori "online"';
$strMODEnLigneA='Admin';
$strMODEnLigneN='Newser';
$strMODEnLigneM='Manager';
$strMODEnLigneW='War Arranger';
$strMODEnLigneMo='Mod';

$strCPPW='Punti vittoria';
$strCPPN='Punti pareggio';
$strCPPL='Punti sconfitta';
$strCPPF='Punti abbandono';

$strAddPageConsignes = '<li>Titolo : titolo pagina (per trovarla velocemente quando vuoi modificarla).<br>
 <li>Rubrica : Se la pagina fa parte della stessa rubrica/cartella. 
 (un menu a tendina<br>
 ti mostra le rubriche disponibili).<br>
 <li>N. pagina : Non &#232; utile in realt&#224; ma mostra il n. della pagina nella rubrica.<br>
 <li>Menu : Il menu che conterr&#224; la pagina (se vuoto, la pagina dovr&#224; essere linkata da un\'altra pagina )
 .&nbsp; <br>
 <li>Link : Testo del link nel menu.<br>
 <li>Ordine : Posizione link nel menu.&nbsp;<br>
 <li>Accesso : Definisce se la pagina necessita un rank
 (logged in member, guest, admin ou newser) per essere vista.<br>Gli amministratori possono vedere tutte le pagine.<br>
 <br>
 <li><img src="images/bb_codescript.gif" border="0" /> Compare se clicchi "authorizza 
html" nel pannello controllo MODS.<br>
 Gli scripts devono stare fra le tags [script] [/script] 
 per essere interpretati.
 <br>
 &nbsp;';
 //////mod ladder
 $strModsladder='Ladder Admin Panel';
 $strLadder='Ladders';
 $strLadlist='Select a ladder';
 $strMODAddlad='Aggiungi a ladder';
 $strLadjeux='Game';
 $strLadType='Type';
 $strRegLad='Ladder rules';
 $strLadName='Ladder name';
 $strMODlistlad='Modifica which ladder ?';
 $strLadNameMod='Modifica a ladder';
 $strladnodatafoundlist='There isn\'t any existing ladder yet';
 $strLadduel='Start a duel';
 $strLadduel1='Start a duel with this player';
 $strLadduele='Start a duel with this team';
 $strLadduel2='Challenge this player in a duel';
 $strMODAdddel='Cancella a ladder';
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
 $strLAD_whosteam = 'What team you want to Aggiungi ?';
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
$str_faq_choose='<font size="2" color=blue><b>Scegli una categoria :</b></font>';
$str_faq_admin='.: FAQs ADMIN PANEL:.';
$str_faq_al1='<font size="2" color="red"><b>Ci deve essere almeno una categoria prima</b></font><br><br>';
$str_faq_al2='<font size="2" color="red"><b>Ci deve essere almeno una Domanda/Risposta prima</b></font><br><br>';
$str_faq_al3='<font size="2" color="red"><b>Ci devono essere almeno due categorie prima</b></font><br><br>';
$str_faq_al4='<font size="2" color="red"><b>Ci devono essere almeno due Domande/Risposte prima</b></font><br><br>';
$str_faq_al5='<font size="2" color="green"><b>Categoria cancellata</b></font><br><br>';
$str_faq_al6='<font size="2" color="red"><b>Niente campi vuoti perfavore</b></font><br><br>';
$str_faq_actA='Aggiungi categoria';
$str_faq_actB='Aggiungi Domanda/Risposta';
$str_faq_actC='Modifica categoria';
$str_faq_actD='Modifica Domanda/Risposta';
$str_faq_actE='Organizza Categorie';
$str_faq_actF='Organizza Domande/Risposte';
$str_faq_actG='Cancella categoria';
$str_faq_actH='Cancella Domanda/Risposta';
$str_faq_actI='Sposta Domanda/Risposta';
$str_faq_addq='Domanda/Risposta aggiunta';
$str_faq_addqr='Aggiungi Domanda/Risposta :';
$str_faq_in='In categoria :';
$str_faq_q='Domanda :';
$str_faq_r='Risposta :';
$str_faq_par='A :';
$str_faq_nothing='Nessuna Domanda/Risposta in questa categoria';
$str_faq_inter='Domanda/Risposta spostata !';
$str_faq_mettre='Metti :';
$strFaq='FAQ :';
$str_faq_error='Sorry, nessuna categoria finora';
 //end FAQ
 
 //FORUM 
 $strAjouterReponse='Aggiungi risposta';
 $strModifyReponse='Modifica risposta';
 $strFLast='Ultimo messaggio da :';
 $strTopic='Topic :';
 $strTopicde='Creato da :';
 $strAjouterCategorie='Aggiungi categoria';
 $strDesc='Descrizione';
 $strEffcaerCategorie='Cancella categoria';
 $strFdep='Sposta topics in '; 
 $strFneedlog='Devi essere loggato per<br>crere un topic.';
 $strFdelall='Cancella senza spostare';
 $strFras='Nessuna categoria finora';
 $strEditeCategorie='Modfica categoria';
 //v2
 $strFNbpage ='Pagina &#035;';
 //$strAvec='with';
 $strFnbtop='topics';
 $strFnbsub='risposte';
 $strFnbtdd='ed in ordine';
 //$strCroissant='increasing';
 $strDecroissant='decreasing';
 $strModo='Mod';
 $strFedit='Messaggio modificato :';
 $strBy='di';
 //end v2
 $strForumnbpost='Numero di posts sul forum';
 $strNbpost='Messaggi';
 $strRkforum='Titolo Forum';
 $strAjouterTopic='Aggiungi Topic';
 $strWhereDep='Sposta topic in categoria';
 $strDepsujet='Sposta tutti topics';
 $strDelsujet='Cancella questo post';
 $strEdsujet='Modifica questo post';
 $strReservedTo='Accessibile a';
 $strReservedTonb='<br>nota : Gli amministratori possono accedere a tutto, togli la spunta a tutto per una categoria "admin only"';
 $strDelCatCookie='Cancella cookies da questa categoria';
 $strIWTL='Chiudi topic';
 $strIWTUL='Apri topic';
 $strSujet='Topic';
 $strMessage='Messaggi';
 $strDernier='Ultimo';
 $strFrasUnacces='Nessun topic può essere acceduto col tuo status. Log in se non l\'hai gi&#224; fatto.<br>Se ancora non puoi accedere il topic, contatta un amministatore indiucando il tuo rank (user, manager, mod...).';
 $forum_need_more_ac='<small>Il risultato necessita essere admin/mod o avere un rank per essere acceduto</small>';
 $strPost_id = 'Post n.';
 $strPost_link = 'Puoi usare il link nel box sotto come link diretto a questo post';
 //END FORUM

$strPageDeBBcode='BBcode help page';

// top 10
$strtop10='MODS "TOP 10"';
$strtop10dl='Blocca downloads';
$strtop10player='10 nuovi membri';
$strlastresult='5 ultimi risultati';
$strlastnews='10 ultime news';
$strlastnews_header='5 ultime news in header';
$strlastnews5='5 ultime News';
$strNoresultnow='Nessun risultato finora...';
$strNonewsnow='Nessuna news finora..';
$strtop10_mod='"TOP" Mod';

/* Fichier plan.php */
$strLibre = 'Libero';
$strEquipePresente = 'Team gi&#224;presente nella stanza';
$strEquipeNonDefini = 'Nessun team selezionato';
$strJoueurNonManager= 'Non sei manager di nessun team';
$strChoixEmplacement = 'Seleziona posizione';
$strSelectionEquipeConsignes = '<li>Solo i twam manager possono riservare posti. La posizione che hai selezionato &#232; solo <font color=red>una richiesta</font> di posizionamento..</li>
<li>Se vuoi cambiare posizione, contatta un amministratore</li>';
$strAdministrationReservation = 'Amministrazione room';
$strPlanSalle = 'Room plan';

//admin tournois
//special arbitre
$strarbitre = 'Gli arbitri';
$strInscriptionsTournoisArbitre = 'Contatta un admin solo se necessario';

//search
$strTopic='Topic';
$strFLast='Di';
$strRechecrher='Cerca';
$strRechercher='Cerca';
$strRechercherJoueur='Cerca giocatore';
$strElementsSearchInvalide='Ricerca incompleta';
$strSearchUnresult='Nessun risultato.';
$strS_listtnick_error='Nessun giocatore trovato.';
$strS_listnick='La ricerca ha trovato questi giocatori';
$strS_listteam_error='Nessun team trovato.';
$strS_listteam='La ricerca ha trovato questi teams';
$strS_listnews_error='Nessuna news trovata.';
$strS_forum_error='Nessun topic trovato';
$strS_nomatch = 'Sorry, ricerca fallita.';
$strRechercherSteam=' Cerca STEAM_ID ';
$strS_listtsteam_error=' Nessuno STEAM_ID trovato.';
$strS_liststeam='La ricerca ha trovato questi STEAM_IDs';
$strElementsSteamInvalide='Devi specificare uno STEAM_ID';
// end search



// RANK
$strRang_a='&#200; Admin-Master';
$strRang_b='&#200; Admin';
$strRang_c='Pu&#242; modificare config & mod';
$strRang_d='Pu&#242; gestire downloads';
$strRang_e='Pu&#242; gestire teams';
$strRang_f='&#200; a FAQ-Master';
$strRang_g='Pu&#242; gestire pagine';
$strRang_h='Pu&#242; gestire links';
$strRang_i='Pu&#242; gestire guest book';
$strRang_j='Pu&#242; gestire players';
$strRang_k='Pu&#242; gestire room plan';
$strRang_l='Pu&#242; gestire mailing list';
$strRang_m='&#200; Moderatore';
$strRang_n='&#200; Newser';
$strRang_o='Pu&#242; accedere al menu admin';
$strRang_p='Pu&#242; gestire i partners';
$strRang_q='Pu&#242; gestire la gallery';
$strRang_r='Pu&#242;gestire i servers';
$strRang_s='Pu&#242; gestire gli sponsors';
$strRang_t='Pu&#242; gestire tornei/mappe/giochi';
$strRang_u='Pu&#242; gestire ladders/mappe/giochi';
$strRang_v='Pu&#242; gestire AdminBot e M4';
$strRang_w='Pu&#242; modificare i ranks';
$strRang_x='Manager di almeno un team';
$strRang_y='War Arranger di almeno un team';
$strRang_z='User (Se no = bannato)';
$strEdit_rang='Modifica poteri';
$strRang_wrong='Non puoi modificare i poteri di un admin-master <br>se non sei uno tu stesso !';
//RANK
$strFLOG='Gli amministratori vogliono che tutti si identifichino.';
$strFtitle_sec='Sicurezza';
$strFtitle='Forza login';

// fix BBcode JAVA
$strL_BBCODE_B_HELP='Grassetto: [b]testo[/b] (alt+b)';
$strL_BBCODE_I_HELP='Corsivo: [i]testo[/i] (alt+i)';
$strL_BBCODE_U_HELP='Sottolineato: [u]testo[/u] (alt+u)';
$strL_BBCODE_Q_HELP='Citazione: [quote]quotation text[/quote] (alt+q)';
$strL_BBCODE_C_HELP='Codice: [code]code[/code] (alt+c)';
$strL_BBCODE_L_HELP='Lista: [list]testo[/list] (alt+l)';
$strL_BBCODE_O_HELP='Lista Ordinata: [list=]testo[/list] (alt+o)';
$strL_BBCODE_P_HELP='Immagine: [img]http://image_url/[/img] (alt+p)';
$strL_BBCODE_W_HELP='Link: [url]http://url/[/url] or [url=http://url/]Nom[/url] (alt+w)';
$strL_BBCODE_S_HELP='Colore: [color=red]testo[/color] hint: #FF0000 works too';
$strL_BBCODE_F_HELP='Dimensione testo: [size=x-small]small[/size]';
$strL_BBCODE_A_HELP='Close all the open BBCode Buoys';
$strL_BBCODE_N_HELP='The BBCode wont be interpreted between these buoys [noBBcode][B]not in bold[/B][/nobbcode]';
$strL_BBCODE_CLOSE_TAGS='Chiudi i tags!';
$strL_EMPTY_MESSAGE='Nessun contenuto !';
$strL_STYLES_TIP='Hint: i tag possono essere applicati ad un testo selezionato';
$strAlignHelp='Allineamento: [align=center]Testo centrato[/align]';
$strAlign='Allineamento';
$strLeft='A Sinistra';
$strRight='A destra';
$strCenter='Centrato';
$strJustify='Giustificato';
$strSurligner='Evidenziato';
$strSurligner_help='Evidenziare [bgcolor=red]testo evidenziato in rosso[/bgcolor]';
// end fox BBcode JAVA

// MOD LEFT TEAM
$strLeaveTeam='Lascia team';
$strLeaveTeamALERT='Sicuro di voler lasciare il team ?';
// END MOD LEFT TEAM

//pc
$strADMINPANEL='Pannello Admin';
// end pc

//sondage
$strBaseInexistante='The database doesn\'t exist, So it\'s not updated.';
$strNoSondage = 'Nessun sondaggio';
$strSondage = 'Sondaggio';
$strAllSondage = 'Vedi tutti';
$strVoter = 'Vota';
$strAdminSondage = 'Pannello ammin.Sondaggi';
$strAddSondage = 'Aggiungi sondaggio';
$strModSondage = 'Modifica sondaggio';
$strDelSondage = 'Cancella sondaggio';
$strCloseSondage = 'Chiudi sondaggio';
$strSondageName = 'Nome sondaggio';
$strOptSondage = 'Opzioni sondaggio';
$strOption = 'Opzioni';
$strRank = 'Rank';
$strAddOption = 'Aggiungi <input type=\'text\' name=\'nb_opt\' value=\'1\' maxlength=\'2\' size=\'2\'> opzione/i';
$strNoSondageName = 'Devi dare un nome al sondaggio';
$strNoSondageOptions = 'Devi selezionare una opzione';
$strConfirmDelSondage = 'Vuoi cancellare il sondaggio?';
$strConfirmCloseSondage = 'Vuoi chiudere il sondaggio?';
$strVoteSondage = 'Vota sondaggio';
$strSondClosed = '(chiuso)';
$strAlreadyVoted = 'Hai gi&#224; votato per questo sondaggio';
$strVote = 'Voto';

//update  & install :
$strConfiguration_general='Configurazione generale';
$strSessions_variables='variabili sessione';
$strFlood_variable='variabili Flood';
$strtable_col='Numero colonne per tabelle';
$strnumxp='Numero di ... per pagina';
$strnb_news_max = 'News';
$strnb_news_commentaires_max = 'commenti News';
$strnb_matchs_commentaires_max = 'Commenti scontri';
$strnb_livredor_max = 'Firma guestbook';
$strnb_gallery_thumb = 'Galleria Immagini';
$strnb_sondage_commentaires_max = 'commenti sondaggio';
$strsess_cookie_min = 'Durata cookie';
$strsess_gc_days = 'Sessione (gc) in giorni';
$strstats_timeout = 'Durata dei backups delle statistiche';
$strflood_time = 'Flood time';
$strx_delta_simple = 'Albero semplice';
$strx_delta_double = 'Albero doppio';
$strcol_equipes = 'Colonna Team';
$strcol_joueurs = 'Colonna giocatori';
$strcol_poules = 'Colonna Gironi';
$strcol_matchs_poules = 'Colonna scontri giorni';
$strcol_maps = 'Colonna mappe';
$strcol_jeux = 'Colonna giochi';
$strcol_serveurs = 'Colonna server';
$strcol_administrateurs = 'Colonna Admins';
$strcol_avatar_gallerie = 'Colonna Avatars (gallerie)';
$strcol_sponsors = 'Colonna Sponsors';
$strcol_categories = 'Colonna Categorie';
$strcol_gallery_thumb = 'Colonna galleria (thumb)';
$strtm4rulecfg = '.cfg files of M4 rules';
$strm4campscfg = 'tipi di campo';
$strm4autostartcfg = 'Auto-start';
$strm4prolongationcfg = 'Prolungamento';
$strabrulecfg = 'cfg rules';
$strabcampscfg = 'tipi di campo';
$strabautostartcfg = 'auto start';
$strabprolongationcfg = 'prolungamento';
$strInstallStage3Delupdatel = 'Attenzione! il file update.php non pu&#242; essere cancellato.<br><u>Per la vostra sicurezza,</u> &#232; <u>FORTEMENTE RACCOMMANDATO</u> di cancellare il file manualmente';

//news english
$strNews2='Versione inglese';
$strElementsTitreInvalide2='Il titolo della news inglese non &#232; valido';
$strElementsContenuInvalide2='Il corpo della news inglese non &#232; valido';
$strNewsUK='Abilita news inglesi';

$str_phptteam = "Cordially,<br>phpTournois Team";
$X = 'Attendi l\'approvazione dell\'avversario';
$A = 'l\'approvazione dello sfidante';
$B = 'Attendi risultato';
$D = 'Invita a scontro';
$V = 'Scontro terminato';

//export
$strEXPORT_tree = 'Esporta albero del torneo';
$strEXPORT_done = 'Albero esportato in include/export/f_';
$strEXPORT_done2 = 'Usa questo link per pagina esportata :';
$strEXPORT_name = 'Titolo link';

$strTG4JOINT='Unisciti a team';
$strTG4NT='Nuovo team';
$strTG4MT='Miei teams';
$strTG4MP='PM';
$strTG4MPB='Nuovo PM!';
$strTG4MPNB='PM box';
$strLinkex='Scambio link!';
$strMessageenvoyez = 'Messaggio inviato.';

$strTop10dl = 'Top 10 DL';
$strLastregistred= 'ultimi registrati';
$strContactout = ', ti ha contattato attraverso il profilo phpTG4.<br />ma la mail non è stata inviata per dei problemi.<br />Ecco il messaggio :<br />';

$str_phpTG4_v = 'La tua versione &#232; :';
$str_phpTG4_vo = 'L\'ultima versione &#232; :';

$strPMED = 'Messaggio inviato tramite PM';
$strPMED_no = 'Messaggio non pu&#242; essere inviato: mail non configurata';
$install_error = 'Non puoi installare se il file g4.g4  è ella root di phpTG4 !';

$strPour = 'per';
$strNoarbitres = 'Nessun arbitro per questo torneo, finora';
$strSanctions = 'Sanzioni';
$strNoUserOnline = 'Nessun utente online';
?>

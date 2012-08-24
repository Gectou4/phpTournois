/*
 * FCKeditor - The text editor for internet
 * Copyright (C) 2003-2005 Frederico Caldeira Knabben
 * 
 * Licensed under the terms of the GNU Lesser General Public License:
 * 		http://www.opensource.org/licenses/lgpl-license.php
 * 
 * For further information visit:
 * 		http://www.fckeditor.net/
 * 
 * File Name: fr.js
 * 	French language file.
 * 
 * File Authors:
 * 		Hubert Garrido (liane@users.sourceforge.net)
 */

var FCKLang =
{
// Language direction : "ltr" (left to right) or "rtl" (right to left).
Dir					: "ltr",

ToolbarCollapse		: "Masquer Outils",
ToolbarExpand		: "Afficher Outils",

// Toolbar Items and Context Menu
Save				: "Enregistrer",
NewPage				: "Nouvelle Page",
Preview				: "Pr&eacute;visualisation",
Cut					: "Couper",
Copy				: "Copier",
Paste				: "Coller",
PasteText			: "Coller comme texte",
PasteWord			: "Coller de Word",
Print				: "Imprimer",
SelectAll			: "Tout s&eacute;lectionner",
RemoveFormat		: "Supprimer Format",
InsertLinkLbl		: "Lien",
InsertLink			: "Ins&eacute;rer/Modifier Lien",
RemoveLink			: "Supprimer Lien",
Anchor				: "Ins&eacute;rer/Modifier Ancre",
InsertImageLbl		: "Image",
InsertImage			: "Ins&eacute;rer/Modifier Image",
InsertFlashLbl		: "Animation Flash",
InsertFlash			: "Ins&eacute;rer/Modifier Animation Flash",
InsertTableLbl		: "Tableau",
InsertTable			: "Ins&eacute;rer/Modifier Tableau",
InsertLineLbl		: "S&eacute;parateur",
InsertLine			: "Ins&eacute;rer S&eacute;parateur",
InsertSpecialCharLbl: "Caractère Sp&eacute;cial",
InsertSpecialChar	: "Ins&eacute;rer Caractère Sp&eacute;cial",
InsertSmileyLbl		: "Smiley",
InsertSmiley		: "Ins&eacute;rer Smiley",
About				: "A propos de FCKeditor",
Bold				: "Gras",
Italic				: "Italique",
Underline			: "Soulign&eacute;",
StrikeThrough		: "Barr&eacute;",
Subscript			: "Indice",
Superscript			: "Exposant",
LeftJustify			: "Align&eacute; à Gauche",
CenterJustify		: "Centr&eacute;",
RightJustify		: "Align&eacute; à Droite",
BlockJustify		: "Texte Justifi&eacute;",
DecreaseIndent		: "Diminuer le Retrait",
IncreaseIndent		: "Augmenter le Retrait",
Undo				: "Annuler",
Redo				: "Refaire",
NumberedListLbl		: "Liste Num&eacute;rot&eacute;e",
NumberedList		: "Ins&eacute;rer/Supprimer Liste Num&eacute;rot&eacute;e",
BulletedListLbl		: "Liste à puces",
BulletedList		: "Ins&eacute;rer/Supprimer Liste à puces",
ShowTableBorders	: "Afficher Bordures de Tableau",
ShowDetails			: "Afficher Caractères Invisibles",
Style				: "Style",
FontFormat			: "Format",
Font				: "Police",
FontSize			: "Taille",
TextColor			: "Couleur de Caractère",
BGColor				: "Couleur de Fond",
Source				: "Source",
Find				: "Chercher",
Replace				: "Remplacer",
SpellCheck			: "Orthographe",
UniversalKeyboard	: "Clavier Universel",

Form			: "Formulaire",
Checkbox		: "Case à cocher",
RadioButton		: "Bouton Radio",
TextField		: "Champ Texte",
Textarea		: "Zone Texte",
HiddenField		: "Champ cach&eacute;",
Button			: "Bouton",
SelectionField	: "Liste/Menu",
ImageButton		: "Bouton Image",

// Context Menu
EditLink			: "Modifier Lien",
InsertRow			: "Ins&eacute;rer une Ligne",
DeleteRows			: "Supprimer des Lignes",
InsertColumn		: "Ins&eacute;rer une Colonne",
DeleteColumns		: "Supprimer des Colonnes",
InsertCell			: "Ins&eacute;rer une Cellule",
DeleteCells			: "Supprimer des Cellules",
MergeCells			: "Fusionner les Cellules",
SplitCell			: "Scinder les Cellules",
CellProperties		: "Propri&eacute;t&eacute;s de Cellule",
TableProperties		: "Propri&eacute;t&eacute;s de Tableau",
ImageProperties		: "Propri&eacute;t&eacute;s d'Image",
FlashProperties		: "Propri&eacute;t&eacute;s d'Animation Flash",

AnchorProp			: "Propri&eacute;t&eacute;s d'Ancre",
ButtonProp			: "Propri&eacute;t&eacute;s de Bouton",
CheckboxProp		: "Propri&eacute;t&eacute;s de Case à Cocher",
HiddenFieldProp		: "Propri&eacute;t&eacute;s de Champ Cach&eacute;",
RadioButtonProp		: "Propri&eacute;t&eacute;s de Bouton Radio",
ImageButtonProp		: "Propri&eacute;t&eacute;s de Bouton Image",
TextFieldProp		: "Propri&eacute;t&eacute;s de Champ Texte",
SelectionFieldProp	: "Propri&eacute;t&eacute;s de Liste/Menu",
TextareaProp		: "Propri&eacute;t&eacute;s de Zone Texte",
FormProp			: "Propri&eacute;t&eacute;s de Formulaire",

FontFormats			: "Normal;Formatted;Address;Titre 1;Titre 2;Titre 3;Titre 4;Titre 5;Titre 6",

// Alerts and Messages
ProcessingXHTML		: "Calcul XHTML. Veuillez patienter...",
Done				: "Termin&eacute;",
PasteWordConfirm	: "Le texte à coller semble provenir de Word. D&eacute;sirez-vous le nettoyer avant de coller?",
NotCompatiblePaste	: "Cette commande n&eacute;cessite Internet Explorer version 5.5 minimum. Souhaitez-vous coller sans nettoyage?",
UnknownToolbarItem	: "El&eacute;ment de barre d'outil inconnu \"%1\"",
UnknownCommand		: "Nom de commande inconnu \"%1\"",
NotImplemented		: "Commande non encore &eacute;crite",
UnknownToolbarSet	: "La barre d'outils \"%1\" n'existe pas",

// Dialogs
DlgBtnOK			: "OK",
DlgBtnCancel		: "Annuler",
DlgBtnClose			: "Fermer",
DlgBtnBrowseServer	: "Parcourir le Serveur",
DlgAdvancedTag		: "Avanc&eacute;",
DlgOpOther			: "&lt;Autre&gt;",
DlgInfoTab			: "Info",
DlgAlertUrl			: "Veuillez saisir l'URL",

// General Dialogs Labels
DlgGenNotSet		: "&lt;Par D&eacute;faut&gt;",
DlgGenId			: "Id",
DlgGenLangDir		: "Sens d'Ecriture",
DlgGenLangDirLtr	: "Gauche vers Droite (LTR)",
DlgGenLangDirRtl	: "Droite vers Gauche (RTL)",
DlgGenLangCode		: "Code Langue",
DlgGenAccessKey		: "Equivalent Clavier",
DlgGenName			: "Nom",
DlgGenTabIndex		: "Ordre de Tabulation",
DlgGenLongDescr		: "URL de Description Longue",
DlgGenClass			: "Classes de Feuilles de Style",
DlgGenTitle			: "Titre Indicatif",
DlgGenContType		: "Type de Contenu Indicatif",
DlgGenLinkCharset	: "Encodage de Caractère de la cible",
DlgGenStyle			: "Style",

// Image Dialog
DlgImgTitle			: "Propri&eacute;t&eacute;s d'Image",
DlgImgInfoTab		: "Informations sur l'Image",
DlgImgBtnUpload		: "Envoyer au Serveur",
DlgImgURL			: "URL",
DlgImgUpload		: "Upload",
DlgImgAlt			: "Texte de Remplacement",
DlgImgWidth			: "Largeur",
DlgImgHeight		: "Hauteur",
DlgImgLockRatio		: "Garder proportions",
DlgBtnResetSize		: "Taille Originale",
DlgImgBorder		: "Bordure",
DlgImgHSpace		: "HSpace",
DlgImgVSpace		: "VSpace",
DlgImgAlign			: "Alignement",
DlgImgAlignLeft		: "Gauche",
DlgImgAlignAbsBottom: "Abs Bas",
DlgImgAlignAbsMiddle: "Abs Milieu",
DlgImgAlignBaseline	: "Bas du texte",
DlgImgAlignBottom	: "Bas",
DlgImgAlignMiddle	: "Milieu",
DlgImgAlignRight	: "Droite",
DlgImgAlignTextTop	: "Haut du texte",
DlgImgAlignTop		: "Haut",
DlgImgPreview		: "Pr&eacute;visualisation",
DlgImgAlertUrl		: "Veuillez saisir l'URL de l'image",
DlgImgLinkTab		: "Lien",

// Flash Dialog
DlgFlashTitle		: "Propri&eacute;t&eacute;s d'animation Flash",
DlgFlashChkPlay		: "Lecture automatique",
DlgFlashChkLoop		: "Boucle",
DlgFlashChkMenu		: "Activer menu Flash",
DlgFlashScale		: "Affichage",
DlgFlashScaleAll	: "Par d&eacute;fault (tout montrer)",
DlgFlashScaleNoBorder	: "Sans Bordure",
DlgFlashScaleFit	: "Ajuster aux Dimensions",

// Link Dialog
DlgLnkWindowTitle	: "Propri&eacute;t&eacute;s de Lien",
DlgLnkInfoTab		: "Informations sur le Lien",
DlgLnkTargetTab		: "Destination",

DlgLnkType			: "Type de Lien",
DlgLnkTypeURL		: "URL",
DlgLnkTypeAnchor	: "Ancre dans cette page",
DlgLnkTypeEMail		: "E-Mail",
DlgLnkProto			: "Protocole",
DlgLnkProtoOther	: "&lt;autre&gt;",
DlgLnkURL			: "URL",
DlgLnkAnchorSel		: "S&eacute;lectionner une Ancre",
DlgLnkAnchorByName	: "Par Nom d'Ancre",
DlgLnkAnchorById	: "Par Id d'El&eacute;ment",
DlgLnkNoAnchors		: "&lt;Pas d'ancre disponible dans le document&gt;",
DlgLnkEMail			: "Adresse E-Mail",
DlgLnkEMailSubject	: "Sujet du Message",
DlgLnkEMailBody		: "Corps du Message",
DlgLnkUpload		: "Upload",
DlgLnkBtnUpload		: "Envoyer au Serveur",

DlgLnkTarget		: "Destination",
DlgLnkTargetFrame	: "&lt;cadre&gt;",
DlgLnkTargetPopup	: "&lt;fenêtre popup&gt;",
DlgLnkTargetBlank	: "Nouvelle Fenêtre (_blank)",
DlgLnkTargetParent	: "Fenêtre Mère (_parent)",
DlgLnkTargetSelf	: "Même Fenêtre (_self)",
DlgLnkTargetTop		: "Fenêtre Sup&eacute;rieure (_top)",
DlgLnkTargetFrameName	: "Nom du Cadre de Destination",
DlgLnkPopWinName	: "Nom de la Fenêtre Popup",
DlgLnkPopWinFeat	: "Caract&eacute;ristiques de la Fenêtre Popup",
DlgLnkPopResize		: "Taille Modifiable",
DlgLnkPopLocation	: "Barre d'Adresses",
DlgLnkPopMenu		: "Barre de Menu",
DlgLnkPopScroll		: "Barres de D&eacute;filement",
DlgLnkPopStatus		: "Barre d'Etat",
DlgLnkPopToolbar	: "Barre d'Outils",
DlgLnkPopFullScrn	: "Plein Ecran (IE)",
DlgLnkPopDependent	: "D&eacute;pendante (Netscape)",
DlgLnkPopWidth		: "Largeur",
DlgLnkPopHeight		: "Hauteur",
DlgLnkPopLeft		: "Position Gauche",
DlgLnkPopTop		: "Position Haut",

DlnLnkMsgNoUrl		: "Veuillez saisir l'URL",
DlnLnkMsgNoEMail	: "Veuillez saisir l'adresse e-mail",
DlnLnkMsgNoAnchor	: "Veuillez s&eacute;lectionner une ancre",

// Color Dialog
DlgColorTitle		: "S&eacute;lectionner",
DlgColorBtnClear	: "Effacer",
DlgColorHighlight	: "Highlight",
DlgColorSelected	: "S&eacute;lectionn&eacute;",

// Smiley Dialog
DlgSmileyTitle		: "Ins&eacute;rer Smiley",

// Special Character Dialog
DlgSpecialCharTitle	: "Ins&eacute;rer Caractère Sp&eacute;cial",

// Table Dialog
DlgTableTitle		: "Propri&eacute;t&eacute;s de Tableau",
DlgTableRows		: "Lignes",
DlgTableColumns		: "Colonnes",
DlgTableBorder		: "Bordure",
DlgTableAlign		: "Alignement",
DlgTableAlignNotSet	: "<Par D&eacute;faut>",
DlgTableAlignLeft	: "Gauche",
DlgTableAlignCenter	: "Centr&eacute;",
DlgTableAlignRight	: "Droite",
DlgTableWidth		: "Largeur",
DlgTableWidthPx		: "pixels",
DlgTableWidthPc		: "pourcentage",
DlgTableHeight		: "Hauteur",
DlgTableCellSpace	: "Espacement",
DlgTableCellPad		: "Contour",
DlgTableCaption		: "Titre",

// Table Cell Dialog
DlgCellTitle		: "Propri&eacute;t&eacute;s de cellule",
DlgCellWidth		: "Largeur",
DlgCellWidthPx		: "pixels",
DlgCellWidthPc		: "pourcentage",
DlgCellHeight		: "Hauteur",
DlgCellWordWrap		: "Retour à la ligne",
DlgCellWordWrapNotSet	: "<Par D&eacute;faut>",
DlgCellWordWrapYes	: "Oui",
DlgCellWordWrapNo	: "Non",
DlgCellHorAlign		: "Alignement Horizontal",
DlgCellHorAlignNotSet	: "<Par D&eacute;faut>",
DlgCellHorAlignLeft	: "Gauche",
DlgCellHorAlignCenter	: "Centr&eacute;",
DlgCellHorAlignRight: "Droite",
DlgCellVerAlign		: "Alignement Vertical",
DlgCellVerAlignNotSet	: "<Par D&eacute;faut>",
DlgCellVerAlignTop	: "Haut",
DlgCellVerAlignMiddle	: "Milieu",
DlgCellVerAlignBottom	: "Bas",
DlgCellVerAlignBaseline	: "Bas du texte",
DlgCellRowSpan		: "Lignes Fusionn&eacute;es",
DlgCellCollSpan		: "Colonnes Fusionn&eacute;es",
DlgCellBackColor	: "Fond",
DlgCellBorderColor	: "Bordure",
DlgCellBtnSelect	: "Choisir...",

// Find Dialog
DlgFindTitle		: "Chercher",
DlgFindFindBtn		: "Chercher",
DlgFindNotFoundMsg	: "Le texte indiqu&eacute; est introuvable.",

// Replace Dialog
DlgReplaceTitle			: "Remplacer",
DlgReplaceFindLbl		: "Rechercher:",
DlgReplaceReplaceLbl	: "Remplacer par:",
DlgReplaceCaseChk		: "Respecter la casse",
DlgReplaceReplaceBtn	: "Remplacer",
DlgReplaceReplAllBtn	: "Tout remplacer",
DlgReplaceWordChk		: "Mot entier",

// Paste Operations / Dialog
PasteErrorPaste	: "Les paramètres de s&eacute;curit&eacute; de votre navigateur empêchent l'&eacute;diteur de coller automatiquement vos donn&eacute;es. Veuillez utiliser les &eacute;quivalents claviers (Ctrl+V).",
PasteErrorCut	: "Les paramètres de s&eacute;curit&eacute; de votre navigateur empêchent l'&eacute;diteur de couper automatiquement vos donn&eacute;es. Veuillez utiliser les &eacute;quivalents claviers (Ctrl+X).",
PasteErrorCopy	: "Les paramètres de s&eacute;curit&eacute; de votre navigateur empêchent l'&eacute;diteur de copier automatiquement vos donn&eacute;es. Veuillez utiliser les &eacute;quivalents claviers (Ctrl+C).",

PasteAsText		: "Coller comme texte",
PasteFromWord	: "Coller à partir de Word",

DlgPasteMsg2	: "Veuillez coller dans la zone ci-dessous en utilisant le clavier (<STRONG>Ctrl+V</STRONG>) et cliquez sur <STRONG>OK</STRONG>.",
DlgPasteIgnoreFont		: "Ignorer les Polices de Caractères",
DlgPasteRemoveStyles	: "Supprimer les Styles",
DlgPasteCleanBox		: "Effacer le contenu",


// Color Picker
ColorAutomatic	: "Automatique",
ColorMoreColors	: "Plus de Couleurs...",

// Document Properties
DocProps		: "Propri&eacute;t&eacute;s du Document",

// Anchor Dialog
DlgAnchorTitle		: "Propri&eacute;t&eacute;s de l'Ancre",
DlgAnchorName		: "Nom de l'Ancre",
DlgAnchorErrorName	: "Veuillez saisir le nom de l'ancre",

// Speller Pages Dialog
DlgSpellNotInDic		: "Pas dans le dictionnaire",
DlgSpellChangeTo		: "Changer en",
DlgSpellBtnIgnore		: "Ignorer",
DlgSpellBtnIgnoreAll	: "Ignorer Tout",
DlgSpellBtnReplace		: "Remplacer",
DlgSpellBtnReplaceAll	: "Remplacer Tout",
DlgSpellBtnUndo			: "Annuler",
DlgSpellNoSuggestions	: "- Aucune suggestion -",
DlgSpellProgress		: "V&eacute;rification d'orthographe en cours...",
DlgSpellNoMispell		: "V&eacute;rification d'orthographe termin&eacute;e: Aucune erreur trouv&eacute;e",
DlgSpellNoChanges		: "V&eacute;rification d'orthographe termin&eacute;e: Pas de modifications",
DlgSpellOneChange		: "V&eacute;rification d'orthographe termin&eacute;e: Un mot modifi&eacute;",
DlgSpellManyChanges		: "V&eacute;rification d'orthographe termin&eacute;e: %1 mots modifi&eacute;s",

IeSpellDownload			: "Le Correcteur n'est pas install&eacute;. Souhaitez-vous le t&eacute;l&eacute;charger maintenant?",

// Button Dialog
DlgButtonText	: "Texte (Valeur)",
DlgButtonType	: "Type",

// Checkbox and Radio Button Dialogs
DlgCheckboxName		: "Nom",
DlgCheckboxValue	: "Valeur",
DlgCheckboxSelected	: "S&eacute;lectionn&eacute;",

// Form Dialog
DlgFormName		: "Nom",
DlgFormAction	: "Action",
DlgFormMethod	: "M&eacute;thode",

// Select Field Dialog
DlgSelectName		: "Nom",
DlgSelectValue		: "Valeur",
DlgSelectSize		: "Taille",
DlgSelectLines		: "lignes",
DlgSelectChkMulti	: "S&eacute;lection multiple",
DlgSelectOpAvail	: "Options Disponibles",
DlgSelectOpText		: "Texte",
DlgSelectOpValue	: "Valeur",
DlgSelectBtnAdd		: "Ajouter",
DlgSelectBtnModify	: "Modifier",
DlgSelectBtnUp		: "Monter",
DlgSelectBtnDown	: "Descendre",
DlgSelectBtnSetValue : "Valeur s&eacute;lectionn&eacute;e",
DlgSelectBtnDelete	: "Supprimer",

// Textarea Dialog
DlgTextareaName	: "Nom",
DlgTextareaCols	: "Colonnes",
DlgTextareaRows	: "Lignes",

// Text Field Dialog
DlgTextName			: "Nom",
DlgTextValue		: "Valeur",
DlgTextCharWidth	: "Largeur en Caractères",
DlgTextMaxChars		: "Nombre Maximum de Caractères",
DlgTextType			: "Type",
DlgTextTypeText		: "Texte",
DlgTextTypePass		: "Mot de Passe",

// Hidden Field Dialog
DlgHiddenName	: "Nom",
DlgHiddenValue	: "Valeur",

// Bulleted List Dialog
BulletedListProp	: "Propri&eacute;t&eacute;s de Liste à puces",
NumberedListProp	: "Propri&eacute;t&eacute;s de Num&eacute;rot&eacute;e",
DlgLstType			: "Type",
DlgLstTypeCircle	: "Cercle",
DlgLstTypeDisk		: "Disque",
DlgLstTypeSquare	: "Carr&eacute;",
DlgLstTypeNumbers	: "Nombres (1, 2, 3)",
DlgLstTypeLCase		: "Lettres Minuscules (a, b, c)",
DlgLstTypeUCase		: "Lettres Majuscules (A, B, C)",
DlgLstTypeSRoman	: "Chiffres Romains Minuscules (i, ii, iii)",
DlgLstTypeLRoman	: "Chiffres Romains Majuscules (I, II, III)",

// Document Properties Dialog
DlgDocGeneralTab	: "G&eacute;n&eacute;ral",
DlgDocBackTab		: "Fond",
DlgDocColorsTab		: "Couleurs et Marges",
DlgDocMetaTab		: "M&eacute;tadonn&eacute;es",

DlgDocPageTitle		: "Titre de la Page",
DlgDocLangDir		: "Sens d'Ecriture",
DlgDocLangDirLTR	: "Gauche vers Droite (LTR)",
DlgDocLangDirRTL	: "Droite vers Gauche (RTL)",
DlgDocLangCode		: "Code Langue",
DlgDocCharSet		: "Encodage de Caractère",
DlgDocCharSetOther	: "Autre Encodage de Caractère",

DlgDocDocType		: "Type de Document",
DlgDocDocTypeOther	: "Autre Type de Document",
DlgDocIncXHTML		: "Inclure les d&eacute;clarations XHTML",
DlgDocBgColor		: "Couleur de Fond",
DlgDocBgImage		: "Image de Fond",
DlgDocBgNoScroll	: "Image fixe sans d&eacute;filement",
DlgDocCText			: "Texte",
DlgDocCLink			: "Lien",
DlgDocCVisited		: "Lien Visit&eacute;",
DlgDocCActive		: "Lien Activ&eacute;",
DlgDocMargins		: "Marges",
DlgDocMaTop			: "Haut",
DlgDocMaLeft		: "Gauche",
DlgDocMaRight		: "Droite",
DlgDocMaBottom		: "Bas",
DlgDocMeIndex		: "Mots Cl&eacute;s (s&eacute;par&eacute;s par des virgules)",
DlgDocMeDescr		: "Description",
DlgDocMeAuthor		: "Auteur",
DlgDocMeCopy		: "Copyright",
DlgDocPreview		: "Pr&eacute;visualisation",

// Templates Dialog
Templates			: "Modèles",
DlgTemplatesTitle	: "Modèles de Contenu",
DlgTemplatesSelMsg	: "Veuillez s&eacute;lectionner le modèle à ouvrir dans l'&eacute;diteur<br>(le contenu actuel sera remplac&eacute;):",
DlgTemplatesLoading	: "Chargement de la liste des modèles. Veuillez patienter...",
DlgTemplatesNoTpl	: "(Aucun modèle disponible)",

// About Dialog
DlgAboutAboutTab	: "A propos de",
DlgAboutBrowserInfoTab	: "Navigateur",
DlgAboutVersion		: "version",
DlgAboutLicense		: "License selon les termes de GNU Lesser General Public License",
DlgAboutInfo		: "Pour plus d'informations, aller à"
}
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
 * File Name: hu.js
 * 	Hungarian language file.
 * 
 * File Authors:
 * 		Varga Zsolt (meridian@netteszt.hu)
 */

var FCKLang =
{
// Language direction : "ltr" (left to right) or "rtl" (right to left).
Dir					: "ltr",

ToolbarCollapse		: "Egyszerû eszköztár",
ToolbarExpand		: "Bõvített eszköztár",

// Toolbar Items and Context Menu
Save				: "Ment&eacute;s",
NewPage				: "Új oldal",
Preview				: "Elõn&eacute;zet",
Cut					: "Kivágás",
Copy				: "Másolás",
Paste				: "Beilleszt&eacute;s",
PasteText			: "Beilleszt&eacute;s formázatlan szövegk&eacute;nt",
PasteWord			: "Beilleszt&eacute;s Wordbõl",
Print				: "Nyomtatás",
SelectAll			: "Minden kijelöl&eacute;se",
RemoveFormat		: "Formázás törl&eacute;se",
InsertLinkLbl		: "Hivatkozás",
InsertLink			: "Hivatkozás beilleszt&eacute;se/módosítása",
RemoveLink			: "Hivatkozás törl&eacute;se",
Anchor				: "Horgony beilleszt&eacute;se/szerkeszt&eacute;se",
InsertImageLbl		: "K&eacute;p",
InsertImage			: "K&eacute;p beilleszt&eacute;se/módosítása",
InsertFlashLbl		: "Flash",	//MISSING
InsertFlash			: "Insert/Edit Flash",	//MISSING
InsertTableLbl		: "Táblázat",
InsertTable			: "Táblázat beilleszt&eacute;se/módosítása",
InsertLineLbl		: "Vonal",
InsertLine			: "Elválasztóvonal beilleszt&eacute;se",
InsertSpecialCharLbl: "Speciális karakter",
InsertSpecialChar	: "Speciális karakter beilleszt&eacute;se",
InsertSmileyLbl		: "Hangulatjelek",
InsertSmiley		: "Hangulatjelek beilleszt&eacute;se",
About				: "FCKeditor n&eacute;vjegy",
Bold				: "F&eacute;lköv&eacute;r",
Italic				: "Dõlt",
Underline			: "Aláhúzott",
StrikeThrough		: "Áthúzott",
Subscript			: "Alsó index",
Superscript			: "Felsõ index",
LeftJustify			: "Balra",
CenterJustify		: "Köz&eacute;pre",
RightJustify		: "Jobbra",
BlockJustify		: "Sorkizárt",
DecreaseIndent		: "Behúzás csökkent&eacute;se",
IncreaseIndent		: "Behúzás növel&eacute;se",
Undo				: "Visszavonás",
Redo				: "Ism&eacute;tl&eacute;s",
NumberedListLbl		: "Számozás",
NumberedList		: "Számozás beilleszt&eacute;se/törl&eacute;se",
BulletedListLbl		: "Felsorolás",
BulletedList		: "Felsorolás beilleszt&eacute;se/törl&eacute;se",
ShowTableBorders	: "Táblázat szeg&eacute;ly mutatása",
ShowDetails			: "R&eacute;szletek mutatása",
Style				: "Stílus",
FontFormat			: "Formátum",
Font				: "Betûtipus",
FontSize			: "M&eacute;ret",
TextColor			: "Betûszín",
BGColor				: "Hátt&eacute;rszín",
Source				: "Forráskód",
Find				: "Keres&eacute;s",
Replace				: "Csere",
SpellCheck			: "Helyesírásellenőrz&eacute;s",
UniversalKeyboard	: "Általános billentyűzet",

Form			: "Űrlap",
Checkbox		: "Jelölőn&eacute;gyzet",
RadioButton		: "Választógomb",
TextField		: "Szövegmező",
Textarea		: "Szövegterület",
HiddenField		: "Rejtettmező",
Button			: "Gomb",
SelectionField	: "Választómező",
ImageButton		: "K&eacute;pgomb",

// Context Menu
EditLink			: "Hivatkozás módosítása",
InsertRow			: "Sor beszúrása",
DeleteRows			: "Sor(ok) törl&eacute;se",
InsertColumn		: "Oszlop beszúrása",
DeleteColumns		: "Oszlop(ok) törl&eacute;se",
InsertCell			: "Cella beszúrása",
DeleteCells			: "Cellák törl&eacute;se",
MergeCells			: "Cellák egyesít&eacute;se",
SplitCell			: "Cellák sz&eacute;tválasztása",
CellProperties		: "Cellák tulajdonsága",
TableProperties		: "Táblázat tulajdonsága",
ImageProperties		: "K&eacute;p tulajdonsága",
FlashProperties		: "Flash Properties",	//MISSING

AnchorProp			: "Horgony(ok) tulajdonsága(i)",
ButtonProp			: "Gomb(ok) tulajdonsága(i) ",
CheckboxProp		: "Jelölőn&eacute;gyzet(ek) tulajdonsága(i)",
HiddenFieldProp		: "Rejtettmező(k) tulajdonsága(i)",
RadioButtonProp		: "Választógomb(ok) tulajdonsága(i)",
ImageButtonProp		: "K&eacute;pgomb(ok) tulajdonsága(i)",
TextFieldProp		: "Szövegmező(k) tulajdonsága(i)",
SelectionFieldProp	: "Választómező(k) tulajdonsága(i)",
TextareaProp		: "Szövegterület(ek) tulajdonsága(i)",
FormProp			: "Űrlap(ok) tulajdonsága(i)",

FontFormats			: "Normál;Formázott;Címsor;Fejl&eacute;c 1;Fejl&eacute;c 2;Fejl&eacute;c 3;Fejl&eacute;c 4;Fejl&eacute;c 5;Fejl&eacute;c 6;Bekezd&eacute;s (DIV)",

// Alerts and Messages
ProcessingXHTML		: "XHTML feldolgozása. K&eacute;rem várjon...",
Done				: "K&eacute;sz",
PasteWordConfirm	: "A szöveg amit be szeretn&eacute;l illeszteni úgy n&eacute;z ki Word-bõl van másolva. Do you want to clean it before pasting?",
NotCompatiblePaste	: "Ez a parancs csak Internet Explorer 5.5 verziótól használható (Firefox rulez). Do you want to paste without cleaning?",
UnknownToolbarItem	: "Ismeretlen eszköztár elem \"%1\"",
UnknownCommand		: "Ismeretlen parancs \"%1\"",
NotImplemented		: "A parancs nincs beágyazva",
UnknownToolbarSet	: "Eszközk&eacute;szlet beállítás \"%1\" nem l&eacute;tezik",

// Dialogs
DlgBtnOK			: "OK",
DlgBtnCancel		: "M&eacute;gsem",
DlgBtnClose			: "Bezárás",
DlgBtnBrowseServer	: "Szerver tallózása",
DlgAdvancedTag		: "Haladó",
DlgOpOther			: "Egy&eacute;b",
DlgInfoTab			: "Info",	//MISSING
DlgAlertUrl			: "Please insert the URL",	//MISSING

// General Dialogs Labels
DlgGenNotSet		: "&lt;nincs beállítva&gt;",
DlgGenId			: "Azonosító",
DlgGenLangDir		: "Nyelv útmutató",
DlgGenLangDirLtr	: "Balról jobbra",
DlgGenLangDirRtl	: "Jobbról balra",
DlgGenLangCode		: "Nyelv kód",
DlgGenAccessKey		: "El&eacute;r&eacute;si kulcs",
DlgGenName			: "N&eacute;v",
DlgGenTabIndex		: "Tabulátor index",
DlgGenLongDescr		: "Hosszú URL",
DlgGenClass			: "Stílusk&eacute;szlet",
DlgGenTitle			: "Advisory Title",
DlgGenContType		: "Advisory Content Type",
DlgGenLinkCharset	: "Hivatkozott kódlap k&eacute;szlet",
DlgGenStyle			: "Stílus",

// Image Dialog
DlgImgTitle			: "K&eacute;p tulajdonsága",
DlgImgInfoTab		: "K&eacute;p információ",
DlgImgBtnUpload		: "Küld&eacute;s a szervernek",
DlgImgURL			: "URL",
DlgImgUpload		: "Feltölt&eacute;s",
DlgImgAlt			: "Bubor&eacute;k szöveg",
DlgImgWidth			: "Sz&eacute;less&eacute;g",
DlgImgHeight		: "Magasság",
DlgImgLockRatio		: "Arány megtartása",
DlgBtnResetSize		: "Eredeti m&eacute;ret",
DlgImgBorder		: "Keret",
DlgImgHSpace		: "Vízsz. táv",
DlgImgVSpace		: "Függ. táv",
DlgImgAlign			: "Igazítás",
DlgImgAlignLeft		: "Bal",
DlgImgAlignAbsBottom: "Legaljára",
DlgImgAlignAbsMiddle: "Közep&eacute;re",
DlgImgAlignBaseline	: "Baseline",
DlgImgAlignBottom	: "Aljára",
DlgImgAlignMiddle	: "Köz&eacute;pre",
DlgImgAlignRight	: "Jobbra",
DlgImgAlignTextTop	: "Szöveg tetj&eacute;re",
DlgImgAlignTop		: "Tetej&eacute;re",
DlgImgPreview		: "Elõn&eacute;zet",
DlgImgAlertUrl		: "Töltse ki a k&eacute;p URL-&eacute;t",
DlgImgLinkTab		: "Link",	//MISSING

// Flash Dialog
DlgFlashTitle		: "Flash Properties",	//MISSING
DlgFlashChkPlay		: "Auto Play",	//MISSING
DlgFlashChkLoop		: "Loop",	//MISSING
DlgFlashChkMenu		: "Enable Flash Menu",	//MISSING
DlgFlashScale		: "Scale",	//MISSING
DlgFlashScaleAll	: "Show all",	//MISSING
DlgFlashScaleNoBorder	: "No Border",	//MISSING
DlgFlashScaleFit	: "Exact Fit",	//MISSING

// Link Dialog
DlgLnkWindowTitle	: "Hivatkozás",
DlgLnkInfoTab		: "Hivatkozás információ",
DlgLnkTargetTab		: "C&eacute;l",

DlgLnkType			: "Hivatkozás tipusa",
DlgLnkTypeURL		: "URL",
DlgLnkTypeAnchor	: "Horgony az oldalon",
DlgLnkTypeEMail		: "E-Mail",
DlgLnkProto			: "Protokoll",
DlgLnkProtoOther	: "&lt;más&gt;",
DlgLnkURL			: "URL",
DlgLnkAnchorSel		: "Horgony választása",
DlgLnkAnchorByName	: "Horgony n&eacute;v szerint",
DlgLnkAnchorById	: "Azonosító szerint elõsorban ",
DlgLnkNoAnchors		: "&lt;Nincs horgony a dokumentumban&gt;",
DlgLnkEMail			: "E-Mail cím",
DlgLnkEMailSubject	: "Üzenet tárgya",
DlgLnkEMailBody		: "Üzenet",
DlgLnkUpload		: "Feltölt&eacute;s",
DlgLnkBtnUpload		: "Küld&eacute;s a szerverhez",

DlgLnkTarget		: "C&eacute;l",
DlgLnkTargetFrame	: "&lt;keret&gt;",
DlgLnkTargetPopup	: "&lt;felugró ablak&gt;",
DlgLnkTargetBlank	: "Új ablak (_blank)",
DlgLnkTargetParent	: "Szülõ ablak (_parent)",
DlgLnkTargetSelf	: "Azonos ablak (_self)",
DlgLnkTargetTop		: "Legfelsõ ablak (_top)",
DlgLnkTargetFrameName	: "C&eacute;l frame neve",
DlgLnkPopWinName	: "Felugró ablak neve",
DlgLnkPopWinFeat	: "Felugró ablak jellemzõi",
DlgLnkPopResize		: "M&eacute;retezhetõ",
DlgLnkPopLocation	: "Location Bar",
DlgLnkPopMenu		: "Menü sor",
DlgLnkPopScroll		: "Gördítõsáv",
DlgLnkPopStatus		: "Állapotsor",
DlgLnkPopToolbar	: "Eszköztár",
DlgLnkPopFullScrn	: "Teljes k&eacute;pernyõ (IE)",
DlgLnkPopDependent	: "Netscape sajátosság",
DlgLnkPopWidth		: "Sz&eacute;less&eacute;g",
DlgLnkPopHeight		: "Magasság",
DlgLnkPopLeft		: "Bal pozíció",
DlgLnkPopTop		: "Felsõ pozíció",

DlnLnkMsgNoUrl		: "Adja meg a hivatkozás URL-&eacute;t",
DlnLnkMsgNoEMail	: "Adja meg az e-mail címet",
DlnLnkMsgNoAnchor	: "Válasszon egy horgonyt",

// Color Dialog
DlgColorTitle		: "Szinválasztás",
DlgColorBtnClear	: "Törl&eacute;s",
DlgColorHighlight	: "Világos r&eacute;sz",
DlgColorSelected	: "Választott",

// Smiley Dialog
DlgSmileyTitle		: "Hangulatjel beszúrása",

// Special Character Dialog
DlgSpecialCharTitle	: "Speciális karakter választása",

// Table Dialog
DlgTableTitle		: "Táblázat tulajdonságai",
DlgTableRows		: "Sorok",
DlgTableColumns		: "Oszlopok",
DlgTableBorder		: "Szeg&eacute;lym&eacute;ret",
DlgTableAlign		: "Igazítás",
DlgTableAlignNotSet	: "<Nincs beállítva>",
DlgTableAlignLeft	: "Bal",
DlgTableAlignCenter	: "Köz&eacute;p",
DlgTableAlignRight	: "Jobb",
DlgTableWidth		: "Sz&eacute;less&eacute;g",
DlgTableWidthPx		: "k&eacute;ppontok",
DlgTableWidthPc		: "százal&eacute;k",
DlgTableHeight		: "Magasság",
DlgTableCellSpace	: "Cell spacing",
DlgTableCellPad		: "Cell padding",
DlgTableCaption		: "Felirat",

// Table Cell Dialog
DlgCellTitle		: "Cella tulajdonságai",
DlgCellWidth		: "Sz&eacute;less&eacute;g",
DlgCellWidthPx		: "k&eacute;ppontok",
DlgCellWidthPc		: "százal&eacute;k",
DlgCellHeight		: "Height",
DlgCellWordWrap		: "Sortör&eacute;s",
DlgCellWordWrapNotSet	: "&lt;Nincs beállítva&gt;",
DlgCellWordWrapYes	: "Igen",
DlgCellWordWrapNo	: "Nem",
DlgCellHorAlign		: "Vízszintes igazítás",
DlgCellHorAlignNotSet	: "&lt;Nincs beállítva&gt;",
DlgCellHorAlignLeft	: "Bal",
DlgCellHorAlignCenter	: "Köz&eacute;p",
DlgCellHorAlignRight: "Jobb",
DlgCellVerAlign		: "Függõleges igazítás",
DlgCellVerAlignNotSet	: "&lt;Nincs beállítva&gt;",
DlgCellVerAlignTop	: "Tetej&eacute;re",
DlgCellVerAlignMiddle	: "Köz&eacute;pre",
DlgCellVerAlignBottom	: "Aljára",
DlgCellVerAlignBaseline	: "Egyvonalba",
DlgCellRowSpan		: "Sorok egyesít&eacute;se",
DlgCellCollSpan		: "Oszlopok egyesít&eacute;se",
DlgCellBackColor	: "Hátt&eacute;rszín",
DlgCellBorderColor	: "Szeg&eacute;lyszín",
DlgCellBtnSelect	: "Kiválasztás...",

// Find Dialog
DlgFindTitle		: "Keres&eacute;s",
DlgFindFindBtn		: "Keres&eacute;s",
DlgFindNotFoundMsg	: "A keresett szöveg nem található.",

// Replace Dialog
DlgReplaceTitle			: "Csere",
DlgReplaceFindLbl		: "Keresendõ:",
DlgReplaceReplaceLbl	: "Cser&eacute;lendõ:",
DlgReplaceCaseChk		: "Találatok",
DlgReplaceReplaceBtn	: "Csere",
DlgReplaceReplAllBtn	: "Összes cser&eacute;je",
DlgReplaceWordChk		: "Eg&eacute;sz dokumentumban",

// Paste Operations / Dialog
PasteErrorPaste	: "A böng&eacute;szõ biztonsági beállításai nem enged&eacute;lyezik a szerkesztõnek, hogy v&eacute;grehatjsa a beilleszt&eacute;s mûveletet.Használja az alábbi billentyûzetkombinációt (Ctrl+V).",
PasteErrorCut	: "A böng&eacute;szõ biztonsági beállításai nem enged&eacute;lyezik a szerkesztõnek, hogy v&eacute;grehatjsa a kivágás mûveletet.Használja az alábbi billentyûzetkombinációt (Ctrl+X).",
PasteErrorCopy	: "A böng&eacute;szõ biztonsági beállításai nem enged&eacute;lyezik a szerkesztõnek, hogy v&eacute;grehatjsa a másolás mûveletet.Használja az alábbi billentyûzetkombinációt (Ctrl+X).",

PasteAsText		: "Beilleszt&eacute;s formázatlan szövegk&eacute;nt",
PasteFromWord	: "Beilleszt&eacute;s Wordbõl",

DlgPasteMsg2	: "Please paste inside the following box using the keyboard (<STRONG>Ctrl+V</STRONG>) and hit <STRONG>OK</STRONG>.",	//MISSING
DlgPasteIgnoreFont		: "Ignore Font Face definitions",	//MISSING
DlgPasteRemoveStyles	: "Remove Styles definitions",	//MISSING
DlgPasteCleanBox		: "Clean Up Box",	//MISSING


// Color Picker
ColorAutomatic	: "Automatikus",
ColorMoreColors	: "Több szín...",

// Document Properties
DocProps		: "Dokumentum tulajdonsága",

// Anchor Dialog
DlgAnchorTitle		: "Horgony tulajdonsága",
DlgAnchorName		: "Horgony neve",
DlgAnchorErrorName	: "K&eacute;rem adja meg a horgony nev&eacute;t",

// Speller Pages Dialog
DlgSpellNotInDic		: "Nincs a könyvtárban",
DlgSpellChangeTo		: "Átváltás",
DlgSpellBtnIgnore		: "Kihagyja",
DlgSpellBtnIgnoreAll	: "Összeset kihagyja",
DlgSpellBtnReplace		: "Csere",
DlgSpellBtnReplaceAll	: "Összes cser&eacute;je",
DlgSpellBtnUndo			: "Visszavonás",
DlgSpellNoSuggestions	: "Nincs feltev&eacute;s",
DlgSpellProgress		: "Helyesírásellenőrz&eacute;s folyamatban...",
DlgSpellNoMispell		: "Helyesírásellenőrz&eacute;s k&eacute;sz: Nem találtam hibát",
DlgSpellNoChanges		: "Helyesírásellenőrz&eacute;s k&eacute;sz: Nincs változtatott szó",
DlgSpellOneChange		: "Helyesírásellenőrz&eacute;s k&eacute;sz: Egy szó cser&eacute;lve",
DlgSpellManyChanges		: "Helyesírásellenőrz&eacute;s k&eacute;sz: %1 szó cser&eacute;lve",

IeSpellDownload			: "A helyesírásellenőrző nincs telepítve. Szeretn&eacute; letölteni most?",

// Button Dialog
DlgButtonText	: "Szöveg (Ért&eacute;k)",
DlgButtonType	: "Típus",

// Checkbox and Radio Button Dialogs
DlgCheckboxName		: "N&eacute;v",
DlgCheckboxValue	: "Ért&eacute;k",
DlgCheckboxSelected	: "Választott",

// Form Dialog
DlgFormName		: "N&eacute;v",
DlgFormAction	: "Esem&eacute;ny",
DlgFormMethod	: "Metódus",

// Select Field Dialog
DlgSelectName		: "N&eacute;v",
DlgSelectValue		: "Ért&eacute;k",
DlgSelectSize		: "M&eacute;ret",
DlgSelectLines		: "sorok",
DlgSelectChkMulti	: "Engedi a többszörös kiválasztást",
DlgSelectOpAvail	: "El&eacute;rhető opciók",
DlgSelectOpText		: "Szöveg",
DlgSelectOpValue	: "Ért&eacute;k",
DlgSelectBtnAdd		: "Bővít",
DlgSelectBtnModify	: "Módosít",
DlgSelectBtnUp		: "Fel",
DlgSelectBtnDown	: "Le",
DlgSelectBtnSetValue : "Beállítja a kiválasztott &eacute;rt&eacute;ket",
DlgSelectBtnDelete	: "Töröl",

// Textarea Dialog
DlgTextareaName	: "N&eacute;v",
DlgTextareaCols	: "Oszlopok",
DlgTextareaRows	: "Sorok",

// Text Field Dialog
DlgTextName			: "N&eacute;v",
DlgTextValue		: "Ért&eacute;k",
DlgTextCharWidth	: "Karakter sz&eacute;less&eacute;g",
DlgTextMaxChars		: "Maximum karakterek",
DlgTextType			: "Típus",
DlgTextTypeText		: "Szöveg",
DlgTextTypePass		: "Jelszó",

// Hidden Field Dialog
DlgHiddenName	: "N&eacute;v",
DlgHiddenValue	: "Ért&eacute;k",

// Bulleted List Dialog
BulletedListProp	: "Felsorolás tulajdonságai",
NumberedListProp	: "Számozás tulajdonságai",
DlgLstType			: "Típus",
DlgLstTypeCircle	: "Ciklus",
DlgLstTypeDisk		: "Lemez",
DlgLstTypeSquare	: "N&eacute;gyzet",
DlgLstTypeNumbers	: "Számok (1, 2, 3)",
DlgLstTypeLCase		: "Kisbetűs (a, b, c)",
DlgLstTypeUCase		: "Nagybetűs (a, b, c)",
DlgLstTypeSRoman	: "Kis római számok (i, ii, iii)",
DlgLstTypeLRoman	: "Nagy római számok (I, II, III)",

// Document Properties Dialog
DlgDocGeneralTab	: "Általános",
DlgDocBackTab		: "Hátt&eacute;r",
DlgDocColorsTab		: "Színek &eacute;s margók",
DlgDocMetaTab		: "Meta adatok",

DlgDocPageTitle		: "Oldalcím",
DlgDocLangDir		: "Nyelv utasítás",
DlgDocLangDirLTR	: "Balról jobbra (LTR)",
DlgDocLangDirRTL	: "Jobbról balra (RTL)",
DlgDocLangCode		: "Nyelv kód",
DlgDocCharSet		: "Karakterkódolás",
DlgDocCharSetOther	: "Más karakterkódolás",

DlgDocDocType		: "Dokumentum címsor típus",
DlgDocDocTypeOther	: "Más dokumentum címsor típus",
DlgDocIncXHTML		: "XHTML elemeket tartalmaz",
DlgDocBgColor		: "Hátt&eacute;rszín",
DlgDocBgImage		: "Hátt&eacute;rk&eacute;p cím",
DlgDocBgNoScroll	: "Nem gördíthető hátt&eacute;r",
DlgDocCText			: "Szöveg",
DlgDocCLink			: "Cím",
DlgDocCVisited		: "Látogatott cím",
DlgDocCActive		: "Aktív cím",
DlgDocMargins		: "Oldal margók",
DlgDocMaTop			: "Felső",
DlgDocMaLeft		: "Bal",
DlgDocMaRight		: "Jobb",
DlgDocMaBottom		: "Felül",
DlgDocMeIndex		: "Dokumentum keresőszavak (vesszővel elválasztva)",
DlgDocMeDescr		: "Dokumentum leírás",
DlgDocMeAuthor		: "Szerző",
DlgDocMeCopy		: "Szerzői jog",
DlgDocPreview		: "Előn&eacute;zet",

// Templates Dialog
Templates			: "Templates",	//MISSING
DlgTemplatesTitle	: "Content Templates",	//MISSING
DlgTemplatesSelMsg	: "Please select the template to open in the editor<br>(the actual contents will be lost):",	//MISSING
DlgTemplatesLoading	: "Loading templates list. Please wait...",	//MISSING
DlgTemplatesNoTpl	: "(No templates defined)",	//MISSING

// About Dialog
DlgAboutAboutTab	: "About",
DlgAboutBrowserInfoTab	: "Böng&eacute;sző információ",
DlgAboutVersion		: "verzió",
DlgAboutLicense		: "GNU Lesser General Public License szabadalom alá tartozik",
DlgAboutInfo		: "További információk&eacute;rt menjen"
}
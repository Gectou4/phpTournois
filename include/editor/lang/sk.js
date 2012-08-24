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
 * File Name: sk.js
 * 	Slovak language file.
 * 
 * File Authors:
 * 		Samuel Szabo (samuel@nanete.sk)
 */

var FCKLang =
{
// Language direction : "ltr" (left to right) or "rtl" (right to left).
Dir					: "ltr",

ToolbarCollapse		: "Skryť panel nástrojov",
ToolbarExpand		: "Zobraziť panel nástrojov",

// Toolbar Items and Context Menu
Save				: "Uložit",
NewPage				: "Nová stránka",
Preview				: "Náhľad",
Cut					: "Vystrihnúť",
Copy				: "Kopírovať",
Paste				: "Vložiť",
PasteText			: "Vložiť ako čistý text",
PasteWord			: "Vložiť z Wordu",
Print				: "Tlač",
SelectAll			: "Vybrať všetko",
RemoveFormat		: "Odstrániť formátovanie",
InsertLinkLbl		: "Odkaz",
InsertLink			: "Vložiť/zmeniť odkaz",
RemoveLink			: "Odstrániť odkaz",
Anchor				: "Vložiť/zmeniť kotvu",
InsertImageLbl		: "Obrázok",
InsertImage			: "Vložiť/zmeniť obrazok",
InsertFlashLbl		: "Flash",
InsertFlash			: "Vložiť/zmeniť Flash",
InsertTableLbl		: "Tabuľka",
InsertTable			: "Vložiť/zmeniť tabulku",
InsertLineLbl		: "Čiara",
InsertLine			: "Vložiť vodorovnú čiara",
InsertSpecialCharLbl: "Speciálne znaky",
InsertSpecialChar	: "Vložiť špeciálne znaky",
InsertSmileyLbl		: "Smajlíky",
InsertSmiley		: "Vložiť smajlíka",
About				: "O aplikáci FCKeditor",
Bold				: "Tučn&eacute;",
Italic				: "Kurzíva",
Underline			: "Podčiarknut&eacute;",
StrikeThrough		: "Prečiarknut&eacute;",
Subscript			: "Dolný index",
Superscript			: "Horný index",
LeftJustify			: "Zarovnať vľavo",
CenterJustify		: "Zarovnať na stred",
RightJustify		: "Zarovnať vpravo",
BlockJustify		: "Zarovnať do bloku",
DecreaseIndent		: "Zmenšiť odsadenie",
IncreaseIndent		: "Zväčšiť odsadenie",
Undo				: "Späť",
Redo				: "Znovu",
NumberedListLbl		: "Číslovanie",
NumberedList		: "Vložiť/odstrániť číslovaný zoznam",
BulletedListLbl		: "Odrážky",
BulletedList		: "Vložiť/odstraniť odrážky",
ShowTableBorders	: "Zobraziť okraje tabuliek",
ShowDetails			: "Zobraziť podrobnosti",
Style				: "Štýl",
FontFormat			: "Formát",
Font				: "Písmo",
FontSize			: "Veľkost",
TextColor			: "Farba textu",
BGColor				: "Farba pozadia",
Source				: "Zdroj",
Find				: "Hľadať",
Replace				: "Nahradiť",
SpellCheck			: "Kontrola pravopisu",
UniversalKeyboard	: "Univerzálna klávesnica",

Form			: "Formulár",
Checkbox		: "Zaškrtávacie políčko",
RadioButton		: "Prepínač",
TextField		: "Textov&eacute; pole",
Textarea		: "Textová oblasť",
HiddenField		: "Skryt&eacute; pole",
Button			: "Tlačítko",
SelectionField	: "Rozbaľovací zoznam",
ImageButton		: "Obrázkov&eacute; tlačítko",

// Context Menu
EditLink			: "Zmeniť odkaz",
InsertRow			: "Vložiť riadok",
DeleteRows			: "Zmazať riadok",
InsertColumn		: "Vložiť stĺpec",
DeleteColumns		: "Zmazať stĺpec",
InsertCell			: "Vložiť bunku",
DeleteCells			: "Zmazať bunky",
MergeCells			: "Zlúčiť bunky",
SplitCell			: "Rozdeliť bunku",
CellProperties		: "Vlastnosti bunky",
TableProperties		: "Vlastnosti tabulky",
ImageProperties		: "Vlastnosti obrázka",
FlashProperties		: "Vlastnosti Flashu",

AnchorProp			: "Vlastnosti kotvy",
ButtonProp			: "Vlastnosti tlačítka",
CheckboxProp		: "Vlastnosti zaškrtávacieho políčka",
HiddenFieldProp		: "Vlastnosti skryt&eacute;ho poľa",
RadioButtonProp		: "Vlastnosti prepínača",
ImageButtonProp		: "Vlastnosti obrázkov&eacute;ho tlačítka",
TextFieldProp		: "Vlastnosti textov&eacute;ho pola",
SelectionFieldProp	: "Vlastnosti rozbaľovacieho zoznamu",
TextareaProp		: "Vlastnosti textov&eacute; oblasti",
FormProp			: "Vlastnosti formulára",

FontFormats			: "Normálny;Formátovaný;Adresa;Nadpis 1;Nadpis 2;Nadpis 3;Nadpis 4;Nadpis 5;Nadpis 6",

// Alerts and Messages
ProcessingXHTML		: "Prebieha spracovanie XHTML. Prosím čakejte...",
Done				: "Dokončen&eacute;.",
PasteWordConfirm	: "Vyzerá to tak, že vkladaný text je kopírovaný z Wordu. Chcete ho pred vložením vyčistiť?",
NotCompatiblePaste	: "Tento príkaz je dostupný len v prehliadači Internet Explorer verzie 5.5 alebo vyššej. Chcete vložiť text bez vyčistenia?",
UnknownToolbarItem	: "Neznáma položka panela nástrojov \"%1\"",
UnknownCommand		: "Neznámy príkaz \"%1\"",
NotImplemented		: "Príkaz nie je implementovaný",
UnknownToolbarSet	: "Panel nástrojov \"%1\" neexistuje",

// Dialogs
DlgBtnOK			: "OK",
DlgBtnCancel		: "Zrušiť",
DlgBtnClose			: "Zavrieť",
DlgBtnBrowseServer	: "Prechádzať server",
DlgAdvancedTag		: "Rozšíren&eacute;",
DlgOpOther			: "&lt;Ďalšie&gt;",
DlgInfoTab			: "Info",
DlgAlertUrl			: "Prosím vložte URL",

// General Dialogs Labels
DlgGenNotSet		: "&lt;nenastaven&eacute;&gt;",
DlgGenId			: "Id",
DlgGenLangDir		: "Orientácia jazyka",
DlgGenLangDirLtr	: "Zľava doprava (LTR)",
DlgGenLangDirRtl	: "Zprava doľava (RTL)",
DlgGenLangCode		: "Kód jazyka",
DlgGenAccessKey		: "Prístupový kľúč",
DlgGenName			: "Meno",
DlgGenTabIndex		: "Poradie prvku",
DlgGenLongDescr		: "Dlhý popis URL",
DlgGenClass			: "Trieda štýlu",
DlgGenTitle			: "Pomocný titulok",
DlgGenContType		: "Pomocný typ obsahu",
DlgGenLinkCharset	: "Priradená znaková sada",
DlgGenStyle			: "Štýl",

// Image Dialog
DlgImgTitle			: "Vlastnosti obrázku",
DlgImgInfoTab		: "Informácie o obrázku",
DlgImgBtnUpload		: "Odoslať na server",
DlgImgURL			: "URL",
DlgImgUpload		: "Odoslať",
DlgImgAlt			: "Alternatívny text",
DlgImgWidth			: "Šírka",
DlgImgHeight		: "Výška",
DlgImgLockRatio		: "Zámok",
DlgBtnResetSize		: "Pôvodná veľkosť",
DlgImgBorder		: "Okraje",
DlgImgHSpace		: "H-medzera",
DlgImgVSpace		: "V-medzera",
DlgImgAlign			: "Zarovnanie",
DlgImgAlignLeft		: "Vľevo",
DlgImgAlignAbsBottom: "Úplne dole",
DlgImgAlignAbsMiddle: "Do stredu",
DlgImgAlignBaseline	: "Na základňu",
DlgImgAlignBottom	: "Dole",
DlgImgAlignMiddle	: "Na stred",
DlgImgAlignRight	: "Vpravo",
DlgImgAlignTextTop	: "Na horný okraj textu",
DlgImgAlignTop		: "Nahor",
DlgImgPreview		: "Náhľad",
DlgImgAlertUrl		: "Zadajte prosím URL obrázku",
DlgImgLinkTab		: "Odkaz",

// Flash Dialog
DlgFlashTitle		: "Vlastnosti Flashu",
DlgFlashChkPlay		: "Automatick&eacute; prehrávanie",
DlgFlashChkLoop		: "Opakovanie",
DlgFlashChkMenu		: "Povoliť Flash Menu",
DlgFlashScale		: "Mierka",
DlgFlashScaleAll	: "Zobraziť mierku",
DlgFlashScaleNoBorder	: "Bez okrajov",
DlgFlashScaleFit	: "Roztiahnuť na cel&eacute;",

// Link Dialog
DlgLnkWindowTitle	: "Odkaz",
DlgLnkInfoTab		: "Informácie o odkaze",
DlgLnkTargetTab		: "Cieľ",

DlgLnkType			: "Typ odkazu",
DlgLnkTypeURL		: "URL",
DlgLnkTypeAnchor	: "Kotva v tejto stránke",
DlgLnkTypeEMail		: "E-Mail",
DlgLnkProto			: "Protokol",
DlgLnkProtoOther	: "&lt;iný&gt;",
DlgLnkURL			: "URL",
DlgLnkAnchorSel		: "Vybrať kotvu",
DlgLnkAnchorByName	: "Podľa mena kotvy",
DlgLnkAnchorById	: "Podľa Id objektu",
DlgLnkNoAnchors		: "&lt;V stránke žiadna kotva nie je definovaná&gt;",
DlgLnkEMail			: "E-Mailová adresa",
DlgLnkEMailSubject	: "Predmet správy",
DlgLnkEMailBody		: "Telo správy",
DlgLnkUpload		: "Odoslať",
DlgLnkBtnUpload		: "Odoslať na server",

DlgLnkTarget		: "Cieľ",
DlgLnkTargetFrame	: "&lt;rámec&gt;",
DlgLnkTargetPopup	: "&lt;vyskakovacie okno&gt;",
DlgLnkTargetBlank	: "Nov&eacute; okno (_blank)",
DlgLnkTargetParent	: "Rodičovsk&eacute; okno (_parent)",
DlgLnkTargetSelf	: "Rovnak&eacute; okno (_self)",
DlgLnkTargetTop		: "Hlavn&eacute; okno (_top)",
DlgLnkTargetFrameName	: "Meno rámu cieľa",
DlgLnkPopWinName	: "Názov vyskakovacieho okna",
DlgLnkPopWinFeat	: "Vlastnosti vyskakovacieho okna",
DlgLnkPopResize		: "Měnitelná velikost",
DlgLnkPopLocation	: "Panel umístění",
DlgLnkPopMenu		: "Panel ponuky",
DlgLnkPopScroll		: "Posuvníky",
DlgLnkPopStatus		: "Stavový riadok",
DlgLnkPopToolbar	: "Panel nástrojov",
DlgLnkPopFullScrn	: "Celá obrazovka (IE)",
DlgLnkPopDependent	: "Závislosť (Netscape)",
DlgLnkPopWidth		: "Šírka",
DlgLnkPopHeight		: "Výška",
DlgLnkPopLeft		: "Ľavý okraj",
DlgLnkPopTop		: "Horný okraj",

DlnLnkMsgNoUrl		: "Zadajte prosím URL odkazu",
DlnLnkMsgNoEMail	: "Zadajte prosím e-mailovú adresu",
DlnLnkMsgNoAnchor	: "Vyberte prosím kotvu",

// Color Dialog
DlgColorTitle		: "Výber farby",
DlgColorBtnClear	: "Vymazať",
DlgColorHighlight	: "Zvýraznená",
DlgColorSelected	: "Vybraná",

// Smiley Dialog
DlgSmileyTitle		: "Vkladanie smajlíkov",

// Special Character Dialog
DlgSpecialCharTitle	: "Výber speciálneho znaku",

// Table Dialog
DlgTableTitle		: "Vlastnosti tabuľky",
DlgTableRows		: "Riadky",
DlgTableColumns		: "Stĺpce",
DlgTableBorder		: "Ohraničenie",
DlgTableAlign		: "Zarovnanie",
DlgTableAlignNotSet	: "<nenastaven&eacute;>",
DlgTableAlignLeft	: "Vľavo",
DlgTableAlignCenter	: "Na stred",
DlgTableAlignRight	: "Vpravo",
DlgTableWidth		: "Šírka",
DlgTableWidthPx		: "pixelov",
DlgTableWidthPc		: "percent",
DlgTableHeight		: "Výška",
DlgTableCellSpace	: "Vzdialenosť buniek",
DlgTableCellPad		: "Odsadenie obsahu",
DlgTableCaption		: "Popis",

// Table Cell Dialog
DlgCellTitle		: "Vlastnosti bunky",
DlgCellWidth		: "Šírka",
DlgCellWidthPx		: "bodov",
DlgCellWidthPc		: "percent",
DlgCellHeight		: "Výška",
DlgCellWordWrap		: "Zalamovannie",
DlgCellWordWrapNotSet	: "<nenanstaven&eacute;>",
DlgCellWordWrapYes	: "Áno",
DlgCellWordWrapNo	: "Nie",
DlgCellHorAlign		: "Vodorovn&eacute; zarovnanie",
DlgCellHorAlignNotSet	: "<nenastaven&eacute;>",
DlgCellHorAlignLeft	: "Vľavo",
DlgCellHorAlignCenter	: "Na stred",
DlgCellHorAlignRight: "Vpravo",
DlgCellVerAlign		: "Zvysl&eacute; zarovnanie",
DlgCellVerAlignNotSet	: "<nenastaven&eacute;>",
DlgCellVerAlignTop	: "Nahor",
DlgCellVerAlignMiddle	: "Doprostred",
DlgCellVerAlignBottom	: "Dole",
DlgCellVerAlignBaseline	: "Na základňu",
DlgCellRowSpan		: "Zlúčen&eacute; riadky",
DlgCellCollSpan		: "Zlúčen&eacute; stĺpce",
DlgCellBackColor	: "Farba pozadia",
DlgCellBorderColor	: "Farba ohraničenia",
DlgCellBtnSelect	: "Výber...",

// Find Dialog
DlgFindTitle		: "Hľadať",
DlgFindFindBtn		: "Hľadať",
DlgFindNotFoundMsg	: "Hľadaný text nebol nájdený.",

// Replace Dialog
DlgReplaceTitle			: "Nahradiť",
DlgReplaceFindLbl		: "Čo hľadať:",
DlgReplaceReplaceLbl	: "Čím nahradiť:",
DlgReplaceCaseChk		: "Rozlišovať mal&eacute;/veľk&eacute; písmená",
DlgReplaceReplaceBtn	: "Nahradiť",
DlgReplaceReplAllBtn	: "Nahradiť všetko",
DlgReplaceWordChk		: "Len cel&eacute; slová",

// Paste Operations / Dialog
PasteErrorPaste	: "Bezpečnostn&eacute; nastavenie Vášho prohehliadača nedovoľujú editoru spustiť funkciu pre vloženie textu zo schránky. Prosím vložte text zo schránky pomocou klávesnice (Ctrl+V).",
PasteErrorCut	: "Bezpečnostn&eacute; nastavenie Vášho prohehliadača nedovoľujú editoru spustiť funkciu pre vystrihnutie zvolen&eacute;ho textu do schránky. Prosím vystrihnite zvolený text do schránky pomocou klávesnice (Ctrl+X).",
PasteErrorCopy	: "Bezpečnostn&eacute; nastavenie Vášho prohehliadača nedovoľujú editoru spustiť funkciu pre kopírovánie zvolen&eacute;ho textu do schránky. Prosím skopírujte zvolený text do schránky pomocou klávesnice (Ctrl+C).",

PasteAsText		: "Vložiť ako čistý text",
PasteFromWord	: "Vložiť text z Wordu",

DlgPasteMsg2	: "Please paste inside the following box using the keyboard (<STRONG>Ctrl+V</STRONG>) and hit <STRONG>OK</STRONG>.",
DlgPasteIgnoreFont		: "Ignorovať nastavenia typu písma",
DlgPasteRemoveStyles	: "Odstrániť formátovanie",
DlgPasteCleanBox		: "Vyčistiť schránku",


// Color Picker
ColorAutomatic	: "Automaticky",
ColorMoreColors	: "Viac farieb...",

// Document Properties
DocProps		: "Vlastnosti dokumentu",

// Anchor Dialog
DlgAnchorTitle		: "Vlastnosti kotvy",
DlgAnchorName		: "Meno kotvy",
DlgAnchorErrorName	: "Zadajte prosím meno kotvy",

// Speller Pages Dialog
DlgSpellNotInDic		: "Nie je v slovníku",
DlgSpellChangeTo		: "Zmeniť na",
DlgSpellBtnIgnore		: "Ignorovať",
DlgSpellBtnIgnoreAll	: "Ignorovať všetko",
DlgSpellBtnReplace		: "Prepísat",
DlgSpellBtnReplaceAll	: "Prepísat všetko",
DlgSpellBtnUndo			: "Späť",
DlgSpellNoSuggestions	: "- Žiadny návrh -",
DlgSpellProgress		: "Prebieha kontrola pravopisu...",
DlgSpellNoMispell		: "Kontrola pravopisu dokončená: bez chyb",
DlgSpellNoChanges		: "Kontrola pravopisu dokončená: žiadne slová nezmenen&eacute;",
DlgSpellOneChange		: "Kontrola pravopisu dokončená: zmenen&eacute; jedno slovo",
DlgSpellManyChanges		: "Kontrola pravopisu dokončená: zmenených %1 slov",

IeSpellDownload			: "Kontrola pravopisu nie je naištalovaná. Chcete ju hneď stiahnuť?",

// Button Dialog
DlgButtonText	: "Text",
DlgButtonType	: "Typ",

// Checkbox and Radio Button Dialogs
DlgCheckboxName		: "Názov",
DlgCheckboxValue	: "Hodnota",
DlgCheckboxSelected	: "Vybran&eacute;",

// Form Dialog
DlgFormName		: "Názov",
DlgFormAction	: "Akcie",
DlgFormMethod	: "Metóda",

// Select Field Dialog
DlgSelectName		: "Názov",
DlgSelectValue		: "Hodnota",
DlgSelectSize		: "Veľkosť",
DlgSelectLines		: "riadkov",
DlgSelectChkMulti	: "Povoliť viacnásobný výber",
DlgSelectOpAvail	: "Dostupn&eacute; možnosti",
DlgSelectOpText		: "Text",
DlgSelectOpValue	: "Hodnota",
DlgSelectBtnAdd		: "Pridať",
DlgSelectBtnModify	: "Zmeniť",
DlgSelectBtnUp		: "Nahor",
DlgSelectBtnDown	: "Dolu",
DlgSelectBtnSetValue : "Nastaviť ako vybranú hodnotu",
DlgSelectBtnDelete	: "Zmazať",

// Textarea Dialog
DlgTextareaName	: "Názov",
DlgTextareaCols	: "Stĺpce",
DlgTextareaRows	: "Riadky",

// Text Field Dialog
DlgTextName			: "Názov",
DlgTextValue		: "Hodnota",
DlgTextCharWidth	: "Šírka pola (znakov)",
DlgTextMaxChars		: "Maximálny počet znakov",
DlgTextType			: "Typ",
DlgTextTypeText		: "Text",
DlgTextTypePass		: "Heslo",

// Hidden Field Dialog
DlgHiddenName	: "Názov",
DlgHiddenValue	: "Hodnota",

// Bulleted List Dialog
BulletedListProp	: "Vlastnosti odrážok",
NumberedListProp	: "Vlastnosti číslovania",
DlgLstType			: "Typ",
DlgLstTypeCircle	: "Krúžok",
DlgLstTypeDisk		: "Disk",
DlgLstTypeSquare	: "Štvorec",
DlgLstTypeNumbers	: "Číslovanie (1, 2, 3)",
DlgLstTypeLCase		: "Mal&eacute; písmená (a, b, c)",
DlgLstTypeUCase		: "Veľk&eacute; písmená (A, B, C)",
DlgLstTypeSRoman	: "Mal&eacute; rímske číslice (i, ii, iii)",
DlgLstTypeLRoman	: "Veľk&eacute; rímske číslice (I, II, III)",

// Document Properties Dialog
DlgDocGeneralTab	: "Všeobecn&eacute;",
DlgDocBackTab		: "Pozadie",
DlgDocColorsTab		: "Farby a okraje",
DlgDocMetaTab		: "Meta Data",

DlgDocPageTitle		: "Titulok",
DlgDocLangDir		: "Orientácie jazyka",
DlgDocLangDirLTR	: "Zľeva doprava (LTR)",
DlgDocLangDirRTL	: "Zprava doľava (RTL)",
DlgDocLangCode		: "Kód jazyka",
DlgDocCharSet		: "Kódová stránka",
DlgDocCharSetOther	: "Iná kódová stránka",

DlgDocDocType		: "Typ záhlavia dokumentu",
DlgDocDocTypeOther	: "Iný typ záhlavia dokumentu",
DlgDocIncXHTML		: "Obsahuje deklarácie XHTML",
DlgDocBgColor		: "Farba pozadia",
DlgDocBgImage		: "URL adresa obrázku na pozadí",
DlgDocBgNoScroll	: "Fixn&eacute; pozadie",
DlgDocCText			: "Text",
DlgDocCLink			: "Odkaz",
DlgDocCVisited		: "Navštívený odkaz",
DlgDocCActive		: "Aktívny odkaz",
DlgDocMargins		: "Okraje stránky",
DlgDocMaTop			: "Horný",
DlgDocMaLeft		: "Ľavý",
DlgDocMaRight		: "Pravý",
DlgDocMaBottom		: "Dolný",
DlgDocMeIndex		: "Kľúčov&eacute; slová pre indexovanie (oddelen&eacute; čiarkou)",
DlgDocMeDescr		: "Popis stránky",
DlgDocMeAuthor		: "Autor",
DlgDocMeCopy		: "Autorsk&eacute; práva",
DlgDocPreview		: "Náhľad",

// Templates Dialog
Templates			: "Šablóny",
DlgTemplatesTitle	: "Šablóny obsahu",
DlgTemplatesSelMsg	: "Prosím vyberte šablóny ma otvorenie v editore<br>(terajší obsah bude stratený):",
DlgTemplatesLoading	: "Nahrávam zoznam šablón. Čakajte prosím...",
DlgTemplatesNoTpl	: "(žiadne šablóny nenájden&eacute;)",

// About Dialog
DlgAboutAboutTab	: "O aplikáci",
DlgAboutBrowserInfoTab	: "Informácie o prehliadači",
DlgAboutVersion		: "verzie",
DlgAboutLicense		: "Licencovan&eacute; pod pravidlami GNU Lesser General Public License",
DlgAboutInfo		: "Viac informácií získate na"
}
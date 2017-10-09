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
/********************************************************
 * S&eacute;curit&eacute;
 */

if (preg_match("/page/i", $_SERVER['PHP_SELF'])) {
    die ("Si vous voulez je peut aussi mettre en log votre IP et porter plainte...");
}

/********************************************************
 * global
 */

global $config, $s_joueur, $s_theme, $db, $dbprefix, $db, $dbprefix;


/********************************************************
 * Ajout d'une page
 */
if ($op == "addpage") {

    /*** verification securite ***/
    if ($grade['a'] != 'a' && $grade['b'] != 'b' && $grade['g'] != 'g') {
        js_goto($PHP_SELF);
    }

    $str = '';
    $erreur = 0;

    if (!$titre) {
        $erreur = 1;
        $str .= "- " . $strElementsTitreInvalide . "<br>";
    }
    if (!$npage) {
        $erreur = 1;
        $str .= "- " . $strElementsNpageInvalide . "<br>";
    }
    if ($nmenu) {
        if (!$lien) {
            $erreur = 1;
            $str .= "- " . $strElementsMenuLien . "<br>";
        }
    }
    if ($lien) {
        if (!$nmenu) {
            $erreur = 1;
            $str .= "- " . $strElementsMenuLien2 . "<br>";
        }
    }
    if (!is_numeric($npage)) {
        $erreur = 1;
        $str .= "- " . $strElementsNpageInvalide . "<br>";
    }
    if (!is_numeric($orde) AND $orde != '' || $orde != NULL) {
        $erreur = 1;
        $str .= "- " . $strElementsOrdeInvalide2 . "<br>";
    }
    if (npage_exist($npage) != 0) {
        $erreur = 1;
        $str .= "- " . $strElementsNpageExistant . "<br>";
    }
    if (!$rubrique) {
        $erreur = 1;
        $str .= "- " . $strElementsRubriqueInvalide . "<br>";
    }
    if (!$contenu) {
        $erreur = 1;
        $str .= "- " . $strElementsContenuInvalide . "<br>";
    }
    if ($erreur == 1) {
        show_erreur_saisie($str);
    } else {
        $date = time();

        if ($mods['pagescript'] == '0' || $mods['pagescript'] == '' || $mods['pagescript'] == NULL) {
            $contenu = remove_XSS($contenu);
        }

        /*
        $db->insert("page (auteur,titre,contenu,date,rubrique,'npage','nmenu','order','acces','lien')";
        $db->values("'$s_joueur','$titre','$contenu','$date','$rubrique',$npage,'$nmenu','$order','$acces','$lien'");
        $db->exec();
        */

        $sqladd = "INSERT INTO ${dbprefix}page(auteur,titre,contenu,date,rubrique,npage,nmenu,orde,acces,lien) Values('$s_joueur','$titre','$contenu','$date','$rubrique',$npage,'$nmenu','$orde','$acces','$lien')";
        $reqadd = mysql_query($sqladd) or die('Erreur SQL !<br>' . $sqladd . '<br>' . mysql_error());


        /*** redirection ***/
        $sql = "SELECT id FROM ${dbprefix}page WHERE titre='$titre' AND npage='$npage' AND rubrique='$rubrique'";
        $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());

        while ($data = mysql_fetch_array($req)) {
            $id = $data['id'];
        }
        js_goto("?page=page&op=modif&id=$id");
    }

}
/********************************************************
 * Del d'une page
 */
if ($op == "delpage") {

    /*** verification securite ***/
    if ($grade['a'] != 'a' && $grade['b'] != 'b' && $grade['g'] != 'g') {
        js_goto($PHP_SELF);
    }

    if ($rubrique != '') {
        $sqldel = "DELETE FROM `${dbprefix}page` WHERE rubrique='$rubrique'";
        $reqdel = mysql_query($sqldel) or die('Erreur SQL !<br>' . $sqldel . '<br>' . mysql_error());
    } else {
        $sqldel = "DELETE FROM `${dbprefix}page` WHERE id='$id'";
        $reqdel = mysql_query($sqldel) or die('Erreur SQL !<br>' . $sqldel . '<br>' . mysql_error());
    }
    /*** redirection ***/
    js_goto("?page=page&op=listm");
}

/********************************************************
 * Modif d'une page
 */
if ($op == "modpage") {

    /*** verification securite ***/
    if ($grade['a'] != 'a' && $grade['b'] != 'b' && $grade['g'] != 'g') {
        js_goto($PHP_SELF);
    }

    $str = '';
    $erreur = 0;

    if (!$titre) {
        $erreur = 1;
        $str .= "- " . $strElementsTitreInvalide . "<br>";
    }
    if (!$npage) {
        $erreur = 1;
        $str .= "- " . $strElementsNpageInvalide . "<br>";
    }
    if (npage_exist($npage) != 0) {
        $erreur = 1;
        $str .= "- " . $strElementsNpageExistant . "<br>";
    }
    if (!$rubrique) {
        $erreur = 1;
        $str .= "- " . $strElementsRubriqueInvalide . "<br>";
    }
    if (!is_numeric($orde) AND $orde != '' || $orde != NULL) {
        $erreur = 1;
        $str .= "- " . $strElementsOrdeInvalide2 . "<br>";
    }
    if (!$contenu) {
        $erreur = 1;
        $str .= "- " . $strElementsContenuInvalide . "<br>";
    }
    if ($erreur == 1) {
        show_erreur_saisie($str);
    } else {
        $date = time();


        if ($mods['pagescript'] == '0' || $mods['pagescript'] == '' || $mods['pagescript'] == NULL) {
            $contenu = remove_XSS($contenu);
        }

        $sqldel = "UPDATE `${dbprefix}page` SET titre = '$titre', contenu = '$contenu', rubrique = '$rubrique', 
		npage = '$npage', nmenu = '$nmenu', orde = '$orde', acces = '$acces', lien = '$lien', orde='$orde' WHERE id ='$id'";
        $reqdel = mysql_query($sqldel) or die('Erreur SQL !<br>' . $sqldel . '<br>' . mysql_error());

        /*$db->update("page");
        $db->set("titre = '$titre'");
        $db->set("contenu = '$contenu'");
        $db->set("rubrique = '$rubrique'");
        $db->set("npage = '$npage'");
        $db->set("nmenu = '$nmenu'");
        $db->set("order = '$order'");
        $db->set("acces = '$acces'");
        $db->set("lien = '$lien'");
        $db->where("id = $id");
        $db->exec();*/

        /*** redirection ***/
        js_goto("?page=page&op=modif&id=$id");
    }


}
/********************************************************
 * Ajout d'une page
 */
if ($_GET['op'] == "add") {

    if ($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['g'] == 'g') {

        echo "<form method=post name=\"formulaire\" action=?page=page&op=addpage>";
        echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
        echo "<table cellspacing=1 cellpadding=0 border=0 name=tab2>";
        echo "<tr><td class=header  fiche>$strAjouterPage</td></tr>";
        echo "<tr><td>";
        echo "<table cellspacing=0 cellpadding=3 border=0 width=100% >";
        echo "<tr>";
        echo "<td class=titlefiche>$strTitre :</td>";
        echo "<td class=textfiche><input type=text name=titre maxlength=40 size=40></td>";
        echo "</tr>";

        $sqld = "SELECT rubrique FROM ${dbprefix}page WHERE rubrique !='' GROUP BY rubrique";
        $reqd = mysql_query($sqld) or die('Erreur SQL !<br>' . $sqld . '<br>' . mysql_error());

        echo "<tr>";
        echo "<td class=titlefiche>$strRubrique :</td>";
        echo "<td class=textfiche><input type=text name=rubrique maxlength=20 size=20>";
        echo "<select name=selectrubrique onChange=\"javascript:document.formulaire.rubrique.value=this.options[this.selectedIndex].value;\"><option value=''></option>";

        while ($datad = mysql_fetch_array($reqd)) {
            echo '<option value="' . $datad['rubrique'] . '">' . $datad['rubrique'] . '</option>';
        }
        echo "</select></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td class=titlefiche>$strNpage :</td>";
        echo "<td class=textfiche><input type=text name=npage maxlength=3 size=3></td>";
        echo "</tr>";

        $sqlx = "SELECT titre FROM ${dbprefix}menu";
        $reqx = mysql_query($sqlx) or die('Erreur SQL !<br>' . $sqlx . '<br>' . mysql_error());

        echo "<tr>";
        echo "<td class=titlefiche>$strNmenu :</td>";
        echo "<td class=textfiche><select name=nmenu><option value=''></option>";

        while ($datax = mysql_fetch_array($reqx)) {
            echo '<option value="' . $datax['titre'] . '">' . $datax['titre'] . '</option>';
        }
        echo "</select>";
        echo "</td></tr>";
        echo "<tr>";
        echo "<td class=titlefiche>$strLien :</td>";
        echo "<td class=textfiche><input type=text name=lien maxlength=12 size=12></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td class=titlefiche>$strOrdre :</td>";
        echo "<td class=textfiche><input type=text name=orde maxlength=2 size=2></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td class=titlefiche>$strAcces :</td>";
        echo "<td class=textfiche><select name=acces><option value=\"0\">$strTous</option>";
        echo "<option value=\"A\">$strAdmins</option>";
        echo "<option value=\"N\">$strNewseur</option>";
        echo "<option value=\"P\">$strPremium</option>";
        echo "<option value=\"M\">$strjoueur</option>";
        echo "</select>";
        echo "</td></tr>";
        echo "<tr>";
        echo "<td class=textfiche colspan=2 align=center>";
        buttonBB('contenu');
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td class=titlefiche style=\"white-space:normal\">$strContenu :</td>";
        echo "<td class=textfiche><textarea cols=60 rows=10 name=contenu ID=contenu wrap=virtual ONSELECT=\"storeCaret(this);\" ONCLICK=\"storeCaret(this);\" ONKEYUP=\"storeCaret(this);\"></textarea></td>";
        echo "</tr>";
        echo "<tr><td class=footerfiche colspan=2 align=center><input type=submit value=\"$strAjouter\"></td></tr>";
        echo "</table>";
        echo "</td></tr></table>";
        echo "</td></tr></table>";
        echo "</form>";

        show_consignes($strAddPageConsignes);

    }
}
/********************************************************
 * List pour modif d'une page
 */
if ($_GET['op'] == "listm") {

    if ($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['g'] == 'g') {

        echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
        echo "<table cellspacing=1 cellpadding=0 border=0>";
        echo "<tr><td class=header  fiche>&nbsp;&nbsp;&nbsp; $strModifierPageR &nbsp;&nbsp;&nbsp;</td></tr>";
        echo "<tr><td>";
        echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";

        $sqlx = "SELECT rubrique,id FROM ${dbprefix}page GROUP BY rubrique";
        $reqx = mysql_query($sqlx) or die('Erreur SQL !<br>' . $sqlx . '<br>' . mysql_error());

        $i2 = '1';
        $list_exist = 'N';

        while ($datax = mysql_fetch_array($reqx)) {
            if ($i2 == "1") {
                echo "<tr>";
                $list_exist = 'O';
            }
            $i2++;
            echo "<td class=textfiche align='center'><li class=lir><a href='?page=page&op=listm2&rubrique=" . $datax['rubrique'] . "'>" . $datax['rubrique'] . "</a><a href='?page=page&op=delpage&id=" . $datax['id'] . "&rubrique=" . $datax['rubrique'] . "'><img src='images/f.gif' border='0' /></a></li></td>";
            if ($i2 == "5") {
                echo "</tr>";
                $i2 = "1";
            }
        }
        if ($list_exist == 'N') {
            echo "<td class=textfiche align='center'>&nbsp; $strPageNotlist &nbsp;</td>";

        }

        echo "</table>";
        echo "</td></tr></table>";
        echo "</td></tr></table>";


    }
}
/********************************************************
 * List Titre pour modif page
 */
if ($_GET['op'] == "listm2") {

    if ($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['g'] == 'g') {

        $rubrique = $_GET['rubrique'];

        echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
        echo "<table cellspacing=1 cellpadding=0 border=0>";
        echo "<tr><td class=header  fiche>&nbsp;&nbsp;&nbsp; $strModifierPage &nbsp;&nbsp;&nbsp;</td></tr>";
        echo "<tr><td>";
        echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";

        $sqlx = "SELECT id,titre FROM ${dbprefix}page WHERE rubrique='$rubrique' AND titre!= '' GROUP BY titre";
        $reqx = mysql_query($sqlx) or die('Erreur SQL !<br>' . $sqlx . '<br>' . mysql_error());

        $i2 = '1';
        while ($datax = mysql_fetch_array($reqx)) {
            if ($i2 == "1") {
                echo "<tr>";
            }
            $i2++;
            echo "<td class=textfiche align=center><li class=lib><a href='?page=page&op=modif&id=" . $datax['id'] . "'>" . $datax['titre'] . "</a></li></td>";
            if ($i2 == "5") {
                echo "</tr>";
                $i2 = "1";
            }
        }

        echo "</table>";
        echo "</td></tr></table>";
        echo "</td></tr></table>";


    }
}
/********************************************************
 * MODIF d'une page
 */
if ($_GET['op'] == "modif") {

    if ($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['g'] == 'g') {

        $id = $_GET['id'];


        $sqldelta = "SELECT * FROM ${dbprefix}page WHERE id='$id'";
        $reqdelta = mysql_query($sqldelta) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());

        while ($data = mysql_fetch_array($reqdelta)) {

            echo "<form method=post name=\"formulaire\" action=?page=page&op=modpage&id=" . $data['id'] . ">";
            echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
            echo "<table cellspacing=1 cellpadding=0 border=0>";
            echo "<tr><td class=header  fiche>$strModifierPage</td></tr>";
            echo "<tr><td>";
            echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
            echo "<tr>";
            echo "<td class=titlefiche>$strTitre :</td>";
            echo "<td class=textfiche><input type=text name=titre maxlength=40 size=40 value=" . $data['titre'] . "></td>";
            echo "</tr>";

            $sqld = "SELECT rubrique FROM ${dbprefix}page WHERE rubrique !='' GROUP BY rubrique";
            $reqd = mysql_query($sqld) or die('Erreur SQL !<br>' . $sqld . '<br>' . mysql_error());

            echo "<tr>";
            echo "<td class=titlefiche>$strRubrique :</td>";
            echo "<td class=textfiche><input type=text name=rubrique maxlength=20 size=20 value=" . $data['rubrique'] . ">";
            echo "<select name=selectrubrique onChange=\"javascript:document.formulaire.rubrique.value=this.options[this.selectedIndex].value;\"><option value=''></option>";

            while ($datad = mysql_fetch_array($reqd)) {
                echo '<option value="' . $datad['rubrique'] . '">' . $datad['rubrique'] . '</option>';
            }
            echo "</select></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td class=titlefiche>$strNpage :</td>";
            echo "<td class=textfiche><input type=text name=npage maxlength=3 size=3 value=" . $data['npage'] . "></td>";
            echo "</tr>";

            $sqlx = "SELECT titre FROM ${dbprefix}menu";
            $reqx = mysql_query($sqlx) or die('Erreur SQL !<br>' . $sqlx . '<br>' . mysql_error());

            echo "<tr>";
            echo "<td class=titlefiche>$strNmenu :</td>";
            echo "<td class=textfiche><select name=nmenu><option value=" . $data['nmenu'] . "></option>";

            while ($datax = mysql_fetch_array($reqx)) {
                echo '<option value="' . $datax['titre'] . '">' . $datax['titre'] . '</option>';
            }
            echo "</select>";
            echo "</td></tr>";
            echo "<tr>";
            echo "<td class=titlefiche>$strLien :</td>";
            echo "<td class=textfiche><input type=text name=lien maxlength=12 size=12 value=" . $data['lien'] . "></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td class=titlefiche>$strLienex :</td>";
            echo "<td class=textfiche><input type=text name=lienex maxlength=140 size=70 value=?page=page&op=see&rubrique=" . $data['rubrique'] . "&npage=" . $data['npage'] . "&id=" . $data['id'] . "></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td class=titlefiche>$strOrdre :</td>";
            echo "<td class=textfiche><input type=text name=orde maxlength=2 size=2 value=" . $data['orde'] . "></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td class=titlefiche>$strAcces :</td>";
            echo "<td class=textfiche><select name=acces>";
            if ($data['acces'] == "0") {
                $rubrique = "$strTous";
            }
            if ($data['acces'] == "A") {
                $rubrique = "$strAdmins";
            }
            if ($data['acces'] == "N") {
                $rubrique = "$strNewseur";
            }
            if ($data['acces'] == "P") {
                $rubrique = "$strPremium";
            }
            if ($data['acces'] == "M") {
                $rubrique = "$strjoueurs";
            }
            echo "<option value=" . $data['rubrique'] . ">" . $rubrique . "</option>";
            echo "<option value=\"0\">Tous</option>";
            echo "<option value=\"A\">Admin</option>";
            echo "<option value=\"N\">Newseur</option>";
            echo "<option value=\"P\">Premium</option>";
            echo "<option value=\"M\">joueur</option>";
            echo "</select>";
            echo "</td></tr>";
            echo "<tr>";
            echo "<td class=textfiche colspan=2 align=center>";
            buttonBB('contenu');
            echo "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td class=titlefiche style=\"white-space:normal\">$strContenu :</td>";
            echo "<td class=textfiche><textarea cols=60 rows=10 name=contenu ID=contenu wrap=virtual ONSELECT=\"storeCaret(this);\" ONCLICK=\"storeCaret(this);\" ONKEYUP=\"storeCaret(this);\">" . $data['contenu'] . "</textarea></td>";
            echo "</tr>";
            echo "<tr><td class=footerfiche colspan=2 align=center><input type=submit value=\"$strModifier\"></td></tr>";
            echo "</table>";
            echo "</td></tr></table>";
            echo "</td></tr></table>";
            echo "</form><br><br><br><hr><br><br>";


            $contenu = $data['contenu'];

            $contenu = BBcode($contenu);
            $contenu = stripslashes($contenu);
            $contenu = wordwrap($contenu, 180, "\n", 1);
            echo $contenu;

            echo "<br><br><hr><br><br><br>";
        }


    }
}
/********************************************************
 * Affichage de la page demand&eacute;e
 */
if ($_GET['op'] == "see") {


    $rubrique = $_GET['rubrique'];
    $npage = $_GET['npage'];

    $sql = "SELECT * FROM ${dbprefix}page WHERE rubrique='$rubrique' AND npage='$npage'";
    $req = mysql_query($sql) or die('Erreur SQL !<br>' . $sql . '<br>' . mysql_error());

    while ($data = mysql_fetch_array($req)) {
        $contenu = $data['contenu'];
        $acces = $data['acces'];
        if ($acces != "" || $contenu != NULL) {
            if ($acces == "A") {
                if ($grade['a'] != 'a' && $grade['b'] != 'b' && $grade['g'] != 'g') js_goto('?page=login');
            }//admin
            if ($acces == "N") {
                if ($grade['a'] != 'a' && $grade['b'] != 'b' && $grade['g'] != 'g' && $grade['n'] != 'n') js_goto('?page=login');
            }//Newser
            if ($acces == "M") {
                if ($s_joueur == "" || $s_joueur == NULL) js_goto('?page=login');
            }//joueur
            if ($acces == "P") {
                if (!premium($s_joueur) && ($grade['a'] != 'a' && $grade['b'] != 'b' && $grade['g'] != 'g')) js_goto('?page=login');
            }//premium

            if ($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['g'] == 'g') {
                echo "<a href='?page=page&op=modif&id=" . $data['id'] . "'><img src='images/edit.gif' border=0 /></a><a href='?page=page&op=delpage&id=" . $data['id'] . "'> <img src='images/f.gif' border=0 /></a><br><br>";
            }
            $contenu = BBcode($contenu);
            $contenu = stripslashes($contenu);
            $contenu = wordwrap($contenu, 180, "\n", 1);

            echo $contenu;
        }

    }

}

?>

<?php
/*
   +---------------------------------------------------------------------+
   | phpTournois                                                         |
   | phpTournoisG4 �2005 by Gectou4 <Gectou4 Gectou4@hotmail.com>        |
   +---------------------------------------------------------------------+
   +---------------------------------------------------------------------+
   | phpTournoisG4 �2004 by Gectou4 <le_gardien_prime@hotmail.com>       |
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
if (preg_match("/partenaires.php/i", $_SERVER['PHP_SELF'])) {
    die ("You cannot open this page directly");
}

if (!$config['partenaires']) js_goto('?page=index');

/********************************************************
 * ajout d'un partenaire
 */
if ($op == 'add') {

    /*** verification securite globale ***/
    if ($grade['a'] != 'a' && $grade['b'] != 'b' && $grade['p'] != 'p') {
        js_goto($PHP_SELF);
    }

    $str = '';
    $erreur = 0;

    if (!$nom) {
        $erreur = 1;
        $str .= "- $strElementsNomInvalide<br>";
    }
    if (!$image) {
        $erreur = 1;
        $str .= "- $strElementsImageInvalide<br>";
    }
    if (!$url || $url == 'http://') {
        $erreur = 1;
        $str .= "- $strElementsUrlInvalide<br>";
    }

    if ($erreur == 1) {
        show_erreur_saisie($str);
    } else {

        $db->insert("${dbprefix}partenaires (nom, url, image, rang, date)");
        $db->values("'$nom','$url','$image','$rang', " . time() . "");
        $db->exec();

        js_goto("?page=partenaires&op=admin");
    }
} /********************************************************
 * suppression d'un partenaire
 */
elseif ($op == "delete") {

    /*** verification securite globale ***/
    if ($grade['a'] != 'a' && $grade['b'] != 'b' && $grade['p'] != 'p') {
        js_goto($PHP_SELF);
    }

    $db->delete("${dbprefix}partenaires");
    $db->where("id = $id");
    $db->exec();


    js_goto("?page=partenaires&op=admin");

} /********************************************************
 * Modification d'un partenaire
 */
elseif ($op == "modify") {

    /*** verification securite globale ***/
    if ($grade['a'] != 'a' && $grade['b'] != 'b' && $grade['p'] != 'p') {
        js_goto($PHP_SELF);
    }

    $db->select("*");
    $db->from("${dbprefix}partenaires");
    $db->where("id = '$id'");
    $res = $db->exec();
    $partenaire = $db->fetch($res);

    echo "<p class=title>.:: $strAdminPartenaires ::.</p>";

    echo "<form method=post action=?page=partenaires&op=do_modify>";
    echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
    echo "<table cellspacing=1 cellpadding=0 border=0>";
    echo "<tr><td class=headerfiche>$strModifierPartenaires</td></tr>";
    echo "<tr><td>";
    echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
    echo "<tr>";
    echo "<td class=titlefiche>$strNom <font color=red><b>*</b></font> :</td>";
    echo "<td class=textfiche><input type=text name=nom size=30 value=\"" . stripslashes($partenaire->nom) . "\"></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche>$strUrl <font color=red><b>*</b></font> :</td>";
    echo "<td class=textfiche><input type=text name=url size=60 value=\"$partenaire->url\"></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche>$strImage <font color=red><b>*</b></font> :</td>";
    echo "<td class=textfiche>";
    echo "<select name=image>";
    $fd = opendir("images/partenaires");

    while ($file = readdir($fd)) {
        if ($file != "." && $file != "..") {
            echo "<option value=\"$file\"";
            if ($partenaire->image == $file) echo " SELECTED";
            echo ">$file";
        }
    }
    echo "</select>";
    closedir($fd);
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche>$strRang :</td>";
    echo "<td class=textfiche><input type=rang name=rang size=5 value=\"$partenaire->rang\"></td></td>";
    echo "</tr>";
    echo "<tr><td class=footerfiche colspan=2 align=center><input type=submit value=\"$strModifier\">&nbsp;<input type=button value=\"$strRetour\" onclick=\"document.location='?page=liens&op=admin'\"></td></tr>";
    echo "</table>";
    echo "</td></tr></table>";
    echo "<input type=hidden name=id value='$id'>";
    echo "</td></tr></form></table>";


} /********************************************************
 * Modification d'un partenaire
 */
elseif ($op == "do_modify") {

    /*** verification securite globale ***/
    if ($grade['a'] != 'a' && $grade['b'] != 'b' && $grade['p'] != 'p') {
        js_goto($PHP_SELF);
    }

    $str = '';
    $erreur = 0;

    if (!$nom) {
        $erreur = 1;
        $str .= "- $strElementsNomInvalide<br>";
    }
    if (!$image) {
        $erreur = 1;
        $str .= "- " . $strElementsImageInvalide . "<br>";
    }
    if (!$url || $url == 'http://') {
        $erreur = 1;
        $str .= "- $strElementsUrlInvalide<br>";
    }

    if ($erreur == 1) {
        show_erreur_saisie($str);
    } else {

        $db->update("${dbprefix}partenaires");
        $db->set("nom = '$nom'");
        $db->set("url = '$url'");
        $db->set("image = '$image'");
        $db->set("rang = '$rang'");
        $db->where("id = '$id'");
        $db->exec();

        js_goto("?page=partenaires&op=admin");
    }
} /********************************************************
 * Affichage admin
 */
elseif ($op == 'admin') {

    /*** verification securite ***/
    if ($grade['a'] != 'a' && $grade['b'] != 'b' && $grade['p'] != 'p') {
        js_goto($PHP_SELF);
    }

    echo "<p class=title>.:: $strAdminPartenaires ::.</p>";

    echo "<table cellspacing=0 cellpadding=2 border=0>";
    echo "<tr><td class=title>" . nb_partenaires() . " $strPartenaires</td></tr>";
    echo "</table>";

    $db->select("*");
    $db->from("${dbprefix}partenaires");
    $db->order_by("rang");
    $partenaires = $db->exec();

    if ($db->num_rows($partenaires) != 0) {

        echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
        echo "<table cellspacing=1 cellpadding=2 border=0>";
        echo "<tr><td class=header>$strRang</td><td class=header>$strNom</td><td class=header>$strUrl</td><td class=header>$strImage</td></tr>";

        while ($partenaire = $db->fetch($partenaires)) {

            echo "<tr>";
            echo "<td class=text align=center>$partenaire->rang</td>";
            echo "<td class=text>";
            echo "<div style=\"clear: both\"><div style=\"float: left\">" . stripslashes($partenaire->nom) . "</div>";
            echo "<div style=\"float: right\">&nbsp;<a href=\"?page=partenaires&op=modify&id=$partenaire->id\">[$strE]</a> <a href=?page=partenaires&op=delete&id=" . $partenaire->id . " onclick=\"return confirm('$strConfirmEffacerPartenaire');\">[$strS]</a></div>";
            echo "</div></td>";
            echo "<td class=text><a href=\"$partenaire->url\">$partenaire->url</a></td>";
            echo "<td class=text align=center><img src=\"images/partenaires/$partenaire->image\" align=absmiddle height=20></td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</td></tr></table>";
    }

    /*** ajout d'un partenaire ***/
    echo "<br>";
    echo "<form method=post action=?page=partenaires&op=add>";
    echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
    echo "<table cellspacing=1 cellpadding=0 border=0>";
    echo "<tr><td class=headerfiche>$strAjouterPartenaire</td></tr>";
    echo "<tr><td>";
    echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
    echo "<tr>";
    echo "<td class=titlefiche>$strNom <font color=red><b>*</b></font> :</td>";
    echo "<td class=textfiche><input type=text name=nom size=30></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche>$strUrl <font color=red><b>*</b></font> :</td>";
    echo "<td class=textfiche><input type=text name=url size=50 value=\"http://\"></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche>$strImage <font color=red><b>*</b></font> :</td>";
    echo "<td class=textfiche>";
    echo "<select name=image>";
    $fd = opendir("images/partenaires");
    while ($file = readdir($fd)) {
        if ($file != "." && $file != "..") {
            echo "<option value=\"$file\">$file";
        }
    }
    echo "</select>";
    closedir($fd);
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche>$strRang :</td>";
    echo "<td class=textfiche><input type=rang name=rang size=5></td></td>";
    echo "</tr>";
    echo "<tr><td class=footerfiche align=center colspan=2><input type=submit value=\"$strAjouter\"></td></tr>";
    echo "</table>";
    echo "</td></tr></table>";
    echo "</td></tr></form></table>";

    echo "<br><img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";

} /********************************************************
 * Affichage normal
 */
else {

    echo "<p class=title>.:: $strPartenaires ::.</p>";

    $db->select("*");
    $db->from("${dbprefix}partenaires");
    $db->order_by("rang");
    $partenaires = $db->exec();

    if ($db->num_rows($partenaires) != 0) {

        echo "<table border=0 align=center cellpadding=2 cellspacing=2>";

        while ($partenaire = $db->fetch($partenaires)) {
            $date = strftime(DATESTRING2, $partenaire->date);
            echo "<tr>";
            echo "<td class=test2 align=center><a target=\"_blank\" href=\"$partenaire->url\"><img border=0 src=\"images/partenaires/$partenaire->image\" title=\"$partenaire->nom\"></a></td>";
            echo "<td class=text2 align=left><li class=lib><a target=\"_blank\" href=\"$partenaire->url\"><b>$partenaire->nom</b></a><br>$strPartenaireDepuisLe : $date<br>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<table cellspacing=2 cellpadding=2 border=0>";
        echo "<tr><td class=title>$strPasDePartenaires</td></tr>";
        echo "</table>";
    }

    echo "<br><table cellspacing=2 cellpadding=2 border=0>";
    echo "<tr><td class=title valign=middle>$strDevenirPartenaire : <a href=\"mailto: $config[emailcontact]?subject=$strLinkex\"><img src=\"images/icon_email.gif\" border=0 align=absmiddle></a></td></tr>";
    echo "</table>";


    echo "<br><img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";


}

?>

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
*/
/*** verification securite ***/
if (preg_match("/rang.php/i", $_SERVER['PHP_SELF'])) {
    die ("You cannot open this page directly");
}

if ($grade['a'] != 'a' && $grade['b'] != 'b' && $grade['w'] != 'w') {
    js_goto($PHP_SELF);
}

/********************************************************
 * Modification de la configuration
 */
if ($op == "modify") {

    $grade_end = '';


    if ($champ_a) {
        $grade_end = $grade_end . 'a';
    }
    if ($champ_b) {
        $grade_end = $grade_end . 'b';
    }
    if ($champ_c) {
        $grade_end = $grade_end . 'c';
    }
    if ($champ_d) {
        $grade_end = $grade_end . 'd';
    }
    if ($champ_e) {
        $grade_end = $grade_end . 'e';
    }
    if ($champ_f) {
        $grade_end = $grade_end . 'f';
    }
    if ($champ_g) {
        $grade_end = $grade_end . 'g';
    }
    if ($champ_h) {
        $grade_end = $grade_end . 'h';
    }
    if ($champ_i) {
        $grade_end = $grade_end . 'i';
    }
    if ($champ_j) {
        $grade_end = $grade_end . 'j';
    }
    if ($champ_k) {
        $grade_end = $grade_end . 'k';
    }
    if ($champ_l) {
        $grade_end = $grade_end . 'l';
    }
    if ($champ_m) {
        $grade_end = $grade_end . 'm';
    }
    if ($champ_n) {
        $grade_end = $grade_end . 'n';
    }
    if ($champ_o) {
        $grade_end = $grade_end . 'o';
    }
    if ($champ_p) {
        $grade_end = $grade_end . 'p';
    }
    if ($champ_q) {
        $grade_end = $grade_end . 'q';
    }
    if ($champ_r) {
        $grade_end = $grade_end . 'r';
    }
    if ($champ_s) {
        $grade_end = $grade_end . 's';
    }
    if ($champ_t) {
        $grade_end = $grade_end . 't';
    }
    if ($champ_u) {
        $grade_end = $grade_end . 'u';
    }
    if ($champ_v) {
        $grade_end = $grade_end . 'v';
    }
    if ($champ_w) {
        $grade_end = $grade_end . 'w';
    }
    if ($champ_x) {
        $grade_end = $grade_end . 'x';
    }
    if ($champ_y) {
        $grade_end = $grade_end . 'y';
    }
    if ($champ_z) {
        $grade_end = $grade_end . 'z';
    }


    $db->update("${dbprefix}joueurs");

    $db->set("grade='$grade_end'");
    $db->where("id=$id_j");
    $db->exec();

    /*** redirection ***/
    js_goto("?page=rang&op=edit&id_j=$id_j");


} /********************************************************
 * Affichage admin
 */
else if ($op == "edit") {

    echo "<p class=title>.:: $strMODS ::.<br><font size=2>$strMODSC</font></p>";

    $id_j = $_GET['id_j'];

    echo "<form method=post action=?page=rang&op=modify>";
    echo "<input type='hidden' value=$id_j name=id_j >";
    //echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
    //echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td class=textfichemods align='center'>";

    /*** table de la config ***/
    echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1 width='400'><tr><td>";


    echo "<table cellspacing=1 cellpadding=0 border=0 width='100%'>";
    echo "<tr><td class=modsfiche width='100%'>$strEdit_rang</td></tr>";
    echo "<tr><td>";
    echo "<table cellspacing=0 cellpadding=2 border=0 width=100%>";
    echo "<tr><td class=partfiche colspan=2></td></tr>";

    if ($grade['a'] != 'a' && $grade['b'] != 'b') {
        js_goto($PHP_SELF);
    }


    /*** chargement de la variable des 'gardes' de l'utilisateur � modifier  ***/
    $db->select("id,grade");
    $db->from("${dbprefix}joueurs");
    $db->where("id = '$id_j'");
    $res = $db->exec();


    $g_array = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z",);


    while ($grade_edit_ch = $db->fetch($res)) {

        $whiled = $grade_edit_ch->grade;

    }


    if (preg_match('/a/i', $whiled)) {
        $edit_req_A = 'YES';
    } else {
        $edit_req_A = 'NO';
    }


    if ($edit_req_A == 'YES' && $grade['a'] != 'a') {

        show_erreur_saisie($strRang_wrong);

    } else {


        for ($g1 = 0; $g1 <= 25; $g1++) {
            $affich = "strRang_" . $g_array[$g1];
            echo "<tr><td class=titlefichemods>${$affich} : </td>";
            echo "<td class=textfichemods>";
            echo "<input type=radio name=champ_" . $g_array[$g1] . " value=1 style=\"border: 0px;background-color:#66CC66;\"";
            if (preg_match('/' . $g_array[$g1] . '/', $whiled)) echo " CHECKED";
            echo "> $strOui ";
            echo "<input type=radio name=champ_" . $g_array[$g1] . " value=0 style=\"border: 0px;background-color:#FF6666;\"";
            if (!preg_match('/' . $g_array[$g1] . '/', $whiled)) echo " CHECKED";
            echo "> $strNon";
            echo "</td></tr>";

        }

        echo "<tr><td class=footerfichemods colspan=2><hr><input type=submit value=\"$strModifier\"></td></tr>";


        echo "</table>";
        echo "</td></tr></table>";
        echo "</td></tr></table>";

        echo "</form>";

        echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";
    }
}

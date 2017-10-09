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

if (preg_match("/jeux.php/i", $_SERVER['PHP_SELF'])) {
    die ("You cannot open this page directly");
}

/*** verification securite ***/
if ($grade['a'] != 'a' && $grade['b'] != 'b' && $grade['t'] != 't' && $grade['u'] != 'u') {
    js_goto($PHP_SELF);
}


/********************************************************
 * Ajout d'un jeux
 */
if ($op == "add") {

    $str = '';
    $erreur = 0;

    if (!$nom) {
        $erreur = 1;
        $str .= "- $strElementsNomInvalide<br>";
    }
    if (!$sigle) {
        $erreur = 1;
        $str .= "- $strElementsSigleInvalide<br>";
    }
    if (!$icone) {
        $erreur = 1;
        $str .= "- $strElementsIconeInvalide<br>";
    }

    if ($erreur == 1) {
        show_erreur_saisie($str);
    } else {

        $db->insert("${dbprefix}jeux (nom,sigle,icone)");
        $db->values("'$nom','$sigle','$icone'");
        $db->exec();

        /*** redirection ***/
        js_goto("?page=jeux");
    }
} /********************************************************
 * Suppression d'un jeux
 */
elseif ($op == "delete") {
    $db->delete("${dbprefix}jeux");
    $db->where("id = $id");
    $db->exec();
    $db->delete("${dbprefix}maps");
    $db->where("jeux = $id");
    $db->exec();

    /*** redirection ***/
    js_goto("?page=jeux");
} /********************************************************
 * Affichage admin
 */
else {
    $nb_jeux = nb_jeux() - 1;
    echo "<p class=title>.:: $strAdminJeux ::.</p>";

    echo "<table cellspacing=0 cellpadding=0 border=0>";
    echo "<tr><td class=title>" . $nb_jeux . " $strJeux</td></tr>";
    echo "</table>";

    $db->select("*");
    $db->from("${dbprefix}jeux");
    $db->where("id <> 1");
    $db->order_by("sigle");
    $jeux = $db->exec();

    /** reinit des colonne a 1 ***/
    if ($db->num_rows($jeux) < $config['col_jeux'])
        $config['col_jeux'] = 1;

    if ($db->num_rows($jeux) != 0) {
        $i = 0;
        while ($jeu = $db->fetch($jeux)) {
            $tab_jeux[$i] = $jeu;
            $i++;
        }

        echo "<table cellspacing=0 cellpadding=0 border=0 class=liste><tr valign=top>";

        for ($i = 0; $i < $config['col_jeux']; $i++) {
            echo "<td>";
            echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
            echo "<table cellspacing=1 cellpadding=2 border=0>";
            echo "<tr><td class=headerliste>$strIcone</td><td class=headerliste>$strSigle</td><td class=headerliste colspan=2>$strNom</td></tr>";

            for ($j = $i; $j < count($tab_jeux); $j = $j + $config['col_jeux']) {
                echo "<tr>";
                echo "<td class=textliste align=center><img src=\"images/jeux/" . $tab_jeux[$j]->icone . "\" border=0></td>";
                echo "<td class=textliste align=center><b>" . $tab_jeux[$j]->sigle . "</b></td>";
                echo "<td class=textliste>";
                echo "<div style=\"clear: both\"><div style=\"float: left\">" . $tab_jeux[$j]->nom . "</div>";
                if (nb_joueurs_jeu($tab_jeux[$j]->id) == 0 && nb_tournois_jeu($tab_jeux[$j]->id) == 0 && nb_serveurs_jeu($tab_jeux[$j]->id) == 0)
                    echo "<div style=\"float: right\">&nbsp;<a href=?page=jeux&op=delete&id=" . $tab_jeux[$j]->id . " onclick=\"return confirm('$strConfirmEffacerJeux');\">[$strS]</a></div>";
                echo "</div></td></tr>";
            }
            echo "</table>";
            echo "</td></tr></table>";
            echo "</td>";
        }
        echo "</tr></table>";
    }

    /*** ajout d'un jeu ***/
    echo "<form method=post action=?page=jeux&op=add>";
    echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
    echo "<table cellspacing=1 cellpadding=0 border=0>";
    echo "<tr><td class=headerfiche colspan=2>$strAjouterJeu</td></tr>";
    echo "<tr><td>";
    echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
    echo "<tr><td class=titlefiche>$strNom <font color=red><b>*</b></font> : </td><td class=textfiche><input type=text name=nom></td>";
    echo "<tr><td class=titlefiche>$strSigle <font color=red><b>*</b></font> :</td><td class=textfiche><input type=text name=sigle></td>";
    echo "<tr><td class=titlefiche>$strIcone <font color=red><b>*</b></font> :</td>";
    echo "<td class=textfiche>";
    echo "<select name=icone>";
    $fd = opendir("images/jeux");
    while ($file = readdir($fd)) {
        if ($file != "." && $file != "..") {
            echo "<option value=\"$file\">$file";
        }
    }
    echo "</select>";
    closedir($fd);
    echo "</td>";

    echo "<tr><td class=footerfiche colspan=2 align=center><input type=submit value=\"$strAjouter\"></td></tr>";
    echo "</table>";
    echo "</td></tr></table>";
    echo "</td></tr></table>";
    echo "</form>";

    show_consignes($strAdminJeuxConsignes);

    echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";

}


?>

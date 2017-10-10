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
if (preg_match("/maps.php/", $_SERVER['PHP_SELF'])) {
    die ("You cannot open this page directly");
}

/********************************************************
 * Ajout d'une map générale
 */
if ($op == "add") {

    /*** verification securite ***/
    if ($grade['a'] != 'a' && $grade['b'] != 'b' && $grade['t'] != 't' && $grade['u'] != 'u') {
        js_goto($PHP_SELF);
    }

    $str = '';
    $erreur = 0;

    if (!$nom) {
        $erreur = 1;
        $str .= "- " . $strElementsNomInvalide . "<br>";
    }
    if (!$jeux) {
        $erreur = 1;
        $str .= "- " . $strElementsJeuxInvalide . "<br>";
    }

    if ($erreur == 1) {
        show_erreur_saisie($str);
    } else {

        $db->insert("${dbprefix}maps (nom, jeux)");
        $db->values("'$nom',$jeux");
        $db->exec();

        /*** redirection ***/
        js_goto("?page=maps");
    }
} /********************************************************
 * Suppression d'une map
 */
elseif ($op == "delete") {

    /*** verification securite ***/
    if ($grade['a'] != 'a' && $grade['b'] != 'b' && $grade['t'] != 't' && $grade['u'] != 'u') {
        js_goto($PHP_SELF);
    }


    $db->delete("${dbprefix}maps");
    $db->where("id = '$id'");
    $db->exec();

    /*** redirection ***/
    js_goto("?page=maps");
} /********************************************************
 * Liste des map pour une fenetre
 */
elseif ($op == "list") {

    $db->select("DISTINCT ${dbprefix}maps.nom");
    $db->from("${dbprefix}maps, ${dbprefix}tournois");
    $db->where("${dbprefix}maps.jeux = ${dbprefix}tournois.jeux");
    //$db->where("${dbprefix}tournois.id = $s_tournois");
    $res1 = $db->exec();

    echo '<table><tr><td>';
    echo "<form>";
    echo "<select name=nom>";
    while ($maps = $db->fetch($res1)) {
        echo "<option value='$maps->nom'>$maps->nom";
    }
    echo "</select>";
    echo "<input type=button value=\"$strValider\" onclick=select_map(this.form.nom.value,'form','$input')>";

    echo "<table cellspacing=0 cellpadding=0 border=0>";
    echo "<tr><td height=8><img src=images/spacer.gif></td></tr>";
    echo "</table>";

    $db->select("${dbprefix}maps.nom");
    $db->from("${dbprefix}maps, ${dbprefix}tournois");
    $db->where("${dbprefix}maps.jeux = ${dbprefix}tournois.jeux");
    //$db->where("${dbprefix}tournois.id = $s_tournois");
    $db->order_by("rand()");
    $res1 = $db->exec();
    $maps = $db->fetch($res1);
    echo "<input type=hidden name=pif value='$maps->nom'>";
    echo "<input type=button value=\"$strChoisirAuHasard\" onclick=select_map(this.form.pif.value,'form','$input')>";
    echo '</td></tr></form></table>';
} /********************************************************
 * Affichage admin
 */
else {

    /*** verification securite ***/
    if ($grade['a'] != 'a' && $grade['b'] != 'b' && $grade['t'] != 't' && $grade['u'] != 'u') {
        js_goto($PHP_SELF);
    }


    echo "<p class=title>.:: $strAdminMaps ::.</p>";

    echo "<table cellspacing=0 cellpadding=0 border=0>";
    echo "<tr><td class=title>" . nb_maps() . " $strMaps</td></tr>";
    echo "</table>";

    $db->select("${dbprefix}maps.id, ${dbprefix}maps.nom,sigle,icone");
    $db->from("${dbprefix}maps, ${dbprefix}jeux");
    $db->where("${dbprefix}maps.jeux=" . "${dbprefix}jeux.id");
    $db->order_by("sigle," . "${dbprefix}maps.nom");
    $maps = $db->exec();

    /** reinit des colonne a 1 ***/
    if ($db->num_rows($maps) < $config['col_maps'])
        $config['col_maps'] = 1;

    if ($db->num_rows($maps) != 0) {
        $i = 0;
        while ($map = $db->fetch($maps)) {
            $tab_maps[$i] = $map;
            $i++;
        }

        echo "<table cellspacing=0 cellpadding=0 border=0 class=liste><tr valign=top>";

        for ($i = 0; $i < $config['col_maps']; $i++) {
            echo "<td>";
            echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
            echo "<table cellspacing=1 cellpadding=2 border=0>";
            echo "<tr><td class=headerliste>$strJeu</td><td class=headerliste>$strNom</td></tr>";

            for ($j = $i; $j < count($tab_maps); $j = $j + $config['col_maps']) {
                echo "<tr>";
                echo "<td class=textliste>";
                if ($tab_maps[$j]->icone) echo "<img src=\"images/jeux/" . $tab_maps[$j]->icone . "\" align=absmiddle> ";
                echo $tab_maps[$j]->sigle . "</td>";
                echo "<td class=textliste>";
                echo "<div style=\"clear: both\"><div style=\"float: left\">" . $tab_maps[$j]->nom . "</div>";
                echo "<div style=\"float: right\">&nbsp;<a href=?page=maps&op=delete&id=" . $tab_maps[$j]->id . " onclick=\"return confirm('$strConfirmEffacerMap');\">[$strS]</a></div>";
                echo "</div></td></tr>";
            }
            echo "</table>";
            echo "</td></tr></table>";
            echo "</td>";
        }
        echo "</tr></table>";
    }

    /*** ajout d'une map ***/
    echo "<form method=post action=?page=maps&op=add>";
    echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
    echo "<table cellspacing=1 cellpadding=0 border=0>";
    echo "<tr><td class=headerfiche colspan=2>$strAjouterMap</td></tr>";
    echo "<tr><td>";
    echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
    echo "<tr><td class=titlefiche>$strNom <font color=red><b>*</b></font> :</td><td class=textfiche><input type=text name=nom></td>";
    echo "<tr><td class=titlefiche>$strJeu <font color=red><b>*</b></font> :</td><td class=textfiche><select name=jeux>";
    $db->select("id, sigle");
    $db->from("${dbprefix}jeux");
    $db->order_by("sigle");
    $db->exec();
    while ($jeux = $db->fetch()) {
        echo "<option value=$jeux->id>$jeux->sigle";
    }
    echo "</select></td></tr>";

    echo "<tr><td class=footerfiche colspan=2 align=center><input type=submit value=\"$strAjouter\"></td></tr>";
    echo "</table>";
    echo "</td></tr></table>";
    echo "</td></tr></table>";
    echo "</form>";

    echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";
}

?>

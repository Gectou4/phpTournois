<?php
/*
   +---------------------------------------------------------------------+
   | page : shoutbox                                                     |
   | MOD Author : Gectou4 <Gectou4@hotmail.com>                  |
   +---------------------------------------------------------------------+
   +---------------------------------------------------------------------+
   | phpTournois                                                         |
    | phpTournoisG4 ©2005 by Gectou4 <Gectou4 Gectou4@hotmail.com>        |
   +---------------------------------------------------------------------+
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
   +---------------------------------------------------------------------|
   | Authors: Li0n  <li0n@phptournois.net>                               |
   |          RV <rv@phptournois.net>                                    |
   |          Gougou                                                     |
   +---------------------------------------------------------------------+
*/
/********************************************************
 * Sécurité
 */

include("kernel.php");
/********************************************************
 * global
 */
global $config, $s_joueur, $s_theme, $db, $dbprefix, $db, $dbprefix, $strAjouter, $s_theme, $grade;

?>
<link rel="stylesheet" type="text/css" href="themes/<?php echo $s_theme; ?>/styles.css"><?php


/********************************************************
 * Ajout d'un commentaire
 */

if ($op == "addshout") {

    /*** verification securite ***/
    if ($s_joueur == "" || $s_joueur == NULL) js_goto('?page=login');


    if (!$contenu) {
        js_goto("?page=index");
    }

    $date = time();
    $contenu = remove_XSS($contenu);
    $pseudo = nom_joueur($s_joueur);
    $sqladd = "INSERT INTO ${dbprefix}shoutbox(id,pseudo,date,contenu) Values(null,'$pseudo','$date','$contenu')";
    $reqadd = $db->query($sqladd);

    var_dump($reqadd);

    if ($a == "o") {
        js_goto("?page=shoutbox&op=archive");
    } else {
        js_goto("?page=index");
    }


}

/********************************************************
 * Del d'un commentaire
 */
if ($op == "del") {

    /*** verification securite ***/
    if ($grade['a'] != 'a' && $grade['b'] != 'b' && $grade['m'] != 'm') {
        js_goto($PHP_SELF);
    }

    $sqldel = "DELETE FROM `${dbprefix}shoutbox` WHERE id='$id'";
    $reqdel = $db->query($sqldel)   ;

    //if ($a=="o") {js_goto("?page=shoutbox&op=archive");}
    //else {js_goto("?page=$oldpage&op=$odlop&id=$oldid");}
}
/********************************************************
 * Affichage
 */


global $strArchiveshout;

echo "<table border='0' align='center' width='100%'>";

echo "<tr><td class=titlefiche align=center><center><a href='index.php?page=shoutbox&op=archive' target='_parent'><b>$strArchiveshout</b></a></center></td></tr>";


if ($s_joueur != "" && $s_joueur != NULL) {
    if ($config['shoutboxc'] != "" || $config['shoutboxc'] != NULL) {
        $shoutlimitc = $config['shoutboxc'];
    } else {
        $shoutlimitc = '';
    }

    global $strAConsignesShoutPopup;
    echo "<form method=post name=\"formu\" action=\"?page=shoutbox&op=addshout\">";
    echo "<tr>";
    echo "<td class=textfiche align=center><input type=text name=contenu size=20 maxlength='$shoutlimitc'></td>";
    echo "</tr>";
    echo "<tr><td class=footerfiche align=center><input type=submit value=\"$strAjouter\">";
    echo "</td></tr></form>";
}

if ($config['shoutlimit'] != "" || $config['shoutlimit'] != NULL) {
    $shoutlimit = $config['shoutlimit'];
} else {
    $shoutlimit = 15;
}
$sqlx = "SELECT * FROM ${dbprefix}shoutbox ORDER BY id DESC LIMIT 0,$shoutlimit";
$reqx = $db->query($sqlx);


$i2 = '1';
while ($datax = $db->fetch_array($reqx)) {
    $contenu = $datax['contenu'];

    if (!preg_match("#^(http\\:\\/\\/[a-z0-9\-]+\.([a-z0-9\-]+\.)?[a-z]+)#i", $contenu)) {
        if (!preg_match('#\[url=(http://)?(.*?)\](.*?)\[/url\]#si', $contenu)) {
            if (!preg_match('#\[url\](http://)?(.*?)\[/url\]#si', $contenu)) {
                $contenu = wordwrap($contenu, 25, "\n", 1);
            }
        }
    }
    $contenu = BBcode($contenu);
    $contenu = stripslashes($contenu);
    $date = strftime("%H:%M", $datax['date']);

    if ($i2 == "1") {
        echo "<tr>";
        echo "<td class=shoutfiche>";

        if ($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['m'] == 'm') {
            echo "<a href=\"index.php?page=shoutbox&op=del&id=" . $datax['id'] . "\" target='_parent'><img src='images/f.gif' border='0' align=RIGHT /></a>";
        }

        echo "($date) <a href=\"index.php?page=joueurs&id=" . id_joueur($datax['pseudo']) . "\" target='_parent'><b><font class=shoutpseudo>" . $datax['pseudo'] . "</font></b></a> :<br>$contenu</td>";
        echo "</tr>";
        $i2++;
    } else if ($i2 == "2") {
        echo "<tr>";
        echo "<td class=shout2fiche>";

        if ($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['m'] == 'm') {
            echo "<a href=\"index.php?page=shoutbox&op=del&id=" . $datax['id'] . "\" target='_parent'><img src='images/f.gif' border='0' align=RIGHT /></a>";
        }

        echo "($date) <a href=\"index.php?page=joueurs&id=" . id_joueur($datax['pseudo']) . "\" target='_parent'><b><font class=shoutpseudo>" . $datax['pseudo'] . "</font></b></a> :<br>$contenu</td>";

        $i2 = "1";
        echo "</tr>";
    }
}

/********************************************************
 * Es-tu joueur ?
 */


echo "</table></body>";


?>

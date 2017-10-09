<?php
/*
   +---------------------------------------------------------------------+
   | phpTournois                                                         |
   +---------------------------------------------------------------------+
   +---------------------------------------------------------------------+
   | phpTournoisG4 �2005 by Gectou4 <Gectou4 Gectou4@hotmail.com>        |
   +---------------------------------------------------------------------+
         This version is based on phpTournois 3.5 realased by :
   +---------------------------------------------------------------------+
   | phpTournoisG4 �2004 by Gectou4 <le_gardien_prime@hotmail.com>       |
   +---------------------------------------------------------------------+
         This version is based on phpTournois 3.5 realased by :
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
   +---------------------------------------------------------------------+
   | Authors: Li0n  <li0n@phptournois.net>                               |
   |          RV <rv@phptournois.net>                                    |
   |          Gougou                                                     |
   +---------------------------------------------------------------------+
*/
if (preg_match("/login.php/i", $_SERVER['PHP_SELF'])) {
    die ("You cannot open this page directly");
}

/********************************************************
 * Connexion
 */
if ($op == "login") {
    js_goto("?page=index");
} /********************************************************
 * Deconnexion
 */
elseif ($op == "logout") {
    js_goto("?page=index");

} /********************************************************
 * Formulaire de connexion
 */
else {

    echo "<p class=title>.:: $strConnexion ::.</p>";

    if (isset($erreur)) echo "<span class=warning>$strErreurLogin</span>";

    if (isset($_COOKIE['data'])) {
        $data_info = $_COOKIE['data'];
        $data_info = base64_decode($data_info);
        $user_data = explode('|', $data_info);
        $checked = 'checked';
    } else {
        $user_data = array('', '');
        $checked = '';
    }

    /*** formulaire ***/
    echo "<form method=post>";
    echo "<input type=hidden name=op value=login>";

    echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
    echo "<table cellspacing=1 cellpadding=0 border=0>";
    echo "<tr><td class=headerfiche>$strLogin</td></tr>";
    echo "<tr><td>";

    echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
    echo "<tr>";
    echo "<td class=titlefiche>$strPseudo : </td>";
    echo "<td class=text><input type=text name=pseudo value=\"$user_data[0]\" size=20></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche>$strPassword :</td>";
    echo "<td class=text><input type=password name=passwd value=\"$user_data[1]\" size=20></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=text colspan=2 align=center><input type=checkbox name=remember size=10 value=1 $checked style=\"border: 0px;background-color:transparent;\"><small>$strSeRappeler</small></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=footerfiche align=center colspan=2><input type=submit value=\"$strConnecter\"></td>";
    echo "</tr>";
    echo "</table>";

    echo "</td></tr></table>";
    echo "</td></tr></table>";
    echo "</form>";

    if ($config['inscription_joueur']) {
        $nbinscrits = nb_joueurs_inscrit();
        $nbplaces = $config['places'];

        if ($nbinscrits < $nbplaces)
            echo "<a href=\"?page=joueurs&op=inscription\"  class=action><b><font color=\"red\">$strSInscrire</font></b></a><br>";
    }
    echo '<a href="?page=joueurs&op=envoi_passwd" class="action">' . $strOubliPass . '</a>';

    echo "<br><br><img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";

}

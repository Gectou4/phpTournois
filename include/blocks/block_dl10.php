<?php
/*
   +---------------------------------------------------------------------+
   |  phpTournois ADDON - module : Top 10 download                       |
   +---------------------------------------------------------------------+
   +---------------------------------------------------------------------+
   | phpTournois                                                         |
   +---------------------------------------------------------------------+
  | phpTournoisG4 �2005 by Gectou4 <Gectou4 Gectou4@hotmail.com>        |
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
   +---------------------------------------------------------------------+
   | Page Author : Gectou4  <lle_gardien_prime@hotmail.com>              |
   +---------------------------------------------------------------------+
*/
if (preg_match("/block_dl10.php/i", $_SERVER['PHP_SELF'])) {
    die ("You cannot open this page directly");
}
//HTML EDITED


theme_openblock("<img src=\"themes/$s_theme/images/load.gif\" align=\"absmiddle\" alt=\":)\"> $strTop10dl");

global $db, $dbprefix, $s_theme;

if (!isset($start) || !is_numeric($start)) $start = 0;

$db->select("*");
$db->from("${dbprefix}download");
$nb_maxx = 10;
$db->order_by("hits DESC LIMIT 10");
$res = $db->exec();

if ($db->num_rows($res) == 0) {
    echo "<ul><li class=\"lib\">Pas de Download</ul><br />";
} else {
    echo "<ul>";
    while ($dl = $db->fetch($res)) {
        $dl->name = stripslashes($dl->nom);
        $max = 17;
        if (strlen($dl->name) >= $max) {
            $dl->name = substr($dl->name, 0, $max);
            $espace = strrpos($dl->name, " ");
            $dl->name = substr($dl->name, 0, $espace) . "...";
        }


        echo "<li class=\"lib\"><a href=\"" . $dl->url . "\">" . $dl->name . "</a><br />";

    }
}
echo "</ul>";

theme_closeblock();
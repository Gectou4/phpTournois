<?php
/*
  +---------------------------------------------------------------------+
  |  phpTournois ADDON - module : last 10 news                          |
  +---------------------------------------------------------------------+
  +---------------------------------------------------------------------+
  | phpTournois                                                         |
    | phpTournoisG4 �2005 by Gectou4 <Gectou4 Gectou4@hotmail.com>        |
  +---------------------------------------------------------------------+
  | Copyright� 2001-2004 Li0n, RV, Gougou (http://www.phptournois.net)|
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
  | Page Author : Gectou4  <Gectou4@hotmail.com>              |
  +---------------------------------------------------------------------+
*/

if (preg_match("/block_10news.php/i", $_SERVER['PHP_SELF'])) {
    die ("You cannot open this page directly");
}


theme_openblock("<img src=\"themes/$s_theme/images/news.gif\" align=\"absmiddle\" alt=\":)\"> $strNews");

global $db, $dbprefix, $s_theme;

if (empty($id)) {

    if (!isset($start) || !is_numeric($start)) $start = 0;


    $db->select("*");
    $db->from("${dbprefix}news");
    $nb_maxx = 10;
    $db->order_by("id DESC LIMIT 10");
    $res = $db->exec();

    if ($db->num_rows($res) == 0) {
        echo "<li class=\"lib\">Pas de news...<br>";
    } else {

        while ($news = $db->fetch($res)) {

            $news->titre = stripslashes($news->titre);
            $max = 17;
            if (strlen($news->titre) >= $max) {
                $news->titre = substr($news->titre, 0, $max);
                $espace = strrpos($news->titre, " ");
                $news->titre = substr($news->titre, 0, $espace) . "...";
            }
            echo "<li class=\"lib\"><a href=\"?page=news&id=" . $news->id . "\">" . $news->titre . "</a><br>";

        }
    }
}


theme_closeblock();

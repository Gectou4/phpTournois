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


if (preg_match("/block_10news_header.php/i", $_SERVER['PHP_SELF'])) {
    die ("You cannot open this page directly");
}
// HTML EDITED 


global $db, $dbprefix, $s_theme, $strNonewsnow, $strlastnews5, $strPasDeNews;

theme_openblock_lastresult("<img src=\"themes/$s_theme/images/icon_resultats.gif\" align=\"absmiddle\" alt=\"enligne\"> $strlastnews5");
echo '<table cellspacing="0" cellpadding="0" border="0" width="100%">';

if (!isset($start) || !is_numeric($start)) $start = 0;


$db->select("*");
$db->from("${dbprefix}news");
$db->order_by("id DESC LIMIT 5");
$res = $db->exec();

if ($db->num_rows($res) != 0) {

    $design_lastnews = '1';
    $design_lastnews_test = '0';
    while ($news = $db->fetch($res)) {

        $news->titre = stripslashes($news->titre);
        $max = 35;
        if (strlen($news->titre) >= $max) {
            $news->titre = substr($news->titre, 0, $max);
            $espace = strrpos($news->titre, " ");
            $news->titre = substr($news->titre, 0, $espace) . "...";
        }

        if ($design_lastnews == '1') {
            echo '<tr><td align="center" style="width:100%;height:20px;text-align:center;" class="lastnewsheader_a">&nbsp<a href="?page=news&amp;id=' . $news->id . '">' . $news->titre . '</a></td></tr>';
            $design_lastnews = 2;
            $design_lastnews_test++;
        } else if ($design_lastnews == '2') {
            echo '<tr><td align="center" style="width:100%;height:20px;text-align:center;" class="lastnewsheader_b">&nbsp<a href="?page=news&amp;id=' . $news->id . '">' . $news->titre . '</a></td></tr>';
            $design_lastnews = 1;
            $design_lastnews_test++;
        }


    }
    if ($design_lastnews_test == '1') {
        echo "<tr><td align=\"center\"  style=\"width:100%;height:20px;text-align:center;\" class='lastnewsheader_b'>&nbsp;" . $strNonewsnow . "</td></tr>";
        echo "<tr><td align=\"center\"  style=\"width:100%;height:20px;text-align:center;\" class='lastnewsheader_a'>&nbsp;" . $strNonewsnow . "</td></tr>";
        echo "<tr><td align=\"center\"  style=\"width:100%;height:20px;text-align:center;\" class='lastnewsheader_b'>&nbsp;" . $strNonewsnow . "</td></tr>";
        echo "<tr><td align=\"center\"  style=\"width:100%;height:20px;text-align:center;\" class='lastnewsheader_a'>&nbsp;" . $strNonewsnow . "</td></tr>";
    } else if ($design_lastnews_test == '2') {
        echo "<tr><td align=\"center\"  style=\"width:100%;height:20px;text-align:center;\" class='lastnewsheader_a'>&nbsp;" . $strNonewsnow . "</td></tr>";
        echo "<tr><td align=\"center\"  style=\"width:100%;height:20px;text-align:center;\" class='lastnewsheader_b'>&nbsp;" . $strNonewsnow . "</td></tr>";
        echo "<tr><td align=\"center\"  style=\"width:100%;height:20px;text-align:center;\" class='lastnewsheader_a'>&nbsp;" . $strNonewsnow . "</td></tr>";
    } else if ($design_lastnews_test == '3') {
        echo "<tr><td align=\"center\"  style=\"width:100%;height:20px;text-align:center;\" class='lastnewsheader_b'>&nbsp;" . $strNonewsnow . "</td></tr>";
        echo "<tr><td align=\"center\"  style=\"width:100%;height:20px;text-align:center;\" class='lastnewsheader_a'>&nbsp;" . $strNonewsnow . "</td></tr>";
    } else if ($design_lastnews_test == '4') {
        echo "<tr><td align=\"center\"  style=\"width:100%;height:20px;text-align:center;\" class='lastnewsheader_a'>&nbsp;" . $strNonewsnow . "</td></tr>";
    }
    echo '</table>';
} else {
    echo '<table cellspascing="0" cellpadding="0" border="0" width="100%">';
    echo "<tr><td align=\"center\"  style=\"width:100%;height:20px;text-align:center;\" class='lastnewsheader_a'>&nbsp;" . $strPasDeNews . "</td></tr>";
    echo "<tr><td align=\"center\"  style=\"width:100%;height:20px;text-align:center;\" class='lastnewsheader_b'>&nbsp;" . $strNonewsnow . "</td></tr>";
    echo "<tr><td align=\"center\"  style=\"width:100%;height:20px;text-align:center;\" class='lastnewsheader_a'>&nbsp;" . $strNonewsnow . "</td></tr>";
    echo "<tr><td align=\"center\"  style=\"width:100%;height:20px;text-align:center;\" class='lastnewsheader_b'>&nbsp;" . $strNonewsnow . "</td></tr>";
    echo "<tr><td align=\"center\"  style=\"width:100%;height:20px;text-align:center;\" class='lastnewsheader_a'>&nbsp;" . $strNonewsnow . "</td></tr>";

    echo '</table>';
}


theme_closeblock_lastresult();


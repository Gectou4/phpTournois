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

if (preg_match("/block_sponsors.php/i", $_SERVER['PHP_SELF'])) {
    die ("You cannot open this page directly");
}

global $db, $dbprefix, $config, $s_joueur, $s_theme, $strSponsors;


if ($config['sponsors'] && nb_sponsors() != 0) {

    theme_openblock("<img src=\"themes/$s_theme/images/icon_sponsors.gif\" align=\"absmiddle\" alt=\"sponsors\"> $strSponsors");

    echo '<div align="center"><marquee onmouseout="this.start()" onmouseover="this.stop()" width="110" scrolldelay="40" scrollamount="1" height="160" direction="up" behavior="scroll">';

    $db->select("*");
    $db->from("${dbprefix}sponsors");
    $db->order_by("rang");
    $sponsors = $db->exec();

    if ($db->num_rows($sponsors) != 0) {

        while ($sponsor = $db->fetch($sponsors)) {

            list($width, $height, $type, $attr) = @getimagesize("images/sponsors/$sponsor->image");
            if ($width > 100) $width = "width=100";
            else $width = '';

            echo "<a href=\"?page=sponsors&amp;id=$sponsor->id\"><img border=\"0\" title=\"$sponsor->nom\" $width src=\"images/sponsors/$sponsor->image\" alt=\"\"></a><br /><br />";
        }
    }
    echo '</marquee></div>';

    theme_closeblock();
}

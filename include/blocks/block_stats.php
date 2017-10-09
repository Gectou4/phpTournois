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

if (preg_match("/block_stats.php/i", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}

global $config,$s_joueur,$s_theme;
global $strStatistiques,$strJoueurs,$strInscrits,$strTournois,$strNews,$strLiens,$strDownloads,$strPagesVues;
global $compteur;

theme_openblock("<img src=\"themes/$s_theme/images/icon_stats.gif\" align=\"absmiddle\" alt=\"stats\"> $strStatistiques");

$nbnews=nb_news();
$nbdownloads=nb_downloads();
$nbliens=nb_liens();
$nbjoueurs=nb_joueurs();
$nbplaces=$config['places'];
$nbinscrits=nb_joueurs_inscrit();
$nbequipes=nb_equipes();
$nbtournois=nb_tournois();

echo "<dl><li class=\"lib\">$strJoueurs : $nbjoueurs</li>";
echo "<li class=\"lib\">$strInscrits : $nbinscrits/$nbplaces</li>";
affiche_bar($nbinscrits,$nbplaces,100);
echo "<li class=\"lib\">$strTournois : $nbtournois</li>";
echo "<li class=\"lib\">$strEquipes : $nbequipes</li>";
if($config['news']) echo "<li class=\"lib\">$strNews : $nbnews</li>";
if($config['liens']) echo "<li class=\"lib\">$strLiens : $nbliens</li>";
if($config['download']) echo "<li class=\"lib\">$strDownloads : $nbdownloads</li></dl>";
echo "<hr width=\"95%\">";
echo '<table><tr><td class="textmenu" style="white-space: normal">';
echo "<div align=\"center\">$strPagesVues: <span style=\"font-weight:bold\">".$compteur['pages vues']."</span></div>";
echo '</td></tr></table>';

theme_closeblock();

?>

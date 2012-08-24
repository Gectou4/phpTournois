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

if (eregi("block_menu.php", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}
//HTML EDITED
global $config,$s_theme,$s_joueur,$mods,$grade;
global $strGeneral,$strAccueil,$strPlanSalle,$strNews,$strInscriptions,$strAc_cmdmenu,$custheme,$strPresentation,$strReglement,$strJoueurs,$strEquipes,$strTournois,$strServeurs,$strSponsors,$strPartenaires,$strForum,$strIrc,$strDownloads,$strLiens,$strLivreDor,$strContact,$strSInscrire,$strLadder,$strGalerie;

theme_openblock("<img src=\"themes/$s_theme/images/icon_menu.gif\" align=\"absmiddle\" alt=\"menu\"> $strGeneral");

echo '<table width="100%">';
echo '<tr><td class="blockjtab"><div><dl>';
echo "<li class=\"lib\"><a href=\"?page=accueil\">$strAccueil</a></li>";
if($config['news'])echo "<li class=\"lib\"><a href=\"?page=news\"><span style\"text-weight:bold\">$strNews</span></a></li>";
if($config['forum']) echo "<li class=\"lib\"><a href=\"?page=forum/\">$strForum</a></li>";
if($config['inscription_joueur'] && !$s_joueur) {
	$nbinscrits=nb_joueurs_inscrit();
	$nbplaces=$config['places'];

	if($nbinscrits < $nbplaces) 
		echo "<li class=\"lir\"><a href=\"?page=joueurs&amp;op=inscription\"><span style\"color:red;text-weight:bold\">$strSInscrire</span></a></li>";
		}
if($config['information']) echo "<li class=\"lib\"><a href=\"?page=informations\">$strPresentation</a></li>";
if($config['reglement']) echo "<li class=\"lib\"><a href=\"?page=reglements\">$strReglement</a></li>";
echo "<li class=\"lib\"><a href=\"?page=joueurs\">$strJoueurs</a></li>";;
echo "<li class=\"lib\"><a href=\"?page=equipes\">$strEquipes</a></li>";
echo "<li class=\"lib\"><a href=\"?page=tournois\">$strTournois</a></li>";;
if($config['ladder']) echo "<li class=\"lib\"><a href=\"?page=ladder&amp;op=list_lad\">$strLadder</a></li>";
if($mods['plan']&&$config['phpt_type']=='lan') echo "<li class=\"lib\"><a href=\"?page=plan\">$strPlanSalle</a></li>";
if($config['serveur']) echo "<li class=\"lib\"><a href=\"?page=serveurs\">$strServeurs</a></li>";
if($config['commande'])echo "<li class=\"lib\"><a href=\"?page=article\">$strAc_cmdmenu</a></li>";
if($config['sponsors']) echo "<li class=\"lib\"><a href=\"?page=sponsors\">$strSponsors</a></li>";
if($config['partenaires']) echo "<li class=\"lib\"><a href=\"?page=partenaires\">$strPartenaires</a></li>";
if($config['galerie']) echo "<li class=\"lib\"><a href=\"?page=galerie\">$strGalerie</a></li>";
if($config['irc']) echo "<li class=\"lib\"><a href=\"?page=irc\">$strIrc</a></li>";
if($config['download']) echo "<li class=\"lib\"><a href=\"?page=download\">$strDownloads</a></li>";
if($config['liens']) echo "<li class=\"lib\"><a href=\"?page=liens\">$strLiens</a></li>";
if($config['livredor']) echo "<li class=\"lib\"><a href=\"?page=livredor\">$strLivreDor</a></li>";
if($config['contact']) echo "<li class=\"lib\"><a href=\"?page=contact\">$strContact</a></li>";
if($config['faq']) echo "<li class=\"lib\"><a href=\"?page=faq\"><span style\"color:green;text-weight:bold\">FAQ</span></a></li>";
if($grade['o']=='o'||$grade['a']=='a'||$grade['b']=='b') {echo "<li class=\"lir\"><a href=\"?page=admincp&amp;op=admin\"><span style\"color:red;text-weight:bold\">Admin Panel</span></a></li>";}
echo '</dl></div></td></tr>';
echo '</table>';
/*
$txtcol='0xFF0000'; //couleur de base  /!\ tjs mettre 0x au d&eacute;but puis le code en hexa le 0x remplace le #
$txtcol2='0x00FF00'; //couleur au survol
$bgcol='#FFFFFF'; //couleur du fond (couleur normal en html)
$urlva='?page=news'; //url du lien
$txte='test'; //text 
$parse = '?txtcol='.$txtcol.'&txtcol2='.$txtcol2.'&urlva='.$urlva.'&txte='.$txte.'';

print ('
<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
 codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"
 WIDTH="100" HEIGHT="20" id="lob" ALIGN="">
 <PARAM NAME=movie VALUE="themes/phptournois/test.swf'.$parse.'&chaine2=30"> <PARAM NAME=quality VALUE=high> <PARAM NAME=bgcolor VALUE='.$bgcol.'> <EMBED src="themes/phptournois/lob.swf" quality=high bgcolor=#FFFFFF  WIDTH="600" HEIGHT="400" NAME="lob" ALIGN=""
 TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED>
</OBJECT>');
*/
if($mods['customtheme']){
echo "<form name=\"formgg\" method=\"post\" action=\"?page=skin\"><p align=\"center\">$custheme<br /><select name=\"theme\">";
	$fd = opendir("themes/");
	while($file = readdir($fd)) {
		if ($file != "." && $file != ".." && is_dir("themes/$file") && file_exists("themes/$file/theme.php")) {
			echo "<option value=\"$file\"";
			if ($file == $configuration->default_theme) echo " selected=\"selected\"";
			echo ">$file";
		}
	}
	closedir($fd);
	echo "</select><input type=\"submit\" name=\"Submit\" value=\"";
	echo "OK";
	echo "\"></P></form>";
}

theme_closeblock();
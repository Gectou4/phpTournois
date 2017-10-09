<?php
/* 
   +---------------------------------------------------------------------+ 
   | phpTournois                                                         | 
   +---------------------------------------------------------------------+ 
   +---------------------------------------------------------------------+ 
  | phpTournoisG4 ?2005 by Gectou4 <Gectou4 Gectou4@hotmail.com>        | 
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
/*** verification securite ***/
if (preg_match("/admincp.php/i", $_SERVER['PHP_SELF'])) {
    die ("You cannot open this page directly");
}

if ($grade['a'] != 'a' && $grade['b'] != 'b' && $grade['o'] != 'o') {
    js_goto($PHP_SELF);
}

/********************************************************
 * Modification des notes
 */
if ($op == "up") {

    $str = '';
    $erreur = 0;

    if ($erreur == 1) {
        show_erreur_saisie($str);
    } else {

        $db->update("${dbprefix}mods");
        $db->set("admin='$admin'");
        $db->exec();
        $op = "admin";
    }

}
/********************************************************
 * Affichage admin
 */
if ($op == "admin") {

    echo "<table border=0 cellpadding=0 width='70%' cellspacing=0 class=bordure1><tr><td>";
    echo "<table cellspacing=1 cellpadding=0 border=0 width='100%'>";
    echo "<tr><td class=modsfiche>&nbsp;&nbsp;&nbsp; $strADMINPANEL &nbsp;&nbsp;&nbsp;</td></tr>";
    echo "<tr><td>";
    echo "<table cellspacing=0 cellpadding=2 border=0 width=100%>";

    echo "<tr><td width='5' class=textfichemods2>&nbsp;</td>";

    if (($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['n'] == 'n') && $config['news'] == 1) {
        echo " <td class=textfichemods2><a href=\"?page=news&op=admin&ad=wr\"><img src='images/G4/reading.gif' border='0' /><br><b>$strNews</b></a></td>";
    } else {
        echo " <td class=textfichemods2><img src='images/G4/reading_s.gif' border='0' /><br><b>$strNews</b></td>";
    }

    if ($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['j'] == 'j') {
        echo "<td class=textfichemods2><a href=\"?page=joueurs&op=admin\"><img src='images/G4/marine_s.gif' border='0' /><br><b>$strJoueurs</b></a></td>";
    } else {
        echo "<td class=textfichemods2><img src='images/G4/marine_s_s.gif' border='0' /><br><b>$strJoueurs</b></td>";
    }

    if ($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['t'] == 't') {
        echo "<td class=textfichemods2><a href=\"?page=tournois&op=admin\"><img src='images/G4/asc.gif' border='0' /><br><b>$strTournois</b></a></td>";
    } else {
        echo "<td class=textfichemods2><img src='images/G4/asc_s.gif' border='0' /><br><b>$strTournois</b></td>";
    }

    if (($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['r'] == 'r') && $config['serveur'] == 1) {
        echo "<td class=textfichemods2><a href=\"?page=serveurs&op=admin\"><img src='images/G4/tfact.gif' border='0' /><br><b>$strServeurs</b></a></td>";
    } else {
        echo "<td class=textfichemods2><img src='images/G4/tfact_s.gif' border='0' /><br><b>$strServeurs</b></td>";
    }

    if ($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['t'] == 't' || $grade['u'] == 'u') {
        echo "<td class=textfichemods2><a href=\"?page=jeux&op=admin\"><img src='images/G4/upgrades_s.gif' border='0' /><br><b>$strJeux</b></a></td>";
    } else {
        echo "<td class=textfichemods2><img src='images/G4/upgrades_s_s.gif' border='0' /><br><b>$strJeux</b></td>";
    }

    echo "<td width='5' class=textfichemods2>&nbsp;</td></tr>";


    echo "<tr><td width='5' class=textfichemods2>&nbsp;</td>";

    if (($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['f'] == 'f') && $config['faq'] == 1) {
        echo "<td class=textfichemods2><a href=\"?page=faq&op=admin\"><img src='images/G4/heavya.gif' border='0' /><br><b>FAQ</b></a></td>";
    } else {
        echo "<td class=textfichemods2><img src='images/G4/heavya_s.gif' border='0' /><br><b>FAQ</b></td>";
    }

    if ($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['e'] == 'e') {
        echo "<td class=textfichemods2><a href=\"?page=equipes&op=admin\"><img src='images/G4/victory_s.gif' border='0' /><br><b>$strEquipes</b></a></td>";
    } else {
        echo "<td class=textfichemods2><img src='images/G4/victory_s_s.gif' border='0' /><br><b>$strEquipes</b></td>";
    }
    if (($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['u'] == 'u') && $config['ladder'] == 1) {
        echo "<td class=textfichemods2><a href=\"?page=ladder&op=add_lad&ad=ad\"><img src='images/G4/knife.gif' border='0' /><br><b>$strLadder</b></a></td>";
    } else {
        echo "<td class=textfichemods2><img src='images/G4/knife_s.gif' border='0' /><br><b>$strLadder</b></td>";
    }

    if (($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['k'] == 'k') && $config['phpt_type'] != 'online') {
        echo "<td class=textfichemods2><a href=\"?page=plan&op=admin\"><img src='images/G4/motiont.gif' border='0' /><br><b>$strPlanSalle</b></a></td>";
    } else {
        echo "<td class=textfichemods2><img src='images/G4/motiont_s.gif' border='0' /><br><b>$strPlanSalle</b></td>";

    }

    if ($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['t'] == 't' || $grade['u'] == 'u') {
        echo "<td class=textfichemods2><a href=\"?page=maps&op=admin\"><img src='images/G4/scan.gif' border='0' /><br><b>$strMaps</b></a></td>";
    } else {
        echo "<td class=textfichemods2><img src='images/G4/scan_s.gif' border='0' /><br><b>$strMaps</b></td>";
    }

    echo "<td width='5' class=textfichemods2>&nbsp;</td></tr>";

    echo "<tr><td width='5' class=textfichemods2>&nbsp;</td>";


    if (($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['s'] == 's') && $config['sponsors'] == 1) {
        echo "<td class=textfichemods2><a href=\"?page=sponsors&op=admin\"><img src='images/G4/protolab.gif' border='0' /><br><b>$strSponsors</b></a></td>";
    } else {
        echo "<td class=textfichemods2><img src='images/G4/protolab_s.gif' border='0' /><br><b>$strSponsors</b></td>";
    }

    if (($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['d'] == 'd') && $config['download'] == 1) {
        echo "<td class=textfichemods2><a href=\"?page=download&op=admin\"><img src='images/G4/droppables_s.gif' border='0' /><br><b>$strDownloads</b></a></td>";
    } else {
        echo "<td class=textfichemods2><img src='images/G4/droppables_s_s.gif' border='0' /><br><b>$strDownloads</b></td>";
    }

    if (($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['i'] == 'i') && $config['livredor'] == 1) {
        echo "<td class=textfichemods2><a href=\"?page=livredor&op=admin\"><img src='images/G4/resources_s.gif' border='0' /><br><b>$strLivreDor</b></a></td>";
    } else {
        echo "<td class=textfichemods2><img src='images/G4/resources_s_s.gif' border='0' /><br><b>$strLivreDor</b></td>";
    }

    if ($config['aburl'] && ($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['v'] == 'v')) {
        echo "<td class=textfichemods2><a href=\"" . $config['aburl'] . "\" target=\"_blank\"><img src='images/G4/armslab.gif' border='0' /><br><b>$strABAdmin</b></a></td>";
    } else {
        echo "<td class=textfichemods2><img src='images/G4/armslab_s.gif' border='0' /><br><b>$strABAdmin</b></td>";
    }

    if (($grade['a'] == 'a' || $grade['b'] == 'b') && $config['ac_spe'] == 1) {
        echo "<td class=textfichemods2><a href=\"?page=ac_spe&op=admin\"><img src='images/G4/lightspeed.gif' border='0' /><br><b>$strAc_cmdmenu</b></a></td>";
    } else {
        echo "<td class=textfichemods2><img src='images/G4/lightspeed_s.gif' border='0' /><br><b>$strAc_cmdmenu</b></td>";
    }

    echo "<td width='5' class=textfichemods2>&nbsp;</td></tr>";

    echo "<tr><td width='5' class=textfichemods2>&nbsp;</td>";

    if (($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['p'] == 'p') && $config['partenaires'] == 1) {
        echo "<td class=textfichemods2><a href=\"?page=partenaires&op=admin\"><img src='images/G4/exoskel.gif' border='0' /><br><b>$strPartenaires</b></a></td>";
    } else {
        echo "<td class=textfichemods2><img src='images/G4/exoskel_s.gif' border='0' /><br><b>$strPartenaires</b></td>";
    }

    if (($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['h'] == 'h') && $config['liens'] == 1) {
        echo "<td class=textfichemods2><a href=\"?page=liens&op=admin\"><img src='images/G4/phase.gif' border='0' /><br><b>$strLiens</b></a></td>";
    } else {
        echo "<td class=textfichemods2><img src='images/G4/phase_s.gif' border='0' /><br><b>$strLiens</b></td>";
    }

    if (($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['l'] == 'l') && $config['phpt_type'] != 'lan' && $config['mailing'] == 1) {
        echo "<td class=textfichemods2><a href=\"?page=mailing&op=admin\"><img src='images/G4/nanotech_s.gif' border='0' /><br><b>$strMailing</b></a></td>";
    } else {
        echo "<td class=textfichemods2><img src='images/G4/nanotech_s_s.gif' border='0' /><br><b>$strMailing</b></td>";
    }

    if ($config['m4url'] && ($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['v'] == 'v')) {
        echo "<td class=textfichemods2><a href=\"" . $config['m4url'] . "\" target=\"_blank\"><img src='images/G4/armory.gif' border='0' /><br><b>$strM4Admin</b></a></td>";
    } else {
        echo "<td class=textfichemods2><img src='images/G4/armory_s.gif' border='0' /><br><b>$strM4Admin</b></td>";
    }

    if ($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['c'] == 'c') {
        echo "<td class=textfichemods2><a href=\"?page=mods&op=pcmods\"><img src='images/G4/pics_cc.gif' border='0' /><br><b>$strMod</b></a></td>";
    } else {
        echo "<td class=textfichemods2><img src='images/G4/pics_cc_s.gif' border='0' /><br><b>$strMod</b></td>";
    }

    echo "<td width='5' class=textfichemods2>&nbsp;</td></tr>";

    echo "<tr><td width='5' class=textfichemods2>&nbsp;</td>";

    if (($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['g'] == 'g') && ($config['phpt_type'] == 'all' || $config['phpt_type'] == 'online')) {
        echo "<td class=textfichemods2><a href=\"?page=menu&op=add\"><img src='images/G4/observ.gif' border='0' /><br><b>$strAddMenu</b></a></td>";
    } else {
        echo "<td class=textfichemods2><img src='images/G4/observ_s.gif' border='0' /><br><b>$strAddMenu</b></td>";
    }

    if (($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['g'] == 'g') && ($config['phpt_type'] == 'all' || $config['phpt_type'] == 'online')) {
        echo "<td class=textfichemods2><a href=\"?page=page&op=add\"><img src='images/G4/jetpacks.gif' border='0' /><br><b>$strAddPage</b></a></td>";
    } else {
        echo "<td class=textfichemods2><img src='images/G4/jetpacks_s.gif' border='0' /><br><b>$strAddPage</b></td>";
    }

    if (($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['g'] == 'g') && ($config['phpt_type'] == 'all' || $config['phpt_type'] == 'online')) {
        echo "<td class=textfichemods2><a href=\"?page=page&op=listm\"><img src='images/G4/welder.gif' border='0' /><br><b>$strModPage</b></a></td>";
    } else {
        echo "<td class=textfichemods2><img src='images/G4/welder_s.gif' border='0' /><br><b>$strModPage</b></a></td>";
    }

    if (($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['q'] == 'q') && $config['galerie'] == 1) {
        echo "<td class=textfichemods2><a href=\"?page=galerie&op=admin\"><img src='images/G4/armor3.gif' border='0' /><br><b>$strGalerie</b></a></td>";
    } else {
        echo "<td class=textfichemods2><img src='images/G4/armor3_s.gif' border='0' /><br><b>$strGalerie</b></td>";
    }

    if ($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['c'] == 'c') {
        echo "<td class=textfichemods2><a href=\"?page=configuration&op=admin\"><img src='images/G4/recycle.gif' border='0' /><br><b>$strConfiguration</b></a></td>";
    } else {
        echo "<td class=textfichemods2><img src='images/G4/recycle_s.gif' border='0' /><br><b>$strConfiguration</b></td>";
    }

    echo "<td width='5' class=textfichemods2>&nbsp;</td></tr>";
    echo "</table></td></tr>";

    echo "<tr><td class=modsfiche>&nbsp;</td></tr>";

    echo "</table>";
    echo "</td></tr></table>";

    echo '<small>' . $str_phpTG4_v . '</small> <img src="images/G4/phpt_v.gif" align="absmiddle" /> ';

    function url_exists($url)
    {

        $fp = @fopen($url, "r");

        return ($fp) ? 1 : 0;
    }

    if (url_exists("http://www.phptournois.net/images/G4/phpt_vo.gif") == 1) {
        echo '<small>' . $str_phpTG4_vo . '</small> <a href="http://www.phptournois.net/?page=download"><img src="http://www.phptournois.net/images/G4/phpt_vo.gif" align="absmiddle" border="0" /></a>';
    }

    echo '<form method=post action=?page=admincp&op=up> 
   <table border=0 cellpadding=0 width="70%" cellspacing=0 class=bordure1><tr><td> 
   <table cellspacing=1 cellpadding=0 border=0 width="100%"> 
   <tr><td class=modsfiche>&nbsp;&nbsp;&nbsp; ' . $strADMINNOTE . ' &nbsp;&nbsp;&nbsp;</td></tr> 
   <tr><td> 
   <table cellspacing=0 cellpadding=2 border=0 width=100%> 
   <tr><td class=partfiche align="center"><div align="center">';

    echo "<textarea cols=60 rows=10 id=admin name=admin wrap=virtual>$modsp->admin</textarea></div></td></tr>";

    echo "<tr><td class=footerfichemods colspan=2><hr><input type=submit value=\" - $strOK - \"></td></tr>";
    echo "</table></td></tr>";

    echo "<tr><td class=modsfiche>&nbsp;</td></tr>";

    echo "</table>";
    echo "</td></tr></table>";
    echo "</form>";
}


?>
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
if (preg_match("/irc.php/i", $_SERVER['PHP_SELF'])) {
    die ("You cannot open this page directly");
}

if (!$config['irc']) js_goto('?page=index');

/********************************************************
 * Applet java
 */
if ($op == "applet") {

    /*** recup des infos pour la connection ***/
    if (!empty($s_joueur)) {
        $joueur = joueur($s_joueur);
        $nick = $joueur->pseudo;
        $altnick = $joueur->nom;
        $name = "$joueur->nom $joueur->prenom";
    } elseif ($pseudo) {
        $nick = $name = $pseudo;
        $altnick = $pseudo . rand(100, 200);
    } else {
        $nick = "phptfan" . rand(0, 100);
        $altnick = "phptfan" . rand(100, 200);
        $name = "phptfan";
    }

    /*** parse des channel IRC ***/
    $channels = explode(" ", $config['ircchannels']);
    $paramchannels = '';

    for ($i = 1; $i <= count($channels); $i++) {
        $paramchannels .= "<param name=\"command$i\" value=\"/join " . $channels[$i - 1] . "\">";
    }

    echo "<p class=title>.:: $strIrc ::.</p>";
    echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1 width=800><tr><td>";

    echo "<table cellspacing=1 cellpadding=2 border=0>";
    echo "<tr><td>";

    echo "<!-- PJIRC applet begin-->";
    echo "<applet codebase=\"pjirc\" code=\"IRCApplet.class\" archive=\"irc.jar,pixx.jar\" width=800 height=400>";
    echo "<param name=\"CABINETS\" value=\"irc.cab,securedirc.cab,pixx.cab\">";
    echo "<param name=\"gui\" value=\"pixx\">";
    echo "<param name=\"nick\" value=\"$nick\">";
    echo "<param name=\"alternatenick\" value=\"$altnick\">";
    echo "<param name=\"name\" value=\"$name\">";
    echo "<param name=\"host\" value=\"$config[ircserver]\">";
    echo "<param name=\"port\" value=\"$config[ircport]\">";
    echo "<param name=\"password\" value=\"$config[ircpassword]\">";
    echo "$paramchannels";

    echo "<param name=\"language\" value=\"$s_lang\">";
    echo "<param name=\"timestamp\" value=\"true\">";
    echo "<param name=\"highlight\" value=\"true\">";
    echo "<param name=\"highlightnick\" value=\"true\">";
    echo "<param name=\"quitmessage\" value=\"phpTournois forever!\">";
    echo "<param name=\"asl\" value=\"false\">";

    echo "<param name=\"smileys\" value=\"true\">";
    echo "<param name=\"bitmapsmileys\" value=\"true\">";
    echo "<param name=\"smiley1\" value=\":) img/sourire.gif\">";
    echo "<param name=\"smiley2\" value=\":-) img/sourire.gif\">";
    echo "<param name=\"smiley3\" value=\":-D img/content.gif\">";
    echo "<param name=\"smiley4\" value=\":d img/content.gif\">";
    echo "<param name=\"smiley5\" value=\":-O img/OH-2.gif\">";
    echo "<param name=\"smiley6\" value=\":o img/OH-1.gif\">";
    echo "<param name=\"smiley7\" value=\":-P img/langue.gif\">";
    echo "<param name=\"smiley8\" value=\":p img/langue.gif\">";
    echo "<param name=\"smiley9\" value=\";-) img/clin-oeuil.gif\">";
    echo "<param name=\"smiley10\" value=\";) img/clin-oeuil.gif\">";
    echo "<param name=\"smiley11\" value=\":-( img/triste.gif\">";
    echo "<param name=\"smiley12\" value=\":( img/triste.gif\">";
    echo "<param name=\"smiley13\" value=\":-| img/OH-3.gif\">";
    echo "<param name=\"smiley14\" value=\":| img/OH-3.gif\">";
    echo "<param name=\"smiley15\" value=\":'( img/pleure.gif\">";
    echo "<param name=\"smiley16\" value=\":$ img/rouge.gif\">";
    echo "<param name=\"smiley17\" value=\":-$ img/rouge.gif\">";
    echo "<param name=\"smiley18\" value=\"(H) img/cool.gif\">";
    echo "<param name=\"smiley19\" value=\"(h) img/cool.gif\">";
    echo "<param name=\"smiley20\" value=\":-@ img/enerve1.gif\">";
    echo "<param name=\"smiley21\" value=\":@ img/enerve2.gif\">";
    echo "<param name=\"smiley22\" value=\":-S img/roll-eyes.gif\">";
    echo "<param name=\"smiley23\" value=\":s img/roll-eyes.gif\">";

    echo "<param name=\"channelfont\" value=\"12 Arial\">";
    echo "<param name=\"chanlistfont\" value=\"12 Arial\">";
    echo "<param name=\"useinfo\" value=\"false\">";
    echo "<param name=\"nickfield\" value=\"true\">";
    echo "<param name=\"styleselector\" value=\"true\">";
    echo "<param name=\"setfontonstyle\" value=\"true\">";
    echo "<param name=\"showabout\" value=\"false\">";
    echo "<param name=\"showhelp\" value=\"false\">";
    echo "<param name=\"backgroundimage\" value=\"true\">";
    echo "<param name=\"defaultbackgroundimage\" value=\"background.gif\">";
    echo "</applet>";
    echo "<!-- end of the PJIRC applet -->";

    echo "</td></tr></table>";
    echo "</td></tr></table>";

} /********************************************************
 * Affichage normal
 */
else {

    echo "<p class=title>.:: $strIrc ::.</p>";
    $channels = explode(" ", $config['ircchannels']);
    $chan = $channels[0];
    $chan = str_replace("#", '', $chan);

    $array1 = array("%serveur%", "%chans%", "%chan%");
    $array2 = array($config['ircserver'] . ':' . $config['ircport'], $config['ircchannels'], $chan);
    $strIRCMessage = str_replace($array1, $array2, $strIRCMessage);

    echo "<table cellspacing=0 cellpadding=0 border=0 width=500 align=center>";
    echo "<tr><td class=title><div align=center>$strIRCMessage</div></td></tr>";
    echo "</table><br>";

    echo "<form method=post target=_blank action=?page=irc&op=applet>";
    echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
    echo "<table cellspacing=1 cellpadding=0 border=0>";
    echo "<tr><td class=headerfiche>$strAppletPJIRC</td></tr>";
    echo "<tr><td>";
    echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
    if (empty($s_joueur)) {
        echo "<tr>";
        echo "<td class=titlefiche>$strPseudo :</td>";
        echo "<td class=textfiche><input type=text name=pseudo maxlength=20></td>";
        echo "</tr>";
    }
    echo "<tr>";
    echo "<td class=titlefiche>$strPopup :</td>";
    echo '<td class="textfiche">';
    echo '<input type="radio" name="header" value="win" checked onclick="this.form.target=\'_blank\'"> ' . $strOui;
    echo '<input type="radio" name="header" value="" onclick="this.form.target=\'_self\'">' . $strNon;
    echo '</td>';
    echo "</tr>";
    echo "<tr><td class=footerfiche colspan=2 align=center><input type=submit value=\"$strConnecter\"></td></tr>";
    echo "</table>";
    echo "</td></tr></table>";
    echo "</td></tr></table>";
    echo "</form>";

    echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";

}


?>

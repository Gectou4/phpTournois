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
if (preg_match("/messagerie.php/i", $_SERVER['PHP_SELF'])) {
    die ("You cannot open this page directly");
}

if (!$config['messagerie']) js_goto('?page=index');

/*** test de la session ***/
if (empty($s_joueur)) js_goto("?page=login");

/********************************************************
 * Effacement d'un message
 */
if ($op == "delete") {

    if (is_numeric($id)) {
        $db->delete("${dbprefix}messages");
        $db->where("id = $id");
        $db->where("destinataire = $s_joueur");
        $db->exec();
    }

    js_goto("?page=messagerie");
} /********************************************************
 * Envoi d'un message
 */
elseif ($op == "envoi") {

    $str = '';
    $erreur = 0;

    if (!$titre) {
        $erreur = 1;
        $str .= "- " . $strElementsTitreInvalide . "<br>";
    }
    if (!$contenu) {
        $erreur = 1;
        $str .= "- " . $strElementsContenuInvalide . "<br>";
    }
    if (!$destinataire) {
        $erreur = 1;
        $str .= "- " . $strElementsDestinataireInvalide . "<br>";
    }

    if ($erreur == 1) {
        show_erreur_saisie($str);
    } else {

        $date = time();
        $titre = remove_XSS($titre);
        $contenu = remove_XSS(addslashes($contenu));

        $db->insert("${dbprefix}messages (emetteur,destinataire,titre,message,date)");
        $db->values("'$s_joueur','$destinataire','$titre','$contenu','$date'");
        $db->exec();

        js_goto("?page=messagerie&ok=1");
    }
} /********************************************************
 * Lecture d'un message
 */
elseif ($op == "lire") {

    echo "<p class=title>.:: $strMessagerie ::.</p>";

    $db->select("*");
    $db->from("${dbprefix}messages");
    $db->where("id = '$id'");
    $db->where("destinataire = $s_joueur");
    $res = $db->exec();
    $message = $db->fetch($res);

    $db->update("${dbprefix}messages");
    $db->set("lu = '1'");
    $db->where("id = '$id'");
    $db->where("destinataire = $s_joueur");
    $res = $db->exec();

    if ($message) {

        $date = strftime(DATESTRING1, $message->date);
        $message->titre = stripslashes($message->titre);
        $contenu = BBcode($message->message);
        $contenu = stripslashes($contenu);

        echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
        echo "<table cellspacing=1 cellpadding=0 border=0 width=450>";
        echo "<tr><td class=headerfiche>$strMessage</td></tr>";
        echo "<tr><td>";

        echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
        echo "<tr>";
        echo "<td class=titlefiche>$strDe :</td>";
        echo "<td class=textfiche colspan=2 width=85%>" . show_joueur($message->emetteur) . "</td>";
        echo "</tr>";
        echo "<td class=titlefiche>$strDate :</td>";
        echo "<td class=textfiche colspan=2>$strLe " . $date . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td class=titlefiche>$strTitre :</td>";
        echo "<td class=textfiche colspan=2><b>" . $message->titre . "</b></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td class=titlefiche style=\"vertical-align:top\">$strMessage :</td>";
        echo "<td class=textfiche style=\"border: 1px solid #000000; white-space: normal;\">$contenu<br><br></td><td class=textfiche>&nbsp;</td>";
        echo "</tr>";
        echo "<tr><td class=footerfiche colspan=3>";
        echo "<table border=0 cellpadding=0 cellspacing=3 align=center><tr>";
        echo "<td align=center><form method=post action='?page=messagerie&op=ecrire&message=" . $message->id . "'><input type=submit class=action value=\"$strRepondre\"></form></td>";
        echo "<td align=center><form method=post action='?page=messagerie&op=delete&id=" . $message->id . "'><input type=submit class=action value=\"$strEffacer\" onclick=\"return confirm('$strConfirmEffacerMessage');\"></form></td>";
        echo "</tr></table>";
        echo "</td></tr>";
        echo "</table>";

        echo "</td></tr>";
        echo "</table>";
        echo "</td></tr></table>";
    }

    echo "<br><img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";

} /********************************************************
 * Envoi d'un message
 */
elseif ($op == "ecrire") {

    /** recupération du message si c une reponse **/
    $contenu = '';

    if (isset($message) && is_numeric($message)) {
        $db->select("*");
        $db->from("${dbprefix}messages");
        $db->where("id = $message");
        $db->where("destinataire = $s_joueur");
        $res = $db->exec();
        $message = $db->fetch($res);
        $contenu = str_replace("", ">> ", $message->message);
        $contenu = ">> " . $contenu;
    } else $message = '';

    if (isset($destinataire) && is_numeric($destinataire)) {

    } else $destinataire = '';

    echo "<p class=title>.:: $strMessagerie ::.</p>";

    echo "<form method=post name=formulaire action=?page=messagerie&op=envoi>";

    echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
    echo "<table cellspacing=1 cellpadding=0 border=0 width=500>";
    if ($message) echo "<tr><td class=headerfiche>$strRepondreMessage</td></tr>";
    else echo "<tr><td class=headerfiche>$strEcrireMessage</td></tr>";
    echo "<tr><td>";

    echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";

    /** titre **/
    echo "<tr><td class=titlefiche>$strTitre :</td>";
    echo "<td class=textfiche>";

    if ($message->titre) echo "<input type=text name=titre maxlength=50 size=50 value=\"Re: " . $message->titre . "\">";
    else echo "<input type=text name=titre maxlength=50 size=50 value=''>";

    echo "</td></tr>";

    /** destinataire **/
    echo "<tr><td class=titlefiche>$strDestinataire :</td>";
    echo "<td class=textfiche>";

    if ($message->emetteur) {
        echo "<input type=hidden name=destinataire value=\"$message->emetteur\">" . show_joueur($message->emetteur);
    } elseif (is_numeric($destinataire)) {
        echo "<input type=hidden name=destinataire value=\"$destinataire\">" . show_joueur($destinataire);
    } else {
        $db->select("id,pseudo");
        $db->from("${dbprefix}joueurs");
        $db->where("(etat = 'I' or etat = 'P')");
        $db->order_by("pseudo");
        $joueurs = $db->exec();

        echo '<select name="destinataire">';
        while ($joueur = $db->fetch($joueurs)) {
            echo "<option value=\"$joueur->id\">$joueur->pseudo";
        }
        echo "</select>";
    }

    echo "</td></tr>";
    echo "<tr>";
    echo "<td class=textfiche colspan=2 align=center>";
    buttonBB('contenu');
    echo "</td>";
    echo "</tr>";

    /** contenu **/
    echo "<tr><td class=titlefiche>$strMessage :</td>";
    echo "<td class=textfiche>";
    echo "<textarea cols=60 rows=10 name=contenu ID=contenu wrap=virtual ONSELECT=\"storeCaret(this);\" ONCLICK=\"storeCaret(this);\" ONKEYUP=\"storeCaret(this);\">" . stripslashes($contenu) . "</textarea>";
    echo "</td></tr>";
    echo "<tr><td class=footerfiche colspan=2 align=center><input type=submit value=\"$strEnvoyer\"></td></tr>";
    echo "</table>";

    echo "</td></tr></table>";
    echo "</td></tr></table>";
    echo "</form>";

    echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";


} /********************************************************
 * Affichage normal
 */
else {

    echo "<p class=title>.:: $strMessagerie ::.</p><br /><br />";
    if ($ok == 1) {
        echo "<p class=title>.:: $strMessageenvoyez ::.</p>";
    }
    echo "<form method=post action='?page=messagerie&op=ecrire'>";
    echo "<table cellspacing=0 cellpadding=0 border=0><tr>";
    echo "<td><input type=submit class=action value=\"$strRedigerMessage\"></td>";
    echo "</tr></table>";
    echo "</form>";

    $db->select("*");
    $db->from("${dbprefix}messages");
    $db->where("destinataire = $s_joueur");
    $db->order_by("id DESC LIMIT 0,10");
    $res = $db->exec();

    if ($db->num_rows($res) == 0) {
        echo "<table cellspacing=0 cellpadding=0 border=0>";
        echo "<tr><td class=title><div align=justify>$strPasDeMessage</div></td></tr>";
        echo "</table>";
    } else {

        echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
        echo "<table border=0 cellspacing=1 cellpadding=2 width=500 align=center>";
        echo "<tr>";
        echo "<td class=headerliste>$strTitre</td>";
        echo "<td class=headerliste width=120>$strEmetteur</td>";
        echo "<td class=headerliste width=10%>$strDate</td>";
        echo "</tr>";

        if ($db->num_rows($res) != 0) {

            while ($message = $db->fetch($res)) {

                $date = strftime(DATESTRING1, $message->date);

                echo "<tr><td class=textliste><div style=\"clear: both\"><div style=\"float: left\">";
                if ($message->lu == "1")
                    echo "<a href=?page=messagerie&op=lire&id=$message->id><img src=images/mess.png border=0 align=absmiddle> $message->titre</a></div>";
                else
                    echo "<a href=?page=messagerie&op=lire&id=$message->id><img src=images/nouveaumess.png border=0 align=absmiddle> <b>$message->titre</b></a></div>";

                echo "<div style=\"float: right\">&nbsp;<a href=\"?page=messagerie&op=delete&id=$message->id\" onclick=\"return confirm('$strConfirmEffacerMessage');\">[$strS]</a></div></div>";


                echo "</td>";
                echo "<td class=textliste >" . show_joueur($message->emetteur) . "</td>";
                echo "<td class=textliste><center>$strLe $date</td>";
                echo "</tr>";
            }
        }

        echo "</table>";
        echo "</td></tr></table>";

        echo "<table border=0 cellspacing=2 cellpadding=2 align=center>";
        echo "<tr><td class=info><img src=images/mess.png align=absmiddle> $strMessageLu</td><td width=20></td><td class=info><img src=images/nouveaumess.png align=absmiddle> $strMessageNouveau</td></tr>";
        echo "</table>";
    }

    echo "<br><img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";

}

?>

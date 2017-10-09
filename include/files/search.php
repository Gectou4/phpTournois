<?php
/*
  +---------------------------------------------------------------------+
  | phpTournois                                                         |
  +---------------------------------------------------------------------+
  +---------------------------------------------------------------------+
  | phpTournoisG4 �2004 by Gectou4 <le_gardien_prime@hotmail.com>       |
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
  |  Edited by @ngelius <angelius@tournois-online.com>  (04/07/2005)    |
  +---------------------------------------------------------------------+
*/
if (preg_match("/search.php/i", $_SERVER['PHP_SELF'])) {
    die ("You cannot open this page directly");
}
/********************************************************
 * TO DO
 *
 *
 * => choose search : Forum | Player | News | Team
 *
 *
 * echo "<option value=\"joueur\">$strJoueurs</option>";
 * echo "<option value=\"joueur2\">$strJoueurs (ID)</option>";
 * echo "<option value=\"steam\">$strSID</option>";
 * echo "<option value=\"equipe\">$strEquipes</option>";
 * echo "<option value=\"equipe2\">$strEquipes (TAG)</option>";
 * echo "<option value=\"new\">$strNews</option>";
 * echo "<option value=\"forum\">$strForum (posts)</option>"; => incatif ici
 *
 *
 *
 */

/********************************************************
 *  SYNTAX DE RECHERCHE
 */

/* ---    JOUEUR    --- */
if ($op == "searching") {

// r&eacute;ception des donn&eacute;es
    if ($_POST['howto'] == 'joueur') {
        $pseudo = $_POST['search'];

//formatage des erreurs
        $str = '';
        $erreur = 0;

        if (!$pseudo) {
            $erreur = 1;
            $str .= "- $strElementsPseudoInvalide<br>";
        }
        if ($erreur == 1) {
            show_erreur_saisie($str);
        } else {

            $rech_ps = 'x';

            if ($pseudo != "*") {

                if (!is_numeric($pseudo)) {
                    $db->select("id, pseudo");
                    $db->from("${dbprefix}joueurs WHERE pseudo='$pseudo'");
                    $res = $db->exec();
                } else {
                    $db->select("id, pseudo");
                    $db->from("${dbprefix}joueurs WHERE id='$pseudo'");
                    $res = $db->exec();
                }

                while ($rech_joueur = $db->fetch($res)) {
                    $rech_id = $rech_joueur->id;
                    $rech_ps = $rech_joueur->pseudo;
                }
            }
            if ($pseudo != $rech_ps and $pseudo != $rech_id) {
                if ($pseudo != "*" and !is_numeric($pseudo)) {
                    $conca = "%";
                    $pseudo = $conca . $pseudo . $conca;
                    $db->select("id, pseudo");
                    $db->from("${dbprefix}joueurs WHERE pseudo LIKE '$pseudo'");
                    $res = $db->exec();
                } else if ($pseudo == "*") {
                    $db->select("*");
                    $db->from("${dbprefix}joueurs ORDER BY pseudo ASC");
                    $res = $db->exec();
                } else if (is_numeric($pseudo)) {
                    $db->select("id, pseudo");
                    $db->from("${dbprefix}joueurs WHERE id='$pseudo'");
                    $res = $db->exec();
                }

                $newspseudo = '';

                while ($rech_joueur = $db->fetch($res)) {
                    $newpseudo = $newpseudo . '<option value="' . $rech_joueur->pseudo . '">' . $rech_joueur->pseudo . '</option>';
                }
                if ($newpseudo == "" || $newpseudo == NULL) {
                    echo "<br><img src=images/warning.gif border=0 align=absmiddle>&nbsp;<span class=info><b>- $strS_nomatch</b></span>";
                    echo "<br><br><span class=warning>$strS_listtnick_error</span><br>";
                    echo "<br><img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br><br>";

                } else {
                    if ($pseudo != "*") {
                        echo "<br><img src=images/warning.gif border=0 align=absmiddle>&nbsp;<span class=info><b>- $strS_nomatch</b>";
                        echo "<br><br>$strS_listnick :</span><br>";
                    }
                    echo '<br /><form method="post" action="?page=search&op=searching">';
                    echo '<table border=0 cellpadding="0" cellspacing="0" class="bordure2"><tr><td>';
                    echo '<table cellspacing="1" cellpadding="0" border="0">';
                    echo "<tr><td class=\"headerfiche\"> $strRechercherJoueur </td></tr>";
                    echo '<tr><td>';
                    echo '<table cellspacing="0" cellpadding="3" border="0" width="100%">';
                    echo '<tr>';
                    echo "<td class=\"titlefiche\">$strPseudo :</td>";
                    echo '<td class="textfiche"> <select name="search">';
                    echo "$newpseudo";
                    echo '</select><input type="hidden" value="joueur" name="howto">';
                    echo '</td>';
                    echo '</tr>';
                    echo "<tr><td class=\"footerfiche\" align=\"center\" colspan=\"2\"><input type=\"submit\" class=\"action\" value=\"$strRechecrher\"></td></tr>";
                    echo '</table>';
                    echo '</td></tr></table>';
                    echo '</td></tr></table></form>';
                    echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action><b>$strRetour</b></a><br>";
                    $rech_help = "oui";
                }

            } else {

                /*** redirection ***/
                js_goto("?page=joueurs&id=$rech_id");

            }
        }

    } elseif ($_POST['howto'] == 'joueur2') {
        $pseudo = $_POST['search'];

//formatage des erreurs
        $str = '';
        $erreur = 0;

        if (!$pseudo) {
            $erreur = 1;
            $str .= "- $strElementsPseudoInvalide<br>";
        }
        if ($erreur == 1) {
            show_erreur_saisie($str);
        } else {

            $rech_ps = 'x';

            if ($pseudo != "*") {

                $db->select("id, pseudo");
                $db->from("${dbprefix}joueurs WHERE id='$pseudo'");
                $res = $db->exec();

                while ($rech_joueur = $db->fetch($res)) {
                    $rech_id = $rech_joueur->id;
                    $rech_ps = $rech_joueur->pseudo;
                }
            }
            if ($pseudo != $rech_id) {
                if ($pseudo != "*") {
                    $conca = "%";
                    $pseudo = $conca . $pseudo . $conca;
                    $db->select("id, pseudo");
                    $db->from("${dbprefix}joueurs WHERE id LIKE '$pseudo'");
                    $res = $db->exec();
                } else if ($pseudo == "*") {
                    $db->select("*");
                    $db->from("${dbprefix}joueurs ORDER BY id ASC");
                    $res = $db->exec();
                }

                $newspseudo = '';

                while ($rech_joueur = $db->fetch($res)) {
                    $newpseudo = $newpseudo . '<option value="' . $rech_joueur->pseudo . '">' . $rech_joueur->pseudo . '(' . $rech_joueur->id . ')</option>';
                }
                if ($newpseudo == "" || $newpseudo == NULL) {
                    echo "<br><img src=images/warning.gif border=0 align=absmiddle>&nbsp;<span class=info><b>- $strS_nomatch</b></span>";
                    echo "<br><br><span class=warning>$strS_listtnick_error</span><br>";
                    echo "<br><img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br><br>";

                } else {
                    if ($pseudo != "*") {
                        echo "<br><img src=images/warning.gif border=0 align=absmiddle>&nbsp;<span class=info><b>- $strS_nomatch</b>";
                        echo "<br><br>$strS_listnick :</span><br>";
                    }
                    echo '<br /><form method="post" action="?page=search&op=searching">';
                    echo '<table border=0 cellpadding="0" cellspacing="0" class="bordure2"><tr><td>';
                    echo '<table cellspacing="1" cellpadding="0" border="0">';
                    echo "<tr><td class=\"headerfiche\"> $strRechercherJoueur </td></tr>";
                    echo '<tr><td>';
                    echo '<table cellspacing="0" cellpadding="3" border="0" width="100%">';
                    echo '<tr>';
                    echo "<td class=\"titlefiche\">$strPseudo :</td>";
                    echo '<td class="textfiche"> <select name="search">';
                    echo "$newpseudo";
                    echo '</select><input type="hidden" value="joueur" name="howto">';
                    echo '</td>';
                    echo '</tr>';
                    echo "<tr><td class=\"footerfiche\" align=\"center\" colspan=\"2\"><input type=\"submit\" class=\"action\" value=\"$strRechecrher\"></td></tr>";
                    echo '</table>';
                    echo '</td></tr></table>';
                    echo '</td></tr></table></form>';
                    echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action><b>$strRetour</b></a><br>";
                    $rech_help = "oui";
                }

            } else {

                /*** redirection ***/
                js_goto("?page=joueurs&id=$rech_id");

            }
        }

    }
    /* ---    Steam    --- */
// r&eacute;ception des donn&eacute;es
    else if ($_POST['howto'] == 'steam') {
        $pseudo = $_POST['search'];

//formatage des erreurs
        $str = '';
        $erreur = 0;

        if (!$pseudo) {
            $erreur = 1;
            $str .= "- $strElementsSteamInvalide<br>";
        }
        if ($erreur == 1) {
            show_erreur_saisie($str);
        } else {

            $rech_ps = 'x';

            if ($pseudo != "*") {

                $db->select("id, pseudo, steam");
                $db->from("${dbprefix}joueurs WHERE steam='$pseudo'");
                $res = $db->exec();

                while ($rech_joueur = $db->fetch($res)) {
                    $rech_id = $rech_joueur->id;
                    $rech_ps = $rech_joueur->steam;
                }
            }
            if ($pseudo != $rech_ps) {
                if ($pseudo != "*") {
                    $conca = "%";
                    $pseudo = $conca . $pseudo . $conca;
                    $db->select("id, pseudo, steam");
                    $db->from("${dbprefix}joueurs WHERE steam LIKE '$pseudo' ORDER BY steam ASC");
                    $res = $db->exec();
                } else if ($pseudo == "*") {
                    $db->select("*");
                    $db->from("${dbprefix}joueurs ORDER BY steam ASC");
                    $res = $db->exec();
                }

                $newspseudo = '';

                while ($rech_joueur = $db->fetch($res)) {
                    $newpseudo = $newpseudo . '<option value="' . $rech_joueur->steam . '">' . $rech_joueur->steam . '</option>';
                }
                if ($newpseudo == "" || $newpseudo == NULL) {
                    echo "<br><img src=images/warning.gif border=0 align=absmiddle>&nbsp;<span class=info><b>- $strS_nomatch</b></span>";
                    echo "<br><br><span class=warning>$strS_listtsteam_error</span><br>";
                    echo "<br><img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br><br>";

                } else {
                    if ($pseudo != "*") {
                        echo "<br><img src=images/warning.gif border=0 align=absmiddle>&nbsp;<span class=info><b>- $strS_nomatch</b>";
                        echo "<br><br>$strS_liststeam :</span><br>";
                    }
                    echo '<br /><form method="post" action="?page=search&op=searching">';
                    echo '<table border=0 cellpadding="0" cellspacing="0" class="bordure2"><tr><td>';
                    echo '<table cellspacing="1" cellpadding="0" border="0">';
                    echo "<tr><td class=\"headerfiche\"> $strRechercherSteam</td></tr>";
                    echo '<tr><td>';
                    echo '<table cellspacing="0" cellpadding="3" border="0" width="100%">';
                    echo '<tr>';
                    echo "<td class=\"titlefiche\">$strSID :</td>";
                    echo '<td class="textfiche"> <select name="search">';
                    echo "$newpseudo";
                    echo '</select><input type="hidden" value="steam" name="howto">';
                    echo '</td>';
                    echo '</tr>';
                    echo "<tr><td class=\"footerfiche\" align=\"center\" colspan=\"2\"><input type=\"submit\" class=\"action\" value=\"$strRechecrher\"></td></tr>";
                    echo '</table>';
                    echo '</td></tr></table>';
                    echo '</td></tr></table></form>';
                    echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action><b>$strRetour</b></a><br>";
                    $rech_help = "oui";
                }

            } else {


                /*** redirection ***/
                js_goto("?page=joueurs&id=$rech_id");

            }
        }

    } /* ---    EQUIPE    --- */
    else if ($_POST['howto'] == 'equipe') {

        $pseudo = $_POST['search'];

//formatage des erreurs
        $str = '';
        $erreur = 0;

        if (!$pseudo) {
            $erreur = 1;
            $str .= "- $strElementsSearchInvalide<br>";
        }
        if ($erreur == 1) {
            show_erreur_saisie($str);
        } else {

            $rech_ps = 'x';

            if ($pseudo != "*") {

                $db->select("id, nom");
                $db->from("${dbprefix}equipes WHERE nom='$pseudo' OR tag='$pseudo'");
                $res = $db->exec();

                while ($rech_joueur = $db->fetch($res)) {
                    $rech_id = $rech_joueur->id;
                    $rech_ps = $rech_joueur->nom;
                    $rech_tag = $rech_joueur->tag;
                }
            }
            if ($pseudo != $rech_ps) {
                if ($pseudo != "*") {
                    $pseudo = "%" . $pseudo . "%";
                    $db->select("id, nom, tag");
                    $db->from("${dbprefix}equipes WHERE nom LIKE '$pseudo' or tag LIKE '$pseudo'");
                    $res = $db->exec();
                } else if ($pseudo == "*") {
                    $db->select("id,nom,tag");
                    $db->from("${dbprefix}equipes ORDER BY nom ASC");
                    $res = $db->exec();
                }

                $newspseudo = '';

                while ($rech_joueur = $db->fetch($res)) {
                    $newpseudo = $newpseudo . '<option value="' . $rech_joueur->nom . '">' . $rech_joueur->nom . ' <small>(tag : ' . $rech_joueur->tag . ')</small></option>';

                }
                if ($newpseudo == "" || $newpseudo == NULL) {
                    echo "<br><img src=images/warning.gif border=0 align=absmiddle>&nbsp;<span class=info><b>- $strS_nomatch</b></span>";
                    echo "<br><br><span class=warning>$strS_listteam_error</span>";
                    echo "<br><img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br><br>";

                } else {
                    if ($pseudo != "*") {
                        echo "<br><img src=images/warning.gif border=0 align=absmiddle>&nbsp;<span class=info><b>- $strS_nomatch</b>";
                        echo "<br><br>$strS_listteam :</span><br>";
                    }
                    echo '<br /><form method="post" action="?page=search&op=searching">';
                    echo '<table border=0 cellpadding="0" cellspacing="0" class="bordure2"><tr><td>';
                    echo '<table cellspacing="1" cellpadding="0" border="0">';
                    echo "<tr><td class=\"headerfiche\"> $strRechecrher </td></tr>";
                    echo '<tr><td>';
                    echo '<table cellspacing="0" cellpadding="3" border="0" width="100%">';
                    echo '<tr>';
                    echo "<td class=\"titlefiche\">$strPseudo :</td>";
                    echo '<td class="textfiche"> <select name="search">';
                    echo "$newpseudo";
                    echo '</select><input type="hidden" value="equipe" name="howto">';
                    echo '</td>';
                    echo '</tr>';
                    echo "<tr><td class=\"footerfiche\" align=\"center\" colspan=\"2\"><input type=\"submit\" class=\"action\" value=\"$strRechecrher\"></td></tr>";
                    echo '</table>';
                    echo '</td></tr></table>';
                    echo '</td></tr></table></form>';
                    echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action><b>$strRetour</b></a><br>";
                    $rech_help = "oui";
                }

            } else {

                /*** redirection ***/
                js_goto("?page=equipes&id=$rech_id");

            }
        }

    } else if ($_POST['howto'] == 'equipe2') {

        $pseudo = $_POST['search'];

//formatage des erreurs
        $str = '';
        $erreur = 0;

        if (!$pseudo) {
            $erreur = 1;
            $str .= "- $strElementsSearchInvalide<br>";
        }
        if ($erreur == 1) {
            show_erreur_saisie($str);
        } else {

            $rech_ps = 'x';

            if ($pseudo != "*") {

                $db->select("id, tag");
                $db->from("${dbprefix}equipes WHERE tag='$pseudo'");
                $res = $db->exec();

                while ($rech_joueur = $db->fetch($res)) {
                    $rech_id = $rech_joueur->id;
                    $rech_ps = $rech_joueur->tag;
                }
            }
            if ($pseudo != $rech_ps) {
                if ($pseudo != "*") {
                    $pseudo = "%" . $pseudo . "%";
                    $db->select("id, tag");
                    $db->from("${dbprefix}equipes WHERE tag LIKE '$pseudo'");
                    $res = $db->exec();
                } else if ($pseudo == "*") {
                    $db->select("*");
                    $db->from("${dbprefix}equipes ORDER BY tag ASC");
                    $res = $db->exec();
                }

                $newspseudo = '';

                while ($rech_joueur = $db->fetch($res)) {
                    $newpseudo = $newpseudo . '<option value="' . $rech_joueur->tag . '">' . $rech_joueur->tag . '</option>';

                }
                if ($newpseudo == "" || $newpseudo == NULL) {
                    echo "<br><img src=images/warning.gif border=0 align=absmiddle>&nbsp;<span class=info><b>- $strS_nomatch</b></span>";
                    echo "<br><br><span class=warning>$strS_listteam_error</span><br>";
                    echo "<br><img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br><br>";

                } else {
                    if ($pseudo != "*") {
                        echo "<br><img src=images/warning.gif border=0 align=absmiddle>&nbsp;<span class=info><b>- $strS_nomatch</b>";
                        echo "<br><br>$strS_listteam :</span><br>";
                    }
                    echo '<br /><form method="post" action="?page=search&op=searching">';
                    echo '<table border=0 cellpadding="0" cellspacing="0" class="bordure2"><tr><td>';
                    echo '<table cellspacing="1" cellpadding="0" border="0">';
                    echo "<tr><td class=\"headerfiche\"> $strRechecrher </td></tr>";
                    echo '<tr><td>';
                    echo '<table cellspacing="0" cellpadding="3" border="0" width="100%">';
                    echo '<tr>';
                    echo "<td class=\"titlefiche\">$strPseudo :</td>";
                    echo '<td class="textfiche"> <select name="search">';
                    echo "$newpseudo";
                    echo '</select><input type="hidden" value="equipe2" name="howto">';
                    echo '</td>';
                    echo '</tr>';
                    echo "<tr><td class=\"footerfiche\" align=\"center\" colspan=\"2\"><input type=\"submit\" class=\"action\" value=\"$strRechecrher\"></td></tr>";
                    echo '</table>';
                    echo '</td></tr></table>';
                    echo '</td></tr></table></form>';
                    echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action><b>$strRetour</b></a><br>";
                    $rech_help = "oui";
                }

            } else {

                /*** redirection ***/
                js_goto("?page=equipes&id=$rech_id");

            }
        }

    } /* ---    NEWS    --- */
    else if ($_POST['howto'] == 'new') {

        $pseudo = $_POST['search'];

//formatage des erreurs
        $str = '';
        $erreur = 0;

        if (!$pseudo) {
            $erreur = 1;
            $str .= "- $strElementsSearchInvalide<br>";
        }
        if ($erreur == 1) {
            show_erreur_saisie($str);
        } else {
            $pseudo = "%" . $pseudo . "%";
            $db->select("*");
            $db->from("${dbprefix}news WHERE (contenu LIKE '$pseudo') OR (titre LIKE '$pseudo') order by date DESC");
            $res = $db->exec();
            echo '<br>';


            $rech_ps = 'NO';

            while ($rech = $db->fetch($res)) {

                if ($rech->titre != '' || $rech->titre != NULL) {
                    $rech_ps = 'OK';

                    $contenu = BBcode($rech->contenu);
                    $contenu = stripslashes($contenu);
                    $titre = stripslashes($rech->titre);
                    $date = strftime(DATESTRING1, $rech->date);
                    $date = "$strLe " . $date;

                    echo "<table width=500 border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
                    echo "<table width=100% border=0 cellspacing=1 cellpadding=2>";
                    echo "<tr>";
                    echo "<td class=header><div style=\"clear: both\"><div style=\"float: left\"><a href=\"?page=news&id=" . $rech->id . "\"><img src=\"images/news/" . $rech->icone . "\" border=0 align=absmiddle><b> " . $titre . "</b></a></div>";
                    echo "</div></td></tr>";
                    echo "<tr>";
                    echo "<td class=text>" . $contenu;
                    echo "<br><br><span class=info><div style=\"clear: both\">";
                    echo "<div style=\"float: left\"><img src=\"images/icon_comment.gif\" border=0 align=absmiddle> <a href=\"?page=news&id=" . $rech->id . "\">$strCommentaires ? (" . nb_news_commentaires($rech->id) . ")</a> | <a href=\"?page=news&op=imprimer&header=nude&id=" . $news->id . "\" target=_blank><img src=\"images/print.gif\" border=0 align=absmiddle></a> | <a href=\"?page=news&op=envoyer&id=" . $news->id . "\"><img src=\"images/friend.gif\" border=0 align=absmiddle></a></div>";
                    echo "<div align=right>$strPostePar <b>" . show_joueur($rech->auteur, $op) . "</b> " . $date . "</div></span>";
                    echo "</div></td></tr>";
                    echo "</table>";
                    echo "</td></tr></table><br>";
                }

            }

            if ($rech_ps == "NO") {
                echo "<br><img src=images/warning.gif border=0 align=absmiddle>&nbsp;<span class=info><b>- $strS_listnews_error</b></span>";
                echo "<br><br><span class=warning>$strSearchUnresult</span><br>";
                echo "<br><img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br><br>";
            }


        }

    } /* ---    FORUM    --- */
    else if ($_POST['howto'] == 'forum' || $_GET['howto'] == 'forum') {

        $pseudo = $_POST['search'];
        if (empty($pseudo)) {
            $pseudo = $_GET['search'];
        }
//formatage des erreurs
        $str = '';
        $erreur = 0;

        if (!$pseudo) {
            $erreur = 1;
            $str .= "- $strElementsSearchInvalide<br>";
        }
        if ($erreur == 1) {
            show_erreur_saisie($str);
        } else {
            if (empty($_GET['start'])) {
                $start = 0;
            } else {
                $start = $_GET['start'];
            }
            $nb_max = $start + 21;
            $pseudo = "%" . $pseudo . "%";
            $db->select("*");
            $db->from("${dbprefix}forum_message WHERE (message LIKE '$pseudo') OR (topic LIKE '$pseudo')LIMIT $start,$nb_max");
            $res = $db->exec();
            echo '<br>';


            $rech_ps = 'NO';
            $i_search = $start;
            $navig = '0';
            while ($rech = $db->fetch($res)) {
                if ($i_search < $nb_max - 1) {

                    if ($rech->topic != '' || $rech->topic != NULL) {

                        if ($rech_ps == 'NO') {
                            echo '<br><table border=1 cellpadding="4" cellspacing="2" class="bordure1" width="90%">';
                            echo '<tr>
   <td class="textforum"></td><td class="headerfiche"><div align=left><b>' . $strTopic . '</b></div></td>
   <td class="headerfiche" width=1%><div align=right><font size=-4><b>' . $strFLast . '</b></font></div></td>
   </tr>';
                        }
                        $rech_ps = 'OK';

                        $topid = $rech->topid;
                        $tit = $rech->topic;
                        $titre = remove_XSS(base64_decode($tit));
                        $cat = $rech->cattopic;


                        $auteur = show_joueur($rech->auteur);
                        // requete interne
                        $db->select("reserved");
                        $db->from("${dbprefix}forum WHERE (cattopic='$cat' AND cattitle != '')");
                        $resr2 = $db->exec();

                        while ($datar2 = $db->fetch($resr2)) {
                            $reserved = $datar2->reserved;
                        }
                        //en requete interne


                        $date = strftime("%c", $rech->topic_date);

                        if ($rech->topic != '' || $rech->topic != NULL) {


                            if ($grade['a'] == 'a' || $grade['b'] == 'b') {
                                $is_able_to_see = 'yes';
                            }

                            if (preg_match('/m/i', $reserved) && $grade['m'] == 'm') {
                                $is_able_to_see = 'yes';
                            }

                            if (preg_match('/n/i', $reserved) && $grade['n'] == 'n') {
                                $is_able_to_see = 'yes';
                            }

                            if (preg_match('/u/i', $reserved) && $s_joueur != '') {
                                $is_able_to_see = 'yes';
                            }

                            if ($is_able_to_see != 'yes' && !preg_match('/u/i', $reserved) && !preg_match('/m/i', $reserved) && !preg_match('/n/i', $reserved)) {
                                $is_able_to_see = 'yes';
                            }
                            $test_de_ok = 'no';
                            if ($is_able_to_see == 'yes') {
                                $test_de_ok = 'ui';
                                echo '<tr>';
                                echo '<td class="endforum" align="center" width="10%"> <img border="0" src="themes/' . $s_theme . '/images/nav.gif" valign=middle> </td>
  <td class="topicfiche" align="left"> <a href="?page=forum&op=read&topid=' . $rech->topid . '&cattopic=' . $rech->cattopic . '&topic=' . base64_encode($rech->topic) . '&titre=' . $titre . '"><b>' . bbcode(stripslashes($rech->topic)) . '</b></a>';
                                echo '</td>
  <td class="topicfiche" align="left"><div align=center>' . $auteur . '<br><font size=-4>' . $date . '</font></div></td>
  </tr>';
                            }
                            if ($test_de_ok == 'no') {
                                echo '<tr>';
                                echo '<td class="endforum" align="center" width="10%"> <img border="0" src="themes/' . $s_theme . '/images/nav.gif" valign=middle> </td>
  <td class="topicfiche" align="left"> (' . $forum_need_more_ac . ')';
                                echo '</td>
  <td class="topicfiche" align="left"><div align=center>-<br><font size=-4>-</font></div></td>
  </tr>';
                            }

                        }


                    }
                }//isearch
                else if ($i_search <= $nb_max) {

                    if ($row->post_id != '') {
                        $navig = '1';
                        $prec_s = $start;
                        $suiv_s = $i_search;
                    }

                }
            }
            if ($rech_ps == 'OK') {
                echo '</td></tr>';
                echo '</table><br>';
            }

            if ($navig == '1') {
                echo '<center>  <a href="?start=' . $prec_s . '&pseudo=' . $pseudo . '&howto=forum">[Precendent]</a> <a href="?start=' . $suiv_s . '&pseudo=' . $pseudo . '&howto=forum">[Suivant]</a> </center>';

            }

            if ($rech_ps == "NO") {
                echo "<br><img src=images/warning.gif border=0 align=absmiddle>&nbsp;<span class=info><b>- $strS_forum_error</b></span>";
                echo "<br><br><span class=warning>$strSearchUnresult</span>";
                echo "<br><img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br><br>";
            }


        }

    }


}
/********************************************************
 *  Rechercher  (formulaire)
 */
if ($op == "") {
    global $config;

    echo '<form method="post" action="?page=search&op=searching">';
    echo '<table border=0 cellpadding="0" cellspacing="0" class="bordure2"><tr><td>';
    echo '<table cellspacing="1" cellpadding="0" border="0">';
    echo "<tr><td class=\"headerfiche\">$strRechecrher Tournois-Online</td></tr>";
    echo '<tr><td>';
    echo '<table cellspacing="0" cellpadding="3" border="0" width="100%">';
    echo '<tr>';
    echo '<td class="textfiche"><input type="text" name="search" maxlength="20"></td>';
    echo "<td class=\"titlefiche\">$strDans </td>";
    echo '<td class="textfiche">';
    echo "<select name=howto>";
    echo "<option value=\"joueur\">$strJoueurs</option>";
    //echo "<option value=\"joueur2\">$strJoueurs (ID)</option>";
    if ($strSID) {
        echo "<option value=\"steam\">$strSID</option>";
    }
    echo "<option value=\"equipe\">$strEquipes</option>";
// echo "<option value=\"equipe2\">$strEquipes (TAG)</option>";
    if ($strNews) {
        echo "<option value=\"new\">$strNews</option>";
    }
    if ($strForum) {
        echo "<option value=\"forum\">$strForum</option>";
    }

    echo "</select></td>";
    echo '</tr>';
    echo "<tr><td colspan='3' class=\"footerfiche\" align=\"center\" colspan=\"2\"><input type=\"submit\" class=\"action\" value=\"$strRechecrher\"></td></tr>";
    echo '</table>';
    echo '</td></tr></table>';
    echo '</td></tr></table>';
    echo '</form>';

//Recherche par google.
    ?>
    <!-- Search Google
    <center>
    <form method="get" action="http://www.google.com/custom" target="_top">
    <table bgcolor="#ffffff">
    <tr><td nowrap="nowrap" valign="top" align="left" height="32">
    <a href="http://www.google.com/">
    <img src="http://www.google.com/logos/Logo_25wht.gif" border="0" alt="Google" align="middle"></img></a>
    <input type="text" name="q" size="31" maxlength="255" value=""></input>
    <input type="submit" name="sa" value="Rechercher"></input>
    <input type="hidden" name="client" value="pub-8936537743718994"></input>
    <input type="hidden" name="forid" value="1"></input>
    <input type="hidden" name="ie" value="ISO-8859-1"></input>
    <input type="hidden" name="oe" value="ISO-8859-1"></input>
    <input type="hidden" name="cof" value="GALT:#008000;GL:1;DIV:#336699;VLC:663399;AH:center;BGC:FFFFFF;LBGC:336699;ALC:0000FF;LC:0000FF;T:000000;GFNT:0000FF;GIMP:0000FF;FORID:1;"></input>
    <input type="hidden" name="hl" value="fr"></input>
    </td></tr></table>
    </form>
    </center>
    <!-- Search Google -->

    <?php
}
?>
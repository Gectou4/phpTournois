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
if (preg_match("/matchs_commentaires.php/i", $_SERVER['PHP_SELF'])) {
    die ("You cannot open this page directly");
}

/*** postage de commentaires ***/
$matchobj = match($match);
$post = 0;

$modecommentaire_tournois = modecommentaire_tournois($matchobj->tournois);
$modeequipe_tournois = modeequipe_tournois($matchobj->tournois);

if ($modecommentaire_tournois != 'N' && ($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['t'] == 't' || $grade['u'] == 'u')) {
    $post = 1;
} elseif ($modecommentaire_tournois == 'O' && $modeequipe_tournois == 'E' && (equipe_appartient($matchobj->equipe1, $s_joueur) || equipe_appartient($matchobj->equipe2, $s_joueur)) && $s_joueur) {
    $post = 1;
} elseif ($modecommentaire_tournois == 'O' && $modeequipe_tournois == 'J' && ($matchobj->equipe1 == $s_joueur || $matchobj->equipe2 == $s_joueur) && $s_joueur) {
    $post = 1;
} elseif ($modecommentaire_tournois == 'N') js_goto("?page=index");


/********************************************************
 * Ajout d'un commentaire
 */
if ($op == "add") {

    if ($post == 1) {

        $str = '';
        $erreur = 0;

        if (!is_numeric($match)) {
            $erreur = 1;
            $str .= "- " . $strMatchInvalide . "<br>";
        }
        if (!$contenu) {
            $erreur = 1;
            $str .= "- " . $strElementsContenuInvalide . "<br>";
        }

        if ($erreur == 1) {
            show_erreur_saisie($str);
        } else {
            $date = time();
            $contenu = remove_XSS($contenu);

            $db->insert("${dbprefix}matchs_commentaires (auteur,contenu,date,matchi)");
            $db->values("'$s_joueur','$contenu','$date','$match'");
            $db->exec();

            /*** redirection ***/
            js_goto("?page=matchs_commentaires&match=$match&header=win");
        }
    }
} /********************************************************
 * Effacement d'un commentaire
 */
elseif ($op == "delete") {

    /*** verification securite ***/
    if ($grade['a'] != 'a' && $grade['b'] != 'b' && $grade['t'] != 't' && $grade['u'] != 'u') {
        js_goto($PHP_SELF);
    }

    if (is_numeric($id) && is_numeric($match)) {

        $db->delete("${dbprefix}matchs_commentaires");
        $db->where("id = $id and matchi = $match");
        $db->exec();
    }

    /*** redirection ***/
    js_goto("?page=matchs_commentaires&match=$match&header=win");

} /********************************************************
 * Affichage normal + admin
 */
else {

    echo "<p class=title>.:: $strCommentairesMatch $match ::.</p>";

    /*** affichage des commentaires ***/
    if (!$start) $start = 0;
    $nb_max = $config['nb_matchs_commentaires_max'];
    $nb_total = nb_matchs_commentaires($match);

    $db->select("*");
    $db->from("${dbprefix}matchs_commentaires");
    $db->where("matchi = $match");
    $db->order_by("id ASC LIMIT $start,$nb_max");
    $res = $db->exec();

    if ($db->num_rows($res) == 0) {
        echo "<table cellspacing=0 cellpadding=0 border=0>";
        echo "<tr><td class=title><div align=justify>$strPasDeCommentaire</div></td></tr>";
        echo "</table><br>";
    } else {

        echo "<table align=center width=300 border=0 cellspacing=0 cellpadding=0>";
        echo "<tr><td class=title align=center>$strCommentaires</td></tr>";
        echo "<tr><td>";

        $nbCommentaires = 0;
        while ($commentaire = $db->fetch($res)) {
            $nbCommentaires++;
            $date = strftime(DATESTRING1, $commentaire->date);
            $date = "$strLe " . $date;
            $contenu = BBcode($commentaire->contenu);

            echo "<table width=300 border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
            echo "<table width=100% border=0 cellspacing=1 cellpadding=2>";
            echo "<tr>";
            echo "<td class=text><div style=\"clear: both\"><div style=\"float: left\">#" . $nbCommentaires . " - $strPostePar <b>" . show_joueur($commentaire->auteur, $op) . "</b> " . $date . "</div>";
            if (($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['t'] == 't' || $grade['u'] == 'u'))
                echo "<div style=\"float: right\">&nbsp;<a href=?page=matchs_commentaires&op=delete&id=" . $commentaire->id . "&match=$match&header=win onclick=\"return confirm('$strConfirmEffacerCommentaire');\">[$strS]</a></div>";
            echo "</div></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td class=text>" . stripslashes($contenu) . "<br><br></td>";
            echo "</tr>";
            echo "</table>";
            echo "</td></tr></table>";
        }
        if ($op) $p = "op=$op&";
        else $p = "";
        echo "<table cellspacing=0 cellpadding=0 border=0 align=center>";
        echo "<tr><td class=text2>" . navigateur($start, $nb_max, $nb_total, "?page=matchs_commentaires&" . $p . "match=$match&start=%d&header=win") . "</td></tr>";
        echo "</table><br>";

        echo "</td></tr></table>";
    }

    /*** poster un commentaire ***/
    echo "<form method=post name=\"formulaire\" action=?page=matchs_commentaires&op=add>";
    echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
    echo "<table cellspacing=1 cellpadding=0 border=0>";
    echo "<tr><td class=headerfiche>$strAjouterCommentaire</td></tr>";
    echo "<tr><td>";
    echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
    if ($post != 1) {
        echo "<tr>";
        echo "<td class=textfiche align=center>$strParticipePourPoster</td>";
        echo "</tr>";
    } else {
        echo "<tr>";
        echo "<td class=textfiche colspan=2 align=center>";
        buttonBB('contenu');
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td class=titlefiche>$strContenu :</td>";
        echo "<td class=textfiche><textarea cols=50 rows=6 name=contenu ID=contenu wrap=virtual ONSELECT=\"storeCaret(this);\" ONCLICK=\"storeCaret(this);\" ONKEYUP=\"storeCaret(this);\"></textarea></td>";
        echo "</tr>";
        echo "<tr><td class=footerfiche colspan=2 align=center><input type=submit value=\"$strAjouter\"></td></tr>";
    }
    echo "</table>";
    echo "</td></tr></table>";
    echo "</td></tr></table>";
    echo "<input type=hidden name=match value=\"$match\">";
    echo "</form>";


    echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:close() class=action>$strRetour</a><br>";

}

?>

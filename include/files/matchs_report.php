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

if (preg_match("/matchs_report.php/i", $_SERVER['PHP_SELF'])) {
    die ("You cannot open this page directly");
}

/*** test de la session ***/
if (empty($s_tournois)) js_goto("?page=index");


/********************************************************
 * Affichage popup report
 */
if ($op == 'report' || $op == 'do_report') {

    $str = '';
    $erreur = 0;

    /** recup du match **/
    $match = match($id);

    if (!$match) {
        $erreur = 1;
        $str .= $strMatchInvalide;
    }

    /** recup du type de tournois **/
    $modeequipe_tournois = modeequipe_tournois($match->tournois);

    $participe = 0;
    $moi = 0;

    /*** test de la participation au match ***/
    /** le tournois est par equipe **/
    if ($modeequipe_tournois == 'E' && $s_joueur) {
        $show = "show_equipe";
        $nom_participant = "nom_equipe";
        $champX = "tag";

        $mesequipes = equipes_manager($s_joueur);

        for ($i = 0; $i < count($mesequipes); $i++) {
            if ($mesequipes[$i]['id'] == $match->equipe1) {
                $moi = 1;
                $participe = 1;
                break;
            } elseif ($mesequipes[$i]['id'] == $match->equipe2) {
                $moi = 2;
                $participe = 1;
                break;
            }
        }
    } /*** le tournois est par joueur ***/
    elseif ($modeequipe_tournois == 'J' && $s_joueur) {
        $show = "show_joueur";
        $nom_participant = "nom_joueur";
        $champX = "pseudo";

        if ($s_joueur == $match->equipe1) {
            $moi = 1;
            $participe = 1;
        } elseif ($s_joueur == $match->equipe2) {
            $moi = 2;
            $participe = 1;
        }
    }

    if (!$participe) {
        $erreur = 1;
        $str .= "Ne participe pas!";
    }

    /*** test de la non reinsertion d'un score ***/
    $db->select("*");
    $db->from("${dbprefix}manches_report");
    $db->where("matchi = $id");
    $db->where("equipe = $moi");
    $manches = $db->exec();

    if ($db->num_rows($manches) != 0) {
        $erreur = 1;
        $str .= "Score deja rentré!";
    }

    if ($erreur == 1) {
        show_erreur($str);
    } else {

        if ($op == 'do_report') {

            /*** mise a jour des manches ***/
            foreach ($_POST as $key => $value) {

                preg_match("/^([a-z]+)_([0-9]+)$/", $key, $keylist);
                list(, $type, $manche) = $keylist;

                if ($type == 'map') {
                    $db->insert("${dbprefix}manches_report (id,matchi,equipe,score1,score2,statusequipe)");
                    $db->values("$manche,$id,'$moi','" . ${"score1_$manche"} . "','" . ${"score2_$manche"} . "','$statusequipe'");
                    $db->exec();
                }
            }

            /*** traitement des manches ***/
            /*$db->select("*");
            $db->from("${dbprefix}manches_report");
            $db->where("matchi = $id");
            $db->where("equipe = ".$moi%2 + 1);
            $manches=$db->exec();

            if($db->num_rows($manches)!=0) {


            }*/


        } else {

            /*** affichage de la popup ***/
            echo "<SCRIPT>
				function oneOrNoCheckboxGroup (checkbox) {
					var checkboxGroup = checkbox.form[checkbox.name];
					for (var c = 0; c < checkboxGroup.length; c++)
						if (checkboxGroup[c] != checkbox)
							checkboxGroup[c].checked = false;
				}
				</SCRIPT>";

            $seed2 = seed($match->equipe2, $match->tournois);
            $seed1 = seed($match->equipe1, $match->tournois);

            echo '<form name="form" method="post">';
            echo '<input type="hidden" name="op" value="do_report">';
            echo "<input type=\"hidden\" name=\"id\" value=\"$id\">";

            echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
            echo "<table cellspacing=1 cellpadding=0 border=0 class=fiche>";

            if ($match->type == 'P')
                echo "<tr><td class=headerfiche>$strMatch $strPoule $match->poule - $strTour $match->tour</td></tr>";
            elseif ($match->type == 'W' || $match->type == 'L') {
                if ($match->type == 'W') $type = $strWinner;
                elseif ($match->type == 'L') $type = $strLooser;

                if ($match->finale > 1)
                    echo "<tr><td class=headerfiche>$strMatch 1/$match->finale $strFinale $type #$match->numero</td></tr>";
                elseif ($match->finale == 1)
                    echo "<tr><td class=headerfiche>$strMatch $strFinale $type #$match->numero</td></tr>";
                else
                    echo "<tr><td class=headerfiche>$strMatch $strGrandFinal</td></tr>";
            }

            echo "<tr><td>";

            echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
            echo "<tr><td class=text colspan=5><img src=images/spacer.gif></td></tr>";
            echo "<tr>";

            echo "<td class=text align=left width=120>&nbsp;&nbsp;";
            echo $show($match->equipe1, '', '', $seed1);
            echo "</td>";

            echo show_score1($match->score1, $match->score2, $match->frags1, $match->frags2, $match->type, $match->status, $match->statusequipe, $match->modematchscore);
            echo "<td class=text align=center width=20>$strVS</td>";
            echo show_score2($match->score1, $match->score2, $match->frags1, $match->frags2, $match->type, $match->status, $match->statusequipe, $match->modematchscore);

            echo "<td class=text align=right width=120>";
            echo $show($match->equipe2, '', '', $seed2, 'right');
            echo "&nbsp;&nbsp;</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td class=text colspan=2 align=left>";
            echo "<input type=checkbox name=statusequipe value=F1 onclick=\"oneOrNoCheckboxGroup(this);\" style=\"border: 0px;background-color:transparent;\">$strForfait&nbsp;&nbsp;";
            echo "<input type=checkbox name=statusequipe value=D1  onclick=\"oneOrNoCheckboxGroup(this);\" style=\"border: 0px;background-color:transparent;\">$strDisqualifie";
            echo "</td>";
            echo "<td class=text></td>";
            echo "<td class=text colspan=2 align=right>";
            echo "$strDisqualifie<input type=checkbox name=statusequipe value=D2 onclick=\"oneOrNoCheckboxGroup(this);\" style=\"border: 0px;background-color:transparent;\">&nbsp;&nbsp;";
            echo "$strForfait<input type=checkbox name=statusequipe value=F2  onclick=\"oneOrNoCheckboxGroup(this);\" style=\"border: 0px;background-color:transparent;\">";
            echo "</td>";
            echo "</tr>";

            echo "<tr><td class=text colspan=5 align=center>";
            echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
            echo "<table cellspacing=1 cellpadding=2 border=0>";
            echo "<tr><td class=header>#</td><td class=header>$strMap</td><td class=header>$strScore 1</td><td class=header>$strScore 2</td></tr>";

            $db->select("*");
            $db->from("${dbprefix}manches");
            $db->where("matchi = $id");
            $db->order_by("id");
            $manches = $db->exec();

            for ($i = 1; $i <= $db->num_rows($manches); $i++) {

                $manche = $db->fetch($manches);
                echo "<input type=hidden name=\"map_$manche->id\" value=\"$manche->map\">";
                echo "<tr>";
                echo "<td class=text align=center>$manche->id</td>";
                echo "<td class=text>$manche->map</td>";
                echo "<td class=text align=center>";
                echo "<input type=text size=2 name=\"score1_$manche->id\" value=\"\">";
                echo "</td>";
                echo "<td class=text align=center>";
                echo "<input type=text size=2 name=\"score2_$manche->id\" value=\"\">";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</td></tr></table>";
            echo "<tr><td class=text colspan=5 align=center><input type=submit value=\"$strValider\"></td></tr>";
            echo "</td></tr>";
            echo "</table>";


            echo "</td></tr></table>";
            echo "</td></tr></table>";

            echo "</form>";
        }
    }

} /********************************************************
 * Affichage normal
 */
else {

    echo "<p class=title>.:: $strRapporterResultats ::.</p>";

    echo '<table cellspacing="0" cellpadding="0" border="0" class="liste">';

    /*** récupération de toutes les équipe du managers ***/
    $ids = '0,';
    if ($modeequipe_tournois == 'E') {

        $mesequipes = equipes_manager($s_joueur);

        for ($i = 0; $i < count($mesequipes); $i++) {
            $ids .= $mesequipes[$i]['id'] . ',';
        }
        $ids = substr($ids, 0, -1);
    }

    /*** rapport d'un score ***/
    echo "<tr><td class=\"title\" align=\"center\">$strMatchAttenteResultats :</td></tr>";
    echo '<tr><td><img src="images/spacer.gif" height="7" alt=""></td></tr>';
    echo '<tr><td align="center">';

    $db->select("id");
    $db->from("${dbprefix}matchs");
    $db->where("status = 'D'");
    $db->where("tournois = $s_tournois");
    if ($modeequipe_tournois == 'E') $db->where("(equipe1 IN ($ids) or equipe2 IN ($ids))");
    elseif ($modeequipe_tournois == 'J') $db->where("(equipe1 = '$s_joueur' or equipe2 = '$s_joueur')");
    $db->order_by("type, poule asc, tour asc, finale desc, numero asc, id asc");
    $res = $db->exec();

    if ($db->num_rows($res) != 0) {

        echo '<table cellspacing="0" cellpadding="1" border="0">';

        while ($matchs = $db->fetch($res)) {

            $match = match($matchs->id);

            $date = strftime(DATESTRING1, $match->date);
            if (!$match->date) $date = '';
            else $date = "- $date";

            echo "<tr>";

            /*** info1 ***/
            echo "<td class=info width=70><img src=images/spacer.gif></td>";

            /*** match ***/
            echo "<td class=info align=center>";
            show_match_poule($match->id, 'report');
            echo "</td>";

            /*** info2 ***/
            echo "<td class=info>&nbsp;&nbsp;";
            if ($match->type == 'W' || $match->type == 'L') {

                if ($match->type == 'W') $type = $strWinner;
                elseif ($match->type == 'L') $type = $strLooser;

                if ($match->finale > 1)
                    echo "1/$match->finale $strFinale $type #$match->numero";
                elseif ($match->finale == 1)
                    echo "$strFinale $type #$match->numero";
                else
                    echo "$strGrandFinal";

            } elseif ($match->type == 'P')
                echo "$strPoule $match->poule - $strTour $match->tour";
            echo "</td>";

            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo '<table cellspacing="0" cellpadding="0" border="0">';
        echo '<tr><td><img src="images/spacer.gif" height="2" alt=""></td></tr>';
        echo '<tr><td class="info" align="center" width="200">' . $strPasDeMatch . '</td></tr>';
        echo '</table>';
    }

    /*** validation d'un score ***/
    echo '<tr><td><img src="images/spacer.gif" height="20" alt=""></td></tr>';
    echo "<tr><td class=\"title\" align=\"center\">$strMatchAttenteValidation :</td></tr>";
    echo '<tr><td><img src="images/spacer.gif" height="7" alt=""></td></tr>';
    echo '<tr><td align="center">';

    $db->select("id");
    $db->from("${dbprefix}matchs");
    $db->where("status = 'V'");
    $db->where("tournois = $s_tournois");
    if ($modeequipe_tournois == 'E') $db->where("((equipe1 IN ($ids) and report = 2) or (equipe2 IN ($ids) and report = 1))");
    elseif ($modeequipe_tournois == 'J') $db->where("((equipe1 = '$s_joueur' and report = 2) or (equipe2 = '$s_joueur' and report = 1))");
    $db->order_by("type, poule asc, tour asc, finale desc, numero asc, id asc");
    $res = $db->exec();

    if ($db->num_rows($res) != 0) {

        echo '<table cellspacing="0" cellpadding="1" border="0">';

        while ($matchs = $db->fetch($res)) {

            $match = match($matchs->id);

            $date = strftime(DATESTRING1, $match->date);
            if (!$match->date) $date = '';
            else $date = "- $date";

            echo "<tr>";

            /*** info1 ***/
            echo "<td class=info width=70><img src=images/spacer.gif></td>";

            /*** match ***/
            echo "<td class=info align=center>";
            show_match_poule($match->id, 'report');
            echo "</td>";

            /*** info2 ***/
            echo "<td class=info>&nbsp;&nbsp;";
            if ($match->type == 'W' || $match->type == 'L') {

                if ($match->type == 'W') $type = $strWinner;
                elseif ($match->type == 'L') $type = $strLooser;

                if ($match->finale > 1)
                    echo "1/$match->finale $strFinale $type #$match->numero";
                elseif ($match->finale == 1)
                    echo "$strFinale $type #$match->numero";
                else
                    echo "$strGrandFinal";

            } elseif ($match->type == 'P')
                echo "$strPoule $match->poule - $strTour $match->tour";
            echo "</td>";

            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo '<table cellspacing="0" cellpadding="0" border="0">';
        echo '<tr><td><img src="images/spacer.gif" height="2" alt=""></td></tr>';
        echo '<tr><td class="info" align="center" width="200">' . $strPasDeMatch . '</td></tr>';
        echo '</table>';
    }


    echo '</table>';
    echo '</form><br>';

    show_consignes($strRapporterConsignes);

    echo '<img src="images/back.gif" border="0" align="absmiddle"> <a href="javascript:back()" class="action">' . $strRetour . '</a><br>';

}

?>

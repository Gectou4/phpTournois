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
if (preg_match("/matchs_list.php/i", $_SERVER['PHP_SELF'])) {
    die ("You cannot open this page directly");
}
/*** test de la session ***/
if (empty($s_tournois)) js_goto("?page=index");

/********************************************************
 * Affichage normal
 */

/*** verification securite ***/
if ($op == 'admin') verif_admin_tournois($s_joueur, $s_tournois, $grade['a'], $grade['b'], $grade['t']);

if (!isset($id)) $id = '';

if (($status != 'A' && $status != 'T' && $status != 'D') && $op != 'admin') $status = 'T';

if ($status == 'C') echo "<p class=\"title\">.:: $strMatchsCaches ::.</p>";
elseif ($status == 'A') echo "<p class=\"title\">.:: $strMatchsActifs ::.</p>";
elseif ($status == 'D') echo "<p class=\"title\">.:: $strMatchsEnCours ::.</p>";
elseif ($status == 'T') echo "<p class=\"title\">.:: $strMatchsTermines ::.</p>";

echo '<form name="liste" method="post" action="?page=matchs_gestion">';
echo "<input type=\"hidden\" name=\"status\" value=\"$status\">";
echo "<input type=\"hidden\" name=\"id\" value=\"$id\">";

// affichage du tableau de lancement
if ($op == 'admin') {
    echo '<table border=0 cellpadding="0" cellspacing="0" class="bordure2"><tr><td>';
    echo "<table cellspacing=1 cellpadding=0 border=0 align=center><tr><td>";
    echo '<table cellspacing="0" cellpadding="3" border="0" width="100%">';
    echo "<input type=hidden name=op value=>";
    echo "<input type=hidden name=opold value=liste>";
    echo "<input type=hidden name=tournois value=$s_tournois>";

    if ($modescore_tournois == 'M4') {
        echo '<tr><td class="text" align="center" colspan="8">';
        if ($status == 'C') echo "<input type=button value='$strActiverMatch' onclick=document.liste.op.value='activer';submit()>&nbsp;&nbsp;";
        if ($status == 'A') echo "<input type=button value='$strLancerMatchM4' onclick=document.liste.op.value='start';submit()>&nbsp;&nbsp;";
        if ($status == 'D') {
            echo "<input type=button value='$strRecupMatchM4' onclick=\"if(document.liste.autorecup.checked) { ouvrir_fenetre('?page=matchs_gestion&op=autorecup&tournois=$s_tournois&header=win','autorecup_$s_tournois',170,300);} else { document.liste.op.value='recup';submit();}\">";
            echo "<input type=checkbox name=autorecup>$strAuto";
        }
        echo "</td>";
        echo "</tr>";
        echo '<tr><td class="text" align="center" colspan="8"><a href="javascript:select_all(\'liste\')">' . $strToutSelectionner . '<a/> - <a href="javascript:unselect_all(\'liste\')">' . $strToutDeselectionner . '<a/></td></tr>';

        if ($status == 'A') {
            echo "<tr>";
            echo "<td class=text align=right>$strRule :</td><td class=text><input type=text name=m4rule value='$m4rulecfg' size=6></td>";
            echo "<td class=text align=right>$strCamps Terro :</td><td class=text><select name=m4camps><option value=0";
            if ($m4campscfg == 0) echo " SELECTED";
            echo ">$strAleatoire<option value=1";
            if ($m4campscfg == 1) echo " SELECTED";
            echo ">$strEquipe 1<option value=2";
            if ($m4campscfg == 2) echo " SELECTED";
            echo ">$strEquipe 2</select></td>";
            echo "<td class=text align=right>$strProlongation :</td><td class=text><input type=checkbox name=m4prolongation";
            if ($m4prolongationcfg == 1) echo " CHECKED";
            echo " style=\"border: 0px;background-color:transparent;\"></td>";
            echo "<td class=text align=right>$strAutoStart :</td><td class=text><input type=checkbox name=m4autostart";
            if ($m4autostartcfg == 1) echo " CHECKED";
            echo " style=\"border: 0px;background-color:transparent;\"></td>";
            echo "</tr>";
        }

    } elseif ($modescore_tournois == 'AB') {
        echo '<tr><td class="text" align="center" colspan="8">';
        if ($status == 'C') echo "<input type=button value='$strActiverMatch' onclick=document.liste.op.value='activer';submit()>&nbsp;&nbsp;";
        if ($status == 'A') echo "<input type=button value='$strLancerMatchAB' onclick=document.liste.op.value='start';submit()>&nbsp;&nbsp;";
        if ($status == 'D') {
            echo "<input type=button value='$strRecupMatchM4' onclick=\"if(document.liste.autorecup.checked) { ouvrir_fenetre('?page=matchs_gestion&op=autorecup&tournois=$s_tournois&header=win','autorecup_$s_tournois',170,300);} else { document.liste.op.value='recup';submit();}\">";
            echo "<input type=checkbox name=autorecup>$strAuto";
        }
        echo "</td>";
        echo "</tr>";
        echo '<tr><td class="text" align="center" colspan="8"><a href="javascript:select_all(\'liste\')">' . $strToutSelectionner . '<a/> - <a href="javascript:unselect_all(\'liste\')">' . $strToutDeselectionner . '<a/></td></tr>';
        if ($status == 'A') {
            echo "<tr>";
            echo "<td class=text align=right>$strRule :</td><td class=text><input type=text name=abrule value='$abrulecfg' size=6></td>";
            echo "<td class=text align=right>$strCamps Terro :</td><td class=text><select name=abcamps><option value=0";
            if ($abcampscfg == 0) echo " SELECTED";
            echo ">$strAleatoire<option value=1";
            if ($abcampscfg == 1) echo " SELECTED";
            echo ">$strEquipe 1<option value=2";
            if ($abcampscfg == 2) echo " SELECTED";
            echo ">$strEquipe 2</select></td>";
            echo "<td class=text align=right>$strProlongation :</td><td class=text><input type=checkbox name=abprolongation DISABLED style=\"border: 0px;background-color:transparent;\"></td>";
            echo "<td class=text align=right>$strAutoStart :</td><td class=text><input type=checkbox name=abautostart";
            if ($abautostartcfg == 1) echo " CHECKED";
            echo " style=\"border: 0px;background-color:transparent;\"></td>";
            echo "</tr>";
        }
    } else {
        if ($status == 'A' || $status == 'C') {
            echo "<tr><td class=text align=center>";
            if ($status == 'C') echo "<input type=button value='$strActiverMatch' onclick=document.liste.op.value='activer';submit()>&nbsp;&nbsp;";
            if ($status == 'A') echo "<input type=button value='$strLancerMatch' onclick=document.liste.op.value='start';submit()>";
            echo "</td>";
            echo "</tr>";
            echo '<tr><td class="text" align="center" colspan="8"><a href="javascript:select_all(\'liste\')">' . $strToutSelectionner . '<a/> - <a href="javascript:unselect_all(\'liste\')">' . $strToutDeselectionner . '<a/></td></tr>';
        }

    }

    echo "</table>";
    echo '</td></tr></table>';
    echo '</td></tr></table>';
    echo "<img src=images/story-7px.gif width=7 height=7><br>";
} else {
    // affichage du tableau des equipes
    if (isset($s_joueur)) {

        echo '<table cellspacing="0" cellpadding="0" border="0">';
        echo '<tr><td class="title" align="center">';
        echo "<a href=\"?page=matchs_liste&status=$status\">$strTous</a>";

        if ($modeequipe_tournois == 'E') {
            $mesequipes = equipes_joueur($s_joueur);

            for ($i = 0; $i < count($mesequipes); $i++) {
                echo " | <a href=\"?page=matchs_liste&status=$status&id=" . $mesequipes[$i]['id'] . "\">" . $mesequipes[$i]['tag'] . "</a>";
            }
        } else {
            echo " | <a href=\"?page=matchs_liste&status=$status&id=$s_joueur\">$strMoi</a>";
        }
        echo '</td></tr>';
        echo '</table><br>';
    }
}


/*** liste de tous les matchs du tournois ***/

/*** les poules ***/
echo '<table cellspacing="0" cellpadding="0" border="0" class="liste">';

if ($type_tournois == 'T' || $type_tournois == 'C') {
    echo "<tr><td class=\"title\" align=\"center\">$strMatchsPoules</td></tr>";
    echo '<tr><td align="center">';

    $last_tour = 0;

    $db->select("id,tour,poule,date");
    $db->from("${dbprefix}matchs");
    $db->where("type = 'P'");
    $db->where("status = '$status'");
    $db->where("tournois = $s_tournois");
    if (is_numeric($id)) $db->where("(equipe1 = $id or equipe2 = $id)");
    $db->order_by("tour asc, poule asc, id asc");
    $res = $db->exec();

    if ($db->num_rows($res) != 0) {

        echo '<table cellspacing="0" cellpadding="1" border="0">';

        while ($match = $db->fetch($res)) {

            if ($match->tour != $last_tour) {
                echo '<tr><td><img src="images/spacer.gif" height="7" alt=""></td></tr>';
                echo "<tr><td class=\"title\" colspan=\"3\"><u>$strTour $match->tour</u></td></tr>";
            }

            $date = strftime(DATESTRING1, $match->date);
            if (!$match->date) $date = '';
            else $date = "- $date";

            echo '<tr>';
            /*** info1 ***/
            //echo "<td class=info width=70>$date</td>";
            echo '<td class="info" align="right">';
            show_match_poule($match->id, $op);
            echo '</td>';
            /*** info2 ***/
            echo "<td class=info valign=top>&nbsp;&nbsp;";
            echo "$strPoule $match->poule $date ";
            echo "</td>";
            echo '</tr>';

            $last_tour = $match->tour;
        }
        echo '</table>';
    } else {
        echo '<table cellspacing="0" cellpadding="0" border="0">';
        echo '<tr><td><img src="images/spacer.gif" height="2" alt=""></td></tr>';
        echo '<tr><td class="info" align="center" width="200">' . $strPasDeMatch . '</td></tr>';
        echo '</table>';
    }

    echo '</td></tr>';
}

/*** les finales ***/
if ($type_tournois == 'T' || $type_tournois == 'E') {
    if ($type_tournois != 'E') echo '<tr><td><img src="images/spacer.gif" height="30" alt=""></td></tr>';
    echo "<tr><td class=\"title\" align=\"center\">$strMatchsFinales</td></tr>";
    echo '<tr><td align="center">';

    $last_finale = 0;
    $last_type = 0;

    $db->select("id,finale,numero,type,date");
    $db->from("${dbprefix}matchs");
    $db->where("(type = 'W' or type = 'L')");
    $db->where("status = '$status'");
    $db->where("tournois = $s_tournois");
    $db->where("finale <> 0"); // pas la grande finale
    $db->where("tournois = $s_tournois");
    if (isset($id) && is_numeric($id)) $db->where("(equipe1 = $id or equipe2 = $id)");
    $db->order_by("finale desc, type, numero asc, id asc");
    $res = $db->exec();

    if ($db->num_rows($res) != 0) {

        echo '<table cellspacing="0" cellpadding="1" border="0">';

        while ($match = $db->fetch($res)) {

            if ($match->finale != $last_finale || $match->type != $last_type) {
                echo '<tr><td><img src="images/spacer.gif" height="7" alt=""></td></tr>';
                echo '<tr><td class="title" colspan="3"><u>';

                if ($match->type == 'W') $type = $strWinner;
                elseif ($match->type == 'L') $type = $strLooser;

                if ($match->finale > 1)
                    echo "1/$match->finale $strFinale $type";
                elseif ($match->finale == 1)
                    echo "$strFinale $type";
                else
                    echo "$strGrandFinal";
                echo '</u></td></tr>';
            }

            $date = strftime(DATESTRING1, $match->date);
            if (!$match->date) $date = '';
            else $date = "- $date";

            echo '<tr>';
            /*** info1 ***/
            //echo "<td class=info width=70>$date</td>";
            echo '<td class="info" align="right">';
            show_match_poule($match->id, $op);
            echo '</td>';
            /*** info2 ***/
            echo "<td class=info>&nbsp;&nbsp;";
            echo "#$match->numero $date ";
            echo "</td>";
            echo '</tr>';

            $last_finale = $match->finale;
            $last_type = $match->type;
        }
        echo '</table>';
    } else {
        echo '<table cellspacing="0" cellpadding="0" border="0">';
        echo '<tr><td><img src="images/spacer.gif" height="2" alt=""></td></tr>';
        echo '<tr><td class="info" align="center" width="200">' . $strPasDeMatch . '</td></tr>';
        echo '</table>';
    }

    /** grande finale **/
    if ($modeelimination_tournois == 'D') {

        $db->select("id,date");
        $db->from("${dbprefix}matchs");
        $db->where("type = 'W'");
        $db->where("status = '$status'");
        $db->where("tournois = $s_tournois");
        $db->where("finale = 0"); //la grande finale
        $db->where("tournois = $s_tournois");
        if (isset($id) && is_numeric($id)) $db->where("(equipe1 = $id or equipe2 = $id)");
        $res = $db->exec();

        if ($db->num_rows($res) == 1) {

            $match = $db->fetch($res);

            echo '<tr><td><img src="images/spacer.gif" height="30" alt=""></td></tr>';
            echo "<tr><td class=\"title\" align=\"center\">$strGrandFinal</td></tr>";
            echo '<tr><td align="center"><br>';

            $date = strftime(DATESTRING1, $match->date);
            if (!$match->date) $date = '';

            echo '<table cellspacing="0" cellpadding="1" border="0">';
            echo '<tr>';
            /*** info1 ***/
            //echo "<td class=info width=70>$date</td>";
            echo '<td class="info" align="right">';
            show_match_poule($match->id, $op);
            echo '</td>';
            /*** info2 ***/
            echo "<td class=info valign=top>&nbsp;&nbsp;";
            echo "$date ";
            echo "</td>";
            echo '</tr>';
            echo '</table>';
        }
    }
}


echo '</table>';
echo '</form>';

echo '<br><img src="images/back.gif" border="0" align="absmiddle"> <a href="javascript:back()" class="action">' . $strRetour . '</a><br>';


?>

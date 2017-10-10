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
if (preg_match("/matchs_poules.php/i", $_SERVER['PHP_SELF'])) {
    die ("You cannot open this page directly");
}
/*** test de la session ***/
if (empty($s_tournois)) js_goto("?page=index");

/********************************************************
 * Generation des matchs d'une poules
 */
/*
result= tab[journée][matchN°][x]
journée : numero de la journee (1<->nbequipes)
matchN° : numero du match (1<->nbequipes/2)
x : equipe du match (1 || 2)
resulr : numero de l'equipe dans la poule (1<->nbequipes)

*/
function generer_match($nb_equipe)
{
    $tableau_equipe = generer_tableau($nb_equipe);

    if ($nb_equipe & 1) // Cas impair : on rajoute l'equipe 0 inexistante
        $tableau_equipe[$nb_equipe++] = 0;

    $nb_journees = $nb_equipe - 1;

    for ($jour = 1; $jour <= $nb_journees; $jour++) {
        $tableau_equipe = tourne($tableau_equipe, $nb_equipe);
        $result[$jour] = generer_journee($tableau_equipe, $nb_equipe);

    }
    return $result;
}

function generer_tableau($nb_equipe)
{
    for ($i = 0; $i <= $nb_equipe; $i++)
        $tableau_equipe[$i] = $i + 1;

    return $tableau_equipe;
}


function tourne($tableau_equipe, $nb_equipe)
{
    $temp = $tableau_equipe[1];
    for ($i = 2; $i < $nb_equipe / 2; $i++)
        $tableau_equipe[$i - 1] = $tableau_equipe[$i];
    $tableau_equipe[$i - 1] = $tableau_equipe[$nb_equipe - 1];
    for ($i = $nb_equipe - 2; $i >= $nb_equipe / 2; $i--)
        $tableau_equipe[$i + 1] = $tableau_equipe[$i];
    $tableau_equipe[$nb_equipe / 2] = $temp;

    return $tableau_equipe;
}


function generer_journee($tableau_equipe, $nb_equipe)
{
    for ($num_match = 0; $num_match < $nb_equipe / 2; $num_match++) {
        $journee[$num_match + 1][1] = $tableau_equipe[$num_match];
        $journee[$num_match + 1][2] = $tableau_equipe[$num_match + $nb_equipe / 2];
    }
    return $journee;
}


/********************************************************
 * Generer tous les matchs
 */
if ($op == "generate") {

    /*** verification securite ***/
    verif_admin_tournois($s_joueur, $s_tournois, $grade['a'], $grade['b'], $grade['t']);

    /*** effacement des matchs de poules ***/
    $db->select("id");
    $db->from("${dbprefix}matchs");
    $db->where("type = 'P'");
    $db->where("tournois = $s_tournois");
    $db->exec();

    while ($match = $db->fetch()) {
        $db->delete("${dbprefix}manches");
        $db->where("matchi = $match->id");
        $db->exec();
    }

    $db->delete("${dbprefix}matchs");
    $db->where("type = 'P'");
    $db->where("tournois = $s_tournois");
    $db->exec();

    for ($j = 1; $j <= $nb_poules_tournois; $j++) {
        $i = 1;
        $db->select("equipe");
        $db->from("${dbprefix}participe");
        $db->where("poule = $j");
        $db->where("tournois = $s_tournois");
        $db->exec();

        while ($row = $db->fetch()) {
            $poules[$j][$i] = $row->equipe;
            $i++;
        }

        // generation de tous les tours de la poules
        $nb_equipes = nb_equipes_poule($j, $s_tournois);

        $matchs = generer_match($nb_equipes);
        $nb_tours = count($matchs);
        $nb_matchs_par_tour = count($matchs[1]);

        for ($tour = 1; $tour <= $nb_tours; $tour++) {
            for ($num_match = 1; $num_match <= $nb_matchs_par_tour; $num_match++) {
                $equipeX1 = $matchs[$tour][$num_match][1];
                $equipeX2 = $matchs[$tour][$num_match][2];

                // si un match est vide (poule impaire)
                if ($equipeX1 == 0 || $equipeX2 == 0) continue;

                /*** declaration du match du tour ***/
                $db->insert("${dbprefix}matchs (equipe1,equipe2,type,poule,tour,tournois)");
                $db->values("'" . $poules[$j][$equipeX1] . "','" . $poules[$j][$equipeX2] . "','P',$j,$tour,$s_tournois");
                $db->exec();

            }
        }
    }

    /*** redirection ***/
    js_goto("?page=maps_tournois");

} /********************************************************
 * Affichage admin et normal
 */
else {

    /*** verification securite ***/
    if ($op == 'admin') verif_admin_tournois($s_joueur, $s_tournois, $grade['a'], $grade['b'], $grade['t']);

    //if((!isset($status) && $op !='admin') || $op !='admin') $status='T';
    if (!isset($x)) $x = '';

    if ($op == 'admin') echo "<p class=\"title\">.:: $strAdminMatchsPoules ::.</p>";
    else echo "<p class=\"title\">.:: $strResultatsMatchsPoules ::.</p>";

    echo '<form name="poules" method="post" action="?page=matchs_gestion">';
    echo "<input type=\"hidden\" name=\"x\" value=\"$x\">";

    // affichage du tableau de lancement
    if ($op == 'admin') {
        echo '<table border=0 cellpadding="0" cellspacing="0" class="bordure2"><tr><td>';
        echo "<table cellspacing=1 cellpadding=0 border=0 align=center><tr><td>";
        echo '<table cellspacing="0" cellpadding="3" border="0" width="100%">';
        echo '<input type="hidden" name="op" value="">';
        echo '<input type="hidden" name="opold" value="poules">';
        echo "<input type='hidden' name='tournois' value='$s_tournois'>";

        if ($modescore_tournois == 'M4') {
            echo '<tr>';
            echo '<td class="text" align="center" colspan="8">';
            echo "<input type=button value='$strActiverMatch' onclick=document.poules.op.value='activer';submit()>&nbsp;&nbsp;";
            echo "<input type=button value='$strLancerMatchM4' onclick=document.poules.op.value='start';submit()>&nbsp;&nbsp;";
            echo "<input type=button value='$strRecupMatchM4' onclick=\"if(document.poules.autorecup.checked) { ouvrir_fenetre('?page=matchs_gestion&op=autorecup&tournois=$s_tournois&header=win','autorecup_$s_tournois',170,300);} else { document.poules.op.value='recup';submit();}\">";
            echo "<input type=checkbox name=autorecup>$strAuto";
            echo "</td>";
            echo "</tr>";
            echo '<tr><td class="text" align="center" colspan="8"><a href="javascript:select_all(\'poules\')">' . $strToutSelectionner . '<a/> - <a href="javascript:unselect_all(\'poules\')">' . $strToutDeselectionner . '<a/></td></tr>';
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
        } elseif ($modescore_tournois == 'AB') {
            echo '<tr>';
            echo '<td class="text" align="center" colspan="8">';
            echo "<input type=button value='$strActiverMatch' onclick=document.poules.op.value='activer';submit()>&nbsp;&nbsp;";
            echo "<input type=button value='$strLancerMatchAB' onclick=document.poules.op.value='start';submit()>&nbsp;&nbsp;";
            echo "<input type=button value='$strRecupMatchAB' onclick=\"if(document.poules.autorecup.checked) { ouvrir_fenetre('?page=matchs_gestion&op=autorecup&tournois=$s_tournois&header=win','autorecup_$s_tournois',170,300);} else { document.poules.op.value='recup';submit();}\">";
            echo "<input type=checkbox name=autorecup>$strAuto";
            echo "</td>";
            echo "</tr>";
            echo '<tr><td class="text" align="center" colspan="8"><a href="javascript:select_all(\'poules\')">' . $strToutSelectionner . '<a/> - <a href="javascript:unselect_all(\'poules\')">' . $strToutDeselectionner . '<a/></td></tr>';
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
        } else {
            echo "<tr><td class=text align=center><input type=button value='$strActiverMatch' onclick=document.poules.op.value='activer';submit()>&nbsp;&nbsp;<input type=button value='$strLancerMatch' onclick=document.poules.op.value='start';submit()></td></tr>";
            echo '<tr><td class="text" align="center" colspan="8"><a href="javascript:select_all(\'poules\')">' . $strToutSelectionner . '<a/> - <a href="javascript:unselect_all(\'poules\')">' . $strToutDeselectionner . '<a/></td></tr>';
        }

        echo "</table>";
        echo '</td></tr></table>';
        echo '</td></tr></table>';
        echo "<img src=images/story-7px.gif width=7 height=7><br>";
    }

    /*** navigateur ***/
    echo '<table cellspacing="0" cellpadding="2" border="0"><tr>';
    echo "<td class=\"text\" align=\"center\">$strPoules :</td>";
    if ($op) $op_str = "&op=$op";
    else $op_str = '';

    for ($i = 1; $i <= $nb_poules_tournois; $i++) {
        echo "<td class=\"text\" align=\"center\"><a href=\"?page=matchs_poules$op_str&x=$i\">$i</a> - </td>";
    }
    echo "<td class=\"header\" align=\"center\"><small><a href=\"?page=matchs_poules$op_str\">$strToutes</small></a></td>";
    echo '</tr></table><br>';

    /*** liste de tous les matchs ***/
    $i = 0;
    echo '<table cellspacing="0" cellpadding="0" border="0">';

    for ($p = 1; $p <= $nb_poules_tournois; $p++) {

        if ($x) {
            if ($x != $p) continue;
            $p = $x;
            $config['col_matchs_poules'] = 1;
        }

        if ($i % $config['col_matchs_poules'] == 0) echo '<tr valign="top">';

        echo '<td align="center">';
        echo '<table cellspacing="0" cellpadding="0" border="0" class="liste">';
        echo "<tr><td class=\"title\" align=\"center\">$strPoule $p [<a href=\"?page=poules&x=$p\" class=action>$strTableau</a>]</td></tr>";
        echo '<tr><td align="center">';

        $nb_tours = nb_tours($p, $s_tournois);
        $last_tour = 0;
        $nb_matchs = 0;

        for ($t = 1; $t <= $nb_tours; $t++) {

            echo '<table cellspacing="0" cellpadding="1" border="0">';

            $tab_matchs_id = array();
            $tab_matchs_id = id_match_poule($p, $t, $s_tournois, $op, $status);

            /** si il y a des match pour la poule on affiche les tour**/
            if (count($tab_matchs_id) != 0) {

                echo '<tr><td><img src="images/spacer.gif" height="2" alt=""></td></tr>';
                echo "<tr><td class=\"title\"><u>$strTour $t</u></td></tr>";

                for ($j = 0; $j < count($tab_matchs_id); $j++) {
                    echo '<tr>';
                    echo '<td class="info" align="right">';
                    show_match_poule($tab_matchs_id[$j], $op);
                    echo '</td>';
                    echo '</tr>';

                    $nb_matchs++;
                }
            }
            echo '</table>';
        }

        /** si il n"y a pas de match pour la poules **/
        if ($nb_matchs == 0) {
            echo '<table cellspacing="0" cellpadding="0" border="0">';
            echo '<tr><td><img src="images/spacer.gif" height="2" alt=""></td></tr>';
            echo '<tr><td class="info" align="center" width="200">' . $strPasDeMatch . '</td></tr>';
            echo '</table>';

        }
        echo '</td></tr></table>';
        echo '</td>';

        if ($i % $config['col_matchs_poules'] == $config['col_matchs_poules'] - 1) echo '</tr>';
        $i++;
    }
    echo '</table>';
    echo '</form>';

    echo '<img src="images/back.gif" border="0" align="absmiddle"> <a href="javascript:back()" class="action">' . $strRetour . '</a><br>';
}

?>

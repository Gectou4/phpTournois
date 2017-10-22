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
if (preg_match("/matchs_finales.php/i", $_SERVER['PHP_SELF'])) {
    die ("You cannot open this page directly");
}
/*** test de la session ***/
if (empty($s_tournois)) js_goto("index.php");


/********************************************************
 * Generer tous les matchs
 */
if ($op == "generate") {

    /*** verification securite ***/
    verif_admin_tournois($s_joueur, $s_tournois, $grade['a'], $grade['b'], $grade['t']);

    $finale = $nb_finales_winner_tournois;

    /*** effacement des manches match de la phase finale winner ***/
    $db->select("id");
    $db->from("${dbprefix}matchs");
    $db->where("type = 'W'");
    $db->where("tournois = $s_tournois");
    $res = $db->exec();

    while ($match = $db->fetch($res)) {
        $db->delete("${dbprefix}manches");
        $db->where("matchi = $match->id");
        $db->exec();
    }

    /*** effacement des match de la phase finale winner - la 1ere***/
    $db->delete("${dbprefix}matchs");
    $db->where("type = 'W'");
    $db->where("finale != $finale");
    $db->where("tournois = $s_tournois");
    $db->exec();

    /*** effacement des manches de la phase finale looser + gf***/
    $db->select("id");
    $db->from("${dbprefix}matchs");
    $db->where("(type = 'L' or (type = 'W' and finale=0))");
    $db->where("tournois = $s_tournois");
    $res = $db->exec();

    while ($match = $db->fetch($res)) {
        $db->delete("${dbprefix}manches");
        $db->where("matchi = $match->id");
        $db->exec();
    }

    /*** effacement des matchs de la phase finale looser + gf ***/
    $db->delete("${dbprefix}matchs");
    $db->where("tournois = $s_tournois");
    $db->where("(type = 'L'  or (type = 'W' and finale=0))");
    $db->exec();


    /*** creation des match de la phase finale winner - la 1 ere***/
    $finales_winner = $nb_finales_winner_tournois / 2;

    while ($finales_winner >= 1) {
        for ($i = 1; $i <= $finales_winner; $i++) {
            $db->insert("${dbprefix}matchs (type,finale,numero,tournois,status)");
            $db->values("'W',$finales_winner,$i,$s_tournois,'C'");
            $db->exec();
        }
        $finales_winner = $finales_winner / 2;
    }

    /*** creation des match de la phase finale looser***/
    if ($modeelimination_tournois == "D") {
        $finales_looser = $nb_finales_looser_tournois / 2;

        while ($finales_looser >= 1) {
            for ($i = 1; $i <= ($finales_looser) * 2; $i++) {

                //if($serveur>$finales_looser*2) $serveur=$finales_looser+1;

                $db->insert("${dbprefix}matchs (type,finale,numero,tournois,status)");
                $db->values("'L',$finales_looser,$i,$s_tournois,'C'");
                $db->exec();

                //$serveur++;
            }
            $finales_looser = $finales_looser / 2;
        }

        /*** creation de la grand final***/
        $db->insert("${dbprefix}matchs (type,finale,numero,tournois,status)");
        $db->values("'W',0,1,$s_tournois,'C'");
        $db->exec();

    }

    /*** redirection ***/
    js_goto("?page=maps_tournois");
} /********************************************************
 * Affichage admin + normal
 */
else {

    /*** verification securite ***/
    if ($op == "admin") verif_admin_tournois($s_joueur, $s_tournois, $grade['a'], $grade['b'], $grade['t']);

    if ($op == 'admin') echo "<p class=title>.:: $strAdminFinales ::.</p>";
    else echo "<p class=title>.:: $strResultatsFinales ::.</p>";

    if (!isset($status)) $status = '';
    if (!isset($x)) $x ='';

    // calcul global des parametres de l'arbre
    $nb_x_total = log($nb_finales_winner_tournois) / log(2);
    if ($modeelimination_tournois == 'D') $nb_x_total++;

    //echo "nb_x_total: $nb_x_total|";

    // calcul des decalages au debut (suivant le type d'arbre)
    if (is_numeric($x)) {
        if ($modeelimination_tournois == 'S') {
            $delta = $config['x_delta_simple'];
        } else {
            $delta = $config['x_delta_double'];
        }

        if ($x <= 0) $x = 0;
        elseif ($x >= $nb_x_total) $x = $nb_x_total;

        $nb_finales_winner = $nb_finales_winner_tournois / pow(2, (int)$x);
    } else {
        $nb_finales_winner = $nb_finales_winner_tournois;
    }

//	echo " nb_finales_winner : $nb_finales_winner|";

    $nb_row_winner = $nb_finales_winner * 2;

    $nb_col = 2 * (log($nb_finales_winner) / log(2) + 1);  // 1 col match + 1 col img

    if ($modeelimination_tournois == 'D') $nb_col++; // 1 de plus pour la grande finale

    // calcul des decalages a la fin
    if (is_numeric($x)) {

        if ($nb_col - $delta > 0) $nb_col = $delta * 2;
    }

    //echo " nb_col :$nb_col|";

    // cacul du nombre de lignes
    if ($modeelimination_tournois == 'S') {
        $nb_row = $nb_row_winner - 1;
        $last_finale = 1;
    } else {
        $nb_row_looser = $nb_finales_looser_tournois - 1;
        $nb_row = $nb_row_winner + $nb_row_looser;
        $last_finale = 0;
    }
    echo '<!-- DEBUT DE LA GENERATION DE L\'ARBRE -->';

    // affichage winner/looser
    echo '<form name="finales" method="post" action="?page=matchs_gestion">';
    echo "<input type=\"hidden\" name=\"x\" value=\"$x\">";


    if ($op == 'admin') {
        echo '<table border=0 cellpadding="0" cellspacing="0" class="bordure2"><tr><td>';
        echo "<table cellspacing=1 cellpadding=0 border=0 align=center><tr><td>";
        echo '<table cellspacing="0" cellpadding="3" border="0" width="100%">';
        echo "<input type=hidden name=op value=>";
        echo "<input type=hidden name=opold value=finales>";
        echo "<input type=hidden name=tournois value=$s_tournois>";

        if ($modescore_tournois == 'M4') {
            echo "<tr><td class=text align=center colspan=8>";
            echo "<input type=button value='$strActiverMatch' onclick=document.finales.op.value='activer';submit()>&nbsp;&nbsp;";
            echo "<input type=button value='$strLancerMatchM4' onclick=document.finales.op.value='start';submit()>&nbsp;&nbsp;";
            echo "<input type=button value='$strRecupMatchM4' onclick=\"if(document.finales.autorecup.checked) { ouvrir_fenetre('?page=matchs_gestion&op=autorecup&tournois=$s_tournois&header=win','autorecup_$s_tournois',170,300);} else { document.finales.op.value='recup';submit();}\">";
            echo "<input type=checkbox name=autorecup>$strAuto";
            echo "</td>";
            echo "</tr>";
            echo '<tr><td class="text" align="center" colspan="8"><a href="javascript:select_all(\'finales\')">' . $strToutSelectionner . '<a/> - <a href="javascript:unselect_all(\'finales\')">' . $strToutDeselectionner . '<a/></td></tr>';
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
            echo "<tr><td class=text align=center colspan=8>";
            echo "<input type=button value='$strActiverMatch' onclick=document.finales.op.value='activer';submit()>&nbsp;&nbsp;";
            echo "<input type=button value='$strLancerMatchAB' onclick=document.finales.op.value='start';submit()>&nbsp;&nbsp;";
            echo "<input type=button value='$strRecupMatchAB' onclick=\"if(document.finales.autorecup.checked) { ouvrir_fenetre('?page=matchs_gestion&op=autorecup&tournois=$s_tournois&header=win','autorecup_$s_tournois',170,300);} else { document.finales.op.value='recup';submit();}\">";
            echo "<input type=checkbox name=autorecup>$strAuto";
            echo "</td>";
            echo "</tr>";
            echo '<tr><td class="text" align="center" colspan="8"><a href="javascript:select_all(\'finales\')">' . $strToutSelectionner . '<a/> - <a href="javascript:unselect_all(\'finales\')">' . $strToutDeselectionner . '<a/></td></tr>';
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
            echo "<tr><td class=text align=center><input type=button value='$strActiverMatch' onclick=document.finales.op.value='activer';submit()>&nbsp;&nbsp;<input type=button value='$strLancerMatch' onclick=document.finales.op.value='start';submit()></td></tr>";
            echo '<tr><td class="text" align="center" colspan="8"><a href="javascript:select_all(\'finales\')">' . $strToutSelectionner . '<a/> - <a href="javascript:unselect_all(\'finales\')">' . $strToutDeselectionner . '<a/></td></tr>';
        }

        echo "</table>";
        echo '</td></tr></table>';
        echo '</td></tr></table>';
        echo "<img src=images/story-7px.gif width=7 height=7><br>";
    }

    if ($op) $op_str = "&op=$op";
    else $op_str = '';

    // affichage du navigateur
    echo '<table cellspacing="0" cellpadding="2" border="0">';
    echo '<tr>';
    echo "<td class=\"text\"><a href=\"?page=matchs_finales&x=0$op_str\"><img src=\"images/back.gif\" border=\"0\"><img src=\"images/back.gif\" border=\"0\"></a></td>";
    echo "<td class=\"text\"><a href=\"?page=matchs_finales&x=" . (((int)$x) - 1) . "$op_str\"><img src=\"images/back.gif\" border=\"0\"></a></td>";
    echo "<td class=\"header\"><small><a href=\"?page=matchs_finales$op_str\">$strTout</a></small></td>";
    echo "<td class=\"text\"><a href=\"?page=matchs_finales&x=" . (((int)$x) + 1) . "$op_str\"><img src=\"images/next.gif\" border=\"0\"></a></td>";
    echo "<td class=\"text\"><a href=\"?page=matchs_finales&x=" . $nb_x_total . "$op_str\"><img src=\"images/next.gif\" border=\"0\"><img src=\"images/next.gif\" border=\"0\"></a></td>";
    echo '</tr>';
    echo '</table>';

    echo '<img src="images/story-7px.gif" width="7" height="7"><br>';

    echo '<table cellspacing="0" cellpadding="0" border="0">';
    echo '<tr>';

    // les headers:
    $finale = $nb_finales_winner;
    for ($f = 0; $f < $nb_col; $f++) {
        if ($f % 2 == 0) {
            if ($finale > 1)
                echo "<td class=\"info\" align=\"center\"><b><u>1/$finale $strFinale</u></b></td>";
            elseif ($finale == 1) {
                echo "<td class=\"info\" align=\"center\"><b><u>$strFinale</u></b></td>";

                if ($modeelimination_tournois == 'S') {
                    $id_grandfinale = id_match_finale('W', 1, 1, $s_tournois, $op, $status);

                    if (match_fini($id_grandfinale)) echo "<td class=\"info\" colspan=\"2\" align=\"center\"><b><u>$strVainqueur</u></b></td>";
                }
            } else {

                if ($modeelimination_tournois == 'D') {
                    echo "<td class=\"info\" align=\"center\"><b><u>$strGrandFinal</u></b></td>";
                    $id_grandfinale = id_match_finale('W', 0, 1, $s_tournois, $op, $status);

                    if (match_fini($id_grandfinale)) echo "<td class=\"info\" colspan=\"2\" align=\"center\"><b><u>$strVainqueur</u></b></td>";

                }
            }
            $finale /= 2;
        } else
            echo '<td align="center"><img src="images/spacer.gif"></td>';

    }
    echo '</tr>';
    echo '<tr><td align="center" colspan="' . $nb_col . '">&nbsp;</td></tr>';

    // l'arbre:
    // parcours par ligne du tableau
    for ($e = 1; $e <= $nb_row; $e++) {
        $finale = $nb_finales_winner;

        echo '<tr>';

        // parcours par colonne du tableau
        for ($f = 1; $f < $nb_col / 2 + 1; $f++) {

            $finale = floor($finale);
            //${"numero$finale"}='';
            //echo $finale;

            // WINNER
            if ($e <= $nb_row_winner) {

                // case pleine winner
                if (($e) % pow(2, $f) == pow(2, $f - 1)) {

                    $numero = ++${"numero$finale"};

                    if ($finale >= $last_finale) {

                        // case match winner
                        echo '<td align="left">';
                        echo '<table cellspacing="0" cellpadding="0" border="0" width="100%">';
                        echo '<tr><td class="info" align="center">';
                        $id = id_match_finale('W', $finale, $numero, $s_tournois, $op, $status);
                        show_match_finale($id, $op);
                        echo "</td>";

                        if ($numero % 2 == 1)
                            echo '<td background="images/arbre_ligneH.gif" style="background-repeat: repeat-x;background-position: bottom;" width=100%><img src="images/spacer.gif"></td>';
                        else
                            echo '<td background="images/arbre_ligneH.gif" style="background-repeat: repeat-x;background-position: top;" width=100%><img src="images/spacer.gif"></td>';

                        echo '</tr></table>';
                        echo '</td>';
                        // end case match

                        // calcul du tree (et du vaingeur si besoin est)
                        if ($finale > 1) {
                            if ($numero % 2 == 1)
                                echo '<td background="images/arbre_coinhaut.gif" style="background-repeat: no-repeat;background-position: bottom;"><img src="images/spacer.gif"></td>';
                            else
                                echo '<td background="images/arbre_coinbas.gif" style="background-repeat: no-repeat;background-position: top;"><img src="images/spacer.gif"></td>';
                        } elseif ($finale == 1) {
                            if ($modeelimination_tournois == 'S') {

                                $id_finale_winner = id_match_finale('W', 1, 1, $s_tournois, $op, $status);

                                if (match_fini($id_finale_winner)) {
                                    $equipe_g = equipe_gagnante($id_finale_winner);

                                    echo '<td background=images/arbre_ligneH.gif style="background-position: center;"><img src=images/spacer.gif></td>';
                                    echo '<td valign="middle">';
                                    echo '<table cellspacing="2" cellpadding="5" width="100%" border="0" height="30">';
                                    echo '<tr>';
                                    echo '<td class="header" width="120"><img src="images/smallcup.gif" align="absmiddle"> ' . $show($equipe_g, $op, '') . '</td>';
                                    echo '</tr>';
                                    echo '</table>';
                                    echo '</td>';
                                }
                            } else
                                echo '<td background="images/arbre_coinhaut.gif" style="background-repeat: no-repeat;background-position: bottom;"><img src="images/spacer.gif"></td>';
                        } elseif ($finale == 0) {

                            $id_grandfinale = id_match_finale('W', 0, 1, $s_tournois, $op, $status);

                            if (match_fini($id_grandfinale)) {
                                $equipe_g = equipe_gagnante($id_grandfinale);

                                echo '<td background=images/arbre_ligneH.gif style="background-position: center;"><img src=images/spacer.gif></td>';
                                echo '<td valign=middle>';
                                echo '<table cellspacing="2" cellpadding="5" width="100%" border="0" height="30">';
                                echo '<tr>';
                                echo '<td class="header" width="120" nowrap><img src="images/smallcup.gif" align="absmiddle"> ' . $show($equipe_g, $op, '') . '</td>';
                                echo '</tr>';
                                echo '</table>';
                                echo '</td>';
                            }
                        }
                    }
                } // case T
                else if (($e) % pow(2, $f + 1) == pow(2, $f)) {
                    if (!($finale == 1 && $modeelimination_tournois == 'S')) {
                        echo '<td align="center"><img src="images/spacer.gif"></td>';
                        echo '<td align="right" background="images/arbre_ligneV.gif"><img src="images/arbre_T.gif"></td>';
                    } else {
                        echo '<td align="center"><img src="images/spacer.gif"></td>';
                        echo '<td align="center"><img src="images/spacer.gif"></td>';
                    }
                } // case |
                else if (${"numero$finale"} % 2 == 1) {
                    if (!($finale == 1 && $modeelimination_tournois == 'S')) {
                        echo '<td height="40" align="center"><img src="images/spacer.gif"></td>';
                        echo '<td background="images/arbre_ligneV.gif" style="background-repeat: repeat-y;"><img src="images/spacer.gif"></td>';
                    } else {
                        echo '<td height="40" align="center"><img src="images/spacer.gif"></td>';
                        echo '<td height="40" align="center"><img src="images/spacer.gif"></td>';
                    }
                } // case vide
                else {
                    echo '<td align="center" height="40"><img src="images/spacer.gif"></td>';
                    echo '<td align="center" height="40"><img src="images/spacer.gif"></td>';
                }
            } // LOOSER
            else {

                // skip des 1ere cases (pour decaler le looser)
                if ($finale > $nb_finales_looser_tournois / 2) {
                    echo '<td align="center"><img src="images/spacer.gif"></td>';
                    echo '<td align="center"><img src="images/spacer.gif"></td>';
                } else {
                    // changement du referentiel
                    $col = log($nb_finales_winner / $nb_finales_looser_tournois) / log(2) + 1;

                    // case pleine looser
                    if (($e - $nb_row_winner) % pow(2, $f - $col) == pow(2, $f - 1 - $col)) {
                        if ($finale >= 1) {
                            $numero = ++${"numeroL$finale"};
                            $numero2 = $numero + $finale;

                            echo '<td align=left>';

                            // case match looser 1
                            echo '<table cellspacing="0" cellpadding="0" border="0" width="100%"><tr>';
                            echo '<td>';
                            $id = id_match_finale('L', $finale, $numero, $s_tournois, $op, $status);
                            show_match_finale($id, $op);
                            echo '</td>';
                            // end case match 1

                            echo '<td valign="bottom"><img src="images/arbre_ligneH2.gif"></td>';

                            // case match looser 2
                            echo '<td align="left">';
                            $id = id_match_finale('L', $finale, $numero2, $s_tournois, $op, $status);
                            show_match_finale($id, $op);
                            echo '</td>';

                            // end match
                            echo '</td>';
                            if ($numero % 2 == 1)
                                echo '<td background="images/arbre_ligneH.gif" style="background-repeat: repeat-x;background-position: bottom;" width=100%><img src="images/spacer.gif"></td>';
                            else
                                echo '<td background="images/arbre_ligneH.gif" style="background-repeat: repeat-x;background-position: top;" width=100%><img src="images/spacer.gif"></td>';
                            echo '</tr></table>';
                            // end case match 2

                            echo '</td>';
                            // calcul du tree apres un match

                            if ($finale > 1) {
                                if ($numero % 2 == 1)
                                    echo '<td background="images/arbre_coinhaut.gif" style="background-repeat: no-repeat;background-position: bottom;"><img src="images/spacer.gif"></td>';
                                else
                                    echo '<td background="images/arbre_coinbas.gif" style="background-repeat: no-repeat;background-position: top;"><img src="images/spacer.gif"></td>';
                            } else if ($finale == 1) echo '<td background="images/arbre_coinbas.gif" style="background-repeat: no-repeat;background-position: top;"><img src="images/spacer.gif"></td>';
                        }
                    } // case T
                    else if (($e - $nb_row_winner) % pow(2, $f + 1 - $col) == pow(2, $f - $col)) {
                        echo '<td height="40" align="center"><img src="images/spacer.gif"></td>';
                        echo '<td align="right" background="images/arbre_ligneV.gif"><img src="images/arbre_T.gif"></td>';
                    } //case |
                    else if ((${"numeroL$finale"} % 2 == 1 && $finale > 1) || (${"numeroL$finale"} % 2 == 0 && $finale == 1)) {
                        echo '<td height="40" align="center"><img src="images/spacer.gif"></td>';
                        echo '<td background="images/arbre_ligneV.gif" style="background-repeat: repeat-y;"><img src=images/spacer.gif></td>';
                    } else {
                        echo '<td height="40" align="center"><img src="images/spacer.gif"></td>';
                        echo '<td height="40" align="center"><img src="images/spacer.gif"></td>';
                    }
                }
            }

            //$finale /= 2;
            $finale = $finale / 2;
        }
        echo '</tr>';
    }
    echo '</table>';
    /*echo '</td>';
    if($x>=0 && $x<$nb_x_total) echo "<td class=\"navigation_arbre_droite\" onclick=\"document.location='?page=matchs_finales&x=".($x+1)."$op_str'\">&nbsp;&nbsp;</TD>";
      else echo '<td>&nbsp;</td>';
      echo '</tr>';
      echo '</table>';*/
    echo '<br><div align="center"><input type="button" value="' . $strEXPORT_tree . '" Onclick="document.location=\'?page=matchs_finales_exp\';"></div>';
    echo '</form>';
    echo '<!-- FIN DE LA GENERATION DE L\'ARBRE -->';

    echo '<img src="images/back.gif" border="0" align="absmiddle"> <a href="javascript:back()" class="action">' . $strRetour . '</a><br>';

}

?>

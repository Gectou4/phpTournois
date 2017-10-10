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

if (preg_match("/maps_tournois.php/", $_SERVER['PHP_SELF'])) {
    die ("You cannot open this page directly");
}

/*** test de la session ***/
if (empty($s_tournois)) js_goto("?page=index");

/*** verification securite ***/
if ($grade['a'] != 'a' && $grade['b'] != 'b' && $grade['t'] != 't' && $grade['u'] != 'u') {
    js_goto($PHP_SELF);
}


/********************************************************
 * Enregistrement des Maps du tournois
 */
if ($op == "modify") {

    // si il y a de maps selectionées
    if (count($_POST) != 0) {

        foreach ($_POST as $key => $value) {

            preg_match("/^([A-Z])([0-9]+)_1$/", $key, $keylist);
            list(, $type, $tour) = $keylist;

            if (($type == 'P' || $type == 'L' || $type == 'W')) {

                if ($type == 'W') {
                    $finale = $tour;
                    $numero = "";
                } elseif ($type == 'L') {
                    $finale = substr($tour, 0, -1);
                    $numero = substr($tour, -1);
                }

                $tab_maps = array();

                /*** empilage des maps ***/
                for ($i = 1; $i <= 9; $i++) {
                    if (${$type . $tour . "_" . $i})
                        $tab_maps[] = ${$type . $tour . "_" . $i};
                }

                for ($i = 1; $i <= 9; $i++) {

                    $map = $tab_maps[$i - 1];

                    /*** mise a jour de la map ***/
                    /*** le record existe ? ***/
                    $db->select("map");
                    $db->from("${dbprefix}maps_tournois");
                    $db->where("tournois = $s_tournois");
                    $db->where("type = '$type'");
                    if ($type == 'P') $db->where("tour = $tour");
                    else $db->where("finale = $finale$numero");
                    $db->where("manche = $i");
                    $res = $db->exec();

                    if ($db->num_rows($res) == 0) {
                        if ($map != '') {
                            $db->insert("${dbprefix}maps_tournois (tournois,type,tour,finale,manche,map)");
                            if ($type == 'P') $db->values("$s_tournois,'$type',$tour,NULL,$i,'$map'");
                            else $db->values("$s_tournois,'$type',NULL,$finale$numero,$i,'$map'");
                            $db->exec();
                        }
                    } else {
                        if ($map == '') {
                            $db->delete("${dbprefix}maps_tournois");
                            $db->where("tournois = $s_tournois");
                            $db->where("type = '$type'");
                            if ($type == 'P') $db->where("tour = $tour");
                            else $db->where("finale = $finale$numero");
                            $db->where("manche = $i");
                            $db->exec();
                        } else {
                            $db->update("${dbprefix}maps_tournois");
                            $db->set("map = '$map'");
                            $db->where("tournois = $s_tournois");
                            if ($type == 'P') $db->where("tour = $tour");
                            else $db->where("finale = $finale$numero");
                            $db->where("manche = $i");
                            $db->exec();
                        }
                    }
                }


                /*** mise a jour de maps des matchs ***/
                $db->select("id");
                $db->from("${dbprefix}matchs");
                $db->where("tournois = $s_tournois");
                $db->where("type = '$type'");
                if ($type == 'P') $db->where("tour = $tour");
                elseif ($type == 'W') $db->where("finale = $finale");
                elseif ($type == 'L') {
                    $db->where("finale = $finale");
                    if ($numero == 2) $db->where("numero > $finale");
                    else $db->where("numero <= $finale");
                }
                $db->where("(status = 'C' OR status = 'A')");
                $matchs = $db->exec();

                while ($match = $db->fetch($matchs)) {

                    /*** le record existe dans les manches? ***/
                    $db->select("id");
                    $db->from("${dbprefix}manches");
                    $db->where("matchi = $match->id");
                    $db->order_by("id");
                    $res = $db->exec();

                    $tab_manches = array();

                    while ($res2 = $db->fetch($res)) {
                        $tab_manches[] = $res2->id;
                    }

                    for ($i = 1; $i <= 9; $i++) {

                        $map = $tab_maps[$i - 1];

                        /*** mise a jour de la map dans les manches***/
                        if ($tab_manches[$i - 1] == '') {
                            if ($map != '') {
                                $db->insert("${dbprefix}manches (matchi,map)");
                                $db->values("$match->id,'$map'");
                                $db->exec();
                            }
                        } else {
                            if ($map == '') {
                                $db->delete("${dbprefix}manches");
                                $db->where("matchi = $match->id");
                                $db->where("id = " . $tab_manches[$i - 1]);
                                $db->exec();
                            } else {
                                $db->update("${dbprefix}manches");
                                $db->set("map = '$map'");
                                $db->where("matchi = $match->id");
                                $db->where("id = " . $tab_manches[$i - 1]);
                                $db->exec();
                            }
                        }
                    }
                }
            }
        }
    }


    /*** redirection ***/
    js_goto("?page=maps_tournois");

} /********************************************************
 * Affichage admin
 */
else {

    echo "<p class=title>.:: $strAdminMaps - $nom_tournois ::.</p>";

    echo "<form name=form method=post action=?page=maps_tournois&op=modify>";

    /*** Poules ***/
    if (($type_tournois == 'T' || $type_tournois == 'C') && $status_tournois == 'P') {

        echo "<table border=0 cellpadding=0 cellspacing=0>";
        echo "<tr><td class=title align=center>$strPoules</td></tr>";
        echo "</table>";
        echo "<table cellspacing=1 cellpadding=2 border=0 class=bordure1>";
        echo "<tr><td class=headerliste>$strTour</td>";
        for ($i = 1; $i <= $nb_manches_max_tournois; $i++) {
            echo "<td class=headerliste>$strMap $strManche $i</td>";
        }
        echo "</tr>";

        //calcul du nombre de tour
        $nb_tours_max = 0;
        for ($i = 1; $i <= $nb_poules_tournois; $i++) {
            $nb_tours_poule = nb_tours($i, $s_tournois);
            if ($nb_tours_poule > $nb_tours_max)
                $nb_tours_max = $nb_tours_poule;
        }

        for ($i = 1; $i <= $nb_tours_max; $i++) {

            echo "<tr><td class=textliste align=center><b>$i</b></td>";

            for ($j = 1; $j <= $nb_manches_max_tournois; $j++) {

                $db->select("*");
                $db->from("${dbprefix}maps_tournois");
                $db->where("tournois = $s_tournois");
                $db->where("type = 'P'");
                $db->where("tour = $i");
                $db->where("manche = $j");
                $res = $db->exec();
                $maptournois = $db->fetch($res);

                echo "<td class=textliste><input type=text name=P${i}_${j} value='$maptournois->map' maxlength=20 size=20> <a href=javascript:ouvrir_fenetre('?page=maps&op=list&input=P${i}_${j}&header=win','maps',100,400)>[...]</a></td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    /*** finales W ***/
    if (($type_tournois == 'T' || $type_tournois == 'E') && $status_tournois == 'F') {

        echo "<table border=0 cellpadding=0 cellspacing=0 >";
        echo "<tr><td class=title align=center>$strFinales Winner</td></tr>";
        echo "</table>";
        echo "<table cellspacing=1 cellpadding=2 border=0 class=bordure1>";
        echo "<tr><td class=headerliste>$strFinales</td>";
        for ($i = 1; $i <= $nb_manches_max_tournois; $i++) {
            echo "<td class=headerliste>$strMap $strManche $i</td>";
        }
        echo "</tr>";

        $finale = $nb_finales_winner_tournois;

        for ($i = 1; $i <= (log($nb_finales_winner_tournois) / log(2)) + 1; $i++) {

            if ($finale > 1)
                echo "<tr><td class=textliste align=center><b>1/$finale</b></td>";
            else
                echo "<tr><td class=textliste align=center><b>$strFinale</b></td>";


            for ($j = 1; $j <= $nb_manches_max_tournois; $j++) {
                $db->select("*");
                $db->from("${dbprefix}maps_tournois");
                $db->where("tournois = $s_tournois");
                $db->where("type = 'W'");
                $db->where("finale = $finale");
                $db->where("manche = $j");
                $res = $db->exec();
                $maptournois = $db->fetch($res);

                echo "<td class=textliste><input type=text name=W${finale}_${j} value='$maptournois->map' maxlength=20 size=20> <a href=javascript:ouvrir_fenetre('?page=maps&op=list&input=W${finale}_${j}&header=win','maps',100,400)>[...]</a></td>";
            }
            echo "</tr>";

            $finale = floor($finale / 2);
        }
        echo "</table>";


        /*** finales L ***/
        if ($modeelimination_tournois == 'D') {

            echo "<br><table border=0 cellpadding=0 cellspacing=0>";
            echo "<tr><td class=title align=center>$strFinales Looser</td></tr>";
            echo "</table>";
            echo "<table cellspacing=1 cellpadding=2 border=0 class=bordure1>";
            echo "<tr><td class=headerliste>$strFinales</td>";
            for ($i = 1; $i <= $nb_manches_max_tournois; $i++) {
                echo "<td class=headerliste>$strMap $strManche $i</td>";
            }
            echo "</tr>";

            $finale = $nb_finales_looser_tournois / 2;

            for ($i = 1; $i <= (log($nb_finales_looser_tournois / 2) / log(2)) + 1; $i++) {

                if ($finale > 1)
                    echo "<tr><td class=textliste align=center><b>1/$finale $strTour 1</b></td>";
                else
                    echo "<tr><td class=textliste align=center><b>$strFinale $strTour 1</b></td>";

                for ($j = 1; $j <= $nb_manches_max_tournois; $j++) {

                    $db->select("*");
                    $db->from("${dbprefix}maps_tournois");
                    $db->where("tournois = $s_tournois");
                    $db->where("type = 'L'");
                    $db->where("finale = " . $finale . "1");
                    $db->where("manche = $j");
                    $res = $db->exec();
                    $maptournois = $db->fetch($res);

                    echo "<td class=textliste><input type=text name=L${finale}1_${j} value='$maptournois->map' maxlength=20 size=20> <a href=javascript:ouvrir_fenetre('?page=maps&op=list&input=L${finale}1_${j}&header=win','maps',100,400)>[...]</a></td>";
                }
                echo "</tr>";

                if ($finale > 1)
                    echo "<tr><td class=textliste align=center><b>1/$finale $strTour 2</b></td>";
                else
                    echo "<tr><td class=textliste align=center><b>$strFinale $strTour 2</b></td>";

                for ($j = 1; $j <= $nb_manches_max_tournois; $j++) {

                    $db->select("*");
                    $db->from("${dbprefix}maps_tournois");
                    $db->where("tournois=$s_tournois");
                    $db->where("type = 'L'");
                    $db->where("finale = " . $finale . "2");
                    $db->where("manche = $j");
                    $res = $db->exec();
                    $maptournois = $db->fetch($res);

                    echo "<td class=textliste><input type=text name=L${finale}2_${j} value='$maptournois->map' maxlength=20 size=20> <a href=javascript:ouvrir_fenetre('?page=maps&op=list&input=L${finale}2_${j}&header=win','maps',100,400)>[...]</a></td>";
                }
                echo "</tr>";

                $finale = floor($finale / 2);
            }
            echo "</table>";

            /***  Grandfinal ***/
            echo "<br><table border=0 cellpadding=0 cellspacing=0 align=center>";
            echo "<tr><td class=title align=center>$strGrandFinal</td></tr>";
            echo "</table>";
            echo "<table cellspacing=1 cellpadding=2 border=0 class=bordure1>";
            echo "<tr>";
            for ($i = 1; $i <= $nb_manches_max_tournois; $i++) {
                echo "<td class=headerliste>$strMap $strManche $i</td>";
            }
            echo "</tr>";

            for ($j = 1; $j <= $nb_manches_max_tournois; $j++) {

                $db->select("*");
                $db->from("${dbprefix}maps_tournois");
                $db->where("tournois=$s_tournois");
                $db->where("type = 'W'");
                $db->where("finale = 0");
                $db->where("manche = $j");
                $res = $db->exec();
                $maptournois = $db->fetch($res);

                echo "<td class=textliste><input type=text name=W0_${j} value='$maptournois->map' maxlength=20 size=20> <a href=javascript:ouvrir_fenetre('?page=maps&op=list&input=W0_${j}&header=win','maps',100,400)>[...]</a></td>";
            }

            echo "</tr></table>";
        }
    }

    echo "<table align=center>";
    echo "<tr><td align=center><input type=submit value=\"$strValider\"></td></tr>";
    echo "</table>";
    echo "</form>";

    show_consignes($strMapsTournoisConsignes);

    echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";
}

?>

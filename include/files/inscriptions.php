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
if (preg_match("/inscriptions.php/i", $_SERVER['PHP_SELF'])) {
    die ("You cannot open this page directly");
}

/*** test de la session ***/
if (empty($s_tournois) && empty($id)) js_goto("?page=index");
if (empty($s_tournois) && is_numeric($id)) $s_tournois = $id;

/********************************************************
 * Modifier les equipes inscites au tournois en cours
 */
if ($op == "modify") {

    /*** verification securite ***/
    verif_admin_tournois($s_joueur, $s_tournois, $grade['a'], $grade['b'], $grade['t']);


    foreach ($_POST as $key => $value) {

        preg_match("/^([a-z]+)_([0-9]+)$/", $key, $keylist);
        list(, $type, $id) = $keylist;

        if ($type == 'id') {

            /** si le joueur est coché ***/
            if (${"participe_$id"} == '1') {

                $seed = ${"seed_$id"};

                /** le joueur participe deja **/
                if (participe($id, $s_tournois)) {

                    $db->update("${dbprefix}participe");
                    if (!$seed) $db->set("seed = null");
                    else $db->set("seed = '$seed'");
                    $db->where("equipe = $id");
                    $db->where("tournois = $s_tournois");
                    $db->exec();
                } else {
                    $date = time();
                    $db->insert("${dbprefix}participe (tournois,equipe,poule,status,seed,date)");
                    if (!$seed) $db->values("$s_tournois,$id,null,'P',null,'$date'");
                    else $db->values("$s_tournois,$id,null,'P','$seed','$date'");
                    $db->exec();
                }
            } else {
                $db->delete("${dbprefix}participe");
                $db->where("equipe = $id");
                $db->where("tournois = $s_tournois");
                $db->exec();

            }
        }
    }

    /*** redirection ***/
    js_goto("?page=inscriptions&op=admin");

} /********************************************************
 * Modifier le status d'une equipe
 */
elseif ($op == "status") {

    /*** verification securite ***/
    verif_admin_tournois($s_joueur, $s_tournois, $grade['a'], $grade['b'], $grade['t']);
    $db->update("${dbprefix}participe");
    $db->set("status = '$value'");
    $db->where("equipe = $id");
    $db->where("tournois = $s_tournois");
    $db->exec();

    if ($value != 'P' && ($status_tournois == 'P' || $status_tournois == 'F')) {
        /*** mise a jour des matchs de ce participant si il y a disqualification***/
        $db->update("${dbprefix}matchs");
        $db->set("statusequipe = '${value}1'");
        $db->where("equipe1 = $id");
        $db->where("status != 'T'");
        $db->where("tournois = $s_tournois");
        $db->exec();

        $up_d = time();
        $db->update("${dbprefix}matchs");
        $db->set("status = 'T', up='$up_d'");
        $db->where("equipe1 = $id");
        $db->where("equipe2 != 0");
        $db->where("status != 'T'");
        $db->where("tournois = $s_tournois");
        $db->exec();

        $db->update("${dbprefix}matchs");
        $db->set("statusequipe = '${value}2'");
        $db->where("equipe2 = $id");
        $db->where("status != 'T'");
        $db->where("tournois = $s_tournois");
        $db->exec();

        $up_d = time();
        $db->update("${dbprefix}matchs");
        $db->set("status = 'T', up='$up_d'");
        $db->where("equipe1 != 0");
        $db->where("equipe2 = $id");
        $db->where("status != 'T'");
        $db->where("tournois = $s_tournois");
        $db->exec();

        /*** calcul du nouvel arbre ***/
        $db->select("id");
        $db->from("${dbprefix}matchs");
        $db->where("(equipe1 = $id OR equipe2 = $id)");
        $db->where("type != 'P'");
        $db->where("status = 'T'");
        $db->where("tournois = $s_tournois");
        $db->order_by("id");
        $res = $db->exec();

        while ($match = $db->fetch($res)) {
            calcul_finales($match->id);
        }
    }

    /*** redirection ***/
    js_goto("?page=inscriptions&op=admin");
}

/********************************************************
 * Inscription de joueurs/equipes par eux meme
 */
if ($op == "sinscire") {

    /*** le tournois est en inscription manuel ***/
    if (modeinscription_tournois($id) == 'J' && status_tournois($id) == 'I') {

        /*** si il y a assez de places ***/
        $nbinscrits = nb_inscrits_tournois($id);
        $nbplaces = nb_places_tournois($id);

        if ($nbinscrits < $nbplaces) {

            /*** le tournois est par equipe (le manager ki inscrit) ***/
            if (modeequipe_tournois($id) == 'E' && equipe_valide($equipe) && !participe($equipe, $id)) {

                /*** verification securite ***/
                verif_manager($equipe, $s_joueur);

                $db->delete("${dbprefix}participe");
                $db->where("tournois = $id");
                $db->where("equipe = $equipe");
                $db->exec();

                $db->insert("${dbprefix}participe (tournois,equipe,poule,status,seed,date)");
                $db->values("$id,$equipe,null,'P',null," . time());
                $db->exec();
            } elseif (modeequipe_tournois($id) == 'J' && joueur_inscrit($s_joueur) && !participe($s_joueur, $id)) {
                $db->delete("${dbprefix}participe");
                $db->where("tournois = $id");
                $db->where("equipe = $s_joueur");
                $db->exec();

                $db->insert("${dbprefix}participe (tournois,equipe,poule,status,seed,date)");
                $db->values("$id,$s_joueur,null,'P',null," . time());
                $db->exec();
            }
        }
    }

    /*** redirection ***/
    js_goto("?page=inscriptions");

}

/********************************************************
 * DesInscription de joueurs/equipes par eux meme
 */
if ($op == "desinscire") {

    /*** le tournois est en inscription manuel ***/
    if (modeinscription_tournois($id) == 'J' && status_tournois($id) == 'I') {

        /*** le tournois est par equipe (le manager ki desinscrit) ***/
        if (modeequipe_tournois($id) == 'E' && participe($equipe, $id)) {

            /*** verification securite ***/
            verif_manager($equipe, $s_joueur);

            $db->delete("${dbprefix}participe");
            $db->where("tournois = $s_tournois");
            $db->where("equipe = $equipe");
            $db->exec();

        } elseif (modeequipe_tournois($id) == 'J' && participe($s_joueur, $id)) {

            $db->delete("${dbprefix}participe");
            $db->where("tournois = $s_tournois");
            $db->where("equipe = $s_joueur");
            $db->exec();
        }
    }

    /*** redirection ***/
    js_goto("?page=inscriptions");

} /********************************************************
 * Affichage admin
 */
elseif ($op == "admin") {

    /*** verification securite ***/
    verif_admin_tournois($s_joueur, $s_tournois, $grade['a'], $grade['b'], $grade['t']);;

    /*** affichage main ***/
    echo "<p class=title>.:: " . ${'str' . $EquipesX . 'Inscrits'} . " - $nom_tournois::.</p>";

    echo "<table cellspacing=0 cellpadding=0 border=0>";

    $nbinscrits = nb_inscrits_tournois($s_tournois);;
    $nbplaces = nb_places_tournois($s_tournois);

    if ($nbinscrits > $nbplaces) echo "<tr><td class=title><font color=red>$nbinscrits</font> / $nbplaces ${"str$EquipesX"}</td></tr>";
    else echo "<tr><td class=title>$nbinscrits / $nbplaces ${"str$EquipesX"}</td></tr>";

    echo "</table>";

    /*** Inscription des equipes au tournois***/
    if ($status_tournois == "I") {

        $db->select("id");
        $db->from("${dbprefix}$equipesX");
        if ($modeequipe_tournois == 'J') $db->where("etat = 'I'");
        if ($modeequipe_tournois == 'E') $db->where("etat = 'V'");
        $db->order_by("$champX");
        $res = $db->exec();

        /** reinit des colonne a 1 ***/
        if ($db->num_rows($res) < $config['col_' . $equipesX])
            $config['col_' . $equipesX] = 1;

        if ($db->num_rows($res) != 0) {
            $i = 0;
            while ($participant = $db->fetch($res)) {
                $tab_participants[$i] = $participant;
                $i++;
            }

            echo "<table class=liste><tr valign=top>";
            echo "<form name='liste' method=post action=?page=inscriptions&op=modify>";

            for ($i = 0; $i < $config['col_' . $equipesX]; $i++) {
                echo "<td>";
                echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
                echo "<table cellspacing=1 cellpadding=1 border=0>";
                echo "<tr><td class=headerliste>#</td><td class=headerliste width=120>$strNom</td><td class=headerliste>$strInscrit</td><td class=headerliste width=10>$strSeed</td><td class=headerliste>$strDate</td></tr>";

                for ($j = $i; $j < count($tab_participants); $j = $j + $config['col_' . $equipesX]) {

                    $date = date_participe($tab_participants[$j]->id, $s_tournois);
                    if ($date != 0) $date = strftime(DATESTRING1, $date);
                    else $date = 'N/A';

                    echo "<tr>";
                    echo "<td class=textliste align=center>" . $tab_participants[$j]->id . "<input type=hidden name=id_" . $tab_participants[$j]->id . " value=" . $tab_participants[$j]->id . "></td>";
                    echo "<td class=textliste>" . $show($tab_participants[$j]->id, $op) . "</a></td>";
                    echo '<td class="textliste" align="center"><input type="checkbox" name="participe_' . $tab_participants[$j]->id . '" value="1"';
                    if (participe($tab_participants[$j]->id, $s_tournois)) {
                        echo ' CHECKED';
                    }
                    echo ' style="border=0px;background-color:transparent;"></td>';
                    echo "<td class=textliste align=center><input type=text maxlength=3 size=2 name=seed_" . $tab_participants[$j]->id . " value=\"" . seed($tab_participants[$j]->id, $s_tournois) . "\"></td>";
                    echo "<td class=textliste align=center>" . $date . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "</td></tr></table>";
                echo "</td>";
            }
            echo "</tr></table>";

            echo "<table cellspacing=1 cellpadding=2 border=0>";
            echo "<tr><td class=text align=center><a href=javascript:select_all('liste')>$strToutSelectionner<a/> - <a href=javascript:unselect_all('liste')>$strToutDeselectionner<a/></td></tr>";
            echo "<tr><td class=text align=center><input type=submit value=\"$strValider\"></td></tr>";
            echo "</form></table>";
        }
    } /*** Changement du status des equipes dans le tournois***/
    else {

        $db->select("id, status, date, IFNULL(seed,10000) as seed");
        $db->from("${dbprefix}$equipesX, ${dbprefix}participe");
        $db->where("${dbprefix}$equipesX.id = ${dbprefix}participe.equipe");
        $db->where("tournois = $s_tournois");
        $db->order_by("seed, $champX");
        $res = $db->exec();

        /** reinit des colonne a 1 ***/
        if ($db->num_rows($res) < $config['col_' . $equipesX])
            $config['col_' . $equipesX] = 1;

        if ($db->num_rows($res) != 0) {
            $i = 0;
            while ($participant = $db->fetch($res)) {
                $tab_participants[$i] = $participant;
                $i++;
            }

            echo "<table cellspacing=0 cellpadding=0 border=0 class=liste><tr valign=top>";

            for ($i = 0; $i < $config['col_' . $equipesX]; $i++) {
                echo "<td>";
                echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
                echo "<table cellspacing=1 cellpadding=2 border=0>";
                echo "<tr><td class=headerliste>#</td><td class=headerliste width=120>$strNom</td><td class=headerliste width=10>$strSeed</td><td class=headerliste>$strInscrit</td><td class=headerliste>$strStatus</td></tr>";

                for ($j = $i; $j < count($tab_participants); $j = $j + $config['col_' . $equipesX]) {
                    echo "<tr>";
                    echo "<td class=textliste align=center>" . $tab_participants[$j]->id . "</td>";
                    echo "<td class=textliste width=120>" . $show($tab_participants[$j]->id, $op) . "</td>";

                    if ($tab_participants[$j]->seed && $tab_participants[$j]->seed != 10000) echo "<td class=textliste align=center>#" . $tab_participants[$j]->seed . "</td>";
                    else echo "<td class=textliste></td>";

                    if ($date != 0) $date = strftime(DATESTRING2, $tab_participants[$j]->date);
                    else $date = '';

                    echo "<td class=textliste align=center>$date</td>";
                    echo "<td class=textliste align=center>";
                    echo "<select name=status onchange=\"javascript:status_participe(" . $tab_participants[$j]->id . ",this.value,'$strChangerStatusParticipe')\">";
                    echo "<option value=P";
                    if ($tab_participants[$j]->status == "P") echo " SELECTED";
                    echo ">$strParticipe";
                    echo "<option value=F";
                    if ($tab_participants[$j]->status == "F") echo " SELECTED";
                    echo ">$strForfait";
                    echo "<option value=D";
                    if ($tab_participants[$j]->status == "D") echo " SELECTED";
                    echo ">$strDisqualifie";
                    echo "</select>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "</td></tr></table>";
                echo "</td>";
            }
            echo "</tr></table>";
        }
    }

    echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";

} /********************************************************
 * Affichage normal
 */
else {

    /*** affichage main ***/
    echo "<p class=title>.:: " . ${'str' . $EquipesX . 'Inscrits'} . " - $nom_tournois::.</p>";

    echo "<table cellspacing=0 cellpadding=0 border=0>";
    $nbinscrits = nb_inscrits_tournois($s_tournois);
    $nbplaces = nb_places_tournois($s_tournois);

    if ($nbinscrits > $nbplaces) echo "<tr><td class=title><font color=red>$nbinscrits</font> / $nbplaces ${"str$EquipesX"}</td></tr>";
    else echo "<tr><td class=title>$nbinscrits / $nbplaces ${"str$EquipesX"}</td></tr>";

    echo "</table>";

    $db->select("id, status, date, IFNULL(seed,10000) as seed");
    $db->from("${dbprefix}$equipesX, ${dbprefix}participe");
    $db->where("${dbprefix}$equipesX.id = ${dbprefix}participe.equipe");
    $db->where("tournois = $s_tournois");
    $db->order_by("seed, $champX");
    $res = $db->exec();

    /** reinit des colonne a 1 ***/
    if ($db->num_rows($res) < $config['col_' . $equipesX])
        $config['col_' . $equipesX] = 1;

    if ($db->num_rows($res) != 0) {
        $i = 0;
        while ($participant = $db->fetch($res)) {
            $tab_participants[$i] = $participant;
            $i++;
        }

        echo "<table cellspacing=0 cellpadding=0 border=0 class=liste><tr valign=top>";

        for ($i = 0; $i < $config['col_' . $equipesX]; $i++) {
            echo "<td>";
            echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
            echo "<table cellspacing=1 cellpadding=2 border=0>";
            echo "<tr><td class=headerliste>#</td><td class=headerliste width=120>$strNom</td><td class=headerliste width=10>$strSeed</td><td class=headerliste>$strInscrit</td></tr>";

            for ($j = $i; $j < count($tab_participants); $j = $j + $config['col_' . $equipesX]) {
                echo "<tr>";
                echo "<td class=textliste align=center>" . $tab_participants[$j]->id . "</td>";

                if ($tab_participants[$j]->status == "P") echo "<td class=textliste>" . $show($tab_participants[$j]->id, $op, '') . "</td>";
                elseif ($tab_participants[$j]->status == "F") echo "<td class=textliste>" . $show($tab_participants[$j]->id, $op, 'F') . "</td>";
                elseif ($tab_participants[$j]->status == "D") echo "<td class=textliste>" . $show($tab_participants[$j]->id, $op, 'D') . "</td>";

                if ($tab_participants[$j]->seed && $tab_participants[$j]->seed != 10000) echo "<td class=textliste align=center>#" . $tab_participants[$j]->seed . "</td>";
                else echo "<td class=textliste align=center> - </td>";

                $date = strftime(DATESTRING1, $tab_participants[$j]->date);
                if ($date == 0) $date = '';

                echo "<td class=textliste align=center>$date</td>";

                echo "</tr>";
            }
            echo "</table>";
            echo "</td></tr></table>";
            echo "</td>";
        }
        echo "</tr></table>";
    }

    show_consignes($strInscriptionsTournoisConsignes);

    echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";

}


?>

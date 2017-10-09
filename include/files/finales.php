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
if (preg_match("/finales.php/i", $_SERVER['PHP_SELF'])) {
    die ("You cannot open this page directly");
}
/*** test de la session ***/
if (empty($s_tournois)) js_goto("?page=index");

/********************************************************
 * MOD CUSTOM POINTS
 */

$db->select("poulewin, poulenull, pouleloose");
$db->from("${dbprefix}config");
$res = $db->exec();

while ($poulepts = $db->fetch($res)) {
    $cust_ptsw = $poulepts->poulewin;
    $cust_ptsl = $poulepts->pouleloose;
    $cust_ptsn = $poulepts->poulenull;
    $cust_ptslfor = $poulepts->poulefor;
}

/********************************************************
 * END MOD CUSTOM POINTS
 */

/********************************************************
 * Fonctions de calcul d'un tableau de seed
 */

function NB_TEAM($tour)
{
    return pow(2.0, $tour + 1);
}

function INV($seed, $tour)
{
    return NB_TEAM($tour) + 1 - $seed;
}

function creer_tableau_r(&$tableau, $indice, $taille, $tour, $seed)
{
    if ($taille == 2) {
        $tableau[$indice] = $seed;
        $tableau[$indice + 1] = INV($seed, $tour);
        return;
    }
    creer_tableau_r($tableau, $indice, $taille / 2, $tour + 1, $seed);
    creer_tableau_r($tableau, $indice + $taille / 2, $taille / 2, $tour + 1, INV(INV($seed, $tour), $tour + 1));
}

/* $tableau :
	R&eacute;sultat - Variable de type tableau d'entier contenant les rencontres
	$tableau[0] joue contre $tableau[1] puis en r�gle g&eacute;n&eacute;ral $tableau[i] joue contre $tableau[i+1] avec i=2n
	$nb_team : Nombre de teams en phase finale. DOIT ETRE UNE PUISSANCE DE 2
	CA PETE LA PHRASE HEIN ? AlgoMan64
*/
function creer_tableau_seed(&$tableau, $nb_team)
{
    creer_tableau_r($tableau, 0, $nb_team, 0, 1);
}


/********************************************************
 * Ajouter un equipe
 */
if ($op == "add") {

    /*** verification securite ***/
    //verif_admin_tournois($s_joueur,$s_tournois);
    verif_admin_tournois($s_joueur, $s_tournois, $grade['a'], $grade['b'], $grade['t']);

    $db->update("${dbprefix}matchs");
    $db->set("equipe$side = $participant");
    $db->where("id = $id");
    $db->exec();

    /*** redirection ***/
    js_goto("?page=finales&op=admin");
}


/********************************************************
 * Retirer un equipe
 */
if ($op == "delete") {

    /*** verification securite ***/
    //verif_admin_tournois($s_joueur,$s_tournois);
    verif_admin_tournois($s_joueur, $s_tournois, $grade['a'], $grade['b'], $grade['t']);

    $db->update("${dbprefix}matchs");
    $db->set("equipe$side = 0");
    $db->where("id = $id");
    $db->exec();

    /*** redirection ***/
    js_goto("?page=finales&op=admin");
} /********************************************************
 * Affecter les equipes au hasard
 */
elseif ($op == "random") {

    /*** verification securite ***/
    //verif_admin_tournois($s_joueur,$s_tournois);
    verif_admin_tournois($s_joueur, $s_tournois, $grade['a'], $grade['b'], $grade['t']);

    $finale = $nb_finales_winner_tournois;

    $db->select("*");
    $db->from("${dbprefix}matchs");
    $db->where("finale = $finale");
    $db->where("type = 'W'");
    $db->where("tournois = $s_tournois");
    $db->order_by("rand()");
    $matchs = $db->exec();

    while ($match = $db->fetch($matchs)) {

        /** si il y a une place dans ce match **/
        if ($match->equipe1 == 0 || $match->equipe2 == 0) {

            /** creation de la liste d'equipes n'ayant pas jou&eacute; **/
            $db->select("equipe1,equipe2");
            $db->from("${dbprefix}matchs");
            $db->where("type = 'W'");
            $db->where("finale = $finale");
            $db->where("tournois = $s_tournois");
            $res1 = $db->exec();

            $equipes_ok = '';

            while ($matchlist = $db->fetch($res1)) {
                $equipes_ok .= "$matchlist->equipe1,$matchlist->equipe2,";
            }

            $equipes_ok = trim($equipes_ok, ",");

            $db->select("id");
            $db->from("${dbprefix}$equipesX, ${dbprefix}participe");
            $db->where("${dbprefix}$equipesX.id = ${dbprefix}participe.equipe");
            $db->where("status = 'P'");
            $db->where("tournois = $s_tournois");
            $db->where("id not in ($equipes_ok)");
            $db->order_by("rand()");
            $lists = $db->exec();

            if ($match->equipe1 == 0) {
                $participant1 = $db->fetch($lists);

                if ($participant1->id) {
                    $db->update("${dbprefix}matchs");
                    $db->set("equipe1 = $participant1->id");
                    $db->where("id = $match->id");
                    $db->exec();
                }
            }


            if ($match->equipe2 == 0) {
                $participant2 = $db->fetch($lists);

                if ($participant2->id) {
                    $db->update("${dbprefix}matchs");
                    $db->set("equipe2 = $participant2->id");
                    $db->where("id = $match->id");
                    $db->exec();
                }
            }
        }
    }

    /*** redirection ***/
    js_goto("?page=finales&op=admin");
} /********************************************************
 * Affecter les equipes avec le seed g&eacute;n&eacute;ral
 */
elseif ($op == "seed") {

    /*** verification securite ***/
    //verif_admin_tournois($s_joueur,$s_tournois);
    verif_admin_tournois($s_joueur, $s_tournois, $grade['a'], $grade['b'], $grade['t']);

    $finale = $nb_finales_winner_tournois;

    //tableau de seeds corrects
    $T = array();

    creer_tableau_seed($T, $finale * 2);

    /** select des match **/
    $db->select("id");
    $db->from("${dbprefix}matchs");
    $db->where("finale = $finale");
    $db->where("type = 'W'");
    $db->where("tournois = $s_tournois");
    $db->order_by("numero");
    $res = $db->exec();

    /** select des seeds **/
    $db->select("equipe, IFNULL(seed,10000) as seed");
    $db->from("${dbprefix}participe");
    $db->where("status = 'P'");
    $db->where("tournois = $s_tournois");
    $db->where("seed!=10000");
    $db->order_by("seed");
    $res2 = $db->exec();

    while ($equipe = $db->fetch($res2))
        $tab_equipes[] = array('id' => ($equipe->equipe), 'seed' => ($equipe->seed));

    $i = 0;

    while ($match = $db->fetch($res)) {

        // on passe tous les seed pour voir si la match correspond au seed
        for ($j = 0; $j < count($tab_equipes); $j++) {
            if ($T[$i] == $tab_equipes[$j]['seed']) {
                // on insere l'equipe 1
                $db->update("${dbprefix}matchs");
                $db->set("equipe1 = " . $tab_equipes[$j]['id']);
                $db->where("id = $match->id");
                $db->exec();
            }
        }
        $i++;

        for ($j = 0; $j < count($tab_equipes); $j++) {
            if ($T[$i] == $tab_equipes[$j]['seed']) {
                // on insere l'equipe
                $db->update("${dbprefix}matchs");
                $db->set("equipe2 = " . $tab_equipes[$j]['id']);
                $db->where("id = $match->id");
                $db->exec();
            }
        }
        $i++;
    }

    /*** redirection en random pour finir***/
    js_goto("?page=finales&op=admin");

} /********************************************************
 * Affecter les equipes avec les sorties de poules
 */
elseif ($op == "poules") {

    /*** verification securite ***/
    //verif_admin_tournois($s_joueur,$s_tournois);
    verif_admin_tournois($s_joueur, $s_tournois, $grade['a'], $grade['b'], $grade['t']);

    $finale = $nb_finales_winner_tournois;
    $nb_poules = $nb_poules_tournois;
    $nb_equipes_max = 0;
    $nb_equipes_sortantes = floor($finale * 2 / $nb_poules);

    // calcul d'une liste de seeds corrects comprise entre 0 et finale*2-1
    $T = array();
    creer_tableau_seed($T, $finale * 2);

    // calcul d'une liste al&eacute;atoire sans doublon comprise entre 0 et finale*2-1
    $tab_rand = array();

    for ($i = 0; $i < $finale * 2; $i++) {
        $ran = rand(0, ($finale * 2) - 1);

        if (in_array($ran, $tab_rand)) $i--;
        else $tab_rand[] = $ran;
    }


    /** calcul des tableaux des sorties de poules **/
    for ($p = 1; $p <= $nb_poules; $p++) {

        $nb_equipes_new = nb_equipes_poule($p, $s_tournois);

        if ($nb_equipes_max < $nb_equipes_new) $nb_equipes_max = $nb_equipes_new;

        // contruction du tableau de poules non tri&eacute;
        $db->select("id, $champX, status, IFNULL(seed,10000) as seed");
        $db->from("${dbprefix}$equipesX, ${dbprefix}participe");
        $db->where("${dbprefix}$equipesX.id = ${dbprefix}participe.equipe");
        $db->where("poule = $p");
        $db->where("status = 'P'");
        $db->where("tournois = $s_tournois");
        $db->order_by("seed,$champX");
        $res1 = $db->exec();

        $j = 0;
        $tab_poule = array();

        while ($participant = $db->fetch($res1)) {

            $db->select("id");
            $db->from("${dbprefix}matchs");
            $db->where("${dbprefix}matchs.status = 'T'");
            $db->where("poule = $p");
            $db->where("tournois = $s_tournois");
            $db->where("(equipe1 = $participant->id OR equipe2 = $participant->id)");
            $matchsid = $db->exec();

            $nb_joues = $nb_gagnes = $nb_nuls = $nb_perdus = $avg = $nb_pts = 0;


            while ($matchid = $db->fetch($matchsid)) {
                $nb_joues++;

                $moi = $adv = $score_moi = $score_adv = $frags_moi = $frags_adv = 0;

                $match = match($matchid->id);

                if ($match->statusequipe == "F1" || $match->statusequipe == "D1") $perdant = 1;
                elseif ($match->statusequipe == "F2" || $match->statusequipe == "D2") $perdant = 2;
                else $perdant = 0;

                if ($match->equipe1 == $participant->id) {
                    $avg += $match->frags1;
                    $avg -= $match->frags2;

                    $moi = 1;
                    $adv = 2;
                    $score_moi = $match->score1;
                    $score_adv = $match->score2;
                    $frags_moi = $match->frags1;
                    $frags_adv = $match->frags2;
                } elseif ($match->equipe2 == $participant->id) {
                    $avg += $match->pts2;
                    $avg -= $match->pts1;

                    $moi = 2;
                    $adv = 1;
                    $score_moi = $match->score2;
                    $score_adv = $match->score1;
                    $frags_moi = $match->frags2;
                    $frags_adv = $match->frags1;
                }


                if ($score_moi > $score_adv) {
                    if ($perdant == $moi) {
                        $nb_perdus++;
                        $nb_pts += $cust_ptsfor;
                    } else {
                        $nb_gagnes++;
                        $nb_pts += $cust_ptsw;
                    }
                } elseif ($score_moi < $score_adv) {
                    if ($perdant == $adv) {
                        $nb_gagnes++;
                        $nb_pts += $cust_ptsw;
                    } else
                        $nb_perdus++;
                    $nb_pts += $cust_ptsl;
                } else {
                    if ($perdant == $moi) {
                        $nb_perdus++;
                        $nb_pts += $cust_ptsfor;
                    } elseif ($perdant == $adv) {
                        $nb_gagnes++;
                        $nb_pts += $cust_ptsw;
                    } else {
                        if ($match->modematchscore == 'RF' && $frags_moi > $frags_adv) {
                            $nb_gagnes++;
                            $nb_pts += $cust_ptsw;
                        } elseif ($match->modematchscore == 'RF' && $frags_moi < $frags_adv) {
                            $nb_perdus++;
                            $nb_pts += $cust_ptsl;
                        } else {
                            $nb_nuls++;
                            $nb_pts += $cust_ptsn;
                        }
                    }
                }
            }

            // affectation de ces valeurs dans un tableau avant triage
            $tab_poule['id'][$j] = $participant->id;
            $tab_poule['equipe'][$j] = $participant->$champX;
            $tab_poule['nb_pts'][$j] = $nb_pts;
            $tab_poule['nb_joues'][$j] = $nb_joues;
            $tab_poule['nb_gagnes'][$j] = $nb_gagnes;
            $tab_poule['nb_nuls'][$j] = $nb_nuls;
            $tab_poule['nb_perdus'][$j] = $nb_perdus;
            $tab_poule['avg'][$j] = $avg;
            $tab_poule['seed'][$j] = $participant->seed;
            $j++;
        }

        //trie du tableau de la poule
        array_multisort($tab_poule['nb_pts'], SORT_NUMERIC, SORT_DESC, $tab_poule['avg'], SORT_NUMERIC, SORT_DESC, $tab_poule['nb_joues'], $tab_poule['nb_gagnes'], $tab_poule['nb_nuls'], $tab_poule['nb_perdus'], $tab_poule['seed'], SORT_NUMERIC, SORT_ASC, $tab_poule['equipe'], $tab_poule['id']);

        if ($type == 'seed' || $type == 'random') {

            // contruction des tableaux de rang $j inter poules non tri&eacute; (tab des 1er, tab des 2e, etc)
            for ($j = 0; $j < $nb_equipes_max; $j++) {

                //calcul de l'indice d'insertion suivant dans les tableaux de rang
                $indice = count(${"tab_poules_$j"}['id']);

                // inscription dans les tableaux de rangs
                ${"tab_poules_$j"}['id'][$indice] = $tab_poule['id'][$j];
                ${"tab_poules_$j"}['equipe'][$indice] = $tab_poule['equipe'][$j];
                ${"tab_poules_$j"}['nb_pts'][$indice] = $tab_poule['nb_pts'][$j];
                ${"tab_poules_$j"}['nb_joues'][$indice] = $tab_poule['nb_joues'][$j];
                ${"tab_poules_$j"}['nb_gagnes'][$indice] = $tab_poule['nb_gagnes'][$j];
                ${"tab_poules_$j"}['nb_nuls'][$indice] = $tab_poule['nb_nuls'][$j];
                ${"tab_poules_$j"}['nb_perdus'][$indice] = $tab_poule['nb_perdus'][$j];
                ${"tab_poules_$j"}['avg'][$indice] = $tab_poule['avg'][$j];
            }
        } elseif ($type == 'croise') {
            ${"tab_poule_$p"} = array();

            // contruction du tableau des sortant de la poule $p (tab des 1er 2e, etc pour une poule donn&eacute;e)
            for ($j = 0; $j < $nb_equipes_sortantes; $j++) {
                ${"tab_poule_$p"}[] = $tab_poule['id'][$j];
            }

        }
    }

    //print_r($tab_poule_1);print_r($tab_poule_2);print_r($tab_poule_3);print_r($tab_poule_4);


    $tab_equipes = array();

    if ($type == 'seed' || $type == 'random') {

        // trie de tous les tableaux de rang inter-poules (meilleur 1er, meilleur 2e etc..)
        for ($i = 0; $i < $nb_equipes_max; $i++) {
            array_multisort(${"tab_poules_$i"}['nb_pts'], SORT_NUMERIC, SORT_DESC, ${"tab_poules_$i"}['avg'], SORT_NUMERIC, SORT_DESC, ${'tab_poules_' . $i}['nb_joues'], ${'tab_poules_' . $i}['nb_gagnes'], ${'tab_poules_' . $i}['nb_nuls'], ${'tab_poules_' . $i}['nb_perdus'], ${'tab_poules_' . $i}['equipe'], ${'tab_poules_' . $i}['id']);
        }

        // affectation du tableau des equipes (et des seeds de sortie de poules) ordon&eacute;e par rang
        $seed = 1;
        for ($i = 0; $i < $nb_equipes_max; $i++) {
            for ($j = 0; $j < count(${"tab_poules_$i"}['id']); $j++) {
                $tab_equipes[] = array('id' => ${"tab_poules_$i"}['id'][$j], 'seed' => $seed);
                $seed++;
            }
        }
    } elseif ($type == 'croise') {

        // affectation du tableau des equipes (et des seeds de sortie de poules) ordon&eacute;e par poules
        $seed = 1;
        for ($p = 1; $p <= $nb_poules; $p++) {
            for ($j = 0; $j < $nb_equipes_sortantes; $j++) {
                $tab_equipes[] = array('id' => ${"tab_poule_$p"}[$j], 'seed' => $seed);
                $seed++;
            }
        }
    }

    //print_r($tab_equipes);

    /** select des match **/
    $db->select("id");
    $db->from("${dbprefix}matchs");
    $db->where("type = 'W'");
    $db->where("finale = $finale");
    $db->where("tournois = $s_tournois");
    $db->order_by("numero");
    $res = $db->exec();

    $i = 0;

    while ($match = $db->fetch($res)) {

        if ($type == 'seed' || $type == 'croise') {

            // on passe tous les seed pour voir si la match correspond au seed
            for ($j = 0; $j < count($tab_equipes); $j++) {
                if ($T[$i] == $tab_equipes[$j]['seed']) {
                    // on insere l'equipe 1
                    $db->update("${dbprefix}matchs");
                    $db->set("equipe1 = " . $tab_equipes[$j]['id']);
                    $db->where("id = $match->id");
                    $db->exec();
                }
            }
            $i++;

            for ($j = 0; $j < count($tab_equipes); $j++) {
                if ($T[$i] == $tab_equipes[$j]['seed']) {
                    // on insere l'equipe
                    $db->update("${dbprefix}matchs");
                    $db->set("equipe2 = " . $tab_equipes[$j]['id']);
                    $db->where("id = $match->id");
                    $db->exec();
                }
            }
            $i++;
        } elseif ($type == 'random') {

            // on passe le tableau random et on affecte les equipes
            if ($tab_equipes[$tab_rand[$i]]['id']) {
                // on insere l'equipe
                $db->update("${dbprefix}matchs");
                $db->set("equipe1 = " . $tab_equipes[$tab_rand[$i]]['id']);
                $db->where("id = $match->id");
                $db->exec();
            }
            $i++;

            if ($tab_equipes[$tab_rand[$i]]['id']) {
                // on insere l'equipe
                $db->update("${dbprefix}matchs");
                $db->set("equipe2 = " . $tab_equipes[$tab_rand[$i]]['id']);
                $db->where("id = $match->id");
                $db->exec();
            }
            $i++;
        }
    }

    /*** redirection en random pour finir***/
    js_goto("?page=finales&op=admin");

} /********************************************************
 * Remettre les matchs a zero
 */
elseif ($op == "reset") {

    /*** verification securite ***/
    //verif_admin_tournois($s_joueur,$s_tournois);
    verif_admin_tournois($s_joueur, $s_tournois, $grade['a'], $grade['b'], $grade['t']);

    $finale = $nb_finales_winner_tournois;

    /*** effacement des equipe de la phase finale winner ***/
    $db->update("${dbprefix}matchs");
    $db->set("equipe1=0");
    $db->set("equipe2=0");
    $db->where("type = 'W'");
    $db->where("finale = $finale");
    $db->where("tournois = $s_tournois");
    $res = $db->exec();

    /*** redirection ***/
    js_goto("?page=finales&op=admin");

} /********************************************************
 * Affichage admin
 */
elseif ($op == "admin") {

    /*** verification securite ***/
    //verif_admin_tournois($s_joueur,$s_tournois);
    verif_admin_tournois($s_joueur, $s_tournois, $grade['a'], $grade['b'], $grade['t']);

    $finale = $nb_finales_winner_tournois;

    $str = '';
    $erreur = 0;

    if (!$finale) {
        $erreur = 1;
        $str .= "- " . $strElementsFinalesInvalides . "<br>";
    }
    if ($modeelimination_tournois == 'D' && !$nb_finales_looser_tournois) {
        $erreur = 1;
        $str .= "- " . $strElementsFinalesLooserInvalides;
    }

    if ($erreur == 1) {
        $str .= "<br><form method=post action='?page=tournois&op=modify&id=$s_tournois'><input type=submit class=action value=\"$strModifier\"></form>";
        show_erreur($str);
    } else {

        echo "<p class=title>.:: $strAdminFinales ::.</p>";

        echo "<table cellspacing=2 cellpadding=2 border=0 class=liste>";
        if ($type_tournois == 'T') {
            echo "<tr align=center><td class=title colspan=3>$strAssignerPoules :</td></tr>";
            echo "<tr align=center>";
            echo "<td><form method=post action='?page=finales&op=poules&type=seed'><input type=submit class=action value=\"$strMethodeSeed\"></td></form>";
            echo "<td><form method=post action='?page=finales&op=poules&type=croise'><input type=submit class=action value=\"$strMethodeCroise\"></td></form>";
            echo "<td><form method=post action='?page=finales&op=poules&type=random'><input type=submit class=action value=\"$strMethodeRandom\"></td></form>";
            echo "</tr>";
        } elseif ($type_tournois == 'E') {
            echo "<tr align=center>";
            echo "<td><form method=post action='?page=finales&op=random'><input type=submit class=action value=\"$strAssignerAleatoirement\"'></td></form>";
            echo "<td><form method=post action='?page=finales&op=seed'><input type=submit class=action value=\"$strAssignerInscriptionSeed\"></td></form>";
            echo "</tr>";
        }
        echo "<tr align=center><td colspan=3><form method=post action='?page=finales&op=reset'><input type=submit class=action value=\"$strRemettreAZero\"></td></form></tr>";
        echo "</table>";

        /** creation des matchs de cette finale si il n'existe pas **/
        for ($i = 1; $i <= $finale; $i++) {

            $db->select("id");
            $db->from("${dbprefix}matchs");
            $db->where("type = 'W'");
            $db->where("finale = $finale");
            $db->where("numero = $i");
            $db->where("tournois = $s_tournois");
            $match = $db->exec();


            if ($db->num_rows($match) == 0) {
                $db->insert("${dbprefix}matchs (type,finale,numero,tournois,status)");
                $db->values("'W',$finale,$i,$s_tournois,'C'");
                $db->exec();

            } else {
                $match = $db->fetch($match);
                $db->update("${dbprefix}matchs");
                $db->set("status = 'C'");
                $db->set("statusequipe = ''");
                $db->where("id = $match->id");
                $db->exec();
            }
        }

        /** creation de la liste d'equipes n'ayant pas jou&eacute; **/
        $db->select("id,equipe1,equipe2");
        $db->from("${dbprefix}matchs");
        $db->where("type = 'W'");
        $db->where("finale = $finale");
        $db->where("tournois = $s_tournois");
        $res1 = $db->exec();

        $tab_equipes_ok = array();

        $equipes_ok = '';
        while ($matchlist = $db->fetch($res1)) {
            $equipes_ok .= "$matchlist->equipe1,$matchlist->equipe2,";
        }

        $equipes_ok = trim($equipes_ok, ",");

        $db->select("id, $champX, IFNULL(seed,10000) as seed");
        $db->from("${dbprefix}$equipesX, ${dbprefix}participe");
        $db->where("${dbprefix}$equipesX.id = ${dbprefix}participe.equipe");
        $db->where("status = 'P'");
        $db->where("tournois = $s_tournois");
        $db->where("id not in ($equipes_ok)");
        $db->order_by("seed,$champX");
        $lists = $db->exec();
        $selectlist = '';
        if ($db->num_rows($lists) != 0) {
            $selectlist .= "<option value=0>";
            $list = 1;

            while ($participant = $db->fetch($lists)) {
                $selectlist .= "<option value=" . $participant->id . ">" . $participant->$champX;
                if ($participant->seed && $participant->seed != 10000) $selectlist .= "&nbsp;(#" . $participant->seed . ")";
                $selectlist .= "";
            }
        }

        echo "<table cellspacing=2 cellpadding=2 border=0>";
        echo "<tr><td class=title colspan=7 align=middle>1/$finale $strFinale</td></tr>";

        $db->select("*");
        $db->from("${dbprefix}matchs");
        $db->where("type = 'W'");
        $db->where("finale = $finale");
        $db->where("tournois = $s_tournois");
        $matchs = $db->exec();

        /** pour tous les matchs de 1/finale **/
        while ($match = $db->fetch($matchs)) {
            echo "<tr>";

            $seed1 = seed($match->equipe1, $s_tournois);
            $seed2 = seed($match->equipe2, $s_tournois);

            if ($match->equipe1) {
                echo "<td class=info><a href=?page=finales&op=delete&id=$match->id&side=1>[$strS]</a></td>";
                echo "<td class=text align=left width=120>" . $show($match->equipe1, $op, '', $seed1) . "</td>";
            } elseif ($list == 1) {
                echo "<td class=info></td><td class=text align=center width=120>";
                echo "<form method=post>";
                echo "<input type=hidden name=op value=add>";
                echo "<input type=hidden name=id value=$match->id>";
                echo "<input type=hidden name=side value=1>";
                echo "<select name=participant onchange=submit()>$selectlist</select></td></form>";
            } else {
                echo "<td class=info></td><td class=text align=center width=120></td>";
            }

            echo "<td class=nullfinale width=15>-</td>";
            echo "<td class=text>$strVS</td>";
            echo "<td class=nullfinale width=15>-</td>";

            if ($match->equipe2) {
                echo "<td class=text align=right width=120>" . $show($match->equipe2, $op, '', $seed2, 'right') . "</td>";
                echo "<td class=info><a href=?page=finales&op=delete&id=$match->id&side=2>[$strS]</a></td>";
            } elseif ($list == 1) {
                echo "<td class=text align=center width=120>";
                echo "<form method=post>";
                echo "<input type=hidden name=op value=add>";
                echo "<input type=hidden name=id value=$match->id>";
                echo "<input type=hidden name=side value=2>";
                echo "<select name=participant onchange=submit()>$selectlist</select></td></form><td class=info></td>";
            } else {
                echo "<td class=text align=center width=120></td><td class=info></td>";
            }
            echo "</tr>";
        }
        echo "</table>";

        echo "<br><table cellspacing=1 cellpadding=2 border=0><tr>";
        echo "<td><form><input type=button value=\"$strValiderFinales\" onclick=\"javascript:valider_finales('$strValiderLesFinales')\"></td></form>";
        echo "</tr></table>";

    }
}

?>

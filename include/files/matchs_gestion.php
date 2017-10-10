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
if (preg_match("/matchs_gestion.php/i", $_SERVER['PHP_SELF'])) {
    die ("You cannot open this page directly");
}

/********************************************************
 * Activation des matchs par lot
 */
if ($op == "activer") {

    /*** test de la session ***/
    if (empty($s_tournois)) js_goto("?page=index");

    /*** verification securite ***/
    verif_admin_tournois($s_joueur, $s_tournois, $grade['a'], $grade['b'], $grade['t']);

    $msg = "";

    // si il y a de matche selectionés
    if (count($tab_matches) != 0) {

        /*** recup des matchs dans le tableau d'id a lancer ***/
        foreach ($tab_matches as $id) {

            /*** test du status du match ***/
            if (status_match($id) == 'C') {

                /*** mise a jour de la 1er manche du match ***/
                $manche = manche_premier($id);

                if ($manche) {
                    /*** mise a jour du match dans phptournois ***/
                    $db->update("${dbprefix}matchs");
                    $db->set("status = 'A'");
                    $db->where("id = $id");
                    $db->exec();

                    /*** mise a jour de la manche dans phptournois ***/
                    $db->update("${dbprefix}manches");
                    $db->set("status = 'A'");
                    $db->where("id = $manche->id");
                    $db->exec();
                } else $msg .= "$strMatch #$id : $strErreurPremiereManche<br>";
            } else $msg .= "$strMatch #$id : $strErreurStatusCache<br>";
        }
    }

    if ($msg) $db->winlog($msg, LOG_ERROR);

    /*** redirection ***/
    if ($opold == 'poules')
        js_goto("?page=matchs_poules&op=admin");
    elseif ($opold == 'finales')
        js_goto("?page=matchs_finales&op=admin&x=$x");
    elseif ($opold == 'liste')
        js_goto("?page=matchs_liste&op=admin&status=$status");


}


/********************************************************
 * Demarrage des matchs par lot
 */
if ($op == "start") {

    /*** test de la session ***/
    if (empty($s_tournois)) js_goto("?page=index");

    /*** verification securite ***/
    verif_admin_tournois($s_joueur, $s_tournois, $grade['a'], $grade['b'], $grade['t']);

    $msg = "";

    // si il y a de matche selectionés
    if (count($tab_matches) != 0) {

        if ($modescore_tournois == 'M4') {
            $dbm4 = new database;
            $dbm4->debug($m4dbdebug);
            $dbm4->connect($m4dbhost, $m4dbuser, $m4dbpass, $m4dbname);

            /** choix des prolong **/
            if ($m4prolongation) $m4prolongation = 1;
            else $m4prolongation = 0;

            /** choix de l'autostart **/
            if ($m4autostart) $m4autostart = 1;
            else $m4autostart = 0;
        } elseif ($modescore_tournois == 'AB') {

            $dbab = new database;
            $dbab->debug($abdbdebug);
            $dbab->connect($abdbhost, $abdbuser, $abdbpass, $abdbname);

            /** choix des prolong !!! ATTENTION diff de M4**/
            /** IMPOSSIBLE A GERER avec ADMINBOT car les matchs de prolong sont indépendants et donc irrécupérable automatiquement ***/
            if ($abprolongation) $abprolongation = 0;
            else $abprolongation = 1;

            /** choix de l'autostart **/
            if ($abautostart) $abautostart = 1;
            else $abautostart = 0;
        }

        srand((float)microtime() * 1000000);

        /*** recup des matchs dans le tableau d'id a lancer ***/
        foreach ($tab_matches as $id) {

            /*** test du status du match ***/
            if (status_match($id) == 'A') {

                /*** on demarre a partir de la manche active du match ***/
                $manche = manche_active($id);

                if ($manche) {

                    if ($modescore_tournois == 'M4') {

                        $match = match($manche->matchi);

                        if (empty($match->equipe1) || empty($match->equipe2)) {
                            $msg .= "$strMatch #$id : $strErreurEquipeManquante<br>";
                            continue;
                        }
                        if (empty($manche->map)) {
                            $msg .= "$strMatch #$id : $strErreurMapManquante<br>";
                            continue;
                        }
                        if (empty($match->serveur)) {
                            $msg .= "$strMatch #$id : $strErreurServeurManquant<br>";
                            continue;
                        }

                        /** choix du camps **/
                        if ($m4camps == 0) $campa1 = rand(1, 2);
                        elseif ($m4camps == 1) $campa1 = 1;
                        else $campa1 = 2;

                        /** le match existe deja dans M4 **/
                        $dbm4->select("*");
                        $dbm4->from("m4_match");
                        $dbm4->where("numero = $manche->id ");
                        $res = $dbm4->exec();

                        /*** si le match n'est pas dans M4 ***/
                        if ($dbm4->num_rows($res) == 0) {

                            /** insertion du match dans m4*/
                            $dbm4->insert("m4_match (numero, serveur, map, rule, clan1, clan2, campa1, tie)");
                            $dbm4->values("$manche->id, $match->serveur, '$manche->map', '$m4rule', $match->equipe1, $match->equipe2, $campa1, $m4prolongation");
                            $dbm4->exec();

                            if ($m4autostart == 1) {
                                /** insert du rcon */
                                $dbm4->insert("m4_rcon");
                                $dbm4->values("$match->serveur, 'm4_match $manche->id'");
                                $dbm4->exec();
                            }
                        } else {
                            $msg .= "$strMatch #$id : $strErreurMatchM4Present<br>";
                            continue;
                        }

                    } elseif ($modescore_tournois == 'AB') {

                        $match = match($manche->matchi);

                        if (empty($match->equipe1) || empty($match->equipe2)) {
                            $msg .= "$strMatch #$id : $strErreurEquipeManquante<br>";
                            continue;
                        }
                        if (empty($manche->map)) {
                            $msg .= "$strMatch #$id : $strErreurMapManquante<br>";
                            continue;
                        }
                        if (empty($match->serveur)) {
                            $msg .= "$strMatch #$id : $strErreurServeurManquant<br>";
                            continue;
                        }

                        /** choix du camps **/
                        if ($abcamps == 0) {
                            $knife = 2;

                            if (round(rand(0, 1))) {
                                $cache = $match->equipe1;
                                $match->equipe1 = $match->equipe2;
                                $match->equipe2 = $cache;
                            }
                        } elseif ($abcamps == 1) {
                            $knife = 1;

                            $cache = $match->equipe1;
                            $match->equipe1 = $match->equipe2;
                            $match->equipe2 = $cache;
                        } else
                            $knife = 0;

                        /*** date ***/
                        if ($match->date) $heure = date("H", $match->date) . "h" . date("i", $match->date);
                        else $heure = '';

                        $match_team_x = nom_equipe($match->equipe1);
                        $match_team_y = nom_equipe($match->equipe2);

                        /** le match existe deja dans AB **/
                        $dbab->select("*");
                        $dbab->from("matchs");
                        $dbab->where("MatchId = $manche->id ");
                        $res = $dbab->exec();

                        /*** si le match n'est pas dans AB ***/
                        if ($dbab->num_rows($res) == 0) {

                            /** insertion du match dans ab*/
                            $dbab->insert("matchs (MatchId, ServerId, Player1Name, Player2Name, ScheduledDate,  Map, Rules, MaxRounds, AllowTie, BreakPoint, Password, RandomSides)");
                            $dbab->values("'$manche->id', '$match->serveur', '$match_team_x', '$match_team_y', '$heure', '$manche->map', '$abrule', '$abrulecfg', '$abprolongation', '$abbreakpoint', '$match->passwd', '$abcampscfg'");
                            $dbab->exec();

                            if ($abautostart == 1) {
                                $heure_now = date(H) . "h" . date(i);

                                /** mise a jour de l'horaire **/
                                $dbab->update("Matchs");
                                //$dbab->set(" match_timeload = 1");
                                $dbab->set("ServerId = '$match->serveur'");
                                $dbab->set(" Status = 1");
                                $dbab->set(" Action = 1");
                                $dbab->where("MatchId = $manche->id");
                                $dbab->exec();
                            }
                        } else {
                            $msg .= "$strMatch #$id : $strErreurMatchABPresent<br>";
                            continue;
                        }
                    }

                    /*** mise a jour du match dans phptournois ***/
                    $db->update("${dbprefix}matchs");
                    $db->set("status = 'D'");
                    $db->where("id = $id");
                    $db->where("tournois = $s_tournois");
                    $db->exec();

                } // pas de manche active
                else $msg .= "$strMatch #$id : $strErreurPremiereManche<br>";
            } // match non  actif
            else $msg .= "$strMatch #$id : $strErreurStatusActif<br>";
        }
    }

    if ($msg) $db->winlog($msg, LOG_ERROR);

    /*** redirection ***/
    if ($opold == 'poules')
        js_goto("?page=matchs_poules&op=admin");
    elseif ($opold == 'finales')
        js_goto("?page=matchs_finales&op=admin&x=$x");
    elseif ($opold == 'liste')
        js_goto("?page=matchs_liste&op=admin&status=$status");


} /********************************************************
 * Recuperation des scores des matchs par lot ou sous status D
 */
elseif ($op == "recup") {

    /*** test de la session ***/
    if (!is_numeric($tournois)) js_goto("?page=index");

    /*** verification securite ***/
    verif_admin_tournois($s_joueur, $s_tournois, $grade['a'], $grade['b'], $grade['t']);

    $msg = "";

    // si il n'y a pas de matche selectioné, on recup tous les match en D
    if (count($tab_matches) == 0) {

        $db->select("id");
        $db->from("${dbprefix}matchs");
        $db->where("status = 'D'");
        $db->where("tournois = $tournois");
        $matches = $db->exec();

        while ($match = $db->fetch($matches)) {
            $tab_matches[] = $match->id;
        }
    }

    $modescore_tournois = modescore_tournois($tournois);

    if ($modescore_tournois == 'M4') {
        $dbm4 = new database;
        $dbm4->debug($m4dbdebug);
        $dbm4->connect($m4dbhost, $m4dbuser, $m4dbpass, $m4dbname);
    } elseif ($modescore_tournois == 'AB') {
        $dbab = new database;
        $dbab->debug($abdbdebug);
        $dbab->connect($abdbhost, $abdbuser, $abdbpass, $abdbname);
    }

    /*** recup des matchs dans le tableau d'id a recup ***/
    foreach ($tab_matches as $id) {

        /*** test du status du match ***/
        if (status_match($id) == 'D') {

            $manche = manche_active($id);

            /*** si aucune manche de ce match est active ***/
            if ($manche) {

                /*** recuperation dans la base M4 ***/
                if ($modescore_tournois == 'M4') {

                    $dbm4->select("clan1, clan2, score1, score2, etape, rule, campa1, tie");
                    $dbm4->from("m4_match");
                    $dbm4->where("numero = $manche->id ");
                    $res1 = $dbm4->exec();

                    /*** si le match est dans M4 ***/
                    if ($dbm4->num_rows($res1) == 1) {

                        $matchm4 = $db->fetch($res1);

                        // si le match est commencé, on recup d'abord juste les scores
                        if ($matchm4->etape > 0) {

                            $match = match($id);

                            /*** mise a jour des scores dans la manche en cours ***/
                            $db->update("${dbprefix}manches");
                            $db->set("score1 = $matchm4->score1");
                            $db->set("score2 = $matchm4->score2");
                            $db->where("id = $manche->id");
                            $db->exec();

                            // si le match m4 est fini, on passe a la manche suivante ou on termine le match et on calcule l'arbre
                            if ($matchm4->etape == 14) {

                                /*** selection de la manche suivante dans phptournois***/
                                $nextmanche = manche_suivante($id, $manche->id);

                                /*** on update la manche et creation de la suivante dans M4  ***/
                                if ($nextmanche) {

                                    if (empty($match->equipe1) || empty($match->equipe2)) {
                                        $msg .= "$strMatch #$id : $strErreurEquipeManquante<br>";
                                        continue;
                                    }
                                    if (empty($nextmanche->map)) {
                                        $msg .= "$strMatch #$id : $strErreurMapManquante<br>";
                                        continue;
                                    }
                                    if (empty($match->serveur)) {
                                        $msg .= "$strMatch #$id : $strErreurServeurManquant<br>";
                                        continue;
                                    }

                                    /** choix du camps **/
                                    if ($matchm4->campa1 == 0) $campa1 = rand(1, 2);
                                    elseif ($matchm4->campa1 == 1) $campa1 = 2;
                                    else $campa1 = 1;

                                    /** insertion du match dans m4*/
                                    $dbm4->insert("m4_match (numero, serveur, map, rule, clan1, clan2, campa1, tie)");
                                    $dbm4->values("$nextmanche->id, $match->serveur, '$nextmanche->map', '$matchm4->rule', $match->equipe1, $match->equipe2, $matchm4->campa1, $matchm4->tie");
                                    $dbm4->exec();

                                    $dbm4->insert("m4_rcon");
                                    $dbm4->values("$match->serveur, 'm4_match $nextmanche->id'");
                                    $dbm4->exec();

                                    /** update des manches **/
                                    $db->update("${dbprefix}manches");
                                    $db->set("status = 'C'");
                                    $db->where("id = $manche->id");
                                    $db->exec();

                                    $db->update("${dbprefix}manches");
                                    $db->set("status = 'A'");
                                    $db->where("id = $nextmanche->id");
                                    $db->exec();
                                } else {

                                    /** mise a jour des manches en cours **/
                                    $db->update("${dbprefix}manches");
                                    $db->set("status = 'C'");
                                    $db->where("matchi = $id");
                                    $db->exec();

                                    /** si on est en phase finale, on ne termine pas le match si nul **/
                                    /*if($match->type!='P') {

                                        $equipe_g=equipe_gagnante($id);
                                        $equipe_p=equipe_perdante($id);

                                        // si le match est nul, on stoppe
                                        if($equipe_g==0 && $equipe_p==0) continue;
                                    }
                                    */
                                    /*** sinon on termmine le match dans phptournois ***/
                                    $db->update("${dbprefix}matchs");
                                    $up_d = time();
                                    $db->set("status = 'T', up='$up_d'");
                                    $db->where("id = $id");
                                    $db->where("tournois = $tournois");
                                    $db->exec();

                                    calcul_finales($id);
                                }
                            }
                            // manche pas finie
                        }
                    } // Match manquant dans M4
                    else $msg .= "$strMatch #$id : $strErreurMatchM4Manquant<br>";
                } /*** recuperation dans la base AB ***/
                elseif ($modescore_tournois == 'AB') {

                    $dbab->select("MatchId, Player1Name, Player2Name, Player1ScoreSet1, Player1ScoreSet2, Player2ScoreSet1, Player2ScoreSet2, Status, Map, ServerId , Password, ScheduledDate, MaxRounds, AllowTie");
                    $dbab->from("matchs");
                    $dbab->where("MatchId = $manche->id ");
                    $res1 = $dbab->exec();

                    /*** si le match est dans AB ***/
                    if ($dbab->num_rows($res1) == 1) {

                        $matchab = $db->fetch($res1);

                        // si le match est commenc�, on recup d'abord juste les scores
                        if ($matchab->Status > 0) {

                            /*** mise a jour des scores dans la manche en cours ***/
                            $score1 = $matchab->Player1ScoreSet1 + $matchab->Player1ScoreSet2;
                            $score2 = $matchab->Player2ScoreSet1 + $matchab->Player2ScoreSet2;

                            $match = match($id);

                            if ($matchab->Player1Name == nom_equipe($match->equipe1)) {
                                $db->update("${dbprefix}manches");
                                $db->set("score1 = $score1");
                                $db->set("score2 = $score2");
                                $db->where("id = $manche->id");
                                $db->exec();
                            } else {
                                $db->update("${dbprefix}manches");
                                $db->set("score1 = $score2");
                                $db->set("score2 = $score1");
                                $db->where("id = $manche->id");
                                $db->exec();
                            }

                            // si le match est fini, on passe a l'etape suivante ou on termine le match et on calcule l'arbre
                            if ($matchab->Status == 5) {

                                /*** selection de la manche suivante dans phptournois***/
                                $nextmanche = manche_suivante($id, $manche->id);

                                /*** si une autre manche, on update cette manche et creation de la suivante dans aB  ***/
                                if ($nextmanche) {

                                    if (empty($match->equipe1) || empty($match->equipe2)) {
                                        $msg .= "$strMatch #$id : $strErreurEquipeManquante<br>";
                                        continue;
                                    }
                                    if (empty($nextmanche->map)) {
                                        $msg .= "$strMatch #$id : $strErreurMapManquante<br>";
                                        continue;
                                    }
                                    if (empty($match->serveur)) {
                                        $msg .= "$strMatch #$id : $strErreurServeurManquant<br>";
                                        continue;
                                    }

                                    /** choix du camps **/
                                    if ($matchab->RandomSides == 1) {

                                        if (round(rand(0, 1))) {
                                            $cache = $match->equipe1;
                                            $match->equipe1 = $match->equipe2;
                                            $match->equipe2 = $cache;
                                        }
                                    } elseif ($matchab->RandomSides == 0) {

                                        $cache = $match->equipe1;
                                        $match->equipe1 = $match->equipe2;
                                        $match->equipe2 = $cache;
                                    }


                                    $match_team_x = nom_equipe($match->equipe1);
                                    $match_team_y = nom_equipe($match->equipe2);

                                    /** insertion du match dans AB*/
                                    $dbab->insert("matchs (MatchId, Player1Name, Player2Name, Map, ServerId, Password, ScheduledDate, MaxRounds, Rules, AllowTie, BreakPoint, RandomSides)");
                                    $dbab->values("$manche->id, '$match_team_x', '$match_team_y', '$manche->map', $match->serveur, '$match->passwd', '$heure', '$abrulecfg', '$abrule', $abprolongation, $abbreakpoint, $abcampscfg");
                                    $dbab->exec();
                                    //$dbab->insert("matchs (MatchId, Player1Name, Player2Name, Map, ServerId, Password, ScheduledDate, MaxRounds, AllowTie)");
                                    //$dbab->values("$nextmanche->id, '$match_team_x', '$match_team_y', '$nextmanche->map', $match->serveur, '$match->passwd', '$matchab->match_date_to_start', '$matchab->match_mr', $matchab->match_allow_tie");
                                    //$dbab->exec();

                                    //if($matchab->match_timeload==1) {
                                    //$heure_now  = date(Y)."-".date(m)."-".date(d)." ".date(H).":".date(i);

                                    /** mise a jour de l'horaire **/
                                    //$dbab->update("matchs");
                                    //$dbab->set(" match_timeload = 1");
                                    //if($heure=='') $dbab->set("ScheduledDate = '$heure_now'");
                                    //$db->where("MatchId = $nextmanche->id");
                                    //$dbab->exec();
                                    //}
                                    if ($abautostart == 1) {
                                        //$heure_now  = date(H)."h".date(i);

                                        /** mise a jour de l'horaire **/
                                        $dbab->update("matchs");
                                        //$dbab->set(" match_timeload = 1");
                                        $dbab->set("ServerId = '$match->serveur'");
                                        $dbab->set(" Status = 1");
                                        $dbab->set(" Action = 1");
                                        $dbab->where("MatchId = $nextmanche->id");
                                        $dbab->exec();
                                    }


                                    /** update des manches **/
                                    $db->update("${dbprefix}manches");
                                    $db->set("status = 'C'");
                                    $db->where("id = $manche->id");
                                    $db->exec();

                                    $db->update("${dbprefix}manches");
                                    $db->set("status = 'A'");
                                    $db->where("id = $nextmanche->id");
                                    $db->exec();
                                } else {

                                    /*** sinon on termmine le match dans phptournois ***/
                                    $db->update("${dbprefix}matchs");
                                    $db->set("status = 'T'");
                                    $db->where("id = $match->id");
                                    $db->where("tournois = $tournois");
                                    $db->exec();

                                    /** mise a jour des manches en cours **/
                                    $db->update("${dbprefix}manches");
                                    $db->set("status = 'C'");
                                    $db->where("matchi = $id");
                                    $db->exec();

                                    calcul_finales($match->id);
                                }
                            }
                            // manche pas finie
                        }
                    } // Match manquant dans AB
                    else $msg .= "$strMatch #$id : $strErreurMatchABManquant<br>";
                }
            } // pas de manche active
            else $msg .= "$strMatch #$id : $strErreurMancheActive<br>";
        } // match pas demarr�
        else $msg .= "$strMatch #$id : $strErreurStatusDemarre<br>";
    }

    if ($msg) $db->winlog($msg, LOG_ERROR);
    else show_notice($strRecupOk);

    if ($opold == 'poules')
        js_goto("?page=matchs_poules&op=admin&x=$x");
    elseif ($opold == 'finales')
        js_goto("?page=matchs_finales&op=admin&x=$x");
    elseif ($opold == 'liste')
        js_goto("?page=matchs_liste&op=admin&status=$status");

} /********************************************************
 * Recuperation AUTO des scores des matchs par lot ou sous status D
 */
elseif ($op == "autorecup") {

    /*** test de la session ***/
    if (!is_numeric($tournois) || !is_numeric($s_joueur)) echo '<script LANGUAGE="JavaScript">fermer_fenetre();</script>';

    $nom_tournois = nom_tournois($tournois);

    echo "<table cellspacing=0 cellspacing=2 border=0>";
    echo "<tr>";
    echo "<td class=title align=center>$strRecupMatchAuto $nom_tournois $strDans <span id=\"time_value\"></span></TD>";
    echo "</tr>";
    echo "</table><br>";
    echo "<iframe src=\"?page=matchs_gestion&op=recup&tournois=$tournois&header=nude\" width=\"250\" height=\"50\"></iframe>";
    echo '<br><br><script LANGUAGE="JavaScript">refresh_recup();</script>';


} /********************************************************
 * Modification d'un match
 */
elseif ($op == "modify") {

    /*** test de la session ***/
    if (empty($s_tournois)) js_goto("?page=index");

    /*** verification securite ***/
    verif_admin_tournois($s_joueur, $s_tournois, $grade['a'], $grade['b'], $grade['t']);

    if (preg_match("/([0-9]{2}|[0-9]{4}).([0-9]{2}).([0-9]{2}|[0-9]{4})[^0-9]*([0-9]{2}):([0-9]{2})/i", $date, $datetmp)) {
        $timestamp = mktime($datetmp[4], $datetmp[5], 0, $datetmp[MONTH_POS], $datetmp[DAY_POS], $datetmp[YEAR_POS]);

        // Check des mois/jours/années pour la date saisie
        if (!checkdate($datetmp[MONTH_POS], $datetmp[DAY_POS], $datetmp[YEAR_POS]) && $datetmp[YEAR_POS] >= 1970)
            $timestamp = '';

    } elseif (preg_match("/([0-9]{2}):([0-9]{2})/i", $date, $datetmp)) {
        $timestamp = mktime($datetmp[1], $datetmp[2], 0, date("m", time()), date("d", time()), date("Y", time()));
    } else
        $timestamp = '';

    /*** mise a jour des donnees du match ***/
    $db->update("${dbprefix}matchs");
    $db->set("equipe1='$equipe1'");
    $db->set("equipe2='$equipe2'");
    $db->set("status='$status'");
    $db->set("statusequipe='$statusequipe'");
    $db->set("serveur = '$serveur'");
    $db->set("passwd = '$passwd'");
    if ($status == 'T') {
        $up_d = time();
        $db->set("up='$up_d'");
    }
    if ($status == 'D') $db->set("report = 0");
    $db->set("date = '$timestamp'");
    $db->where("id=$id");
    $db->exec();

    /*** mise a jour des manches ***/
    foreach ($_POST as $key => $value) {

        preg_match("/^([a-z]+)_([0-9]+)$/", $key, $keylist);
        list(, $type, $manche) = $keylist;

        if ($type == 'map') {
            $db->select("map");
            $db->from("${dbprefix}manches");
            $db->where("matchi = $id");
            $db->where("id = $manche");
            $res = $db->exec();

            /*** mise a jour de la map dans les manches***/
            if ($db->num_rows($res) == 0) {

                if (${"map_$manche"} != '') {
                    $db->insert("${dbprefix}manches (matchi,map,score1,score2,status)");
                    if ($mancheencours == 0) $db->values("$id,'$map_0','$score1_0','$score2_0','A'");
                    else $db->values("$id,'$map_0','$score1_0','$score2_0','C'");
                    $db->exec();
                }
            } else {
                if (${"map_$manche"} == '') {
                    $db->delete("${dbprefix}manches");
                    $db->where("matchi = $id");
                    $db->where("id = $manche");
                    $db->exec();
                } else {
                    $db->update("${dbprefix}manches");
                    $db->set("map = '" . ${"map_$manche"} . "'");
                    $db->set("score1 = '" . ${"score1_$manche"} . "'");
                    $db->set("score2 = '" . ${"score2_$manche"} . "'");
                    if ($mancheencours == $manche) $db->set("status = 'A'");
                    else $db->set("status = 'C'");
                    $db->where("id = $manche");
                    $db->where("matchi = $id");
                    $db->exec();
                }
            }
        }

        /** mise a jour des manches en cours **/
        if ($status == 'T') {
            $db->update("${dbprefix}manches");
            $db->set("status = 'C'");
            $db->where("matchi = $id");
            $db->exec();
        }
    }

    calcul_finales($id);

    /*** redirection ***/
    if ($op2 == 'valider') {
        echo "<script>this.opener.location=this.opener.location;this.close();</script>";
    } else {
        js_goto("?page=matchs_gestion&op=admin&id=$id&header=win");
    }

} /********************************************************
 * Modification d'un report
 */
elseif ($op == "modify_report") {

    $match = match($id);
    $modescore_tournois = modescore_tournois($match->tournois);
    $modeequipe_tournois = modeequipe_tournois($match->tournois);

    /*** verification securite ***/
    if ($match->report != 0 || $match->status != 'D' || $modescore_tournois != 'J') fermer_fenetre();

    /*** mise a jour des donnees du match ***/
    if ((equipe_manager($match->equipe1, $s_joueur) && $modeequipe_tournois == 'E') ||
        ($match->equipe1 == $s_joueur && $modeequipe_tournois == 'J')) {
        $report = 1;
    } elseif ((equipe_manager($match->equipe2, $s_joueur) && $modeequipe_tournois == 'E') ||
        ($match->equipe2 == $s_joueur && $modeequipe_tournois == 'J')) {
        $report = 2;
    } else fermer_fenetre();

    $db->update("${dbprefix}matchs");
    $db->set("status = 'V'");
    $db->set("report = '$report'");
    $db->set("statusequipe = '$statusequipe'");
    $db->where("id = $id");
    $db->exec();

    $db->update("${dbprefix}manches");
    $db->set("status = 'C'");
    $db->where("matchi = $id");
    $db->exec();

    /*** mise a jour des manches ***/
    foreach ($_POST as $key => $value) {

        preg_match("/^([a-z]+)_([0-9]+)$/", $key, $keylist);
        list(, $type, $manche) = $keylist;

        if ($type == 'map') {
            $db->update("${dbprefix}manches");
            $db->set("score1 = '" . ${"score1_$manche"} . "'");
            $db->set("score2 = '" . ${"score2_$manche"} . "'");
            $db->where("id = $manche");
            $db->where("matchi = $id");
            $db->exec();
        }

    }

    /*** redirection ***/
    echo "<script>this.opener.location=this.opener.location;this.close();</script>";


} /********************************************************
 * Validation d'un report
 */
elseif ($op == "valider_report") {

    $match = match($id);
    $modescore_tournois = modescore_tournois($match->tournois);
    $modeequipe_tournois = modeequipe_tournois($match->tournois);

    /*** verification securite ***/
    if ($match->report == 0 || $match->status != 'V' || $modescore_tournois != 'J') fermer_fenetre();

    /*** mise a jour des donnees du match ***/
    if (($match->report == 1 && equipe_manager($match->equipe2, $s_joueur) && $modeequipe_tournois == 'E') ||
        ($match->report == 2 && equipe_manager($match->equipe1, $s_joueur) && $modeequipe_tournois == 'E') ||
        ($match->report == 1 && $match->equipe2 == $s_joueur && $modeequipe_tournois == 'J') ||
        ($match->report == 2 && $match->equipe1 == $s_joueur && $modeequipe_tournois == 'J')) {

        if ($op2 == 'valider') {
            $status = 'T';
        } elseif ($op2 == 'refuser') {
            $status = 'F';
        }
        $db->update("${dbprefix}matchs");
        $db->set("status = '$status'");
        if ($status == 'T') {
            $up_d = time();
            $db->set("up='$up_d'");
        }
        $db->where("id=$id");
        $db->exec();

        if ($op2 == 'valider') {
            calcul_finales($id);
        }

        /*** redirection ***/
        echo "<script>this.opener.location=this.opener.location;this.close();</script>";

    } else fermer_fenetre();


} /********************************************************
 * Affichage normal
 */
else {
    /*** verification securite ***/
    if ($op == 'admin') verif_admin_tournois($s_joueur, $s_tournois, $grade['a'], $grade['b'], $grade['t']);

    echo
    "<SCRIPT>
		function oneOrNoCheckboxGroup (checkbox) {
			var checkboxGroup = checkbox.form[checkbox.name];
			for (var c = 0; c < checkboxGroup.length; c++)
				if (checkboxGroup[c] != checkbox)
					checkboxGroup[c].checked = false;
		}
	</SCRIPT>";

    /*** informations sur un match ***/
    if (!empty($id)) {

        $match = match($id);

        if (!$match) fermer_fenetre();

        /** recup du type de tournois **/
        $modeequipe_tournois = modeequipe_tournois($match->tournois);
        $modescore_tournois = modescore_tournois($match->tournois);
        $modefichier_tournois = modefichier_tournois($match->tournois);
        $modecommentaire_tournois = modecommentaire_tournois($match->tournois);

        $avatar_ok = 0;

        if ($modeequipe_tournois == 'E') {
            $show = "show_equipe";
            $nom_participant = "tag_equipe";
            $champX = "tag";

            if ($config['avatar'] == 'E' || $config['avatar'] == 'A') {
                $avatar_ok = 1;
                $equipe1 = equipe($match->equipe1);
                $img1 = $equipe1->avatar_img;
                $equipe2 = equipe($match->equipe2);
                $img2 = $equipe2->avatar_img;
            }
        } else {
            $show = "show_joueur";
            $nom_participant = "nom_joueur";
            $champX = "pseudo";

            if ($config['avatar'] == 'J' || $config['avatar'] == 'A') {
                $avatar_ok = 1;
                $joueur1 = joueur($match->equipe1);
                $img1 = $joueur1->avatar_img;
                $joueur2 = joueur($match->equipe2);
                $img2 = $joueur2->avatar_img;
            }
        }

        /** type de report **/
        $report_type = 0;

        if ($op == 'report' && $modescore_tournois == 'J') {

            if ($match->report == 0 && $match->status == 'D') {
                $report_type = 1;
            } elseif (($match->report == 1 && equipe_manager($match->equipe2, $s_joueur) && $modeequipe_tournois == 'E') ||
                ($match->report == 2 && equipe_manager($match->equipe1, $s_joueur) && $modeequipe_tournois == 'E') ||
                ($match->report == 1 && $match->equipe2 == $s_joueur && $modeequipe_tournois == 'J') ||
                ($match->report == 2 && $match->equipe1 == $s_joueur && $modeequipe_tournois == 'J')) {
                $report_type = 2;
            }

        }

        if ($op == 'admin') {
            /** creation de la liste d'equipe participante **/
            $db->select("id, $champX");
            $db->from("${dbprefix}$equipesX, ${dbprefix}participe");
            $db->where("${dbprefix}$equipesX.id = ${dbprefix}participe.equipe");
            if ($match->type == 'P') $db->where("poule = $match->poule");
            $db->where("status = 'P'");
            $db->where("tournois = $match->tournois");
            $db->order_by("$champX");
            $res = $db->exec();

            while ($participant_champ = $db->fetch($res))
                $participants_list[$participant_champ->id] = $participant_champ->$champX;
        }

        echo '<form name="form" method="post">';
        if ($op == 'admin') echo '<input type="hidden" name="op" value="modify">';
        elseif ($report_type == 1) echo '<input type="hidden" name="op" value="modify_report">';
        elseif ($report_type == 2) echo '<input type="hidden" name="op" value="valider_report">';

        echo "<input type=hidden name=op2 value=''>";
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
        if ($avatar_ok && $op != 'admin') {
            echo "<tr>";
            echo "<td class=text colspan=1 align=center>";
            echo show_avatar($img1);
            echo "</td>";
            echo "<td class=text colspan=3 align=center><font size=+2>$strVS</font></td>";
            echo "<td class=text colspan=1 align=center>";
            echo show_avatar($img2);
            echo "</td>";
            echo "</tr>";
        }
        echo "<tr>";

        echo "<td class=text align=center width=120>&nbsp;&nbsp;";

        if ($op == 'admin') {
            echo "<select name=equipe1><option value=0>";

            if ($match->equipe1 && (status_participe($match->equipe1, $match->tournois) != 'P'))
                echo "<option value=$match->equipe1 SELECTED>! " . $nom_participant($match->equipe1) . " !";

            foreach ($participants_list as $eid => $enom) {
                if ($eid == $match->equipe1)
                    echo "<option value=$eid SELECTED>$enom";
                else
                    echo "<option value=$eid>$enom";
            }

            echo "</select>";
        } else {
            $seed1 = seed($match->equipe1, $match->tournois);

            if ($match->statusequipe == 'F1') echo $show($match->equipe1, '', 'F', $seed1, '');
            elseif ($match->statusequipe == 'D1') echo $show($match->equipe1, '', 'D', $seed1, '');
            else echo $show($match->equipe1, '', '', $seed1, '');
        }

        echo "</td>";
        echo show_score1($match->score1, $match->score2, $match->frags1, $match->frags2, $match->type, $match->status, $match->statusequipe, $match->modematchscore);
        if ($avatar_ok && $op != 'admin') echo "<td class=text align=center width=20></td>";
        else echo "<td class=text align=center width=20>$strVS</td>";
        echo show_score2($match->score1, $match->score2, $match->frags1, $match->frags2, $match->type, $match->status, $match->statusequipe, $match->modematchscore);

        echo "<td class=text align=center width=120>";
        if ($op == 'admin') {
            echo "<select name=equipe2><option value=0>";

            if ($match->equipe2 && (status_participe($match->equipe2, $match->tournois) != 'P'))
                echo "<option value=$match->equipe2 SELECTED>! " . $nom_participant($match->equipe2) . " !";

            foreach ($participants_list as $eid => $enom) {
                if ($eid == $match->equipe2)
                    echo "<option value=$eid SELECTED>$enom";
                else
                    echo "<option value=$eid>$enom";
            }
            echo "</select>";
        } else {
            $seed2 = seed($match->equipe2, $match->tournois);

            if ($match->statusequipe == 'F2') echo $show($match->equipe2, '', 'F', $seed2, 'right');
            elseif ($match->statusequipe == 'D2') echo $show($match->equipe2, '', 'D', $seed2, 'right');
            else echo $show($match->equipe2, '', '', $seed2, 'right');
        }

        echo "&nbsp;&nbsp;</td>";
        echo "</tr>";

        if ($op == 'admin' || $report_type == 1) {
            echo "<tr>";
            echo "<td class=text colspan=2 align=left>";
            echo "<input type=checkbox name=statusequipe value=F1 ";
            if ($match->statusequipe == "F1") echo " CHECKED";
            echo " onclick=\"oneOrNoCheckboxGroup(this);\" style=\"border: 0px;background-color:transparent;\">$strForfait&nbsp;&nbsp;";
            echo "<input type=checkbox name=statusequipe value=D1 ";
            if ($match->statusequipe == "D1") echo " CHECKED";
            echo " onclick=\"oneOrNoCheckboxGroup(this);\" style=\"border: 0px;background-color:transparent;\">$strDisqualifie";
            echo "</td>";
            echo "<td class=text></td>";
            echo "<td class=text colspan=2 align=right>";
            echo "$strDisqualifie<input type=checkbox name=statusequipe value=D2 ";
            if ($match->statusequipe == "D2") echo " CHECKED";
            echo " onclick=\"oneOrNoCheckboxGroup(this);\" style=\"border: 0px;background-color:transparent;\">&nbsp;&nbsp;";
            echo "$strForfait<input type=checkbox name=statusequipe value=F2 ";
            if ($match->statusequipe == "F2") echo " CHECKED";
            echo " onclick=\"oneOrNoCheckboxGroup(this);\" style=\"border: 0px;background-color:transparent;\">";
            echo "</td>";
            echo "</tr>";
        }

        // manches
        echo "<tr><td class=text colspan=5 align=center>";
        echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
        echo "<table cellspacing=1 cellpadding=2 border=0>";
        echo "<tr><td class=header>#</td><td class=header>A</td><td class=header>$strMap</td><td class=header width=50>$strScore 1</td><td class=header width=50>$strScore 2</td></tr>";

        $db->select("*");
        $db->from("${dbprefix}manches");
        $db->where("matchi = $match->id");
        $db->order_by("id");
        $manches = $db->exec();

        for ($i = 1; $i <= $db->num_rows($manches) + 1; $i++) {

            $manche = $db->fetch($manches);

            if ($op != 'admin' && !$manche->map) break;

            if ($i == $db->num_rows($manches) + 1) {
                $manche->id = 0;
                $manche->status = 'C';
            }

            echo "<tr>";
            echo "<td class=text align=center>$manche->id</td>";
            echo "<td class=text align=center>";
            echo "<input type=checkbox name=mancheencours value=$manche->id";
            if ($manche->status == "A") echo " CHECKED";
            if ($op != 'admin') echo " DISABLED";
            echo " onclick=\"oneOrNoCheckboxGroup(this);\" style=\"border: 0px;background-color:transparent;\">";
            echo "</td>";

            echo "<td class=text>";
            if ($op == 'admin') echo "<input type=text name=map_$manche->id value=\"$manche->map\" maxlength=20 size=20> <a href=javascript:ouvrir_fenetre('?page=maps&op=list&input=map_$manche->id&header=win','maps',100,400)>[...]</a>";
            elseif ($report_type == 1) echo "<input type=hidden name=map_$manche->id value=\"$manche->map\">$manche->map";
            else echo $manche->map;
            echo "</td>";

            echo "<td class=text align=center>";
            if ($op == 'admin' || $report_type == 1) echo "<input type=text size=2 name=\"score1_$manche->id\" value=\"$manche->score1\">";
            else echo $manche->score1;
            echo "</td>";

            echo "<td class=text align=center>";
            if ($op == 'admin' || $report_type == 1) echo "<input type=text size=2 name=\"score2_$manche->id\" value=\"$manche->score2\">";
            else echo $manche->score2;
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "</td></tr></table>";
        echo "</td></tr>";

        echo "<tr><td class=text colspan=5 align=center>";
        echo "<table cellspacing=1 cellpadding=1 border=0>";

        /** affichage du serveur **/
        if ($op == 'admin' || $match->serveur) {
            echo "<tr><td class=titlefiche>$strServeur :</td>";
            echo "<td class=textfiche>";

            if ($match->serveur == 0) $match->serveur = '';

            if ($op == 'admin') {

                $db->select("id,nom,adresse,port");
                $db->from("${dbprefix}serveurs, ${dbprefix}serveurs_tournois");
                $db->where("${dbprefix}serveurs.id = ${dbprefix}serveurs_tournois.serveur");
                $db->where("tournois = $match->tournois");
                $db->order_by("id");
                $serveurs = $db->exec();

                echo "<select name=serveur>";
                echo "<option>";
                while ($serveur = $db->fetch($serveurs)) {

                    if ($serveur->nom) $servername = $serveur->nom;
                    else $servername = "$serveur->adresse:$serveur->port";

                    echo "<option value='$serveur->id'";
                    if ($serveur->id == $match->serveur) echo " SELECTED";
                    echo ">#$serveur->id - $servername";
                }
                echo "</select>";
                echo "<input type=text name=passwd value=\"$match->passwd\" maxlength=20 size=10>";
            } elseif ($match->serveur) {
                $db->select("${dbprefix}serveurs.id, ${dbprefix}serveurs.nom,adresse,port,origine,protocole");
                $db->from("${dbprefix}serveurs, ${dbprefix}jeux");
                $db->where("${dbprefix}serveurs.jeux = ${dbprefix}jeux.id");
                $db->where("${dbprefix}serveurs.id = $match->serveur");
                $res = $db->exec();
                $serveur = $db->fetch($res);

                if ($serveur->nom) $servername = $serveur->nom;
                else $servername = "$serveur->adresse:$serveur->port";

                echo "<img src=\"images/flags/$serveur->origine.gif\" border=0 align=absmiddle> ";

                if ($serveur->protocole) echo "<a href=javascript:ouvrir_fenetre('?page=serveurs&op=voir&id=" . $serveur->id . "&header=win','servers',300,400)>$servername</a>";
                else echo "$servername";

                /** affichage du password si bonnes personnes **/
                if ($modeequipe_tournois == 'E' && !empty($s_joueur)) {

                    if ((equipe_appartient($match->equipe1, $s_joueur) || equipe_appartient($match->equipe2, $s_joueur)) && !empty($match->passwd))
                        echo " - $strPassword : $match->passwd";
                } elseif (!empty($s_joueur)) {
                    if (($s_joueur == $match->equipe1 || $s_joueur == $match->equipe2) && !empty($match->passwd))
                        echo " - $strPassword : $match->passwd";
                }
            }
            echo "</td></tr>";
        }

        /** affichage de la date **/
        if ($op == 'admin' || $match->date) {
            echo "<tr><td class=titlefiche>$strDate :</td>";
            echo "<td class=textfiche>";

            if ($op == 'admin') {
                $date = strftime(DATESTRING, $match->date);
                if (!$match->date) $date = '';
                echo "<input type=text name=date value=\"$date\" maxlength=20 size=20>";
            } else {
                $date = strftime(DATESTRING1, $match->date);
                echo $date;
            }

            echo "</td></tr>";
        }

        echo "<tr><td class=titlefiche>$strStatus :</td>";
        echo "<td class=textfiche>";
        if ($op == 'admin') {
            echo "<input type=radio name=status value=C";
            if ($match->status == "C") echo " CHECKED";
            echo " style=\"border: 0px;background-color:transparent;\"> $strCache";
            echo "<input type=radio name=status value=A";
            if ($match->status == "A") echo " CHECKED";
            echo " style=\"border: 0px;background-color:transparent;\"> $strActif";
            echo "<input type=radio name=status value=D";
            if ($match->status == "D") echo " CHECKED";
            echo " style=\"border: 0px;background-color:transparent;\"> $strEnCours";
            echo "<input type=radio name=status value=T";
            if ($match->status == "T") echo " CHECKED";
            echo " style=\"border: 0px;background-color:transparent;\"> $strTermine";
        } else {
            if ($match->status == "C") echo "$strCache";
            if ($match->status == "A") echo "<font color=orange><b>$strActif</b></font>";
            if ($match->status == "D") echo "<font color=green><b>$strEnCours</b></font>";
            if ($match->status == "V") echo "<font color=orange><b>$strValidation</b></font>";;
            if ($match->status == "F") echo "<font color=red><b>$strConflit</b></font>";;
            if ($match->status == "T") echo "<font color=red><b>$strTermine</b></font>";

        }
        echo "</td></tr>";
        echo "</table>";
        echo "</td></tr>";

        if ($op == 'admin') echo "<tr><td class=text colspan=5 align=center><input type=submit value=\"$strModifier\">&nbsp;&nbsp;&nbsp;<input type=submit value=\"$strValider\" onclick=\"document.form.op2.value='valider';return true;\"></td></tr>";
        elseif ($report_type == 1) echo "<tr><td class=text colspan=5 align=center><input type=submit value=\"$strValiderScore\"></td></tr>";
        elseif ($report_type == 2) echo "<tr><td class=text colspan=5 align=center><input type=submit value=\"$strValiderScore\" onclick=\"document.form.op2.value='valider';return true;\">&nbsp;&nbsp;&nbsp;<input type=submit value=\"$strRefuserScore\" onclick=\"document.form.op2.value='refuser';return true;\"></td></tr>";


        echo "<tr><td class=text colspan=5 align=center>";

        if ($modecommentaire_tournois != 'N') echo "<img src=\"images/icon_comment.gif\" border=0 align=absmiddle> <a href=\"#\" onclick=\"javascript:ouvrir_fenetre('?page=matchs_commentaires&match=$match->id&header=win','fichiers',400,600)\">$strCommentaires ? (" . nb_matchs_commentaires($match->id) . ")</a>&nbsp&nbsp;";
        if ($modefichier_tournois != 'N' && ($match->status == "T" || $op == 'admin')) echo "<img src=\"images/icon_attach.gif\" border=0 align=absmiddle> <a href=\"#\" onclick=\"javascript:ouvrir_fenetre('?page=matchs_browser&match=$match->id&header=win','fichiers',300,600)\">$strFichiersAttaches</a>";
        echo "</td></tr>";

        echo "</td></tr>";
        echo "</table>";

        echo "</td></tr></table>";
        echo "</td></tr></table>";

        echo "</form>";


    }

}

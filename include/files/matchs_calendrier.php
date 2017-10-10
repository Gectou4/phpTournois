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

if (preg_match("/matchs_calendrier.php/i", $_SERVER['PHP_SELF'])) {
    die ("You cannot open this page directly");
}

/*** test de la session ***/
if (empty($s_tournois)) js_goto("?page=index");

/*** fonctions ***/
function today()
{
    global $day, $month, $year;

    $month = date("m", time());
    $year = date("Y", time());
}

function is_leap_year($year)
{
    if (($year % 4 == 0 && $year % 100 != 0) || $year % 400 == 0)
        return TRUE;
    else
        return FALSE;
}

function get_month_length($year, $month)
{
    $days_number = array(0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    $days_number[2] = (is_leap_year($year)) ? 29 : 28;

    return $days_number[(int)$month];
}

function get_day_of_week($year, $month, $day)
{
    $day_of_week = (int)strftime('%w', mktime(gmdate('H'), gmdate('i'), gmdate('s'), $month, $day, $year)) - 1;

    if ($day_of_week == -1) $day_of_week = 6;

    return $day_of_week;
}

function get_weeks_number($year, $month, $day)
{
    $day_of_week = get_day_of_week($year, 1, 1);
    $days_number = 0;
    $weeks_number = 0;

    for ($m = 1; $m < $month; $m++) {
        $days_number += get_month_length($year, $m);
    }

    $days_number = $days_number + $day - (8 - $day_of_week);
    $weeks_number = floor($days_number / 7) + 1;

    if ($day_of_week == 0) $weeks_number++;

    return $weeks_number;
}

/********************************************************
 * Affichage  match
 */
if ($op == 'test') {
} /********************************************************
 * Affichage  normal
 */
else {

    /*** affichage du calendrier ***/
    echo "<p class=title>.:: $strCalendrierMatchs ::.</p>";

    /** aujourd'hui**/
    $day_now = date("d", time());
    $month_now = date("m", time());
    $year_now = date("Y", time());

    if (!isset($month) || !isset($year)) today();

    if ($month == 0) {
        $month = 12;
        $year--;
    }

    if ($month == 13) {
        $month = 1;
        $year++;
    }

    if ($year < 1582) {
        today();
    } elseif ($month < 1 || $month > 12) {
        today();
    }

    echo "<div id=calendrier class=calendrier>";
    echo "<table border=1 cellpadding=2 cellspacing=0 width=600>";

    if ($op == 'admin') $hauteur = 400;
    else $hauteur = 300;

    echo "<tr class=headercalendrier>";
    echo "<th><a href=\"?page=matchs_calendrier&month=" . $month . "&year=" . ($year - 1) . "\"><img src=images/back.gif border=0><img src=images/back.gif border=0></a></th>";
    echo "<th><a href=\"?page=matchs_calendrier&month=" . ($month - 1) . "&year=$year\"><img src=images/back.gif border=0></a></th>";
    echo "<th colspan=\"3\">" . $tabMois[$month - 1] . " $year</th>";
    echo "<th><a href=\"?page=matchs_calendrier&month=" . ($month + 1) . "&year=$year\"><img src=images/next.gif border=0></a></th>";
    echo "<th><a href=\"?page=matchs_calendrier&month=" . $month . "&year=" . ($year + 1) . "\"><img src=images/next.gif border=0><img src=images/next.gif border=0></a></th>";
    echo "<th>&nbsp;</th>";
    echo "</tr>";

    echo "<tr>";
    for ($d = 0; $d < 7; $d++) {
        echo "<td class=semaineheadercalendrier>" . substr($tabJoursSemaine[$d], 0, 3) . "</td>";
    }
    echo "<td class=semainecalendrier>" . substr($strSemaine, 0, 3) . "</td>";
    echo "</tr>";

    $week = get_weeks_number($year, $month, 1);
    $i = -get_day_of_week($year, $month, 1);

    for ($w = 0; $w < 6; $w++) {
        echo "<tr>";

        for ($d = 1; $d < 8; $d++) {

            if ($i + $d <= 0 || $i + $d > get_month_length($year, $month))
                echo "<td width=\"13.5%\" valign=top class=nojourcalendrier>&nbsp;";
            else {
                if ($i + $d == $day_now && $month == $month_now && $year == $year_now)
                    echo "<td width=\"13.5%\" valign=top class=cejourcalendrier><b><font color=red>" . ($i + $d) . "<br></font></b>";
                else
                    echo "<td width=\"13.5%\" valign=top class=jourcalendrier>" . ($i + $d) . "<br>";


                $timestamp1 = mktime(0, 0, 0, $month, ($i + $d), $year);
                $timestamp2 = mktime(23, 59, 59, $month, ($i + $d), $year);

                $db->select("*");
                $db->from("${dbprefix}matchs");
                $db->where("(status = 'D' or status = 'A')");
                $db->where("tournois = $s_tournois");
                $db->where("(date > $timestamp1 and date < $timestamp2)");
                $db->order_by("date");
                $matchs = $db->exec();

                while ($match = $db->fetch($matchs)) {
                    $date = date("H:i", $match->date);

                    if ($modeequipe_tournois == 'E' && !empty($s_joueur)) {
                        $equipes = equipes_joueur($s_joueur);

                        for ($f = 0; $f < count($equipes); $f++) {
                            if (($equipes[$f][id] == $match->equipe1) || ($equipes[$f][id] == $match->equipe2)) {
                                echo "<img src=images/next.gif border=0><a href=\"#\" onclick=\"javascript:ouvrir_fenetre('?page=matchs_gestion&op=$op&id=$match->id&header=win','match',$hauteur,500)\">$date - #$match->id</a><br>";
                                break;

                            }
                        }
                    } elseif (!empty($s_joueur)) {

                        if (($s_joueur == $match->equipe1) || ($s_joueur == $match->equipe2)) {
                            echo "<img src=images/next.gif border=0><a href=\"#\" onclick=\"javascript:ouvrir_fenetre('?page=matchs_gestion&op=$op&id=$match->id&header=win','match',$hauteur,500)\">$date - #$match->id</a><br>";
                        }
                    }
                }
            }
            echo "</td>";
        }

        //if ($week + $w == get_weeks_number($year, $month, $day))
        //	echo "<td class=CurrentWeekCalendrier>".($week + $w)."</td>";
        //else
        echo "<td width=\"5.5%\" align=center valign=middle class=semainecalendrier>" . ($week + $w) . "<br><br><br></td>";

        echo "</tr>";

        $i = $i + 7;
        if ($i >= get_month_length($year, $month)) break;
    }

    echo "</table>";
    echo "</div>";

    echo "<br><img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";

}

?>



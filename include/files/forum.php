<?php
/*
   +---------------------------------------------------------------------+
   | page : forum.php                                                    |
   | phpTournois ADDONS                 		 	         |
   | MOD Author : Gectou4 <Gectou4@hotmail.com>                  |
   +---------------------------------------------------------------------+
   +---------------------------------------------------------------------+
   | phpTournois                                                         |
   | phpTournoisG4 ©2005 by Gectou4 <Gectou4 Gectou4@hotmail.com>        |
   +---------------------------------------------------------------------+
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
if (preg_match("/forum.php/i", $_SERVER['PHP_SELF'])) {
    die ("You cannot open this page directly");
}


global $config, $s_joueur, $s_theme, $db, $dbprefix;
global $last_post_topic_i, $last_post_cat_i;

/********************************************************
 * Affichage normal (cat)
 */


// On récup�re les nouveaux messages
if ($s_joueur != "") {

    //if ($last_post_topic_i==''||$last_post_topic_i==NULL||$last_post_topic_i=='0') {

    $db->select("last_forum_join");
    $db->from("${dbprefix}joueurs");
    $db->where("id='$s_joueur'");
    $date_log = $db->exec();
    while ($data_login = $db->fetch($date_log)) {
        $last_forum_joining = $data_login->last_forum_join;
    }

    if ($last_forum_joining != '0' && $last_forum_joining != '' && $last_forum_joining != NULL) {

        $db->select("topid,cattopic");
        $db->from("${dbprefix}forum_message");
        $db->where("date >= '$last_forum_joining'");
        //$db->where("auteur != '$s_joueur'");
        $last_see_post = $db->exec();

        //$last_post_topic=array();
        //$last_post_cat=array();
        $last_post_topic_i = 1;
        $last_post_cat_i = 1;

        while ($data_login2 = $db->fetch($last_see_post)) {

            //$last_post[$last_post_topic_i]=$data_login2->topid;

            //$last_post_cat[$last_post_cat_i]=$data_login2->cattopic;

            //$last_post[$data_login2->topid]="unread";
            setcookie($data_login2->topid, "unread", time() + 3600);

            //$last_post_cat[$data_login2->cattopic]="unread";
            setcookie($data_login2->cattopic, "unread", time() + 3600);
            setcookie("" . $data_login2->cattopic . "nb", $last_post_cat_i, time() + 3600);

            $last_post_topic_i++;
            $last_post_cat_i++;
        }


        /*

		while ($data_login = $db->fetch($date_log)) {
				$last_post[$data_login->last_forum_join]=$data_login->last_forum_join;
				}
		*/
    }

    $date = time();
    $db->update("${dbprefix}joueurs");
    $db->set("last_forum_join='$date' WHERE id=$s_joueur");
    $db->exec();

    //}
}


// FORUM =>
echo "<center><b>.: <a href='?page=forum'><b>$strForum</b></a> :.</b></center>";

if ($_GET['op'] == "" || $_GET['op'] == NULL) {

    $db->select("idcat,cattopic,cattitle,descri,id,reserved");
    $db->from("${dbprefix}forum ORDER by idcat");
    $resr = $db->exec();

    echo '<table border=1 cellpadding="0" cellspacing="0" class="bordure1" width="90%">';
    echo '<tr><td align=center colspan="4" class="headerforum">&nbsp;<span style="color:#333366";><b>' . $strForum . ' : ' . $config['nomsite'] . '</b>&nbsp;</span></td></tr>';
    echo '<tr>';
    echo '<td align=center class=endforum>&nbsp;<span style="color:black;font-size:12px";>' . $strCategorie . '&nbsp;</span></td>';
    echo '<td align=center class=endforum>&nbsp;<span style="color:black;font-size:12px";>' . $strSujet . '&nbsp;</span></td>';
    echo '<td align=center class=endforum>&nbsp;<span style="color:black;font-size:12px";>' . $strMessage . '&nbsp;</span></td>';
    echo '<td align=center class=endforum>&nbsp;<span style="color:black;font-size:12px";>' . $strDernier . '&nbsp;</span></td>';
    echo '</tr>';

    $ok = "B";
    while ($datar = $db->fetch($resr)) {

        $ifcat = '';
        $edit = '';


        $is_able_to_see = '';

        if ($grade['a'] == 'a' || $grade['b'] == 'b') {
            $is_able_to_see = 'yes';
        }

        if (preg_match('/m/i', $datar->reserved) && $grade['m'] == 'm') {
            $is_able_to_see = 'yes';
        }

        if (preg_match('/n/i', $datar->reserved) && $grade['n'] == 'n') {
            $is_able_to_see = 'yes';
        }

        if (preg_match('/u/i', $datar->reserved) && $s_joueur != '') {
            $is_able_to_see = 'yes';
        }

        if ($is_able_to_see != 'yes' && !preg_match('/u/i', $datar->reserved) && !preg_match('/m/i', $datar->reserved) && !preg_match('/n/i', $datar->reserved)) {
            $is_able_to_see = 'yes';
        }

        if ($datar->descri != '' || $datar->descri != NULL) {
            $ifcat = "<br><font size=-4>&nbsp;" . bbcode(stripslashes($datar->descri)) . "</font>";
        }

        if ($datar->cattitle != '' || $datar->cattitle != NULL) {

            // je fait trois requ�te et oui c pas bien paske si je met et incrémente des champs PHP et SQL ne veulent ni afficher C champ ni les incrémenter (c a en devenir fou Oo)
            $db->select("COUNT(id) FROM ${dbprefix}forum WHERE ((cattopic = $datar->cattopic) AND cattitle = '')");
            $db->order_by("id");
            $res = $db->exec();
            $row_data_nb = $db->fetch_array($res);

            $db->select("COUNT(id) FROM ${dbprefix}forum_message WHERE cattopic = $datar->cattopic");
            $db->order_by("id");
            $res2 = $db->exec();
            $row_data_nb_post = $db->fetch_array($res2);


            $db->select("auteur,date,edit_date,edit,topid,cattopic");
            $db->from("${dbprefix}forum_message WHERE cattopic = '$datar->cattopic' ORDER by date");
            $resr2 = $db->exec();
            $auteur = '';
            $date = '';
            $topidlast = '';
            $topiclast = '';
            $cattopiclast = '';
            while ($datar2 = $db->fetch($resr2)) {
                $auteur = show_joueur($datar2->auteur);
                $date = $datar2->date;
                $topidlast = $datar2->topid;
                $topiclast = $datar2->topic;
                $cattopiclast = $datar2->cattopic;
                if ($datar2->edit == 'O') {
                    $date = $datar2->edit_date;
                }
            }
            if (!empty($date)) $date = @strftime("%c", $date);

            $ok = "A";
            if ($is_able_to_see == 'yes') {
                echo '<tr><td class="catfiche" align="left"><div align=left>&nbsp;<a href="?page=forum&op=topic&cat=' . $datar->cattopic . '&titre=' . base64_encode($datar->cattitle) . '">';
                // if news message
                //if ($last_post_cat[$datar->cattopic]=="unread") {
                //if ($_COOKIE[$datar->cattopic]=="unread") {
                if ($_COOKIE[$datar->cattopic] == "unread") {
                    echo '<img src="themes/' . $s_theme . '/images/folder_new_big.gif" border="0" align="absmiddle" />';
                } else {
                    echo '<img src="themes/' . $s_theme . '/images/folder_big.gif" border="0" align="absmiddle" />';
                }
                echo '<b><u>' . bbcode(stripslashes($datar->cattitle)) . '</u></b></a>&nbsp;&nbsp;&nbsp;';

                if ($grade['a'] == 'a' || $grade['b'] == 'b') {
                    echo '<a href="?page=forum&op=edicat&id=' . $datar->id . '&topid=' . $topid . '&cat=' . $datar->cattopic . '"><img src="themes/' . $s_theme . '/images/topic_edit.gif" align=absmiddle border="0" /></a> <a href="?page=forum&op=deletecat&id=' . $datar->id . '&cattopic=' . $cat . '&topid=' . $topid . '&titre=' . $titre . '"><img src="themes/' . $s_theme . '/images/topic_delete.gif" align=absmiddle border="0" /></a>';
                }
                echo '' . $ifcat . '</td><td class="catfiche" align="center"><div align="center"> ' . $row_data_nb[0] . ' </div></td>';
                echo '<td class="catfiche" align="center"><div align="center"> ' . $row_data_nb_post[0] . ' </div></td>';
                if (!empty($auteur)) echo '<td class="catfiche" align="center"><div align=center>' . $auteur . '<a href="?page=forum&op=read&topid=' . $topidlast . '&cattopic=' . $cattopiclast . '&toplast=1&topic=&titre=' . base64_encode($datar->cattitle) . '"><img src="themes/' . $s_theme . '/images/icon_latest_reply.gif" border="0" /></a><br><font size=-4>' . $date . '</font></div></td></tr>';
                else echo '<td class="catfiche" align="center">-</td></tr>';

                //	echo'<td class="catfiche" align="center"><b><div align=center>'.$total_topic.'</div></b></td>';
                echo '</tr>';
            } else {
                $ok = "C";
            }
        }
    }
    if ($ok == "B") {
        echo '<tr><td class="catfiche" colspan="4" align="center">' . $strFras . '</td></tr>';
    } else if ($ok == "C") {
        echo '<tr><td class="catfiche" colspan="4" align="center"><div align="center">' . $strFrasUnacces . '</DIV></td></tr>';
    }

    if ($grade['a'] == 'a' || $grade['b'] == 'b') {
        echo '<tr><td align=right colspan="4" class=endforum><a href="?page=forum&op=addcat"><img src="themes/' . $s_theme . '/images/t_new.gif" border=0 ></a></td></tr>';
    } else {
        echo '<tr><td align=right colspan="4" class=endforum>&nbsp;</td></tr>';
    }
    echo '</table><br>';
}
/********************************************************
 * Affichage TOPIC
 */

if ($_GET['op'] == "topic") {
    $cat = $_GET['cat'];
    $tit = $_GET['titre'];
    $titre = remove_XSS(base64_decode($tit));

    $new_count_sook = $_COOKIE['' . $cat . 'nb'];
    if ($new_count_sook == 1 || $new_count_sook == '1' || $new_count_sook == '' || $new_count_sook == NULL) {
        setcookie("" . $cat . "nb", "", time() - 9999999);
        setcookie("" . $cat . "", "", time() - 9999999);

    }
    $db->select("reserved");
    $db->from("${dbprefix}forum WHERE (cattopic='$cat' AND cattitle != '')");
    $resrX = $db->exec();

    while ($datarX = $db->fetch($resrX)) {
        $reserved = $datarX->reserved;
    }
    $is_able_to_see = '';
    if ($grade['a'] == 'a' || $grade['b'] == 'b') {
        $is_able_to_see = 'yes';
    }
    if (preg_match('/m/i', $reserved) && $grade['m'] == 'm') {
        $is_able_to_see = 'yes';
    }
    if (preg_match('/n/i', $reserved) && $grade['n'] == 'n') {
        $is_able_to_see = 'yes';
    }
    if (preg_match('/u/i', $reserved) && ($grade['z'] == 'z')) {
        $is_able_to_see = 'yes';
    }
    if ($is_able_to_see != 'yes' && !preg_match('/u/i', $datar->reserved) && !preg_match('/m/i', $datar->reserved) && !preg_match('/n/i', $datar->reserved)) {
        $is_able_to_see = 'yes';
    }
    if ($is_able_to_see != 'yes') {
        js_goto("?page=forum");
    }


    //echo '----+>'.$new_count_sook.'----';
    //echo '----+>'.$cat.'----';
    if ($_GET['delc'] == 'oui') {
        setcookie("" . $cat . "nb", "", time() - 9999999);
        setcookie("" . $cat . "", "", time() - 9999999);
    }


    $db->select("count(id)");
    $db->from("${dbprefix}forum");
    $db->where("topic!=''");
    $db->where("topic!=0");
    $db->where("cattopic=$cat");
    $res = $db->exec();
    $row_topic = $db->fetch_array($res);
    $total_topic = $row_topic[0];

    if ($total_topic == '' || $total_topic == NULL || $total_topic == "0") {
        $total_topic = "1";
    }

    if ($nbtop != "" || $nbtop != NULL) {
        $topic_end = $nbtop;
    } else {
        $topic_end = "20";
    }
    if ($total_topic / $topic_end > intval($total_topic / $topic_end)) {
        $nbtopicpage = intval($total_topic / $topic_end) + 1;
    } elseif ($total_topic / $topic_end <= intval($total_topic / $topic_end)) {
        $nbtopicpage = (intval($total_topic / $topic_end));
    }

    if ($nbtopicpageX == '' || $nbtopicpageX == NULL || $nbtopicpageX == '0') {
        $nbtopicpageX = 1;
    }

    echo '<table border="0" cellpadding="2" cellspacing="0" class="" width="90%"><td class="headforum" colspan="2" style="vertical-align: middle;"><img src="themes/' . $s_theme . '/images/navf.gif" border="0" alt="" align="absmiddle">&nbsp;<a href="?page=forum"><b>Index : ' . $config['nomsite'] . '</b></a> &gt; <a href="?page=forum&op=topic&cat=' . $cat . '&titre=' . base64_encode($titre) . '"><b>' . bbcode(stripslashes($titre)) . '</b></a></td></tr></table>';
    echo '<table border="0" cellpadding="4" cellspacing="1" class="bordure1" width="90%">';

    echo '<tr><td class="headerforum" colspan="3" align="left" ><a href=""><b><u><font color=#222266>' . bbcode(stripslashes($titre)) . '</font></u></b></a></td></tr>';

    if ($s_joueur != "" && $s_joueur != NULL) {

        echo '<tr><td colspan="3" class="headforum" style="vertical-align: middle;"><a href="?page=forum&op=addtopic&cattopic=' . $cat . '&titre=' . $tit . '"><img src="themes/' . $s_theme . '/images/t_new.gif" align="right" border=0 /></a>';
        echo '</td></tr>';
    }

    echo '<form method=post name="forum_formu"action="?page=forum&op=topic&cat=' . $cat . '&titre=' . base64_encode($titre) . '">';

    echo '<tr><td colspan="3" class=textfiche align=center>';


    //tableau def affichage

    echo " $strFNbpage <select name=nbtopicpageX>";
    echo "<option value=\"" . $nbtopicpageX . "\" >" . $nbtopicpageX . "</option>";

    for ($nbpage = "1"; $nbpage <= $nbtopicpage; $nbpage++) {
        echo "<option value=\"" . $nbpage . "\" >" . $nbpage . "</option>";
    }

    echo "</select>";
    echo " $strAvec ";
    echo "<select name=nbtop>";
    echo "<option value=\"" . $topic_end . "\" >" . $topic_end . "</option>";
    echo "<option value=\"10\" >10</option>";
    echo "<option value=\"20\" >20</option>";
    echo "<option value=\"30\" >30</option>";
    echo "<option value=\"40\" >40</option>";
    echo "<option value=\"50\" >50</option>";
    echo "<option value=\"60\" >60</option>";
    echo "<option value=\"70\" >70</option>";
    echo "<option value=\"80\" >80</option>";
    echo "<option value=\"90\" >90</option>";
    echo "<option value=\"100\" >100</option>";

    echo "</select> $strFnbtop ";


    if ($desc == "O") {
        $desc2 = "$strCroissant";
    } elseif ($desc == "N") {
        $desc2 = "$strDecroissant";
    } elseif ($desc == '' || $desc == NULL) {
        $desc2 = "$strCroissant";
        $desc = "O";
    }

    echo "$strFnbtdd <select name=desc>";
    echo "<option value=\"" . $desc . "\" >" . $desc2 . "</option>";
    echo "<option value=\"O\" >$strCroissant</option>";
    echo "<option value=\"N\" >$strDecroissant</option>";
    echo "</select>";
    echo "&nbsp;<input type=submit value=\"$strOK\">";
    echo "</td></tr>";
    echo "</form>";
    //debut du tableau forum (def)
    echo '<tr><td class="textforum"></td><td class="headerfiche"><div align=left><b>' . $strTopic . '</b></div></td><td class="headerfiche" width=1%><div align=center><font size=-4><b>' . $strFLast . '</b></font></div></td></tr>';


    if ($desc == "O") {
        $desct = "DESC";
    } else if ($desc == "" || $desc == NULL) {
        $desct = "DESC";
    } else {
        $desct = "";
    }
    $topic_start = ($nbtopicpageX * $topic_end) - $topic_end;
    $db->select("topic,topid,topic_date,reserved");
    $db->from("${dbprefix}forum WHERE cattopic=$cat ORDER by topic_date " . $desct . " LIMIT $topic_start,$topic_end");
    $resr = $db->exec();


    while ($datar = $db->fetch($resr)) {


        // requete interne
        $topid = $datar->topid;
        $db->select("auteur,locking");
        $db->from("${dbprefix}forum_message WHERE topid=$topid ORDER by id");
        $resr2 = $db->exec();

        while ($datar2 = $db->fetch($resr2)) {
            $auteur = show_joueur($datar2->auteur);
            $locki = $datar2->locking;
        }
        //en requete interne

        $date = strftime("%c", $datar->topic_date);

        if ($datar->topic != '' || $datar->topic != NULL) {
            echo '<tr>';
            echo '<td class="endforum" align="center" width="1%">';
            if ($locki == '1') {
                echo '<img border="0" src="themes/' . $s_theme . '/images/topic_lock.gif" valign="middle">';
            } else if ($_COOKIE[$datar->topid] == "unread") {
                echo '<img border="0" src="themes/' . $s_theme . '/images/navnew.gif" valign="middle">';
            } else {
                echo '<img border="0" src="themes/' . $s_theme . '/images/nav.gif" valign="middle">';
            }
            echo '</td><td class="topicfiche" align="left"> <a href="?page=forum&op=read&topid=' . $datar->topid . '&cattopic=' . $cat . '&topic=' . base64_encode($datar->topic) . '&titre=' . base64_encode($titre) . '"><b>' . bbcode(stripslashes($datar->topic)) . '</b></a>';
            echo '</td><td class="topicfiche" align="left"><div align=center>' . $auteur . '<a href="?page=forum&op=read&topid=' . $datar->topid . '&cattopic=' . $cat . '&topic=' . base64_encode($datar->topic) . '&titre=' . base64_encode($titre) . '"><img src="themes/' . $s_theme . '/images/icon_latest_reply.gif" border="0" /></a><br><font size=-4>' . $date . '</font></div></td></tr>';


        }
    }
    // ajout choix affichage
    echo '<form method=post name="forum_formu"action="?page=forum&op=topic&cat=' . $cat . '&titre=' . base64_encode($titre) . '">';
    echo '<tr><td colspan="3" class=textfiche align=center>';
    //tableau def affichage
    echo "$strFNbpage <select name=nbtopicpageX>";
    echo "<option value=\"" . $nbtopicpageX . "\" >" . $nbtopicpageX . "</option>";

    for ($nbpage = "1"; $nbpage <= $nbtopicpage; $nbpage++) {
        echo "<option value=\"" . $nbpage . "\" >" . $nbpage . "</option>";
    }

    echo "</select>";
    echo " $strAvec ";
    echo "<select name=nbtop>";
    echo "<option value=\"" . $topic_end . "\" >" . $topic_end . "</option>";
    echo "<option value=\"10\" >10</option>";
    echo "<option value=\"20\" >20</option>";
    echo "<option value=\"30\" >30</option>";
    echo "<option value=\"40\" >40</option>";
    echo "<option value=\"50\" >50</option>";
    echo "<option value=\"60\" >60</option>";
    echo "<option value=\"70\" >70</option>";
    echo "<option value=\"80\" >80</option>";
    echo "<option value=\"90\" >90</option>";
    echo "<option value=\"100\" >100</option>";

    echo "</select> $strFnbtop ";


    if ($desc == "O") {
        $desc2 = "$strCroissant";
    } elseif ($desc == "N") {
        $desc2 = "$strDecroissant";
    } elseif ($desc == '' || $desc == NULL) {
        $desc2 = "$strCroissant";
        $desc = "O";
    }

    echo "$strFnbtdd <select name=desc>";
    echo "<option value=\"" . $desc . "\" >" . $desc2 . "</option>";
    echo "<option value=\"O\" >$strCroissant</option>";
    echo "<option value=\"N\" >$strDecroissant</option>";
    echo "</select>";
    echo "&nbsp;<input type=submit value=\"$strOK\">";
    echo "</td></tr>";
    echo "</form>";
    //end ajout choix affichage

    //reply / nouveau

    echo '<tr><td colspan="3" class=endforum>';
    if ($s_joueur != "" && $s_joueur != NULL) {
        echo '<a href="?page=forum&op=addtopic&cattopic=' . $cat . '&titre=' . $tit . '"><img src="themes/' . $s_theme . '/images/t_new.gif" align=right border=0 /></a>';
    } else {
        echo $strFneedlog;
        echo '<center><img src="images/back.gif" border=0 align=align=absmiddle> <a href=javascript:back() class=action>' . $strRetour . '</a></center>';
    }

    echo '</td></tr>';
    echo '<tr><td class=endforum align="left" colspan="3" valign="left">';
    echo '<div align="right"><a href="?page=forum&op=topic&cat=' . $cat . '&titre=' . $tit . '&delc=oui">' . $strDelCatCookie . '</a></div>';
    echo '</td></tr>';
    echo '</table><br>';

}
/********************************************************
 * Affichage sujet
 */
if ($_GET['op'] == "read") {


    $topiced = '';
    $topid = $_GET['topid'];
    $topic = $_GET['topic'];
    if ($topic == '' || $_GET['toplast'] == '1') {
        $db->select("topic");
        $db->from("${dbprefix}forum_message");
        $db->where("topid = '$topid'");
        $db->where("topic != ''");
        $db->order_by("topic");
        $resre = $db->exec();

        while ($datare = $db->fetch($resre)) {
            $topic = base64_encode($datare->topic);
        }

    }
    $topiced = remove_XSS(base64_decode($topic));
    $cat = $_GET['cattopic'];
    $titre = $_GET['titre'];
    $titred = remove_XSS(base64_decode($titre));
    $header_ttestX = 'O';
    setcookie($topid, "", time() - 9999999);
    $new_count_sook = $_COOKIE['' . $cat . 'nb'];
    $new_count_sook = $new_count_sook--;

    if ($new_count_sook == 1 || $new_count_sook == '1') {
        setcookie("" . $cat . "nb", "", time() - 9999999);
        setcookie("" . $cat . "", "", time() - 9999999);
    } else {
        setcookie("" . $cat . "nb", $new_count_sook, time() + 3600);
    }

    $db->select("reserved");
    $db->from("${dbprefix}forum WHERE (cattopic='$cat' AND cattitle != '')");
    $resrX = $db->exec();

    while ($datarX = $db->fetch($resrX)) {
        $reserved = $datarX->reserved;
    }
    $is_able_to_see = '';
    if ($grade['a'] == 'a' || $grade['b'] == 'b') {
        $is_able_to_see = 'yes';
    }
    if (preg_match('/m/i', $reserved) && $grade['m'] == 'm') {
        $is_able_to_see = 'yes';
    }
    if (preg_match('/n/i', $reserved)) {
        $is_able_to_see = 'yes';
    }
    if (preg_match('/u/i', $reserved) && ($grade['z'] == 'z')) {
        $is_able_to_see = 'yes';
    }
    if ($is_able_to_see != 'yes' && !preg_match('/u/i', $datar->reserved) && !preg_match('/m/i', $datar->reserved) && !preg_match('/n/i', $datar->reserved)) {
        $is_able_to_see = 'yes';
    }
    if ($is_able_to_see != 'yes') {
        js_goto("?page=forum");
    }


    $db->select("count(id)");
    $db->from("${dbprefix}forum_message");
    $db->where("topid='$topid'");
    $resX = $db->exec();
    $row_topic = $db->fetch_array($resX);
    $total_topic = $row_topic[0];

    if ($total_topic == '' || $total_topic == NULL || $total_topic == "0") {
        $total_topic = "1";
    }

    if ($nbtop != "" || $nbtop != NULL) {
        $topic_end = $nbtop;
    } else {
        $topic_end = "20";
    }

    if ($total_topic / $topic_end > intval($total_topic / $topic_end)) {
        $nbtopicpage = intval($total_topic / $topic_end) + 1;
    } elseif ($total_topic / $topic_end <= intval($total_topic / $topic_end)) {
        $nbtopicpage = (intval($total_topic / $topic_end));
    }

    if ($nbtopicpageX == '' || $nbtopicpageX == NULL || $nbtopicpageX == '0') {
        $nbtopicpageX = 1;
    }

    if (!$topic || !$cat || !$titre || !$topid) {
        js_goto("?page=forum");
    }

    echo '<table border="0" cellpadding="2" cellspacing="0" class="" width="90%"><td class="headforum" colspan="2" style="vertical-align: middle;"><img src="themes/' . $s_theme . '/images/navf.gif" border="0" alt="" align="absmiddle">&nbsp;<a href="?page=forum"><b>Index : ' . $config['nomsite'] . '</b></a> &gt; <a href="?page=forum&op=topic&cat=' . $cat . '&titre=' . $titre . '"><b>' . bbcode(stripslashes($titred)) . '</b></a> &gt; <a href=""><b>' . bbcode(stripslashes($topiced)) . '</b></a></td></tr></table>';
    echo '<table border=1 cellpadding="0" cellspacing="0" class="bordure1" width="90%">';
    echo '<tr><td class="headerforum" colspan="3" align="left"><a href="?page=forum&op=topic&cat=' . $cat . '&titre=' . $titre . '"><b><u><span style=\'color:#222266\'>' . bbcode(stripslashes($titred)) . '</span></u></b></a></td></tr>';
    echo '<tr>';

    if ($s_joueur != "" && $s_joueur != NULL) {
        $db->select("locking");
        $db->from("${dbprefix}forum_message WHERE topid=$topid");
        $reslock = $db->exec();
        while ($islock = $db->fetch($reslock)) {
            if ($islock->locking == 1) $lock = 1;
        }
        if ($lock == 1) {
            echo '<td class="endforum" colspan="3"><center><img src="themes/' . $s_theme . '/images/reply-locked.gif" border=0 /></center>';
        } else {
            echo '<td class="endforum" colspan="3" style="text-align: right;"><a href="?page=forum&op=addreply&topid=' . $topid . '&cattopic=' . $cat . '&titre=' . $titre . '&nbtopicpageX=' . $nbtopicpageX . '&nbtop=' . $nbtop . '"><img src="themes/' . $s_theme . '/images/t_reply.gif" border=0 align="absmiddle" ></a><a href="?page=forum&op=addtopic&cattopic=' . $cat . '&titre=' . $titre . '&topid=' . $topid . '&topic=' . $topic . '"><img src="themes/' . $s_theme . '/images/t_new.gif" align="absmiddle" border="0" ></a>';
        }
    } else {
        echo $strFneedlog;
        echo '<td class="endforum" colspan="3"><center><img src="images/back.gif" border=0 align=align=absmiddle> <a href=javascript:back() class=action>' . $strRetour . '</a></center>';
    }
    echo '</td></tr>';
    /*echo '<tr><td class="headforum">';
		if($s_joueur!="" && $s_joueur!=NULL) {
		if($lock=='1'){
		echo '<center><img src="themes/'.$s_theme.'/images/reply-locked.gif.gif" align=right border=0 ></center>';
		}else{
		echo '<a href="?page=forum&op=addtopic&cattopic='.$cat.'&titre='.$titre.'&topid='.$topid.'&topic='.$topic.'"><img src="themes/'.$s_theme.'/images/t_new.gif" align=right border=0 ></a><a href="?page=forum&op=addreply&topid='.$topid.'&cattopic='.$cat.'&titre='.$titre.'&nbtopicpageX='.$nbtopicpageX.'&nbtop='.$nbtop.'"><img src="themes/'.$s_theme.'/images/t_reply.gif" border=0 ></a>';
		}
		} else {
		echo $strFneedlog;
		echo '<center><img src="images/back.gif" border=0 align=align=absmiddle> <a href=javascript:back() class=action>'.$strRetour.'</a></center>';
		}
		echo '</td></tr>';*/

    // ajout choix affichage
    echo '<form method=post name="forum_formu"action="?page=forum&op=read&topid=' . $topid . '&cattopic=' . $cat . '&titre=' . $titre . '&topic=' . $topic . '">';
    echo '<tr><td colspan="3" class=textfiche align=center>';
    //tableau def affichage
    echo "$strFNbpage <select name=nbtopicpageX>";
    echo "<option value=\"" . $nbtopicpageX . "\" >" . $nbtopicpageX . "</option>";

    for ($nbpage = "1"; $nbpage <= $nbtopicpage; $nbpage++) {
        echo "<option value=\"" . $nbpage . "\" >" . $nbpage . "</option>";
    }

    echo "</select>";
    echo " $strAvec ";
    echo "<select name=nbtop>";
    echo "<option value=\"" . $topic_end . "\" >" . $topic_end . "</option>";
    echo "<option value=\"10\" >10</option>";
    echo "<option value=\"20\" >20</option>";
    echo "<option value=\"30\" >30</option>";
    echo "<option value=\"40\" >40</option>";
    echo "<option value=\"50\" >50</option>";
    echo "<option value=\"60\" >60</option>";
    echo "<option value=\"70\" >70</option>";
    echo "<option value=\"80\" >80</option>";
    echo "<option value=\"90\" >90</option>";
    echo "<option value=\"100\" >100</option>";

    echo "</select> $strFnbsub ";

    /*
			if ($desc=="O") {$desc2="$strCroissant";
			}
			elseif ($desc=="N") {$desc2="$strDecroissant";
			}
			elseif ($desc==''||$desc==NULL) {$desc2="$strCroissant";$desc="O";}

			echo "$strFnbtdd <select name=desc>";
			echo "<option value=\"".$desc."\" >".$desc2."</option>";
			echo "<option value=\"O\" >$strCroissant</option>";
			echo "<option value=\"N\" >$strDecroissant</option>";
			echo "</select>";*/
    echo "&nbsp;<input type=submit value=\"$strOK\">";
    echo "</td></tr>";
    echo "</form>";
    //end ajout choix affichage

    $topic_start = ($nbtopicpageX * $topic_end) - $topic_end;

    $topic_endX = $topic_start + $topic_end;
    $db->select("*");
    $db->from("${dbprefix}forum_message WHERE topid=$topid ORDER by id LIMIT $topic_start,$topic_end");
    $resr = $db->exec();

    $message_id = 0;
    while ($datar = $db->fetch($resr)) {
        $topic_tit = $datar->topic;

        if ($datar->locking == '1') {
            $islock = 'unlock';
            $wantlock = 'iwtul';
            $strLsujet = $strIWTUL;
        } else {
            $islock = 'lock';
            $wantlock = 'iwtl';
            $strLsujet = $strIWTL;
        }

        if (($datar->topic != '' || $datar->topic != NULL)) {
            echo '<tr><td colspan="3" class="headerfiche"><a href="">' . bbcode(stripslashes($topiced)) . '</a></td></tr><tr><td colspan="3">';

            if ($datar->message != '' || $datar->message != NULL) {


                $date = strftime("%d %b %G, %Hh%M %Ss", $datar->date);

                $joueur = joueur($datar->auteur);
                $row = '';
                $edit = '';
                $is_admin_ok = '';

                $rank_av = '';

                if (preg_match('/a/i', $joueur->grade)) {
                    $is_admin_ok = 'ok';
                }
                if (preg_match('/b/i', $joueur->grade)) {
                    $is_admin_ok = 'ok';
                }
                if ($is_admin_ok == 'ok') {
                    $rank_av = '<img src="themes/' . $s_theme . '/images/admin.gif" border="0" />';
                } else if (preg_match('/m/i', $joueur->grade)) {
                    $rank_av = '<img src="themes/' . $s_theme . '/images/moderator.gif" border="0" />';
                } else if ($datar->auteur == $s_joueur) {
                }

                $is_admin_ok = '';

                if ($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['m'] == 'm') {
                    $is_admin_ok = 'ok';
                }
                if ($is_admin_ok == 'ok') {
                    $edit = '<a href="?page=forum&op=' . $wantlock . '&id=' . $datar->id . '&cat=' . $cat . '&topid=' . $topid . '&nbtopicpageX=' . $nbtopicpageX . '&nbtop=' . $nbtop . '&topic=' . $topic . '&titre=' . $titre . '" title="' . $strLsujet . '"><img src="themes/' . $s_theme . '/images/topic_' . $islock . '.gif" border="0" /></a> <a href="?page=forum&op=editreply&id=' . $datar->id . '&cat=' . $cat . '&topid=' . $topid . '&nbtopicpageX=' . $nbtopicpageX . '&nbtop=' . $nbtop . '&topic=' . $topic . '&titre=' . $titre . '" title="' . $strEdsujet . '"><img src="themes/' . $s_theme . '/images/topic_edit.gif" border="0" /></a> <a href="?page=forum&op=deletereply2&id=' . $datar->id . '&cattopic=' . $cat . '&topid=' . $topid . '&nbtopicpageX=' . $nbtopicpageX . '&nbtop=' . $nbtop . '&titre=' . $titre . '&topic=' . $topic . '&titre=' . $titre . '" title="' . $strDelsujet . '"><img src="themes/' . $s_theme . '/images/topic_delete.gif" border="0" /></a> <a href="?page=forum&op=dej_topic&id=' . $datar->id . '&cattopic=' . $cat . '&topid=' . $topid . '&nbtopicpageX=' . $nbtopicpageX . '&nbtop=' . $nbtop . '&titre=' . $titre . '&topic=' . $topic . '&titre=' . $titre . '" title="' . $strDepsujet . '" ><img src="themes/' . $s_theme . '/images/topic_move.gif" border="0" /></a>';
                } else if ($datar->auteur == $s_joueur) {
                    $edit = '<a href="?page=forum&op=editreply&id=' . $datar->id . '&cat=' . $cat . '&topid=' . $topid . '&nbtopicpageX=' . $nbtopicpageX . '&nbtop=' . $nbtop . '&topic=' . $topic . '&titre=' . $titre . '"><img src="themes/' . $s_theme . '/images/topic_edit.gif" border="0" /></a>';
                }


                if ($rank_av == '') {
                    $rank_av = $joueur->forum_userrank;
                }

                if ($rank_av == '') {
                    $tab_rank = file("themes/" . $s_theme . "/images/forum_rank/forum");


                    for ($i = 0; $i < count($tab_rank); $i++) {
                        $tab_rank_split = preg_split('/,/', $tab_rank[$i]);
                        $tab_rank_id = $tab_rank_split[0];
                        $tab_rank_egal = trim($tab_rank_split[1]);

                        if ($tab_rank_id <= $joueur->forum_post) {
                            if (preg_match('/.gif/i', $tab_rank_egal) || preg_match('/.png/i', $tab_rank_egal) || preg_match('/.jpg/i', $tab_rank_egal) || preg_match('/.jpeg/i', $tab_rank_egal)) {

                                $rank_av = "<img src='themes/" . $s_theme . "/images/forum_rank/" . $tab_rank_egal . "' border='0' />";
                            } else {
                                $rank_av = $tab_rank_egal;
                            }
                        }
                    }
                }//for


            }
        } else {

            if ($nbtopicpageX != 1 && $header_ttestX == 'O') {
                // snif
                //tester si par url => afficher page 1
                //sinon shoper le titre depuis la page 1
                echo '<tr><td class="headerfiche" colspan="3"><a href="?page=forum&op=topic&cat=' . $cat . '&titre=' . $titre . '&topic=' . $topic . '">' . bbcode(stripslashes($topiced)) . '</a></td></tr><tr><td colspan="3">';
                $header_ttestX = 'N';
            }

            $date = strftime("%d %b %G, %Hh%M %Ss", $datar->date);

            $joueur = joueur($datar->auteur);
            $row = '';
            $edit = '';
            $is_admin_ok = '';

            $rank_av = '';

            if (preg_match('/a/i', $joueur->grade)) {
                $is_admin_ok = 'ok';
            }
            if (preg_match('/b/i', $joueur->grade)) {
                $is_admin_ok = 'ok';
            }
            if ($is_admin_ok == 'ok') {
                $rank_av = '<img src="themes/' . $s_theme . '/images/admin.gif" border="0" />';
            } else if (preg_match('/m/i', $joueur->grade)) {
                $rank_av = '<img src="themes/' . $s_theme . '/images/moderator.gif" border="0" />';
            }

            $is_admin_ok = '';

            if ($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['m'] == 'm') {
                $is_admin_ok = 'ok';
            }
            if ($is_admin_ok == 'ok') {
                $edit = '<a href="?page=forum&op=' . $wantlock . '&id=' . $datar->id . '&cat=' . $cat . '&topid=' . $topid . '&nbtopicpageX=' . $nbtopicpageX . '&nbtop=' . $nbtop . '&topic=' . $topic . '&titre=' . $titre . '" title="' . $strLsujet . '"><img src="themes/' . $s_theme . '/images/topic_' . $islock . '.gif" border="0" /></a> <a href="?page=forum&op=editreply&id=' . $datar->id . '&cat=' . $cat . '&topid=' . $topid . '&nbtopicpageX=' . $nbtopicpageX . '&nbtop=' . $nbtop . '&topic=' . $topic . '&titre=' . $titre . '" title="' . $strEdsujet . '"><img src="themes/' . $s_theme . '/images/topic_edit.gif" border="0" /></a> <a href="?page=forum&op=deletereply&id=' . $datar->id . '&cattopic=' . $cat . '&topid=' . $topid . '&nbtopicpageX=' . $nbtopicpageX . '&nbtop=' . $nbtop . '&titre=' . $titre . '&topic=' . $topic . '&titre=' . $titre . '" title="' . $strDelsujet . '"><img src="themes/' . $s_theme . '/images/topic_delete.gif" border="0" /></a> <a href="?page=forum&op=dej_topic&id=' . $datar->id . '&cattopic=' . $cat . '&topid=' . $topid . '&nbtopicpageX=' . $nbtopicpageX . '&nbtop=' . $nbtop . '&titre=' . $titre . '&topic=' . $topic . '&titre=' . $titre . '" title="' . $strDepsujet . '" ><img src="themes/' . $s_theme . '/images/topic_move.gif" border="0" /></a>';
            } else if ($datar->auteur == $s_joueur) {
                $edit = '<a href="?page=forum&op=editreply&id=' . $datar->id . '&cat=' . $cat . '&topid=' . $topid . '&nbtopicpageX=' . $nbtopicpageX . '&nbtop=' . $nbtop . '&topic=' . $topic . '&titre=' . $titre . '"><img src="themes/' . $s_theme . '/images/topic_edit.gif" border="0" /></a>';
            }


            if ($rank_av == '') {
                $rank_av = $joueur->forum_userrank;
            }

            if ($rank_av == '') {
                $tab_rank = file("themes/" . $s_theme . "/images/forum_rank/forum");


                for ($i = 0; $i < count($tab_rank); $i++) {
                    $tab_rank_split = preg_split('/,/', $tab_rank[$i]);
                    $tab_rank_id = $tab_rank_split[0];
                    $tab_rank_egal = trim($tab_rank_split[1]);

                    if ($tab_rank_id <= $joueur->forum_post) {
                        if (preg_match('/.gif/i', $tab_rank_egal) || preg_match('/.png/i', $tab_rank_egal) || preg_match('/.jpg/i', $tab_rank_egal) || preg_match('/.jpeg/i', $tab_rank_egal)) {

                            $rank_av = "<img src='themes/" . $s_theme . "/images/forum_rank/" . $tab_rank_egal . "' border='0' />";
                        } else {
                            $rank_av = $tab_rank_egal;
                        }
                    }
                }
            }//for

        }

        $message_id++;
        echo '<table border=0 cellpadding="4" cellspacing="1" width=100%>';
        echo '<tr><td class="textforum2" width="25%">' . show_joueur($datar->auteur) . '</td>';
        echo '<td class="textforum3">';
        echo "<div align='left' style='float:left;padding-top:4px;padding-bottom:4px'>";
        echo '' . $strLe . ' ' . $date . '';
        echo '</div>';
        echo "<div align='right' style='float:right;padding-top:4px;padding-bottom:4px'>";
        echo $edit;
        echo '</div></td></tr>';

        echo '<tr><td class="textforum4" width="25%">' . show_avatar($joueur->avatar_img) . '<br><div align="center">' . $rank_av . '<br>' . $joueur->forum_userrank . '<br><div align="left">' . $strNbpost . ' : ' . $joueur->forum_post . '</td>';
        echo '<td class="textforum">' . bbcode(stripslashes($datar->message)) . '';
        if ($datar->edit == 'O') {
            echo "<br><br><br><br><font size='-3'>&nbsp;<b>$strFedit</b> " . strftime("%c", $datar->edit_date) . " $strBy " . nom_joueur($datar->edit_by) . "</font>";
        }
        echo '</td></tr>';
        echo '</table>';

    }
    echo '</td></tr>';
    // ajout choix affichage
    echo '<form method=post name="forum_formu"action="?page=forum&op=read&topid=' . $topid . '&cattopic=' . $cat . '&titre=' . $titre . '&topic=' . $topic . '">';
    echo '<tr><td colspan="3" class=textfiche align=center>';
    //tableau def affichage
    echo "$strFNbpage <select name=nbtopicpageX>";
    echo "<option value=\"" . $nbtopicpageX . "\" >" . $nbtopicpageX . "</option>";

    for ($nbpage = "1"; $nbpage <= $nbtopicpage; $nbpage++) {
        echo "<option value=\"" . $nbpage . "\" >" . $nbpage . "</option>";
    }

    echo "</select>";
    echo " $strAvec ";
    echo "<select name=nbtop>";
    echo "<option value=\"" . $topic_end . "\" >" . $topic_end . "</option>";
    echo "<option value=\"10\" >10</option>";
    echo "<option value=\"20\" >20</option>";
    echo "<option value=\"30\" >30</option>";
    echo "<option value=\"40\" >40</option>";
    echo "<option value=\"50\" >50</option>";
    echo "<option value=\"60\" >60</option>";
    echo "<option value=\"70\" >70</option>";
    echo "<option value=\"80\" >80</option>";
    echo "<option value=\"90\" >90</option>";
    echo "<option value=\"100\" >100</option>";
    echo "</select> $strFnbsub ";
    echo "&nbsp;<input type=submit value=\"$strOK\">";
    echo "</td></tr>";
    echo "</form>";

    //end ajout choix affichage

    echo '<tr>';
    if ($s_joueur != "" && $s_joueur != NULL) {
        if ($islock == 'unlock') {
            echo '<td class="endforum" colspan="3"><center><img src="themes/' . $s_theme . '/images/reply-locked.gif" border=0 /></center>';
        } else {
            echo '<td class="endforum" colspan="3" style="text-align: right;"><a href="?page=forum&op=addreply&topid=' . $topid . '&cattopic=' . $cat . '&titre=' . $titre . '&nbtopicpageX=' . $nbtopicpageX . '&nbtop=' . $nbtop . '"><img src="themes/' . $s_theme . '/images/t_reply.gif" border=0 align="absmiddle" ></a><a href="?page=forum&op=addtopic&cattopic=' . $cat . '&titre=' . $titre . '&topid=' . $topid . '&topic=' . $topic . '"><img src="themes/' . $s_theme . '/images/t_new.gif" align="absmiddle" border="0" ></a>';
        }
    } else {
        echo $strFneedlog;
        echo '<td class="endforum" colspan="3"><center><img src="images/back.gif" border=0 align=align=absmiddle> <a href=javascript:back() class=action>' . $strRetour . '</a></center>';
    }
    echo '</td></tr>';
    echo '</table><br>';
}
/********************************************************
 * Ajouter une réponse
 */
if ($_GET['op'] == "addreply") {
    $topid = $_GET['topid'];
    $cattopic = $_GET['cattopic'];
    $tit = $_GET['titre'];
    $topic = $_GET['topic'];
    $nbtopicpageX = $_GET['nbtopicpageX'];
    $nbtop = $_GET['nbtop'];

    $db->select("locking");
    $db->from("${dbprefix}forum_message WHERE topid=$topid");
    $reslock = $db->exec();
    $lock = 0;
    while ($islock = $db->fetch($reslock)) {
        if ($islock->locking == 1) {
            js_goto("?page=forum&op=read&topid=$topid&cattopic=$cattopic&titre=$tit&topic=$topic&nbtopicpageX=$nbtopicpageX&nbtop=$nbtop");
            $lock = 1;
        }
    }
    if ($lock == 0) {
        echo "<form method=post name=\"formulaire\" action=?page=forum&op=add_reply&tit=" . $tit . ">";
        echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
        echo "<table cellspacing=1 cellpadding=0 border=0>";
        echo "<tr><td class=headerfiche>$strAjouterReponse</td></tr>";
        echo "<tr><td>";

        echo "<input type=hidden name='topid' value='$topid'>";
        echo "<input type=hidden name='cattopic' value='$cattopic'>";
        echo "<input type=hidden name='nbtopicpageX' value='$nbtopicpageX'>";
        echo "<input type=hidden name='nbtop' value='$nbtop'>";

        echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
        echo "<tr>";
        echo "<td class=textfiche align=center width='450'>";
        buttonBB('contenu');
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        //secho "<td class=titlefiche></td>";
        echo "<td  class=textfiche width='500'  align=center valign=center><textarea cols=50 rows=6 name=contenu id=contenu wrap=virtual ONSELECT=\"storeCaret(this);\" ONCLICK=\"storeCaret(this);\" ONKEYUP=\"storeCaret(this);\"></textarea></td>";
        echo "</tr>";
        echo "<tr><td class=footerfiche  align=center valign=center><input type=submit value=\"$strAjouter\"></td></tr>";
        echo "</table>";
        echo "</td></tr></table>";
        echo "</td></tr></table>";
        echo "</form>";
    }
}
/********************************************************
 * Réponse SQL
 */
if ($_GET['op'] == "add_reply") {


    $str = '';
    $erreur = 0;

    $db->select("locking");
    $db->from("${dbprefix}forum_message WHERE topid=$topid");
    $reslock = $db->exec();
    while ($islock = $db->fetch($reslock)) {
        if ($islock->locking == 1) $erreur = 1;
    }
    if ($erreur) {
        $str .= "- Ce Topic est vérouillé!<br>";
    }
    if (!$contenu) {
        $erreur = 1;
        $str .= "- " . $strElementsContenuInvalide . "<br>";
    }

    if ($erreur == 1) {
        show_erreur_saisie($str);
    } else {


        $date = time();

        $db->insert("${dbprefix}forum_message (auteur,date,topid,message,cattopic)");
        $db->values("'$s_joueur','$date','$topid','$contenu','$cattopic'");
        $db->exec();

        $db->update("${dbprefix}forum");
        $db->set("topic_date='$date' WHERE topid='$topid'");
        $db->exec();

        if ($mods['rangforum'] || $config['rangforum']) {

            $db->select("forum_post");
            $db->from("${dbprefix}joueurs");
            $db->where("id='$s_joueur'");
            $req_up_post = $db->exec();

            while ($req_up_post_while = $db->fetch($req_up_post)) {
                $end_up_post = $req_up_post_while->forum_post;
            }
            $end_up_post = $end_up_post + 1;

            $db->update("${dbprefix}joueurs");
            $db->set("forum_post = '$end_up_post' WHERE id='$s_joueur'");
            $db->exec();

        }
        /*** redirection ***/
        js_goto("?page=forum&op=read&topid=$topid&cattopic=$cattopic&titre=$tit&topic=$topic&nbtopicpageX=$nbtopicpageX&nbtop=$nbtop");
    }
}
/********************************************************
 * Ajouter un sujet
 */
if ($_GET['op'] == "addtopic") {
    $cattopic = $_GET['cattopic'];
    $tit = $_GET['titre'];


    echo "<form method=post name=\"formulaire\" action=?page=forum&op=add_topic&tit=" . $tit . ">";
    echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
    echo "<table cellspacing=1 cellpadding=0 border=0>";
    echo "<tr><td class=headerfiche>$strAjouterTopic</td></tr>";
    echo "<tr><td>";

    echo "<input type=hidden name='cattopic' value='$cattopic'>";

    echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
    echo "<tr>";
    echo "<td class=titlefiche>$strTitre :</td>";
    echo "<td class=textfiche><input type=text name=titre maxlength=70 size=70></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=textfiche colspan=2 align=center>";
    buttonBB('contenu');
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche style=\"white-space:normal\">$strContenu :</td>";
    echo "<td class=textfiche width='500'  align=center valign=center><textarea cols=60 rows=10 ID=contenu name=contenu wrap=virtual ONSELECT=\"storeCaret(this);\" ONCLICK=\"storeCaret(this);\" ONKEYUP=\"storeCaret(this);\"></textarea></td>";
    echo "</tr>";
    echo "<tr><td class=footerfiche colspan=2 align=center><input type=submit value=\"$strAjouter\"></td></tr>";
    echo "</table>";
    echo "</td></tr></table>";
    echo "</td></tr></table>";
    echo "</form>";
}
/********************************************************
 * Sujet SQL
 */
if ($_GET['op'] == "add_topic") {
    $str = '';
    $erreur = 0;

    if (!$contenu) {
        $erreur = 1;
        $str .= "- " . $strElementsContenuInvalide . "<br>";
    }
    if (!$titre) {
        $erreur = 1;
        $str .= "- " . $strElementsTitreInvalide . "<br>";
    }

    if ($erreur == 1) {
        show_erreur_saisie($str);
    } else {


        $db->select("topid");
        $db->from("${dbprefix}forum ORDER by topid");
        $resr = $db->exec();

        while ($datar = $db->fetch($resr)) {
            $topid = $datar->topid;
        }
        $topid = $topid + 1;
        $date = time();

        $db->insert("${dbprefix}forum (topic,cattopic,topid,topic_date)");
        $db->values("'$titre','$cattopic','$topid','$date'");
        $db->exec();

        $db->insert("${dbprefix}forum_message (auteur,date,topid,topic,message,cattopic)");
        $db->values("'$s_joueur','$date','$topid','$titre','$contenu','$cattopic'");
        $db->exec();

        if ($mods['rangforum'] || $config['rangforum']) {

            $db->select("forum_post");
            $db->from("${dbprefix}joueurs");
            $db->where("id='$s_joueur'");
            $req_up_post = $db->exec();

            while ($req_up_post_while = $db->fetch($req_up_post)) {
                $end_up_post = $req_up_post_while->forum_post;
            }
            $end_up_post = $end_up_post + 1;
            $db->update("${dbprefix}joueurs");
            $db->set("forum_post ='$end_up_post' WHERE id='$s_joueur'");
            $db->exec();

        }

        /*** redirection ***/
        js_goto("?page=forum&op=read&topid=$topid&cattopic=$cattopic&titre=$tit");
    }
}
/********************************************************
 * Effacer réponse
 */
if ($_GET['op'] == "deletereply") {

    /*** verification securite ***/
    if ($grade['a'] != 'a' || $grade['b'] != 'b' || $grade['m'] != 'm') {
        js_goto("?page=index.php");
    }

    $topid = $_GET['topid'];
    $cat = $_GET['cattopic'];
    $topic = $_GET['topic'];
    $titre = $_GET['titre'];
    $nbtopicpageX = $_GET['nbtopicpageX'];
    $nbtop = $_GET['nbtop'];

    if (is_numeric($id)) {
        $db->delete("${dbprefix}forum_message");
        $db->where("id = $id");
        $db->exec();
    }

    /*** redirection ***/
    js_goto("?page=forum&op=read&cattopic=$cat&topid=$topid&topic=$topic&titre=$titre&nbtopicpageX=$nbtopicpageX&nbtop=$nbtop");

}
/********************************************************
 * Effacer sujet
 */
if ($_GET['op'] == "deletereply2") {

    /*** verification securite ***/
    if ($grade['a'] != 'a' || $grade['b'] != 'b' || $grade['m'] != 'm') {
        js_goto("?page=index.php");
    }

    $topid = $_GET['topid'];
    $cat = $_GET['cattopic'];
    $topic = $_GET['topic'];
    $titre = $_GET['titre'];

    if (is_numeric($topid)) {
        $db->delete("${dbprefix}forum_message");
        $db->where("topid = $topid");
        $db->exec();

        $db->delete("${dbprefix}forum");
        $db->where("topid = $topid");
        $db->exec();
    }

    /*** redirection ***/
    js_goto("?page=forum&op=topic&cat=$cat");

}
/********************************************************
 *Edité réponse
 */
if ($_GET['op'] == "editreply") {

    $topid = $_GET['topid'];
    $topic = $_GET['topic'];
    $titre = $_GET['titre'];
    $cat = $_GET['cat'];
    $nbtopicpageX = $_GET['nbtopicpageX'];
    $nbtop = $_GET['nbtop'];

    $db->select("*");
    $db->from("${dbprefix}forum_message WHERE id=$id ORDER by id");
    $resr = $db->exec();

    while ($datar = $db->fetch($resr)) {

        echo "<form method=post name=\"formulaire\" action=?page=forum&op=edit_reply&id=" . $id . ">";
        echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
        echo "<table cellspacing=1 cellpadding=0 border=0>";
        echo "<tr><td class=headerfiche>$strModifyReponse</td></tr>";
        echo "<tr><td>";

        echo "<input type=hidden name='topid' value='$topid'>";
        echo "<input type=hidden name='topic' value='$topic'>";
        echo "<input type=hidden name='titre' value='$titre'>";
        echo "<input type=hidden name='cat_post' value='$cat'>";
        echo "<input type=hidden name='nbtopicpageX' value='$nbtopicpageX'>";
        echo "<input type=hidden name='nbtop' value='$nbtop'>";

        echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
        echo "<tr>";
        echo "<td class=textfiche align=center>";
        buttonBB('contenu');
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        //echo "<td class=titlefiche style=\"white-space:normal\">$strContenu :</td>";
        echo "<td class=textfiche width='500'  align=center valign=center><textarea cols=60 rows=10 name=contenu id=contenu wrap=virtual ONSELECT=\"storeCaret(this);\" ONCLICK=\"storeCaret(this);\" ONKEYUP=\"storeCaret(this);\">";
        echo stripslashes($datar->message);
        echo "</textarea></td>";
        echo "</tr>";
        echo "<tr><td class=footerfiche align=center><input type=submit value=\"$strModifier\"></td></tr>";
        echo "</table>";
        echo "</td></tr></table>";
        echo "</td></tr></table>";
        echo "</form>";

    }


}
/********************************************************
 * Edité réponse SQl
 */
if ($_GET['op'] == "edit_reply") {

    $str = '';
    $erreur = 0;

    $id = $_GET['id'];

    if (!$contenu) {
        $erreur = 1;
        $str .= "- " . $strElementsContenuInvalide . "<br>";
    }

    if ($erreur == 1) {
        show_erreur_saisie($str);
    } else {


        $date = time();

        $db->update("${dbprefix}forum_message");
        $db->set("edit_date='$date',topid='$topid',message='$contenu',edit='O',edit_by='$s_joueur' WHERE id=$id");
        $db->exec();

        /*** redirection ***/
        js_goto("?page=forum&op=read&cattopic=$cat_post&topid=$topid&nbtopicpageX=$nbtopicpageX&nbtop=$nbtop&topic=$topic&titre=$titre");
    }
}
/********************************************************
 * Edité sujet
 */
if ($_GET['op'] == "editreply2") {

    $topid = $_GET['topid'];
    $topic = $_GET['topic'];
    $titre = $_GET['titre'];
    $cat = $_GET['cat'];
    $nbtopicpageX = $_GET['nbtopicpageX'];
    $nbtop = $_GET['nbtop'];

    $db->select("*");
    $db->from("${dbprefix}forum_message WHERE id=$id ORDER by id");
    $resr = $db->exec();

    while ($datar = $db->fetch($resr)) {

        echo "<form method=post name=\"formulaire\" action=?page=forum&op=edit_reply2&id=" . $id . ">";
        echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
        echo "<table cellspacing=1 cellpadding=0 border=0>";
        echo "<tr><td class=headerfiche>$strModifyReponse</td></tr>";
        echo "<tr><td>";

        echo "<input type=hidden name='topid' value='$topid'>";
        echo "<input type=hidden name='topic' value='$topic'>";
        echo "<input type=hidden name='titre_cat' value='$titre'>";
        echo "<input type=hidden name='cat_post' value='$cat'>";
        echo "<input type=hidden name='nbtopicpageX' value='$nbtopicpageX'>";
        echo "<input type=hidden name='nbtop' value='$nbtop'>";

        echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
        echo "<tr>";
        echo "<td class=titlefiche>$strTitre :</td>";
        echo "<td class=textfiche><input type=text name=titre maxlength=70 size=70 value='" . stripslashes($datar->topic) . "'></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td class=textfiche colspan=2 align=center>";
        buttonBB('contenu');
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td class=titlefiche style=\"white-space:normal\">$strContenu :</td>";
        echo "<td class=textfiche width='s500'><textarea cols=60 rows=10 name=contenu id=contenu wrap=virtual ONSELECT=\"storeCaret(this);\" ONCLICK=\"storeCaret(this);\" ONKEYUP=\"storeCaret(this);\">";
        echo stripslashes($datar->message);
        echo "</textarea></td>";
        echo "</tr>";
        echo "<tr><td class=footerfiche colspan=2 align=center><input type=submit value=\"$strModifier\"></td></tr>";
        echo "</table>";
        echo "</td></tr></table>";
        echo "</td></tr></table>";
        echo "</form>";

    }


}
/********************************************************
 * Edité sujet SQL
 */
if ($_GET['op'] == "edit_reply2") {

    $str = '';
    $erreur = 0;

    $id = $_GET['id'];

    if (!$contenu) {
        $erreur = 1;
        $str .= "- " . $strElementsContenuInvalide . "<br>";
    }

    if (!$titre) {
        $erreur = 1;
        $str .= "- " . $strElementsTitreInvalide . "<br>";
    }

    if ($erreur == 1) {
        show_erreur_saisie($str);
    } else {


        $date = time();

        $db->update("${dbprefix}forum_message");

        $db->set("edit_date='$date',topid='$topid',message='$contenu',topic='$titre',edit='O',edit_by='$s_joueur' WHERE id=$id");
        $db->exec();

        $db->update("${dbprefix}forum");
        $db->set("topic='$titre' WHERE topid=$topid");
        $db->exec();

        /*** redirection ***/
        js_goto("?page=forum&op=read&cattopic=$cat_post&topid=$topid&nbtopicpageX=$nbtopicpageX&nbtop=$nbtop&topic=$topic&titre=$titre_cat");
    }
}
/********************************************************
 * Ajouté catégorie
 */
if ($_GET['op'] == "addcat") {
    $cattopic = $_GET['cattopic'];

    echo "<form method=post name=\"formulaire\" action=?page=forum&op=add_cat>";
    echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
    echo "<table cellspacing=1 cellpadding=0 border=0>";
    echo "<tr><td class=headerfiche>$strAjouterCategorie</td></tr>";
    echo "<tr><td>";

    echo "<input type=hidden name='cattopic' value='$cattopic'>";

    echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
    echo "<tr>";
    echo "<td class=titlefiche>$strTitre :</td>";
    echo "<td class=textfiche><input type=text name=titre maxlength=70 size=70></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche>$strOrdre :</td>";
    echo "<td class=textfiche><input type=text name=idcat maxlength=2 size=1></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche>$strReservedTo :</td>";
    echo "<td class=textfiche>";
    echo "<input type=checkbox name=modo value=m> $strModo";
    echo "<input type=checkbox name=newser value=n> $strNewseurs";
    echo "<input type=checkbox name=user value=u> $strJoueurs";
    echo " $strReservedTonb</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=textfiche colspan=2 align=center>";
    buttonBB('contenu');
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche style=\"white-space:normal\">$strDesc :</td>";
    echo "<td class=textfiche width='500'  align=center valign=center><textarea cols=60 rows=10 name=contenu id=contenu wrap=virtual ONSELECT=\"storeCaret(this);\" ONCLICK=\"storeCaret(this);\" ONKEYUP=\"storeCaret(this);\"></textarea></td>";
    echo "</tr>";
    echo "<tr><td class=footerfiche colspan=2 align=center><input type=submit value=\"$strAjouter\"></td></tr>";
    echo "</table>";
    echo "</td></tr></table>";
    echo "</td></tr></table>";
    echo "</form>";
}
/********************************************************
 * Ajouté catégorie SQL
 */
if ($_GET['op'] == "add_cat") {
    $str = '';
    $erreur = 0;

    if (!$titre) {
        $erreur = 1;
        $str .= "- " . $strElementsContenuInvalide . "<br>";
    }
    if (!is_numeric($idcat)) {
        $erreur = 1;
        $str .= "- " . $strElementsCatInvalide . "<br>";
    }

    if ($erreur == 1) {
        show_erreur_saisie($str);
    } else {

        $db->select("cattopic");
        $db->from("${dbprefix}forum ORDER by cattopic");
        $resr = $db->exec();

        while ($datar = $db->fetch($resr)) {
            $cattopic = $datar->cattopic;
        }
        $cattopic = $cattopic + 1;

        $reserved = $modo . $newser . $user;

        if ($idcat <= 0) {
            $idcat = 1;
        }
        if ($idcat <= '0') {
            $idcat = '1';
        }

        $db->insert("${dbprefix}forum (cattitle,descri,cattopic,reserved,idcat)");
        $db->values("'$titre','$contenu','$cattopic','$reserved',idcat");
        $db->exec();

        /*** redirection ***/
        js_goto("?page=forum");
    }
}
/********************************************************
 * Effacer Catégorie
 */
if ($_GET['op'] == "deletecat") {

    /*** verification securite ***/
    if ($grade['a'] != 'a' || $grade['b'] != 'b' || $grade['m'] != 'm') {
        js_goto("?page=index.php");
    }


    if ($ok == "dep") {

        $db->update("${dbprefix}forum");
        $db->set("cattopic='$deplacer' WHERE cattopic='$cattopic'");
        $db->exec();

        $db->delete("${dbprefix}forum");
        $db->where("id = $id");
        $db->exec();

        /*** redirection ***/
        js_goto("?page=forum");


    } else if ($ok == "ok") {

        $db->select("topid");
        $db->from("${dbprefix}forum");
        $db->where("cattopic = $cattopic");
        $db->where("topid != ''");
        $db->where("topid != '0'");
        $db->where("topid != 0");
        $resr = $db->exec();

        while ($datar = $db->fetch($resr)) {

            $topid = $datar->topid;


            $db->delete("${dbprefix}forum_message");
            $db->where("topid = $topid");
            $db->exec();

        }


        $db->delete("${dbprefix}forum");
        $db->where("cattopic = $cattopic");
        $db->exec();

        /*** redirection ***/
        js_goto("?page=forum");

    } else {
        $id = $_GET['id'];
        echo "<form method=post name=\"formulaire\" action=?page=forum&op=deletecat&ok=dep>";
        echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
        echo "<table cellspacing=1 cellpadding=0 border=0>";
        echo "<tr><td class=headerfiche>$strEffcaerCategorie</td></tr>";
        echo "<tr><td>";

        echo "<input type=hidden name='id' value='$id'>";

        echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
        echo "<tr>";
        echo "<td class=titlefiche>$strFdep :</td>";

        $db->select("*");
        $db->from("${dbprefix}forum");
        $db->where("cattitle != ''");
        $resr = $db->exec();

        $id_ident = '';

        echo "<td class=textfiche><select name=deplacer>";

        $cat_ras = 'B';

        while ($datar = $db->fetch($resr)) {
            if ($datar->id != $id) {
                $cat_ras = 'C';
                echo "<option value='" . $datar->cattopic . "'>" . $datar->cattitle . "</option>";
            } else {
                $id_ident = "<input type=hidden name='cattopic' value='" . $datar->cattopic . "'>";
            }

        }
        if ($cat_ras == 'B') {
            echo "<option value=''>$strFras</option>";
        }
        echo "</select>" . $id_ident . "</td>";
        echo "</tr>";
        if ($cat_ras == 'C') {
            echo "<tr><td class=footerfiche colspan=2 align=center><input type=submit value=\"$strOK\"></td></tr>";
        }
        echo "</form><form method=post name=\"formulaire\" action=?page=forum&op=deletecat&ok=ok>";
        echo "<input type=hidden name='id' value='$id'>" . $id_ident . "";
        echo "<tr><td class=footerfiche colspan=2 align=center><input type=submit value=\"$strFdelall\"></td></tr>";
        echo "</table>";
        echo "</td></tr></table>";
        echo "</td></tr></table>";
        echo "</form>";
    }


}
/********************************************************
 * Edité cat
 */
if ($_GET['op'] == "edicat") {

    $id = $_GET['id'];
    $cat = $_GET['cat'];

    $db->select("*");
    $db->from("${dbprefix}forum WHERE id=$id");
    $resr = $db->exec();

    while ($datar = $db->fetch($resr)) {
        $titre = $datar->cattitle;
        $idcat = $datar->idcat;
        $descri = $datar->descri;
        $reserved = $datar->reserved;
    }


    echo "<form method=post name=\"formulaire\" action=?page=forum&op=edi_cat>";
    echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
    echo "<table cellspacing=1 cellpadding=0 border=0>";
    echo "<tr><td class=headerfiche>$strEditeCategorie</td></tr>";
    echo "<tr><td>";

    echo "<input type=hidden name='cattopic' value='$cat'>";
    echo "<input type=hidden name='id' value='$id'>";

    echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
    echo "<tr>";
    echo "<td class=titlefiche>$strTitre :</td>";
    echo "<td class=textfiche><input type=text name=titre maxlength=70 size=70 value='";
    echo stripslashes($titre);
    echo "'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche>$strOrdre :</td>";
    if ($idcat == NULL || $idcat == '0') {
        $idcat = '1';
    }
    echo "<td class=textfiche><input type=text name=idcat maxlength=2 size=1 value='";
    echo $idcat;
    echo "'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche>$strReservedTo :</td>";
    echo "<td class=textfiche>";
    if (preg_match('/m/i', $reserved)) {
        $ch_usm = 'Checked';
    }
    echo "<input type=checkbox name=modo value=m $ch_usm > $strModo";
    if (preg_match('/n/i', $reserved)) {
        $ch_usn = 'Checked';
    }
    echo "<input type=checkbox name=newser value=n $ch_usn > $strNewseurs";
    if (preg_match('/u/i', $reserved)) {
        $ch_usu = 'Checked';
    }
    echo "<input type=checkbox name=user value=u $ch_usu> $strJoueurs";
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=textfiche colspan=2 align=center>";
    buttonBB('contenu');
    echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche style=\"white-space:normal\">$strDesc :</td>";
    echo "<td class=textfiche  align=center valign=center><textarea cols=60 rows=10 id=contenu name=contenu wrap=virtual ONSELECT=\"storeCaret(this);\" ONCLICK=\"storeCaret(this);\" ONKEYUP=\"storeCaret(this);\">" . stripslashes($descri) . "</textarea></td>";
    echo "</tr>";
    echo "<tr><td class=footerfiche colspan=2 align=center><input type=submit value=\"$strAjouter\"></td></tr>";
    echo "</table>";
    echo "</td></tr></table>";
    echo "</td></tr></table>";
    echo "</form>";
}
/********************************************************
 * Edité cat SQL
 */
if ($_GET['op'] == "edi_cat") {

    $str = '';
    $erreur = 0;

    if (!$titre) {
        $erreur = 1;
        $str .= "- " . $strElementsTitreInvalide . "<br>";
    }
    if (!is_numeric($idcat)) {
        $erreur = 1;
        $str .= "- " . $strElementsCatInvalide . "<br>";
    }

    if ($erreur == 1) {
        show_erreur_saisie($str);
    } else {
        $reserved = $modo . $newser . $user;

        if ($idcat <= 0) {
            $idcat = 1;
        }
        if ($idcat <= '0') {
            $idcat = '1';
        }

        $db->update("${dbprefix}forum");
        $db->set("cattitle='$titre',descri='$contenu',reserved='$reserved',idcat='$idcat' WHERE id='$id'");
        $db->exec();

        /*** redirection ***/
        js_goto("?page=forum");
    }
}
/********************************************************
 * Déplacer Sujet STEP 1
 */
if ($_GET['op'] == "dej_topic") {

    $topid = $_GET['topid'];

    $db->select("idcat,cattitle,cattopic");
    $db->from("${dbprefix}forum ORDER by idcat desc");
    //$db->where("cattitle != ''"); connard de where de mes deux
    $resr = $db->exec();

    echo '<br><form name="catform"  method="post" action="?page=forum&op=dej_topic_end">';
    echo $strWhereDep . ' :';
    echo '<select name="new_cat">';

    while ($datar = $db->fetch($resr)) {
        if ($datar->cattitle != '') {
            echo '<option value="' . $datar->cattopic . '">' . stripslashes($datar->cattitle) . '</option>';
        }
    }


    echo '</select>&nbsp;&nbsp;';
    echo '<input type="hidden" value="' . $topid . '" name="topid">';
    echo '<input type="submit" name="Button1" value="';
    echo "- $strOK -";
    echo '"></form>';


}
/********************************************************
 * Déplacer Sujet fin
 */
if ($_GET['op'] == "dej_topic_end") {


    $db->update("${dbprefix}forum_message");
    $db->set("cattopic='$new_cat' WHERE topid='$topid'");
    $db->exec();

    $db->update("${dbprefix}forum");
    $db->set("cattopic='$new_cat' WHERE topid='$topid'");
    $db->exec();

    /*** redirection ***/
    js_goto("?page=forum");

}
/********************************************************
 * Locker un sujet Sujet
 */
if ($_GET['op'] == "iwtl") {


    $db->update("${dbprefix}forum_message");
    $db->set("locking='1' WHERE topid='$topid'");
    $db->exec();

    /*** redirection ***/
    js_goto("?page=forum");

}
/********************************************************
 * Locker un sujet Sujet
 */
if ($_GET['op'] == "iwtul") {


    $db->update("${dbprefix}forum_message");
    $db->set("locking='0' WHERE topid='$topid'");
    $db->exec();

    /*** redirection ***/
    js_goto("?page=forum");

}


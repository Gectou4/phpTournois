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
if (preg_match("/news.php/i", $_SERVER['PHP_SELF'])) {
    die ("You cannot open this page directly");
}
?>
<SCRIPT type=text/javascript>
    <!--
    function showimage($op) {
        $sr = 'images/gicon/' + $op;
        document.formulaire.icx.src = $sr;
    }

    function showimage2($op) {
        $sr = 'images/news/' + $op;
        document.formulaire.ic.src = $sr;
    }

    //-->
</script>
<?php
if (!$config['news']) js_goto('?page=index');

/********************************************************
 * Ajout d'une news
 */
if ($op == "add_news") {

    /*** verification securite ***/
    if ($grade['a'] != 'a' && $grade['b'] != 'b' && $grade['n'] != 'n') {
        js_goto('?page=login');
    }


    $str = '';
    $erreur = 0;

    if (!$titre) {
        $erreur = 1;
        $str .= "- " . $strElementsTitreInvalide . "<br>";
    }
    if (!$contenu) {
        $erreur = 1;
        $str .= "- " . $strElementsContenuInvalide . "<br>";
    }
    if ($mods['news2']) {
        if (!$titre_2) {
            $erreur = 1;
            $str .= "- " . $strElementsTitreInvalide2 . "<br>";
        }
        if (!$contenu_2) {
            $erreur = 1;
            $str .= "- " . $strElementsContenuInvalide2 . "<br>";
        }
    }

    if ($erreur == 1) {
        show_erreur_saisie($str);
    } else {
        $date = time();

        $db->insert("${dbprefix}news (auteur,titre,contenu,date,icone,icone2,titre_2,contenu_2)");
        $db->values("'$s_joueur','$titre','$contenu','$date','$icone','$icone2','$titre_2','$contenu_2'");
        $db->exec();

        /*** redirection ***/
        js_goto("?page=news");

    }

} /********************************************************
 * Ajout d'un commentaire
 */
elseif ($op == "add_commentaire") {

    if (!$s_joueur) js_goto('?page=login');

    $str = '';
    $erreur = 0;

    if (!is_numeric($id)) {
        $erreur = 1;
        $str .= "- " . $strElementsNewsInvalide . "<br>";
    }
    if (!$contenu) {
        $erreur = 1;
        $str .= "- " . $strElementsContenuInvalide . "<br>";
    }

    if ($erreur == 1) {
        show_erreur_saisie($str);
    } else {
        $date = time();
        $contenu = remove_XSS($contenu);

        $db->insert("${dbprefix}news_commentaires (auteur,contenu,date,news)");
        $db->values("'$s_joueur','$contenu','$date',$id");
        $db->exec();

        /*** redirection ***/
        js_goto("?page=news&id=$id");
    }
} /********************************************************
 * Effacement d'une news
 */
elseif ($op == "delete_news") {

    /*** verification securite ***/
    if ($grade['a'] != 'a' && $grade['b'] != 'b' && $grade['n'] != 'n') {
        js_goto('?page=login');
    }


    if (is_numeric($id)) {
        $db->delete("${dbprefix}news");
        $db->where("id = $id");
        $db->exec();

        $db->delete("${dbprefix}news_commentaires");
        $db->where("news = $id");
        $db->exec();
    }

    /*** redirection ***/
    js_goto("?page=news");

} /********************************************************
 * Effacement d'un commentaire
 */
elseif ($op == "delete_commentaire") {

    /*** verification securite ***/
    if ($grade['a'] != 'a' && $grade['b'] != 'b' && $grade['n'] != 'n') {
        js_goto('?page=login');
    }


    if (is_numeric($id) && is_numeric($news)) {

        $db->delete("${dbprefix}news_commentaires");
        $db->where("id = $id and news = $news");
        $db->exec();
    }

    /*** redirection ***/
    js_goto("?page=news&id=$news");

} /********************************************************
 * Modification d'une news
 */
elseif ($op == "modify_news") {

    /*** verification securite ***/
    if ($grade['a'] != 'a' && $grade['b'] != 'b' && $grade['n'] != 'n') {
        js_goto('?page=login');
    }


    if (is_numeric($id)) {

        $db->select("*");
        $db->from("${dbprefix}news");
        $db->where("id = '$id'");
        $res = $db->exec();
        $news = $db->fetch($res);

        $date = strftime(DATESTRING1, $news->date);
        $date = "$strLe " . $date;

        echo "<p class=title>.:: $strAdminNews ::.</p>";

        echo "<form method=post name=\"formulaire\" action=?page=news&op=do_modify_news>";
        echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
        echo "<table cellspacing=1 cellpadding=0 border=0>";
        echo "<tr><td class=headerfiche>$strModifierNews</td></tr>";
        echo "<tr><td>";
        echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
        echo "<tr>";
        echo "<td class=titlefiche>$strIcone :</td>";
        echo "<td class=textfiche>";

        $selected = 0;
        echo "<select name=icone onchange=\"showimage2(this.options[this.selectedIndex].value);\">";
        echo "<option value=\"$news->icone\" selected>$news->icone</option>";
        $handle = opendir('./images/news');
        while ($file = readdir($handle)) {
            if ($file != "." && $file != "..") {
                if (!preg_match("/.db/i", $file)) {
                    echo "<option value=\"" . $file . "\">$file</option>";
                }

            }
        }
        if ($news->icone != '') {
            $g_icon1 = $news->icone;
        } else {
            $g_icon1 = "aucun.gif";
        }
        echo "</select><img src='images/news/$g_icon1' border='0' name='ic'/>    -    $strgicon";
        closedir($handle);
        echo "<select name=icone2 onchange=\"showimage(this.options[this.selectedIndex].value);\">";
        echo "<option value=\"$news->icone2\" selected>$news->icone2</option>";
        $fd = opendir("images/gicon");
        while ($file = readdir($fd)) {
            if ($file != "." && $file != "..") {
                if (!preg_match("/.db/i", $file)) {
                    echo "<option value=\"" . $file . "\">$file</option>";
                }
            }
        }
        if ($news->icone2 != '') {
            $g_icon2 = $news->icone2;
        } else {
            $g_icon2 = "aucun.gif";
        }
        echo "</select><img src='images/gicon/$g_icon2' border='0' name='icx' align='absmiddle'/>";
        closedir($fd);
        echo "</td></tr>";
        echo "<tr>";
        echo "<td class=titlefiche>$strTitre :</td>";
        echo "<td class=textfiche><input type=text name=titre maxlength=70 size=70 value=\"" . stripslashes($news->titre) . "\"></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td class=titlefiche></td>";
        echo "<td class=textfiche>$strPostePar " . show_joueur($news->auteur, $op) . " $date</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td class=textfiche colspan=2 align=center>";
        buttonBB('contenu');
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td class=titlefiche>$strContenu :</td>";


        echo "<td class=textfiche><textarea  cols=80 rows=10 name=contenu ID=contenu wrap=virtual ONSELECT=\"storeCaret(this);\" ONCLICK=\"storeCaret(this);\" ONKEYUP=\"storeCaret(this);\">" . stripslashes($news->contenu) . "</textarea></td>";


        echo "</tr>";

        if ($mods['news2']) {
            echo "<tr>";
            echo "<td class=headerfiche colspan=2><center>$strNews2</center></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td class=titlefiche>$strTitre :</td>";
            echo "<td class=textfiche><input type=text name=titre_2 maxlength=70 size=70 value=\"" . stripslashes($news->titre_2) . "\"></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td class=titlefiche></td>";
            echo "<td class=textfiche>$strPostePar " . show_joueur($news->auteur, $op) . " $date</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td class=titlefiche>$strContenu :</td>";
            echo "<td class=textfiche><textarea  cols=80 rows=10 name=contenu_2 ID=contenu_2 wrap=virtual ONSELECT=\"storeCaret(this);\" ONCLICK=\"storeCaret(this);\" ONKEYUP=\"storeCaret(this);\">" . stripslashes($news->contenu_2) . "</textarea></td>";
            echo "</tr>";
        }
        echo "<tr><td class=footerfiche colspan=2 align=center><input type=submit value=\"$strModifier\">&nbsp;<input type=button value=\"$strRetour\" onclick=\"document.location='?page=news&op=admin'\"></td></tr>";
        echo "</table>";
        echo "</td></tr></table>";
        echo "</td></tr></table>";
        echo "<input type=hidden name=id value='$id'>";
        echo "</form>";
    }
} /********************************************************
 * Modification d'une news
 */
elseif ($op == "do_modify_news") {

    /*** verification securite ***/
    if ($grade['a'] != 'a' && $grade['b'] != 'b' && $grade['n'] != 'n') {
        js_goto('?page=login');
    }


    $str = '';
    $erreur = 0;

    if (!is_numeric($id)) {
        $erreur = 1;
        $str .= "- " . $strElementsNewsInvalide . "<br>";
    }
    if (!$titre) {
        $erreur = 1;
        $str .= "- " . $strElementsTitreInvalide . "<br>";
    }
    if (!$contenu) {
        $erreur = 1;
        $str .= "- " . $strElementsContenuInvalide . "<br>";
    }
    if ($mods['news2']) {
        if (!$titre_2) {
            $erreur = 1;
            $str .= "- " . $strElementsTitreInvalide2 . "<br>";
        }
        if (!$contenu_2) {
            $erreur = 1;
            $str .= "- " . $strElementsContenuInvalide2 . "<br>";
        }
    }

    if ($erreur == 1) {
        show_erreur_saisie($str);
    } else {

        $db->update("${dbprefix}news");
        $db->set("titre = '$titre'");
        $db->set("contenu = '$contenu'");
        $db->set("icone = '$icone'");
        $db->set("icone2 = '$icone2'");
        $db->set("titre_2 = '$titre_2'");
        $db->set("contenu_2 = '$contenu_2'");
        $db->where("id = $id");
        $db->exec();

        /*** redirection ***/
        js_goto("?page=news&op=modify_news&id=$id");
    }
} /********************************************************
 * print d'une news
 */
elseif ($op == "imprimer") {

    $str = '';
    $erreur = 0;

    if (!is_numeric($id)) {
        $erreur = 1;
        $str .= "- " . $strElementsNewsInvalide . "<br>";
    }

    if ($erreur == 1) {
        show_erreur($str);
    } else {

        $db->select("*");
        $db->from("${dbprefix}news");
        $db->where("id = $id");
        $res = $db->exec();
        $news = $db->fetch($res);

        $date = strftime(DATESTRING1, $news->date);
        $date = "$strLe " . $date;


        if (($lang == 'english' || $s_lang == 'english' || $config['default_lang'] == 'english') AND ($news->titre_2 != "" || $news->contenu_2 != "")) {
            $contenu = BBcode($news->contenu_2);
            $titre = stripslashes($news->titre_2);
        } else {
            $contenu = BBcode($news->contenu);
            $titre = stripslashes($news->titre);
        }

        echo "<div align=center>";
        if (!empty($config['logo'])) echo '<img src="images/' . $config['logo'] . '" border="0" align="absmiddle">';
        echo "<br><br>";
        echo "<font size=3><img src=\"images/news/" . $news->icone . "\" border=0 align=absmiddle> " . $titre . "</font>";
        echo "<br><br><font size=2>";
        echo "$strPostePar " . show_joueur($news->auteur) . " $date";
        echo "<br><br>";

        echo "<table width=600 border=0 cellspacing=0 cellpadding=0>";
        echo "<tr><td>";
        if ($news->icone2 != "") {
            echo "<IMG src='images/news/$news->icone' align='RIGHT' border='0'>";
        }
        echo stripslashes($contenu);
        echo "</td></tr>";
        echo "</table>";
        echo "</td></tr></table>";

        echo "$strArticleDuSite " . $config['nom'] . "<br>";
        echo "<a href=\"" . $config['urlsite'] . "\">" . $config['urlsite'] . "</a>";
        echo "<br><br>";
        echo "$strURLArticle :<br>";
        echo "<a href=\"" . $config['urlsite'] . "/?page=news&id=$id\">" . $config['urlsite'] . "/?page=news&id=$id</a>";
        echo "</div><script language=\"JavaScript\">window.print()</script>";
        echo "</body></html>";


    }
} /********************************************************
 * envoi d'une news a un ami
 */
elseif ($op == "envoyer") {

    echo "<p class=title>.:: $strEnvoyerNews ::.</p>";

    /*** table du joueur ***/
    echo '<form method="post" action="?page=news&op=do_envoyer">';
    echo "<input type=\"hidden\" name=\"id\" value=\"$id\">";
    echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
    echo "<table cellspacing=1 cellpadding=0 border=0 class=fiche>";
    echo "<tr><td>";
    echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";

    /*** email **/
    echo "<tr><td class=titlefiche>$strVotreEmail <font color=red><b>*</b></font> :</td>";
    echo "<td class=textfiche>";
    echo "<input type=text name=email_from maxlength=100 size=30>";
    echo "</td></tr>";

    /*** email **/
    echo "<tr><td class=titlefiche>$strSonEmail <font color=red><b>*</b></font> :</td>";
    echo "<td class=textfiche>";
    echo "<input type=text name=email_to maxlength=100 size=30>";
    echo "</td></tr>";

    echo "<tr><td class=footerfiche align=center colspan=2><input type=submit class=action class=action value=\"$strEnvoyer\"></td></tr>";
    echo "</table>";

    echo "</td></tr></table>";
    echo "</td></tr></table>";
    echo "</form>";

    echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";

} /********************************************************
 * envoi d'une news a un ami
 */
elseif ($op == "do_envoyer") {

    $str = '';
    $erreur = 0;

    if (!$email_from || !preg_match("/^[a-z0-9\._-]+@+[a-z0-9\._-]+\.+[a-z]{2,3}$/i", $email_from)) {
        $erreur = 1;
        $str .= "- 1e " . $strElementsEmailInvalide . "<br>";
    }
    if (!$email_to || !preg_match("/^[a-z0-9\._-]+@+[a-z0-9\._-]+\.+[a-z]{2,3}$/i", $email_to)) {
        $erreur = 1;
        $str .= "- 2e " . $strElementsEmailInvalide . "<br>";
    }
    if (!is_numeric($id)) {
        $erreur = 1;
        $str .= "- " . $strElementsNewsInvalide . "<br>";
    }

    if ($erreur == 1) {
        show_erreur_saisie($str);
    } else {
        if ($config['mail'] != 'N') {

            /*** génération de l'email ***/
            $link = "<a href=\"" . $config['urlsite'] . "/?page=news&id=$id\" target=\"_blank\">" . $config['urlsite'] . "/?page=news&id=$id</a>";
            $array1 = array("%nomsite%", "%urlsite%", "%link%");
            $array2 = array($config['nomsite'], $config['urlsite'], $link);

            $to = $email_to;
            $from = $email_from;
            $subject = $strNewsEnvoiSubject;
            $subject = str_replace($array1, $array2, $subject);
            $body = $strNewsEnvoiMessage;
            $body = str_replace($array1, $array2, $body);

            $mail = new phpTMailer();
            $mail->From = $from;
            $mail->FromName = "";
            $mail->AddAddress($to);
            $mail->Subject = $subject;
            $mail->Body = $body;

            if (!$mail->Send()) {
                show_erreur("$strErreurMessageEnvoi<br><br>$mail->ErrorInfo");
            } else {

                show_notice(str_replace($array1, $array2, $strNewsEnvoiConfirm));
                echo "<br><form method=post action='?page=news'><input type=submit class=action value=\"$strOK\"></form>";
            }
        } else {
            show_erreur($strPasDeFonctionMail);
        }
    }

} /********************************************************
 * Affichage  admin
 */
else if ($ad == 'wr') {
    /*** Ajout de news ***/
    if ($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['n'] == 'n') {

        echo "<form method=post name=\"formulaire\" action=?page=news&op=add_news>";
        echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
        echo "<table cellspacing=1 cellpadding=0 border=0>";
        echo "<tr><td class=headerfiche>$strAjouterNews</td></tr>";
        echo "<tr><td>";
        echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
        echo "<tr>";
        echo "<td class=titlefiche>$strIcone :</td>";
        echo "<td class=textfiche style=\"white-space:normal\">";

        $selected = 0;
        echo "<select name=icone onchange=\"showimage2(this.options[this.selectedIndex].value);\">";
        $handle = opendir('./images/news');
        while ($file = readdir($handle)) {
            if ($file != "." && $file != "..") {
                if (!preg_match("/.db/i", $file)) {
                    echo "<option value=\"" . $file . "\">$file</option>";
                }
            }
        }
        echo "</select><img src='images/news/aucun.gif' border='0' name='ic'/>    -    $strgicon";
        closedir($handle);
        echo "<select name=icone2 onchange=\"showimage(this.options[this.selectedIndex].value);\">";
        $fd = opendir("images/gicon");
        while ($file = readdir($fd)) {
            if ($file != "." && $file != "..") {
                if (!preg_match("/.db/i", $file)) {
                    echo "<option value=\"" . $file . "\">$file</option>";
                }
            }
        }
        echo "</select><img src='images/gicon/aucun.gif' border='0' name='icx' align='absmiddle'/>";
        closedir($fd);
        echo "</td></tr>";
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
        echo "<td class=textfiche><textarea cols=60 rows=10 id=contenu name=contenu wrap=virtual";
        if ($mods['bbcode'] == "1") {
            echo "ONSELECT=\"storeCaret(this);\" ONCLICK=\"storeCaret(this);\" ONKEYUP=\"storeCaret(this);\"";
        }
        echo "></textarea></td>";
        echo "</tr>";

        if ($mods['news2']) {
            echo "<tr>";
            echo "<td class=headerfiche colspan=2><center>$strNews2</center></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td class=titlefiche>$strTitre :</td>";
            echo "<td class=textfiche><input type=text name=titre_2 maxlength=70 size=70></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td class=titlefiche>$strContenu :</td>";
            echo "<td class=textfiche><textarea cols=60 rows=10 id=contenu name=contenu wrap=virtual";
            if ($mods['bbcode'] == "1") {
                echo "ONSELECT=\"storeCaret(this);\" ONCLICK=\"storeCaret(this);\" ONKEYUP=\"storeCaret(this);\"";
            }
            echo "></textarea></td>";
            echo "</tr>";
        }

        echo "<tr><td class=footerfiche colspan=2 align=center><input type=submit value=\"$strAjouter\"></td></tr>";
        echo "</table>";
        echo "</td></tr></table>";
        echo "</td></tr></table>";
        echo "</form>";
    }

} /********************************************************
 * Affichage normal + admin
 */
else {

    if ($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['n'] == 'n') {
        echo "<p class=title>.:: $strAdminNews ::.</p>";
    } else {
        echo "<p class=title>.:: $strNews ::.</p>";
    }


    /*** liste des toutes les news ***/
    if (empty($id)) {

        if (!isset($start) || !is_numeric($start)) $start = 0;
        $nb_max = $config['nb_news_max'];
        $nb_total = nb_news();

        $db->select("*");
        $db->from("${dbprefix}news");
        $db->order_by("id DESC LIMIT $start,$nb_max");
        $res = $db->exec();

        if ($db->num_rows($res) == 0) {
            echo "<table cellspacing=0 cellpadding=0 border=0>";
            echo "<tr><td class=title><div align=justify>$strPasDeNews</div></td></tr>";
            echo "</table><br>";
        } else {

            /*** Affichage des news ***/
            echo "<table align=center width=400 border=0 cellspacing=0 cellpadding=0>";
            echo "<tr><td>";

            $nbnews = 0;
            while ($news = $db->fetch($res)) {
                $nbnews++;

                $date = strftime("%c", $news->date);
                $date = "$strLe " . $date;
                if (($lang == 'english' || $s_lang == 'english' || $config['default_lang'] == 'english') AND ($news->titre_2 != "" || $news->contenu_2 != "")) {
                    $titre = stripslashes($news->titre_2);
                    $contenu = BBcode($news->contenu_2);
                } else {
                    $titre = stripslashes($news->titre);
                    $contenu = BBcode($news->contenu);
                }
                $contenu = stripslashes($contenu);

                echo "<a name=\"no" . $nbnews . "\"></a>";
                echo "<table width=500 border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
                echo "<table width=100% border=0 cellspacing=1 cellpadding=2>";
                echo "<tr>";
                echo "<td class=header><div style=\"clear: both\"><div style=\"float: left\"><a href=\"?page=news&id=" . $news->id . "\"><img src=\"images/news/" . $news->icone . "\" border=0 align=absmiddle><b> " . $titre . "</b></a></div>";
                if ($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['n'] == 'n') {
                    echo "<div style=\"float: right\">&nbsp;<a href=?page=news&op=modify_news&id=" . $news->id . ">[$strE]</a>&nbsp;<a href=?page=news&op=delete_news&id=" . $news->id . " onclick=\"return confirm('$strConfirmEffacerNews');\">[$strS]</a></div>";
                }
                echo "</div></td></tr>";
                echo "<tr>";
                echo "<td class=text>";
                if ($news->icone2 != "") {
                    echo "<IMG src='images/gicon/$news->icone2' align='RIGHT' border='0'>";
                }
                echo $contenu;
                echo "<br><br><span class=info><div style=\"clear: both\">";
                echo "<div style=\"float: left\"><img src=\"images/icon_comment.gif\" border=0 align=absmiddle> <a href=\"?page=news&id=" . $news->id . "\">$strCommentaires ? (" . nb_news_commentaires($news->id) . ")</a> | <a href=\"?page=news&op=imprimer&header=nude&id=" . $news->id . "\" target=_blank><img src=\"images/print.gif\" border=0 align=absmiddle></a> | <a href=\"?page=news&op=envoyer&id=" . $news->id . "\"><img src=\"images/friend.gif\" border=0 align=absmiddle></a></div>";
                echo "<div align=right>$strPostePar <b>" . show_joueur($news->auteur, $op) . "</b> " . $date . "</div></span>";
                echo "</div></td></tr>";
                echo "</table>";
                echo "</td></tr></table><br>";
            }

            if ($op) $op_str = "&op=$op";
            else $op_str = '';
            echo "<table cellspacing=0 cellpadding=0 border=0 align=center>";
            echo "<tr><td class=text2>" . navigateur($start, $nb_max, $nb_total, "?page=news$op_str&start=%d") . "</td></tr>";
            echo "</table><br>";


            /*** Affichage des titres ***/
            /*echo "</td><td valign=top>";
            echo "<table width=250 border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
            echo "<table width=100% border=0 cellspacing=1 cellpadding=2>";
            echo "<tr><td class=header><img src=\"images/news/news.gif\" border=0 align=absmiddle> $strDerniersTitres</td></tr>";

            $db->select("*");
            $db->from("${dbprefix}news");
            $db->order_by("id DESC LIMIT 0,10");
            $res=$db->exec();

            $nbNews=0;

            while ($news = $db->fetch($res)) {

                $date=strftime(DATESTRING2, $news->date);
                $news->titre=stripslashes($news->titre);

                $nbNews++;
                echo "<tr>";
                echo "<td class=text>";
                echo "<div style=\"clear: both\"><div style=\"float: left\">";
                echo "<a href=\"#no".$nbNews."\">$date - ".$news->titre."</a></div>";
                echo "</div></td></tr>";
            }
            echo "</table>";
            echo "</td></tr></table>";*/

            echo "</td></tr></table>";
        }

        /*** Ajout de news ***/
        if ($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['n'] == 'n') {

            echo "<form method=post name=\"formulaire\" action=?page=news&op=add_news>";
            echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
            echo "<table cellspacing=1 cellpadding=0 border=0>";
            echo "<tr><td class=headerfiche>$strAjouterNews</td></tr>";
            echo "<tr><td>";
            echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
            echo "<tr>";
            echo "<td class=titlefiche>$strIcone :</td>";
            echo "<td class=textfiche style=\"white-space:normal\">";

            $selected = 0;
            echo "<select name=icone onchange=\"showimage2(this.options[this.selectedIndex].value);\">";
            $handle = opendir('./images/news');
            while ($file = readdir($handle)) {
                if ($file != "." && $file != "..") {
                    if (!preg_match("/.db/i", $file)) {
                        echo "<option value=\"" . $file . "\">$file</option>";
                    }
                }
            }
            echo "</select><img src='images/news/aucun.gif' border='0' name='ic'/>    -    $strgicon";
            closedir($handle);
            echo "<select name=icone2 onchange=\"showimage(this.options[this.selectedIndex].value);\">";
            $fd = opendir("images/gicon");
            while ($file = readdir($fd)) {
                if ($file != "." && $file != "..") {
                    if (!preg_match("/.db/i", $file)) {
                        echo "<option value=\"" . $file . "\">$file</option>";
                    }
                }
            }
            echo "</select><img src='images/gicon/aucun.gif' border='0' name='icx' align='absmiddle'/>";
            closedir($fd);
            echo "</td></tr>";
            echo "<tr>";
            echo "<td class=titlefiche>$strTitre :</td>";
            echo "<td class=textfiche><input type=text name=titre maxlength=70 size=70></td>";
            echo "</tr>";
            echo "<td class=textfiche colspan=2 align=center>";
            buttonBB('contenu');
            echo "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td class=titlefiche style=\"white-space:normal\">$strContenu :</td>";
            echo "<td class=textfiche><textarea cols=60 rows=10 id=contenu name=contenu wrap=virtual ONSELECT=\"storeCaret(this);\" ONCLICK=\"storeCaret(this);\" ONKEYUP=\"storeCaret(this);\"></textarea></td>";
            echo "</tr>";

            if ($mods['news2']) {
                echo "<tr>";
                echo "<td class=headerfiche colspan=2><center>$strNews2</center></td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td class=titlefiche>$strTitre :</td>";
                echo "<td class=textfiche><input type=text name=titre_2 maxlength=70 size=70></td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td class=titlefiche>$strContenu :</td>";
                echo "<td class=textfiche><textarea  cols=60 rows=10 name=contenu_2 ID=contenu_2 wrap=virtual ONSELECT=\"storeCaret(this);\" ONCLICK=\"storeCaret(this);\" ONKEYUP=\"storeCaret(this);\"></textarea></td>";
                echo "</tr>";
            }

            echo "<tr><td class=footerfiche colspan=2 align=center><input type=submit value=\"$strAjouter\"></td></tr>";
            echo "</table>";
            echo "</td></tr></table>";
            echo "</td></tr></table>";
            echo "</form>";
        }
    } /*** fiche d'une news ***/
    else if (is_numeric($id)) {

        $db->select("*");
        $db->from("${dbprefix}news");
        $db->where("id = $id");
        $res = $db->exec();
        $news = $db->fetch($res);

        $date = strftime(DATESTRING1, $news->date);
        $date = "$strLe " . $date;

        if (($lang == 'english' || $s_lang == 'english' || $config['default_lang'] == 'english') AND ($news->titre_2 != "" || $news->contenu_2 != "")) {
            $titre = stripslashes($news->titre_2);
            $contenu = BBcode($news->contenu_2);
        } else {
            $titre = stripslashes($news->titre);
            $contenu = BBcode($news->contenu);
        }
        $contenu = stripslashes($contenu);


        echo "<br><table width=450 border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
        echo "<table width=100% border=0 cellspacing=1 cellpadding=2>";
        echo "<tr>";
        echo "<td class=header><div style=\"clear: both\"><div style=\"float: left\"><img src=\"images/news/" . $news->icone . "\" border=0 align=absmiddle> " . $titre . "</a></div>";
        if ($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['n'] == 'n') {
            echo "<div style=\"float: right\">&nbsp;<a href=?page=news&op=modify_news&id=" . $news->id . ">[$strE]</a>&nbsp;<a href=?page=news&op=delete_news&id=" . $news->id . " onclick=\"return confirm('$strConfirmEffacerNews');\">[$strS]</a></div>";
        }

        echo "</td></tr>";
        echo "<tr>";
        echo "<td class=text>";
        if ($news->icone2 != "") {
            echo "<IMG src='images/gicon/$news->icone2' align='RIGHT' border='0'>";
        }
        echo $contenu;
        echo "<br><br><span class=info><div style=\"clear: both\">";
        echo "<div style=\"float: left\"><img src=\"images/next.gif\" border=0 align=align=absmiddle> " . nb_news_commentaires($news->id) . " $strCommentaires | <a href=\"?page=news&op=imprimer&header=nude&id=" . $news->id . "\" target=_blank><img src=\"images/print.gif\" border=0 align=absmiddle></a> | <a href=\"?page=news&op=envoyer&id=" . $news->id . "\"><img src=\"images/friend.gif\" border=0 align=absmiddle></a></div>";
        echo "<div align=right>$strPostePar " . show_joueur($news->auteur, $op) . " $date</div></span>";
        echo "</div></td></tr>";
        echo "</table>";
        echo "</td></tr></table><br>";

        /*** affichage des commentaires ***/
        if (!isset($start) || !is_numeric($start)) $start = 0;
        $nb_max = $config['nb_news_commentaires_max'];
        $nb_total = nb_news_commentaires($id);

        $db->select("*");
        $db->from("${dbprefix}news_commentaires");
        $db->where("news = $id");
        $db->order_by("id ASC LIMIT $start,$nb_max");
        $res = $db->exec();

        if ($db->num_rows($res) != 0) {

            echo "<table align=center width=300 border=0 cellspacing=0 cellpadding=0>";
            echo "<tr><td class=title align=center>$strCommentaires</td></tr>";
            echo "<tr><td>";

            $nbCommentaires = 0;
            while ($commentaire = $db->fetch($res)) {
                $nbCommentaires++;
                $date = strftime(DATESTRING1, $commentaire->date);
                $date = "$strLe " . $date;
                $contenu = BBcode($commentaire->contenu);
                $contenu = BBcode($commentaire->contenu);

                echo "<table width=300 border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
                echo "<table width=100% border=0 cellspacing=1 cellpadding=2>";
                echo "<tr>";
                echo "<td class=text><div style=\"clear: both\"><div style=\"float: left\">#" . $nbCommentaires . " - $strPostePar <b>" . show_joueur($commentaire->auteur, $op) . "</b> " . $date . "</div>";
                if ($grade['a'] == 'a' || $grade['b'] == 'b' || $grade['n'] == 'n')
                    echo "<div style=\"float: right\">&nbsp;<a href=?page=news&op=delete_commentaire&id=" . $commentaire->id . "&news=" . $news->id . " onclick=\"return confirm('$strConfirmEffacerCommentaire');\">[$strS]</a></div>";
                echo "</div></td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td class=text>" . stripslashes($contenu) . "<br><br></td>";
                echo "</tr>";
                echo "</table>";
                echo "</td></tr></table>";
            }
            if ($op) $p = "op=$op&";
            else $p = "";
            echo "<table cellspacing=0 cellpadding=0 border=0 align=center>";
            echo "<tr><td class=text2>" . navigateur($start, $nb_max, $nb_total, "?page=news&" . $p . "id=" . $news->id . "&start=%d") . "</td></tr>";
            echo "</table><br>";

            echo "</td></tr></table>";
        }

        /*** poster un commentaire ***/
        echo "<form method=post name=\"formulaire\" action=?page=news&op=add_commentaire>";
        echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
        echo "<table cellspacing=1 cellpadding=0 border=0>";
        echo "<tr><td class=headerfiche>$strAjouterCommentaire</td></tr>";
        echo "<tr><td>";
        echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
        if (empty($s_joueur)) {
            echo "<tr>";
            echo "<td class=textfiche align=center>$strLoguePourPoster</td>";
            echo "</tr>";
        } else {
            echo "<tr>";
            echo "<td class=textfiche colspan=2 align=center width='450'>";
            buttonBB('contenu');
            echo "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td class=titlefiche></td>";
            echo "<td class=textfiche width='500'><textarea cols=50 rows=6 name=contenu ID=contenu wrap=virtual ONSELECT=\"storeCaret(this);\" ONCLICK=\"storeCaret(this);\" ONKEYUP=\"storeCaret(this);\"></textarea></td>";
            echo "</tr>";
            echo "<tr><td class=footerfiche colspan=2 align=center><input type=submit value=\"$strAjouter\"></td></tr>";
        }
        echo "</table>";
        echo "</td></tr></table>";
        echo "</td></tr></table>";
        echo "<input type=hidden name=id value='$id'>";
        echo "</form>";
    }

    echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";


}

?>

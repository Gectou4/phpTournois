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

if (preg_match("/mailing.php/i", $_SERVER['PHP_SELF'])) {
    die ("You cannot open this page directly");
}

/*** verification securite ***/
if ($grade['a'] != 'a' && $grade['b'] != 'b' && $grade['l'] != 'l') {
    js_goto($PHP_SELF);
}

/********************************************************
 * Envoi d'un message
 */
if ($op == "envoi") {

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
    if (!$destinataires) {
        $erreur = 1;
        $str .= "- " . $strElementsDestinataireInvalide . "<br>";
    }

    if ($erreur == 1) {
        show_erreur_saisie($str);
    } else {

        $tab_destinataires = preg_split('/,/', $destinataires);
        $titre = remove_XSS($titre);
        $contenu = remove_XSS($contenu);

        /*** generation commune ***/
        $link = "<a href=\"" . $config['urlsite'] . "\" target=\"_blank\">" . $config['urlsite'] . "</a>";
        $array1 = array("%nomsite%", "%urlsite%", "%link%");
        $array2 = array($config['nomsite'], $config['urlsite'], $link);

        $titre = str_replace($array1, $array2, $titre);
        $contenu = str_replace($array1, $array2, $contenu);

        $erreur = 0;

        if (isset($email)) {

            if ($config['mail'] != 'N') {

                /*** g&eacute;n&eacute;ration de l'email ***/
                $mail = new phpTMailer();
                $from = joueur($s_joueur);
                $mail->From = $from->email;
                $mail->FromName = $from->pseudo;
                $mail->Subject = $titre;
                $body = BBcode($contenu);
                $mail->Body = str_replace("SRC=\"images/smilies/", "SRC=\"" . $config['urlsite'] . "/images/smilies/", $body);

                /*** generation de la messagerie ***/
                for ($i = 0; $i < count($tab_destinataires); $i++) {
                    $to = joueur($tab_destinataires[$i]);
                    $mail->AddAddress($to->email);
                }

                if (!$mail->Send()) {
                    $erreur = 1;
                }
            } else {
                show_erreur($strPasDeFonctionMail);
            }
        }

        if (isset($messagerie)) {
            $date = time();

            for ($i = 0; $i < count($tab_destinataires); $i++) {
                $destinataire = $tab_destinataires[$i];

                $db->insert("${dbprefix}messages (emetteur,destinataire,titre,message,date)");
                $db->values("'$s_joueur','$destinataire','$titre','$contenu','$date'");
                $db->exec();
            }
        }

        if ($erreur == 1)
            show_erreur("$strErreurMessageEnvoi<br><br>$mail->ErrorInfo");
        else {
            show_notice($strMessageEnvoi);
            echo "<br><form method=post action='?page=mailing'><input type=submit class=action value=\"$strOK\"></form>";
        }

    }
} /********************************************************
 * Affichage admin
 */
else {

    ?>
    <script>

        // -------------------------------------------------------------------
        // sortSelect(select_object)
        //   Pass this function a SELECT object and the options will be sorted
        //   by their text (display) values
        // -------------------------------------------------------------------
        function sortSelect(obj) {
            var o = new Array();
            if (obj.options == null) {
                return;
            }
            for (var i = 0; i < obj.options.length; i++) {
                o[o.length] = new Option(obj.options[i].text, obj.options[i].value, obj.options[i].defaultSelected, obj.options[i].selected);
            }
            if (o.length == 0) {
                return;
            }
            o = o.sort(
                function (a, b) {

                    if ((a.text.toLowerCase() + "") < (b.text.toLowerCase() + "")) {
                        return -1;
                    }
                    if ((a.text.toLowerCase() + "") > (b.text.toLowerCase() + "")) {
                        return 1;
                    }
                    return 0;
                }
            );

            for (var i = 0; i < o.length; i++) {
                obj.options[i] = new Option(o[i].text, o[i].value, o[i].defaultSelected, o[i].selected);
            }
        }

        // -------------------------------------------------------------------
        // moveSelectedOptions(select_object,select_object[,autosort(true/false)[,regex]])
        //  This function moves options between select boxes. Works best with
        //  multi-select boxes to create the common Windows control effect.
        //  Passes all selected values from the first object to the second
        //  object and re-sorts each box.
        //  If a third argument of 'false' is passed, then the lists are not
        //  sorted after the move.
        //  You can also put this into the <SELECT> object as follows:
        //    onDblClick="moveSelectedOptions(this,this.form.target)
        //  This way, when the user double-clicks on a value in one box, it
        //  will be transferred to the other (in browsers that support the
        //  onDblClick() event handler).
        // -------------------------------------------------------------------
        function moveSelectedOptions(from, to) {

            // Move them over
            for (var i = 0; i < from.options.length; i++) {
                var o = from.options[i];
                if (o.selected) {
                    to.options[to.options.length] = new Option(o.text, o.value, false, false);
                }
            }
            // Delete them from original
            for (var i = (from.options.length - 1); i >= 0; i--) {
                var o = from.options[i];
                if (o.selected) {
                    from.options[i] = null;
                }
            }
            if ((arguments.length < 3) || (arguments[2] == true)) {
                sortSelect(from);
                sortSelect(to);
            }
            from.selectedIndex = -1;
            to.selectedIndex = -1;
        }

        // -------------------------------------------------------------------
        // moveAllOptions(select_object,select_object[,autosort(true/false)])
        //  Move all options from one select box to another.
        // -------------------------------------------------------------------
        function moveAllOptions(from, to) {
            selectAllOptions(from);
            if (arguments.length == 2) {
                moveSelectedOptions(from, to);
            }
            else if (arguments.length == 3) {
                moveSelectedOptions(from, to, arguments[2]);
            }
        }

        // -------------------------------------------------------------------
        // selectAdmins(select_object)
        // -------------------------------------------------------------------
        function selectAdmins(obj) {

            for (var i = 0; i < obj.options.length; i++) {

                <?php
                $db->select("id");
                $db->from("${dbprefix}joueurs");
                $db->where("admin = 'O'");
                $admins = $db->exec();

                if ($db->num_rows($admins) != 0) {

                    while ($admin = $db->fetch($admins)) {
                        echo "if (obj.options[i].value=='$admin->id' ) obj.options[i].selected = true;";
                    }
                }
                ?>
            }
        }


        // -------------------------------------------------------------------
        // selectNewseurs(select_object)
        // -------------------------------------------------------------------
        function selectNewseurs(obj) {

            for (var i = 0; i < obj.options.length; i++) {

                <?php
                $db->select("id");
                $db->from("${dbprefix}joueurs");
                $db->where("newseur = 'O'");
                $newseurs = $db->exec();

                if ($db->num_rows($newseurs) != 0) {

                    while ($newseur = $db->fetch($newseurs)) {
                        echo "if (obj.options[i].value=='$newseur->id' ) obj.options[i].selected = true;";
                    }
                }
                ?>
            }
        }

        // -------------------------------------------------------------------
        // selectInscrit(select_object)
        // -------------------------------------------------------------------
        function selectInscrits(obj) {

            for (var i = 0; i < obj.options.length; i++) {

                <?php
                $db->select("id");
                $db->from("${dbprefix}joueurs");
                $db->where("etat = 'I'");
                $inscrits = $db->exec();

                if ($db->num_rows($inscrits) != 0) {

                    while ($inscrit = $db->fetch($inscrits)) {
                        echo "if (obj.options[i].value=='$inscrit->id' ) obj.options[i].selected = true;";
                    }
                }
                ?>
            }
        }


        // -------------------------------------------------------------------
        // selectInscrit(select_object)
        // -------------------------------------------------------------------
        function selectPreInscrits(obj) {

            for (var i = 0; i < obj.options.length; i++) {

                <?php
                $db->select("id");
                $db->from("${dbprefix}joueurs");
                $db->where("etat = 'P'");
                $preinscrits = $db->exec();

                if ($db->num_rows($preinscrits) != 0) {

                    while ($preinscrit = $db->fetch($preinscrits)) {
                        echo "if (obj.options[i].value==$preinscrit->id ) obj.options[i].selected = true;";
                    }
                }
                ?>
            }
        }


        // -------------------------------------------------------------------
        // selectManagers(select_object)
        // -------------------------------------------------------------------
        function selectManagers(obj) {

            for (var i = 0; i < obj.options.length; i++) {

                <?php
                $db->select("distinct manager");
                $db->from("${dbprefix}equipes");
                $managers = $db->exec();

                if ($db->num_rows($managers) != 0) {

                    while ($manager = $db->fetch($managers)) {
                        echo "if (obj.options[i].value=='$manager->manager' ) obj.options[i].selected = true;";
                    }
                }
                ?>
            }
        }

        // -------------------------------------------------------------------
        // selectManagers(select_object)
        // -------------------------------------------------------------------
        function selectWarArranger(obj) {

            for (var i = 0; i < obj.options.length; i++) {

                <?php
                $db->select("joueur");
                $db->from("${dbprefix}appartient");
                $db->where("status='2'");
                $waras = $db->exec();

                if ($db->num_rows($waras) != 0) {

                    while ($wara = $db->fetch($waras)) {
                        echo "if (obj.options[i].value=='$wara->joueur' ) obj.options[i].selected = true;";
                    }
                }
                ?>
            }
        }

        // -------------------------------------------------------------------
        // selectEquipe(select_object)
        // -------------------------------------------------------------------
        function selectEquipe(obj, id) {

            for (var i = 0; i < obj.options.length; i++) {

                <?php
                $db->select("distinct equipe as id");
                $db->from("${dbprefix}appartient");
                //$db->where("equipe = 'I'");
                $equipes = $db->exec();

                if ($db->num_rows($equipes) != 0) {

                    while ($equipe = $db->fetch($equipes)) {

                        echo "if (id == '$equipe->id' ) {";

                        $db->select("distinct joueur as id");
                        $db->from("${dbprefix}appartient");
                        $db->where("equipe = '$equipe->id'");
                        $joueurs = $db->exec();

                        if ($db->num_rows($joueurs) != 0) {

                            while ($joueur = $db->fetch($joueurs)) {
                                echo "if (obj.options[i].value=='$joueur->id' ) obj.options[i].selected = true;";
                            }
                        }
                        echo "}";
                    }
                }
                ?>
            }
        }

        // -------------------------------------------------------------------
        // selectTournois(select_object)
        // -------------------------------------------------------------------
        /*
        function selectTournois(obj,id) {

            for (var i=0; i<obj.options.length; i++) {


                $db->select("type,id");
                $db->from("${dbprefix}tournois");
                //$db->where("id = id");
                $res_one = $db->exec();

                while ($res_one_t = $db->fetch($res_one)) {

                    echo "if (id == '$res_one_t->id' ) {";

                         if ($res_one_t->type=="E") {

                            $db->select("equipe");
                            $db->from("${dbprefix}participe");
                            $db->where("tournois = '$res_one_t->id'");
                            //$db->where("equipe = 'I'");
                            $equipes=$db->exec();

                            if ($db->num_rows($equipes) != 0) {

                                while ($equipe = $db->fetch($equipes)) {


                                    echo "selectEquipe(obj,".$equipe->equipe.")";

                                    }
                            }

                         }

                    echo "}";

                }
                /*$sql_fuck_unwork_db2 = "SELECT type FROM ${dbprefix}tournois WHERE id = ".echo 'id'."";
                $req_fuck_unwork_db2 = mysql_query($sql_fuck_unwork_db2) or die('Erreur SQL !<br>'.$sql_fuck_unwork_db2.'<br>'.mysql_error());

                while($data_fuck_unwork_db2_2 = mysql_fetch_array($req_fuck_unwork_db2))
                {
                $type_find=$data_fuck_unwork_db2_2['type'];
                }*

                if ($type_find=="E") {

                $db->select("equipe,id");
                $db->from("${dbprefix}equipes, ${dbprefix}participe");
                $db->where("${dbprefix}equipes.id = ${dbprefix}participe.equipe");
                $db->where("tournois = id");
                $res = $db->exec();

                while ($data_deux = $db->fetch($res)) {
                $data_deux_end=$data_deux['equipe'];
                $db->select("distinct equipe as $data_deux_end");
                $db->from("${dbprefix}appartient");
                $equipes=$db->exec();

                if ($db->num_rows($equipes) != 0) {

                    while ($equipe = $db->fetch($equipes)) {

                        echo "if (id == '$equipe->id' ) {";

                        $db->select("distinct joueur as id");
                        $db->from("${dbprefix}appartient");
                        $db->where("equipe = '$equipe->id'");
                        $joueurs=$db->exec();

                        if ($db->num_rows($joueurs) != 0) {

                            while ($joueur = $db->fetch($joueurs)) {
                                echo "if (obj.options[i].value=='$joueur->id' ) obj.options[i].selected = true;";
                            }
                        }
                        echo "}";
                    }
                }
                }
                } else {
                echo '';
                }





            }
        }*/

        // -------------------------------------------------------------------
        // selectAllOptions(select_object)
        // -------------------------------------------------------------------
        function selectAllOptions(obj) {
            for (var i = 0; i < obj.options.length; i++) {
                obj.options[i].selected = true;
            }
        }

        // -------------------------------------------------------------------
        // unselectAllOptions(select_object)
        // -------------------------------------------------------------------
        function unselectAllOptions(obj) {
            for (var i = 0; i < obj.options.length; i++) {
                obj.options[i].selected = false;
            }
        }

        function option_compress(box, field) {
            field.value = "";
            for (var i = 0; i < box.options.length; i++) {
                if (i > 0) field.value += ",";
                field.value += box.options[i].value;
            }
        }

    </script>

    <?php

    /*** liste des tous les joueurs ***/

    echo "<p class=title>.:: $strMailing ::.</p>";

    $db->select("id,pseudo,email");
    $db->from("${dbprefix}joueurs");
    $db->where("(etat <> 'C')");
    $db->order_by("pseudo");
    $joueurs = $db->exec();

    echo "<form method=post name=formulaire action=?page=mailing&op=envoi>";
    echo "<input type=hidden name=destinataires>";

    echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
    echo "<table cellspacing=1 cellpadding=0 border=0 width=500>";
    echo "<tr><td class=headerfiche>$strEcrireMessage</td></tr>";
    echo "<tr><td>";

    echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";

    /** destinataires **/
    echo "<tr><td class=textfiche colspan=2>";
    echo "<table border=0 width=100%>";
    echo "<tr>";
    echo "<td align=center width=130>";
    echo "<br><input TYPE=button VALUE=\"$strAdmins\" ONCLICK=\"selectAdmins(this.form['list1'])\">";
    echo "<br><input TYPE=button VALUE=\"$strNewseurs\" ONCLICK=\"selectNewseurs(this.form['list1'])\">";
    echo "<br><input TYPE=button VALUE=\"$strManagers\" ONCLICK=\"selectManagers(this.form['list1'])\">";
    echo "<br><input TYPE=button VALUE=\"$strManagers\" ONCLICK=\"selectManagers(this.form['list1'])\">";
    echo "<br><input TYPE=button VALUE=\"$strInscrits\" ONCLICK=\"selectInscrits(this.form['list1'])\">";
    echo "<br><input TYPE=button VALUE=\"$strPreinscrits\" ONCLICK=\"selectPreInscrits(this.form['list1'])\">";

    $db->select("id,tag");
    $db->from("${dbprefix}equipes");
    $db->order_by("tag");
    $equipes = $db->exec();

    if ($db->num_rows($equipes) != 0) {
        echo "<select name=equipes onchange=\"selectEquipe(this.form['list1'],this.value)\">";
        echo "<option value=0 selected>$strEquipe...";

        while ($equipe = $db->fetch($equipes)) {
            echo "<option value='$equipe->id'>$equipe->tag</option>";

        }
        echo "</select>";
    }

    //$db->select("id,nom");
    //$db->from("${dbprefix}tournois");
    //$db->order_by("nom");
    //$tournois=$db->exec();
    /* Note : le code en comme ne renvoie QU'UN SEUL tournois en select. Petite merde !!! */
    /*$sql_fuck_unwork_db = "SELECT id,nom FROM ${dbprefix}tournois ORDER BY nom";
    $req_fuck_unwork_db = mysql_query($sql_fuck_unwork_db) or die('Erreur SQL !<br>'.$sql_fuck_unwork_db.'<br>'.mysql_error());

    if (mysql_fetch_row($req_fuck_unwork_db) != 0) {
        echo "<select name=tournois onchange=\"selectTournois(this.form['list1'],this.value)\">";
        echo "<option value=0 selected>$strTournois...";

        while($data_fuck_unwork_db = mysql_fetch_array($req_fuck_unwork_db))
                    {
        //while ($tournois = $db->fetch($tournois)) {
            echo '<option value="'.$data_fuck_unwork_db['id'].'">'.$data_fuck_unwork_db['nom'].'</option>';
        }
        echo "</select>";
    }*/
    echo "<br><input TYPE=button VALUE=\"$strTous\" ONCLICK=\"selectAllOptions(this.form['list1'])\">";
    echo "&nbsp;<input TYPE=button VALUE=\"$strEffacer\" ONCLICK=\"unselectAllOptions(this.form['list1'])\">";
    echo "</td>";
    echo "<td ALIGN=CENTER class=titlefiche><center>$strJoueurs :<br>";
    echo "<select name=list1 style=\"width:120px\" MULTIPLE SIZE=10 onDblClick=\"moveSelectedOptions(this.form['list1'],this.form['list2'],true)\">";
    while ($joueur = $db->fetch($joueurs)) {
        echo "<option value=$joueur->id>$joueur->pseudo</option>";
    }
    echo "</select></td>";
    echo "<td VALIGN=MIDDLE ALIGN=CENTER><br>";
    echo "<input TYPE=button VALUE=\"&gt;&gt;\"     ONCLICK=\"moveSelectedOptions(this.form['list1'],this.form['list2'],true)\"><br><br>";
    echo "<input TYPE=button VALUE=\"$strTous &gt;&gt;\" ONCLICK=\"moveAllOptions(this.form['list1'],this.form['list2'],true)\"><br><br>";
    echo "<input TYPE=button VALUE=\"&lt;&lt;\"     ONCLICK=\"moveSelectedOptions(this.form['list2'],this.form['list1'],true)\"><br><br>";
    echo "<input TYPE=button VALUE=\"&lt;&lt; $strTous\" ONCLICK=\"moveAllOptions(this.form['list2'],this.form['list1'],true)\">";
    echo "</td>";
    echo "<td ALIGN=CENTER class=titlefiche><center>$strDestinataires :<br>";
    echo "<select name=list2 style=\"width:120px\" MULTIPLE SIZE=10 onDblClick=\"moveSelectedOptions(this.form['list2'],this.form['list1'],true)\">";
    echo "</select>";
    echo "</td>";
    //echo "<td width=1>&nbsp;</td>";
    echo "</tr>";
    echo "</table>";
    echo "</td></tr>";

    /** titre **/
    echo "<tr><td class=titlefiche>$strTitre :</td>";
    echo "<td class=textfiche>";
    echo "<input type=text name=titre maxlength=50 size=50 value=''>";
    echo "</td></tr>";
    echo "<tr>";
    echo "<td class=textfiche colspan=2 align=center>";
    buttonBB('contenu');
    echo "</td>";
    echo "</tr>";

    /** contenu **/
    echo "<tr><td class=titlefiche>$strMessage :</td>";
    echo "<td class=textfiche>";
    echo "<textarea cols=60 rows=10 name=contenu ID=contenu wrap=virtual ONSELECT=\"storeCaret(this);\" ONCLICK=\"storeCaret(this);\" ONKEYUP=\"storeCaret(this);\"></textarea>";
    echo "</td></tr>";

    /** type **/
    echo "<tr><td class=textfiche colspan=2 align=center>";
    echo "$strEMail : <input type=checkbox name=email value=1 checked style=\"border=0px;background-color:transparent;\">&nbsp;&nbsp;$strMessagerie : <input type=checkbox name=messagerie value=1 style=\"border=0px;background-color:transparent;\">";
    echo "</td></tr>";

    echo "<tr><td class=footerfiche colspan=2 align=center><input type=submit value=\"$strEnvoyer\" onclick=\"option_compress(this.form.list2, this.form.destinataires);return true;\"></td></tr>";
    echo "</table>";

    echo "</td></tr></table>";
    echo "</td></tr></table>";
    echo "</form>";

    echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";

}

?>

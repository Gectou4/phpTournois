<?php
/*
   +---------------------------------------------------------------------+
   | phpTournois                                                         |
   +---------------------------------------------------------------------+
   +---------------------------------------------------------------------+
   | phpTournoisG4 ©2005 by Gectou4 <Gectou4 Gectou4@hotmail.com>        |
   +---------------------------------------------------------------------+
   | Copyright(c) 2001-2004 Li0n, RV, Gougou (http://www.phptournois.com)|
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
   | Authors: Li0n  <li0n@phptournois.com>                               |
   |          RV <rv@phptournois.com>                                    |
   |          Gougou                                                     |
   +---------------------------------------------------------------------+
*/

/** @var database $db */
if (file_exists('g4.g4')) {
    echo $install_error;
    exit();
}

$s_theme = 'phpTG4';
$header = 'win';
$version = '3.5_phpTG4_1.1';
$filename = 'config.php';
$filenamem4 = 'config.m4.php';
$filenameab = 'config.ab.php';

//

/*** inclusion des globals ***/
include('globals.php');

/*** chargement de la classe base de donN°e ***/
include("db/mysql.inc.php");

/*** chargement du fichier de fonctions ***/
include("include/functions.inc.php");

/*** chargemen du theme ***/
$config['nomsite'] = 'Install';
if (file_exists("themes/$s_theme/theme.php")) {
    include("themes/$s_theme/theme.php");
}


/*** chargement de la langue ***/
if (isset($langue) && file_exists("lang/$langue.inc.php")) {
    include("lang/$langue.inc.php");
} else {
    include("lang/francais.inc.php");
}

include('include/header.inc.php');

if ($stage == 10) {
    echo "<p class=title>.:: Installation stage : $Installtype2 ::.</p>";
} else {
    echo "<p class=title>.:: Installation stage : $stage ::.</p>";
}
/********************************************************
 * STAGE 0
 */

if ($stage == 0) {
    /*** chargement de la configuration statique***/

    if (defined("PHPTOURNOIS_INSTALLED")) {
        js_goto("index.php?page=index");
    }

    echo "<h3>Welcome on phpTournois !!</h3>";
    echo "<table cellspacing=2 cellpadding=2 border=0>";
    echo "<tr><td class=title>Please select your language :</td></tr>";
    echo "</table>";

    echo "<form method=post action=?stage=10>";
    echo "<table cellspacing=2 cellpadding=2 border=0>";
    echo "<tr><td class=text2 align=center>";
    echo "<select name=langue>";
    $fd = opendir("lang/");
    while ($file = readdir($fd)) {
        if ($file != "." && $file != "..") {
            $file = preg_replace("/.inc.php/", "", $file);
            echo "<option value=$file>$file";
        }
    }
    echo "</select>";
    echo "&nbsp;<input type=submit class=action value=\"OK\">";
    echo "</td></tr>";
    echo "</table>";
    echo "</form>";

}
/********************************************************
 * STAGE 0 - 1
 */
if ($stage == 10) {

    echo "<table cellspacing=2 cellpadding=2 border=0>";
    echo "<tr><td class=title>$Installtype</td></tr>";
    echo "</table>";

    echo "<form method=post action=?stage=1>";
    echo "<table cellspacing=2 cellpadding=2 border=0>";
    echo "<tr><td class=text2 align=center>";
    echo "<select name=install>";
    echo "<option value='install'>$strInstall phpTG4</option>";
    echo "<option value='update'>$strUpdate phpT 3.5 -> phpTG4 RC1</option>";
    //echo "<option value='update16'>$strUpdate phpTG4 1.5 -> phpTG4 1.6</option>";
    echo "</select>";
    echo "<input type=hidden name=langue value=$langue>";
    echo "&nbsp;<input type=submit class=action value=\"OK\">";
    echo "</td></tr>";
    echo "</table>";
    echo "</form>";

} /********************************************************
 * STAGE 1
 */
elseif ($stage == 1) {


    if (!file_exists("config.php")) {
        fwrite(fopen("config.php", "w"), "");
        // fclose("config.php");
    }
    if (!file_exists("config.m4.php")) {
        fwrite(fopen("config.m4.php", "w"), "");
        // fclose("config.m4.php");
    }
    if (!file_exists("config.ab.php")) {
        fwrite(fopen("config.ab.php", "w"), "");
        // fclose("config.ab.php");
    }


    if ($install == "update") {
        js_goto("update.php?stage=1&langue=$langue");
    } else if ($install == "update16") {
        js_goto("update.php?stage=1&langue=$langue&sql=16");
    }

    echo "<h3>$strInstallStage1</h3>";

    if (!is_writable($filename)) {
        show_warning("$strPermissionInvalideConfigFile : $filename");
    }

    if (!is_writable($filenamem4)) {
        show_warning("$strPermissionInvalideConfigFile : $filenamem4");
    }

    if (!is_writable($filenameab)) {
        show_warning("$strPermissionInvalideConfigFile : $filenameab");
    }

    echo "<table cellspacing=2 cellpadding=2 border=0>";
    echo "<tr><td class=title>$strInstallStage1Consignes :</td></tr>";
    echo "</table>";

    echo "<form method=post action=?stage=2>";
    echo "<input type=hidden name=langue value=$langue>";
    echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
    echo "<table cellspacing=1 cellpadding=0 border=0>";
    echo "<tr><td>";
    echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strDBHost :</TD>";
    echo "<td class=textfiche><input type='text' name='dbhost' value='localhost' size='40'></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strDBName :</TD>";
    echo "<td class=textfiche><input type='text' name='dbname' value='phptournois' size='25'></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strDBUser :</TD>";
    echo "<td class=textfiche><input type='text' name='dbuser' value='root' size='15'></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strDBPass :</TD>";
    echo "<td class=textfiche><input type='password' name='dbpass' value=''  size='15'></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>Port :</TD>";
    echo "<td class=textfiche><input type='text' name='dbport' value=''  size='15'></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strDBPrefix :</TD>";
    echo "<td class=textfiche><input type=text name=dbprefix size=10 value=\"phpt_\"></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strphpt_type :</TD>";
    //echo "<td class=textfiche><input type=text name=phpt_type size=10 value=\"$config['phpt_type']\" disabled></TD>";
    echo "<td class=textfiche><select name='phpt_type'>";
    echo "<option value='lan'>lan</option>";
    echo "<option value='online'>online</option>";
    echo "<option value='all'>all</option>";
    echo "</select></td>";
    echo "</tr>";
    echo "</table>";
    echo "</td></tr></table>";
    echo "</td></tr></table>";

    echo "<input type=hidden name=usem4 value=0>";
    echo "<input type=hidden name=useab value=0>";

    echo "<table cellspacing=0 cellspacing=2 border=0>";
    echo "<tr>";
    echo "<td class=text2 align=center>$strInstallStage1Consignes2 </TD>";
    echo "<td class=text2 align=center>$strM4 :</TD>";
    echo "<td class=text2><input type=checkbox name=usem4 value=1 onclick=\"if(this.checked==true) document.getElementById('m4').style.display='block'; else  document.getElementById('m4').style.display='none'\"></TD>";
    echo "<td class=text2 align=center> & $strAdminBot :</TD>";
    echo "<td class=text2><input type=checkbox name=useab value=1 onclick=\"if(this.checked==true) document.getElementById('ab').style.display='block'; else  document.getElementById('ab').style.display='none'\"></TD>";
    echo "</tr>";
    echo "</table>";

    echo "<div id=m4 style=\"display:none\"><table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
    echo "<table cellspacing=1 cellpadding=0 border=0>";
    echo "<tr><td>";
    echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strDBHost $strM4:</TD>";
    echo "<td class=textfiche><input type=text name=m4dbhost value='localhost' size=40></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strDBName $strM4:</TD>";
    echo "<td class=textfiche><input type=text name=m4dbname value='m4' size=25></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strDBUser $strM4:</TD>";
    echo "<td class=textfiche><input type=text name=m4dbuser value='root' size=15></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strDBPass $strM4:</TD>";
    echo "<td class=textfiche><input type=text name=m4dbpass value='' size=15></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strM4Admin:</TD>";
    echo "<td class=textfiche><input type=text name=m4url value='http://' size=40></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "</tr>";

    echo "</table>";
    echo "</td></tr></table>";
    echo "</td></tr></table></div>";

    echo "<div id=ab style=\"display:none\"><table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
    echo "<table cellspacing=1 cellpadding=0 border=0>";
    echo "<tr><td>";
    echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strDBHost $strAdminBot:</TD>";
    echo "<td class=textfiche><input type=text name=abdbhost value='localhost' size=40></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strDBName $strAdminBot:</TD>";
    echo "<td class=textfiche><input type=text name=abdbname value='adminbot' size=25></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strDBUser $strAdminBot:</TD>";
    echo "<td class=textfiche><input type=text name=abdbuser value='root' size=15></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strDBPass $strAdminBot:</TD>";
    echo "<td class=textfiche><input type=text name=abdbpass value='' size=15></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strABAdmin:</TD>";
    echo "<td class=textfiche><input type=text name=aburl value='http://' size=40></TD>";
    echo "</tr>";
    echo "</table>";
    echo "</td></tr></table>";
    echo "</td></tr></table></div>";

    echo "<br><input type=submit class=action value=\"$strValider\">";
    echo "</form>";

} /********************************************************
 * STAGE 2
 */
elseif ($stage == 2) {

    $erreur = 0;
    $dbport ?: 3306;
    /*** configuration g�N°rale ***/
    $str = "<?php
/*
   +---------------------------------------------------------------------+
   | phpTournois                                                         |
   +---------------------------------------------------------------------+
   | phpTournoisG4 ©2005 by Gectou4 <Gectou4 Gectou4@hotmail.com>        |
   +---------------------------------------------------------------------+
   | Copyright(c) 2001-2004 Li0n, RV, Gougou (http://www.phptournois.com)|
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
   | Authors: Li0n  <li0n@phptournois.com>                               |
   |          RV <rv@phptournois.com>                                    |
   |          Gougou                                                     |
   +---------------------------------------------------------------------+
*/

if (preg_match('/config.php/i', \$_SERVER['PHP_SELF'])) {
	die ('You cannot open this page directly');
}

/*****************************/
/*** phpTournois DATABASE ***/
\$dbhost = '$dbhost';
\$dbuser = '$dbuser';
\$dbpass = '$dbpass';
\$dbname = '$dbname';
\$dbport = '$dbport';
\$dbdebug = 1;
\$dbprefix = '$dbprefix';

\$config['phpt_type']='$phpt_type'; // for lan/online mod or all

/************************************************/
/*** Sessions variables ***/
\$config['sess_cookie_min']=120;
\$config['sess_gc_days']=1;
\$config['stats_timeout']=600;

/************************************************/
/*** Flood variable ***/
\$config['flood_time']=30; // must be in minutes !!! Doit être en minutes !!! 

/************************************************/
/*** Screening variables for drawing <table> ***/
// leave default is recommended

/*** Arbres ***/
\$config['x_delta_simple'] = 2;
\$config['x_delta_double'] = 1;

/*** Affichage Equipes ***/
\$config['col_equipes'] = 2;

/*** Affichage Joueur ***/
\$config['col_joueurs'] = 2;

/*** Affichage Poules ***/
\$config['col_poules'] = 2;

/*** Affichage Matchs Poules ***/
\$config['col_matchs_poules'] = 2;

/*** Affichage Maps ***/
\$config['col_maps'] = 3;

/*** Affichage Maps ***/
\$config['col_jeux'] = 2;

/*** Affichage Serveurs ***/
\$config['col_serveurs'] = 1;

/*** Affichage Administrateurs ***/
\$config['col_administrateurs'] = 2;

/*** Affichage Gallerie ***/
\$config['col_avatar_gallerie'] = 5;

/*** Affichage Sponsors ***/
\$config['col_sponsors'] = 4;

/*** Affichage Catégorie ***/
\$config['col_categories']=4;

/*** Affichage des miniature ***/
\$config['col_gallery_thumb'] = 4;

/*** Nb de X max / page ***/
\$config['nb_news_max']=5;
\$config['nb_news_commentaires_max']=5;
\$config['nb_matchs_commentaires_max']=10;
\$config['nb_livredor_max']=10;
\$config['nb_gallery_thumb'] = 16;
\$config['nb_sondage_commentaires_max']=10;


/** do not touch **/
include('config.m4.php');
include('config.ab.php');

";
    /*** ecriture de la config g�N°rale ***/
    if (!$fd = @fopen($filename, "w")) {
        $erreur = 1;
        show_erreur("$strOuvertureInvalideConfigFile : $filename");
    } elseif (!fputs($fd, $str)) {
        $erreur = 1;
        show_erreur("$strEcritureInvalideConfigFile : $filename");
    } else {
        fclose($fd);
    }

    /*** configuration M4 ***/
    if ($m4url == 'http://') $m4url = '';
    $str = "<?php
/*
   +---------------------------------------------------------------------+
   | phpTournois                                                         |
   +---------------------------------------------------------------------+
   | phpTournoisG4 ©2005 by Gectou4 <Gectou4 Gectou4@hotmail.com>        |
   +---------------------------------------------------------------------+
   | Copyright(c) 2001-2004 Li0n, RV, Gougou (http://www.phptournois.com)|
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
   | Authors: Li0n  <li0n@phptournois.com>                               |
   |          RV <rv@phptournois.com>                                    |
   |          Gougou                                                     |
   +---------------------------------------------------------------------+
*/

if (preg_match('`config.m4.php`i', \$_SERVER['PHP_SELF'])) {
	die ('You cannot open this page directly');
}

/*****************************/
/*** M4 DATABASE***/
\$m4dbhost = '$m4dbhost';
\$m4dbuser = '$m4dbuser';
\$m4dbpass = '$m4dbpass';
\$m4dbname = '$m4dbname';
\$m4dbdebug = 1;
\$m4url='$m4url';

// M4 default cvar for creating matches
\$m4rulecfg = 'RL12';
\$m4campscfg = 0;
\$m4autostartcfg = 1;
\$m4prolongationcfg = 1;

";

    /*** ecriture de la config M4 ***/
    if (!$fd = @fopen($filenamem4, "w")) {
        $erreur = 1;
        show_erreur("$strOuvertureInvalideConfigFile : $filenamem4");
    } elseif (!fputs($fd, $str)) {
        $erreur = 1;
        show_erreur("$strEcritureInvalideConfigFile : $filenamem4");
    } else {
        fclose($fd);
    }


    /*** configuration Abminbot ***/
    if ($aburl == 'http://') $aburl = '';
    $str = "<?php
/*
   +---------------------------------------------------------------------+
   | phpTournois                                                         |
   +---------------------------------------------------------------------+
   | phpTournoisG4 ©2005 by Gectou4 <Gectou4 Gectou4@hotmail.com>        |
   +---------------------------------------------------------------------+
   | Copyright(c) 2001-2004 Li0n, RV, Gougou (http://www.phptournois.com)|
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
   | Authors: Li0n  <li0n@phptournois.com>                               |
   |          RV <rv@phptournois.com>                                    |
   |          Gougou                                                     |
   +---------------------------------------------------------------------+
*/

if (preg_match('`config.ab.php`i', \$_SERVER['PHP_SELF'])) {
	die ('You cannot open this page directly');
}

/***************************************/
/*** AdminBot-MX DATABASE ***/
\$abdbhost = '$abdbhost';
\$abdbuser = '$abdbuser';
\$abdbpass = '$abdbpass';
\$abdbname = '$abdbname';
\$abdbdebug = 1;
\$aburl = '$aburl';
\$aburle = 'mr15';

// AdminBot-MX default cvar for creating matches
\$abrulecfg = '12';
\$abcampscfg = 0;
\$abautostartcfg = 1;
\$abprolongationcfg = 0;

";

    /*** ecriture de la config AB ***/
    if (!$fd = @fopen($filenameab, "w")) {
        $erreur = 1;
        show_erreur("$strOuvertureInvalideConfigFile : $filenameab");
    } elseif (!fputs($fd, $str)) {
        $erreur = 1;
        show_erreur("$strEcritureInvalideConfigFile : $filenameab");
    } else {
        fclose($fd);
    }


    if (!$erreur) {
        echo "<h3>$strInstallStage2</h3>";
        echo "<table cellspacing=2 cellpadding=2 border=0>";
        echo "<tr><td class=title>$strInstallStage2Consignes :</td></tr>";
        echo "</table>";

        echo "<form method=post action=?stage=3>";
        echo "<input type=hidden name=langue value=$langue>";
        echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
        echo "<table cellspacing=1 cellpadding=0 border=0>";
        echo "<tr><td>";
        echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
        echo "<tr><td class=titlefiche>$strNom :</td>";
        echo "<td class=textfiche><input type=text name=nomsite size=50>";
        echo "</td></tr>";
        echo "<tr><td class=titlefiche>$strSite :</td>";
        echo "<td class=textfiche><input type=text name=urlsite value=\"http://" . $_SERVER['SERVER_NAME'] . str_replace("/install.php", "", $_SERVER["SCRIPT_NAME"]) . "\" size=100>";
        echo "</td></tr>";
        //echo "<tr><td class=titlefiche>$strVersion :</td>";
        //echo "<td class=textfiche><select name=mode><option value=''>$strSansDemo</select>";
        //<option value=demo>$strAvecDemo
        echo "</td></tr>";
        echo "</table>";
        echo "</td></tr></table>";
        echo "</td></tr></table>";

        echo "<br><table cellspacing=2 cellpadding=2 border=0>";
        echo "<tr><td class=title>$strInstallStage2Consignes2:</td></tr>";
        echo "</table>";

        echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
        echo "<table cellspacing=1 cellpadding=0 border=0>";
        echo "<tr><td>";
        echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
        echo "<tr><td class=titlefiche>$strPseudo :</td>";
        echo "<td class=textfiche><input type=text name=adminpseudo value=\"admin\"size=20>";
        echo "</td></tr>";
        echo "<tr><td class=titlefiche>$strPassword :</td>";
        echo "<td class=textfiche><input type=password name=adminpassword value=\"\" size=20>";
        echo "</td></tr>";
        echo "<tr><td class=titlefiche>$strConfirm :</td>";
        echo "<td class=textfiche><input type=password name=adminpassword2 value=\"\" size=20>";
        echo "</td></tr>";
        echo "<tr><td class=titlefiche>$strEMail :</td>";
        echo "<td class=textfiche><input type=text name=adminemail value=\"\" size=30>";
        echo "</td></tr>";
        echo "</table>";
        echo "</td></tr></table>";
        echo "</td></tr></table>";

        echo "<input type=submit class=action value=\"$strValider\">";

        echo "</form>";


    }
} /********************************************************
 * STAGE 3
 */
elseif ($stage == 3) {

    /*** chargement de la configuration statique***/
    include('config.php');

    $str = '';
    $erreur = 0;


    if (!$adminpseudo) {
        $erreur = 1;
        $str .= "- $strElementsPseudoInvalide<br>";
    }
    if (!$adminpassword || !$adminpassword2 || $adminpassword != $adminpassword2) {
        $erreur = 1;
        $str .= "- $strElementsPasswordInvalide<br>";
    }
    if (!$adminemail || !preg_match("`^[a-z0-9._-]+@+[a-z0-9._-]+.+[a-z]{2,4}$`i", $adminemail)) {
        $erreur = 1;
        $str .= "- $strElementsEmailInvalide<br>";
    }

    if ($erreur == 1) {
        show_erreur_saisie($str);
    } else {
        /*** test de la base ***/
        $link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname, $dbport ?? 3306) or die($strConnexionImpossible);

        if (!$link) {
            /*** creation de la base ***/
            die($strCreationImpossible . " : " . mysqli_error($link));
        }

        mysqli_close($link);

        /*** reouverture en mode objet ***/
        $db = new database($dbhost, $dbuser, $dbpass, $dbname, $dbport ?? 3306);
        $db->debug($dbdebug);
        $db->connect();

        include "db/g4.php";
        $a = explode(';', $req);

        foreach ($a as $q) {
            if (trim($q) == "") break;
            if (!$db->query($q))
                die($db->getError());
        }

        /*** from http://www.php.net/manual/fr/function.mysql-query.php ***/

        /* update nom & site*/
        $db->update("${dbprefix}config");
        $db->set("nomsite='$nomsite',urlsite='$urlsite'");
        $db->exec();

        /* update de l'admin */
        $db->update("${dbprefix}joueurs");
        $db->set("pseudo='$adminpseudo',passwd=md5('$adminpassword'),email='$adminemail'");
        $db->where('id = 1');
        $db->exec();

        /* update du fichier de conf */
        if (!$fd = @fopen($filename, "a+")) {
            $erreur = 1;
            show_erreur("$strOuvertureInvalideConfigFile : $filename");
        } elseif (!fputs($fd, "define('PHPTOURNOIS_INSTALLED',true);")) {
            $erreur = 1;
            show_erreur("$strEcritureInvalideConfigFile : $filename");
        } else {
            fclose($fd);
        }

        echo "<h3>$strInstallStage3</h3>";
        echo "$strInstallStage3Consignes<br>";
        echo "pensez à visiter les forum phpTournois http://forum.phptournois.net/ !";

        /** tentative d'effacage **/
        //@unlink('install.php');
        //if (is_file('install.php')) show_warning("$strInstallStage3DelInstall<br>");
        //@unlink('update.php');
        //if (is_file('update.php')) show_warning("$strInstallStage3Delupdatel<br>");
        if (!file_exists("g4.g4")) {
            try {
                fwrite(fopen("g4.g4", "w"), "phpTG4 installed");
            } catch (Exception $e) {
                echo "can't create g4.g4 files on root to prevent install exploit";
            }
        }

    }

} elseif ($stage == 4) {
    echo "<h3>$strInstallStage3</h3>";
    echo "$strInstallStage3Consignes<br>";
}

echo "<br>";
include('include/footer.inc.php');
$db->close();
exit;
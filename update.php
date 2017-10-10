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
// test de s�curit�
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

/*** inclusion des globals ***/
include('globals.php');

/*** chargement de la classe base de donN°e ***/
include("db/mysql.inc.php");

/*** chargement du fichier de fonctions ***/
include("include/functions.inc.php");

/*** chargement du theme ***/
$config['nomsite'] = 'Install';
include("themes/$s_theme/theme.php");

/*** chargement de la langue ***/
if (isset($langue)) {
    include("lang/$langue.inc.php");
} /*else
{
	include("lang/english.inc.php");
}*/
else {
    include("lang/francais.inc.php");
}

include('include/header.inc.php');

/*** chargement de la configuration statique***/
if (@file_exists("config_old.php") AND $stage == 1) {
    include('config_old.php');
} else {
    include('config.php');
}
if (@file_exists("config.m4_old.php") AND $stage == 1) {
    include('config.m4_old.php');
} else {
    include('config.m4.php');
}
if (@file_exists("config.ab_old.php") AND $stage == 1) {
    include('config.ab_old.php');
} else {
    include('config.ab.php');
}


echo "<p class=title>.:: Mise à jour stage $stage ::.</p>";

/********************************************************
 * STAGE 0
 */
if ($stage == 0) {


    if (!defined("PHPTOURNOIS_INSTALLED"))
        js_goto("install.php");

    echo "<h3>Welcome on phpTournois !!</h3>";
    echo "<table cellspacing=2 cellpadding=2 border=0>";
    echo "<tr><td class=title>Please select your language :</td></tr>";
    echo "</table>";

    echo "<form method=post action=?stage=1>";
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

} /********************************************************
 * STAGE 1
 */
elseif ($stage == 1) {

    /*
        if(file_exists("config.php") AND filesize("config.php") != 0 )
        {
        rename("config.php", "config_old.php");
        fwrite( fopen("config.php","w"), "");
       // fclose("config.php");
        }else if(!file_exists("config.php")){
        fwrite( fopen("config.php","w"), "");
       // fclose("config.php");
        }
        if(file_exists("config.m4.php") AND filesize("config.m4.php") != 0 )
        {
        rename("config.m4.php", "config.m4_old.php");
        fwrite( fopen("config.m4.php","w"), "");
        //fclose("config.m4.php");
        }else if(!file_exists("config.m4.php")){
        fwrite( fopen("config.m4.php","w"), "");
       // fclose("config.m4.php");
        }
        if(file_exists("config.ab.php") AND filesize("config.ab.php") != 0 )
        {
        rename("config.ab.php", "config.ab_old.php");
        fwrite( fopen("config.ab.php","w"), "");
       // fclose("config.ab.php");
        }else if(!file_exists("config.ab.php")){
        fwrite( fopen("config.ab.php","w"), "");
       // fclose("config.ab.php");
        }
        */
    include('config.php');

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
    echo "<input type=hidden name=sql value=$sql>";
    echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
    echo "<table cellspacing=1 cellpadding=0 border=0>";
    echo "<tr><td>";
    echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strCocheforwrite1 :</TD>";
    echo "<td class=textfiche><input type=checkbox name=useconfig value=1 onclick=\"if(this.checked==true) document.getElementById('config').style.display='block'; else  document.getElementById('config').style.display='none'\"></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strCocheforwrite2 :</TD>";
    echo "<td class=textfiche><input type=checkbox name=usem4 value=1 onclick=\"if(this.checked==true) document.getElementById('m4').style.display='block'; else  document.getElementById('m4').style.display='none'\"></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strCocheforwrite3 :</TD>";
    echo "<td class=textfiche><input type=checkbox name=useab value=1 onclick=\"if(this.checked==true) document.getElementById('ab').style.display='block'; else  document.getElementById('ab').style.display='none'\"></TD>";
    echo "</tr>";
    echo "</table>";
    echo "</td></tr></table>";
    echo "</td></tr></table>";

    echo "<input type=hidden name=usem4 value=0>";
    echo "<input type=hidden name=useab value=0>";


    echo "<div id=config style=\"display:none\"><table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
    echo "<table cellspacing=1 cellpadding=0 border=0>";
    echo "<tr><td>";
    echo "<table cellspacing=0 cellpadding=3 border=0>";

    echo "<tr>";
    echo "<td class=headerfiche align=center colspan=2>$strConfiguration_general</TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strDBHost :</TD>";
    echo "<td class=textfiche><input type=text name=dbhost value='$dbhost' size=40></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strDBName :</TD>";
    echo "<td class=textfiche><input type=text name=dbname value='$dbname' size=25></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strDBUser :</TD>";
    echo "<td class=textfiche><input type=text name=dbuser value='$dbuser' size=15></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strDBPass :</TD>";
    echo "<td class=textfiche><input type=password name=dbpass value='$dbpass' size=15></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strDBPrefix :</TD>";
    echo "<td class=textfiche><input type=text name=dbprefix size=10 value=\"$dbprefix\" disabled></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strphpt_type :</TD>";
    //echo "<td class=textfiche><input type=text name=phpt_type size=10 value=\"$config['phpt_type']\" disabled></TD>";
    echo "<td class=textfiche><select name=phpt_type>";
    echo "<option value='" . $config['phpt_type'] . "' selected>" . $config['phpt_type'] . "</option>";
    echo "<option value='lan'>lan</option>";
    echo "<option value='online'>online</option>";
    echo "<option value='all'>all</option>";
    echo "</select></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=headerfiche align=center colspan=2>$strSessions_variables</TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strsess_cookie_min :</TD>";
    echo "<td class=textfiche><input type=text name=sess_cookie_min size=10 value=\"" . $config['sess_cookie_min'] . "\" ></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strsess_gc_days :</TD>";
    echo "<td class=textfiche><input type=text name=sess_gc_days size=10 value=\"" . $config['sess_gc_days'] . "\" ></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strstats_timeout :</TD>";
    echo "<td class=textfiche><input type=text name=stats_timeout size=10 value=\"" . $config['stats_timeout'] . "\" ></TD>";
    echo "</tr>";

    echo "<tr>";
    echo "<td class=headerfiche align=center colspan=2>$strFlood_variable</TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strflood_time :</TD>";
    echo "<td class=textfiche><input type=text name=flood_time size=10 value=\"" . $config['flood_time'] . "\" ></TD>";
    echo "</tr>";

    echo "<tr>";
    echo "<td class=headerfiche align=center colspan=2>$strtable_col</font> </TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strx_delta_simple :</TD>";
    echo "<td class=textfiche><input type=text name=x_delta_simple size=3 value=\"" . $config['x_delta_simple'] . "\" ></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strx_delta_double :</TD>";
    echo "<td class=textfiche><input type=text name=x_delta_double size=3 value=\"" . $config['x_delta_double'] . "\" ></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strcol_equipes :</TD>";
    echo "<td class=textfiche><input type=text name=col_equipes size=3 value=\"" . $config['col_equipes'] . "\" ></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strcol_joueurs  :</TD>";
    echo "<td class=textfiche><input type=text name=col_joueurs size=3 value=\"" . $config['col_joueurs'] . "\" ></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strcol_poules :</TD>";
    echo "<td class=textfiche><input type=text name=col_poules size=3 value=\"" . $config['col_poules'] . "\" ></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strcol_matchs_poules :</TD>";
    echo "<td class=textfiche><input type=text name=col_matchs_poules size=3 value=\"" . $config['col_matchs_poules'] . "\" ></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strcol_maps  :</TD>";
    echo "<td class=textfiche><input type=text name=col_maps size=3 value=\"" . $config['col_maps'] . "\" ></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strcol_jeux :</TD>";
    echo "<td class=textfiche><input type=text name=col_jeux size=3 value=\"" . $config['col_jeux'] . "\" ></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strcol_serveurs :</TD>";
    echo "<td class=textfiche><input type=text name=col_serveurs size=3 value=\"" . $config['col_serveurs'] . "\" ></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strcol_administrateurs  :</TD>";
    echo "<td class=textfiche><input type=text name=col_administrateurs size=3 value=\"" . $config['col_administrateurs'] . "\" ></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strcol_avatar_gallerie  :</TD>";
    echo "<td class=textfiche><input type=text name=col_avatar_gallerie size=3 value=\"" . $config['col_avatar_gallerie'] . "\" ></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strcol_sponsors  :</TD>";
    echo "<td class=textfiche><input type=text name=col_sponsors size=3 value=\"" . $config['col_sponsors'] . "\" ></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strcol_categories  :</TD>";
    echo "<td class=textfiche><input type=text name=col_categories size=3 value=\"" . $config['col_categories'] . "\" ></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strcol_gallery_thumb  :</TD>";
    echo "<td class=textfiche><input type=text name=col_gallery_thumb size=3 value=\"" . $config['col_gallery_thumb'] . "\" ></TD>";
    echo "</tr>";

    echo "<tr>";
    echo "<td class=headerfiche align=center colspan=2>$strnumxp</TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strnb_news_max :</TD>";
    echo "<td class=textfiche><input type=text name=nb_news_max size=3 value=\"" . $config['nb_news_max'] . "\" ></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strnb_news_commentaires_max :</TD>";
    echo "<td class=textfiche><input type=text name=nb_news_commentaires_max size=3 value=\"" . $config['nb_news_commentaires_max'] . "\" ></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strnb_matchs_commentaires_max :</TD>";
    echo "<td class=textfiche><input type=text name=nb_matchs_commentaires_max size=3 value=\"" . $config['nb_matchs_commentaires_max'] . "\" ></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strnb_livredor_max :</TD>";
    echo "<td class=textfiche><input type=text name=nb_livredor_max size=3 value=\"" . $config['nb_livredor_max'] . "\" ></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strnb_gallery_thumb :</TD>";
    echo "<td class=textfiche><input type=text name=nb_gallery_thumb size=3 value=\"" . $config['nb_gallery_thumb'] . "\" ></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strnb_sondage_commentaires_max :</TD>";
    echo "<td class=textfiche><input type=text name=nb_sondage_commentaires_max size=3 value=\"" . $config['nb_sondage_commentaires_max'] . "\" ></TD>";
    echo "</tr>";


    echo "</table>";
    echo "</td></tr></table>";
    echo "</td></tr></table>";
    echo "</div>";

    echo "<div id=m4 style=\"display:none\"><table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
    echo "<table cellspacing=1 cellpadding=0 border=0>";
    echo "<tr><td>";
    echo "<table cellspacing=0 cellpadding=3 border=0>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strDBHost $strM4:</TD>";
    echo "<td class=textfiche><input type=text name=m4dbhost value='$m4dbhost' size=40></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strDBName $strM4:</TD>";
    echo "<td class=textfiche><input type=text name=m4dbname value='$m4dbname' size=25></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strDBUser $strM4:</TD>";
    echo "<td class=textfiche><input type=text name=m4dbuser value='$m4dbuser' size=15></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strDBPass $strM4:</TD>";
    echo "<td class=textfiche><input type=text name=m4dbpass value='$m4dbpass' size=15></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strM4Admin:</TD>";
    echo "<td class=textfiche><input type=text name=m4url value='$m4url' size=40></TD>";

    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strtm4rulecfg:</TD>";
    echo "<td class=textfiche><input type=text name=m4rulecfg value='$m4rulecfg' size=40></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strm4campscfg:</TD>";
    echo "<td class=textfiche><input type=text name=m4campscfg value='$m4campscfg' size=40></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strm4autostartcfg:</TD>";
    echo "<td class=textfiche><input type=text name=m4autostartcfg value='$m4autostartcfg' size=40></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strm4prolongationcfg:</TD>";
    echo "<td class=textfiche><input type=text name=m4prolongationcfg value='$m4prolongationcfg' size=40></TD>";
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
    echo "<td class=textfiche><input type=text name=abdbhost value='$abdbhost' size=40></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strDBName $strAdminBot:</TD>";
    echo "<td class=textfiche><input type=text name=abdbname value='$abdbname' size=25></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strDBUser $strAdminBot:</TD>";
    echo "<td class=textfiche><input type=text name=abdbuser value='$abdbuser' size=15></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strDBPass $strAdminBot:</TD>";
    echo "<td class=textfiche><input type=text name=abdbpass value='$abdbpass' size=15></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strABAdmin:</TD>";
    echo "<td class=textfiche><input type=text name=aburl value='$aburl' size=40></TD>";
    echo "</tr>";

    echo "<tr>";
    echo "<td class=titlefiche align=center>$strabrulecfg:</TD>";
    echo "<td class=textfiche><input type=text name=abrulecfg value='$abrulecfg' size=40></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strabcampscfg:</TD>";
    echo "<td class=textfiche><input type=text name=abcampscfg value='$abcampscfg' size=40></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strabautostartcfg:</TD>";
    echo "<td class=textfiche><input type=text name=abautostartcfg value='$abautostartcfg' size=40></TD>";
    echo "</tr>";
    echo "<tr>";
    echo "<td class=titlefiche align=center>$strabprolongationcfg:</TD>";
    echo "<td class=textfiche><input type=text name=abprolongationcfg value='$abprolongationcfg' size=40></TD>";
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


    /*** configuration g�N°rale ***/
    if ($useconfig == "1" || $useconfig == 1) {
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
\$dbdebug = 1;
\$dbprefix = 'phpt_';

\$config['phpt_type']='$phpt_type'; // for lan/online mod or all

/************************************************/
/*** Sessions variables ***/
\$config['sess_cookie_min']=$sess_gc_days;
\$config['sess_gc_days']=$sess_gc_days;
\$config['stats_timeout']=$stats_timeout;

/************************************************/
/*** Flood variable ***/
\$config['flood_time']=$flood_time; // must be in minutes !!! Doit être en minutes !!! 

/************************************************/
/*** Screening variables for drawing <table> ***/
// leave default is recommended

/*** Arbres ***/
\$config['x_delta_simple'] = $x_delta_simple;
\$config['x_delta_double'] = $x_delta_double;

/*** Affichage Equipes ***/
\$config['col_equipes'] = $col_equipes;

/*** Affichage Joueur ***/
\$config['col_joueurs'] = $col_joueurs;

/*** Affichage Poules ***/
\$config['col_poules'] = $col_poules;

/*** Affichage Matchs Poules ***/
\$config['col_matchs_poules'] = $col_matchs_poules;

/*** Affichage Maps ***/
\$config['col_maps'] = $col_maps;

/*** Affichage Maps ***/
\$config['col_jeux'] = $col_jeux;

/*** Affichage Serveurs ***/
\$config['col_serveurs'] = $col_serveurs;

/*** Affichage Administrateurs ***/
\$config['col_administrateurs'] = $col_administrateurs;

/*** Affichage Gallerie ***/
\$config['col_avatar_gallerie'] = $col_avatar_gallerie;

/*** Affichage Sponsors ***/
\$config['col_sponsors'] = $col_sponsors;

/*** Affichage Catégorie ***/
\$config['col_categories']=$col_categories;

/*** Affichage des miniature ***/
\$config['col_gallery_thumb'] = $col_gallery_thumb;

/*** Nb de X max / page ***/
\$config['nb_news_max']=$nb_news_max;
\$config['nb_news_commentaires_max']=$nb_news_commentaires_max;
\$config['nb_matchs_commentaires_max']=$nb_matchs_commentaires_max;
\$config['nb_livredor_max']=$nb_livredor_max;
\$config['nb_gallery_thumb'] = $nb_gallery_thumb;
\$config['nb_sondage_commentaires_max']=$nb_sondage_commentaires_max;


/** do not touch **/
include('config.m4.php');
include('config.ab.php');

?>";
        /*** ecriture de la config g�N°rale ***/
        if (!$fd = @fopen($filename, "w+")) {
            $erreur = 1;
            show_erreur("$strOuvertureInvalideConfigFile : $filename");
        } elseif (!fputs($fd, $str)) {
            $erreur = 1;
            show_erreur("$strEcritureInvalideConfigFile : $filename");
        } else {
            fclose($fd);
        }
    }
    /*** configuration M4 ***/
    if ($usem4 == "1" || $usem4 == 1) {
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

if (preg_match('/config.m4.php/i', \$_SERVER['PHP_SELF'])) {
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
\$m4rulecfg = '$m4rulecfg';
\$m4campscfg = $m4campscfg;
\$m4autostartcfg = $m4autostartcfg;
\$m4prolongationcfg = $m4prolongationcfg;

?>";

        /*** ecriture de la config M4 ***/
        if (!$fd = @fopen($filenamem4, "w+")) {
            $erreur = 1;
            show_erreur("$strOuvertureInvalideConfigFile : $filenamem4");
        } elseif (!fputs($fd, $str)) {
            $erreur = 1;
            show_erreur("$strEcritureInvalideConfigFile : $filenamem4");
        } else {
            fclose($fd);
        }

    }
    /*** configuration Abminbot ***/
    if ($useab == "1" || $useab == 1) {
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

if (preg_match('/config.ab.php/i', \$_SERVER['PHP_SELF'])) {
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

// AdminBot-MX default cvar for creating matches
\$abrulecfg = '$abrulecfg';
\$abcampscfg = $abcampscfg;
\$abautostartcfg = $abautostartcfg;
\$abprolongationcfg = $abprolongationcfg;

?>";

        /*** ecriture de la config AB ***/
        if (!$fd = @fopen($filenameab, "w+")) {
            $erreur = 1;
            show_erreur("$strOuvertureInvalideConfigFile : $filenameab");
        } elseif (!fputs($fd, $str)) {
            $erreur = 1;
            show_erreur("$strEcritureInvalideConfigFile : $filenameab");
        } else {
            fclose($fd);
        }

    }

    if (!$erreur) {
        echo "<h3>$strInstallStage2</h3>";
        echo "<table cellspacing=2 cellpadding=2 border=0>";
        echo "<tr><td class=title>$strInstallStage2Consignes :</td></tr>";
        echo "</table>";

        echo "<form method=post action=?stage=3>";
        echo "<input type=hidden name=langue value=$langue>";
        echo "<input type=hidden name=sql value=$sql>";
        echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
        echo "<table cellspacing=1 cellpadding=0 border=0>";
        echo "<tr><td>";
        echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
        echo "<tr><td class=titlefiche>$strNom :</td>";
        echo "<td class=textfiche><input type=text name=nomsite size=50>";
        echo "</td></tr>";
        echo "<tr><td class=titlefiche>$strSite :</td>";
        echo "<td class=textfiche><input type=text name=urlsite value=\"http://" . $_SERVER['SERVER_NAME'] . str_replace("/update.php", "", $_SERVER["SCRIPT_NAME"]) . "\" size=30>";
        echo "</td></tr>";
        //echo "<tr><td class=titlefiche>$strVersion :</td>";
        //echo "<td class=textfiche><select name=mode><option value=''>$strSansDemo</select>";
        //<option value=demo>$strAvecDemo
        echo "</td></tr>";
        echo "</table>";
        echo "</td></tr></table>";
        echo "</td></tr></table>";
        /*
        echo "<br><table cellspacing=2 cellpadding=2 border=0>";
                echo "<tr><td class=title>$strInstallStage2Consignes2:</td></tr>";
                echo "</table>";

        echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
        echo "<table cellspacing=1 cellpadding=0 border=0>";
        echo "<tr><td>";
        echo "<table cellspacing=0 cellpadding=3 border=0 width='100%'>";
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
        */
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

    if ($erreur == 1) {
        show_erreur_saisie($str);
    } else {

        /*** test de la base ***/
        $link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname, $dbport ?? 3306) or die($strConnexionImpossible);

        if (!$link) {
            show_erreur("$strBaseInexistante : $dbname");
        }

        mysqli_close($link);

        /*** reouverture en mode objet ***/
        $db = new database($dbhost, $dbuser, $dbpass, $dbname, $dbport ?? 3306);
        $db->debug($dbdebug);
        $db->connect();

        if (($sql ?? false) == "16") {
            include("db/up_g4_16.php");
            $a = explode(';', $req);

            if (!$db->query($req))
                die($db->getError());

            $db->exec();

        } else {

            include("db/up_g4.php");
        }


        /* update des newseurs */
        $db->update("${dbprefix}joueurs");
        $db->set("grade='nz'");
        $db->where("newseur = 'O'");
        $db->exec();

        /* update des admins */
        $db->update("${dbprefix}joueurs");
        $db->set("grade='abcdefghijklmnopqrstuvwxyz'");
        $db->where("admin = 'O'");
        $db->exec();


        /* update du fichier de conf */
        if (!$fd = @fopen($filename, "a+")) {
            $erreur = 1;
            show_erreur("$strOuvertureInvalideConfigFile : $filename");
        } elseif (!fputs($fd, "<?php define('PHPTOURNOIS_INSTALLED',true);?>")) {
            $erreur = 1;
            show_erreur("$strEcritureInvalideConfigFile : $filename");
        } else {
            fclose($fd);
        }

        echo "<h3>$strInstallStage3</h3>";
        echo "$strInstallStage3Consignes<br>";
        echo "Support ? : http://forum.phptournois.net/ !<br>";
        echo "Don't forgot to go on your configuration pag for define new configuration tool !<br>";
        echo "N'oubliez pas d'aller sur votre page configuration pour définir les nouvelles options de configurations !<br>";


        /** tentative d'effacage **/
        @unlink('install.php');
        if (is_file('install.php')) show_warning("$strInstallStage3DelInstall<br>");
        @unlink('update.php');
        if (is_file('update.php')) show_warning("$strInstallStage3Delupdatel<br>");
        if (!file_exists("g4.g4")) {
            try {
                fwrite(fopen("g4.g4", "w"), "phpTG4 installed");
            } catch (Eception $e) {
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
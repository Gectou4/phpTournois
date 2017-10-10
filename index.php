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

// TEST d'install
if (!file_exists("config.php")) {
    echo '
	<script language="javascript">
	
	location.href = "install.php";
	
	</script>
	';

}

/*** chargement du kernel ***/
include('kernel.php');

if (!isset($op)) $op = '';

if (isset($page) && $page != '') $file = $page;
else $file = 'index';

$file = str_replace(array("..", "/"), "", $file);

if ($file == 'index') {
    if ($config['pagestart']) $file = $config['pagestart'];
    else $file = 'accueil';
}

if ($config['pagestart']) $pg_start = $config['pagestart'];
else $pg_start = 'accueil';

if (($s_joueur == NULL || $s_joueur == '') && $mods['forcing'] == '1' && ($file != 'index' && $file != 'accueil' && $file != 'login' && $op != 'login' && $file != $pg_start && ($file != 'joueurs' && ($op != 'inscription' || $op != 'do_inscription')))) {
    $file = 'flog';
}
/*** header ***/
if (!isset($header) || $header != 'nude') {
    include('include/header.inc.php');
}

/*** commande module ***/
include('include/files/alerte.php');

/*** main ***/
if (is_file("include/files/$file.php")) {
    include("include/files/$file.php");
} else {
    include("include/files/404.php");
}

/*** footer ***/
if (!isset($header) || $header != 'nude') {
    include('include/footer.inc.php');
}

/*** fermeture de la base ***/
$db->close();
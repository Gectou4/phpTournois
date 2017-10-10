
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
if (preg_match("`header.inc.php`i", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}

/*<script lang="Javascript"><?php include('include/javascript.inc.php');?></script>*/

/*** Benchmark ***/
$time_start = getmicrotime();
$compteur=compteur();
//<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
//http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd>
?>
<html>
<head>
<title><?php echo 'phpTournois - '.$config['nomsite'];?></title>
<link rel="shortcut icon" href="/images/transparent.ico" />
<META NAME="TITLE" CONTENT="phpTournois">
<META NAME="DESCRIPTION" CONTENT="Outil en php d'aide dans la gestion de tournois, de lan party">
<META NAME="KEYWORDS" CONTENT="php, gestion, tournoi, tournois, lan, management, manager, lan party, tournament, organisation, ladder, ligue, league, coupe, championnat">
<META NAME="OWNER" CONTENT="phpTournois - phpTG4">
<META NAME="AUTHOR" CONTENT="RV, Li0n, Gectou4">
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=ISO-8859-1">
<META HTTP-EQUIV="CONTENT-LANGUAGE" CONTENT="French">
<META NAME="ROBOTS" CONTENT="index,follow">
<META NAME="REVISIT-AFTER" CONTENT="10">
<meta name="copyright" content="(c) phpTournois COPYRIGHT 1999-2005">
<link rel="stylesheet" type="text/css" href="themes/<?php echo $s_theme;?>/styles.css">
<script lang="Javascript" src="include/javascript.inc.js"></script>
<script type="text/javascript" src="include/fckeditor.js"></script>

</head>

<?php
	echo '<body>';
	
if(!isset($autorefresh)) $autorefresh='';
if(!isset($autoscroll)) $autoscroll='';
if(!isset($hidemenu)) $hidemenu='';

echo "<form><input type=\"hidden\" name=\"timer\" value=\"$autorefresh\"><input type=\"hidden\" name=\"scroll\" value=\"$autoscroll\"><input type=\"hidden\" name=\"menu\" value=\"$hidemenu\"></form>";

/*** chargement du theme header ***/
if(isset($header) && $header == 'win')
	theme_header_win();
else {
	theme_header();
}

?>

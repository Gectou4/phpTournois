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

if (preg_match("`footer.inc.php`i", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}

/*** chargement du footer ***/
if(isset($header) && $header == 'win')
	theme_footer_win();
else {
	theme_footer();
}

if($s_joueur == -1) {
	echo '<script lang="Javascript">init_timer();init_scroll();init_menu();refresh_timer();</script>';
}
?>
</body>
</html>
<?php

/*** Benchmark ***/
$time_end = getmicrotime();

if(!isset($header) || $header != 'win') {
	if($config['gzip'] == 1) $gzip_text='GZIP compression ON';
	else $gzip_text='GZIP compression OFF';

	echo '<center><small>';
	/* !!!! INTERDICTION D'ENLEVER LES MARQUES DE COPYRIGHT !!! /// cf LICENCE !!*/
	echo 'Copyright &copy; 2001-2006 by phpTournois. All Rights Reserved. phpTournois is released under the GNU/GPL.<br>
	Copyright &copy; 2005 - 2075 phpTG4 (modded version) by Gectou4<br>';
	/* !!!! INTERDICTION D'ENLEVER LES MARQUES DE COPYRIGHT !!! /// cf LICENCE */
	echo $strPageGeneree.' '.number_format(($time_end - $time_start),3)." $strSecondes :: $gzip_text :: $db->nbquery<br>";
	echo '</small></center><br>';
}
//$db->close();
exit;

<?php
/*
  +---------------------------------------------------------------------+
  |  phpTournois ADDON - module : last 10 player register               |
  +---------------------------------------------------------------------+
  +---------------------------------------------------------------------+
  | phpTournois                                                         |
  | phpTournoisG4 ©2005 by Gectou4 <Gectou4 Gectou4@hotmail.com>        |
  +---------------------------------------------------------------------+
  | Copyright© 2001-2004 Li0n, RV, Gougou (http://www.phptournois.net)|
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
  |          Go???ugou                                                     |
  +---------------------------------------------------------------------+
  +---------------------------------------------------------------------+
  | Page Author : Gectou4  <lle_gardien_prime@hotmail.com>              |
  +---------------------------------------------------------------------+
*/

if (eregi("block_10player.php", $_SERVER['PHP_SELF'])) {
die ("You cannot open this page directly");
}
// HTML EDITED



theme_openblock("<img src=\"themes/$s_theme/images/player.gif\" align=\"absmiddle\" alt=\":)\"> $strLastregistred");
   
if(!isset($start) || !is_numeric($start)) $start=0;    
  

$db->select("*");
$db->from("${dbprefix}joueurs");

$nb_maxx = 10;
$db->where("etat = 'I'");
$db->order_by("id DESC LIMIT $start,$nb_maxx");
$res=$db->exec();
   echo "<ul>";
if ($db->num_rows($res)==0) {
 echo "<li class=\"lib\">$strPasDeJoueur<br>";
}
else {

  while ($ps = $db->fetch($res)) {

   $ps->pseudo=stripslashes($ps->pseudo);
$max = 17; 
   if (strlen($ps->pseudo) >= $max) {
      $ps->pseudo= substr($ps->pseudo, 0, $max); 
      $espace = strrpos($ps->pseudo, " ");    
     $ps->pseudo= substr($ps->pseudo, 0, $espace)."...";
    }
   echo "<li class=\"lib\"><a href=\"?page=joueurs&id=".$ps->id."\">".$ps->pseudo."</a><br>";

  }
  }
  echo "</ul>";


theme_closeblock();
?>
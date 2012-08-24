<?php 
/* 
   +---------------------------------------------------------------------+ 
   | phpTournois                                                         | 
   +---------------------------------------------------------------------+ 
   +---------------------------------------------------------------------+ 
   | phpTournoisG4 ?2005 by Gectou4 <Gectou4 Gectou4@hotmail.com>        | 
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
if (eregi("reglements.php", $_SERVER['PHP_SELF'])) { 
   die ("You cannot open this page directly"); 
} 

/******************************************************** 
 * Affichage normal 
 */ 

 $isntafile_usesql="no"; 
  
if(isset($id) && is_numeric($id) && $id != 0) { 
   $db->select("reglement"); 
   $db->from("${dbprefix}tournois"); 
   $db->where("id = $id"); 
   $res=$db->exec(); 
   $tournois = $db->fetch($res); 
   $reglement=$tournois->reglement; 
    
   echo "<p class=title>.:: $strReglement $nom_tournois ::.</p>"; 
} 
else {    
   if(!$config['reglement']) js_goto('?page=index'); 
   else $reglement=$config['reglement']; 
    
   $isntafile_usesql="no"; 
   echo "<p class=title>.:: $strReglement ::.</p>\n"; 
} 

echo "<table cellspacing=2 cellpadding=2 border=0>"; 
echo "<tr>\n"; 

$reglement=str_replace ( "..", "", $reglement); 
if ($isntafile_usesql=="no" && file_exists("./include/html/reglements/$s_lang/$reglement") && !is_dir("./include/html/reglements/$s_lang/$reglement")) { 
   echo "<td>"; 
   include("include/html/reglements/$s_lang/$reglement"); 
   echo "</td>"; 
} else { 

$reglement = BBCode($reglement); 

if($reglement!=NULL||$reglement!="") { 
   echo "<td>"; 
   echo $reglement; 
   echo "</td>"; 
} else { 
   echo "<td class=title>$strPasDeReglement</td>"; 
} 
} 
echo "</tr>\n";    
echo "</table>"; 

echo "<br><img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>"; 

?>
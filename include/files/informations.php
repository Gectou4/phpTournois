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
if (eregi("informations.php", $_SERVER['PHP_SELF'])) { 
   die ("You cannot open this page directly"); 
} 

/******************************************************** 
 * Affichage normal 
 */ 
 $isntafile_usesql="no"; 
 if($id != null){ 
   $db->select("information"); 
   $db->from("${dbprefix}tournois"); 
   $db->where("id = $id"); 
 }else{ 
   $db->select("information"); 
   $db->from("${dbprefix}config"); 
 } 

   $res=$db->exec(); 
   $infos_sql=$db->fetch($res);    
   $information = $infos_sql->information; 
   echo "<p class=title>.:: $strInformations / $strPresentation ::.</p>"; 

          
echo "<table cellspacing=2 cellpadding=2 border=0>"; 
echo "<tr>"; 
$information=str_replace ( "..", "", $information); 
if ($isntafile_usesql=="no" && file_exists("./include/html/informations/$s_lang/$information") && !is_dir("./include/html/informations/$s_lang/$information")) { 
   echo "<td>"; 
   include("include/html/informations/$s_lang/$information"); 
   echo "</td>"; 
} else { 

$information = BBCode($information); 


if($information!=NULL||$information!="") { 
   echo "<td>"; 
   echo $information; 
   echo "</td>"; 
} 
else { 
   echo "<td class=title>$strPasDInformation</td>"; 
} 
} 
echo "</tr>";    
echo "</table>"; 

echo "<br><img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>"; 
    
?>
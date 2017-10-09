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

if (preg_match("/block_lastresult.php/i", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}

	global $db,$dbprefix,$strNoresultnow,$strlastresult,$s_theme,$strPasDeMatch;


theme_openblock_lastresult("<img src=\"themes/$s_theme/images/icon_resultats.gif\" align=\"absmiddle\" alt=\"enligne\"> $strlastresult");

  $last_finale=0;
  $last_type=0;
  $db->select("id,finale,numero,type,date");
  $db->from("${dbprefix}matchs");
  $db->where("status = 'T'");
  $db->order_by("up DESC LIMIT 5");
  $res = $db->exec();

  if($db->num_rows($res)!=0) {

echo '<table cellspacing="0" cellpadding="0" border="0" width="100%"><tr><td align="center" valign="center">';
$design_lastresult='1';
$design_lastresult_test='0';
   while($match = $db->fetch($res)) {

     $date=strftime(DATESTRING1, $match->date);
    if(!$match->date) $date='';
    else $date="- $date";
    
       
   // echo '<tr>';
    //echo '<td class="info" align="right">';
	if ($design_lastresult==1){
    show_match_lastresult($match->id,$op,'lastnewsheader_a');
	$design_lastresult=2;
	}
	else if ($design_lastresult==2){
    show_match_lastresult($match->id,$op,'lastnewsheader_B');
	$design_lastresult=1;
	}
    //echo '</td>';
    //echo '</tr>';
    $design_lastresult_test++;
   }
    if($design_lastresult_test=='1'){
   echo "<tr><td align=\"center\" style=\"width:100%;height:20px;text-align:center;\" class='lastnewsheader_b'>&nbsp;".$strNoresultnow."</td></tr>";
   echo "<tr><td align=\"center\" style=\"width:100%;height:20px;text-align:center;\" class='lastnewsheader_a'>&nbsp;".$strNoresultnow."</td></tr>";
   echo "<tr><td align=\"center\" style=\"width:100%;height:20px;text-align:center;\" class='lastnewsheader_b'>&nbsp;".$strNoresultnow."</td></tr>";
   echo "<tr><td align=\"center\" style=\"width:100%;height:20px;text-align:center;\" class='lastnewsheader_a'>&nbsp;".$strNoresultnow."</td></tr>";
   } else if($design_lastresult_test=='2') {
   echo "<tr><td align=\"center\" style=\"width:100%;height:20px;text-align:center;\" class='lastnewsheader_a'>&nbsp;".$strNoresultnow."</td></tr>";
   echo "<tr><td align=\"center\" style=\"width:100%;height:20px;text-align:center;\" class='lastnewsheader_b'>&nbsp;".$strNoresultnow."</td></tr>";
   echo "<tr><td align=\"center\" style=\"width:100%;height:20px;text-align:center;\" class='lastnewsheader_a'>&nbsp;".$strNoresultnow."</td></tr>";
   }
    else if($design_lastresult_test=='3') {
   echo "<tr><td align=\"center\" style=\"width:100%;height:20px;text-align:center;\" class='lastnewsheader_b'>&nbsp;".$strNoresultnow."</td></tr>";
   echo "<tr><td align=\"center\" style=\"width:100%;height:20px;text-align:center;\" class='lastnewsheader_a'>&nbsp;".$strNoresultnow."</td></tr>";
   }
    else if($design_lastresult_test=='4') {
   echo "<tr><td align=\"center\" style=\"width:100%;height:20px;text-align:center;\" class='lastnewsheader_a'>&nbsp;".$strNoresultnow."</td></tr>";
   }
   echo '</td></tr></table>';
  }
  else {
   echo '<table cellspacing="0" cellpadding="0" border="0" width="100%">';
   echo "<tr><td align=\"center\" style=\"width:100%;height:20px;text-align:center;\" class='lastnewsheader_a'>&nbsp;".$strPasDeMatch."</td></tr>";
   echo "<tr><td align=\"center\" style=\"width:100%;height:20px;text-align:center;\" class='lastnewsheader_b'>&nbsp;".$strNoresultnow."</td></tr>";
   echo "<tr><td align=\"center\" style=\"width:100%;height:20px;text-align:center;\" class='lastnewsheader_a'>&nbsp;".$strNoresultnow."</td></tr>";
   echo "<tr><td align=\"center\" style=\"width:100%;height:20px;text-align:center;\" class='lastnewsheader_b'>&nbsp;".$strNoresultnow."</td></tr>";
   echo "<tr><td align=\"center\" style=\"width:100%;height:20px;text-align:center;\" class='lastnewsheader_a'>&nbsp;".$strNoresultnow."</td></tr>";
   echo '</table>';

  }
  
  theme_closeblock_lastresult();


?>

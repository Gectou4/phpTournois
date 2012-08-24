<?php
/*
   +---------------------------------------------------------------------+
   | page : popup.php                                                    |
   | phpTournois ADDONS | Module name : "aricles & commandes" V 4.0      |
   | MOD Author : Gectou4 <Gectou4@hotmail.com>                  |
   +---------------------------------------------------------------------+
   +---------------------------------------------------------------------+
   | phpTournois                                                         |
   +---------------------------------------------------------------------+
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
function xhtml_highlight_string($chaine, $lignes=FALSE, $retour=FALSE)
{
   $source = str_replace("</font>", "</span>", str_replace("<font color=\"", "<span style=\"color:", highlight_string($chaine, TRUE)));
   
  
   
   if($lignes)
   {
   	$leslignes = explode("<br />", $source);
   	$no = 1;
   	$source = "";
   	foreach($leslignes as $laligne)
   		$source .= sprintf("<span style=\"color:#666666\">%04d </span>", $no++).$laligne."<br />\n";
   	$source = str_replace("<span style=\"color:#666666\">0001 </span><code>", "<code><span style=\"color:#666666\">0001 </span>", $source);
   }
   if($retour) return $source;
	echo $source;
}



		echo '<table border=0 >';
  		echo '<tr> ';
    	echo '<td bgcolor="#CCFFCC" class=text style="border: 3px dashed"><p>&nbsp;</p>';

		if ($_POST['code']!='') {
echo xhtml_highlight_string($_POST['code'],true,false,false);
} else  {
echo xhtml_highlight_string($_GET['code'],true,false,false);
}


       	echo '</b></p><FORM><p align=center><INPUT TYPE="BUTTON" VALUE="Go back / Retour" ONCLICK="javascript:history.go(-1);" class="input"></p></td>';
   		echo '</tr>';
 		echo '</table>';
			
 ?>

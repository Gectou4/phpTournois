<?php
/*
   +---------------------------------------------------------------------+
   | page : alerte.php                                                   |
   | phpTournois ADDONS | Module name : "aricles & commandes" V 4.0      |
   | MOD Author : Gectou4 <Gectou4@hotmail.com >                 |
   +---------------------------------------------------------------------+
   +---------------------------------------------------------------------+
   | phpTournois                                                         |
   | phpTournoisG4 ©2005 by Gectou4 <Gectou4 Gectou4@hotmail.com>        |
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

 if (eregi("alerte.php", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}

		// MOD COMMANDE //////////////////////////////////////////////////////////////////////////
		 $pseudodrrX=''.nom_joueur($s_joueur).'';
		 $pev='';
		
		$sqln12X = "SELECT article_config FROM ${dbprefix}config"; 
		$reqn12X = mysql_query($sqln12X) or die('Erreur SQL !<br>'.$sqln12X.'<br>'.mysql_error());
		while($datad12X = mysql_fetch_array($reqn12X)) 
   	 				{$ccidX = $datad12X['article_config'];}
	
		$sqlnX = "SELECT * FROM ${dbprefix}article ORDER BY id"; 
		$reqnX = mysql_query($sqlnX) or die('Erreur SQL !<br>'.$sqlnX.'<br>'.mysql_error());
		$iX=0;
		$okX="no";
		while($datadX = mysql_fetch_array($reqnX)) 
   	 				{
					$iX++;
					$didX = $datadX['id'];
					$tcidX = $datadX['cid'];
					$name_articleX = $datadX['article'];
					$pseudo_testX = $datadX['pseudo'];
					$pev = $datadX['pev'];
					if ($tcidX < $ccidX) {$passerX ="o";}
				
					
					if ($pseudo_testX == $pseudodrrX) 
						{
						// article commander payer, arriver
						if($datadX['regle'] == "O" AND $datadX['arrive'] == "O") {if ($datadX['pev']!="a") {$alerteX = "arr";}}
							
						// article commander pas payer, arriver		
						if($datadX['regle'] == "N" AND $datadX['arrive'] == "O") {if ($datadX['pev']!="a") {$alerteX = "arr";}} 	
						}// end if
					
					}//en while 1
					

if ($alerteX=="arr") {?><script>window.open('include/files/popup.php?txt=arrive', 'popup', 'resizable=no, toolbar=no, scrollbars=yes, location=no, width=455, height=250, top=300, left=300')</script><?php }
// MOD COMMANDE ////////////////////////////////////////////////////////////////////////// 
?>
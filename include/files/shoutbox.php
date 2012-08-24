<?php
/*
   +---------------------------------------------------------------------+
   | page : shoutbox                                                     |
   | MOD Author : Gectou4 <Gectou4 Gectou4@hotmail.com>                |
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
   +---------------------------------------------------------------------|
   | Authors: Li0n  <li0n@phptournois.net>                               |
   |          RV <rv@phptournois.net>                                    |
   |          Gougou                                                     |
   +---------------------------------------------------------------------+
*/
/********************************************************
 * S&eacute;curit&eacute;
 */

/********************************************************
 * global
 */
 global $config,$s_joueur,$s_theme,$db,$dbprefix,$db,$dbprefix,$strAjouter;
 	  

/********************************************************
 * Ajout d'un commentaire
 */

if($op == "addshout") {

	/*** verification securite ***/
	if($s_joueur=="" || $s_joueur==NULL) js_goto('?page=login');


	if(!$contenu) {
		js_goto("?page=index");		
	}
		
		$date=time();
		$contenu = remove_XSS($contenu);
		$pseudo=nom_joueur($s_joueur);
		$sqladd = "INSERT INTO ${dbprefix}shoutbox(id,pseudo,date,contenu) Values('','$pseudo','$date','$contenu')"; 
		$reqadd = mysql_query($sqladd) or die('Erreur SQL !<br>'.$sqladd.'<br>'.mysql_error());
		
			if ($a=="o") {js_goto("?page=shoutbox&op=archive");
			}
			else {
			js_goto("?page=index");
			}


}

 /********************************************************
 * Del d'un commentaire
 */
if($op == "del") {

	/*** verification securite ***/
	if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['m']!='m') {js_goto($PHP_SELF);} 

		$sqldel = "DELETE FROM `${dbprefix}shoutbox` WHERE id='$id'";
		$reqdel = mysql_query($sqldel) or die('Erreur SQL !<br>'.$sqldel.'<br>'.mysql_error());
		//if a==o
		js_goto("?page=shoutbox&op=archive");
}

		

/********************************************************
 * Archive
 */
 
 if($op == "archive") {
 
 			$db->select("count(id)");
			$db->from("${dbprefix}shoutbox");
			$res=$db->exec();
			$row = mysql_fetch_row($res);
			$ptotal = $row[0];
			
			if ($ptotal==''||$ptotal==NULL||$nptotal=="0") {$ptotal="1";}
			
			if($nbcom!=""||$nbcom!=NULL) {
			$shoutlimit2=$nbcom;
			}
			else {
			$shoutlimit2="20";
			}
			if ($ptotal/$shoutlimit2>intval($ptotal/$shoutlimit2)) {
			$nbshoutpage = intval($ptotal/$shoutlimit2)+1;
			}
			elseif ($ptotal/$shoutlimit2<=intval($ptotal/$shoutlimit2)){
			$nbshoutpage = (intval($ptotal/$shoutlimit2));
			}
			
			if ($nbshoutboxpage==''||$nbshoutboxpage==NULL||$nbshoutboxpage=='0') {$nbshoutboxpage=1;}
			
 
 			echo "<form method=post name=\"formuadd\" action=?page=shoutbox&op=archive>";
 			echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2 width=80%><tr><td>";
			echo "<table cellspacing=1 cellpadding=0 border=0 width=100%><tr><td>";
			echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
			echo "<tr><td class=headerfiche>";
			
			echo "$shoutoption";
			echo "</td></tr>";
			echo "<tr><td class=textfiche>";
			
			echo "$strShoutNbpage <select name=nbshoutboxpage>";
			echo "<option value=\"".$nbshoutboxpage."\" >".$nbshoutboxpage."</option>";
			
			for($nbspage="1"; $nbspage<=$nbshoutpage; $nbspage++)
			{
			echo "<option value=\"".$nbspage."\" >".$nbspage."</option>";
			}
			
			echo "</select>";
			echo " $strAvec ";
			echo "<select name=nbcom>";
			echo "<option value=\"".$shoutlimit2."\" >".$shoutlimit2."</option>";
			echo "<option value=\"10\" >10</option>";
			echo "<option value=\"20\" >20</option>";
			echo "<option value=\"30\" >30</option>";
			echo "<option value=\"40\" >40</option>";
			echo "<option value=\"50\" >50</option>";
			echo "<option value=\"60\" >60</option>";
			echo "<option value=\"70\" >70</option>";
			echo "<option value=\"80\" >80</option>";
			echo "<option value=\"90\" >90</option>";
			echo "<option value=\"100\" >100</option>";
			echo "</select> $strShoutNbcom ";

			
			if ($desc=="O") {$desc2="$strCroissant";
			}
			elseif ($desc=="N") {$desc2="$strDeroissant";
			}
			elseif ($desc==''||$desc==NULL) {$desc2="$strCroissant";$desc="O";}
			
			echo "$strShoutdesc <select name=desc>";
			echo "<option value=\"".$desc."\" >".$desc2."</option>";
			echo "<option value=\"O\" >$strCroissant</option>";
			echo "<option value=\"N\" >$strDecroissant</option>";
			echo "</select>";
			echo "</td></tr><tr><td class=footerfiche><input type=submit value=\"$strOK\">";
			
			echo "</td></tr></table>";
			echo "</td></tr></table>";
			echo "</td></tr></table>";
			echo "</form>";			
 
 			echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2 width=80%><tr><td>";
			echo "<table cellspacing=1 cellpadding=0 border=0 width=100%><tr><td>";
			echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
			
					if($s_joueur!="" || $s_joueur!=NULL){
				if($config['shoutboxc']!=""||$config['shoutboxc']!=NULL) {
			$shoutlimitc=$config['shoutboxc'];
			}
			else {
			$shoutlimitc='';
			}
			echo "<form method=post name=\"formu\" action=?page=shoutbox&op=addshout&a=o>";
			echo "<tr>";
			echo "<td class=textfiche align=center><input type=text name=contenu size=70 maxlength=".$shoutlimitc.">";
			echo "<input type=submit value=\"$strAjouter\">";
			echo "</td></tr>";		
			echo "</form>";
			
			
					
	}
			
			if ($desc=="O") {$desc="DESC";}
			else {$desc="";}
			$nbshoutboxpage2=($nbshoutboxpage*$shoutlimit2)-$shoutlimit2;
			$sqlx = "SELECT * FROM ${dbprefix}shoutbox ORDER BY id ".$desc." LIMIT $nbshoutboxpage2,$shoutlimit2"; 
			$reqx = mysql_query($sqlx) or die('Erreur SQL !<br>'.$sqlx.'<br>'.mysql_error());
			
				
				
			$i2='1';
			while($datax = mysql_fetch_array($reqx)) 
   	 			{
				$contenu=$datax['contenu'];
				if(!preg_match("#^(http\\:\\/\\/[a-z0-9\-]+\.([a-z0-9\-]+\.)?[a-z]+)#i", $contenu)) {
				if(!preg_match('#\[url=(http://)?(.*?)\](.*?)\[/url\]#si', $contenu)){
				if(!preg_match('#\[url\](http://)?(.*?)\[/url\]#si', $contenu)) {
				$contenu=wordwrap($contenu, 100, "<br>", 1);
				}
				}
				}
				$contenu=BBcode($contenu);
				$contenu=stripslashes($contenu);
				$date=strftime("%H:%M", $datax['date']);
				
					if ($i2=="1") {
						echo "<tr>";
						echo "<td class=shoutfiche>";
						
						if ($grade['a']=='a'||$grade['b']=='b'||$grade['m']=='m') {
						echo "<a href=\"?page=shoutbox&op=del&a=o&id=".$datax['id']."\"><img src='images/f.gif' border='0' align=RIGHT /></a>";
						}
						
						echo "($date) <a href=\"?page=joueurs&id=".id_joueur($datax['pseudo'])."\"><b><font class=shoutpseudo>".$datax['pseudo']."</font></b></a> :<br>$contenu</td>";
					    echo "</tr>";
						$i2++;
					}
				
		
					else if ($i2=="2") {
						echo "<tr>";
					echo "<td class=shout2fiche>";
					
					if ($grade['a']=='a'||$grade['b']=='b'||$grade['m']=='m')  {
					echo "<a href=\"?page=shoutbox&op=del&a=o&id=".$datax['id']."\"><img src='images/f.gif' border='0' align=RIGHT /></a>";
					}
					
					echo "($date)<a href=\"?page=joueurs&id=".id_joueur($datax['pseudo'])."\"><b><font class=shoutpseudo>".$datax['pseudo']."</font></b></a> :<br>$contenu</td>";
					
					$i2="1";
					echo "</tr>";
					}
				}
		
/********************************************************
 * Es-tu joueur ?
 */	



			echo "</td></tr></table>";
			echo "</td></tr></table>";
			echo "</td></tr></table>";

	
			echo "<form method=post name=\"formuadd\" action=?page=shoutbox&op=archive>";
 			echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2 width=80%><tr><td>";
			echo "<table cellspacing=1 cellpadding=0 border=0 width=100%><tr><td>";
			echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
			echo "<tr><td class=headerfiche>";
			
			echo "$shoutoption";
			echo "</td></tr><tr><td class=textfiche>";
			
			echo "$strShoutNbpage <select name=nbshoutboxpage>";
			echo "<option value=\"".$nbshoutboxpage."\" >".$nbshoutboxpage."</option>";
			
			for($nbspage=1; $nbspage<=$nbshoutpage; $nbspage++)
			{
			echo "<option value=\"".$nbpage."\" >".$nbpage."</option>";
			}
			
			echo "</select>";
			echo " $strAvec ";
			echo "<select name=nbcom>";
			echo "<option value=\"".$shoutlimit2."\" >".$shoutlimit2."</option>";
			echo "<option value=\"10\" >10</option>";
			echo "<option value=\"20\" >20</option>";
			echo "<option value=\"30\" >30</option>";
			echo "<option value=\"40\" >40</option>";
			echo "<option value=\"50\" >50</option>";
			echo "<option value=\"60\" >60</option>";
			echo "<option value=\"70\" >70</option>";
			echo "<option value=\"80\" >80</option>";
			echo "<option value=\"90\" >90</option>";
			echo "<option value=\"100\" >100</option>";
			echo "</select> $strShoutNbcom ";

			
			if ($desc=="O") {$desc2="$strCroissant";
			}
			elseif ($desc=="N") {$desc2="$strDeroissant";
			}
			elseif ($desc==''||$desc==NULL) {$desc2="$strCroissant";$desc="O";}
			
			echo "$strShoutdesc <select name=desc>";
			echo "<option value=\"".$desc."\" >".$desc2."</option>";
			echo "<option value=\"O\" >$strCroissant</option>";
			echo "<option value=\"N\" >$strDecroissant</option>";
			echo "</select>";
			echo "<tr><td class=footerfiche align=center><input type=submit value=\"$strOK\">";
			
			echo "</td></tr></table>";
			echo "</td></tr></table>";
			echo "</td></tr></table>";
			echo "</form>";		
 
 }	
 
?>

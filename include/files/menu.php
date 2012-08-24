<?php
/*
   +---------------------------------------------------------------------+
   | Addon By Gectou4 le_gardien_prime@hotmail.com                       |
   +---------------------------------------------------------------------+
   +---------------------------------------------------------------------+
   | phpTournois                                                         |
   +---------------------------------------------------------------------+
   | phpTournoisG4 ©2005 by Gectou4 <Gectou4 Gectou4@hotmail.com>        |
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
   |          RV <rv@phptournois.net>                            
    |          Gougou                                                     |
   +---------------------------------------------------------------------+
*/
/********************************************************
 * S&eacute;curit&eacute;
 */
 
if (eregi("menu", $_SERVER['PHP_SELF'])) {
	die ("Si vous voulez je peut aussi mettre en log votre IP et porter plainte...");
}

/********************************************************
 * global
 */

 	  global $config,$s_joueur,$s_theme,$db,$dbprefix,$db,$dbprefix;
 	  

/********************************************************
 * Ajout d'un Menu
 */
if($op == "addmenu") {

	/*** verification securite ***/
	if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['g']!='g') {js_goto('?page=login');} 

	$str='';
	$erreur=0;
	
	if(!$titre) {
		$erreur=1;
		$str.="- ".$strElementsTitreInvalide."<br>";		
	}
	if(!is_numeric($orde)) {
		$erreur=1;
		$str.="- ".$strElementsOrdeInvalide."<br>";		
	}
	if($erreur==1) {		
		show_erreur_saisie($str);			
	}
	else {	
		
		/*$db->insert("menu (titre,align");
		$db->values("'$titre','$align'");
		$db->exec();
		*/
		$sqladd = "INSERT INTO ${dbprefix}menu(id,titre,align,orde) Values('','$titre','$align','orde')"; 
		$reqadd = mysql_query($sqladd) or die('Erreur SQL !<br>'.$sqladd.'<br>'.mysql_error());
		
		/*** redirection ***/
		js_goto("?page=index");
	}

}

 /********************************************************
 * Del d'une page
 */
if($op == "delmenu") {

	/*** verification securite ***/
	if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['g']!='g') {js_goto('?page=login');}

		$sqldel = "DELETE FROM `${dbprefix}menu` WHERE id='$id'";
		$reqdel = mysql_query($sqldel) or die('Erreur SQL !<br>'.$sqldel.'<br>'.mysql_error());
		
		/*** redirection ***/
		js_goto("?page=index");
	
}
/********************************************************
 * Modif d'un menu 
 */	
if($op == "modmenu") {

	/*** verification securite ***/
    if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['g']!='g') {js_goto('?page=login');}

	$str='';
	$erreur=0;
	
	if(!$titre) {
		$erreur=1;
		$str.="- ".$strElementsTitreInvalide."<br>";		
	}
	if(!is_numeric($orde)) {
		$erreur=1;
		$str.="- ".$strElementsOrdeInvalide."<br>";		
	}
	if($erreur==1) {		
		show_erreur_saisie($str);			
	}
	else {	
		
		$sqldel = "UPDATE `${dbprefix}menu` SET titre = '$titre', align = '$align', orde = '$orde' WHERE id = $id";
		$reqdel = mysql_query($sqldel) or die('Erreur SQL !<br>'.$sqldel.'<br>'.mysql_error());
		
		/*$db->update("menu");
		$db->set("titre = '$titre'");
		$db->set("align = '$align'");
		$db->where("id = $id");
		$db->exec();*/
		
			/*** redirection ***/
		js_goto("?page=menu&op=modif&id=$id&titre=$titre");
	}
	

}	  	  
/********************************************************
 * Ajout d'un menu 
 */
if ($_GET['op']=="add"){	
	  
	if ($grade['a']=='a'||$grade['b']=='b'||$grade['g']=='g') {
			
			echo "<br><a href='?page=menu&op=list'><font size=2><img src='images/edit.gif' border=0 /> $strModifierMenus</font></a><br><br>"; 
			echo "<form method=post name=\"formulaire\" action=?page=menu&op=addmenu>";
			echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
			echo "<table cellspacing=1 cellpadding=0 border=0>";
			echo "<tr><td class=headerfiche>$strAjouterMenu</td></tr>";
			echo "<tr><td>";
			echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
			echo "<tr>";
			echo "<td class=titlefiche>$strTitre :</td>";
			echo "<td class=textfiche><input type=text name=titre maxlength=40 size=40></td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td class=titlefiche>$strOrdre :</td>";
			echo "<td class=textfiche><input type=text name=orde maxlength=2 size=2></td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td class=titlefiche>$strAlign :</td>";
			echo "<td class=textfiche><select name=align><option value=\"G\">$strGauche</option>";
			echo "<option value=\"D\">$strDroite</option>";
			echo "<option value=\"H\">$strHide</option>";
			echo "</select>";
			echo "</td></tr>";
			echo "<tr>";
			echo "<tr><td class=footerfiche colspan=2 align=center><input type=submit value=\"$strAjouter\"></td></tr>";
			echo "</table>";
			echo "</td></tr></table>";
			echo "</td></tr></table>";		
			echo "</form>";
	
	}
}				
/********************************************************
 * MODIF d'un menu
 */
if ($_GET['op']=="modif"){	
	  
	if ($grade['a']=='a'||$grade['b']=='b'||$grade['g']=='g') {
	
		$titre=$_GET['titre'];
		if ($id==''||$id==NULL) $id=$_GET['id'];
		
		$sql = "SELECT * FROM ${dbprefix}menu WHERE id='$id'"; 
  		$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());	
		
		while($data = mysql_fetch_array($req)) 
   	 			{
	
			echo "<form method=post name=\"formulaire\" action=?page=menu&op=modmenu&id=".$data['id'].">";
			echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
			echo "<table cellspacing=1 cellpadding=0 border=0>";
			echo "<tr><td class=headerfiche>$strModifierMenu</td></tr>";
			echo "<tr><td>";
			echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";	
			echo "<tr>";
			echo "<td class=titlefiche>$strTitre :</td>";
			echo "<td class=textfiche><input type=text name=titre maxlength=40 size=40 value=".$data['titre']."></td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td class=titlefiche>$strOrdre :</td>";
			echo "<td class=textfiche><input type=text name=orde maxlength=2 size=2 value=".$data['orde']."></td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td class=titlefiche>$strAlign :</td>";
			if ($data['align']=="G") {$align="$strGauche";}
			if ($data['align']=="D") {$align="$strDroite";}
			if ($data['align']=="H") {$align="$strHide";}
			echo "<td class=textfiche><select name=align><option value=\"".$data['align']."\">".$align."</option>";
			echo "<option value=\"G\">$strGauche</option>";
			echo "<option value=\"D\">$strDroite</option>";
			echo "<option value=\"H\">$strHide</option>";
			echo "</select>";
			echo "</td></tr>";
			echo "<tr>";
			echo "<tr><td class=footerfiche colspan=2 align=center><input type=submit value=\"$strModifier\"></td></tr>";
			echo "</table>";
			echo "</td></tr></table>";
			echo "</td></tr></table>";				
			echo "</form>";
		
			}	
	
	}
}				
/********************************************************
 * List pour modif d'un menu
 */
if ($_GET['op']=="list"){	
	  
	if ($grade['a']=='a'||$grade['b']=='b'||$grade['g']=='g') {
	
			echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
			echo "<table cellspacing=1 cellpadding=0 border=0>";
			echo "<tr><td class=headerfiche>&nbsp;&nbsp;&nbsp; $strModifierMenu &nbsp;&nbsp;&nbsp;</td></tr>";
			echo "<tr><td>";
			echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
			
			$sqlx = "SELECT id,titre FROM ${dbprefix}menu GROUP BY titre"; 
			$reqx = mysql_query($sqlx) or die('Erreur SQL !<br>'.$sqlx.'<br>'.mysql_error());
			
			$i2='1';
			$notlist='N';
			
			while($datax = mysql_fetch_array($reqx)) 
   	 			{
				if ($i2=="1") {echo "<tr>";$notlist='O';}
				$i2++;
				echo "<td class=textfiche align='center'><li class=\"lib\"><a href=\"?page=menu&op=modif&id=".$datax['id']."\">".$datax['titre']."</a><a href=\"?page=menu&op=delmenu&id=".$datax['id']."\"><img src='images/f.gif' border='0' /></a><br></td>";
				if ($i2=="5") {echo "</tr>";$i2="1";}
				}
			if ($notlist=='N') {
			echo "<td class=textfiche align='center'>&nbsp; $strPageNotlist2 &nbsp;</td>";
			}
				
			echo "</table>";
			echo "</td></tr></table>";
			echo "</td></tr></table>";		
						
	
	}
}	


?>

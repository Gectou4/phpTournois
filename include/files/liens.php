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
if (preg_match("/liens.php/i", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}

if(!$config['liens']) js_goto('?page=index');

/********************************************************
 * ajout d'un lien
 */
if ($op=='add') {
	
	/*** verification securite globale ***/
		if($op == 'admin') {if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['h']!='h') {js_goto($PHP_SELF);} }

	$str='';
	$erreur=0;	

	if(!$nom) {
		$erreur=1;
		$str.="- $strElementsNomInvalide<br>";
	}
	if(!$description) {
		$erreur=1;
		$str.="- $strElementsDescriptionInvalide<br>";
	}
	if(!$url || $url=='http://') {
		$erreur=1;
		$str.="- $strElementsUrlInvalide<br>";
	}	

	if($erreur==1) {		
		show_erreur_saisie($str);		
	}
	else {

		$db->insert("${dbprefix}liens (nom, url, description, image, categorie,date)");
		$db->values("'$nom','$url','$description','$image','$categorie','".time()."'");
		$db->exec();

		js_goto("?page=liens&op=admin");
	}
}

/********************************************************
 * suppression d'un lien
 */
elseif ($op=="delete") {
			
	/*** verification securite globale ***/
		if($op == 'admin') {if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['j']!='j') {js_goto($PHP_SELF);} }

	$db->delete("${dbprefix}liens");
	$db->where("id = $id");
	$db->exec();		

	js_goto("?page=liens&op=admin");	
}

/********************************************************
 * activation du lien
 */
elseif($op=="visit") {

	$db->select("*");
	$db->from("${dbprefix}liens");
	$db->where("id = $id");
	$res=$db->exec();
	$link = $db->fetch($res);

	$db->update("${dbprefix}liens");
	$db->set("hits=hits+1");
	$db->where("id = $id ");
	$db->exec();

	header("Location: $link->url");
	die();

}
/********************************************************
 * Modification d'un lien
 */
elseif($op == "modify") {

	/*** verification securite globale ***/
		if($op == 'admin') {if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['j']!='j') {js_goto($PHP_SELF);} }

	$db->select("*");
	$db->from("${dbprefix}liens");	
	$db->where("id = '$id'");
	$res=$db->exec();
	$link = $db->fetch($res);

	echo "<p class=title>.:: $strAdminLiens ::.</p>";

	echo "<form method=post action=?page=liens&op=do_modify>";
	echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
	echo "<table cellspacing=1 cellpadding=0 border=0>";
	echo "<tr><td class=headerfiche>$strModifierLiens</td></tr>";
	echo "<tr><td>";
	echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
	echo "<tr>";
	echo "<td class=titlefiche>$strNom <font color=red><b>*</b></font> :</td>";
	echo "<td class=textfiche><input type=text name=nom size=30 value=\"".stripslashes($link->nom)."\"></td>";
	echo "</tr>";
	echo "<tr>";	
	echo "<td class=titlefiche>$strUrl <font color=red><b>*</b></font> :</td>";
	echo "<td class=textfiche><input type=text name=url size=60 value=\"$link->url\"></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class=titlefiche>$strDescription <font color=red><b>*</b></font> :</td>";
	echo "<td class=textfiche><textarea name=description ID=description cols=\"50\" rows=\"4\">".stripslashes($link->description)."</textarea></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class=titlefiche>$strCategorie :</td>";
	echo "<td class=textfiche><input type=text name=categorie size=20 value=\"".stripslashes($link->categorie)."\"></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class=titlefiche>$strImage :</td>";
	echo "<td class=textfiche>";
	echo "<select name=image>";
	echo "<option>";
	$fd = opendir("images/liens");

	while($file = readdir($fd)) {
		if ($file != "." && $file != "..") {
			echo "<option value=\"$file\"";
			if($link->image==$file) echo " SELECTED";
			echo ">$file";
		}
	}
	echo "</select>";
	closedir($fd);	
	echo "</td>";
	echo "</tr>";		
	echo "<tr><td class=footerfiche colspan=2 align=center><input type=submit value=\"$strModifier\">&nbsp;<input type=button value=\"$strRetour\" onclick=\"document.location='?page=liens&op=admin'\"></td></tr>";
	echo "</table>";
	echo "</td></tr></table>";
	echo "<input type=hidden name=id value='$id'>";
	echo "</td></tr></form></table>";
	
}
/********************************************************
 * Modification d'un partenaire
 */
elseif($op == "do_modify") {

	/*** verification securite globale ***/
		if($op == 'admin') {if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['j']!='j') {js_goto($PHP_SELF);} }

	$str='';
	$erreur=0;

	if(!$nom) {
		$erreur=1;
		$str.="- $strElementsNomInvalide<br>";
	}
	if(!$description) {
		$erreur=1;
		$str.="- $strElementsDescriptionInvalide<br>";
	}
	if(!$url || $url=='http://') {
		$erreur=1;
		$str.="- $strElementsUrlInvalide<br>";
	}

	if($erreur==1) {
		show_erreur_saisie($str);
	}
	else {

		$db->update("${dbprefix}liens");
		$db->set("nom = '$nom'");
		$db->set("url = '$url'");
		$db->set("description = '$description'");
		$db->set("categorie = '$categorie'");
		$db->set("image = '$image'");
		$db->where("id = '$id'");
		$db->exec();

		js_goto("?page=liens&op=admin");
	}
}
/********************************************************
 * Affichage admin
 */
elseif($op == "admin") {

	/*** verification securite globale ***/
		if($op == 'admin') {if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['j']!='j') {js_goto($PHP_SELF);} }

	echo "<p class=title>.:: $strAdminLiens ::.</p>";

	echo "<table cellspacing=0 cellpadding=2 border=0>";
	echo "<tr><td class=title>". nb_liens() ." $strLiens</td></tr>";
	echo "</table>";

	$db->select("*");
	$db->from("${dbprefix}liens");
	$db->order_by("categorie,nom");
	$res=$db->exec();

	if ($db->num_rows($res)!=0) {

		echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
		echo "<table cellspacing=1 cellpadding=2 border=0>";
		echo "<tr><td class=header>$strCategorie</td><td class=header>$strNom</td><td class=header>$strHits</td><td class=header>$strUrl</td><td class=header>$strImage</td></tr>";

		while ($link = $db->fetch($res)) {
			$cat = stripslashes($link->categorie);
			echo "<tr>";
			echo "<td class=text align=center>$cat</td>";
			echo "<td class=text>";
			echo "<div style=\"clear: both\"><div style=\"float: left\"><a href=?page=liens&id=$link->id><b>".stripslashes($link->nom)."</b></a></div>";
			echo "<div style=\"float: right\">&nbsp;<a href=\"?page=liens&op=modify&id=$link->id\">[$strE]</a> <a href=?page=liens&op=delete&id=$link->id onclick=\"return confirm('$strConfirmEffacerLien');\">[$strS]</a></div>";
			echo "</div></td>";
			echo "<td class=text align=center><b>$link->hits</b></td>";
			echo "<td class=text><a target=_blank href=\"$link->url\">$link->url</a></td>";
			echo "<td class=text align=center>"; if($link->image) echo "<img src=\"images/liens/$link->image\" align=absmiddle height=20>";echo "</td>";
			echo "</tr>";

		}
		echo "</table>";
		echo "</td></tr></table>";

	}

	/*** ajouter un lien ***/
	echo "<br>";
	echo "<form method=post action=?page=liens&op=add>";
	echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
	echo "<table cellspacing=1 cellpadding=0 border=0>";
	echo "<tr><td class=headerfiche>$strAjouterLien</td></tr>";
	echo "<tr><td>";
	echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
	echo "<tr>";
	echo "<td class=titlefiche>$strNom <font color=red><b>*</b></font> :</td>";
	echo "<td class=textfiche><input type=text name=nom size=30></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class=titlefiche>$strUrl <font color=red><b>*</b></font> :</td>";
	echo "<td class=textfiche><input type=text name=url size=50 value=\"http://\"></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class=titlefiche>$strDescription <font color=red><b>*</b></font> :</td>";
	echo "<td class=textfiche><textarea name=description ID=description cols=\"50\" rows=\"4\"></textarea></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class=titlefiche>$strCategorie :</td>";
	echo "<td class=textfiche><input type=text name=categorie size=20></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class=titlefiche>$strImage :</td>";
	echo "<td class=textfiche>";
	echo "<select name=image>";
	echo "<option>";
	$fd = opendir("images/liens");

	while($file = readdir($fd)) {
		if ($file != "." && $file != "..") {
			echo "<option value=\"$file\">$file";
		}
	}
	echo "</select>";
	closedir($fd);
	echo "</td>";
	echo "</tr>";
	echo "<tr><td class=footerfiche align=center colspan=2><input type=submit value=\"$strAjouter\"></td></tr>";
	echo "</table>";
	echo "</td></tr></form></table>";
	echo "</td></tr></table>";

	show_consignes($strAdminLiensConsignes);

	echo "<br><img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";

}
/********************************************************
 * Affichage normal 
 */
else {

	echo "<p class=title>.:: $strLiens ::.</p>";

	if(!isset($cat)) $cat='';
	
	$db->select("categorie,count(id) as nb");
	$db->from("${dbprefix}liens");
	$db->group_by("categorie");
	$db->order_by("categorie");
	$res=$db->exec();
	
	while($cats = $db->fetch($res)) {
		$tab_cats[]=$cats;
	}
		
	if(count($tab_cats)>1 || (count($tab_cats)==1 && !empty($tab_cats[0]->categorie))) {
	
		echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1 width=80%><tr><td>";
		echo "<table cellspacing=1 cellpadding=0 border=0 width=100%>";
		echo "<tr><td class=titlecategorie align=center>$strCategories :<br>";
		echo "<table cellspacing=0 cellpadding=10 border=0>";

		for($i=0;$i<count($tab_cats);$i++) {
			$nomcat= stripslashes($tab_cats[$i]->categorie);	
			if($nomcat=="") $nomcat="$strSans";
			
			if($i%$config['col_categories'] == 0) echo "<tr>";
			
			echo "<td height=100% align=left class=categorie>";
			if($tab_cats[$i]->categorie!=$cat) 		
				echo "<img border=0 src=\"images/dir.gif\" title=\"$nomcat\" align=absmiddle> <a href=\"?page=liens&cat=".$tab_cats[$i]->categorie."\">$nomcat</a> (".$tab_cats[$i]->nb.")";
			else 
				echo "<img border=0 src=\"images/dir_o.gif\" title=\"$nomcat\" align=absmiddle> <b>$nomcat</b> (".$tab_cats[$i]->nb.")";
			echo "</td>";
	
			if($i%$config['col_categories'] == $config['col_categories']-1) echo "</tr>";
		}
		echo "</table></td></tr></table></td></tr></table>";
	}				
			
	$db->select("*");
	$db->from("${dbprefix}liens");
	$db->where("categorie = '$cat'");
	$db->order_by("nom");
	$res=$db->exec();

	if ($db->num_rows($res)!=0) {

		echo "<table align=center border=0 cellspacing=0 cellpadding=0>";

		while ($link = $db->fetch($res)) {
			
			echo "<tr><td>";			
			echo "<table cellspacing=0 cellpadding=2 border=0 width=500><tr>";
			echo "<td valign=top><a href=\"?page=liens&op=visit&id=$link->id\" target='_blank'><img src=images/lien.gif align=absmiddle border=0></a></td>";
			echo "<td class=text2 width=100% align=left><a href=\"?page=liens&op=visit&id=$link->id\" target='_blank'><b>".stripslashes($link->nom)."</b></a>";
			echo "<br>";

			if($link->description)
				echo "<i>$strDescription</i> : ".nl2br(stripslashes($link->description))."<br>";

			if($link->hits>=0)
				echo "<i>$strHits</i> : <b>$link->hits</b><br>";
			
			$date=strftime(DATESTRING2, $link->date);
			echo "<i>$strAjouteLe</i> : $date ";
			if($link->date  > time()-(3*24*3600)) echo "<img src=\"images/new_3day.gif\" border=0 align=align=absmiddle>";
			elseif($link->date  > time()-(7*24*3600)) echo "<img src=\"images/new_week.gif\" border=0 align=align=absmiddle>";
			elseif($link->date  > time()-(21*24*3600)) echo "<img src=\"images/new_3week.gif\" border=0 align=align=absmiddle>";
			echo "<br>";
			
			echo "</td>";	
			if($link->image) echo "<td valign=top><a href=\"?page=liens&op=visit&id=$link->id\" target='_blank'><img src=\"images/liens/$link->image\" align=absmiddle border=0></a></td>";
			echo "</tr></table>";

			echo "</td><tr>";

		}
		echo "</table>";
	}
	else {
		echo "<table cellspacing=2 cellpadding=2 border=0>";
		echo "<tr><td class=title>$strPasDeLien</td></tr>";
		echo "</table>";
	}

	echo "<br><img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";

}

?>


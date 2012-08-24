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
if (eregi("download.php", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}

if(!$config['download']) js_goto('?page=index');

/********************************************************
 * ajout d'un fichier
 */
if ($op=='add') {
	
	/*** verification securite globale ***/
	if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['d']!='d') {js_goto($PHP_SELF);} 
	//verif_admin_general($s_joueur);

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
	if(!$taille) {
		$erreur=1;
		$str.="- $strElementsTailleInvalide<br>";
	}

	if($erreur==1) {	
		show_erreur_saisie($str);	
	}
	else {

		$db->insert("${dbprefix}download (nom, url, taille, description, categorie, date)");
		$db->values("'$nom', '$url', '$taille', '$description', '$categorie', '".time()."'");
		$db->exec();

		js_goto("?page=download&op=admin");
	}
}

/********************************************************
 * suppression d'un fichier
 */
elseif ($op=="delete") {
			
	/*** verification securite globale ***/
	//verif_admin_general($s_joueur);
	if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['d']!='d') {js_goto($PHP_SELF);} 
		
	$db->delete("${dbprefix}download");
	$db->where("id = $id");
	$db->exec();		

	js_goto("?page=download&op=admin");
	
}

/********************************************************
 * activation du DL
 */
elseif($op=="get") {
	
	$db->select("*");
	$db->from("${dbprefix}download");
	$db->where("id = $id");
	$res=$db->exec();
	$file = $db->fetch($res);
		
	$db->update("${dbprefix}download");
	$db->set("hits=hits+1");
	$db->where("id = $id ");
	$db->exec();
		
	header("Location: $file->url");
	die();
	
}
/********************************************************
 * Modification d'un download
 */
elseif($op == "modify") {

	/*** verification securite globale ***/
	//verif_admin_general($s_joueur);
	if ($grade['a']!='a' && $grade['b']!='b' && $grade['d']!='d') {js_goto($PHP_SELF);} 
	
	$db->select("*");
	$db->from("${dbprefix}download");	
	$db->where("id = '$id'");
	$res=$db->exec();
	$download = $db->fetch($res);
	
	echo "<p class=title>.:: $strAdminDownloads ::.</p>";
	
	echo "<form method=post action=?page=download&op=do_modify>";
	echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
	echo "<table cellspacing=1 cellpadding=0 border=0>";			
	echo "<tr><td class=headerfiche>$strModifierDownload</td></tr>";
	echo "<tr><td>";
	echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
	echo "<tr>";
	echo "<td class=titlefiche>$strNom <font color=red><b>*</b></font> :</td>";
	echo "<td class=textfiche><input type=text name=nom size=30 value=\"".stripslashes($download->nom)."\"></td>";
	echo "</tr>";
	echo "<tr>";	
	echo "<td class=titlefiche>$strUrl <font color=red><b>*</b></font> :</td>";
	echo "<td class=textfiche><input type=text name=url size=60 value=\"$download->url\"></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class=titlefiche>$strTaille <font color=red><b>*</b></font> :</td>";
	echo "<td class=textfiche><input type=text name=taille size=10 value=\"$download->taille\"> ($strOctets)</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class=titlefiche>$strDescription <font color=red><b>*</b></font> :</td>";
	echo "<td class=textfiche><textarea name=description cols=\"50\" rows=\"4\">".stripslashes($download->description)."</textarea></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class=titlefiche>$strCategorie :</td>";
	echo "<td class=textfiche><input type=text name=categorie size=20 value=\"".stripslashes($download->categorie)."\"></td>";
	echo "</tr>";
	echo "<tr><td class=footerfiche colspan=2 align=center><input type=submit value=\"$strModifier\">&nbsp;<input type=button value=\"$strRetour\" onclick=\"document.location='?page=download&op=admin'\"></td></tr>";
	echo "</table>";
	echo "</td></tr></table>";
	echo "<input type=hidden name=id value='$id'>";
	echo "</td></tr></form></table>";

}

/********************************************************
 * Modification d'un download
 */
elseif($op == "do_modify") {

	/*** verification securite globale ***/
	//verif_admin_general($s_joueur);
	if ($grade['a']!='a' && $grade['b']!='b' && $grade['d']!='d') {js_goto($PHP_SELF);} 
	
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
	if(!$taille) {
		$erreur=1;
		$str.="- $strElementsTailleInvalide<br>";
	}

	if($erreur==1) {		
		show_erreur_saisie($str);		
	}
	else {

		$db->update("${dbprefix}download");
		$db->set("nom = '$nom'");
		$db->set("url = '$url'");
		$db->set("taille = '$taille'");
		$db->set("description = '$description'");
		$db->set("categorie = '$categorie'");
		$db->where("id = '$id'");
		$db->exec();	

		js_goto("?page=download&op=admin");
	}
}
/********************************************************
 * Affichage admin
 */
elseif($op == "admin") {

	/*** verification securite globale ***/
	//verif_admin_general($s_joueur);
	if ($grade['a']!='a' && $grade['b']!='b' && $grade['d']!='d') {js_goto($PHP_SELF);} 
	

	echo "<p class=title>.:: $strAdminDownloads ::.</p>";

	$db->select("*");
	$db->from("${dbprefix}download");
	$db->order_by("categorie, nom");
	$res=$db->exec();

	if($db->num_rows($res)!=0) {

		echo "<table cellspacing=0 cellpadding=2 border=0>";
		echo "<tr><td class=title>". nb_downloads() ." $strDownloads</td></tr>";
		echo "</table>";

		echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
		echo "<table cellspacing=1 cellpadding=2 border=0>";
		echo "<tr><td class=header>$strCategorie</td><td class=header>$strNom</td><td class=header>$strTaille</td><td class=header>$strHits</td><td class=header>$strUrl</td></tr>";

		while ($download = $db->fetch($res)) {
			$cat = stripslashes($download->categorie);
			echo "<tr>";
			echo "<td class=text align=center>$cat</td>";
			echo "<td class=text>";
			echo "<div style=\"clear: both\"><div style=\"float: left\"><a href=?page=download&id=$download->id><b>".stripslashes($download->nom)."</b></a></div>";
			echo "<div style=\"float: right\">&nbsp;<a href=\"?page=download&op=modify&id=$download->id\">[$strE]</a> <a href=?page=download&op=delete&id=$download->id onclick=\"return confirm('$strConfirmEffacerDownload');\">[$strS]</a></div>";
			echo "</div></td>";
			echo "<td class=text align=center>".coolsize($download->taille)."</td>";
			echo "<td class=text align=center><b>$download->hits</b></td>";
			echo "<td class=text><a target=_blank href=\"$download->url\">$download->url</a></td>";

			echo "</tr>";

		}
		echo "</table>";
		echo "</td></tr></table>";
	}
	else {
		echo "<table cellspacing=2 cellpadding=2 border=0>";
		echo "<tr><td class=title>$strPasDeDownload</td></tr>";
		echo "</table>";
	}


	/*** ajouter un download ***/
	echo "<br>";
	echo "<form method=post action=?page=download&op=add>";
	echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
	echo "<table cellspacing=1 cellpadding=0 border=0>";
	echo "<tr><td class=headerfiche>$strAjouterFichier</td></tr>";
	echo "<tr><td>";
	echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
	echo "<tr>";
	echo "<td class=titlefiche>$strNom <font color=red><b>*</b></font> :</td>";
	echo "<td class=textfiche><input type=text name=nom size=30></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class=titlefiche>$strUrl <font color=red><b>*</b></font> :</td>";
	echo "<td class=textfiche><input type=text name=url size=60 value=\"http://\"></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class=titlefiche>$strTaille <font color=red><b>*</b></font> :</td>";
	echo "<td class=textfiche><input type=text name=taille size=10> ($strOctets)</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class=titlefiche>$strDescription <font color=red><b>*</b></font> :</td>";
	echo "<td class=textfiche><textarea name=description cols=\"50\" rows=\"4\"></textarea></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class=titlefiche>$strCategorie :</td>";
	echo "<td class=textfiche><input type=text name=categorie size=20></td>";
	echo "</tr>";
	echo "<tr><td class=footerfiche align=center colspan=2><input type=submit value=\"$strAjouter\"></td></tr>";
	echo "</table>";
	echo "</td></tr></table>";
	echo "</td></tr></form></table>";

	echo "<br><img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";


}
/********************************************************
 * Affichage normal 
 */
else {
	
	echo "<p class=title>.:: $strDownloads ::.</p>";

	if(!isset($cat)) $cat='';

	$db->select("categorie,count(id) as nb");
	$db->from("${dbprefix}download");
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
			if($tab_cats[$i]->categorie != $cat)
				echo "<img border=0 src=\"images/dir.gif\" title=\"$nomcat\" align=absmiddle> <a href=\"?page=download&cat=".$tab_cats[$i]->categorie."\">$nomcat</a> (".$tab_cats[$i]->nb.")";
			else
				echo "<img border=0 src=\"images/dir_o.gif\" title=\"$nomcat\" align=absmiddle> <b>$nomcat</b> (".$tab_cats[$i]->nb.")";
			echo "</td>";
	
			if($i%$config['col_categories'] == $config['col_categories']-1) echo "</tr>";
		}
		echo "</table></td></tr></table></td></tr></table>";
	}
								
		
	$db->select("*");
	$db->from("${dbprefix}download");
	$db->where("categorie = '$cat'");
	$db->order_by("nom");
	$res=$db->exec();
	
	if ($db->num_rows($res)!=0) {

		echo "<table align=center border=0 cellspacing=0 cellpadding=0>"; 		
	
		while ($file = $db->fetch($res)) {
								
			echo "<tr><td>";				
			echo "<table cellspacing=0 cellpadding=2 border=0 width=500><tr>";
			echo "<td valign=top><a href=\"?page=download&op=get&id=$file->id\" target='_blank'><img src=images/download.gif align=absmiddle border=0></a></td>";
			echo "<td class=text2 width=100%><a href=\"?page=download&op=get&id=$file->id\" target='_blank'><b>".stripslashes($file->nom)."</b></a>";
			echo "<br>";
	
			if($file->description)
				echo "<i>$strDescription</i> : ".nl2br(stripslashes($file->description))."<br>";
				
			if($file->taille>=0)
				echo "<i>$strTaille</i> : ".CoolSize($file->taille)."<br>";
			
			if($file->hits>=0)
				echo "<i>$strHits</i> : <b>$file->hits</b><br>";
				
			$date=strftime(DATESTRING2, $file->date);
			echo "<i>$strAjouteLe</i> : $date ";
			if($file->date > time()-(3*24*3600)) echo "<img src=\"images/new_3day.gif\" border=0 align=align=absmiddle>";
			elseif($file->date > time()-(7*24*3600)) echo "<img src=\"images/new_week.gif\" border=0 align=align=absmiddle>";
			elseif($file->date > time()-(21*24*3600)) echo "<img src=\"images/new_3week.gif\" border=0 align=align=absmiddle>";
			echo "<br>";
				
			echo "</td>";
			echo "</tr></table>";

			echo "</td><tr>";
			
		}
		echo "</table>";
	}
	else {
		echo "<table cellspacing=2 cellpadding=2 border=0>";
		echo "<tr><td class=title>$strPasDeDownload</td></tr>";
		echo "</table>";
	}
	

	echo "<br><img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";

}

?>


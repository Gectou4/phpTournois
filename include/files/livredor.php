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

if (eregi("livredor.php", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}

if(!$config['livredor']) js_goto('?page=index');

/********************************************************
 * Ajout d'une signature
 */
if($op == "add") {

	$str='';
	$erreur=0;

	if(!$auteur) {
		$erreur=1;
		$str.="- $strElementsAuteurInvalide<br>";
	}
	if(!$contenu) {
		$erreur=1;
		$str.="- $strElementsContenuInvalide<br>";
	}

	if($erreur==1) {		
		show_erreur_saisie($str);	
	}
	else {
		if(is_flood('livredor')) {
			show_erreur($strFloodDetect);
		}
		else {
			$date=time();
			$auteur = remove_XSS($auteur);
			$contenu = remove_XSS($contenu);
	
			$db->insert("${dbprefix}livredor (auteur,contenu,date)");
			$db->values("'$auteur','$contenu','$date'");
			$db->exec();
	
			/*** redirection ***/
			js_goto("?page=livredor&id=$id");
		}
	}
}
/********************************************************
 * Effacement d'une signature
 */
elseif($op == "delete") {

	/*** verification securite ***/
		if($op == 'admin') {if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['i']!='i') {js_goto($PHP_SELF);} }

	if(is_numeric($id)) {

		$db->delete("${dbprefix}livredor");
		$db->where("id = $id");
		$db->exec();
	}

	/*** redirection ***/
	js_goto("?page=livredor&op=admin");

}
/********************************************************
 * Affichage normal + admin
 */
 else {

	/*** verification securite ***/
		if($op == 'admin') {if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['i']!='i') {js_goto($PHP_SELF);} }

	if($op=='admin') echo "<p class=title>.:: $strAdminLivreDor ::.</p>";
	else echo "<p class=title>.:: $strLivreDor ::.</p>";

	if($op) $str_op="&op=$op";
	else $str_op="";

	if(!isset($start) || !is_numeric($start)) $start=0;

	$nb_max=$config['nb_livredor_max'];
	$nb_total=nb_livredor();

	/*** liste des toutes les signatures ***/
	$db->select("*");
	$db->from("${dbprefix}livredor");
	$db->order_by("id ASC LIMIT $start,$nb_max");
	$res=$db->exec();

	if ($db->num_rows($res)!=0) {

		echo "<table align=center width=400 border=0 cellspacing=0 cellpadding=0>";
		echo "<tr><td>";

		$nbSignatures=0;
		while ($signature = $db->fetch($res)) {
			$nbSignatures ++;
			$date=strftime(DATESTRING1, $signature->date);
			$date = "$strLe ".$date;
			$contenu=BBcode($signature->contenu);

			echo "<table width=400 border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
			echo "<table width=100% border=0 cellspacing=1 cellpadding=2>";
			echo "<tr>";
			echo "<td class=text><div style=\"clear: both\"><div style=\"float: left\">#".$nbSignatures." - $strPostePar <b>".stripslashes($signature->auteur)."</b> ".$date."</div>";
			if($op=='admin')
				echo "<div style=\"float: right\">&nbsp;<a href=?page=livredor&op=delete&id=".$signature->id." onclick=\"return confirm('$strConfirmEffacerSignature');\">[$strS]</a></div>";
			echo "</div></td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td class=text>".stripslashes($contenu)."<br><br></td>";
			echo "</tr>";
			echo "</table>";
			echo "</td></tr></table>";
		}
		

		echo "<table cellspacing=0 cellpadding=0 border=0 align=center>";
		echo "<tr><td class=text2>".navigateur($start,$nb_max,$nb_total,"?page=livredor$str_op&start=%d")."</td></tr>";
		echo "</table><br>";			
						
		echo "</td></tr></table>";
	}
	else {
		echo "<table cellspacing=0 cellpadding=0 border=0>";
		echo "<tr><td class=title>$strPasDeSignature</td></tr>";
		echo "</table><br>";
	}

	/*** poster un commentaire ***/
	if($op!='admin') {
		echo "<form method=post name=\"formulaire\" action=?page=livredor&op=add>";
		echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
		echo "<table cellspacing=1 cellpadding=0 border=0>";
		echo "<tr><td class=headerfiche>$strAjouterSignature</td></tr>";
		echo "<tr><td>";
		echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
		if(!empty($s_joueur)) {
			$auteur=joueur($s_joueur);
			echo "<input type=hidden name=auteur value='$auteur->pseudo'>";
		}
		else {
			echo "<tr>";
			echo "<td class=titlefiche>$strPseudo :</td>";
			echo "<td class=textfiche><input type=text name=auteur maxlength=20></td>";
			echo "</tr>";
		}
		echo "<tr>";
		echo "<td class=textfiche colspan=2 align=center>";buttonBB('contenu');echo "</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class=titlefiche>$strSignature :</td>";
		echo "<td class=textfiche><textarea cols=50 rows=6 ID=contenu name=contenu wrap=virtual ONSELECT=\"storeCaret(this);\" ONCLICK=\"storeCaret(this);\" ONKEYUP=\"storeCaret(this);\"></textarea></td>";
		echo "</tr>";
		echo "<tr><td class=footerfiche colspan=2 align=center><input type=submit value=\"$strAjouter\"></td></tr>";
		echo "</table>";
		echo "</td></tr></table>";
		echo "</td></tr></table>";
		echo "</form>";
	}

	echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";

 }

?>

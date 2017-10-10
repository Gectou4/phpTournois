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
// code from Lille-eurolan
if (preg_match("/sponsors.php/", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}

if (!$config['sponsors'] && $op != "admin" && $grade['a'] != 'a' && $grade['b'] != 'b' && $grade['s'] != 's' ) js_goto('?page=index');

/********************************************************
 * Affichage de la page iframe
 */
if($op == "show") {
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript">
function disableselect(e)
{
	return false
}

function reEnable()
{
	return true
}

document.onselectstart=new Function ("return false")

if (window.sidebar)
{
	document.onmousedown=disableselect
	document.onclick=reEnable
}
</SCRIPT>
</head>
<body onmouseover="stop_scroll()" onmouseout="start_scroll()" bgcolor="#FFFFFF">
<div id="content_area" style="position:absolute; width:110px; top:0px; left:0px; clip:rect(0 110 400 0);"></div>

<script type="text/javascript">
var g_asponsors = new Array();
<?php

$db->select("*");
$db->from("${dbprefix}sponsors");
$db->order_by("rang");
$sponsors=$db->exec();


if ($db->num_rows($sponsors) != 0) {
	$str='';
	echo "var g_asponsors = new Array(";

	while ($sponsor = $db->fetch($sponsors)) {

		$img="images/sponsors/$sponsor->image";
		$str.= "new Array('$sponsor->nom','$img','?page=sponsors&id=$sponsor->id'),";

	}
	$str[strlen($str)-1]=' ';
	echo $str;
	echo ");";
}

?>
var g_ilayer_width = 0;
var g_bscroll = false;
var g_oimgs = new Array();
var g_iprogress_index = 0;

function ver_scroll(p_idirection, p_ispeed, p_iloop)
{
	var opage = document.getElementById("content_area").style;

	if (-parseInt(opage.top) >= g_ilayer_width)
	{
		opage.top = parseInt(opage.top) + g_ilayer_width;
	}

	opage.top = parseInt(opage.top) + p_idirection;
	opage.clip = "rect(" + (-parseInt(opage.top)) + " 110 " + (400 - parseInt(opage.top)) + " 0)";
	g_oscroll_timer = setTimeout("ver_scroll(" + p_idirection + "," + p_ispeed + "," + p_iloop + ")", p_ispeed);
}

function stop_scroll()
{
	if (g_bscroll)
	{
		clearTimeout(g_oscroll_timer);
	}
}

function start_scroll()
{
	if (g_bscroll)
	{
		g_oscroll_timer = setTimeout("ver_scroll(-2,75,1)", 100);
	}
}

function check_load(p_iindex, p_itry)
{
	p_itry++;
	(p_itry > 10 || g_oimgs[p_iindex].complete) ? progress() : setTimeout("check_load(" + p_iindex + "," + p_itry + ")", 100);
}

function progress()
{
	g_iprogress_index++;

	if (g_iprogress_index == g_asponsors.length)
	{
		create_scroll();
	}
}

function preload()
{
	var iindex = 0;

	while (iindex < g_asponsors.length)
	{
		g_oimgs[iindex] = new Image();
		g_oimgs[iindex].src = g_asponsors[iindex][1];
		check_load(iindex, 0)
		iindex++;
	}
}

function create_scroll()
{
	var smsg = '<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">';
	var iindex = 0;

	while (iindex < g_asponsors.length)
	{
		var oimg = new Image();
		var simg_width = "";

		oimg.src = g_asponsors[iindex][1];


		if (oimg.width > 110)
		{
			simg_width += 'width="100" '
		}

		smsg += '<TR><TD height="15"></TD></TR>';
		smsg += '<TR><TD valign=middle align=center height=80><A target="_parent" href="'+ g_asponsors[iindex][2] + '"><IMG border=0 ' + simg_width + ' src="' + g_asponsors[iindex][1] + '" title="' + g_asponsors[iindex][0] + '"></A></TD></TR>';
		iindex++;
	}

	smsg += "</TABLE>";

	document.getElementById("content_area").innerHTML = smsg;
	var oframe = document.getElementById("content_area");
	/*
	if(navigator.appName.substring(0,3) == "Net")
	{
		oframe = document.documentElement;
	}*/

	g_ilayer_width = oframe.scrollHeight;

	if (g_ilayer_width > 200)
	{
		smsg += smsg;
		document.getElementById("content_area").innerHTML = smsg;
		g_bscroll = true;		
		start_scroll();
	}
}

preload();
</SCRIPT>
</body>
</html>
<?php
}
/********************************************************
 * ajout d'un sponsor
 */
elseif ($op=='add') {
	
	/*** verification securite globale ***/
	if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['s']!='s') {js_goto($PHP_SELF);} 

	$str='';
	$erreur=0;

	if(!$nom) {
		$erreur=1;
		$str.="- $strElementsNomInvalide<br>";
	}	
	if(!$image) {
		$erreur=1;
		$str.="- $strElementsImageInvalide<br>";
	}
	if(!$url || $url=='http://') {
		$erreur=1;
		$str.="- $strElementsUrlInvalide<br>";
	}	

	if($erreur==1) {
		show_erreur_saisie($str);		
	}
	else {
		$nom = remove_XSS($nom);
		$contenu = remove_XSS($contenu);

		$db->insert("${dbprefix}sponsors (nom, url, image, rang, description)");
		$db->values("'$nom', '$url', '$image', '$rang', '$contenu'");
		$db->exec();

		js_goto("?page=sponsors&op=admin");
	}
}

/********************************************************
 * suppression d'un sponso
 */
elseif ($op=="delete") {
			
	/*** verification securite globale ***/
	if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['s']!='s') {js_goto($PHP_SELF);} 

	$db->delete("${dbprefix}sponsors");
	$db->where("id = $id");
	$db->exec();

	js_goto("?page=sponsors&op=admin");
	
}

/********************************************************
 * Modification d'un sponsors
 */
elseif($op == "modify") {

	/*** verification securite globale ***/
	if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['s']!='s') {js_goto($PHP_SELF);} 

	$db->select("*");
	$db->from("${dbprefix}sponsors");
	$db->where("id = '$id'");
	$res=$db->exec();
	$sponsor = $db->fetch($res);	

	echo "<p class=title>.:: $strAdminSponsors ::.</p>";

	echo "<form method=post name=\"formulaire\" action=?page=sponsors&op=do_modify>";
	echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
	echo "<table cellspacing=1 cellpadding=0 border=0>";
	echo "<tr><td class=headerfiche>$strModifierSponsors</td></tr>";
	echo "<tr><td>";
	echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
	echo "<td class=titlefiche>$strNom <font color=red><b>*</b></font> :</td>";
	echo "<td class=textfiche><input type=text name=nom size=30 value='".stripslashes($sponsor->nom)."'></td>";
	echo "</tr>";
	echo "<tr>";	
	echo "<td class=titlefiche>$strUrl <font color=red><b>*</b></font> :</td>";
	echo "<td class=textfiche><input type=text name=url size=50 value=\"$sponsor->url\"></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class=titlefiche>$strImage <font color=red><b>*</b></font> :</td>";
	echo "<td class=textfiche>";
	echo "<select name=image>";
	$fd = opendir("images/sponsors");
	while($file = readdir($fd)) {
		if ($file != "." && $file != "..") {	
			echo "<option value=\"$file\"";
			if($sponsor->image=="$file") echo " selected";			
			echo ">$file";
		}
	}
	echo "</select>";
	closedir($fd);	
	echo "</td>";
	echo "</tr>";	
	echo "<tr>";
	echo "<td class=titlefiche>$strRang :</td>";
	echo "<td class=textfiche><input type=rang name=rang size=5 value=\"$sponsor->rang\"></td></td>";
	echo "</tr>";	
	echo "<tr>";
	echo "<td class=textfiche colspan=2 align=center>";buttonBB('contenu');echo "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class=titlefiche>$strDescription :</td>";
	echo "<td class=textfiche><textarea cols=80 rows=10 name=contenu ID=contenu wrap=virtual ONSELECT=\"storeCaret(this);\" ONCLICK=\"storeCaret(this);\" ONKEYUP=\"storeCaret(this);\">".stripslashes($sponsor->description)."</textarea></td>";
	echo "</tr>";
	echo "<tr><td class=footerfiche colspan=2 align=center><input type=submit value=\"$strModifier\">&nbsp;<input type=button value=\"$strRetour\" onclick=\"document.location='?page=sponsors&op=admin'\"></td></tr>";
	echo "</table>";
	echo "</td></tr></table>";
	echo "</td></tr></table>";
	echo "<input type=hidden name=id value='$id'>";
	echo "</form>";
}

/********************************************************
 * Modification d'un sponsor
 */
elseif($op == "do_modify") {

	/*** verification securite globale ***/
	if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['s']!='s') {js_goto($PHP_SELF);} 
	
	$str='';
	$erreur=0;
		
	if(!$nom) {
		$erreur=1;
		$str.="- $strElementsNomInvalide<br>";
	}	
	if(!$image) {
		$erreur=1;
		$str.="- $strElementsImageInvalide<br>";
	}
	if(!$url || $url=='http://') {
		$erreur=1;
		$str.="- $strElementsUrlInvalide<br>";
	}
	
	if($erreur==1) {			
		show_erreur_saisie($str);	
	}
	else {

		$nom = remove_XSS($nom);
		$contenu = remove_XSS($contenu);

		$db->update("${dbprefix}sponsors");
		$db->set("nom = '$nom'");
		$db->set("description = '$contenu'");
		$db->set("image = '$image'");
		$db->set("url = '$url'");
		$db->set("rang = '$rang'");
		$db->where("id = '$id'");
		$db->exec();

		/*** redirection ***/
		js_goto("?page=sponsors&op=admin");
	}
}


/********************************************************
 * Affichage admin
 */
elseif($op=='admin') {

	/*** verification securite ***/
	if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['s']!='s') {js_goto($PHP_SELF);} 

	echo "<p class=title>.:: $strAdminSponsors ::.</p>";

	echo "<table cellspacing=0 cellpadding=2 border=0>";
	echo "<tr><td class=title>". nb_sponsors() ." $strSponsors</td></tr>";
	echo "</table>";

	$db->select("*");
	$db->from("${dbprefix}sponsors");
	$db->order_by("rang");
	$sponsors = $db->exec();

	if ($db->num_rows($sponsors)!=0) {

		echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
		echo "<table cellspacing=1 cellpadding=2 border=0>";
		echo "<tr><td class=header>$strRang</td><td class=header>$strNom</td><td class=header>$strUrl</td><td class=header>$strImage</td></tr>";

		while($sponsor = $db->fetch($sponsors)) {
			echo "<tr>";
			echo "<td class=text align=center>$sponsor->rang</td>";
			echo "<td class=text>";
			echo "<div style=\"clear: both\"><div style=\"float: left\"><a href=?page=sponsors&id=$sponsor->id>".stripslashes($sponsor->nom)."</a></div>";
			echo "<div style=\"float: right\">&nbsp;<a href=\"?page=sponsors&op=modify&id=$sponsor->id\">[$strE]</a> <a href=?page=sponsors&op=delete&id=$sponsor->id onclick=\"return confirm('$strConfirmEffacerSponsor');\">[$strS]</a></div>";
			echo "</div></td>";
			echo "<td class=text><a href=\"$sponsor->url\">$sponsor->url</a></td>";
			echo "<td class=text align=center><img src=\"images/sponsors/$sponsor->image\" align=absmiddle height=20></td>";
			echo "</tr>";
		}
		echo "</table>";
		echo "</td></tr></table>";
	}
	
	/*** ajout d'un sponsor ***/
	echo "<br>";
	echo "<form name=formulaire method=post action=?page=sponsors&op=add>";
	echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
	echo "<table cellspacing=1 cellpadding=0 border=0>";			
	echo "<tr><td class=headerfiche>$strAjouterSponsor</td></tr>";
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
	echo "<td class=titlefiche>$strImage <font color=red><b>*</b></font> :</td>";
	echo "<td class=textfiche>";
	echo "<select name=image>";
	$fd = opendir("images/sponsors");
	while($file = readdir($fd)) {
		if ($file != "." && $file != "..") {			
			echo "<option value=\"$file\">$file";
		}
	}
	echo "</select>";
	closedir($fd);	
	echo "</td>";
	echo "</tr>";	
	echo "<tr>";
	echo "<td class=titlefiche>$strRang :</td>";
	echo "<td class=textfiche><input type=rang name=rang size=5></td></td>";
	echo "</tr>";	
	echo "<tr>";
	echo "<td class=textfiche colspan=2 align=center>";buttonBB('contenu');echo "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class=titlefiche>$strDescription :</td>";
	echo "<td class=textfiche><textarea cols=50 rows=6 name=contenu ID=contenu wrap=virtual ONSELECT=\"storeCaret(this);\" ONCLICK=\"storeCaret(this);\" ONKEYUP=\"storeCaret(this);\"></textarea></td>";
	echo "</tr>";
	echo "<tr><td class=footerfiche align=center colspan=2><input type=submit value=\"$strAjouter\"></td></tr>";
	echo "</table>";
	echo "</td></tr></table>";
	echo "</td></tr></form></table>";

	show_consignes($strAdminSponsorsConsignes);

	echo "<br><img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";

}
/********************************************************
 * Affichage normal
 */
else {
	
	/*** liste des tous les  sponsors  ***/
	if(empty($id)) {
		
		echo "<p class=title>.:: $strSponsors ::.</p>";
		
		$db->select("*");
		$db->from("${dbprefix}sponsors");
		$db->order_by("rang");
		$sponsors=$db->exec();

		if ($db->num_rows($sponsors)==0) {
			echo "<table cellspacing=2 cellpadding=2 border=0>";
			echo "<tr><td class=title>$strPasDeSponsor</td></tr>";
			echo "</table>";
		}
		else {

			while($sponsor = $db->fetch($sponsors)) {
				$tab_sponsors[]=$sponsor;
			}
		
			echo "<table cellspacing=0 cellpadding=0 border=0 class=liste><tr valign=top><td>";
			echo "<table cellspacing=10 cellpadding=2 border=0>";

			for($i=0;$i<count($tab_sponsors);$i++) {
				if($i%$config['col_sponsors'] == 0) echo "<tr>";

				$sponsor->nom=stripslashes($tab_sponsors[$i]->nom);
				echo "<td height=100% align=center>";
				echo "<table cellspacing=0 cellpadding=0 border=0 height=100% >";
				echo "<tr>";
				echo "<td class=text2 align=center height=100%><a href=\"?page=sponsors&id=".$tab_sponsors[$i]->id."\"><img border=0 src=\"images/sponsors/".$tab_sponsors[$i]->image."\" title=\"".$tab_sponsors[$i]->nom."\"></a></td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td class=text2 valign=bottom align=center><li class=lib><b>$sponsor->nom</b><br>";
				echo "</td>";
				echo "</tr></table>";
				echo "</td>";

   				if($i%$config['col_sponsors'] == $config['col_sponsors']-1) echo "</tr>";
			}
			echo "</table></td></tr></table>";
		}
	}
	else {

		$db->select("*");
		$db->from("${dbprefix}sponsors");
		$db->where("id = '$id'");
		$res=$db->exec();
		$sponsor=$db->fetch($res);	
		
		echo "<p class=title>.:: $strSponsor $sponsor->nom ::.</p>";
		
		if($db->num_rows($res)!=0) {
			$sponsor->nom=stripslashes($sponsor->nom);
			$description=BBcode($sponsor->description);
			$description=stripslashes($description);

			echo "<table cellspacing=2 cellpadding=2 border=0>";
			echo "<tr><td class=text2 align=center><a target=\"_blank\" href=\"$sponsor->url\"><img border=0 src=\"images/sponsors/$sponsor->image\" title=\"$sponsor->nom\"></a></td></tr>";
			echo "<tr><td class=text2 align=center>$description</td></tr>";
			echo "<tr><td class=text2 align=center><br><br><li class=lib><a target=\"_blank\" href=\"$sponsor->url\">$sponsor->url</a></td></tr>";
			echo "</table>";
		}
	}

	echo "<br><img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";

}


?>

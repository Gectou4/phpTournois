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
// MatchBrowser par JPinchaud - j_pinchaud@yahoo.fr

if (eregi("matchs_browser.php", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}

$config['download_path'] = "matchs";
$config['download_max_filesize'] = 2000000;

/*** upload des fichier ***/
$matchobj=match($match);
$upload=0;

$modefichier_tournois=modefichier_tournois($matchobj->tournois);
$modeequipe_tournois=modeequipe_tournois($matchobj->tournois);

if($modefichier_tournois!='N' && ($grade['a']=='a'||$grade['b']=='b'||$grade['t']=='t'||$grade['u']=='u')) {
	$upload=1;
}
elseif($modefichier_tournois=='C' && $modeequipe_tournois=='E' && (equipe_manager($matchobj->equipe1,$s_joueur) || equipe_manager($matchobj->equipe2,$s_joueur)) && $s_joueur) {
	$upload=1;
}
elseif($modefichier_tournois=='C' && $modeequipe_tournois=='J' && ($matchobj->equipe1==$s_joueur || $matchobj->equipe2==$s_joueur) && $s_joueur) {
	$upload=1;
}
elseif($modefichier_tournois=='N') js_goto("?page=index");


$directory=str_replace( array("..","//"), "", $directory);
$match=str_replace( array("..","//"), "", $match);


function create_dirs($matchs) {
	global $config;
	
	@mkdir($config['download_path']."/".$matchs);
	@mkdir($config['download_path']."/"."$matchs/replays");
	@mkdir($config['download_path']."/"."$matchs/screenshots");
	@mkdir($config['download_path']."/"."$matchs/reports");
}
////////////////////////////////////////////////////////////////////////////////
// dossier = fichier sans point

function p_is_file($file_name){
	$pt = strrpos($file_name, ".");
	if ($pt == FALSE)
		$is_file = FALSE;
	else
		$is_file = TRUE;
	return($is_file);
}

////////////////////////////////////////////////////////////////////////////////
// last ou milieu $i est-il le dernier

function p_is_last($i, $j){
	$j--;
	if ($i <= $j)
		$is_last = FALSE;
	else
		$is_last = TRUE;
	return($is_last);
}

////////////////////////////////////////////////////////////////////////////////
// level

function p_level($file_name, $level, $directory){
	global $config,$match;
		
	$dir_level= $config['download_path']."/$match/";
	
	$i = 1;
	$j = $level;
	$arr_dir = explode ("/",$directory);	
	$cur_dir = $dir_level.$directory;
	$images='';
			
	while ($i <= $level){
		
		$dir_level .= $arr_dir[$i-1] . "/";
				
		$nb_dir = get_nb_all($dir_level);
		$handle=opendir($dir_level);
		$dirlist="";
		while ($dir = readdir($handle)) {
			if (!p_is_file($dir) && $dir != "." && $dir != "..") {
				$dirlist[] = $dir;    
			}   	
		}
		closedir($handle);       
	    if($dirlist) sort($dirlist);
	
		for($d=0;$d<count($dirlist);$d++) {
			$dir=$dirlist[$d];						
			$dirlast=0;				
			if($dir==$arr_dir[$i]) $dirlast=1;						 	
		}

		if(get_nb_file($dir_level)==0 && $dirlast==1) {
			$images .= "<img src=\"images/browser/b_vert_null.gif\" width=\"15\" height=\"20\" align=\"absmiddle\" border=\"0\">";
		}
		else {
			$images .= "<img src=\"images/browser/b_vert.gif\" width=\"15\" height=\"20\" align=\"absmiddle\" border=\"0\">";
		}
		
		$i++;
		$j--;
	}

	return($images.$file_name);
}

////////////////////////////////////////////////////////////////////////////////
// type fichier

function get_type($file){
	$pt = strrpos($file, ".");
	if ($pt != FALSE){
		$file_ext = substr($file, $pt + 1, strlen($file) - $pt - 1);
		switch ($file_ext){
			case "gif": $image = "images/browser/i_gif.gif";
		break;
			case "htm": $image = "images/browser/i_htm.gif";
		break;
			case "html": $image = "images/browser/i_htm.gif";
		break; 
			case "bmp": $image = "images/browser/i_img.gif";
		break;
			case "jpg": $image = "images/browser/i_jpg.gif";
		break;
			case "mp3": $image = "images/browser/i_mp3.gif";
		break;
			case "exe": $image = "images/browser/i_pgm.gif";
		break;
			case "txt": $image = "images/browser/i_txt.gif";
		break;
			case "wav": $image = "images/browser/i_wav.gif";
		break;
			case "zip": $image = "images/browser/i_zip.gif";
		break;
			case "dem": $image = "images/browser/i_demo.gif";
		break;
			default: $image = "images/browser/i_other.gif";
		break;
		}
		$img_size = GetImageSize($image);
		$img_size_wh = $img_size[3];
		$image = "<img src=\"$image\" $img_size_wh align=\"absmiddle\" border=\"0\" alt=\"$file\">";
		return($image);
	}
}

////////////////////////////////////////////////////////////////////////////////
// nb dir and file

function get_nb_all($directory){
	$handle=opendir($directory);
	$nb_all = 0;
	while ($file = readdir($handle)){
		if ($file != "." && $file != "..") {
			$nb_all++;
		}
	}
	closedir($handle);
	return($nb_all);
}

////////////////////////////////////////////////////////////////////////////////
// nb file

function get_nb_file($directory){
	$handle=opendir($directory);	
	$nb_file = 0;
	while ($file = readdir($handle)){
		if ($file != "." && $file != "..") {
			if (p_is_file($file))
				$nb_file++;
		}
	}
	closedir($handle);
	return($nb_file);
}

////////////////////////////////////////////////////////////////////////////////
// get dir

function p_get_dir($match,$directory,$level,$dir_no){	
	global $config;

	$cur_dir=$config['download_path']."/$match/$directory";
	$line_dir=array();

	//$arr_dir = explode ("/",$cur_dir);
	$nb_dir = get_nb_all($cur_dir);
	$i = 0;
	$handle=opendir($cur_dir);
	while ($file = readdir($handle)) {
		$filelist[] = $file;
	}
	closedir($handle);
    if($filelist) sort($filelist);


	
	for($f=0;$f<count($filelist);$f++) {
		$file=$filelist[$f];
				
		if ($file != "." && $file != ".."){
			if (!p_is_file($file)){
				$i++;
				$file_name = $file;
				$new_dir = $directory . $file_name . "/";
				if (p_is_last($i,$nb_dir))
					if ($file_name == $dir_no)
						$image="<img src=\"images/browser/b_last_dir_open.gif\" width=\"15\" height=\"20\" align=\"absmiddle\" border=\"0\">";
					else
						$image="<img src=\"images/browser/b_last_dir_closed.gif\" width=\"15\" height=\"20\" align=\"absmiddle\" border=\"0\">";
				else
					if ($file_name == $dir_no)
						$image="<img src=\"images/browser/b_dir_open.gif\" width=\"15\" height=\"20\" align=\"absmiddle\" border=\"0\">";
					else
						$image="<img src=\"images/browser/b_dir_closed.gif\" width=\"15\" height=\"20\" align=\"absmiddle\" border=\"0\">";
			
				$image = p_level($image,$level,$directory);
				$line_dir[$level].= "
					  <tr align=\"left\" valign=\"middle\"> 
					    <td valign=\"middle\" colspan=\"3\"><a href=\"?page=matchs_browser&match=$match&directory=$directory&header=win\">$image</a><font face=\"Verdana, Arial, Helvetica, sans-serif\" size=\"2\"><a href=\"?page=matchs_browser&match=$match&directory=$new_dir&header=win\"><img src=\"images/browser/i_dir.gif\" width=\"15\" height=\"13\" align=\"absmiddle\" border=\"0\"></a>&nbsp;<a href=\"?page=matchs_browser&match=$match&directory=$new_dir&header=win\">$file_name</a></font></td>
					  </tr>
				";
			} 
		}
		if ($file == $dir_no){
			$line_dir[$level].= "x?x?x" . $level . "x?x?x";
		}
	}	
	return($line_dir);
}

////////////////////////////////////////////////////////////////////////////////
// get file

function p_get_file($match,$directory,$level){
	// $directory = str_replace (" ", "%20", $directory);
	global $config,$strS,$strConfirmEffacerFile,$s_joueur;

	$cur_dir=$config['download_path']."/$match/$directory";
	$line_file=array();

	$cur_dir=str_replace ( "//", "/", $cur_dir);
	$nb_file = get_nb_file($cur_dir);
	$i = 0;
	$handle=opendir($cur_dir);
	while ($file = readdir($handle)) {
		if ($file != "." && $file != "..") { 		// Que des fichiers
			$filelist[] = $file;
       	}
	}
	closedir($handle);       
    if($filelist) sort($filelist);

	for($f=0;$f<count($filelist);$f++) {
		$file=$filelist[$f];
		
		if (p_is_file($file)){
			$i++;
			$file_name = $file;
			$file_path = $cur_dir . $file;
			$file_size = filesize($file_path);
			$file_size = CoolSize($file_size);

			if (p_is_last($i,$nb_file))
				$image_l="images/browser/b_vert_last_file.gif";
			else
				$image_l="images/browser/b_vert_file.gif";

			$image = get_type($file_name);

			$b_vert = "";
			$b_vert = p_level($b_vert, $level, $directory);
				
			$line_file[$level].= "
				  <tr align=\"left\" valign=\"middle\">
				    <td nowrap valign=\"middle\" colspan=\"2\">$b_vert<font face=\"Verdana, Arial, Helvetica, sans-serif\" size=\"2\"><img src=\"$image_l\" width=\"15\" height=\"20\" align=\"absmiddle\" border=\"0\"><a href=\"$file_path\" target=\"_blank\">$image</a><a href=\"$file_path\" target=\"_blank\">$file_name</a>";
			if($grade['a']=='a'||$grade['b']=='b'||$grade['t']=='t'||$grade['u']=='u') $line_file[$level].= "&nbsp;<a href=\"?page=matchs_browser&op=delete&filename=$file_name&match=$match&directory=$directory&header=win\" onclick=\"return confirm('$strConfirmEffacerFile');\">[$strS]</a>";
			
			$line_file[$level].= "</font></td>
				    <td width=\"100\" align=\"left\"><font face=\"Verdana, Arial, Helvetica, sans-serif\" size=\"2\">$file_size</font></td>
				  </tr>
			";
		}
	} 
		
	return($line_file);
}

/********************************************************
 * Post d'un fichier
 */
if($op=='upload') {

	//$directory=str_replace( array(".","//"), "", $directory);
	//$match=str_replace ( array(".","//"), "", $match);
	if(!is_dir($config['download_path']."/$match/$directory") || $directory=="") $directory="/";

	if($upload==1) {

		include_once("include/class.upload.php");
		$uploadc = new Upload();
		$uploadc->maxupload_size = $config['download_max_filesize'];
		$destination=$config['download_path']."/$match/$directory";
		$field_filename = trim($uploadc->getFileName("userfile"));

		if ($field_filename) {
			if($uploadc->save($destination, "userfile", true)) {
				js_goto("?page=matchs_browser&match=$match&directory=$directory&header=win");
 			}
			else {
				show_warning($uploadc->errors);
			}
		}
		else {
			show_warning("$strFichierInvalide : $field_filename");
		}
	}
} 

/********************************************************
 * Effacement d'un fichier
 */
if($op=='delete') {

	/*** verification securite ***/
	if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['t']!='t'&&$grade['u']!='u') {js_goto($PHP_SELF);} 

	$filename=str_replace( "/", "", $filename);

	if(!is_dir($config['download_path']."/$match/$directory") || $directory=="") $directory="/";

	@unlink($config['download_path']."/$match/$directory/$filename");

	js_goto("?page=matchs_browser&match=$match&directory=$directory&header=win");

}
/********************************************************
 * Affichage normal
 */
else {
  
	echo "<p class=title>.:: $strFichiersAttachesMatch $match ::.</p>";
  
	if(is_numeric($match) && !is_dir($config['download_path']."/$match")) {
		create_dirs($match);
	}

	if(!is_dir($config['download_path']."/$match/$directory") || $directory=='') $directory="/";
  
	// barre navig
	$arr_nav_dir = explode ("/",$directory);
	$nav_bar = '';
	$taille = sizeof($arr_nav_dir)-2;
  
	for ($i=0 ; $i <= $taille ; $i++){
		$nav_lnk = "";
		for ($j = 0 ; $j <= $i ; $j++){
			$nav_lnk .= $arr_nav_dir[$j] . "/";
		};
		$nav_bar.= "<a href=\"?page=matchs_browser&match=$match&directory=$nav_lnk&header=win\">" . $arr_nav_dir[$i] . "</a>" . "/";
	}
  
	////////////////////////////////////////////////
	// en tête
  
	echo "<table width=\"500+\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
		<tr align=\"left\" valign=\"middle\">
		<td align=\"left\" colspan=\"3\"><font face=\"Verdana, Arial, Helvetica, sans-serif\" size=\"2\"><u>$strMatch <b>$match</b></u> : $nav_bar</font></td>
		</tr>
	";
  
	$arr_dir = explode ("/",$directory);
	$dir_cur = '';
	$level = sizeof($arr_dir)-2;
	$j=0;
	while ($j <= $level){
		$dir_cur .= $arr_dir[$j] . "/";
		$dir_no = $arr_dir[$j+1];
		$line_dir = p_get_dir($match,$dir_cur, $j, $dir_no);
		$line_file = p_get_file($match,$dir_cur,$j);
  
		if ($line_dir[$j] != "")
			$the_line_dir[$j] = $line_dir[$j];
		if ($line_file[$j] != "")
			$the_line_file[$j] = $line_file[$j];
		$j++;
	}
  
	$j=1;
	$line = $the_line_dir[0] . $the_line_file[0];
  
	while ($j <= $level){
		$rep = $j - 1;
		$replace_str = "x?x?x" . $rep . "x?x?x";
		$added_line = $the_line_dir[$j] . $the_line_file[$j];
		$line = str_replace ($replace_str, $added_line, $line);
		$j++;
	}
  
	echo "$line";
	echo "</table>";
  
	/*** upload des fichier ***/
	if($upload==1) {
		echo "<br>";
		echo "<form name=input action=\"?page=matchs_browser&op=upload&header=win\" method=post enctype=\"multipart/form-data\">";
		echo "<input type=\"hidden\" name=\"match\" value=\"$match\">";
		echo "<input type=\"hidden\" name=\"directory\" value=\"$directory\">";
		echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
		echo "<table cellspacing=1 cellpadding=0 border=0>";
		echo "<tr><td class=headerfiche>$strUploaderFichier $directory</td></tr>";
		echo "<tr><td>";
		echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
		echo "<tr>";
		echo "<td class=titlefiche>$strFichier <font color=red><b>*</b></font> :</td>";
		echo "<td class=textfiche><input type=file name=userfile size=40 maxlength=80></td>";
		echo "</tr>";
		echo "<tr><td class=footerfiche align=center colspan=2><input type=submit value=\"$strEnvoyer\"></td></tr>";
		echo "</table>";
		echo "</td></tr></table>";
		echo "</td></tr></table>";
		echo "</form>";

		show_consignes($strUploadFichierConsignes.coolsize($config['download_max_filesize']));
	}

	echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:close() class=action>$strRetour</a><br>";
  
} 
  
?>
                                                                                                                                                                                

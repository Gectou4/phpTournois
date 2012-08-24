<?php
/*
   +---------------------------------------------------------------------+
   | page : faq.php                                                      |
   | phpTournois ADDONS | Module name : "FAQ" V 1.3          |
   | MOD Author : Gectou4 <le_gardien_prime@hotmail.com                  |
   +---------------------------------------------------------------------+
   +---------------------------------------------------------------------+
   | phpTournois                                                         |
   +---------------------------------------------------------------------+
   | Copyright© 2001-2004 Li0n, RV, Gougou (http://www.phptournois.net)|
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
  | Edited by @ngelius <angelius@tournois-online.com> (21/07/2005)      |
  +---------------------------------------------------------------------+
*/
if (eregi("faq.php", $_SERVER['PHP_SELF'])) {
die ("You cannot open this page directly");
}

global $config,$s_joueur,$s_theme,$db,$dbprefix;

/********************************************************
* !et c'est partie mon kiki==>>>
*/

//la fonction flag(); permet d'afficher le drapeau.
$flag="images/flags/FR.gif";
$flagFR=$flag;
if($lang=='english' || $s_lang=='english')
{
$flag="images/flags/UK.gif";
}
if ($_GET['op']!="admin") {
 
   $db->select("categorie,idcat");
   $db->from("${dbprefix}faq ORDER by idcat");
   $res = $db->exec();
         echo "<p class=title>.:: $strFaq:.</p>";
  echo "$str_faq_choose";
  echo '<br><form name="catform"  method="post" action="?page=faq&op=seecat">';
 
if ($_GET['alerte']!="a")
  {
   echo '<img src="images/consignes.gif" border="0" />&nbsp;<select name="catf">';
 
  while ($data = $db->fetch($res))
   {
    if ($data->categorie!='')
    {
    $select_test=$data->categorie;

     echo '<option value="'.$data->idcat.'"';
                          if($catf==$data->idcat) echo " SELECTED";
                          echo'>'.stripslashes($data->categorie).'</option>';
    }
   }
   if ($select_test=='') {js_goto("?page=faq&alerte=a");}
 
 
  echo '</select>&nbsp;&nbsp;';
  echo '<input type="submit" name="Button1" value="';
  echo "- $strOK -";
  echo '">';
  } else {
  echo $str_faq_error;
 
  }
    echo '</form>';

 
/********************************************************
* Affichage de la categorie demand&eacute;
*/
if ($_GET['op']=="seecat") {

   $idcat=$_POST['catf']; 
  
  $db->select("*");
  $db->from("${dbprefix}faq WHERE idcat='$idcat' ORDER by rang");
  $resr = $db->exec();


   echo "<table width=500 border=0 cellpadding=0 cellspacing=0>";

   while ($datar = $db->fetch($resr)) {
 
  /////////////////
  $datar->question=stripslashes($datar->question);
  $reponse=$datar->reponse;
  $reponse=BBcode($reponse);
  $reponse=stripslashes($reponse);
  /////////////////
 
  if ($datar->categorie!='')
   {
   echo '<tr><td align=center valign=center> <table width=100% border=1 cellpadding=1 cellspacing=1><tr><td class="headerfiche" align="left"> '.stripslashes($datar->categorie).' </td>
   </tr></table> </td></tr>';
   }
 
  else
   {
   $reponse=wordwrap($reponse, 110, "\n", 1);


   echo "<tr><td class=faqtd><table width=500 border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
   echo "<table width=100% border=0 cellspacing=1 cellpadding=2>";
   echo "<tr><td class=header><div style=\"clear: both\"><div style=\"float: left\"><img src=\"images/icon_comment.gif\" border=0 align=absmiddle> ".$datar->question."</div>";
   echo "</div></td></tr>";
   echo "<tr><td class=text>$reponse</td></tr>";
   echo "</table>";
   echo "</td></tr></table></td></tr>";
   }

  }
  echo '</table>';




}

}

/********************************************************
* ADMIN
*/
if ($_GET['op']=="admin")
{
/*** verification securite ***/
//verif_admin_general($s_joueur);
if (($grade['a']!='a' && $grade['b']!='b' && $grade['f']!='f') && $config['faq'] == 1) {js_goto('?page=index');}

  echo '<p align= center><b>';
  echo "$str_faq_admin";
  echo '</b></P><br><form name="act"  method="post" action="?page=faq&op=admin">';
 
  if ($_GET['alerte']=="a") {echo "$str_faq_al1";}
  if ($_GET['alerte']=="b") {echo "$str_faq_al2";}
  if ($_GET['alerte']=="c") {echo "$str_faq_al3";}
  if ($_GET['alerte']=="d") {echo "$str_faq_al4";}
  if ($_GET['alerte']=="g") {echo "$str_faq_al5";}
  if ($_GET['alerte']=="h") {echo "$str_faq_al6";}
  if ($_GET['alerte']=="i") {echo "$str_faq_al7";}

   echo '<select name="act">';
  echo "<option value='A'";if($act==A) echo " SELECTED";echo">$str_faq_actA</option>";
  echo "<option value='B'";if($act==B) echo " SELECTED";echo">$str_faq_actB</option>";
  echo "<option value='C'";if($act==C) echo " SELECTED";echo">$str_faq_actC</option>";
  echo "<option value='D'";if($act==D) echo " SELECTED";echo">$str_faq_actD</option>";
  echo "<option value='E'";if($act==E) echo " SELECTED";echo">$str_faq_actE</option>";
  echo "<option value='F'";if($act==F) echo " SELECTED";echo">$str_faq_actF</option>";
  echo "<option value='G'";if($act==G) echo " SELECTED";echo">$str_faq_actG</option>";
  echo "<option value='H'";if($act==H) echo " SELECTED";echo">$str_faq_actH</option>";
  echo "<option value='I'";if($act==I) echo " SELECTED";echo">$str_faq_actI</option>";
  echo '</select>';
  echo '&nbsp;&nbsp;<input type="submit" name="Button1" value="';
  echo "- $strOK -";
  echo '">';
    echo '</form>';

/********************************************************
* AJOUTER CATEGORIE
*/

if ($_POST['act']=="A" || $_GET['act']=="A")
{
echo'<br><br><form name="form2" method="post" action="?page=faq&op=admin&act=Aup"><font size="2" color ="green">';
echo "$str_faq_actA";
echo '</fonT><br>';
   echo'<input type="text" name="addcat"><br>';
   echo'<input type="submit" name="Submit" value="';
echo "- $strOK -";
echo '">';
echo'</form>';
}

if ($_GET['act']=="Aup")
{
  $db->select("*");
  $db->from("${dbprefix}faq WHERE categorie!='' ORDER by id");
  $res = $db->exec();
  while ($data = $db->fetch($res))
     $idcat=$data->idcat;
  $idcat=$idcat+1;
  $addcat=$_POST['addcat'];

  if ($_POST['addcat']=='') {js_goto("?page=faq&op=admin&alerte=h");}

  $addcat=htmlentities($addcat);$addcat=str_replace("nowhere","nowhere",$addcat);$addcat=str_replace("NOWHERE","nowhere",$addcat);

$sql = "INSERT INTO ${dbprefix}faq (id,question,reponse,categorie,rang,date,idcat) Values('','','','$addcat','-1','','$idcat')";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

js_goto("?page=faq&op=admin&act=B");
}

/********************************************************
* Ajouter QR
*/
if ($_POST['act']=="B" || $_GET['act']=="B")
{
  $db->select("categorie,idcat");
  $db->from("${dbprefix}faq ORDER by id");
  $res = $db->exec();

if ($_GET['v']=="o") {echo'<br><br><font size="2" color ="green"><b>'; echo"$str_faq_addq"; echo'</b></fonT><br>';}
  
  echo'<br><br><form name="formulaire" method="post" action="?page=faq&op=admin&act=Bup">';

  echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
  echo "<table cellspacing=1 cellpadding=0 border=0>";
  echo "<tr><td class=headerfiche>$str_faq_addqr</td></tr>";
  echo "<tr><td>";
  echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
  echo "<tr>";
  echo "<td class=titlefiche>$str_faq_in</td>";
  echo '<td class=textfiche style=\"white-space:normal\"><select name="catf">';
 
  while ($data = $db->fetch($res))
   {
    if ($data->categorie!='')
    {
    $select_test=$data->categorie;
     echo '<option value="'.$data->idcat.'">'.stripslashes($data->categorie).'</option>';
    }
   }
   if ($select_test=='') {js_goto("?page=faq&op=admin&alerte=a");}
 
  echo '</select></td></tr>';
 
   echo "<tr>";
   echo "<td class=titlefiche>$str_faq_q</td>";
   echo "<td class=textfiche><input type=text name=addq size=70></td>";
   echo "</tr>";
   echo "<tr>";
   echo "<td class=textfiche colspan=2 align=center>";buttonBB('contenu');echo "</td>";
   echo "</tr>";
   echo "<tr>";
   echo "<td class=titlefiche style=\"white-space:normal\">$str_faq_r</td>";
   echo "<td class=textfiche><textarea cols=60 rows=10 name=contenu wrap=virtual ONSELECT=\"storeCaret(this);\" ONCLICK=\"storeCaret(this);\" ONKEYUP=\"storeCaret(this);\"></textarea></td>";
   echo "</tr>";
   echo "<tr><td class=footerfiche colspan=2 align=center><input type=submit value=\"$strAjouter\"></td></tr>";
   echo "</table>";
   echo "</td></tr></table>";
   echo "</td></tr></table>"; 
   echo "</form>";

////////////////////////////////////////

/////////////////////////////////////////
}

if ($_GET['act']=="Bup")
{
         $idcat=$_POST['catf'];
  $db->select("*");
  $db->from("${dbprefix}faq WHERE idcat='$idcat' order by rang");
  $res = $db->exec();
  while ($data = $db->fetch($res))
  {
  $rang=$data->rang;echo"$rang<br>";
  }
  $rang=$rang+1;
  $addq=$_POST['addq'];
  $addr=$_POST['contenu'];

  if ($_POST['addq']=='' || $_POST['contenu']=='') {js_goto("?page=faq&op=admin&alerte=h");}
 
  $addq=htmlentities($addq);$addq=str_replace("nowhere","nowhere",$addq);$addq=str_replace("NOWHERE","nowhere",$addq);
  $addr=htmlentities($addr);$addr=str_replace("nowhere","nowhere",$addr);$addr=str_replace("NOWHERE","nowhere",$addr);

$sql = "INSERT INTO ${dbprefix}faq (id,question,reponse,categorie,rang,date,idcat) Values('','$addq','$addr','','$rang','','$idcat')";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

js_goto("?page=faq&op=admin&act=B&v=o");
        }

/********************************************************
* Modifier cat&eacute;gorie
*/
if ($_POST['act']=="C"  || $_GET['act']=="C")
{
  $db->select("categorie,idcat");
  $db->from("${dbprefix}faq ORDER by id");
  $res = $db->exec();

 
echo'<br><br><form name="form2" method="post" action="?page=faq&op=admin&act=Cup"><font size="2" color ="green">';
echo "$str_faq_actC";
echo '</fonT><br>';
   echo '<br><table border="0"><tr><td>';
   echo '<font size="2" color ="blue"><b>';
echo "$strModifier";
echo '</b></font></td><td><select name="catf">';
 
  while ($data = $db->fetch($res))
   {
    if ($data->categorie!='')
    {
    $select_test=$data->categorie; 
     echo '<option value="'.$data->idcat.'">'.stripslashes($data->categorie).'</option>';
    }
   }
  if ($select_test=='') {js_goto("?page=faq&op=admin&alerte=a");}
  
  echo '</select></td></tr>';
 
   echo'<tr><td><font size="2" color ="blue"><b>';
echo "$str_faq_par";
echo'</b></font></td><td><input type="text" name="modifcat"></td></tr></table>';
echo'<input type="submit" name="Submit" value="';
echo "- $strModifier -";
echo '">';
echo'</form>';
}

if ($_GET['act']=="Cup")
{

  $modifcat=$_POST['modifcat'];
  $idcat=$_POST['catf'];


  $modifcat=htmlentities($modifcat);$modifcat=str_replace("nowhere","nowhere",$modifcat);$modifcat=str_replace("NOWHERE","nowhere",$modifcat);
 
$sqldel = "UPDATE `${dbprefix}faq` SET categorie='$modifcat' WHERE idcat='$idcat' and categorie!=''";
$reqdel = mysql_query($sqldel) or die('Erreur SQL !<br>'.$sqldel.'<br>'.mysql_error());

js_goto("?page=faq&op=admin");
}

/********************************************************
* Modifier Q/R
*/

if ($_POST['act']=="D" || $_GET['act']=="D")
  {
  $db->select("categorie,idcat");
  $db->from("${dbprefix}faq ORDER by id");
  $res = $db->exec();

 
  echo'<br><br><form name="formX" method="post" action="?page=faq&op=admin&act=D2"><font size="2" color ="green">';
  echo "$str_faq_actD";
  echo'</fonT><br>';
    echo '<br><table border="0"><tr><td>';
    echo '<font size="2" color ="blue"><b>';
  echo "$str_faq_in";
  echo'</b></font></td><td><select name="catf">';
 
  while ($data = $db->fetch($res))
   {
    if ($data->categorie!='')
    {
    $select_test=$data->categorie; 
     echo '<option value="'.$data->idcat.'">'.stripslashes($data->categorie).'</option>';
    }
   }
   if ($select_test=='') {js_goto("?page=faq&op=admin&alerte=a");}
 
  echo '</select></td></tr></table>';
echo'<input type="submit" name="Submit" value="';
echo "- $strModifier -";
echo '">';
echo'</form>';
}

if ($_POST['act']=="D2"  || $_GET['act']=="D2")
{
$idcat=$_POST['catf'];
  $db->select("id,question");
  $db->from("${dbprefix}faq WHERE idcat='$idcat' ORDER by id");
  $res = $db->exec();

 
echo '<br><br><form name="form2" method="post" action="?page=faq&op=admin&act=Dup"><font size="2" color ="green">';
echo "$str_faq_actD";
echo '</fonT><br>';
   echo '<br><table border="0"><tr><td>';
   echo '<font size="2" color ="blue"><b>';
echo "$strModifier";
echo '&nbsp;:</b></font></td><td><select name="modifqr">';
 
  while ($data = $db->fetch($res))
   {
    if ($data->question!='')
    {
    $select_test=$data->question; 
     echo '<option value="'.$data->id.'">'.stripslashes($data->question).'</option>';
    }
   }
   if ($select_test=='') {js_goto("?page=faq&op=admin&alerte=b");}
  
  echo '</select></td></tr></table>';
 
    echo'<input type="submit" name="Submit" value="';
echo "- $strModifier -";
echo '">';
echo'</form>';
}

if ($_GET['act']=="Dup")
{
  if ($_POST['modifqr']==''){$modifqr=$_GET['modifqr'];}else{$modifqr=$_POST['modifqr'];}
 
 
  $db->select("question,reponse");
  $db->from("${dbprefix}faq WHERE id='$modifqr'");
  $res = $db->exec();

 
  while ($data = $db->fetch($res))
   {
   $question=stripslashes($data->question);
   $reponse=stripslashes($data->reponse);
   }
 
  if ($_GET['v']=="o") {echo'<br><br><font size="2" color ="green"><b>'; echo "$str_faq_addq"; echo'</b></fonT><br>';}
 
  echo'<br><br><form name="formulaire" method="post" action="?page=faq&op=admin&act=Dup2">';

  echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
  echo "<table cellspacing=1 cellpadding=0 border=0>";
  echo "<tr><td class=headerfiche>$str_faq_actD</td></tr>";
  echo "<tr><td>";
  echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
  
   echo "<tr>";
   echo "<td class=titlefiche>$str_faq_q</td>";
   echo "<td class=textfiche><input type=text name=addq size=70 value=\"$question\"></td>";
   echo "</tr>";
   echo "<tr>";
   echo "<td class=textfiche colspan=2 align=center>";buttonBB('contenu');echo "</td>";
   echo "</tr>";
   echo "<tr>";
   echo "<td class=titlefiche style=\"white-space:normal\">$str_faq_r</td>";
   echo "<td class=textfiche><textarea cols=60 rows=10 name=contenu wrap=virtual ONSELECT=\"storeCaret(this);\" ONCLICK=\"storeCaret(this);\" ONKEYUP=\"storeCaret(this);\">";
   echo ''.$reponse.'</textarea></td>';
   echo "</tr>";
   echo'<tr><td class=footerfiche colspan=2 align=center><input type="hidden" name="id" value="'.$modifqr.'">';
   echo "<input type=submit value=\"$strModifier\"></td></tr>";
   echo "</table>";
   echo "</td></tr></table>";
   echo "</td></tr></table>"; 
   echo "</form><br><br>";
  
   /////////////////
  $question=stripslashes($question);
  $reponse=$reponse;
  $reponse=BBcode($reponse);
  $reponse=stripslashes($reponse);
  /////////////////

   $reponse=wordwrap($reponse, 110, "\n", 1);
   echo "<table width=500 border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
   echo "<table width=100% border=0 cellspacing=1 cellpadding=2>";
   echo "<tr>";
   echo "<td class=header><div style=\"clear: both\"><div style=\"float: left\"><img src=\"images/icon_comment.gif\" border=0 align=absmiddle> $question</div>";
   echo "</div></td></tr>";
   echo '<tr><td class=text>'.$reponse.'</td></tr>';
   echo '</td></tr></table>';
   echo '</td></tr></table>';


///
}

if ($_GET['act']=="Dup2")
{
$modifqr=$_POST['id'];
$modifq=$_POST['addq'];
$modifr=$_POST['contenu'];

 
$modifq=htmlentities($modifq);$modifq=str_replace("nowhere","nowhere",$modifq);$modifq=str_replace("NOWHERE","nowhere",$modifq);
$modifr=htmlentities($modifr);$modifr=str_replace("nowhere","nowhere",$modifr);$modifr=str_replace("NOWHERE","nowhere",$modifr);

$sqldel = "UPDATE `${dbprefix}faq` SET question='$modifq', reponse='$modifr' WHERE id='$modifqr'";
$reqdel = mysql_query($sqldel) or die('Erreur SQL !<br>'.$sqldel.'<br>'.mysql_error());


js_goto("?page=faq&op=admin&act=Dup&v=o&modifqr=$modifqr");

}

/********************************************************
* Reorder cat&eacute;gorie
*/
if ($_POST['act']=="E" || $_GET['act']=="E")
  { 
  $db->select("categorie,idcat");
  $db->from("${dbprefix}faq WHERE categorie!='' ORDER by idcat");
  $resr = $db->exec();
 

   echo '<br><br><font size="2" color ="green">';
  echo "$str_faq_actE";
  echo '</fonT><br>';
   echo '<table border=1 cellpadding="0" cellspacing="0" class="bordure1">';
  $p_test=1;
  $m_test=1;
 
  $req = mysql_query("SELECT COUNT(*) AS categorie FROM ${dbprefix}faq WHERE categorie!=''");
  $t_max = mysql_fetch_array($req);
  $cat_max=$t_max['categorie'];
  $select_test2=0;
 
   while ($datar = $db->fetch($resr))
  {

   echo '<tr><td class="headerfiche" align="left">&nbsp;'.$datar->categorie.'&nbsp;</td><td class="textfiche">';
   // j'ai matter le reoder de IBF ouer bas dès que "j'aurais le temps" je ferrais pareil (bigre de bigre)
 
  if ($p_test!=$cat_max)
   {
   $p_test++;
   $idcatp=$datar->idcat;
   $idcatp=$idcatp+1;
   echo'<a href="?page=faq&op=admin&act=Eup&id='.$datar->idcat.'&idcat='.$idcatp.'">[<font size="2" color="red"><img src="images/g4/down.gif" alt="down" border="0" /></font>]</a>';
   }
   else
   echo'[<font size="2" color="red">X</font>]</a>';
  if ($m_test!=1)
   {
   $idcatm=$datar->idcat;
   $idcatm=$idcatm-1;
   echo'<a href="?page=faq&op=admin&act=Eup&id='.$datar->idcat.'&idcat='.$idcatm.'">[<font size="2" color="blue"><img src="images/g4/up.gif" alt="up" border="0"/></font>]</a>';
   echo '</td></tr>';
   }
   else
   echo'[<font size="2" color="red">X</font>]</a>';
   $m_test=0;
  
   $select_test=$datar->categorie;
   $select_test2++;
  }
  if ($select_test=='') {js_goto("?page=faq&op=admin&alerte=a");}
  if ($select_test2==1) {js_goto("?page=faq&op=admin&alerte=c");}

  echo '</table>';
  

}

if ($_GET['act']=="Eup")
{
$idcat=$_GET['idcat'];
$id=$_GET['id'];
  $req = mysql_query("SELECT COUNT(*) AS categorie FROM ${dbprefix}faq WHERE categorie!=''");
  $t_max = mysql_fetch_array($req);
  $id_max=$t_max['categorie']+1;

   $sql = "UPDATE `${dbprefix}faq` SET idcat='$id_max' WHERE idcat='$idcat'";
   $req = mysql_query($sql) or die('Erreur SQL 1 !<br>'.$sql.'<br>'.mysql_error());

   $sql = "UPDATE `${dbprefix}faq` SET idcat='$idcat' WHERE idcat='$id'";
   $req = mysql_query($sql) or die('Erreur SQL 2 !<br>'.$sql.'<br>'.mysql_error());

   $sql = "UPDATE `${dbprefix}faq` SET idcat='$id' WHERE idcat='$id_max'";
   $req = mysql_query($sql) or die('Erreur SQL 3 !<br>'.$sql.'<br>'.mysql_error());

js_goto("?page=faq&op=admin&act=E");
}
/********************************************************
* Reorder QR
*/
if ($_POST['act']=="F")
  {
  $db->select("categorie,idcat");
  $db->from("${dbprefix}faq ORDER by id");
  $res = $db->exec();


  echo '<br><br><form name="formX" method="post" action="?page=faq&op=admin&act=F2"><font size="2" color ="green">';
  echo "$str_faq_actF";
  echo '</fonT><br>';
    echo '<br><table border="0"><tr><td>';
    echo '<font size="2" color ="blue"><b>';
  echo "$str_faq_in";
  echo '</b></font></td><td><select name="catf">';
 
 
  while ($data = $db->fetch($res))
   {
    if ($data->categorie!='')
    {
    $select_test=$data->categorie; 
     echo '<option value="'.$data->idcat.'">'.$data->categorie.'</option>';
    }
   }
   if ($select_test=='') {js_goto("?page=faq&op=admin&alerte=a");}
  
 
  echo '</select></td></tr></table>';
  echo'<input type="submit" name="Submit" value="';
  echo "- $strOK -";
  echo '">';
  echo'</form>';
}

if ($_POST['act']=="F2"  || $_GET['act']=="F2")
  {
                if($_GET['catf']=='')
                $catf=$_POST['catf'];
  $db->select("question,rang");
  $db->from("${dbprefix}faq WHERE question!='' and idcat='$catf' ORDER by rang");
  $resr = $db->exec();

  $db->select("categorie");
  $db->from("${dbprefix}faq WHERE categorie!='' and idcat='$catf'");
  $resc = $db->exec();
                $datac = $db->fetch($resc);
                $categ=$datac->categorie;
   echo '<br><br><form name="formX" method="post" action="?page=faq&op=admin&act=F2"><font size="2" color ="green">';
  echo "$str_faq_actF ($categ)";
  echo '</fonT><br>';
   echo '<table border=1 cellpadding="0" cellspacing="0" class="bordure1">';
  $p_test=1;
  $m_test=1;
  $select_test2=0;
 
  $req = mysql_query("SELECT COUNT(*) AS question FROM ${dbprefix}faq WHERE question!='' and idcat='$catf'");
  $t_max = mysql_fetch_array($req);
  $cat_max=$t_max['question'];

   while ($datar = $db->fetch($resr))
  {
 
   echo '<tr><td class="headerfiche" align="left">&nbsp;'.$datar->question.'&nbsp;</td><td class="textfiche">';
 
  if ($p_test!=$cat_max)
   {
   $p_test++;
   $idrangp=$datar->rang;
   $idrangp=$idrangp+1;
   echo'<a href="?page=faq&op=admin&act=Fup&id='.$datar->rang.'&idrang='.$idrangp.'&idcat='.$catf.'">[<font size="2" color="red"><img src="images/g4/down.gif" alt="down" border="0" /></font>]</a>';
   }
   else
   echo'[<font size="2" color="red">X</font>]</a>';

  if ($m_test!=1)
   {
   $idrangm=$datar->rang;
   $idrangm=$idrangm-1;
   echo'<a href="?page=faq&op=admin&act=Fup&id='.$datar->rang.'&idrang='.$idrangm.'&idcat='.$catf.'">[<font size="2" color="blue"><img src="images/g4/up.gif" alt="up" border="0"/></font>]</a>';
   echo '</td></tr>';  
   }
   else
   echo'[<font size="2" color="red">X</font>]</a>';
   $m_test=0;
  
   $select_test=$datar->question;
   $select_test2++;
  }
  if ($select_test=='') {js_goto("?page=faq&op=admin&alerte=b");}
  if ($select_test2==1) {js_goto("?page=faq&op=admin&alerte=d");}
 
  echo '</table>';
  

}

if ($_GET['act']=="Fup")
{
$idrang=$_GET['idrang'];
$id=$_GET['id'];
$catf=$_GET['idcat'];
  $req = mysql_query("SELECT COUNT(*) AS question FROM ${dbprefix}faq WHERE question!='' and idcat='$catf'");
  $t_max = mysql_fetch_array($req);
  $id_max=$t_max['question']+1;

   $sql = "UPDATE `${dbprefix}faq` SET rang='$id_max' WHERE rang='$idrang' and idcat='$catf'";
   $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

   $sql = "UPDATE `${dbprefix}faq` SET rang='$idrang' WHERE rang='$id' and idcat='$catf'";
   $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

   $sql = "UPDATE `${dbprefix}faq` SET rang='$id' WHERE rang='$id_max' and idcat='$catf'";
   $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());


js_goto("?page=faq&op=admin&act=F2&catf=$catf");

}
/********************************************************
* EFFACER Cat&eacute;gorie
*/
if ($_POST['act']=="G" || $_GET['act']=="G")
  {
  $db->select("categorie,idcat");
  $db->from("${dbprefix}faq ORDER by id");
  $res = $db->exec();

 
  echo '<br><br><form name="formX" method="post" action="?page=faq&op=admin&act=Gup"><font size="2" color ="green">';
  echo "$str_faq_actG";
  echo '</fonT><br>';
    echo '<br><table border="0"><tr><td>';
    echo '<font size="2" color ="blue"><b>Effacer :</b></font></td><td><select name="catf">';
 
  while ($data = $db->fetch($res))
   {
    if ($data->categorie!='')
    {
    $select_test=$data->categorie;
     echo '<option value="'.$data->idcat.'">'.$data->categorie.'</option>';
    }
   }
  if ($select_test=='') {js_goto("?page=faq&op=admin&alerte=a");}
 
echo '</select></td></tr></table><br>';
echo '<input type="submit" name="Submit" value="';
echo "- $strOK -";
echo '">';
echo '</form>';
}
if ($_GET['act']=="Gup")
{
$idcat=$_POST['catf'];


   $sql = "DELETE FROM `${dbprefix}faq` WHERE idcat='$idcat'";
   $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

  

js_goto("?page=faq&op=admin&alerte=g");
}
/********************************************************
* EFFACER Q/R
*/
if ($_POST['act']=="H" || $_GET['act']=="H")
  {
  $db->select("categorie,idcat");
  $db->from("${dbprefix}faq ORDER by id");
  $res = $db->exec();

   if ($_GET['v']=="o") {echo '<br><br><font size="2" color="red"><b>'; echo "$str_faq_nothing"; echo '</b></font>';}
 
  echo'<br><br><form name="formX" method="post" action="?page=faq&op=admin&act=H2"><font size="2" color ="green">';
  echo "$str_faq_actH";
  echo '</fonT><br>';
    echo '<br><table border="0"><tr><td>';
    echo '<font size="2" color ="blue"><b>';
  echo "$str_faq_in";
  echo '</b></font></td><td><select name="catf">';
 
  while ($data = $db->fetch($res))
   {
    if ($data->categorie!='')
    {
    $select_test=$data->categorie;
     echo '<option value="'.$data->idcat.'">'.$data->categorie.'</option>';
    }
   }
if ($select_test=='') {js_goto("?page=faq&op=admin&alerte=a");}
 
echo '</select></td></tr></table><br>';
echo'<input type="submit" name="Submit" value="';
echo "- $strOK -";
echo '">';
echo'</form>';
}

if ($_GET['act']=="H2")
{
  if ($_POST['catf']=='' || $_POST['catf'] == NULL) {$catid=$_GET['catid'];}else {$catid=$_POST['catf'];}
  $db->select("question,id");
  $db->from("${dbprefix}faq WHERE idcat='$catid' ORDER by id");
  $res = $db->exec();

  echo'<br><br><form name="formX" method="post" action="?page=faq&op=admin&act=Hup"><font size="2" color ="green">';
  echo "$str_faq_actH";
  echo '</fonT><br>';
  echo '<br><table border="0"><tr><td>';
    echo '<font size="2" color ="blue"><b>Effacer :</b></font></td><td><select name="catf">';
 
 
  while ($data = $db->fetch($res))
   {
    if ($data->question!='')
    {
     $select_test=$data->question;
     echo '<option value="'.$data->id.'">'.$data->question.'</option>';
    }
   }

echo '</select></td></tr></table><br>';
echo'<input type="hidden" name="idcat" value="'.$catid.'"><input type="submit" name="Submit" value="';
echo "- $strOK -";
echo '">';
echo'</form>';

// if ($select_test=='') {js_goto("?page=faq&op=admin&act=H&v=o");}
}

if ($_GET['act']=="Hup")
{
$id=$_POST['catf'];
$catid=$_POST['idcat'];


   $sql = "DELETE FROM `${dbprefix}faq` WHERE id='$id'";
   $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

  

js_goto("?page=faq&op=admin&act=H2&catid=$catid");
}
/********************************************************
* Echanger Q/R
*/
if ($_POST['act']=="I" || $_GET['act']=="I")
  {
  $db->select("categorie,idcat");
  $db->from("${dbprefix}faq ORDER by id");
  $res = $db->exec();

   if ($_GET['v']=="o") {echo '<br><br><font size="2" color="red"><b>'; echo "$str_faq_nothing"; echo '</b></font>';}

  echo'<br><br><form name="formX" method="post" action="?page=faq&op=admin&act=I2"><font size="2" color ="green">';
  echo "$str_faq_actI";
  echo '</fonT><br>';
    echo '<br><table border="0"><tr><td>';
    echo '<font size="2" color ="blue"><b>';
  echo "$str_faq_in";
  echo '</b></font></td><td><select name="catf">';
 
  while ($data = $db->fetch($res))
   {
    if ($data->categorie!='')
    {
    $select_test=$data->categorie;
     echo '<option value="'.$data->idcat.'">'.$data->categorie.'</option>';
    }
   }
if ($select_test=='') {js_goto("?page=faq&op=admin&alerte=a");}
 
echo '</select></td></tr></table><br>';
echo'<input type="submit" name="Submit" value="';
echo "- $strOK -";
echo '">';
echo'</form>';
}

if ($_GET['act']=="I2")
{
  if ($_POST['catf']=='' || $_POST['catf'] == NULL) {$catid=$_GET['catid'];}else {$catid=$_POST['catf'];}
  $db->select("question,id");
  $db->from("${dbprefix}faq WHERE idcat='$catid' ORDER by id");
  $res = $db->exec();

  if ($_GET['v']=='o'){echo'<br><br><font size="2" color ="green">'; echo "$str_faq_inter"; echo '</fonT><br>';}
   
  echo'<br><br><form name="formX" method="post" action="?page=faq&op=admin&act=Iup"><font size="2" color ="green">';
  echo "$str_faq_actI";
  echo '</fonT><br>';
  echo '<br><table border="0"><tr><td>';
    echo '<font size="2" color ="blue"><b>';
  echo "$str_faq_mettre";
  echo '</b></font></td><td><select name="catf1">';
 
 
  while ($data = $db->fetch($res))
   {
    if ($data->question!='')
    {
     $select_test=$data->question;
     echo '<option value="'.$data->id.'">'.$data->question.'</option>';
    }
   }
  if ($select_test=='') {js_goto("?page=faq&op=admin&alerte=b");}
 
echo '</select></td><td>';

$db->select("categorie,idcat");
$db->from("${dbprefix}faq ORDER by id");
$res = $db->exec();

echo '<font size="2" color ="blue"><b>';
echo "$str_faq_in";
echo '</b></font></td><td><select name="catf">';
 
  while ($data = $db->fetch($res))
   {
    if ($data->categorie!='')
    {
     echo '<option value="'.$data->idcat.'">'.$data->categorie.'</option>';
    }
   }


echo '</td></tr></table><br>';
echo'<input type="hidden" name="catidx" value="'.$catid.'"><input type="submit" name="Submit" value="';
echo "- $strOK -";
echo '">';
echo'</form>';

}

if ($_GET['act']=="Iup")
{
$catid=$_POST['catf'];
$id=$_POST['catf1'];
$catidx=$_POST['catidx'];


  $sql = "UPDATE `${dbprefix}faq` SET idcat='$catid' WHERE id='$id'";
  $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

  

js_goto("?page=faq&op=admin&act=I2&catid=$catidx&v=o");
}

}
?>
<?php 
/*
   +---------------------------------------------------------------------+
   | page : ac_spe                                                   |
   | phpTournois ADDONS | Module name : "aricles & commandes" V 4.0      |
   | MOD Author : Gectou4 <Gectou4@hotmail.com>                  |
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
if (eregi("ac_spe.php", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}

 	  global $config,$s_joueur,$s_theme,$db,$dbprefix,$db,$dbprefix;
 	  $pseudodrr=''.nom_joueur($s_joueur).'';
	  
/********************************************************
 * Qui est-tu petit homme ?
 */
if ($_GET['op'] == "admin") {
				/*** verification securite ***/
				//verif_admin_general($s_joueur);
				if ($grade['a']!='a' && $grade['b']!='b') {js_goto($PHP_SELF);} 
				
	
	$ad_ok ="ok";
	$disabled='';
				
			
/********************************************************
 * Annule expert
 */
if ($_GET['act']=="delxp")
	{
	
		$chaine_req = $_POST['chaindel'];
		$array_chaine = explode('|', $chaine_req); 

		$max=$_POST['nbdel'];
		$idel="id='-1'";
		
		for($w=0; $w<=$max; $w++)
			{
	 		
			if($array_chaine[$w]!='')
	 			{
			 	$idel=$idel." OR id='".$array_chaine[$w]."'";
				} 
			}
		
		if($_GET['art']=="oui")
			{
			$sqldel = "DELETE FROM `${dbprefix}listarticle` WHERE ";
			}
		else {
			$sqldel = "DELETE FROM `${dbprefix}article` WHERE ";
			}
		$sqldel =$sqldel.$idel;
		$reqdel = mysql_query($sqldel) or die('Erreur SQL !<br>'.$sqldel.'<br>'.mysql_error());
		
}
/********************************************************
 * A payer expert
 */
if ($_GET['act']=="regxp")
	{
	
		$chaine_req = $_POST['chaindel'];
		$array_chaine = explode('|', $chaine_req); 

		$max=$_POST['nbdel'];
		$idel="id='-1'";
		
		for($w=0; $w<=$max; $w++)
			{
	 		
			if($array_chaine[$w]!='')
	 			{
			 	$idel=$idel." OR id='".$array_chaine[$w]."'";
				} 
			}
		$sqldel = "UPDATE `${dbprefix}article` SET regle='O' WHERE ";
		$sqldel =$sqldel.$idel;
		$reqdel = mysql_query($sqldel) or die('Erreur SQL !<br>'.$sqldel.'<br>'.mysql_error());
		
}
/********************************************************
 * Commande arriv&eacute;e
 */
if ($_GET['act']=="arvxp")
	{
	
		$chaine_req = $_POST['chaindel'];
		$array_chaine = explode('|', $chaine_req); 

		$max=$_POST['nbdel'];
		$idel="id='-1'";
		
		for($w=0; $w<=$max; $w++)
			{
	 		
			if($array_chaine[$w]!='')
	 			{
			 	$idel=$idel." OR id='".$array_chaine[$w]."'";
				} 
			}
		$sqldel = "UPDATE `${dbprefix}article` SET arrive='O' WHERE ";
		$sqldel =$sqldel.$idel;
		$reqdel = mysql_query($sqldel) or die('Erreur SQL !<br>'.$sqldel.'<br>'.mysql_error());
		
}
/********************************************************
 * A prit ça commande
 */
if ($_GET['act']=="prixp")
	{
	
		$chaine_req = $_POST['chaindel'];
		$array_chaine = explode('|', $chaine_req); 

		$max=$_POST['nbdel'];
		$idel="id='-1'";
		
		for($w=0; $w<=$max; $w++)
			{
	 		
			if($array_chaine[$w]!='')
	 			{
			 	$idel=$idel." OR id='".$array_chaine[$w]."'";
				} 
			}
		$sqldel = "UPDATE `${dbprefix}article` SET arrive='X', regle='O' WHERE ";
		$sqldel =$sqldel.$idel;
		$reqdel = mysql_query($sqldel) or die('Erreur SQL !<br>'.$sqldel.'<br>'.mysql_error());
		
}
/********************************************************
 * Ajout d'un article
 */
if ($_GET['admin'] == "add") 
		{
		if ($_GET['up'] == "addX") 
			{
			
			$sqllistaddx = "SELECT article FROM ${dbprefix}listarticle WHERE article='".$_POST['addarticle']."'"; 
  			$reqlistaddx = mysql_query($sqllistaddx) or die('Erreur SQL !<br>'.$sqllistaddx.'<br>'.mysql_error());
			
			while($datalistaddx = mysql_fetch_array($reqlistaddx )) 
   	 			{
				$chaddx=$datalistaddx['article_config'];
				}
				
			$str='';
			$erreur=0;


				if ($chaddx == $_POST['addarticle']){
				$erreur=1;
				$str.="- ".$strACAlredyExist."<br>";
				
				}
				
				if(eregi(",", $_POST['addprix'] || !is_numeric($_POST['addprix']))) {
				$erreur=1;
				$str.="- $strAC_podevirg<br>";
				}
				if($erreur==1) {	
				show_erreur_saisie($str);		
			}
			else {
			
			$add1=$_POST['addprix'];
			$add2=$_POST['addingred'];
			$add3=$_POST['addarticle'];
			$sqladd = "INSERT INTO ${dbprefix}listarticle(id,article,prix,ingred) Values('','$add3','$add1','$add2')"; 
			$reqadd = mysql_query($sqladd) or die('Erreur SQL !<br>'.$sqladd.'<br>'.mysql_error());
			}
		}
}
/********************************************************
 * Enlever article
 */
/*if ($_GET['admin'] == "del") 
	{
	 if ($_GET['up'] == "delX") 
		{
		$del_pseudo=''.nom_joueur($s_joueur).'';
		
		if ($del_pseudo != "")
			{
 			$delx_id = $_GET['delx'];
			$sqldelx = "DELETE FROM `${dbprefix}listarticle` WHERE id='$delx_id'"; 
			$reqdelx = mysql_query($sqldelx) or die('Erreur SQL !<br>'.$sqldelx.'<br>'.mysql_error());
			}
		}
}*/
/********************************************************
 * Traiter toute les commandes comme &eacute;tant 'prisent' (allprit) 
 */
if ($_GET['allprit']!="") 
 	{
		$lcid=$_GET['allprit'];
		$sqldel = "UPDATE `${dbprefix}article` SET arrive='X', regle='O' WHERE cid='$lcid'";
		$reqdel = mysql_query($sqldel) or die('Erreur SQL !<br>'.$sqldel.'<br>'.mysql_error());
}
 /********************************************************
 *  Signaler que toute les commandes sont arriv&eacute;es (allarrive) 
 */
 if ($_GET['allarrive']!="") 
 	{
		$lcid=$_GET['allarrive'];
		$sqldel = "UPDATE `${dbprefix}article` SET arrive='O', regle='O' WHERE cid='$lcid' AND arrive!='X'";
		$reqdel = mysql_query($sqldel) or die('Erreur SQL !<br>'.$sqldel.'<br>'.mysql_error());
}
 /********************************************************
 *  Signaler que toute les commandes sont r&eacute;gl&eacute;es (allregle)
 */
 if ($_GET['allregle']!="") 
 	{
		$lcid=$_GET['allregle'];
		$sqldel = "UPDATE `${dbprefix}article` SET regle='O' WHERE cid='$lcid' AND arrive!='X'";
		$reqdel = mysql_query($sqldel) or die('Erreur SQL !<br>'.$sqldel.'<br>'.mysql_error());
}
 
/********************************************************
 * Java Script
 */
 ?>
<script language="JavaScript">
function same()
{
i=document.history.nbdel.value;
i++;
document.history.nbdel.value=i;
}
function samedel()
{
z=document.artdel.nbdel.value;
z++;
document.artdel.nbdel.value=z;
}
function sama()
{
j=document.history.nbdel.value;
j--;
document.history.nbdel.value=j;
}
function sami()
{
i=document.one.inbdel.value;
i++;
document.one.inbdel.value=i;
}
function samex()
{
x=document.one.xnbdel.value;
x++;
document.one.xnbdel.value=x;
}
function samer()
{
r=document.one.rnbdel.value;
r++;
document.one.rnbdel.value=r;
}
function samep()
{
p=document.one.pnbdel.value;
p++;
document.one.pnbdel.value=p;
}
</script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>

<?php 


/********************************************************
 * L'admin cherche t'il une commande en particulier ? ($wtl)
 */
		
if ($_GET['wtl'] != "") 
	{
	$lcid=$_GET['wtl'];
				
	}else if ($_GET['wtl'] == "") 
			{
		 	$sqllistc = "SELECT article_config FROM ${dbprefix}config"; 
  			$reqlistc = mysql_query($sqllistc) or die('Erreur SQL !<br>'.$sqllistc.'<br>'.mysql_error());
			
			while($datalistc = mysql_fetch_array($reqlistc)) 
   	 			{
				$lcid=$datalistc['article_config'];
				}
}
	
/********************************************************
 * Affichage page
 */
 		echo '&lt;=== <b>.: - Admin - :.</b> ===&gt;</p><p><em><b>';
  		echo "$strAc_commandes";
		echo '</b></em> :';

/********************************************************
 * test commande actif, encours o off
 */
 
 	if ($_GET['admin'] == "statuson") 
		{
		$sqllustss = "UPDATE `${dbprefix}config` SET article='on'";
		$reqlustss = mysql_query($sqllustss) or die('Erreur SQL !<br>'.$sqllustss.'<br>'.mysql_error());
		} 
	else if ($_GET['admin'] == "statusoff") 
		{
		$sqllustss = "UPDATE `${dbprefix}config` SET article='off'";
		$reqlustss = mysql_query($sqllustss) or die('Erreur SQL !<br>'.$sqllustss.'<br>'.mysql_error());
		
			if ($_GET['annule']!= "") 
				{
				$delt_id = $_GET['annule'];
				$sqldelt = "DELETE FROM `${dbprefix}article` WHERE cid='$delt_id'"; 
				$reqdelt = mysql_query($sqldelt) or die('Erreur SQL !<br>'.$sqldelt.'<br>'.mysql_error());
				}
		}
		else if ($_GET['admin'] == "statusok") 
				{
				$sqllustss = "UPDATE `${dbprefix}config` SET article='ok'";
				$reqlustss = mysql_query($sqllustss) or die('Erreur SQL !<br>'.$sqllustss.'<br>'.mysql_error());
		
				if ($_GET['cid'] == "ok") 
					{
					$sqllistc2 = "SELECT article_config FROM ${dbprefix}config"; 
					$reqlistc2 = mysql_query($sqllistc2) or die('Erreur SQL !<br>'.$sqllistc2.'<br>'.mysql_error());
				
					while($datalistc2 = mysql_fetch_array($reqlistc2)) 
   	 					{
						$lcid2=$datalistc2['article_config'];
						}
					
					$lcid2 = $lcid2+1;
					$sqllustss2 = "UPDATE `${dbprefix}config` SET article_config='$lcid2'";
					$reqlustss2 = mysql_query($sqllustss2) or die('Erreur SQL !<br>'.$sqllustss2.'<br>'.mysql_error());
					}
				}
		
		
		$sqlst = "SELECT article FROM ${dbprefix}config"; 
		$reqst = mysql_query($sqlst) or die('Erreur SQL !<br>'.$sqlst.'<br>'.mysql_error());
	
	while($datast = mysql_fetch_array($reqst)) {$status=$datast['article'];}
	
	if ($status == "on") { $s_test="on";}
	
	else if($status == "off") { $s_test="off";}
	
	else if($status == "ok") { $s_test="ok";}
 
/********************************************************
 * Annalyse test commande actif, encours o off
 */		
		if ($s_test=="on") 
			{
   			echo '<a href="?page=ac_spe&op=admin&admin=statusoff"><b><font color="#009900" size="-2">ON</font></b></a><font size="-2">'; 
    		}
	
		if($s_test=="ok") 
			{
			echo " - ";
    		}
			
		if($s_test=="off") 
			{ 
    		echo '<a href="?page=ac_spe&op=admin&admin=statuson"><b><font color="#FF0000" size="-2">OFF</font></b></a></font>'; 
			} 
  
  		if ($s_test=="ok")
			{
			echo '<a href="?page=ac_spe&op=admin&admin=statusoff"><b><font color="blue" size="-2">';
    		echo "$strAc_cmdlancer";
			echo '</font></b></a></font>';
  			echo'<br><br><b><font color="red" size="-2"><u>';
			echo "$strAc_ifcmdok";
			echo '</u></font></b><br>';
  			}
 	
		echo '</p><p><br>';
		echo '<a href="?page=ac_spe&op=admin&admin=add"><font color="#FF6600""><u><b><font size="-1">';
		echo "$strAc_ajouter";
		echo '</font></b></u></font></a><font size="-1"> | <a href="?page=ac_spe&op=admin&admin=del"><b><u><font color="#FF6600"">';
		echo "$strAc_enlever";
		echo '</font></u></b></A> | <a href="?page=ac_spe&op=admin&admin=list"><b><u><font color="#FF6600"">';
		echo "$strAc_lister";
		echo '</font></u></b></a></font><a href="?page=ac_spe&op=admin&admin=list">'; 
    	echo '</a></p>';
		echo '</div><br>';
		
		
	if ($_GET['admin']== "list") 
		{
		echo '<strong><font size="-1">';
		echo "$strAc_wlisting";
		echo '</font></strong><strong><font size="-1"> : ';
		echo '[ <a href="?page=ac_spe&op=admin&admin=list&ac_op=regle"><font color="green">';
		echo "$strAc_paiment";
		echo '</strong></font></a><strong> | <a href="?page=ac_spe&op=admin&admin=list&ac_op=prit"><font color="navy">';
		echo "$strAc_recep";
		echo '</font></a> | <a href="?page=ac_spe&op=admin&admin=list&ac_op=arrive"><font color="blue">';
		echo "$strAc_cmdarriver";
		echo '</font></a> | <a href="?page=ac_spe&op=admin&admin=list&ac_op=del"><font color="red">';
		echo "$strAc_annulation";
		echo '</a></font></strong> <b>]</b></font>';
		}

/********************************************************
 * Formulaire D'ajout d'article
 */
if ($_GET['admin'] == "add") 
		{
		
			echo '<br><center>'; 
			echo '<form name="formaddX" method="post" action="?page=ac_spe&op=admin&admin=add&up=addX">'; 
 			echo '<table width="360" border="1" cellpadding="1">'; 
   			echo '<tr> '; 
     		echo '<td width="94" bgcolor="#CCCCCC"><font color="#000066"><b>';
			echo "$strAc_name";
			echo '&nbsp;:</b></font></td>'; 
			echo '<td width="151"><input type="text" name="addarticle"></td>'; 
      		echo '<td width="93" rowspan="3" align="center" valign="middle" bgcolor="#CCCCCC"><input type="submit" name="Submit" value=" -&nbsp;'; 
			echo "$strAc_add";
			echo '&nbsp;- "></td></tr><tr> '; 
            echo '<td bgcolor="#CCCCCC"><font color="#000066"><b>';
			echo "$strAc_Composition";
			echo '&nbsp;:</b></font></td>'; 
      		echo '<td><input type="text" name="addingred"></td>'; 
    		echo '</tr><tr> '; 
      		echo '<td bgcolor="#CCCCCC"><font color="#000066"><b>';
			echo "$strAc_prix";
			echo '&nbsp;:</b></font></td>'; 
      		echo '<td><input type="text" name="addprix">€</td>'; 
    		echo '</tr>'; 
  			echo '</table>'; 
  			echo '</form></center>'; 
	
		
		
}
/********************************************************
 * Formulaire enlever un article
 */
	if ($_GET['admin'] == "del") 
		{
			echo '<br><form name="artdel" method="post" action="?page=ac_spe&op=admin&admin=del&art=oui&act=delxp">';
			echo '<table width="461" border="1" cellpadding="1">';
 			echo '<tr bordercolor="#000000" bgcolor="#003300">';
    		echo '<td colspan="4"> <div align="center"><font color="#FF3300"><b>';
			echo "$strAc_art";
			echo '</b></font></div></td>';
 			echo '</tr>';
  			echo '<tr bordercolor="#000000" bgcolor="#000033">'; 
			echo '<td><font color=#55BBFF><b>ID</b></font></td>';
    		echo '<td width="349"> <div align="center"><font color="#CCFFFF"><b>';
			echo "$strAc_arti";
			echo '</b></font></div></td>';
    		echo '<td width="46"> <div align="center"><font color="#CCFFFF"><b>';
			echo "$strAc_euro";
			echo '</b></font></div></td>';
    		echo '<td align="center" valign="middle"><font color="#CCFFFF">';
			echo "$strS";
  			echo '</font></td></tr>';
 
			$sqldell = "SELECT * FROM ${dbprefix}listarticle ORDER BY id"; 
			$reqdell = mysql_query($sqldell) or die('Erreur SQL !<br>'.$sqldell.'<br>'.mysql_error());
			$di=0;
			while($datadell = mysql_fetch_array($reqdell)) 
   	 				{
					$di++;
					$name_article = $datadell['article'];
					
							echo '<tr><td align="center">'.$datadell['id'].'</td><td width="399" valign="middle">'.$datadell['article'].' - '.$datadell['ingred'].'</td>';
							echo '<td width="46"><div align="center">'.$datadell['prix'].'</div></td>';
							echo '<td valign="middle" align="center">';
							echo '<input name="boxdel" type="checkbox"  style="background=\'red\'" onClick=\'if(this.checked) {samedel();document.artdel.chaindel.value=document.artdel.chaindel.value+this.value+"|";}else{this.checked=true;alert ("Effacer en mode expert ou faite -Reset-");}\' value="'.$datadell['id'].'">';
							echo '</td></tr>'; 
					
					}//en while 1
					echo '</table>';
					 		echo '<br><center><p><strong><font size="-1"><u>';
		echo "$strAc_anu";
		echo '</u></font></strong>'; 
        echo '&nbsp;:<br>';
     	echo '<font size="-1">';
		echo "$strAc_readme";
       	echo '</font </p><p></center>';
   		echo '<table align="center" width="80%" border="0" cellspacing="1" cellpadding="1">';
   		echo '<tr>';
     	echo '<td align="right">'; 
        echo '<input type="text" name="chaindel" value="">';
        echo '<input type="text" name="nbdel">';
        echo '<input type="hidden" name="up" value="ok">';
     	echo '<input type="submit" name="s" value="- OK -">';
 		echo '</td>';
		echo '<td><input type="reset" name="Reset" value="- RESET -" style="color:red">';
 		echo '</td>';
   		echo '</tr>';
 		echo '</table></form>';
		
		echo '<table border="0" cellspacing="1" cellpadding="1">';
  		echo '<tr><td><div name="faq">';
		echo "$strAc_consae";
		echo '</div></td></tr>';
		echo '</table>';
			
}//end bloc
/********************************************************
 * Formulaire g&eacute;n&eacute;rale
 */
if ($_GET['admin']== "list") 
	{
		
		if ($_GET['ac_op']=="regle") {$ac_op="regxp";$ac_chex_color="green";$ac_w=$_GET['ac_op'];$ac_l="[<font color=\"green\"><b>P</b></font>]";}
		elseif ($_GET['ac_op']=="arrive") {$ac_op="arvxp";$ac_chex_color="blue";$ac_w=$_GET['ac_op'];$ac_l="[<font color=\"blue\"><b>C</b></font>]";}
		elseif ($_GET['ac_op']=="prit") {$ac_op="prixp";$ac_chex_color="navy";$ac_w=$_GET['ac_op'];$ac_l="[<font color=\"navy\"><b>R</b></font>]";}
		elseif ($_GET['ac_op']=="del") {$ac_op="delxp";$ac_chex_color="red";$ac_w=$_GET['ac_op'];$ac_l="[<font color=\"red\"><b>A</b></font>]";}
		elseif ($_GET['ac_op']=="") {$ac_op="delxp";$ac_chex_color="red";$ac_w="del";$ac_l="[<font color=\"red\"><b>A</b></font>]";}

	
		echo '<form action="?page=ac_spe&op=admin&admin=list&act='.$ac_op.'&ac_op='.$ac_w.'" name="history" method="post">';		
		echo '<br>';
		echo '<table cellspacing="1" cellpadding="1">';
 	 	echo '<tr>';
    	echo '<td><font color="#0000FF"><strong>ID :</strong></font>';
		echo " $strAc_cnumid";
		
		if ($ac_w=="regle") 
			{
			echo '<br><font color="green"><strong>P : </strong></font>';
     		echo "$strAc_P";
			}
		elseif ($ac_w=="arrive") 
			{
			echo '<br><font color="blue"><strong>C : </strong></font>';
     		echo "$strAc_C";
			}
		elseif ($ac_w=="prit")
			{
			echo '<br><font color="navy"><strong>R : </strong></font>';
     		echo "$strAc_R";
			}
		elseif ($ac_w=="del") 
			{
			echo '<br><font color="red"><strong>A : </strong></font>';
     		echo "$strAc_A";
			}
		elseif ($ac_w=="") 
			{
			echo '<br><font color="red"><strong>A : </strong></font>';
     		echo "$strAc_A";
			}
    
 	 	echo '</td></tr>';
		echo '</table>';
		echo '<br /><br /><br />';

	
		echo '<table width="593" border="1" cellpadding="1">';
    	echo '<tr bgcolor="#99CCFF">';
      	echo '<td width="24" bgcolor="#000033"><div align="center"><font color="#FFFFFF"><b>ID</b></font></div></td>';
      	echo '<td width="464" valign="middle"><div align="center"><font color="#000033"><b> ';
        echo '<font color="#000033"><b>';
		echo "$strAc_infocmd"; 
		echo '</b></font>';
       
/********************************************************
 * Select de la var $wtl
 */	   
	    echo '<select name="menu1" onChange="MM_jumpMenu(\'parent\',this,1)" style="font-size :14px; font-family : courrier;background-color : yellow; color=gold">'; 
        echo '<option value="?page=ac_spe&op=admin&admin=list&wtl='.$lcid.'" style="background-color : #0000DD" selected><b>'.$lcid.'</b></option>';
          
		$sqlliwt = "SELECT DISTINCT cid FROM ${dbprefix}article"; 
  		$reqliwt = mysql_query($sqlliwt) or die('Erreur SQL !<br>'.$sqlliwt.'<br>'.mysql_error());
		
		while($dataliwt = mysql_fetch_array($reqliwt)) 
   			{
          	echo '<option value="?page=ac_spe&op=admin&admin=list&wtl='.$dataliwt['cid'].'" style="background-color : #000044">'.$dataliwt['cid'].'</option>';
            } 
         
		 echo '</select>';
         echo ' </b></font></div></td>';
      	 echo '<td width="40"><div align="center"><font color="#000033"><b>';
		 echo "$strAc_euro";
		 echo '</b></font></div></td>';
         echo ' <td width="37"><div align="center">'.$ac_l.'</div></td>';
         echo '</tr>';
/********************************************************
* RAZ prix + check N° commande
*/         
	
		
	 
		 $total_prix =0;
		 $sqllist = "SELECT * FROM ${dbprefix}article WHERE cid='$lcid' ORDER BY pseudo"; 
		 $reqlist = mysql_query($sqllist) or die('Erreur SQL !<br>'.$sqllist.'<br>'.mysql_error());
		 $pt=mysql_num_rows($reqlist); 
    
		 $ilist=0;
		
		while($datalist = mysql_fetch_array($reqlist)) 
   	 				{
					$ilist++;
					$list_prix = $datalist['prix'];
					$ulcid = $datalist['cid'];
					$total_prix = $total_prix + $list_prix;
					
					if ($ulcid == $lcid)
						{
						 if ($pt != 0) 
							{
   							echo '<tr> ';
							echo '<td align="center" bgcolor="#000033"> <font color="#FFFFFF">'.$datalist['id'].'</font></td>';
							echo '<td align="center"><a href="?page=messagerie&op=ecrire&destinataire='.$datalist['idj'].'"><b><u><font color="#006600"  size="-1">'.$datalist['pseudo'].'</font></u></b></a>';
							echo "&nbsp;$strAc_acmd"; 
							echo '<font color="#000066" size="-1"><b>&nbsp;'.$datalist['article'].'</b></font></td>';
							echo '<td align="center">'.$datalist['prix'].'</td>';
							echo '<td align="center">'; 


		if ($ac_w=="regle") 
			{
				if ($datalist['regle'] == "N")
					{
					echo '<input name="box" type="checkbox"  style="background=\''.$ac_chex_color.'\'" onClick=\'if(this.checked) {same();document.history.chaindel.value=document.history.chaindel.value+this.value+"|";}else{this.checked=true;alert ("Effacer en mode expert ou faite -Reset-");}\' value="'.$datalist['id'].'">';
					}
				else if($datalist['regle'] == "O") 
					{
					echo '<input type="checkbox"  style="background=\''.$ac_chex_color.'\'" disabled checked>';
					}
			}
		elseif ($ac_w=="arrive") 
			{
				if ($datalist['arrive'] == "N")
					{
					echo '<input name="box" type="checkbox"  style="background=\''.$ac_chex_color.'\'" onClick=\'if(this.checked) {same();document.history.chaindel.value=document.history.chaindel.value+this.value+"|";}else{this.checked=true;alert ("Effacer en mode expert ou faite -Reset-");}\' value="'.$datalist['id'].'">';
					}
				else if($datalist['arrive'] == "O" || $datalist['arrive'] == "X") 
					{
					echo '<input type="checkbox"  style="background=\''.$ac_chex_color.'\'" disabled checked>';
					}
			}
		elseif ($ac_w=="prit")
			{
			if ($datalist['arrive'] == "N" || $datalist['arrive'] == "O")
					{
					echo '<input name="box" type="checkbox"  style="background=\''.$ac_chex_color.'\'" onClick=\'if(this.checked) {same();document.history.chaindel.value=document.history.chaindel.value+this.value+"|";}else{this.checked=true;alert ("Effacer en mode expert ou faite -Reset-");}\' value="'.$datalist['id'].'">';
					}
				else if($datalist['arrive'] == "X") 
					{
					echo '<input type="checkbox"  style="background=\''.$ac_chex_color.'\'" disabled checked>';
					}
			}
		elseif ($ac_w=="del") 
			{
			echo '<input name="box" type="checkbox"  style="background=\''.$ac_chex_color.'\'" onClick=\'if(this.checked) {same();document.history.chaindel.value=document.history.chaindel.value+this.value+"|";}else{this.checked=true;alert ("Effacer en mode expert ou faite -Reset-");}\' value="'.$datalist['id'].'">';
			}
		elseif ($ac_w=="") 
			{
			echo '<input name="box" type="checkbox"  style="background=\''.$ac_chex_color.'\'" onClick=\'if(this.checked) {same();document.history.chaindel.value=document.history.chaindel.value+this.value+"|";}else{this.checked=true;alert ("Effacer en mode expert ou faite -Reset-");}\' value="'.$datalist['id'].'">';
			}							

							echo '</td>';
							echo '</tr>';
     						
							}//end $pt test
  						}//$ulcid test
  
 					}//end whil listing 
					
/********************************************************
* Pas de commande
*/
if($pt == 0){	
  
  		$disabled="disabled";		
		
		echo '<tr>';
      	echo '<td width="24" bgcolor="#000033"><div align="center"><font color="#FFFFFF"><b>-</b></font></div></td>';
      	echo '<td width="464"><div align="center"><font color="#FF0000"><b><em>  - ';
        echo "$strAc_nocmd";
      	echo '</em> -</b></font></div></td><td width="40"><div align="center"><font color="#000033"><b>-</b></font></div></td>';
        echo '<td width="37"><div align="center"><font color="#FF0000"><b>-</b></font></div></td>';
    	echo '</tr>';
    
}
/********************************************************
* Commande d&eacute;tect&eacute;.. bzzp pr&eacute;senter vos papier... On plaisante pas ^^
*/

   		echo '<tr bgcolor="#99CCFF">';
      	echo '<td align="center" bgcolor="silver"><font color="#FFFFFF">';
		
	if ($_GET['wtl'] != "")
		{
		echo'<img src="images/G4/ok.gif" alt="';
		echo "$strAc_cmdtrt";
		echo '" border="0">';
		}
	if ($_GET['wtl'] == "")
		{
		echo '<a href="?page=ac_spe&op=admin&admin=statusok&cid=ok"><div align="center"><img src="images/G4/yes.gif" alt="';
		echo "$strAc_valcmd";
		echo '" border="0"></div></a>';
		} 
		
		echo'</font></td>';
      	echo '<td align="center"><div align="left"><b><u><font size="+1">';
		echo "$strAC_total";
        echo '</font></u>:&nbsp;</b><b><font color="#FF0000">'.$pt.'</font></b><font size="-1"><b> ';
        echo "$strAc_command";
		echo '</b>&nbsp;<font color="#FF0000"><b>'.$total_prix.'</b></font></font> ';
        echo '<font size="-1"><b>';
		echo "$strAc_euro";
		echo '</b>';
         
/********************************************************
* wlt = ''
*/
if ($_GET['wtl'] == "")
	{
	 
	 	echo '<font size="-1">';
		//echo "$strAc_wdoyouwant";
		echo '</font>';
	
	}else{
	
	 	echo '<font size="-1">-&nbsp';
		echo "$strAc_cmddejapasser";
		echo '&nbsp;-</font>';

} 

        echo '</font></div></td>';
        echo '<td align="center"><b><font color="red" face="Arial, Helvetica, sans-serif">'.$total_prix.'</font></b></td>';
	    echo '<td align="center">';
        //echo '<a href="?page=ac_spe&op=admin&admin=statusoff&annule='.$lcid.'"><div align="center"><img src="images/G4/non.gif" onClik="javascipt:confirm ("ATENTION !!!\nVous allez effacer d&eacute;finitivement\nLa totalit&eacute; des comandes de cette commande\n");" alt="';
		//echo "$strAc_annueff"; 
		//echo '&nbsp;(N°'.$lcid.')" border="0"></div>';
		

	
	if ($ac_w=="regle") 
			{
			echo '<input name="box" type="checkbox"  style="background=\''.$ac_chex_color.'\'" onClick=\'if(this.checked) {if (confirm("';
			echo "$strAC_alerteregle";
			echo '")){location.replace ("?page=ac_spe&op=admin&admin=list&allregle='.$lcid.'");}}\'" '.$disabled.'>';					
			}
		elseif ($ac_w=="arrive") 
			{
			echo '<input name="box" type="checkbox"  style="background=\''.$ac_chex_color.'\'" onClick=\'if(this.checked) {if (confirm("';
			echo "$strAC_alertea";
			echo '")){location.replace ("?page=ac_spe&op=admin&admin=list&allarrive='.$lcid.'");}}\'" '.$disabled.'>';					
			}
		elseif ($ac_w=="prit")
			{
			echo '<input name="box" type="checkbox"  style="background=\''.$ac_chex_color.'\'" onClick=\'if(this.checked) {if (confirm("';
			echo "$strAC_alerteprit";
			echo '")){location.replace ("?page=ac_spe&op=admin&admin=list&allprit='.$lcid.'");}}\'" '.$disabled.'>';					
			}
		elseif ($ac_w=="del") 
			{
			echo '<input name="box" type="checkbox"  style="background=\''.$ac_chex_color.'\'" onClick=\'if(this.checked) {if (confirm("';
			echo "$strAC_alertedel";
			echo '")){location.replace ("?page=ac_spe&op=admin&admin=statusoff&annule='.$lcid.'");}}\'" '.$disabled.'>';					
			}
		elseif ($ac_w=="") 
			{
			echo '<input name="box" type="checkbox"  style="background=\''.$ac_chex_color.'\'" onClick=\'if(this.checked) {if (confirm("';
			echo "$strAC_alertedel";
			echo '")){location.replace ("?page=ac_spe&op=admin&admin=statusoff&annule='.$lcid.'");}}\'" '.$disabled.'>';					
			}

		 
		echo '</a></td>';
     	echo '</tr>';
		echo '</table>';
 		echo '<br><center><p><strong><font size="-1"><u>';
		echo "$strAc_anu";
		echo '</u></font></strong>'; 
        echo '&nbsp;:<br>';
     	echo '<font size="-1">';
		echo "$strAc_readme";
       	echo '</font </p><p></center>';
   		echo '<table align="center" width="80%" border="0" cellspacing="1" cellpadding="1">';
   		echo '<tr>';
     	echo '<td align="right">'; 
        echo '<input type="text" name="chaindel" value="">';
        echo '<input type="text" name="nbdel">';
        echo '<input type="hidden" name="up" value="ok">';
     	echo '<input type="submit" name="s" value="- OK -">';
 		echo '</td>';
		echo '<td><input type="reset" name="Reset" value="- RESET -" style="color:red">';
 		//echo '<td><form action="?page=ac_spe&op=admin" name="reset" method="post"><input type="submit" onClick="javascript:resetall()" value="- RESET -" style="color:red"></form>';
 		echo '</td>';
   		echo '</tr>';
 		echo '</table>';
 		echo '<p align="left"><br>';
   		echo '<br></form><br></p>';
 
  

		echo '<table border="0" cellspacing="1" cellpadding="1">';
  		echo '<tr><td><div name="faq">';
		echo "$strAc_consae";
		echo '</div></td></tr>';
		echo '</table>';
		
}// end if admin == list



/********************************************************
 * Rechercher un joueur
 */

if($ac_op == "rechj") {
	$pseudo = $_POST['pseudo'];
	$str='';
	$erreur=0;
			
	if(!$pseudo) {
		$erreur=1;
		$str.="- $strElementsPseudoInvalide<br>";
	}
	if($erreur==1) {		
		show_erreur_saisie($str);
	}
	else {
	
	$rech_ps='x';
	
	if($pseudo!="*") 
	{
	
		$db->select("id, pseudo");
		$db->from("${dbprefix}joueurs WHERE pseudo='$pseudo'");
		$res = $db->exec();
	
		while ($rech_joueur = $db->fetch($res)) {
		$rech_id = $rech_joueur->id;
		$rech_ps = $rech_joueur->pseudo;
		}
	}
		if ($pseudo != $rech_ps)
			{
			if ($pseudo!="*")
				{
				$conca="%";
				$pseudo=$conca.$pseudo.$conca;
				$db->select("id, pseudo");
				$db->from("${dbprefix}joueurs WHERE pseudo LIKE '$pseudo'");
				$res = $db->exec();
				}
			else if ($pseudo=="*")
				{
				$db->select("*");
				$db->from("${dbprefix}joueurs ORDER BY pseudo ASC");
				$res = $db->exec();
				}
			
			$newspseudo='';
			
			while ($rech_joueur = $db->fetch($res)) 
				{
				$rech_ps = $rech_joueur->pseudo;
				
				$newpseudo =$newpseudo.'<option value="'.$rech_ps.'">'.$rech_ps.'</option>';
				
				}
			if($rech_ps=="" || $rech_ps==NULL) 
			{
			echo "<br><img src=images/warning.gif border=0 align=absmiddle>&nbsp;<span class=info><b>- $strRechInvalide</b></span>";
			echo "<br><br><span class=warning>$strAc_listnickfailed</span>";
			echo "<br><img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br><br>";

			} else {
				if ($pseudo!="*") {
			echo "<br><img src=images/warning.gif border=0 align=absmiddle>&nbsp;<span class=info><b>- $strRechInvalide</b>";
			echo "<br><br>$strAc_listnick :</span><br>";
					  }
			echo '<br /><form method="post" action="?page=ac_spe&op=admin&ac_op=rechj">';
			echo '<table border=0 cellpadding="0" cellspacing="0" class="bordure2"><tr><td>';
			echo '<table cellspacing="1" cellpadding="0" border="0">';
			echo "<tr><td class=\"headerfiche\">$strRechercherJoueur</td></tr>";
			echo '<tr><td>';
			echo '<table cellspacing="0" cellpadding="3" border="0" width="100%">';
			echo '<tr>';
			echo "<td class=\"titlefiche\">$strPseudo <font color=\"red\"><b>*</b></font> :</td>";
			echo '<td class="textfiche"> <select name="pseudo"<option value="*" selected></option>';
            echo "$newpseudo";
            echo '</select>';
            echo '</td>';
			echo '</tr>';
			echo "<tr><td class=\"footerfiche\" align=\"center\" colspan=\"2\"><input type=\"submit\" class=\"action\" value=\"$strRechecrher\"></td></tr>";
			echo '</table>';
			echo '</td></tr></table>';
			echo '</td></tr></table></form>';
			echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action><b>$strRetour</b></a><br>";
			$rech_help="oui";
			}
			
		} else {
		
		/*** redirection ***/
		js_goto("?page=ac_spe&id=$rech_id&op=admin&pseudo=$pseudo");
		
		} 
	}
}

if ($_GET['ac_op']=="rechup") {
/********************************************************
 * Effacer expert 2
 */
		$ichaine_req = $_POST['ichaindel'];
		$iarray_chaine = explode('|', $ichaine_req); 

		$imax=$_POST['inbdel'];
		$iidel="id='-1'";
		
		for($iw=0; $iw<=$imax; $iw++)
			{
	 		
			if($iarray_chaine[$iw]!='')
	 			{
			 	$iidel=$iidel." OR id='".$iarray_chaine[$iw]."'";
				} 
			}
		$isqldel = "DELETE FROM `${dbprefix}article` WHERE ";
		$isqldel =$isqldel.$iidel;
		$ireqdel = mysql_query($isqldel) or die('Erreur SQL !<br>'.$isqldel.'<br>'.mysql_error());
		

/********************************************************
 * A payer expert 2
 */
		$pchaine_req = $_POST['pchaindel'];
		$parray_chaine = explode('|', $pchaine_req); 

		$pmax=$_POST['rnbdel'];
		$pidel="id='-1'";
		
		for($pw=0; $pw<=$pmax; $pw++)
			{
	 		
			if($parray_chaine[$pw]!='')
	 			{
			 	$pidel=$pidel." OR id='".$parray_chaine[$pw]."'";
				} 
			}
		$psqldel = "UPDATE `${dbprefix}article` SET regle='O' WHERE ";
		$psqldel =$psqldel.$pidel;
		$preqdel = mysql_query($psqldel) or die('Erreur SQL !<br>'.$psqldel.'<br>'.mysql_error());
		

/********************************************************
 * Commande arriv&eacute;e 2
 */

		$xchaine_req = $_POST['xchaindel'];
		$xarray_chaine = explode('|', $xchaine_req); 

		$xmax=$_POST['xnbdel'];
		$xidel="id='-1'";
		
		for($xw=0; $xw<=$xmax; $xw++)
			{
	 		
			if($xarray_chaine[$xw]!='')
	 			{
			 	$xidel=$xidel." OR id='".$xarray_chaine[$xw]."'";
				} 
			}
		$xsqldel = "UPDATE `${dbprefix}article` SET arrive='O' WHERE ";
		$xsqldel =$xsqldel.$xidel;
		$xreqdel = mysql_query($xsqldel) or die('Erreur SQL !<br>'.$xsqldel.'<br>'.mysql_error());
		

/********************************************************
 * A prit ça commande 2
 */

		$rchaine_req = $_POST['rchaindel'];
		$rarray_chaine = explode('|', $rchaine_req); 

		$rmax=$_POST['rnbdel'];
		$ridel="id='-1'";
		
		for($rw=0; $rw<=$rmax; $rw++)
			{
	 		
			if($rarray_chaine[$rw]!='')
	 			{
			 	$ridel=$ridel." OR id='".$rarray_chaine[$rw]."'";
				} 
			}
		$rsqldel = "UPDATE `${dbprefix}article` SET arrive='X', regle='O' WHERE ";
		$rsqldel =$rsqldel.$ridel;
		$rreqdel = mysql_query($rsqldel) or die('Erreur SQL !<br>'.$rsqldel.'<br>'.mysql_error());
		


}

if ($_GET['id']!="") 
	{
		$id=$_GET['id'];
		$pseudo=$_GET['pseudo'];
		
		echo '<br /><br /><p align="left">&nbsp;&nbsp;&nbsp;[<font color="green"><b>P</b></font>] ';
		echo "$strAc_P";
		echo '<br />&nbsp;&nbsp;&nbsp;[<font color="blue"><b>C</b></font>] ';
		echo "$strAc_C";
		echo '<br />&nbsp;&nbsp;&nbsp;[<font color="navy"><b>R</b></font>] ';
		echo "$strAc_R";
		echo '<br />&nbsp;&nbsp;&nbsp;[<font color="red"><b>A</b></font>] ';
		echo "$strAc_A";
		echo '</P><br /><br />';
		echo '<form action="?page=ac_spe&op=admin&pseudo='.$pseudo.'&id='.$id.'&ac_op=rechup" name="one" method="post">';
		echo '<table width="95%" border="1" cellspacing="1" cellpadding="1" align="center" valign="middle">';
		echo '<tr bgcolor="#000055"> ';
		echo '<td colspan="8"><div align="center"><strong><font color="#FFFFFF">';
		echo "$strAc_histr";
		echo '</font><a href="?page=messagerie&op=ecrire&destinataire='.$id.'"><font color="#66BBFF"><b>'.$pseudo.'</b></font></a></div></strong></td>';
		echo '</tr>';
		echo '<tr> ';
		echo '<td bgcolor="#CCCCCC"><font color="#0000FF"><div align="center"><b>ID</b></font></td>';
		echo '<td width="135"><div align="center"><strong>';
		echo "$strAc_cmdnum";
		echo'</strong></div></td>';
		echo '<td><div align="center"><strong>';
		echo "$strAc_arti";
		echo '</strong></div></td>';
		echo '<td align="center"><div align="center"><strong>';
		echo "$strAc_prix";
		echo '</strong></div></td>';
		echo '<td width="20" align="center"><div align="center"><strong>[<font color="green">P</font>]</strong></div></td>';
		echo '<td width="20" align="center"><div align="center"><strong>[<font color="blue">C</font>]</strong></div></td>';
		echo '<td width="20" align="center"><div align="center"><strong>[<font color="navy">R</font>]</strong></div></td>';
		echo '<td width="20" align="center"><div align="center"><strong>[<font color="red">A</font>]</strong></div></td>';
		echo '</tr>';
		
			$sqlrech = "SELECT * FROM ${dbprefix}article WHERE pseudo='$pseudo' ORDER BY cid"; 
			$reqrech = mysql_query($sqlrech) or die('Erreur SQL !<br>'.$sqlrech.'<br>'.mysql_error());

 			while($datarech = mysql_fetch_array($reqrech)) 
   	 				{
					$rech_j_cmd_test=$datarech['article'];

					if ($datarech['regle']=="N")
						{
						$prix='<input name="P" type="checkbox"  style="background=\'green\'" onClick=\'if(this.checked) {samep();document.one.pchaindel.value=document.one.pchaindel.value+this.value+"|";}else{this.checked=true;alert ("Effacer en mode expert ou faite -Reset-");}\' value="'.$datarech['id'].'">';
						}
					else if ($datarech['regle']=="O")
						{
						$prix='<input name="P" type="checkbox"  style="background=\'green\'"  disabled checked>';
						}
					if ($datarech['arrive']=="N")
						{
						$arrive='<input name="C" type="checkbox"  style="background=\'blue\'" onClick=\'if(this.checked) {samex();document.one.xchaindel.value=document.one.xchaindel.value+this.value+"|";}else{this.checked=true;alert ("Effacer en mode expert ou faite -Reset-");}\' value="'.$datarech['id'].'">';
						$reception='<input name="R" type="checkbox"  style="background=\'navy\'" onClick=\'if(this.checked) {samer();document.one.rchaindel.value=document.one.rchaindel.value+this.value+"|";}else{this.checked=true;alert ("Effacer en mode expert ou faite -Reset-");}\' value="'.$datarech['id'].'">';
						}
					else  if ($datarech['arrive']=="O")
						{
						$arrive='<input name="C" type="checkbox"  style="background=\'blue\'"  disabled checked>';
						$reception='<input name="R" type="checkbox"  style="background=\'navy\'" onClick=\'if(this.checked) {samer();document.one.rchaindel.value=document.one.rchaindel.value+this.value+"|";}else{this.checked=true;alert ("Effacer en mode expert ou faite -Reset-");}\' value="'.$datarech['id'].'">';
						}
					elseif ($datarech['arrive']=="X")
						{
						$arrive='<input name="C" type="checkbox" style="background=\'blue\'"  disabled checked>';
						$reception='<input name="C" type="checkbox" style="background=\'navy\'"  disabled checked>';
						}	
							
		echo '<tr> ';
		echo '<td bgcolor="#CCCCCC" align="center"><font color="#3366FF"><b>'.$datarech['id'].'</b></font></td>';
		echo '<td><div align="center">'.$datarech['cid'].'</div></td>';
		echo '<td><div align="center">'.$datarech['article'].'</div></td>';
		echo '<td><div align="center">'.$datarech['prix'].'</div></td>';
		echo '<td><div align="center">'.$prix.'</div></td>';
		echo '<td><div align="center">'.$arrive.'</div></td>';
		echo '<td><div align="center">'.$reception.'</div></td>';
		echo '<td><div align="center"><input name="A" type="checkbox"  style="background=\'red\'" onClick=\'if(this.checked) {sami();document.one.ichaindel.value=document.one.ichaindel.value+this.value+"|";}else{this.checked=true;alert ("Effacer en mode expert ou faite -Reset-");}\' value="'.$datarech['id'].'"></div></td>';
		echo '</tr>';
					}
		if ($rech_j_cmd_test=="" || $rech_j_cmd_test==NULL) 		
					{
		echo '<tr> ';
		echo '<td colspan="8"><div align="center"><b><font color="red">';
		echo "$strAc_rechcmdno";
		echo '</font></b></div></td></tr>';
					}	
		echo '</table><br /><br />';
		
		
		echo '<table width="80%" border="0" cellspacing="1" cellpadding="1">';
    	echo '<tr>';
      	echo '<td><p align="center"><b><u>';
	  	echo "$strAc_anu";
	  	echo '</b></u></p>';
        echo '<p align="center"><strong>[<font color="green">P</font>] ';
        echo '<input type="text" name="pchaindel" value="">';
        echo '<input type="text" name="pnbdel" value="">';
        echo ' </strong></p>';
       	echo '<p align="center"><strong>[<font color="blue">C</font>] ';
        echo '<input type="text" name="xchaindel" value="">';
        echo '<input type="text" name="xnbdel" value="">';
        echo '</strong></p>';
        echo '<p align="center"><strong>[<font color="navy">R</font>] ';
        echo '<input type="text" name="rchaindel" value="">';
        echo '<input type="text" name="rnbdel" value="">';
        echo '</strong> </p>';
		echo '<p align="center"><strong>[<font color="red">A</font>] ';
        echo '<input type="text" name="ichaindel" value="">';
        echo '<input type="text" name="inbdel" value="">';
        echo '</strong> </p>';
        echo '<br /><p align="center">';
        echo '<input type="submit" name="s" value="- OK -">';
        echo '<input type="reset" name="Reset" value="- RESET -" style="color:red">';
        echo '</p>';
        echo '</form>';
        echo '</td>';
    	echo '</tr>';
  		echo '</table>';
}

if ($rech_help != "oui")
	{
			echo '<form method="post" action="?page=ac_spe&op=admin&ac_op=rechj">';									
			echo '<table border=0 cellpadding="0" cellspacing="0" class="bordure2"><tr><td>';
			echo '<table cellspacing="1" cellpadding="0" border="0">';
			echo "<tr><td class=\"headerfiche\">$strRechercherJoueur</td></tr>";
			echo '<tr><td>';
			echo '<table cellspacing="0" cellpadding="3" border="0" width="100%">';
			echo '<tr>';
			echo "<td class=\"titlefiche\">$strPseudo <font color=\"red\"><b>*</b></font> :</td>";
			echo '<td class="textfiche"><input type="text" name="pseudo" maxlength="20"></td>';
			echo '</tr>';
			echo "<tr><td class=\"footerfiche\" align=\"center\" colspan=\"2\"><input type=\"submit\" class=\"action\" value=\"$strRechecrher\"></td></tr>";
			echo '</table>';
			echo '</td></tr></table>';
			echo '</td></tr></table>';
			echo '</form>';
			echo "$strAc_rechehlp";
			echo '<br><br><bR>';
}
		
/********************************************************
 * Fin admin
 */
}
?>

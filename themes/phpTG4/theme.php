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

function theme_header() {
	global $config,$db,$mods,$s_joueur;
	global $strTournois,$strForum,$strInscriptions,$strAccueil,$strContact;
	global $config,$strRechecrher,$strDans,$strJoueurs,$strEquipes,$strNews,$strForum,$strSID,$strOK,$strSeRappeler,$checked,$strPseudo,$strPassword;
?>

<!-- Header [start] ------------------------------------------------>
<center>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td>
		
		<?php include ("header_joueur.php"); ?>
		
		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-left:1px;">
			<tr>
				<td background="themes/phptournois/images/story-title.gif">
					<table width="100%" border="0" cellspacing="0" cellpadding="2">
						<tr>
							<td colspan="3">
								<table cellspacing="0" cellpadding="0" width="100%" height="40" border="0">
									<tr>
										<td class="titlebar" align="left" width="80%">
											<?php
											if (!empty($config['logo'])) echo '&nbsp;&nbsp;<a href="'.$config['urlsite'].'"><img src="images/'.$config['logo'].'" border="0" align="absmiddle"></a>';
											echo '&nbsp;&nbsp;'.$config['nomsite'];
											?>
										</td>
										<td align="center" valign="top" width="20%">
											<a href="http://www.phptournois.net" target="_blank"><img src="images/phptournois.gif" height="40" border="0" align="absmiddle" alt="phptournois"></a>
										</td>
										<td align="center" valign="middle">
											<table cellspacing="2" cellpadding="2"  border="0">
												<tr><td><a href="?<?php echo $_SERVER['QUERY_STRING'];?>&lang=francais"><img src="images/flags/FR.gif" border="0" align="absmiddle"></a><a href="?<?php echo $_SERVER['QUERY_STRING'];?>&lang=english"><img src="images/flags/UK.gif" border="0" align="absmiddle"></a></td></tr>									
												<tr><td>&nbsp;</td></tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td align="left" width="10%">&nbsp;</td>
							<td align="center" class="title" width="80%">    
				     			 .:: <a class="menu" href="?page=index"><?php echo $strAccueil;?></a>&nbsp;&nbsp;
				     			  <?php if($config['forum']) {echo "<a href=\"?page=forum\">$strForum</a>&nbsp;&nbsp;";}
				    
								  if($config['inscription_joueur'] && !$s_joueur) {
									$nbinscrits=nb_joueurs_inscrit();
									$nbplaces=$config['places'];

									if($nbinscrits < $nbplaces) {
									echo "<a href=\"?page=joueurs&op=inscription\"><font color=\"red\"><b>$strSInscrire</b></font></a>";
									}
									}
								  //if($config['inscription_joueur']) 	echo "| <a href=\"?page=joueurs&op=inscription\">$strInscriptions</a>";?>
				    			  <a class="menu" href="?page=tournois"><?php echo $strTournois;?></a>&nbsp;&nbsp; 
				     			  <?php if($config['contact']) 				echo "<a href=\"?page=contact\">$strContact</a>&nbsp;&nbsp;";?>
				     			  ::.
				     		</td>
							<td align="right" width="10%">								
								
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		
		
		
		<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#000000">		
			<tr>
				<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td align="center" valign="top" class="back">
<!-- Header [end] -------------------------------------------------->
								<table width="100%" border="0" cellpadding="1" cellspacing="1" >
									<tr>										
										<?php 
										
										theme_menu_left();
										theme_opencenter();
}


function theme_footer() {
	global $config,$strVisites;
							
										theme_closecenter();
										theme_menu_right();
?>
									</tr>
								</table>							
<!-- Footer [start] ------------------------------------------------>
							</td>							
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="7"><img src="themes/phptournois/images/story-BL2.gif" width="7" height="30" alt=""></td>
				<td height="30" background="themes/phptournois/images/story-B2.gif">
					<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
						<tr>
							<td width="100%">
								<div class="poweredby" align="center">
								<!-- !!!! INTERDICTION D'ENLEVER LES MARQUES DE COPYRIGHT !!!  cf LICENCE !! -->
								Powered by&nbsp;<a class="poweredby" href="http://www.phptournois.net" target="_blank"><b><font color="blue">phpTournois</font></b></a>&copy;&nbsp;<?php echo $config['version'];?> - <?php affiche_compteur($compteur['visites']);?> <?php echo $strVisites;?>
        						</div>							
        					</td>
        					<td>
        <!--				<a href="include/html/panic.html"><img src="images/tux.gif" align="middle" alt='PANIC !!kh&eacute;h&eacute;h&eacute;&eacute;h&eacute;!!!' border="0"></a> -->
        					</td>
						</tr>
					</table>
				</td>
				<td width="7"><img src="themes/phptournois/images/story-BR2.gif" width="7" height="30"></td>
			</tr>
		</table>
	</td>
</tr>
</table>

<br>
</center>
<!-- Footer [end] ------------------------------------------------>
<?php
}

function theme_header_win() {	
?>

<!-- Header [start] ------------------------------------------------>
<center>
<img src="images/story-7px.gif" width="7" height="7" alt=""><br>

<table width="99%" border="0" cellspacing="0" cellpadding="2">
<tr>
	<td>
		<table width="100%" height="12" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="7"><img src="themes/phptournois/images/story-TL.gif" width="7" height="12" align="middle" alt=""></td>
				<td background="themes/phptournois/images/story-T.gif"><img src="images/story-7px.gif" width="7" height="7" alt=""></td>
				<td width="7"><img src="themes/phptournois/images/story-TR.gif" width="7" height="12" align="middle" alt=""></td>
			</tr>
		</table>

		<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#757575">
			<tr>
				<td bgcolor="#ffffff">
					<table width="100%" border="0" cellspacing="0" cellpadding="4">
						<tr>
							<td align="center">
<!-- Header [end] -------------------------------------------------->
<?php
}

function theme_footer_win() {
?>
<!-- Footer [Start] ------------------------------------------------>
			   				</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="7"><img src="themes/phptournois/images/story-BL.gif" width="7" height="12" align="middle" alt=""></td>
				<td background="themes/phptournois/images/story-B.gif"><img src="images/story-7px.gif" width="7" height="7" alt=""></td>
				<td width="7"><img src="themes/phptournois/images/story-BR.gif" width="7" height="12" align="middle" alt=""></td>
			</tr>
		</table>
	</td>
</tr>
</table>
<br>
</center>
<!-- Footer [end] ------------------------------------------------>
<?php
}

function theme_menu_left()
{
	global $mods;
	echo "<!-- Menu Gauche[start] -------------------------------------------------->\n";
	echo '<td valign="top" align="center">';
	echo '<div id="menudiv">';
	echo '<table cellpadding="0" cellspacing="0" width="140" border="0"><tr><td valign="top">';
	
	include("include/blocks/block_menu.php");
	//$show_tournois_status='';include("include/blocks/block_tournois.php")
	$show_tournois_status='E';include("include/blocks/block_tournois.php");
	$show_tournois_status='T';include("include/blocks/block_tournois.php");
	include("include/blocks/block_stats.php");
	//include("include/blocks/block_en_ligne.php");
	include("include/blocks/block_donation.php");
	if($config['shoutbox']){include("include/blocks/block_shoutbox.php");}
	
	// module TOP 10 à repositionn&eacute; au besoin ;)
	if($mods['topdl']){include("include/blocks/block_dl10.php");}
	if($mods['topplayer']){include("include/blocks/block_10player.php");}
	global $config,$db,$dbprefix,$s_membre;

 
 
if ($config['phpt_type'] != 'lan'){
 
		 $sql = "SELECT * FROM ${dbprefix}menu WHERE titre!='' AND align='G' ORDER BY orde"; 
		 $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		 
		 while($data = mysql_fetch_array($req)) 
			   {
		   $titre=$data['titre'];
		   
		   theme_openblock("$titre");
		   
		   $sql2 = "SELECT * FROM ${dbprefix}page WHERE lien!='' AND nmenu='$titre' ORDER BY orde"; 
			 $req2 = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
		   
		   while($data2 = mysql_fetch_array($req2)) 
		   {
		   $rubrique=$data2['rubrique'];
		   $lien=$data2['lien'];
		   $npage=$data2['npage'];
		   $id=$data2['id'];
		   echo "<li class=\"lib\"><a href=\"?page=page&op=see&rubrique=$rubrique&npage=$npage&id=$id\">$lien</a><br>";
		   }
		   theme_closeblock();
		   }
     
   
   }
	
	echo '</td></tr></table>';
	echo '</div>';
	echo "<!-- Menu Gauche [end] ---------------------------------------------------->\n";
	echo '</td>';
}


function theme_menu_right()
{
	global $mods;
	echo "<!-- Menu Droit[start] -------------------------------------------------->\n";
	echo '<td valign="top" align="center">';
	echo '<div id="menudiv_d">';
	echo '<table cellpadding="0" cellspacing="0" width="140" border="0"><tr><td valign="top">';
	
	//include("include/blocks/block_joueur.php");
	include("include/blocks/block_admin_tournois.php");
	
	//include("include/blocks/block_admin.php");
	
	// module des 10 dernière news à placer ou vous voulez ^^
	if($mods['lastnews']==1){include("include/blocks/block_10news.php");}
	
	include("include/blocks/block_partenaires.php");
	include("include/blocks/block_sponsors.php");

	global $config,$db,$dbprefix,$s_membre;

if ($config['phpt_type'] != 'lan'){
		   $sql = "SELECT * FROM ${dbprefix}menu WHERE titre!='' AND align='D' ORDER BY orde"; 
		   $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		 
		
		 
		 while($data = mysql_fetch_array($req)) 
			   {
		   $titre=$data['titre'];
		   
		   theme_openblock("$titre");
		   
		   $sql2 = "SELECT * FROM ${dbprefix}page WHERE lien!='' AND nmenu='$titre' ORDER BY orde"; 
		   $req2 = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
		   
		   while($data2 = mysql_fetch_array($req2)) 
		   {
		   $rubrique=$data2['rubrique'];
		   $lien=$data2['lien'];
		   $npage=$data2['npage'];
		   $id=$data2['id'];
		   echo "<li class=\"lib\"><a href=\"?page=page&op=see&rubrique=$rubrique&npage=$npage&id=$id\">$lien</a><br>";
		   }
		   theme_closeblock();
		   }
     
   
   }
   	
	echo '</td></tr></table>';
	echo '</div>';
	echo "<!-- Menu Droit [end] ---------------------------------------------------->\n";
	echo '</td>';
}


function theme_opencenter()
{
	global $s_joueur,$strAutorefresh,$strAutoscroll,$mods,$strHidemenu;
	
	echo '<td align="center" width="100%" valign="top" class="back">';
	
	echo '<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td>';
	
	if($mods['lastresult'] == 1) {
	echo '<table border="0" cellpadding="0" cellspacing="0" width="100%">';	
	echo '<tr><td>';
	include("include/blocks/block_lastresult.php");
	
	if($mods['lastnews_header'] != 1) {
	echo '</td></tr></table>';
	} else {
	echo '</td>';
	}
	}
	
	
	if($mods['lastnews_header'] == 1) {
	if($mods['lastresult'] != 1) {
	echo '<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td>';	
	} else {
	echo '<td>';
	}
	include("include/blocks/block_10news_header.php");
	echo '</td></tr></table>';
	
	}
	echo '</td></tr></table>';

	
	echo '<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td>';
	
	echo '
			
				<table cellspacing="0" cellpadding="0" width="100%" border="0">
	 
					<tr>
	    	          	<td><img alt="" src="themes/phptournois/images/centrehautcornergauche.gif" border="0"></td>
		              	<td width="100%" background="themes/phptournois/images/centrehaut.gif"><img height="1" alt="" src="images/spacer.gif" width="1" border="0"></td>
	              		<td align="right"><img alt="" src="themes/phptournois/images/centrehautcornerdroit.gif" border="0"></td>
	            	</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td valign="top" align="center" class="center">';
										
	/** pc retroproj **/
	if($s_joueur == -1) {

		echo '<table border=0 cellpadding="0" cellspacing="0" class="bordure2"><tr><td>';
		echo "<table cellspacing=1 cellpadding=0 border=0 align=center><tr><td>";
		echo '<table cellpadding="2" cellspacing="0" border="0"><tr>';
		echo "<td class=\"text\">$strAutorefresh <span id=\"time_value\" style=\"color: #CCCCCC\"></span> : </td><td class=\"text\"><a href=\"javascript: swap_timer()\"><div id=\"timer_status\" style=\"color: #CCCCCC\">Off</div></a></td>";
		echo "<td class=\"text\">$strAutoscroll : </td><td class=\"text\"><a href=\"javascript: swap_scroll()\"><div id=\"scroll_status\" style=\"color: #CCCCCC\">Off</div></a></td>";
		echo "<td class=\"text\">$strHidemenu : </td><td class=\"text\"><a href=\"javascript: swap_menu()\"><div id=\"menu_status\" style=\"color: #CCCCCC\">Off</div></a></td>";
		echo '</tr></table>';
		echo '</td></tr></table>';
		echo '</td></tr></table>';
	}
}

function theme_closecenter()
{	
global $config;
	echo '<br>
			</td>
		</tr>
		<tr>
			<td>	
				<table cellspacing="0" cellpadding="0" width="100%" border="0">
 					<tr>
    		          	<td><img alt="" src="themes/phptournois/images/centrebascornergauche.gif" border="0"></td>
	      	        	<td width="100%" background="themes/phptournois/images/centrebas.gif"><img height="1" alt="" src="images/spacer.gif" width="1" border="0"></td>
          	    		<td align="right"><img alt="" src="themes/phptournois/images/centrebascornerdroit.gif" border="0"></td>
         		   	</tr>
        		 </table>';
			if($config['enligne'] == 1) {include("include/blocks/block_en_ligne.php");}
			echo '</td>
		</tr>
	</table>
	</td>';
  

}


function theme_openblock($titre)
{	
?>
<!-- Block [start] ---------------------------------------------- -->
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	<td>
		<table background="themes/phptournois/images/menucenterback.gif" height="1" width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr>
		    <td height="1" width="11" valign="top"><img src="themes/phptournois/images/menucornergauche.gif" border="0" alt=""></td>
		    <td height="1" class="headermenu" background="themes/phptournois/images/menucenter.gif"><?php echo $titre;?></td>
		    <td height="1" width="11" valign="top"><p align="right"><img src="themes/phptournois/images/menucornerdroit.gif" border="0" alt=""></p></td>
		 </tr>
		</table>
	</td>
</tr>
<tr>
	<td>	
		<table width="100%" cellspacing="0" cellpadding="3" border="1" class="borduremenu">
		<tr>
			<td width="100%" class="textmenu">
				
<?php
}

function theme_closeblock()
{	
?>
			</td>
		</tr>
		</table>		
	</td>
</tr>
<tr>
	<td>	
		<table cellspacing="0" cellpadding="0" width="100%" border="0">
 			<tr>
              	<td><img alt="" src="themes/phptournois/images/menubascornergauche.gif" border="0"></td>
              	<td width="100%" background="themes/phptournois/images/menubas.gif"><img height="1" alt="" src="images/spacer.gif" width="1" border="0"></td>
              	<td align="right"><img alt="" src="themes/phptournois/images/menubascornerdroit.gif" border="0"></td>
            </tr>
         </table>
	</td>
</tr>
</table>
<br>				
<?php	
}


function theme_openblock_droite($titre)
{	
?>
<!-- Block [start] ---------------------------------------------- -->
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="menu">
<tr>
	<td>
		<table background="themes/phptournois/images/menucenterback.gif" height="1" width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr>
		    <td height="1" width="11" valign="top"><img src="themes/phptournois/images/menucornergauche.gif" border="0" alt=""></td>
		    <td height="1" class="headermenu" background="themes/phptournois/images/menucenter.gif"><?php echo $titre;?></td>
		    <td height="1" width="11" valign="top"><p align="right"><img src="themes/phptournois/images/menucornerdroit.gif" border="0" alt=""></p></td>
		 </tr>
		</table>
	</td>
</tr>
<tr>
	<td>	
		<table width="100%" cellspacing="0" cellpadding="3" border="1" class="borduremenu">
		<tr>
			<td width="100%" class="textmenu">
				
<?php
}

function theme_closeblock_droite()
{	
?>
			</td>
		</tr>
		</table>		
	</td>
</tr>
<tr>
	<td>	
		<table cellspacing="0" cellpadding="0" width="100%" border="0">
 			<tr>
              	<td><img alt="" src="themes/phptournois/images/menubascornergauche.gif" border="0"></td>
              	<td width="100%" background="themes/phptournois/images/menubas.gif"><img height="1" alt="" src="images/spacer.gif" width="1" border="0"></td>
              	<td align="right"><img alt="" src="themes/phptournois/images/menubascornerdroit.gif" border="0"></td>
            </tr>
         </table>
	</td>
</tr>
</table>
<img src="images/story-7px.gif" width="7" height="7" alt=""><br>
				
<?php	
}

function theme_openblock_enligne()
{	
?>
<table width="100%" cellspacing="0" cellpadding="3" align="center" border="1" class="borduremenu">
		<tr>
			<td width="100%" class="textmenu" align="center">
				
<?php
}

function theme_closeblock_enligne($titre)
{	
?>
			</td>
		</tr>
		</table>		
<tr>
	<td>	
		<table background="themes/phptournois/images/menucenterback.gif" align="center" height="1" width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr>
		    <td height="1" width="" valign="top"><img src="themes/phptournois/images/menucornerdroit2.gif" border="0" alt="" bgcolor=navy></td>
		    <td height="1" width="100%" class="headermenu" background="themes/phptournois/images/menucenter2.gif" align="center"><?php echo $titre;?></td>
		    <td height="1" width="11" valign="top"><p align="right"><img src="themes/phptournois/images/menucornergauche2.gif" border="0" alt=""></p></td>
		 </tr>
	</td>
</tr>
		</table>
		
				
<?php	
}

function theme_openblock_lastresult($titre)
{	
?>
<!-- Block [start] ------------------------------------------------>

		<table background="themes/phptournois/images/menucenterback.gif" align="center" height="1" width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr>
		    <td height="1" width="11" valign="top"><img src="themes/phptournois/images/menucornergauche.gif" border="0" alt="" bgcolor=navy></td>
		    <td height="1" class="headermenu" background="themes/phptournois/images/menucenter.gif" align="center"><?php echo $titre;?></td>
		    <td height="1" width="11" valign="top"><p align="right"><img src="themes/phptournois/images/menucornerdroit.gif" border="0" alt=""></p></td>
		 </tr>
		</table>
		<table width="100%" cellspacing="0" cellpadding="3" align="center" border="1" class="borduremenu">
		<tr>
			<td width="100%" class="textmenu" align="center">
				
<?php
}

function theme_closeblock_lastresult()
{	
?>
			</td>
		</tr>
		</table>
		
			
<?php	
}
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

	global $config,$db,$dbprefix,$mods,$s_joueur;
	global $strTournois,$strForum,$strInscriptions,$strAccueil,$strContact;
	global $config,$strRechecrher,$strDans,$strJoueurs,$strEquipes,$strNews,$strForum,$strSID,$strOK,$strSeRappeler,$checked,$strPseudo,$strPassword,$strOubliPass;

if (empty($s_joueur)){
		
	if(isset($_COOKIE['data'])) {
	
		//$data_banned = $_COOKIE['data'];
		//if ($data_banned="banned") {js_goto("?page=banned.php");}
		
		$data_info = $_COOKIE['data'];
		$data_info = base64_decode($data_info);
		$user_data = explode('|',$data_info);
		$checked = 'checked';
		
		/*** transmition des variables via donn&eacute;e du cookie ***/
		$pseudo=$user_data[0];
		$passwd=$user_data[1];

		/*** login ***
		$db->select("id,langue,admin");
		$db->from("${dbprefix}joueurs");
		$db->where("pseudo = '$pseudo'");
		$db->where("passwd = md5('$passwd')");
		$db->where("passwd != ''");
		$db->where("passwd is not null");
		$db->where("(etat in ('P','I') or id = -1 or admin = 'O')");
		$db->exec();

		if ($db->num_rows() != 0) {
		  $joueur = $db->fetch();
  */
  
		  /* creation de la session
		  SessionNew(session_id(),$joueur->id);  
		  SessionSetVar("s_joueur",$joueur->id);
		  SessionSetVar("s_type","1");

		  if($joueur->admin == 'O') {
		   SessionSetVar("s_type","2");
		  }

		  if($joueur->langue) {
		   SessionSetVar("s_lang",$joueur->langue);
		  }

		   $data_info="$pseudo|$passwd";
		   $data_info=base64_encode($data_info);
		   setcookie("data","$data_info",time()+9999999);
    */

		  // update de la date de login
		  /*
		  $db->update("${dbprefix}joueurs");
		  $db->set("datelogin = '".time()."'");
		  $db->where("id = '$joueur->id'");
		  $db->exec();
    
		js_goto("?page=index");
		}
		*/
	}
	else {
		$user_data = array('','');
		$checked = '';		
	}
		
	?>
		<table width="100%" height="12" border="0" cellpadding="0" cellspacing="0" background="themes/phpTG4/images/bck.png">
			<form method="post" action="?page=login&op=login" name="loginin">
				<tr>
					<td>
				
						<table width="583" height="12" border="0" cellpadding="0" cellspacing="0">
							<tr>
								 <td style="width: 10px;" background="themes/phpTG4/images/bck.png" height="26"></td>
								 <td style="width: 50px;" background="themes/phpTG4/images/bck.png"  height="26"><span style="color: rgb(101, 255, 125);"><?php echo $strPseudo;?> : </span></td>
								 <td style="width: 80px;" background="themes/phpTG4/images/bck.png" height="26"><input name="pseudo" size="10" maxlength="32" type="text">&nbsp;</td>
								 <td style="width: 90px;" background="themes/phpTG4/images/bck.png" height="26"><span style="color: rgb(101, 255, 125);"><?php echo $strPassword;?> : </span></td>
								 <td style="width: 50px;" background="themes/phpTG4/images/bck.png" height="26"><input name="passwd" size="10" maxlength="32" type="password"></td>
								 <td style="width: 120px;" background="themes/phpTG4/images/bck.png" height="26"> <input type="checkbox" name="remember" <?php echo $checked; ?>size="10" value="1" style="border: 0px;background-color:transparent;"><font style="color: rgb(204, 204, 204);" size="-2"><?php echo $strSeRappeler; ?></font></td>
								 <td style="width: 61x;" background="themes/phpTG4/images/signin.jpg" height="26"><input type="image" src="themes/phpTG4/images/login.png" /></td>
									<?php if($config['inscription_joueur']) {
									$nbinscrits=nb_joueurs_inscrit();
									$nbplaces=$config['places'];
							
									if($nbinscrits < $nbplaces) 
									{?>
								 <td style="width: 61px;" background="themes/phpTG4/images/signup.jpg" height="26"><a href="?page=joueurs&op=inscription"><img src="themes/phpTG4/images/register.png" border="0" alt="register" title="register" /></a></td>				
									<?php } 
									}
									?>
								<td style="width: 61px;" background="themes/phpTG4/images/bck.png" height="26"><a href=\"?page=joueurs&op=envoi_passwd\"><img src="themes/phpTG4/images/password.png" border="0" alt="password" title="password" /></a></td>
							</tr>
						</table>
				
					</td>
							<?php
								if($config['horloge'] == 1) {	
									echo '<td style="width: 61px; text-align: right; vertical-align: middle;" background="themes/phpTG4/images/bck.png" height="26">
									<table cellspacing="0" cellpadding="0" border="1" bgcolor="#000000" style="margin-right:5px;"><tr><td>
									<img height=15 src="images/clock/8.gif" name="a" border="0" alt="a"><img height="15" src="images/clock/8.gif" name="b" alt="b"><img height="15" src="images/clock/c.gif" name="c" alt="c"><img height="15" src="images/clock/8.gif" name="d" alt="d"><img height="15" src="images/clock/8.gif" name="e" alt="e"><img height="13" src="images/clock/c.gif" name="f" alt="f"><img height="13" src="images/clock/8.gif" name="g" alt="g"><img height="13" src="images/clock/8.gif" name="h" alt="h">
									</td></tr></table>
									<script>show(\''.date('M, d Y H:i:s').'\');</script>								
									</td>';
								}
							?>
					 
				</tr>
			</form>
		</table>
		<?php
		} else if ($s_joueur != -1){
		?>
		<table width="100%" height="12" border="0" cellpadding="0" cellspacing="0" background="themes/phpTG4/images/bck.png">
				<tr><form method="post" action="?page=search&op=searching">
					<td>
				
						<table height="12" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td style="width: 10px;" background="themes/phpTG4/images/bck.png" height="26"></td>
								<td style="vertical-align: justify;" background="themes/phpTG4/images/bck.png" height="26"><span style="color: rgb(101, 255, 125);"><u>user</u> : </span><span style="color: rgb(255, 255, 255);"><?php echo nom_joueur($s_joueur); ?></span></td>
								<td style="text-align: center; width: 59px;" background="themes/phpTG4/images/bck.png" height="26"><a href="?page=login&op=logout"><img src="themes/phpTG4/images/logout.png" border="0"></a> </td>
								<td style="width: 23px; text-align: center;" background="themes/phpTG4/images/bck.png" height="26"><a href="?page=joueurs&id=<?php echo $s_joueur; ?>"><img src="themes/phpTG4/images/profile.png" alt="profile" border="0"></a> </td>
								
								<?php if($config['inscription_equipe']) {?>
								<td style="text-align: center; width: 23px;" background="themes/phpTG4/images/bck.png" height="26"><a href="?page=equipes&op=inscription"><img src="themes/phpTG4/images/nteam.png" alt="new team" border="0" /></a>  </td>
								<?php } 
								
								$mesequipes=equipes_joueur($s_joueur); 
								
								if(count($mesequipes)=="1") {
									?><td style="text-align: center; width: 25px;" background="themes/phpTG4/images/bck.png" height="26"><a href="?page=equipes&id=<?php echo $mesequipes[0]['id'];?>"><img src="themes/phpTG4/images/myteam.png" alt="my team" border="0" /></a> </td><?php
								}
								else if(count($mesequipes)>1) {//  A REVOIR ICI
									
									for($i=0;$i<count($mesequipes);$i++) {
									?><td background="themes/phpTG4/images/bck.png" height="26"><a href="?page=equipes&id=<?php echo $mesequipes[$i]['id'];?>"><img src="themes/phpTG4/images/myteam.png" alt="<?php echo stripslashes($mesequipes[$i]['tag']); ?>" title="<?php echo stripslashes($mesequipes[$i]['tag']); ?>" border="0" /></a> </td><td><font style="color: rgb(204, 204, 204);" size="-2">(<?php echo stripslashes($mesequipes[$i]['tag']); ?>)</font></a>&nbsp; </td>
									  <?php
								
									}
								} else {
								?><td style="text-align: center; width: 25px;" background="themes/phpTG4/images/bck.png" height="26"><img src="themes/phpTG4/images/myteam_no.png" alt="my team" border="0" /> </td><?php
								}
								?>
								<td style="text-align: center; width: 23px;" background="themes/phpTG4/images/bck.png" height="26"><a href="?page=equipes&op=rejoindre"><img src="themes/phpTG4/images/rteam.png" alt="join team" border="0" /></a> </td>
								
								<?php 
								if($config['messagerie']) {
								$nb_new_message=nb_new_message($s_joueur);
								if($nb_new_message>0) {
								?> 
								<td style="text-align: center; width: 26px;" background="themes/phpTG4/images/bck.png" height="26"><a href="?page=messagerie"><img src="themes/phpTG4/images/nmsg.png" alt="MP" border="0"></a> </td>
								<?php								
								} else {
								?>
								<td style="text-align: center; width: 26px;" background="themes/phpTG4/images/bck.png" height="26"><a href="?page=messagerie"><img src="themes/phpTG4/images/msg.png" alt="MP" border="0"></a> </td>
								<?php
								}
								
								}?>
								
								<td style="text-align: center; width: 26px;" background="themes/phpTG4/images/bck.png" height="26"><a href="?page=messagerie&op=ecrire"><img src="themes/phpTG4/images/pm.png" alt="MP" border="0"></a> </td>
								</tr>
						</table>
				
					</td>
					<td style="text-align: right; vertical-align: middle; width: 200px;" background="themes/phpTG4/images/bck.png" height="26">
					<input name="search" size="10" value="<?php echo $strRechecrher; ?>" onfocus="this.value=''" type="text"><select name="howto">
									  <option value="joueur"><?php echo $strJoueurs; ?></option>
									  <option value="equipe"><?php echo $strEquipes; ?></option>
									  <option value="new"><?php echo $strNews; ?></option>
									  <option value="forum"><?php echo $strForum; ?></option>
									  <option value="steam"><?php echo $strSID; ?></option>
									</select></td>
					<td style="width: 10px; text-align: left;" background="themes/phpTG4/images/bck.png" height="26"><input class="action" value="<?php echo $strOK; ?>" size="2" type="submit"></td>
					<td style="width: 20px;" background="themes/phpTG4/images/bck.png" height="26"><span style="color: rgb(101, 255, 125);"><font size="-2">&nbsp;IP :</font></span></td>
					<td style="width: 20px;" background="themes/phpTG4/images/bck.png" height="26"><span style="color: rgb(255, 255, 255);"><font size="-2">&nbsp;<?php echo $_SERVER['REMOTE_ADDR']; ?>&nbsp;</font></span></td>
																
					<?php
								if($config['horloge'] == 1) {	
									echo '<td style="width: 61px; text-align: right; vertical-align: middle;" background="themes/phpTG4/images/bck.png" height="26">
									<table cellspacing="0" cellpadding="0" border="1" bgcolor="#000000" style="margin-right:5px;"><tr><td style="text-align: right;">
									<img height=15 src="images/clock/8.gif" name="a" border="0" alt="a"><img height="15" src="images/clock/8.gif" name="b" alt="b"><img height="15" src="images/clock/c.gif" name="c" alt="c"><img height="15" src="images/clock/8.gif" name="d" alt="d"><img height="15" src="images/clock/8.gif" name="e" alt="e"><img height="13" src="images/clock/c.gif" name="f" alt="f"><img height="13" src="images/clock/8.gif" name="g" alt="g"><img height="13" src="images/clock/8.gif" name="h" alt="h">
									</td></tr></table><script>show(\''.date('M, d Y H:i:s').'\');</script> </td>';
								}
							?>
					 
				</form></tr>
			</table>		
		<?php
		}
		?>
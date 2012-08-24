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
if (eregi("serveurs.php", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}

if(!$config['serveur']) js_goto('?page=index');

/*** chargement de phpQstat ***/
include("qstat/phpqstat.php");

/********************************************************
 * Ajout d'un serveur g&eacute;n&eacute;ral
 */
if ($op == "add") {

	/*** verification securite ***/
	if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['r']!='r') {js_goto($PHP_SELF);} 
	
	$str='';
	$erreur=0;
	
	if(!$adresse) {
		$erreur=1;
		$str.="- ".$strElementsAdresseInvalide."<br>";		
	}
	if(!$port) {
		$erreur=1;
		$str.="- ".$strElementsPortInvalide."<br>";
	}
	if(!$origine) {
		$erreur=1;
		$str.="- ".$strElementsOrigineInvalide."<br>";
	}
	if(!$jeux) {
		$erreur=1;
		$str.="- ".$strElementsJeuxInvalide."<br>";
	}

	if($erreur==1) {		
		show_erreur_saisie($str);		
	}
	else {	
		$nom=remove_XSS($nom);
		
		if(!$nom && !$protocole) $nom="$adresse:$port";

		if($stats=='http://') $stats='';

		$db->insert("${dbprefix}serveurs (nom,adresse,port,origine,jeux,protocole,rcon)");
		$db->values("'$nom','$adresse','$port','$origine',$jeux,'$protocole','$rcon'");
		$db->exec();

		$id=$db->insert_id();

		if($insert_m4) {
			$dbm4 = new database;
			$dbm4->debug($m4dbdebug);
			$dbm4->connect($m4dbhost,$m4dbuser,$m4dbpass,$m4dbname);

			/*** delete du serveur dans m4 ***/
			$dbm4->delete("m4_serveur");
			$dbm4->where("numero = $id");
			$dbm4->exec();

			/*** insertion du serveur dans m4 ***/
			$dbm4->insert("m4_serveur (numero,adresse,port,hostname)");
			$dbm4->values("$id,'$adresse','$port','$nom'");
			$dbm4->exec();

			$dbm4->close();
		}

		if($insert_ab) {
			$dbab = new database;
			$dbab->debug($abdbdebug);
			$dbab->connect($abdbhost,$abdbuser,$abdbpass,$abdbname);

			/*** delete du serveur dans adminbot ***/
			$dbab->delete("gameserver");
			$dbab->where("ServerId= $id");
			$dbab->exec();

			/*** insertion du serveur dans adminbot ***/
			$dbab->insert("gameserver (ServerId,GameId,GameGroupId,ServerAddress,ServerPort,ServerIsUp,ServerType,ServerRcon,ServerHostName)");
			$dbab->values("'$id','0','','$adresse','$port','0','cs','$rcon','$nom'");
			$dbab->exec();

			$dbab->close();
		}

		/*** redirection ***/
		js_goto("?page=serveurs&op=admin");
	}
}

/********************************************************
 * Modifier un serveur g&eacute;n&eacute;ral
 */
elseif ($op == "do_modify") {

	/*** verification securite ***/
	if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['r']!='r') {js_goto($PHP_SELF);} 

	$str='';
	$erreur=0;
	
	if(!$adresse) {
		$erreur=1;
		$str.="- ".$strElementsAdresseInvalide."<br>";		
	}
	if(!$port) {
		$erreur=1;
		$str.="- ".$strElementsPortInvalide."<br>";
	}
	if(!$origine) {
		$erreur=1;
		$str.="- ".$strElementsOrigineInvalide."<br>";
	}
	if(!$jeux) {
		$erreur=1;
		$str.="- ".$strElementsJeuxInvalide."<br>";
	}

	if($erreur==1) {			
		show_erreur_saisie($str);			
	}
	else {
		$nom=remove_XSS($nom);
		
		if($stats=='http://') $stats='';

		$db->update("${dbprefix}serveurs");
		$db->set("nom='$nom',adresse='$adresse',port='$port',origine='$origine',jeux=$jeux,protocole='$protocole',rcon='$rcon',stats='$stats'");
		$db->where("id = $id");
		$db->exec();

		if($insert_m4) {
			$dbm4 = new database;
			$dbm4->debug($m4dbdebug);
			$dbm4->connect($m4dbhost,$m4dbuser,$m4dbpass,$m4dbname);

			/*** delete du serveur dans m4 ***/
			$dbm4->delete("m4_serveur");
			$dbm4->where("numero = $id");
			$dbm4->exec();

			/*** insertion du serveur dans m4 ***/
			$dbm4->insert("m4_serveur (numero,adresse,port,hostname)");
			$dbm4->values("$id,'$adresse','$port','$nom'");
			$dbm4->exec();

			$dbm4->close();
		}

		if($insert_ab) {
			$dbab = new database;
			$dbab->debug($abdbdebug);
			$dbab->connect($abdbhost,$abdbuser,$abdbpass,$abdbname);

			/*** delete du serveur dans adminbot ***/
			$dbab->delete("gameserver");
			$dbab->where("ServerId = $id");
			$dbab->exec();

			/*** insertion du serveur dans adminbot ***/
			$dbab->insert("gameserver (ServerId,GameId,GameGroupId,ServerAddress,ServerPort,ServerIsUp,ServerType,ServerRcon,ServerHostName)");
			$dbab->values("'$id','','','$adresse','$port','','cs','$rcon','$nom'");
			$dbab->exec();

			$dbab->close();
		}

		/*** redirection ***/
		js_goto("?page=serveurs&op=modify&id=$id");
	}
}

/********************************************************
 * Suppression d'un serveur g&eacute;n&eacute;ral
 */
elseif ($op == "delete") {

	/*** verification securite ***/
	if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['r']!='r') {js_goto($PHP_SELF);} 

	$db->delete("${dbprefix}serveurs");
	$db->where("id = $id");
	$db->exec();

	/*** redirection ***/
	js_goto("?page=serveurs&op=admin");
}


/********************************************************
 * Liste des serveurs pour une fenetre
 */
/*elseif ($op == "list") {

 	$db->select("${dbprefix}serveurs.id, ${dbprefix}serveurs.nom, adresse, port");
	$db->from("${dbprefix}serveurs, ${dbprefix}tournois");
	$db->where("${dbprefix}serveurs.jeux = ${dbprefix}tournois.jeux");
	$db->where("${dbprefix}tournois.id = $s_tournois");
	$db->order_by("${dbprefix}serveurs.id");
	$res1 = $db->exec();

	include("include/header_win.inc.php");
	echo "<form>";
	echo "<select name=nom>";
	while($serveur = $db->fetch($res1)) {
		if($serveur->nom)
				$servername=$serveur->nom;
			else
				$servername="$serveur->adresse:$serveur->port";	
				
		echo "<option value='$serveur->id'>#$serveur->id - $servername";
	}
	echo "</select>";
	echo "<input type=button value=\"$strValider\" onclick=select_serveur(this.form.nom.value,'form',,'$input')>";

	echo "<table cellspacing=0 cellpadding=0 border=0>";
	echo "<tr><td height=8><img src=images/spacer.gif></td></tr>";
	echo "</table>";

	$db->select("${dbprefix}serveurs.id,${dbprefix}serveurs.nom");
	$db->from("${dbprefix}serveurs,tournois");
	$db->where("${dbprefix}serveurs.jeux = ${dbprefix}tournois.jeux");
	$db->where("${dbprefix}tournois.id = $s_tournois");
	$db->order_by("rand()");
	$res1 = $db->exec();
	$serveur = $db->fetch($res1);
	echo "<input type=hidden name=pif value='$serveur->id'>";
	echo "<input type=button value=\"$strChoisirAuHasard\" onclick=select_serveur(this.form.pif.value,'form','$input')>";

	echo "</form>";
	include("include/footer_win.inc.php");

}*/
/********************************************************
 * Affichage du serveur pour une fenetre
 */
elseif ($op == "voir") {

 	$db->select("${dbprefix}serveurs.id, ${dbprefix}serveurs.nom,adresse,port,origine,protocole,sigle,icone");
	$db->from("${dbprefix}serveurs LEFT JOIN ${dbprefix}jeux ON (${dbprefix}serveurs.jeux = ${dbprefix}jeux.id)");
	$db->where("${dbprefix}serveurs.id = $id");
	$serveurs = $db->exec();
	$serveur = $db->fetch($serveurs);

	$Qstat = new phpQStat($serveur->protocole, $serveur->adresse . ":" . $serveur->port, true, true);

	if($Qstat->server_name != "DOWN" && $Qstat->server_name != "TIMEOUT" && $Qstat->server_name != "ERROR" && $Qstat->server_name != "N/A" )
	{
		/** map **/
		if (file_exists("qstat/mappics/$Qstat->game_type/$Qstat->server_map.jpg"))
        	$imgmap="<img id=map src=\"qstat/mappics/$Qstat->game_type/$Qstat->server_map.jpg\" style=\"filter:progid:DXImageTransform.Microsoft.Pixelate(MaxSquare=20)\">";
       	elseif ( file_exists("qstat/mappics/$Qstat->game_type/$Qstat->server_map.png"))
        	$imgmap="<img id=map src=\"qstat/mappics/$Qstat->game_type/$Qstat->server_map.png\" style=\"filter:progid:DXImageTransform.Microsoft.Pixelate(MaxSquare=20)\">";
      	else
			$imgmap="<img id=map src=\"qstat/mappics/na.gif\" style=\"filter:progid:DXImageTransform.Microsoft.Pixelate(MaxSquare=20)\">";
		
		echo "<p class=title><img src=images/flags/$serveur->origine.gif align=absmiddle>&nbsp;" . $Qstat->server_name."</p>";

		echo "<table border=0 cellpadding=1 cellspacing=0 class=bordure1><tr><td>";
		echo "<table cellspacing=0 cellpadding=3 border=0>";
  		echo "<tr><td class=titlefiche><i>$strIp</i> :</td><td class=textfiche><b>$serveur->adresse:$serveur->port</b></td></tr>";
		echo "<tr><td class=titlefiche><i>$strType</i> :</td><td class=textfiche>";
		if($serveur->icone) echo "<img src=\"images/jeux/$serveur->icone\" border=0 align=absmiddle>&nbsp;";if($serveur->sigle) echo "<b>$serveur->sigle</b></td></tr>";
		echo "<tr><td class=titlefiche><i>$strPing</i> :</td><td class=textfiche><b>$Qstat->server_responce_time ms</b></td></tr>";
		//echo "<tr><td class=titlefiche><i>$strMap</i> :</td><td class=textfiche><b>$Qstat->server_map</b><br></td></tr>";
		echo "<tr><td class=textfiche align=center colspan=2><img src=\"images/next.gif\" border=0 align=align=absmiddle><a href=\"game://".$serveur->adresse.":".$serveur->port."/action=join\"><b>$strJoin</b></a></td></tr>";
		echo "</table>";
		echo "</td></tr></table>";
		echo "<span class=infoserveur><center>";
		echo "<i>$strMap</i> : <b>$Qstat->server_map</b><br>";
		
		echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
		echo "<table cellspacing=1 cellpadding=2 border=0>";
		echo "<tr><td class=textliste>$imgmap</td></tr>";
		echo "</table>";
		echo "</td></tr></table>";
		echo "<script>map.filters[0].Apply();map.filters[0].Play();</script>";

		/** Players **/
		echo "";
		if($Qstat->server_num_players == $Qstat->server_num_players_max)
			echo "<b><font color=red>".$Qstat->server_num_players . "/" . $Qstat->server_num_players_max."</font></b> $strJoueurs";
		else
			echo "<b>".$Qstat->server_num_players . "/" . $Qstat->server_num_players_max."</b> $strJoueurs";

		echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
		echo "<table cellspacing=1 cellpadding=2 border=0>";
        echo "<tr><td class=headerliste>#</td><td class=headerliste>$strJoueur</td><td class=headerliste>$strFrags</td><td class=headerliste>$strTempsDeConnexion</td></tr>";

		for ($i = 0 ; $i < $Qstat->players->count ; $i++) {
			 echo "<tr><td class=textliste>".($i+1)."</td>";
			 echo "<td class=textliste>".$Qstat->players->field0[$i]."</td>";
			 echo "<td class=textliste align=center>". $Qstat->players->field1[$i]."</td>";
			 echo "<td class=textliste align=right>".floor( $Qstat->players->field2[$i] / 60 ) . " $strMinutes" ."</td></tr>";
		}
		echo "</table>";
		echo "</td></tr></table>";
		echo "<br>";

		//Rules
		echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
		echo "<table cellspacing=1 cellpadding=2 border=0>";      
	    echo "<tr><td class=headerliste>$strRegle = $strValeur</td></tr>";
		echo "<tr><td class=textliste>";
		echo "<select name=rules size=10>";
		for ($i = 0 ; $i < $Qstat->rules->count ; $i++)
		{
			 echo "<option>".$Qstat->rules->name[$i]." = ". $Qstat->rules->value[$i];
		
		}
		echo "</select></td></tr>";
		echo "</table>";
		echo "</td></tr></table>";
		echo "</center></span>";
	}
	elseif($Qstat->server_name == "ERROR")
		echo "<span class=warning>$strErreur</span>";
	elseif($Qstat->server_name == "DOWN" || $Qstat->server_name == "TIMEOUT")
		echo "<span class=warning>$strMaintenance</span>";
	else
		echo "$strNA";
	
}
/********************************************************
 * Modification d'un serveur
 */
elseif($op == "modify") {

	/*** verification securite ***/
	if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['r']!='r') {js_goto($PHP_SELF);} 

	echo "<p class=title>.:: $strAdminServeurs ::.</p>";

	$db->select("*");
	$db->from("${dbprefix}serveurs");
	$db->where("${dbprefix}serveurs.id = $id");
	$db->exec();
	$serveur = $db->fetch();

	echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
	echo "<table cellspacing=1 cellpadding=0 border=0>";
	echo "<form method=post action=?page=serveurs&op=do_modify>";
	echo "<input type=hidden name=id value=$id>";
	echo "<tr><td class=headerfiche colspan=2>$strModifierServeur</td></tr>";
	echo "<tr><td>";
	echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
	echo "<tr><td class=titlefiche>$strNom :</td><td class=textfiche><input type=text size=30 name=nom value=\"".stripslashes($serveur->nom)."\"></td></tr>";
	echo "<tr><td class=titlefiche>$strAdresse : $strPort <font color=red><b>*</b></font> :</td><td class=textfiche><input type=text size=20 name=adresse value='$serveur->adresse'> : <input type=text size=6 name=port value='$serveur->port'></td></tr>";
	echo "<tr><td class=titlefiche>$strOrigine <font color=red><b>*</b></font> :</td>";
	echo "<td class=textfiche><select name=origine>";

	$tab_countrys = file("images/flags/country");

	for($i=0;$i<count($tab_countrys);$i++)
	{
		$tab_country=split(',',$tab_countrys[$i]);
		$country_code=$tab_country[0];
		$country_name=$tab_country[1];
		echo "<option value=$country_code";
		if ($country_code == $serveur->origine) echo " SELECTED";
		echo ">$country_name";
	}
	echo "</select></td></tr>";

	echo "<tr><td class=titlefiche>$strJeu <font color=red><b>*</b></font> :</td>";
	echo "<td class=textfiche><select name=jeux>";

	$db->select("id, sigle");
	$db->from("${dbprefix}jeux");
	$db->order_by("sigle");
	$db->exec();
	while($jeux = $db->fetch()) {
		echo "<option value=$jeux->id";
		if ($jeux->id == $serveur->jeux) echo " SELECTED";
		echo ">$jeux->sigle";
	}
	echo "</select></td></tr>";

	echo "<tr><td class=titlefiche>$strQstatProtocole :</td>";
	echo "<td class=textfiche><select name=protocole>";
	echo "<option value=''>";
	$tab_protos = file("qstat/protocoles");

	for($i=0;$i<count($tab_protos);$i++)
	{
		$tab_proto=split(',',$tab_protos[$i]);
		$proto_code=$tab_proto[0];
		$proto_name=$tab_proto[1];
		echo "<option value=$proto_code";
		if ($proto_code == $serveur->protocole) echo " SELECTED";
		echo ">$proto_name";
	}
	echo "</select></td></tr>";

	echo "<tr><td class=titlefiche>Rcon : </td><td class=textfiche><input type=text size=15 name=rcon value=\"".stripslashes($serveur->rcon)."\"></td></tr>";

	echo "<tr><td class=titlefiche>$strPageStats :</td>";
	if(!$serveur->stats) $serveur->stats='http://';
	echo "<td class=textfiche><input type=text name=stats value=\"$serveur->stats\" size=40></td></tr>";

	echo "<tr><td class=titlefiche>$strPublierServeurDans : </td><td class=textfiche>$strM4 <input type=checkbox style=\"border:0px\" name=insert_m4 value=1> $strAdminBot <input type=checkbox style=\"border:0px\" name=insert_ab value=1></td></tr>";

	echo "<tr><td class=footerfiche colspan=2 align=center><input type=submit value=\"$strModifier\">&nbsp;<input type=button value=\"$strRetour\" onclick=\"document.location='?page=serveurs&op=admin'\"></td></tr>";
	echo "</table>";
	echo "</td></tr>";
	echo "</form>";
	echo "</table>";
	echo "</td></tr></table><br>";

	show_consignes($strServeursConsignes);
	

}
/******************************************************** 
 * Affichage admin + normal
 */
else {

	/*** verification securite ***/
	if ($op == "admin") {if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['r']!='r') {js_goto($PHP_SELF);} }
	
	if($op=='admin') echo "<p class=title>.:: $strAdminServeurs ::.</p>";
	else echo "<p class=title>.:: $strServeurs ::.</p>";

	$db->select("${dbprefix}serveurs.id, ${dbprefix}serveurs.nom,adresse,port,origine,protocole,sigle,icone,stats");
	$db->from("${dbprefix}serveurs LEFT JOIN ${dbprefix}jeux ON (${dbprefix}serveurs.jeux = ${dbprefix}jeux.id)");
	$db->order_by("${dbprefix}serveurs.id");
	$res = $db->exec();

	if ($db->num_rows($res) != 0) {

		/** reinit des colonne a 1 ***/
		if ($db->num_rows($serveurs) < $config['col_serveurs']) $config['col_serveurs']=1;

		echo "<table cellspacing=0 cellpadding=0 border=0>";
		echo "<tr><td class=title>". nb_serveurs()." $strServeurs</td></tr>";
		echo "</table>";

		$i=0;
		while($serveur = $db->fetch($res)) {
			$tab_serveurs[$i]=$serveur;
			$i++;
		}
		echo "<table cellspacing=0 cellpadding=0 border=0 class=liste><tr valign=top>";

		for($i=0;$i<$config['col_serveurs'];$i++) {
			echo "<td>";
			echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
			echo "<table cellspacing=1 cellpadding=2 border=0>";
			echo "<tr><td class=headerliste>#</td><td class=headerliste>$strJeu</td><td class=headerliste>$strNom</td><td class=headerliste>$strAdresse</td><td class=headerliste>$strEtat</td><td class=headerliste>$strJoueurs</td><td class=headerliste>$strMap</td><td class=headerliste>$strPing</td><td class=headerliste>$strStats</td><td class=headerliste></td></tr>";

			for($j=$i;$j<count($tab_serveurs);$j=$j+$config['col_serveurs']) {

				$Qstat = new phpQStat($tab_serveurs[$j]->protocole, $tab_serveurs[$j]->adresse . ":" . $tab_serveurs[$j]->port, false, false);

				/** nom **/
				if($Qstat->server_name != "DOWN" && $Qstat->server_name != "TIMEOUT" && $Qstat->server_name != "ERROR" && $Qstat->server_name != "N/A")
					$servername=$Qstat->server_name;
				elseif($tab_serveurs[$j]->nom)
					$servername=stripslashes($tab_serveurs[$j]->nom);
				else
					$servername="N/A";

				if($tab_serveurs[$j]->origine) $img = "<img src=\"images/flags/".$tab_serveurs[$j]->origine.".gif\" border=0 align=absmiddle>";
				else $img = '';

				echo "<tr>";
				echo "<td class=textliste align=center>".$tab_serveurs[$j]->id."</td>";
				echo "<td class=textliste align=center><img src=\"images/jeux/".$tab_serveurs[$j]->icone."\" border=0 align=absmiddle></td>";

				echo "<td class=textliste>";
				echo "<div style=\"clear: both\"><div style=\"float: left\">";
				if($Qstat->server_name != "DOWN" && $Qstat->server_name != "TIMEOUT" && $Qstat->server_name != "ERROR" && $Qstat->server_name != "N/A")
					echo "$img <a href=javascript:ouvrir_fenetre('?page=serveurs&op=voir&id=".$tab_serveurs[$j]->id."&header=win','servers',300,400)>$servername</a></div>";
				else
					echo "$img $servername</div>";

				if($op=='admin') echo "<div style=\"float: right\">&nbsp;<a href=?page=serveurs&op=modify&id=".$tab_serveurs[$j]->id.">[$strE]</a>&nbsp;<a href=?page=serveurs&op=delete&id=".$tab_serveurs[$j]->id." onclick=\"return confirm('$strConfirmEffacerServeur');\">[$strS]</a></div>";
				echo "</div></td>";

				echo "<td class=textliste>".$tab_serveurs[$j]->adresse.":".$tab_serveurs[$j]->port."</td>";

				echo "<td class=textliste align=center>";
				if($Qstat->server_name != "DOWN" && $Qstat->server_name != "TIMEOUT" && $Qstat->server_name != "ERROR" && $Qstat->server_name != "N/A")
					echo "<img src=images/soleil.gif border=0 align=absmiddle title=\"$strOK\">";
				elseif($Qstat->server_name == "ERROR")
					echo "<img src=images/orage.gif border=0 align=absmiddle title=\"$strErreur\">";
				elseif($Qstat->server_name == "DOWN" || $Qstat->server_name == "TIMEOUT")
					echo "<img src=images/pluie.gif border=0 align=absmiddle title=\"$strMaintenance\">";
				else
					echo "<div align=right></div>";
				echo "</td>";

				echo "<td class=textliste align=center>";
				if($Qstat->server_num_players_max) {
					if($Qstat->server_num_players == $Qstat->server_num_players_max)
						echo "<font color=red>".$Qstat->server_num_players . "/" . $Qstat->server_num_players_max."</font>";
					else
						echo $Qstat->server_num_players . "/" . $Qstat->server_num_players_max;
				}
				elseif($tab_serveurs[$j]->protocole) echo "-";
				echo "</td>";

				echo "<td class=textliste align=center>";if($Qstat->server_map) echo $Qstat->server_map;elseif($tab_serveurs[$j]->protocole) echo "-"; echo "</td>";
				echo "<td class=textliste align=center>";if($Qstat->server_responce_time) echo $Qstat->server_responce_time." ms";elseif($tab_serveurs[$j]->protocole) echo "-";echo "</td>";

				echo "<td class=textliste align=center>";
				if($tab_serveurs[$j]->stats)
					echo "<a href=\"".$tab_serveurs[$j]->stats."\" target=_blank><img src=images/stats.gif border=0 align=absmiddle></a>";
				echo "</td>";

				echo "<td class=textliste align=center>";
				echo "<img src=\"images/next.gif\" border=0 align=align=absmiddle><a href=\"game://".$tab_serveurs[$j]->adresse.":".$tab_serveurs[$j]->port."/action=join\"><b>$strJoin</b></a>";
				echo "</td></tr>";
			}
			echo "</table>";
			echo "</td></tr></table>";
			echo "</td>";
		}
		echo "</tr></table>";

		echo "<table cellspacing=0 cellpadding=0 border=0>";
		echo "</table>";
		show_consignes($strJoinAvecHlla);
	}
	else {
		echo "<table cellspacing=2 cellpadding=2 border=0>";
		echo "<tr><td class=title>$strPasDeServeur</td></tr>";
		echo "</table>";
	}

	/*** ajout d'un server ***/
	if($op=='admin') {

		echo "<br><table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
		echo "<table cellspacing=1 cellpadding=0 border=0>";
		echo "<form method=post action=?page=serveurs&op=add>";
		echo "<tr><td class=headerfiche colspan=2>$strAjouterServeur</td></tr>";
		echo "<tr><td>";
		echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
		echo "<tr><td class=titlefiche>$strNom :</td><td class=textfiche><input type=text size=30 name=nom></td></tr>";
		echo "<tr><td class=titlefiche>$strAdresse : $strPort <font color=red><b>*</b></font> :</td><td class=textfiche><input type=text size=20 name=adresse> : <input type=text size=6 name=port></td></tr>";
		echo "<tr><td class=titlefiche>$strOrigine <font color=red><b>*</b></font> :</td>";
		echo "<td class=textfiche><select name=origine>";

		$tab_countrys = file("images/flags/country");

		for($i=0;$i<count($tab_countrys);$i++)
		{
			$tab_country=split(',',$tab_countrys[$i]);
			$country_code=$tab_country[0];
			$country_name=$tab_country[1];
			echo "<option value=$country_code";
			if ($country_code == 'FR') echo " SELECTED";
			echo ">$country_name";
		}
		echo "</select></td></tr>";

		echo "<tr><td class=titlefiche>$strJeu <font color=red><b>*</b></font> :</td>";
		echo "<td class=textfiche><select name=jeux>";

		$db->select("id, sigle");
		$db->from("${dbprefix}jeux");		
		$db->order_by("sigle");
		$db->exec();
		while($jeux = $db->fetch()) {
			echo "<option value=$jeux->id>$jeux->sigle";
		}
		echo "</select></td></tr>";
		
		echo "<tr><td class=titlefiche>$strQstatProtocole :</td>";
		echo "<td class=textfiche><select name=protocole>";
		echo "<option value=''>";
		$tab_protos = file("qstat/protocoles");

		for($i=0;$i<count($tab_protos);$i++)
		{
			$tab_proto=split(',',$tab_protos[$i]);
			$proto_code=$tab_proto[0];
			$proto_name=$tab_proto[1];
			echo "<option value=$proto_code";
			echo ">$proto_name";
		}
		echo "</select></td></tr>";

		echo "<tr><td class=titlefiche>Rcon : </td><td class=textfiche><input type=text size=15 name=rcon></td></tr>";
		echo "<tr><td class=titlefiche>$strPublierServeurDans : </td><td class=textfiche>$strM4 <input type=checkbox style=\"border:0px\" name=insert_m4 value=1> $strAdminBot <input type=checkbox style=\"border:0px\" name=insert_ab value=1></td></tr>";
		
		echo "<tr><td class=footerfiche colspan=2 align=center><input type=submit value=\"$strAjouter\"></td></tr>";
		echo "</table>";
		echo "</td></tr>";
		echo "</form>";
		echo "</table>";
		echo "</td></tr></table>";

		show_consignes($strServeursConsignes);
		
	}

	echo "<br><img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";

}

?>

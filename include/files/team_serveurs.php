<?php
/*
   +---------------------------------------------------------------------+
   | phpTournois                                                         |
   +---------------------------------------------------------------------+
   +---------------------------------------------------------------------+
   | phpTournoisG4 �2005 by Gectou4 <Gectou4 Gectou4@hotmail.com>        |
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
if (preg_match("/serveurs.php/i", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}

if(!$config['serveur']) js_goto('?page=index');

/*** chargement de phpQstat ***/
//include("qstat/phpqstat.php");

/********************************************************
 * Ajout d'un serveur g&eacute;n&eacute;ral d'une team
 */
if ($op == "add") {

	/*** verification securite ***/
	//if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['r']!='r') {js_goto($PHP_SELF);} 
	if(!equipe_manager($id_t,$s_joueur)) js_goto($PHP_SELF);
	
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
		
		
		$db->select("id");
		$db->from("${dbprefix}serveurs");
		$db->where("${dbprefix}serveurs.nom = '$nom' AND ${dbprefix}serveurs.adresse = '$adresse' AND ${dbprefix}serveurs.port = '$port'");
		$db->exec();
		$serveur = $db->fetch();
	
		$db->update("${dbprefix}equipes");
		$db->set("id_s = '$serveur->id'");
		$db->where("id = $id_t");
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
			$dbab->delete("adb_server_tbl");
			$dbab->where("server_id = $id");
			$dbab->exec();

			/*** insertion du serveur dans adminbot ***/
			$dbab->insert("adb_server_tbl (server_id,server_hostname,server_ip,server_port,server_rcon,server_game)");
			$dbab->values("$id,'$nom','$adresse','$port','$rcon','CS'");
			$dbab->exec();

			$dbab->close();
		}

		/*** redirection ***/
		js_goto("?page=team_serveurs&id=$serveur->id&id_t=$id_t&op=modify");
	}
}
/********************************************************
 * Modifier un serveur g&eacute;n&eacute;ral
 */
elseif ($op == "do_modify") {

	/*** verification securite ***/
	if(!equipe_manager($id_t,$s_joueur)) js_goto($PHP_SELF);

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
		$db->where("id = $id_s");
		$db->exec();
		
		$db->update("${dbprefix}equipes");
		$db->set("id_s = '$id_s'");
		$db->where("id = $id_t");
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
			$dbab->delete("adb_server_tbl");
			$dbab->where("server_id = $id");
			$dbab->exec();

			/*** insertion du serveur dans adminbot ***/
			$dbab->insert("adb_server_tbl (server_id,server_hostname,server_ip,server_port,server_rcon,server_game)");
			$dbab->values("$id,'$nom','$adresse','$port','$rcon','CS'");
			$dbab->exec();

			$dbab->close();
		}

		/*** redirection ***/
		js_goto("?page=team_serveurs&op=modify&id=$id_s&id_t=$id_t");
	}
}
/********************************************************
 * Suppression d'un serveur g&eacute;n&eacute;ral
 */
elseif ($op == "delete") {

if(!equipe_manager($id_t,$s_joueur)) js_goto($PHP_SELF);

	/*** verification securite ***/
	//if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['r']!='r') {js_goto($PHP_SELF);} 

	$db->delete("${dbprefix}serveurs");
	$db->where("id = $id_s");
	$db->exec();
	
	$db->update("${dbprefix}equipes");
	$db->set("id_s = '0',servername='',serverip=''");
	$db->where("id = $id_t");
	$db->exec();

	/*** redirection ***/
	js_goto("?page=equipes&id=$id_t");
}



/********************************************************
 * Modification d'un serveur
 */
elseif($op == "modify") {

if(!equipe_manager($id_t,$s_joueur)) js_goto($PHP_SELF);

	/*** verification securite ***/
	//if ($grade['a']!='a'&&$grade['b']!='b'&&$grade['r']!='r') {js_goto($PHP_SELF);} 

	echo "<p class=title>.:: $strAdminServeurs ::.</p>";

	$db->select("*");
	$db->from("${dbprefix}serveurs");
	$db->where("${dbprefix}serveurs.id = $id");
	$db->exec();
	$serveur = $db->fetch();

	echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
	echo "<table cellspacing=1 cellpadding=0 border=0>";
	echo "<form method=post action=?page=team_serveurs&op=do_modify>";
	echo "<input type=hidden name=id_s value=$id>";
	echo "<input type=hidden name=id_t value=$id_t>";
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
		$tab_country=preg_split('/,/',$tab_countrys[$i]);
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
		$tab_proto=preg_split('/,/',$tab_protos[$i]);
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

	echo "<tr><td class=footerfiche colspan=2 align=center><input type=submit value=\"$strModifier\">&nbsp;</td></tr>";
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

	
	if(!equipe_manager($id_t,$s_joueur)) js_goto($PHP_SELF);

	
	if ($id_s!=''&&$id_s!=0){
	$db->select("*");
	$db->from("${dbprefix}serveurs");
	$db->where("${dbprefix}serveurs.id = $id_s");
	$db->exec();
	$serveur = $db->fetch();
	
	echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
	echo "<table cellspacing=1 cellpadding=0 border=0>";
	echo "<form method=post action=?page=team_serveurs&op=do_modify&id_s=$id_s&id_t=$id_t>";
	echo "<input type=hidden name=id value=$id>";
	echo "<tr><td class=headerfiche colspan=2>$strModifierServeur</td></tr>";
	echo "<tr><td>";
	echo "<input type=hidden name=id_s value=$id_s>";
	echo "<input type=hidden name=id_t value=$id_t>";
	echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
	echo "<tr><td class=titlefiche>$strNom :</td><td class=textfiche><input type=text size=30 name=nom value=\"".stripslashes($serveur->nom)."\"></td></tr>";
	echo "<tr><td class=titlefiche>$strAdresse : $strPort <font color=red><b>*</b></font> :</td><td class=textfiche><input type=text size=20 name=adresse value='$serveur->adresse'> : <input type=text size=6 name=port value='$serveur->port'></td></tr>";
	echo "<tr><td class=titlefiche>$strOrigine <font color=red><b>*</b></font> :</td>";
	echo "<td class=textfiche><select name=origine>";

	$tab_countrys = file("images/flags/country");

	for($i=0;$i<count($tab_countrys);$i++)
	{
		$tab_country=preg_split('/,/',$tab_countrys[$i]);
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
		$tab_proto=preg_split('/,/',$tab_protos[$i]);
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

	echo "<tr><td class=footerfiche colspan=2 align=center><input type=submit value=\"$strModifier\">&nbsp;<input type=\"button\" class=\"action\" value=\"$strSupprimer\" onclick=\"location='?page=team_serveurs&op=delete&id_s=$id_s&id_t=$id_t'\"></td></tr>";
	echo "</table>";
	echo "</td></tr>";
	echo "</form>";
	echo "</table>";
	echo "</td></tr></table><br>";

	show_consignes($strServeursConsignes);
		
		
	} else {
	
	$equipe = equipe($id_t);
	
	$str='';
	$erreur=0;
	
	if ($equipe->servername== '') {
 		$erreur=1;
		$str.="- $strElementsServerNameInvalide<br>";
	}
	if ($equipe->serverip== '') {
 		$erreur=1;
		$str.="- $strElementsServerIpInvalide<br>";
	}	
	if($erreur==1) {
		show_erreur_saisie($str);
	}
	else {
	echo "<br><table border=0 cellpadding=0 cellspacing=0 class=bordure2><tr><td>";
		echo "<table cellspacing=1 cellpadding=0 border=0>";
		echo "<form method=post action=?page=team_serveurs&op=add&id_s=$id_s&id_t=$id_t>";
		echo "<tr><td class=headerfiche colspan=2>$strADD_t_server</td></tr>";
		echo "<tr><td>";
		echo "<input type=hidden name=id_s value=$id_s>";
		echo "<input type=hidden name=id_t value=$id_t>";
		echo "<table cellspacing=0 cellpadding=3 border=0 width=100%>";
		echo "<tr><td class=titlefiche>$strNom :</td><td class=textfiche><input type=hidden size=30 name=nom value='".stripslashes($equipe->servername)."'>".stripslashes($equipe->servername)."</td></tr>";
		echo "<tr><td class=titlefiche>$strAdresse : $strPort <font color=red><b>*</b></font> :</td><td class=textfiche><input type=text size=20 name=adresse> : <input type=text size=6 name=port></td></tr>";
		echo "<tr><td class=titlefiche>$strOrigine <font color=red><b>*</b></font> :</td>";
		echo "<td class=textfiche><select name=origine>";

		$tab_countrys = file("images/flags/country");

		for($i=0;$i<count($tab_countrys);$i++)
		{
			$tab_country=preg_split('/,/',$tab_countrys[$i]);
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
			$tab_proto=preg_split('/,/',$tab_protos[$i]);
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
}
}

?>

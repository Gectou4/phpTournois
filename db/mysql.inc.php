<?php
/*
   +---------------------------------------------------------------------+
   | phpTournois                                                         |
   +---------------------------------------------------------------------+
   +---------------------------------------------------------------------+
   | phpTournoisG4 ©2005 by Gectou4 <Gectou4 Gectou4@hotmail.com>        |
   +---------------------------------------------------------------------+
         This version is based on phpTournois 3.5 realased by :
   | Copyright (c) 2003 RV, Li0n, Gougou (http://www.phptournois.net)    |
   +---------------------------------------------------------------------+
   | This file is part of phpTournois.                                   |
   |                                                                     |
   | phpTournois may be distributed under the terms of the QPL Public    |
   | License as defined by Trolltech AS of Norway and appearing in       |
   | the file LICENSE.QPL included in the packaging of this file.        |
   |                                                                     |
   | phpTournois is distributed in the hope that it will be useful,      |
   | but WITHOUT ANY WARRANTY; without even the implied warranty of      |
   | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the QPL   |
   | Public License for more details.                                    |  
   |                                                                     |
      +---------------------------------------------------------------------+
   | Authors: RV <rv@phptournois.net>                                    |
   |          Li0n  <li0n@phptournois.net>                               |
   |          Gougou                                                     |
   | Mods :                                                              |
   |          Gectou4 <Gectou4@hotmail.com>                              |
   | Contributors:                                                       |
   |          Nono                                                       |
   |          Ben64                                                      |
   +---------------------------------------------------------------------+
*/

define("LOG_SYSTEM","blue");
define("LOG_EXEC","green");
define("LOG_SHOW","orange");
define("LOG_ERROR","red");
define("LOG_DEFAULT","black");
define('SQL_DATESTRING','%Y-%m-%d %H:%M:%S');

class database {

	var $dbhost, $dbuser, $dbpass, $dbname;
	var $sql;
	var $res;
	var $debuglevel;
	var $nbquery;
	var $link;
	var $is_set;
	var $is_where;
	var $table;
	var $can_c;
	var $db_i;
	var $db_i2;	
	
	function connect($dbhost,$dbuser,$dbpass,$dbname) {
		$this->dbhost = $dbhost;
		$this->dbuser = $dbuser;
		$this->dbpass = $dbpass;
		$this->dbname = $dbname;
		$this->nbquery = 0;
		
		if ($this->debuglevel >= 3)
			$this->winlog("Connexion a $dbuser@$dbhost", LOG_SYSTEM);
		$this->link=mysql_connect($this->dbhost,$this->dbuser,$this->dbpass) or die();
		if ($this->debuglevel >= 1) 
			$this->error();

		if ($this->debuglevel >= 3)
			$this->winlog("Ouverture de $dbname", LOG_SYSTEM);
		@mysql_select_db($this->dbname, $this->link);
		if ($this->debuglevel >= 1)
			$this->error();
			
	}
	
	function close() {
		if ($this->debuglevel >= 3)
			$this->winlog("Fermeture connexion", LOG_SYSTEM);
		@mysql_close();
		if ($this->debuglevel >= 1)
			$this->error();
		if ($this->debuglevel >= 3)
			$this->winlog("Nombre de requete(s) : $this->nbquery", LOG_SYSTEM);
		if ($this->debuglevel >= 2)
			$this->winlog("<hr>", LOG_SYSTEM);
		
	}
	
	function query($sql) {
		if ($this->debuglevel >= 2)
			$this->winlog($sql, LOG_EXEC);
		$this->res = @mysql_db_query($this->dbname,$sql,$this->link);
		$this->nbquery++;
		if ($this->debuglevel >= 1)
			$this->error();
		return $this->res;
	}

	function fetch() {
		if (func_num_args() == 0)
			$res = $this->res;
		else
			$res = func_get_arg(0);
		$tuple = @mysql_fetch_object($res);
		if ($this->debuglevel >= 1)
			$this->error();
		return $tuple;
	}

	function fetch_array() {
		if (func_num_args() == 0)
			$res = $this->res;
		else
			$res = func_get_arg(0);
		$tuple = @mysql_fetch_array($res);
		if ($this->debuglevel >= 1)
			$this->error();
		return $tuple;
	}

	function insert_id() {
		$id = @mysql_insert_id($this->link);
		if ($this->debuglevel >= 1)
			$this->error();
		return $id;
	}

	function num_rows() {
		if (func_num_args() == 0)
			$res = $this->res;
		else
			$res = func_get_arg(0);
		$num =  @mysql_num_rows($res);
		if ($this->debuglevel >= 1)
			$this->error();
		return $num;
	}
	
	function affected_rows() {
		
		$num =  mysql_affected_rows($this->link);
		if ($this->debuglevel >= 1)
			$this->error();
		return $num;
	}
	
	function select($col) {
		$this->is_where = 0;
		$this->sql = "SELECT $col";
	}
	
	function from($tables) {
		$this->sql .= " FROM $tables"; 
	}
	
	function where($cond) {
		if(!$this->is_where) {
			$this->is_where = 1;
			$this->sql .= " WHERE $cond";
		}
		else {
			$this->sql .= " AND $cond";
		}
	}
	
	function group_by($col) {
		$this->sql .= " GROUP BY $col";
	}
	
	function order_by($col) {
		$this->sql .= " ORDER BY $col";
	}
	
	function free_req($req) {
		$this->sql .= $req;
	}
	
	function limit() {
		if (func_num_args() == 1)
			$this->sql .= " LIMIT " . func_get_arg(0);
		if (func_num_args() == 2)
			$this->sql .= " LIMIT " . func_get_arg(0) . ", " . func_get_arg(1);
	}
	
	function insert ($table) {
		$this->is_where = 0;
		$this->sql = "INSERT INTO $table";
	}
	
	function values($values) {
		$this->sql .= " VALUES ($values)";
	}
		
	function update ($table) {
		$this->is_set = 0;
		$this->is_where = 0;
		$this->sql = "UPDATE $table";
	}
	
	function set ($values) {
		if(!$this->is_set) {
			$this->is_set = 1;
			$this->sql .= " SET $values";
		}
		else
			$this->sql .= ", $values";
	}
	
	function delete ($table) {
		$this->is_where = 0;
		$this->sql = "DELETE FROM $table";
	}
	
	function debug($level) {
		$this->debuglevel = $level;		
	}
	
	var $creat_i; 
	
	function create($table) {
		
		if ($this->creat_i!=1){
			if ($this->can_c == 1) {
				$this->sql = "CREATE TABLE $table (".$this->table.");";
			}
		} else {
			$this->creat_i = 1;
			$this->sql .= "CREATE TABLE $table (".$this->table.");";
		}
		
	}
	
	var $table_i;
	
	function table($table) {
	
		if ($this->table_i!=1){
			$this->sql = $table;
			$this->can_c = 1;
		} else {
			$this->table_i = 1;
			$this->sql .= $table;
		}
	}
	
	var $drop_i;
	
	function drop($table) {

		if ($this->drop_i!=1){
			$this->sql = "DROP TABLE $table;";
		} else {
			$this->drop_i = 1;
			$this->sql .= ", $table;";
		}
	}

	var $vider_i;
		
	function vider($table) {

		if ($this->vider_i != 1){
			$this->sql = "TRUNCATE TABLE $table";
		} else {
			$this->vider_i = 1;
			$this->sql .= ", $table";
		}
	}
	
	var $change_i;
	
	function change($table,$data_t,$req) {

		if ($this->change_i != 1){
			$this->sql = "ALTER TABLE $table CHANGE $data_t $req;";
		} else {
			$this->change_i = 1;
			$this->sql .= "ALTER TABLE $table CHANGE $data_t $req;";
		}
	}
	
	var $optimize_i;
	
	function optimize($table) {

		if ($this->optimize_i!=1){
			$this->sql = "OPTIMIZE TABLE $table;";
		} else {
			$this->optimize_i = 1;
			$this->sql = ", $table;";
		}
	}
	
	function create_db($db_c) {
		
		if ($this->db_i!=1){
			$this->sql = "CREATE DATABASE $db_c ;";
		} else {
			$this->db_i = 1;
			$this->sql .= "CREATE DATABASE $db_c ;";
		}
	}
	
	function drop_db($db_d) {

		if ($this->db_i2!=1){
			$this->sql = "CREATE DATABASE $db_d ;";
		} else {
			$this->db_i2 = 1;
			$this->sql .= "CREATE DATABASE $db_d ;";
		}
	}
	
	function ext_req($req) {
		$this->res = $this->query($req);
		return $this->res;
	}
	
	var $ext_req_w;
	
	function ext_req_w($req) {
		if ($this->ext_req_w!=1){
			$this->sql = $req;
		} else {
			$this->ext_req_w = 1;
			$this->sql .= $req;
		}
	}
	
	function exec() {
		$this->res = $this->query($this->sql);
		return $this->res;
	}

	function test() {
		if (func_num_args() == 0)
			$sql = $this->sql;
		else
			$sql = func_get_arg(0);
		if (@mysql_db_query($this->dbname,$sql,$this->link)) {
			$msg = "[OK] : $sql";
			$this->winlog($msg, LOG_EXEC);
		}
		else  {
			$msg = "[ERROR] : $sql : " . mysql_error($this->link);
			$this->winlog($msg, LOG_ERROR);
		}
	}
	
	function show() {
		$this->winlog($this->sql, LOG_SHOW);
	}
	
	function showmsg($message) {
			$msg = "msg : $message";
			$this->winlog($msg, LOG_SHOW);
	}

	function error() {
		if (mysql_errno($this->link)) {
			$msg = $this->sql."<br>";
			$msg.= "-> Error " . mysql_errno($this->link) . " : " . mysql_error($this->link);
			$this->winlog($msg, LOG_ERROR);
			@ob_flush();
		}
	}
	
	function winlog() {
		
		$msg = func_get_arg(0);
		if (func_num_args() == 2)
			$color = func_get_arg(1);
		else
			$color = LOG_DEFAULT;
		
		echo "

<script>
	sql = window.open('','sql','scrollbars=yes,height=300,width=500')
	sql.document.writeln(\"<font color=$color>$msg</font><br>\")
</script>
		
		";
	}
}

?>

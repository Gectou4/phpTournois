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

define("LOG_SYSTEM", "blue");
define("LOG_EXEC", "green");
define("LOG_SHOW", "orange");
define("LOG_ERROR", "red");
define("LOG_DEFAULT", "black");
define('SQL_DATESTRING', '%Y-%m-%d %H:%M:%S');

class database
{
    public $dbhost;
    public $dbuser;
    public $dbpass;
    public $dbname;
    public $dbport;
    public $sql;
    public $res;
    public $debuglevel;
    public $nbquery;
    public $link;
    public $is_set;
    public $is_where;
    public $table;
    public $can_c;
    public $db_i;
    public $db_i2;
    public $creat_i;
    public $table_i;
    public $drop_i;
    public $vider_i;
    public $change_i;
    public $optimize_i;
    public $ext_req_w;
    public $winlogstring = '';

    /**
     * @param $dbhost
     * @param $dbuser
     * @param $dbpass
     * @param $dbname
     * @param $dbport
     */
    public function __construct($dbhost, $dbuser, $dbpass, $dbname, $dbport = null)
    {
        if (!$dbport) {
            $dbport = ini_get("mysqli.default_port");
        }

        $this->dbhost = $dbhost;
        $this->dbuser = $dbuser;
        $this->dbpass = $dbpass;
        $this->dbname = $dbname;
        $this->dbport = $dbport;
        $this->nbquery = 0;
    }

    /**
     *
     */
    public function connect()
    {
        if ($this->debuglevel >= 3)
            $this->winlog("Connexion a {$this->dbuser}@{$this->dbhost}", LOG_SYSTEM);
        $this->link = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname, $this->dbport) or die();
        $this->link->set_charset("utf8");
        if ($this->debuglevel >= 1)
            $this->error();

        if ($this->debuglevel >= 3)
            $this->winlog("Ouverture de {$this->dbname}", LOG_SYSTEM);

        if ($this->debuglevel >= 1)
            $this->error();

    }

    /**
     *
     */
    public function winlog()
    {
        $msg = func_get_arg(0);
        if (func_num_args() == 2)
            $color = func_get_arg(1);
        else
            $color = LOG_DEFAULT;

        $this->winlogstring = "
<script>
	sql = window.open('','sql','scrollbars=yes,height=300,width=500')
	sql.document.writeln(\"<font color=$color>$msg</font><br>\")
</script>
		";
    }

    /**
     *
     */
    public function error()
    {
        if (mysqli_errno($this->link)) {
            $msg = $this->sql . "<br>";
            $msg .= "-> Error " . mysqli_errno($this->link) . " : " . mysqli_error($this->link);
            $this->winlog($msg, LOG_ERROR);
            ob_flush();
        }
    }

    public function getError()
    {
        if (mysqli_errno($this->link)) {
            return "-> Error " . mysqli_errno($this->link) . " : " . mysqli_error($this->link);
        }
    }

    /**
     *
     */
    public function close()
    {
        if ($this->debuglevel >= 3)
            $this->winlog("Fermeture connexion", LOG_SYSTEM);
        mysqli_close($this->link);
        if ($this->debuglevel >= 1)
            $this->error();
        if ($this->debuglevel >= 3)
            $this->winlog("Nombre de requete(s) : $this->nbquery", LOG_SYSTEM);
        if ($this->debuglevel >= 2)
            $this->winlog("<hr>", LOG_SYSTEM);

    }

    /**
     * @return object|stdClass
     */
    public function fetch()
    {
        $tuple = null;

        if (func_num_args() == 0)
            $res = $this->res;
        else
            $res = func_get_arg(0);

        if ($res) {
            $tuple = mysqli_fetch_object($res);
            if ($this->debuglevel >= 1)
                $this->error();
        }

        return $tuple;
    }

    public function fetch_array()
    {
        $tuple = [];
        if (func_num_args() == 0)
            $res = $this->res;
        else
            $res = func_get_arg(0);

        if ($res) {
            $tuple = mysqli_fetch_array($res);
            if ($this->debuglevel >= 1)
                $this->error();
        }

        return $tuple;
    }

    public function insert_id()
    {
        $id = mysqli_insert_id($this->link);
        if ($this->debuglevel >= 1)
            $this->error();
        return $id;
    }

    public function num_rows()
    {
        $num = 0;

        if (func_num_args() == 0)
            $res = $this->res;
        else
            $res = func_get_arg(0);

        if ($res) {
            $num = mysqli_num_rows($res);
            if ($this->debuglevel >= 1)
                $this->error();
        }

        return $num;
    }

    public function affected_rows()
    {
        $num = mysqli_affected_rows($this->link);
        if ($this->debuglevel >= 1)
            $this->error();
        return $num;
    }

    public function select($col)
    {
        $this->is_where = 0;
        $this->sql = "SELECT $col";
    }

    public function from($tables)
    {
        $this->sql .= " FROM $tables";
    }

    public function where($cond)
    {
        if (!$this->is_where) {
            $this->is_where = 1;
            $this->sql .= " WHERE $cond";
        } else {
            $this->sql .= " AND $cond";
        }
    }

    public function group_by($col)
    {
        $this->sql .= " GROUP BY $col";
    }

    public function order_by($col)
    {
        $this->sql .= " ORDER BY $col";
    }

    public function free_req($req)
    {
        $this->sql .= $req;
    }

    public function limit()
    {
        if (func_num_args() == 1)
            $this->sql .= " LIMIT " . func_get_arg(0);
        if (func_num_args() == 2)
            $this->sql .= " LIMIT " . func_get_arg(0) . ", " . func_get_arg(1);
    }

    public function insert($table)
    {
        $this->is_where = 0;
        $this->sql = "INSERT INTO $table";
    }

    public function values($values)
    {
        $this->sql .= " VALUES ($values)";
    }

    public function update($table)
    {
        $this->is_set = 0;
        $this->is_where = 0;
        $this->sql = "UPDATE $table";
    }

    public function set($values)
    {
        if (!$this->is_set) {
            $this->is_set = 1;
            $this->sql .= " SET $values";
        } else
            $this->sql .= ", $values";
    }

    public function delete($table)
    {
        $this->is_where = 0;
        $this->sql = "DELETE FROM $table";
    }

    public function debug($level)
    {
        $this->debuglevel = $level;
    }

    public function create($table)
    {

        if ($this->creat_i != 1) {
            if ($this->can_c == 1) {
                $this->sql = "CREATE TABLE $table (" . $this->table . ");";
            }
        } else {
            $this->creat_i = 1;
            $this->sql .= "CREATE TABLE $table (" . $this->table . ");";
        }

    }

    public function table($table)
    {

        if ($this->table_i != 1) {
            $this->sql = $table;
            $this->can_c = 1;
        } else {
            $this->table_i = 1;
            $this->sql .= $table;
        }
    }

    public function drop($table)
    {

        if ($this->drop_i != 1) {
            $this->sql = "DROP TABLE $table;";
        } else {
            $this->drop_i = 1;
            $this->sql .= ", $table;";
        }
    }

    public function vider($table)
    {

        if ($this->vider_i != 1) {
            $this->sql = "TRUNCATE TABLE $table";
        } else {
            $this->vider_i = 1;
            $this->sql .= ", $table";
        }
    }

    public function change($table, $data_t, $req)
    {

        if ($this->change_i != 1) {
            $this->sql = "ALTER TABLE $table CHANGE $data_t $req;";
        } else {
            $this->change_i = 1;
            $this->sql .= "ALTER TABLE $table CHANGE $data_t $req;";
        }
    }

    public function optimize($table)
    {

        if ($this->optimize_i != 1) {
            $this->sql = "OPTIMIZE TABLE $table;";
        } else {
            $this->optimize_i = 1;
            $this->sql = ", $table;";
        }
    }

    public function create_db($db_c)
    {

        if ($this->db_i != 1) {
            $this->sql = "CREATE DATABASE $db_c ;";
        } else {
            $this->db_i = 1;
            $this->sql .= "CREATE DATABASE $db_c ;";
        }
    }

    public function drop_db($db_d)
    {

        if ($this->db_i2 != 1) {
            $this->sql = "CREATE DATABASE $db_d ;";
        } else {
            $this->db_i2 = 1;
            $this->sql .= "CREATE DATABASE $db_d ;";
        }
    }

    public function ext_req($req)
    {
        $this->res = $this->query($req);
        return $this->res;
    }

    public function query($sql)
    {
        $this->res = null;
        if (!empty($sql)) {
            if ($this->debuglevel >= 2)
                $this->winlog($sql, LOG_EXEC);
            $this->res = mysqli_query($this->link, $sql);
            $this->nbquery++;
            if ($this->debuglevel >= 1)
                $this->error();
        }

        return $this->res;
    }

    public function ext_req_w($req)
    {
        if ($this->ext_req_w != 1) {
            $this->sql = $req;
        } else {
            $this->ext_req_w = 1;
            $this->sql .= $req;
        }
    }

    public function exec()
    {
        $this->res = $this->query($this->sql);
        return $this->res;
    }

    public function test()
    {
        if (func_num_args() == 0)
            $sql = $this->sql;
        else
            $sql = func_get_arg(0);
        if (mysqli_query($this->link, $sql)) {
            $msg = "[OK] : $sql";
            $this->winlog($msg, LOG_EXEC);
        } else {
            $msg = "[ERROR] : $sql : " . mysqli_error($this->link);
            $this->winlog($msg, LOG_ERROR);
        }
    }

    public function show()
    {
        $this->winlog($this->sql, LOG_SHOW);
    }

    public function showmsg($message)
    {
        $msg = "msg : $message";
        $this->winlog($msg, LOG_SHOW);
    }
}

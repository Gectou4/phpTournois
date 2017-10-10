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
//-------------------------------------------------------------------------//
//  Mainly from Nuked-KlaN - PHP Portal		                               //
//  http://www.nuked-klan.org                                              //
//-------------------------------------------------------------------------//


error_reporting(E_ERROR | E_WARNING | E_PARSE);

if (!get_magic_quotes_gpc()) {
    if (is_array($_GET)) {
        while (list($k, $v) = each($_GET)) {
            if (is_array($_GET[$k])) {
                while (list($k2, $v2) = each($_GET[$k])) {
                    $_GET[$k][$k2] = addslashes($v2);
                }
                @reset($_GET[$k]);
            } else {
                $_GET[$k] = addslashes($v);
            }
        }
        @reset($_GET);
    }

    if (is_array($_POST)) {
        while (list($k, $v) = each($_POST)) {
            if (is_array($_POST[$k])) {
                while (list($k2, $v2) = each($_POST[$k])) {
                    $_POST[$k][$k2] = addslashes($v2);
                }
                @reset($_POST[$k]);
            } else {
                $_POST[$k] = addslashes($v);
            }
        }
        @reset($_POST);
    }
    if (is_array($_COOKIE)) {
        while (list($k, $v) = each($_COOKIE)) {
            if (is_array($_COOKIE[$k])) {
                while (list($k2, $v2) = each($_COOKIE[$k])) {
                    $_COOKIE[$k][$k2] = addslashes($v2);
                }
                @reset($_COOKIE[$k]);
            } else {
                $_COOKIE[$k] = addslashes($v);
            }
        }
        @reset($_COOKIE);
    }
}


if (!@ini_get("register_globals")) {
    make_globals('_GET');
    make_globals('_POST');
    make_globals('_COOKIE');
    make_globals('_SERVER');
}


function make_globals($table)
{

    if (is_array($GLOBALS[$table])) {
        reset($GLOBALS[$table]);

        while (list($key, $val) = each($GLOBALS[$table])) {
            $GLOBALS[$key] = $val;
        }
    }
}


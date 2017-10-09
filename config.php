<?php
/*
   +---------------------------------------------------------------------+
   | phpTournois                                                         |
   +---------------------------------------------------------------------+
   | phpTournoisG4 �2005 by Gectou4 <Gectou4 Gectou4@hotmail.com>        |
   +---------------------------------------------------------------------+
   | Copyright(c) 2001-2004 Li0n, RV, Gougou (http://www.phptournois.com)|
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
   | Authors: Li0n  <li0n@phptournois.com>                               |
   |          RV <rv@phptournois.com>                                    |
   |          Gougou                                                     |
   +---------------------------------------------------------------------+
*/

if (preg_match('/config.php/i', $_SERVER['PHP_SELF'])) {
	die ('You cannot open this page directly');
}

/*****************************/
/*** phpTournois DATABASE ***/
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'phptournois';
$dbdebug = 1;
$dbprefix = 'phpt_';

$config['phpt_type']='lan'; // for lan/online mod or all

/************************************************/
/*** Sessions variables ***/
$config['sess_cookie_min']=120;
$config['sess_gc_days']=1;
$config['stats_timeout']=600;

/************************************************/
/*** Flood variable ***/
$config['flood_time']=30; // must be in minutes !!! Doit �tre en minutes !!! 

/************************************************/
/*** Screening variables for drawing <table> ***/
// leave default is recommended

/*** Arbres ***/
$config['x_delta_simple'] = 2;
$config['x_delta_double'] = 1;

/*** Affichage Equipes ***/
$config['col_equipes'] = 2;

/*** Affichage Joueur ***/
$config['col_joueurs'] = 2;

/*** Affichage Poules ***/
$config['col_poules'] = 2;

/*** Affichage Matchs Poules ***/
$config['col_matchs_poules'] = 2;

/*** Affichage Maps ***/
$config['col_maps'] = 3;

/*** Affichage Maps ***/
$config['col_jeux'] = 2;

/*** Affichage Serveurs ***/
$config['col_serveurs'] = 1;

/*** Affichage Administrateurs ***/
$config['col_administrateurs'] = 2;

/*** Affichage Gallerie ***/
$config['col_avatar_gallerie'] = 5;

/*** Affichage Sponsors ***/
$config['col_sponsors'] = 4;

/*** Affichage Cat�gorie ***/
$config['col_categories']=4;

/*** Affichage des miniature ***/
$config['col_gallery_thumb'] = 4;

/*** Nb de X max / page ***/
$config['nb_news_max']=5;
$config['nb_news_commentaires_max']=5;
$config['nb_matchs_commentaires_max']=10;
$config['nb_livredor_max']=10;
$config['nb_gallery_thumb'] = 16;
$config['nb_sondage_commentaires_max']=10;


/** do not touch **/
include('config.m4.php');
include('config.ab.php');

?>
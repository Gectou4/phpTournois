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

if (eregi("functions.inc.php", $_SERVER['PHP_SELF'])) {
	die ("You cannot open this page directly");
}

/*** Fonctions SQL simples ***/

/**** TOURNOIS Edition **********************/
function tournois($id) {
	global $db,$dbprefix;

	if(!is_numeric($id)) return;

	$db->select("${dbprefix}tournois.*,sigle,icone");
	$db->from("${dbprefix}tournois LEFT JOIN ${dbprefix}jeux on (${dbprefix}tournois.jeux = ${dbprefix}jeux.id)");
	$db->where("${dbprefix}tournois.id = $id");
	$res = $db->exec();	
	
	$tournoi = $db->fetch($res);

	return $tournoi;
}

function nom_tournois($id) {
	global $db,$dbprefix;

	if(!is_numeric($id)) return;

	$db->select("nom");
	$db->from("${dbprefix}tournois");
	$db->where("id = $id");
	$res = $db->exec();
	$tournois = $db->fetch($res);

	return $tournois->nom;
}

function jeux_tournois($id) {
	global $db,$dbprefix;

	if(!is_numeric($id)) return;

	$db->select("jeux");
	$db->from("${dbprefix}tournois");
	$db->where("id = $id");
	$res = $db->exec();
	$tournois = $db->fetch($res);

	return $tournois->jeux;
}

function status_tournois($id) {
	global $db,$dbprefix;

	if(!is_numeric($id)) return;

	$db->select("status");
	$db->from("${dbprefix}tournois");
	$db->where("id = $id");
	$res = $db->exec();
	$tournois = $db->fetch($res);

	return $tournois->status;
}

function type_tournois($id) {
	global $db,$dbprefix;

	if(!is_numeric($id)) return;

	$db->select("type");
	$db->from("${dbprefix}tournois");
	$db->where("id = $id");
	$res = $db->exec();
	$tournois = $db->fetch($res);

	return $tournois->type;
}

function elimination_tournois($id) {
	global $db,$dbprefix;

	if(!is_numeric($id)) return;
	
	$db->select("elimination");
	$db->from("${dbprefix}tournois");
	$db->where("id = $id");
	$db->exec();
	$tournois = $db->fetch();

	return $tournois->elimination;
}

function modescore_tournois($id) {
	global $db,$dbprefix;

	if(!is_numeric($id)) return;

	$db->select("modescore");
	$db->from("${dbprefix}tournois");
	$db->where("id = $id");
	$db->exec();
	$tournois = $db->fetch();

	return $tournois->modescore;
}

function modematchscore_tournois($id) {
	global $db,$dbprefix;

	if(!is_numeric($id)) return;

	$db->select("modematchscore");
	$db->from("${dbprefix}tournois");
	$db->where("id = $id");
	$db->exec();
	$tournois = $db->fetch();

	return $tournois->modematchscore;
}

function modeinscription_tournois($id) {
	global $db,$dbprefix;

	if(!is_numeric($id)) return;

	$db->select("modeinscription");
	$db->from("${dbprefix}tournois");
	$db->where("id = $id");
	$db->exec();
	$tournois = $db->fetch();

	return $tournois->modeinscription;
}

function modefichier_tournois($id) {
	global $db,$dbprefix;

	if(!is_numeric($id)) return;

	$db->select("modefichier");
	$db->from("${dbprefix}tournois");
	$db->where("id = $id");
	$db->exec();
	$tournois = $db->fetch();

	return $tournois->modefichier;
}


function modecommentaire_tournois($id) {
	global $db,$dbprefix;

	if(!is_numeric($id)) return;

	$db->select("modecommentaire");
	$db->from("${dbprefix}tournois");
	$db->where("id = $id");
	$db->exec();
	$tournois = $db->fetch();

	return $tournois->modecommentaire;
}


function modeequipe_tournois($id) {
	global $db,$dbprefix;

	if(!is_numeric($id)) return;

	$db->select("modeequipe");
	$db->from("${dbprefix}tournois");
	$db->where("id = $id");
	$db->exec();
	$tournois = $db->fetch();

	return $tournois->modeequipe;
}

function nb_finales_winner($id) {
	global $db,$dbprefix;

	if(!is_numeric($id)) return 0;

	$db->select("winner");
	$db->from("${dbprefix}tournois");
	$db->where("id = $id");
	$db->exec();
	$tournois = $db->fetch();

	return $tournois->winner;
}

function nb_finales_looser($id) {
	global $db,$dbprefix;

	if(!is_numeric($id)) return 0;

	$db->select("looser");
	$db->from("${dbprefix}tournois");
	$db->where("id = $id");
	$db->exec();
	$tournois = $db->fetch();

	return $tournois->looser;
}

function nb_poules($id) {
	global $db,$dbprefix;

	if(!is_numeric($id)) return 0;

	$db->select("poules");
	$db->from("${dbprefix}tournois");
	$db->where("id = $id");
	$db->exec();
	$tournois = $db->fetch();

	return $tournois->poules;
} 


function nb_places_tournois($id) {
	global $db,$dbprefix;

	if(!is_numeric($id)) return 0;

	$db->select("places");
	$db->from("${dbprefix}tournois");
	$db->where("id = $id");
	$db->exec();
	$tournois = $db->fetch();

	return $tournois->places;
} 


function nb_manches_max_tournois($id) {
	global $db,$dbprefix;

	if(!is_numeric($id)) return 0;

	$db->select("manchesmax");
	$db->from("${dbprefix}tournois");
	$db->where("id = $id");
	$db->exec();
	$tournois = $db->fetch();

	return $tournois->manchesmax;
}


function show_tournois($id,$selected=0) {
	
	if(!$id) return;

	$tournoi=tournois($id);
	
	$nom=stripslashes($tournoi->nom);
		
	if($tournoi->icone)
		$img = "<img src=\"images/jeux/$tournoi->icone\" border=\"0\" align=\"absmiddle\" alt=\"\">";
	
	if($selected)
		return "$img <b><font color=\"red\">$nom</font></b>";
	elseif($tournoi->status=='I')
		return "$img <a href=\"?page=tournois&op=select&id=$id\"><font color=\"orange\">$nom</font></a>";
	elseif($tournoi->status=='G' || $tournoi->status=='P' || $tournoi->status=='H' || $tournoi->status=='F')
		return "$img <a href=\"?page=tournois&op=select&id=$id\"><font color=\"green\">$nom</font></a>";
	else
		return "$img <a href=\"?page=tournois&op=select&id=$id\">$nom</a>";

}

/**** PARTICIPE **********************/

function participe($participant, $tournois) {
	global $db,$dbprefix;

	if(!is_numeric($participant) || !is_numeric($tournois)) return 0;

	$db->select("tournois");
	$db->from("${dbprefix}participe");
	$db->where("equipe = $participant");
	$db->where("tournois = $tournois");
	$res=$db->exec();

	return $db->num_rows($res);
}

function poule_participe($participant, $tournois) {
	global $db,$dbprefix;

	if(!is_numeric($participant) || !is_numeric($tournois)) return;

	$db->select("poule");
	$db->from("${dbprefix}participe");
	$db->where("equipe = $participant");
	$db->where("tournois = $tournois");
	$res=$db->exec();
	$poule=$db->fetch($res);

	return $poule->poule;
}

function status_participe($participant, $tournois) {
	global $db,$dbprefix;

	if(!is_numeric($participant) || !is_numeric($tournois)) return;

	$db->select("status");
	$db->from("${dbprefix}participe");
	$db->where("equipe = $participant");
	$db->where("tournois = $tournois");
	$res=$db->exec();
	$status=$db->fetch($res);

	return $status->status;
}

function seed($participant, $tournois) {
	global $db,$dbprefix;

	if(!is_numeric($participant) || !is_numeric($tournois)) return;

	$db->select("seed");
	$db->from("${dbprefix}participe");
	$db->where("equipe = $participant");
	$db->where("tournois = $tournois");
	$res=$db->exec();
	$seed=$db->fetch($res);

	return $seed->seed;
}


function date_participe($participant, $tournois) {
	global $db,$dbprefix;

	if(!is_numeric($participant) || !is_numeric($tournois)) return;

	$db->select("date");
	$db->from("${dbprefix}participe");
	$db->where("equipe = $participant");
	$db->where("tournois = $tournois");
	$res=$db->exec();
	$date=$db->fetch($res);
	
	return $date->date;	
}


/***** EQUIPES / JOUEURS **********/

function nom_joueur($id) {
	global $db,$dbprefix;

	if(!is_numeric($id)) return;

	$db->select("pseudo");
	$db->from("${dbprefix}joueurs");
	$db->where("id = $id");
	$res=$db->exec();
	$joueur = $db->fetch($res);

	return $joueur->pseudo;
}

function id_joueur($nom) {
	global $db,$dbprefix;

	$db->select("id");
	$db->from("${dbprefix}joueurs");
	$db->where("pseudo = '$nom'");
	$res=$db->exec();
	$joueur = $db->fetch($res);

	if(!$joueur->id) return 0;
	else return $joueur->id;
}

function email_exist($email) {
	global $db,$dbprefix;

	$db->select("id");
	$db->from("${dbprefix}joueurs");
	$db->where("email = '$email'");
	$res=$db->exec();
	$joueur = $db->fetch($res);

	if(!$joueur->id) return 0;
	else return $joueur->id;
}

function nom_equipe($id) {
	global $db,$dbprefix;

	if(!is_numeric($id)) return 0;

	$db->select("nom");
	$db->from("${dbprefix}equipes");
	$db->where("id = $id");
	$res=$db->exec();
	$equipe = $db->fetch($res);

	return $equipe->nom;
}

function tag_equipe($id) {
	global $db,$dbprefix;

	if(!is_numeric($id)) return 0;

	$db->select("tag");
	$db->from("${dbprefix}equipes");
	$db->where("id = $id");
	$res=$db->exec();
	$equipe = $db->fetch($res);

	return $equipe->tag;
}

function id_equipe($tag) {
	global $db,$dbprefix;

	$db->select("id");
	$db->from("${dbprefix}equipes");
	$db->where("tag = '$tag'");
	$res=$db->exec();
	$equipe = $db->fetch($res);

	if(!$equipe->id) return 0;
	else return $equipe->id;
}

function joueur($id) {
	global $db,$dbprefix,$config;

	if(!is_numeric($id)) return;

	$db->select("*");
	$db->from("${dbprefix}joueurs");
	$db->where("id = $id");
	$res=$db->exec();
	$joueur = $db->fetch($res);

	$avatar_img = '';

	if($joueur->avatar_type != 'N') {

		switch($joueur->avatar_type ) {
			case 'U':
				$avatar_img = ($config['avatar_upload']) ? "<img src=\"./images/avatars/$joueur->avatar\" alt=\"\" style=\"border: 1px solid #000000;padding: 1px;\">" : '';
				break;
			case 'R':
				$avatar_img = ($config['avatar_remote']) ? "<img src=\"$joueur->avatar\" alt=\"\" style=\"border: 1px solid #000000;padding: 1px;\">" : '';
				break;
			case 'G':
				$avatar_img = ($config['avatar_gallerie']) ? "<img src=\"./images/avatars/gallerie/$joueur->avatar\" alt=\"\" style=\"border: 1px solid #000000;padding: 1px;\">" : '';
				break;
		}
		if((!file_exists($avatar_img) && !$joueur->avatar_type == 'R') || (!$joueur->avatar && $joueur->avatar_type!='N'))
			$avatar_img='<img src="./images/avatars/unknown.gif" alt="" style="border: 1px solid #000000;padding: 1px;">';
	}
	
	$joueur->avatar_img=$avatar_img;

	return $joueur;
}

function equipe($id) {
	global $db,$dbprefix,$config;

	if(!is_numeric($id)) return;

	$db->select("*");
	$db->from("${dbprefix}equipes");
	$db->where("id = $id");
	$res=$db->exec();
	$equipe = $db->fetch($res);
	
	$avatar_img = '';

	if($equipe->avatar_type != 'N') {

		switch($equipe->avatar_type ) {
			case 'U':
				$avatar_img = ($config['avatar_upload']) ? "<img src=\"./images/avatars/$equipe->avatar\" alt=\"\" style=\"border: 1px solid #000000;padding: 1px;\">" : '';
				break;
			case 'R':
				$avatar_img = ($config['avatar_remote']) ? "<img src=\"$equipe->avatar\" alt=\"\" style=\"border: 1px solid #000000;padding: 1px;\">" : '';
				break;
			case 'G':
				$avatar_img = ($config['avatar_gallerie']) ? "<img src=\"./images/avatars/gallerie/$equipe->avatar\" alt=\"\" style=\"border: 1px solid #000000;padding: 1px;\">" : '';
				break;
		}
		if((!file_exists($avatar_img) && !$equipe->avatar_type == 'R') || (!$equipe->avatar && $equipe->avatar_type!='N'))
			$avatar_img='<img src="./images/avatars/unknown.gif" alt="" style="border: 1px solid #000000;padding: 1px;">';
	}
	
	$equipe->avatar_img=$avatar_img;

	return $equipe;
}

function equipes_joueur($joueur) {
	global $db,$dbprefix;

	if(!is_numeric($joueur)) return;

	$equipes=array();

	$db->select("distinct id,nom,tag,origine");
	$db->from("${dbprefix}equipes LEFT JOIN ${dbprefix}appartient on (${dbprefix}equipes.id = ${dbprefix}appartient.equipe)");
	$db->where("(joueur = $joueur or manager = $joueur)");
	$db->order_by('tag');
	$res=$db->exec();

	while($equipe=$db->fetch($res)) {
		$equipes[]=array("nom"=>$equipe->nom,"tag"=>$equipe->tag,"id"=>$equipe->id,"origine"=>$equipe->origine);
	}
	return $equipes;
}

function equipes_manager($joueur) {
	global $db,$dbprefix;

	if(!is_numeric($joueur)) return;

	$equipes=array();

	$db->select("distinct id,nom,tag,origine");
	$db->from("${dbprefix}equipes");
	$db->where("manager = $joueur");
	$db->order_by('tag');
	$res=$db->exec();

	while($equipe = $db->fetch($res)) {
		$equipes[]=array("nom"=>$equipe->nom,"tag"=>$equipe->tag,"id"=>$equipe->id,"origine"=>$equipe->origine);
	}
	return $equipes;
}

function equipe_appartient($equipe,$joueur,$jeux='') {
	global $db,$dbprefix;

	if(!is_numeric($equipe) || !is_numeric($joueur)) return 0;

	$db->select("equipe");
	$db->from("${dbprefix}appartient");
	$db->where("joueur = $joueur");
	$db->where("equipe = $equipe");
	if($jeux) $db->where("jeux = $jeux");
	$res=$db->exec();

	if ($db->num_rows($res) != 0) return 1;
	else return 0;
}

function equipe_manager($equipe,$joueur) {
	global $db,$dbprefix;

	if(!is_numeric($equipe) || !is_numeric($joueur)) return 0;

	$db->select("id");
	$db->from("${dbprefix}equipes");
	$db->where("manager = $joueur");
	$db->where("manager <> 0");
	$db->where("id = $equipe");
	$res=$db->exec();

	return $db->num_rows($res);;
}

function joueur_inscrit($id) {
	global $db,$dbprefix;

	if(!is_numeric($id)) return 0;

	$db->select("id");
	$db->from("${dbprefix}joueurs");
	$db->where("id = $id");
	$db->where("etat = 'I'");
	$db->exec();
	$res=$db->exec();

	return $db->num_rows($res);;
}

function equipe_valide($id) {
	global $db,$dbprefix;

	if(!is_numeric($id)) return 0;

	$db->select("id");
	$db->from("${dbprefix}equipes");
	$db->where("id = '$id'");
	$db->where("etat = 'V'");
	$db->exec();
	$res=$db->exec();

	return $db->num_rows($res);;
}

function newseur($id) {
	global $db,$dbprefix;

	if(!is_numeric($id)) return 0;

	$db->select("id");
	$db->from("${dbprefix}joueurs");
	$db->where("id = '$id'");
	$db->where("newseur = 'O'");
	$res=$db->exec();

	return $db->num_rows($res);
}


function show_joueur($id,$op='',$status='',$seed=10000,$align='left',$class='') {
	global $strDisqualifie,$strForfait,$header;

	if(!$id) return;

	$joueur=joueur($id);

	if($seed && $seed!=10000)
		$seed="(#$seed)";
	else
		$seed='';
			
	if($op) $op="&op=$op";
	else $op='';

	if($joueur->origine)
		$img="<img src=\"images/flags/$joueur->origine.gif\" border=\"0\" align=\"absmiddle\" alt=\"$joueur->origine\">";

	if($header=='win') {
		$href='#';
		$onclick="onclick=\"opener.location='?page=joueurs&id=$id$op'\"";
	}
	else {
		$href="?page=joueurs&id=$id$op";
		$onclick='';
	}

	$pseudo=stripslashes($joueur->pseudo);

	if($align=='right') {
		if($status=='F')
			return "<span class=\"warning\">$strForfait</span> $seed <a href=\"$href\" $onclick><strike><span class=\"$class\">$pseudo</span></strike></a> $img";
		elseif($status=='D')
			return "<span class=\"warning\">$strDisqualifie</span> $seed <a href=\"$href\" $onclick><strike><span class=\"$class\">$pseudo</span></strike></a> $img";
		elseif($status=='I')
			return "$seed <a href=\"$href\" $onclick><font color=gray><span class=\"$class\">$pseudo</span></font></a> $img";
		else
			return "$seed <a href=\"$href\" $onclick><span class=\"$class\">$pseudo</span></a> $img";
	}
	else {
		if($status=='F')
			return "$img <a href=\"$href\" $onclick><strike><span class=\"$class\">$pseudo</span></strike></a> $seed <span class=\"warning\">$strForfait</span>";
		elseif($status=='D')
			return "$img <a href=\"$href\" $onclick><strike><span class=\"$class\">$pseudo</span></strike></a> $seed <span class=\"warning\">$strDisqualifie</span>";
		elseif($status=='I')
			return "$img <a href=\"$href\" $onclick><font color=gray><span class=\"$class\">$pseudo</span> $seed</font></a>";
		else
			return "$img <a href=\"$href\" $onclick><span class=\"$class\">$pseudo</span> $seed</a>";

	}	
}

function show_enligne($id) {
	global $header,$mods;

	if(!$id) return;

	$joueur=joueur($id);

	$op='';

	//if($joueur->origine){
	//	$img="<img src=\"images/flags/$joueur->origine.gif\" border=\"0\" align=\"absmiddle\" alt=\"$joueur->origine\">";
	//	 }
	if(eregi('a', $joueur->grade)||eregi('b', $joueur->grade)) {
		$memcolor=$mods['MODEnLigneA'];
		 }
	 elseif(eregi('m', $joueur->grade)) {
		$memcolor=$mods['MODEnLigneMo'];
	 }
	 elseif(eregi('n', $joueur->grade)) {
		$memcolor=$mods['MODEnLigneN'];
	 }
	 elseif(eregi('x', $joueur->grade)) {
		$memcolor=$mods['MODEnLigneM'];
	 }
	 elseif (eregi('y', $joueur->grade)) {
		$memcolor=$mods['MODEnLigneW'];
	 }
	
	
		$href="?page=joueurs&id=$id$op";
		$onclick='';
	
	$pseudo=stripslashes($joueur->pseudo);

			return "<a href=\"$href\" $onclick><font color=$memcolor>".$pseudo."</font></a>";
	
}

function show_equipe($id,$op='',$status='',$seed=10000,$align='left',$class='') {
	global $strDisqualifie,$strForfait,$header;

	if(!$id) return;

	$equipe=equipe($id);

	if($seed && $seed!=10000)
		$seed="(#$seed)";
	else
		$seed="";
		
	if($op) $op="&op=$op";
	else $op='';
		
	if($equipe->origine)
		$img="<img src=\"images/flags/$equipe->origine.gif\" border=\"0\" align=\"absmiddle\" alt=\"$equipe->origine\">";

	if($header=='win') {
		$href='#';
		$onclick="onclick=\"opener.location='?page=equipes&id=$id$op'\"";
	}
	else {
		$href="?page=equipes&id=$id$op";
		$onclick='';
	}

	$tag=stripslashes($equipe->tag);

	if($align=='right') {
		if($status=='F')
			return "<span class=\"warning\">$strForfait</span> $seed <a href=\"$href\" $onclick><strike><span class=\"$class\">$tag</span></strike></a> $img";
		elseif($status=='D')
			return "<span class=\"warning\">$strDisqualifie</span> $seed <a href=\"$href\" $onclick><strike><span class=\"$class\">$tag</span></strike></a> $img";
		else
			return "$seed <a target=_parent href=\"$href\" $onclick><span class=\"$class\">$tag</span></p</a> $img";

	}
	else {
		if($status=='F')
			return "$img <a href=\"$href\" $onclick><strike>$tag</strike></a> $seed <span class=\"warning\">$strForfait</span>";
		elseif($status=='D')
			return "$img <a href=\"$href\" $onclick><strike>$tag</strike></a> $seed <span class=\"warning\">$strDisqualifie</span>";
		else
			return "$img <a href=\"$href\" $onclick><span class=\"$class\">$tag $seed</span></a>";
		}
}


function show_score1($score1,$score2,$frags1,$frags2,$type,$status,$statusequipe,$modematchscore) {

	if($type=='P') $style="poule";
	elseif($type=='F') $style="finale";
	else $style="match";
	
	if($status=='F') $style='score';
	elseif($status=='V') $style='score';
		
	if($statusequipe=="F1" || $statusequipe=="D1") $perdant=1;
	elseif($statusequipe=="F2" || $statusequipe=="D2") $perdant=2;
	else $perdant=0;

	if($status=='A' || $status=='C') $score1=$score2='-';

	if($status!='T') return "<td class=\"null$style\" width=\"15\" align=\"center\">$score1</td>";

	if($score1 > $score2) {
		if($perdant==1)
			return "<td class=\"loose$style\" width=\"15\" align=\"center\">$score1</td>";
		else
			return "<td class=\"win$style\" width=\"15\" align=\"center\">$score1</td>";
	}
	elseif($score1 < $score2) {
		if($perdant==2)
			return "<td class=\"win$style\" width=\"15\" align=\"center\">$score1</td>";
		else
			return "<td class=\"loose$style\" width=\"15\" align=\"center\">$score1</td>";
	}
	else {
		if($perdant==1)
			return "<td class=\"loose$style\" width=\"15\" align=\"center\">$score1</td>";
		elseif($perdant==2)
			return "<td class=\"win$style\" width=\"15\" align=\"center\">$score1</td>";
		else {
			if($modematchscore=='RF' && $frags1 > $frags2)
				return "<td class=\"win$style\" width=\"15\" align=\"center\">$score1</td>";
			elseif($modematchscore=='RF' && $frags1 < $frags2)
				return "<td class=\"loose$style\" width=\"15\" align=\"center\">$score1</td>";
			else
				return "<td class=\"null$style\" width=\"15\" align=\"center\">$score1</td>";
		}
	}
}

function show_score2($score1,$score2,$frags1,$frags2,$type,$status,$statusequipe,$modematchscore) {

	if($type=='P') $style="poule";
	elseif($type=='F') $style="finale";
	else $style="match";
	
	if($status=='F') $style='score';
	elseif($status=='V') $style='score';
	
	if($statusequipe=="F1" || $statusequipe=="D1") $perdant=1;
	elseif($statusequipe=="F2" || $statusequipe=="D2") $perdant=2;
	else $perdant=0;

	if($status=='A' || $status=='C') $score1=$score2='-';

	if($status!='T') return "<td class=\"null$style\" width=\"15\" align=\"center\">$score2</td>";

	if($score1 > $score2) {
		if($perdant==1)
			return "<td class=\"win$style\" width=\"15\" align=\"center\">$score2</td>";
		else
			return "<td class=\"loose$style\" width=\"15\" align=\"center\">$score2</td>";
	}
	elseif($score1 < $score2) {
		if($perdant==2)
			return "<td class=\"loose$style\" width=\"15\" align=\"center\">$score2</td>";
		else
			return "<td class=\"win$style\" width=\"15\" align=\"center\">$score2</td>";
	}
	else {
		if($perdant==1)
			return "<td class=\"win$style\" width=\"15\" align=\"center\">$score2</td>";
		elseif($perdant==2)
			return "<td class=\"loose$style\" width=\"15\" align=\"center\">$score2</td>";
		else {
			if($modematchscore=='RF' && $frags1 < $frags2)
				return "<td class=\"win$style\" width=\"15\" align=\"center\">$score2</td>";
			elseif($modematchscore=='RF' && $frags1 > $frags2)
				return "<td class=\"loose$style\" width=\"15\" align=\"center\">$score2</td>";
			else
				return "<td class=\"null$style\" width=\"15\" align=\"center\">$score2</td>";
		}
	}
}

function show_match_finale($id,$op='') {
	global $db,$dbprefix,$s_joueur;	
	global $strCache,$strActif,$strEnCours,$strValidation,$strConflit,$strTermine,$grade;
	
	$match=match($id);
	
		/*** verification securite ***/
	//if($op=='admin') verif_admin_tournois($s_joueur,$match->tournois);	
	if($op == "admin") verif_admin_tournois($s_joueur,$match->tournois,$grade['a'],$grade['b'],$grade['t']);
	
	/*** r&eacute;cup&eacute;ration des infos ***/
	$seed1=seed($match->equipe1, $match->tournois);
	$seed2=seed($match->equipe2, $match->tournois);
	$modeequipe_tournois=modeequipe_tournois($match->tournois);	
	$modescore_tournois=modescore_tournois($match->tournois);	
		
	if($modeequipe_tournois=='E') $show = "show_equipe";
	else $show = "show_joueur";
	
	if($op) $op_str="&op=$op";
	else $op_str='';
	
	if($match->status == "C") $title=$strCache;
	if($match->status == "A") $title=$strActif;
	if($match->status == "D") $title=$strEnCours;
	if($match->status == "V") $title=$strValidation;
	if($match->status == "F") $title=$strConflit;
	if($match->status == "T") $title=$strTermine;
	
	echo '<table cellspacing="0" cellpadding="0" border="0"><tr><td>';
	
	// info du match
	echo '<table cellspacing="0" cellpadding="0" border="0">';
	if($op=='admin') {
		echo "<tr valign=\"center\"><td class=\"info\" align=\"center\">$match->status</td></tr>";
		$hauteur=400;
	}
	else
		$hauteur=300;		
	
	echo "<tr valign=\"center\"><td class=\"info\" align=\"center\">";
	if($match) echo "<input type=\"radio\" name=\"match\" value=\"$match->id\" onclick=\"javascript:ouvrir_fenetre('?page=matchs_gestion$op_str&id=$match->id&header=win','match',$hauteur,500)\" style=\"border: 0px;background-color:transparent;\" title=\"$title\">";
	else echo "<input type=\"radio\" name=\"match_off\" disabled>";
	echo "</td></tr>";
	

	if($op=='admin' && ($match->status=='C' || $match->status=='A'|| ($match->status=='D' && ($modescore_tournois=='M4' || $modescore_tournois=='AB'))))
		echo "<tr valign=\"center\"><td class=\"info\" align=\"center\"><input type=\"checkbox\" name=\"tab_matches[]\" value=\"$match->id\" style=\"border: 0px;background-color:transparent;\"></td></tr>";
	
	echo '</table>';
		
	echo '</td><td>';
	
	// tableau match
	echo '<table cellspacing="1" cellpadding="1" width="150" border="1">';
	// ekip 1
	echo '<tr height="20" valign="middle">';
	echo '<td class="text" width="120">';
	if($match->statusequipe == 'F1') echo $show($match->equipe1,$op,'F',$seed1);
	elseif($match->statusequipe == 'D1') echo $show($match->equipe1,$op,'D',$seed1);
	else echo $show($match->equipe1,$op,'',$seed1);
	echo '</td>';
	echo show_score1($match->score1,$match->score2,$match->frags1,$match->frags2,$match->type,$match->status,$match->statusequipe,$match->modematchscore);
	echo '</tr>';

	// milieu	
	echo '<tr height="10">';
	
	/** manche en cours **/
	$mancheactive=manche_active($match->id);
	
	if($mancheactive->map && ($match->status=='D')) {
		$map="- $mancheactive->map";
	
		if(nb_manches($match->id) > 1) $map.= " - $match->score1_manche:$match->score2_manche";
		
	}
	else $map='';
		
	/** date **/
	$date_now = time();
	$date=strftime(DATESTRING1, $match->date);
	if(!$match->date) $date='';

	if($match->date < $date_now)
		$date="<font color=\"red\">$date</font>";
	
	if($match->date && ($match->status=='C' || $match->status=='A')) $date="- $date";
	else $date='';
	
	echo "<td colspan=\"2\" class=\"info\" nowrap><img src=\"images/next.gif\" border=\"0\" align=\"absmiddle\"><small>$match->id $map $date</small></td>";
	echo '</tr>';

	// ekip2
	echo '<tr height="20" valign="middle">';
	echo '<td class="text" width="120">';
	if($match->statusequipe == 'F2') echo $show($match->equipe2,$op,'F',$seed2);
	elseif($match->statusequipe == 'D2') echo $show($match->equipe2,$op,'D',$seed2);
	else echo $show($match->equipe2,$op,'',$seed2);
	echo '</td>';
	echo show_score2($match->score1,$match->score2,$match->frags1,$match->frags2,$match->type,$match->status,$match->statusequipe,$match->modematchscore);
	echo '</tr>';
	echo '</table>';
	// end match
	echo '</td></tr></table>';
	
}

function show_match_finale_exp($id,$op='') {
	global $db,$dbprefix,$s_joueur;	
	global $strCache,$strActif,$strEnCours,$strValidation,$strConflit,$strTermine,$grade;
	
	$match=match($id);
	
		/*** verification securite ***/
	//if($op=='admin') verif_admin_tournois($s_joueur,$match->tournois);	
	if($op == "admin") verif_admin_tournois($s_joueur,$match->tournois,$grade['a'],$grade['b'],$grade['t']);
	
	/*** r&eacute;cup&eacute;ration des infos ***/
	$seed1=seed($match->equipe1, $match->tournois);
	$seed2=seed($match->equipe2, $match->tournois);
	$modeequipe_tournois=modeequipe_tournois($match->tournois);	
	$modescore_tournois=modescore_tournois($match->tournois);	
		
	if($modeequipe_tournois=='E') $show = "show_equipe";
	else $show = "show_joueur";
	
	if($op) $op_str="&op=$op";
	else $op_str='';
	
	if($match->status == "C") $title=$strCache;
	if($match->status == "A") $title=$strActif;
	if($match->status == "D") $title=$strEnCours;
	if($match->status == "V") $title=$strValidation;
	if($match->status == "F") $title=$strConflit;
	if($match->status == "T") $title=$strTermine;
	
	$ret_exp = '<table cellspacing="0" cellpadding="0" border="0"><tr><td>';
	
	// info du match
	$ret_exp .= '<table cellspacing="0" cellpadding="0" border="0">';
	if($op=='admin') {
		$ret_exp .= "<tr valign=\"center\"><td class=\"info\" align=\"center\">$match->status</td></tr>";
		$hauteur=400;
	}
	else
		$hauteur=300;		
	
	$ret_exp .= "<tr valign=\"center\"><td class=\"info\" align=\"center\">";
	if($match) $ret_exp .= "<input type=\"radio\" name=\"match\" value=\"$match->id\" onclick=\"javascript:ouvrir_fenetre('?page=matchs_gestion$op_str&id=$match->id&header=win','match',$hauteur,500)\" style=\"border: 0px;background-color:transparent;\" title=\"$title\">";
	else $ret_exp .= "<input type=\"radio\" name=\"match_off\" disabled>";
	$ret_exp .= "</td></tr>";
	

	if($op=='admin' && ($match->status=='C' || $match->status=='A'|| ($match->status=='D' && ($modescore_tournois=='M4' || $modescore_tournois=='AB'))))
		$ret_exp .= "<tr valign=\"center\"><td class=\"info\" align=\"center\"><input type=\"checkbox\" name=\"tab_matches[]\" value=\"$match->id\" style=\"border: 0px;background-color:transparent;\"></td></tr>";
	
	$ret_exp .= '</table>';
		
	$ret_exp .= '</td><td>';
	
	// tableau match
	$ret_exp .= '<table cellspacing="1" cellpadding="1" width="150" border="1">';
	// ekip 1
	$ret_exp .= '<tr height="20" valign="middle">';
	$ret_exp .= '<td class="text" width="120">';
	if($match->statusequipe == 'F1') $ret_exp .= $show($match->equipe1,$op,'F',$seed1);
	elseif($match->statusequipe == 'D1') $ret_exp .= $show($match->equipe1,$op,'D',$seed1);
	else $ret_exp .= $show($match->equipe1,$op,'',$seed1);
	$ret_exp .= '</td>';
	$ret_exp .= show_score1($match->score1,$match->score2,$match->frags1,$match->frags2,$match->type,$match->status,$match->statusequipe,$match->modematchscore);
	$ret_exp .= '</tr>';

	// milieu	
	$ret_exp .= '<tr height="10">';
	
	/** manche en cours **/
	$mancheactive=manche_active($match->id);
	
	if($mancheactive->map && ($match->status=='D')) {
		$map="- $mancheactive->map";
	
		if(nb_manches($match->id) > 1) $map.= " - $match->score1_manche:$match->score2_manche";
		
	}
	else $map='';
		
	/** date **/
	$date_now = time();
	$date=strftime(DATESTRING1, $match->date);
	if(!$match->date) $date='';

	if($match->date < $date_now)
		$date="<font color=\"red\">$date</font>";
	
	if($match->date && ($match->status=='C' || $match->status=='A')) $date="- $date";
	else $date='';
	
	$ret_exp .= "<td colspan=\"2\" class=\"info\" nowrap><img src=\"images/next.gif\" border=\"0\" align=\"absmiddle\"><small>$match->id $map $date</small></td>";
	$ret_exp .= '</tr>';

	// ekip2
	$ret_exp .= '<tr height="20" valign="middle">';
	$ret_exp .= '<td class="text" width="120">';
	if($match->statusequipe == 'F2') $ret_exp .= $show($match->equipe2,$op,'F',$seed2);
	elseif($match->statusequipe == 'D2') $ret_exp .= $show($match->equipe2,$op,'D',$seed2);
	else $ret_exp .= $show($match->equipe2,$op,'',$seed2);
	$ret_exp .= '</td>';
	$ret_exp .= show_score2($match->score1,$match->score2,$match->frags1,$match->frags2,$match->type,$match->status,$match->statusequipe,$match->modematchscore);
	$ret_exp .= '</tr>';
	$ret_exp .= '</table>';
	// end match
	$ret_exp .= '</td></tr></table>';
	
	return $ret_exp;
}

function show_match_lastresult($id,$op='',$class) {
	global $db,$dbprefix,$s_joueur,$strVS,$strScore,$strMap;
	global $strCache,$strActif,$strEnCours,$strValidation,$strConflit,$strTermine;

	$match=match($id);
	if(!$match) return;
	
		
	/*** r&eacute;cup&eacute;ration des infos ***/
	$seed1=seed($match->equipe1, $match->tournois);
	$seed2=seed($match->equipe2, $match->tournois);
	$modeequipe_tournois=modeequipe_tournois($match->tournois);
	$modescore_tournois=modescore_tournois($match->tournois);

	if($modeequipe_tournois=='E') $show = "show_equipe";
	else $show = "show_joueur";
	
	if($op!='admin' && $match->status=='C') $match='';
	
	if($op) $op_str="&op=$op";
	else $op_str='';
	

	if($match->status == "T") $title=$strTermine;
			

	// info du match
	$hauteur=350;
	echo '<table cellspacing="0" cellpadding="0" border="0" width="100%"><tr>';
	
 $echo_value = ''; 
	
	// ekip 1
	echo '<td class="'.$class.'" align="left" width="40%" height="20">';
	
	$tournois = tournois($match->tournois);
	echo '<a href="?page=tournois&op=select&id='. $tournois->id .'"><img src="images/jeux/'. $tournois->icone .'" border=0 alt="'. $tournois->nom .'" /></a>&nbsp;&nbsp;';
		
	//echo tournois_lastresult($match->tournois).'&nbsp;';
	if($match->statusequipe == 'F1') echo $show($match->equipe1,$op,'F',$seed1);
	elseif($match->statusequipe == 'D1') echo $show($match->equipe1,$op,'D',$seed1);
	else echo $show($match->equipe1,$op,'',$seed1);
	echo '</td>';
	echo '<td align="center" valign="center" height="20">';
	echo show_score1($match->score1,$match->score2,$match->frags1,$match->frags2,$match->type,$match->status,$match->statusequipe,$match->modematchscore);
	echo '</td><td height="20" class="text" align="center" valign="center" >'.$strVS.'</td><td height="20" align="center" valign="center">';
	echo show_score2($match->score1,$match->score2,$match->frags1,$match->frags2,$match->type,$match->status,$match->statusequipe,$match->modematchscore);
echo '</td>';
	// ekip 2
	echo '<td height="20" class="'.$class.'" align="right" width="40%">';
	if($match->statusequipe == 'F2') echo $show($match->equipe2,$op,'F',$seed2,'right');
	elseif($match->statusequipe == 'D2') echo $show($match->equipe2,$op,'D',$seed2,'right');
	else echo $show($match->equipe2,$op,'',$seed2,'right');
	
	echo "<input type=\"radio\" name=\"match\" value=\"$match->id\" onclick=\"javascript:ouvrir_fenetre('?page=matchs_gestion$op_str&id=$match->id&header=win','match',$hauteur,500)\" style=\"border: 0px;background-color:transparent;\" title=\"$title\">";
	
	echo '</td>';
	echo '</tr>';
	echo '</td></tr></table>';
}

function show_match_poule($id,$op='') {
	global $db,$dbprefix,$s_joueur,$strVS,$strScore,$strMap;
	global $strCache,$strActif,$strEnCours,$strValidation,$strConflit,$strTermine,$grade;

	$match=match($id);
	if(!$match) return;
	
	/*** verification securite ***/
	//if($op=='admin') verif_admin_tournois($s_joueur,$match->tournois);
	if($op=='admin') verif_admin_tournois($s_joueur,$match->tournois,$grade['a'],$grade['b'],$grade['t']);
	
	/*** r&eacute;cup&eacute;ration des infos ***/
	$seed1=seed($match->equipe1, $match->tournois);
	$seed2=seed($match->equipe2, $match->tournois);
	$modeequipe_tournois=modeequipe_tournois($match->tournois);
	$modescore_tournois=modescore_tournois($match->tournois);

	if($modeequipe_tournois=='E') $show = "show_equipe";
	else $show = "show_joueur";
	
	if($op!='admin' && $match->status=='C') $match='';
	
	if($op) $op_str="&op=$op";
	else $op_str='';
	
	if($match->status == "C") $title=$strCache;
	if($match->status == "A") $title=$strActif;
	if($match->status == "D") $title=$strEnCours;
	if($match->status == "V") $title=$strValidation;
	if($match->status == "F") $title=$strConflit;
	if($match->status == "T") $title=$strTermine;
			

	// info du match
	echo '<table cellspacing="0" cellpadding="0" border="0"><tr><td>';
	echo '<table cellspacing="0" cellpadding="0" border="0"><tr valign=center>';

	if($op=='admin') {
		echo "<td class=\"info\">$match->status</td>";
		$hauteur=450;
	}
	elseif($op=='report') {
		$hauteur=400;
	}
	else {
		$hauteur=350;
	}

	echo "<td class=\"info\"><input type=\"radio\" name=\"match\" value=\"$match->id\" onclick=\"javascript:ouvrir_fenetre('?page=matchs_gestion$op_str&id=$match->id&header=win','match',$hauteur,500)\" style=\"border: 0px;background-color:transparent;\" title=\"$title\">";

	if($op=='admin' && ($match->status=='C' || $match->status=='A'|| ($match->status=='D' && ($modescore_tournois=='M4' || $modescore_tournois=='AB'))))
		echo "<td class=\"info\"><input type=\"checkbox\" name=\"tab_matches[]\" value=\"$match->id\" style=\"border: 0px;background-color:transparent;\"></td>";

	echo '</tr>';
	echo '</table>';
	echo '</td>';

	// ekip 1
	echo '<td class="text" align="left" width="120">';
	if($match->statusequipe == 'F1') echo $show($match->equipe1,$op,'F',$seed1);
	elseif($match->statusequipe == 'D1') echo $show($match->equipe1,$op,'D',$seed1);
	else echo $show($match->equipe1,$op,'',$seed1);
	echo '</td>';

	echo show_score1($match->score1,$match->score2,$match->frags1,$match->frags2,$match->type,$match->status,$match->statusequipe,$match->modematchscore);
	echo '<td class="text" align="center" width="20">'.$strVS.'</td>';
	echo show_score2($match->score1,$match->score2,$match->frags1,$match->frags2,$match->type,$match->status,$match->statusequipe,$match->modematchscore);

	// ekip 2
	echo '<td class="text" align="right" width="120">';
	if($match->statusequipe == 'F2') echo $show($match->equipe2,$op,'F',$seed2,'right');
	elseif($match->statusequipe == 'D2') echo $show($match->equipe2,$op,'D',$seed2,'right');
	else echo $show($match->equipe2,$op,'',$seed2,'right');
	echo '</td>';
	echo '</tr>';
	
	/** info du match **/
	if($op!='report' && (($match->status!='T' && $match->status!='F'  && $match->status!='V') || $op=='admin' )) {

		$map='';

		/** manche **/
		if($match->status=='A') {
			$manches=manches($match->id);

			for($i=0;$i<count($manches);$i++) {
				if($manches[$i]->map) {
					$map.=$manches[$i]->map.',';
				}
			}
			$map=substr($map,0,-1);

		}
		elseif($match->status=='D') {
			$mancheactive=manche_active($match->id);
			if($mancheactive->map) {
				$map=$mancheactive->map;
				if(nb_manches($match->id) > 1) $map.= ': '.$mancheactive->score1.'/'.$mancheactive->score2;
			}
		}

		if($map) $map="- $map";


		/** date **/
		/*$date_now = time();
		$date=strftime(DATESTRING, $match->date);
		if(!$match->date) $date='';

		if($match->date < $date_now && ($match->status=='C' || $match->status=='A'))
			$date='<font color="red">'.$date.'</font>';

		if($match->date && ($match->status=='C' || $match->status=='A')) $date="- $date";
		else $date='';*/
	
		echo '<tr height="10">';
		echo '<td></td>';
		echo '<td class="info" colspan="5" nowrap ><img src="images/next.gif" border="0" align="absmiddle" alt="next"><small>'.$match->id.' '.$map.'</small></td>';
		echo '</tr>';
	}
	echo '</td></tr></table>';

}

function show_erreur_saisie($str) {
	global $strRetour,$strErreurDeSaisie;

	echo "<br><img src=images/warning.gif border=0 align=absmiddle>&nbsp;<span class=info><b>$strErreurDeSaisie</b></span>";
	echo "<br><br><span class=warning>$str</span>";
	echo "<br><img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";
}

function show_erreur($str) {
	global $strRetour,$strErreur;
	
	echo "<br><img src=images/warning.gif border=0 align=absmiddle>&nbsp;<span class=warning>$strErreur: $str</span>";
	echo "<br><br><img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";
}

function show_notice($str) {
	global $strRetour;

	echo "<img src=images/info.gif border=0 align=absmiddle>&nbsp;<span class=info>$str</span><br>";
}

function show_warning($str) {
	global $strRetour;

	echo "<img src=images/warning.gif border=0 align=absmiddle>&nbsp;<span class=warning>$str</span><br>";

}

function show_avatar($img) {
	
	if($img) return $img;
	else return '<img src="./images/avatars/unknown.gif" alt="" style="border: 1px solid #000000;padding: 1px;">';
}

function show_consignes($str) {
	global $strConsignes;
	
	echo "<table cellspacing=0 cellpadding=0 border=0 align=center style=\"margin: 0 10 0 10;\">";
	echo "<tr><td class=title><img src=images/consignes.gif align=absmiddle> <u>$strConsignes</u> :</td></tr>";
	echo "<tr><td class=title><div align=justify style=\"margin-left:5px\">$str</div></td></tr>";
	echo "</table><br>";
}

function steam_checking($idsteam) {
	global $db,$dbprefix;

	
	$db->select("steam");
	$db->from("${dbprefix}joueurs");
	$db->where("steam = '$idsteam'");
	$res=$db->exec();

	return $db->num_rows($res);
}

/**** ADMIN *******************/

function admin_general($id) {
	global $db,$dbprefix;

	if(!is_numeric($id)) return 0;

	$db->select("id");
	$db->from("${dbprefix}joueurs");
	$db->where("id = $id");
	$db->where("admin = 'O'");
	$res=$db->exec();

	return $db->num_rows($res);
}

function modo($id) {
	global $db,$dbprefix;

	if(!is_numeric($id)) return 0;

	$db->select("id");
	$db->from("${dbprefix}joueurs");
	$db->where("id = $id");
	$db->where("modo = 'O'");
	$res=$db->exec();

	return $db->num_rows($res);
}

function admin_news($id,$news) {
	global $db,$dbprefix;

	if(!is_numeric($id) || !is_numeric($news)) return 0;

	$db->select("${dbprefix}joueurs.id");
	$db->from("${dbprefix}joueurs, ${dbprefix}news");
	$db->where("${dbprefix}joueurs.id = $id");
	$db->where("${dbprefix}news.id = $news");
	$db->where("newseur = 'O'");
	$db->where("${dbprefix}joueurs.id = ${dbprefix}news.auteur");
	$res=$db->exec();

	return $db->num_rows($res);
}

/*
function grade_s($id) {
	global $db,$dbprefix;
	//if(!$grades) $gardes=array("a" => "",    "b" => "",    "c" => "","d" => "",    "e" => "","f" => "",	"g" => "",    "h" => "",    "i" => "",	"j" => "",    "k" => "",    
	//"l" => "",	"m" => "",    "n" => "",    "o" => "","p" => "",	"q" => "",	"r" => "",	"s" => "",	"t" => "",	"u" => "",	"v" => "",	"w" => "",	"x" => "",	"y" => "",	"z" => "",);
	
	$db->select("id,grade");
	$db->from("${dbprefix}joueurs");
	$db->where("id = $id");
	$res=$db->exec();
	//$grade_checking = $db->fetch($res);
	//$_SESSION['grade'] = $grade_checking->grade;
	
	/*$_SESSION['grade'] = array(
	"a" => "",
    "b" => "",
    "c" => "",
	"d" => "",
    "e" => "",
    "f" => "",
	"g" => "",
    "h" => "",
    "i" => "",
	"j" => "",
    "k" => "",
    "l" => "",
	"m" => "",
    "n" => "",
    "o" => "", 
	"p" => "",
	"q" => "",
	"r" => "",
	"s" => "",
	"t" => "",
	"u" => "",
	"v" => "",
	"w" => "",
	"x" => "",
	"y" => "",
	"z" => "",
	);
	*/
		
	//while ($grade_ch = $db->fetch($res)) {
	
	/*
	//  A est 'le' chef
	if (eregi('a', $grade_ch->grade)) {
    $_SESSION['grade']['a'] = 'a'; 
    }
	// B peut tout faire sauf modifier 'le chef'
	if (eregi('b', $grade_ch->grade)) {
    $_SESSION['grade']['b'] = 'b'; 
    }
	// C peut modifier la configuration (mods comprit)
	if (eregi('c', $grade_ch->grade)) {
    $_SESSION['grade']['c'] = 'c'; 
    }
	// D gère les downloads
	if (eregi('d', $grade_ch->grade)) {
    $_SESSION['grade']['d'] = 'd'; 
    }
	//E peut gèrer les &eacute;quipe
	if (eregi('e', $grade_ch->grade)) {
    $_SESSION['grade']['e'] = 'e'; 
    }
	//E peut cr&eacute;er des pages ou des menus
	if (eregi('f', $grade_ch->grade)) {
    $_SESSION['grade']['f'] = 'f'; 
    }
	if (eregi('g', $grade_ch->grade)) {
    $_SESSION['grade']['g'] = 'g'; 
    }
	//H peut gèrer les liens ( <a Href=''> ) 
	if (eregi('h', $grade_ch->grade)) {
    $_SESSION['grade']['h'] = 'h'; 
    }
	//I peut gèrer le livre d'or ???
	if (eregi('i', $grade_ch->grade)) {
    $_SESSION['grade']['i'] = 'i'; 
    }
	//J peut gèrer les joueurs
	if (eregi('j', $grade_ch->grade)) {
    $_SESSION['grade']['j'] = 'j'; 
    }
	if (eregi('k', $grade_ch->grade)) {
    $_SESSION['grade']['k'] = 'k'; 
    }
	//L peut utiliser la maling List
	if (eregi('l', $grade_ch->grade)) {
    $_SESSION['grade']['l'] = 'l'; 
    }
	// M Mod&eacute;rateur
	if (eregi('m', $grade_ch->grade)) {
    $_SESSION['grade']['m'] = 'm'; 
    }
	// N newser
	if (eregi('n', $grade_ch->grade)) {
    $_SESSION['grade']['n'] = 'n'; 
    }
	if (eregi('o', $grade_ch->grade)) {
    $_SESSION['grade']['o'] = 'o'; 
    }
	// P gère les partenaire
	if (eregi('p', $grade_ch->grade)) {
    $_SESSION['grade']['p'] = 'p'; 
    }
	if (eregi('q', $grade_ch->grade)) {
    $_SESSION['grade']['q'] = 'q'; 
    }
	// S gère les server
	if (eregi('r', $grade_ch->grade)) {
    $_SESSION['grade']['r'] = 'r'; 
    }
	// S gère les sponsors
	if (eregi('s', $grade_ch->grade)) {
    $_SESSION['grade']['s'] = 's'; 
    }
	// T admin de tous les tournois (est orga & admin)
	if (eregi('t', $grade_ch->grade)) {
    $_SESSION['grade']['t'] = 't'; 
    }
	// U admin des ladder (cr&eacute;er, gère..).
	if (eregi('u', $grade_ch->grade)) {
    $_SESSION['grade']['u'] = 'u'; 
    }
	if (eregi('v', $grade_ch->grade)) {
    $_SESSION['grade']['v'] = 'v'; 
    }
	if (eregi('w', $grade_ch->grade)) {
    $_SESSION['grade']['w'] = 'w'; 
    }
	if (eregi('x', $grade_ch->grade)) {
    $_SESSION['grade']['x'] = 'x'; 
    }
	if (eregi('y', $grade_ch->grade)) {
    $_SESSION['grade']['y'] = 'y'; 
    }
	//le Z est le rang 'user' un membre qui n'a pas "z" est bannit...
	if (eregi('z', $grade_ch->grade)) {
    $_SESSION['grade']['z'] = 'z'; 
    }
	 */
	 /*
	 //  A est 'le' chef
	if (eregi('a', $grade_ch->grade)) {
   $grades['a'] = 'a'; 
    }
	// B peut tout faire sauf modifier 'le chef'
	if (eregi('b', $grade_ch->grade)) {
   $grades['b'] = 'b'; 
    }
	// C peut modifier la configuration (mods comprit)
	if (eregi('c', $grade_ch->grade)) {
   $grades['c'] = 'c'; 
    }
	// D gère les downloads
	if (eregi('d', $grade_ch->grade)) {
   $grades['d'] = 'd'; 
    }
	//E peut gèrer les &eacute;quipe
	if (eregi('e', $grade_ch->grade)) {
   $grades['e'] = 'e'; 
    }
	//E peut cr&eacute;er des pages ou des menus
	if (eregi('f', $grade_ch->grade)) {
   $grades['f'] = 'f'; 
    }
	if (eregi('g', $grade_ch->grade)) {
   $grades['g'] = 'g'; 
    }
	//H peut gèrer les liens ( <a Href=''> ) 
	if (eregi('h', $grade_ch->grade)) {
   $grades['h'] = 'h'; 
    }
	//I peut gèrer le livre d'or ???
	if (eregi('i', $grade_ch->grade)) {
   $grades['i'] = 'i'; 
    }
	//J peut gèrer les joueurs
	if (eregi('j', $grade_ch->grade)) {
   $grades['j'] = 'j'; 
    }
	if (eregi('k', $grade_ch->grade)) {
   $grades['k'] = 'k'; 
    }
	//L peut utiliser la maling List
	if (eregi('l', $grade_ch->grade)) {
   $grades['l'] = 'l'; 
    }
	// M Mod&eacute;rateur
	if (eregi('m', $grade_ch->grade)) {
   $grades['m'] = 'm'; 
    }
	// N newser
	if (eregi('n', $grade_ch->grade)) {
   $grades['n'] = 'n'; 
    }
	if (eregi('o', $grade_ch->grade)) {
   $grades['o'] = 'o'; 
    }
	// P gère les partenaire
	if (eregi('p', $grade_ch->grade)) {
   $grades['p'] = 'p'; 
    }
	if (eregi('q', $grade_ch->grade)) {
   $grades['q'] = 'q'; 
    }
	// S gère les server
	if (eregi('r', $grade_ch->grade)) {
   $grades['r'] = 'r'; 
    }
	// S gère les sponsors
	if (eregi('s', $grade_ch->grade)) {
   $grades['s'] = 's'; 
    }
	// T admin de tous les tournois (est orga & admin)
	if (eregi('t', $grade_ch->grade)) {
   $grades['t'] = 't'; 
    }
	// U admin des ladder (cr&eacute;er, gère..).
	if (eregi('u', $grade_ch->grade)) {
   $grades['u'] = 'u'; 
    }
	if (eregi('v', $grade_ch->grade)) {
   $grades['v'] = 'v'; 
    }
	if (eregi('w', $grade_ch->grade)) {
   $grades['w'] = 'w'; 
    }
	if (eregi('x', $grade_ch->grade)) {
   $grades['x'] = 'x'; 
    }
	if (eregi('y', $grade_ch->grade)) {
   $grades['y'] = 'y'; 
    }
	//le Z est le rang 'user' un membre qui n'a pas "z" est bannit...
	if (eregi('z', $grade_ch->grade)) {
   $grades['z'] = 'z'; 
    }
	
	
	}
	
		
	return  $grades;
}*/

function admin_tournois($id,$tournois) {
	global $db,$dbprefix;

	if(!is_numeric($id) || !is_numeric($tournois)) return 0;

	$db->select("joueur");
	$db->from("${dbprefix}administre");
	$db->where("joueur = $id");
	$db->where("tournois = $tournois");
	$res=$db->exec();

	return $db->num_rows($res);
}

/**** MATCHSS **********************************/


function match($id) {
	global $db,$dbprefix;
	
	if(!is_numeric($id)) return;

	//fragaverage pur  F
	//roundaverage pur R
	//roundaverage + fragaverage RF

	$db->select("${dbprefix}matchs.*, ${dbprefix}manches.status as manchestatus, ${dbprefix}manches.score1 as score1, ${dbprefix}manches.score2 as score2");
	$db->from("${dbprefix}matchs LEFT JOIN ${dbprefix}manches ON (${dbprefix}matchs.id = ${dbprefix}manches.matchi)");
	$db->where("${dbprefix}matchs.id = $id");
	$db->order_by("${dbprefix}manches.id");
	$res=$db->exec();

	$score1=$score2=$frags1=$frags2=$score1_manche=$score2_manche=0;

	while($manche = $db->fetch($res)) {

		$match=$manche;
		$modematchscore=modematchscore_tournois($match->tournois);

		if($modematchscore=='F') {

			$score1+=$manche->score1;
			$score2+=$manche->score2;
			$frags1+=$manche->score1;
			$frags2+=$manche->score2;

			if($match->manchestatus == 'A') {
				$score1_manche=$manche->score1;
				$score2_manche=$manche->score2;
			}
		}

		elseif($modematchscore=='R' || $modematchscore=='RF') {

			if($match->manchestatus != 'A') {
				$frags1+=$manche->score1;
				$frags2+=$manche->score2;

				if($manche->score1 > $manche->score2) {
					$score1++;
				}
				elseif($manche->score1 < $manche->score2) {
					$score2++;
				}
			}
			else  {
				$score1_manche=$manche->score1;
				$score2_manche=$manche->score2;
			}
		}
	}

	$match->modematchscore=$modematchscore;
	$match->score1=$score1;
	$match->score2=$score2;
	$match->frags1=$frags1;
	$match->frags2=$frags2;
	$match->score1_manche=$score1_manche;
	$match->score2_manche=$score2_manche;

	return $match;
}

function status_match($id) {
	global $db,$dbprefix;

	if(!is_numeric($id)) return;

	$db->select("status");
	$db->from("${dbprefix}matchs");
	$db->where("id = $id");
	$res = $db->exec();
	$match= $db->fetch($res);

	return $match->status;
}

function manches($id) {
	global $db,$dbprefix;

	if(!is_numeric($id)) return;

	$db->select("*");
	$db->from("${dbprefix}manches");
	$db->where("matchi = $id");
	$db->order_by("id");
	$res=$db->exec();

	while($manche = $db->fetch($res)) {
		$manches[]=$manche;
	}
	return $manches;
}

function manche_active($id) {
	global $db,$dbprefix;

	if(!is_numeric($id)) return;
	
	$db->select("*");
	$db->from("${dbprefix}manches");
	$db->where("matchi = $id");
	$db->where("status = 'A'");
	$db->exec();
	$mancheactive = $db->fetch();

	return $mancheactive;
}

function manche_premier($id) {
	global $db,$dbprefix;

	if(!is_numeric($id)) return;

	$db->select("*");
	$db->from("${dbprefix}manches");
	$db->where("matchi = $id");
	$db->order_by("id");
	$db->limit(0,1);
	$db->exec();
	$manchepremier = $db->fetch();

	return $manchepremier;
}


function manche_suivante($id,$mancheid) {
	global $db,$dbprefix;

	if(!is_numeric($id) || !is_numeric($mancheid)) return;
	
	$db->select("*");
	$db->from("${dbprefix}manches");
	$db->where("matchi = $id");
	$db->where("id > $mancheid");
	$db->limit(0,1);
	$db->exec();	
	$nextmanche=$db->fetch();
		
	return $nextmanche;
}


function nb_manches($id) {
	global $db,$dbprefix;
	
	if(!is_numeric($id)) return 0;

	$db->select("count(${dbprefix}matchs.id) as nb");
	$db->from("${dbprefix}matchs LEFT JOIN ${dbprefix}manches ON (${dbprefix}matchs.id = ${dbprefix}manches.matchi)");
	$db->where("${dbprefix}matchs.id = $id");
	$db->exec();
	$manches = $db->fetch();

	return $manches->nb;
}


function match_finales($id) { 
/*** 0 si poule 1 si phase finale ***/
	global $db,$dbprefix;

	$db->select("finale");
	$db->from("${dbprefix}matchs");
	$db->where("id = $id");
	$db->where("finale is not null");
	$db->exec();

	return $db->num_rows();
}

/*** renvoie le rang de match (1/8,1/4,1/2,finale) dans winner/looser***/
function no_finale($id) {
	global $db,$dbprefix;

	$db->select("finale");
	$db->from("${dbprefix}matchs");
	$db->where("id = $id");
	$db->exec();
	$match = $db->fetch();

	return $match->finale;
}

/*** renvoie le numero du match dans winner/looser***/
function no_match($id) { 
	global $db,$dbprefix;

	$db->select("numero");
	$db->from("${dbprefix}matchs");
	$db->where("id = $id");
	$db->exec();
	$match = $db->fetch();

	return $match->numero;
}

/*** renvoie l'identifiant du match dans winner/looser***/
function id_match_finale($type,$finale,$numero,$tournois,$op='',$status='') {
	global $db,$dbprefix;

	$db->select("id");
	$db->from("${dbprefix}matchs");
	$db->where("type = '$type'");
	$db->where("finale = $finale");
	$db->where("numero = $numero");
	$db->where("tournois = $tournois");
	if($status=='T') $db->where("status = 'T'");
	if($status=='D') $db->where("status = 'D'");
	if($status=='A') $db->where("status = 'A'");
	if($op!='admin') $db->where("status != 'C'");
	$db->exec();
	$match = $db->fetch();

	return $match->id;
}

/*** renvoie les identifiants du match dans la poule + tour***/
function id_match_poule($poule,$tour,$tournois,$op='',$status='') {
	global $db,$dbprefix;
	
	$db->select("id");
	$db->from("${dbprefix}matchs");
	$db->where("type = 'P'");
	$db->where("poule = $poule");
	$db->where("tour = $tour");
	$db->where("tournois = $tournois");	
	if($status=='T') $db->where("status = 'T'");
	if($status=='D') $db->where("status = 'D'");
	if($status=='A') $db->where("status = 'A'");
	if($op!='admin') $db->where("status != 'C'");
	$db->order_by("id");
	$db->exec();

	$tab_id=array();
	
	while($id = $db->fetch()) {
		$tab_id[]=$id->id;
	}
	return $tab_id;
}

/*** renvoie le type de match dans winner/looser***/
function type_match($id) {
	global $db,$dbprefix;

	$db->select("type");
	$db->from("${dbprefix}matchs");
	$db->where("id = $id");
	$db->exec();
	$match = $db->fetch();

	return $match->type;
}

function equipe_gagnante($id) {
	global $db,$dbprefix;	
	$perdant=0;
	
	$match=match($id);

	if($match->statusequipe=="F1" || $match->statusequipe=="D1") $perdant=1;
	elseif($match->statusequipe=="F2" || $match->statusequipe=="D2") $perdant=2;

	if($match->score1 > $match->score2) {
		if($perdant==1)
			return $match->equipe2;
		else
			return $match->equipe1;
	}
	elseif($match->score1 < $match->score2) {
		if($perdant==2)
			return $match->equipe1;
		else
			return $match->equipe2;
	}
	else {
		if($perdant==1)
			return $match->equipe2;
		elseif($perdant==2)
			return $match->equipe1;
		else {
			if($match->modematchscore=='RF' && $match->frags1 > $match->frags2)
				return $match->equipe1;
			elseif($match->modematchscore=='RF' && $match->frags1 < $match->frags2)
				return $match->equipe2;
			else
				return 0;
		}
	}
}

function equipe_perdante($id) {
	global $db,$dbprefix;	
	$perdant=0;
	
	$match=match($id);

	if($match->statusequipe=="F1" || $match->statusequipe=="D1") $perdant=1;
	elseif($match->statusequipe=="F2" || $match->statusequipe=="D2") $perdant=2;

	if($match->score1 > $match->score2) {
		if($perdant==1)
			return $match->equipe1;
		else
			return $match->equipe2;
	}
	elseif($match->score1 < $match->score2) {
		if($perdant==2)
			return $match->equipe2;
		else
			return $match->equipe1;
	}
	else {
		if($perdant==1)
			return $match->equipe1;
		elseif($perdant==2)
			return $match->equipe2;
		else {
			if($match->modematchscore=='RF' && $match->frags1 > $match->frags2)
				return $match->equipe2;
			elseif($match->modematchscore=='RF' && $match->frags1 < $match->frags2)
				return $match->equipe1;
			else
				return 0;
		}
	}
}

function match_fini($id) {
	global $db,$dbprefix;
	
	if(!$id) return 0;
	
	$db->select("id");
	$db->from("${dbprefix}matchs");
	$db->where("id = $id");
	$db->where("status='T'");
	$db->exec();
	
	return $db->num_rows();
}

function calcul_finales($id) {
	global $db,$dbprefix,$s_tournois,$modeelimination_tournois,$nb_finales_winner_tournois,$nb_finales_looser_tournois;

	/*** verification securite ***/
	//verif_admin_tournois($s_joueur,$s_tournois);

	/*** creation du match suivant ***/
	$type_match=type_match($id);
	
	if(match_fini($id) && $type_match!='P') {
		$n_finale=no_finale($id);
		$no=no_match($id);
		$equipe_g=equipe_gagnante($id);
		$equipe_p=equipe_perdante($id);
		
		$forfait_perdant=0;
		
		/** pour ne pas envoyer le perdant disqualifi&eacute;/forfait winner dans le looser **/
		if(status_participe($equipe_p,$s_tournois)!='P') $forfait_perdant=1;
			
		/*echo "final: 1/$n_finale $type_match<BR>";
		echo "n°: $no<BR>";
		echo "equipe gagnante: $equipe_g<BR>";
		echo "equipe perdante: $equipe_p<BR><BR>";
 		*/

		// si le match n'est pas nul
		if(!($equipe_g==0 && $equipe_p==0)) {
		
			// si le match est dans le winner
			if($type_match=='W') {
				// pour les matchs gagnants du winner
				if(!($modeelimination_tournois=='S' && $n_finale==1) && !($modeelimination_tournois=='D' && $n_finale==0)) {
					$next_finale = floor($n_finale/2);
					$next_no = round($no/2);
					if($no %2 == 1) $next_pos=1;
					else $next_pos=2;
					/*
					echo "equipe gagnante: $equipe_g<BR>";
					echo "next final: 1/$next_finale W <BR>";
					echo "next n°: $next_no<BR>";
					echo "next pos°: $next_pos<BR>";
					*/

					$next_id=id_match_finale('W',$next_finale,$next_no,$s_tournois,'admin');
					//echo "next id: $next_id<BR><BR>";
					
					$db->update("${dbprefix}matchs");
					$db->set("equipe$next_pos = $equipe_g");
					$db->where("id = $next_id");
					$db->exec();					
				}

				// pour les perdants des matchs du winner du 1er tour
				if($modeelimination_tournois=='D' && $n_finale==$nb_finales_looser_tournois) {
					$next_finale =  $n_finale/2;
					$next_no = ($n_finale/2+1)-round($no/2);
					if($no %2 == 0) $next_pos=1;
					else $next_pos=2;
					
					/*echo "equipe perdante: $equipe_p<BR><BR>";
					echo "next final: 1/$next_finale L<BR>";
					echo "next n°: $next_no<BR>";
					echo "next pos°: $next_pos<BR>";
					*/

					$next_id=id_match_finale('L',$next_finale,$next_no,$s_tournois,'admin');
					//echo "next id: $next_id<BR><BR>";

					$db->update("${dbprefix}matchs");
					$db->set("equipe$next_pos = $equipe_p");
					if($forfait_perdant) $db->set("statusequipe = 'F$next_pos'");
					$db->where("id = $next_id");
					$db->exec();	
				}
				// pour les matchs perdants du winner autre que le 1er tour
				elseif($modeelimination_tournois=='D' && $n_finale<$nb_finales_looser_tournois && $n_finale!=0)  {
					$next_finale = $n_finale;
					$next_no = $no+$n_finale;
					$next_pos=1;

					/*echo "equipe perdante: $equipe_p<BR><BR>";
					echo "next final: 1/$next_finale L<BR>";
					echo "next n°: $next_no<BR>";
					echo "next pos°: $next_pos<BR>";
					*/

					$next_id=id_match_finale('L',$next_finale,$next_no,$s_tournois,'admin');
					//echo "next id: $next_id<BR><BR>";

					$db->update("${dbprefix}matchs");
					$db->set("equipe$next_pos = $equipe_p");
					if($forfait_perdant) $db->set("statusequipe = 'F$next_pos'");
					$db->where("id = $next_id");
					$db->exec();	
				}
			}
			// le match est un match du looser
			else
			{
				// pour les matchs gagnants du looser autre que la finale (la L 1.2)
				if($n_finale!=1 || $no!=2) {

					// si c le 1er tour
					if($no<=$n_finale) {
						$next_finale = $n_finale;
						$next_no = $no+$n_finale;
						$next_pos=2;
					
						/*echo "equipe gagnante: $equipe_g<BR>";
						echo "next final: 1/$next_finale L <BR>";
						echo "next n°: $next_no<BR>";
						echo "next pos°: $next_pos<BR>";
						*/

						$next_id=id_match_finale('L',$next_finale,$next_no,$s_tournois,'admin');
						//echo "next id: $next_id<BR><BR>";

						$db->update("${dbprefix}matchs");
						$db->set("equipe$next_pos = $equipe_g");					
						$db->where("id = $next_id");
						$db->exec();					
					}
					// si c le 2e tour
					else {
						$next_finale = floor($n_finale/2);
						$next_no = round(($no-$n_finale)/2);
						if($no %2 == 1) $next_pos=1;
						else $next_pos=2;
						
						/*echo "equipe gagnante: $equipe_g<BR>";
						echo "next final: 1/$next_finale L <BR>";
						echo "next n°: $next_no<BR>";
						echo "next pos°: $next_pos<BR>";
						*/

						$next_id=id_match_finale('L',$next_finale,$next_no,$s_tournois,'admin');
						//echo "next id: $next_id<BR><BR>";
						
						$db->update("${dbprefix}matchs");
						$db->set("equipe$next_pos = $equipe_g");					
						$db->where("id = $next_id");
						$db->exec();		
					}
				}
				// finale du looser (pour la remont&eacute;&eacute; en winner)
				elseif($n_finale==1 && $no==2) {
					$next_finale = 0;
					$next_no = 1;
					$next_pos=2;
					
					/*echo "equipe gagnante: $equipe_g<BR>";
					echo "next final: GRAND FINAL W <BR>";
					echo "next n°: $next_no<BR>";
					*/

					$next_id=id_match_finale('W',$next_finale,$next_no,$s_tournois,'admin');
					//echo "next id: $next_id<BR><BR>";

					$db->update("${dbprefix}matchs");
					$db->set("equipe$next_pos = $equipe_g");
					$db->where("id = $next_id");
					$db->exec();	
				}
			}
		}
	}	
}

/****** SERVEURS ********************/

function utilise_serveur($serveur, $tournois) {
	global $db,$dbprefix;

	$db->select("serveur");
	$db->from("${dbprefix}serveurs_tournois");
	$db->where("serveur = $serveur");
	$db->where("tournois = $tournois");
	$db->exec();

	return $db->num_rows();
}


/******* NOMBRES *****************/

function nb_joueurs() {
	global $db,$dbprefix;

	$db->select("count(id) as nb");
	$db->from("${dbprefix}joueurs");
	$db->where("(etat='I' or  etat='P')");
	$db->exec();
	$joueurs = $db->fetch();
	return $joueurs->nb;
}

function nb_joueurs_total($op) {
	global $db,$dbprefix;

	$db->select("count(id) as nb");
	$db->from("${dbprefix}joueurs");
	if($op!='admin') $db->where("(etat='I' or  etat='P')");
	$db->exec();
	$joueurs = $db->fetch();
	return $joueurs->nb;
}


function nb_joueurs_inscrit() {
	global $db,$dbprefix;

	$db->select("count(id) as nb");
	$db->from("${dbprefix}joueurs");
	$db->where("etat='I'");
	$db->exec();
	$joueurs = $db->fetch();
	return $joueurs->nb;
}


function nb_joueurs_preinscrit() {
	global $db,$dbprefix;

	$db->select("count(id) as nb");
	$db->from("${dbprefix}joueurs");
	$db->where("etat='P'");
	$db->exec();
	$joueurs = $db->fetch();
	return $joueurs->nb;
}


function nb_equipes() {
	global $db,$dbprefix;

	$db->select("count(id) as nb");
	$db->from("${dbprefix}equipes");
	$db->where("(etat='A' or  etat='V')");
	$db->exec();
	$equipes = $db->fetch();
	return $equipes->nb;
}

function nb_equipes_total($op) {
	global $db,$dbprefix;

	$db->select("count(id) as nb");
	$db->from("${dbprefix}equipes");
	if($op!='admin') $db->where("etat='A' or  etat='V'");
	$db->exec();
	$equipes = $db->fetch();
	return $equipes->nb;
}

function nb_equipes_attente() {
	global $db,$dbprefix;

	$db->select("count(id) as nb");
	$db->from("${dbprefix}equipes");
	$db->where("etat='A'");
	$db->exec();
	$equipes = $db->fetch();
	return $equipes->nb;
}


function nb_equipes_valide() {
	global $db,$dbprefix;

	$db->select("count(id) as nb");
	$db->from("${dbprefix}equipes");
	$db->where("etat='V'");
	$db->exec();
	$equipes = $db->fetch();
	return $equipes->nb;
}



function nb_tournois() {
	global $db,$dbprefix;

	$db->select("count(id) as nb");
	$db->from("${dbprefix}tournois");
	$db->exec();
	$tournois = $db->fetch();
	return $tournois->nb;
}


function nb_maps() {
	global $db,$dbprefix;

	$db->select("count(id) as nb");
	$db->from("${dbprefix}maps");
	$db->exec();
	$maps = $db->fetch();
	return $maps->nb;
}


function nb_jeux() {
	global $db,$dbprefix;

	$db->select("count(id) as nb");
	$db->from("${dbprefix}jeux");
	$db->exec();
	$jeux = $db->fetch();
	return $jeux->nb;
}


function nb_membres($id) {
	global $db,$dbprefix;

	$db->select("count(id) as nb");
	$db->from("${dbprefix}joueurs");
	$db->where("equipe = $id");
	$db->exec();
	$joueurs = $db->fetch();
	return $joueurs->nb;
}


function nb_serveurs() {
	global $db,$dbprefix;

	$db->select("count(id) as nb");
	$db->from("${dbprefix}serveurs");
	$db->exec();
	$serveurs = $db->fetch();
	return $serveurs->nb;
}

function nb_serveurs_tournois($tournois) {
	global $db,$dbprefix;

	$db->select("count(serveur) as nb");
	$db->from("${dbprefix}serveurs_tournois");
	$db->where("tournois = $tournois");
	$db->exec();
	$serveurs = $db->fetch();
	return $serveurs->nb;
}

function nb_serveurs_jeu($id) {
	global $db,$dbprefix;

	$db->select("count(DISTINCT jeux) as nb");
	$db->from("${dbprefix}serveurs");
	$db->where("jeux = $id");
	$db->group_by("jeux");
	$db->exec();
	$serveur = $db->fetch();
	if(!$serveur->nb) return 0;
	else return $serveur->nb;
}

function nb_inscrits_tournois($id) {
	global $db,$dbprefix;

	$db->select("count(equipe) as nb");
	$db->from("${dbprefix}participe");
	$db->where("tournois = $id");
	$db->exec();
	$equipes = $db->fetch();
	return $equipes->nb;
}

function nb_encours($id) {
	global $db,$dbprefix;

	$db->select("count(id) as nb");
	$db->from("${dbprefix}matchs");
	$db->where("status = 'D'");
	$db->where("tournois = $id");
	$db->exec();
	$matchs = $db->fetch();
	return $matchs->nb;
}


function nb_tours_termine($poule,$id) {
	global $db,$dbprefix;

	$db->select("count(distinct tour) as nb");
	$db->from("${dbprefix}matchs");
	$db->where("poule = $poule");
	$db->where("type = 'P'");
	$db->where("status = 'T'");
	$db->where("tournois = $id");
	$db->exec();
	$poules = $db->fetch();
	return $poules->nb;
}

function nb_tours($poule,$id) {
	global $db,$dbprefix;

	$db->select("count(distinct tour) as nb");
	$db->from("${dbprefix}matchs");
	$db->where("poule = $poule");
	$db->where("type = 'P'");
	$db->where("tournois = $id");
	$db->exec();
	$poules = $db->fetch();
	return $poules->nb;
}

function nb_tours_max($id) {
	global $db,$dbprefix;

	$db->select("count(distinct tour) as nb");
	$db->from("${dbprefix}matchs");
	$db->where("type = 'P'");
	$db->where("tournois = $id");
	$db->exec();
	$res = $db->fetch();
	return $res->nb;
}

function nb_equipes_poule($poule,$id) {
	global $db,$dbprefix;

	$db->select("count(distinct equipe) as nb");
	$db->from("${dbprefix}participe");
	$db->where("poule = $poule");
	$db->where("tournois = $id");
	$db->exec();
	$equipes = $db->fetch();
	return $equipes->nb;
}


function nb_tournois_joueur($id) {
	global $db,$dbprefix;
	
	if(!is_numeric($id)) return;

	$db->select("equipe,count(DISTINCT tournois) as nbtournois");
	$db->from("${dbprefix}participe,${dbprefix}tournois");
	$db->where("${dbprefix}participe.equipe = $id");
	$db->where("${dbprefix}participe.tournois = ${dbprefix}tournois.id");
	$db->where("${dbprefix}tournois.modeequipe = 'J'");
	$db->group_by("equipe");
	$db->exec();
	$joueur = $db->fetch();
	if(!$joueur->nbtournois) return 0;
	else return $joueur->nbtournois;
}

function nb_tournois_equipe($id) {
	global $db,$dbprefix;

	$db->select("equipe,count(DISTINCT tournois) as nbtournois");
	$db->from("${dbprefix}participe,${dbprefix}tournois");
	$db->where("${dbprefix}participe.equipe = $id");
	$db->where("${dbprefix}participe.tournois = ${dbprefix}tournois.id");
	$db->where("${dbprefix}tournois.modeequipe = 'E'");
	$db->group_by("equipe");
	$db->exec();
	$equipe = $db->fetch();
	if(!$equipe->nbtournois) return 0;
	else return $equipe->nbtournois;
}

function nb_joueurs_equipe($id,$etat='',$jeu='') {
	global $db,$dbprefix;
	
	if(!is_numeric($id)) return;
		
	$db->select("equipe,count(DISTINCT joueur) as nbjoueurs");
	$db->from("${dbprefix}joueurs,${dbprefix}appartient");
	if($etat) $db->where("etat = '$etat'");	
	if($jeu) $db->where("jeux = '$jeu'");	
	$db->where("equipe = $id");
	$db->where("${dbprefix}appartient.joueur = ${dbprefix}joueurs.id");
	$db->group_by("equipe");
	$db->exec();
	$equipe = $db->fetch();
	if(!$equipe->nbjoueurs) return 0;
	else return $equipe->nbjoueurs;
}

function nb_equipes_joueur($id) {
	global $db,$dbprefix;

	if(!is_numeric($id)) return;

	$db->select("joueur, count(distinct equipe) as nbequipes");
	$db->from("${dbprefix}appartient");
	$db->where("joueur = $id");
	$db->group_by("equipe");
	$res=$db->exec();

	$joueur = $db->fetch();
	if(!$joueur->nbequipes) return 0;
	else return $joueur->nbequipes;
}



function nb_joueurs_jeu($id) {
	global $db,$dbprefix;
	$db->select("jeux,count(DISTINCT joueur) as nbjoueurs");
	$db->from("${dbprefix}appartient");
	$db->where("jeux = $id");
	$db->group_by("jeux");
	$db->exec();
	$joueur = $db->fetch();
	if(!$joueur->nbjoueurs) return 0;
	else return $joueur->nbjoueurs;
}

function nb_tournois_jeu($id) {
	global $db,$dbprefix;
	$db->select("jeux,count(DISTINCT id) as nbtournois");
	$db->from("${dbprefix}tournois");
	$db->where("jeux = $id");
	$db->group_by("jeux");
	$db->exec();
	$tournois = $db->fetch();
	if(!$tournois->nbtournois) return 0;
	else return $tournois->nbtournois;
}


function nb_new_message($id) {
	global $db,$dbprefix;
	$db->select("count(distinct id) as nb");
	$db->from("${dbprefix}messages");
	$db->where("destinataire = $id");
	$db->where("lu = '0'");
	$db->exec();
	$nb_new_message = $db->fetch();
	if(!$nb_new_message->nb) return 0;
	else return $nb_new_message->nb;
}


function nb_sponsors() {
	global $db,$dbprefix;

	$db->select("count(id) as nb");
	$db->from("${dbprefix}sponsors");
	$db->exec();
	$sponsors = $db->fetch();
	return $sponsors->nb;
}

function nb_partenaires() {
	global $db,$dbprefix;

	$db->select("count(id) as nb");
	$db->from("${dbprefix}partenaires");
	$db->exec();
	$partenaires = $db->fetch();
	return $partenaires->nb;
}


function nb_liens() {
	global $db,$dbprefix;

	$db->select("count(id) as nb");
	$db->from("${dbprefix}liens");
	$db->exec();
	$liens = $db->fetch();
	return $liens->nb;
}


function nb_downloads() {
	global $db,$dbprefix;

	$db->select("count(id) as nb");
	$db->from("${dbprefix}download");
	$db->exec();
	$downloads = $db->fetch();
	return $downloads->nb;
}


function nb_news() {
	global $db,$dbprefix;
	$db->select("count(distinct id) as nb");
	$db->from("${dbprefix}news");
	$db->exec();
	$news = $db->fetch();
	return $news->nb;
}

function nb_news_commentaires($id) {
	global $db,$dbprefix;
	$db->select("news,count(DISTINCT id) as nbcommentaires");
	$db->from("${dbprefix}news_commentaires");
	$db->where("news = $id");
	$db->group_by("news");
	$db->exec();
	$commentaires = $db->fetch();
	if(!$commentaires->nbcommentaires) return 0;
	else return $commentaires->nbcommentaires;
}

function nb_matchs_commentaires($id) {
	global $db,$dbprefix;
	$db->select("matchi,count(DISTINCT id) as nbcommentaires");
	$db->from("${dbprefix}matchs_commentaires");
	$db->where("matchi = $id");
	$db->group_by("matchi");
	$db->exec();
	$commentaires = $db->fetch();
	if(!$commentaires->nbcommentaires) return 0;
	else return $commentaires->nbcommentaires;
}


function nb_livredor() {
	global $db,$dbprefix;
	$db->select("count(distinct id) as nb");
	$db->from("${dbprefix}livredor");
	$db->exec();
	$livredor = $db->fetch();
	return $livredor->nb;
}

function nb_player($id) {
	global $db,$dbprefix;
	$db->select("count(distinct joueur_id) as nb");
	$db->from("${dbprefix}lad_part");
	$db->where("ladder_id = $id");
	$db->exec();
	$nb_player = $db->fetch();
	return $nb_player->nb;
}



/*** fonctions securite ***/
function verif_admin_general($joueur) {
	global $PHP_SELF;

	if (empty($joueur) || !admin_general($joueur)) {
		js_goto($PHP_SELF);
	}
}

function verif_admin_modo($joueur) {
	global $PHP_SELF;

	if (empty($joueur) || (!admin_general($joueur)) && !modo($joueur)) {
		js_goto($PHP_SELF);
	}
}

function verif_admin_tournois($joueur,$tournois,$a=FALSE,$b=FALSE,$c=FALSE) {
	global $PHP_SELF;

	if (	empty($joueur)) 
	//|| 	empty($tournois))
	{	js_goto($PHP_SELF);	}
	
	if (	($a!='a' && $b!='b' && $t!='t') && admin_tournois($joueur,$tournois)==0 	)
	{	js_goto($PHP_SELF);	}
	
}

function verif_admin_news($joueur,$news) {
	global $PHP_SELF;

	if (empty($joueur) || empty($news) || ! (admin_general($joueur) || admin_news($joueur,$news))) {
		js_goto($PHP_SELF);
	}
}

function verif_manager($equipe,$joueur) {
	global $PHP_SELF,$grade;

	if (empty($joueur) || empty($equipe) || ! (equipe_manager($equipe,$joueur) || $garde['a']!='a' || $garde['b']!='b' || $garde['e']!='e' || $garde['j']!='j')) {
		js_goto($PHP_SELF);
	}
}


/*** fonctions Javascript ***/
function js_goto($url) {
	echo '<script>';
	echo "location.href='$url'";
	echo '</script>';	
	die();
}



function fermer_fenetre($url) {
	echo '<script>this.close();</script>';	
	die();
}

/** BBCODE G4 EDITING **/

// fonction du BBcode 'code'
function parse_code_php($texte)
{
global $strPHP;

if ($strPHP==''){$strPHP="&lt;? PHP ?&gt;";}

		
preg_match_all("`\[php\](.*?)\[/php\]`si", $texte, $matches);
	$nb_matches = count($matches[1]);
	for ($i = 0; $i < $nb_matches; $i++)
	{
		$xyz = array('#\[#', '#\]#');
		$replace_xyz = array('&fs1;', '&fs2;');
		
	
		$origine = $matches[1][$i];
		$remplacement = $matches[1][$i];
		$remplacement = preg_replace($xyz, $replace_xyz, $remplacement);
		$remplacement = str_replace("  ", "&nbsp; ", $remplacement);
		$remplacement = str_replace("  ", " &nbsp;", $remplacement);
		
		$remplacement = xhtml_highlight_string($remplacement,false,true,true);
		$origine = '[php]' . $origine . '[/php]';
		$remplacement = '[php]' . $remplacement . '[/php]';
		$texte = str_replace($origine, $remplacement, $texte);
	}
	//$texte = subparse($texte, '(\[code\])', '(\[/code\])', sprintf('<br><br /><table class="table" style="width: %s;" align="center" cellspacing="0" cellpadding="3"><tr><td class="code_titre">%s</td></tr><tr><td class="code">', '90%', '<b>'.$strCode.'</b>'), '</td></tr></table><br>');
	$texte=preg_replace("`\[php](.*?)\[/php\]`si", sprintf('<br><br /><table class="table" style="width: %s;" align="center" cellspacing="0" cellpadding="3"><tr><td class="php_titre">%s</td></tr><tr><td class="php">%s</td></tr></table><br>', '90%', $strPHP, '\\1'), $texte);

	return($texte);
}

function parse_code_php_line($texte)
{
global $strPHP;

if ($strPHP==''){$strPHP="&lt;? PHP ?&gt;";}

preg_match_all("`\[php=line\](.*?)\[/php\]`si", $texte, $matches);
	$nb_matches = count($matches[1]);
	for ($i = 0; $i < $nb_matches; $i++)
	{
		$xyz = array('#\[#', '#\]#');
		$replace_xyz = array('&fs1;', '&fs2;');
		
	
		$origine = $matches[1][$i];
		$remplacement = $matches[1][$i];
		$remplacement = preg_replace($xyz, $replace_xyz, $remplacement);
		$remplacement = str_replace("  ", "&nbsp; ", $remplacement);
		$remplacement = str_replace("  ", " &nbsp;", $remplacement);
		
		$remplacement = xhtml_highlight_string($remplacement,false,true,true);
		$origine = '[php=line]' . $origine . '[/php]';
		$remplacement = '[php=line]' . $remplacement . '[/php]';
		$texte = str_replace($origine, $remplacement, $texte);
	}
	$texte=preg_replace("`\[php=line\](.*?)\[/php\]`si", sprintf('<br><br /><table class="table" style="width: %s;" align="center" cellspacing="0" cellpadding="3"><tr><td class="php_titre">%s</td></tr><tr><td class="php">%s</td></tr></table><br>', '90%', $strPHP, '\\1'), $texte);
return($texte);
}
/*
function parse_html($texte)
{

preg_match_all("`\[html\](.*?)\[/html\]`si", $texte, $matches);
	$nb_matches = count($matches[1]);
	for ($i = 0; $i < $nb_matches; $i++)
	{
		$xyz = array('#\[#', '#\]#');
		$replace_xyz = array('&fs1;', '&fs2;');
		
	
		$origine = $matches[1][$i];
		$remplacement = $matches[1][$i];
		$remplacement = preg_replace($xyz, $replace_xyz, $remplacement);
		$remplacement = str_replace("  ", "&nbsp; ", $remplacement);
		$remplacement = str_replace("  ", " &nbsp;", $remplacement);
		
		$remplacement = xhtml_highlight_string($remplacement,false,true,false);
		$origine = '[html]' . $origine . '[/html]';
		$remplacement = '[html]' . $remplacement . '[/html]';
		$texte = str_replace($origine, $remplacement, $texte);
	}
	//$texte = subparse($texte, '(\[code\])', '(\[/code\])', sprintf('<br><br /><table class="table" style="width: %s;" align="center" cellspacing="0" cellpadding="3"><tr><td class="code_titre">%s</td></tr><tr><td class="code">', '90%', '<b>'.$strCode.'</b>'), '</td></tr></table><br>');
	$texte=preg_replace("`\[html\](.*?)\[/html\]`si", sprintf('<br><br /><table class="table" style="width: %s;" align="center" cellspacing="0" cellpadding="3"><tr><td class="html_titre">%s</td></tr><tr><td class="html">%s</td></tr></table><br>', '90%', 'HTML', '\\1'), $texte);

	return($texte);
}

function parse_html_line($texte)
{

preg_match_all("`\[html=line\](.*?)\[/html\]`si", $texte, $matches);
	$nb_matches = count($matches[1]);
	for ($i = 0; $i < $nb_matches; $i++)
	{
		$xyz = array('#\[#', '#\]#');
		$replace_xyz = array('&fs1;', '&fs2;');
		
	
		$origine = $matches[1][$i];
		$remplacement = $matches[1][$i];
		$remplacement = preg_replace($xyz, $replace_xyz, $remplacement);
		$remplacement = str_replace("  ", "&nbsp; ", $remplacement);
		$remplacement = str_replace("  ", " &nbsp;", $remplacement);
		
		$remplacement = xhtml_highlight_string($remplacement,false,true,false);
		$origine = '[html=line]' . $origine . '[/html]';
		$remplacement = '[html=line]' . $remplacement . '[/html]';
		$texte = str_replace($origine, $remplacement, $texte);
	}
	$texte=preg_replace("`\[html=line\](.*?)\[/html\]`si", sprintf('<br><br /><table class="table" style="width: %s;" align="center" cellspacing="0" cellpadding="3"><tr><td class="html_titre">%s</td></tr><tr><td class="html"><code>%s</code></td></tr></table><br>', '90%', 'HTML', '\\1'), $texte);
return($texte);
}
*/
function parse_code($texte)
{
global $strCode;
preg_match_all("`\[code\](.*?)\[/code\]`si", $texte, $matches);
	$nb_matches = count($matches[1]);
	for ($i = 0; $i < $nb_matches; $i++)
	{
		$xyz = array('#\[#', '#\]#');
		$replace_xyz = array('&fs1;', '&fs2;');
		
	
		$origine = $matches[1][$i];
		$remplacement = $matches[1][$i];
		$remplacement = preg_replace($xyz, $replace_xyz, $remplacement);
		$remplacement = str_replace("  ", "&nbsp; ", $remplacement);
		$remplacement = str_replace("  ", " &nbsp;", $remplacement);
		
		$origine = '[code]' . $origine . '[/code]';
		$remplacement = '[code]' . $remplacement . '[/code]';
		$texte = str_replace($origine, $remplacement, $texte);
	}
	//$texte = subparse($texte, '(\[code\])', '(\[/code\])', sprintf('<br><br /><table class="table" style="width: %s;" align="center" cellspacing="0" cellpadding="3"><tr><td class="code_titre">%s</td></tr><tr><td class="code">', '90%', '<b>'.$strCode.'</b>'), '</td></tr></table><br>');
	$texte=preg_replace("`\[code\](.*?)\[/code\]`si", sprintf('<br><br /><table class="table" style="width: %s;" align="center" cellspacing="0" cellpadding="3"><tr><td class="code_titre">%s</td></tr><tr><td class="code">%s</td></tr></table><br>', '90%', $strCode, '\\1'), $texte);

	return($texte);
}



function parse_code_line($texte)
{
global $strCode;
preg_match_all("`\[code=line\](.*?)\[/code\]`si", $texte, $matches);
	$nb_matches = count($matches[1]);
	for ($i = 0; $i < $nb_matches; $i++)
	{
		$xyz = array('#\[#', '#\]#');
		$replace_xyz = array('&fs1;', '&fs2;');
		
	
		$origine = $matches[1][$i];
		$remplacement = $matches[1][$i];
		$remplacement = preg_replace($xyz, $replace_xyz, $remplacement);
		$remplacement = str_replace("  ", "&nbsp; ", $remplacement);
		$remplacement = str_replace("  ", " &nbsp;", $remplacement);
		
		$remplacement = xhtml_highlight_string($remplacement,false,true,false);
		$origine = '[code=line]' . $origine . '[/code]';
		$remplacement = '[code=line]' . $remplacement . '[/code]';
		$texte = str_replace($origine, $remplacement, $texte);
	}
	$texte=preg_replace("`\[code=line\](.*?)\[/code\]`si", sprintf('<br><br /><table class="table" style="width: %s;" align="center" cellspacing="0" cellpadding="3"><tr><td class="code_titre">%s</td></tr><tr><td class="code"><code>%s</code></td></tr></table><br>', '90%', $strCode, '\\1'), $texte);
return($texte);
}

function parse_code_sql_line($texte)
{

preg_match_all("`\[sql=line\](.*?)\[/sql\]`si", $texte, $matches);
	$nb_matches = count($matches[1]);
	for ($i = 0; $i < $nb_matches; $i++)
	{
		$xyz = array('#\[#', '#\]#');
		$replace_xyz = array('&fs1;', '&fs2;');
		
	
		$origine = $matches[1][$i];
		$remplacement = $matches[1][$i];
		$remplacement = preg_replace($xyz, $replace_xyz, $remplacement);
		$remplacement = str_replace("  ", "&nbsp; ", $remplacement);
		$remplacement = str_replace("  ", " &nbsp;", $remplacement);
		
		
		$remplacement = sql_highlight_string($remplacement,false,true);
		
		$origine = '[sql=line]' . $origine . '[/sql]';
		$remplacement = '[sql=line]' . $remplacement . '[/sql]';
		$texte = str_replace($origine, $remplacement, $texte);
	}
		while( preg_match( "`\[sql=line\](.*?)\[/sql\]`si", $texte ) )
			{
		$texte=preg_replace("`\[sql=line\](.*?)\[/sql\]`si", sprintf('<br><br /><table class="table" style="width: %s;" align="center" cellspacing="0" cellpadding="3"><tr><td class="sql_titre">%s</td></tr><tr><td class="sql"><code>%s</code></td></tr></table><br>', '90%', 'SQL', '\\1'), $texte);
			}
	return($texte);
}	 

function parse_code_sql($texte)
{

preg_match_all("`\[sql\](.*?)\[/sql\]`si", $texte, $matches);
	$nb_matches = count($matches[1]);
	for ($i = 0; $i < $nb_matches; $i++)
	{
		$xyz = array('#\[#', '#\]#');
		$replace_xyz = array('&fs1;', '&fs2;');
		
	
		$origine = $matches[1][$i];
		$remplacement = $matches[1][$i];
		$remplacement = preg_replace($xyz, $replace_xyz, $remplacement);
		$remplacement = str_replace("  ", "&nbsp; ", $remplacement);
		$remplacement = str_replace("  ", " &nbsp;", $remplacement);
		$remplacement = preg_replace("!‘!i", "&lsquo;", $remplacement);
		$remplacement = preg_replace("!'!i", "&#39;", $remplacement);
		
		$remplacement = preg_replace( "#^<br />#", "", $remplacement );
		$remplacement = preg_replace( "/^\s+/"   , "", $remplacement );
		$remplacement = preg_replace( "#(=|\+|\-|&gt;|&lt;|~|==|\!=|LIKE|NOT LIKE|REGEXP|\*)#is"            , "<span style='color:orange'>\\1</span>", $remplacement );
		$remplacement = preg_replace( "#(\.)#is"            , "<span style='color:red'>\\1</span>", $remplacement );
		$remplacement = preg_replace( "#(&lsquo;.*?&lsquo;)#si"            , "<span style='color:blue'>\\1</span>", $remplacement );
		$remplacement = preg_replace( "#(MAX|AVG|SUM|COUNT|MIN)\(#is"                                    , "<span style='color:blue'>\\1</span>("    , $remplacement );
	    $remplacement = preg_replace( "!(&quot;|&#39;|&#039;)(.+?)(&quot;|&#39;|&#039;)!is"              , "<span style='color:red'>\\1\\2\\3</span>" , $remplacement );
	    $remplacement = preg_replace( "#\s{1,}(AND|OR|ON|AS)\s{1,}#is"                                         , " <span style='color:blue'>\\1</span> "    , $remplacement );
	    $remplacement = preg_replace( "#(LEFT|JOIN|WHERE|MODIFY|CHANGE|AS|DISTINCT|IN|ASC|DESC|ORDER BY|GROUP BY)\s{1,}#i" , "<span style='color:green'>\\1</span> "   , $remplacement );
	    $remplacement = preg_replace( "#LIMIT\s*(\d+)\s*,\s*(\d+)#is"                                    , "<span style='color:green'>LIMIT</span> <span style='color:orange'>\\1, \\2</span>" , $remplacement );
	    $remplacement = preg_replace( "#(FROM|INTO)\s{1,}(\S+?)\s{1,}#is"                                , "<span style='color:green'>\\1</span> <span style='color:orange'>\\2</span> ", $remplacement );
	    $remplacement = preg_replace( "#(SELECT|INSERT|UPDATE|DELETE|ALTER TABLE|DROP)#is"               , "<span style='color:blue;font-weight:bold'>\\1</span>" , $remplacement );
		$remplacement = preg_replace( "/^<br>/"  , "", $remplacement );
		
		$origine = '[sql]' . $origine . '[/sql]';
		$remplacement = '[sql]' . $remplacement . '[/sql]';
		$texte = str_replace($origine, $remplacement, $texte);
	}
	while( preg_match( "`\[sql\](.*?)\[/sql\]`si", $texte ) )
			{
		$texte=preg_replace("`\[sql\](.*?)\[/sql\]`si", sprintf('<br><br /><table class="table" style="width: %s;" align="center" cellspacing="0" cellpadding="3"><tr><td class="sql_titre">%s</td></tr><tr><td class="sql"><code>%s</code></td></tr></table><br>', '90%', 'SQL', '\\1'), $texte);
			}
	return($texte);
}	   


function parse_area($texte)
{



preg_match_all("`\[area\](.*?)\[/area\]`si", $texte, $matches);
	$nb_matches = count($matches[1]);
	for ($i = 0; $i < $nb_matches; $i++)
	{
		$xyz = array('#\[#', '#\]#');
		$replace_xyz = array('&fs1;', '&fs2;');
	
		$origine = $matches[1][$i];
		$remplacement = $matches[1][$i];
		//$remplacement = preg_replace($xyz, $replace_xyz, $remplacement);
		
		$remplacement = preg_replace("!<br />!is", "", $remplacement);
	
		$origine = '[area]' . $origine . '[/area]';
		$remplacement = '[area]' . $remplacement . '[/area]';
		$texte = str_replace($origine, $remplacement, $texte);
	}
	while( preg_match( "`\[area\](.*?)\[/area\]`si", $texte ) )
			{
		//$texte=preg_replace("`\[area\](.*?)\[/area\]`si", sprintf('<br><br /><center><textarea cols="%s" rows="%s">&lt;area'.$area_n.'&gt;%s&lt;/area'.$area_n.'&gt;</textarea></center><br>', '60%', '6', '\\1'), $texte);
		$texte = subparse($texte, '(\[area\])', '(\[/area\])', '<br><br /><center><textarea cols=\"60%\" rows=\"6\">&lt;area&gt;', '&lt;/area&gt;</textarea></center><br>', 'font');
			}
	return($texte);
}	   

function parse_area_end($texte_end,$texte_save)
{		
					
	preg_match_all('`&lt;area&gt;(.*?)&lt;/area&gt;`si', $texte_save, $matches_save);
	preg_match_all('`&lt;area&gt;.*?&lt;/area&gt;`si', $texte_end, $matches_end);
	$minimum = count($matches_save[0]);
		
	for ( $i = 0; $i < $minimum; $i++ )
	{
			$texte = preg_replace('`' . preg_quote($matches_end[0][$i]) .'`si', '&lt;area&gt;'.$i.'&lt;/area&gt;', $texte_end);
			
	}
	
	
	
	
//$texte_i = preg_replace("`(&lt;area2&gt;(.*?)&lt;/area2&gt;)`i", preg_replace("`.*?&lt;area2&gt;(.*?)&lt;/area2&gt;.*?`si", '\\1', $texte_save), $texte_end);
		//$texte=preg_replace("`.*?&lt;area2&gt;(.*?)&lt;/area2&gt;.*?`si", '\\1', $texte_save);
		// repartition = ok, code = pas ok   ([0-9]{10})
	/*$area_n='0';
	while( preg_match( "`&lt;area([0-9]{10})&gt;.*?&lt;/area([0-9]{10})&gt;`si", $texte ) )
			{
			$area_n++;
			$texte = preg_replace("`(&lt;area&gt;(.*?)&lt;/area&gt;)`i", preg_replace("`.*?&lt;area&gt;(.*?)&lt;/area&gt;.*?`si", '\\1', $texte_save), $texte_end);
			}
		*/// repartition = pas ok (tout dans le mm), code = ok
		//$texte = preg_replace("`(&lt;area&gt;(.*?)&lt;/area&gt;)`si", preg_replace("`.*?&lt;area&gt;(.*?)&lt;/area&gt;.*?`si", '\\1', $texte_save), $texte_end);
		/**/
		//  foutre area1 2 3 4... et for / reaplaece ...
	return($texte);
}	   


// fonction qui SUB le BBcode
function subing($texte)
{
	global $strQuote;
	$texte = subparse($texte, '(\[color=(#[0-9A-Fa-f]{6}|[a-zA-Z].*?)\])', '(\[/color\])', '<span style="color:%s;">', '</span>', 'couleur');
	$texte = subparse($texte, '(\[size=([[:digit:]-]{1,2})\])', '(\[/size\])', '<span style="font-size:%spx">', '</span>', 'taille');
	$texte = subparse($texte, '(\[font=(.*?)\])', '(\[/font\])', '<font face="%s">', '</font>', 'font');
	$texte = subparse($texte, '(\[quote\])', '(\[/quote\])', sprintf('<br><table class="tableau" style="width: %s;" align="center" cellspacing="0" cellpadding="3"><tr><td class="quote_titre">%s</td></tr><tr><td class="quote">', '90%', '<b>'.$strQuote.'</b>'), '</td></tr></table><br>');
	$texte = subparse($texte, '(\[quote=(.*?)\])', '(\[/quote\])', '', '</td></tr></table><br>', 'quot');
	$texte = subparse($texte, '\[glow=(#[0-9A-Fa-f]{6}|[a-zA-Z].*?),([[:digit:]-]{1,2})\]', '\[/glow\]', sprintf('<span style="width:1px;filter:glow(color="#FF000",strength="2");">\'%s\' dd %s', '\\1', '\\2'), '</span>');
	$texte = subparse($texte, '(\[glow=(#[0-9A-Fa-f]{6}|[a-zA-Z].*?)\])', '(\[/glow\])', sprintf('<span style="width:1px;filter:glow(color=\"%s\",strength=2);">', '\\1'), '</span>');
	$texte = subparse($texte, '(\[align=([^\[]*)\])', '(\[/align\])', '<p align=%s>', '</p>', 'align');
	$texte = subparse($texte, '(\[b\])', '(\[/b\])', '<b>', '</b>', 'font');
	$texte = subparse($texte, '(\[i\])', '(\[/i\])', '<i>', '</i>', 'font');
	$texte = subparse($texte, '(\[u\])', '(\[/u\])', '<u>', '</u>', 'font');
	$texte = subparse($texte, '(\[li\])', '(\[/li\])', '<li>', '</li>', 'font');
	$texte = subparse($texte, '(\[table=(.*?)\])', '(\[/table\])', '<table %s>', '</table>', 'table');
	$texte = subparse($texte, '(\[td=(.*?)\])', '(\[/td\])', '<td %s>', '</td>', 'tr');
	$texte = subparse($texte, '(\[tr=(.*?)\])', '(\[/tr\])', '<tr %s>', '</tr>', 'td');
	
return($texte);
}
	// BBCode parser v0.1
	// LAlex 2003
	// lalex@lalex.com - http://www.lalex.com/
	//adater sur phpTrounois par G4.
	// Le terme BBCode est la propri&eacute;t&eacute; de phpBB : http://www.phpBB.com/
	//
	// Ce code est prot&eacute;g&eacute; par les lois sur la propri&eacute;t&eacute; intellectuelle et
	// ne peut être vendu ni utilis&eacute; a des fins commerciales.
	// Il doit être redistribu&eacute; gratuitement, et toute modification lors de
	// sa diffusion doit être signal&eacute;e dans l'entête du code.
	

	
	
	// Appel&eacute; à l'ouverture d'un tag XML
	function startTag($parser, $name, $att) {
		// On r&eacute;cupères les tableaux
		global $bbTags;
		global $htmlTags;
		global $xmlstack;
		global $xmlcurtag;
		// On ajoute le tag ouvert dans la pile de tags XML
		array_push($xmlstack,$name);
		// Si c'est un debut de d&eacute;claration de tag BBCode
		if ($name == "TAG") {
			// S'il a un nom
			if($curtag = $att["NAME"]) {
				// On rajoute le tag aux tags BBCode
				array_push($bbTags,$curtag);
				// Pour diff&eacute;rencier les comportements avec parametre et
				// sans paramètre, on rajoute un identifiant -param
				if ($att["PARAM"] == "yes") {
					$curtag .= "-param";
				}
				// Le tag courant est initialis&eacute;
				$xmlcurtag = $curtag;
				// On cr&eacute;e une entr&eacute;e dans les paramètres HTML du tag
				//  - close : Dit si le tag doit être ferm&eacute;
				//  - parent : Dit si le tag doit obligatoirement être imbriqu&eacute;
				//             dans un autre
				//  - keep : Sit si on conserve le texte contenu entre le tag d'ouverture
				//           et le tag de fermeture
				//  - param : Dit si le tag d'ouverture doit avoir un parametre =param
				//  - function : Specifie le nom d'une fonction a appeler pour modifer
				//               le contenu du tag.
				$htmlTags[$curtag] = Array("close"=>$att["CLOSE"],
								       "parent"=>$att["PARENT"],
									   "keep"=>$att["KEEPVALUE"],
									   "render"=>$att["RENDER"],
									   "param"=>$att["PARAM"],
									   "function"=>$att["FUNCTION"]);
			}
		}
	}
	
	// Appel&eacute; à la fermeture d'un tag XML
	function endTag($parser, $name) {
		global $xmlstack;
		global $xmlcurtag;
		// Le tag courant est vid&eacute;
		if (array_pop($xmlstack) == "TAG") {
			$xmlcurtag = "";
		}
	}
	
	// Appel&eacute; au parsage du contenu d'un tag XML
	function cdataTag($parser, $data) {
//		echo htmlspecialchars($getdata) . " * " . htmlspecialchars($data) . "<br>";
		// Recupere la pile de tags XML ouverts
		global $xmlstack;
		global $xmlcurtag;
		// R&eacute;cupère les donn&eacute;es HTML
		global $htmlTags;
		// Si c'est le remplacement du tag d'ouverture
		// on renseigne la propri&eacute;t&eacute; "begin" des donn&eacute;es HTML
		// du tag en cours
		if (($curtag = array_pop($xmlstack)) == "BEGIN") {
			$htmlTags[$xmlcurtag]["begin"] = $data;
		} elseif ($curtag == "FINISH") {
		// Si c'est le remplacement du tag de fermeture
		// on renseigne la propri&eacute;t&eacute; "finish"
			$htmlTags[$xmlcurtag]["finish"] = $data;
		}
	}
	
	// Fonction pouvant servir à retourner une chaine identique
	function identity($str) {
		return $str;
	}
	
	// R&eacute;cupère les donn&eacute;es BBCode a partir d'un fichier XML dont
	// le chemin est donn&eacute; en paramètre
	function getBBTags($fil) {
	
		// Cr&eacute;e le parser XML
		$xmlparser = xml_parser_create("UTF-8");
		// Attribue les 'handler' qui vont parser le fichier XML
		xml_set_element_handler($xmlparser, "startTag", "endTag");
		xml_set_character_data_handler($xmlparser, "cdataTag");
		// Ouvre le fichier XML
		if (!($fp = fopen($fil, "r"))) {
			die("Impossible d'ouvrir le fichier XML");
		}
		// Parse le fichier XML
		while ($data = fread($fp, 4096)) {
			if (!xml_parse($xmlparser, $data, feof($fp))) {
				die(sprintf("erreur XML : %s &agrave; la ligne %d",
					xml_error_string(xml_get_error_code($xmlparser)),
					xml_get_current_line_number($xmlparser)));
			}
		}
		// Efface le parser et ferme le fichier
		xml_parser_free($xmlparser);
		fclose($fp);
	}

	// Fonction qui va attribuer un identifiant unique
	// a chaque tag qui en a besoin
	function parseBBTags (&$str) {
		global $bbTags;
		global $htmlTags;
		// Mes variables
		// $progress contient la chaine reconsitut&eacute;e.
		$progress = Array();
		// Result contient le resultat de la recherche par regexp PERL
		$result = Array();
		// Stack est un pile contenant les tags ouverts
		$stack = Array();
		// On g&eacute;nère la chaine de caractère a rechercher
		// On concatène les valeurs du tableau bbTags
		// avec un operateur "ou" : |
		$srch = "";
		for($i=0 ; $i<count($bbTags) ; $i++) {
			$srch .= preg_quote($bbTags[$i]) . "|";
		}
		// On enlève le dernier |
		$srch = substr($srch,0,-1);
		// je rajoute les crochets à ma recherche, et le texte qui suit jusqu'au prochain tag
		$srchall = "\[(/)?(" . $srch . ")(=(?:.*?))?\](.*?)(?=(?:\[(/)?(" . $srch . ")(=(?:.*?))?\])|$)";
		// Je r&eacute;cupère ma chaine en "morceaux" de la regexp
		preg_match_all("#" . $srchall . "#is",$str,$result);
		// Je r&eacute;cupère le texte du d&eacute;but de la chaine jusqu'au premier tag
		// et j'initialise la chaine qui va être retourn&eacute;e : $ret
		$begin = Array();
		if (preg_match("#^(.*?)(?=(?:\[(/)?(" . $srch . ")(=(?:.*?))?\])|$)#is",$str,$begin)) {
			$ret = $begin[1];
		} else {
			$ret = "";
		}
		// Je boucle sur mes resultats
		// Chaque indice de $result contient une partie du r&eacute;sultat
		//  0 : colonne contenant les exepressions trouv&eacute;es
		//  1 : Barre de fermeture (si elle existe)
		//  2 : Nom du tag (b, u, etc...)
		//  3 : Paramètre du tag (avec un '=' au debut)
		//  4 : Texte qui suit le tag (jusqu'au prochain)
		$norender = 0;
		for ($i=0 ; $i<count($result[1]) ; $i++) {
			// Je cr&eacute;e mon tableau associatif avec les donn&eacute;es du tag courant
			$curTag = Array("tag"=>$result[2][$i],
							"close"=>($result[1][$i] == "/"),
							"param"=>$result[3][$i],
							"after"=>$result[4][$i]);
			// Si c'est une fermeture de tag
			if ($curTag["close"]) {
				// Je recherche les tags ouverts dans ma pile en 
				// partant du dernier tag ouvert puis en remontant la pile
				for ($k=count($stack)-1 ; $k>=0 ; $k--) {
					$lastTag = $stack[$k];
					// Si le tag ouvert est le même que celui que je ferme,
					// J'attribue a mon tag de fermeture le meme id
					// que le tag ouvrant et j'arrete la boucle
					if ($lastTag["tag"] == $curTag["tag"]) {
						// Si le tag est ouvert, je regarde s'il peut être ferm&eacute;
						// Si c'est le cas, je donne l'identifiant du tag d'ouverture
						// au tag de fermeture
						if ($lastTag["canclose"]) {
							$curTag["uid"] = $lastTag["uid"];
						}
						// Je supprime le tag d'ouverture de la pile
						array_splice($stack,$k,1);
						// Si c'&eacute;tait un tag qui epêmchait le parsage des BBCode
						// de son contenu, je diminue le nombre de tag de "non-rendu".
						if ($htmlTags[$curTag["tag"]]["render"] == "no") {
							$norender--;
						}
						// Si le tag est trouv&eacute;, inutile de continuer la boucle
						break;
					
					// Sinon, c'est un chevauchement de tag, le tag courant
					// ne pourra pas être ferm&eacute;.
					} else {
						$stack[$k]["canclose"] = false;
					}
				}
			
			// Si c'est un tag d'ouverture
			} else {
				// S'il a besoin d'être ferme, je lui cr&eacute;e un identifiant unique
				// de longueur 10 (ca devrait suffire)
				if ($htmlTags[$curTag["tag"]]["close"] != "no") {
					// Je g&eacute;nère un ID al&eacute;atoire et je l'attribue
					// au tag d'ouverture
					$uid = md5(mt_rand());
					$uid = substr($uid, 0, 10);
					$curTag["uid"] = $uid;
					// Si on est dans un tag de "non-rendu", le tag
					// ne peut être ferm&eacute; (il ne sera donc pas interpr&eacute;t&eacute;)
					$curTag["canclose"] = ($norender == 0);
					// Je rajoute le tag dans ma pile
					array_push($stack,$curTag);
					// Si c'est un tag de "non-rendu" que l'on ouvre
					// j'augmente le nombre de tag de "non-rendu" ouverts
					if ($htmlTags[$curTag["tag"]]["render"] == "no") {
						$norender++;
					}
				}
			}
			// Quoi qu'il arrive, je rajoute mon tag a la progression
			array_push($progress,$curTag);
		}
		// Je reconstruit ma chaîne à partir de ma progression
		for ($i=0 ; $i<count($progress) ; $i++) {
			$ret .= "[";
			$ret .= $progress[$i]["close"] ? "/" : "";
			$ret .= $progress[$i]["tag"];
			$ret .= $progress[$i]["param"];
			$ret .= isset($progress[$i]["uid"]) ? ":" . $progress[$i]["uid"] : "";
			$ret .= "]";
			$ret .= $progress[$i]["after"];
		}
		
		// Je retourne la chaine ainsi obtenue
		return $ret;
	}
	
	// Fonction qui transforme les BBCode en HTML
	function renderBBCode (&$str) {
		// Je rend les tableaux de paramètres disponibles
		// à ma fonction
		global $bbTags;
		global $htmlTags;
		
		getBBTags("include/bbcode.xml");

		// Je parse les BBCode pour leur attribuer un id unique
		$tmp = parseBBTags($str);
		// Pour chaque tag BBCode de mes aramètres HTML
		reset($htmlTags);
		while (list ($key, $val) = each ($htmlTags)) {
			// Je r&eacute;cupère le nom et les propri&eacute;t&eacute;s de mon tag
			$curtagname = $key;
			$curtagprops = $val;
			// Si c'est un tag avec paramètres, je dois enlever
			// le '-param' qui est à la fin.
			if ($curtagprops["param"] == "yes") {
				$curtagname = substr($curtagname,0,-6);
			}
			// Il s'agit maintenant de g&eacute;n&eacute;rer l'expression r&eacute;gulière ... :D
			//  - before : regexp pour un contenu &eacute;ventuel AVANT le tag
			//  - tagsrch : regexp pour le tag lui-même
			//  - contsrch : regexp pour le contenu du tag
			//  - endsrch : regexp pour le tag de fermeture
			//  - after : regexp pour un contenu eventuel APRES le tag de fermeture
			$before = "";
			$tagsrch = "\[" . preg_quote($curtagname);
			$contsrch = "(.*?)";
			$endsrch = "";
			$after = "";
			
			// Idinces des regexp
			//  - idind : Indice dans la regexp de l'ID du tag (utile pour les r&eacute;f&eacute;rences arrières)
			//  - contind : Indice du contenu du tag
			//  - paramind : Indice du paramètre du tag (s'il en faut un)
			$idind = 0;
			$contind = 1;
			$paramind = 0;
			
			// Chaine de remplacement
			//  - beforerepl : Debut de la chaine de remplacement
			//  - repl : Remplacement
			//  - afterrepl : Fin de la chaine de remplacement
			$beforerepl = "";
			$repl = "";
			$afterrepl = "";
			
			// Il s'agit de donner les bonnes valeurs aux indices et regexp maintenant
			// SI le tag prend un paramètre
			if ($curtagprops["param"] == "yes") {
				// On rajoute le paramètre à la regexp du tag d'ouverture
				$tagsrch .= "(?:=(.*?))";
				// Le parametre a un indice
				$paramind++;
				// Du coup, l'ID et le contenu sont un cran plus loin
				$idind++;
				$contind++;
			}
			// Si le tag doit être ferm&eacute;, il a un ID
			if($curtagprops["close"] != "no") {
				// On rajoute l'ID à la regexp du tag d'ouverture
				$tagsrch .= "(:[0-9a-z]{10})";
				// Du coup, l'ID a un indice
				$idind++;
				// Et le contenu est encore d&eacute;cal&eacute; d'un cran
				$contind++;
				// Le tag de fermeture doit être recherch&eacute; avec le meme ID
				// que celui d'ouverture
				$endsrch = "\[/" . preg_quote($curtagname) . "\\" . $idind . "\]";
			} else {
				// Si le tag n'a pas de fermeture, on ne peut pas trouver de "contenu"
				$contsrch = "";
			}
			// On rajoute le crochet de fin du tag d'ouverture
			$tagsrch .= "\]";
			// Si le tag doit avoir un parent, on s'assure qu'il est dans ce parent
			if ($partag = $curtagprops["parent"]) {
				// On cherche le tag parent d'ouverture AVANT le tag
				$before = "(\[" . preg_quote($partag) . "(?:=.*?)?(:[0-9a-z]{10})\].*?)";
				// Et on cherche la tag prent de fermeture APRES le tag
				$after = "(.*?\[/" . preg_quote($partag) . "\\2\])";
				// Du coup, le contenu est d&eacute;cal&eacute; de 2 cran : tag parent d'ouverture
				// + ID du tag parent d'ouverture
				$contind += 2;
				// Pareil pour l'ID
				$paramind += 2;
				$idind +=2;
				// On remet les tags parent avant et apr&eacute;s dans la chaine de remplacement
				$beforerepl = "$1";
				$afterrepl = "$" . ($contind+1);
			}
			// Maintenant que tous les indices de position sont bons, on peut chercher
			// le tag de fermeture (si besoin est)
			if($curtagprops["close"] != "no") {
				// Le tag de fermeture doit être recherch&eacute; avec le meme ID
				// que celui d'ouverture
				$endsrch = "\[/" . preg_quote($curtagname) . "\\" . $idind . "\]";
			}
			// On remplace les valeurs {PARAM} et {VALUE} qui peuvent apparaître
			// dans le HTML de remplacement. {PARAM} ets remplac&eacute; par le paramètre
			// du tag BBCode, et {VALUE} par son contenu
			// On en profite pour commencer la chaine de remplacement par le HTML de debut
			$repl = "'" . $curtagprops["begin"] . "'";
			$repl = str_replace("{VALUE}", "$" . $contind,$repl);
			if ($paramind > 0) {
				$repl = str_replace("{PARAM}","$" . $paramind,$repl);
			} else {
				$repl = str_replace("{PARAM}","",$repl);
			}
			
			// Si on veut garder le contenu entre le HTML de d&eacute;but et le HTML de fin
			if ($curtagprops["keep"] != "no") {
				// Si le contenu doit être pars&eacute; par une fonction, on y fait appel
				if ($curtagprops["function"]) {
					$repl .= " . " . $curtagprops["function"] . "(\"$" . $contind . "\")";
				
				// Sinon, on affiche tout simplement le contenu (grace a son indice
				// trouv&eacute; plus haut)
				} else {
					$repl .= " . '$" . $contind . "'";
				}
			}
			// On finit la chaine de remplacement par le HTML de fin
			$repl .= " . '" . $curtagprops["finish"] . "'";

			// On assemble la chaine de remplacement
			$repl = "'" . $beforerepl . "' . " . $repl . " . '" . $afterrepl . "'";

			// On assemble la regexp
			$srch = $before . $tagsrch . $contsrch . $endsrch . $after;
			
			// Affichage de debug, affiche la regexp et le pattern de remplacement
			// si la regexp n'est pas trouv&eacute;e
			//			if (!preg_match("#" . $srch . "#isS", $tmp)) {
			//				echo $srch . " => " . htmlspecialchars($repl) . "<br />\n";
			//			}
			// A cause de l'imbrication &eacute;ventuelle des tags, on effectue
			// le remplacement jusqu'à ce qu'il n'y ai plus de tag à remplacer.
			while (preg_match("#" . $srch . "#isS",$tmp)) {
				// Le stripslashes &eacute;limine les quelques antislah qui ont pu se glisser
				// à cause du preg_quote.
				$tmp = stripslashes(preg_replace("#" . $srch . "#isSe" . $options,$repl,$tmp));
			}
			
		}
		
		/*** smilies phpT ***/
		$tab_smilies = file("images/smilies/smilies");
	
		for($i=0;$i<count($tab_smilies);$i++) {
			$tab_smiley=split(',',$tab_smilies[$i]);
			$smiley_code=$tab_smiley[0];
			$smiley_img=trim($tab_smiley[1]);
							
			$tmp = str_replace("$smiley_code", "<IMG border='0' SRC=\"images/smilies/$smiley_img\" />", $tmp);
			}
		
		// Si jamais il reste des tags avec id qui n'ont pas &eacute;t&eacute; remplac&eacute;s
		// on enlève l'id. Le pricipe de recherche est le même que pour parseBBTags
		$srch = "";
		for($i=0 ; $i<count($bbTags) ; $i++) {
			$srch .= preg_quote($bbTags[$i]) . "|";
		}
		$srch = substr($srch,0,-1);
		$srch = "(\[(?:/)?(?:" . $srch . ")(?:=(?:.*?))?)(?::[0-9a-z]{10})(\])";
		$tmp = preg_replace("#" . $srch . "#i","$1$2",$tmp);
		// Je retourne la chaine obtenue
		return $tmp;
	}
	
	// Cette fonction remplace les URLs et emails par des liens
	// puis parse les BBCode et enfin remplace les retour chariot
	// par des <br />
	function render (&$str) {
		return nl2br(renderBBCode($str));
	}
function ireg_url($texte) {
/*** EREG sur les 'url' ***/
	if (preg_match('#\[url=(http://)?(.*?)\](.*?)\[/url\]#i', $texte)||preg_match('#\[url\](http://)?(.*?)\[/url\]#si', $texte)||preg_match('#\[img\](.*?)\[/img\]#si', $texte)||preg_match('#\[img=.*?,.*?\](.*?)\[/img\]#si', $texte)||preg_match('#<img.*?>.*?</img>#si', $texte)||preg_match('#<img.*?/>#si', $texte)||preg_match('#<a href=".*?">.*?</a>#si', $texte)){
	$texte = preg_replace("#\[url=(http://)?(.*?)\](.*?)\[/url\]#i", "<A HREF=http://\\2 TARGET=_blank>\\3</A>", $texte);
	$texte = preg_replace("#\[url=(ftp://)?(.*?)\](.*?)\[/url\]#i", "<A HREF=ftp://\\2 TARGET=_blank>\\3</A>", $texte);
	$texte = preg_replace("#\[url\](http://)?(.*?)\[/url\]#i", "<A HREF=http://\\2 TARGET=_blank>\\2</A>", $texte);
	$texte = preg_replace("#\[img\](.*?)\[/img\]#i", "<IMG SRC=\\1 />", $texte);
	$texte = preg_replace("#\[img=(.*?),(.*?)\](.*?)\[/img\]#i", "<IMG BORDER='0' VALIGN='\\2' ALIGN='\\1' SRC='\\3' />", $texte);
	
	$texte = preg_replace("#<img(.*?)>(.*?)</img>#si", "<IMG \\1>\\2</img>", $texte);
	$texte = preg_replace("#<img(.*?)/>#si", "<IMG \\1 />", $texte);
	
	//$texte = preg_replace('#<a href=".*?">.*?</a>#si', "", $texte)
	}
	else {
	if (preg_match('!^www.[a-z0-9._/-]+!i', $texte)){
	$texte = str_replace("www", "http://www", $texte);
	}
	if (preg_match('!http://[a-z0-9._/-]+!i', $texte)) {
	$texte = preg_replace('!http://[a-z0-9._/-]+!si', '<a href="$0"><b>[URL]</b></a>', $texte);
	}
	}
	/*** END ***/
	return $texte;
}
function unsmilies($txt,$texte) {
			
		$own_txt=$txt;	
		$tab_smilies = file("images/smilies/smilies");
	
		//$txt = preg_replace( "#(.*?)<*#si", "\\1 <", $texte );
		//$txt = str_replace("<img", "X <", $txt);
			
		
		for($i=0;$i<count($tab_smilies);$i++) {
			$tab_smiley=split(',',$tab_smilies[$i]);
			$smiley_code=$tab_smiley[0];
			$smiley_img=trim($tab_smiley[1]);
			
			$txt = str_replace("<IMG border='0' SRC=\"images/smilies/$smiley_img\" />", "$smiley_code", $txt);
			}
			
			//$end = preg_replace( "#".$own_txt."*#si", $txt, $texte );
			$txt = str_replace($own_txt, $txt, $texte);
			
			//$txt = str_replace("<IMG border='0' SRC=\"images/smilies/smile.gif\">", ":)", $txt);
			

return $txt;
}

// mouvelle func BBcode
function BBcode($texte)
	{
	//$texte_save=$texte;
	//$texte_save_area = parse_area($texte_save);
	//$texte_save_code = parse_code($texte_save);
	//$texte_BB=$texte;
		
		$texte = ireg_url($texte);
		
		$texte = render($texte);
		//$texte = preg_replace( "#(<pre>.*?</pre>)#si"     , unsmilies("\\1"), $texte );
		//$texte = unsmilies(preg_replace( "#.*<pre>(.*?)</pre>.*#si", "\\1", $texte ),$texte);
		
		//echo unsmilies($text);
		//invers&eacute; les smilay si find <pre> </pre>
		
		
		/*$texte = codeBB($texte);
		$texte_BB = parse_area($texte_BB);
		$texte_BB = parse_code($texte_BB);
		$texte_BB = parse_code_line($texte_BB);
		$texte_BB = parse_code_sql_line($texte_BB);
		$texte_BB = parse_code_sql($texte_BB);
		$texte_BB = parse_code_php($texte_BB);
		$texte_BB = parse_code_php_line($texte_BB);
		*/
		
		//$texte_BB_end = parse_area_end($texte_BB,$texte_save_area);
		//$texte_BB_end = parse_code_end($texte_BB,$texte_save_code);
		//$texte_BB_end = parse_code_line_end($texte_BB,$texte_save_code);
		//$texte = parse_html($texte);
		//$texte = parse_html_line($texte);
				
		return($texte);
	}
// modification du nom de function
function codeBB($texte)
{
		global $strQuote,$strCode,$mods,$strColorerCode;
		
		// Modification de s&eacute;curit&eacute;
		$texte = preg_replace("/>/i", "&gt;", $texte);
	    $texte = preg_replace("/</i", "&lt;", $texte);
		$texte = str_replace("?", "&#63", $texte);
		
	
		// ---> Full edit :
		$texte = preg_replace( "#\(c\)#i"     , "&copy;" , $texte );
		$texte = preg_replace( "#\(tm\)#i"    , "&#153;" , $texte );
		$texte = preg_replace( "#\(r\)#i"     , "&reg;"  , $texte );
		// remove <br /> to <br> for [code] is suxx I know but another apps not work ;( (fuck nl2br...) 
		$texte = preg_replace("!<br />!si", "<br>", $texte);
		
		
		
		
	//G4 -> Mod 'script' en multi ereg ;)
	if($mods['pagescript']=='1'){
	while( preg_match( "#\[script\].*?\[/script\]#si", $texte ) )
			{
		$texte = preg_replace("#\[script\].*?\[/script\]#si", preg_replace("#\&lt;(.*?)\&gt;#si", "<$1>", preg_replace("#.*?\[script\](.*?)\[/script\].*?#si", "$1", $texte)), $texte); 
			}
	}
	
	
	
	//G4 BBCODE ADD ne n&eacute;c&eacute;ssite pas de 'sub' (car ne marcherais de toute façon pas
	while( preg_match( "#(\[flash=)(\S+?)(\,)(\S+?)(\])(\S+?)(\[\/flash\])#i", $texte ) )
			{
			$texte = preg_replace( '#(\[flash=)(\S+?)(\,)(\S+?)(\])(\S+?)(\[\/flash\])#i', 'flash(\'\\2\',\'\\4\',\'\\6\')', $texte );
			}		
	$texte = preg_replace("` (.*?)(\[code\].*?\[/code\])(.*?)`si", smiliesX('\\1','\\2','\\3'), $texte);
	$texte = subing($texte);
	$texte = preg_replace("#\[email\](\S+?)\[/email\]#i"                                                                , "<a href='mailto:\\1'>\\1</a>", $texte);
	$texte = preg_replace("#\[email\s*=\s*\&quot\;([\.\w\-]+\@[\.\w\-]+\.[\.\w\-]+)\s*\&quot\;\s*\](.*?)\[\/email\]#i"  , "<a href='mailto:\\1'>\\2</a>", $texte);
	$texte = preg_replace("#\[email\s*=\s*([\.\w\-]+\@[\.\w\-]+\.[\w\-]+)\s*\](.*?)\[\/email\]#i"                       , "<a href='mailto:\\1'>\\2</a>", $texte);
	//$texte = preg_replace("#\[area=([[:digit:]-]{1,2})\](.*?)\[\/area\]#si"                       , "<textarea cols=80 rows=\\1>\\2</textarea>", $texte);
	//$texte = subparse($texte, '(\[area=([[:digit:]-]{1,2})\])', '(\[/area\])', '<textarea cols=\"400px\" rows=\"%s\">', '</textarea>', 'area');
		
	
	/*** EREG sur les 'url' ***/
	if (preg_match('#\[url=(http://)?(.*?)\](.*?)\[/url\]#i', $texte)||preg_match('#\[url\](http://)?(.*?)\[/url\]#si', $texte)||preg_match('#\[img\](.*?)\[/img\]#si', $texte)||preg_match('#\[img=.*?,.*?\](.*?)\[/img\]#si', $texte)){
	$texte = preg_replace("#\[url=(http://)?(.*?)\](.*?)\[/url\]#i", "<A HREF=http://\\2 TARGET=_blank>\\3</A>", $texte);
	$texte = preg_replace("#\[url=(ftp://)?(.*?)\](.*?)\[/url\]#i", "<A HREF=ftp://\\2 TARGET=_blank>\\3</A>", $texte);
	$texte = preg_replace("#\[url\](http://)?(.*?)\[/url\]#i", "<A HREF=http://\\2 TARGET=_blank>\\2</A>", $texte);
	$texte = preg_replace("#\[img\](.*?)\[/img\]#i", "<IMG SRC=\\1 />", $texte);
	$texte = preg_replace("#\[img=(.*?),(.*?)\](.*?)\[/img\]#i", "<IMG BORDER='0' VALIGN='\\2' ALIGN='\\1' SRC='\\3' />", $texte);
	}
	else {
	if (preg_match('!^www.[a-z0-9._/-]+!i', $texte)){
	$texte = str_replace("www", "http://www", $texte);
	}
	if (preg_match('!http://[a-z0-9._/-]+!i', $texte)) {
	$texte = preg_replace('!http://[a-z0-9._/-]+!si', '<a href="$0"><b>[URL]</b></a>', $texte);
	}
	}
	/*** END ***/
	
	preg_match_all("`\[list\](.*?)\[/list\]`si", $texte, $matches);
	$nb_matches = count($matches);
	for ($i = 0; $i < $nb_matches; $i++)
	{
		$origine = $matches[0][$i];
		$remplacement = $matches[0][$i];
		$remplacement = str_replace('[*]', '<li>', $remplacement);
		$texte = str_replace($origine, $remplacement, $texte);
	}
	// FULL sub (or not work) c'est con hein ? ^^
	$texte = subparse($texte, '(\[list\])', '(\[/list\])', '<ul>', '</ul>');
	

	$texte = nl2br($texte);	
	return($texte);
}

function smiliesX($var1,$var2,$var3) {

	$var1=smilies($var1);
	$var3=smilies($var3);
	
	return $vra1.$var2.$var3;
}

function my_wordwrap($texte="", $chrs=0, $replace="<br />")
	{
		if ( $texte == "" )
		{
			return $texte;
		}
		
		if ( $chrs < 1 )
		{
			return $texte;
		}
		
		$texte = preg_replace("#([^\s<>'\"/\.\\-\?&\n\r\%]{".$chrs."})#i", " \\1".$replace ,$texte);
		
		return $texte;
		
}

function flash ($width="", $height="", $url="") 
{
    $default = "\[flash=$width,$height\]$url\[/flash\]";
    
    $width = ($width > 100)?'100':$width;
    $height = ($height > 300)?'300':$height;
    
    if (!preg_match( "/^http:\/\/(\S+)\.swf$/i", $url) ) {
            $url = 'Mauvaise url !';
    return $default;}
    
    return "<OBJECT CLASSID='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' WIDTH=$width HEIGHT=$height><PARAM NAME=MOVIE VALUE=$url><PARAM NAME=PLAY VALUE=TRUE><PARAM NAME=LOOP VALUE=TRUE><PARAM NAME=QUALITY VALUE=HIGH><EMBED SRC=$url WIDTH=$width HEIGHT=$height PLAY=TRUE LOOP=TRUE QUALITY=HIGH></EMBED></OBJECT>";
} 
  
function sql_highlight_string($chaine, $lignes=FALSE, $retour=FALSE)
{
		$chaine = preg_replace("!<br />!i", "[#newline#]", $chaine);
		$chaine = preg_replace("!‘!i", "&lsquo;", $chaine);
		$chaine = preg_replace("!'!i", "&#39;", $chaine);
		
		$chaine = preg_replace( "/^\s+/"   , "", $chaine );
		$chaine = preg_replace( "#(=|\+|\-|&gt;|&lt;|~|==|\!=|LIKE|NOT LIKE|REGEXP|\*)#i"            , "<span style='color:orange'>\\1</span>", $chaine );
		$chaine = preg_replace( "#(\.)#i"            , "<span style='color:red'>\\1</span>", $chaine );
		$chaine = preg_replace( "#(&lsquo;.*?&lsquo;)#i"            , "<span style='color:blue'>\\1</span>", $chaine );
		$chaine = preg_replace( "#(MAX|AVG|SUM|COUNT|MIN)\(#i"                                    , "<span style='color:blue'>\\1</span>("    , $chaine );
	    $chaine = preg_replace( "!(&quot;|&#39;|&#039;)(.+?)(&quot;|&#39;|&#039;)!i"              , "<span style='color:red'>\\1\\2\\3</span>" , $chaine );
	    $chaine = preg_replace( "#\s{1,}(AND|OR|AS|ON)\s{1,}#i"                                         , " <span style='color:blue'>\\1</span> "    , $chaine );
	    $chaine = preg_replace( "#(LEFT|JOIN|WHERE|MODIFY|CHANGE|AS|DISTINCT|IN|ASC|DESC|ORDER BY|GROUP BY)\s{1,}#i" , "<span style='color:green'>\\1</span> "   , $chaine );
	    $chaine = preg_replace( "#LIMIT\s*(\d+)\s*,\s*(\d+)#i"                                    , "<span style='color:green'>LIMIT</span> <span style='color:orange'>\\1, \\2</span>" , $chaine );
	    $chaine = preg_replace( "#(FROM|INTO)\s{1,}(\S+?)\s{1,}#i"                                , "<span style='color:green'>\\1</span> <span style='color:orange'>\\2</span> ", $chaine );
	    $chaine = preg_replace( "#(SELECT|INSERT|UPDATE|DELETE|ALTER TABLE|DROP)#i"               , "<span style='color:blue;font-weight:bold'>\\1</span>" , $chaine );

	

   $source = $chaine;
   //str_replace("</font>", "</span>", str_replace("<font color=\"", "<span style=\"color:", $chaine));
   	$no = '';	
  
   	$leslignes = explode("[#newline#]", $source);
   	$no = 1;
   	$source = "";
   	foreach($leslignes as $laligne){
		$source .= sprintf("<span style=\"color:#666666\">%04d</span> ".$laligne."<br>", $no++);
		}
   
   return $source;
}
function xhtml_highlight_string($chaine, $lignes=FALSE, $retour=FALSE, $php=FALSE)
{
    $chaine = str_replace("&#63", "?", $chaine);
	$chaine = preg_replace("/&gt;/i", ">", $chaine);
	$chaine = preg_replace("/&lt;/i", "<", $chaine);
	$chaine = preg_replace("/&#91;/i", "[", $chaine);
	$chaine = preg_replace("/&#93;/i", "]", $chaine);
	$chaine = preg_replace("/&fs1;/i", "[", $chaine);
	$chaine = preg_replace("/&fs2;/i", "]", $chaine);
	$chaine = preg_replace("!<br />!i", "", $chaine);
		
 if ($php) {		
  if (!preg_match('!<\?(.+?)\?>!i',$chaine)){
	$chaine = "<? ".$chaine." ?>";
	}
	}
	
   $source = str_replace("</font>", "</span>", str_replace("<font color=\"", "<span style=\"color:", highlight_string($chaine, TRUE)));
   	$no = '';	
   if($lignes)
   {
   	$leslignes = explode("<br />", $source);
   	$no = 1;
   	$source = "";
   	foreach($leslignes as $laligne){
		$source .= sprintf("<span style=\"color:#666666\">%04d</span>".$laligne."<br>", $no++);
		}
   } else {
   	$leslignes = explode("<br />", $source);
   	$source = "";
   	foreach($leslignes as $laligne){
		$source .= $laligne."<br>";
		}
   }
  		
   if($retour) 
   {
   return $source;
   } else {
	echo $source;
   }
}

function smilies($texte) {

		$tab_smilies = file("images/smilies/smilies");
	
		for($i=0;$i<count($tab_smilies);$i++) {
			$tab_smiley=split(',',$tab_smilies[$i]);
			$smiley_code=$tab_smiley[0];
			$smiley_img=trim($tab_smiley[1]);
							
			$texte = str_replace("$smiley_code", "<IMG border='0' SRC=\"images/smilies/$smiley_img\">", $texte);
			}
			return $texte;
}

function buttonBB($BBtext)
{
	global $mods;
	
	
	if ($mods['bbcode']) {
	global $strGras,$strItalique,$strSouligner,$strListe,$strQuote,$strCode,$strEMail,$strURL,$strImage;
	global $strCouleur,$strRED,$strDARKED,$strBLUE,$strDARKBLUE,$strORANGE,$strBROWN,$strYELLOW,$strGREEN,$strVIOLET,$strCYAN,$strOLIVE,$strINDIGO,$strWHITE,$strBLACK;
	global $strTaille,$strPolice,$db,$dbprefix,$mods,$strScript;
	global $strL_BBCODE_B_HELP,$strSurligner_help,$strL_BBCODE_I_HELP,$strL_BBCODE_U_HELP,$strL_BBCODE_Q_HELP,$strL_BBCODE_C_HELP,$strL_BBCODE_L_HELP,$strL_BBCODE_O_HELP,$strL_BBCODE_P_HELP,$strL_BBCODE_W_HELP,$strL_BBCODE_S_HELP,$strL_BBCODE_F_HELP,$strL_BBCODE_A_HELP,$strL_BBCODE_CLOSE_TAGS,$strL_EMPTY_MESSAGE,$strL_STYLES_TIP,$strL_BBCODE_N_HELP;
	global $strAlign,$strLeft,$strRight,$strCenter,$strJustify,$strAlignHelp,$strSurligner;
	
	echo '
<script language="JavaScript" type="text/javascript">
<!--
// BBCode int&eacute;gration java multi navigateur
// l\'appellation BBcode est d&eacute;pos&eacute; par phpBB
// ce parsing JAVA est issue de phpBB 2.0 et est cens&eacute; être compatible 
// pour la majorit&eacute; des navigateur. 
// r&eacute;adapter par Gectou4 pour phpTG4

// Startup variables
var imageTag = false;
var theSelection = false;

// Check for Browser & Platform for PC & IE specific bits
// More details from: http://www.mozilla.org/docs/web-developer/sniffer/browser_type.html
var clientPC = navigator.userAgent.toLowerCase(); // Get client info
var clientVer = parseInt(navigator.appVersion); // Get browser version

var is_ie = ((clientPC.indexOf("msie") != -1) && (clientPC.indexOf("opera") == -1));
var is_nav = ((clientPC.indexOf(\'mozilla\')!=-1) && (clientPC.indexOf(\'spoofer\')==-1)
                && (clientPC.indexOf(\'compatible\') == -1) && (clientPC.indexOf(\'opera\')==-1)
                && (clientPC.indexOf(\'webtv\')==-1) && (clientPC.indexOf(\'hotjava\')==-1));
var is_moz = 0;

var is_win = ((clientPC.indexOf("win")!=-1) || (clientPC.indexOf("16bit") != -1));
var is_mac = (clientPC.indexOf("mac")!=-1);

// Helpline messages
b_help = "'.$strL_BBCODE_B_HELP.'";
i_help = "'.$strL_BBCODE_I_HELP.'";
u_help = "'.$strL_BBCODE_U_HELP.'";
q_help = "'.$strL_BBCODE_Q_HELP.'";
c_help = "'.$strL_BBCODE_C_HELP.'";
l_help = "'.$strL_BBCODE_L_HELP.'";
o_help = "'.$strL_BBCODE_O_HELP.'";
p_help = "'.$strL_BBCODE_P_HELP.'";
w_help = "'.$strL_BBCODE_W_HELP.'";
a_help = "'.$strL_BBCODE_A_HELP.'";
s_help = "'.$strL_BBCODE_S_HELP.'";
f_help = "'.$strL_BBCODE_F_HELP.'";
n_help = "'.$strL_BBCODE_N_HELP.'";
h_help = "'.$strAlignHelp.'";
y_help = "'.$strSurligner_help.'";

// Define the bbCode tags
bbcode = new Array();
bbtags = new Array(\'[b]\',\'[/b]\',\'[i]\',\'[/i]\',\'[u]\',\'[/u]\',\'[quote]\',\'[/quote]\',\'[code]\',\'[/code]\',\'[list]\',\'[/list]\',\'[list=]\',\'[/list]\',\'[img]\',\'[/img]\',\'[url]\',\'[/url]\',\'[-]\',\'[/-]\',\'[+]\',\'[/+]\');
imageTag = false;

// Shows the help messages in the helpline window
function helpline(help) {
	document.formulaire.helpbox.value = eval(help + "_help");
}


// Replacement for arrayname.length property
function getarraysize(thearray) {
	for (i = 0; i < thearray.length; i++) {
		if ((thearray[i] == "undefined") || (thearray[i] == "") || (thearray[i] == null))
			return i;
		}
	return thearray.length;
}

// Replacement for arrayname.push(value) not implemented in IE until version 5.5
// Appends element to the array
function arraypush(thearray,value) {
	thearray[ getarraysize(thearray) ] = value;
}

// Replacement for arrayname.pop() not implemented in IE until version 5.5
// Removes and returns the last element of an array
function arraypop(thearray) {
	thearraysize = getarraysize(thearray);
	retval = thearray[thearraysize - 1];
	delete thearray[thearraysize - 1];
	return retval;
}


function checkForm() {

	formErrors = false;    

	if (document.formulaire.'.$BBtext.'.value.length < 2) {
		formErrors = "'.$strL_EMPTY_MESSAGE.'";
	}

	if (formErrors) {
		alert(formErrors);
		return false;
	} else {
		bbstyle(-1);
		//formObj.preview.disabled = true;
		//formObj.submit.disabled = true;
		return true;
	}
}

function emoticon(text) {
	var txtarea = document.formulaire.'.$BBtext.';
	text = \' \' + text + \' \';
	if (txtarea.createTextRange && txtarea.caretPos) {
		var caretPos = txtarea.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == \' \' ? caretPos.text + text + \' \' : caretPos.text + text;
		txtarea.focus();
	} else {
		txtarea.value  += text;
		txtarea.focus();
	}
}

function bbfontstyle(bbopen, bbclose) {
	var txtarea = document.formulaire.'.$BBtext.';

	if ((clientVer >= 4) && is_ie && is_win) {
		theSelection = document.selection.createRange().text;
		if (!theSelection) {
			txtarea.value += bbopen + bbclose;
			txtarea.focus();
			return;
		}
		document.selection.createRange().text = bbopen + theSelection + bbclose;
		txtarea.focus();
		return;
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, bbopen, bbclose);
		return;
	}
	else
	{
		txtarea.value += bbopen + bbclose;
		txtarea.focus();
	}
	storeCaret(txtarea);
}


function bbstyle(bbnumber) {
	var txtarea = document.formulaire.'.$BBtext.';

	txtarea.focus();
	donotinsert = false;
	theSelection = false;
	bblast = 0;

	if (bbnumber == -1) { // Close all open tags & default button names
		while (bbcode[0]) {
			butnumber = arraypop(bbcode) - 1;
			txtarea.value += bbtags[butnumber + 1];
			buttext = eval(\'document.formulaire.addbbcode\' + butnumber + \'.value\');
			eval(\'document.formulaire.addbbcode\' + butnumber + \'.value ="\' + buttext.substr(0,(buttext.length - 1)) + \'"\');
		}
		imageTag = false; // All tags are closed including image tags :D
		txtarea.focus();
		return;
	}

	if ((clientVer >= 4) && is_ie && is_win)
	{
		theSelection = document.selection.createRange().text; // Get text selection
		if (theSelection) {
			// Add tags around selection
			document.selection.createRange().text = bbtags[bbnumber] + theSelection + bbtags[bbnumber+1];
			txtarea.focus();
			theSelection = \'\';
			return;
		}
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, bbtags[bbnumber], bbtags[bbnumber+1]);
		return;
	}
	
	// Find last occurance of an open tag the same as the one just clicked
	for (i = 0; i < bbcode.length; i++) {
		if (bbcode[i] == bbnumber+1) {
			bblast = i;
			donotinsert = true;
		}
	}

	if (donotinsert) {		// Close all open tags up to the one just clicked & default button names
		while (bbcode[bblast]) {
				butnumber = arraypop(bbcode) - 1;
				txtarea.value += bbtags[butnumber + 1];
				buttext = eval(\'document.formulaire.addbbcode\' + butnumber + \'.value\');
				eval(\'document.formulaire.addbbcode\' + butnumber + \'.value ="\' + buttext.substr(0,(buttext.length - 1)) + \'"\');
				imageTag = false;
			}
			txtarea.focus();
			return;
	} else { // Open tags
	
		if (imageTag && (bbnumber != 14)) {		// Close image tag before adding another
			txtarea.value += bbtags[15];
			lastValue = arraypop(bbcode) - 1;	// Remove the close image tag from the list
			document.formulaire.addbbcode14.value = "Img";	// Return button back to normal state
			imageTag = false;
		}
		
		// Open tag
		txtarea.value += bbtags[bbnumber];
		if ((bbnumber == 14) && (imageTag == false)) imageTag = 1; // Check to stop additional tags after an unclosed image tag
		arraypush(bbcode,bbnumber+1);
		eval(\'document.formulaire.addbbcode\'+bbnumber+\'.value += "*"\');
		txtarea.focus();
		return;
	}
	storeCaret(txtarea);
}

// From http://www.massless.org/mozedit/
function mozWrap(txtarea, open, close)
{
	var selLength = txtarea.textLength;
	var selStart = txtarea.selectionStart;
	var selEnd = txtarea.selectionEnd;
	if (selEnd == 1 || selEnd == 2) 
		selEnd = selLength;

	var s1 = (txtarea.value).substring(0,selStart);
	var s2 = (txtarea.value).substring(selStart, selEnd)
	var s3 = (txtarea.value).substring(selEnd, selLength);
	txtarea.value = s1 + open + s2 + close + s3;
	return;
}

// Insert at Claret position. Code from
// http://www.faqts.com/knowledge_base/view.phtml/aid/1052/fid/130
function storeCaret(textEl) {
	if (textEl.createTextRange) textEl.caretPos = document.selection.createRange().duplicate();
}

//-->
</script>
	';
	
	echo "<script language=\"javascript\">	
	function storeCaret () { 
		if (document.formulaire.".$BBtext.".createTextRange) document.formulaire.".$BBtext.".caretPos = document.selection.createRange().duplicate(); 
	} 
	
	function insertAtCaret (icon1, icon2) { 
		if (document.formulaire.".$BBtext.".createTextRange && document.formulaire.".$BBtext.".caretPos) { 
			var caretPos = document.formulaire.".$BBtext.".caretPos; 
			selectedtext = caretPos.text; 
			caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == '' ? icon1 + '' : icon1; 
			caretPos.text = caretPos.text + selectedtext + icon2; 
		} else document.formulaire.".$BBtext.".value = document.formulaire.".$BBtext.".value + icon1 + ' ' + icon2 
		
		document.formulaire.".$BBtext.".focus(); 
	}
	function insertAtCaret2 (icon1, icon2) { 
		if (document.formulaire.".$BBtext.".createTextRange && document.formulaire.".$BBtext.".caretPos) { 
			var caretPos = document.formulaire.".$BBtext.".caretPos; 
			selectedtext = caretPos.text; 
			caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == '' ? icon1 + '' : icon1; 
			caretPos.text = caretPos.text + selectedtext + icon2; 
		} else document.formulaire.".$BBtext.".value = document.formulaire.".$BBtext.".value + icon1 + ' ' + icon2 
		
		document.formulaire.".$BBtext.".focus(); 
	}
	</script>";
	
	echo '
	
	<table border="0" cellspacing="0" cellpadding="2" align="center" valign="middle">
		  <tr align="center" valign="center"> 
		  <!--
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="b" name="addbbcode0" value=" B " style="font-weight:bold; width: 30px" onClick="bbstyle(0)" onMouseOver="helpline(\'b\')" />
			  </span></td>
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="i" name="addbbcode2" value=" i " style="font-style:italic; width: 30px" onClick="bbstyle(2)" onMouseOver="helpline(\'i\')" />
			  </span></td>
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="u" name="addbbcode4" value=" u " style="text-decoration: underline; width: 30px" onClick="bbstyle(4)" onMouseOver="helpline(\'u\')" />
			  </span></td>
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="q" name="addbbcode6" value="Quote" style="width: 50px" onClick="bbstyle(6)" onMouseOver="helpline(\'q\')" />
			  </span></td>
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="c" name="addbbcode8" value="Code" style="width: 40px" onClick="bbstyle(8)" onMouseOver="helpline(\'c\')" />
			  </span></td>
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="l" name="addbbcode10" value="List" style="width: 40px" onClick="bbstyle(10)" onMouseOver="helpline(\'l\')" />
			  </span></td>
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="o" name="addbbcode12" value="List=" style="width: 40px" onClick="bbstyle(12)" onMouseOver="helpline(\'o\')" />
			  </span></td>
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="p" name="addbbcode14" value="Img" style="width: 40px"  onClick="bbstyle(14)" onMouseOver="helpline(\'p\')" />
			  </span></td>
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="w" name="addbbcode16" value="URL" style="text-decoration: underline; width: 40px" onClick="bbstyle(16)" onMouseOver="helpline(\'w\')" />
			  </span></td>-->
			<td><span class="genmed"> 
			  <input type="button" class="button" accesskey="b" name="addbbcode0" value=" B " style="font-weight:bold; width: 30px" onClick="bbstyle(0)" onMouseOver="helpline(\'b\')" />
		
			
			  <input type="button" class="button" accesskey="i" name="addbbcode2" value=" i " style="font-style:italic; width: 30px" onClick="bbstyle(2)" onMouseOver="helpline(\'i\')" />
		
		
			  <input type="button" class="button" accesskey="u" name="addbbcode4" value=" u " style="text-decoration: underline; width: 30px" onClick="bbstyle(4)" onMouseOver="helpline(\'u\')" />
		
			
			  <input type="button" class="button" accesskey="q" name="addbbcode6" value="Quote" style="width: 50px" onClick="bbstyle(6)" onMouseOver="helpline(\'q\')" />
		
			 
			  <input type="button" class="button" accesskey="c" name="addbbcode8" value="Code" style="width: 40px" onClick="bbstyle(8)" onMouseOver="helpline(\'c\')" />
			
		
			  <input type="button" class="button" accesskey="l" name="addbbcode10" value="List" style="width: 40px" onClick="bbstyle(10)" onMouseOver="helpline(\'l\')" />
		
			
			  <input type="button" class="button" accesskey="o" name="addbbcode12" value="List=" style="width: 40px" onClick="bbstyle(12)" onMouseOver="helpline(\'o\')" />
		
			
			  <input type="button" class="button" accesskey="p" name="addbbcode14" value="Img" style="width: 40px"  onClick="bbstyle(14)" onMouseOver="helpline(\'p\')" />
			
			
			  <input type="button" class="button" accesskey="w" name="addbbcode16" value="URL" style="text-decoration: underline; width: 40px" onClick="bbstyle(16)" onMouseOver="helpline(\'w\')" />
			  
			  
			  <input type="button" class="button" accesskey="x" name="closetag" value="[/]" width: 40px" onClick="bbstyle(-1)" onMouseOver="helpline(\'a\')" />
			 
			
			  
			 </span></td>
			 
		  </tr>
		  <tr> 
			<!--<td colspan="9"> -->
			<td>
			  <table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr> 				
				  <td><span class="genmed"> &nbsp;'.$strCouleur.': 
					<select name="addbbcode18" onChange="bbfontstyle(\'[color=\' + this.form.addbbcode18.options[this.form.addbbcode18.selectedIndex].value + \']\', \'[/color]\');this.selectedIndex=0;" onMouseOver="helpline(\'s\')">
					  <!-- <option style="color:black; background-color: black" value="{T_FONTCOLOR1}" class="genmed">black</option> -->
					  <option style="color:white; background-color: WHITE" value="white" class="genmed">'.$strWHITE.'</option> 
					  <option style="color:red; background-color: RED" value="red" class="genmed">'.$strRED.'</option>
					  <option style="color:orange; background-color: ORANGE" value="orange" class="genmed">'.$strORANGE.'</option>
					  <option style="color:darkred; background-color: darkred" value="darkred" class="genmed">'.$strDARKED.'</option>
					  <option style="color:brown; background-color: BROWN" value="brown" class="genmed">'.$strBROWN.'</option>
					  <option style="color:yellow; background-color: YELLOW" value="yellow" class="genmed">'.$strYELLOW.'</option>
					  <option style="color:green; background-color: GREEN" value="green" class="genmed">'.$strGREEN.'</option>
					  <option style="color:olive; background-color: OLIVE" value="olive" class="genmed">'.$strOLIVE.'</option>
					  <option style="color:cyan; background-color: CYAN" value="cyan" class="genmed">'.$strCYAN.'</option>
					  <option style="color:blue; background-color: BLUE" value="blue" class="genmed">'.$strBLUE.'</option>
					  <option style="color:darkblue; background-color: DARKBLUE" value="darkblue" class="genmed">'.$strDARKBLUE.'</option>
					  <option style="color:indigo; background-color: INDIGO" value="indigo" class="genmed">'.$strINDIGO.'</option>
					  <option style="color:violet; background-color: VIOLET" value="violet" class="genmed">'.$strVIOLET.'</option>
					  <option style="color:black; background-color: BLACK" value="black" class="genmed">'.$strBLACK.'</option>
					 
					</select> &nbsp;'.$strTaille.':<select name="addbbcode20" onChange="bbfontstyle(\'[size=\' + this.form.addbbcode20.options[this.form.addbbcode20.selectedIndex].value + \']\', \'[/size]\')" onMouseOver="helpline(\'f\')">
					  <option value="7" class="genmed">7</option>
					  <option value="9" class="genmed">9</option>
					  <option value="12" selected class="genmed">12</option>
					  <option value="18" class="genmed">18</option>
					  <option  value="24" class="genmed">24</option>
					</select>
					
					</select> &nbsp;'.$strAlign.':<select name="addbbcode30" onChange="bbfontstyle(\'[align=\' + this.form.addbbcode30.options[this.form.addbbcode30.selectedIndex].value + \']\', \'[/align]\')" onMouseOver="helpline(\'h\')">
					  <option value="left" class="genmed">'.$strLeft.'</option>
					  <option value="right" class="genmed">'.$strRight.'</option>
					  <option value="center" class="genmed">'.$strCenter.'</option>
					  <option value="justify" class="genmed">'.$strJustify.'</option>

					</select>&nbsp;'.$strSurligner.': 
					<select name="addbbcode40" onChange="bbfontstyle(\'[bgcolor=\' + this.form.addbbcode40.options[this.form.addbbcode40.selectedIndex].value + \']\', \'[/bgcolor]\');this.selectedIndex=0;" onMouseOver="helpline(\'y\')">
					  <!-- <option style="color:black; background-color: black" value="{T_FONTCOLOR1}" class="genmed">black</option> -->
					  <option style="color:white; background-color: WHITE" value="white" class="genmed">'.$strWHITE.'</option> 
					  <option style="color:red; background-color: RED" value="red" class="genmed">'.$strRED.'</option>
					  <option style="color:orange; background-color: ORANGE" value="orange" class="genmed">'.$strORANGE.'</option>
					  <option style="color:darkred; background-color: darkred" value="darkred" class="genmed">'.$strDARKED.'</option>
					  <option style="color:brown; background-color: BROWN" value="brown" class="genmed">'.$strBROWN.'</option>
					  <option style="color:yellow; background-color: YELLOW" value="yellow" class="genmed">'.$strYELLOW.'</option>
					  <option style="color:green; background-color: GREEN" value="green" class="genmed">'.$strGREEN.'</option>
					  <option style="color:olive; background-color: OLIVE" value="olive" class="genmed">'.$strOLIVE.'</option>
					  <option style="color:cyan; background-color: CYAN" value="cyan" class="genmed">'.$strCYAN.'</option>
					  <option style="color:blue; background-color: BLUE" value="blue" class="genmed">'.$strBLUE.'</option>
					  <option style="color:darkblue; background-color: DARKBLUE" value="darkblue" class="genmed">'.$strDARKBLUE.'</option>
					  <option style="color:indigo; background-color: INDIGO" value="indigo" class="genmed">'.$strINDIGO.'</option>
					  <option style="color:violet; background-color: VIOLET" value="violet" class="genmed">'.$strVIOLET.'</option>
					  <option style="color:black; background-color: BLACK" value="black" class="genmed">'.$strBLACK.'</option>
					</span></td>
				 <!-- <td nowrap="nowrap" align="right"><span class="gensmall"><a href="javascript:bbstyle(-1)" class="genmed" onMouseOver="helpline(\'a\')">'.$strL_BBCODE_CLOSE_TAGS.'</a></span></td> -->
				</tr>
			  </table>
			</td>
		  </tr>
		  <tr> 
			<td colspan="9"> <span class="gensmall"> 
			  <input type="text" name="helpbox" size="45" maxlength="100" style="width:450px; font-size:10px" class="helpline" value="'.$strL_STYLES_TIP.'" />
			  </span></td>
		  </tr>
		</table>
		
		';
	
	$tab_smilies = file("images/smilies/smilies");

	for($i=0;$i<count($tab_smilies);$i++) {
		$tab_smiley=split(',',$tab_smilies[$i]);
		$smiley_code=$tab_smiley[0];
		$smiley_img=trim($tab_smiley[1]);

		echo " <a href=\"javascript:insertAtCaret('$smiley_code','')\"><img src=\"images/smilies/$smiley_img\" border=\"0\"></a>";
		}
	} else {

		
	echo ' 
		
	<script type="text/javascript">
	
	window.onload = function()
      {
		
        var oFCKeditor = new FCKeditor( \''.$BBtext.'\' ) ;
		
		oFCKeditor.Width =\'450\';
		oFCKeditor.BasePath	= \'include/\' ;
		oFCKeditor.Value	= \'Taper ici votre message !\'  ;
		oFCKeditor.ReplaceTextarea() ;
      }</script>';
	  
	  }
	/*echo '
	  
<script type="text/javascript" src="/FCKeditor2/fckeditor.js"></script>

<script type="text/javascript">
var oFCKeditor = new FCKeditor( \'FCKeditor1\' ) ;
oFCKeditor.BasePath	= \'/FCKeditor2/\' ;
oFCKeditor.Value	= \'EDITED\'  ;
oFCKeditor.Create() ;

			</script>';*/

}

function remove_XSS($str)
{
$str = str_replace("content-disposition:","!content-disposition:!",$str);
$str = str_replace("content-type:","!content-type:!",$str);
$str = str_replace("content-transfer-encoding:","!content-transfer-encoding:!",$str);
$str = str_replace("include","!include!",$str);
$str = str_replace("\<\?","&lt;?",$str);
$str = str_replace("<\?php","&lt;?php",$str);
$str = str_replace("\?\>","?&gt;",$str);
$str = str_replace("script","!script!",$str);
$str = str_replace("eval","!eval!",$str);
$str = str_replace("javascript","!javascript!",$str);
$str = str_replace("embed","!embed!",$str);
$str = str_replace("iframe","!iframe!",$str);
$str = str_replace("refresh","!refresh!",$str);
$str = str_replace("onload","!onload!",$str);
$str = str_replace("onstart","!onstart!",$str);
$str = str_replace("onerror","!onerror!",$str);
$str = str_replace("onabort","!onabort!",$str);
$str = str_replace("onblur","!onblur!",$str);
$str = str_replace("onchange","!onchange!",$str);
$str = str_replace("onclick","!onclick!",$str);
$str = str_replace("ondblclick","!ondblclick!",$str);
$str = str_replace("onfocus","!onfocus!",$str);
$str = str_replace("onkeydown","!onkeydown!",$str);
$str = str_replace("onkeypress","!onkeypress!",$str);
$str = str_replace("onkeyup","!onkeyup!",$str);
$str = str_replace("onmousedown","!onmousedown!",$str);
$str = str_replace("onmousemove","!onmousemove!",$str);
$str = str_replace("onmouseover","!onmouseover!",$str);
$str = str_replace("onmouseout","!onmouseout!",$str);
$str = str_replace("onmouseup","!onmouseup!",$str);
$str = str_replace("onreset","!onreset!",$str);
$str = str_replace("onselect","!onselect!",$str);
$str = str_replace("onsubmit","!onsubmit!",$str);
$str = str_replace("onunload","!onunload!",$str);
$str = str_replace("document.cookie","!document.cookie!",$str);
$str = str_replace("vbscript","!vbscript!",$str);
$str = str_replace("location","!location!",$str);
$str = str_replace("object","!object!",$str);
$str = str_replace("vbs","!vbs!",$str);
$str = str_replace("href","!href!",$str);
$str = str_replace("<","&lt;",$str);
$str = str_replace(">","&gt;",$str);
//$str = str_replace(" ","&nbsp;",$str);
return($str);	
}

//fonction fsb && phpBB re-&eacute;dit&eacute; rofl ^^
function subparse($texte, $patern_ouvert, $patern_ferme, $theme_ouvert, $theme_ferme, $special = FALSE)
{
	global $strQuote;

	preg_match_all('`' . $patern_ouvert . '`i', $texte, $matches_o);
	preg_match_all('`' . $patern_ferme . '`i', $texte, $matches_f);
	$minimum = min(count($matches_o[0]), count($matches_f[0]));
	$position_o = 0;
	$position_f = 0;

	for ( $i = 0; $i < $minimum; $i++ )
	{
		$position_o = strpos($texte, $matches_o[0][$i], $position_o);
		$position_f = strpos($texte, $matches_f[0][$i], $position_f);
		if ( $position_o < $position_f )
		{
			$open = $theme_ouvert;
			if ($special == 'quot')
			{
				$open = sprintf('<br><table class="tableau" style="width: %s;" align="center" cellspacing="0" cellpadding="3"><tr><td class="quote_titre">%s</td></tr><tr><td class="quote">', '90%', '<b>'.$strQuote . ' :</b> ' . $matches_o[2][$i]);
			}
			else if ($special == 'couleur' || $special == 'taille' || $special == 'font' || $special == 'align'|| $special == 'glow' || $special == 'area' || $special == 'table' || $special == 'td' || $special == 'tr')
			{
				$open = sprintf($theme_ouvert, $matches_o[2][$i]);
			}
	
			$texte = preg_replace('`' . preg_quote($matches_o[0][$i]) . '`i', $open, $texte, 1);
			$texte = preg_replace('`' . preg_quote($matches_f[0][$i]) . '`i', $theme_ferme, $texte, 1);
		}
	}

	return $texte;
}

function CoolSize($size) {
	global $strOctets,$strKOctets,$strMOctets;
    $mb = 1024*1024;
    if ( $size > $mb ) {
        $mysize = sprintf ("%01.2f",$size/$mb) . " $strMOctets";
    } elseif ( $size >= 1024 ) {
        $mysize = sprintf ("%01.2f",$size/1024) . " $strKOctets";
    } else {
        $mysize = $size . " $strOctets";
    }
    return $mysize;
}


function getmicrotime()
{
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
}

function is_flood($mod_flood) {
	global $config,$db,$dbprefix;
	
	$ip = (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : 
			(isset($_SERVER['HTTP_CLIENT_IP'])) ? $_SERVER['HTTP_CLIENT_IP'] : $_SERVER['REMOTE_ADDR'];

	$date= time();
	$minute_flood = strftime("%Y", $date).strftime("%m", $date).(strftime("%H", $date)*60)+(strftime("%M", $date))+(strftime("%H", $date)*24*60);
	
	$noflood_time = $minute_flood - $config['flood_time'];
	
	//$db->select("*");
	//$db->from("${dbprefix}flood");
	//$res= $db->exec();
	
	//while ($result_flood = $db->fetch($res)) {
		
		$db->delete("${dbprefix}flood");
		$db->where("date < $noflood_time");
		$db->exec();
	
	//}
	//on vide toutes les addresses ip obsoletes enregistr&eacute;es dans la table
	
	//on verifie l adresse ip et si la date est dans slice de temps flood
	$db->select("*");
	$db->from("${dbprefix}flood");
	$db->where("ip = '$ip' AND `date` = '$noflood_time' AND `mod` = '$mod_flood'");
	//$db->order_by("date DESC");
	$res = $db->exec();	
	
	if($db->num_rows($res)!= 0)	{
		return true;
	}
	else {
		$db->insert("${dbprefix}flood (ip,date,mod)");
		$db->values("'$ip','$minute_flood','$mod_flood'");	
		return false;
	}
}


function navigateur($start, $limit, $total, $link)
{	
	
	if ($limit > 0 && $total > 0 && $start < $total) {
		$nb_pages = ceil($total / $limit);
		$act_page = $start / $limit + 1;
		$list = "";

		if ($nb_pages > 1) {  
			if ($act_page > 1) {
				$list.= "<a href=\"".sprintf($link,($start - $limit))."\"><img src=\"images/back.gif\" border=\"0\" align=\"absmiddle\"></a>&nbsp;";
			}
			for ($i = 1; $i <= $nb_pages; $i++) {
				if ($i == $act_page) {
					$list.= "<B>[$i]</B>";
				}
				else {
					$list.= "<a href=\"".sprintf($link,(($i - 1) * $limit))."\">[$i]</a>";
				}

				if ($i < $nb_pages)	{
					$list.= "&nbsp;";
				}
			}

			if ($act_page < $nb_pages) {
				$list.= "&nbsp;<a href=\"".sprintf($link,($start + $limit))."\"><img src=\"images/next.gif\" border=\"0\" align=\"absmiddle\"></a>";
			}
		}
		return $list;
	}
}




function compteur() {
	global $s_joueur,$config,$db,$dbprefix,$s_type,$Sess;

	if($db) {
	$time = time();
	$duree = $time + $config['stats_timeout'];

	if ($s_joueur>0)
	{
		$grade = get_grade($s_joueur);
		$c_grade = 0;
		if ( stripos($grade, 'v') !== false ) $c_grade++;
		if ( stripos($grade, 'w') !== false ) $c_grade++;
		if ( stripos($grade, 'x') !== false ) $c_grade++;
		if ( stripos($grade, 'y') !== false ) $c_grade++;
		if ( stripos($grade, 'z') !== false ) $c_grade++;
		
		if (strlen($grade)-$c_grade>0) $s_type = 2;
		else if ($s_joueur > 0) $s_type = 1;
	}
	
	//on vide toutes les addresses ip obsoletes enregistr&eacute;es dans la table
	$db->delete("${dbprefix}compteur");
	$db->where("date < $time");
	$db->exec();

	//on incremente la nb de pages vues
	$db->update("${dbprefix}stats");
	$db->set("count = count + 1");
	$db->where("nom='pages vues' AND type='compteur'");
	$db->exec();

	//on verifie l adresse ip du visiteur et aussi son heure de passage
	$db->select("*");
	$db->from("${dbprefix}compteur");
	$db->where("id = '".md5($Sess->ip.$Sess->id)."'");
	$res = $db->exec();

	if($db->num_rows($res) > 0) 
	{ 
		//on met a jour les info de l'ip d&eacute;tect&eacute;e
		$db->update("${dbprefix}compteur");
		if(!isset($s_joueur) || empty($s_joueur)) $s_joueur = '0';
		if(!isset($s_joueur) || empty($s_joueur)) $s_type = '0';
		$db->set("date = $duree, joueur = '$s_joueur', type = '$s_type'");
		$db->where("id = '".md5($Sess->ip.$Sess->id)."'");
		$db->exec();
	}
	else {
		//on enregistre l adresse ip si elle est inconnu et on incremente le compteur
		$db->insert("${dbprefix}compteur (id,date,joueur,type)");
		if(!is_int($s_joueur)) $s_joueur = '0';
		if(!is_int($s_type)) $s_type = '0';
		$db->values("'".md5($Sess->ip.$Sess->id)."','$duree','$s_joueur','$s_type'");
		$db->exec();

		if ((ereg("Nav", getenv("HTTP_USER_AGENT"))) || (ereg("Gold", getenv("HTTP_USER_AGENT"))) || (ereg("X11", getenv("HTTP_USER_AGENT"))) || (ereg("Mozilla", getenv("HTTP_USER_AGENT"))) || (ereg("Netscape", getenv("HTTP_USER_AGENT"))) AND (!ereg("MSIE", getenv("HTTP_USER_AGENT")))) {
			$browser = "Netscape";}
		elseif (ereg("MSIE", getenv("HTTP_USER_AGENT"))) {
			$browser = "Internet Explorer";}
		elseif (ereg("Lynx", getenv("HTTP_USER_AGENT"))) {
			$browser = "Lynx";}
		elseif (ereg("Opera", getenv("HTTP_USER_AGENT"))) {
			$browser = "Opera";}
		elseif (ereg("WebTV", getenv("HTTP_USER_AGENT"))) {
			$browser = "WebTV";}
		elseif (ereg("Konqueror", getenv("HTTP_USER_AGENT"))) {
			$browser = "Konqueror";}
		elseif ((eregi("bot", getenv("HTTP_USER_AGENT"))) || (ereg("Google", getenv("HTTP_USER_AGENT"))) || (ereg("Slurp", getenv("HTTP_USER_AGENT"))) || (ereg("Scooter", getenv("HTTP_USER_AGENT"))) || (eregi("Spider", getenv("HTTP_USER_AGENT"))) || (eregi("Infoseek", getenv("HTTP_USER_AGENT")))) {
			$browser = "Moteurs de recherche";}
		else {
			$browser = "Autres";}

		if (ereg("Win", getenv("HTTP_USER_AGENT"))) {
			$os = "Windows";}
		elseif ((ereg("Mac", getenv("HTTP_USER_AGENT"))) || (ereg("PPC", getenv("HTTP_USER_AGENT")))) {
			$os = "Mac";}
		elseif (ereg("Linux", getenv("HTTP_USER_AGENT"))) {
			$os = "Linux";}
		elseif (ereg("FreeBSD", getenv("HTTP_USER_AGENT"))) {
			$os = "FreeBSD";}
		elseif (ereg("SunOS", getenv("HTTP_USER_AGENT"))) {
			$os = "SunOS";}
		elseif (ereg("IRIX", getenv("HTTP_USER_AGENT"))) {
			$os = "IRIX";}
		elseif (ereg("BeOS", getenv("HTTP_USER_AGENT"))) {
			$os = "BeOS";}
		elseif (ereg("OS/2", getenv("HTTP_USER_AGENT"))) {
			$os = "OS/2";}
		elseif (ereg("AIX", getenv("HTTP_USER_AGENT"))) {
			$os = "AIX";}
		else {
			$os = "Autres";}

		$db->update("${dbprefix}stats");
		$db->set("count = count + 1");
		$db->where("((nom='visites' AND type='compteur') OR (type = 'browser' AND nom = '$browser') OR (type = 'os' AND nom = '$os'))");
		$db->exec();

	}

	// recup des resultats
	$db->select("count(id) as nb,type");
	$db->from("${dbprefix}compteur");
	$db->group_by("type");
	$res1 = $db->exec();
		
	$compteur['nb_anonyme']=$compteur['nb_enregistre']=$compteur['nb_admin']=0;

	while($stats=$db->fetch($res1)) {	
		if($stats->type==0) 
			$compteur['nb_anonyme']+=$stats->nb;
		elseif($stats->type==1) 
			$compteur['nb_enregistre']+=$stats->nb;
		elseif($stats->type>1) 
			$compteur['nb_admin']+=$stats->nb;
	}

	$compteur['nb_connecte']=$compteur['nb_enregistre']+$compteur['nb_admin'];
	$compteur['nb_total']=$compteur['nb_anonyme']+$compteur['nb_connecte'];
	
	$db->select("nom,count");
	$db->from("${dbprefix}stats");
	$db->where("type='compteur'");
	$res=$db->exec();

	while($result=$db->fetch($res)) {
		$compteur[$result->nom]=$result->count;
	}

	return $compteur;
	}
}
function get_grade($idj)
{
	global $db,$dbprefix;
	
	$db->select("id,grade");
	$db->from("${dbprefix}joueurs");
	$db->where("id = $idj");
	$res=$db->exec();
	$grade_ch = $db->fetch($res);
	return $grade_ch->grade;
}

function affiche_compteur($nb) {	
	$nb_digits=5;
	$n[]=substr("$nb", 0,1); 
	$n[]=substr("$nb", 1,1); 
	$n[]=substr("$nb", 2,1);
	$n[]=substr("$nb", 3,1);
	$n[]=substr("$nb", 4,1);
	$n[]=substr("$nb", 5,1);
	$n[]=substr("$nb", 6,1);
	$n[]=substr("$nb", 7,1);
	$n[]=substr("$nb", 8,1);
	$n[]=substr("$nb", 9,1);

	if ( strlen ( $nb) < $nb_digits ) {	
		$difference= $nb_digits - (strlen ($nb));
		for ( $x = 1; $x <= $difference; $x++ )	{
			echo "<IMG SRC=\"images/compteur/0.gif\" border=\"0\" width=\"10\" align=\"absmiddle\">";			
		}
	}	
	for ( $x = 0; $x < $nb_digits; $x++ ) {			
		if ( $n[$x] == "" )	break; 
	
		echo "<IMG SRC=\"images/compteur/$n[$x].gif\" border=\"0\" width=\"10\" align=\"absmiddle\">";	
	}	 
}

function affiche_vote($tab_votes) {

	$a = 46;
	$b = 15;
	$c = 33;

	$tab_votes = array("a"=>$a,"b"=>$b,"c"=>$c);
	$total_votes = array_sum($tab_votes);

	echo '<table cellpadding="0" cellspacing="0"><tr>';
	echo '<td>';

	while ($vote = each($tab_votes))
	{
		$precis = number_format(($vote[1]*100)/$total_votes, 2, ".", " ");
		$barre = floor($precis)*2;

		echo "<li class=lib>$vote[0]";

		echo '<table height="14" cellpadding="0" cellspacing="0"><tr>';
		echo '<td>';
		echo '<table cellpadding="0" cellspacing="0" height="12"><tr>';
		echo '<td background="images/vote_bar_l.gif" width="4"></td>';
		echo "<td width=\"$barre\" background=\"images/vote_bar_m.gif\"></td>";
		echo '<td background="images/vote_bar_r.gif" width="4"></td>';
		echo '</tr></table>';
		echo '</td>';
		echo '<td class=text2>';
		echo "&nbsp;&nbsp;$precis% ($vote[1] votes)";
		echo '</td>';
		echo '</tr></table>';
	}
	echo '</tr></table>';
}

function affiche_bar($nombre,$total,$taille=100) {

	if($total<=0||$total<='0'){$total=1;}
	$precis = floor($nombre*100/$total);
	$barre = floor($precis/100*$taille);
	$barre_total = $taille;

	echo '<table height="12" cellpadding="0" cellspacing="0" align=center><tr>';
	echo '<td background="images/bar_l.gif" width="4"></td>';
	echo "<td width=\"$barre_total\" bgcolor=\"#959595\">";
	echo '<table cellpadding="0" cellspacing="0" height="12"><tr>';
	echo "<td width=\"$barre\" background=\"images/bar_m.gif\"></td>";
	echo '<td background="images/bar_r.gif" width="4"></td>';
	echo '</tr></table>';
	echo '</td>';
	echo '<td class=text2>';
	echo "&nbsp;$precis%";
	echo '</td>';
	echo '</tr></table>';

}

function make_pass() {
	$mdp="";
	mt_srand((double)microtime()*1000000);

	$alphabet = "123456789abcdefghjkmnpqrstuvwxyz";
	$alphabet .= "123456789ABCDEFGHJKMNPQRSTUVWXYZ";

    for($j=0; $j<8; $j++)
        $mdp.=$alphabet[mt_rand()%strlen($alphabet)];

	return($mdp);
}

function npage_exist($npage) {
global $db,$dbprefix;

$db->select("id");
$db->from("${dbprefix}page");
$db->where("npage = '$npage'");
$db->where("rubrique = '$rubrique'");
$res=$db->exec();
$membre = $db->fetch($res);

if(!$joueur->id) return 0;
else return $joueur->id;
}

function recuperer_nouveaux_messages_X($derniere_visite)
{
	global $db, $config, $dbprefix, $langue, $HTTP_COOKIE_VARS;
	
	$cookie = unserialize(stripslashes($HTTP_COOKIE_VARS['phptg4cookie_sujets']));

	$sql = 'SELECT id, topid, date FROM ${dbprefix}forum_message  
			WHERE date >= \'' . ( $derniere_visite === 0 ? time() : $derniere_visite ) . '\'';

		if ($derniere_visite==''||$derniere_visite==NULL||$derniere_visite==0) {
		$derniere_visite = time();
		}
		
		$db->select("id, topid, date");
		$db->from("${dbprefix}forum_message");
		$db->where("date >= '$derniere_visite'");
		$sql = $db->exec();
		
		//$lastvist=array();
		//@mysql_fetch_assoc($result)
		while ($data = $db->fetch($sql)) {
		$lastvist.=$data->id;
		$lastvist.=$data->topid;
		$lastvist.=$data->date;
		}
		
			
	
		echo $lastvist;
}

function recuperer_nouveaux_messages($derniere_visite)
{
	global $db, $config, $dbprefix, $langue, $HTTP_COOKIE_VARS;

	$cookie = unserialize(stripslashes($HTTP_COOKIE_VARS['phptg4cookie' . '_sujets']));

	$sql = 'SELECT id, topid, date FROM ${dbprefix}forum_message  
			WHERE date >= \'' . ( $derniere_visite === 0 ? time() : $derniere_visite ) . '\'';
	if ( ! $result = $db->exec($sql) )
	{
		info('Error', sprintf('Impossible de s&eacute;lectionner les donn&eacute;es de: %s', 'sujets'), __LINE__, __FILE__, $sql);
	}

	$data = array();
	while ( $nouveau = $db->tableau($result) )
	{
		$status = ( $cookie[$nouveau['sujet_id']]['type'] == LU && $nouveau['dernier_message_temps'] <= $cookie[$nouveau['sujet_id']]['temps'] ) ? LU : NON_LU;
		$data[$nouveau['sujet_id']]['type'] = $status;
		$data[$nouveau['sujet_id']]['forum_id'] = $nouveau['forum_id'];
		$data[$nouveau['sujet_id']]['temps'] = $nouveau['dernier_message_temps'];
	}

	return $data;
}

function tableau($result, $simple_tableau = FALSE)
	{
		return $simple_tableau ? @mysql_fetch_row($result) : @mysql_fetch_assoc($result);
	}

?>

<?php
/*
  +---------------------------------------------------------------------+
  | Hack by Evolution <Evolution@Freekillers.net>                      |
  +---------------------------------------------------------------------+
  | phpTournois                                                        |
  | phpTournoisG4 ©2005 by Gectou4 <Gectou4 Gectou4@hotmail.com>        |
  +---------------------------------------------------------------------+
  | Copyright(c) 2001-2004 Li0n, RV, Gougou (http://www.phptournois.net)|
  +---------------------------------------------------------------------+
  | This file is part of phpTournois.                                  |
  |                                                                    |
  | phpTournois is free software; you can redistribute it and/or modify |
  | it under the terms of the GNU General Public License as published by|
  | the Free Software Foundation; either version 2 of the License, or  |
  | (at your option) any later version.                                |
  |                                                                    |
  | phpTournois is distributed in the hope that it will be useful,      |
  | but WITHOUT ANY WARRANTY; without even the implied warranty of      |
  | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the      |
  | GNU General Public License for more details.                        |
  |                                                                    |
  | You should have received a copy of the GNU General Public License  |
  | along with AdminBot; if not, write to the Free Software Foundation, |
  | Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA      |
  |                                                                    |
  +---------------------------------------------------------------------+
  | Authors: Li0n  <li0n@phptournois.net>                              |
  |          RV <rv@phptournois.net>                                    |
  |          Gougou                                                    |
  +---------------------------------------------------------------------+
*/

if (preg_match("/inscriptions.php/i", $_SERVER['PHP_SELF'])) {
die ("You cannot open this page directly");
}


$colarbitre = 1;

/*** Affichage des arbitres ***/
  
echo "<p class=title>.:: $strarbitre $strPour $nom_tournois::.</p>";

$db->select("tournois,joueur,id,pseudo,email,msn");
$db->from("${dbprefix}administre, ${dbprefix}joueurs");
$db->where("${dbprefix}administre.joueur = ${dbprefix}joueurs.id");
$db->where("tournois = $s_tournois");
$db->order_by("pseudo");
$res = $db->exec();

    if ($db->num_rows($res) < $colarbitre)
  $colarbitre =1;

if ($db->num_rows($res) != 0) {
  $i=0;
  while ($arbitre = $db->fetch($res)) {
  $tab_arbitre[$i]=$arbitre;
  $i++;
  }

  echo "<table cellspacing=0 cellpadding=0 border=0 class=liste><tr valign=top>";

  for($i=0;$i<$colarbitre;$i++) {

  echo "<td>";
  echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
  echo "<table cellspacing=1 cellpadding=2 border=0>";
  echo "<tr align=\"center\"><td class=headerliste width=120>$strPseudo</td><td class=headerliste width=120>$strEmailContact</td><td class=headerliste width=120>$strMSN</td>";

  for($j=$i;$j<count($tab_arbitre);$j=$j+$colarbitre) {
    echo "<tr>";
    echo "<td class=textliste align=center>".$tab_arbitre[$j]->pseudo."</td>";
    echo "<td class=textliste align=center><a href='mailto:".$tab_arbitre[$j]->email."'>".$tab_arbitre[$j]->email."</a></td>";
    echo "<td class=textliste align=center>".$tab_arbitre[$j]->msn."</td>";
    echo "</tr>";
  }
  echo "</table>";
  echo "</td></tr></table>";
  echo "</td>";
  }  
  echo "</tr></table>";
}

else { 
  echo "<table cellspacing=0 cellpadding=0 border=0 class=liste><tr valign=top><td>";
        echo "<table border=0 cellpadding=0 cellspacing=0 class=bordure1><tr><td>";
  echo "<table cellspacing=1 cellpadding=2 border=0>";
  echo "<tr align=\"center\"><td class=headerliste>$strPseudo</td><td class=headerliste width=120>$strEmailContact</td><td class=headerliste align=\"center\" width=10>$strMSN</td></tr>";
        echo "<tr align=\"center\"><td class=textliste align=center colspan=3>$strNoarbitres</td></tr>"; 
        echo "</table>";
  echo "</td></tr></table>";    
      echo "</td></tr></table>";
}
  
show_consignes($strInscriptionsTournoisArbitre);

echo "<img src=\"images/back.gif\" border=0 align=align=absmiddle> <a href=javascript:back() class=action>$strRetour</a><br>";

?>
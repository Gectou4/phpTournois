# phpTournois (version phpTG4)

CMS libre (GPL v2) d'aide à l'organisation de tournois, surtout de jeux vidéo, en LAN ou en ligne : inscriptions des joueurs et des équipes, matchs et résultats, galerie, shoutbox.

L'intégration de MatchMod (dJeyL.net) et d'AdminBot-MX (neXen.org) permet de lancer et de récupérer directement les matchs Counter-Strike sur les serveurs, avec la carte et les paramètres voulus.

## Historique

| Période | Étape |
|---|---|
| 2001 - 2004 | phpTournois, par Li0n, RV et Gougou |
| 2005 | phpTG4 : version maintenue par Gectou4 |
| 2012 | Import sur GitHub, compatibilité PHP 5.4 |
| 2017 | Portage PHP 7 : `ereg` et `split` remplacés, `mysql` vers `mysqli`, passage en UTF-8, PHPMailer à jour |

## Statut

Le code principal date d'avant 2005. Il fonctionne jusqu'à PHP 7, mais il n'a pas été conçu avec les pratiques de sécurité actuelles. Il est conservé ici comme projet historique : à utiliser de préférence en LAN, sur un réseau fermé.

Piste à l'étude : une réécriture en PHP 8, avec une API séparée de l'interface.

## Installation

1. Créer une base de données MySQL, par exemple `phptournois`.
2. Copier les fichiers dans un dossier web servi par PHP.
3. Ouvrir l'URL du site et suivre l'installation pas à pas.
4. Vérifier que les fichiers d'installation ont bien été supprimés à la fin.

## Équipe

**Développement** : Li0n (code leader), RV (project leader)

**Version phpTG4** : Gectou4

**Bêta-tests** : Killercool, S4ruman, Fatboy

**Contributeurs** : Ben64 (algorithmes), Nono (intégration M4), Florian95 (modules), Gimlur, PsYcO et OlyM4rs (idées et soutien)

## Licence

GNU General Public License v2 ou ultérieure, voir [LICENCE](LICENCE).

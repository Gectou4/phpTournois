/*
   +---------------------------------------------------------------------+
   | phpTournois                                                         |
   +---------------------------------------------------------------------+
   +---------------------------------------------------------------------+
   | phpTournoisG4 �2004 by Gectou4 <le_gardien_prime@hotmail.com>       |
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

function cloturer_inscriptions(strCloturerLesInscriptions) {
	reponse = confirm(strCloturerLesInscriptions);
	
	if (reponse)
		location.href = "?page=tournois&op=cloturer_inscriptions";
}

function valider_poules(strValiderLesPoules) {
	reponse = confirm(strValiderLesPoules);
	
	if (reponse)
		location.href = "?page=tournois&op=valider_poules";
}

function terminer_poules(strTerminerLesPoules) {
	reponse = confirm(strTerminerLesPoules);

	if (reponse)
		location.href = "?page=tournois&op=terminer_poules";
}

function valider_finales(strValiderLesFinales) {
	reponse = confirm(strValiderLesFinales);
	
	if (reponse)
		location.href = "?page=tournois&op=valider_finales";
}

function terminer_tournois(strTerminerLeTournois) {
	reponse = confirm(strTerminerLeTournois);

	if (reponse)
		location.href = "?page=tournois&op=terminer_tournois";
}


function status_tournois(tournois,status,strChangerStatusTournois) {
		reponse = confirm(strChangerStatusTournois);

	if (reponse) 
		location.href = "?page=tournois&op=status&value=" + status + "&id=" + tournois;
	else
		location.href = "?page=tournois&op=admin";
}

function poules_tournois(tournois,poules,strChangerPoules) {
	reponse = confirm(strChangerPoules);
	
	if (reponse) 
		location.href = "?page=tournois&op=poules&value=" + poules + "&id=" + tournois;
}

function alerter(lien,strText) {
	reponse = confirm(strText);
	
	if (reponse) 
		location.href = lien;
}

function finales_winner(tournois,finales,strChangerFinales) {
	reponse = confirm(strChangerFinales);

	if (reponse) 
		location.href = "?page=tournois&op=winner&value=" + finales + "&id=" + tournois;
}

function finales_looser(tournois,finales,strChangerLooser) {
	reponse = confirm(strChangerLooser);

	if (reponse) {
		location.href = "?page=tournois&op=looser&value=" + finales + "&id=" + tournois;
	}
}

function finales_elimination(tournois,finales_type,strChangerElimination) {
	reponse = confirm(strChangerElimination);

	if (reponse) {
		location.href = "?page=tournois&op=elimination&value=" + finales_type + "&id=" + tournois;
	}
}

function status_participe(equipe, status, strChangerStatusParticipe) {
	reponse = confirm(strChangerStatusParticipe);

	if (reponse)
		location.href = "?page=inscriptions&op=status&value=" + status + "&id=" + equipe;
}

function status_joueur(joueur, status, strChangerStatusJoueur) {
	reponse = confirm(strChangerStatusJoueur);

	if (reponse)
		location.href = "?page=joueurs&op=status&value=" + status + "&id=" + joueur;
}
function status_equipe(equipe, status, strChangerStatusEquipe) {
	reponse = confirm(strChangerStatusEquipe);

	if (reponse)
		location.href = "?page=equipes&op=status&value=" + status + "&id=" + equipe;
}

function valider_match() {	
	var str = this.opener.location;
	this.opener.location = str;
	this.close();
	
}

function select_map(map,form,input) {
	var tmpform=eval("this.opener.document."+form);	
	len = tmpform.elements.length;

	for (i = 0 ; i < len ; i++) {
		if(tmpform.elements[i].name == input) {
			break
		}
	}

	tmpform.elements[i].value = map;
	this.close();
}

function select_serveur(serveur,form,input) {
	var tmpform=eval("this.opener.document."+form);	
	len = tmpform.elements.length;

	for (i = 0 ; i < len ; i++) {
		if(tmpform.elements[i].name == input) {
			break
		}
	}

	tmpform.elements[i].value = serveur;
	this.close();
}


function select_avatar_cat(cat,url) {
	location.href = "?page=avatars&op=galerie&cat=" + cat + url + "&header=win";
}


function ouvrir_fenetre(addr,nom,height,width) {

	var top=(screen.height-height)/2;
	var left=(screen.width-width)/2;

	var windowops = eval("'status=no,scrollbars=yes,top=" + top + ",left=" + left + ",height=" + height + ",width=" + width + "'");
	this.open(addr,nom,windowops);
}

function fermer_fenetre() {
	this.close();
}

function back() {
	history.go(-1);
}

function select_all(form) {
	var tmpform=eval("document."+form);
	len = tmpform.elements.length;
	for (i = 0 ; i < len ; i++) {		
		if((tmpform.elements[i].name.indexOf('m4prolongation')==-1) && (tmpform.elements[i].name.indexOf('m4autostart')==-1) && (tmpform.elements[i].name.indexOf('abprolongation')==-1) && (tmpform.elements[i].name.indexOf('abautostart')==-1) && (tmpform.elements[i].name.indexOf('autorecup')==-1)) {
			tmpform.elements[i].checked = true;
		}
	}
}

function unselect_all(form) {
	var tmpform=eval("document."+form);
	len = tmpform.elements.length;
	for (i = 0 ; i < len ; i++) {
		if((tmpform.elements[i].name.indexOf('m4prolongation')==-1) && (tmpform.elements[i].name.indexOf('m4autostart')==-1) && (tmpform.elements[i].name.indexOf('abprolongation')==-1) && (tmpform.elements[i].name.indexOf('abautostart')==-1) && (tmpform.elements[i].name.indexOf('autorecup')==-1)) {
			tmpform.elements[i].checked = false;
		}
	}
}

function alerter(lien,strText) {
reponse = confirm(strText);

if (reponse)
 location.href = lien;
}

/*******************************/
/***** refresh retroproj *******/
/** thx to adminbot code **/

var max_time = 30;
var compteur = 0;

function init_timer()
{
	if(document.forms[0].timer.value == 'checked')
	{
		document.getElementById("timer_status").innerHTML = 'On';
		document.getElementById("timer_status").style.color = '00FF00';
	}
}
function swap_timer()
{
	if(document.forms[0].timer.value == 'checked')
	{
		document.getElementById("timer_status").innerHTML = 'Off';
		document.getElementById("timer_status").style.color = 'CCCCCC';
		document.forms[0].timer.value = '';
		document.getElementById("time_value").innerHTML = '';
	}

	else if(document.forms[0].timer.value == '')
	{
		document.getElementById("timer_status").innerHTML = 'On';
		document.getElementById("timer_status").style.color = '00FF00';
		document.forms[0].timer.value = 'checked';
		compteur = 0;
		document.getElementById("time_value").innerHTML = max_time+'s';
	}
}

function refresh_timer()
{
	var url = '';
	compteur = compteur+1;

	if((document.forms[0].timer.value == 'checked') && (compteur >= max_time))
	{
		url = window.location.href;

		if(url.substring(url.length - 19,url.length) == 'autorefresh=checked') {
				url = url.substring(0,url.length - 20);
		}

		if(url.substring(url.length - 18,url.length) == 'autoscroll=checked') {
				url = url.substring(0,url.length - 19);
		}

		if(url.substring(url.length - 16,url.length) == 'hidemenu=checked') {
				url = url.substring(0,url.length - 17);
		}

		if(url.indexOf("?",0) > 0) {
			if((document.forms[0].menu.value == 'checked') && (document.forms[0].scroll.value == 'checked'))
				window.location.href = url + "&hidemenu=checked&autoscroll=checked&autorefresh=checked";
			else if(document.forms[0].scroll.value == 'checked')
				window.location.href = url + "&autoscroll=checked&autorefresh=checked";
			else if(document.forms[0].menu.value == 'checked')
				window.location.href = url + "&hidemenu=checked&autorefresh=checked";
			else
				window.location.href = url + "&autorefresh=checked";
		}
		else {
			if((document.forms[0].menu.value == 'checked') && (document.forms[0].scroll.value == 'checked'))
				window.location.href = url + "?hidemenu=checked&autoscroll=checked&autorefresh=checked";
			else if(document.forms[0].scroll.value == 'checked')
				window.location.href = url + "?autoscroll=checked&autorefresh=checked";
			else if(document.forms[0].menu.value == 'checked')
				window.location.href = url + "?hidemenu=checked&autorefresh=checked";
			else
				window.location.href = url + "?autorefresh=checked";
		}
			
	}
	else if(document.forms[0].timer.value == 'checked') {
		document.getElementById("time_value").innerHTML = max_time-compteur +'s';
	}
	setTimeout("refresh_timer()",1000);
}


function refresh_recup()
{
	compteur = compteur+1;

	if(compteur >= max_time)
	{
		window.location=window.location;
	}
	document.getElementById("time_value").innerHTML = max_time-compteur +'s'
	setTimeout("refresh_recup()",1000);
}


/*******************************/
/********* scrolling ***********/
var timeout;
var y = 0;
var step = 1;
var sens = 1;

function init_scroll()
{
	if(document.forms[0].scroll.value == 'checked')	{
		document.getElementById("scroll_status").innerHTML = 'On';
		document.getElementById("scroll_status").style.color = '00FF00';
		start_scroll();
	}
}

function swap_scroll() {

	if(document.forms[0].scroll.value == 'checked')	{
		document.getElementById("scroll_status").innerHTML = 'Off';
		document.getElementById("scroll_status").style.color = 'CCCCCC';
		document.forms[0].scroll.value = '';
		stop_scroll();
	}

	else if(document.forms[0].scroll.value == '') {
		document.getElementById("scroll_status").innerHTML = 'On';
		document.getElementById("scroll_status").style.color = '00FF00';
		document.forms[0].scroll.value = 'checked';
		start_scroll();
	}
}

function start_scroll() {
			
	if (document.body.scrollTop == 0) {
		sens = 1;			
	}		
	else if (document.body.scrollTop == document.body.scrollHeight - document.body.clientHeight ) {
		sens = 0;
	}	
		
	if (sens == 1) {
		doScrollDown();
	}
	else {
		doScrollUp();
	}
	
	timeout=setTimeout("start_scroll()",100);
}

function stop_scroll() {
	clearTimeout(timeout);
}

function doScrollUp() {
	y = document.body.scrollTop - step;
	self.scroll(0,y);
}

function doScrollDown() {
	y = document.body.scrollTop + step;
	self.scroll(0,y);
	
}

/*******************************/
/******* show hide menu ********/

function init_menu()
{
	if(document.forms[0].menu.value == 'checked')	{
		document.getElementById("menu_status").innerHTML = 'On';
		document.getElementById("menu_status").style.color = '00FF00';
		hideMenu("menudiv");
		hideMenu("menudiv_d");
	}
}

function swap_menu() {

	if(document.forms[0].menu.value == 'checked')	{
		document.getElementById("menu_status").innerHTML = 'Off';
		document.getElementById("menu_status").style.color = 'CCCCCC';
		document.forms[0].menu.value = '';
		showMenu("menudiv");
		showMenu("menudiv_d");
	}

	else if(document.forms[0].menu.value == '') {
		document.getElementById("menu_status").innerHTML = 'On';
		document.getElementById("menu_status").style.color = '00FF00';
		document.forms[0].menu.value = 'checked';
		hideMenu("menudiv");
		hideMenu("menudiv_d");
	}
}

function showMenu(element){
	document.getElementById(element).style.display="block";
}

function hideMenu(element){
	document.getElementById(element).style.display="none";
}

//var showImg = new Image();showImg.src = "images/show.gif";
//var hideImg = new Image();hideImg.src = "images/hide.gif";

function swapshow(element,img){
	var objDiv = document.getElementById(element).style;	
	var	objImg = document.getElementById(img);
	
	if(objDiv.display=="block") {
		hideMenu(element);
		objImg.src = hideImg.src;
	}
	else {
		showMenu(element);
		objImg.src = showImg.src;
		
	}
}

/*******************************/
/*********** horloge ***********/
// Original:  Ramandeep Singh (ramandeepji@yahoo.com) -- Web Site:  http://hard-drive.hypermart.net
var Digital;
c1 = new Image(); c1.src = "images/clock/1.gif";
c2 = new Image(); c2.src = "images/clock/2.gif";
c3 = new Image(); c3.src = "images/clock/3.gif";
c4 = new Image(); c4.src = "images/clock/4.gif";
c5 = new Image(); c5.src = "images/clock/5.gif";
c6 = new Image(); c6.src = "images/clock/6.gif";
c7 = new Image(); c7.src = "images/clock/7.gif";
c8 = new Image(); c8.src = "images/clock/8.gif";
c9 = new Image(); c9.src = "images/clock/9.gif";
c0 = new Image(); c0.src = "images/clock/0.gif";
cb = new Image(); cb.src = "images/clock/b.gif";
ct = new Image(); cb.src = "images/clock/t.gif";

function extract(h,m,s) {
	if (!document.images.a) return;

	if (h <= 9) {
		document.images.a.src = c0.src;
		document.images.b.src = eval("c"+h+".src");
	}
	else {
		document.images.a.src = eval("c"+Math.floor(h/10)+".src");
		document.images.b.src = eval("c"+(h%10)+".src");
	}
	if (m <= 9) {
		document.images.d.src = c0.src;
		document.images.e.src = eval("c"+m+".src");
	}
	else {
		document.images.d.src = eval("c"+Math.floor(m/10)+".src");
		document.images.e.src = eval("c"+(m%10)+".src");
	}
	if (s <= 9) {
		document.g.src = c0.src;
		document.images.h.src = eval("c"+s+".src");
	}
	else {
		document.images.g.src = eval("c"+Math.floor(s/10)+".src");
		document.images.h.src = eval("c"+(s%10)+".src");
	}
}

function show(datephp) {
	if(!document.images.a) return;
		
	if (datephp) Digital = new Date(datephp);

	var hours = Digital.getHours();
	var minutes = Digital.getMinutes();
	var seconds = Digital.getSeconds();
	Digital.setSeconds( seconds+1 );

	extract(hours, minutes, seconds);

	setTimeout("show()", 1000);
}

function lien_msg(msg,url)
{
	temp = prompt( msg, url );
	return false;
}

//***INFO BULLE***//

var IB=new Object;
var posX=0;posY=0;
var xOffset=10;yOffset=10;
function AffBulle(texte) {
  contenu="<TABLE border=0 cellspacing=0 cellpadding=0 class=\"bordure1\"><TR><TD><TABLE border=0 cellpadding=2 cellspacing=1><TR><TD class=\"text\">"+texte+"</TD></TR></TABLE></TD></TR></TABLE>&nbsp;";
  var finalPosX=posX-xOffset;
  if (finalPosX<0) finalPosX=0;
  if (document.layers) {
    document.layers["bulle"].document.write(contenu);
    document.layers["bulle"].document.close();
    document.layers["bulle"].top=posY+yOffset;
    document.layers["bulle"].left=finalPosX;
    document.layers["bulle"].visibility="show";}
  if (document.all) {
    //var f=window.event;
    //doc=document.body.scrollTop;
    bulle.innerHTML=contenu;
    document.all["bulle"].style.top=posY+yOffset;
    document.all["bulle"].style.left=finalPosX;//f.x-xOffset;
    document.all["bulle"].style.visibility="visible";
  }
  //modif CL 09/2001 - NS6 : celui-ci ne supporte plus document.layers mais document.getElementById
  else if (document.getElementById) {
    document.getElementById("bulle").innerHTML=contenu;
    document.getElementById("bulle").style.top=posY+yOffset;
    document.getElementById("bulle").style.left=finalPosX;
    document.getElementById("bulle").style.visibility="visible";
  }
}
function getMousePos(e) {
  if (document.all) {
  posX=event.x+document.body.scrollLeft; //modifs CL 09/2001 - IE : regrouper l'év�nement
  posY=event.y+document.body.scrollTop;
  }
  else {
  posX=e.pageX; //modifs CL 09/2001 - NS6 : celui-ci ne supporte pas e.x et e.y
  posY=e.pageY; 
  }
}
function HideBulle() {
	if (document.layers) {document.layers["bulle"].visibility="hide";}
	if (document.all) {document.all["bulle"].style.visibility="hidden";}
	else if (document.getElementById){document.getElementById("bulle").style.visibility="hidden";}
}

function InitBulle(ColTexte,ColFond,ColContour,NbPixel) {
	IB.ColTexte=ColTexte;IB.ColFond=ColFond;IB.ColContour=ColContour;IB.NbPixel=NbPixel;
	if (document.layers) {
		window.captureEvents(Event.MOUSEMOVE);window.onMouseMove=getMousePos;
		document.write("<LAYER name='bulle' top=0 left=0 visibility='hide'></LAYER>");
	}
	if (document.all) {
		document.write("<DIV id='bulle' style='position:absolute;top:0;left:0;visibility:hidden'></DIV>");
		document.onmousemove=getMousePos;
	}
	//modif CL 09/2001 - NS6 : celui-ci ne supporte plus document.layers mais document.getElementById
	else if (document.getElementById) {
	        document.onmousemove=getMousePos;
	        document.write("<DIV id='bulle' style='position:absolute;top:0;left:0;visibility:hidden'></DIV>");
	}

}

InitBulle("navy","#FFCC66","orange",1);
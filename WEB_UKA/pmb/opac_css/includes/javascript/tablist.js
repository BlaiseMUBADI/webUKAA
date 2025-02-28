//+-------------------------------------------------+
//© 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
//+-------------------------------------------------+
//$Id: tablist.js,v 1.13 2011-08-19 12:32:41 jpermanne Exp $

//gestion des listes "collapsibles" en Javascript

var imgOpened = new Image();
imgOpened.src = './images/minus.gif';
var imgClosed = new Image();
imgClosed.src = './images/plus.gif';
var expandedDb = '';

//on regarde si le client est DOM-compliant

var isDOM = (typeof(document.getElementsByTagName) != 'undefined') ? 1 : 0;

//Konqueror (support DOM partiel) : on rejette
if(isDOM && typeof(navigator.userAgent) != 'undefined') {
	var browserName = ' ' + navigator.userAgent.toLowerCase();
	if(browserName.indexOf('konqueror') > 0) {
		isDOM = 0;
	}
}

function changeCoverImage(elt) {
	imgs=elt.getElementsByTagName('img');
	for (i=0; i < imgs.length; i++) {
		img=imgs[i];		
		isbn=img.getAttribute('isbn');
		vigurl=img.getAttribute('vigurl');
		url_image=img.getAttribute('url_image');
		if (vigurl) {
			if (img.src.substring(img.src.length-8,img.src.length)=='vide.png') {
				img.src=vigurl;
			}
		} else if (isbn) {
			if (img.src.substring(img.src.length-8,img.src.length)=='vide.png') {
				img.src=url_image.replace(/!!noticecode!!/,isbn);
			}
		}
	}
}

function initIt(){
	if (!isDOM) {
//		alert("ce navigateur n'est pas compatible avec le DOM.");
		return;
	}
	var tempColl    = document.getElementsByTagName('DIV');
	var tempCollCnt = tempColl.length;
	for (var i = 0; i < tempCollCnt; i++) {
		if (tempColl[i].className == 'notice-child') {
			if (tempColl[i].getAttribute('startOpen') == 'Yes' ) {
				expandBase (tempColl[i].id.substring(0,tempColl[i].id.indexOf('Child')), true);
			} else tempColl[i].style.display = 'none';
		}
	}
} // end of the 'initIt()' function

function creeAddthis(el){
	var addthisEl = document.getElementById(el + 'addthis');
	
	var aEl = addthisEl.appendChild(document.createElement("a"));
	var aEl2 = addthisEl.appendChild(document.createElement("a"));
	var aEl3 = addthisEl.appendChild(document.createElement("a"));

	aEl.setAttribute("class","addthis_button_facebook_like");
	aEl.setAttribute("fb:like:layout","button_count");	
	aEl2.setAttribute("class","addthis_button_tweet");	
	aEl3.setAttribute("class","addthis_counter addthis_pill_style");
	//on marque l'élément
	addthisEl.setAttribute("added","1");
} // end of the 'creeAddthis()' function

function ReinitializeAddThis(){
	if(window.addthis){
		window.addthis.ost = 0;
		window.addthis.ready();
	}
}

function expandBase(el, unexpand){
	if (!isDOM)
		return;
	var whichEl = document.getElementById(el + 'Child');
	var whichIm = document.getElementById(el + 'Img');

	if (whichEl.style.display == 'none' && whichIm) {
		if(whichEl.getAttribute("enrichment")){
			getEnrichment(el.replace("el",""));
		} 
		var whichAddthis = document.getElementById(el + 'addthis');
		if (whichAddthis && !whichAddthis.getAttribute("added")){
			creeAddthis(el);
		}
		whichEl.style.display  = 'block';
		whichIm.src            = imgOpened.src;
		changeCoverImage(whichEl);
	}
	else if (unexpand) {
		whichEl.style.display  = 'none';
		whichIm.src            = imgClosed.src;
	}
	ReinitializeAddThis();
} // end of the 'expandBase()' function

function expandAll() {
	var tempColl    = document.getElementsByTagName('DIV');
	var tempCollCnt = tempColl.length;

	for (var i = 0; i < tempCollCnt; i++) {
		if(tempColl[i].className == 'notice-child'){
			tempColl[i].style.display = 'block';
			var el = tempColl[i].getAttribute("id").replace("Child","");
			if (tempColl[i].getAttribute("enrichment")){
				getEnrichment(el.replace("el",""));
			}
			var whichAddthis = document.getElementById(el + 'addthis');
			if (whichAddthis && !whichAddthis.getAttribute("added")){
				creeAddthis(el);
			}
		}
		changeCoverImage(tempColl[i]);
	}
	tempColl    = document.getElementsByTagName('IMG');
	tempCollCnt = tempColl.length;
	for (var i = 0; i < tempCollCnt; i++) {
		if(tempColl[i].name == 'imEx') {
			tempColl[i].src = imgOpened.src;
		}
	}
	ReinitializeAddThis();
}

function collapseAll() {
	var tempColl    = document.getElementsByTagName('DIV');
	var tempCollCnt = tempColl.length;
	for (var i = 0; i < tempCollCnt; i++) {
		if(tempColl[i].className == 'notice-child')
			tempColl[i].style.display = 'none';
	}
	tempColl    = document.getElementsByTagName('IMG');
	tempCollCnt = tempColl.length;
	for (var i = 0; i < tempCollCnt; i++) {
		if(tempColl[i].name == 'imEx') {
			tempColl[i].src = imgClosed.src;
		}
	}
}

onload = initIt;
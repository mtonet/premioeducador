/*
simpleTabs v1.1

Author: Fotis Evangelou (Komrade Ltd.)
License: GNU/GPL v2.0
Credits:
- Peter-Paul Koch for the "Cookies" functions. More on: http://www.quirksmode.org/js/cookies.html
- Simon Willison for the "addLoadEvent" function. More on: http://simonwillison.net/2004/May/26/addLoadEvent/
- Ryan Demmer for pointing to me that IE does not fully support the DOM. More on http://www.joomlacontenteditor.net/
Last updated: December 3rd, 2008

TO DO:
- Enable cookie per tab set
- Enable tab selection via URL anchor

CHANGELOG:
- v1.1: Namespaced the entire script

*/


// Main simpleTabs function

var simpleTabs = {

	init: function(){
		if(!document.getElementsByTagName) return false;
		if(!document.getElementById) return false;
		var containerDiv = document.getElementsByTagName("div");
	
		for(var i=0; i<containerDiv.length; i++){
			if (containerDiv[i].className == "simpleTabs") {
				
				// assign a unique ID for this tab block and then grab it
				containerDiv[i].setAttribute("id","tabber"+[i]);		
				var containerDivId = containerDiv[i].getAttribute("id");
	
				// Navigation
				var ul = containerDiv[i].getElementsByTagName("ul");
				
				for(var j=0; j<ul.length; j++){
					if (ul[j].className == "simpleTabsNavigation") {
	
						var a = ul[j].getElementsByTagName("a");
						for(var k=0; k<a.length; k++){
							a[k].setAttribute("id",containerDivId+"_a_"+k);
							// get current
							if(simpleTabs.readCookie('simpleTabsCookie')){
								var cookieElements = simpleTabs.readCookie('simpleTabsCookie').split("_");
								var curTabCont = cookieElements[1];
								var curAnchor = cookieElements[2];
								if(a[k].parentNode.parentNode.parentNode.getAttribute("id")=="tabber"+curTabCont){
									if(a[k].getAttribute("id")=="tabber"+curTabCont+"_a_"+curAnchor){
										a[k].className = "current";
									} else {
										a[k].className = "";
									}
								} else {
									a[0].className = "current";
								}
							} else {
								a[0].className = "current";
							}
							
							a[k].onclick = function(){
								simpleTabs.setCurrent(this,'simpleTabsCookie');
								return false;
							}
						}
					}
				}
	
				// Tab Content
				var div = containerDiv[i].getElementsByTagName("div");
				for(var l=0; l<div.length; l++){
					if (div[l].className == "simpleTabsContent") {
						div[l].setAttribute("id",containerDivId+"_div_"+[l]);	
						if(simpleTabs.readCookie('simpleTabsCookie')){
							var cookieElements = simpleTabs.readCookie('simpleTabsCookie').split("_");
							var curTabCont = cookieElements[1];
							var curAnchor = cookieElements[2];		
							if(div[l].parentNode.getAttribute("id")=="tabber"+curTabCont){
								if(div[l].getAttribute("id")=="tabber"+curTabCont+"_div_"+curAnchor){
									div[l].className = "simpleTabsContent currentTab";
								} else {
									div[l].className = "simpleTabsContent";
								}
							} else {
								div[0].className = "simpleTabsContent currentTab";
							}
						} else {
							div[0].className = "simpleTabsContent currentTab";
						}
					}
				}	
	
				// End navigation and content block handling	
			}
		}
	},
	
	// Function to set the current tab
	setCurrent: function(elm,cookie){
		
		this.eraseCookie(cookie);
		
		//get container ID
		var thisContainerID = elm.parentNode.parentNode.parentNode.getAttribute("id");
	
		// get current anchor position
		var regExpAnchor = thisContainerID+"_a_";
		//var regExpAnchor=new RegExp(this.parentNode.parentNode.parentNode.getAttribute("id")+"_a_");
		var thisLinkPosition = elm.getAttribute("id").replace(regExpAnchor,"");
	
		// change to clicked anchor
		var otherLinks = elm.parentNode.parentNode.getElementsByTagName("a");
		for(var n=0; n<otherLinks.length; n++){
			otherLinks[n].className = "";
		}
		elm.className = "current";
		
		// change to associated div
		var otherDivs = document.getElementById(thisContainerID).getElementsByTagName("div");
		for(var i=0; i<otherDivs.length; i++){
			if ( /simpleTabsContent/.test(otherDivs[i].className) ) {
				otherDivs[i].className = "simpleTabsContent";
			}
		}
		document.getElementById(thisContainerID+"_div_"+thisLinkPosition).className = "simpleTabsContent currentTab";
	
		// get Tabs container ID
		var thisContainerPosition = thisContainerID.replace(/tabber/,"");
		
		// set cookie
		this.createCookie(cookie,'simpleTabsCookie_'+thisContainerPosition+'_'+thisLinkPosition,1);
	},
	
	// Cookies
	createCookie: function(name,value,days) {
		if (days) {
			var date = new Date();
			date.setTime(date.getTime()+(days*24*60*60*1000));
			var expires = "; expires="+date.toGMTString();
		}
		else var expires = "";
		document.cookie = name+"="+value+expires+"; path=/";
	},
	
	readCookie: function(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
		return null;
	},
	
	eraseCookie: function(name) {
		this.createCookie(name,"",-1);
	},
	
	// Loader
	addLoadEvent: function(func) {
		var oldonload = window.onload;
		if (typeof window.onload != 'function') {
			window.onload = func;
		} else {
			window.onload = function() {
				if (oldonload) {
					oldonload();
				}
				func();
			}
		}
	}
	// END
};

// Load SimpleTabs
simpleTabs.addLoadEvent(simpleTabs.init);

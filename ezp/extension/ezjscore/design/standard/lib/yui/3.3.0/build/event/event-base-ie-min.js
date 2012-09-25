/*
Copyright (c) 2010, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 3.3.0
build: 3167
*/
(function(){var b,f=YUI.Env,d=YUI.config,g=d.doc,c=g&&g.documentElement,e="onreadystatechange",a=d.pollInterval||40;if(c.doScroll&&!f._ieready){f._ieready=function(){f._ready();};
/*! DOMReady: based on work by: Dean Edwards/John Resig/Matthias Miller/Diego Perini */
if(self!==self.top){b=function(){if(g.readyState=="complete"){f.remove(g,e,b);f.ieready();}};f.add(g,e,b);}else{f._dri=setInterval(function(){try{c.doScroll("left");clearInterval(f._dri);f._dri=null;f._ieready();}catch(h){}},a);}}})();YUI.add("event-base-ie",function(c){var a=function(){c.DOM2EventFacade.apply(this,arguments);};c.extend(a,c.DOM2EventFacade,{init:function(){a.superclass.init.apply(this,arguments);var j=this._event,i=c.DOM2EventFacade.resolve,g,m,k,f,l,h;this.target=i(j.srcElement);if(("clientX" in j)&&(!g)&&(0!==g)){g=j.clientX;m=j.clientY;k=c.config.doc;f=k.body;l=k.documentElement;g+=(l.scrollLeft||(f&&f.scrollLeft)||0);m+=(l.scrollTop||(f&&f.scrollTop)||0);this.pageX=g;this.pageY=m;}if(j.type=="mouseout"){h=j.toElement;}else{if(j.type=="mouseover"){h=j.fromElement;}}this.relatedTarget=i(h);if(j.button){switch(j.button){case 2:this.which=3;break;case 4:this.which=2;break;default:this.which=j.button;}this.button=this.which;}},stopPropagation:function(){var d=this._event;d.cancelBubble=true;this._wrapper.stopped=1;this.stopped=1;},stopImmediatePropagation:function(){this.stopPropagation();this._wrapper.stopped=2;this.stopped=2;},preventDefault:function(d){this._event.returnValue=d||false;this._wrapper.prevented=1;this.prevented=1;}});var b=c.config.doc&&c.config.doc.implementation;if(b&&(!b.hasFeature("Events","2.0"))){c.DOMEventFacade=a;}},"3.3.0");

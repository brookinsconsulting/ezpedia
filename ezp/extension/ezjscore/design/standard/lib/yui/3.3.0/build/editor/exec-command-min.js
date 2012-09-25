/*
Copyright (c) 2010, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 3.3.0
build: 3167
*/
YUI.add("exec-command",function(B){var A=function(){A.superclass.constructor.apply(this,arguments);};B.extend(A,B.Base,{_lastKey:null,_inst:null,command:function(F,E){var D=A.COMMANDS[F];if(D){return D.call(this,F,E);}else{return this._command(F,E);}},_command:function(F,E){var D=this.getInstance();try{try{D.config.doc.execCommand("styleWithCSS",null,1);}catch(I){try{D.config.doc.execCommand("useCSS",null,0);}catch(H){}}D.config.doc.execCommand(F,null,E);}catch(G){}},getInstance:function(){if(!this._inst){this._inst=this.get("host").getInstance();}return this._inst;},initializer:function(){B.mix(this.get("host"),{execCommand:function(E,D){return this.exec.command(E,D);},_execCommand:function(E,D){return this.exec._command(E,D);}});this.get("host").on("dom:keypress",B.bind(function(D){this._lastKey=D.keyCode;},this));}},{NAME:"execCommand",NS:"exec",ATTRS:{host:{value:false}},COMMANDS:{wrap:function(F,D){var E=this.getInstance();return(new E.Selection()).wrapContent(D);},inserthtml:function(F,D){var E=this.getInstance();if(E.Selection.hasCursor()||B.UA.ie){return(new E.Selection()).insertContent(D);}else{this._command("inserthtml",D);}},insertandfocus:function(H,E){var G=this.getInstance(),D,F;if(G.Selection.hasCursor()){E+=G.Selection.CURSOR;D=this.command("inserthtml",E);F=new G.Selection();F.focusCursor(true,true);}else{this.command("inserthtml",E);}return D;},insertbr:function(F){var E=this.getInstance(),G,D=new E.Selection();D.setCursor();G=D.getCursor();G.insert("<br>","before");D.focusCursor(true,false);return((G&&G.previous)?G.previous():null);},insertimage:function(E,D){return this.command("inserthtml",'<img src="'+D+'">');},addclass:function(F,D){var E=this.getInstance();return(new E.Selection()).getSelected().addClass(D);},removeclass:function(F,D){var E=this.getInstance();return(new E.Selection()).getSelected().removeClass(D);},forecolor:function(F,G){var E=this.getInstance(),D=new E.Selection(),H;if(!B.UA.ie){this._command("useCSS",false);}if(E.Selection.hasCursor()){if(D.isCollapsed){if(D.anchorNode&&(D.anchorNode.get("innerHTML")==="&nbsp;")){D.anchorNode.setStyle("color",G);H=D.anchorNode;}else{H=this.command("inserthtml",'<span style="color: '+G+'">'+E.Selection.CURSOR+"</span>");D.focusCursor(true,true);}return H;}else{return this._command(F,G);}}else{this._command(F,G);}},backcolor:function(F,G){var E=this.getInstance(),D=new E.Selection(),H;if(B.UA.gecko||B.UA.opera){F="hilitecolor";}if(!B.UA.ie){this._command("useCSS",false);}if(E.Selection.hasCursor()){if(D.isCollapsed){if(D.anchorNode&&(D.anchorNode.get("innerHTML")==="&nbsp;")){D.anchorNode.setStyle("backgroundColor",G);H=D.anchorNode;}else{H=this.command("inserthtml",'<span style="background-color: '+G+'">'+E.Selection.CURSOR+"</span>");D.focusCursor(true,true);}return H;}else{return this._command(F,G);}}else{this._command(F,G);}},hilitecolor:function(){return A.COMMANDS.backcolor.apply(this,arguments);},fontname:function(F,G){this._command("fontname",G);var E=this.getInstance(),D=new E.Selection();if(D.isCollapsed&&(this._lastKey!=32)){if(D.anchorNode.test("font")){D.anchorNode.set("face",G);}}},fontsize:function(F,H){this._command("fontsize",H);var E=this.getInstance(),D=new E.Selection();if(D.isCollapsed&&D.anchorNode&&(this._lastKey!=32)){if(B.UA.webkit){if(D.anchorNode.getStyle("lineHeight")){D.anchorNode.setStyle("lineHeight","");}}if(D.anchorNode.test("font")){D.anchorNode.set("size",H);}else{if(B.UA.gecko){var G=D.anchorNode.ancestor(E.Selection.DEFAULT_BLOCK_TAG);if(G){G.setStyle("fontSize","");}}}}}}});var C=function(I,Q,N){var J=this.getInstance(),O=J.config.doc,G=O.selection.createRange(),F=O.queryCommandValue(I),K,E,H,D,L,P,M;if(F){K=G.htmlText;E=new RegExp(N,"g");H=K.match(E);if(H){K=K.replace(N+";","").replace(N,"");G.pasteHTML('<var id="yui-ie-bs">');D=O.getElementById("yui-ie-bs");L=O.createElement("div");P=O.createElement(Q);L.innerHTML=K;if(D.parentNode!==J.config.doc.body){D=D.parentNode;}M=L.childNodes;D.parentNode.replaceChild(P,D);B.each(M,function(R){P.appendChild(R);});G.collapse();G.moveToElementText(P);G.select();}}this._command(I);};if(B.UA.ie){A.COMMANDS.bold=function(){C.call(this,"bold","b","FONT-WEIGHT: bold");};A.COMMANDS.italic=function(){C.call(this,"italic","i","FONT-STYLE: italic");};A.COMMANDS.underline=function(){C.call(this,"underline","u","TEXT-DECORATION: underline");};}B.namespace("Plugin");B.Plugin.ExecCommand=A;},"3.3.0",{requires:["frame"],skinnable:false});

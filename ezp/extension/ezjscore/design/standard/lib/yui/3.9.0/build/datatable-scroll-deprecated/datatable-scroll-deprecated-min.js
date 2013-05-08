/* YUI 3.9.0 (build 5827) Copyright 2013 Yahoo! Inc. http://yuilibrary.com/license/ */
YUI.add("datatable-scroll-deprecated",function(b){var m=b.Node,k=b.Lang,o=b.UA,g=b.ClassNameManager.getClassName,n="datatable",a=g(n,"hd"),e=g(n,"bd"),d=g(n,"data"),l=g(n,"liner"),j=g(n,"scrollable"),i='<div class="'+a+'"></div>',c='<div class="'+e+'"></div>',h="<table></table>",f=b.cached(function(){var q=b.one("body").appendChild('<div style="position:absolute;visibility:hidden;overflow:scroll;width:20px;"><p style="height:1px"/></div>'),r=q.get("offsetWidth")-q.get("clientWidth");q.remove(true);return r;});function p(){p.superclass.constructor.apply(this,arguments);}b.mix(p,{NS:"scroll",NAME:"dataTableScroll",ATTRS:{width:{value:undefined,writeOnce:"initOnly"},height:{value:undefined,writeOnce:"initOnly"},_scroll:{valueFn:function(){var q=this.get("width"),r=this.get("height");if(q&&r){return"xy";}else{if(q){return"x";}else{if(r){return"y";}else{return null;}}}}},COLOR_COLUMNFILLER:{value:"#f2f2f2",validator:k.isString,setter:function(q){if(this._headerContainerNode){this._headerContainerNode.setStyle("backgroundColor",q);}}}}});b.extend(p,b.Plugin.Base,{_parentTableNode:null,_parentTheadNode:null,_parentTbodyNode:null,_parentMsgNode:null,_parentContainer:null,_bodyContainerNode:null,_headerContainerNode:null,initializer:function(q){var r=this.get("host");this._parentContainer=r.get("contentBox");this._parentContainer.addClass(j);this._setUpNodes();},_setUpNodes:function(){this.afterHostMethod("_addTableNode",this._setUpParentTableNode);this.afterHostMethod("_addTheadNode",this._setUpParentTheadNode);this.afterHostMethod("_addTbodyNode",this._setUpParentTbodyNode);this.afterHostMethod("_addMessageNode",this._setUpParentMessageNode);this.afterHostMethod("renderUI",this.renderUI);this.afterHostMethod("bindUI",this.bindUI);this.afterHostMethod("syncUI",this.syncUI);if(this.get("_scroll")!=="x"){this.afterHostMethod("_attachTheadThNode",this._attachTheadThNode);this.afterHostMethod("_attachTbodyTdNode",this._attachTbodyTdNode);}},_setUpParentTableNode:function(){this._parentTableNode=this.get("host")._tableNode;},_setUpParentTheadNode:function(){this._parentTheadNode=this.get("host")._theadNode;},_setUpParentTbodyNode:function(){this._parentTbodyNode=this.get("host")._tbodyNode;},_setUpParentMessageNode:function(){this._parentMsgNode=this.get("host")._msgNode;},renderUI:function(){this._createBodyContainer();this._createHeaderContainer();this._setContentBoxDimensions();},bindUI:function(){this._bodyContainerNode.on("scroll",b.bind("_onScroll",this));this.afterHostEvent("recordsetChange",this.syncUI);this.afterHostEvent("recordset:recordsChange",this.syncUI);},syncUI:function(){this._removeCaptionNode();this._syncWidths();this._syncScroll();},_removeCaptionNode:function(){this.get("host")._captionNode.remove();},_syncWidths:function(){var t=this._parentContainer.one("."+a),q=this._parentContainer.one("."+e),v=t.all("thead ."+l),u=q.one("."+d+" tr"),s=u&&u.all("."+l),r=(o.ie)?"offsetWidth":"clientWidth";if(s&&s.size()){v.each(function(B,y){var w=s.item(y),x=B.get(r),A=w.get(r),z=Math.max(x,A);z-=(parseInt(B.getComputedStyle("paddingLeft"),10)|0)+(parseInt(B.getComputedStyle("paddingRight"),10)|0);B.setStyle("width",z+"px");w.setStyle("width",z+"px");});}},_attachTheadThNode:function(r){var q=r.column.get("width");if(q){r.th.one("."+l).setStyles({width:q,overflow:"hidden"});}},_attachTbodyTdNode:function(r){var q=r.column.get("width");if(q){r.td.one("."+l).setStyles({width:q,overflow:"hidden"});}},_createBodyContainer:function(){var q=m.create(c);this._bodyContainerNode=q;this._setStylesForTbody();q.appendChild(this._parentTableNode);this._parentContainer.appendChild(q);},_createHeaderContainer:function(){var r=m.create(i),q=m.create(h);this._headerContainerNode=r;this._setStylesForThead();q.appendChild(this._parentTheadNode);r.appendChild(q);this._parentContainer.prepend(r);},_setStylesForTbody:function(){var r=this.get("_scroll"),q=this.get("width")||"",t=this.get("height")||"",s=this._bodyContainerNode,u={width:"",height:t};if(r==="x"){u.overflowY="hidden";u.width=q;}else{if(r==="y"){u.overflowX="hidden";}else{if(r==="xy"){u.width=q;}else{u.overflowX="hidden";u.overflowY="hidden";u.width=q;}}}s.setStyles(u);return s;},_setStylesForThead:function(){var q=this.get("width")||"",r=this._headerContainerNode;r.setStyles({"width":q,"overflow":"hidden"});},_setContentBoxDimensions:function(){if(this.get("_scroll")==="y"||(!this.get("width"))){this._parentContainer.setStyle("width","auto");}},_onScroll:function(){this._headerContainerNode.set("scrollLeft",this._bodyContainerNode.get("scrollLeft"));},_syncScroll:function(){this._syncScrollX();this._syncScrollY();this._syncScrollOverhang();if(o.opera){this._headerContainerNode.set("scrollLeft",this._bodyContainerNode.get("scrollLeft"));if(!this.get("width")){document.body.style+="";}}},_syncScrollY:function(){var q=this._parentTbodyNode,s=this._bodyContainerNode,r;if(!this.get("width")){r=(s.get("scrollHeight")>s.get("clientHeight"))?(q.get("parentNode").get("clientWidth")+f())+"px":(q.get("parentNode").get("clientWidth")+2)+"px";this._parentContainer.setStyle("width",r);}},_syncScrollX:function(){var q=this._parentTbodyNode,s=this._bodyContainerNode,r;this._headerContainerNode.set("scrollLeft",this._bodyContainerNode.get("scrollLeft"));if(!this.get("height")&&(o.ie)){r=(s.get("scrollWidth")>s.get("offsetWidth"))?(q.get("parentNode").get("offsetHeight")+f())+"px":q.get("parentNode").get("offsetHeight")+"px";s.setStyle("height",r);}if(q.get("rows").size()){this._parentMsgNode.get("parentNode").setStyle("width","");}else{this._parentMsgNode.get("parentNode").setStyle("width",this._parentTheadNode.get("parentNode").get("offsetWidth")+"px");}},_syncScrollOverhang:function(){var q=this._bodyContainerNode,r=1;if((q.get("scrollHeight")>q.get("clientHeight"))||(q.get("scrollWidth")>q.get("clientWidth"))){r=18;}this._setOverhangValue(r);if(o.ie!==0&&this.get("_scroll")==="y"&&this._bodyContainerNode.get("scrollHeight")>this._bodyContainerNode.get("offsetHeight")){this._headerContainerNode.setStyle("width",this._parentContainer.get("width"));
}},_setOverhangValue:function(r){var t=this.get("host"),v=t.get("columnset").get("definitions"),q=v.length,u=r+"px solid "+this.get("COLOR_COLUMNFILLER"),s=m.all("#"+this._parentContainer.get("id")+" ."+a+" table thead th");s.item(q-1).setStyle("borderRight",u);}});b.namespace("Plugin").DataTableScroll=p;},"3.9.0",{requires:["datatable-base-deprecated","plugin"]});

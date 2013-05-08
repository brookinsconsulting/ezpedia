/* YUI 3.9.0 (build 5827) Copyright 2013 Yahoo! Inc. http://yuilibrary.com/license/ */
YUI.add("series-candlestick",function(e,t){function n(){n.superclass.constructor.apply(this,arguments)}n.NAME="candlestickSeries",n.ATTRS={type:{value:"candlestick"},graphic:{lazyAdd:!1,setter:function(e){return this.get("rendered")||this.set("rendered",!0),this.set("upcandle",e.addShape({type:"path"})),this.set("downcandle",e.addShape({type:"path"})),this.set("wick",e.addShape({type:"path"})),e}},upcandle:{},downcandle:{},wick:{}},e.extend(n,e.RangeSeries,{_drawMarkers:function(e,t,n,r,s,o,u,a,f){var l=this.get("upcandle"),c=this.get("downcandle"),h=this.get("wick"),p,d,v,m,g,y,b,w,E,S=f.padding.left,x;l.set(f.upcandle),c.set(f.downcandle),h.set(f.wick),l.clear(),c.clear(),h.clear();for(i=0;i<o;i+=1)p=e[i]+S,y=p-a,b=p+a,d=t[i],v=n[i],m=r[i],g=s[i],x=d>g,w=x?g:d,E=x?d:g,height=E-w,candle=x?l:c,candle.drawRect(y,w,u,height),h.moveTo(p,v),h.lineTo(p,m);l.end(),c.end(),h.end(),h.toBack()},_toggleVisible:function(e){this.get("upcandle").set("visible",e),this.get("downcandle").set("visible",e),this.get("wick").set("visible",e)},destructor:function(){var e=this.get("upcandle"),t=this.get("downcandle"),n=this.get("wick");e&&e.destroy(),t&&t.destroy(),n&&n.destroy()},_getDefaultStyles:function(){var e={upcandle:{fill:{color:"#00aa00",alpha:1},stroke:{color:"#000000",alpha:1,weight:0}},downcandle:{fill:{color:"#aa0000",alpha:1},stroke:{color:"#000000",alpha:1,weight:0}},wick:{stroke:{color:"#000000",alpha:1,weight:1}}};return this._mergeStyles(e,n.superclass._getDefaultStyles())}}),e.CandlestickSeries=n},"3.9.0",{requires:["series-range"]});

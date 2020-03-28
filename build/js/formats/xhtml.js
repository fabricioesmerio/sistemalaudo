/* SCEditor v2.1.2 | (C) 2017, Sam Clarke | sceditor.com/license */

!function(t){"use strict";function e(){function i(e,n,i){var r,a=i.createElement("div");return a.innerHTML=n,o(a,"visibility","hidden"),i.body.appendChild(a),l(a),f(a),h(a),e||x(a),r=(new t.XHTMLSerializer).serialize(a,!0),i.body.removeChild(a),r}function r(t,e){m[t]&&m[t].forEach(function(n){n.tags[t]?u(n.tags[t],function(t,i){e.getAttributeNode&&(!(t=e.getAttributeNode(t))||i&&i.indexOf(t.value)<0||n.conv.call(p,e))}):n.conv&&n.conv.call(p,e)})}function l(t){n.traverse(t,function(t){var e=t.nodeName.toLowerCase();r("*",t),r(e,t)},!0)}function c(t,i){var o,r=t.childNodes,l=t.nodeName.toLowerCase(),s=t.nodeValue,u=r.length,d=e.allowedEmptyTags||[];if(i&&"br"===l)return!0;if(a(t,".sceditor-ignore"))return!0;if(d.indexOf(l)>-1||"td"===l||!n.canHaveChildren(t))return!1;if(s&&/\S|\u00A0/.test(s))return!1;for(;u--;)if(!c(r[u],i&&!t.previousSibling&&!t.nextSibling))return!1;return!t.getBoundingClientRect||!t.className&&!t.hasAttributes("style")||(!(o=t.getBoundingClientRect()).width||!o.height)}function f(t){n.traverse(t,function(i){var o,r=i.nodeName.toLowerCase(),a=i.parentNode,l=i.nodeType,s=!n.isInline(i),u=i.previousSibling,d=i.nextSibling,f=a===t,g=!u&&!d,v="iframe"!==r&&c(i,f&&g&&"br"!==r),x=i.ownerDocument,h=e.allowedTags,p=e.disallowedTags;if(3!==l&&(4===l?r="!cdata":"!"!==r&&8!==l||(r="!comment"),v?o=!0:h&&h.length?o=h.indexOf(r)<0:p&&p.length&&(o=p.indexOf(r)>-1),o)){if(!v){for(s&&u&&n.isInline(u)&&a.insertBefore(x.createTextNode(" "),i);i.firstChild;)a.insertBefore(i.firstChild,d);s&&d&&n.isInline(d)&&a.insertBefore(x.createTextNode(" "),d)}a.removeChild(i)}},!0)}function v(t,e){var n={};return t&&s(n,t),e?(u(e,function(t,e){Array.isArray(e)?n[t]=(n[t]||[]).concat(e):n[t]||(n[t]=null)}),n):n}function x(t){n.removeWhiteSpace(t);for(var e,i,o=t.firstChild;o;)i=o.nextSibling,n.isInline(o)&&!a(o,".sceditor-ignore")?(e||(e=t.ownerDocument.createElement("p"),o.parentNode.insertBefore(e,o)),e.appendChild(o)):e=null,o=i}function h(t){var i,o,r,a,l,c,s=e.allowedAttribs,u=s&&!d(s),f=e.disallowedAttribs,g=f&&!d(f);b={},n.traverse(t,function(t){if(t.attributes&&(i=t.nodeName.toLowerCase(),a=t.attributes.length))for(b[i]||(b[i]=u?v(s["*"],s[i]):v(f["*"],f[i]));a--;)o=t.attributes[a],r=o.name,l=b[i][r],c=!1,u?c=null!==l&&(!Array.isArray(l)||l.indexOf(o.value)<0):g&&(c=null===l||Array.isArray(l)&&l.indexOf(o.value)>-1),c&&t.removeAttribute(r)})}var p=this,m={},b={};p.init=function(){d(e.converters||{})||u(e.converters,function(t,e){u(e.tags,function(t){m[t]||(m[t]=[]),m[t].push(e)})}),this.commands=s(!0,{},g,this.commands)},p.toSource=i.bind(null,!1),p.fragmentToSource=i.bind(null,!0)}var n=t.dom,i=t.utils,o=n.css,r=n.attr,a=n.is,l=n.removeAttr,c=n.convertElement,s=i.extend,u=i.each,d=i.isEmptyObject,f=t.command.get,g={bold:{txtExec:["<strong>","</strong>"]},italic:{txtExec:["<em>","</em>"]},underline:{txtExec:['<span style="text-decoration:underline;">',"</span>"]},strike:{txtExec:['<span style="text-decoration:line-through;">',"</span>"]},subscript:{txtExec:["<sub>","</sub>"]},superscript:{txtExec:["<sup>","</sup>"]},left:{txtExec:['<div style="text-align:left;">',"</div>"]},center:{txtExec:['<div style="text-align:center;">',"</div>"]},right:{txtExec:['<div style="text-align:right;">',"</div>"]},justify:{txtExec:['<div style="text-align:justify;">',"</div>"]},font:{txtExec:function(t){var e=this;f("font")._dropDown(e,t,function(t){e.insertText('<span style="font-family:'+t+';">',"</span>")})}},size:{txtExec:function(t){var e=this;f("size")._dropDown(e,t,function(t){e.insertText('<span style="font-size:'+t+';">',"</span>")})}},color:{txtExec:function(t){var e=this;f("color")._dropDown(e,t,function(t){e.insertText('<span style="color:'+t+';">',"</span>")})}},bulletlist:{txtExec:["<ul><li>","</li></ul>"]},orderedlist:{txtExec:["<ol><li>","</li></ol>"]},table:{txtExec:["<table><tr><td>","</td></tr></table>"]},horizontalrule:{txtExec:["<hr />"]},code:{txtExec:["<code>","</code>"]},image:{txtExec:function(t,e){var n=this;f("image")._dropDown(n,t,e,function(t,e,i){var o="";e&&(o+=' width="'+e+'"'),i&&(o+=' height="'+i+'"'),n.insertText("<img"+o+' src="'+t+'" />')})}},email:{txtExec:function(t,e){var n=this;f("email")._dropDown(n,t,function(t,i){n.insertText('<a href="mailto:'+t+'">'+(i||e||t)+"</a>")})}},link:{txtExec:function(t,e){var n=this;f("link")._dropDown(n,t,function(t,i){n.insertText('<a href="'+t+'">'+(i||e||t)+"</a>")})}},quote:{txtExec:["<blockquote>","</blockquote>"]},youtube:{txtExec:function(t){var e=this;f("youtube")._dropDown(e,t,function(t,n){e.insertText('<iframe width="560" height="315" src="https://www.youtube.com/embed/{id}?wmode=opaque&start='+n+'" data-youtube-id="'+t+'" frameborder="0" allowfullscreen></iframe>')})}},rtl:{txtExec:['<div stlye="direction:rtl;">',"</div>"]},ltr:{txtExec:['<div stlye="direction:ltr;">',"</div>"]}};t.XHTMLSerializer=function(){function t(t){var e={"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;"," ":"&nbsp;"};return t?t.replace(/[&<>"\xa0]/g,function(t){return e[t]||t}):""}function e(t){return t.replace(/[\r\n]/," ").replace(/[^\S|\u00A0]+/g," ")}function i(t,e){switch(t.nodeType){case 1:"!"===t.nodeName.toLowerCase()?s(t):l(t,e);break;case 3:u(t,e);break;case 4:c(t);break;case 8:s(t);break;case 9:case 11:r(t)}}function r(t){for(var e=t.firstChild;e;)i(e),e=e.nextSibling}function l(e,r){var l,c,s,u=e.nodeName.toLowerCase(),g="iframe"===u,v=e.attributes.length,h=e.firstChild,p=r||/pre(?:\-wrap)?$/i.test(o(e,"whiteSpace")),m=!e.firstChild&&!n.canHaveChildren(e)&&!g;if(!a(e,".sceditor-ignore")){for(d("<"+u,!r&&f(e));v--;)s=(c=e.attributes[v]).value,d(" "+c.name.toLowerCase()+'="'+t(s)+'"',!1);for(d(m?" />":">",!1),g||(l=h);l;)x++,i(l,p),l=l.nextSibling,x--;m||d("</"+u+">",!p&&!g&&f(e)&&h&&f(h))}}function c(e){d("<![CDATA["+t(e.nodeValue)+"]]>")}function s(e){d("\x3c!-- "+t(e.nodeValue)+" --\x3e")}function u(n,i){var o=n.nodeValue;i||(o=e(o)),o&&d(t(o),!i&&f(n))}function d(t,e){var n=x;if(!1!==e)for(v.length&&v.push("\n");n--;)v.push(g.indentStr);v.push(t)}function f(t){var e=t.previousSibling;return 1!==t.nodeType&&e?!n.isInline(e):!e&&!n.isInline(t.parentNode)||!n.isInline(t)}var g={indentStr:"\t"},v=[],x=0;this.serialize=function(t,e){if(v=[],e)for(t=t.firstChild;t;)i(t),t=t.nextSibling;else i(t);return v.join("")}},e.converters=[{tags:{"*":{width:null}},conv:function(t){o(t,"width",r(t,"width")),l(t,"width")}},{tags:{"*":{height:null}},conv:function(t){o(t,"height",r(t,"height")),l(t,"height")}},{tags:{li:{value:null}},conv:function(t){l(t,"value")}},{tags:{"*":{text:null}},conv:function(t){o(t,"color",r(t,"text")),l(t,"text")}},{tags:{"*":{color:null}},conv:function(t){o(t,"color",r(t,"color")),l(t,"color")}},{tags:{"*":{face:null}},conv:function(t){o(t,"fontFamily",r(t,"face")),l(t,"face")}},{tags:{"*":{align:null}},conv:function(t){o(t,"textAlign",r(t,"align")),l(t,"align")}},{tags:{"*":{border:null}},conv:function(t){o(t,"borderWidth",r(t,"border")),l(t,"border")}},{tags:{applet:{name:null},img:{name:null},layer:{name:null},map:{name:null},object:{name:null},param:{name:null}},conv:function(t){r(t,"id")||r(t,"id",r(t,"name")),l(t,"name")}},{tags:{"*":{vspace:null}},conv:function(t){o(t,"marginTop",r(t,"vspace")-0),o(t,"marginBottom",r(t,"vspace")-0),l(t,"vspace")}},{tags:{"*":{hspace:null}},conv:function(t){o(t,"marginLeft",r(t,"hspace")-0),o(t,"marginRight",r(t,"hspace")-0),l(t,"hspace")}},{tags:{hr:{noshade:null}},conv:function(t){o(t,"borderStyle","solid"),l(t,"noshade")}},{tags:{"*":{nowrap:null}},conv:function(t){o(t,"whiteSpace","nowrap"),l(t,"nowrap")}},{tags:{big:null},conv:function(t){o(c(t,"span"),"fontSize","larger")}},{tags:{small:null},conv:function(t){o(c(t,"span"),"fontSize","smaller")}},{tags:{b:null},conv:function(t){c(t,"strong")}},{tags:{u:null},conv:function(t){o(c(t,"span"),"textDecoration","underline")}},{tags:{s:null,strike:null},conv:function(t){o(c(t,"span"),"textDecoration","line-through")}},{tags:{dir:null},conv:function(t){c(t,"ul")}},{tags:{center:null},conv:function(t){o(c(t,"div"),"textAlign","center")}},{tags:{font:{size:null}},conv:function(t){o(t,"fontSize",o(t,"fontSize")),l(t,"size")}},{tags:{font:null},conv:function(t){c(t,"span")}},{tags:{"*":{type:["_moz"]}},conv:function(t){l(t,"type")}},{tags:{"*":{_moz_dirty:null}},conv:function(t){l(t,"_moz_dirty")}},{tags:{"*":{_moz_editor_bogus_node:null}},conv:function(t){t.parentNode.removeChild(t)}}],e.allowedAttribs={},e.disallowedAttribs={},e.allowedTags=[],e.disallowedTags=[],e.allowedEmptyTags=[],t.formats.xhtml=e}(sceditor);
!function(t){var e={};function n(o){if(e[o])return e[o].exports;var a=e[o]={i:o,l:!1,exports:{}};return t[o].call(a.exports,a,a.exports,n),a.l=!0,a.exports}n.m=t,n.c=e,n.d=function(t,e,o){n.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:o})},n.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},n.t=function(t,e){if(1&e&&(t=n(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var o=Object.create(null);if(n.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var a in t)n.d(o,a,function(e){return t[e]}.bind(null,a));return o},n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="",n(n.s=21)}([function(t,e){t.exports=window.wp.i18n},function(t,e){t.exports=window.regeneratorRuntime},function(t,e,n){"use strict";n.d(e,"d",(function(){return r})),n.d(e,"e",(function(){return i})),n.d(e,"b",(function(){return s})),n.d(e,"a",(function(){return c})),n.d(e,"c",(function(){return l}));var o=n(4),a=n.n(o),r=function(t){document.querySelectorAll(".gpalab-slo-tab-button").forEach((function(e){e.id==="gpalab-slo-tab-".concat(t)?(e.focus(),e.setAttribute("aria-selected","true"),e.removeAttribute("tabindex")):(e.removeAttribute("aria-selected"),e.setAttribute("tabindex","-1"))})),document.querySelectorAll(".gpalab-slo-tabpanel").forEach((function(e){e.id==="gpalab-slo-settings-".concat(t)?e.style.display="flex":e.style.display="none"}))},i=function(t){var e=document.querySelectorAll(".gpalab-slo-tab-button");if(null!==t)switch(t){case-1:r(e[e.length-1].dataset.id);break;case e.length:r(e[0].dataset.id);break;default:r(e[t].dataset.id)}},s=function(t){var e=document.querySelectorAll(".gpalab-slo-tab-button"),n=document.querySelectorAll(".gpalab-slo-tabpanel");if(0!==e.length&&0!==n.length){var o=t>=e.length?0:t,r=a()(e);r.splice(o,1),e[o].setAttribute("aria-selected","true"),n[o].style.display="flex",r.forEach((function(t){t.setAttribute("tabindex","-1")}))}},c=function(){var t=window.location.hash,e=/(gpalab-slo-tab-[0-9]*)/g,n=t.match(e)?t.match(e)[0]:null;return n?n.replace("gpalab-slo-tab-",""):0},l=function(t){var e=window.location,n=e.origin,o=e.pathname,a=e.search;window.location.href="".concat(n).concat(o).concat(a,"#gpalab-slo-tab-").concat(t),window.location.reload()}},function(t,e){function n(t,e,n,o,a,r,i){try{var s=t[r](i),c=s.value}catch(t){return void n(t)}s.done?e(c):Promise.resolve(c).then(o,a)}t.exports=function(t){return function(){var e=this,o=arguments;return new Promise((function(a,r){var i=t.apply(e,o);function s(t){n(i,a,r,s,c,"next",t)}function c(t){n(i,a,r,s,c,"throw",t)}s(void 0)}))}},t.exports.default=t.exports,t.exports.__esModule=!0},function(t,e,n){var o=n(8),a=n(9),r=n(10),i=n(11);t.exports=function(t){return o(t)||a(t)||r(t)||i()},t.exports.default=t.exports,t.exports.__esModule=!0},function(t,e){t.exports=function(t,e){(null==e||e>t.length)&&(e=t.length);for(var n=0,o=new Array(e);n<e;n++)o[n]=t[n];return o},t.exports.default=t.exports,t.exports.__esModule=!0},,function(t,e,n){"use strict";n.d(e,"a",(function(){return c})),n.d(e,"b",(function(){return l})),n.d(e,"c",(function(){return d})),n.d(e,"d",(function(){return u})),n.d(e,"e",(function(){return p}));var o=n(3),a=n.n(o),r=n(1),i=n.n(r),s=n(2),c=function(){var t=a()(i.a.mark((function t(e){var n,o,a,r,c;return i.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return o=(null===(n=window)||void 0===n?void 0:n.gpalabSloAdmin)||{},(a=new FormData).append("action","gpalab_add_slo_mission"),a.append("security",o.sloNonce),t.prev=4,t.next=7,fetch(o.ajaxUrl,{method:"POST",body:a});case 7:return r=t.sent,t.next=10,r.json();case 10:c=t.sent,console.log(c),Object(s.c)(e),t.next=18;break;case 15:t.prev=15,t.t0=t.catch(4),console.error(t.t0);case 18:case"end":return t.stop()}}),t,null,[[4,15]])})));return function(_x){return t.apply(this,arguments)}}(),l=function(){var t=a()(i.a.mark((function t(e,n){var o,a,r,c,l;return i.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return a=(null===(o=window)||void 0===o?void 0:o.gpalabSloAdmin)||{},(r=new FormData).append("action","gpalab_remove_slo_mission"),r.append("security",a.sloNonce),r.append("mission_id",e),t.prev=5,t.next=8,fetch(a.ajaxUrl,{method:"POST",body:r});case 8:return c=t.sent,t.next=11,c.json();case 11:l=t.sent,console.log(l),Object(s.c)(n),t.next=19;break;case 16:t.prev=16,t.t0=t.catch(5),console.error(t.t0);case 19:case"end":return t.stop()}}),t,null,[[5,16]])})));return function(e,n){return t.apply(this,arguments)}}(),d=function(){var t=a()(i.a.mark((function t(e){var n,o,a,r,s;return i.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return o=(null===(n=window)||void 0===n?void 0:n.gpalabSloDashboard)||{},(a=new FormData).append("action","gpalab_slo_user_mission"),a.append("security",o.dashNonce),a.append("mission_id",e),a.append("user_id",o.currentUser),t.prev=6,t.next=9,fetch(o.ajaxUrl,{method:"POST",body:a});case 9:return r=t.sent,t.next=12,r.json();case 12:s=t.sent,console.log(s),window.location.reload(),t.next=20;break;case 17:t.prev=17,t.t0=t.catch(6),console.error(t.t0);case 20:case"end":return t.stop()}}),t,null,[[6,17]])})));return function(e){return t.apply(this,arguments)}}(),u=function(){var t=a()(i.a.mark((function t(e,n,o){var a,r,c,l,d;return i.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return r=(null===(a=window)||void 0===a?void 0:a.gpalabSloAdmin)||{},(c=new FormData).append("action","gpalab_update_slo_page_title"),c.append("security",r.sloNonce),c.append("post_id",e),c.append("title",n),t.prev=6,t.next=9,fetch(r.ajaxUrl,{method:"POST",body:c});case 9:return l=t.sent,t.next=12,l.json();case 12:d=t.sent,console.log(d),Object(s.c)(o),t.next=20;break;case 17:t.prev=17,t.t0=t.catch(6),console.error(t.t0);case 20:case"end":return t.stop()}}),t,null,[[6,17]])})));return function(e,n,o){return t.apply(this,arguments)}}(),p=function(){var t=a()(i.a.mark((function t(e,n,o,a){var r,c,l,d,u;return i.a.wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return c=(null===(r=window)||void 0===r?void 0:r.gpalabSloAdmin)||{},(l=new FormData).append("action","gpalab_update_slo_permalink"),l.append("security",c.sloNonce),l.append("permalink",o),l.append("post_id",e),l.append("title",n),t.prev=7,t.next=10,fetch(c.ajaxUrl,{method:"POST",body:l});case 10:return d=t.sent,t.next=13,d.json();case 13:u=t.sent,console.log(u),Object(s.c)(a),t.next=21;break;case 18:t.prev=18,t.t0=t.catch(7),console.error(t.t0);case 21:case"end":return t.stop()}}),t,null,[[7,18]])})));return function(e,n,o,a){return t.apply(this,arguments)}}()},function(t,e,n){var o=n(5);t.exports=function(t){if(Array.isArray(t))return o(t)},t.exports.default=t.exports,t.exports.__esModule=!0},function(t,e){t.exports=function(t){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(t))return Array.from(t)},t.exports.default=t.exports,t.exports.__esModule=!0},function(t,e,n){var o=n(5);t.exports=function(t,e){if(t){if("string"==typeof t)return o(t,e);var n=Object.prototype.toString.call(t).slice(8,-1);return"Object"===n&&t.constructor&&(n=t.constructor.name),"Map"===n||"Set"===n?Array.from(t):"Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)?o(t,e):void 0}},t.exports.default=t.exports,t.exports.__esModule=!0},function(t,e){t.exports=function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")},t.exports.default=t.exports,t.exports.__esModule=!0},,,,,,,,,,function(t,e,n){"use strict";n.r(e);var o=n(2),a=n(4),r=n.n(a),i=n(0),s=['a[href]:not([tabindex^="-"])','area[href]:not([tabindex^="-"])','input:not([type="hidden"]):not([type="radio"]):not([disabled]):not([tabindex^="-"])','input[type="radio"]:not([disabled]):not([tabindex^="-"]):checked','select:not([disabled]):not([tabindex^="-"])','textarea:not([disabled]):not([tabindex^="-"])','button:not([disabled]):not([tabindex^="-"])','iframe:not([tabindex^="-"])','audio[controls]:not([tabindex^="-"])','video[controls]:not([tabindex^="-"])','[contenteditable]:not([tabindex^="-"])','[tabindex]:not([tabindex^="-"])'];function c(t){this._show=this.show.bind(this),this._hide=this.hide.bind(this),this._maintainFocus=this._maintainFocus.bind(this),this._bindKeypress=this._bindKeypress.bind(this),this.$el=t,this.shown=!1,this._id=this.$el.getAttribute("data-a11y-dialog")||this.$el.id,this._previouslyFocused=null,this._listeners={},this.create()}function l(t,e){return n=(e||document).querySelectorAll(t),Array.prototype.slice.call(n);var n}function d(t){var e=u(t),n=t.querySelector("[autofocus]")||e[0];n&&n.focus()}function u(t){return l(s.join(","),t).filter((function(t){return!!(t.offsetWidth||t.offsetHeight||t.getClientRects().length)}))}function p(){l("[data-a11y-dialog]").forEach((function(t){new c(t)}))}c.prototype.create=function(){return this.$el.setAttribute("aria-hidden",!0),this.$el.setAttribute("aria-modal",!0),this.$el.hasAttribute("role")||this.$el.setAttribute("role","dialog"),this._openers=l('[data-a11y-dialog-show="'+this._id+'"]'),this._openers.forEach(function(t){t.addEventListener("click",this._show)}.bind(this)),this._closers=l("[data-a11y-dialog-hide]",this.$el).concat(l('[data-a11y-dialog-hide="'+this._id+'"]')),this._closers.forEach(function(t){t.addEventListener("click",this._hide)}.bind(this)),this._fire("create"),this},c.prototype.show=function(t){return this.shown||(this._previouslyFocused=document.activeElement,this.$el.removeAttribute("aria-hidden"),this.shown=!0,d(this.$el),document.body.addEventListener("focus",this._maintainFocus,!0),document.addEventListener("keydown",this._bindKeypress),this._fire("show",t)),this},c.prototype.hide=function(t){return this.shown?(this.shown=!1,this.$el.setAttribute("aria-hidden","true"),this._previouslyFocused&&this._previouslyFocused.focus&&this._previouslyFocused.focus(),document.body.removeEventListener("focus",this._maintainFocus,!0),document.removeEventListener("keydown",this._bindKeypress),this._fire("hide",t),this):this},c.prototype.destroy=function(){return this.hide(),this._openers.forEach(function(t){t.removeEventListener("click",this._show)}.bind(this)),this._closers.forEach(function(t){t.removeEventListener("click",this._hide)}.bind(this)),this._fire("destroy"),this._listeners={},this},c.prototype.on=function(t,e){return void 0===this._listeners[t]&&(this._listeners[t]=[]),this._listeners[t].push(e),this},c.prototype.off=function(t,e){var n=(this._listeners[t]||[]).indexOf(e);return n>-1&&this._listeners[t].splice(n,1),this},c.prototype._fire=function(t,e){(this._listeners[t]||[]).forEach(function(t){t(this.$el,e)}.bind(this))},c.prototype._bindKeypress=function(t){this.$el.contains(document.activeElement)&&(this.shown&&27===t.which&&"alertdialog"!==this.$el.getAttribute("role")&&(t.preventDefault(),this.hide(t)),this.shown&&9===t.which&&function(t,e){var n=u(t),o=n.indexOf(document.activeElement);e.shiftKey&&0===o?(n[n.length-1].focus(),e.preventDefault()):e.shiftKey||o!==n.length-1||(n[0].focus(),e.preventDefault())}(this.$el,t))},c.prototype._maintainFocus=function(t){!this.shown||t.target.closest('[aria-modal="true"]')||t.target.closest("[data-a11y-dialog-ignore-focus-trap]")||d(this.$el)},"undefined"!=typeof document&&("loading"===document.readyState?document.addEventListener("DOMContentLoaded",p):window.requestAnimationFrame?window.requestAnimationFrame(p):window.setTimeout(p,16));var f=c,h=n(7),b=function(t,e,n){var o=document.getElementById("slo-avatar-".concat(n)),a=document.getElementById("slo-avatar-preview-".concat(n)),r=document.getElementById("slo-avatar-placeholder-".concat(n)),s=o.value!=e;a&&s&&(a.style.display="none"),r&&t?(s&&(r.style.display="block"),r.innerText=t):r&&(r.style.display="block",r.innerText=Object(i.__)("No avatar added","gpalab-slo")),o.value=e,document.getElementById("slo-avatar-manager-".concat(n)).value=t?Object(i.__)("Change avatar image","gpalab-slo"):Object(i.__)("Select an avatar image","gpalab-slo"),document.getElementById("slo-avatar-remove-".concat(n)).style.display=t?"block":"none"},v=function(){var t=document.querySelectorAll(".gpalab-slo-tab-button");t.forEach((function(t){t.addEventListener("click",(function(t){t.preventDefault();var e=t.target.dataset.id;Object(o.d)(e)}))})),t.forEach((function(t,e){t.addEventListener("keydown",(function(t){switch(t.which){case 37:Object(o.e)(e-1);break;case 39:Object(o.e)(e+1);break;case 40:t.preventDefault(),document.getElementById("title_".concat(e)).focus();break;default:return null}}))})),document.getElementById("slo-add-mission").addEventListener("click",(function(){Object(h.a)(t.length)}));var e=document.querySelectorAll(".slo-remove-mission"),n=document.getElementById("gpalab-slo-removal-confirmation-dialog"),a=document.getElementById("gpalab-slo-dialog-title");e.forEach((function(e){e.addEventListener("click",(function(e){var o=e.target.dataset.id,s=r()(t).filter((function(t){return void 0!==t.attributes["aria-selected"]})),c=s[0].dataset.id,l=c>0?c-1:0,d="Are you sure you want to delete the ".concat(s[0].innerText," page?");a.textContent=Object(i.__)(d,"gpalab-slo"),n.dataset.id=o,n.dataset.idxafter=l}))}));var s=new f(n,"#wpwrap");document.getElementById("remove-affirmative").addEventListener("click",(function(){var t=n.dataset,e=t.id,o=t.idxafter;Object(h.b)(e,o),s.hide()})),s.on("show",(function(){document.documentElement.style.overflow="hidden"})),s.on("hide",(function(){document.documentElement.removeAttribute("style")})),document.querySelectorAll(".slo-submit").forEach((function(t,e){t.addEventListener("click",(function(t){var n=t.target.dataset.post,o=document.getElementById("title_".concat(e));Object(h.d)(n,o.value,e)}))})),document.querySelectorAll(".slo-permalink").forEach((function(t,e){t.addEventListener("click",(function(t){var n=t.target.dataset,o=n.id,a=n.post,r=n.title,i=document.getElementById("permalink-".concat(o));Object(h.e)(a,r,i.value,e)}))})),document.querySelectorAll(".gpalab-slo-avatar-media-manager").forEach((function(t){t.addEventListener("click",(function(t){!function(t,e){t.preventDefault();var n,o=window.wp.media;n&&n.open(),(n=o({button:{text:Object(i.__)("Use as mission avatar","gpalab-slo")},library:{type:"image"},multiple:!1,title:Object(i.__)("Add an avatar","gpalab-slo")})).on("close",(function(){return function(t,e){var n,o,a=t.state().get("selection").first(),r=null==a||null===(n=a.attributes)||void 0===n?void 0:n.filename,i=null==a||null===(o=a.attributes)||void 0===o?void 0:o.id;b(r,i,e)}(n,e)})),n.on("open",(function(){return function(t,e){var n=document.getElementById("slo-avatar-".concat(e)),o=t.state().get("selection");if(n.value&&"undefined"!==n.value){var a=window.wp.media.attachment(n.value);a.fetch(),o.add(a?[a]:[])}else o.add([])}(n,e)})),n.open()}(t,t.target.dataset.id)}))})),document.querySelectorAll(".gpalab-slo-avatar-remove").forEach((function(t){t.addEventListener("click",(function(t){var e;e=t.target.dataset.id,b("","",e)}))}))},m=function(t){var e=document.createElement("button"),n="remove-affirmative",o="primary",a="Yes, delete";return"cancel"===t&&(n="remove-cancel",o="secondary",a="No, cancel",e.setAttribute("data-a11y-dialog-hide","")),e.setAttribute("type","button"),e.setAttribute("id",n),e.setAttribute("class","button button-".concat(o)),e.textContent=Object(i.__)(a,"gpalab-slo"),e},y=function(){var t=document.createElement("div"),e=function(){var t=document.createElement("div");return t.setAttribute("class","gpalab-slo-dialog-overlay"),t.setAttribute("tabindex","-1"),t.setAttribute("data-a11y-dialog-hide",""),t}(),n=function(){var t=document.createElement("div"),e=function(){var t=document.createElement("div"),e=function(){var t=document.createElement("h1");return t.setAttribute("id","gpalab-slo-dialog-title"),t}(),n=function(){var t=document.createElement("div"),e=m("cancel"),n=m("confirm");return t.setAttribute("class","gpalab-slo-dialog-actions"),t.appendChild(e),t.appendChild(n),t}();return t.setAttribute("role","document"),t.appendChild(e),t.appendChild(n),t}();return t.setAttribute("role","dialog"),t.setAttribute("aria-labelledby","gpalab-slo-dialog-title"),t.appendChild(e),t}();return t.setAttribute("id","gpalab-slo-removal-confirmation-dialog"),t.setAttribute("class","gpalab-slo-dialog-container"),t.setAttribute("aria-hidden","true"),t.appendChild(e),t.appendChild(n),t};!function(){var t,e;t=document.getElementById("wpwrap"),e=y(),t.insertAdjacentElement("afterend",e),v();var n=Object(o.a)();Object(o.b)(n||0)}()}]);
!function(e){var t={};function n(a){if(t[a])return t[a].exports;var r=t[a]={i:a,l:!1,exports:{}};return e[a].call(r.exports,r,r.exports,n),r.l=!0,r.exports}n.m=e,n.c=t,n.d=function(e,t,a){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:a})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var a=Object.create(null);if(n.r(a),Object.defineProperty(a,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var r in e)n.d(a,r,function(t){return e[t]}.bind(null,r));return a},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=22)}([function(e,t){e.exports=window.regeneratorRuntime},function(e,t,n){"use strict";n.d(t,"d",(function(){return o})),n.d(t,"e",(function(){return c})),n.d(t,"b",(function(){return i})),n.d(t,"a",(function(){return l})),n.d(t,"c",(function(){return u}));var a=n(4),r=n.n(a),o=function(e){document.querySelectorAll(".gpalab-slo-tab-button").forEach((function(t){t.id==="gpalab-slo-tab-".concat(e)?(t.focus(),t.setAttribute("aria-selected","true"),t.removeAttribute("tabindex")):(t.removeAttribute("aria-selected"),t.setAttribute("tabindex","-1"))})),document.querySelectorAll(".gpalab-slo-tabpanel").forEach((function(t){t.id==="gpalab-slo-settings-".concat(e)?t.style.display="flex":t.style.display="none"}))},c=function(e){var t=document.querySelectorAll(".gpalab-slo-tab-button");if(null!==e)switch(e){case-1:o(t[t.length-1].dataset.id);break;case t.length:o(t[0].dataset.id);break;default:o(t[e].dataset.id)}},i=function(e){var t=document.querySelectorAll(".gpalab-slo-tab-button"),n=document.querySelectorAll(".gpalab-slo-tabpanel");if(0!==t.length&&0!==n.length){var a=e>=t.length?0:e,o=r()(t);o.splice(a,1),t[a].setAttribute("aria-selected","true"),n[a].style.display="flex",o.forEach((function(e){e.setAttribute("tabindex","-1")}))}},l=function(){var e=window.location.hash,t=/(gpalab-slo-tab-[0-9]*)/g,n=e.match(t)?e.match(t)[0]:null;return n?n.replace("gpalab-slo-tab-",""):0},u=function(e){var t=window.location,n=t.origin,a=t.pathname,r=t.search;window.location.href="".concat(n).concat(a).concat(r,"#gpalab-slo-tab-").concat(e),window.location.reload()}},function(e,t){e.exports=window.wp.i18n},function(e,t){function n(e,t,n,a,r,o,c){try{var i=e[o](c),l=i.value}catch(e){return void n(e)}i.done?t(l):Promise.resolve(l).then(a,r)}e.exports=function(e){return function(){var t=this,a=arguments;return new Promise((function(r,o){var c=e.apply(t,a);function i(e){n(c,r,o,i,l,"next",e)}function l(e){n(c,r,o,i,l,"throw",e)}i(void 0)}))}}},function(e,t,n){var a=n(7),r=n(8),o=n(9),c=n(10);e.exports=function(e){return a(e)||r(e)||o(e)||c()}},function(e,t){e.exports=function(e,t){(null==t||t>e.length)&&(t=e.length);for(var n=0,a=new Array(t);n<t;n++)a[n]=e[n];return a}},function(e,t,n){"use strict";n.d(t,"a",(function(){return l})),n.d(t,"b",(function(){return u})),n.d(t,"c",(function(){return s})),n.d(t,"d",(function(){return d}));var a=n(0),r=n.n(a),o=n(3),c=n.n(o),i=n(1),l=function(){var e=c()(r.a.mark((function e(t){var n,a,o,c,l;return r.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return a=(null===(n=window)||void 0===n?void 0:n.gpalabSloAdmin)||{},(o=new FormData).append("action","gpalab_add_slo_mission"),o.append("security",a.sloNonce),e.prev=4,e.next=7,fetch(a.ajaxUrl,{method:"POST",body:o});case 7:return c=e.sent,e.next=10,c.json();case 10:l=e.sent,console.log(l),Object(i.c)(t),e.next=18;break;case 15:e.prev=15,e.t0=e.catch(4),console.error(e.t0);case 18:case"end":return e.stop()}}),e,null,[[4,15]])})));return function(t){return e.apply(this,arguments)}}(),u=function(){var e=c()(r.a.mark((function e(t,n){var a,o,c,l,u;return r.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return o=(null===(a=window)||void 0===a?void 0:a.gpalabSloAdmin)||{},(c=new FormData).append("action","gpalab_remove_slo_mission"),c.append("security",o.sloNonce),c.append("mission_id",t),e.prev=5,e.next=8,fetch(o.ajaxUrl,{method:"POST",body:c});case 8:return l=e.sent,e.next=11,l.json();case 11:u=e.sent,console.log(u),Object(i.c)(n),e.next=19;break;case 16:e.prev=16,e.t0=e.catch(5),console.error(e.t0);case 19:case"end":return e.stop()}}),e,null,[[5,16]])})));return function(t,n){return e.apply(this,arguments)}}(),s=function(){var e=c()(r.a.mark((function e(t){var n,a,o,c,i;return r.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return a=(null===(n=window)||void 0===n?void 0:n.gpalabSloDashboard)||{},(o=new FormData).append("action","gpalab_slo_user_mission"),o.append("security",a.dashNonce),o.append("mission_id",t),o.append("user_id",a.currentUser),e.prev=6,e.next=9,fetch(a.ajaxUrl,{method:"POST",body:o});case 9:return c=e.sent,e.next=12,c.json();case 12:i=e.sent,console.log(i),window.location.reload(),e.next=20;break;case 17:e.prev=17,e.t0=e.catch(6),console.error(e.t0);case 20:case"end":return e.stop()}}),e,null,[[6,17]])})));return function(t){return e.apply(this,arguments)}}(),d=function(){var e=c()(r.a.mark((function e(t,n,a){var o,c,l,u,s;return r.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return c=(null===(o=window)||void 0===o?void 0:o.gpalabSloAdmin)||{},(l=new FormData).append("action","gpalab_update_slo_permalink"),l.append("security",c.sloNonce),l.append("permalink",n),l.append("post_id",t),e.prev=6,e.next=9,fetch(c.ajaxUrl,{method:"POST",body:l});case 9:return u=e.sent,e.next=12,u.json();case 12:s=e.sent,console.log(s),Object(i.c)(a),e.next=20;break;case 17:e.prev=17,e.t0=e.catch(6),console.error(e.t0);case 20:case"end":return e.stop()}}),e,null,[[6,17]])})));return function(t,n,a){return e.apply(this,arguments)}}()},function(e,t,n){var a=n(5);e.exports=function(e){if(Array.isArray(e))return a(e)}},function(e,t){e.exports=function(e){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e))return Array.from(e)}},function(e,t,n){var a=n(5);e.exports=function(e,t){if(e){if("string"==typeof e)return a(e,t);var n=Object.prototype.toString.call(e).slice(8,-1);return"Object"===n&&e.constructor&&(n=e.constructor.name),"Map"===n||"Set"===n?Array.from(e):"Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)?a(e,t):void 0}}},function(e,t){e.exports=function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}},,,,,,,,,,,,function(e,t,n){"use strict";n.r(t);var a=n(1),r=n(4),o=n.n(r),c=n(6),i=n(2),l=function(e,t,n){document.getElementById("slo-avatar-".concat(n)).value=t;var a=document.getElementById("slo-avatar-preview-".concat(n));a&&(a.style.display="none"),document.getElementById("slo-avatar-manager-".concat(n)).value=e?Object(i.__)("Change avatar image","gpalab-slo"):Object(i.__)("Select an avatar image","gpalab-slo");var r=document.getElementById("slo-avatar-placeholder-".concat(n));r&&e?r.innerText=e:r&&(r.style.display="block",r.innerText=Object(i.__)("No avatar added","gpalab-slo")),document.getElementById("slo-avatar-remove-".concat(n)).style.display=e?"block":"none"},u=function(){var e=document.querySelectorAll(".gpalab-slo-tab-button");e.forEach((function(e){e.addEventListener("click",(function(e){e.preventDefault();var t=e.target.dataset.id;Object(a.d)(t)}))})),e.forEach((function(e,t){e.addEventListener("keydown",(function(e){switch(e.which){case 37:Object(a.e)(t-1);break;case 39:Object(a.e)(t+1);break;case 40:e.preventDefault(),document.getElementById("title_".concat(t)).focus();break;default:return null}}))})),document.getElementById("slo-add-mission").addEventListener("click",(function(){Object(c.a)(e.length)})),document.querySelectorAll(".slo-remove-mission").forEach((function(t){t.addEventListener("click",(function(t){var n=t.target.dataset.id,a=o()(e).filter((function(e){return void 0!==e.attributes["aria-selected"]}))[0].dataset.id,r=a>0?a-1:0;Object(c.b)(n,r)}))})),document.querySelectorAll(".slo-permalink").forEach((function(e,t){e.addEventListener("click",(function(e){var n=e.target.dataset,a=n.id,r=n.post,o=document.getElementById("permalink-".concat(a));Object(c.d)(r,o.value,t)}))})),document.querySelectorAll(".gpalab-slo-avatar-media-manager").forEach((function(e){e.addEventListener("click",(function(e){!function(e,t){e.preventDefault();var n,a=window.wp.media;n&&n.open(),(n=a({button:{text:Object(i.__)("Use as mission avatar","gpalab-slo")},library:{type:"image"},multiple:!1,title:Object(i.__)("Add an avatar","gpalab-slo")})).on("close",(function(){return function(e,t){var n,a,r=e.state().get("selection").first(),o=null==r||null===(n=r.attributes)||void 0===n?void 0:n.filename,c=null==r||null===(a=r.attributes)||void 0===a?void 0:a.id;l(o,c,t)}(n,t)})),n.on("open",(function(){return function(e,t){var n=document.getElementById("slo-avatar-".concat(t)),a=e.state().get("selection");if(n.value&&"undefined"!==n.value){var r=window.wp.media.attachment(n.value);r.fetch(),a.add(r?[r]:[])}else a.add([])}(n,t)})),n.open()}(e,e.target.dataset.id)}))})),document.querySelectorAll(".gpalab-slo-avatar-remove").forEach((function(e){e.addEventListener("click",(function(e){var t;t=e.target.dataset.id,l("","",t)}))}))};!function(){u();var e=Object(a.a)();Object(a.b)(e||0)}()}]);
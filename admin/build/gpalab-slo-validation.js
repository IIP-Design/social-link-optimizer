!function(e){var t={};function n(r){if(t[r])return t[r].exports;var i=t[r]={i:r,l:!1,exports:{}};return e[r].call(i.exports,i,i.exports,n),i.l=!0,i.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var i in e)n.d(r,i,function(t){return e[t]}.bind(null,i));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=20)}({11:function(e,t,n){"use strict";n.d(t,"a",(function(){return r}));var r=function(e){if("loading"!==document.readyState)return e();document.addEventListener("DOMContentLoaded",e)}},20:function(e,t,n){"use strict";n.r(t);var r=n(11),i=function(){return document.getElementById("gpalab-slo-validation")},o=function(e,t){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"";e.innerHTML="",e.classList=n,t&&n&&e.appendChild(t)},a=function(){return document.querySelectorAll('[aria-invalid="true"]')},l=function(){var e=a();if(e.length){var t=document.createElement("div"),n=document.createElement("p"),r=document.createElement("ul"),i="Please complete the following required field".concat(e.length>1?"s":"",":");return n.textContent=i,e.forEach((function(e){var t,n=document.createElement("li"),i=(null==e||null===(t=e.name)||void 0===t?void 0:t.split("_"))||[],o=i[i.length-1];o&&(n.textContent=o,r.appendChild(n))})),t.appendChild(n),t.appendChild(r),t}},u=function(e){var t=e.target;t.setAttribute("aria-invalid","true"),function(e){var t=function(e){var t="Please enter a title.";switch(e){case"gpalab_slo_mission":t="Please select a mission.";break;case"gpalab_slo_link":t="Please enter a URL."}return t}(e.name),n=l();e.setCustomValidity(t);var r=i();o(r,n,"notice notice-error gpalab-slo")}(t)},c=function(e){var t=e.target,n=!!t.attributes.getNamedItem("required");if(""!==t.value.trim()&&n){t.removeAttribute("aria-invalid"),t.setCustomValidity(""),t.checkValidity();var r=i();o(r,null);var u=a();if(null==u?void 0:u.length){var c=l();o(r,c,"notice notice-error gpalab-slo")}}},d=function(){var e,t,n,r=document.getElementById("post"),i=(e=c,t=500,function(){for(var r=this,i=arguments.length,o=new Array(i),a=0;a<i;a++)o[a]=arguments[a];var l=function(){return e.apply(r,o)};clearTimeout(n),n=setTimeout(l,t)});r.addEventListener("input",i),r.addEventListener("invalid",u,!0)};Object(r.a)((function(){var e,t,n;e=document.getElementById("post"),(t=document.createElement("div")).setAttribute("id","gpalab-slo-validation"),t.setAttribute("role","status"),t.setAttribute("aria-live","polite"),e.insertAdjacentElement("beforebegin",t),document.getElementById("title-prompt-text").textContent+=" (required)",n='[name="post_title"]',document.querySelector(n).setAttribute("required",""),d()}))}});
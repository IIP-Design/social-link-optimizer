!function(e){var t={};function n(r){if(t[r])return t[r].exports;var a=t[r]={i:r,l:!1,exports:{}};return e[r].call(a.exports,a,a.exports,n),a.l=!0,a.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var a in e)n.d(r,a,function(t){return e[t]}.bind(null,a));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=22)}({0:function(e,t){e.exports=window.wp.i18n},22:function(e,t,n){"use strict";n.r(t);var r=n(6),a=function(){return document.getElementById("gpalab-slo-validation")},i=function(e,t){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"";e.innerHTML="",e.classList=n,t&&n&&e.appendChild(t)},o=n(0),l=function(){return document.querySelectorAll('[aria-invalid="true"]')},u=function(e){return e.match(/(gpalab-slo-settings\[([0-9]|[0-9][0-9])\]\[title\])/)},c=function(){var e=l();if(e.length){var t=document.createElement("div"),n=document.createElement("p"),r=document.createElement("ul"),a="Please complete the following required field",i=e.length>1?Object(o.__)("".concat(a,"s"),"gpalab-slo"):Object(o.__)(a,"gpalab-slo");return n.textContent=i,e.forEach((function(e){var t,n=document.createElement("li"),a=(null==e||null===(t=e.name)||void 0===t?void 0:t.split("_"))||[],i=u(e.name)?Object(o.__)("Mission name","gpalab-slo"):a[a.length-1];i&&(n.textContent=i,r.appendChild(n))})),t.appendChild(n),t.appendChild(r),t}},s=function(e){var t=e.target;t.setAttribute("aria-invalid","true"),function(e){var t=function(e){var t=Object(o.__)("Please provide a value for this field.","gpalab-slo");switch(e){case(u(e)||{}).input:t=Object(o.__)("Please provide a mission name.","gpalab-slo");break;case"gpalab_slo_mission":t=Object(o.__)("Please select a mission.","gpalab-slo");break;case"gpalab_slo_link":t=Object(o.__)("Please enter a URL.","gpalab-slo");break;case"post_title":t=Object(o.__)("Please enter a title.","gpalab-slo")}return t}(e.name),n=c();e.setCustomValidity(t);var r=a();i(r,n,"notice notice-error gpalab-slo")}(t)},d=function(e){var t=e.target,n=!!t.attributes.getNamedItem("required");if(""!==t.value.trim()&&n){t.removeAttribute("aria-invalid"),t.setCustomValidity(""),t.checkValidity();var r=a();i(r,null);var o=l();if(null!=o&&o.length){var u=c();i(r,u,"notice notice-error gpalab-slo")}}};Object(r.a)((function(){var e,t,n,r;e=document.getElementById("post"),(t=document.createElement("div")).setAttribute("id","gpalab-slo-validation"),t.setAttribute("role","status"),t.setAttribute("aria-live","polite"),e.insertAdjacentElement("beforebegin",t),(n=document.getElementById("title-prompt-text"))&&(n.textContent+=" (required)"),(r=document.querySelector('[name="post_title"]'))&&r.setAttribute("required",""),function(){var e,t,n=document.getElementById("post"),r=(e=d,500,function(){for(var n=this,r=arguments.length,a=new Array(r),i=0;i<r;i++)a[i]=arguments[i];var o=function(){return e.apply(n,a)};clearTimeout(t),t=setTimeout(o,500)});n.addEventListener("input",r),n.addEventListener("invalid",s,!0)}()}))},6:function(e,t,n){"use strict";n.d(t,"a",(function(){return r}));var r=function(e){if("loading"!==document.readyState)return e();document.addEventListener("DOMContentLoaded",e)}}});
!function(e){var t={};function n(r){if(t[r])return t[r].exports;var o=t[r]={i:r,l:!1,exports:{}};return e[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)n.d(r,o,function(t){return e[t]}.bind(null,o));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=20)}({0:function(e,t){e.exports=window.wp.i18n},20:function(e,t,n){"use strict";n.r(t);var r=n(0),o=n(6);Object(o.a)((function(){var e,t;e=document.getElementById("post_status"),(t=document.createElement("option")).setAttribute("value","archived"),t.textContent=Object(r.__)("Archived","gpalab-slo"),e.appendChild(t),document.getElementById("misc-publishing-actions").addEventListener("click",(function(e){e.preventDefault();var t,n,o=e.target.innerText;"OK"!==o&&"Cancel"!==o||(t=document.getElementById("save-post"),n=document.getElementById("post_status").value||"draft",t&&"archived"===n&&(t.value=Object(r.__)("Save as Archived","gpalab-slo")))}))}))},6:function(e,t,n){"use strict";n.d(t,"a",(function(){return r}));var r=function(e){if("loading"!==document.readyState)return e();document.addEventListener("DOMContentLoaded",e)}}});
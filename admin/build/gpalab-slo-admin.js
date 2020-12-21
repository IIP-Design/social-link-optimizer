/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./admin/js/admin.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./admin/js/admin.js":
/*!***************************!*\
  !*** ./admin/js/admin.js ***!
  \***************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utils_tab_nav__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./utils/tab-nav */ "./admin/js/utils/tab-nav.js");
/* harmony import */ var _utils_events_listeners__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./utils/events-listeners */ "./admin/js/utils/events-listeners.js");


/**
 * Initialized the plugin's admin JS.
 */

var init = function init() {
  // Initialize tabbed-container event listeners.
  Object(_utils_events_listeners__WEBPACK_IMPORTED_MODULE_1__["eventListeners"])();
  var index = Object(_utils_tab_nav__WEBPACK_IMPORTED_MODULE_0__["getTabFromLocation"])(); // Opens the first tab.

  Object(_utils_tab_nav__WEBPACK_IMPORTED_MODULE_0__["initializeTabs"])(index || 0);
};

init();

/***/ }),

/***/ "./admin/js/utils/ajax.js":
/*!********************************!*\
  !*** ./admin/js/utils/ajax.js ***!
  \********************************/
/*! exports provided: addSLOMission, removeSLOMission */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "addSLOMission", function() { return addSLOMission; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "removeSLOMission", function() { return removeSLOMission; });
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "@babel/runtime/regenerator");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_helpers_asyncToGenerator__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/helpers/asyncToGenerator */ "./node_modules/@babel/runtime/helpers/asyncToGenerator.js");
/* harmony import */ var _babel_runtime_helpers_asyncToGenerator__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_asyncToGenerator__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _tab_nav__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./tab-nav */ "./admin/js/utils/tab-nav.js");



/**
 * Send an Ajax request to add a new mission to the plugin settings.
 *
 * @param {string} length  Length of the old array which is equal to the index of the new item.
 */

var addSLOMission = /*#__PURE__*/function () {
  var _ref = _babel_runtime_helpers_asyncToGenerator__WEBPACK_IMPORTED_MODULE_1___default()( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee(length) {
    var _window;

    var fromPHP, formData, response, result;
    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
      while (1) {
        switch (_context.prev = _context.next) {
          case 0:
            // Get values provided to the client by the server
            fromPHP = ((_window = window) === null || _window === void 0 ? void 0 : _window.gpalabSloAdmin) || {};
            formData = new FormData();
            formData.append('action', 'gpalab_add_slo_mission');
            formData.append('security', fromPHP.sloNonce);
            _context.prev = 4;
            _context.next = 7;
            return fetch(fromPHP.ajaxUrl, {
              method: 'POST',
              body: formData
            });

          case 7:
            response = _context.sent;
            _context.next = 10;
            return response.json();

          case 10:
            result = _context.sent;
            console.log(result);
            Object(_tab_nav__WEBPACK_IMPORTED_MODULE_2__["reloadInTab"])(length);
            _context.next = 18;
            break;

          case 15:
            _context.prev = 15;
            _context.t0 = _context["catch"](4);
            console.error(_context.t0);

          case 18:
          case "end":
            return _context.stop();
        }
      }
    }, _callee, null, [[4, 15]]);
  }));

  return function addSLOMission(_x) {
    return _ref.apply(this, arguments);
  };
}();
/**
 * Remove a mission from the settings page.
 *
 * @param {string} id     The id of the mission to delete.
 * @param {number} index  The index of the tab that should show after reload.
 */

var removeSLOMission = /*#__PURE__*/function () {
  var _ref2 = _babel_runtime_helpers_asyncToGenerator__WEBPACK_IMPORTED_MODULE_1___default()( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee2(id, index) {
    var _window2;

    var fromPHP, formData, response, result;
    return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee2$(_context2) {
      while (1) {
        switch (_context2.prev = _context2.next) {
          case 0:
            // Get values provided to the client by the server
            fromPHP = ((_window2 = window) === null || _window2 === void 0 ? void 0 : _window2.gpalabSloAdmin) || {};
            formData = new FormData();
            formData.append('action', 'gpalab_remove_slo_mission');
            formData.append('security', fromPHP.sloNonce);
            formData.append('mission_id', id);
            _context2.prev = 5;
            _context2.next = 8;
            return fetch(fromPHP.ajaxUrl, {
              method: 'POST',
              body: formData
            });

          case 8:
            response = _context2.sent;
            _context2.next = 11;
            return response.json();

          case 11:
            result = _context2.sent;
            console.log(result);
            Object(_tab_nav__WEBPACK_IMPORTED_MODULE_2__["reloadInTab"])(index);
            _context2.next = 19;
            break;

          case 16:
            _context2.prev = 16;
            _context2.t0 = _context2["catch"](5);
            console.error(_context2.t0);

          case 19:
          case "end":
            return _context2.stop();
        }
      }
    }, _callee2, null, [[5, 16]]);
  }));

  return function removeSLOMission(_x2, _x3) {
    return _ref2.apply(this, arguments);
  };
}();

/***/ }),

/***/ "./admin/js/utils/events-listeners.js":
/*!********************************************!*\
  !*** ./admin/js/utils/events-listeners.js ***!
  \********************************************/
/*! exports provided: eventListeners */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "eventListeners", function() { return eventListeners; });
/* harmony import */ var _babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/toConsumableArray */ "./node_modules/@babel/runtime/helpers/toConsumableArray.js");
/* harmony import */ var _babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _ajax__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ajax */ "./admin/js/utils/ajax.js");
/* harmony import */ var _tab_nav__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./tab-nav */ "./admin/js/utils/tab-nav.js");



/**
 * Adds event listeners required to run the settings page tabbed container.
 */

var eventListeners = function eventListeners() {
  // Add event listeners to tab navigation buttons.
  var tabBtns = document.querySelectorAll('.gpalab-slo-tab-button'); // Handle clicking on tab.

  tabBtns.forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      var id = e.target.dataset.id;
      Object(_tab_nav__WEBPACK_IMPORTED_MODULE_2__["selectTab"])(id);
    });
  }); // Handle keyboard navigation.

  tabBtns.forEach(function (btn, idx) {
    btn.addEventListener('keydown', function (e) {
      switch (e.which) {
        case 37:
          Object(_tab_nav__WEBPACK_IMPORTED_MODULE_2__["switchTab"])(idx - 1);
          break;

        case 39:
          Object(_tab_nav__WEBPACK_IMPORTED_MODULE_2__["switchTab"])(idx + 1);
          break;

        case 40:
          e.preventDefault();
          document.getElementById("title_".concat(idx)).focus();
          break;

        default:
          return null;
      }
    });
  }); // Add event listener to the Add Mission button.

  var addMissionBtn = document.getElementById('slo-add-mission');
  addMissionBtn.addEventListener('click', function () {
    Object(_ajax__WEBPACK_IMPORTED_MODULE_1__["addSLOMission"])(tabBtns.length);
  }); // Add event listeners to the Remove This Mission buttons.

  var removeMissionBtns = document.querySelectorAll('.slo-remove-mission');
  removeMissionBtns.forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      var id = e.target.dataset.id; // Find the currently selected tab and it's id.

      var selected = _babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_0___default()(tabBtns).filter(function (tab) {
        return tab.attributes['aria-selected'] !== undefined;
      });

      var index = selected[0].dataset.id; // If deleting first tab one new first tab, otherwise ope tab prior to that just deleted.

      var indexAfterRemoval = index > 0 ? index - 1 : 0;
      Object(_ajax__WEBPACK_IMPORTED_MODULE_1__["removeSLOMission"])(id, indexAfterRemoval);
    });
  });
};

/***/ }),

/***/ "./admin/js/utils/tab-nav.js":
/*!***********************************!*\
  !*** ./admin/js/utils/tab-nav.js ***!
  \***********************************/
/*! exports provided: selectTab, switchTab, initializeTabs, getTabFromLocation, reloadInTab */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "selectTab", function() { return selectTab; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "switchTab", function() { return switchTab; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "initializeTabs", function() { return initializeTabs; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getTabFromLocation", function() { return getTabFromLocation; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "reloadInTab", function() { return reloadInTab; });
/* harmony import */ var _babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/toConsumableArray */ "./node_modules/@babel/runtime/helpers/toConsumableArray.js");
/* harmony import */ var _babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_0__);


/**
 * Update the tabbed container display when a new tab is selected.
 *
 * @param {string} id  The id value of the selected tab.
 */
var selectTab = function selectTab(id) {
  var tabs = document.querySelectorAll('.gpalab-slo-tab-button'); // Update the display of the tab buttons.

  tabs.forEach(function (tab) {
    if (tab.id === "gpalab-slo-tab-".concat(id)) {
      tab.focus();
      tab.setAttribute('aria-selected', 'true');
      tab.removeAttribute('tabindex');
    } else {
      tab.removeAttribute('aria-selected');
      tab.setAttribute('tabindex', '-1');
    }
  });
  var panels = document.querySelectorAll('.gpalab-slo-tabpanel'); // Hide all but the selected tab panel.

  panels.forEach(function (panel) {
    if (panel.id === "gpalab-slo-settings-".concat(id)) {
      panel.style.display = 'flex';
    } else {
      panel.style.display = 'none';
    }
  });
};
/**
 * Navigate between tabs by index (used in keyboard nav).
 *
 * @param {int} index Index of the tab which should be showing.
 */

var switchTab = function switchTab(index) {
  var btns = document.querySelectorAll('.gpalab-slo-tab-button');

  if (index !== null) {
    switch (index) {
      // If on first tab wrap around to the last tab.
      case -1:
        selectTab(btns[btns.length - 1].dataset.id);
        break;
      // If on the last tab wrap around to the first tab.

      case btns.length:
        selectTab(btns[0].dataset.id);
        break;

      default:
        selectTab(btns[index].dataset.id);
    }
  }
};
/**
 * Open on the initial tab.
 *
 * @param {number} index  The index of the selected tab.
 */

var initializeTabs = function initializeTabs(index) {
  var btns = document.querySelectorAll('.gpalab-slo-tab-button');
  var panels = document.querySelectorAll('.gpalab-slo-tabpanel'); // Abort if no tab buttons or panels present.

  if (!btns || !panels) {
    return;
  } // Check to make sure that the provided index is within range of the tabs, if not open first tab


  var selected = index >= btns.length ? 0 : index; // Get all the tabs NOT selected.

  var remainingBtns = _babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_0___default()(btns);

  remainingBtns.splice(selected, 1); // Display the first tab button and panel.

  btns[selected].setAttribute('aria-selected', 'true');
  panels[selected].style.display = 'flex'; // Capture the focus on the current tab by removing the ability to tab across the remaining buttons

  remainingBtns.forEach(function (btn) {
    btn.setAttribute('tabindex', '-1');
  });
};
/**
 * Checks the current URL for a hash indicating which tab to open.
 *
 * @returns {number} The index of the tab to focus on.
 */

var getTabFromLocation = function getTabFromLocation() {
  var hash = window.location.hash;
  var re = /(gpalab-slo-tab-[0-9]*)/g;
  var tab = hash.match(re) ? hash.match(re)[0] : null;
  return tab ? tab.replace('gpalab-slo-tab-', '') : 0;
};
/**
 * Adds a hash value to the URL and reloads the browser to navigate to selected tab.
 *
 * @param {number} id  The id of the tab in question.
 */

var reloadInTab = function reloadInTab(id) {
  var _window$location = window.location,
      origin = _window$location.origin,
      pathname = _window$location.pathname,
      search = _window$location.search;
  window.location.href = "".concat(origin).concat(pathname).concat(search, "#gpalab-slo-tab-").concat(id);
  window.location.reload();
};

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/arrayLikeToArray.js":
/*!*****************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/arrayLikeToArray.js ***!
  \*****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _arrayLikeToArray(arr, len) {
  if (len == null || len > arr.length) len = arr.length;

  for (var i = 0, arr2 = new Array(len); i < len; i++) {
    arr2[i] = arr[i];
  }

  return arr2;
}

module.exports = _arrayLikeToArray;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/arrayWithoutHoles.js":
/*!******************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/arrayWithoutHoles.js ***!
  \******************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var arrayLikeToArray = __webpack_require__(/*! ./arrayLikeToArray */ "./node_modules/@babel/runtime/helpers/arrayLikeToArray.js");

function _arrayWithoutHoles(arr) {
  if (Array.isArray(arr)) return arrayLikeToArray(arr);
}

module.exports = _arrayWithoutHoles;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/asyncToGenerator.js":
/*!*****************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/asyncToGenerator.js ***!
  \*****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) {
  try {
    var info = gen[key](arg);
    var value = info.value;
  } catch (error) {
    reject(error);
    return;
  }

  if (info.done) {
    resolve(value);
  } else {
    Promise.resolve(value).then(_next, _throw);
  }
}

function _asyncToGenerator(fn) {
  return function () {
    var self = this,
        args = arguments;
    return new Promise(function (resolve, reject) {
      var gen = fn.apply(self, args);

      function _next(value) {
        asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value);
      }

      function _throw(err) {
        asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err);
      }

      _next(undefined);
    });
  };
}

module.exports = _asyncToGenerator;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/iterableToArray.js":
/*!****************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/iterableToArray.js ***!
  \****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _iterableToArray(iter) {
  if (typeof Symbol !== "undefined" && Symbol.iterator in Object(iter)) return Array.from(iter);
}

module.exports = _iterableToArray;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/nonIterableSpread.js":
/*!******************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/nonIterableSpread.js ***!
  \******************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _nonIterableSpread() {
  throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
}

module.exports = _nonIterableSpread;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/toConsumableArray.js":
/*!******************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/toConsumableArray.js ***!
  \******************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var arrayWithoutHoles = __webpack_require__(/*! ./arrayWithoutHoles */ "./node_modules/@babel/runtime/helpers/arrayWithoutHoles.js");

var iterableToArray = __webpack_require__(/*! ./iterableToArray */ "./node_modules/@babel/runtime/helpers/iterableToArray.js");

var unsupportedIterableToArray = __webpack_require__(/*! ./unsupportedIterableToArray */ "./node_modules/@babel/runtime/helpers/unsupportedIterableToArray.js");

var nonIterableSpread = __webpack_require__(/*! ./nonIterableSpread */ "./node_modules/@babel/runtime/helpers/nonIterableSpread.js");

function _toConsumableArray(arr) {
  return arrayWithoutHoles(arr) || iterableToArray(arr) || unsupportedIterableToArray(arr) || nonIterableSpread();
}

module.exports = _toConsumableArray;

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/unsupportedIterableToArray.js":
/*!***************************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/unsupportedIterableToArray.js ***!
  \***************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var arrayLikeToArray = __webpack_require__(/*! ./arrayLikeToArray */ "./node_modules/@babel/runtime/helpers/arrayLikeToArray.js");

function _unsupportedIterableToArray(o, minLen) {
  if (!o) return;
  if (typeof o === "string") return arrayLikeToArray(o, minLen);
  var n = Object.prototype.toString.call(o).slice(8, -1);
  if (n === "Object" && o.constructor) n = o.constructor.name;
  if (n === "Map" || n === "Set") return Array.from(o);
  if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return arrayLikeToArray(o, minLen);
}

module.exports = _unsupportedIterableToArray;

/***/ }),

/***/ "@babel/runtime/regenerator":
/*!**********************************************!*\
  !*** external {"this":"regeneratorRuntime"} ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = this["regeneratorRuntime"]; }());

/***/ })

/******/ });
//# sourceMappingURL=gpalab-slo-admin.js.map
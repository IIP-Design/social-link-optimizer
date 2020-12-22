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
/******/ 	return __webpack_require__(__webpack_require__.s = "./admin/js/validation.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./admin/js/utils/handle-invalid.js":
/*!******************************************!*\
  !*** ./admin/js/utils/handle-invalid.js ***!
  \******************************************/
/*! exports provided: getInvalidFields, getLiveRegionInvalidMessage, handleInvalidFieldMessage, handleInvalidField */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getInvalidFields", function() { return getInvalidFields; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getLiveRegionInvalidMessage", function() { return getLiveRegionInvalidMessage; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "handleInvalidFieldMessage", function() { return handleInvalidFieldMessage; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "handleInvalidField", function() { return handleInvalidField; });
/* harmony import */ var _validation_utils__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./validation-utils */ "./admin/js/utils/validation-utils.js");

/**
 * Return invalid required fields.
 */

var getInvalidFields = function getInvalidFields() {
  return document.querySelectorAll('[aria-invalid="true"]');
};
/**
 * Construct a custom error message.
 * @param {string} inputName form field name
 * @param {boolean} isSelect is the field a select element
 */

var getCustomTooltipInvalidMessage = function getCustomTooltipInvalidMessage(inputName) {
  var message = 'Please enter a title.';

  switch (inputName) {
    case 'gpalab_slo_mission':
      message = 'Please select a mission.';
      break;

    case 'gpalab_slo_link':
      message = 'Please enter a URL.';
      break;

    default:
      break;
  }

  return message;
};
/**
 * Construct the live region error message.
 */


var getLiveRegionInvalidMessage = function getLiveRegionInvalidMessage() {
  var errors = getInvalidFields();

  if (!errors.length) {
    return;
  }

  var p = document.createElement('p');
  var ul = document.createElement('ul');
  var msg = "Please complete the following required field".concat(errors.length > 1 ? 's' : '', ":");
  p.textContent = msg;
  ul.style.listStyle = 'disc';
  ul.style.paddingLeft = '1rem';
  errors.forEach(function (error) {
    var _error$name;

    var li = document.createElement('li');
    var fields = (error === null || error === void 0 ? void 0 : (_error$name = error.name) === null || _error$name === void 0 ? void 0 : _error$name.split('_')) || [];
    var field = fields[fields.length - 1];

    if (field) {
      li.textContent = field;
      ul.appendChild(li);
    }
  });
  p.appendChild(ul);
  return p;
};
/**
 * Set a custom error message.
 * @param {node} element required form field
 * @param {string} message custom error message
 */

var handleInvalidFieldMessage = function handleInvalidFieldMessage(element) {
  var tooltipMsg = getCustomTooltipInvalidMessage(element.name);
  var p = getLiveRegionInvalidMessage();
  element.setCustomValidity(tooltipMsg);
  var formLiveRegion = Object(_validation_utils__WEBPACK_IMPORTED_MODULE_0__["getFormLiveRegion"])(); // Update the live region content.

  Object(_validation_utils__WEBPACK_IMPORTED_MODULE_0__["updateLiveRegion"])(formLiveRegion, p, 'notice notice-error gpalab-slo');
};
/**
 * Add error styling to an invalid form field.
 * @param {node} element invalid form field
 */

var handleInvalidFieldStyling = function handleInvalidFieldStyling(element) {
  element.style.borderColor = '#dc3232';
  element.style.boxShadow = '0 0 0 1px #dc3232';
};
/**
 * Set custom error message.
 * @param {object} e event object
 */


var handleInvalidField = function handleInvalidField(e) {
  var target = e.target; // Set field as invalid

  target.setAttribute('aria-invalid', 'true');
  handleInvalidFieldMessage(target);
  handleInvalidFieldStyling(target);
};

/***/ }),

/***/ "./admin/js/utils/handle-valid.js":
/*!****************************************!*\
  !*** ./admin/js/utils/handle-valid.js ***!
  \****************************************/
/*! exports provided: handleFieldValidation */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "handleFieldValidation", function() { return handleFieldValidation; });
/* harmony import */ var _validation_utils__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./validation-utils */ "./admin/js/utils/validation-utils.js");
/* harmony import */ var _handle_invalid__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./handle-invalid */ "./admin/js/utils/handle-invalid.js");


/**
 * Validate a required form field.
 * @param {object} e event object
 */

var handleFieldValidation = function handleFieldValidation(e) {
  var target = e.target; // Field remains invalid if empty spaces are entered.

  if (target.value.trim() === '') {
    return;
  } // Reset styling, custom tooltip, etc.


  target.removeAttribute('aria-invalid');
  target.setCustomValidity('');
  target.checkValidity();
  Object(_validation_utils__WEBPACK_IMPORTED_MODULE_0__["handleResetFieldStyling"])(target);
  var formLiveRegion = Object(_validation_utils__WEBPACK_IMPORTED_MODULE_0__["getFormLiveRegion"])(); // Reset the live region content.

  Object(_validation_utils__WEBPACK_IMPORTED_MODULE_0__["updateLiveRegion"])(formLiveRegion, null);
  var errors = Object(_handle_invalid__WEBPACK_IMPORTED_MODULE_1__["getInvalidFields"])(); // Update the live region content if there are still errors.

  if (errors === null || errors === void 0 ? void 0 : errors.length) {
    var p = Object(_handle_invalid__WEBPACK_IMPORTED_MODULE_1__["getLiveRegionInvalidMessage"])();
    Object(_validation_utils__WEBPACK_IMPORTED_MODULE_0__["updateLiveRegion"])(formLiveRegion, p, 'notice notice-error gpalab-slo');
  }
};

/***/ }),

/***/ "./admin/js/utils/validation-utils.js":
/*!********************************************!*\
  !*** ./admin/js/utils/validation-utils.js ***!
  \********************************************/
/*! exports provided: addRequiredTitleLabel, setRequiredAttribute, handleResetFieldStyling, insertFormLiveRegion, getFormLiveRegion, updateLiveRegion, debounce */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "addRequiredTitleLabel", function() { return addRequiredTitleLabel; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "setRequiredAttribute", function() { return setRequiredAttribute; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "handleResetFieldStyling", function() { return handleResetFieldStyling; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "insertFormLiveRegion", function() { return insertFormLiveRegion; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getFormLiveRegion", function() { return getFormLiveRegion; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "updateLiveRegion", function() { return updateLiveRegion; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "debounce", function() { return debounce; });
/**
 * Add required to the title field label
 */
var addRequiredTitleLabel = function addRequiredTitleLabel() {
  var titleLabel = document.getElementById('title-prompt-text');
  titleLabel.textContent += ' (required)';
};
/**
 * Add required attribute to a form element.
 * @param {string} selector CSS selector
 */

var setRequiredAttribute = function setRequiredAttribute(selector) {
  document.querySelector(selector).setAttribute('required', '');
};
/**
 * Reset a form field to the default WordPress classic editor styling.
 * @param {node} element form field
 */

var handleResetFieldStyling = function handleResetFieldStyling(element) {
  element.style.borderColor = '#7e8993';
  element.style.boxShadow = '0 0 0 0 transparent';
};
/**
 * Insert a live region for validation errors
 */

var insertFormLiveRegion = function insertFormLiveRegion() {
  var form = document.getElementById('post');
  var formLiveRegion = document.createElement('div');
  formLiveRegion.setAttribute('id', 'gpalab-slo-validation');
  formLiveRegion.setAttribute('role', 'status');
  formLiveRegion.setAttribute('aria-live', 'polite');
  form.insertAdjacentElement('beforebegin', formLiveRegion);
};
/**
 * Return invalid required fields.
 */

var getFormLiveRegion = function getFormLiveRegion() {
  return document.getElementById('gpalab-slo-validation');
};
/**
 * Update the live region content.
 * @param {node} element the live region node
 * @param {node} childNode the node to append to the live region
 */

var updateLiveRegion = function updateLiveRegion(element, childNode) {
  var classValues = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : '';
  element.innerHTML = '';
  element.classList = classValues;

  if (childNode && classValues) {
    element.appendChild(childNode);
  }
};
/**
 * Debounce function.
 * @param {function} fn the function to debounce
 */

var debounce = function debounce(fn, delay) {
  var timeout;
  return function () {
    var _this = this;

    for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
      args[_key] = arguments[_key];
    }

    var fnCall = function fnCall() {
      return fn.apply(_this, args);
    };

    clearTimeout(timeout);
    timeout = setTimeout(fnCall, delay);
  };
};

/***/ }),

/***/ "./admin/js/validation.js":
/*!********************************!*\
  !*** ./admin/js/validation.js ***!
  \********************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utils_validation_utils__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./utils/validation-utils */ "./admin/js/utils/validation-utils.js");
/* harmony import */ var _utils_handle_valid__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./utils/handle-valid */ "./admin/js/utils/handle-valid.js");
/* harmony import */ var _utils_handle_invalid__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./utils/handle-invalid */ "./admin/js/utils/handle-invalid.js");



/**
 * Add input and invalid event listeners to social link form.
 */

var initializeEventListeners = function initializeEventListeners() {
  var form = document.getElementById('post');
  var debounceFieldValidation = Object(_utils_validation_utils__WEBPACK_IMPORTED_MODULE_0__["debounce"])(_utils_handle_valid__WEBPACK_IMPORTED_MODULE_1__["handleFieldValidation"], 500);
  form.addEventListener('input', debounceFieldValidation);
  form.addEventListener('invalid', _utils_handle_invalid__WEBPACK_IMPORTED_MODULE_2__["handleInvalidField"], true);
};
/**
 * Document ready
 * @param {function} callback
 */


var ready = function ready(callback) {
  if (document.readyState !== 'loading') {
    return callback();
  }

  document.addEventListener('DOMContentLoaded', callback);
};

ready(function () {
  Object(_utils_validation_utils__WEBPACK_IMPORTED_MODULE_0__["insertFormLiveRegion"])();
  Object(_utils_validation_utils__WEBPACK_IMPORTED_MODULE_0__["addRequiredTitleLabel"])();
  Object(_utils_validation_utils__WEBPACK_IMPORTED_MODULE_0__["setRequiredAttribute"])('[name="post_title"]');
  initializeEventListeners();
});

/***/ })

/******/ });
//# sourceMappingURL=gpalab-slo-validation.js.map
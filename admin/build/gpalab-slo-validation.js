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

/***/ "./admin/js/validation.js":
/*!********************************!*\
  !*** ./admin/js/validation.js ***!
  \********************************/
/*! no static exports found */
/***/ (function(module, exports) {

/**
 * Add error styling to an invalid form field.
 * @param {node} element invalid form field
 */
var handleInvalidFieldStyling = function handleInvalidFieldStyling(element) {
  element.style.borderColor = '#dc3232';
  element.style.boxShadow = '0 0 0 1px #dc3232';
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
 * Construct a custom error message.
 * @param {string} inputName form field name
 * @param {boolean} isSelect is the field a select element
 */


var getCustomErrorMessage = function getCustomErrorMessage(inputName) {
  var message = 'Please enter a title';

  switch (inputName) {
    case 'gpalab_slo_mission':
      message = 'Please select a mission';
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
 * Set a custom error message.
 * @param {node} element required form field
 * @param {string} message custom error message
 */


var handleErrorMessage = function handleErrorMessage(element) {
  var message = getCustomErrorMessage(element.name);
  element.setCustomValidity(message);
};
/**
 * Set custom error message.
 * @param {object} e event object
 */


var handleInvalidField = function handleInvalidField(e) {
  var target = e.target;
  target.setAttribute('aria-invalid', 'true');
  handleErrorMessage(target);
  handleInvalidFieldStyling(target);
};
/**
 * Validate a required form field.
 * @param {object} e event object
 */


var handleFieldValidation = function handleFieldValidation(e) {
  var target = e.target;

  if (e.target.value.trim() === '') {
    return;
  }

  target.removeAttribute('aria-invalid');
  target.setCustomValidity('');
  target.checkValidity();
  handleResetFieldStyling(target);
};
/**
 * Add input and invalid event listeners to post form.
 */


var initializeEventListeners = function initializeEventListeners() {
  var form = document.getElementById('post');
  form.addEventListener('input', handleFieldValidation);
  form.addEventListener('invalid', handleInvalidField, true);
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
  addRequiredTitleLabel();
  setRequiredAttribute('[name="post_title"]');
  initializeEventListeners();
});

/***/ })

/******/ });
//# sourceMappingURL=gpalab-slo-validation.js.map
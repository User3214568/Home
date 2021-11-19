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
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 6);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/evaluation.js":
/*!************************************!*\
  !*** ./resources/js/evaluation.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  //Session change
  $("li[name='triggers-session']").click(function (event) {
    var _this = this;

    setTimeout(function () {
      var tab = $(_this).parent().parent().find("div.active[name='notes'] ");
      var container = tab.find("div.table-responsive");
      ajaxRequest(tab.attr('result'), tab.attr('promotion'), tab.attr('semestre'), "all", tab.attr('session'), container);
      container.html(spinner());
    }, 400);
  });
  $("li[name='triggers-session-module']").click(function (event) {
    var _this2 = this;

    setTimeout(function () {
      var tab = $(_this2).parent().parent().find("div.active[name='notes-module'] ");
      var container = tab.find("div.table-responsive");
      ajaxRequest(tab.attr('result'), tab.attr('promotion'), tab.attr('semestre'), tab.attr('module'), tab.attr('session'), container);
      container.html(spinner());
    }, 400);
  }); //Module change

  $("li[name='triggers']").click(function (event) {
    var _this3 = this;

    setTimeout(function () {
      var root = $(_this3).parent().next().find("div" + $(_this3).find("a").attr('href'));
      var tab = root.find("li[name='triggers-session-module']");
      $.each(tab, function (key, e) {
        if ($(e).find("a.active").length != 0) {
          $(e).click();
          return 0;
        }
      });
      tab = root.find("li[name='triggers-session']");
      $.each(tab, function (key, e) {
        if ($(e).find("a.active").length != 0) {
          $(e).click();
          return 0;
        }
      });
    }, 400);
  });
  $("li[name='triggers-semestre']").click(function () {
    var _this4 = this;

    setTimeout(function () {
      var root = $(_this4).parent().next().find("div" + $(_this4).find("a").attr('href'));
      var tab = root.find("li[name='triggers']");
      $.each(tab, function (key, e) {
        if ($(e).find("a.active").length != 0) {
          $(e).click();
          return 0;
        }
      });
    }, 200);
  });
  $("li[name='triggers-promo']").click(function () {
    var _this5 = this;

    setTimeout(function () {
      var root = $(_this5).parent().next().find("div" + $(_this5).find("a").attr('href'));
      var tab = root.find("li[name='triggers-semestre']");
      $.each(tab, function (key, e) {
        if ($(e).find("a.active").length != 0) {
          $(e).click();
          return 0;
        }
      });
    }, 400);
  });
});

function ajaxRequest(result, promotion, semestre, module, session, element) {
  var token = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
    url: "/admin/etudiant/request-notes/" + result + "-" + promotion + "-" + semestre + "-" + module + "-" + session,
    method: 'GET',
    data: {
      _token: token
    },
    success: function success(response) {
      element.html(response);
    },
    error: function error(_error) {
      element.html("Error Loading FAILED");
      console.log(_error);
    }
  });
}

function spinner() {
  return '<div class="row justify-content-center align-items-center mt-5"><div class="spinner-border text-warning" role="status"><span class="visually-hidden">Loading...</span></div></div>';
}

/***/ }),

/***/ 6:
/*!******************************************!*\
  !*** multi ./resources/js/evaluation.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /home/fedorauser/pfa/resources/js/evaluation.js */"./resources/js/evaluation.js");


/***/ })

/******/ });
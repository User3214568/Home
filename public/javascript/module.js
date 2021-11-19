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
/******/ 	return __webpack_require__(__webpack_require__.s = 16);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/module.js":
/*!********************************!*\
  !*** ./resources/js/module.js ***!
  \********************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _popup_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./popup.js */ "./resources/js/popup.js");

var devoirs = {
  toDelete: [],
  length: 0,
  sum: function sum() {
    var _this = this;

    var keys = Object.keys(this);
    var s = {
      ord: 0,
      rat: 0
    };
    keys.forEach(function (e) {
      if (/^[0-9]+$/.test(e)) {
        if (_this[e].session == 1) {
          s.ord += Number(_this[e].ratio);
          console.log(s.ord);
        } else {
          s.rat += Number(_this[e].ratio);
        }
      }
    });
    return s;
  }
};

function syncDevoirs() {
  $("#data").val(JSON.stringify(devoirs));
}

function showDevoirs() {
  if (typeof devs == "undefined") {} else {
    for (var i = 0; i < devs.length; i++) {
      var tar = '';

      if (devs[i].session == 2) {
        tar = '1';
      }

      var name = $("#devoirDiv" + tar).find("#name");
      name.val(devs[i].name);
      name.attr('name', devs[i].id);
      name.focus();
      var ratio = $("#devoirDiv" + tar).find("#ratio");
      ratio.val(devs[i].ratio);
      ratio.focus();
      $("#devoirDiv" + tar).find("#addModule" + tar).click();
    }
  }
}

$(document).ready(function () {
  //Add module btn event
  $("#addModule").click({
    param1: ''
  }, handle);
  $("#addModule1").click({
    param1: 1
  }, handle);
  showDevoirs();
});

function handle(event) {
  var dv = $("#devoirDiv" + event.data.param1).clone();
  var input_name = dv.find("#name");
  var name = input_name.val();
  var ratio = dv.find("#ratio").val();

  if (!(name === "" || ratio === '')) {
    if (/^[0-9]+(\.[0-9]+)?$/.test(ratio)) {
      if (Number(event.data.param1 == '1' ? devoirs.sum().rat : devoirs.sum().ord) + Number(ratio) > 100) {
        Object(_popup_js__WEBPACK_IMPORTED_MODULE_0__["default"])('Données Invalides', 'La somme des proucentage des devoires a dépassé 100%', 'bg-danger');
      } else {
        devoirs.length++;
        dv.attr('id', '#' + devoirs.length);
        devoirs[devoirs.length] = {
          name: name,
          ratio: ratio,
          session: event.data.param1 == 1 ? 2 : 1
        };

        if (input_name.attr('name') !== "") {
          devoirs[devoirs.length].id = input_name.attr('name');
        }

        var btn = dv.find("#addModule" + event.data.param1);
        btn.removeClass("btn-primary");
        var edit = dv.find("#check" + event.data.param1);
        edit.click(saveEdit);
        edit.attr('name', Number(event.data.param1) + 1);
        edit.attr('id', devoirs.length);
        edit.attr('hidden', false);
        btn.addClass('btn-danger');
        btn.attr('id', devoirs.length);
        btn.find('i').removeClass();
        btn.find('i').addClass('fas fa-times');
        btn.click(removeModule);
        $("#devoirs" + event.data.param1).prepend(dv);
        $("#devoirDiv" + event.data.param1).find("#name").val('');
        $("#devoirDiv" + event.data.param1).find("#name").attr("name", '');
        $("#devoirDiv" + event.data.param1).find("#ratio").val('');
      }
    } else {
      Object(_popup_js__WEBPACK_IMPORTED_MODULE_0__["default"])('Données Invalides', "Le Pourcentage doit étre une une valeur numérique", "bg-danger");
    }
  } else {
    Object(_popup_js__WEBPACK_IMPORTED_MODULE_0__["default"])('Opération Interdite', "Le nom du devoir ou sa portion (pourcentage) dans la note du module est Vide!", "bg-danger");
  }

  syncDevoirs();
}

function saveEdit(e) {
  var calculated = 0;

  if ($(this).attr('name') == '1') {
    calculated = devoirs.sum().ord;
  } else {
    calculated = devoirs.sum().rat;
  }

  if (calculated - Number(devoirs[$(this).attr('id')].ratio) + Number($(this).parent().parent().find('#ratio').val()) > 100) {
    Object(_popup_js__WEBPACK_IMPORTED_MODULE_0__["default"])('Données Invalides', 'La somme des proucentage des devoires a dépassé 100%', 'bg-danger');
    $(this).parent().parent().find('#ratio').val(devoirs[$(this).attr('id')].ratio);
  } else {
    devoirs[$(this).attr('id')].name = $(this).parent().parent().find('#name').val();
    devoirs[$(this).attr('id')].ratio = $(this).parent().parent().find('#ratio').val();
  }

  syncDevoirs();
}

function removeModule(event) {
  if (devoirs[$(this).attr('id')].id) {
    devoirs.toDelete.push(devoirs[$(this).attr('id')].id);
  }

  delete devoirs[$(this).attr('id')];
  devoirs.length--;
  $(this).parent().parent().remove();
  syncDevoirs();
}

/***/ }),

/***/ "./resources/js/popup.js":
/*!*******************************!*\
  !*** ./resources/js/popup.js ***!
  \*******************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return popup; });
function popup(title, content, bg) {
  var icon = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : 'far fa-times-circle';
  $("#modal-title-id").empty();
  $("#modal-header").removeClass("bg-danger bg-success");
  $("#modal-header").addClass(bg);
  $("#modal-header").empty();
  $("#modal-header").append("<div class='d-flex justify-content-center align-items-center " + bg + "'><p><i class='" + icon + " fa-6x'></i></p></div>");
  $("#modal-footer").addClass('border-white');
  $("#modal-id").empty();
  $("#modal-id").html("<div class='mt-2 d-flex justify-content-center align-items-center'><p class='h4'>" + title + "</p></div>" + "<div class='d-flex justify-content-center align-items-center'><p>" + content + "</p></div>");
  $("#close-popup").removeClass("bg-danger bg-success");
  $("#close-popup").addClass(bg);
  $("#modal-trigger").click();
}

/***/ }),

/***/ 16:
/*!**************************************!*\
  !*** multi ./resources/js/module.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /home/fedorauser/pfa/resources/js/module.js */"./resources/js/module.js");


/***/ })

/******/ });
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
/******/ 	return __webpack_require__(__webpack_require__.s = 17);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/notes.js":
/*!*******************************!*\
  !*** ./resources/js/notes.js ***!
  \*******************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _popup_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./popup.js */ "./resources/js/popup.js");

$(document).ready(function () {
  $("#formation-select").on('change', function () {
    var id = $(this).val();
    var target = $(this).attr('target');
    var empty = $("#etudiants-notes").text();
    $("#empty-notes").remove();
    $("#etudiants-notes").addClass('border mt-5');
    $("#etudiants-notes").html('<div class="d-flex justify-content-center align-items-center m-5 p-5 flex-column "><div class="spinner-border text-danger" role="status"><span class="visually-hidden">Loading...</span></div><div class="ms-4">Chargement du Contenue depuis le serveur ...</div></div>');
    var token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
      url: '/admin/formation/notes',
      method: "POST",
      data: {
        id: id,
        target: target,
        ajax: true,
        _token: token
      },
      success: function success(response) {
        $("#etudiants-notes").removeClass('border mt-5');
        $("#etudiants-notes").empty();
        $("#etudiants-notes").append(response);
        setupsave();
      },
      error: function error(_error) {
        console.log(_error);
        $("#etudiants-notes").empty();
        $("#etudiants-note").html('<div class="d-flex justify-content-center align-items-center m-5 p-5 flex-column "><div class="text-danger"><i class="fas fa-times-circle fa-6x"></i></div><div class="p-4">Une Erreur a été survenu : ' + _error.message + '</div></div>');
      }
    });
  });
  setupsave();
});

function setupsave() {
  $("button").each(function () {
    $(this).click(function () {
      if ($(this).attr('name') == "savenote") {
        var evaluation = {};
        var fails = [];
        $(this).parent().parent().parent().find(".table-responsive").find("td[name='note']").each(function (e) {
          var id = $(this).attr('id');
          var value = Number($(this).text().trim());

          if (/^[0-9]+(\.[0-9]+)?$/.test(value) && value <= 20 && value >= 0) {
            evaluation[id] = {
              note: value
            };
          } else {
            fails.push('Valeur Invalide : ' + id);
          }
        });

        if (fails.length == 0) {
          editNote(evaluation);
        } else alert('Donnée Invalides');
      }
    });
  });
}

function editNote(evaluation) {
  var token = $('meta[name="csrf-token"]').attr('content');
  console.log('ev : ', evaluation);
  $.ajax({
    url: '/admin/etudiant/update-note',
    method: 'POST',
    data: {
      evaluations: JSON.stringify(evaluation),
      ajax: true,
      _token: token
    },
    success: function success(response) {
      Object(_popup_js__WEBPACK_IMPORTED_MODULE_0__["default"])("Enregistrement Terminé", response.message, 'bg-success', 'fas fa-check-circle');
    },
    error: function error(response) {
      Object(_popup_js__WEBPACK_IMPORTED_MODULE_0__["default"])("Enregistrement Echoué", response.responseJSON.message, 'bg-danger', 'fas fa-times-circle');
    }
  });
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

/***/ 17:
/*!*************************************!*\
  !*** multi ./resources/js/notes.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\Users\asus\Desktop\Home\resources\js\notes.js */"./resources/js/notes.js");


/***/ })

/******/ });
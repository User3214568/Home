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
/******/ 	return __webpack_require__(__webpack_require__.s = 8);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/formation-cards.js":
/*!*****************************************!*\
  !*** ./resources/js/formation-cards.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$('document').ready(function () {
  $("button[name='card-formation']").on('click', function () {
    var formation = JSON.parse($(this).parent().find('textarea[name="sems"]').val());
    console.log(formation);
    $("#modal-dialog").addClass("modal-fullscreen");
    $("#modal-title-id").html("Informations sur la Formation " + formation.name + "<hr class='dropdown-divider'/>");
    $("#modal-title-id").addClass("text-primary");
    $("#modal-footer").addClass('border-white');
    $("#modal-id").empty();
    $("#modal-id").html("<div class='container-fluid'>" + prepareContent(formation) + '</div>');
    $("#close-popup").removeClass("bg-danger bg-success");
    $("#close-popup").addClass("bg-danger");
    $("#modal-trigger").click();
  });

  function prepareContent(formation) {
    var content = '<div class="accordion  " id="accordionExample">';
    var sems = formation.semes;
    sems.forEach(function (element) {
      content += '<div class="accordion-item mt-2 " ><h2 class="accordion-header " id="sem' + element.numero + '">';
      content += '<button class="accordion-button" type="button" data-mdb-toggle="collapse" data-mdb-target="#exp' + element.numero + '" aria-expanded="false">Semestre ' + element.numero + '</button></h2>';
      content += '<div id="exp' + element.numero + '" class="accordion-collapse collapse "  data-mdb-parent="#accordionExample"><div class="accordion-body">';

      if (element.modules.length > 0) {
        content += "<div class='row text-center justify-content-center '>";
        element.modules.forEach(function (module) {
          content += "<table class='text-white border-light " + randomBackground() + " m-1 col-lg-3  rounded-0 shadow-5 table-bordered'>";
          content += "<tr><th class='p-2'>Module</th><td  class='p-2'>" + module.name + "</td></tr>";
          content += "<tr><th class='p-2'>Professeur</th><td class='p-2'>" + module.teacher + "</td></tr>";
          content += "</table>";
        });
        content += "</div>";
      } else {
        content += "<div class='text-lead'>Cette semestre n'a aucun module.</div>";
      }

      content += " </div></div></div>";
    });
    content += "</div>";
    return content;
  }

  function randomBackground() {
    var i = Math.random();

    if (i <= 0.2) {
      return 'bg-danger';
    }

    if (i <= 0.4) {
      return 'bg-warning';
    }

    if (i <= 0.55) {
      return 'bg-primary';
    }

    if (i <= 0.7) {
      return 'bg-secondary';
    }

    if (i <= 0.85) {
      return 'bg-info';
    }

    return 'bg-dark';
  }
});

/***/ }),

/***/ 8:
/*!***********************************************!*\
  !*** multi ./resources/js/formation-cards.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /home/fedorauser/pfa/resources/js/formation-cards.js */"./resources/js/formation-cards.js");


/***/ })

/******/ });
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
/******/ 	return __webpack_require__(__webpack_require__.s = 9);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/formation.js":
/*!***********************************!*\
  !*** ./resources/js/formation.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  setTimeout(init, 200);
  $("#add-semestre").click(function () {
    var newSem = $("#sem-template").clone();
    semestres[semestres.last] = [];
    newSem.attr('id', 'sem' + semestres.last); //Buttons update delete

    newSem.find("#add-semestre").remove();
    var editButton = newSem.find("#edit-semestre");
    editButton.attr('hidden', false);
    editButton.attr('target', newSem.attr('id'));
    var editButton = newSem.find("#delete-semestre");
    editButton.attr('hidden', false);
    editButton.attr('target', newSem.attr('id')); //title

    newSem.find("#title").text("Semestre" + semestres.last); //sync semestres variable

    newSem.find("input:checkbox ").each(function (index, item) {
      var oldId = $(item).attr('id');
      $(item).attr('id', oldId + "-" + newSem.attr('id'));
      newSem.find('label[for="' + oldId + '"]').attr('for', $(item).attr('id'));

      if ($(item).prop('checked')) {
        semestres[semestres.last].push($(item).val());
      }
    });
    semestres.last = semestres.last + 1;
    $("#semestres").append(newSem); //Clear Checked from template

    $("#sem-template").find("input:checkbox").each(function (index, item) {
      if ($(item).prop('checked')) {
        $(item).prop('checked', false);
      }
    });
    syncsemestres();
  });
});

function updateSemestre(element) {
  var sem = $("#" + $(element).attr('target'));
  semestres[$(element).attr('target').substring(3)] = [];
  sem.find("input:checkbox ").each(function (index, item) {
    if ($(item).prop('checked')) {
      semestres[$(element).attr('target').substring(3)].push($(item).val());
    }
  });
  syncsemestres();
}

function deleteSemestre(element) {
  var index = $(element).attr('target').substring(3);

  if (semestres.last - 1 == index) {
    delete semestres[index];
    $("#" + $(element).attr('target')).slideUp(100, function () {
      $("#" + $(element).attr('target')).remove();
    });
    semestres.last--;
    syncsemestres();
  }
}

function syncsemestres() {
  var keys = Object.keys(semestres);
  var results = {};
  keys.forEach(function (key) {
    if (key !== 'last') {
      results[key] = semestres[key];
    }
  });
  $("#semestres-data").val(JSON.stringify(results));
}

function init() {
  var keys = Object.keys(semestres);

  if (keys.length == 0) {
    semestres.last = 1;
  } else {
    keys.forEach(function (key) {
      if (key !== 'last') {
        var sem = $("#sem-template");
        sem.find('input:checkbox').each(function (index, item) {
          if (semestres[key].includes($(item).val())) {
            $(item).prop('checked', true);
          }
        });
        $("#add-semestre").click();
      }
    });
  }
}

/***/ }),

/***/ 9:
/*!*****************************************!*\
  !*** multi ./resources/js/formation.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\Users\asus\Desktop\Home\resources\js\formation.js */"./resources/js/formation.js");


/***/ })

/******/ });
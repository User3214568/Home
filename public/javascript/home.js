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
/******/ 	return __webpack_require__(__webpack_require__.s = 10);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/home.js":
/*!******************************!*\
  !*** ./resources/js/home.js ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports) {

var total_vsed = 0;
var total_pai = 0;
$(document).ready(function () {
  var keys = Object.keys(stats);
  var etudiant = [],
      module = [],
      prof = [],
      formations = [];
  keys.forEach(function (formation) {
    etudiant.push(stats[formation].etudiants);
    module.push(stats[formation].modules);
    prof.push(stats[formation].profs);
    formations.push(formation);
  });
  Apex.colors = ['#3eb59b', '#F44336', '#366ff4'];
  var options = {
    series: [{
      name: 'Etudiants',
      data: etudiant
    }, {
      name: 'Modules',
      data: module
    }, {
      name: 'Professeurs',
      data: prof
    }],
    chart: {
      type: 'bar',
      height: 350,
      stacked: true,
      toolbar: {
        show: true
      },
      zoom: {
        enabled: true
      }
    },
    responsive: [{
      breakpoint: 480,
      options: {
        legend: {
          position: 'bottom',
          offsetX: -10,
          offsetY: 0
        }
      }
    }],
    plotOptions: {
      bar: {
        horizontal: false,
        borderRadius: 10
      }
    },
    xaxis: {
      categories: formations
    },
    legend: {
      position: 'top',
      offsetY: 10
    },
    fill: {
      opacity: 1
    }
  };
  var chart = new ApexCharts(document.querySelector("#chart1"), options);
  chart.render(); // chart 2

  var data = [],
      data1 = [];
  var formations = Object.keys(fin_stats);
  formations.forEach(function (formation) {
    total_vsed += fin_stats[formation].total_vers;
    console.log('tot : ', fin_stats[formation].total_vers);
    total_pai += fin_stats[formation].paiements;
    data.push({
      x: formation,
      y: fin_stats[formation].vers,
      goals: [{
        name: 'Expected',
        value: fin_stats[formation].total_vers,
        strokeWidth: 5,
        strokeColor: '#775DD0'
      }]
    });
    data1.push({
      x: formation,
      y: fin_stats[formation].paiements,
      goals: [{
        name: 'Expected',
        value: fin_stats[formation].total_paiements,
        strokeWidth: 5,
        strokeColor: '#775DD0'
      }]
    });
  });
  var options = {
    series: [{
      name: 'Actual',
      data: data
    }],
    chart: {
      height: 350,
      type: 'bar'
    },
    plotOptions: {
      bar: {
        horizontal: true
      }
    },
    colors: ['#00E396'],
    dataLabels: {
      formatter: function formatter(val, opt) {
        var goals = opt.w.config.series[opt.seriesIndex].data[opt.dataPointIndex].goals;

        if (goals && goals.length) {
          return "".concat(val, " / ").concat(goals[0].value);
        }

        return val;
      }
    },
    legend: {
      show: true,
      showForSingleSeries: true,
      customLegendItems: ['Actual', 'Expected'],
      markers: {
        fillColors: ['#00E396', '#775DD0']
      }
    }
  };
  var chart = new ApexCharts(document.querySelector("#chart2"), options);
  chart.render(); // chart 3

  var options = {
    series: [{
      name: 'Actual',
      data: data1
    }],
    chart: {
      height: 350,
      type: 'bar'
    },
    plotOptions: {
      bar: {
        horizontal: true
      }
    },
    colors: ['#00E396'],
    dataLabels: {
      formatter: function formatter(val, opt) {
        var goals = opt.w.config.series[opt.seriesIndex].data[opt.dataPointIndex].goals;

        if (goals && goals.length) {
          return "".concat(val, " / ").concat(goals[0].value);
        }

        return val;
      }
    },
    legend: {
      show: true,
      showForSingleSeries: true,
      customLegendItems: ['Actual', 'Expected'],
      markers: {
        fillColors: ['#00E396', '#775DD0']
      }
    }
  };
  var chart = new ApexCharts(document.querySelector("#chart3"), options);
  chart.render(); //chart 3-4

  console.log(fin_stats);
  renderChartRadial("#chart4", total_vsed <= 0 ? 100 : (total_versments * 100 / total_vsed).toFixed(2));
  renderChartRadial('#chart5', total_paiements <= 0 ? 100 : (total_pai * 100 / total_paiements).toFixed(2));
});

function renderChartRadial(divId, value) {
  var label = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : "";
  var options = {
    series: [value],
    chart: {
      height: 150,
      type: 'radialBar',
      offsetY: -10
    },
    plotOptions: {
      radialBar: {
        startAngle: -135,
        endAngle: 135,
        dataLabels: {
          name: {
            fontSize: '16px',
            color: undefined,
            offsetY: 120
          },
          value: {
            offsetY: 76,
            fontSize: '22px',
            color: undefined,
            formatter: function formatter(val) {
              return val + "%";
            }
          }
        }
      }
    },
    fill: {
      type: 'gradient',
      gradient: {
        shade: 'dark',
        shadeIntensity: 0.15,
        inverseColors: false,
        opacityFrom: 1,
        opacityTo: 1,
        stops: [0, 50, 65, 91]
      }
    },
    stroke: {
      dashArray: 4
    },
    labels: [label]
  };
  var chart = new ApexCharts(document.querySelector(divId), options);
  chart.render();
}

/***/ }),

/***/ 10:
/*!************************************!*\
  !*** multi ./resources/js/home.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /home/fedorauser/pfa/resources/js/home.js */"./resources/js/home.js");


/***/ })

/******/ });
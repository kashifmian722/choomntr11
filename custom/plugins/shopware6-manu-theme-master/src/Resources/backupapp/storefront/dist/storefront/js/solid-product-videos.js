(window.webpackJsonp=window.webpackJsonp||[]).push([["solid-product-videos"],{"6uON":function(t,e,i){"use strict";i.d(e,"a",(function(){return a}));var n=i("WGrI"),r=i.n(n),o=i("ERap");function s(){return(s=Object.assign||function(t){for(var e=1;e<arguments.length;e++){var i=arguments[e];for(var n in i)Object.prototype.hasOwnProperty.call(i,n)&&(t[n]=i[n])}return t}).apply(this,arguments)}function l(t,e){for(var i=0;i<e.length;i++){var n=e[i];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(t,n.key,n)}}var a=function(){function t(){!function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(this,t)}var e,i,n;return e=t,n=[{key:"getViewportSettings",value:function(t,e){var i=s({},t),n=t.responsive;delete i.responsive;var o=n[window.breakpoints[e.toLowerCase()]];return r()(i,o)}},{key:"prepareBreakpointPxValues",value:function(t){return o.a.iterate(t.responsive,(function(e,i){var n=window.breakpoints[i.toLowerCase()];t.responsive[n]=e,delete t.responsive[i]})),t}}],(i=null)&&l(e.prototype,i),n&&l(e,n),t}()},Yicb:function(t,e,i){"use strict";i.d(e,"a",(function(){return y}));var n=i("FGIj"),r=i("dKJH"),o=i("nnsc"),s=i("6uON"),l=i("Cxgn");function a(t){return(a="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}function u(t,e){var i=Object.keys(t);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(t);e&&(n=n.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),i.push.apply(i,n)}return i}function c(t,e){for(var i=0;i<e.length;i++){var n=e[i];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(t,n.key,n)}}function d(t,e){return!e||"object"!==a(e)&&"function"!=typeof e?function(t){if(void 0===t)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return t}(t):e}function p(t){return(p=Object.setPrototypeOf?Object.getPrototypeOf:function(t){return t.__proto__||Object.getPrototypeOf(t)})(t)}function h(t,e){return(h=Object.setPrototypeOf||function(t,e){return t.__proto__=e,t})(t,e)}function f(t,e,i){return e in t?Object.defineProperty(t,e,{value:i,enumerable:!0,configurable:!0,writable:!0}):t[e]=i,t}var y=function(t){function e(){return function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(this,e),d(this,p(e).apply(this,arguments))}var i,n,a;return function(t,e){if("function"!=typeof e&&null!==e)throw new TypeError("Super expression must either be null or a function");t.prototype=Object.create(e&&e.prototype,{constructor:{value:t,writable:!0,configurable:!0}}),e&&h(t,e)}(e,t),i=e,(n=[{key:"init",value:function(){this._slider=!1,this.el.classList.contains(this.options.initializedCls)||(this.options.slider=s.a.prepareBreakpointPxValues(this.options.slider),this._correctIndexSettings(),this._getSettings(o.a.getCurrentViewport()),this._initSlider(),this._registerEvents())}},{key:"_correctIndexSettings",value:function(){this.options.slider.startIndex-=1,this.options.slider.startIndex=this.options.slider.startIndex<0?0:this.options.slider.startIndex}},{key:"destroy",value:function(){if(this._slider&&"function"==typeof this._slider.destroy)try{this._slider.destroy()}catch(t){}this.el.classList.remove(this.options.initializedCls)}},{key:"_registerEvents",value:function(){var t=this;this._slider&&document.addEventListener("Viewport/hasChanged",(function(){return t.rebuild(o.a.getCurrentViewport())}))}},{key:"rebuild",value:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:o.a.getCurrentViewport(),e=arguments.length>1&&void 0!==arguments[1]&&arguments[1];this._getSettings(t.toLowerCase());try{if(this._slider&&!e){var i=this._getCurrentIndex();this._sliderSettings.startIndex=i}this.destroy(),this._initSlider()}catch(t){}this.$emitter.publish("rebuild")}},{key:"_getSettings",value:function(t){this._sliderSettings=s.a.getViewportSettings(this.options.slider,t)}},{key:"getCurrentSliderIndex",value:function(){if(this._slider){var t=this._slider.getInfo(),e=t.displayIndex%t.slideCount;return(e=0===e?t.slideCount:e)-1}}},{key:"getActiveSlideElement",value:function(){var t=this._slider.getInfo();return t.slideItems[t.index]}},{key:"_initSlider",value:function(){var t=this;this.el.classList.add(this.options.initializedCls);var e=this.el.querySelector(this.options.containerSelector),i=this.el.querySelector(this.options.controlsSelector);e&&(this._sliderSettings.enabled?(e.style.display="",this._slider=Object(r.a)(function(t){for(var e=1;e<arguments.length;e++){var i=null!=arguments[e]?arguments[e]:{};e%2?u(i,!0).forEach((function(e){f(t,e,i[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(i)):u(i).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(i,e))}))}return t}({container:e,controlsContainer:i,onInit:function(){l.a.initializePlugins(),t.$emitter.publish("initSlider")}},this._sliderSettings))):e.style.display="none"),this.$emitter.publish("afterInitSlider")}},{key:"_getCurrentIndex",value:function(){var t=this._slider.getInfo(),e=t.index%t.slideCount;return(e=0===e?t.slideCount:e)-1}}])&&c(i.prototype,n),a&&c(i,a),e}(n.a);f(y,"options",{initializedCls:"js-slider-initialized",containerSelector:"[data-base-slider-container=true]",controlsSelector:"[data-base-slider-controls=true]",slider:{enabled:!0,responsive:{xs:{},sm:{},md:{},lg:{},xl:{}}}})},abXN:function(t,e,i){"use strict";i.r(e);var n=i("o99n"),r=i("6uON"),o=i("nnsc"),s=i("dKJH");function l(t){return(l="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}function a(t,e){var i=Object.keys(t);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(t);e&&(n=n.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),i.push.apply(i,n)}return i}function u(t){for(var e=1;e<arguments.length;e++){var i=null!=arguments[e]?arguments[e]:{};e%2?a(i,!0).forEach((function(e){c(t,e,i[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(i)):a(i).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(i,e))}))}return t}function c(t,e,i){return e in t?Object.defineProperty(t,e,{value:i,enumerable:!0,configurable:!0,writable:!0}):t[e]=i,t}function d(t,e){for(var i=0;i<e.length;i++){var n=e[i];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(t,n.key,n)}}function p(t,e){return!e||"object"!==l(e)&&"function"!=typeof e?function(t){if(void 0===t)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return t}(t):e}function h(t){return(h=Object.setPrototypeOf?Object.getPrototypeOf:function(t){return t.__proto__||Object.getPrototypeOf(t)})(t)}function f(t,e){return(f=Object.setPrototypeOf||function(t,e){return t.__proto__=e,t})(t,e)}var y=window.PluginManager,b=function(t){function e(){return function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(this,e),p(this,h(e).apply(this,arguments))}var i,n,l;return function(t,e){if("function"!=typeof e&&null!==e)throw new TypeError("Super expression must either be null or a function");t.prototype=Object.create(e&&e.prototype,{constructor:{value:t,writable:!0,configurable:!0}}),e&&f(t,e)}(e,t),i=e,(n=[{key:"init",value:function(){this._setProductVideosPreloadBehaviour(),this._slider=!1,this._thumbnailSlider=!1,this.el.classList.contains(this.options.initializedCls)||(this.options.slider=r.a.prepareBreakpointPxValues(this.options.slider),this.options.thumbnailSlider=r.a.prepareBreakpointPxValues(this.options.thumbnailSlider),this._correctIndexSettings(),this._getSettings(o.a.getCurrentViewport()),this._initSlider(),this._registerEvents())}},{key:"_setProductVideosPreloadBehaviour",value:function(){var t=navigator.userAgent.toLowerCase(),e=!1;-1!==t.indexOf("safari")&&-1===t.indexOf("chrome")&&(e=!0),e||this.el.querySelectorAll("video").forEach((function(t){t.setAttribute("preload","auto")}))}},{key:"_initSlider",value:function(){var t=this;this.el.classList.add(this.options.initializedCls);var e=this.el.querySelector(this.options.containerSelector),i=this.el.querySelector(this.options.thumbnailsSelector),n=this.el.querySelector(this.options.controlsSelector),r=!!i;if(e&&(this._sliderSettings.enabled?(e.style.display="",this._slider=Object(s.a)(u({container:e,controlsContainer:n,navContainer:i,onInit:function(){y.initializePlugin("Magnifier","[data-magnifier]"),y.initializePlugin("ZoomModal","[data-zoom-modal]"),r||t.el.classList.remove(t.options.loadingCls),t.$emitter.publish("initGallerySlider")}},this._sliderSettings)),this._initDots()):e.style.display="none"),i){var o=this.el.querySelector(this.options.thumbnailControlsSelector);this._thumbnailSliderSettings.enabled?(i.style.display="",this._thumbnailSlider=Object(s.a)(u({container:i,controlsContainer:o,onInit:function(){r&&t.el.classList.remove(t.options.loadingCls),t.$emitter.publish("initThumbnailSlider")}},this._thumbnailSliderSettings))):(i.style.display="none",this.el.classList.remove(this.options.loadingCls))}this.$emitter.publish("afterInitSlider"),this._slider&&this._slider.events.on("transitionStart",(function(){t._stopProductVideos()}))}},{key:"_registerEvents",value:function(){var t=this;this._slider&&document.addEventListener("Viewport/hasChanged",(function(e){"NONE"!==e.detail.previousViewport&&t.rebuild(o.a.getCurrentViewport())}))}},{key:"_stopProductVideos",value:function(){var t=this.el.querySelectorAll("video"),e=this.el.querySelectorAll(".youtube"),i=this.el.querySelectorAll(".vimeo");t.forEach((function(t){t.pause(),t.currentTime=0})),e.forEach((function(t){t.contentWindow.postMessage('{ "event": "command", "func": "stopVideo", "args": "" }',"*")})),i.forEach((function(t){var e=t.getAttribute("src");t.src="",t.src=e}))}}])&&d(i.prototype,n),l&&d(i,l),e}(n.a);window.PluginManager.override("GallerySlider",b,"[data-gallery-slider]")},o99n:function(t,e,i){"use strict";i.d(e,"a",(function(){return _}));var n=i("WGrI"),r=i.n(n),o=i("dKJH"),s=i("nnsc"),l=i("6uON"),a=i("Cxgn"),u=i("ERap"),c=i("Yicb"),d=i("gHbT");function p(t){return(p="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}function h(t,e){var i=Object.keys(t);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(t);e&&(n=n.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),i.push.apply(i,n)}return i}function f(t){for(var e=1;e<arguments.length;e++){var i=null!=arguments[e]?arguments[e]:{};e%2?h(i,!0).forEach((function(e){m(t,e,i[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(i)):h(i).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(i,e))}))}return t}function y(t,e){for(var i=0;i<e.length;i++){var n=e[i];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(t,n.key,n)}}function b(t,e){return!e||"object"!==p(e)&&"function"!=typeof e?function(t){if(void 0===t)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return t}(t):e}function v(t,e,i){return(v="undefined"!=typeof Reflect&&Reflect.get?Reflect.get:function(t,e,i){var n=function(t,e){for(;!Object.prototype.hasOwnProperty.call(t,e)&&null!==(t=g(t)););return t}(t,e);if(n){var r=Object.getOwnPropertyDescriptor(n,e);return r.get?r.get.call(i):r.value}})(t,e,i||t)}function g(t){return(g=Object.setPrototypeOf?Object.getPrototypeOf:function(t){return t.__proto__||Object.getPrototypeOf(t)})(t)}function S(t,e){return(S=Object.setPrototypeOf||function(t,e){return t.__proto__=e,t})(t,e)}function m(t,e,i){return e in t?Object.defineProperty(t,e,{value:i,enumerable:!0,configurable:!0,writable:!0}):t[e]=i,t}var _=function(t){function e(){return function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(this,e),b(this,g(e).apply(this,arguments))}var i,n,r;return function(t,e){if("function"!=typeof e&&null!==e)throw new TypeError("Super expression must either be null or a function");t.prototype=Object.create(e&&e.prototype,{constructor:{value:t,writable:!0,configurable:!0}}),e&&S(t,e)}(e,t),i=e,(n=[{key:"init",value:function(){this._slider=!1,this._thumbnailSlider=!1,this.el.classList.contains(this.options.initializedCls)||(this.options.slider=l.a.prepareBreakpointPxValues(this.options.slider),this.options.thumbnailSlider=l.a.prepareBreakpointPxValues(this.options.thumbnailSlider),this._correctIndexSettings(),this._getSettings(s.a.getCurrentViewport()),this._initSlider(),this._registerEvents())}},{key:"_correctIndexSettings",value:function(){v(g(e.prototype),"_correctIndexSettings",this).call(this),this.options.thumbnailSlider.startIndex-=1,this.options.thumbnailSlider.startIndex=this.options.thumbnailSlider.startIndex<0?0:this.options.thumbnailSlider.startIndex}},{key:"destroy",value:function(){if(this._slider&&"function"==typeof this._slider.destroy)try{this._slider.destroy()}catch(t){}if(this._thumbnailSlider&&"function"==typeof this._thumbnailSlider.destroy)try{this._thumbnailSlider.destroy()}catch(t){}this.el.classList.remove(this.options.initializedCls)}},{key:"rebuild",value:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:s.a.getCurrentViewport();this._getSettings(t.toLowerCase());try{if(this._slider){var e=this.getCurrentSliderIndex();this._sliderSettings.startIndex=e,this._thumbnailSliderSettings.startIndex=e}this.destroy(),this._initSlider()}catch(t){}this.$emitter.publish("rebuild")}},{key:"_getSettings",value:function(t){v(g(e.prototype),"_getSettings",this).call(this,t),this._thumbnailSliderSettings=l.a.getViewportSettings(this.options.thumbnailSlider,t)}},{key:"_setActiveDot",value:function(){var t=this,e=this.getCurrentSliderIndex();u.a.iterate(this._dots,(function(e){return e.classList.remove(t.options.dotActiveClass)}));var i=this._dots[e];i&&i.classList.add(this.options.dotActiveClass)}},{key:"_initDots",value:function(){var t=this;this._dots=this.el.querySelectorAll("["+this.options.navDotDataAttr+"]"),this._dots&&(u.a.iterate(this._dots,(function(e){e.addEventListener("click",t._onDotClick.bind(t))})),this._setActiveDot(),this._slider&&this._slider.events.on("indexChanged",(function(){t._setActiveDot()})))}},{key:"_onDotClick",value:function(t){var e=d.a.getDataAttribute(t.target,this.options.navDotDataAttr);this._slider.goTo(e-1)}},{key:"_initSlider",value:function(){var t=this;this.el.classList.add(this.options.initializedCls);var e=this.el.querySelector(this.options.containerSelector),i=this.el.querySelector(this.options.thumbnailsSelector),n=this.el.querySelector(this.options.controlsSelector),r=!!i;if(e&&(this._sliderSettings.enabled?(e.style.display="",this._slider=Object(o.a)(f({container:e,controlsContainer:n,navContainer:i,onInit:function(){a.a.initializePlugin("Magnifier","[data-magnifier]"),a.a.initializePlugin("ZoomModal","[data-zoom-modal]"),r||t.el.classList.remove(t.options.loadingCls),t.$emitter.publish("initGallerySlider")}},this._sliderSettings)),this._initDots()):e.style.display="none"),i){var s=this.el.querySelector(this.options.thumbnailControlsSelector);this._thumbnailSliderSettings.enabled?(i.style.display="",this._thumbnailSlider=Object(o.a)(f({container:i,controlsContainer:s,onInit:function(){r&&t.el.classList.remove(t.options.loadingCls),t.$emitter.publish("initThumbnailSlider")}},this._thumbnailSliderSettings))):i.style.display="none"}this.$emitter.publish("afterInitSlider")}}])&&y(i.prototype,n),r&&y(i,r),e}(c.a);m(_,"options",r()(c.a.options,{containerSelector:"[data-gallery-slider-container=true]",thumbnailsSelector:"[data-gallery-slider-thumbnails=true]",controlsSelector:"[data-gallery-slider-controls=true]",thumbnailControlsSelector:"[data-thumbnail-slider-controls=true]",dotActiveClass:"tns-nav-active",navDotDataAttr:"data-nav-dot",loadingCls:"is-loading",slider:{startIndex:1,responsive:{xs:{},sm:{},md:{},lg:{},xl:{}}},thumbnailSlider:{enabled:!0,loop:!1,nav:!1,items:5,gutter:10,startIndex:1,responsive:{xs:{},sm:{},md:{},lg:{},xl:{}}}}))}},[["abXN","runtime","vendor-node","vendor-shared"]]]);
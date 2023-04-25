/*! For license information please see menu.js.LICENSE.txt */
!function(){"use strict";var t,n=function(){function t(t,n){this._j=t,this._l10n=n,this._fx_duration=200,this._submenu_button_class_name="js-sub-menu-button",this._submenu_selector="#primary-menu .menu li > ul",this._submenu_button_selector=".".concat(this._submenu_button_class_name)}return t.prototype.toggleSubMenu=function(t){var n=this._j(t),e=n.parent("li").siblings("li"),o=n.next("ul");e.children("ul").slideUp(this._fx_duration),e.children("a").children(this._submenu_button_selector).html(this.renderIcon("down")),this.toggleIcon(t),o.find("ul").prev("a").children(this._submenu_button_selector).html(this.renderIcon("down")),o.find("ul").slideUp(this._fx_duration),o.slideToggle(this._fx_duration)},t.prototype.toggleIcon=function(t){var n=this._j(t),e="none"===n.next("ul").css("display")?"up":"down";n.children(this._submenu_button_selector).html(this.renderIcon(e))},t.prototype.renderIcon=function(t){return'<span class="fas fa-caret-'.concat(t,'" aria-hidden="true">\n            </span>\n            <span class="screen-reader-text">').concat(this._l10n.submenu,"</span>")},t}(),e=(t=function(n,e){return t=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(t,n){t.__proto__=n}||function(t,n){for(var e in n)Object.prototype.hasOwnProperty.call(n,e)&&(t[e]=n[e])},t(n,e)},function(n,e){if("function"!=typeof e&&null!==e)throw new TypeError("Class extends value "+String(e)+" is not a constructor or null");function o(){this.constructor=n}t(n,e),n.prototype=null===e?Object.create(e):(o.prototype=e.prototype,new o)}),o=function(t){function n(){return null!==t&&t.apply(this,arguments)||this}return e(n,t),n.prototype.run=function(){this.handleClick()},n.prototype.handleClick=function(){var t=this;this._j(".js-main-menu-button").attr("href","#").on("click",(function(n){t._j(".js-main-menu").slideToggle(t._fx_duration,(function(){t._j(".js-main-menu").toggleClass("show hide").css({display:""})})),n.preventDefault()}))},n}(n),r=function(){var t=function(n,e){return t=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(t,n){t.__proto__=n}||function(t,n){for(var e in n)Object.prototype.hasOwnProperty.call(n,e)&&(t[e]=n[e])},t(n,e)};return function(n,e){if("function"!=typeof e&&null!==e)throw new TypeError("Class extends value "+String(e)+" is not a constructor or null");function o(){this.constructor=n}t(n,e),n.prototype=null===e?Object.create(e):(o.prototype=e.prototype,new o)}}(),u=function(t){function n(){return null!==t&&t.apply(this,arguments)||this}return r(n,t),n.prototype.run=function(){this.handleClick()},n.prototype.moveElement=function(){var t=this;this._j(this._submenu_selector).prev("a").filter((function(n,e){var o;return 0!==(null===(o=t._j(e).attr("href"))||void 0===o?void 0:o.indexOf("#"))})).each((function(n,e){var o=t._j(e).first();o.detach().appendTo(o.next())}))},n.prototype.handleClick=function(){var t=this;this._j(this._submenu_selector).prev("a").on("click",(function(n){t.toggleSubMenu(n.currentTarget),n.preventDefault()}))},n}(n),i=function(){var t=function(n,e){return t=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(t,n){t.__proto__=n}||function(t,n){for(var e in n)Object.prototype.hasOwnProperty.call(n,e)&&(t[e]=n[e])},t(n,e)};return function(n,e){if("function"!=typeof e&&null!==e)throw new TypeError("Class extends value "+String(e)+" is not a constructor or null");function o(){this.constructor=n}t(n,e),n.prototype=null===e?Object.create(e):(o.prototype=e.prototype,new o)}}(),s=function(t){function n(){return null!==t&&t.apply(this,arguments)||this}return i(n,t),n.prototype.run=function(){this.add()},n.prototype.add=function(){this._j(this._submenu_selector).prev("a").append('<span class="'.concat(this._submenu_button_class_name,'\n                sub-menu-toggle">').concat(this.renderIcon("down"),"</span>"))},n}(n),c=function(){var t=function(n,e){return t=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(t,n){t.__proto__=n}||function(t,n){for(var e in n)Object.prototype.hasOwnProperty.call(n,e)&&(t[e]=n[e])},t(n,e)};return function(n,e){if("function"!=typeof e&&null!==e)throw new TypeError("Class extends value "+String(e)+" is not a constructor or null");function o(){this.constructor=n}t(n,e),n.prototype=null===e?Object.create(e):(o.prototype=e.prototype,new o)}}(),l=function(t){function n(){return null!==t&&t.apply(this,arguments)||this}return c(n,t),n.prototype.run=function(){this.hide(),this.handleClickOutside()},n.prototype.hide=function(){this._j(this._submenu_selector).hide()},n.prototype.handleClickOutside=function(){var t=this;this._j(document).on("click",(function(n){if(!n.isDefaultPrevented()){var e=t._j(t._submenu_selector),o=e.parent("li").get(0);o&&t._j.contains(o,n.target)||(e.prev("a").children(t._submenu_button_selector).html(t.renderIcon("down")),e.slideUp(t._fx_duration))}}))},n}(n),a=[new s(jQuery,jentilMenuL10n),new l(jQuery,jentilMenuL10n),new o(jQuery,jentilMenuL10n),new u(jQuery,jentilMenuL10n)];jQuery.each(a,(function(t,n){return n.run()}))}();
//# sourceMappingURL=menu.js.map
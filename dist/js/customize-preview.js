/*! For license information please see customize-preview.js.LICENSE.txt */
!function(){"use strict";var t,n=function(){function t(t,n,o){this._j=t,this._wp=n,this._mod_ids=o}return t.prototype.run=function(){this.update()},t.prototype.replaceShortTags=function(t,n){return this._j.each(t,(function(t,o){n=n.split(t).join(o)})),n},t}(),o=(t=function(n,o){return t=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(t,n){t.__proto__=n}||function(t,n){for(var o in n)Object.prototype.hasOwnProperty.call(n,o)&&(t[o]=n[o])},t(n,o)},function(n,o){if("function"!=typeof o&&null!==o)throw new TypeError("Class extends value "+String(o)+" is not a constructor or null");function r(){this.constructor=n}t(n,o),n.prototype=null===o?Object.create(o):(r.prototype=o.prototype,new r)}),r=function(t){function n(n,o,r,e){var i=t.call(this,n,o,[r])||this;return i._short_tags=e,i}return o(n,t),n.prototype.update=function(){var t=this;this._wp.customize(this._mod_ids[0],(function(n){n.bind((function(n){t._j("#colophon small").html(t.replaceShortTags(t._short_tags,n))}))}))},n}(n),e=function(){var t=function(n,o){return t=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(t,n){t.__proto__=n}||function(t,n){for(var o in n)Object.prototype.hasOwnProperty.call(n,o)&&(t[o]=n[o])},t(n,o)};return function(n,o){if("function"!=typeof o&&null!==o)throw new TypeError("Class extends value "+String(o)+" is not a constructor or null");function r(){this.constructor=n}t(n,o),n.prototype=null===o?Object.create(o):(r.prototype=o.prototype,new r)}}(),i=function(t){function n(){return null!==t&&t.apply(this,arguments)||this}return e(n,t),n.prototype.update=function(){var t=this;this._j.each(this._mod_ids,(function(n,o){t._wp.customize(o,(function(n){n.bind((function(n){t.updateBodyClass(n)}))}))}))},n.prototype.updateBodyClass=function(t){this._j("body").attr("class",(function(t,n){return n.replace(/(^|\s)layout\-\S+/g,"")})).addClass("layout-".concat(t," layout-columns-").concat(t.split("-").length))},n}(n),u=function(){var t=function(n,o){return t=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(t,n){t.__proto__=n}||function(t,n){for(var o in n)Object.prototype.hasOwnProperty.call(n,o)&&(t[o]=n[o])},t(n,o)};return function(n,o){if("function"!=typeof o&&null!==o)throw new TypeError("Class extends value "+String(o)+" is not a constructor or null");function r(){this.constructor=n}t(n,o),n.prototype=null===o?Object.create(o):(r.prototype=o.prototype,new r)}}(),c=function(t){function n(n,o,r,e){var i=t.call(this,n,o,r)||this;return i._short_tags=e,i}return u(n,t),n.prototype.update=function(){var t=this;this._j.each(this._mod_ids,(function(n,o){t._wp.customize(o,(function(n){n.bind((function(n){t._j(".page-title").html(t.replaceShortTags(t._short_tags,n))}))}))}))},n}(n),s=function(){var t=function(n,o){return t=Object.setPrototypeOf||{__proto__:[]}instanceof Array&&function(t,n){t.__proto__=n}||function(t,n){for(var o in n)Object.prototype.hasOwnProperty.call(n,o)&&(t[o]=n[o])},t(n,o)};return function(n,o){if("function"!=typeof o&&null!==o)throw new TypeError("Class extends value "+String(o)+" is not a constructor or null");function r(){this.constructor=n}t(n,o),n.prototype=null===o?Object.create(o):(r.prototype=o.prototype,new r)}}(),p=function(t){function n(){return null!==t&&t.apply(this,arguments)||this}return s(n,t),n.prototype.update=function(){var t=this;this._j.each(this._mod_ids,(function(n,o){t._wp.customize(o,(function(n){n.bind((function(n){t._j("#related-posts-wrap .posts-heading").html(n)}))}))}))},n}(n),a=[new r(jQuery,wp,jentilColophonModId,jentilShortTags),new i(jQuery,wp,jentilPageLayoutModIds),new c(jQuery,wp,jentilPageTitleModIds,jentilShortTags),new p(jQuery,wp,jentilRelatedPostsHeadingModIds)];jQuery.each(a,(function(t,n){return n.run()}))}();
//# sourceMappingURL=customize-preview.js.map
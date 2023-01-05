/**
 * videojs-hls-quality-selector
 * @version 1.0.5
 * @copyright 2019 Chris Boustead (chris@forgemotion.com)
 * @license MIT
 */
! function(t, e) { "object" == typeof exports && "undefined" != typeof module ? module.exports = e(require("video.js")) : "function" == typeof define && define.amd ? define(["video.js"], e) : t.videojsHlsQualitySelector = e(t.videojs) }(this, function(i) { "use strict";
    i = i && i.hasOwnProperty("default") ? i.default : i; var l = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(t) { return typeof t } : function(t) { return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t },
        u = (function() {
            function a(t) { this.value = t }

            function t(i) { var r, l;

                function u(t, e) { try { var n = i[t](e),
                            o = n.value;
                        o instanceof a ? Promise.resolve(o.value).then(function(t) { u("next", t) }, function(t) { u("throw", t) }) : s(n.done ? "return" : "normal", n.value) } catch (t) { s("throw", t) } }

                function s(t, e) { switch (t) {
                        case "return":
                            r.resolve({ value: e, done: !0 }); break;
                        case "throw":
                            r.reject(e); break;
                        default:
                            r.resolve({ value: e, done: !1 }) }(r = r.next) ? u(r.key, r.arg): l = null }
                this._invoke = function(o, i) { return new Promise(function(t, e) { var n = { key: o, arg: i, resolve: t, reject: e, next: null };
                        l ? l = l.next = n : (r = l = n, u(o, i)) }) }, "function" != typeof i.return && (this.return = void 0) } "function" == typeof Symbol && Symbol.asyncIterator && (t.prototype[Symbol.asyncIterator] = function() { return this }), t.prototype.next = function(t) { return this._invoke("next", t) }, t.prototype.throw = function(t) { return this._invoke("throw", t) }, t.prototype.return = function(t) { return this._invoke("return", t) } }(), function(t, e) { if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function") }),
        t = function(t, e) { if ("function" != typeof e && null !== e) throw new TypeError("Super expression must either be null or a function, not " + typeof e);
            t.prototype = Object.create(e && e.prototype, { constructor: { value: t, enumerable: !1, writable: !0, configurable: !0 } }), e && (Object.setPrototypeOf ? Object.setPrototypeOf(t, e) : t.__proto__ = e) },
        s = function(t, e) { if (!t) throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); return !e || "object" != typeof e && "function" != typeof e ? t : e },
        e = i.getComponent("MenuButton"),
        r = i.getComponent("Menu"),
        a = i.getComponent("Component"),
        c = i.dom; var o = function(e) {
            function n(t) { return u(this, n), s(this, e.call(this, t, { title: t.localize("Quality") })) } return t(n, e), n.prototype.createItems = function() { return [] }, n.prototype.createMenu = function() { var t, e = new r(this.player_, { menuButton: this }); if (this.hideThreshold_ = 0, this.options_.title) { var n = c.createEl("li", { className: "vjs-menu-title", innerHTML: (t = this.options_.title, "string" != typeof t ? t : t.charAt(0).toUpperCase() + t.slice(1)), tabIndex: -1 }),
                        o = new a(this.player_, { el: n });
                    this.hideThreshold_ += 1, e.addItem(o) } if (this.items = this.createItems(), this.items)
                    for (var i = 0; i < this.items.length; i++) e.addItem(this.items[i]); return e }, n }(e),
        h = function(r) {
            function l(t, e, n, o) { u(this, l); var i = s(this, r.call(this, t, { label: e.label, selectable: !0, selected: e.selected || !1 })); return i.item = e, i.qualityButton = n, i.plugin = o, i } return t(l, r), l.prototype.handleClick = function() { for (var t = 0; t < this.qualityButton.items.length; ++t) this.qualityButton.items[t].selected(!1);
                this.plugin.setQuality(this.item.value), this.selected(!0) }, l }(i.getComponent("MenuItem")),
        y = {},
        n = i.registerPlugin || i.plugin,
        f = function() {
            function n(t, e) { u(this, n), this.player = t, this.player.qualityLevels && this.getHls() && (this.createQualityButton(), this.bindPlayerEvents()) } return n.prototype.getHls = function() { return this.player.tech({ IWillNotUseThisInPlugins: !0 }).hls }, n.prototype.bindPlayerEvents = function() { this.player.qualityLevels().on("addqualitylevel", this.onAddQualityLevel.bind(this)) }, n.prototype.createQualityButton = function() { var t = this.player;
                this._qualityButton = new o(t); var e = t.controlBar.children().length - 2,
                    n = t.controlBar.addChild(this._qualityButton, { componentClass: "qualitySelector" }, e);
                n.addClass("vjs-quality-selector"), n.menuButton_.$(".vjs-icon-placeholder").className += " vjs-icon-hd", n.removeClass("vjs-hidden") }, n.prototype.getQualityMenuItem = function(t) { var e = this.player; return new h(e, t, this._qualityButton, this) }, n.prototype.onAddQualityLevel = function() { for (var n = this, t = this.player, o = t.qualityLevels().levels_ || [], i = [], e = function(e) { if (!i.filter(function(t) { return t.item && t.item.value === o[e].height }).length) { var t = n.getQualityMenuItem.call(n, { label: o[e].height + "p", value: o[e].height });
                            i.push(t) } }, r = 0; r < o.length; ++r) e(r);
                i.sort(function(t, e) { return "object" !== (void 0 === t ? "undefined" : l(t)) || "object" !== (void 0 === e ? "undefined" : l(e)) ? -1 : t.item.value < e.item.value ? -1 : t.item.value > e.item.value ? 1 : 0 }), i.push(this.getQualityMenuItem.call(this, { label: t.localize("Auto"), value: "auto", selected: !0 })), this._qualityButton && (this._qualityButton.createItems = function() { return i }, this._qualityButton.update()) }, n.prototype.setQuality = function(t) { for (var e = this.player.qualityLevels(), n = 0; n < e.length; ++n) { var o = e[n];
                    o.enabled = o.height === t || "auto" === t }
                this._qualityButton.unpressButton() }, n }(),
        p = function(n) { var o = this;
            this.ready(function() { var t, e;
                t = o, e = i.mergeOptions(y, n), t.addClass("vjs-hls-quality-selector"), t.hlsQualitySelector = new f(t, e) }) }; return n("hlsQualitySelector", p), p.VERSION = "1.0.5", p });
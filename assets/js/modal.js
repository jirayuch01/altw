+function (c) {
    var b = function (e, d) {
        this.options = d;
        this.$body = c(document.body);
        this.$element = c(e);
        this.$backdrop = this.isShown = null;
        this.scrollbarWidth = 0;
        if (this.options.remote) {
            this.$element.find(".modal-content").load(this.options.remote, c.proxy(function () {
                this.$element.trigger("loaded.bs.modal")
            }, this))
        }
    };
    b.DEFAULTS = {
        backdrop: true,
        keyboard: true,
        show: true
    };
    b.prototype.toggle = function (d) {
        return this.isShown ? this.hide() : this.show(d)
    };
    b.prototype.show = function (g) {
        var d = this;
        var f = c.Event("show.bs.modal", {
            relatedTarget: g
        });
        this.$element.trigger(f);
        if (this.isShown || f.isDefaultPrevented()) {
            return
        }
        this.isShown = true;
        this.checkScrollbar();
        this.$body.addClass("modal-open");
        this.setScrollbar();
        this.escape();
        this.$element.on("click.dismiss.bs.modal", '[data-dismiss="modal"]', c.proxy(this.hide, this));
        this.backdrop(function () {
            var i = c.support.transition && d.$element.hasClass("fade");
            if (!d.$element.parent().length) {
                d.$element.appendTo(d.$body)
            }
            d.$element.show().scrollTop(0);
            if (i) {
                d.$element[0].offsetWidth
            }
            d.$element.addClass("in").attr("aria-hidden", false);
            d.enforceFocus();
            var h = c.Event("shown.bs.modal", {
                relatedTarget: g
            });
            i ? d.$element.find(".modal-dialog").one(c.support.transition.end, function () {
                d.$element.trigger("focus").trigger(h)
            }).emulateTransitionEnd(300) : d.$element.trigger("focus").trigger(h)
        })
    };
    b.prototype.hide = function (d) {
        if (d) {
            d.preventDefault()
        }
        d = c.Event("hide.bs.modal");
        this.$element.trigger(d);
        if (!this.isShown || d.isDefaultPrevented()) {
            return
        }
        this.isShown = false;
        this.$body.removeClass("modal-open");
        this.resetScrollbar();
        this.escape();
        c(document).off("focusin.bs.modal");
        this.$element.removeClass("in").attr("aria-hidden", true).off("click.dismiss.bs.modal");
        c.support.transition && this.$element.hasClass("fade") ? this.$element.one(c.support.transition.end, c.proxy(this.hideModal, this)).emulateTransitionEnd(300) : this.hideModal()
    };
    b.prototype.enforceFocus = function () {
        c(document).off("focusin.bs.modal").on("focusin.bs.modal", c.proxy(function (d) {
            if (this.$element[0] !== d.target && !this.$element.has(d.target).length) {
                this.$element.trigger("focus")
            }
        }, this))
    };
    b.prototype.escape = function () {
        if (this.isShown && this.options.keyboard) {
            this.$element.on("keyup.dismiss.bs.modal", c.proxy(function (d) {
                d.which == 27 && this.hide()
            }, this))
        } else {
            if (!this.isShown) {
                this.$element.off("keyup.dismiss.bs.modal")
            }
        }
    };
    b.prototype.hideModal = function () {
        var d = this;
        this.$element.hide();
        this.backdrop(function () {
            d.removeBackdrop();
            d.$element.trigger("hidden.bs.modal")
        })
    };
    b.prototype.removeBackdrop = function () {
        this.$backdrop && this.$backdrop.remove();
        this.$backdrop = null
    };
    b.prototype.backdrop = function (f) {
        var e = this.$element.hasClass("fade") ? "fade" : "";
        if (this.isShown && this.options.backdrop) {
            var d = c.support.transition && e;
            this.$backdrop = c('<div class="modal-backdrop ' + e + '" />').appendTo(this.$body);
            this.$element.on("click.dismiss.bs.modal", c.proxy(function (g) {
                if (g.target !== g.currentTarget) {
                    return
                }
                this.options.backdrop == "static" ? this.$element[0].focus.call(this.$element[0]) : this.hide.call(this)
            }, this));
            if (d) {
                this.$backdrop[0].offsetWidth
            }
            this.$backdrop.addClass("in");
            if (!f) {
                return
            }
            d ? this.$backdrop.one(c.support.transition.end, f).emulateTransitionEnd(150) : f()
        } else {
            if (!this.isShown && this.$backdrop) {
                this.$backdrop.removeClass("in");
                c.support.transition && this.$element.hasClass("fade") ? this.$backdrop.one(c.support.transition.end, f).emulateTransitionEnd(150) : f()
            } else {
                if (f) {
                    f()
                }
            }
        }
    };
    b.prototype.checkScrollbar = function () {
        if (document.body.clientWidth >= window.innerWidth) {
            return
        }
        this.scrollbarWidth = this.scrollbarWidth || this.measureScrollbar()
    };
    b.prototype.setScrollbar = function () {
        var d = parseInt(this.$body.css("padding-right") || 0);
        if (this.scrollbarWidth) {
            this.$body.css("padding-right", d + this.scrollbarWidth)
        }
    };
    b.prototype.resetScrollbar = function () {
        this.$body.css("padding-right", "")
    };
    b.prototype.measureScrollbar = function () {
        var e = document.createElement("div");
        e.className = "modal-scrollbar-measure";
        this.$body.append(e);
        var d = e.offsetWidth - e.clientWidth;
        this.$body[0].removeChild(e);
        return d
    };
    var a = c.fn.modal;
    c.fn.modal = function (d, e) {
        return this.each(function () {
            var h = c(this);
            var g = h.data("bs.modal");
            var f = c.extend({}, b.DEFAULTS, h.data(), typeof d == "object" && d);
            if (!g) {
                h.data("bs.modal", (g = new b(this, f)))
            }
            if (typeof d == "string") {
                g[d](e)
            } else {
                if (f.show) {
                    g.show(e)
                }
            }
        })
    };
    c.fn.modal.Constructor = b;
    c.fn.modal.noConflict = function () {
        c.fn.modal = a;
        return this
    };
    c(document).on("click.bs.modal.data-api", '[data-toggle="modal"]', function (i) {
        var h = c(this);
        var f = h.attr("href");
        var d = c(h.attr("data-target") || (f && f.replace(/.*(?=#[^\s]+$)/, "")));
        var g = d.data("bs.modal") ? "toggle" : c.extend({
            remote: !/#/.test(f) && f
        }, d.data(), h.data());
        if (h.is("a")) {
            i.preventDefault()
        }
        d.modal(g, this).one("hide", function () {
            h.is(":visible") && h.trigger("focus")
        })
    })
}(jQuery);
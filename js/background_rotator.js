(function (b) {
    b.fn.promoSlider = function (a) {
        function c(a) {
            var c = b(window).height();
            c > h.minHeight ? a.height(c - 100) : a.height(h.minHeight)
        }
        function d(a) {
            var c = a.find("li"),
                e = c.has("span:visible");
            e.find("span").animate({
                opacity: 0
            }, 2E3, function () {
                b(this).hide()
            });
            e.children("div").delay(1E3).animate({
                opacity: 0
            }, 1E3, function () {
                b(this).hide()
            });
            e.next().length ? (e.next().find("span").show().animate({
                opacity: 1
            }, 2E3), e.next().children("div").delay(2E3).show().animate({
                opacity: 1
            }, 2E3)) : (c.first().find("span").show().animate({
                opacity: 1
            },
            2E3), c.first().children("div").delay(2E3).show().animate({
                opacity: 1
            }, 2E3));
            window.setTimeout(function () {
                d(a)
            }, 1E4)
        }
        function e(a, c) {
            window.clearTimeout(g);
            if (a.is(":visible")) {
                var d = a.find("ul:eq(0) li"),
                    f = a.find("ul:eq(1) li"),
                    h = d.has(":visible");
                h.stop().animate({
                    opacity: 0
                }, 1E3, function () {
                    b(this).hide()
                });
                h = h.next().length ? h.next() : d.first();
                typeof c !== "undefined" && (h = b(c).index(), h = d.eq(h));
                h.stop().show().animate({
                    opacity: 1
                }, 1E3);
                f.removeClass("active").eq(h.index()).addClass("active");
                g = window.setTimeout(function () {
                    e(a)
                },
                1E4)
            }
        }
        var h = b.extend({
            minHeight: 700,
            maxHeight: function () {
                return b(window).height()
            }
        }, a),
            f = this,
            g = null;
        h.alternate === !0 ? f.each(function () {
            var a = b(this);
            a.find("ul:eq(1)").on("click", "li", function (b) {
                b.preventDefault();
                e(a, this)
            }).find("li:eq(0)").addClass("active");
            g = window.setTimeout(function () {
                e(a)
            }, 5E3)
        }) : (b(window).off("resize.sliderSize").on("resize.sliderSize", function () {
            f.each(function () {
                var a = b(this);
                c(a)
            })
        }), f.each(function () {
            var a = b(this);
            c(a);
            window.setTimeout(function () {
                d(a)
            }, 5E3)
        }))
    }
})(jQuery);
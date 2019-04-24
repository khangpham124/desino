//by Michalis Tzikas
//thanks to www.webhoster.gr & www.michalistzikas.com
//27-04-2011
//v1.3
//web site: http://www.jquery.gr/introtzikas
/*
Copyright (C) 2011 by Michalis Tzikas

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/
!function(i) {
    i.fn.introtzikas = function(s) {
        var t = {
            line: "#F00",
            speedwidth: 2e3,
            speedheight: 1e3,
            speedopacity: 800,
            bg: "#333",
            lineheight: 2
        }, s = i.extend(t, s);
        i("iframe").hide(), i("body").css("overflow-y", "hidden"), i('<div class="introtzikas_bg" style="position:relative;z-index:999999;visibility:visible"><div class="introtzikas" style="visibility:visible"></div></div>').appendTo("body"), 
        i(".introtzikas_bg").css("background-color", s.bg), i(".introtzikas_bg").css("position", "fixed"),
        i(".introtzikas_bg").css("height", "100%"), i(".introtzikas_bg").css("width", "100%"),
        i(".introtzikas_bg").css("top", "0"), i(".introtzikas_bg").css("left", "0"), i(".introtzikas_bg").css("visibility", "visible"),
        i("body").css("visibility", "hidden"), i(".introtzikas").css("background-color", s.line),
        i(".introtzikas").css("position", "fixed"), i(".introtzikas").css("top", "50%"),
        i(".introtzikas").css("height", s.lineheight + "px"), i(".introtzikas").css("width", "0%"),
        i(".introtzikas").css("visibility", "visible"), i(".introtzikas").animate({
            width: "+=100%"
        }, s.speedwidth, function() {
            i(".introtzikas").animate({
                height: "+=100%",
                top: "-=50%"
            }, s.speedheight, function() {
                i("body").attr("style", ""), i("body").css("visibility", "visible"), i(".introtzikas_bg").css("visibility", "hidden"),
                i(".introtzikas").animate({
                    opacity: 0
                }, s.speedopacity, function() {
                    i(".introtzikas_bg").remove(), i("iframe").show(), i("body").css("overflow-y", "visible");
                });
            });
        });
    };
}(jQuery);

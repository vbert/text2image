    /**
     * @author Wojciech Sobczak, wsobczak@gmail.com
     * @copyright (c) 2017
     */
    "use strict";

    var userAgent = navigator.userAgent.toLowerCase(),
        initialDate = new Date(),
        $document = $(document),
        $window = $(window),
        $html = $("html");

    $document.ready(function () {
        /**
         * Debug panel
         * @description Enable Debug info box
         */
        var debugBox = $("#vb-debug");
        var debugH3 = $("#vb-debug-title");
        var toggle = 0;
        if (debugBox.length > 0) {
            debugH3.on('click', function (e) {
                e.preventDefault();
                debugBox.css("bottom");
                var _H = debugBox.height() + 8;
                var _h = debugH3.height() + 18;
                if (toggle === 0) {
                    debugBox.animate({
                        bottom: "10px",
                        opacity: .84
                    }, 500);
                    toggle = 1;
                } else {
                    var delta = _H - _h + 10;
                    debugBox.animate({
                        bottom: -delta,
                        opacity: .4
                    }, 500);
                    toggle = 0;
                }
            });
        }
    });
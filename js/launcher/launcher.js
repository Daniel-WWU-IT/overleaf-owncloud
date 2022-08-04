'use strict';

(function (OC, window, $) {
    $(document).ready(function () {
        $('#overleaf-wrapper').on('load', function () {
            $('#overleaf-wrapper-loading').hide();
        });
    });
})(OC, window, jQuery);

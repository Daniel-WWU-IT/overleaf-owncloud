'use strict';

(function (OC, window, $) {
    const wrapperHeightBuffer = 50;

    $(document).ready(function () {
        $('#overleaf-wrapper').on('load', () => {
            $('#overleaf-wrapper-loading').hide();
        });

        $(window).on('resize', () => {
            _updateWrapperHeight();
        });

        _updateWrapperHeight();
    });

    function _updateWrapperHeight() {
        let winHeight = $(window).height();
        $('#overleaf-wrapper').height(winHeight - wrapperHeightBuffer);
    }
})(OC, window, jQuery);

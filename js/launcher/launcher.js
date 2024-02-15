'use strict';

(function (OC, window, $) {
    const wrapperHeightBuffer = 50;

    $(document).ready(function () {
        $('#overleaf-wrapper').on('load', () => {
            $('#overleaf-wrapper-loading').hide();
            $('#app').css('background-color', '#2c3645');
        });

        // Some window event listeners
        $(window).on('message', (msg) => {
            _handleMessageEvent(msg.originalEvent);
        }).on('resize', () => {
            _updateWrapperHeight();
        });

        _updateWrapperHeight();
    });

    function _handleMessageEvent(event) {
        // Check if the redirect came from the correct Overleaf instance
        let url = new URL(event.origin);
        let origin = $('#overleaf-wrapper').attr('x-origin');
        if (url.hostname.toLowerCase() !== origin.toLowerCase()) {
            console.log("Message received from invalid source");
            return;
        }

        // Handle the event
        switch (event.data) {
            case 'login-page-displayed': // The login page was displayed, so automatically perform a relogin
                let addr = location.href;
                location.href = addr;
                break;
        }
    }

    function _updateWrapperHeight() {
        let winHeight = $(window).height();
        $('#overleaf-wrapper').height(winHeight - wrapperHeightBuffer);
    }
})(OC, window, jQuery);

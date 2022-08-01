'use strict';

class View {
    _handler = null;

    constructor(handler) {
        this._handler = handler;
    }

    render() {
        this._renderContent();
    }

    _getContentData() {
        return {};
    }

    _preRenderContent() {
    }

    _postRenderContent() {
    }

    _renderContent() {
        this._preRenderContent();

        renderHandlebarsTemplate('#content-tpl', '#content-section', this._getContentData());

        let self = this;
        $('#global-message-close-x').click(function () {
            self._hideMessage();
        })

        this._postRenderContent();
    }

    handler() {
        return this._handler;
    }

    _hideMessage() {
        $('#global-message').hide();
    }

    _showMessage(topic, message, style) {
        $('#global-message-header').html(topic);
        $('#global-message-text').html(message);
        $('#global-message').removeClass('message-info message-success message-warning message-error').addClass(style).show();

        window.scrollTo(0, 0);
    }

    infoMessage(topic, message) {
        this._showMessage(topic, message, "message-info");
    }

    successMessage(topic, message) {
        this._showMessage(topic, message, "message-success");
    }

    warningMessage(topic, message) {
        this._showMessage(topic, message, "message-warning");
    }

    errorMessage(topic, message) {
        this._showMessage(topic, message, "message-error");
    }
}

'use strict';

class HandlerResponse {
    _statusCode = 0;
    _message = "";
    _data = null;

    constructor(statusCode, message, data = []) {
        this._statusCode = statusCode;
        this._message = message;
        this._data = data;
    }

    statusCode() {
        return this._statusCode;
    }

    message() {
        return this._message;
    }

    data() {
        return this._data;
    }

    formatMsg(msg) {
        return msg + ': <i>' + this.message() + '</i>.'
    }

    formatError(msg) {
        return msg + ': <i>' + this.message() + ' (code=' + this.statusCode() + ')</i>.'
    }
}

class Handler {
    constructor(baseUrl) {
        this._baseUrl = baseUrl;
    }

    resolve(endpoint) {
        let fullUrl = this._baseUrl;
        if (!fullUrl.endsWith('/') && !endpoint.startsWith('/')) {
            fullUrl += '/';
        }
        return fullUrl + endpoint;
    }

    call(endpoint, method, data = null) {
        let deferred = $.Deferred();
        let self = this;
        $.ajax({
            url: this.resolve(endpoint),
            method: method,
            contentType: 'application/json',
            data: JSON.stringify(data)
        }).done(function (data) {
            // Extract information from the standard HandlerResponse sent by the backend
            deferred.resolve(new HandlerResponse(200, data.message, data.data));
        }).fail(function (resp) {
            // Extract information from the XHR response object
            deferred.reject(new HandlerResponse(resp.status, resp.responseJSON.message, resp.responseJSON.data));
        });
        return deferred.promise();
    }
}

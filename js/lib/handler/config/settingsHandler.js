'use strict';

class SettingsHandler extends Handler {
    getAll() {
        return this.call('get', 'GET');
    }

    getDefaults() {
        return this.call('get/defaults', 'GET');
    }

    save(settings) {
        return this.call('set', 'POST', {settings: JSON.stringify(settings)});
    }
}

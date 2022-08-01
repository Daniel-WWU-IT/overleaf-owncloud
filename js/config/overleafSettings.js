'use strict';

(function (OC, window, $) {
    class SnapshotSettingsView extends View {
        constructor(handler) {
            super(handler);
        }

        _postRenderContent() {
            super._postRenderContent();

            this._bindFormActions();
        }

        _bindFormActions() {
            let self = this;

            $('#settings-save').click(function (event) {
                event.preventDefault();

                self.infoMessage('Saving settings', 'The settings are being saved...');
                self._enableForm(false);

                let settings = self._getSettings();
                self.handler().save(settings).done(function (resp) {
                    self.successMessage('Settings saved', 'The new settings have been saved.');
                    self._enableForm();
                }).fail(function (reason) {
                    self.errorMessage('Settings error', reason.formatError('The settings could not be saved'));
                    self._enableForm();
                });
            });
        }

        _getSettings() {
            return {
                overleaf_url: $('#overleaf-url').val().trim(),
            };
        }

        _setSettings(settings) {
            $('#overleaf-url').val(settings.overleaf_url);
        }

        _enableForm(enable = true) {
            $("#settings-form :input").prop('disabled', !enable);
            $("#settings-form a").each(function ()  {
                if (enable) {
                    $(this).on('click');
                    $(this).css('pointer-events', 'auto');
                } else {
                    $(this).off('click');
                    $(this).css('pointer-events', 'none');
                }
            });
        }
    }

    $(document).ready(function () {
        let handler = new SettingsHandler(OC.generateUrl('/apps/overleaf_sciebo/config'));

        let view = new SnapshotSettingsView(handler);
        view.render();
    });
})(OC, window, jQuery);

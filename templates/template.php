<?php
    // Initialize the template
    if (!isset($_['scope']) || !isset($_['file'])) {
        die("Either the template scope or file weren't specified");
    }

    function _initTemplate($scope, $file) {
        // Styles
        style('overleaf_owncloud', 'overleaf-owncloud');

        style('overleaf_owncloud', $scope . '/' . $file);

        // Scripts
        script('overleaf_owncloud', 'lib/3rdparty/handlebars');
        script('overleaf_owncloud', 'lib/3rdparty/js.cookie');

        script('overleaf_owncloud', 'lib/handler/handler');
        script('overleaf_owncloud', 'lib/handler/config/settingsHandler');
        script('overleaf_owncloud', 'lib/ui/ui');
        script('overleaf_owncloud', 'lib/ui/template/template');
        script('overleaf_owncloud', 'lib/ui/template/helpers');
        script('overleaf_owncloud', 'lib/ui/template/partials');
        script('overleaf_owncloud', 'lib/ui/view/view');
	    script('overleaf_owncloud', 'lib/util/utils');

        script('overleaf_owncloud', $scope . '/' . $file);
    }

    _initTemplate($_['scope'], $_['file']);
?>

<!-- Basic content template -->
<div id="app" style="background-color: #2c3645;">
    <div id="app-content">
        <div id="app-content-wrapper">
            <div class="section">
                <!-- Message display -->
                <div id="global-message" class="message message-info" style="display: none;">
                    <div id="global-message-header" class="message-header">Message topic</div>
                    <div id="global-message-text" class="message-text">Message text</div>
                    <div id="global-message-close" class="message-close"><a id="global-message-close-x"><img src="<?php print_unescaped(image_path('overleaf_owncloud', 'icons/close.svg')); ?>" width="20px"/></a></div>
                </div>

                <!-- Main content -->
                <div id="content-section">
                </div>
            </div>
        </div>
    </div>
</div>

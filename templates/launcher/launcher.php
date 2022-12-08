<!-- This iframe doesn't rely on the templating system -->
<?php
    style('overleaf_owncloud', 'overleaf-owncloud');
    style('overleaf_owncloud', 'launcher/launcher');

    script('overleaf_owncloud', 'launcher/launcher');
?>

<div id="app">
    <div id="app-content">
        <div id="app-content-wrapper">
            <div id="overleaf-wrapper-loading"><i>Loading Overleaf...</i></div>
            <iframe id="overleaf-wrapper" src="<?php p(\OC::$server->getURLGenerator()->linkToRoute("overleaf_owncloud.launch.overleaf_page")); ?>" title="Overleaf" x-origin="<?php p($_['overleaf-origin']); ?>"></iframe>
        </div>
    </div>
</div>

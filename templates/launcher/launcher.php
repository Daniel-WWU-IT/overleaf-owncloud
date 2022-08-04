<!-- This iframe doesn't rely on the templating system -->

<?php
    style('overleaf_sciebo', 'overleaf-sciebo');
    style('overleaf_sciebo', 'launcher/launcher');

    script('overleaf_sciebo', 'launcher/launcher');
?>

<div id="app">
    <div id="app-content">
        <div id="app-content-wrapper">
            <div id="overleaf-wrapper-loading"><i>Loading Overleaf...</i></div>
            <iframe id="overleaf-wrapper" src="<?php p(\OC::$server->getURLGenerator()->linkToRoute("overleaf_sciebo.launch.overleaf_page")); ?>" title="Overleaf"></iframe>
        </div>
    </div>
</div>

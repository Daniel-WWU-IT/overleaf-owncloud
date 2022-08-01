<!-- This iframe doesn't rely on the templating system -->

<?php
    style('overleaf_sciebo', 'overleaf-sciebo');
    style('overleaf_sciebo', 'launcher/launcher');
?>

<div id="app">
    <div id="app-content">
        <div id="app-content-wrapper">
            <iframe id="overleaf-iframe" src="<?php p($_['overleaf_url'])?>" title="Overleaf"></iframe>
        </div>
    </div>
</div>

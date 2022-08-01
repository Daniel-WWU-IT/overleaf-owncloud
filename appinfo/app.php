<?php

\OC::$server->getNavigationManager()->add(function () {
    $urlGenerator = \OC::$server->getURLGenerator();
    return [
        'id' => 'overleaf_sciebo',
        'name' => 'Overleaf',
        'order' => 5,
        'href' => $urlGenerator->linkToRoute('overleaf_sciebo.config.overleaf_settings_page'),
        'icon' => $urlGenerator->imagePath('overleaf_sciebo', 'icons/icon.svg'),
    ];
});

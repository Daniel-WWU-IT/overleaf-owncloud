<?php

use OCA\OverleafSciebo\Util\CurrentUser;

\OC::$server->getNavigationManager()->add(function () {
	$urlGenerator = \OC::$server->getURLGenerator();
	return [
		'id' => 'overleaf_sciebo_launch',
		'name' => 'Overleaf',
		'order' => 8,
		'href' => $urlGenerator->linkToRoute('overleaf_sciebo.launch.launch_page'),
		'icon' => $urlGenerator->imagePath('overleaf_sciebo', 'icons/icon.svg'),
	];
});

if (CurrentUser::isAdmin()) {
	\OC::$server->getNavigationManager()->add(function () {
		$urlGenerator = \OC::$server->getURLGenerator();
		return [
			'id' => 'overleaf_sciebo',
			'name' => 'Overleaf Settings',
			'order' => 10,
			'href' => $urlGenerator->linkToRoute('overleaf_sciebo.config.overleaf_settings_page'),
			'icon' => $urlGenerator->imagePath('overleaf_sciebo', 'icons/icon.svg'),
		];
	});
}

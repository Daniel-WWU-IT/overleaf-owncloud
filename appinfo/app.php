<?php

use OCA\Overleaf\Util\CurrentUser;

\OC::$server->getNavigationManager()->add(function () {
	$urlGenerator = \OC::$server->getURLGenerator();
	return [
		'id' => 'overleaf_owncloud',
		'name' => 'Overleaf',
		'order' => 8,
		'href' => $urlGenerator->linkToRoute('overleaf_owncloud.launch.launch_page'),
		'icon' => $urlGenerator->imagePath('overleaf_owncloud', 'icons/icon.svg'),
	];
});

if (CurrentUser::isAdmin()) {
	\OC::$server->getNavigationManager()->add(function () {
		$urlGenerator = \OC::$server->getURLGenerator();
		return [
			'id' => 'overleaf_owncloud',
			'name' => 'Overleaf Settings',
			'order' => 10,
			'href' => $urlGenerator->linkToRoute('overleaf_owncloud.config.overleaf_settings_page'),
			'icon' => $urlGenerator->imagePath('overleaf_owncloud', 'icons/icon.svg'),
		];
	});
}

\OC::$server->query('OCA\Overleaf\Hooks\UserHooks')->register();

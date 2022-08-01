<?php

return ['routes' => [
	// LaunchController: Pages
	[
		'name' => 'launch#launch_page',
		'url' => '/launcher/launch',
		'verb' => 'GET',
	],

	// ConfigController: API endpoints
	[
		'name' => 'config#get',
		'url' => '/config/get',
		'verb' => 'GET',
	],
	[
		'name' => 'config#get_defaults',
		'url' => '/config/get/defaults',
		'verb' => 'GET',
	],
	[
		'name' => 'config#set',
		'url' => '/config/set',
		'verb' => 'POST',
	],
	// ConfigController: Pages
	[
		'name' => 'config#overleaf_settings_page',
		'url' => '/config/overleaf-settings',
		'verb' => 'GET',
	],
]];

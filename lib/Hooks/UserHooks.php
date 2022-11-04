<?php

namespace OCA\Overleaf\Hooks;

use OCA\Overleaf\Service\OverleafService;
use OCP\IUserManager;

class UserHooks {
	private IUserManager $userManager;
	private OverleafService $overleafService;

	public function __construct($AppName, IUserManager $userManager, OverleafService $overleafService) {
		$this->userManager = $userManager;
		$this->overleafService = $overleafService;
	}

	public function register() {
		$this->userManager->listen('\OC\User', 'postDelete', function ($user) { $this->onPostDeleteUser($user); });
	}

	private function onPostDeleteUser($user) {
		$url = $this->overleafService->generateDeleteUserURL($user);
		file_get_contents($url);
	}
}

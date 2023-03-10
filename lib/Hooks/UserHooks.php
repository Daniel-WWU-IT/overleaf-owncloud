<?php

namespace OCA\Overleaf\Hooks;

use OCA\Overleaf\Service\ConfigService;
use OCA\Overleaf\Service\OverleafService;
use OCA\Overleaf\Util\Requests;
use OCP\IUserManager;

class UserHooks {
	private IUserManager $userManager;
	private OverleafService $overleafService;
    private ConfigService $configService;

	public function __construct($AppName, IUserManager $userManager, OverleafService $overleafService, ConfigService $configService) {
		$this->userManager = $userManager;
		$this->overleafService = $overleafService;
        $this->configService = $configService;
	}

	public function register() {
		$this->userManager->listen('\OC\User', 'postDelete', function ($user) { $this->onPostDeleteUser($user); });
	}

	private function onPostDeleteUser($user) {
		$url = $this->overleafService->generateDeleteUserURL($user);
        Requests::getProtectedContents($url, $this->configService);
	}
}

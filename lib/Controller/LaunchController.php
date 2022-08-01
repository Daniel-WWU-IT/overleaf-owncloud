<?php

namespace OCA\OverleafSciebo\Controller;

use OCA\OverleafSciebo\Service\OverleafService;
use OCA\OverleafSciebo\Util\CurrentUser;

use OCP\IRequest;
use OCP\AppFramework\{
	Controller,
	Http\RedirectResponse
};

class LaunchController extends Controller {
	private OverleafService $overleafService;

	public function __construct($AppName, IRequest $request, OverleafService $overleafService) {
		parent::__construct($AppName, $request);

		$this->overleafService = $overleafService;
	}

	/*** Page endpoints ***/

	/**
	 * @NoAdminRequired
	 */
	public function launchPage() {
		$url = $this->overleafService->generateOverleafURL();
		if ($url == "") {
			return null;
		}
		return new RedirectResponse($url);
	}
}

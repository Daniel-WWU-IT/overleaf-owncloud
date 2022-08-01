<?php

namespace OCA\OverleafSciebo\Controller;

use OCA\OverleafSciebo\Service\OverleafService;

use OCP\IRequest;
use OCP\AppFramework\{
	Controller,
	Http\TemplateResponse
};

use OC\Security\CSP\ContentSecurityPolicy;

class LaunchController extends Controller {
	private OverleafService $overleafService;

	public function __construct($AppName, IRequest $request, OverleafService $overleafService) {
		parent::__construct($AppName, $request);

		$this->overleafService = $overleafService;
	}

	/*** Page endpoints ***/

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function launchPage() {
		$overleafURL = $this->overleafService->generateOverleafURL();
		$host = parse_url($overleafURL, PHP_URL_HOST);
		$data = [
			'overleaf_url' => $overleafURL,
		];
		$resp = new TemplateResponse($this->appName, 'launcher/launcher', $data);
		$csp = new ContentSecurityPolicy();
		$csp->allowInlineScript(true);
		$csp->addAllowedScriptDomain($host);
		$csp->addAllowedFrameDomain($host);
		$csp->addAllowedFrameDomain("blob:");
		$csp->addAllowedChildSrcDomain($host);
		$csp->addAllowedChildSrcDomain("blob:");
		$resp->setContentSecurityPolicy($csp);
		return $resp;
	}
}

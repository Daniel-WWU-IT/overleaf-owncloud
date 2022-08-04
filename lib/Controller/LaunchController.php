<?php

namespace OCA\OverleafSciebo\Controller;

use OCA\OverleafSciebo\Service\OverleafService;

use OCP\IRequest;
use OCP\AppFramework\{Controller, Http\RedirectResponse, Http\TemplateResponse};

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
		$host = $_SERVER['HTTP_HOST'];
		$overleafHost = parse_url($this->overleafService->generateOverleafURL(), PHP_URL_HOST);

		$csp = new ContentSecurityPolicy();
		$csp->allowInlineScript(true);
		$csp->addAllowedScriptDomain($host);
		$csp->addAllowedScriptDomain($overleafHost);
		$csp->addAllowedFrameDomain($host);
		$csp->addAllowedFrameDomain($overleafHost);
		$csp->addAllowedFrameDomain("blob:");
		$csp->addAllowedChildSrcDomain($host);
		$csp->addAllowedChildSrcDomain($overleafHost);
		$csp->addAllowedChildSrcDomain("blob:");

		$resp = new TemplateResponse($this->appName, 'launcher/launcher');
		$resp->setContentSecurityPolicy($csp);
		return $resp;
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function overleafPage() {
		$overleafURL = $this->overleafService->generateOverleafURL();
		$resp = new RedirectResponse($overleafURL);
		return $resp;
	}
}

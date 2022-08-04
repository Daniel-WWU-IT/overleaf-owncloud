<?php

namespace OCA\OverleafSciebo\Controller;

use OCA\OverleafSciebo\Service\OverleafService;
use OCA\OverleafSciebo\Http\HeadersParser;

use OCP\IRequest;
use OCP\AppFramework\{
	Controller,
	Http\RedirectResponse,
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
		$host = $_SERVER['HTTP_HOST'];
		$overleafHost = $this->overleafService->getHost();

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
		$overleafURL = $this->overleafService->generateCreateAndLoginURL();
		$headers = HeadersParser::fromURL($overleafURL);

		$resp = new RedirectResponse($this->overleafService->generateProjectsURL());

		// Add any Overleaf headers to the response
		foreach ($headers->filterHeaders('*sharelatex*') as $key => $value) {
			$resp->addHeader($key, $value);
		}

		// TODO: Cookies... oc setzt Pfad jedoch eigenständig etc.

		return $resp;
	}
}

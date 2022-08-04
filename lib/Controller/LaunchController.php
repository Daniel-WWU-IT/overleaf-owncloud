<?php

namespace OCA\OverleafSciebo\Controller;

use OCA\OverleafSciebo\Service\OverleafService;

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
		/* TODO:
			1) create-and-login muss alle Daten als JSON liefern, die zum Bauen der Redirect Response nötig sind (Headers&Cookies)
			2) Neuer EP in OL für Redirect/Login mit Headers&Cookies
				- Statt Email&Password werden direkt die Headers&Cookies verwendet
				- Eigentlicher Redirect wird so dennoch vom OL Service durchgeführt
			3) Redirect an neuen EP
				- Daten aus vorigem Aufruf müssen übergeben werden (idR Session ID)
				- In Header-Wert als ein JSON-String packen, im OL Svc entpacken
				- EP leitet an OL weiter (s. akt. login())
		*/

		return new RedirectResponse($overleafURL);
	}
}

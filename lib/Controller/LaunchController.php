<?php

namespace OCA\Overleaf\Controller;

use OCA\Overleaf\Service\ConfigService;
use OCA\Overleaf\Service\OverleafService;

use OCA\Overleaf\Util\Requests;
use OCP\IRequest;
use OCP\AppFramework\{Controller, Http\RedirectResponse, Http\TemplateResponse};

use OC\Security\CSP\ContentSecurityPolicy;

class LaunchController extends Controller {
	private OverleafService $overleafService;
    private ConfigService $configService;

	public function __construct($AppName, IRequest $request, OverleafService $overleafService, ConfigService $configService) {
		parent::__construct($AppName, $request);

		$this->overleafService = $overleafService;
        $this->configService = $configService;
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

		$resp = new TemplateResponse($this->appName, 'launcher/launcher', ['overleaf-origin' => $overleafHost]);
		$resp->setContentSecurityPolicy($csp);
		return $resp;
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function overleafPage() {
		// Create and login the user, and use the provided data to redirect to the projects page
		$overleafURL = $this->overleafService->generateCreateAndLoginURL();
        $password = $this->overleafService->generatePassword();
        $data = Requests::getProtectedContents($overleafURL, $this->configService, [Requests::HEADER_PASSWORD => $password]);

        $resp = new RedirectResponse($this->overleafService->generateProjectsURL($data));
		return $resp;
	}
}

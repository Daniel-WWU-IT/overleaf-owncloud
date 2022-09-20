<?php

namespace OCA\Overleaf\Controller;

use Exception;

use OCA\Overleaf\Service\ConfigService;

use OCP\IRequest;
use OCP\AppFramework\{
    Controller,
    Http,
    Http\TemplateResponse,
	Http\DataResponse
};

class ConfigController extends Controller {
    private ConfigService $configService;

    public function __construct($AppName, IRequest $request, ConfigService $configService) {
        parent::__construct($AppName, $request);

        $this->configService = $configService;
    }

    /*** API endpoints ***/

    public function get() {
        return new DataResponse($this->configService->jsonSerialize());
    }

    public function getDefaults() {
        return new DataResponse($this->configService->defaults());
    }

    public function set(string $settings) {
        try {
            $data = json_decode($settings, true);
            $this->configService->jsonDeserialize($data);
            return new DataResponse($this->configService->jsonSerialize());
        } catch (Exception $e) {
            return new DataResponse(['error' => 'Unable to save configuration: ' . $e->getMessage()], Http::STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    /*** Page endpoints ***/

    public function overleafSettingsPage() {
        $data = [
            'config' => $this->configService->jsonSerialize(),
            'defaults' => $this->configService->defaults(),
        ];
        return new TemplateResponse($this->appName, 'config/overleafSettings', $data);
    }
}

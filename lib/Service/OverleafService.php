<?php

namespace OCA\Overleaf\Service;

use OCA\Overleaf\Util\CurrentUser;

class OverleafService {
	private ConfigService $configService;

	public function __construct($AppName, ConfigService $configService) {
		$this->configService = $configService;
	}

	public function getHost() : string {
		$url = $this->configService->getOverleafURL();
		if ($url == "") {
			return "";
		}
		return parse_url($url, PHP_URL_HOST);
	}

	public function generateProjectsURL($userData) : string {
		$url = $this->configService->getOverleafURL();
		if ($url == "") {
			return "";
		}

		// Build the URL and redirect to it
		$params = http_build_query([
			'action' => 'open-projects',
			'data' => $userData,
		]);
		return rtrim($url, '/') . "/regsvc?{$params}";
	}

	public function generateCreateAndLoginURL() : string {
		$url = $this->configService->getOverleafURL();
		if ($url == "") {
			return "";
		}

		$user = CurrentUser::get();
		if ($user == null) {
			return "";
		}

		// Build the URL and redirect to it
		$params = http_build_query([
			'action' => 'create-and-login',
			'email' => $this->normalizeUserID($user->getUID()),
		]);
		return rtrim($url, '/') . "/regsvc?{$params}";
	}

	public function generateDeleteUserURL($user) : string {
		$url = $this->configService->getOverleafURL();
		if ($url == "") {
			return "";
		}

		// Build the URL and redirect to it
		$params = http_build_query([
			'action' => 'delete',
			'email' => $this->normalizeUserID($user->getUID()),
		]);
		return rtrim($url, '/') . "/regsvc?{$params}";
	}

    public function generatePassword(int $length = 64) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        return $randomString;
    }

	private function normalizeUserID($uid) {
		// We need a valid email address
		if (filter_var($uid, FILTER_VALIDATE_EMAIL)) {
			if ($this->configService->getEnforceUserIDSuffix()) {
				$uid = str_replace(['@', '.'], '-', $uid);
			} else {
				return $uid;
			}
		}
		$uid = str_replace('@', '-', $uid);
		$host = $this->configService->getUserIDSuffix();
		if ($host == "") {
			$host = parse_url($this->configService->getOverleafURL(), PHP_URL_HOST);
		}
		return $uid . '@' . $host;
	}
}
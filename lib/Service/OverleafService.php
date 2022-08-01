<?php

namespace OCA\OverleafSciebo\Service;

use OCA\OverleafSciebo\Util\CurrentUser;

class OverleafService {
	private ConfigService $configService;

	public function __construct($AppName, ConfigService $configService) {
		$this->configService = $configService;
	}

	public function generateOverleafURL() : string {
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
			'password' => $this->generatePassword(),
		]);
		return rtrim($url, '/') . "/regsvc?{$params}";
	}

	private function normalizeUserID($uid) {
		// We need a valid email address
		if (filter_var($uid, FILTER_VALIDATE_EMAIL)) {
			return $uid;
		} else {
			$uid = str_replace('@', '-', $uid);
			$host = parse_url($this->configService->getOverleafURL(), PHP_URL_HOST);
			return $uid . '@' . $host;
		}
	}

	private function generatePassword(int $length = 64) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$index = rand(0, strlen($characters) - 1);
			$randomString .= $characters[$index];
		}
		return $randomString;
	}
}
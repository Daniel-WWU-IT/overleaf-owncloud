<?php

namespace OCA\Overleaf\Service;

use Exception;
use JsonSerializable;

use OCP\AppFramework\Http\Response;
use OCP\IConfig;

class ConfigService implements JsonSerializable {
	const SETTING_OVERLEAF_URL = 'overleaf_url';
	const SETTING_API_KEY = 'api_key';
	const SETTING_USERID_SUFFIX = 'userid_suffix';
	const SETTING_USERID_ENFORCE_SUFFIX = 'userid_suffix_enforce';

	private string $appName;
    private IConfig $config;

    private array $settings;

    public function __construct($AppName, IConfig $config) {
		$this->appName = 'overleaf_owncloud'; // Hardcoded since ownCloud sometimes passes an invalid name here
        $this->config = $config;
        $this->settings = $this->defaults();

        try {
            $this->load();
        } catch (Exception $e) {
            // Keep defaults if the loaded settings aren't valid
        }
    }

    public function defaults() {
        $settings = [];
	    foreach ($this->getKeys() as $key) {
			$settings[$key] = "";
	    }
        return $settings;
    }

    private function save() {
        foreach ($this->getKeys() as $key) {
            $this->setValue($key, $this->settings[$key]);
        }
    }

    private function load() {
        $settings = [];
        foreach ($this->getKeys() as $key) {
            $settings[$key] = $this->getValue($key, $this->settings[$key]);
        }
        $this->settings = $settings;
    }

    private function getKeys() {
        return [
			self::SETTING_OVERLEAF_URL,
	        self::SETTING_API_KEY,
	        self::SETTING_USERID_SUFFIX,
	        self::SETTING_USERID_ENFORCE_SUFFIX,
        ];
    }

	public function getOverleafURL() {
		return $this->settings[self::SETTING_OVERLEAF_URL];
	}

	public function getAPIKey() {
		return $this->settings[self::SETTING_API_KEY];
	}

	public function getUserIDSuffix() {
		return $this->settings[self::SETTING_USERID_SUFFIX];
	}

	public function getEnforceUserIDSuffix() {
		return $this->settings[self::SETTING_USERID_ENFORCE_SUFFIX];
	}

	public function config() : IConfig {
		return $this->config;
	}

    public function jsonSerialize() {
        return $this->settings;
    }

    public function jsonDeserialize($data) {
        if (!is_array($data)) {
            return;
        }
        $data = array_map('trim', $data);

        foreach ($this->getKeys() as $key) {
            if (array_key_exists($key, $data)) {
                $this->settings[$key] = $data[$key];
            }
        }

        $this->save();
    }

    private function setValue($name, $value) {
        $this->config->setAppValue($this->appName, $name, strval($value));
    }

    private function getValue($name, $default = '') {
        return $this->config->getAppValue($this->appName, $name, strval($default));
    }
}

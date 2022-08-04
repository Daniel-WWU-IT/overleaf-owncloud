<?php

namespace OCA\OverleafSciebo\Http;

class HeadersParser {
	private array $headers;
	private array $cookies;

	static function fromURL($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		$result = curl_exec($ch);
		curl_close($ch);

		return new HeadersParser($result);
	}

	function __construct($content) {
		$this->parse($content);
	}

	function filterHeaders($name) : array {
		$result = [];
		foreach ($this->headers as $headerBlock) {
			foreach ($headerBlock as $key => $value) {
				if (fnmatch($name, $key, FNM_CASEFOLD)) {
					$result[$key] = $value;
				}
			}
		}
		return $result;
	}

	function filterCookies($name) : array {
		$result = [];
		foreach ($this->cookies as $key => $value) {
			if (fnmatch($name, $key, FNM_CASEFOLD)) {
				$result[$key] = $value;
			}
		}
		return $result;
	}

	function cookies() {
		return $this->cookies;
	}

	private function parse($content) {
		// Get all headers
		$content = str_replace("\r", "", $content);
		$arrRequests = explode("\n\n", $content);
		for ($index = 0; $index < count($arrRequests) - 1; $index++) {
			foreach (explode("\n", $arrRequests[$index]) as $i => $line) {
				if ($i === 0) {
					$headers[$index]['http_code'] = $line;
				} else {
					list ($key, $value) = explode(': ', $line, 2);
					$headers[$index][$key] = $value;
				}
			}
		}
		$this->headers = $headers;

		// Get all cookies
		preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $content, $matches);
		$cookies = array();
		foreach($matches[1] as $item) {
			parse_str($item, $cookie);
			$cookies = array_merge($cookies, $cookie);
		}
		$this->cookies = $cookies;
	}
}

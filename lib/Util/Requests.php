<?php

namespace OCA\Overleaf\Util;

use OCA\Overleaf\Service\ConfigService;

class Requests {
    const HEADER_APIKEY = 'X-Overleaf-Apikey';
    const HEADER_PASSWORD = 'X-Overleaf-Password';

    static public function getProtectedContents(string $url, ConfigService $configService, $extraHeaders = null) {
        $headers = [
            Requests::HEADER_APIKEY => $configService->getAPIKey(),
        ];
        if ($extraHeaders != null) {
            $headers = array_merge($headers, $extraHeaders);
        }

        $opts = [
            "http" => [
                "method" => "GET",
                "header" => Requests::formatHeaders($headers)
            ]
        ];
        $context = stream_context_create($opts);
        return file_get_contents($url, false, $context);
    }

    static private function formatHeaders($headers) {
        $headerText = "";
        foreach ($headers as $key => $value) {
            $headerText .= $key . ": " . $value . "\r\n";
        }
        return $headerText;
    }
}

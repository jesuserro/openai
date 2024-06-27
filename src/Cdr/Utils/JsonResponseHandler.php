<?php

namespace Cdr\Utils;

class JsonResponseHandler {
    public static function handle(string $response): array {
        $responseData = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('Failed to decode JSON response: ' . json_last_error_msg() . ' Response: ' . $response);
        }

        if (!isset($responseData['choices'][0]['message']['content']) && !isset($responseData['id'])) {
            throw new \RuntimeException('Unexpected response structure: ' . $response);
        }

        return $responseData;
    }
}

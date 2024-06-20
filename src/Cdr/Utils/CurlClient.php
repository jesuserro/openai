<?php

namespace Cdr\Utils;

class CurlClient {
    private string $endpointUrl;
    private string $apiKey;

    public function __construct(string $endpointUrl, string $apiKey) {
        $this->endpointUrl = $endpointUrl;
        $this->apiKey = $apiKey;
    }

    public function post(array $data, array $additionalHeaders = []): string {
        $headers = array_merge([
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->apiKey
        ], $additionalHeaders);

        $ch = curl_init($this->endpointUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            throw new \Exception('cURL error: ' . $error_msg);
        }

        curl_close($ch);

        if ($response === false) {
            throw new \Exception('Error executing cURL request.');
        }

        return $response;
    }
}

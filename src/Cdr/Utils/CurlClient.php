<?php

namespace Cdr\Utils;

class CurlClient {
    private string $endpointUrl;
    private array $headers;

    public function __construct(string $endpointUrl, string $apiKey) {
        $this->endpointUrl = $endpointUrl;
        $this->headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey
        ];
    }

    public function post(array $data): string {
        $ch = curl_init($this->endpointUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
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

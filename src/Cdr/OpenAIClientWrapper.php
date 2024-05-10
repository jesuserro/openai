<?php

namespace Cdr;

use OpenAI;

class OpenAIClientWrapper implements OpenAIClientInterface {
    private $client;

    public function __construct(string $apiKey) {
        $this->client = OpenAI::client($apiKey);
    }

    public function chat() {
        return $this->client->chat();
    }
}

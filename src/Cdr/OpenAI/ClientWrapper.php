<?php

namespace Cdr\OpenAI;

use OpenAI;

class ClientWrapper implements ClientInterface {
    private $client;

    public function __construct(string $apiKey) {
        $this->client = OpenAI::client($apiKey);
    }

    public function chat() {
        return $this->client->chat();
    }

    public function retrieve(string $assistantId){
        return  $this->client->assistants()->retrieve($assistantId);
    }
}

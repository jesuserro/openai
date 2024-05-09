<?php

namespace Cdr;

use OpenAI\Client as OpenAIClient;

class OpenAI
{
    private OpenAIClient $client;

    public function __construct(string $apiKey)
    {
        $this->client = \OpenAI::client($apiKey);
    }

    public function sayHello(): string
    {
        $result = $this->client->chat()->create([
            'model' => 'gpt-4',
            'messages' => [
                ['role' => 'user', 'content' => 'Hello!'],
            ],
        ]);

        return $result->choices[0]->message->content; // Hello! How can I assist you today?
    }
}

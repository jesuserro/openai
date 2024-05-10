<?php

namespace Cdr\OpenAI;

class Service {
    private readonly ClientInterface $client;

    public function __construct(ClientInterface $client) {
        $this->client = $client;
    }

    public function sayHello(): string {
        $result = $this->client->chat()->create([
            'model' => 'gpt-4',
            'messages' => [
                ['role' => 'user', 'content' => 'Hello!'],
            ],
        ]);

        return $result->choices[0]->message->content; // Hello! How can I assist you today?
    }

    public function sayCapitalDeEspaña(): string {
        $result = $this->client->chat()->create([
            'model' => 'gpt-4',
            'messages' => [
                ['role' => 'user', 'content' => '¿Cuál es la capital de España?'],
            ],
        ]);

        return $result->choices[0]->message->content; // Madrid
    }
}

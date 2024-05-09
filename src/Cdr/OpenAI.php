<?php

namespace Cdr;

use OpenAI\Client as OpenAIClient;  // Asegúrate de que este use statement esté apuntando al correcto OpenAI\Client que estás utilizando.

class OpenAI
{
    private OpenAIClient $client;  // Esta línea ahora correctamente define el tipo.

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

        return $result->choices[0]->message->content;
    }
}

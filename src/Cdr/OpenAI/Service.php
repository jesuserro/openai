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

        return $result->choices[0]->message->content; // La capital de España es Madrid.
    }

    public function sayColorDelCieloEnLaTierra(): string {
        $result = $this->client->chat()->create([
            'model' => 'gpt-4',
            'messages' => [
                ['role' => 'user', 'content' => '¿De qué color es el cielo en el planeta Tierra?'], // El cielo en el planeta Tierra es generalmente de color azul durante un día despejado. Sin embargo, puede variar en otras condiciones, como al amanecer o al atardecer cuando puede aparecer en tonos de rojo, naranja, rosa o púrpura.
            ],
        ]);

        return $result->choices[0]->message->content; // Azul
    }
}

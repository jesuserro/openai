<?php

namespace Cdr\OpenAI;

class Service {
    private readonly ClientInterface $client;

    public function __construct(ClientInterface $client) {
        $this->client = $client;
    }

    public function sayHello(): string {
        $result = $this->client->chat()->create([
            'model' => 'gpt-4o',
            'messages' => [
                ['role' => 'user', 'content' => 'Hello!'],
            ],
        ]);

        return $result->choices[0]->message->content; 
    }

    public function sayCapitalDeEspaña(): string {
        $result = $this->client->chat()->create([
            'model' => 'gpt-4o',
            'messages' => [
                ['role' => 'user', 'content' => '¿Cuál es la capital de España?'],
            ],
        ]);

        return $result->choices[0]->message->content; 
    }

    public function sayElementoQuimicoOxigeno(): string {
        $result = $this->client->chat()->create([
            'model' => 'gpt-4o',
            'messages' => [
                ['role' => 'user', 'content' => '¿Cuál es el elemento químico con símbolo O?'],
            ],
        ]);

        return $result->choices[0]->message->content; 
    }

    public function sayPlanetaMasGrandeDelSistemaSolar(): string {
        $result = $this->client->chat()->create([
            'model' => 'gpt-4o',
            'messages' => [
                ['role' => 'user', 'content' => '¿Cuál es el planeta más grande del sistema solar?'],
            ],
        ]);

        return $result->choices[0]->message->content; 
    }

    public function sayColorDelCieloEnLaTierra(): string {
        $result = $this->client->chat()->create([
            'model' => 'gpt-4o',
            'messages' => [
                ['role' => 'user', 'content' => '¿De qué color es el cielo en el planeta Tierra?'],
            ],
        ]);

        return $result->choices[0]->message->content; 
    }

    public function sayPaymentMethodsInCentraldereservas(): string {
        $result = $this->client->chat()->create([
            'model' => 'gpt-4o',
            'messages' => [
                ['role' => 'user', 'content' => '¿Cuáles son los métodos de pago en Centraldereservas.com?'],
            ],
        ]);

        return $result->choices[0]->message->content;
    }
}

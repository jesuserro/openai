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

    public function sayElementoQuimicoOxigeno(): string {
        $result = $this->client->chat()->create([
            'model' => 'gpt-4',
            'messages' => [
                ['role' => 'user', 'content' => '¿Cuál es el elemento químico con símbolo O?'],
            ],
        ]);

        return $result->choices[0]->message->content; 
    }

    public function sayPlanetaMasGrandeDelSistemaSolar(): string {
        $result = $this->client->chat()->create([
            'model' => 'gpt-4',
            'messages' => [
                ['role' => 'user', 'content' => '¿Cuál es el planeta más grande del sistema solar?'],
            ],
        ]);

        return $result->choices[0]->message->content; 
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

    public function sayPaymentMethodsInCentraldereservas(): string {
        $result = $this->client->chat()->create([
            'model' => 'gpt-4',
            'messages' => [
                ['role' => 'user', 'content' => '¿Cuáles son los métodos de pago en Centraldereservas.com?'],
            ],
        ]);

        return $result->choices[0]->message->content;
        /*
        En Centraldereservas.com se pueden realizar pagos utilizando diferentes métodos:

            1. Tarjeta de crédito: es el método más común e inmediato. Aceptan la mayoría de las tarjetas como Visa, MasterCard, AMEX, etc.
            
            2. Transferencia bancaria: puedes transferir el monto del pago a su cuenta bancaria. Sin embargo, debes tener en cuenta que la reserva no se confirma hasta que reciben el pago, lo que puede tardar unos días.
            
            3. PayPal: si tienes una cuenta de PayPal, puedes utilizarla para realizar tus pagos.
            
            4. Pago a plazos: algunos establecimientos permiten el pago a plazos.
            
            5. Pago en el hotel: para algunas reservas, Centraldereservas.com ofrece la opción de pagar directamente en el hotel al llegar.
            
            Recuerda que los métodos de pago pueden variar en función al país y al hotel. Antes de realizar una reserva, asegúrate de comprobar los métodos de pago disponibles.
            */
    }
}

<?php

use Cdr\OpenAI\Service as OpenAIService;
use Cdr\OpenAI\ClientInterface;
use PHPUnit\Framework\TestCase;

uses(TestCase::class);

test('sayHello returns correct response', function () {
    $expectedResponse = 'Hello! How can I assist you today?';
    $mockClient = $this->createMock(ClientInterface::class);

    // Creamos un objeto mock que puede tener métodos adicionales
    $mockChat = new class {
        public function create(array $config) {
            return (object) [
                'choices' => [
                    (object) ['message' => (object) ['content' => $config['messages'][0]['content'] . ' How can I assist you today?']]
                ]
            ];
        }
    };

    // Configuramos el método chat para que devuelva nuestro mockChat
    $mockClient->method('chat')->willReturn($mockChat);

    $openAIService = new OpenAIService($mockClient);

    expect($openAIService->sayHello())->toBe($expectedResponse);
});

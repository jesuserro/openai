<?php

use Cdr\OpenAI\Service as OpenAIService;
use Cdr\OpenAI\ClientInterface;
use PHPUnit\Framework\TestCase;

class OpenAIServiceTest extends TestCase {
    public function createMockChat(array $messages): object {
        return new class($messages) {
            private $messages;
            public function __construct(array $messages) {
                $this->messages = $messages;
            }
            public function create(array $config) {
                return (object) [
                    'choices' => [
                        (object) ['message' => (object) ['content' => $config['messages'][0]['content'] . ' How can I assist you today?']]
                    ]
                ];
            }
        };
    }

    public function setUpOpenAIServiceWithMock(array $messages): OpenAIService {
        $mockClient = $this->createMock(ClientInterface::class);
        $mockChat = $this->createMockChat($messages);
    
        $mockClient->method('chat')->willReturn($mockChat);
        return new OpenAIService($mockClient);
    }

    public function testSayHelloReturnsCorrectResponse() {
        
        $messages = [
            ['role' => 'user', 'content' => 'Hello!']
        ];
        $expectedResponse = 'Hello! How can I assist you today?';
        
        $openAIService = $this->setUpOpenAIServiceWithMock($messages);
    
        $this->assertEquals($expectedResponse, $openAIService->sayHello());
    }
}

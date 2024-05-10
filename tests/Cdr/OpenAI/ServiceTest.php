<?php

use Cdr\OpenAI\Service as OpenAIService;
use Cdr\OpenAI\ClientWrapper;
use PHPUnit\Framework\TestCase;

class OpenAIServiceTest extends TestCase {
    public function setUpOpenAIService(): OpenAIService {
        $apiKey = getenv('OPENAI_API_KEY');
        if (!$apiKey) {
            $this->fail('API Key no configurada. Asegúrate de que la variable de entorno OPENAI_API_KEY está establecida.');
        }
        $client = new ClientWrapper($apiKey);
        return new OpenAIService($client);
    }

    public function testSayHelloReturnsExpectedResponse() {
        $openAIService = $this->setUpOpenAIService();
        
        $response = $openAIService->sayHello(); // Hello! How can I assist you today?
        
        $this->assertStringContainsString('Hello!', $response, 'La respuesta debería contener \'Hello!\'.');
    }

    public function testSayCapitalDeEspaña() {
        $openAIService = $this->setUpOpenAIService();
        
        $response = $openAIService->sayCapitalDeEspaña(); // La capital de España es Madrid.
        
        $this->assertStringContainsString('Madrid', $response, 'La respuesta debería contener \'Madrid\'.');
    }
}

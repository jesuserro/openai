<?php

use Cdr\OpenAI\Service as OpenAIService;
use Cdr\OpenAI\ClientWrapper;
use Cdr\OpenAI\ClientInterface;
use Cdr\Questions\Questions\CapitalDeEspañaQuestion;
use Cdr\Questions\Questions\ElementoQuimicoOxigenoQuestion;
use Cdr\Questions\Questions\PaymentMethodsInCentraldereservasQuestion;
use PHPUnit\Framework\TestCase;

class OpenAIServiceTest extends TestCase {
    private $assistantId;

    public function setUp(): void
    {
        $this->assistantId = getenv('OPENAI_ASSISTANT_ID');
        if (!$this->assistantId) {
            $this->fail('Assistant ID no configurado. Asegúrate de que la variable de entorno OPENAI_ASSISTANT_ID está establecida.');
        }
    }

    public function setUpOpenAIService(): OpenAIService {
        $apiKey = getenv('OPENAI_API_KEY');
        if (!$apiKey) {
            $this->fail('API Key no configurada. Asegúrate de que la variable de entorno OPENAI_API_KEY está establecida.');
        }

        $client = new ClientWrapper($apiKey);
        return new OpenAIService($client);
    }

    public function testSayCapitalDeEspaña() {
        $openAIService = $this->setUpOpenAIService();
        $question = new CapitalDeEspañaQuestion();
        
        $response = $openAIService->askQuestion($question);
        
        $this->assertStringContainsString('Madrid', $response, 'La respuesta debería contener \'Madrid\'.');
    }

    public function testSayElementoQuimicoLetraO() {
        $openAIService = $this->setUpOpenAIService();
        $question = new ElementoQuimicoOxigenoQuestion();
        
        $response = $openAIService->askQuestion($question);
        
        $this->assertStringContainsString('oxígeno', $response, 'La respuesta debería contener \'oxígeno\'.');
    }

    public function testSayPaymentMethodsInCentraldereservas() {
        $openAIService = $this->setUpOpenAIService();
        $question = new PaymentMethodsInCentraldereservasQuestion();
        
        $response = $openAIService->askQuestion($question);
        
        $this->assertStringContainsString('Transferencia', $response, 'La respuesta debería contener \'Transferencia\'.');
        $this->assertStringContainsString('PayPal', $response, 'La respuesta debería contener \'PayPal\'.');
    }

    public function testGetAssistant()
    {
        $openAIService = $this->setUpOpenAIService();
        
        $expectedResponse = ['id' => $this->assistantId, 'name' => 'NgesTest-Jesús'];

        $response = $openAIService->getAssistant($this->assistantId);

        $this->assertEquals($expectedResponse['name'], $response['name']);
    }
}

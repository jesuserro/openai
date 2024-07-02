<?php

use Cdr\OpenAI\Service;
use Cdr\OpenAI\ClientWrapper;
use Cdr\Utils\CurlClient;
use Cdr\Questions\Questions\CapitalDeEspañaQuestion;
use Cdr\Questions\Questions\PaymentMethodsInCentraldereservasQuestion;
use PHPUnit\Framework\TestCase;

class OpenAIServiceTest extends TestCase {
    private $assistantId;
    private $apiKey;

    public function setUp(): void
    {
        // Cargar variables de entorno desde el archivo .env.test
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../', '.env.test');
        $dotenv->load();

        $this->assistantId = $_ENV['OPENAI_ASSISTANT_ID'];
        $this->apiKey = $_ENV['OPENAI_API_KEY'];

        if (!$this->assistantId) {
            $this->fail('Assistant ID no configurado. Asegúrate de que la variable de entorno OPENAI_ASSISTANT_ID está establecida.');
        }

        if (!$this->apiKey) {
            $this->fail('API Key no configurada. Asegúrate de que la variable de entorno OPENAI_API_KEY está establecida.');
        }
    }

    public function setUpOpenAIService(): Service {
        $client = new ClientWrapper($this->apiKey);
        $curlClient = new CurlClient('https://api.openai.com/v1/chat/completions', $this->apiKey);
        return new Service($client, $curlClient);
    }

    public function testSayCapitalDeEspaña() {
        $openAIService = $this->setUpOpenAIService();
        $question = new CapitalDeEspañaQuestion();
        
        $response = $openAIService->askQuestion($question);
        
        $this->assertStringContainsString('Madrid', $response, 'La respuesta debería contener \'Madrid\'.');
    }

    public function testSayPaymentMethodsInCentraldereservas() {
        $openAIService = $this->setUpOpenAIService();
        $question = new PaymentMethodsInCentraldereservasQuestion();
        
        $response = $openAIService->askQuestion($question);
        
        $this->assertStringContainsString('Transferencia', $response, 'La respuesta debería contener \'Transferencia\'.');
        $this->assertStringContainsString('PayPal', $response, 'La respuesta debería contener \'PayPal\'.');
    }

    public function testGetAssistant() {
        $openAIService = $this->setUpOpenAIService();
        
        // Expected response structure for the test
        $expectedResponse = ['id' => $this->assistantId, 'name' => 'NgesTest-Jesús'];

        // Make the API call
        $response = $openAIService->getAssistant($this->assistantId);

        // Assertions to verify the response structure
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('name', $response);
        $this->assertEquals($expectedResponse['name'], $response['name']);
        $this->assertEquals($expectedResponse['id'], $response['id']);
    }

    public function testSendMessageToAssistant() {
        $openAIService = $this->setUpOpenAIService();
        $question = new CapitalDeEspañaQuestion();
        $response = $openAIService->sendMessage($question->getQuestion());
    
        $this->assertNotEmpty($response, 'The response should not be empty');

        // Show response data for debugging
        // fwrite(STDERR, print_r($response, true));
    
        // As the response is already decoded and we directly get the content, we don't need to decode it again.
        $this->assertStringContainsString('Madrid', $response, 'La respuesta debería contener \'Madrid\'.');
    }

    public function testThreadedConversation() {
        $openAIService = $this->setUpOpenAIService();
        
        // Create a thread with the first question
        $threadId = $openAIService->createConversationThread('¿Cuál es la capital de España?');
        $this->assertNotEmpty($threadId, 'Thread ID should not be empty');

        // Ask a follow-up question in the same thread
        $secondResponse = $openAIService->sendMessage('¿Qué es conocido por ser el centro cultural de España?', $threadId);
        
        $this->assertStringContainsString('Madrid', $secondResponse, 'La respuesta debería contener \'Madrid\'.');
    }

    public function testObtenerListaTareas()
    {
        $openAIService = $this->setUpOpenAIService();
        
        $result = $openAIService->obtenerListaTareas([], 0, 3);

        $this->assertTrue($result['result']['success']);
        $this->assertCount(3, $result['result']['data']);
        $this->assertEquals(3, $result['result']['total']);
    }

    public function testObtenerResumenTareas()
    {
        $openAIService = $this->setUpOpenAIService();

        $tareas = [
            [
                'id' => 1,
                'nombre' => 'Tarea 1',
                'descripcion' => 'Descripción de la tarea 1',
                'prioridad' => 'Alta'
            ],
            [
                'id' => 2,
                'nombre' => 'Tarea 2',
                'descripcion' => 'Descripción de la tarea 2',
                'prioridad' => 'Media'
            ],
            [
                'id' => 3,
                'nombre' => 'Tarea 3',
                'descripcion' => 'Descripción de la tarea 3',
                'prioridad' => 'Baja'
            ]
        ];

        $resumen = $openAIService->obtenerResumenTareas($tareas);

        $this->assertNotEmpty($resumen, 'El resumen no debería estar vacío');
        $this->assertStringContainsString('Descripción de la tarea 1', $resumen, 'La IA debería identificar correctamente la tarea más urgente.');
    }
}

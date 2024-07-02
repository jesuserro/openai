<?php

namespace Cdr\OpenAI;

use Cdr\Questions\QuestionInterface;
use Cdr\Utils\CurlClient;
use Cdr\Utils\JsonResponseHandler;
use Cdr\Tarea;

class Service {
    private readonly ClientInterface $client;
    private readonly CurlClient $curlClient;
    private readonly Tarea $tarea;

    public function __construct(ClientInterface $client, CurlClient $curlClient) {
        $this->client = $client;
        $this->curlClient = $curlClient;
        $this->tarea = new Tarea();
    }

    public function askQuestion(QuestionInterface $question): string {
        $response = $this->client->chat()->create($this->buildRequestData('user', $question->getQuestion()));
        return $response->choices[0]->message->content;
    }

    public function getAssistant(string $assistantId): array {
        $url = "https://api.openai.com/v1/assistants/{$assistantId}";
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $_ENV['OPENAI_API_KEY'],
            'OpenAI-Beta: assistants=v2'
        ];
        $response = $this->curlClient->get($url, $headers);

        return JsonResponseHandler::handle($response);
    }

    public function sendMessage(string $userMessage, string $assistantId = null): string {
        $data = $this->buildRequestData('user', $userMessage);
        $headers = $assistantId ? ['OpenAI-Thread-Id' => $assistantId] : [];
        $response = $this->curlClient->post($data, $headers);
        
        $responseData = JsonResponseHandler::handle($response);
        return $responseData['choices'][0]['message']['content'];
    }

    public function createConversationThread(string $userMessage): string {
        $data = $this->buildRequestData('user', $userMessage);
        $response = $this->curlClient->post($data);

        $responseData = JsonResponseHandler::handle($response);
        return $responseData['id'];
    }

    private function buildRequestData(string $role, string $content): array {
        return [
            'model' => 'gpt-4o',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                ['role' => $role, 'content' => $content]
            ],
            'temperature' => 0.5,
            'top_p' => 1,
            'n' => 1,
            'stop' => null,
            'presence_penalty' => 0,
            'frequency_penalty' => 0,
        ];
    }

    public function obtenerListaTareas($datos, $start = null, $limit = null)
    {
        $result = $this->tarea->listaTareas($datos, $start, $limit);
        // Aquí puedes hacer alguna acción interesante con el resultado
        // Por ejemplo, procesar los datos y devolver algún análisis
        return $result;
    }
}

<?php

namespace Cdr\OpenAI;

use Cdr\Questions\QuestionInterface;
use Cdr\Utils\CurlClient;

class Service {
    private readonly ClientInterface $client;
    private readonly CurlClient $curlClient;

    public function __construct(ClientInterface $client, CurlClient $curlClient) {
        $this->client = $client;
        $this->curlClient = $curlClient;
    }

    public function askQuestion(QuestionInterface $question): string {
        $response = $this->client->chat()->create($this->buildRequestData('user', $question->getQuestion()));
        return $response->choices[0]->message->content;
    }

    public function getAssistant(string $assistantId) {
        return $this->client->retrieve($assistantId);
    }

    public function sendMessage(string $userMessage, string $assistantId = null): string {
        $data = $this->buildRequestData('user', $userMessage);
        $headers = $assistantId ? ['OpenAI-Thread-Id' => $assistantId] : [];
        $response = $this->curlClient->post($data, $headers);
        
        $responseData = $this->handleApiResponse($response);
        return $responseData['choices'][0]['message']['content'];
    }

    public function createThreadedAssistant(string $userMessage): string {
        $data = $this->buildRequestData('user', $userMessage);
        $response = $this->curlClient->post($data);

        $responseData = $this->handleApiResponse($response);
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

    private function handleApiResponse(string $response): array {
        $responseData = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('Failed to decode JSON response: ' . json_last_error_msg() . ' Response: ' . $response);
        }

        if (!isset($responseData['choices'][0]['message']['content']) && !isset($responseData['id'])) {
            throw new \RuntimeException('Unexpected response structure: ' . $response);
        }

        return $responseData;
    }
}

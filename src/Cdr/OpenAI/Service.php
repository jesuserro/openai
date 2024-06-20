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
        $result = $this->client->chat()->create($this->buildRequestData('user', $question->getQuestion()));
        return $result->choices[0]->message->content;
    }

    public function getAssistant(string $assistantId) {
        return $this->client->retrieve($assistantId);
    }

    public function callOpenAi(string $userMessage): string {
        $data = $this->buildRequestData('user', $userMessage);
        return $this->curlClient->post($data);
    }

    public function createThreadedAssistant(string $userMessage): string {
        $data = $this->buildRequestData('user', $userMessage);
        $response = $this->curlClient->post($data);

        $responseData = json_decode($response, true);
        return $responseData['id'];
    }

    public function askThreadedQuestion(string $assistantId, string $userMessage): string {
        $data = $this->buildRequestData('user', $userMessage);
        $response = $this->curlClient->post($data, ['OpenAI-Thread-Id' => $assistantId]);

        $responseData = json_decode($response, true);
        return $responseData['choices'][0]['message']['content'];
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
}

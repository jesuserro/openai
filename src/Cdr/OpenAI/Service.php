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

    /**
     * @param string $userMessage
     * @return string
     * @throws \Exception
     */
    public function callOpenAi(string $userMessage): string {
        $data = $this->buildRequestData('user', $userMessage);
        return $this->curlClient->post($data);
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

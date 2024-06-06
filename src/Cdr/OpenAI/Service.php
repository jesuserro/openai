<?php

namespace Cdr\OpenAI;

use Cdr\Questions\QuestionInterface;

class Service {
    private readonly ClientInterface $client;

    public function __construct(ClientInterface $client) {
        $this->client = $client;
    }

    public function askQuestion(QuestionInterface $question): string {
        $result = $this->client->chat()->create($this->buildRequestData('user', $question->getQuestion()));

        return $result->choices[0]->message->content;
    }

    public function getAssistant(string $assistantId){
        return $this->client->retrieve($assistantId);
    }

    /**
     * @param string $userMessage
     * @return string
     * @throws \Exception
     */
    public function callOpenAi(string $userMessage): string
    {
        $data = $this->buildRequestData('user', $userMessage);
        return $this->executeCurlRequest($data);
    }

    private function buildRequestData(string $role, string $content): array
    {
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

    private function executeCurlRequest(array $data): string
    {
        $endpointUrl = "https://api.openai.com/v1/chat/completions";
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . getenv('OPENAI_API_KEY')
        ];

        $ch = curl_init($endpointUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            throw new \Exception('cURL error: ' . $error_msg);
        }

        curl_close($ch);

        if ($response === false) {
            throw new \Exception('Error executing cURL request.');
        }

        return $response;
    }
}

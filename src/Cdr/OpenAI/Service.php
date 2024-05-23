<?php

namespace Cdr\OpenAI;

use Cdr\Questions\QuestionInterface;

class Service {
    private readonly ClientInterface $client;

    public function __construct(ClientInterface $client) {
        $this->client = $client;
    }

    public function askQuestion(QuestionInterface $question): string {
        $result = $this->client->chat()->create([
            'model' => 'gpt-4o',
            'messages' => [
                ['role' => 'user', 'content' => $question->getQuestion()],
            ],
        ]);

        return $result->choices[0]->message->content;
    }

    public function getAssistant(string $assistantId): array
    {
        return $this->client->retrieve($assistantId);
    }
}

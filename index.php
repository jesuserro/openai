<?php
require_once 'vendor/autoload.php';

$apiKey = getenv('OPENAI_API_KEY');
if (!$apiKey) {
    die('API Key no configurada. Asegúrate de que la variable de entorno OPENAI_API_KEY está establecida.');
}

$client = OpenAI::client($apiKey);

$result = $client->chat()->create([
    'model' => 'gpt-4',
    'messages' => [
        ['role' => 'user', 'content' => 'Hello!'],
    ],
]);

echo $result->choices[0]->message->content . PHP_EOL; // Hello! How can I assist you today?
<?php
require_once 'vendor/autoload.php';

$yourApiKey = 'YOUR_API_TOKEN';  

$client = OpenAI::client($yourApiKey);

$result = $client->chat()->create([
    'model' => 'gpt-4',
    'messages' => [
        ['role' => 'user', 'content' => 'Hello!'],
    ],
]);

echo $result->choices[0]->message->content; // Hello! How can I assist you today?
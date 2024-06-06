<?php

$apiKey = getenv('OPENAI_API_KEY');
if (!$apiKey) {
    exit("API Key no configurada. Asegúrate de que la variable de entorno OPENAI_API_KEY está establecida.\n");
}

$endpointUrl = "https://api.openai.com/v1/chat/completions";

$data = [
    'model' => 'gpt-3.5-turbo',
    'messages' => [
        ['role' => 'system', 'content' => 'You are a helpful assistant.'],
        ['role' => 'user', 'content' => 'Hello, world!']
    ],
    'temperature' => 0.5,
    'top_p' => 1,
    'n' => 1,
    'stop' => null,
    'presence_penalty' => 0,
    'frequency_penalty' => 0,
];

$headers = [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey
];

$ch = curl_init($endpointUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
curl_close($ch);

echo $response;



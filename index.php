<?php

require_once 'vendor/autoload.php';

use Cdr\OpenAI;
use Cdr\OpenAIClientWrapper;

$apiKey = getenv('OPENAI_API_KEY');
if (!$apiKey) {
    exit('API Key no configurada. Asegúrate de que la variable de entorno OPENAI_API_KEY está establecida.');
}

try {
    $client = new OpenAIClientWrapper($apiKey);
    $OpenAI = new OpenAI($client);
    echo $OpenAI->sayHello() . PHP_EOL;
} catch (\Exception $e) {
    echo 'Error: ' . $e->getMessage();
}

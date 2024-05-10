<?php

require_once 'vendor/autoload.php';

use Cdr\OpenAI\Service as OpenAIService;
use Cdr\OpenAI\ClientWrapper;

$apiKey = getenv('OPENAI_API_KEY');
if (!$apiKey) {
    exit('API Key no configurada. Asegúrate de que la variable de entorno OPENAI_API_KEY está establecida.');
}

try {
    $client = new ClientWrapper($apiKey);
    $openAIService  = new OpenAIService($client);
    echo $openAIService ->sayHello() . PHP_EOL;
    echo $openAIService ->sayPaymentMethodsInCentraldereservas() . PHP_EOL;
} catch (\Exception $e) {
    echo 'Error: ' . $e->getMessage();
}

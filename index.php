<?php

require_once 'vendor/autoload.php';

use Cdr\OpenAI\Service;
use Cdr\OpenAI\ClientWrapper;

use Cdr\Questions\Questions\PaymentMethodsInCentraldereservasQuestion;

$apiKey = getenv('OPENAI_API_KEY');
if (!$apiKey) {
    exit("API Key no configurada. Asegúrate de que la variable de entorno OPENAI_API_KEY está establecida.\n");
}

try {
    $client = new ClientWrapper($apiKey);

    $service = new Service($client); 

    $pagosQuestion = new PaymentMethodsInCentraldereservasQuestion();
    echo $service->askQuestion($pagosQuestion) . PHP_EOL;
} catch (\Exception $e) {
    echo 'Error: ' . $e->getMessage(). PHP_EOL;
}

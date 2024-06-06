<?php

require_once 'vendor/autoload.php';

use Cdr\OpenAI\Service;
use Cdr\OpenAI\ClientWrapper;

use Cdr\Questions\Questions\PaymentMethodsInCentraldereservasQuestion;
use Cdr\Questions\Questions\CapitalDeEspañaQuestion;

$apiKey = getenv('OPENAI_API_KEY');
if (!$apiKey) {
    exit("API Key no configurada. Asegúrate de que la variable de entorno OPENAI_API_KEY está establecida.\n");
}

try {
    
    $client = new ClientWrapper($apiKey);
    $service = new Service($client); 

    // 1. Ejemplo de uso de askQuestion
    $pagosQuestion = new PaymentMethodsInCentraldereservasQuestion();
    echo 'Respuesta a PaymentMethodsInCentraldereservasQuestion: ' . PHP_EOL . $service->askQuestion($pagosQuestion) . PHP_EOL;

    echo PHP_EOL;

    // 2. Ejemplo de uso de callOpenAI
    $capitalMadridQuestion = new CapitalDeEspañaQuestion();
    $response = $service->callOpenAi( $capitalMadridQuestion->getQuestion() );
    $responseData = json_decode($response, true);
    echo 'Respuesta a callOpenAI: ' . PHP_EOL . $responseData['choices'][0]['message']['content'] . PHP_EOL;

} catch (\Exception $e) {

    echo 'Error: ' . $e->getMessage(). PHP_EOL;

}

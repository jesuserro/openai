<?php

require_once 'vendor/autoload.php';

use Cdr\OpenAI\Service;
use Cdr\OpenAI\ClientWrapper;
use Cdr\Questions\Questions\PaymentMethodsInCentraldereservasQuestion;
use Cdr\Questions\Questions\CapitalDeEspañaQuestion;
use Cdr\Utils\Output;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiKey = $_ENV['OPENAI_API_KEY'];
if (!$apiKey) {
    exit("API Key no configurada. Asegúrate de que la variable de entorno OPENAI_API_KEY está establecida.\n");
}

try {
    $client = new ClientWrapper($apiKey);
    $service = new Service($client); 

    // 1. Ejemplo de uso de askQuestion
    $pagosQuestion = new PaymentMethodsInCentraldereservasQuestion();
    $answer = $service->askQuestion($pagosQuestion);
    Output::print('Respuesta a PaymentMethodsInCentraldereservasQuestion: ' . PHP_EOL . $answer);

    Output::print('---');

    // 2. Ejemplo de uso de callOpenAI
    $capitalMadridQuestion = new CapitalDeEspañaQuestion();
    $response = $service->callOpenAi($capitalMadridQuestion->getQuestion());
    $responseData = json_decode($response, true);
    $answer = $responseData['choices'][0]['message']['content']; 
    Output::print('Respuesta a CapitalDeEspañaQuestion: ' . PHP_EOL . $answer);

} catch (\Exception $e) {
    Output::print('Error: ' . $e->getMessage());
}

<?php

require_once 'vendor/autoload.php';

use Cdr\OpenAI\Service;
use Cdr\OpenAI\ClientWrapper;

use Cdr\Questions\Questions\PaymentMethodsInCentraldereservasQuestion;
use Cdr\Questions\Questions\CapitalDeEspañaQuestion;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiKey = $_ENV['OPENAI_API_KEY'];
if (!$apiKey) {
    exit("API Key no configurada. Asegúrate de que la variable de entorno OPENAI_API_KEY está establecida.\n");
}

function output($message) {
    if (php_sapi_name() == "cli") {
        // Ejecutado en la terminal
        echo $message . PHP_EOL;
    } else {
        // Ejecutado en un navegador
        echo nl2br($message) . "<br />";
    }
}

try {
    
    $client = new ClientWrapper($apiKey);
    $service = new Service($client); 

    // 1. Ejemplo de uso de askQuestion
    $pagosQuestion = new PaymentMethodsInCentraldereservasQuestion();
    $answer = $service->askQuestion($pagosQuestion);
    output('Respuesta a PaymentMethodsInCentraldereservasQuestion: ' . PHP_EOL . $answer);

    output('---');

    // 2. Ejemplo de uso de callOpenAI
    $capitalMadridQuestion = new CapitalDeEspañaQuestion();
    $response = $service->callOpenAi( $capitalMadridQuestion->getQuestion() );
    $responseData = json_decode($response, true);
    $answer = $responseData['choices'][0]['message']['content']; 
    output('Respuesta a CapitalDeEspañaQuestion: ' . PHP_EOL . $answer);

} catch (\Exception $e) {

    echo 'Error: ' . $e->getMessage(). PHP_EOL;

}

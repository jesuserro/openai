<?php

require_once 'vendor/autoload.php';

use Cdr\OpenAI\Service;
use Cdr\OpenAI\ClientWrapper;
use Cdr\Utils\CurlClient;
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
    $curlClient = new CurlClient('https://api.openai.com/v1/chat/completions', $apiKey);
    $service = new Service($client, $curlClient);

    // 1. Example askQuestion
    $pagosQuestion = new PaymentMethodsInCentraldereservasQuestion();
    $answer = $service->askQuestion($pagosQuestion);
    Output::print('Respuesta a PaymentMethodsInCentraldereservasQuestion: ' . PHP_EOL . $answer);

    Output::print('---');

    // 2. Second example of another single question
    $CapitalMadridQuestion = new CapitalDeEspañaQuestion();
    $capitalMadridQuestion = $CapitalMadridQuestion->getQuestion();

    $answer = $service->callOpenAi($capitalMadridQuestion);
    Output::print('Respuesta a CapitalDeEspañaQuestion: ' . PHP_EOL . $answer);

    Output::print('---');

    // 3. Example Threaded questions: createThreadedAssistant and askThreadedQuestion
    $threadId = $service->createThreadedAssistant($capitalMadridQuestion);
    Output::print('Thread ID: ' . $threadId);

    $secondResponse = $service->askThreadedQuestion($threadId, '¿Qué es conocido por ser el centro cultural de España?');
    Output::print('Respuesta del hilo a segunda pregunta: ' . PHP_EOL . $secondResponse);

} catch (\Exception $e) {
    Output::print('Error: ' . $e->getMessage());
}

<?php

require_once 'vendor/autoload.php';

use Cdr\OpenAI\Service;
use Cdr\OpenAI\ClientWrapper;
use Cdr\Utils\CurlClient;
use Cdr\Questions\Questions\PaymentMethodsInCentraldereservasQuestion;
use Cdr\Questions\Questions\CapitalDeEspañaQuestion;
use Cdr\Utils\Output;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiKey = $_ENV['OPENAI_API_KEY'];
if (!$apiKey) {
    exit("API Key no configurada. Asegúrate de que la variable de entorno OPENAI_API_KEY está establecida.\n");
}

try {
    $client = new ClientWrapper($apiKey);
    $curlClient = new CurlClient('https://api.openai.com/v1/chat/completions', $apiKey);
    $service = new Service($client, $curlClient);

    // Example 1: Simple question with the Github OpenAi Client (askQuestion)
    handleAskQuestion($service);

    // Example 2: Simple question with CURL (callOpenAi)
    handleCallOpenAi($service);

    // Example 3: Chained questions with createThreadedAssistant and askThreadedQuestion
    handleThreadedQuestions($service);

} catch (\Exception $e) {
    Output::print('Error: ' . $e->getMessage());
}

/**
 * Handle the askQuestion example
 */
function handleAskQuestion(Service $service) {
    $pagosQuestion = new PaymentMethodsInCentraldereservasQuestion();
    $answer = $service->askQuestion($pagosQuestion);
    Output::print('Respuesta a PaymentMethodsInCentraldereservasQuestion: ' . PHP_EOL . $answer);
    Output::print('---');
}

/**
 * Handle the callOpenAi example
 */
function handleCallOpenAi(Service $service) {
    $capitalQuestion = new CapitalDeEspañaQuestion();
    $questionText = $capitalQuestion->getQuestion();
    $answer = $service->callOpenAi($questionText);
    Output::print('Respuesta a CapitalDeEspañaQuestion: ' . PHP_EOL . $answer);
    Output::print('---');
}

/**
 * Handle the threaded questions example
 */
function handleThreadedQuestions(Service $service) {
    $capitalQuestion = new CapitalDeEspañaQuestion();
    $questionText = $capitalQuestion->getQuestion();

    // Create a threaded conversation
    $threadId = $service->createThreadedAssistant($questionText);
    Output::print('Thread ID: ' . $threadId);

    // Ask a follow-up question in the same thread
    $secondResponse = $service->askThreadedQuestion($threadId, '¿Qué es conocido por ser el centro cultural de España?');
    Output::print('Respuesta del hilo a segunda pregunta: ' . PHP_EOL . $secondResponse);
    Output::print('---');
}

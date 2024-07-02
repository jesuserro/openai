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

    // Ejemplo 1: Pregunta simple con askQuestion
    handleAskQuestion($service);

    // Ejemplo 2: Pregunta simple con sendMessage
    handleSendMessage($service);

    // Ejemplo 3: Preguntas encadenadas con createConversationThread y sendMessage
    handleThreadedQuestions($service);

    // Ejemplo 4: Obtener lista de tareas y mostrar el resumen
    handleListaTareas($service);

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
 * Handle the sendMessage example
 */
function handleSendMessage(Service $service) {
    $capitalQuestion = new CapitalDeEspañaQuestion();
    $questionText = $capitalQuestion->getQuestion();
    $answer = $service->sendMessage($questionText);
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
    $threadId = $service->createConversationThread($questionText);
    Output::print('Thread ID: ' . $threadId);

    // Ask a follow-up question in the same thread
    $secondResponse = $service->sendMessage('¿Qué es conocido por ser el centro cultural de España?', $threadId);
    Output::print('Respuesta del hilo a segunda pregunta: ' . PHP_EOL . $secondResponse);
    Output::print('---');
}

/**
 * Handle the listaTareas example
 */
function handleListaTareas(Service $service) {
    $result = $service->obtenerListaTareas([], 0, 3);
    $tareas = $result['result']['data'];
    
    Output::print('Lista de Tareas: ' . PHP_EOL . json_encode($tareas, JSON_PRETTY_PRINT));

    // Generar el resumen de IA
    $resumen = $service->obtenerResumenTareas($tareas);

    Output::print('Resumen de IA: ' . PHP_EOL . $resumen);
    Output::print('---');
}

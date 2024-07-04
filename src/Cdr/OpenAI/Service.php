<?php

namespace Cdr\OpenAI;

use Cdr\Questions\QuestionInterface;
use Cdr\Utils\CurlClient;
use Cdr\Utils\JsonResponseHandler;
use Cdr\Tarea;

class Service {
    private readonly ClientInterface $client;
    private readonly CurlClient $curlClient;
    private readonly Tarea $tarea;

    public function __construct(ClientInterface $client, CurlClient $curlClient) {
        $this->client = $client;
        $this->curlClient = $curlClient;
        $this->tarea = new Tarea();
    }

    public function askQuestion(QuestionInterface $question): string {
        $response = $this->client->chat()->create($this->buildRequestData('user', $question->getQuestion()));
        return $response->choices[0]->message->content;
    }

    public function getAssistant(string $assistantId): array {
        $url = "https://api.openai.com/v1/assistants/{$assistantId}";
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $_ENV['OPENAI_API_KEY'],
            'OpenAI-Beta: assistants=v2'
        ];
        $response = $this->curlClient->get($url, $headers);

        return JsonResponseHandler::handle($response);
    }

    public function sendMessage(string $userMessage, string $assistantId = null): string {
        $data = $this->buildRequestData('user', $userMessage);
        $headers = $assistantId ? ['OpenAI-Thread-Id' => $assistantId] : [];
        $response = $this->curlClient->post($data, $headers);
        
        $responseData = JsonResponseHandler::handle($response);
        return $responseData['choices'][0]['message']['content'];
    }

    public function createConversationThread(string $userMessage): string {
        $data = $this->buildRequestData('user', $userMessage);
        $response = $this->curlClient->post($data);

        $responseData = JsonResponseHandler::handle($response);
        return $responseData['id'];
    }

    private function buildRequestData(string $role, string $content): array {
        return [
            'model' => 'gpt-4o',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                ['role' => $role, 'content' => $content]
            ],
            'temperature' => 0.5,
            'top_p' => 1,
            'n' => 1,
            'stop' => null,
            'presence_penalty' => 0,
            'frequency_penalty' => 0,
        ];
    }

    public function generarResumenTareas(array $tareas): string
    {
        $tareasTexto = array_map(function($tarea) {
            return "ID: {$tarea['id']}, Nombre: {$tarea['nombre']}, Descripción: {$tarea['descripcion']}, Prioridad: {$tarea['prioridad']}";
        }, $tareas);

        $prompt = "Aquí hay una lista de tareas. Por favor, genera un resumen y determina cuál de estas tareas es la más urgente (tarea con prioridad 'Alta'):\n\n" . implode("\n", $tareasTexto);

        $data = $this->buildRequestData('user', $prompt);

        $response = $this->curlClient->post($data);

        $responseData = JsonResponseHandler::handle($response);
        return $responseData['choices'][0]['message']['content'] ?? 'No se pudo generar el resumen.';
    }

    public function getWeatherInCity(string $city, string $unit = 'metric'): string {
        $apiKey = $_ENV['WEATHER_API_KEY'];
        $encodedCity = urlencode($city);
        $url = "http://api.openweathermap.org/data/2.5/weather?q={$encodedCity}&units={$unit}&appid={$apiKey}";
    
        $response = $this->curlClient->get($url);
    
        $weatherData = json_decode($response, true);
        if (isset($weatherData['cod']) && $weatherData['cod'] != 200) {
            throw new \RuntimeException('Error fetching weather data: ' . $weatherData['message']);
        }
    
        $temperature = $weatherData['main']['temp'];
        $description = $weatherData['weather'][0]['description'];
    
        return "The temperature in $city is $temperature ° and the weather is $description.";
    }
}

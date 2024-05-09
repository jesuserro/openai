<?php

require_once 'vendor/autoload.php';

use Cdr\OpenAI;

$apiKey = getenv('OPENAI_API_KEY');
if (!$apiKey) {
    die('API Key no configurada. Asegúrate de que la variable de entorno OPENAI_API_KEY está establecida.');
}

try {
    $OpenAI = new OpenAI($apiKey);
    echo $OpenAI->sayHello() . PHP_EOL;
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}

<?php
namespace Tests\Cdr;

use PHPUnit\Framework\TestCase;
use Cdr\Weather;
use Cdr\Utils\CurlClient;

class WeatherTest extends TestCase {

    private $assistantId;
    private $apiKey;
    private $weatherService;

    public function setUp(): void
    {
        // Cargar variables de entorno desde el archivo .env.test
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../../', '.env.test');
        $dotenv->load();

        $this->assistantId = $_ENV['OPENAI_ASSISTANT_ID'];
        $this->apiKey = $_ENV['WEATHER_API_KEY'];

        if (!$this->assistantId) {
            $this->fail('Assistant ID no configurado. Asegúrate de que la variable de entorno OPENAI_ASSISTANT_ID está establecida.');
        }

        if (!$this->apiKey) {
            $this->fail('API Key no configurada. Asegúrate de que la variable de entorno OPENAI_API_KEY está establecida.');
        }

        // Instanciar Weather
        $curlClientWheater = new CurlClient('http://api.openweathermap.org/data/2.5/weather', $this->apiKey);
        $this->weatherService = new Weather($curlClientWheater, $this->apiKey);
    }

    public function testGetWeatherInCityZaragoza()
    {
        
        $result = $this->weatherService->getWeatherInCity('Zaragoza');

        $this->assertStringContainsString('Zaragoza', $result);

        
    }
}

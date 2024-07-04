<?php

namespace Cdr;

use Cdr\Utils\CurlClient;

class Weather {
    private readonly CurlClient $curlClient;
    private readonly string $apiKey;

    public function __construct(CurlClient $curlClient, string $apiKey) {
        $this->curlClient = $curlClient;
        $this->apiKey = $apiKey;
    }

    public function getWeatherInCity(string $city, string $unit = 'metric'): string {
        $encodedCity = urlencode($city);
        $url = "http://api.openweathermap.org/data/2.5/weather?q={$encodedCity}&units={$unit}&appid={$this->apiKey}";
    
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

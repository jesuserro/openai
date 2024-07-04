# OpenWeatherMap API Documentation

## Endpoint

### Current Weather Data

- **Request:**

GET http://api.openweathermap.org/data/2.5/weather?q=Zaragoza,%20Spain&units=metric&appid={API_KEY}


- **Response:**
```json
{
  "coord": {"lon": -0.8773, "lat": 41.6561},
  "weather": [
    {"id": 800, "main": "Clear", "description": "clear sky", "icon": "01d"}
  ],
  "base": "stations",
  "main": {
    "temp": 30.2,
    "feels_like": 29.28,
    "temp_min": 29.89,
    "temp_max": 30.81,
    "pressure": 1014,
    "humidity": 34,
    "sea_level": 1014,
    "grnd_level": 976
  },
  "visibility": 10000,
  "wind": {"speed": 6.17, "deg": 300},
  "clouds": {"all": 0},
  "dt": 1720100619,
  "sys": {"type": 2, "id": 2003310, "country": "ES", "sunrise": 1720067674, "sunset": 1720122062},
  "timezone": 7200,
  "id": 3104324,
  "name": "Zaragoza",
  "cod": 200
}
```

## Parameters

q: City name along with the country code.
units: Units of measurement. Standard, metric, and imperial units are available.
appid: Your unique API key.

## Example Usage

```php
$apiKey = 'your_api_key';
$city = 'Zaragoza, Spain';
$unit = 'metric';

$url = "http://api.openweathermap.org/data/2.5/weather?q={$city}&units={$unit}&appid={$apiKey}";

$response = file_get_contents($url);
$weatherData = json_decode($response, true);

if (isset($weatherData['cod']) && $weatherData['cod'] == 200) {
    $temperature = $weatherData['main']['temp'];
    $description = $weatherData['weather'][0]['description'];
    echo "The temperature in $city is $temperature ° and the weather is $description.";
} else {
    echo "Error fetching weather data: " . $weatherData['message'];
}
```

# API Documentation

## Available APIs

- [OpenWeatherMap API](API/OpenWeatherMap.md)
- [Other API](API/OtherAPI.md)




<?php
namespace Blixter\Controller\Weather;

use Blixter\Controller\Utilities;
use DateTime;
use DateInterval;

/**
 *
 * Model for WeatherController
 */
class WeatherModel
{
    /**
     *
     *  @var string @apiKey Init the procted API key
     *  @var object @curlModel Init the object 
     *
     */
    protected $apiKey;
    protected $curlModel;

    /**
     *
     * Get and Set the API key
     *
     * @return void
     */
    public function __construct()
    {
        // Get the file where they key is stored
        $keys = require ANAX_INSTALL_PATH . "/config/keys.php";
        $this->apiKey = $keys["darkSkyApiKey"];
        $this->darkSkyUrl = "https://api.darksky.net/forecast";
        $this->curlModel = new Utilities\CurlModel();
    }
    
    /**
     * Send request to Dark sky given coordinates
     *
     * @return array with weather information
     */
    public function fetchData($coordinates)
    {   

        $lat = $coordinates["lat"];
        $lon = $coordinates["lon"];

        $exclude = "exclude=minutely,hourly,currently,alerts,flags"; 
        $extend = "extend=daily&lang=sv&units=auto";
        $url = "$this->darkSkyUrl/$this->apiKey/$lat,$lon?$exclude&$extend"; 
        
        // curl the url and return the weather data
        $jsonResponse = $this->curlModel->curl($url, $json=true);
        
        $weatherData = [];
        foreach($jsonResponse["daily"]["data"] as $weather) {                
            array_push($weatherData, [
                "date" => gmdate("y-m-d", $weather["time"]),
                "summary" => $weather["summary"],
                "icon" => $weather["icon"],
                "temperatureMin" => $weather["temperatureMin"], 
                "temperatureMax" => $weather["temperatureMax"],
                "windSpeed" => $weather["windSpeed"],
                "windGust" => $weather["windGust"],
                "sunriseTime" => $weather["sunriseTime"],
                "sunsetTime" => $weather["sunsetTime"],
                ]);
        }

        // Remove first element in $weatherData, because it's yesterdays weather
        array_shift($weatherData);

        return $weatherData;
    }    

    /**
     * Send request to Dark sky given coordinates
     *
     * @return array with weather information
     */
    public function fetchDataMulti($coordinates)
    {   

        $lat = $coordinates["lat"];
        $lon = $coordinates["lon"];
        $time = new DateTime();
        $unixTime = $time->getTimestamp(); 

        $exclude = "exclude=minutely,hourly,currently,alerts,flags"; 
        $extend = "extend=daily&lang=sv&units=auto";
        
        for ($i = 0; $i < 30; $i++) {
            $unixTime = $time->getTimestamp();
            $time->sub(new DateInterval("P1D"));
            $url = "$this->darkSkyUrl/$this->apiKey/$lat,$lon,$unixTime?$exclude&$extend"; 
            $urls[$i] = $url;
        }
        
        // curl the urls and return the weather data
        $jsonResponse = $this->curlModel->multiCurl($urls, $json=true);

        $weatherData = [];
        foreach($jsonResponse as $weatherDay) {
            foreach ($weatherDay["daily"]["data"] as $weather) {
                array_push($weatherData, [
                    "date" => gmdate("y-m-d", $weather["time"]),
                    "summary" => $weather["summary"],
                    "icon" => $weather["icon"],
                    "temperatureMin" => $weather["temperatureMin"], 
                    "temperatureMax" => $weather["temperatureMax"],
                    "windSpeed" => $weather["windSpeed"],
                    "windGust" => $weather["windGust"],
                    "sunriseTime" => $weather["sunriseTime"],
                    "sunsetTime" => $weather["sunsetTime"],
                    ]);
            }
        }
        return $weatherData;
    }

    /**
     * Get location information from given query.
     *
     * @return array with coordinates
     */
    public function getCoordinates($query)
    {
        // Curl this url with the query and return the coordinates.
        $url = "https://nominatim.openstreetmap.org/?format=json&addressdetails=1&q=$query&limit=1&email=r.blixter89@gmail.com";
        $jsonResponse = $this->curlModel->curl($url, $json=true);
        
        $coords = [
            "lat" => $jsonResponse[0]["lat"],
            "lon" => $jsonResponse[0]["lon"]
        ]; 

        return $coords;
    }
}

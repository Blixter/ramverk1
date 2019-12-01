<?php
namespace Blixter\Weather;

use DateInterval;
use DateTime;

/**
 *
 * Model for WeatherController
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class WeatherModel
{
    /**
     *
     *  @var string @apiKey Init the procted API key
     *  @var object @curlhandler Init the object
     *
     */
    protected $apiKey;
    protected $curlhandler;
    protected $darkSkyUrl;

    /**
     *
     * Get and Set the API key
     *
     * @return void
     */
    public function __construct()
    {
        // Get the file where they key is stored
        $this->darkSkyUrl = "https://api.darksky.net/forecast";
    }

    /**
     *
     * Set the curlhandler
     *
     * @return void
     */
    public function setCurl($ch)
    {
        $this->curlhandler = $ch;
    }

    /**
     *
     * Set the darkSkyUrl
     *
     * @return void
     */
    public function setUrl($url)
    {
        $this->darkSkyUrl = $url;
    }

    /**
     *
     * Set the ApiKey
     *
     * @return void
     */
    public function setApi($key)
    {
        $this->apiKey = $key;
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

        $json = true;
        // curl the url and return the weather data
        $jsonResponse = $this->curlhandler->curl($url, $json);

        $weatherData = [];
        foreach ((array) $jsonResponse["daily"]["data"] as $weather) {
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

        $json = true;

        // curl the urls and return the weather data
        $jsonResponse = $this->curlhandler->multiCurl($urls, $json);

        $weatherData = [];
        foreach ($jsonResponse as $weatherDay) {
            foreach ((array) $weatherDay["daily"]["data"] as $weather) {
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
        $json = true;
        // Curl this url with the query and return the coordinates.
        $url = "https://nominatim.openstreetmap.org/?format=json&addressdetails=1&q=$query&limit=1&email=r.blixter89@gmail.com";
        $jsonResponse = $this->curlhandler->curl($url, $json) ?? null;

        if ($jsonResponse) {
            $coords = [
                "lat" => $jsonResponse[0]["lat"],
                "lon" => $jsonResponse[0]["lon"],
            ];
        } else {
            $coords = null;
        }

        return $coords;
    }
}

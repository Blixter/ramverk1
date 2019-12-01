<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Weather prognos",
            "mount" => "weather",
            "handler" => "\Blixter\Weather\WeatherController",
        ],
    ],
];

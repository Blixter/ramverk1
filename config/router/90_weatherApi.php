<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Weather prognos",
            "mount" => "api/weather",
            "handler" => "\Blixter\Controller\Weather\WeatherApi",
        ],
    ],
];

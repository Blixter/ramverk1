<?php
/**
 * Configuration file for DI container.
 */
return [
    // Services to add to the container.
    "services" => [
        "weather" => [
            "shared" => true,
            "callback" => function () {
                $weather = new \Blixter\Weather\WeatherModel();
                // Load the configuration files
                $weather->setApi("test");
                return $weather;
            },
        ],
    ],
];

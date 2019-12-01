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
                $cfg = $this->get("configuration");
                $config = $cfg->load("keys.php");
                $config = $config["config"] ?? null;
                $weather->setApi($config['darkSkyApiKey']);
                return $weather;
            },
        ],
    ],
];

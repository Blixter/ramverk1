<?php
/**
 * Configuration file for DI container.
 */
return [
    // Services to add to the container.
    "services" => [
        "ipgeo" => [
            "active" => false,
            "shared" => true,
            "callback" => function () {
                $ipgeo = new \Blixter\IpGeolocation\IpGeoModel();
                // Load the configuration files
                $cfg = $this->get("configuration");
                $config = $cfg->load("keys.php");
                $config = $config["config"] ?? null;
                $ipgeo->setApi($config['ipStackApiKey']);
                return $ipgeo;
            },
        ],
    ],
];

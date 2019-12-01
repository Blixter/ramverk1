<?php
/**
 * Configuration file for DI container.
 */
return [
    // Services to add to the container.
    "services" => [
        "curlhandler" => [
            "active" => true,
            "shared" => true,
            "callback" => function () {
                $curlhandler = new \Blixter\Utilities\CurlModel();
                return $curlhandler;
            },
        ],
    ],
];

<?php
/**
 * Configuration file for DI container.
 */
return [

    // Services to add to the container.
    "services" => [
        "curlhandler" => [
            "shared" => true,
            "callback" => function () {
                $curlhandler = new \Blixter\Utilities\CurlModel();
                $curlhandler->setDI($this);

                return $curlhandler;
            }
        ],
    ],
];

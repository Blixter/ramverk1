<?php
/**
 * Configuration file to create router as $di service.
 */

return [
    "services" => [
        "ipvalidation" => [
            "active" => false,
            "shared" => true,
            "callback" => function () {
                $ipvalidation = new \Blixter\IpValidate\IpValidation();
                $ipvalidation->setDI($this);

                return $ipvalidation;
            },
        ],
    ],
];

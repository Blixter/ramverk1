<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Ip-validator",
            "mount" => "ip",
            "handler" => "\Blixter\IpValidate\IpController",
        ],
    ],
];

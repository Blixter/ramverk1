<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Ip-validator to JSON",
            "mount" => "iptojson",
            "handler" => "\Blixter\Controller\IpValidate\IpApiController",
        ],
    ]
];

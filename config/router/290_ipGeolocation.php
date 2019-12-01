<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Ip-geolocator",
            "mount" => "iptogeo",
            "handler" => "\Blixter\IpGeolocation\IpGeoController",
        ],
    ],
];

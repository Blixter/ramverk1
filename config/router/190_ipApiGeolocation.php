<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Ip-geolocator to JSON",
            "mount" => "api/iptogeo",
            "handler" => "\Blixter\IpGeolocation\IpApiGeoController",
        ],
    ],
];

<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Ip-geolocator",
            "mount" => "iptogeo",
            "handler" => "\Blixter\Controller\IpGeolocation\IpGeoController",
        ],
    ]
];

<?php
/**
 * Load the stylechooser as a controller class.
 */
return [
    "routes" => [
        [
            "info" => "Mock api",
            "mount" => "mock",
            "handler" => "\Blixter\Mock\MockApi",
        ],
    ],
];

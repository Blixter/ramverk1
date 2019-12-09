<?php

namespace Blixter\Weather;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class WeatherApi implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;
    /**
     * This is the index method action, it handles:
     * GET METHOD mountpoint
     * GET METHOD mountpoint/
     * GET METHOD mountpoint/index
     *
     * @return Array
     */
    public function indexActionGet(): array
    {
        $request = $this->di->get("request");
        $location = $request->getGet("location");
        // Using ipValidation class from $di.
        $ipValidation = $this->di->get("ipvalidation");
        $isIpValid = $ipValidation->isIpValid($location);
        $ipGeoModel = $this->di->get("ipgeo");
        $curlhandler = $this->di->get("curlhandler");
        $weatherModel = $this->di->get("weather");
        $weatherModel->setCurl($curlhandler);
        $ipGeoModel->setCurl($curlhandler);

        $isLocationValid = $weatherModel->getCoordinates($location);
        $coords = null;

        // Check if the sent location was an valid IP.
        if ($isIpValid) {
            $apiRes = $ipGeoModel->fetchData($location);
            $coords = [
                "lon" => $apiRes["longitude"] ?? null,
                "lat" => $apiRes["latitude"] ?? null,
            ];
        }

        // Check if the sent location was an valid address.
        if ($isLocationValid) {
            $coords = $isLocationValid;
        }

        if ($coords) {
            $weatherChoice = $request->getGet("period");
            if (!$weatherChoice) {
                $weatherChoice = "upcoming";
            }
            if ($weatherChoice === "upcoming") {
                $weatherData = $weatherModel->fetchData($coords);
            } else if ($weatherChoice === "past") {
                $weatherData = $weatherModel->fetchDataMulti($coords);
            }
        }

        $data = [
            "weatherData" => $weatherData ?? "Not valid location",
        ];
        return [$data];
    }
}

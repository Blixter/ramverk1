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
class WeatherController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * This is the index method action, it handles:
     * GET METHOD mountpoint
     * GET METHOD mountpoint/
     * GET METHOD mountpoint/index
     *
     * @return object
     */
    public function indexActionGet(): object
    {
        // Add content as a view and then render the page
        $page = $this->di->get("page");
        $title = "Väder";

        $data = [
            "title" => $title,
        ];

        $page->add("blixter/weather/header", $data);
        $page->add("blixter/weather/search-location", $data);

        // Deal with the action and return a response.
        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the index method action, it handles:
     * POST METHOD mountpoint
     * POST METHOD mountpoint/
     * POST METHOD mountpoint/index
     *
     * @return object
     */
    public function indexActionPost(): object
    {
        // Add content as a view and then render the page
        $page = $this->di->get("page");
        $request = $this->di->get("request");
        $location = $request->getPost("location");
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

        if ($isIpValid) {
            $apiRes = $ipGeoModel->fetchData($location);
            $coords = [
                "lon" => $apiRes["longitude"] ?? null,
                "lat" => $apiRes["latitude"] ?? null,
            ];
        }

        if ($isLocationValid) {
            $coords = $isLocationValid;
        }

        if ($coords) {
            $weatherChoice = $request->getPost("radiochoice");
            if ($weatherChoice === "upcoming") {
                $weatherData = $weatherModel->fetchData($coords);
            } else if ($weatherChoice === "past") {
                $weatherData = $weatherModel->fetchDataMulti($coords);
            }
        }

        $title = "Väderprognos";

        $data = [
            "title" => $title,
            "weatherData" => $weatherData ?? null,
            "coords" => $coords ?? null,
        ];

        $page->add("blixter/weather/header", $data);
        $page->add("blixter/weather/weather-result", $data);

        // Deal with the action and return a response.
        return $page->render([
            "title" => $title,
        ]);
    }
}

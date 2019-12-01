<?php

namespace Blixter\Mock;

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
class MockApi implements ContainerInjectableInterface
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
        $weatherMock = new WeatherMock();

        $res = $weatherMock->getWeatherUpcoming();

        // Deal with the action and return a response.
        return $res;
    }

    /**
     * This is the index method action, it handles:
     * GET METHOD mountpoint/past
     *
     * @return Array
     */
    public function pastActionGet(): array
    {
        $weatherMock = new WeatherMock();

        $res = $weatherMock->getWeatherPast();

        // Deal with the action and return a response.
        return $res;
    }

    /**
     * This is the index method action, it handles:
     * GET METHOD mountpoint/past
     *
     * @return Array
     */
    public function ipActionGet(): array
    {
        $ipMock = new IpMock();

        $res = $ipMock->getIpInfo();

        // Deal with the action and return a response.
        return $res;
    }
}

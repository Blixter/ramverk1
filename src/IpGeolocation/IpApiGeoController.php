<?php

namespace Blixter\IpGeolocation;

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
class IpApiGeoController implements ContainerInjectableInterface
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
        $ipaddress = $request->getGet("ip");
        // Using ipValidation class from $di.
        $ipValidation = $this->di->get("ipvalidation");
        // Get ipgeo from $di
        $curlhandler = $this->di->get("curlhandler");
        $ipGeoModel = $this->di->get("ipgeo");
        $ipGeoModel->setCurl($curlhandler);

        $isIpValid = $ipValidation->isIpValid($ipaddress);

        if ($isIpValid) {
            $domain = $ipValidation->getdomain($ipaddress);
            $apiRes = $ipGeoModel->fetchData($ipaddress);
        }

        $data = [
            "isIpValid" => $isIpValid,
            "domain" => $domain ?? null,
            "apiRes" => $apiRes ?? null,
        ];

        // Deal with the action and return a response.
        return [$data];
    }
}

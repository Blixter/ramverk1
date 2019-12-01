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
class IpGeoController implements ContainerInjectableInterface
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

        $title = "Geolokalisera en Ip-adress";

        $curlhandler = $this->di->get("curlhandler");
        $ipGeoModel = $this->di->get("ipgeo");
        $ipGeoModel->setCurl($curlhandler);

        $request = $this->di->get("request");
        $userIp = $ipGeoModel->getUserIpAddr($request);
        $data = [
            "title" => $title,
            "userIp" => $userIp,
        ];

        $page->add("blixter/ipgeolocation/header", $data);
        $page->add("blixter/ipgeolocation/search-ip", $data);

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

        // Using ipValidation class from $di.
        $ipValidation = $this->di->get("ipvalidation");
        $title = "Geolokalisering av Ip-adress";
        $ipaddress = $request->getPost("ipaddress");

        $curlhandler = $this->di->get("curlhandler");
        $ipGeoModel = $this->di->get("ipgeo");
        $ipGeoModel->setCurl($curlhandler);

        $isIpValid = $ipValidation->isIpValid($ipaddress);

        if ($isIpValid) {
            $protocol = $ipValidation->getProtocol($ipaddress);
            $domain = $ipValidation->getdomain($ipaddress);
            $apiRes = $ipGeoModel->fetchData($ipaddress);
        }

        $data = [
            "title" => $title,
            "ipaddress" => $ipaddress,
            "isIpValid" => $isIpValid,
            "protocol" => $protocol ?? null,
            "domain" => $domain ?? null,
            "apiRes" => $apiRes ?? null,
        ];

        $page->add("blixter/ipgeolocation/header", $data);
        $page->add("blixter/ipgeolocation/ip-result", $data);

        // Deal with the action and return a response.
        return $page->render([
            "title" => $title,
        ]);
    }
}

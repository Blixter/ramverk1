<?php

namespace Blixter\IpValidate;

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
class IpApiController implements ContainerInjectableInterface
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

        $isIpValid = $ipValidation->isIpValid($ipaddress);

        if ($isIpValid) {
            $protocol = $ipValidation->getProtocol($ipaddress);
            $domain = $ipValidation->getdomain($ipaddress);
        }

        $data = [
            "ipaddress" => $ipaddress,
            "isIpValid" => $isIpValid,
            "protocol" => $protocol ?? null,
            "domain" => $domain ?? null,
        ];

        // Deal with the action and return a response.
        return [$data];
    }
}

<?php
namespace Blixter\IpValidate;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class IpValidation implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;
    /**
     * Check if ip-address is valid
     *
     * @return bool
     */
    public function isIpValid($ipAddress)
    {
        if (filter_var($ipAddress, FILTER_VALIDATE_IP)) {
            return true;
        }
        return false;
    }
    /**
     * Return if IPv4 or IPv6 protocol
     *
     * @return string
     */
    public function getProtocol($ipAddress)
    {
        $protocol = "";
        if (filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $protocol = "IPv4";
        }
        if (filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $protocol = "IPv6";
        }
        return $protocol;
    }
    /**
     * Return domain of ip-address
     *
     * @return string
     */
    public function getDomain($ipAddress)
    {
        return gethostbyaddr($ipAddress);
    }
}

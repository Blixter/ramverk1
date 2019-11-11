<?php
namespace Blixter\Controller\IpGeolocation;

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
class IpGeoModel implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;
    /**
     *
     *  @var string @apiKey Init the procted API key
     *
     */
    protected $apiKey;

    /**
     *
     * Get and Set the API key
     *
     * @return void
     */
    public function __construct()
    {
        // Get the file where they key is stored
        $keys = require ANAX_INSTALL_PATH . "/config/keys.php";
        $this->apiKey = $keys["ipStackApiKey"];
    }

    /**
     * Send request to Ip stack with given Ip adress
     *
     * @return array with information about the Ip address
     */
    public function fetchData($ipAddress)
    {
        $ch = curl_init('http://api.ipstack.com/' . $ipAddress . '?access_key=' . $this->apiKey);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Store the returned data
        $response = curl_exec($ch);
        curl_close($ch);

        // Decode to JSON
        $json_response = json_decode($response, true);

        return $json_response;
    }

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

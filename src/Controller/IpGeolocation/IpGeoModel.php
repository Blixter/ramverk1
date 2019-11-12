<?php
namespace Blixter\Controller\IpGeolocation;

/**
 *
 * Model for IpGeoController
 */
class IpGeoModel
{
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

        // Adding MapLink to the JSON response
        $json_response = $this->addMapLink($json_response);

        return $json_response;
    }

    /**
     * Send request to Ip stack with given Ip adress
     *
     * @return array with information about the Ip address
     */
    public function addMapLink($json)
    {
        $latitude = $json["latitude"];
        $longitude = $json["longitude"];
        $json["mapLink"] = "https://www.openstreetmap.org/#map=13/$latitude/$longitude";

        return $json;
    }

    /**
     * Get ip from $request->getServer
     *
     * @return string with current usrs Ip address
     */
    public function getUserIpAddr($request)
    {
        if (!empty($request->getServer('HTTP_CLIENT_IP'))) {
            //ip from share internet
            $ip = $request->getServer('HTTP_CLIENT_IP');
        } elseif (!empty($request->getServer('HTTP_X_FORWARDED_FOR'))) {
            //ip pass from proxy
            $ip = $request->getServer('HTTP_X_FORWARDED_FOR');
        } else {
            $ip = $request->getServer('REMOTE_ADDR');
        }
        return $ip;
    }
}

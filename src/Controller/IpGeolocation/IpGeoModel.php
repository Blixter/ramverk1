<?php

namespace Blixter\Controller\IpGeolocation;

use Blixter\Controller\Utilities;

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
    protected $curlModel;

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
        $this->curlModel = New Utilities\CurlModel();
    }

    /**
     * Send request to Ip stack with given Ip adress
     *
     * @return array with information about the Ip address
     */
    public function fetchData($ipAddress)
    {
        // $curl = curl_init('http://api.ipstack.com/' . $ipAddress . '?access_key=' . $this->apiKey);
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // // Store the returned data
        // $response = curl_exec($curl);
        // curl_close($curl);
        // Decode to JSON
        // $jsonResponse = json_decode($response, true);
        
        $url = 'http://api.ipstack.com/' . $ipAddress . '?access_key=' . $this->apiKey;
        
        $jsonResponse = $this->curlModel->curl($url, $json=true);
        
        // Adding MapLink to the JSON response
        $jsonResponse = $this->addMapLink($jsonResponse);


        return $jsonResponse;
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
            $ipAddr = $request->getServer('HTTP_CLIENT_IP');
        } elseif (!empty($request->getServer('HTTP_X_FORWARDED_FOR'))) {
            //ip pass from proxy
            $ipAddr = $request->getServer('HTTP_X_FORWARDED_FOR');
        } else {
            $ipAddr = $request->getServer('REMOTE_ADDR');
        }
        return $ipAddr;
    }
}

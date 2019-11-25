<?php
namespace Blixter\Controller\Utilities;

/**
 *
 * Model for Curl
 *
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class CurlModel
{
    /**
     * Curl to given url and return an json-response.
     *
     * @param string $url as an url to curl
     * @param bool $json decode response to json if true, Default is false.
     *
     * @return $response
     */
    public function curl($url, $json = false)
    {
        // init curl handler and set url
        $ch = curl_init($url);

        // Return the response, if fail, print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Store the returned data
        $response = curl_exec($ch);

        // Close the curl handler
        curl_close($ch);

        // If $json === true
        if ($json) {
            // Decode to JSON
            $response = json_decode($response, true);
        }


        return $response;
    }

    /**
     * Curl to given urls and return an response.
     *
     * @param array $urls as an array with urls to curl
     * @param bool $json decode response to json if true, Default is false.
     *
     * @return array $response with the responses
     */
    public function multiCurl($urls, $json = false)
    {
        $options = [
            CURLOPT_RETURNTRANSFER => true,
        ];

        // Add the curl handlers.
        // Init the multi curl
        $mh = curl_multi_init();
        $chAll = [];
        foreach ((array) $urls as $url) {
            $ch = curl_init($url);
            curl_setopt_array($ch, $options);
            curl_multi_add_handle($mh, $ch);
            $chAll[] = $ch;
        }

        // Execute the multi curls
        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while ($running);

        // Close the handles
        foreach ($chAll as $ch) {
            curl_multi_remove_handle($mh, $ch);
        }
        curl_multi_close($mh);

        // The requests are done and the result stored in $response
        $response = [];
        foreach ($chAll as $ch) {
            $data = curl_multi_getcontent($ch);
            if ($json) {
                // Decode to JSON
                $response[] = json_decode($data, true);

            } else {
                $response[] = $data;
            }
        }
        return $response;
    }
}

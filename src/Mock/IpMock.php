<?php
namespace Blixter\Mock;

class IpMock
{
    /**
     * Returns a mocked API response from IpStack.
     *
     *
     * @return array $json
     */
    public function getIpInfo(): array
    {
        $json = '{"ip":"8.8.8.8","type":"ipv4","continent_code":"NA","continent_name":"North America","country_code":"US","country_name":"United States","region_code":"CA","region_name":"California","city":"Mountain View","zip":"94043","latitude":37.419158935546875,"longitude":-122.07540893554688,"location":{"geoname_id":5375480,"capital":"Washington D.C.","languages":[{"code":"en","name":"English","native":"English"}],"country_flag":"http:\/\/assets.ipstack.com\/flags\/us.svg","country_flag_emoji":"\ud83c\uddfa\ud83c\uddf8","country_flag_emoji_unicode":"U+1F1FA U+1F1F8","calling_code":"1","is_eu":false}}';

        return [$json];
    }
}

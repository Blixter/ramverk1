<?php
namespace Blixter\Mock;

class WeatherMock
{
    /**
     * Function that takes an coordinate and gets upcomming weather.
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @return array $result
     */
    public function getWeatherUpcoming(): array
    {
        $json = file_get_contents(ANAX_INSTALL_PATH . "/src/Mock/weather-upcoming.json");

        return [$json];
    }
    /**
     * Function that takes an coordinate and get past 30 days weather
     *
     *
     * @return array $result
     */
    public function getWeatherPast(): array
    {

        $json = file_get_contents(ANAX_INSTALL_PATH . "/src/Mock/weather-past.json");

        return [$json];
    }
}

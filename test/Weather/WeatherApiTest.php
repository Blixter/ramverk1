<?php

namespace Blixter\Weather;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class WeatherApiTest extends TestCase
{
    /**
     * Prepare before each test.
     */
    protected function setUp()
    {
        global $di;
        // Set di as global variable
        $this->di = new DIFactoryConfig();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        $this->di->loadServices(ANAX_INSTALL_PATH . "/test/config/di");
        $di = $this->di;
        // Use a different cache dir for unit test
        $this->di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");
        // Get the model from di and set the url for the mock api.
        $this->weather = $di->get("weather");

        // Setup controllerclass
        $this->controller = new WeatherApi();
        $this->controller->setDI($this->di);
    }

    /**
     * Test the route "index".
     */
    public function testIndexActionGetValid()
    {

        $request = $this->di->get("request");
        $request->setGet("location", "8.8.8.8");

        $this->weather->setUrl("http://www.student.bth.se/~rony18/dbwebb-kurser/ramverk1/me/redovisa/htdocs/mock?");

        $res = $this->controller->indexActionGet();
        $this->assertIsArray($res);

        $this->assertArrayHasKey("weatherData", $res[0]);
    }

    /**
     * Test the route "index".
     */
    public function testIndexActionGetPast()
    {
        $request = $this->di->get("request");

        $this->weather->setUrl("http://www.student.bth.se/~rony18/dbwebb-kurser/ramverk1/me/redovisa/htdocs/mock/past?");

        $request->setGet("location", "8.8.8.8");
        $request->setGet("period", "past");

        $res = $this->controller->indexActionGet();
        $this->assertIsArray($res);

        $this->assertArrayHasKey("weatherData", $res[0]);
    }
}

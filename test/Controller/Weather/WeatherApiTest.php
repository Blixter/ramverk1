<?php

namespace Blixter\Controller\Weather;

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
        // Setup di
        $this->di = new DIFactoryConfig();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        // View helpers uses the global $di so it needs its value
        $di = $this->di;

        // Use a different cache dir for unit test
        $di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        // Setup the controller
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
        $request->setGet("location", "8.8.8.8");
        $request->setGet("period", "past");

        $res = $this->controller->indexActionGet();
        $this->assertIsArray($res);

        $this->assertArrayHasKey("weatherData", $res[0]);
    }

    /**
     * Test the route "index".
     */
    public function testIndexActionGetInvalid()
    {
        $request = $this->di->get("request");
        $request->setGet("location", "999.999.999.999");

        $res = $this->controller->indexActionGet();
        $this->assertIsArray($res);
        $this->assertArrayHasKey("weatherData", $res[0]);
    }
}

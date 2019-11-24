<?php

namespace Blixter\Controller\Weather;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class WeatherControllerTest extends TestCase
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
        $this->controller = new WeatherController();
        $this->controller->setDI($this->di);
    }

    /**
     * Test the route "index" GET.
     */
    public function testIndexActionGet()
    {
        $request = $this->di->get("request");

        $request->setGet("title", "Väder");

        $res = $this->controller->indexActionGet();

        $this->assertIsObject($res);
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();
        $exp = "Väder";
        $this->assertContains($exp, $body);
    }

    /**
     * Test the route "index" POST request with a valid IP.
     */
    public function testIndexActionPostValid()
    {
        $request = $this->di->get("request");
        // Valid IPv6
        $request->setPost("location", "2001:4860:4860::8888");

        $res = $this->controller->indexActionPost();

        $this->assertIsObject($res);
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();
        // Div with id madid should exist
        $exp = "mapid";
        $this->assertContains($exp, $body);
    }

    /**
     * Test the route "index" POST request with a valid IP.
     */
    public function testIndexActionPostCity()
    {
        $request = $this->di->get("request");
        // Valid City
        $request->setPost("location", "Göteborg");
        // Upcoming weather prognos
        $request->setPost("radiochoice", "upcoming");

        $res = $this->controller->indexActionPost();

        $this->assertIsObject($res);
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();
        // Div with id madid should exist
        $exp = "mapid";
        $this->assertContains($exp, $body);
    }

    /**
     * Test the route "index" POST request with a valid IP.
     */
    public function testIndexActionPostCountry()
    {
        $request = $this->di->get("request");
        // Valid Country
        $request->setPost("location", "Sweden");
        // Weather prognos for past month
        $request->setPost("radiochoice", "past");

        $res = $this->controller->indexActionPost();

        $this->assertIsObject($res);
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();
        $exp = "mapid";
        $this->assertContains($exp, $body);
    }

    /**
     * Test the route "index" POST request with invalid IP.
     */
    public function testIndexActionPostiInvalid()
    {
        $request = $this->di->get("request");
        // Setup a new post request with in invalid ip-address.
        $request->setPost("location", "129.99.999.21");

        $res = $this->controller->indexActionPost();

        $this->assertIsObject($res);
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();
        $exp = "| ramverk1</title>";
        // Message for invalid location
        $exp2 = "Ip-adressen eller platsen är inte giltlig";
        $this->assertContains($exp, $body);
        $this->assertContains($exp2, $body);
        // div with id=mapid should not exist
        $exp = "mapid";
        $this->assertNotContains($exp, $body);
    }
}

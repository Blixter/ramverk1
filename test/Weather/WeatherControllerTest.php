<?php

namespace Blixter\Weather;

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

        $this->weather->setUrl("http://www.student.bth.se/~rony18/dbwebb-kurser/ramverk1/me/redovisa/htdocs/mock?");

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

        $this->weather->setUrl("http://www.student.bth.se/~rony18/dbwebb-kurser/ramverk1/me/redovisa/htdocs/mock?");

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

        $this->weather->setUrl("http://www.student.bth.se/~rony18/dbwebb-kurser/ramverk1/me/redovisa/htdocs/mock?");

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

        $this->weather->setUrl("http://www.student.bth.se/~rony18/dbwebb-kurser/ramverk1/me/redovisa/htdocs/mock?");

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

        $this->weather->setUrl("http://www.student.bth.se/~rony18/dbwebb-kurser/ramverk1/me/redovisa/htdocs/mock?");

        $this->assertIsObject($res);
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();
        // Message for invalid location
        $exp = "Ip-adressen eller platsen är inte giltlig";
        $this->assertContains($exp, $body);
        // div with id=mapid should not exist
        $exp = "mapid";
        $this->assertNotContains($exp, $body);
    }
}

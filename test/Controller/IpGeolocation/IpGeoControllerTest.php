<?php

namespace Blixter\Controller\IpGeolocation;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class IpGeoControllerTest extends TestCase
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
        $this->controller = new IpGeoController();
        $this->controller->setDI($this->di);
    }

    /**
     * Test the route "index" GET.
     */
    public function testIndexActionGet()
    {
        $request = $this->di->get("request");

        $request->setGet("title", "Ip-adress");
        $request->setServer('HTTP_CLIENT_IP', "8.8.8.8");

        $res = $this->controller->indexActionGet();

        $this->assertIsObject($res);
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();
        $exp = "Geolokalisera en Ip-adress | ramverk1</title>";
        $this->assertContains($exp, $body);
    }

    /**
     * Test the method getUserIpAddr.
     */
    public function testGetUserIpAddr()
    {
        $request = $this->di->get("request");

        $request->setServer('HTTP_CLIENT_IP', "9.9.9.9");
        $res = $this->controller->indexActionGet();
        $body = $res->getBody();
        $this->assertContains("9.9.9.9", $body);

        $request->setServer('HTTP_CLIENT_IP', null);
        $request->setServer('HTTP_X_FORWARDED_FOR', "7.7.7.7");
        $request->setServer('REMOTE_ADDR', '10.10.10.10');
        $res = $this->controller->indexActionGet();
        $body = $res->getBody();
        $this->assertContains("7.7.7.7", $body);

        $request->setServer('HTTP_CLIENT_IP', null);
        $request->setServer('HTTP_X_FORWARDED_FOR', null);
        $res = $this->controller->indexActionGet();
        $body = $res->getBody();
        $this->assertContains("10.10.10.10", $body);
    }

    /**
     * Test the route "index" POST request with a valid IP.
     */
    public function testIndexActionPostValid()
    {
        $request = $this->di->get("request");
        // Valid IPv6
        $request->setPost("ipaddress", "2001:4860:4860::8888");

        $res = $this->controller->indexActionPost();

        $this->assertIsObject($res);
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();
        $exp = "Godkänd";
        $this->assertContains($exp, $body);
        $exp = "mapid";
        $this->assertContains($exp, $body);
        $exp = "IPv6";
        $this->assertContains($exp, $body);
        $exp = "United States";
        $this->assertContains($exp, $body);
    }

    /**
     * Test the route "index" POST request with invalid IP.
     */
    public function testIndexActionPostiInvalid()
    {
        $request = $this->di->get("request");
        // Setup a new post request with in invalid ip-address.
        $request->setPost("ipaddress", "129.99.999.21");

        $res = $this->controller->indexActionPost();

        $this->assertIsObject($res);
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();
        $exp = "| ramverk1</title>";
        $exp2 = "Inte godkänd";
        $this->assertContains($exp, $body);
        $this->assertContains($exp2, $body);
        $exp = "mapid";
        $this->assertNotContains($exp, $body);
    }
}

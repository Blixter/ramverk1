<?php

namespace Blixter\IpValidate;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class IpControllerTest extends TestCase
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
        $this->di->loadServices(ANAX_INSTALL_PATH . "/test/config/di");

        // View helpers uses the global $di so it needs its value
        $di = $this->di;

        // Use a different cache dir for unit test
        $this->di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        // Setup the controller
        $this->controller = new IpController();
        $this->controller->setDI($this->di);
    }

    /**
     * Test the route "index" GET.
     */
    public function testIndexActionGet()
    {
        $request = $this->di->get("request");

        $request->setGet("title", "Validera en Ip-adress");

        $res = $this->controller->indexActionGet();

        $this->assertIsObject($res);
        $this->assertInstanceOf("\Anax\Response\Response", $res);

        $body = $res->getBody();
        $exp = "Validera en Ip-adress";
        $this->assertContains($exp, $body);
    }

    /**
     * Test the route "index".
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
    }

    /**
     * Test the route "index".
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
        // $exp = "| ramverk1</title>";
        $exp2 = "Inte godkänd";
        // $this->assertContains($exp, $body);
        $this->assertContains($exp2, $body);
    }

}

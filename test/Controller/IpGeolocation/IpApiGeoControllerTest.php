<?php

namespace Blixter\Controller\IpGeolocation;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class IpApiGeoControllerTest extends TestCase
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
        $this->controller = new IpApiGeoController();
        $this->controller->setDI($this->di);
    }
    /**
     * Test the route "index".
     */
    public function testIndexActionGetValid()
    {
        $request = $this->di->get("request");
        $request->setGet("ip", "8.8.8.8");

        $res = $this->controller->indexActionGet();
        $this->assertIsArray($res);

        $this->assertArrayHasKey("isIpValid", $res[0]);
        $this->assertEquals(true, $res[0]["isIpValid"]);
        $this->assertArrayHasKey("apiRes", $res[0]);
        $this->assertArrayHasKey("domain", $res[0]);
        $this->assertArrayHasKey("ip", $res[0]["apiRes"]);
        $this->assertArrayHasKey("type", $res[0]["apiRes"]);
        $this->assertArrayHasKey("mapLink", $res[0]["apiRes"]);
    }

    /**
     * Test the route "index".
     */
    public function testIndexActionGetInvalid()
    {
        $request = $this->di->get("request");
        $request->setGet("ip", "999.999.999.999");

        $res = $this->controller->indexActionGet();
        $this->assertIsArray($res);
        $this->assertEquals(false, $res[0]["isIpValid"]);
        $this->assertArrayHasKey("isIpValid", $res[0]);
        $this->assertEmpty($res[0]["apiRes"]);
    }
}

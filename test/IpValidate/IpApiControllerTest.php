<?php

namespace Blixter\IpValidate;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class IpApiControllerTest extends TestCase
{
    /**
     * Test the route "index".
     */
    public function testIndexActionGet()
    {
        global $di;

        // Setup di
        $this->di = new DIFactoryConfig();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        $this->di->loadServices(ANAX_INSTALL_PATH . "/test/config/di");
        $di = $this->di;

        // Use a different cache dir for unit test
        $this->di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");
        $request = $di->get("request");

        // Setup the controller
        $controller = new IpApiController();
        $controller->setDi($di);

        $request->setGet("ip", "8.8.8.8");
        $res = $controller->indexActionGet();
        $this->assertIsArray($res);

        $this->assertArrayHasKey("ipaddress", $res[0]);
        $this->assertArrayHasKey("isIpValid", $res[0]);
        $this->assertArrayHasKey("protocol", $res[0]);
        $this->assertArrayHasKey("domain", $res[0]);
    }
}

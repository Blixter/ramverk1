<?php

namespace Blixter\Mock;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the MockApi Controller.
 */
class MockApiTest extends TestCase
{
    /**
     * Prepare before each test.
     */
    protected function setUp()
    {
        global $di;
        // Set di as global variable
        $this->di = new DIFactoryConfig();
        $di = $this->di;
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        $di->loadServices(ANAX_INSTALL_PATH . "/test/config/di");

        // Use a different cache dir for unit test
        $this->di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        // Setup controllerclass
        $this->controller = new MockApi();
        $this->controller->setDI($this->di);
    }

    /**
     * Test the route "index".
     */
    public function testIndexActionGet()
    {
        $res = $this->controller->indexActionGet();
        $this->assertIsArray($res);
    }

    /**
     * Test the route "/past".
     */
    public function testPastActionGet()
    {
        $res = $this->controller->PastActionGet();
        $this->assertIsArray($res);
    }

    /**
     * Test the route "/ip".
     */
    public function testIpActionGet()
    {
        $res = $this->controller->IpActionGet();
        $this->assertIsArray($res);
    }

}

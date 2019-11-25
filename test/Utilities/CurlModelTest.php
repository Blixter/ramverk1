<?php

namespace Blixter\Controller\Utilities;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the CurlModel.
 */
class CurlModelTest extends TestCase
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

        // Setup the class
        $this->class = new CurlModel();
    }

    /**
     * Test the method multiCurl with json set as true.
     */
    public function testCurl()
    {

        $res = $this->class->Curl("https://rem.dbwebb.se/api/users", true);

        $this->assertIsArray($res);
        $this->assertArrayHasKey("data", $res);
    }

    /**
     * Test the method multiCurl with json set as true.
     */
    public function testMultiCurl()
    {

        $res = $this->class->multiCurl("https://rem.dbwebb.se/api/users", true);

        $this->assertIsArray($res);
        $this->assertArrayHasKey("data", $res[0]);
    }
    
    /**
     * Test the method multiCurl with json set as false.
     */
    public function testMultiCurlJsonFalse()
    {

        $urls = ["https://rem.dbwebb.se/api/users", "https://rem.dbwebb.se/api/users"];

        $res = $this->class->multiCurl($urls, false);

        $this->assertIsArray($res);
    }
}

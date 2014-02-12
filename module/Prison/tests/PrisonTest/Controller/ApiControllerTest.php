<?php
namespace PrisonTest\PrisonTest\Controller;

use PrisonTest\Bootstrap;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase as ControllerTest;

class ApiControllerTest extends ControllerTest
{
    public function setUp()
    {
        $config = Bootstrap::getServiceManager()->get('ApplicationConfig');
        $this->setApplicationConfig($config);
    }

    public function testStoreAction()
    {
        $this->assertTrue(true);
    }
}
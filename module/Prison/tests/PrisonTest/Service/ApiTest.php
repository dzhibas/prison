<?php
namespace PrisonTest\PrisonTest\Service;


use Prison\Model\ApiAuth;
use \Prison\Service\Api;
use Zend\Stdlib\Parameters;

/**
 * Class ApiTest
 * @package ZfcBaseTest\PrisonTest\Service
 */
class ApiTest extends \PHPUnit_Framework_TestCase
{

    public function testSetGetApiAuthModule()
    {
        $apiService = new Api();
        $authModel = new ApiAuth(new Parameters([]));
        $apiService->setAuth($authModel);
        $this->assertEquals($apiService->getAuth(), $authModel);
    }
} 
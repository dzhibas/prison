<?php
namespace Prison\Controller;

use Prison\Service\ApiAuth;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\Http\Response;

class ApiController extends AbstractActionController
{
    public function storeAction()
    {
        $apiAuth = new ApiAuth($this->getEvent());
        $apiAuth->setServiceLocator($this->getServiceLocator());
        $result = $apiAuth->validateKeys();

        if ($result instanceof Response)
            return $result;

        return new JsonModel(array("success" => true));
    }
}
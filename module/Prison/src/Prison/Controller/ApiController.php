<?php
namespace Prison\Controller;

use Prison\Library\ApiAuth;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class ApiController extends AbstractActionController
{
    public function storeAction()
    {
        $apiAuth = new ApiAuth($this->getRequest());
        $vars = $apiAuth->extractAuthVars();
        return new JsonModel(array("vars" => $vars, "success" => true));
    }
}

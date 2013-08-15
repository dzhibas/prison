<?php
namespace Prison\Controller;

use Prison\Service\ApiAuth;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Exception;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;
use Zend\Http\Response;
use Zend\Http\Request;

class ApiController extends AbstractActionController
{
    protected $authVars;

    public function storeAction()
    {
        /**
         * at this point project is validated and keys is good
         * next step process sentry_data and insert data into database
         * 1. if its not straight json decode and decompress sentry_data
         * 2. safely json decode
         * 3. validate data provided (project, data, auth.client)
         * 4. group normalize event data (data)
         * 5. insert data to database or any other store (Redis for example)
         */
        if ($this->getRequest()->isPost()) {
            return new JsonModel(array("success" => true));
        } else if ($this->getRequest()->isGet()) {
            # Javascript clients
            # We should return a simple 1x1 gif for browser so they don't throw a warning
            /** @var Response $response */
            $response = $this->getResponse();
            $response->setContent(PIXEL);
            $response->getHeaders()->addHeaders(array(
                'Content-Type' => 'image/gif',
            ));
            return $response;
        }
        $this->getResponse()->setStatusCode(Response::STATUS_CODE_405);
        $this->getResponse()->setContent("Method not allowed");
        return $this->getResponse();
    }

    public function onDispatch(MvcEvent $e)
    {
        /**
         * 1. extract auth vars
         * 2. check client version support
         * 3. get project from auth vars if fails respnse
         * 4. project id match with auth pub key project
         * 5. gen api auth var
         */
        $apiAuthService = new ApiAuth($e);
        $apiAuthService->setServiceLocator($this->getServiceLocator());
        $result = $apiAuthService->validateKeys();

        if ($result instanceof Response)
            return $result;

        $this->authVars = new \Prison\Model\ApiAuth($result);

        return parent::onDispatch($e);
    }
}
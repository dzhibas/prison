<?php
namespace Prison\Service;

use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Parameters;

class ApiAuth implements ServiceLocatorAwareInterface
{
    protected $request;
    protected $response;
    protected $event;
    protected $service;
    protected $key;

    public function __construct(MvcEvent $e)
    {
        $this->request = $e->getRequest();
        $this->response = $e->getResponse();
        $this->event = $e;
    }

    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->service = $serviceLocator;
    }

    /**
     * Get service locator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->service;
    }

    /**
     * @return Parameters
     */
    public function extractAuthVars()
    {
        $sentryKeys = array();
        if (substr($this->request->getHeader('HTTP_X_SENTRY_AUTH', ''), 0, 6) == "Sentry") {
            return $this->parseHeader($this->request->getHeader('HTTP_X_SENTRY_AUTH'));
        } else if (substr($this->request->getHeader('HTTP_AUTHORIZATION', ''), 0, 6) == "Sentry") {
            return $this->parseHeader($this->request->getHeader('HTTP_AUTHORIZATION'));
        } else {
            foreach ($this->request->getQuery() as $qKey => $qVal) {
                if (substr($qKey, 0, 7) == "sentry_") {
                    $sentryKeys[$qKey] = $qVal;
                }
            }
        }
        return new Parameters($sentryKeys);
    }

    /**
     * @param $headerValue string
     * @return Parameters
     */
    public function parseHeader($headerValue)
    {
        $params = new Parameters();
        $params->fromString($headerValue);
        return $params;
    }

    /**
     * @return \Zend\Stdlib\ResponseInterface
     */
    public function validateKeys()
    {
        $authVariables = $this->extractAuthVars();

        if (!$authVariables->get('sentry_key', false)) {
            return $this->forbidden();   
        }

        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $projectKey = $em->getRepository('Prison\Entity\ProjectKey')->findOneBy(array("publicKey" => $authVariables['sentry_key']));

        if (!$projectKey) {
            return $this->forbidden();
        }

        if ($authVariables->get('sentry_secret', $projectKey->getSecretKey()) != $projectKey->getSecretKey()) {
            return $this->forbidden();
        }

        $this->setProjectKey($projectKey);

        return $authVariables;
    }

    /**
     * @param $key \Prison\Entity\ProjectKey
     */
    public function setProjectKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return \Prison\Entity\ProjectKey
     */
    public function getProjectKey()
    {
        return $this->key;
    }

    /**
     * @return \Prison\Entity\ProjectKey
     */
    public function getKey()
    {
        return $this->getProjectKey();
    }

    /**
     * @return null|\Prison\Entity\Project
     */
    public function getProject()
    {
        if ($this->getProjectKey())
            return $this->getProjectKey()->getProject();

        return NULL;
    }

    /**
     * @internal param string $message
     * @return \Zend\Stdlib\ResponseInterface
     */
    protected function forbidden()
    {
        $response = $this->event->getResponse();
        $response->setStatusCode(Response::STATUS_CODE_403);
        $response->sendHeaders();
        exit;
    }
}
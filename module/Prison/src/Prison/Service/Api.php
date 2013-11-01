<?php
namespace Prison\Service;

use Prison\Model;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Api implements ServiceLocatorAwareInterface
{
    protected $service;
    /** @var  \Prison\Model\ApiAuth */
    protected $auth;
    protected $data;

    public function __construct()
    {
    }

    /**
     * @param mixed $auth
     */
    public function setAuth(Model\ApiAuth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @return mixed
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        if (is_array($data)) {
            $this->data = $data;
            return;
        }

        // if its not json try to decompress
        if (substr($data, 0, 1) !== "{")
        {
            try {
                $data = base64_decode($data);
            } catch (\Exception $e) {}
            try {
                $data = gzuncompress($data);
            } catch (\Exception $e) {}
        }

        $data = json_decode($data, true);

        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
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
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->service;
    }
}
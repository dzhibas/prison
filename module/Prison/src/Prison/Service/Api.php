<?php
namespace Prison\Service;

use Prison\Model;
use Zend\Log\Logger;
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
                $data = gzuncompress($data);
            } catch (\Exception $e) {}
        }

        $data = json_decode($data, true);
        if ($data === null)
        {
            /** @var Logger $log */
            $log = $this->getServiceLocator()->get('Log\Prison');
            $log->crit($this->auth . " " . $this->json_last_error_msg());
            $this->data = array();
        } else {
            $this->data = $data;
        }
    }

    public function json_last_error_msg()
    {
        switch (json_last_error()) {
            default:
                return;
            case JSON_ERROR_DEPTH:
                $error = 'Maximum stack depth exceeded';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $error = 'Underflow or the modes mismatch';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $error = 'Unexpected control character found';
                break;
            case JSON_ERROR_SYNTAX:
                $error = 'Syntax error, malformed JSON';
                break;
            case JSON_ERROR_UTF8:
                $error = 'Malformed UTF-8 characters, possibly incorrectly encoded';
                break;
        }
        return $error;
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
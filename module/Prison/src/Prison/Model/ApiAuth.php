<?php
namespace Prison\Model;

use Prison\Entity\ProjectKey;
use Zend\Stdlib\Parameters;

class ApiAuth
{
    protected $client;
    protected $version;
    protected $secretKey;
    protected $publicKey;

    /** @var ProjectKey */
    protected $projectKey;

    public function __construct(Parameters $authVars)
    {
        $this->setClient($authVars->get('sentry_client'));
        $this->setPublicKey($authVars->get('sentry_key'));
        $this->setSecretKey($authVars->get('sentry_secret'));
        $this->setVersion($authVars->get('sentry_version'));
        $this->setProjectKey($authVars->get('projectKey'));
    }

    /**
     * @param ProjectKey $projectKey
     */
    public function setProjectKey($projectKey)
    {
        $this->projectKey = $projectKey;
    }

    /**
     * @return ProjectKey
     */
    public function getProjectKey()
    {
        return $this->projectKey;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $publicKey
     */
    public function setPublicKey($publicKey)
    {
        $this->publicKey = $publicKey;
    }

    /**
     * @return mixed
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * @param mixed $secretKey
     */
    public function setSecretKey($secretKey)
    {
        $this->secretKey = $secretKey;
    }

    /**
     * @return mixed
     */
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     * @param mixed $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }

    public function toArray()
    {
        return array(
            "version" => $this->getVersion(),
            "publicKey" => $this->getPublicKey(),
            "secretKey" => $this->getSecretKey(),
            "projectKeyId" => $this->getProjectKey()->getId(),
            "client" => $this->getClient(),
        );
    }

    public function __toString()
    {
        return sprintf("%s (%s:%s)", $this->getClient(), $this->getPublicKey(), $this->getSecretKey());
    }

}
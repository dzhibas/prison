<?php
namespace Prison\Form;

use Zend\Di\ServiceLocator;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Project extends Form implements InputFilterProviderInterface, ServiceLocatorAwareInterface
{
    /** @var ServiceLocatorInterface */
    protected $service;

    public function __construct(ServiceLocatorInterface $service)
    {
        $this->service = $service;
        parent::__construct();

        $this->add(array(
            "name" => "name",
            "options" => array(
                "label" => "Project name"
            ),
            'attributes' => array(
                'type'  => 'text',
            ),
        ));

        $config = $this->getServiceLocator()->get("config");
        $platformOptions = array();
        foreach($config['prison']['platforms'] as $name) {
            $platformOptions[$name] = $name;
        }

        $this->add(array(
            "type" => 'Zend\Form\Element\Select',
            "name" => "platform",
            "options" => array(
                "label" => "Project platform",
                'value_options' => $platformOptions,
            ),
            "attributes" => array(
                "type" => "select",
                "value" => "php",
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'csrf',
            'options' => array(
                'csrf_options' => array(
                    'timeout' => 600
                )
            )
        ));

        $this->add(array(
            "type" => "submit",
            "name" => "submit",
            "attributes" => array("value" => "Create new project", "class" => "ui blue submit button"),
        ));
    }

    public function getInputFilterSpecification()
    {
        return array(
            "name" => array( "required" => true )
        );
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
}
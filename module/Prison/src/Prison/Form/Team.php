<?php
namespace Prison\Form;

use Zend\Form\ElementPrepareAwareInterface;
use Zend\Form\Form;
use Zend\Form\FormInterface;
use Zend\InputFilter\InputFilterProviderInterface;

class Team extends Form implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct();

        $this->add(array(
            "name" => "name",
            "options" => array(
                "label" => "Team name"
            ),
            'attributes' => array(
                'type'  => 'text',
            ),
        ));
    }

    public function getInputFilterSpecification()
    {
        return array(
            "name" => array( "required" => true )
        );
    }
}
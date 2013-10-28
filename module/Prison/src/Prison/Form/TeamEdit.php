<?php
namespace Prison\Form;


class TeamEdit extends Team
{
    public function __construct()
    {
        parent::__construct();

        $this->add(array(
            "name" => "slug",
            "options" => array(
                "label" => "Slug"
            ),
            'attributes' => array(
                'type'  => 'text',
            ),
        ));
        $this->add(array(
            "name" => "id",
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
    }
} 
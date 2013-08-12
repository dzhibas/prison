<?php
namespace Prison\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Project options apply only to an instance of a project.
 * Options which are specific to a plugin should namespace
 * their key. e.g. key='myplugin:optname'
 *
 * @ORM\Entity
 * @ORM\Table(name="project_option")
 */
class ProjectOption
{
    /**
     * @var int
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @var Project
     * @ORM\ManyToOne(targetEntity="Project")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    protected $project;

    /**
     * @var string
     * @ORM\Column(type="string", length=64)
     */
    protected $key;

    /**
     * serialized php object
     *
     * @var string
     * @ORM\Column(type="text")
     */
    protected $value;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }


}
<?php
namespace Prison\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Projects are permission based namespaces which generally
 * are the top level entry point for all data.
 * A project may be owned by only a single team, and may or may not
 * have an owner (which is thought of as a project creator).
 *
 * @ORM\Entity
 * @ORM\Table(name="project")
 */
class Project
{
    /**
     * @var int
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $slug;

    /**
     * @var string
     * @ORM\Column(type="string", length=200)
     */
    protected $name;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    protected $owner;

    /**
     * @var Team
     * @ORM\ManyToOne(targetEntity="Team")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id")
     */
    protected $team;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    protected $public = false;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", name="date_added")
     */
    protected $dateAdded;

    /**
     * @var integer
     * @ORM\Column(type="integer", columnDefinition="SMALLINT(2) NOT NULL")
     */
    protected $status = 0;

    /**
     * @var string
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    protected $platform;

    /**
     * Project keys
     *
     * @ORM\OneToMany(targetEntity="ProjectKey", mappedBy="project")
     */
    private $keys;

    public function __construct()
    {
        $this->keys = new ArrayCollection();
    }

    /**
     * @param mixed $keys
     */
    public function setKeys($keys)
    {
        $this->keys = $keys;
    }

    /**
     * @return mixed
     */
    public function getKeys()
    {
        return $this->keys;
    }

    /**
     * @param \DateTime $dateAdded
     */
    public function setDateAdded($dateAdded)
    {
        $this->dateAdded = $dateAdded;
    }

    /**
     * @return \DateTime
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $platform
     */
    public function setPlatform($platform)
    {
        $this->platform = $platform;
    }

    /**
     * @return string
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * @param boolean $public
     */
    public function setPublic($public)
    {
        $this->public = $public;
    }

    /**
     * @return boolean
     */
    public function getPublic()
    {
        return $this->public;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param \Prison\Entity\User $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return \Prison\Entity\User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param \Prison\Entity\Team $team
     */
    public function setTeam($team)
    {
        $this->team = $team;
    }

    /**
     * @return \Prison\Entity\Team
     */
    public function getTeam()
    {
        return $this->team;
    }

    function __toString()
    {
        return $this->getName();
    }
}
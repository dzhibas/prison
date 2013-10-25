<?php
namespace Prison\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;

use ZfcUser\Entity\UserInterface;

/** 
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User implements UserInterface
{
    /**
     * @var int
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true, length=255)
     */
    protected $username;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $password;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=false, length=256)
     */
    protected $email;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true, name="date_added")
     */
    protected $dateAdded;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true, name="display_name")
     */
    protected $displayName;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $state;

    /**
     * Teams in which user is in
     * @ORM\OneToMany(targetEntity="Team", mappedBy="owner")
     */
    private $teams;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
    }

    public function getTeams()
    {
        return $this->teams;
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
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * @param string $name
     */
    public function setDisplayName($name)
    {
        $this->displayName = $name;
    }

    /**
     * @return int
     */
    public function getState() 
    {
        return $this->state;
    }

    /**
     * @param int $state
     */
    public function setState($state) 
    {
        $this->state = $state;
    }
}
<?php
namespace Prison\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="project_key")
 */
class ProjectKey
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
     * @ORM\Column(name="public_key", type="string", length=32)
     */
    protected $publicKey;

    /**
     * @var string
     * @ORM\Column(name="secret_key", type="string", length=32)
     */
    protected $secretKey;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * for auditing
     *
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_added_id", referencedColumnName="id")
     */
    protected $userAdded;

    /**
     * for auditing
     *
     * @var \DateTime
     * @ORM\Column(name="date_added", type="datetime")
     */
    protected $dateAdded;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $publicKey
     */
    public function setPublicKey($publicKey)
    {
        $this->publicKey = $publicKey;
    }

    /**
     * @return string
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * @param string $secretKey
     */
    public function setSecretKey($secretKey)
    {
        $this->secretKey = $secretKey;
    }

    /**
     * @return string
     */
    public function getSecretKey()
    {
        return $this->secretKey;
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
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }


}
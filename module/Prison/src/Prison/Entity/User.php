<?php
namespace Prison\Entity;

/** @Entity */
class User
{
    /**
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @var string
     * @Column(type="string", nullable=false, length=255)
     */
    protected $username;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $password;
    /**
     * @var string
     * @Column(type="string", nullable=false, length=256)
     */
    protected $email;

    /**
     * @var \DateTime
     * @Column(type="datetime", nullable=true)
     */
    protected $dateAdded;

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


}
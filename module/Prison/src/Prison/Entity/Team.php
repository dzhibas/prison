<?php
namespace Prison\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * A team represents a group of individuals which maintain ownership of projects.
 */

/** @ORM\Entity */
class Team
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
     * @ORM\Column(type="string", nullable=false)
     */
    protected $name;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="Prison\User")
     * @ORM\JoinColumn(name="owner_id", referenceColumnName="id")
     */
    protected $owner;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    protected $dateAdded;

    /** @todo add relation */
    protected $members;
}
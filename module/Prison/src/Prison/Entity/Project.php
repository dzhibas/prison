<?php
namespace Prison\Entity;
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
    protected $public;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", name="date_added")
     */
    protected $dateAdded;

    /**
     * @var integer
     * @ORM\Column(type="integer", columnDefinition="SMALLINT(2) NOT NULL")
     */
    protected $status;

    /**
     * @var string
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    protected $platform;
}
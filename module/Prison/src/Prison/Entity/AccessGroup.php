<?php
namespace Prison\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class AccessGroup
 * @package Prison\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="access_group")
 */
class AccessGroup
{
    /**
     * @var int
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @var Team
     * @ORM\ManyToOne(targetEntity="Team")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id")
     */
    protected $team;

    /**
     * possible values is in constants $MEMBER_TYPES
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $type;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $managed = false;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    protected $data;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", name="date_added")
     */
    protected $dateAdded;

    /** @todo manytomany relation */
    protected $projects;

    /** @todo manytomany relation */
    protected $members;
}
<?php
namespace Prison\Entity;

/**
 * A team represents a group of individuals which maintain ownership of projects.
 */

/** @Entity */
class Team
{
    /**
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $slug;

    /**
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $name;

    /**
     * @var User
     * @ManyToOne(targetEntity="Prison\User")
     * @JoinColumn(name="owner_id", referenceColumnName="id")
     */
    protected $owner;

    /**
     * @var \DateTime
     * @Column(type="datetime")
     */
    protected $dateAdded;

    /** @todo add relation */
    protected $members;
}
<?php
namespace Prison\Entity;
use Doctrine\ORM\Mapping as ORM;

/** @IgnoreAnnotation("EventBase") */
class EventBase
{
    /**
     * @var Project
     * @ORM\ManyToOne(targetEntity="Project")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    protected $project;
    protected $logger;
    protected $level;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    protected $message;

    /**
     * @var string
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $culprit;

    /**
     * @var string
     * @ORM\Column(type="string", length=32)
     */
    protected $checksum;

    /**
     * @var string gzipped data
     * @ORM\Column(columnDefinition="MEDIUMBLOB NULL")
     */
    protected $data;

    /**
     * @var int
     * @ORM\Column(type="integer", columnDefinition="MEDIUMINT(8) unsigned NOT NULL", name="num_comments")
     */
    protected $numComments;

    /**
     * @var string
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    protected $platform;
}
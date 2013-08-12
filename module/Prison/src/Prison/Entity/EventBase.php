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

    /**
     * @var string
     * @ORM\Column(type="string", length=64)
     */
    protected $logger = "root";

    /**
     * @var int
     * @ORM\Column(type="integer", columnDefinition="MEDIUMINT(8) unsigned NULL")
     */
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

    /**
     * @param string $checksum
     */
    public function setChecksum($checksum)
    {
        $this->checksum = $checksum;
    }

    /**
     * @return string
     */
    public function getChecksum()
    {
        return $this->checksum;
    }

    /**
     * @param string $culprit
     */
    public function setCulprit($culprit)
    {
        $this->culprit = $culprit;
    }

    /**
     * @return string
     */
    public function getCulprit()
    {
        return $this->culprit;
    }

    /**
     * @param string $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param int $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param string $logger
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return string
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param int $numComments
     */
    public function setNumComments($numComments)
    {
        $this->numComments = $numComments;
    }

    /**
     * @return int
     */
    public function getNumComments()
    {
        return $this->numComments;
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


}
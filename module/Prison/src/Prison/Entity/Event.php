<?php
namespace Prison\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity 
 * @ORM\Table(name="event", indexes={@ORM\Index(name="checksum_idx", columns={"checksum"})})
 */
class Event extends EventBase
{
    /**
     * @var int
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @var Group
     * @ORM\ManyToOne(targetEntity="Group")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     */
    protected $group;

    /**
     * @var string
     * @ORM\Column(type="string", length=32, name="event_id")
     */
    protected $eventId;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    protected $datetime;

    /**
     * @var float
     * @ORM\Column(type="float", name="time_spent")
     */
    protected $timeSpent = 0.0;

    /**
     * @var string
     * @ORM\Column(type="string", length=128, name="server_name")
     */
    protected $serverName;

    /**
     * @var string
     * @ORM\Column(type="string", length=128)
     */
    protected $site;

    /**
     * @param \DateTime $datetime
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;
    }

    /**
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * @param string $eventId
     */
    public function setEventId($eventId)
    {
        $this->eventId = $eventId;
    }

    /**
     * @return string
     */
    public function getEventId()
    {
        return $this->eventId;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $serverName
     */
    public function setServerName($serverName)
    {
        $this->serverName = $serverName;
    }

    /**
     * @return string
     */
    public function getServerName()
    {
        return $this->serverName;
    }

    /**
     * @param string $site
     */
    public function setSite($site)
    {
        $this->site = $site;
    }

    /**
     * @return string
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @param float $timeSpent
     */
    public function setTimeSpent($timeSpent)
    {
        $this->timeSpent = $timeSpent;
    }

    /**
     * @return float
     */
    public function getTimeSpent()
    {
        return $this->timeSpent;
    }


}
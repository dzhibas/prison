<?php
namespace Prison\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="group")
 */
class Group
{
    const STATUS_UNRESOLVED = 0;
    const STATUS_RESOLVED = 1;
    const STATUS_MUTED = 2;

    public static $STATUS_LEVELS = array(
        Group::STATUS_UNRESOLVED => "Unresolved",
        Group::STATUS_RESOLVED => "Resolved",
        Group::STATUS_MUTED => "Muted",
    );

    /**
     * @var int
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @var int
     * @ORM\Column(type="integer", columnDefinition="SMALLINT(4) unsigned NULL")
     */
    protected $status;

    /**
     * @var int
     * @ORM\Column(type="integer", name="times_seen")
     */
    protected $timesSeen = 1;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", name="last_seen")
     */
    protected $lastSeen;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", name="first_seen")
     */
    protected $firstSeen;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", name="resolved_at")
     */
    protected $resolvedAt;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", name="active_at")
     */
    protected $activeAt;

    /**
     * @var float
     * @ORM\Column(type="float", name="time_spent_total")
     */
    protected $timeSpentTotal = 0.0;

    /**
     * @var int
     * @ORM\Column(type="integer", name="time_spent_count")
     */
    protected $timeSpentCount = 0;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $score = 0;

    /**
     * @var bool
     * @ORM\Column(type="boolean", name="is_public")
     */
    protected $isPublic = false;

    /**
     * @param \DateTime $activeAt
     */
    public function setActiveAt($activeAt)
    {
        $this->activeAt = $activeAt;
    }

    /**
     * @return \DateTime
     */
    public function getActiveAt()
    {
        return $this->activeAt;
    }

    /**
     * @param \DateTime $firstSeen
     */
    public function setFirstSeen($firstSeen)
    {
        $this->firstSeen = $firstSeen;
    }

    /**
     * @return \DateTime
     */
    public function getFirstSeen()
    {
        return $this->firstSeen;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param boolean $isPublic
     */
    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;
    }

    /**
     * @return boolean
     */
    public function getIsPublic()
    {
        return $this->isPublic;
    }

    /**
     * @param \DateTime $lastSeen
     */
    public function setLastSeen($lastSeen)
    {
        $this->lastSeen = $lastSeen;
    }

    /**
     * @return \DateTime
     */
    public function getLastSeen()
    {
        return $this->lastSeen;
    }

    /**
     * @param \DateTime $resolvedAt
     */
    public function setResolvedAt($resolvedAt)
    {
        $this->resolvedAt = $resolvedAt;
    }

    /**
     * @return \DateTime
     */
    public function getResolvedAt()
    {
        return $this->resolvedAt;
    }

    /**
     * @param int $score
     */
    public function setScore($score)
    {
        $this->score = $score;
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $timeSpentCount
     */
    public function setTimeSpentCount($timeSpentCount)
    {
        $this->timeSpentCount = $timeSpentCount;
    }

    /**
     * @return int
     */
    public function getTimeSpentCount()
    {
        return $this->timeSpentCount;
    }

    /**
     * @param float $timeSpentTotal
     */
    public function setTimeSpentTotal($timeSpentTotal)
    {
        $this->timeSpentTotal = $timeSpentTotal;
    }

    /**
     * @return float
     */
    public function getTimeSpentTotal()
    {
        return $this->timeSpentTotal;
    }

    /**
     * @param int $timesSeen
     */
    public function setTimesSeen($timesSeen)
    {
        $this->timesSeen = $timesSeen;
    }

    /**
     * @return int
     */
    public function getTimesSeen()
    {
        return $this->timesSeen;
    }


}
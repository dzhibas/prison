<?php
namespace Prison\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity 
 * @ORM\Table(name="event")
 */
class Event extends EventBase
{
    /**
     * @var int
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;
    protected $group;
    protected $eventId;
    protected $datetime;
    protected $timeSpent;
    protected $serverName;
    protected $site;
}
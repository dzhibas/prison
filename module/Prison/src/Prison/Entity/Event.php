<?php
namespace Prison\Entity;

/** @Entity */
class Event extends EventBase
{
    protected $group;
    protected $eventId;
    protected $datetime;
    protected $timeSpent;
    protected $serverName;
    protected $site;
}
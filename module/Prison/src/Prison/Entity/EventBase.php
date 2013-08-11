<?php
namespace Prison\Entity;

/** @EventBase */
class EventBase
{
    protected $project;
    protected $logger;
    protected $level;
    protected $message;
    protected $culprit;
    protected $checksum;
    protected $data;
    protected $num_comments;
    protected $platform;
}
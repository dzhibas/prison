<?php
namespace Prison\Entity;

/**
 * Projects are permission based namespaces which generally
 * are the top level entry point for all data.
 * A project may be owned by only a single team, and may or may not
 * have an owner (which is thought of as a project creator).
 */

class Project
{
    protected $slug;
    protected $name;
    protected $owner;
    protected $team;
    protected $public;
    protected $dateAdded;
    protected $status;
    protected $platform;
}
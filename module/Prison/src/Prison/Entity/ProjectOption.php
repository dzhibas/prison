<?php
namespace Prison\Entity;

/**
 * Project options apply only to an instance of a project.
 * Options which are specific to a plugin should namespace
 * their key. e.g. key='myplugin:optname'
 */

class ProjectOption
{
    protected $project;
    protected $key;
    protected $value;
}
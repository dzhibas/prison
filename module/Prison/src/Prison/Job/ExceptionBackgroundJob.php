<?php
namespace Prison\Job;

use SlmQueue\Job\AbstractJob;

class ExceptionBackgroundJob extends AbstractJob
{
    /**
     * Execute the job
     *
     * @return void
     */
    public function execute()
    {
        echo "heavy job of parsing exception";
    }

}
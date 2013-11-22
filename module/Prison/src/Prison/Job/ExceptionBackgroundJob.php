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
        // @TODO https://github.com/dzhibas/sentry/blob/master/src/sentry/manager.py#L325
        echo "heavy job of parsing exception";
    }

}
<?php

declare(strict_types=1);

namespace Otcstores\EventLog;

class EventLogConfiguration
{
    /**
     * @var callable
     */
    private $usernameCallable;

    /**
     * @return callable|null
     */
    public function getUsernameCallable()
    {
        return $this->usernameCallable;
    }

}
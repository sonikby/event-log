<?php

declare(strict_types=1);

namespace Otcstores\EventLog\Doctrine\Annotation;

interface GroupInterface
{
    public function getGroupName(): ?string;
}
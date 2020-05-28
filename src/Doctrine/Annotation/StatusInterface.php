<?php

declare(strict_types=1);

namespace Otcstores\EventLog\Doctrine\Annotation;

interface StatusInterface
{
    public function isEnabled(): bool;

    public function isIgnore(): bool;

    public function isEmpty(): bool;
}
<?php

declare(strict_types=1);

namespace Otcstores\EventLog\Doctrine\Annotation;

class EmptyAnnotation extends StatusAbstract
{
    public function __construct()
    {
        $this->status = self::EMPTY;
    }
}
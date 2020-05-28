<?php

declare(strict_types=1);

namespace Otcstores\EventLog\Doctrine\Reflection;

interface InterfaceReflection
{
    public function getPropsObjectEntity($entity): array;

}
<?php

declare(strict_types=1);

namespace Otcstores\EventLog\Doctrine\Helper;

class EntityName
{
    /**
     * @var array
     */
    private static $entityList = [];

    public static function registrationName(string $entityName, string $name): void
    {
        self::$entityList[$entityName] = $name;
    }

    public static function getName(string $entityName): ?string
    {
        return self::$entityList[$entityName] ?? $entityName;
    }
}
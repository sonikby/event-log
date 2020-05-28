<?php

declare(strict_types=1);

namespace Otcstores\EventLog\Doctrine\Annotation;

class StatusAbstract implements StatusInterface, OtcstoresAnnotation
{
    /**
     * @Enum({"Enabled", "Ingore"})
     */
    public $status;

    public const ENABLED = 'enabled';

    public const IGNORE = 'ignore';

    public const EMPTY = 'empty';

    public const STATUS_NAME = 'status';

    public const VALUE_NAME = 'value';


    public function isEnabled(): bool
    {
        return $this->status === self::ENABLED;
    }

    public function isIgnore(): bool
    {
        return $this->status === self::IGNORE;
    }

    public function isEmpty(): bool
    {
        return $this->status === self::EMPTY || $this->status === null;
    }

    protected function setStatus(array $params): void
    {
        $status = $params[self::VALUE_NAME] ?? $params[self::STATUS_NAME] ?? null;
        if ($status === null) {
            return;
        }
        $this->status = $status;
    }
}
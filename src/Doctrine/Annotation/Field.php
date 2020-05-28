<?php

declare(strict_types=1);

namespace Otcstores\EventLog\Doctrine\Annotation;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
class Field extends StatusAbstract implements GroupInterface
{
    /**
     * @var string
     */
    public $group;

    public const GROUP_NAME = 'group';

    public function __construct(array $params)
    {
        foreach ($params as $name => $value) {
            if ($name === self::GROUP_NAME) {
                $this->group = mb_strtolower($value);
            }
        }
        $this->setStatus($params);
    }

    public function getGroupName(): ?string
    {
        return $this->group;
    }
}
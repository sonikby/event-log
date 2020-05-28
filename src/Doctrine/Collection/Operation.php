<?php

declare(strict_types=1);

namespace Otcstores\EventLog\Doctrine\Collection;

class Operation implements OperationInterface
{
    /**
     * @var array
     */
    private $operation;

    /**
     * @var string
     */
    private $value;

    public const CREATE = 'create';

    public const UPDATE = 'update';

    public const DELETE = 'delete';

    public const ALL = 'all';

    public function __construct(string $operation)
    {
        $this->value = $operation;
        $this->operation = explode(',', mb_strtolower($operation));
    }

    public function isDelete(): bool
    {
        return in_array(self::DELETE, $this->operation) || $this->isAll();
    }

    public function isUpdate(): bool
    {
        return in_array(self::UPDATE, $this->operation) || $this->isAll();
    }

    public function isCreate(): bool
    {
        return in_array(self::CREATE, $this->operation) || $this->isAll();
    }

    public function isAllowOperation(OperationInterface $operation): bool
    {
        if ($this->isAll()) {
            return true;
        }
        foreach ($operation as $val) {
            if (in_array($val, $this->operation) === false) {
                return false;
            }
        }
        return true;
    }

    public function arrayValue(): array
    {
        return $this->operation;
    }

    private function isAll(): bool
    {
        return in_array(self::ALL, $this->operation);
    }

}
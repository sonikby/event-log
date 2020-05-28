<?php

declare(strict_types=1);

namespace Otcstores\EventLog\Doctrine\Collection;

interface OperationInterface
{
    public function isDelete(): bool;

    public function isUpdate(): bool;

    public function isCreate(): bool;

    public function arrayValue(): array;

    public function isAllowOperation(OperationInterface $operation): bool;
}
<?php

declare(strict_types=1);

namespace Otcstores\EventLog\Doctrine\Helper;

use Otcstores\EventLog\Doctrine\Collection\OperationInterface;
use Otcstores\EventLog\Doctrine\Collection\Operation;
class ActionDecoder
{
    public static function getActionName(OperationInterface $operation)
    {
        if ($operation->isUpdate()) {
            return Operation::UPDATE;
        }
        if ($operation->isDelete()) {
            return Operation::DELETE;
        }
        if ($operation->isCreate()){
            return Operation::CREATE;
        }
    }
}
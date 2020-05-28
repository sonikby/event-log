<?php

declare(strict_types=1);

namespace Otcstores\EventLog\Doctrine\Annotation;

use Otcstores\EventLog\Doctrine\Collection\Operation;
use Otcstores\EventLog\Doctrine\Collection\OperationInterface;

/**
 * @Annotation
 * @Target("CLASS")
 */
class Entity implements OtcstoresAnnotation
{
    /**
     * @var OperationInterface
     */
    public $operation;


    public function __construct(array $params)
    {
        $this->operation = new Operation($params['operation'] ?? '');
    }

    public function getOperation(): OperationInterface
    {
        return $this->operation;
    }

}
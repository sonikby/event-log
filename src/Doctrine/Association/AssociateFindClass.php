<?php

declare(strict_types=1);

namespace Otcstores\EventLog\Doctrine\Association;

use Otcstores\EventLog\Doctrine\Config\IncludeClassAssociate;
use Otcstores\EventLog\Doctrine\Reflection\InterfaceReflection;

class AssociateFindClass
{
    /**
     * @var InterfaceReflection
     */
    private $reflection;

    public function __construct(InterfaceReflection $reflection)
    {
        $this->reflection = $reflection;
    }

    public function findEntityAssociate($entity): array
    {
        return $this->reflection->getPropsObjectEntity($entity);
    }

}
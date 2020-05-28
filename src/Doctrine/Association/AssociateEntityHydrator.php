<?php

declare(strict_types=1);

namespace Otcstores\EventLog\Doctrine\Association;

use Doctrine\Common\Persistence\Mapping\MappingException;
use Doctrine\ORM\UnitOfWork;
use Otcstores\EventLog\Doctrine\Collection\AssociationEntity;
use Otcstores\EventLog\Doctrine\Collection\LogEntity;
use Otcstores\EventLog\Doctrine\Helper\EntityName;

class AssociateEntityHydrator
{
    public function hydrate(array $classList, UnitOfWork $unitOfWork, LogEntity $logEnt): array
    {
        $result = [];
        foreach ($classList as $item) {

            try {
                $id = (string)$unitOfWork->getSingleIdentifierValue($item);
            } catch (MappingException $exception){
                continue;
            }
            $result[] = new AssociationEntity(
                EntityName::getName(get_class($item)),
                $id,
                get_class($item),
                $logEnt
            );
        }
        return $result;
    }
}
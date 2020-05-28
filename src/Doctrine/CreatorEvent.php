<?php

declare(strict_types=1);

namespace Otcstores\EventLog\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\UnitOfWork;
use Otcstores\EventLog\Doctrine\Association\AssociateEntityHydrator;
use Otcstores\EventLog\Doctrine\Association\AssociateFindClass;
use Otcstores\EventLog\Doctrine\Collection\LogEntity;
use Otcstores\EventLog\Doctrine\Collection\OperationInterface;
use Otcstores\EventLog\Doctrine\Helper\ActionDecoder;
use Otcstores\EventLog\Doctrine\Metadata\AnnotationMetadata;
use Otcstores\EventLog\Doctrine\Reflection\Reflection;
use Otcstores\EventLog\Doctrine\Helper\EntityName;
use Otcstores\EventLog\User\InterfaceUserData;

class CreatorEvent
{
    /**
     * @var AnnotationMetadata
     */
    protected $metadata;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var object
     */
    protected $entity;

    /**
     * @var OperationInterface
     */
    protected $operation;

    /**
     * @var InterfaceUserData
     */
    protected $userData;

    public function __construct(
        AnnotationMetadata $metadata,
        ObjectManager $objectManager,
        $entity,
        OperationInterface $operation,
        InterfaceUserData $userData
    ) {
        $this->metadata = $metadata;
        $this->objectManager = $objectManager;
        $this->entity = $entity;
        $this->operation = $operation;
        $this->userData = $userData;
    }

    public function create()
    {
        $fields = $this->getField();
        if ($this->isAllowUpdate($fields) === false) {
            return null;
        }
        $logEnt =  new LogEntity(
            ActionDecoder::getActionName($this->operation),
            get_class($this->entity),
            $fields,
            $this->getTargetId(),
            $this->getTargetName() ,
            $this->getAuthorId(),
            $this->getAuthorType()
        );
        $assot = $this->getAssociateClass($logEnt);
        $logEnt->setAssociateEntity($assot);
        return $logEnt;
    }

    private function getField(): ?array
    {
        return $this->filterFieldOperation($this->getFieldsEntity());
    }

    private function filterFieldOperation(array $fields): ?array
    {
        if ($this->operation->isUpdate()) {
            return $this->metadata->filterFields($fields);
        }
        return $fields;
    }

    private function getFieldsEntity(): ?array
    {
        $uow = $this->getUnitOfWork();
        if ($this->operation->isUpdate() === true ) {
            return $uow->getEntityChangeSet($this->entity);
        } else {
            return $uow->getOriginalEntityData($this->entity);
        }

    }

    private function getAssociateClass(LogEntity $logEnt): ?array
    {
        $reflection = new Reflection();
        $associateClass = new AssociateFindClass($reflection);
        $resultAssoc = $associateClass->findEntityAssociate($this->entity);
        $hydrator = new AssociateEntityHydrator();
        return $hydrator->hydrate($resultAssoc, $this->getUnitOfWork(), $logEnt);
    }

    private function isAllowUpdate(array $field): bool
    {
        return $this->operation->isUpdate() === false || !empty($field);
    }

    private function getUnitOfWork(): UnitOfWork
    {
        return $this->objectManager->getUnitOfWork();
    }

    private function getAuthorId(): ?string
    {
        return $this->userData->getUserId();
    }

    private function getAuthorType(): ?string
    {
        if (!empty($this->userData->getUserId())) {
            return $this->userData->getType();
        }
        return null;
    }

    private function getNameEntity(): string
    {
        return EntityName::getName(get_class($this->entity));
    }


    private function getTargetId(): string
    {
        return (string)$this->getUnitOfWork()->getSingleIdentifierValue($this->entity);
    }

    private function getTargetName(): string
    {
        return $this->getNameEntity();
    }
}
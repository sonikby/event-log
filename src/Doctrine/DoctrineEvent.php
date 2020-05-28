<?php

declare(strict_types=1);

namespace Otcstores\EventLog\Doctrine;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Events;
use Otcstores\EventLog\Doctrine\Annotation\Entity;
use Otcstores\EventLog\Doctrine\Collection\Operation;
use Otcstores\EventLog\Doctrine\Collection\OperationInterface;
use Otcstores\EventLog\Doctrine\Metadata\AnnotationMetadata;
use Psr\Container\ContainerInterface;
use Otcstores\EventLog\User\InterfaceUserData;

class DoctrineEvent implements EventSubscriber
{
    /**
     * @var InterfaceUserData
     */
    private $userData;
    public function __construct(InterfaceUserData $userData)
    {
        $this->userData = $userData;
    }

    /**
     * @var OperationInterface
     */
    protected $operation;

    public function getSubscribedEvents()
    {
        return [
            Events::postPersist,
            Events::preRemove,
            Events::postUpdate
        ];
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->operation = new Operation(Operation::CREATE);
        $this->logActivity($args);
    }


    public function preRemove(LifecycleEventArgs $args)
    {
        $this->operation = new Operation(Operation::DELETE);
        $this->logActivity($args);
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->operation = new Operation(Operation::UPDATE);
        $this->logActivity($args);
    }

    private function logActivity(LifecycleEventArgs $args): void
    {
        if ($this->isLogOperation($this->getMetadata($args)->getEntityAnnotation()) === false) {
            return;
        }
        $creatorEvent = new CreatorEvent(
            $this->getMetadata($args),
            $args->getObjectManager(),
            $args->getObject(),
            $this->operation,
            $this->userData
        );
        $event = $creatorEvent->create();
        if ($event !== null) {
            $args->getObjectManager()->persist($event);
            $args->getObjectManager()->flush();
        }
    }

    private function isLogOperation(?Entity $entity): bool
    {
        if ($entity === null) {
            return false;
        }
        return $this->isOperationAllowed($entity->getOperation(), $this->operation);
    }

    private function isOperationAllowed(OperationInterface $operationAnnotation, OperationInterface $operation): bool
    {
        return $operationAnnotation->isAllowOperation($operation);
    }

    private function getMetadata(LifecycleEventArgs $args): ?AnnotationMetadata
    {
        $cmf = $args->getObjectManager()->getMetadataFactory();
        $metadata = $cmf->getMetadataFor(get_class($args->getObject()));
        return new AnnotationMetadata($metadata);
    }

}
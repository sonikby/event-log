<?php

declare(strict_types=1);

namespace Otcstores\EventLog\Doctrine\Collection;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Otcstores\EventLog\Doctrine\LogRepository")
 * @ORM\Table(name="log_doctrine")
 */
class LogEntity
{
    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(nullable=false)
     */
    private $action;

    /**
     * @ORM\Column(nullable=true)
     */
    private $entity;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $metadata;

    /**
     * @ORM\Column(nullable=true)
     */
    private $targetId;

    /**
     * @ORM\Column(nullable=true)
     */
    private $target;

    /**
     * @ORM\OneToMany(targetEntity="Otcstores\EventLog\Doctrine\Collection\AssociationEntity", mappedBy="logEntity", cascade={"all"})
     */
    private $associateEntity;

    /**
     * @ORM\Column(nullable=true)
     */
    private $authorId;

    /**
     * @ORM\Column(nullable=true)
     */
    private $authorType;

    /**
     * @ORM\Column(type="datetimetz")
     */
    private $created_at;

    public function __construct(
        string $action,
        string $entity,
        ?array $metadata,
        string $targetId,
        string $target,
        ?string $authorId,
        ?string $authorType
    ) {
        $this->action = $action;
        $this->entity = $entity;
        $this->metadata = $metadata;
        $this->targetId = $targetId;
        $this->target = $target;
        $this->authorId = $authorId;
        $this->authorType = $authorType;
        $this->created_at = new \DateTime();
    }

    public function setAssociateEntity(array $associateEntity): void
    {
        $this->associateEntity = $associateEntity;
    }
}
<?php

declare(strict_types=1);

namespace Otcstores\EventLog\Doctrine\Collection;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Otcstores\EventLog\Doctrine\AssociationEntityRepository")
 * @ORM\Table(name="log_doctrine_entity")
 */
class AssociationEntity
{
    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Otcstores\EventLog\Doctrine\Collection\LogEntity", inversedBy="associateEntity", cascade = {"all"})
     * @ORM\JoinColumn()
     */
    private $logEntity;

    /**
     * @ORM\Column(nullable=true)
     */
    private $identityEntity;

    /**
     * @ORM\Column(nullable=false)
     */
    private $nameEntity;

    /**
     * @ORM\Column(nullable=false)
     */
    private $classEntity;

    public function __construct(string $nameEntity, string $identityEntity, string $classEntity, LogEntity $logEntity)
    {
        $this->identityEntity = $identityEntity;
        $this->nameEntity = $nameEntity;
        $this->classEntity = $classEntity;
        $this->logEntity = $logEntity;
    }

    /**
     * @return string|null
     */
    public function getIdentityEntity(): ?string
    {
        return $this->identityEntity;
    }

    /**
     * @return string|null
     */
    public function getNameEntity(): ?string
    {
        return $this->nameEntity;
    }
}
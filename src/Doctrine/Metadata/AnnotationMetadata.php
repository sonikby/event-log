<?php

declare(strict_types=1);

namespace Otcstores\EventLog\Doctrine\Metadata;

use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Otcstores\EventLog\Doctrine\Annotation\Entity;
use Otcstores\EventLog\Doctrine\Annotation\Reader\ReaderAnnotation;
use Otcstores\EventLog\Doctrine\Annotation\StatusInterface;

class AnnotationMetadata
{
    /**
     * @var ClassMetadata
     */
    private $metadata;

    /**
     * @var ReaderAnnotation
     */
    private $readerAnnotation;

    /**
     * @var Entity|null
     */
    private $entityAnnotation;


    public function __construct(ClassMetadata $metadata)
    {
        $this->metadata = $metadata;
        $this->readerAnnotation = new ReaderAnnotation($metadata);
        $this->entityAnnotation = $this->readerAnnotation->loadAnnotationEntity();
    }

    public function getEntityAnnotation(): ?Entity
    {
        return $this->entityAnnotation;
    }

    public function isEnabledField(string $nameField): bool
    {
        $resultAnnotation = $this->initResultAnnotation($nameField);
        return $resultAnnotation->isIgnore() === false;
    }

    protected function initResultAnnotation(string $nameField): StatusInterface
    {
        return $this->readerAnnotation->loadAnnotationField($nameField);
    }

    public function filterFields(array $fields): array
    {
        $result = [];
        foreach ($fields as $name => $value) {
            if ($this->isEnabledField($name) === true) {
                $result[$name] = $value;
            }
        }
        return $result;
    }
}
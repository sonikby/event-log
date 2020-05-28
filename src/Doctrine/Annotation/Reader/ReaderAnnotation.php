<?php

declare(strict_types=1);

namespace Otcstores\EventLog\Doctrine\Annotation\Reader;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Otcstores\EventLog\Doctrine\Annotation\EmptyAnnotation;
use Otcstores\EventLog\Doctrine\Annotation\Entity;
use Otcstores\EventLog\Doctrine\Annotation\OtcstoresAnnotation;
use Otcstores\EventLog\Doctrine\Annotation\StatusAbstract;
use Otcstores\EventLog\Doctrine\Annotation\StatusInterface;
use ReflectionClass;
use ReflectionProperty;

class ReaderAnnotation
{
    /**
     * @var ClassMetadata
     */
    private $metadata;

    /**
     * @var Reader
     */
    private $reader;

    public function __construct(ClassMetadata $metadata)
    {
        $this->metadata = $metadata;
        $this->reader = new AnnotationReader();
    }

    public function loadAnnotationField(string $name): StatusAbstract
    {
        $reflClass = new ReflectionProperty($this->metadata->getName(), $name);
        $annotations = $this->reader->getPropertyAnnotations($reflClass);
        $annotation = $this->initAnnotation($annotations);
        if ($annotation instanceof StatusAbstract) {
            return $annotation;
        }
        return new EmptyAnnotation();
    }

    public function loadAnnotationEntity(): ?Entity
    {
        $reflClass = new ReflectionClass($this->metadata->getName());
        $annotations = $this->reader->getClassAnnotations($reflClass);
        $annotation = $this->initAnnotation($annotations);
        if ($annotation instanceof Entity) {
            return $annotation;
        }
        return null;
    }

    private function initAnnotation(array $annotations): ?OtcstoresAnnotation
    {
        foreach ($annotations as $annotation) {
            if (($annotation instanceof OtcstoresAnnotation) === true) {
                return $annotation;
            }
        }
        return null;
    }
}
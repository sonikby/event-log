<?php

declare(strict_types=1);

namespace Otcstores\EventLog\Doctrine\Reflection;

use Otcstores\EventLog\Doctrine\Config\IncludeClassAssociate;
use ReflectionClass;

class Reflection implements InterfaceReflection
{
    /**
     * @var ReflectionClass
     */
    private $reflectionClass;


    private function getProperty(): array
    {
        return array_map(
            function ($value) {
                return $value->getName();
            },
            $this->reflectionClass->getProperties()
        );
    }

    private function loadProperty(array $props, $entity): array
    {
        $result = [];
        foreach ($props as $prop)
        {
            if ($val = $this->getValObjectProperty($prop, $entity)) {
                $result[] =  $val;
            }
        }
        return $result;
    }

    /**
     * @param string $prop
     * @param object $entity
     * @return object|null
     * @throws \ReflectionException
     */
    private function getValObjectProperty(string $prop, $entity)
    {
        $reflectionProperty = $this->reflectionClass->getProperty($prop);
        $reflectionProperty->setAccessible(true);
        $val = $reflectionProperty->getValue($entity);
        if (is_object($val)) {
            return $val;
        }
        return null;
    }

    public function getPropsObjectEntity($entity): array
    {
        $this->reflectionClass = new \ReflectionClass(get_class($entity));
        return $this->loadProperty($this->getProperty(), $entity);
    }
}
<?php

namespace App\Context;


use Doctrine\ORM\Mapping\NamingStrategy;

class ApiCompareNamingStrategy implements NamingStrategy
{
    public function classToTableName(string $className): string
    {
        return 'ApiCompare_' . substr($className, strrpos($className, '\\') + 1);
    }
    public function propertyToColumnName(string $propertyName, string $className): string
    {
        return $propertyName;
    }

    public function embeddedFieldToColumnName(
        string $propertyName,
        string $embeddedColumnName,
        string $className,
        string $embeddedClassName,
    ): string {
        return $propertyName . '_' . $embeddedColumnName;
    }

    public function referenceColumnName(): string
    {
        return 'id';
    }
    public function joinColumnName(string $propertyName, ?string $className = null): string
    {
        return $propertyName . '_' . $this->referenceColumnName();
    }
    public function joinTableName(string $sourceEntity, string $targetEntity, string $propertyName): string
    {
        return strtolower($this->classToTableName($sourceEntity) . '_' .
            $this->classToTableName($targetEntity));
    }
    public function joinKeyColumnName(string $entityName, ?string $referencedColumnName): string
    {
        return strtolower($this->classToTableName($entityName) . '_' .
            ($referencedColumnName ?: $this->referenceColumnName()));
    }
}

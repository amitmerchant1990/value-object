<?php

namespace Spatie\ValueObject;

use TypeError;

class ValueObjectError extends TypeError
{
    public static function unknownProperties(array $properties, string $className): ValueObjectError
    {
        $propertyNames = implode('`, `', $properties);

        return new self("Public properties `{$propertyNames}` not found on {$className}");
    }

    public static function invalidType(ValueObjectProperty $property, $value): ValueObjectError
    {
        if ($value === null) {
            $value = 'null';
        }

        if (is_object($value)) {
            $value = get_class($value);
        }

        $expectedTypes = implode(', ', $property->getTypes());

        return new self("Invalid type: expected {$property->getFqn()} to be of type {$expectedTypes}, instead got value `{$value}`.");
    }

    public static function uninitializedProperty(ValueObjectProperty $property): ValueObjectError
    {
        return new self("Non-nullable property {$property->getFqn()} has not been initialized.");
    }
}
<?php

namespace D2;

use ReflectionClass;
use ReflectionNamedType;
use RuntimeException;

abstract class Dto
{
    private $data;

    public function __construct(array $data = [])
    {
        $this->load($data);
        $this->validate();
    }

    protected function validate(): void {}

    private function load(array $data): void
    {
        $reflection = new ReflectionClass(get_called_class());
        $defaults   = $reflection->getDefaultProperties();

        foreach ($reflection->getProperties() as $property) {

            $name = $property->getName();

            if (array_key_exists($name, $data)) {
                $value = $data[$name];
            }

            elseif (array_key_exists($name, $defaults)) {
                $value = $defaults[$name];
            }

            else {
                throw new RuntimeException("The value for the command \"{$name}\" attribute is missing.");
            }

            if ($property->hasType() && $value) {
                $this->cast($value, $property->getType());
            }

            $this->{$name} = $value;
        }

        $this->data = $data;
    }

    private function cast(&$value, ReflectionNamedType $type): void
    {
        $typeName = $type->getName();

        if ($type->isBuiltin()) {
            settype($value, $type->getName());
        }

        else {
            $value = new $typeName($value);
        }
    }

    public function __get(string $name)
    {
        return $this->$name;
    }
}

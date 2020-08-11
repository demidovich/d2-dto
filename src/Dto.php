<?php

namespace D2;

use ReflectionClass;
use ReflectionNamedType;
use RuntimeException;

abstract class Dto
{
    private $rawData;

    const PARTIAL = 0b001;

    public function __construct(array $data = [], int $flags = 0)
    {
        $this->load($data, $flags);
        $this->validate();

        $this->rawData = $data;
    }

    /**
     * Partial data loading
     * @param array $data
     * @return static
     */
    public static function partial(array $data = []): self
    {
        return new static($data, self::PARTIAL);
    }

    protected function validate(): void {}

    private function load(array $data, int $flags): void
    {
        $reflection  = new ReflectionClass(get_called_class());
        $defaults    = $reflection->getDefaultProperties();
        $partialLoad = $flags & self::PARTIAL;

        foreach ($reflection->getProperties() as $property) {

            $name = $property->getName();

            if (array_key_exists($name, $data)) {
                $value = $data[$name];
            }

            elseif (array_key_exists($name, $defaults)) {
                $value = $defaults[$name];
            }

            elseif ($partialLoad) {
                continue;
            }

            else {
                throw new RuntimeException("The value for the command parameter \"{$name}\" is missing.");
            }

            if ($property->hasType() && $value) {
                $this->cast($value, $property->getType());
            }

            $this->{$name} = $value;
        }
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

    /**
     * Is this parameter initialized?
     */
    public function has(string $param): bool
    {
        return array_key_exists($param, $this->rawData);
    }

    public function __get(string $name)
    {
        if ($this->has($name)) {
            return $this->$name;
        }

        throw new RuntimeException("The command parameter \"{$name}\" has not been initialized.");
    }
}

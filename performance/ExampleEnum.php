<?php

namespace Performance;

class ExampleEnum
{
    const EXAMPLE_STATUS = 'example_status';

    private $value;

    public final function __construct($value)
    {
        $this->value = $value;
    }

    public function equalsTo(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function value(): string
    {
        return $this->value;
    }
}

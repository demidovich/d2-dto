<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\Stub\ExampleCommand;
use Tests\Stub\ExampleEnum;

class CommandTest extends TestCase
{
    public function test_command()
    {
        $data = [
            'integer' => 100,   
            'string' => 'mystring',
            'datetime' => '2020-01-01 00:00:00',
            'enum' => 'example_status',
        ];

        $command = new ExampleCommand($data);

        $this->assertEquals(100, $command->integer);
        $this->assertEquals('mystring', $command->string);
        $this->assertInstanceOf(\DateTimeImmutable::class, $command->datetime);
        $this->assertInstanceOf(ExampleEnum::class, $command->enum);
        $this->assertEquals('example_status', $command->enum->value());
    }
}

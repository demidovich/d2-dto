<?php

namespace Tests;

use D2\Dto;
use Exception;
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

    public function test_missing_param_exception()
    {
        $this->expectException(Exception::class);

        $data = [
            'integer__' => 100,   
            'string' => 'mystring',
            'datetime' => '2020-01-01 00:00:00',
            'enum' => 'example_status',
        ];

        new ExampleCommand($data);
    }

    public function test_partial_load()
    {
        $data = [
            'integer' => 100,
        ];

        $command = new ExampleCommand($data, Dto::PARTIAL);

        $this->assertTrue($command->has('integer'));
        $this->assertFalse($command->has('string'));
        $this->assertEquals(100, $command->integer);
    }

    public function test_partial_load_exception()
    {
        $this->expectException(Exception::class);

        $data = [
            'integer' => 100,
        ];

        $command = new ExampleCommand($data, Dto::PARTIAL);

        $string = $command->string;
    }
}

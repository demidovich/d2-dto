<?php

namespace Tests\Stub;

use D2\Dto;
use DateTimeImmutable;
use Tests\Stub\ExampleEnum;

/**
 * @property int $integer
 * @property string $string
 * @property DateTimeImmutable $datetime
 * @property ExampleEnum $enum
 * @property int $integerNullable
 * @property DateTimeImmutable $datetimeNullable
 * @property mixed $untyped
 * @property mixed $untypedNullable
 */
class ExampleCommand extends Dto
{
    protected int $integer;
    protected string $string;
    protected DateTimeImmutable $datetime;
    protected ExampleEnum $enum;

    protected ?int $integerNullable = null;
    protected ?DateTimeImmutable $datetimeNullable = null;

    protected $untyped;
    protected $untypedNullable = null;
}


[![Build Status](https://travis-ci.org/demidovich/d2-dto.svg?branch=master)](https://travis-ci.com/demidovich/d2-dto) [![codecov](https://codecov.io/gh/demidovich/d2-dto/branch/master/graph/badge.svg)](https://codecov.io/gh/demidovich/d2-dto)

## d2 dto

This is a simple base class of data transfer object. The class constructor casts primitives into value objects.

```php
class CreateBookCommand extends Dto
{
    private BookId   $id;
    private BookName $name;
    private AuthorId $author_id;
}

$command = new CreateBookCommand([
    'id' => 1,
    'name' => 'Анна Каренина',
    'author_id' => 10,
]);

$command = new CreateBookCommand([
    'name' => 'Анна Каренина',
], \D2\Dto::PARTIAL);
```

Example of usage with partial data.

```php
class CreateBookCommand extends Dto
{
    private BookId   $id;
    private BookName $name;
    private AuthorId $author_id;
}

$command = new CreateBookCommand([
    'name' => 'Анна Каренина',
], \D2\Dto::PARTIAL);

if ($command->has('name')) {
    $book->rename($command->name);
}
```

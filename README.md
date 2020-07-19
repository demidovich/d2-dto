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
```

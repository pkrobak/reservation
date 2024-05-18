<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use ArrayIterator;
use Countable;
use IteratorAggregate;

/** @implements IteratorAggregate<int, mixed> */
abstract class AbstractCollection implements Countable, IteratorAggregate
{
    /** @var array<int, mixed> $items */
    private array $items;

    /** @param object[] $items */
    public function __construct(array $items)
    {
        $this->items = $items;
        Assert::arrayOf($this->type(), $items);
    }

    final public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items());
    }

    final public function count(): int
    {
        return count($this->items());
    }

    final public function push(mixed $item): void
    {
        $this->items[] = $item;
    }

    /** @return  array<int, mixed> $items */
    public function items(): array
    {
        return $this->items;
    }

    abstract protected function type(): string;
}

<?php

declare(strict_types=1);

namespace webpublic\components;

use IteratorAggregate;
use Traversable;
use ArrayObject;
use Countable;

/**
 * @implements \IteratorAggregate<int, MenuItem>
 */
class Menu implements IteratorAggregate, Countable
{
    /** @var array<int,MenuItem> $data */
    protected array $data = [];

    /**
     * @param array<array{url: ?string,text: ?string,children:array<int,mixed>}> $data
     */
    public function __construct(array $data)
    {
        foreach ($data as $item) {
            $this->data[] = new MenuItem($item['url'] ?? '', $item['text'] ?? '', $item['children'] ?? []);
        }
    }
    /**
     * @return Traversable<int,MenuItem>
     */
    public function getIterator(): Traversable
    {
        return new ArrayObject($this->data);
    }
    public function count(): int
    {
        return count($this->data);
    }
    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        $temp = [];
        foreach ($this->data as $item) {
            $temp[] = [
                'url' => $item->url(),
                'text' => $item->text(),
                'children' => $item->children()->toArray(),
            ];
        }
        return $temp;
    }
}

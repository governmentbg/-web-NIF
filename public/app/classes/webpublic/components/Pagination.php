<?php

declare(strict_types=1);

namespace webpublic\components;

use Iterator;

/**
 * @implements Iterator<int,int>
  */
class Pagination implements Iterator
{
    protected int $count;
    protected int $min;
    protected int $max;
    protected int $index;

    public function __construct(
        protected int $current = 1,
        protected int $perPage = 10,
        protected array $params = [],
        protected string $path = '',
        protected int $maxVisiblePages = 7,
        protected int $maxVisibleUpfrontPages = 3
    ) {
        $this->min = 0;
        $this->max = 0;
        $this->count = 0;
        $this->index = 0;
    }
    public function setCurrentPage(int $page): static
    {
        $this->current = $page;
        return $this;
    }
    public function setPerPage(int $perPage): static
    {
        $this->perPage = $perPage;
        return $this;
    }
    public function setParams(array $params): static
    {
        $this->params = $params;
        return $this;
    }
    public function setPath(string $path): static
    {
        $this->path = $path;
        return $this;
    }
    public function setMaxVisiblePages(int $maxVisiblePages): static
    {
        $this->maxVisiblePages = $maxVisiblePages;
        return $this;
    }
    public function setMaxVisibleUpfrontPages(int $maxVisibleUpfrontPages): static
    {
        $this->maxVisibleUpfrontPages = $maxVisibleUpfrontPages;
        return $this;
    }
    public function setItemsCount(int $itemsCount): void
    {
        $count = (int) ceil($itemsCount / $this->perPage);

        $this->count = $count;

        $max = $this->current + $this->maxVisibleUpfrontPages;
        if ($max > $count) {
            while ($max > $count) {
                $max--;
            }
        }
        $min = $max - $this->maxVisiblePages;
        if ($min < 1) {
            $min = 1;
            while ($max <= $this->maxVisiblePages && $max < $count) {
                $max++;
            }
        }

        $this->min = $min;
        $this->max = $max;

        $this->rewind();
    }
    public function current(): mixed
    {
        return $this->index;
    }
    public function next(): void
    {
        $this->index++;
    }
    public function key(): mixed
    {
        return $this->index;
    }
    public function valid(): bool
    {
        return $this->count && $this->index >= $this->min && $this->index <= $this->max;
    }
    public function rewind(): void
    {
        $this->index = $this->min;
    }
    public function getCurrentPage(): int
    {
        return $this->current;
    }
    public function getPerPage(): int
    {
        return $this->perPage;
    }
    public function getParams(): array
    {
        return $this->params;
    }
    public function getPath(): string
    {
        return $this->path;
    }
    public function getMin(): int
    {
        return $this->min;
    }
    public function getMax(): int
    {
        return $this->max;
    }
    public function getCount(): int
    {
        return $this->count;
    }
    public function hasFirst(): bool
    {
        return $this->min > 1;
    }
    public function getFirst(): int
    {
        return 1;
    }
    public function hasPrev(): bool
    {
        return $this->current > 1;
    }
    public function getPrev(): int
    {
        return $this->current - 1;
    }
    public function hasNext(): bool
    {
        return $this->current < $this->count;
    }
    public function getNext(): int
    {
        return $this->current + 1;
    }
    public function hasLast(): bool
    {
        return $this->max < $this->count;
    }
    public function getLast(): int
    {
        return $this->count;
    }
}

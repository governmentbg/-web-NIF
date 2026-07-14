<?php

declare(strict_types=1);

namespace schema;

use vakata\collection\Collection;
use vakata\database\schema\Entity;
use vakata\files\File;

/**
 * @property int $news
 * @property int $lang
 * @property string $fordate
 * @property string $title
 * @property ?int $image
 * @property string $content
 * @property int $hidden
 * @property string $visible_beg
 * @property ?string $visible_end
 * @property ?int $site
 * @property int $status
 * @property string $description
 * @property int $leading_news
 * @property \vakata\collection\Collection<int,TagsEntity> $tags via news_tags
 * @property LanguagesEntity $languages
 * @property ?UploadsEntity $uploads
 * @property ?SitesEntity $sites
 * @property \vakata\collection\Collection<int,NewsFilesEntity> $news_files
 * @property \vakata\collection\Collection<int,NewsImagesEntity> $news_images
 * @property \vakata\collection\Collection<int,NewsTypesEntity> $news_types
 */
class NewsEntity extends Entity
{
    protected ?NewsEntity $prev;
    protected ?NewsEntity $next;
    public function __construct(array $data = [], array $lazy = [], array $relations = [])
    {
        $this->prev = null;
        $this->next = null;

        parent::__construct($data, $lazy, $relations);
    }
    public function title(): string
    {
        return html_entity_decode($this->title);
    }
    public function getDate(): int
    {
        return (int) strtotime($this->fordate);
    }
    public function getDescription(): string
    {
        return html_entity_decode($this->description);
    }
    public function file(): ?File
    {
        return $this->uploads?->file();
    }
    public function getUrl(): string
    {
        return (string) $this->news;
    }
    public function setPrev(?NewsEntity $item): static
    {
        $this->prev = $item;

        return $this;
    }
    public function setNext(?NewsEntity $item): static
    {
        $this->next = $item;

        return $this;
    }
    public function getPrev(): ?NewsEntity
    {
        return $this->prev;
    }
    public function getNext(): ?NewsEntity
    {
        return $this->next;
    }
    /**
     * @return Collection<int|string,?File>
     */
    public function images(): Collection
    {
        return Collection::from(
            $this->relatedQuery('news_images')->sort('pos')
        )
        ->map(function (NewsImagesEntity $e) {
            return $e->file() ?? null;
        });
    }
    /** @return Collection<int,NewsFilesEntity> */
    public function files(): Collection
    {
        /** @var Collection<int,NewsFilesEntity> */
        return Collection::from(
            $this->relatedQuery('news_files')
                ->sort('pos')
                ->collection(['file'])
        )
        ->filter(function (NewsFilesEntity $file): bool {
            return (bool) $file->getFile();
        });
    }
}

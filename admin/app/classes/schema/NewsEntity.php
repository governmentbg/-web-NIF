<?php

declare(strict_types=1);

namespace schema;

use vakata\collection\Collection;
use vakata\database\schema\Entity;

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
 * @property ?UploadsEntity $uploads
 * @property LanguagesEntity $languages
 * @property ?SitesEntity $sites
 * @property \vakata\collection\Collection<int,NewsFilesEntity> $news_files
 * @property \vakata\collection\Collection<int,NewsImagesEntity> $news_images
 * @property \vakata\collection\Collection<int,NewsTypesEntity> $news_types
 */
class NewsEntity extends Entity
{
    /**
     * @psalm-suppress all
     * @return array<int,int>
     */
    public function images(): array
    {
        return Collection::from($this->news_images)
            ->map(function (NewsImagesEntity $item): int {
                return $item->image;
            })
            ->toArray();
    }
    public function files(): array
    {
        return Collection::from($this->news_files)
            ->map(function (NewsFilesEntity $item): int {
                return $item->file;
            })
            ->toArray();
    }
    public function types(): array
    {
        return Collection::from(
            $this->relatedQuery('news_types')
            ->sort('pos')
            ->collection(['news', 'type', 'pos'])
        )
        ->map(function (NewsTypesEntity $e): int {
            return $e->type;
        })->toArray();
    }
    public function tags(): array
    {
        return Collection::from($this->tags)
            ->map(function (TagsEntity $item): int {
                return $item->tag;
            })
            ->toArray();
    }
}

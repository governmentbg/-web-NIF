<?php

declare(strict_types=1);

namespace schema;

use vakata\collection\Collection;
use vakata\database\schema\Entity;

/**
 * @property int $document
 * @property int $lang
 * @property string $name
 * @property ?string $description
 * @property string $fordate
 * @property int $hidden
 * @property \vakata\collection\Collection<int,DocumentsCategoriesEntity> $documents_categories via documents_types
 * @property LanguagesEntity $languages
 * @property \vakata\collection\Collection<int,DocumentFilesEntity> $document_files
 */
class DocumentsEntity extends Entity
{
    public function files(): array
    {
        return Collection::from($this->document_files)
            ->map(function (DocumentFilesEntity $item) {
                return $item->file();
            })
            ->toArray();
    }
    public function types(): array
    {
        return $this->documents_categories->toArray('category');
    }
}

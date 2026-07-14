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
    public function getName(): string
    {
        return html_entity_decode($this->name);
    }
    public function getDescription(): string
    {
        return $this->description ? html_entity_decode($this->description) : '';
    }
    public function getDate(): int
    {
        return (int) strtotime($this->fordate);
    }
    /** @return Collection<int,DocumentFilesEntity> */
    public function getFiles(): Collection
    {
        /** @var Collection<int,DocumentFilesEntity> */
        return Collection::from(
            $this->relatedQuery('document_files')
                ->collection(['file'])
        )
        ->filter(function (DocumentFilesEntity $file): bool {
            return (bool) $file->getFile();
        });
    }
}

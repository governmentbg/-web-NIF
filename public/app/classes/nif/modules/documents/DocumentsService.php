<?php

declare(strict_types=1);

namespace nif\modules\documents;

use schema\DocumentsEntity;
use vakata\collection\Collection;
use vakata\database\DBInterface;
use vakata\database\schema\TableQueryMapped;

class DocumentsService
{
    public function __construct(protected DBInterface $db)
    {
    }
    /**
     * @psalm-suppress all
     * @return TableQueryMapped<DocumentsEntity>
     * */
    protected function repository(int $lang): TableQueryMapped
    {
        /** @psalm-suppress all */
        return $this->db->tableMapped('documents')
            ->with('documents_categories')
            ->with('document_files')
            ->filter('lang', $lang);
    }
    /** @return Collection<int,DocumentsEntity>  */
    public function getDocumentsById(array $ids, string $order, int $direction, int $lang): Collection
    {
        $repo = $this->repository($lang)
            ->filter('document', $ids);

        if (in_array($order, [ 'id', 'title', 'fordate' ])) {
            $repo->sort($order, (bool) $direction);
        }

        return $repo->collection();
    }
    /**
     * @return Collection<int,DocumentsEntity>
     */
    public function getDocumentsByGroup(array $categories, string $order, int $direction, int $lang): Collection
    {
        $repo = $this->repository($lang)
            ->filter('documents_categories.category', $categories);

        if (in_array($order, [ 'id', 'title', 'fordate' ])) {
            $repo->sort($order, (bool) $direction);
        }

        return $repo->collection();
    }
}

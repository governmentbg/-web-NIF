<?php

declare(strict_types=1);

namespace nif\modules\site\documents;

use vakata\database\DBInterface;
use vakata\database\schema\Entity;
use vakata\database\schema\TableQueryMapped;
use vakata\intl\Intl;
use vakata\user\User;
use webadmin\modules\common\crud\CRUDService;
use webadmin\modules\common\crud\CRUDServiceInterface;
use webadmin\modules\common\crud\CRUDModuleInterface;

/**
 * @extends CRUDService<\schema\DocumentsEntity>
 */
class DocumentsService extends CRUDService
{
    protected DBInterface $db;
    protected User $user;
    protected Intl $intl;

    /**
     * @param CRUDModuleInterface<\schema\DocumentsEntity,CRUDServiceInterface<\schema\DocumentsEntity>> $module
     */
    public function __construct(
        CRUDModuleInterface $module,
        DBInterface $db,
        User $user,
        Intl $intl
    ) {
        parent::__construct($module, $db, $user);
        $this->db = $db;
        $this->user = $user;
        $this->intl = $intl;
    }
    protected function entities(): TableQueryMapped
    {
        return parent::entities()
            ->filter('lang', array_keys($this->user->languages));
    }
    /**
     * @return array<int,string>
     */
    public function languages(): array
    {
        return $this->user->languages;
    }
    public function intl(): Intl
    {
        return $this->intl;
    }
    /**
     * @return array<int,string>
     */
    public function getTypes(): array
    {
        $document_types = $this->db
            ->table('documents_categories')
            ->select(['name']);
        $data = [];
        foreach ($document_types as $k => $v) {
            $data[$v['category']] = $v['name'];
        }
        return $data;
    }
    public function readQuery(): TableQueryMapped
    {
        return parent::readQuery()
            ->with('documents_categories')
            ->with('document_files', true, 'pos')
            ->with('document_files.uploads');
    }
    public function listQuery(): TableQueryMapped
    {
        /** @var TableQueryMapped<\schema\DocumentsEntity> */
        return parent::listQuery()
            ->sort('document')
            ->columns([
                'lang',
                'name',
                'fordate',
                'hidden'
            ]);
    }
    public function toArray(Entity $entity, bool $relations = false): array
    {
        $data = parent::toArray($entity, true);
        $data['files'] = $entity->files();
        $data['documents_categories'] = array_keys($entity->types());
        return $data;
    }
    protected function fromArray(Entity $entity, array $data = []): void
    {
        if (isset($data['files']) && is_string($data['files'])) {
            $pos = 0;
            $data['document_files'] = array_map(
                function (string $value) use (&$pos): array {
                    return [ 'file' => (int) $value, 'pos' => $pos++ ];
                },
                array_filter(
                    explode(
                        ',',
                        $data['files']
                    ),
                    function (mixed $value): bool {
                        return (bool) (int) $value;
                    }
                )
            );
            unset($data['files']);
        }
        parent::fromArray($entity, $data);
    }
    public function getCategories(): array
    {
        return $this->db->all(
            'SELECT category, name FROM documents_categories ORDER BY  category',
            null,
            'category',
            true
        );
    }
    public function getDocuments(): array
    {
        return $this->db->all('SELECT document, name FROM documents ORDER BY document', null, 'document', true);
    }
}

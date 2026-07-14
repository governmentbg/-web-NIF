<?php

declare(strict_types=1);

namespace nif\modules\site\programs;

use vakata\database\DBException;
use vakata\database\DBInterface;
use vakata\database\schema\Entity;
use vakata\database\schema\TableQueryMapped;
use vakata\intl\Intl;
use vakata\user\User;
use webadmin\modules\common\crud\CRUDServiceVersioned;

/**
 * @extends CRUDServiceVersioned<\schema\ProgramsEntity>
 * */
class ProgramsService extends CRUDServiceVersioned
{
    protected Intl $intl;
    public function __construct(ProgramsModule $module, DBInterface $db, User $user, Intl $intl)
    {
        parent::__construct($module, $db, $user);
        $this->intl = $intl;
    }
    public function listQuery(): TableQueryMapped
    {
        /** @var TableQueryMapped<\schema\ProgramsEntity> */
        return parent::listQuery()
            ->sort('program')
            ->columns([
                'lang',
                'title',
                'status',
                'p_beg',
                'p_end',
                'is_leading',
                'publish_status'
            ]);
    }
    public function readQuery(): TableQueryMapped
    {
        return parent::readQuery()
            ->with('programs_images', true, 'pos')
            ->with('programs_images.uploads')
            ->with('programs_files', true, 'pos')
            ->with('programs_files.uploads');
    }

    public function toArray(Entity $entity, bool $relations = false): array
    {
        $data = parent::toArray($entity, $relations);
        $data['images'] = $entity->images();
        $data['files'] = $entity->files();
        return $data;
    }
    protected function fromArray(Entity $entity, array $data = []): void
    {
        $data['created'] = $entity->program ?
            $entity->created :
            date('Y-m-d H:i:s');
        $data['updated'] = $entity->program ?
            date('Y-m-d H:i:s') :
            null;
        $data['created_by'] = $entity->program ?
            $entity->created_by :
            $this->user->getID();
        $data['updated_by'] = $entity->program ?
            $this->user->getID() :
            null;
        if (isset($data['files']) && is_string($data['files'])) {
            $pos = 0;
            $data['programs_files'] = array_map(
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
        if (isset($data['images']) && is_string($data['images'])) {
            $pos = 0;
            $data['programs_images'] = array_map(
                function (string $value) use (&$pos): array {
                    return [ 'image' => (int) $value, 'pos' => $pos++ ];
                },
                array_filter(
                    explode(
                        ',',
                        $data['images']
                    ),
                    function (mixed $value): bool {
                        return (bool) (int) $value;
                    }
                )
            );
            unset($data['images']);
        }
        parent::fromArray($entity, $data);
    }
    public function create(array $data = []): Entity
    {
        $entity = parent::create($data);
        $this->version($entity, 0, true);
        return $entity;
    }
    public function update(mixed $id, array $data = []): Entity
    {
        $entity = parent::update($id, $data);
        $this->version($entity, 1, true);
        return $entity;
    }
    public function languages(): array
    {
        return $this->user->languages;
    }
    public function intl(): Intl
    {
        return $this->intl;
    }
    public function getTypes(): array
    {
        return $this->db->all(
            "SELECT
                name,
                category
            FROM program_categories
            ORDER BY category",
            null,
            'category',
            true
        );
    }
    public function archiveProgram(int $id): void
    {
        try {
            $this->db->table('programs')->filter('program', $id)->update(['publish_status' => 2]);
        } catch (DBException) {
        }
    }
    public function publishProgram(int $id): void
    {
        try {
            $this->db->table('programs')->filter('program', $id)->update(['publish_status' => 1]);
        } catch (DBException) {
        }
    }
    public function checkPublishStatus(int $id): int
    {
        return $this->db->table('programs')->filter('program', $id)->select(['publish_status'])[0]['publish_status'];
    }
    public function statuses(): array
    {
        return [
            0 => $this->intl()->get($this->module->getName() . '.value.active'),
            1 => $this->intl()->get($this->module->getName() . '.value.past'),
            2 => $this->intl()->get($this->module->getName() . '.value.upcoming'),
            3 => $this->intl()->get($this->module->getName() . '.value.in_progress'),
            4 => $this->intl()->get($this->module->getName() . '.value.cancelled')
        ];
    }
    public function publishStatus(): array
    {
        return [
            0 => $this->intl()->get($this->module->getName() . '.value.draft'),
            1 => $this->intl()->get($this->module->getName() . '.value.published'),
            2 => $this->intl()->get($this->module->getName() . '.value.archived')
        ];
    }
}

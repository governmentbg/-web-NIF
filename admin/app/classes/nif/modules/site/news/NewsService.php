<?php

declare(strict_types=1);

namespace nif\modules\site\news;

use vakata\collection\Collection;
use vakata\database\DBInterface;
use vakata\database\schema\Entity;
use vakata\database\schema\TableQueryMapped;
use vakata\intl\Intl;
use vakata\user\User;
use webadmin\modules\site\news\NewsService as WebadminNewsService;

class NewsService extends WebadminNewsService
{
    protected Intl $intl;
    protected User $user;
    protected DBInterface $db;
    public function __construct(NewsModule $module, DBInterface $db, User $user, Intl $intl)
    {
        parent::__construct($module, $db, $user);
        $this->module = $module;
        $this->user = $user;
        $this->db = $db;
        $this->intl = $intl;
    }
    public function listQuery(): TableQueryMapped
    {
        /** @var TableQueryMapped<\schema\NewsEntity> */
        return parent::listQuery()
            ->sort('fordate', true)
            ->columns([
                'lang',
                'fordate',
                'title',
                'hidden',
                'tags.tag',
                'tags.name',
                'news_types.type',
                'status'
            ]);
    }
    public function readQuery(): TableQueryMapped
    {
        return parent::readQuery()
            ->with('news_files', true, 'pos')
            ->with('news_files.uploads')
            ->with('news_images', true, 'pos')
            ->with('news_images.uploads')
            ->with('news_types')
            ->with('tags');
    }
    public function toArray(Entity $entity, bool $relations = false): array
    {
        $data = parent::toArray($entity, $relations);
        $data['tags'] = $entity->tags();
        $data['images'] = $entity->images();
        $data['files'] = $entity->files();
        $data['categories[]'] = $entity->types();
        return $data;
    }
    protected function fromArray(Entity $entity, array $data = []): void
    {
        if (isset($data['categories']) && is_array($data['categories'])) {
            $pos = 0;
            $data['news_types'] = array_map(function (mixed $value) use ($pos) {
                return ['type' => (int) $value, "pos" => $pos++];
            },
            array_filter(
                $data['categories']
            ));
            unset($data['categories']);
        } else {
            $data['news_types'] = [];
            unset($data['categories']);
        }
        if (isset($data['files']) && is_string($data['files'])) {
            $pos = 0;
            $data['news_files'] = array_map(
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
            $data['news_images'] = array_map(
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
        $data['tags'] = array_unique($data['tags'] ?? []);
        parent::fromArray($entity, $data);
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
            FROM news_categories
            ORDER BY category",
            null,
            'category',
            true
        );
    }
    public function getTags(): array
    {
        return $this->db->all('SELECT tag, name FROM tags ORDER BY  tag', null, 'tag', true);
    }
    public function statuses(): array
    {
        return [
            0 => $this->intl()->get($this->module->getName() . '.value.not_active'),
            1 => $this->intl()->get($this->module->getName() . '.value.active')
        ];
    }
}

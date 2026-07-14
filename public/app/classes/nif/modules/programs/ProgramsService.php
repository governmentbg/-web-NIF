<?php

declare(strict_types=1);

namespace nif\modules\programs;

use schema\ProgramsEntity;
use vakata\collection\Collection;
use vakata\database\DBInterface;
use vakata\database\schema\TableQueryMapped;
use vakata\intl\Intl;

class ProgramsService
{
    public function __construct(
        protected DBInterface $db,
        protected Intl $intl
    ) {
    }
    /**
     * @psalm-suppress all
     * @return TableQueryMapped<ProgramsEntity>
     * */
    public function repo(int $lang): TableQueryMapped
    {
        /**@psalm-suppress all */
        return $this->db->tableMapped('programs')
            ->filter('lang', $lang)
            ->filter('publish_status', 1);
    }
    /**
     * @param integer $lang
     * @return array<int,Collection<int,ProgramsEntity>>
     */
    public function activePrograms(int $lang): array
    {
        $programs = $this->repo($lang)
            ->filter('status', 0)
            ->sort('created', true)
            ->limit(3)
            ->collection(['program', 'title', 'description', 'budget', 'm_duration'])
            ->toArray();
        return $programs;
    }
    /**
     * @param integer $lang
     * @param integer $id
     * @return ?ProgramsEntity
     */
    public function single(int $lang, int $id): ?ProgramsEntity
    {
        /** @var ?ProgramsEntity $item */
        $item = $this->repo($lang)
            ->filter('program', $id)
            ->with('programs_images', true, 'pos')
            ->with('programs_images.uploads')
            ->with('programs_files', true, 'pos')
            ->with('programs_files.uploads')
            ->select()[0] ?? null;
        if ($item) {
            $temp = $this->repo($lang)
                ->where('p_beg >= ?', [$item->p_beg])
                ->order('p_beg ASC, program DESC')
                ->filter('program', $id, true)
                ->limit(1, 0, true);
            $item->setPrev($temp->select(['title'])[0] ?? null);

            $temp = $this->repo($lang)
                ->where('p_beg <= ?', [$item->p_beg])
                ->order('p_beg DESC, program DESC')
                ->filter('program', $id, true)
                ->limit(1, 0, true);
            $prev = $item->getPrev();
            if ($prev) {
                $temp->filter('program', $prev->program, true);
            }
            $item->setNext($temp->select(['title'])[0] ?? null);
        }
        return $item;
    }
    /**
     * @return array{count:int,items:Collection<int,ProgramsEntity>}
     */
    public function listing(
        int $lang,
        array $data,
        int $page = 1,
        int $perpage = 10
    ): array {
        $repo = $this->repo($lang)
            ->with('program_categories')
            ->filter('program_categories.is_active', 1)
            ->filter('program_categories.lang', $lang)
            ->sort('program', true)
            ->sort('is_leading', true)
            ->paginate(max(1, $page), $perpage)
            ->limitOnMainTable(true);
        if (
            isset($data['categories']) &&
            is_array($data['categories']) &&
            count(array_filter($data['categories']))
        ) {
            $repo->filter('type', array_filter($data['categories']));
        }
        if (
            isset($data['status']) &&
            is_array($data['status']) &&
            count($data['status'])
        ) {
            $repo->filter('status', $data['status']);
        }
        if (isset($data['date_from']) && strlen(trim($data['date_from']))) {
            $repo->where('p_beg >= ?', [date('Y-m-d', (int) strtotime($data['date_from']))]);
        }
        if (isset($data['date_to']) && strlen(trim($data['date_to']))) {
            $repo->where('p_end <= ?', [date('Y-m-d 23:59:59', (int) strtotime($data['date_to']))]);
        }
        return [
            'count' => $repo->count(),
            'items' => $repo->collection(['program', 'title', 'description', 'budget', 'm_duration', 'status'])
        ];
    }
    public function getCategories(int $lang): array
    {
        /**@psalm-suppress all */
        return $this->db->tableMapped('program_categories')
            ->filter('lang', $lang)
            ->filter('is_active', 1)
            ->collection(['category', 'name'])
            ->toArray();
    }
    public function statuses(): array
    {
        return [
            0 => $this->intl->get('programs.status.active'),
            1 => $this->intl->get('programs.status.not_active'),
            2 => $this->intl->get('programs.status.upcoming'),
            3 => $this->intl->get('programs.status.in_progress'),
            4 => $this->intl->get('programs.status.cancelled')
        ];
    }
    public function currentFilterStatus(array $statuses): string
    {
        if (!count($statuses) || count($statuses) === count($this->statuses())) {
            return $this->intl->get('programs.curr.status.all');
        }
        $intl_statuses = $this->statuses();
        $arr = [];
        foreach ($statuses as $k => $status) {
            if (key_exists((int)$status, $intl_statuses)) {
                $arr[] = $intl_statuses[(int) $status];
            }
        }
        return implode(', ', $arr) . " " . $this->intl->get('programs');
    }
    public function singleStatus(): array
    {
        return [
            0 => $this->intl->get('programs.status.single.active'),
            1 => $this->intl->get('programs.status.single.past'),
            2 => $this->intl->get('programs.status.single.upcoming'),
            3 => $this->intl->get('programs.status.single.in_progress'),
            4 => $this->intl->get('programs.status.single.cancelled')
        ];
    }
}

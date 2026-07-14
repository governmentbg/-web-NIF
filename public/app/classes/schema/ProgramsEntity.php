<?php

declare(strict_types=1);

namespace schema;

use vakata\collection\Collection;
use vakata\database\schema\Entity;
use vakata\files\File;

/**
 * @property int $program
 * @property int $lang
 * @property string $title
 * @property string $description
 * @property int $status
 * @property ?int $m_duration
 * @property string $p_beg
 * @property string $p_end
 * @property ?string $budget
 * @property int $is_leading
 * @property int $header_img
 * @property ?string $content
 * @property ?string $redirect_url
 * @property int $publish_status
 * @property string $created
 * @property ?string $updated
 * @property int $created_by
 * @property ?int $updated_by
 * @property ?int $type
 * @property LanguagesEntity $languages
 * @property UploadsEntity $uploads
 * @property ?ProgramCategoriesEntity $program_categories
 * @property UsersEntity $created_by_users
 * @property ?UsersEntity $updated_by_users
 * @property \vakata\collection\Collection<int,ProgramsImagesEntity> $programs_images
 * @property \vakata\collection\Collection<int,ProgramsFilesEntity> $programs_files
 */
class ProgramsEntity extends Entity
{
    protected ?ProgramsEntity $prev;
    protected ?ProgramsEntity $next;

    public function __construct(array $data = [], array $lazy = [], array $relations = [])
    {
        $this->prev = null;
        $this->next = null;
        parent::__construct($data, $lazy, $relations);
    }
    public function getTitle(): string
    {
        return html_entity_decode($this->title);
    }
    public function getDescription(): string
    {
        return html_entity_decode($this->description);
    }
    public function getStatus(): int
    {
        return $this->status;
    }
    public function statusColor(): string
    {
        switch ($this->status) {
            case 0:
                return 'active';
            case 1:
                return 'past';
            case 2:
                return 'upcomming';
            case 3:
                return 'in_progress';
            default:
                return 'cancelled';
        }
    }
    public function getBegDate(): int
    {
        return (int) strtotime($this->p_beg);
    }
    public function getEndDate(): int
    {
        return (int) strtotime($this->p_end);
    }
    public function monthsDuration(): ?int
    {
        return $this->m_duration;
    }
    public function getBudget(): string
    {
        return $this->budget && strlen($this->budget) ? html_entity_decode($this->budget) : '';
    }
    public function getUrl(): string
    {
        return (string) $this->program;
    }
    public function getImage(): ?File
    {
        return $this->uploads->file();
    }
    public function setPrev(?ProgramsEntity $item): static
    {
        $this->prev = $item;

        return $this;
    }
    public function setNext(?ProgramsEntity $item): static
    {
        $this->next = $item;

        return $this;
    }
    public function getPrev(): ?ProgramsEntity
    {
        return $this->prev;
    }
    public function getNext(): ?ProgramsEntity
    {
        return $this->next;
    }
    /**
     * @return Collection<int|string,?File>
     */
    public function images(): Collection
    {
        return Collection::from(
            $this->relatedQuery('programs_images')->sort('pos')
        )
        ->map(function (ProgramsImagesEntity $e) {
            return $e->file() ?? null;
        });
    }
    /**
     * @return Collection<int,ProgramsFilesEntity>
     */
    public function files(): Collection
    {
        /** @var Collection<int,ProgramsFilesEntity> */
        return Collection::from(
            $this->relatedQuery('programs_files')
            ->collection(['file'])
        )
        ->filter(function (ProgramsFilesEntity $file): bool {
            return (bool) $file->getFile();
        });
    }
}

<?php

declare(strict_types=1);

namespace schema;

use vakata\collection\Collection;
use vakata\database\schema\Entity;

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
 * @property ?ProgramCategoriesEntity $program_categories
 * @property UploadsEntity $uploads
 * @property UsersEntity $created_by_users
 * @property ?UsersEntity $updated_by_users
 * @property \vakata\collection\Collection<int,ProgramsFilesEntity> $programs_files
 * @property \vakata\collection\Collection<int,ProgramsImagesEntity> $programs_images
 */
class ProgramsEntity extends Entity
{
    public function images(): array
    {
         return Collection::from($this->programs_images)
            ->map(function (ProgramsImagesEntity $item): int {
                return $item->image;
            })
            ->toArray();
    }
    public function files(): array
    {
        return Collection::from($this->programs_files)
            ->map(function (ProgramsFilesEntity $item): int {
                return $item->file;
            })
            ->toArray();
    }
}

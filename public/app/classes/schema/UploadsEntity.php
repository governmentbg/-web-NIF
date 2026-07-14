<?php

declare(strict_types=1);

namespace schema;

use vakata\database\schema\Entity;
use vakata\files\File;
use vakata\files\FileStorageInterface;

/**
 * @property int $id
 * @property string $name
 * @property string $location
 * @property int $bytesize
 * @property string $uploaded
 * @property string $hash
 * @property ?string $data
 * @property ?string $settings
 * @property \vakata\collection\Collection<int,CollectionsEntity> $collections via upload_collections
 * @property \vakata\collection\Collection<int,UsersEntity> $users via upload_user
 * @property \vakata\collection\Collection<int,DocumentFilesEntity> $document_files
 * @property \vakata\collection\Collection<int,NewsFilesEntity> $news_files
 * @property \vakata\collection\Collection<int,UploadsVersionsEntity> $uploads_versions
 * @property \vakata\collection\Collection<int,ProgramsEntity> $programs
 * @property \vakata\collection\Collection<int,ProgramsImagesEntity> $programs_images
 * @property \vakata\collection\Collection<int,ProgramsFilesEntity> $programs_files
 * @property \vakata\collection\Collection<int,NewsEntity> $news
 * @property \vakata\collection\Collection<int,GalleryImagesEntity> $gallery_images
 * @property \vakata\collection\Collection<int,UsersEntity> $users_avatar
 * @property \vakata\collection\Collection<int,NewsImagesEntity> $news_images
 * @property \vakata\collection\Collection<int,InfoblocksEntity> $infoblocks
 * @property \vakata\collection\Collection<int,BannersEntity> $banners
 */
class UploadsEntity extends Entity
{
    protected FileStorageInterface $files;
    /**
     * @param FileStorageInterface $files
     * @param array<string,mixed> $data
     * @param array<string,callable> $lazy
     * @param array<string,callable> $relations
     */
    public function __construct(FileStorageInterface $files, array $data = [], array $lazy = [], array $relations = [])
    {
        $this->files = $files;
        parent::__construct($data, $lazy, $relations);
    }
    public function file(): ?File
    {
        return $this->files->get((string)$this->id);
    }
}

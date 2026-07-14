<?php

declare(strict_types=1);

namespace schema;

use vakata\database\schema\Entity;

/**
 * @property int $usr
 * @property string $name
 * @property string $mail
 * @property int $tfa
 * @property int $disabled
 * @property ?int $avatar
 * @property ?string $avatar_data
 * @property ?string $data
 * @property ?string $push
 * @property ?string $sessions
 * @property \vakata\collection\Collection<int,OrganizationEntity> $organization via user_organizations
 * @property \vakata\collection\Collection<int,UploadsEntity> $uploads via upload_user
 * @property \vakata\collection\Collection<int,LanguagesEntity> $languages via user_lang
 * @property \vakata\collection\Collection<int,SitesEntity> $sites via user_site
 * @property ?UploadsEntity $avatar_uploads
 * @property \vakata\collection\Collection<int,ProgramsEntity> $programs_created_by
 * @property \vakata\collection\Collection<int,ProgramsEntity> $programs_updated_by
 * @property \vakata\collection\Collection<int,LogEntity> $log
 * @property \vakata\collection\Collection<int,LogSystemEntity> $log_system
 * @property \vakata\collection\Collection<int,UserGroupsEntity> $user_groups
 * @property \vakata\collection\Collection<int,UserGroupsProvisionalEntity> $user_groups_provisional
 * @property \vakata\collection\Collection<int,UserProvidersEntity> $user_providers
 * @property \vakata\collection\Collection<int,CollectionsEntity> $collections
 * @property \vakata\collection\Collection<int,TreeDataEntity> $tree_data
 * @property \vakata\collection\Collection<int,TreeDataPubEntity> $tree_data_pub
 */
class UsersEntity extends Entity
{
}

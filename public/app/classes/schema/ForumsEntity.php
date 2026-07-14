<?php

declare(strict_types=1);

namespace schema;

use vakata\database\schema\Entity;

/**
 * @property int $forum
 * @property string $created
 * @property int $usr
 * @property string $name
 * @property int $hidden
 * @property int $locked
 * @property \vakata\collection\Collection<int,ForumTopicsEntity> $forum_topics
 * @property ?UsersEntity $users
 */
class ForumsEntity extends Entity
{
}

<?php

declare(strict_types=1);

namespace schema;

use vakata\database\schema\Entity;

/**
 * @property int $usr
 * @property int $topic
 * @property string $created
 * @property ?string $seen
 * @property ?ForumTopicsEntity $forum_topics
 * @property ?UsersEntity $users
 */
class UserForumsEntity extends Entity
{
}

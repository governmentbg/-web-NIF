<?php

declare(strict_types=1);

namespace schema;

use vakata\database\schema\Entity;

/**
 * @property int $collection
 * @property int $grp
 * @property int $rw
 * @property GrpsEntity $grps
 * @property CollectionsEntity $collections
 */
class CollectionGroupsEntity extends Entity
{
}

<?php

declare(strict_types=1);

namespace schema;

use vakata\database\schema\Entity;

/**
 * @property int $id
 * @property string $created
 * @property string $lvl
 * @property string $message
 * @property ?string $context
 * @property ?string $request
 * @property ?string $response
 * @property string $ip
 * @property string $ua
 */
class LogPublicEntity extends Entity
{
}

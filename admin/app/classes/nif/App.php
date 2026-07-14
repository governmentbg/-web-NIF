<?php

declare(strict_types=1);

namespace nif;

use webadmin\App as WebadminApp;
use vakata\config\Config;
use vakata\http\Request;
use vakata\http\Response;

class App extends WebadminApp
{
    public static function init(): self
    {
        /** @psalm-suppress InvalidArgument */
        return new self(
            (require __DIR__ . '/../../../.env.php') ?? Config::parseEnvFile(__DIR__ . '/../../../.env')
        );
    }
    public function defaults(): array
    {
        return array_merge(
            parent::defaults(),
            [
                "CACHE"                => "memcached",
                'RATELIMIT_REQUESTS'   => 5,
                'RATELIMIT_SECONDS'    => 900,
                'PUBLIC_URL'           => "https://nif.government.bg/",
                "MIDDLEWARE_RATELIMIT" => true
            ]
        );
    }
}

#!/usr/bin/env php
<?php

declare(strict_types=1);

use vakata\random\Generator;
use nif\App;
use webpublic\Jobs;

set_time_limit(0);

if (php_sapi_name() !== 'cli') {
    echo 'Command line usage only!';
    exit(1);
}

if (!is_file(__DIR__ . '/../.env.php')) {
    file_put_contents(
        __DIR__ . '/../.env.php',
        '<?' . 'php return null;' . "\n"
    );
}

require_once __DIR__ . '/../vendor/autoload.php';

if (!is_file(__DIR__ . '/../.env')) {
    $name = basename(realpath(__DIR__ . '/../') ?: '');
    file_put_contents(
        __DIR__ . '/../.env',
        implode("\n", [
            'SIGNATUREKEY = "' . Generator::string(32) . '"',
            'ENCRYPTIONKEY = "' . Generator::string(32) . '"',
            ''
        ])
    );
}

$jobs = App::init()->di()->instance(Jobs::class);

try {
    switch ($argv[1] ?? '') {
        case 'setup':
            $jobs->setup();
            break;
        case 'permissions':
            $jobs->permissions();
            break;
        case 'cache:clean':
            $jobs->cacheClean();
            break;
        case 'cache:env':
            $jobs->cacheEnv();
            break;
        case 'cache:langs':
            $jobs->cacheLangs();
            break;
        case 'cache:schema':
            $jobs->cacheSchema();
            break;
        case 'tmp:clean':
            $jobs->tmpClean();
            break;
        case 'migrations:up':
            $jobs->migrationsUp();
            break;
        case 'migrations:test':
            $jobs->migrationsTest();
            break;
        case 'migrations:reset':
            $jobs->migrationsReset();
            break;
        case 'version:create':
            $jobs->versionCreate($argv[2] ?? '', $argv[3] ?? null);
            break;
        case 'version:deploy':
            $jobs->versionDeploy($argv[2] ?? '');
            break;
        case 'version:revert':
            $jobs->versionRevert();
            break;
        case 'index':
            $jobs->index($argv[2] ?? null);
            break;
        case 'schema':
            $jobs->schema();
            break;
        default:
            throw new RuntimeException('Invalid command');
    }
    exit(0);
} catch (RuntimeException $e) {
    echo $e->getMessage() . "\r\n";
    exit(1);
}

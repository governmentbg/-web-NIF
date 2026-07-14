<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use nif\App;

$app = App::init();
$app->emit(
    $app->run($app->stack(), $app->req())
);

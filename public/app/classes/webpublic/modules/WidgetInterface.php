<?php

declare(strict_types=1);

namespace webpublic\modules;

interface WidgetInterface
{
    public function render(): string;
}

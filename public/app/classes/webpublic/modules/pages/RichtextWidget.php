<?php

declare(strict_types=1);

namespace webpublic\modules\pages;

use vakata\views\Views;
use webpublic\modules\WidgetInterface;

class RichtextWidget implements WidgetInterface
{
    /**
     * @param Views $views
     * @param array<string,mixed> $params
     */
    public function __construct(
        protected Views $views,
        protected array $params = []
    ) {
        $views->addFolder('pages', __DIR__ . '/views');
    }
    public function render(): string
    {
        return $this->params['richtext'] ?? '';
    }
}

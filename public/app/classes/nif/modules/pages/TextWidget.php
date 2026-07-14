<?php

declare(strict_types=1);

namespace nif\modules\pages;

use vakata\views\Views;
use webpublic\modules\WidgetInterface;

class TextWidget implements WidgetInterface
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
        return $this->views->render('pages::text', [ 'content' => $this->params['textarea'] ?? '' ]);
    }
}

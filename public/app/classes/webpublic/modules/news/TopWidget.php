<?php

declare(strict_types=1);

namespace webpublic\modules\news;

use vakata\views\Views;
use webpublic\modules\WidgetInterface;

class TopWidget implements WidgetInterface
{
    /**
     * @param NewsService $news
     * @param Views $views
     * @param array<string,mixed> $params
     */
    public function __construct(
        protected NewsService $news,
        protected Views $views,
        protected array $params = []
    ) {
        $views->addFolder('news', __DIR__ . '/views');
    }
    public function render(): string
    {
        return $this->views->render(
            'news::top',
            [
                'news' => $this->news->top(
                    (int)($this->params['tag'] ?? 0),
                    (int)($this->params['count'] ?? 3)
                )
            ]
        );
    }
}

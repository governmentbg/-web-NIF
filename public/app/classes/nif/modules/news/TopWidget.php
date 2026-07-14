<?php

declare(strict_types=1);

namespace nif\modules\news;

use vakata\views\Views;
use webpublic\components\Page;
use webpublic\components\ParamsContainer;
use webpublic\modules\WidgetInterface;

class TopWidget implements WidgetInterface
{
    /**
     * @param NewsService $news
     * @param Page $page
     * @param Views $views
     * @param array<string,mixed> $params
     */
    public function __construct(
        protected NewsService $news,
        protected Page $page,
        protected Views $views,
        protected array $params
    ) {
        $this->views->addFolder('news', __DIR__ . '/views');
    }
    public function render(): string
    {
        $params = new ParamsContainer($this->params);
        [ 'count' => $count, 'items' => $items ] = $this->news->top(
            $this->page->language()->lang(),
            $params->getArray('categories'),
            $params->getArray('tags'),
            6
        );
        return $this->views->render(
            'news::top',
            [
                'title' => $params->getString('title'),
                'link'  => $params->getString('link'),
                'page'  => $this->page,
                'news'  => $items,
                'count' => $count
            ]
        );
    }
}

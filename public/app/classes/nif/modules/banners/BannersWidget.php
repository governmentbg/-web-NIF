<?php

declare(strict_types=1);

namespace nif\modules\banners;

use vakata\views\Views;
use webpublic\components\Page;
use webpublic\modules\WidgetInterface;

class BannersWidget implements WidgetInterface
{
    public function __construct(
        protected BannersService $service,
        protected Page $page,
        protected Views $views,
        protected array $params
    ) {
        $this->views->addFolder('banners', __DIR__ . '/views');
    }
    public function render(): string
    {
        return $this->views->render(
            'banners::banners',
            [
                'banners' => $this->service->listing($this->page->language()->lang())
            ]
        );
    }
}

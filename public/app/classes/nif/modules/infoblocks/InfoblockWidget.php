<?php

declare(strict_types=1);

namespace nif\modules\infoblocks;

use vakata\views\Views;
use webpublic\components\Page;
use webpublic\modules\WidgetInterface;
use webpublic\components\ParamsContainer;

class InfoblockWidget implements WidgetInterface
{
    /**
     * @param Views $views
     * @param InfoblocksService $service
     * @param Page $page
     * @param array<string,mixed> $params
     */
    public function __construct(
        protected Views $views,
        protected InfoblocksService $service,
        protected Page $page,
        protected array $params
    ) {
        $this->views->addFolder('infoblocks', __DIR__ . '/views');
    }
    public function render(): string
    {
        $params = new ParamsContainer($this->params);
        return $this->views->render(
            'infoblocks::infoblocks',
            ['infoblocks' => $this->service->blocks($this->page->language()->lang(), $params->getArray('infoblocks'))]
        );
    }
}

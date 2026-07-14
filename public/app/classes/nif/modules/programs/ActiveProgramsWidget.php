<?php

declare(strict_types=1);

namespace nif\modules\programs;

use vakata\views\Views;
use webpublic\components\Page;
use webpublic\modules\WidgetInterface;

class ActiveProgramsWidget implements WidgetInterface
{
    /**
     * @param Views $views
     * @param ProgramsService $service
     * @param Page $page
     * @param array<string,mixed> $params
     */
    public function __construct(
        protected Views $views,
        protected ProgramsService $service,
        protected Page $page,
        protected array $params
    ) {
        $this->views->addFolder('programs', __DIR__ . '/views');
    }
    public function render(): string
    {
        return $this->views->render(
            'programs::activeprograms',
            [
                'programs' => $this->service->activePrograms($this->page->language()->lang()),
                'page'     => $this->page
            ]
        );
    }
}

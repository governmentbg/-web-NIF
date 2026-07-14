<?php

declare(strict_types=1);

namespace nif\modules\documents;

use vakata\views\Views;
use webpublic\components\Page;
use webpublic\components\ParamsContainer;
use webpublic\modules\WidgetInterface;

class DocumentsGroupWidget implements WidgetInterface
{
    /**
     * @param Views $views
     * @param DocumentsService $service
     * @param array<string,mixed> $params
     */
    public function __construct(
        protected Views $views,
        protected DocumentsService $service,
        protected Page $page,
        protected array $params = []
    ) {
        $views->addFolder('documents', __DIR__ . '/views');
    }
    public function render(): string
    {
        $params = new ParamsContainer($this->params);
        return $this->views->render(
            'documents::documents',
            [
                'documents' => $this->service
                    ->getDocumentsByGroup(
                        $params->getArray('group'),
                        $params->getString('order_by') ?? 'fordate',
                        $params->getInt('order_direction') ?? 0,
                        (int)$this->page->language()->lang()
                    ),
                'title' => $params->getString('name')
            ]
        );
    }
}

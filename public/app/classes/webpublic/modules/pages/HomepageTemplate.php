<?php

declare(strict_types=1);

namespace webpublic\modules\pages;

use vakata\views\Views;
use webpublic\components\Page;
use vakata\http\Response;
use webpublic\components\ParamsContainer;
use webpublic\modules\WidgetInterface;

class HomepageTemplate
{
    /**
     * @param Page $page
     * @param Views $views
     * @param ParamsContainer $params
     * @param array<string,list<WidgetInterface>> $widgets
     */
    public function __construct(
        protected Page $page,
        protected Views $views,
        protected ParamsContainer $params,
        protected array $widgets = []
    ) {
        $views->addFolder('pages', __DIR__ . '/views');
    }
    public function get(): Response
    {
        return new Response(
            200,
            $this->views->render(
                'pages::homepage',
                [
                    'page' => $this->page,
                    'content' => $this->params->getString('content', '') ?? '',
                    'widgets' => $this->widgets
                ]
            )
        );
    }
}

<?php

declare(strict_types=1);

namespace nif\modules\pages;

use vakata\http\Response;
use vakata\views\Views;
use webpublic\components\Page;
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
                    'page'    => $this->page,
                    'content' => $this->params->getString('content', '') ?? '',
                    'link'    => $this->params->getString('link', '') ?? '',
                    'widgets' => $this->widgets
                ]
            )
        );
    }
}

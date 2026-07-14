<?php

declare(strict_types=1);

namespace nif\modules\pages;

use vakata\http\Response;
use vakata\views\Views;
use webpublic\components\Page;

class SitemapTemplate
{
    public function __construct(
        protected Page $page,
        protected Views $views
    ) {
        $this->views->addFolder('pages', __DIR__ . '/views');
    }
    public function get(): Response
    {
        return new Response(
            200,
            $this->views->render(
                'pages::sitemap',
                [
                    'page' => $this->page
                ]
            )
        );
    }
}

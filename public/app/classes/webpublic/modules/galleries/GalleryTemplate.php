<?php

declare(strict_types=1);

namespace webpublic\modules\galleries;

use vakata\views\Views;
use vakata\http\Request;
use webpublic\components\Page;
use vakata\http\Response;
use webpublic\components\Pagination;
use webpublic\components\ParamsContainer;
use webpublic\modules\WidgetInterface;

class GalleryTemplate
{
    /**
     * @param GalleriesService $service
     * @param Page $page
     * @param Views $views
     * @param ParamsContainer $params
     * @param array<string,list<WidgetInterface>> $widgets
     */
    public function __construct(
        protected GalleriesService $service,
        protected Page $page,
        protected Views $views,
        protected ParamsContainer $params,
        protected array $widgets = []
    ) {
        $views->addFolder('galleries', __DIR__ . '/views');
    }
    public function get(Request $req): Response
    {
        $pagination = new Pagination(
            max(1, $req->getQuery('p', 1, 'int')),
            min(50, $this->params->getInt('perpage', 10) ?: 10),
            $req->getQuery(),
            $req->getUrl()->getRealPath(true)
        );
        [ 'count' => $count, 'items' => $items ] = $this->service->listing(
            (int)$this->page->language()->lang(),
            (int)($this->params->getInt('tags') ?? 0),
            $pagination->getCurrentPage(),
            $pagination->getPerPage()
        );
        $pagination->setItemsCount($count);
        return new Response(
            200,
            $this->views->render(
                'galleries::galleries',
                [
                    'page' => $this->page,
                    'widgets' => $this->widgets,
                    'galleries' => $items,
                    'pagination' => $pagination
                ]
            )
        );
    }
}

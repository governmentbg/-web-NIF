<?php

declare(strict_types=1);

namespace webpublic\modules\pages;

use vakata\views\Views;
use vakata\database\DBInterface;
use vakata\http\Request;
use webpublic\components\Page;
use vakata\http\Response;
use webpublic\components\Pagination;
use webpublic\components\ParamsContainer;
use webpublic\components\Site;
use webpublic\modules\WidgetInterface;

class SearchTemplate
{
    /**
     * @param SearchService $service
     * @param Site $site
     * @param Page $page
     * @param Views $views
     * @param ParamsContainer $params
     * @param array<string,list<WidgetInterface>> $widgets
     */
    public function __construct(
        protected SearchService $service,
        protected Site $site,
        protected Page $page,
        protected Views $views,
        protected ParamsContainer $params,
        protected array $widgets = []
    ) {
        $views->addFolder('pages', __DIR__ . '/views');
    }
    public function get(Request $req): Response
    {
        $q = (string)$req->getQuery('q', '', 'string');
        $pagination = new Pagination(
            max(1, $req->getQuery('p', 1, 'int')),
            min(50, $this->params->getInt('perpage', 10) ?: 10),
            $req->getQuery(),
            $req->getUrl()->getRealPath(true)
        );
        $items = null;
        if (strlen($q)) {
            [ 'count' => $count, 'items' => $items ] = $this->service->listing(
                (int)$this->page->language()->lang(),
                $q,
                $pagination->getCurrentPage(),
                $pagination->getPerPage()
            );
            $pagination->setItemsCount($count);
        }

        return new Response(
            200,
            $this->views->render(
                'pages::search',
                [
                    'page' => $this->page,
                    'q' => $q,
                    'pagination' => $pagination,
                    'results' => $items,
                    'widgets' => $this->widgets
                ]
            )
        );
    }
}

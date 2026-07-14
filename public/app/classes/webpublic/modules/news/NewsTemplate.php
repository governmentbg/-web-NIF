<?php

declare(strict_types=1);

namespace webpublic\modules\news;

use vakata\views\Views;
use RuntimeException;
use vakata\http\Request;
use webpublic\components\Page;
use vakata\http\Response;
use vakata\http\Uri;
use webpublic\components\Pagination;
use webpublic\components\ParamsContainer;
use webpublic\modules\WidgetInterface;

class NewsTemplate
{
    /**
     * @param NewsService $service
     * @param Page $page
     * @param Views $views
     * @param ParamsContainer $params
     * @param array<string,list<WidgetInterface>> $widgets
     */
    public function __construct(
        protected NewsService $service,
        protected Page $page,
        protected Views $views,
        protected ParamsContainer $params,
        protected array $widgets = []
    ) {
        $views->addFolder('news', __DIR__ . '/views');
    }
    public function get(Request $req): Response
    {
        /** @var Uri $turl */
        $turl = $req->getAttribute('turl');
        if ((int)$turl->getSegment(0)) {
            $news = $this->service->single((int)$this->page->language()->lang(), (int)$turl->getSegment(0));
            if (!$news) {
                throw new RuntimeException('Page not found', 404);
            }
            return new Response(
                200,
                $this->views->render(
                    'news::single',
                    [
                        'page' => $this->page,
                        'widgets' => $this->widgets,
                        'news' => $news
                    ]
                )
            );
        }
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
                'news::listing',
                [
                    'page' => $this->page,
                    'widgets' => $this->widgets,
                    'news' => $items,
                    'pagination' => $pagination,
                ]
            )
        );
    }
}

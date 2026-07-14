<?php

declare(strict_types=1);

namespace nif\modules\news;

use RuntimeException;
use vakata\http\Request;
use vakata\http\Response;
use vakata\http\Uri;
use vakata\views\Views;
use webpublic\components\Page;
use webpublic\components\Pagination;
use webpublic\components\ParamsContainer;

class NewsTemplate
{
    /**
     * @param NewsService $service
     * @param Page $page
     * @param Views $views
     * @param ParamsContainer $params
     */
    public function __construct(
        protected NewsService $service,
        protected Page $page,
        protected Views $views,
        protected ParamsContainer $params
    ) {
        $this->views->addFolder('news', __DIR__ . '/views');
    }
    public function get(Request $req): Response
    {
        /** @var Uri $turl */
        $turl = $req->getAttribute('turl');
        if ((int)$turl->getSegment(0)) {
            $news = $this->service->single(
                (int)$this->page->language()->lang(),
                (int)$turl->getSegment(0),
                $this->params->getArray('categories')
            );
            if (!$news) {
                throw new RuntimeException('Page not found', 404);
            }
            return new Response(
                200,
                $this->views->render(
                    'news::single',
                    [
                        'page' => $this->page,
                        'news' => $news
                    ]
                )
            );
        }
        $pagination = new Pagination(
            max(1, $req->getQuery('p', 1, 'int')),
            $this->params->getInt('perpage', 10) ?: 10,
            $req->getQuery(),
            $req->getUrl()->getRealPath(true)
        );
        [ 'count' => $count, 'items' => $items ] = $this->service->listing(
            (int)$this->page->language()->lang(),
            $this->params->getArray('categories'),
            $this->params->getArray('tags'),
            $pagination->getCurrentPage(),
            $pagination->getPerPage(),
            $this->params->getString('order_by', 'fordate') ?? '',
            $this->params->getInt('order_direction', 1) ?? 1
        );
        $pagination->setItemsCount($count);

        return new Response(
            200,
            $this->views->render(
                'news::listing',
                [
                    'page'       => $this->page,
                    'news'       => $items,
                    'pagination' => $pagination
                ]
            )
        );
    }
}

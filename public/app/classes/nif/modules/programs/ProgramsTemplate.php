<?php

declare(strict_types=1);

namespace nif\modules\programs;

use RuntimeException;
use vakata\http\Request;
use vakata\http\Response;
use vakata\http\Uri;
use vakata\views\Views;
use webpublic\components\Page;
use webpublic\components\Pagination;
use webpublic\components\ParamsContainer;

class ProgramsTemplate
{
    public function __construct(
        protected ProgramsService $service,
        protected Page $page,
        protected Views $views,
        protected ParamsContainer $params
    ) {
        $this->views->addFolder('programs', __DIR__ . '/views');
    }
    public function get(Request $req): Response
    {
         /** @var Uri $turl */
        $turl = $req->getAttribute('turl');
        if ((int)$turl->getSegment(0)) {
            $program = $this->service->single((int)$this->page->language()->lang(), (int)$turl->getSegment(0));
            if (!$program) {
                throw new RuntimeException('Page not found', 404);
            }
            return new Response(
                200,
                $this->views->render(
                    'programs::single',
                    [
                        'page'     => $this->page,
                        'program'  => $program,
                        'statuses' => $this->service->singleStatus()
                    ]
                )
            );
        }
        $queryData = [];
        $queryData['date_from'] = $req->getQuery('date_from', '');
        $queryData['date_to'] = $req->getQuery('date_to', '');
        $queryData['categories'] = $req->getQuery('category', []);
        $queryData['status'] =  $req->getQuery('status', []);
        $queryData['currStatuses'] = $this->service->currentFilterStatus($req->getQuery('status', []));
        $pagination = new Pagination(
            max(1, $req->getQuery('p', 1, 'int')),
            min(50, $this->params->getInt('perpage', 10) ?: 10),
            $req->getQuery(),
            $req->getUrl()->getRealPath(true)
        );
        [ 'count' => $count, 'items' => $items ] = $this->service->listing(
            (int) $this->page->language()->lang(),
            $queryData,
            $pagination->getCurrentPage(),
            $pagination->getPerPage()
        );
        $pagination->setItemsCount($count);
        return new Response(
            200,
            $this->views->render(
                'programs::listing',
                [
                    'categories'    => $this->service->getCategories($this->page->language()->lang()),
                    'formData'      => $queryData,
                    'page'          => $this->page,
                    'pagination'    => $pagination,
                    'programs'      => $items,
                    'statuses'      => $this->service->statuses(),
                    'singleStatus'  => $this->service->singleStatus()
                ]
            )
        );
    }
}

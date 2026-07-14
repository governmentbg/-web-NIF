<?php

declare(strict_types=1);

namespace nif\modules\pages;

use nif\exceptions\ValidationException;
use Throwable;
use vakata\config\Config;
use vakata\http\Request;
use vakata\http\Response;
use vakata\http\Uri;
use vakata\session\SessionInterface;
use vakata\views\Views;
use webpublic\components\Page;
use webpublic\components\ParamsContainer;
use webpublic\modules\WidgetInterface;

class ContactsTemplate
{
    /**
     * @param Page $page
     * @param ContactsService $service
     * @param Views $views
     * @param ParamsContainer $params
     * @param SessionInterface $session
     * @param Uri $url
     * @param array<string,list<WidgetInterface>> $widgets
     */
    public function __construct(
        protected Page $page,
        protected ContactsService $service,
        protected Views $views,
        protected ParamsContainer $params,
        protected SessionInterface $session,
        protected Uri $url,
        protected array $widgets = []
    ) {
        $views->addFolder('pages', __DIR__ . '/views');
        $this->session->start();
    }
    public function post(Request $req): Response
    {
        $data = [];
        try {
            $data = $req->getParsedBody() ?? [];
            $mail = $this->params->getString('receiver_email');
            $subject = $this->params->getString('receiver_subject');
            $this->service->sendMail(
                $data,
                $mail,
                $subject
            );
            $this->session->set('contacts.success', true);
            return (new Response())
                ->withHeader(
                    'Location',
                    $this->url->get(
                        $this->page->url(),
                        ['success' => true]
                    )
                );
        } catch (ValidationException $e) {
            $errors = array_filter(
                array_merge(
                    $e->getErrors(),
                    [$e->getMessage()]
                )
            );
            return (new Response())
                ->withHeader(
                    'Location',
                    $this->url->get(
                        $this->page->url(),
                        [
                            'errors' => $errors,
                            'data'   => $data
                        ]
                    )
                );
        } catch (Throwable $e) {
            return (new Response())
                ->withHeader(
                    'X-Log',
                    'Exception: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine()
                )
                ->withHeader(
                    'Location',
                    $this->url->get(
                        $this->page->url(),
                        [
                            'errors' => ['errors.common'],
                            'data'   => $data
                        ]
                    )
                );
        }
    }
    public function get(Request $req): Response
    {
        $isSuccessfull = (bool) $req->getQuery('success', null);
        if ($isSuccessfull) {
            return new Response(
                200,
                $this->views->render(
                    'pages::contacts-sent',
                    ['page' => $this->page]
                )
            );
        }
        return new Response(
            200,
            $this->views->render(
                'pages::contacts',
                [
                    'page'   => $this->page,
                    'errors' => $req->getQuery('errors', []),
                    'data'   => $req->getQuery('data', [])
                ]
            )
        );
    }
}

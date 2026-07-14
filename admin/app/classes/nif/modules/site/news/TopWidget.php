<?php

declare(strict_types=1);

namespace nif\modules\site\news;

use webadmin\components\html\Form;
use webadmin\modules\site\WidgetInterface;
use webadmin\components\html\Field;

class TopWidget implements WidgetInterface
{
    public function __construct(protected NewsService $service)
    {
    }
    public function getName(): string
    {
        return 'news_top';
    }
    public function getForm(array $data = [], array $context = []): Form
    {
        return (new Form())
            ->addField(
                new Field(
                    'text',
                    [ 'name' => 'title' ],
                    [ 'label' => 'pages.templates.news.top.title' ]
                )
            )
            ->addField(
                new Field(
                    'text',
                    [ 'name' => 'link' ],
                    [ 'label' => 'pages.templates.news.top.link' ]
                )
            )
            ->addField(
                new Field(
                    'multipleselect',
                    [ 'name' => 'categories[]' ],
                    [
                        'label' => 'pages.templates.news.top.categories',
                        'values' => $this->service->getTypes()
                    ]
                )
            )
            ->addField(
                new Field(
                    'multipleselect',
                    [ 'name' => 'tags[]' ],
                    [
                        'label' => 'pages.templates.news.top.tags',
                        'values' => $this->service->getTags()
                    ]
                )
            )
            ->setLayout([
                [ 'title', 'link' ],
                [ 'categories[]', 'tags[]' ]
            ])
            ->populate($data);
    }
}

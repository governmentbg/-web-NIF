<?php

declare(strict_types=1);

namespace nif\modules\site\news;

use webadmin\components\html\Field;
use webadmin\components\html\Form;
use vakata\intl\Intl;
use webadmin\modules\site\TemplateInterface;

class NewsTemplate implements TemplateInterface
{
    public function __construct(
        protected NewsService $service,
        protected Intl $intl
    ) {
    }
    public function getName(): string
    {
        return 'news';
    }
    public function getForm(array $data = [], array $context = []): Form
    {
        return (new Form())
            ->addField(
                new Field(
                    'number',
                    [
                        'name' => 'perpage',
                        'value' => 0
                    ],
                    [ 'label' => 'pages.templates.news.perpage' ]
                )
            )
            ->addField(
                new Field(
                    'multipleselect',
                    [ 'name' => 'categories[]' ],
                    [
                        'label' => 'pages.templates.news.categories',
                        'values' => $this->service->getTypes()
                    ]
                )
            )
            ->addField(
                new Field(
                    'multipleselect',
                    [ 'name' => 'tags[]' ],
                    [
                        'label' => 'pages.templates.news.tags',
                        'values' => $this->service->getTags()
                    ]
                )
            )
            ->addField(
                new Field(
                    'checkbox',
                    [ 'name' => 'leading' ],
                    [ 'label' => 'pages.templates.news.leading' ]
                )
            )
            ->addField(
                new Field(
                    'select',
                    [ 'name' => 'order_by' ],
                    [
                        'label' => 'pages.templates.news.order_by',
                        'values' => [
                            'visible_beg' => $this->intl->get('pages.templates.news.values.visible_beg'),
                            'fordate' => $this->intl->get('pages.templates.news.values.fordate'),
                            'title' => $this->intl->get('pages.templates.news.values.title')
                        ]
                    ]
                )
            )
            ->addField(
                new Field(
                    'select',
                    [ 'name' => 'order_direction' ],
                    [
                        'label' => 'pages.templates.news.order_direction',
                        'values' => [
                            0 => $this->intl->get('pages.templates.news.values.asc'),
                            1 => $this->intl->get('pages.templates.news.values.desc')
                        ]
                    ]
                )
            )
            ->setLayout(
                [
                    [  'perpage', 'leading' ],
                    [ 'categories[]', 'tags[]'],
                    [ 'order_by', 'order_direction' ],
                ]
            )
            ->populate($data);
    }
    public function getZones(): array
    {
        return ['main'];
    }
}

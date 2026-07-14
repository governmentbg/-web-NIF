<?php

declare(strict_types=1);

namespace nif\modules\site\documents;

use nif\modules\site\documents\DocumentsService;
use webadmin\components\html\Field;
use webadmin\components\html\Form;
use vakata\intl\Intl;
use webadmin\modules\site\TemplateInterface;

class DocumentsTemplate implements TemplateInterface
{
    public function __construct(
        protected DocumentsService $service,
        protected Intl $intl
    ) {
    }
    public function getName(): string
    {
        return 'documents';
    }
    public function getForm(array $data = [], array $context = []): Form
    {
        return (new Form())
            ->addField(
                new Field(
                    'checkbox',
                    [ 'name' => 'sidebar' ],
                    [ 'label' => 'pages.templates.files.sidebar' ]
                )
            )
            ->addField(
                new Field(
                    'text',
                    [ 'name' => 'subtitle' ],
                    [ 'label' => 'pages.templates.files.subtitle' ]
                )
            )
            ->addField(
                new Field(
                    'image',
                    [ 'name' => 'image' ],
                    [ 'label' => 'pages.templates.files.image' ]
                )
            )
            ->addField(
                new Field(
                    'number',
                    [
                        'name' => 'perpage',
                        'value' => 0
                    ],
                    [ 'label' => 'pages.templates.files.perpage' ]
                )
            )
            ->addField(
                new Field(
                    'multipleselect',
                    [ 'name' => 'categories[]' ],
                    [
                        'label' => 'pages.templates.files.categories',
                        'values' => $this->service->getCategories()
                    ]
                )
            )
            ->addField(
                new Field(
                    'select',
                    [ 'name' => 'order_by' ],
                    [
                        'label' => 'pages.templates.files.order_by',
                        'values' => [
                            'fordate' => $this->intl->get('pages.templates.files.values.fordate'),
                            'id' => $this->intl->get('pages.templates.files.values.id'),
                            'title' => $this->intl->get('pages.templates.files.values.title')
                        ]
                    ]
                )
            )
            ->addField(
                new Field(
                    'select',
                    [ 'name' => 'order_direction' ],
                    [
                        'label' => 'pages.templates.files.order_direction',
                        'values' => [
                            0 => $this->intl->get('pages.templates.files.values.asc'),
                            1 => $this->intl->get('pages.templates.files.values.desc')
                        ]
                    ]
                )
            )
            ->setLayout(
                [
                    [ 'subtitle', 'perpage' ],
                    [ 'order_by', 'order_direction', 'categories[]' ],
                    [ 'image' ]
                ]
            )
            ->populate($data);
    }
    public function getZones(): array
    {
        return [ 'main', 'sidebar' ];
    }
}

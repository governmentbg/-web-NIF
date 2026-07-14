<?php

declare(strict_types=1);

namespace nif\modules\site\documents;

use webadmin\components\html\Field;
use webadmin\components\html\Form;
use webadmin\modules\site\WidgetInterface;
use vakata\intl\Intl;

class DocumentsChosenWidget implements WidgetInterface
{
    public function __construct(
        protected DocumentsService $service,
        protected Intl $intl
    ) {
    }
    public function getName(): string
    {
        return 'documentschosen';
    }
    /**
     * @param array<string,mixed> $data
     * @param array<string,mixed> $context
     * @return Form
     */
    public function getForm(array $data = [], array $context = []): Form
    {
        return (new Form())
            ->addField(
                new Field(
                    'text',
                    [ 'name' => 'name' ],
                    [ 'label' => 'pages.widgets.documents.title']
                )
            )->addField(
                new Field(
                    'multipleselect',
                    [ 'name' => 'documents[]'],
                    [
                        'label' => 'pages.widgets.documents.documents',
                        'values' => $this->service->getDocuments()
                    ]
                )
            )
            ->addField(
                new Field(
                    'select',
                    [ 'name' => 'order_by' ],
                    [
                        'label' => 'pages.widgets.documents.order_by',
                        'values' => [
                            'document' => $this->intl->get('pages.widgets.documents.values.id'),
                            'name'     => $this->intl->get('pages.widgets.documents.values.name'),
                            'fordate'  => $this->intl->get('pages.widgets.documents.values.date')
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
            ->populate($data)
            ->setLayout(
                [
                    ['name', 'order_by', 'order_direction'],
                    ['documents[]']
                ]
            );
    }
}

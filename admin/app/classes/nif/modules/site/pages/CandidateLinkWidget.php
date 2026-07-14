<?php

declare(strict_types=1);

namespace nif\modules\site\pages;

use webadmin\modules\site\WidgetInterface;
use webadmin\components\html\Form;
use webadmin\components\html\Field;

class CandidateLinkWidget implements WidgetInterface
{
    public function getName(): string
    {
        return 'candidatelink';
    }
    public function getForm(array $data = [], array $context = []): Form
    {
        return (new Form())
            ->addField(
                new Field(
                    'text',
                    ['name' => "title"],
                    [
                        'label' => "pages.widgets.candidatelink.name"
                    ]
                )
            )
            ->addField(
                new Field(
                    'text',
                    [
                        'name'   => "url"
                    ],
                    [ 'label' => 'pages.widgets.candidatelink.url' ]
                )
            )
            ->addField(
                new Field(
                    'image',
                    ['name' => 'logo'],
                    ['label' => 'pages.widgets.candidatelink.image']
                )
            )
            ->addField(
                new Field(
                    'select',
                    ['name' => 'colour'],
                    [
                        'label'  => 'pages.widgets.candidatelink.colour',
                        'values' => [
                            'info'  => 'info',
                            'light' => 'light'
                        ]
                    ]
                )
            )
            ->setLayout([
                ['title', 'url'],
                ['colour'],
                ['logo']
            ])
            ->populate($data);
    }
}

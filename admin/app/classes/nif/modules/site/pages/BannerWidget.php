<?php

declare(strict_types=1);

namespace nif\modules\site\pages;

use webadmin\components\html\Field;
use webadmin\components\html\Form;
use webadmin\modules\site\WidgetInterface;

class BannerWidget implements WidgetInterface
{
    public function getName(): string
    {
        return 'banner';
    }
    public function getForm(array $data = [], array $context = []): Form
    {
        return (new Form())
            ->addField(
                new Field(
                    'image',
                    [ 'name' => 'image' ],
                    [ 'label' => 'pages.widgets.pages.image']
                )
            )->addField(
                new Field(
                    'url',
                    [
                        'name' => 'url',
                        'target' => '_blank'
                    ],
                    [
                        'label' => 'pages.widgets.pages.url'
                    ]
                )
            )
            ->addField(
                new Field(
                    'select',
                    [
                        'name' => 'link_target'
                    ],
                    [
                        'label' => 'pages.widgets.pages.link_target',
                        'values' => [
                            '_self' => 'self',
                            '_blank' => 'blank'
                        ]
                    ]
                )
            )
            ->setLayout(
                [
                    [ 'url', 'link_target' ],
                    [ 'image' ]
                ]
            )->populate($data);
    }
}

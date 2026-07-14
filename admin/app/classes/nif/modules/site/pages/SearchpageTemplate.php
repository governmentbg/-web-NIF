<?php

declare(strict_types=1);

namespace nif\modules\site\pages;

use webadmin\components\html\Field;
use webadmin\components\html\Form;
use webadmin\modules\site\TemplateInterface;

class SearchpageTemplate implements TemplateInterface
{
    public function getName(): string
    {
        return 'searchpage';
    }
    public function getForm(array $data = [], array $context = []): Form
    {
        return (new Form())
            ->addField(
                new Field(
                    'text',
                    [ 'name' => 'subtitle' ],
                    [ 'label' => 'pages.templates.searchpage.subtitle' ]
                )
            )
            ->addField(
                new Field(
                    'image',
                    [ 'name' => 'image' ],
                    [ 'label' => 'pages.templates.searchpage.image' ]
                )
            )
            ->addField(
                new Field(
                    'number',
                    [ 'name' => 'perpage' ],
                    [ 'label' => 'pages.templates.searchpage.perpage' ]
                )
            )
            ->setLayout(
                [
                    [ 'subtitle', 'perpage' ],
                    [ 'image' ]
                ]
            )
            ->populate($data);
    }
    public function getZones(): array
    {
        return [ 'main'];
    }
}

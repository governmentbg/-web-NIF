<?php

declare(strict_types=1);

namespace nif\modules\site\pages;

use webadmin\components\html\Field;
use webadmin\components\html\Form;
use vakata\intl\Intl;
use webadmin\modules\site\TemplateInterface;

class PageTemplate implements TemplateInterface
{
    public function __construct(
        protected Intl $intl
    ) {
    }
    public function getName(): string
    {
        return 'page';
    }
    public function getForm(array $data = [], array $context = []): Form
    {
        return (new Form())
            ->addField(
                new Field(
                    'richtext',
                    [ 'name' => 'content' ],
                    [ 'label' => $this->intl->get('pages.templates.pages.content')]
                )
            )
            ->setLayout([
                [ 'content' ]
            ])
            ->populate($data);
    }
    public function getZones(): array
    {
        return ['main', 'sidebar'];
    }
}

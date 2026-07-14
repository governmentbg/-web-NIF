<?php

declare(strict_types=1);

namespace nif\modules\site\pages;

use webadmin\components\html\Field;
use webadmin\components\html\Form;
use webadmin\modules\site\TemplateInterface;

class ContactTemplate implements TemplateInterface
{
    public function getName(): string
    {
        return 'contact';
    }
    public function getForm(array $data = [], array $context = []): Form
    {
        return (new Form())
            ->addField(
                new Field(
                    'mail',
                    [ 'name' => 'receiver_email' ],
                    [ 'label' => 'pages.templates.contact.receiver_email' ]
                )
            )
            ->addField(
                new Field(
                    'text',
                    [ 'name' => 'receiver_subject' ],
                    [ 'label' => 'pages.templates.contact.receiver_subject' ]
                )
            )
            ->setLayout(
                [
                    [ 'receiver_email', 'receiver_subject']
                ]
            )
            ->populate($data);
    }
    public function getZones(): array
    {
        return [];
    }
}

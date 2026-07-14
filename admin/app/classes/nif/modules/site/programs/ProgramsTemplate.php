<?php

declare(strict_types=1);

namespace nif\modules\site\programs;

use webadmin\modules\site\TemplateInterface;
use webadmin\components\html\Form;
use webadmin\components\html\Field;

class ProgramsTemplate implements TemplateInterface
{
    public function getName(): string
    {
        return 'programs';
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
            ->setLayout([['perpage']])
            ->populate($data);
    }
    public function getZones(): array
    {
        return ['main'];
    }
}

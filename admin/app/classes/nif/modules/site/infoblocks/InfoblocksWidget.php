<?php

declare(strict_types=1);

namespace nif\modules\site\infoblocks;

use webadmin\components\html\Field;
use webadmin\components\html\Form;
use webadmin\modules\site\WidgetInterface;

class InfoblocksWidget implements WidgetInterface
{
    public function getName(): string
    {
        return 'infoblocks';
    }
    public function getForm(array $data = [], array $context = []): Form
    {
        return (new Form())
            ->addField(
                new Field(
                    'module',
                    [ 'name' => 'infoblocks'],
                    [
                        'label'     => 'pages.widgets.infoblocks',
                        'multiple'  => true,
                        'createUrl' => false,
                        'url'       => 'infoblocks',
                        'id'        => 'infoblock'
                    ]
                )
            )
            ->populate($data);
    }
}

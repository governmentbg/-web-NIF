<?php

declare(strict_types=1);

namespace nif\modules\site\programs;

use webadmin\modules\site\WidgetInterface;
use webadmin\components\html\Form;

class ActiveProgramsWidget implements WidgetInterface
{
    public function getForm(array $data = [], array $context = []): Form
    {
        return (new Form());
    }
    public function getName(): string
    {
        return 'activeprograms';
    }
}

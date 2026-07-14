<?php

declare(strict_types=1);

namespace nif\modules\site\banners;

use webadmin\modules\site\WidgetInterface;
use webadmin\components\html\Form;

class BannersWidget implements WidgetInterface
{
    public function getForm(array $data = [], array $context = []): Form
    {
        return (new Form());
    }
    public function getName(): string
    {
        return 'banners';
    }
}

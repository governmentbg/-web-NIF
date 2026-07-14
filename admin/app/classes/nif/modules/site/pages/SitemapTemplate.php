<?php

declare(strict_types=1);

namespace nif\modules\site\pages;

use webadmin\components\html\Field;
use webadmin\components\html\Form;
use webadmin\modules\site\TemplateInterface;

class SitemapTemplate implements TemplateInterface
{
    public function getName(): string
    {
        return 'sitemap';
    }
    public function getForm(array $data = [], array $context = []): Form
    {
        return (new Form());
    }
    public function getZones(): array
    {
        return [ 'main' ];
    }
}

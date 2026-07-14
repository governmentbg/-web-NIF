<?php

declare(strict_types=1);

namespace nif\modules\site\pages;

use RuntimeException;
use nif\modules\site\pages\BannerWidget;
use vakata\di\DIContainer;
use nif\modules\site\pages\HomepageTemplate;
use webadmin\modules\site\pages\PagesModule as WebadminPagesModule;
use nif\modules\site\pages\PageTemplate;
use webadmin\modules\site\pages\RichtextWidget;
use nif\modules\site\pages\SearchpageTemplate;
use webadmin\modules\site\pages\TextWidget;
use webadmin\modules\site\TemplateInterface;
use webadmin\modules\site\WidgetInterface;

class PagesModule extends WebadminPagesModule
{
    public const string NAME = 'pages';
    public function __construct(DIContainer $container, string $slug = '')
    {
        parent::__construct($container, $slug);
    }
    public function getTemplates(): array
    {
        return [ 'homepage', 'page', 'searchpage', 'contact', 'sitemap' ];
    }
    public function getTemplate(string $name): TemplateInterface
    {
        switch ($name) {
            case 'homepage':
                return new HomepageTemplate();
            case 'page':
                return $this->container->instance(PageTemplate::class);
            case 'searchpage':
                return new SearchpageTemplate();
            case 'contact':
                return new ContactTemplate();
            case 'sitemap':
                return new SitemapTemplate();
            default:
                throw new RuntimeException();
        }
    }
    public function getWidgets(): array
    {
        return [ 'richtext', 'text', 'banner', 'candidatelink' ];
    }
    public function getWidget(string $name): WidgetInterface
    {
        switch ($name) {
            case 'richtext':
                return new RichtextWidget();
            case 'text':
                return new TextWidget();
            case 'banner':
                return new BannerWidget();
            case 'candidatelink':
                return new CandidateLinkWidget();
            default:
                throw new RuntimeException();
        }
    }
}

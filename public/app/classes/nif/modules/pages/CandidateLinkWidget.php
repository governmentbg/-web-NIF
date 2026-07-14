<?php

declare(strict_types=1);

namespace nif\modules\pages;

use vakata\views\Views;
use webpublic\components\ParamsContainer;
use webpublic\modules\WidgetInterface;
use vakata\files\FileStorageInterface;

class CandidateLinkWidget implements WidgetInterface
{
    /**
     * @param Views $views
     * @param array<string,mixed> $params
     */
    public function __construct(
        protected FileStorageInterface $fsi,
        protected Views $views,
        protected array $params = []
    ) {
        $views->addFolder('pages', __DIR__ . '/views');
    }
    public function render(): string
    {
        $params = new ParamsContainer($this->params);
        $image = null;
        if ($this->params['logo']) {
            $image = $this->fsi->get($this->params['logo']);
        }
        return $this->views->render(
            'pages::candidatelink',
            [
                'text'   => $params->getString('title'),
                'link'   => $params->getString('url'),
                'image'  => $image,
                'colour' => $params->getString('colour')
            ]
        );
    }
}

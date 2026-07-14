<?php
/**
 * @var \vakata\views\View $this
 * @var \webpublic\components\Page $page
 * @var string $content
 * @var \vakata\intl\Intl $intl
 * @var array<string,array<\webpublic\modules\WidgetInterface>> $widgets
 */
?>
<?php
$this->layout(
    'nif::html',
    [
        'title' => $page->title(),
        'meta'  => $page->getMeta(),
        'clss'  => $page->getSetting('clss')
    ]
);
?>
<?= $this->insert(
    'nif::header',
    [
        'topmenu'    => $page->menu('top_menu'),
        'headermenu' => $page->menu('main_menu'),
        'page'       => $page,
        'homepage'   => $page->site()->getHomepage($page->language()->lang())
    ]
) ?>
<main
    class="flex-grow-1"
    data-animation="fadeIn"
    data-on="load"
    data-duration="500"
    data-delay="500">
    <div class="w-100 h-100">
        <div class="page container py-4">
            <?=
            $this->insert(
                'nif::breadcrumb',
                [
                    'breadcrumb' => $page->breadcrumb(),
                    'homepage'   => $page->site()->getHomepage($page->language()->lang())
                ]
            ) ?>
            <div class="page-content py-4">
                <div class="row mb-4">
                    <div class="col-sm-12">
                        <h2 class="page-title mb-4"><?= $this->e($page->title()) ?></h2>
                    </div>
                </div>
                <div class="row gy-4">
                    <div class="col-sm-12">
                        <?= $content ?>
                    </div>

                    <div class="col-sm-12">
                        <?php foreach ($widgets['main'] ?? [] as $widget) : ?>
                            <?= $widget->render() ?>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
<?= $this->insert(
    'nif::footer',
    [
        'leftfootermenu'  => $page->menu('left_footer_menu'),
        'rightfootermenu' => $page->menu('right_footer_menu'),
        'homepage'        => $page->site()->getHomepage($page->language()->lang())
    ]
) ?>
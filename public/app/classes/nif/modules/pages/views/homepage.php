<?php
/**
 * @var \vakata\views\View $this
 * @var \webpublic\components\Page $page
 * @var string $content
 * @var string $link
 * @var \vakata\http\Uri $url
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
<main class="flex-grow-1">
    <div class="w-100 h-100">
        <section class="home bg-transparent my-md-5">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-md-8" data-animation="fadeInUp">
                        <?= $content ?>
                        <a href="<?= $this->e($url($link)) ?>" class="btn btn-outline-primary">
                            <?= $this->e($intl->get('pages.homepage.check_out_more')) ?>
                        </a>
                    </div>
                    <div class="col-md-4" data-group="cards">
                        <?php foreach ($widgets['sidebar'] ?? [] as $widget) : ?>
                            <?php if ($widget instanceof \nif\modules\pages\CandidateLinkWidget) : ?>
                                <?= $widget->render() ?>
                            <?php endif; ?>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
            <?php foreach ($widgets['sidebar'] ?? [] as $widget) : ?>
                <?php if ($widget instanceof \nif\modules\infoblocks\InfoblockWidget) : ?>
                    <?= $widget->render() ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </section>

        <?php foreach ($widgets['main'] ?? [] as $widget) : ?>
            <?= $widget->render() ?>
        <?php endforeach ?>
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
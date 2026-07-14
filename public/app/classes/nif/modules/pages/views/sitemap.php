<?php
/**
 * @var \vakata\views\View $this
 * @var \webpublic\components\Page $page
 * @var \vakata\http\Uri $url
 * @var \vakata\intl\Intl $intl
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
        <div class="page sitemap container py-4">
            <?=
            $this->insert(
                'nif::breadcrumb',
                [
                    'breadcrumb' => $page->breadcrumb(),
                    'homepage'   => $page->site()->getHomepage($page->language()->lang())
                ]
            ) ?>
            <div class="page-content py-4">
                <div class="row">
                    <div class="col-sm-12">
                        <h2 class="page-title mb-4"><?= $this->e($page->title()) ?></h2>
                    </div>
                    <div class="col-sm-12">
                        <div class="sitemap-list" aria-label="Карта на сайта">
                            <ul>
                                <?php foreach ($page->menu() as $item) : ?>
                                    <li>
                                        <a href="<?= $url($item->url()) ?>" title="<?= $item->text() ?>">
                                            <?= $this->e($item->text()) ?>
                                        </a>
                                        <?php if ($item->hasChildren()) : ?>
                                            <?php foreach ($item->children() as $child) : ?>
                                                <ul>
                                                    <li>
                                                        <a
                                                            href="<?= $this->e($url($child->url())) ?>"
                                                            title="<?= $this->e($child->text()) ?>">
                                                            <?= $this->e($child->text()) ?>
                                                        </a>
                                                    </li>
                                                </ul>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
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
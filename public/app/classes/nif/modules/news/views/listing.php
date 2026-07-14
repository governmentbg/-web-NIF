<?php
/**
 * @var \vakata\views\View $this
 * @var \webpublic\components\Page $page
 * @var \vakata\intl\Intl $intl
 * @var \vakata\http\Uri $url
 * @var callable (string, array<string,scalar>=): string $upload
 * @var \vakata\collection\Collection<int,\schema\NewsEntity> $news
 * @var \webpublic\components\Pagination $pagination
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
        <div class="news container py-4">
            <?= $this->insert(
                'nif::breadcrumb',
                [
                    'breadcrumb' => $page->breadcrumb(),
                    'homepage'   => $page->site()->getHomepage($page->language()->lang())
                ]
            ) ?>
            <div class="page-content py-4">
                <section class="news">
                    <div class="row mb-4 gy-4">
                        <?php foreach ($news as $item) : ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="card h-100">
                                    <figure class="card-img-top">
                                        <?php if ($image = $item->file()) : ?>
                                            <img
                                            src="<?= $this->e($url($upload($image->id(), ['w' => 500]))) ?>"   
                                            class="img-fluid"
                                            alt="<?= $this->e($item->title()) ?>">
                                        <?php endif; ?>
                                    </figure>
                                    <div class="card-body p-4">
                                        <p class="text-secondary mb-2">
                                            <?= $this->e(
                                                date(
                                                    'd.m.Y',
                                                    $item->getDate()
                                                )
                                            ) ?>
                                        </p>
                                        <a href="<?= $this->e($url($page->url() . '/' . $item->getUrl())) ?>"
                                            class="card-text stretched-link text-decoration-none fs-5">
                                            <?= $this->e($item->title()) ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            </div>
            <?= $this->insert('nif::pagination', ['pagination' => $pagination]) ?>
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
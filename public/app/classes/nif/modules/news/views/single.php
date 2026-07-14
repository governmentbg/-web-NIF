<?php
/**
 * @var \vakata\views\View $this
 * @var \webpublic\components\Page $page
 * @var \vakata\intl\Intl $intl
 * @var \vakata\http\Uri $url
 * @var callable (string, array<string,scalar>=): string $upload
 * @var \schema\NewsEntity $news
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
        <div class="page news container py-4">
            <?= $this->insert(
                'nif::breadcrumb',
                [
                    'breadcrumb'      => $page->breadcrumb(),
                    'singlePageTitle' => $news->title(),
                    'homepage'        => $page->site()->getHomepage($page->language()->lang())
                ]
            ) ?>
            <div class="pt-4">
                <div class="card bg-light mb-4">
                    <div class="row">
                        <div class="col-md-6 col-lg-4 d-flex order-2 order-md-1">
                            <div class="card-body p-4 justify-content-center d-flex flex-column">
                                <h2 class="card-title">
                                    <?= $this->e($news->title()) ?>
                                </h2>
                                <p class="text-secondary mb-2">
                                    <?= $this->e(
                                        date(
                                            'd.m.Y',
                                            $news->getDate()
                                        )
                                    ) ?>
                                </p>
                            </div>
                        </div>
                        <?php if ($image = $news->file()) : ?>
                            <div class="col-md-6 col-lg-8 order-1 order-md-2">
                                <figure class="m-0">
                                    <img src="<?= $this->e($url($upload($image->id()))) ?>" class="img-fluid">
                                </figure>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row">
                    <?php if ($news->getPrev() || $news->getNext()) : ?>
                        <div class="col-lg-4 d-flex flex-column mt-md-4 order-2 order-lg-1">
                            <div class="more-news position-sticky top-0 d-none d-md-block">
                                <?php if ($news->getPrev()) : ?>
                                    <a 
                                        href="<?= $this->e($url(
                                            $page->url() . '/' . $news->getPrev()->getUrl()
                                        )) ?>"
                                        class="d-flex justify-content-between 
                                        align-items-center text-decoration-none fw-bold text-secondary">
                                        <span class="fs-5"><?= $this->e($intl->get('news.single.previous')) ?></span>
                                        <i class="fa fa-chevron-left"></i>
                                    </a>
                                    <p class="py-2">
                                        <?= $this->e($news->getPrev()->title()) ?>
                                        <br>
                                        <span class="text-secondary">
                                            <?= $this->e(
                                                date(
                                                    'd.m.Y',
                                                    $news->getPrev()->getDate()
                                                )
                                            ) ?>
                                        </span>
                                    </p>
                                <?php endif; ?>
                                <?php if ($news->getNext()) : ?>
                                    <a
                                        href="<?= $this->e($url(
                                            $page->url() . '/' . $news->getNext()->getUrl()
                                        )) ?>"
                                        class="d-flex justify-content-between
                                        text-decoration-none fw-bold text-secondary">
                                        <span class="fs-5"><?= $this->e($intl->get('news.single.next')) ?></span>
                                        <i class="fa fa-chevron-right"></i></a>
                                    <p class="py-2">
                                        <?= $this->e($news->getNext()->title()) ?>
                                        <br>
                                        <span class="text-secondary">
                                            <?= $this->e(
                                                date(
                                                    'd.m.Y',
                                                    $news->getNext()->getDate()
                                                )
                                            ) ?>
                                        </span>
                                    </p>
                                <?php endif; ?>
                            </div>
                            <a
                                href="<?= $this->e($url($page->url())) ?>"
                                class="btn btn-outline-primary btn-lg d-block d-md-none">
                                    <?= $this->e($page->title()) ?>
                                </a>
                        </div>
                    <?php endif; ?>
                    <div class="col-lg-8 page-content mt-4 order-1 order-lg-2">
                        <p class="fw-bold">
                            <?= $this->e($news->getDescription()) ?>
                        </p>
                        <?= $news->content ?>
                        <?php if ($news->images()->count() > 0) : ?>
                            <div class="news-slider mt-5">
                                <?= $this->insert("nif::slider", ['images' => $news->images()]) ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($news->files()->count() > 0) : ?>
                            <div class="download-files list-group list-group-flush">
                                <?php foreach ($news->files() as $item) : ?>
                                    <?php if ($file = $item->getFile()) : ?>
                                        <a href="<?= $this->e($url($upload($file->id()))) ?>"
                                            class="list-group-item list-group-item-action d-flex flex-row">
                                            <div class="d-flex align-items-center p-4">
                                                <i class="fas fa-cloud-arrow-down fa-xl"></i>
                                            </div>
                                            <div class="d-flex w-100 flex-column">
                                                <span class="pb-2"><?= $this->e($file->name()) ?></span>
                                                <span class="text-secondary">
                                                    <?= $this->e($file->ext()) ?>,
                                                    <?= round($file->size() / 1024, 2) . 'KB' ?>,
                                                    <?= $this->e($intl->get('documents.documents.published') .
                                                        ' ' .
                                                    date('d.m.Y', $file->uploaded())) ?>
                                                </span>
                                            </div>
                                        </a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
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
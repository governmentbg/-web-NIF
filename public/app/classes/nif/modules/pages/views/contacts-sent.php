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
        <div class="page container py-4">
            <?= $this->insert(
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
                    <div class="col-md-4">
                        <?php /*<div class="card">
                            <div class="card-body bg-info p-4">
                                <h5><?= $this->e($intl->get('contacts.to')) ?></h5>
                                 /*<p><?= $this->e($intl->get('contacts.for.programs')) ?><br>
                                    +359 2 940 11 01
                                    <br><br>
                                    <?= $this->e($intl->get('contacts.for.projects.reports')) ?><br>
                                    +359 2 940 11 02
                                    <br><br>
                                    <?= $this->e($intl->get('contacts.for.finance.contracts')) ?><br>
                                    +359 2 940 11 03
                                </p>
                            </div>
                        </div> */?>
                        <div class="card mt-4">
                            <div class="card-body bg-info p-4">
                                <h5><?= $this->e($intl->get('site.address')) ?></h5>
                                <p>
                                    <?= $this->e($intl->get('contacts.address.city')) ?> <br>
                                    <?= $this->e($intl->get('contacts.address.address')) ?> <br>
                                    <?= $this->e($intl->get('contacts.address.name')) ?>
                                </p>
                            </div>
                        </div>
                        <div class="card mt-4">
                            <div class="card-body bg-info p-4">
                                <h5><?= $this->e($intl->get('contacts.email')) ?></h5>
                                <p><i class="fas fa-arrow-up-right-from-square me-2"></i>info@nif.government.bg</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h5 class="mb-4"><?= $this->e($intl->get('contacts.us')) ?></h5>

                        <div class="alert alert-success mt-4" role="alert">
                            <?= $this->e($intl->get('contacts.success')) ?>
                        </div>
                        <?php if ($homepage = $page->site()->getHomepage($page->language()->lang())) : ?>
                            <a
                            href="<?= $this->e($url($homepage->url())) ?>"
                            class="btn btn-secondary text-white">
                                <i class="fas fa-arrow-left me-2"></i>
                                <?= $this->e($homepage->title()) ?>
                            </a>
                        <?php endif; ?>
                        <a href="<?= $this->e($url($page->url())) ?>" class="btn btn-outline-secondary">
                            <?= $this->e($page->title()) ?>
                        </a>
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
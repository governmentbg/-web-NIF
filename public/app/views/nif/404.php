<?php
/**
 * @var \vakata\views\View $this
 * @var callable (string, array<string,string>=, bool=): string $asset
 * @var ?\webpublic\components\Page $page
 * @var \vakata\intl\Intl $intl
 */
?>
<?php
$this->layout(
    'nif::html',
    [
        'lang'  => isset($page) ? $page->language()->code() : 'bg',
        'title' => $this->e($intl->get('error.404.page'))
    ]
);
?>
<?php if (isset($page)) : ?>
    <?= $this->insert(
        'nif::header',
        [
            'topmenu'    => $page->menu('top_menu'),
            'headermenu' => $page->menu('main_menu'),
            'page'       => $page,
            'homepage'   => $page->site()->getHomepage($page->language()->lang())
        ]
    ) ?>
<?php endif; ?>
<main
    class="flex-grow-1"
    data-animation="fadeIn"
    data-on="load"
    data-duration="500"
    data-delay="500">
    <div class="w-100 h-100">
        <div class="page 404 py-5 flex-grow-1">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-sm-12 col-md-6 p-4">
                        <img
                            src="<?= $this->e($asset('assets/img/404.png')) ?>"
                            class="img-fluid"
                            alt="404"
                            title="404">
                    </div>
                    <div class="col-sm-12 col-md-6 p-4">
                        <h1 class="mb-3 fw-bold">404</h1>
                        <h1 class="mb-3"><?= $this->e($intl->get('error.not.found')) ?></h1>
                        <p><?= $this->e($intl->get('error.reasons')) ?></p>
                        <ul>
                            <li><?= $this->e($intl->get('error.reasons.address')) ?></li>
                            <li><?= $this->e($intl->get('error.reasons.copy')) ?></li>
                            <li><?= $this->e($intl->get('error.reasons.not.full')) ?></li>
                            <li><?= $this->e($intl->get('error.reasons.moved')) ?></li>
                            <li><?= $this->e($intl->get('error.reasons.deleted')) ?></li>
                        </ul>
                        <p class="m-0"><?= $this->e($intl->get('error.reasons.try.again')) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php if (isset($page)) : ?>
    <?= $this->insert(
        'nif::footer',
        [
            'leftfootermenu'  => $page->menu('left_footer_menu'),
            'rightfootermenu' => $page->menu('right_footer_menu'),
            'homepage'        => $page->site()->getHomepage($page->language()->lang())
        ]
    ) ?>
<?php endif; ?>
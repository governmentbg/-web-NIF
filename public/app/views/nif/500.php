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
<main
    class="flex-grow-1"
    data-animation="fadeIn"
    data-on="load"
    data-duration="500"
    data-delay="500">
    <div class="w-100 h-100">
        <div class="page 500 d-flex flex-grow-1">
            <div class="container m-auto">
                <div class="row align-items-center">
                    <div class="col-sm-12 col-md-6 p-4">
                        <img
                            src="<?= $this->e($asset('assets/img/500.png')) ?>"
                            class="img-fluid"
                            alt="500"
                            title="500">
                    </div>
                    <div class="col-sm-12 col-md-6 p-4 text-center text-md-start">
                        <h1 class="mb-3 fw-bold"><?= $this->e($intl->get('500.server.error')) ?></h1>
                        <p><?= $this->e($intl->get('500.server.error.description')) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
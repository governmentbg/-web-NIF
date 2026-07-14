<?php
/**
 * @var \vakata\views\View $this
 * @var \webpublic\components\Page $page
 * @var \vakata\intl\Intl $intl
 * @var \vakata\http\Uri $url
 * @var callable (string, array<string,scalar>=): string $upload
 * @var \schema\ProgramsEntity $program
 * @var \vakata\collection\Collection<int,\schema\ProgramsEntity> $others
 * @var array $statuses
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
        <div class="page programs container py-4">
            <?= $this->insert(
                'nif::breadcrumb',
                [
                    'breadcrumb'      => $page->breadcrumb(),
                    'singlePageTitle' => $program->getTitle(),
                    'homepage'        => $page->site()->getHomepage()
                ]
            ) ?>
            <div class="py-4">
                <div class="card bg-light mb-4">
                    <div class="row">
                        <div class="col-lg-4 d-flex order-2 order-lg-1">
                            <div class="card-body p-4 justify-content-center d-flex flex-column">
                                <h2 class="card-title">
                                    <?= $this->e($program->getTitle()) ?>
                                </h2>
                                <p class="text-secondary mb-2">
                                    <?= $this->e(
                                        date(
                                            'd.m.Y',
                                            $program->getBegDate()
                                        ) .
                                        ' - ' .
                                        date(
                                            'd.m.Y',
                                            $program->getEndDate()
                                        )
                                    ) ?>
                                </p>
                            </div>
                        </div>
                        <?php if ($image = $program->getImage()) : ?>
                            <div class="col-lg-8 order-1 order-lg-2">
                                <figure class="m-0">
                                    <img src="<?= $this->e($url($upload($image->id()))) ?>" class="img-fluid">
                                </figure>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row">
                    <?php if ($program->getPrev() || $program->getNext()) : ?>
                        <div class="col-lg-4 d-flex flex-column mt-md-4 order-2 order-lg-1">
                            <div class="my-md-5"></div>
                            <div class="more-news position-sticky top-0  mt-md-4 pt-2">
                                <?php if ($program->getPrev()) : ?>
                                    <a href="<?=
                                        $this->e($url($page->url() . '/' . $program->getPrev()->getUrl()));
                                    ?>"
                                        class="d-flex justify-content-between
                                    align-items-center text-decoration-none fw-bold text-secondary">
                                        <span class="fs-5"><?= $this->e($intl->get('program.single.previous')) ?></span>
                                        <i class="fa fa-chevron-left"></i>
                                    </a>
                                    <p class="py-2">
                                        <?= $this->e($program->getPrev()->getTitle()) ?>
                                    </p>
                                <?php endif; ?>
                                <?php if ($program->getNext()) : ?>
                                    <a
                                        href="<?=
                                            $this->e($url($page->url() . '/' . $program->getNext()->getUrl()));
                                        ?>"
                                        class="d-flex justify-content-between
                                        text-decoration-none fw-bold text-secondary">
                                        <span class="fs-5"><?= $this->e($intl->get('program.single.next')) ?></span>
                                        <i class="fa fa-chevron-right"></i>
                                    </a>
                                    <p class="py-2">
                                        <?= $this->e($program->getNext()->getTitle()) ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="col-lg-8 page-content mt-4 order-1 order-lg-2">
                        <div class="row mb-4 gy-4">
                            <div class="col-sm-4">
                                <div class="card h-100">
                                    <div class="card-body bg-info p-4">
                                        <h5><?= $this->e($intl->get('programs.status')) ?></h5>
                                        <?= $this->e($intl->get($statuses[$program->getStatus()])) ?>
                                    </div>
                                </div>
                            </div>
                            <?php if (strlen(trim($program->getBudget()))) : ?>
                                <div class="col-sm-4">
                                    <div class="card h-100">
                                        <div class="card-body bg-info p-4">
                                            <h5><?= $this->e($intl->get('programs.budget')) ?></h5>
                                            <?= $this->e($program->getBudget()) . " €" ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="col-sm-4">
                                <div class="card h-100">
                                    <div class="card-body bg-info p-4">
                                        <h5><?= $this->e($intl->get('programs.period')) ?></h5>
                                        <?= $this->e(($program->monthsDuration() ?
                                            $program->monthsDuration() .
                                            " " .
                                            $intl->get('programs.period.months') : '') .
                                            " (" .
                                                date(
                                                    'd.m.Y',
                                                    $program->getBegDate()
                                                ) .
                                                    ' - ' .
                                                    date(
                                                        'd.m.Y',
                                                        $program->getEndDate()
                                                    )
                                            . ") ") ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="fw-bold">
                            <?= $this->e($program->getDescription()) ?>
                        </p>
                        <?= $program->content ?>
                        <?php if ($program->images()->count() > 0) : ?>
                            <div class="news-slider mt-5">
                                <?= $this->insert("nif::slider", ['images' => $program->images()]) ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($program->files()->count() > 0) : ?>
                            <div class="download-files list-group list-group-flush">
                                <?php foreach ($program->files() as $item) : ?>
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
                                                    <?=
                                                    $this->e($intl->get('documents.single.valid') .
                                                        ' ' .
                                                        date('d.m.Y', $doc->getDate()))
                                                    ?>
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
<?php
/**
 * @var \vakata\views\View $this
 * @var \vakata\collection\Collection<int,\schema\ProgramsEntity> $programs
 * @var \vakata\intl\Intl $intl
 * @var \webpublic\components\Page $page
 * @var \vakata\http\Uri $url
 */
?>
<section class="programs bg-gradient-blue">
    <div class="container">
        <div class="row mb-5">
            <div class="col-sm-8 col-md-9">
                <h1 class="title"><?= $this->e($intl->get('programs.curr.status.active')) ?></h1>
            </div>
            <div class="col-sm-4 col-md-3 text-md-end text-sm-left">
                <a
                    href="<?= $this->e($url($page->language()->code() . '/programs')) ?>"
                    class="btn btn-outline-light">
                    <?= $this->e($intl->get('programs.link.all')) ?>
                </a>
            </div>
        </div>
        <div class="row gy-4" data-group="programs">
            <?php foreach ($programs as $program) : ?>
                <div class="col-12">
                    <div class="card bordered active" data-animation="fadeIn" data-duration="500">
                        <div class="card-body p-0 mb-2">
                            <div class="row m-0">
                                <div class="col-md-4 bg">
                                    <h4 class="card-title p-4 m-0">
                                        <a
                                        href="<?= $this->e($url(
                                            $page->language()->code() . '/programs/' . $program->getUrl()
                                        )) ?>"
                                            class="stretched-link"
                                            title="<?= $this->e($program->getTitle()) ?>">
                                            <?= $this->e($program->getTitle()) ?>
                                        </a>
                                    </h4>
                                </div>
                                <div class="col-md-5">
                                    <?php if ($program->getDescription()) : ?>
                                        <div class="d-flex justify-content-end">
                                            <span class="badge badge-top mb-4 mt-n3">
                                                <?= $this->e($intl->get('programs.status.active')) ?>
                                            </span>
                                        </div>
                                        <div class="p-4">
                                            <?= $this->e($program->getDescription()) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-3">
                                    <div class="p-4">
                                        <div class="d-flex justify-content-end">
                                            <span class="badge badge-bottom mb-4">
                                                <?= $this->e($intl->get('programs.status.active')) ?>
                                            </span>
                                        </div>
                                        <p>
                                            <span class="fw-bold">
                                                <?= $this->e($intl->get('programs.period')) ?>
                                            </span><br>
                                            <?= $this->e(($program->monthsDuration() ?
                                                $program->monthsDuration() .
                                                " " .
                                                $intl->get('programs.period.months') : '') .
                                                " (" .
                                                date('d.m.Y', $program->getBegDate()) .
                                                ' - ' .
                                                date('d.m.Y', $program->getEndDate()) .
                                            ") ") ?>
                                        </p>
                                        <hr>
                                        <?php if ($program->getBudget()) : ?>
                                            <p>
                                                <span class="fw-bold">
                                                    <?= $this->e($intl->get('programs.budget')) ?>
                                                </span><br>
                                                <?=
                                                $this->e($program->getBudget() .
                                                    " " .
                                                    $intl->get('euro.currency'))
                                                ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
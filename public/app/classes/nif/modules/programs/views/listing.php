<?php
/**
 * @var array $formData
 * @var array $statuses
 * @var array $singleStatus
 * @var \vakata\collection\Collection<int,\schema\ProgramCategoriesEntity> $categories
 * @var \vakata\collection\Collection<int,\schema\ProgramsEntity> $programs
 * @var \vakata\http\Uri $url
 * @var \vakata\intl\Intl $intl
 * @var \vakata\views\View $this
 * @var \webpublic\components\Page $page
 * @var \webpublic\components\Pagination $pagination
 * @var callable (string, array<string,string>=, bool=): string $asset
 * @var string $cspNonce
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
<?=
$this->insert(
    'nif::header',
    [
        'topmenu'    => $page->menu('top_menu'),
        'headermenu' => $page->menu('main_menu'),
        'page'       => $page,
        'homepage'   => $page->site()->getHomepage($page->language()->lang())
    ]
)
?>
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
                <section class="programs">
                    <div class="row mb-4 gy-4">
                        <div class="col-sm-12">
                            <h1 class="page-title mb-4">
                                <?= $this->e($formData['currStatuses']) ?>
                            </h1>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-12">
                            <form
                                method="GET"
                                action=<?= $this->e($url($page->url())) ?>
                                class="mb-5 mb-md-0" id="programs-filter">
                                <div class="row gy-3">
                                    <div class="col-sm-6 col-md-3">
                                        <label>
                                            <?= $this->e($intl->get("programs.categories")) ?>
                                        </label>
                                        <div class="dropdown dropdown-multiselect w-100">
                                            <button
                                                class="form-select w-100 text-start text-secondary"
                                                type="button"
                                                data-bs-toggle="dropdown"
                                                data-bs-auto-close="outside"
                                                data-selected-text="<?=
                                                    $this->e($intl->get("programs.selected.categories"))
                                                ?> 
                                                {count}"
                                                id="categoriesDropdown">
                                                <?= $this->e($intl->get("programs.select.categories")) ?>
                                            </button>
                                            <ul class="dropdown-menu p-2" aria-labelledby="categoriesDropdown">
                                                <?php foreach ($categories as $categ) : ?>
                                                    <li>
                                                        <label class="dropdown-item d-flex align-items-center gap-2">
                                                            <input
                                                            class="form-check-input m-0"
                                                            type="checkbox"
                                                            name="category[]"
                                                            value=<?= $categ->getId() ?>
                                                            <?= $this->e(isset($formData['categories']) ?
                                                            (
                                                                in_array($categ->getId(), $formData['categories']) ?
                                                                'checked' : ''
                                                            ) : '') ?>>
                                                            <?= $this->e($categ->getTitle()) ?>
                                                        </label>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <label>
                                            <?= $this->e($intl->get("programs.statuses")) ?>
                                        </label>
                                        <div class="dropdown dropdown-multiselect w-100">
                                            <button
                                                class="form-select w-100 text-start text-secondary"
                                                type="button"
                                                data-bs-toggle="dropdown"
                                                data-bs-auto-close="outside"
                                                data-selected-text="<?=
                                                    $this->e($intl->get("programs.selected.statuses"))
                                                ?>
                                                {count}"
                                                id="programsDropdown">
                                                <?= $this->e($intl->get("programs.select.statuses")) ?>
                                            </button>
                                            <ul class="dropdown-menu p-2" aria-labelledby="programsDropdown">
                                                <?php foreach ($statuses as $k => $stat) : ?>
                                                    <li>
                                                        <label class="dropdown-item d-flex align-items-center gap-2">
                                                            <input
                                                                class="form-check-input m-0"
                                                                type="checkbox"
                                                                name="status[]"
                                                                value=<?= $k ?>
                                                                <?= isset($formData['status']) ?
                                                                (in_array($k, $formData['status']) ?
                                                                'checked' : '') : '' ?>>
                                                            <?= $this->e($stat) ?>
                                                        </label>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <label for="date-from">
                                            <?= $this->e($intl->get('programs.date.from')) ?>
                                        </label>
                                        <input
                                            type="text"
                                            name="date_from"
                                            class="form-control data-format-input"
                                            placeholder="<?=
                                                $page->language()->lang() === 1 ?
                                                'дд.мм.гггг' :
                                                'mm / dd / yyyy'
                                            ?>"
                                            data-max-date="today"
                                            value="<?= $this->e(
                                                isset($formData['date_from']) ? $formData['date_from'] : ''
                                            ) ?>"
                                            aria-label="<?= $this->e($intl->get('programs.period.from')) ?>"
                                            id="date-from">
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <label for="date-to">
                                            <?= $this->e($intl->get('programs.date.to')) ?>
                                        </label>
                                        <input
                                            type="text"
                                            name="date_to"
                                            class="form-control data-format-input"
                                            placeholder="<?=
                                                $page->language()->lang() === 1 ?
                                                'дд.мм.гггг' :
                                                'mm / dd / yyyy'
                                            ?>"
                                            value="<?=
                                                $this->e(isset($formData['date_to']) ? $formData['date_to'] : '')
                                            ?>"
                                            aria-label="<?= $this->e($intl->get('programs.period.to')) ?>"
                                            id="date-to">
                                    </div>
                                </div>
                                <div class="row position-absolute">
                                    <div class="col-sm-12 mt-3">
                                        <button type="submit" class="btn btn-light btn-sm">
                                            <?= $this->e($intl->get('programs.button.filter')) ?>
                                        </button>
                                        <a
                                            href="<?= $this->e($url($page->url())) ?>"
                                            class="btn btn-light btn-sm"
                                            title="<?= $this->e($intl->get('programs.button.clear')) ?>">
                                            <?= $this->e($intl->get('programs.button.clear')) ?>
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-12 text-end py-2 d-none d-md-block">
                            <?= $this->e($intl->get('programs.choose.view')) ?>
                            <div class="btn-group" role="group">
                                <a href="#" class="btn btn-link pe-1" id="grid-view-btn">
                                    <i class="fa-solid fa-grip fa-2x"></i>
                                </a>
                                <a href="#" class="btn btn-link ps-1 pe-0 active" id="list-view-btn">
                                    <i class="fa-regular fa-rectangle-list fa-2x"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row gy-4">
                        <?php foreach ($programs as $k => $program) : ?>
                            <div class="col-12">
                                <div class="card bordered <?= $this->e($program->statusColor()) ?>">
                                    <div class="card-body p-0 mb-2">
                                        <div class="row w-100 m-0">
                                            <div class="col-md-4 bg">
                                                <h4 class="card-title p-4 m-0">
                                                    <a
                                                        href="<?= $this->e($url(
                                                            $page->url() . '/' . $program->getUrl()
                                                        )) ?>"
                                                        class="stretched-link"
                                                        title="<?= $this->e($program->getTitle()) ?>">
                                                        <?= $this->e($program->getTitle()) ?>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="d-flex justify-content-end">
                                                    <span class="badge badge-top mb-4 mt-n3">
                                                        <?= $this->e($singleStatus[$program->getStatus()]) ?>
                                                    </span>
                                                </div>
                                                <div class="p-4">
                                                    <?php if (strlen($program->getDescription())) : ?>
                                                        <?= $this->e($program->getDescription()) ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="p-4">
                                                    <div class="d-flex justify-content-end">
                                                        <span class="badge badge-bottom mb-4">
                                                            <?= $this->e($singleStatus[$program->getStatus()]) ?>
                                                        </span>
                                                    </div>
                                                        <p>
                                                            <span class="fw-bold">
                                                                <?= $intl->get('programs.period') ?>
                                                            </span><br>
                                                            <?= $this->e(($program->monthsDuration() ?
                                                                $program->monthsDuration() .
                                                                " " .
                                                                $intl->get('programs.period.months') : '') .
                                                                " (" .
                                                                    date('d.m.Y', $program->getBegDate()) .
                                                                    ' - ' .
                                                                    date('d.m.Y', $program->getEndDate())
                                                                 .
                                                            ") ") ?>
                                                        </p>
                                                    <hr>
                                                    <?php if ($program->getBudget()) : ?>
                                                        <p>
                                                            <span class="fw-bold">
                                                                <?= $this->e($intl->get('programs.budget')) ?>
                                                            </span><br>
                                                            <?= $this->e($program->getBudget()) . " €" ?>
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
                    <?= $this->insert('nif::pagination', ['pagination' => $pagination]) ?>
                </section>
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
<script src="<?= $this->e($asset('assets/scripts/flatpickr.js')) ?>"></script>
<script src="<?= $this->e($asset('assets/scripts/flatpickr-bg.js')) ?>"></script>   
<script nonce="<?= $cspNonce ?>">
//datapicker
const dataFormatInput = document.querySelectorAll('.data-format-input');
dataFormatInput.forEach(input => {
    const fp = flatpickr(input, {
        locale: '<?= $page->language()->lang() === 1 ? 'bg' : 'en' ?>',
        dateFormat: '<?= $page->language()->lang() === 1 ? 'd.m.Y' : 'm/d/Y' ?>',
        // defaultDate: moment().format('DD.MM.YYYY')
        allowInput: true,
        maxDate: input.getAttribute('data-max-date')
    });
});
</script>
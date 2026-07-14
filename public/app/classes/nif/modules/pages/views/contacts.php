<?php
/**
 * @var \vakata\views\View $this
 * @var \webpublic\components\Page $page
 * @var \vakata\http\Uri $url
 * @var \vakata\intl\Intl $intl
 * @var array $errors
 * @var array $data
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
                        <?php /*
                        <div class="card">
                            <div class="card-body bg-info p-4">
                                <h5><?= $this->e($intl->get('contacts.to')) ?></h5>
                                <p><?= $this->e($intl->get('contacts.for.programs')) ?><br>
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
                        <form
                            class="row needs-validation"
                            method="POST"
                            action="<?= $this->e($url($page->url())) ?>"
                            novalidate>
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <label for="name" class="form-label">
                                        <?= $this->e($intl->get('contacts.label.name')) ?> *
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control
                                        <?= $this->e(isset($errors['contacts.name.required']) ?
                                        'is-invalid'  : (isset($data['name']) ? 'is-valid' : '')) ?>"
                                        id="name"
                                        placeholder="<?= $this->e($intl->get('contacts.placeholder.name')) ?>"
                                        aria-describedby="nameHelpBlock"
                                        name="name"
                                        required
                                        value=<?= $this->e(
                                            !isset($errors['contacts.name.required']) &&
                                            isset($data['name']) ?
                                            $data['name'] : ''
                                        ) ?>>
                                    <div id="nameHelpBlock" class="form-text">
                                        <i class="far fa-circle-check me-2"></i>
                                        <?= $this->e($intl->get('contacts.block.names')) ?>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="subject" class="form-label">
                                        <?= $this->e($intl->get('contacts.label.reason')) ?>
                                    </label>
                                    <input
                                        type="text"
                                        name="reason"
                                        class="form-control
                                        <?= $this->e(isset($errors['contacts.reason.required']) ?
                                        'is-invalid' : (isset($data['reason']) ? 'is-valid' : '')) ?>"
                                        id="subject"
                                        placeholder="<?= $this->e($intl->get('contacts.placeholder.reason')) ?>"
                                        aria-describedby="subjectHelpBlock"
                                        value=<?= $this->e(!isset($errors['contacts.reason.required']) &&
                                        isset($data['reason']) ? $data['reason'] : '') ?>>
                                    <div id="subjectHelpBlock" class="form-text">
                                        <i class="far fa-circle-check me-2"></i>
                                        <?= $this->e($intl->get('contacts.block.reason')) ?>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="email" class="form-label">
                                        <?= $this->e($intl->get('contacts.label.email')) ?> *
                                    </label>
                                    <!-- use is-invalid for invalid form data -->
                                    <input
                                        type="text"
                                        class="form-control
                                        <?= $this->e(isset($errors['contacts.mail.required']) ||
                                        isset($errors['contacts.email.mail']) ?
                                        'is-invalid'  : (isset($data['email']) ? 'is-valid' : '')) ?>"
                                        id="email"
                                        placeholder="<?= $this->e($intl->get('contacts.placeholder.email')) ?>"
                                        name="email"
                                        aria-describedby="emailHelpBlock"
                                        required
                                        value=<?= $this->e(!isset($errors['contacts.mail.required']) &&
                                        !isset($errors['contacts.email.mail']) &&
                                        isset($data['email']) ?
                                        $data['email'] : '') ?>>
                                    <div id="emailHelpBlock" class="form-text">
                                        <i class="far fa-circle-check me-2"></i>
                                        <?= $this->e($intl->get('contacts.block.email')) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 text-end">
                                <div class="mb-4 text-start">
                                    <label for="message" class="form-label">
                                        <?= $this->e($intl->get('contacts.label.message')) ?>
                                    </label>
                                    <textarea id="message" name="message" class="form-control" rows="8"></textarea>
                                </div>
                                <div class="d-grid d-md-block">
                                    <button class="btn btn-secondary text-white" type="submit">
                                        <?= $this->e($intl->get('contacts.button.send')) ?>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?=
$this->insert(
    'nif::footer',
    [
        'leftfootermenu'  => $page->menu('left_footer_menu'),
        'rightfootermenu' => $page->menu('right_footer_menu'),
        'homepage'        => $page->site()->getHomepage($page->language()->lang())
    ]
)
?>
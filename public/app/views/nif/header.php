<?php

/**
 * @var \vakata\views\View $this
 * @var \vakata\intl\Intl $intl
 * @var \vakata\http\Uri $url
 * @var \webpublic\components\Menu $topmenu
 * @var \webpublic\components\Menu $headermenu
 * @var \webpublic\components\Page $homepage
 * @var \webpublic\components\Page $page
 * @var callable (string, array<string,string>=, bool=): string $asset
 */
?>
<nav class="bg-white shadow-sm" data-animation="fadeIn" data-duration="300">
    <div class="container">
        <ul class="nav justify-content-end">
            <?php foreach ($topmenu as $item) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $this->e($url($item->url())) ?>">
                        <?= $this->e($item->text()) ?>
                    </a>
                </li>
            <?php endforeach; ?>
            <li class="nav-item">
                <?php
                /**
                 * @var ?\webpublic\components\MenuItem $translation
                 * @phpstan-ignore-next-line
                 */
                $translation = $page->translations()
                    ->getIterator()[$page->language()->lang() === 1 ? 1 : 0] ?? null;
                ?>
                <?php if ($translation) : ?>
                    <a href="<?= $this->e($url($translation->url())); ?>" class="nav-link">
                        <?= $this->e($page->language()->lang() === 1 ? 'EN' : 'БГ') ?>
                    </a>
                <?php endif; ?>
            </li>
        </ul>
    </div>
</nav>

<header>
    <div class="container">
        <div class="py-5 d-flex align-items-center">
            <a href="<?= $this->e($url($homepage->url())) ?>" class="brand">
                <img
                    src="<?= $this->e($asset(
                        'assets/img/' .
                        ($homepage->language()->lang() === 1 ? 'state-brand-bg.svg' : 'state-brand-en.svg')
                    )) ?>"
                    alt="Logo"
                    class="logo"
                    data-animation="zoomIn" data-duration="300">
            </a>
            <div class="ms-2">
                <img src="<?= $this->e($asset('assets/img/logo-nif.svg')) ?>" alt="Logo" class="logo"
                    data-animation="zoomIn" data-duration="500">
            </div>
        </div>
        <nav
        class="navbar navbar-expand-md navbar-dark bg-primary py-0 px-3"
        data-animation="fadeInUp"
        data-duration="500"
        data-delay="150">
            <button class="navbar-toggler my-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav mx-auto">
                    <?php foreach ($headermenu as $item) : ?>
                        <li class="nav-item <?= $item->hasChildren() ? 'dropdown' : '' ?>">
                            <?php if ($item->hasChildren()) : ?>
                                <a
                                class="nav-link dropdown-toggle <?= $item->url() === $page->url() ? 'active' : '' ?>"
                                data-bs-toggle="dropdown"
                                href="#"
                                role="button"
                                aria-expanded="false">
                                    <span><?= $this->e($item->text()) ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php foreach ($item->children() as $child) : ?>
                                        <li>
                                            <a
                                            class="dropdown-item <?= $child->url() === $page->url() ? 'active' : '' ?>"
                                            href="<?= $this->e($url($child->url())) ?>">
                                                <?= $this->e($child->text()) ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else : ?>
                                <a class="nav-link <?= $item->url() === $page->url() ? 'active' : '' ?>""
                                    href=" <?= $this->e($url($item->url())) ?>">
                                    <span><?= $this->e($item->text()) ?></span>
                                </a>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </nav>
    </div>
</header>
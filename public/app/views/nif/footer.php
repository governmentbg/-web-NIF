<?php
/**
 * @var \vakata\views\View $this
 * @var \vakata\intl\Intl $intl
 * @var \vakata\http\Uri $url
 * @var \webpublic\components\Menu $leftfootermenu
 * @var \webpublic\components\Menu $rightfootermenu
 * @var \webpublic\components\Page $homepage
 * @var callable (string, array<string,string>=, bool=): string $asset
 */
?>
<footer class="mt-auto">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-4">
                <div class="card bg-transparent h-100">
                    <div class="card-body">
                        <a href="<?= $this->e($url($homepage->url())) ?>" class="brand">
                            <img
                            src="<?= $this->e($asset(
                                'assets/img/' .
                                ($homepage->language()->lang() === 1 ? 'nif-brand-bg.svg' : 'nif-brand-en.svg')
                            ))?>"
                            alt="Logo"
                            class="logo w-100">
                        </a>
                        <p class="text-white mt-4">
                            <abbr><?= $this->e($intl->get('site.address')) ?></abbr><br>
                            <?= $this->e($intl->get('footer.address')) ?><br>
                            <abbr>E</abbr>: info@nif.government.bg<br>
                            <!-- <abbr>Т</abbr>: +359 2 807 5381 -->
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card bg-transparent h-100">
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <?php foreach ($leftfootermenu as $link) : ?>
                                <li>
                                    <a href="<?= $this->e($url($link->url())) ?>"><?= $this->e($link->text()) ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card bg-transparent h-100">
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <?php foreach ($rightfootermenu as $link) : ?>
                                <li>
                                    <a href="<?= $this->e($url($link->url())) ?>"><?= $this->e($link->text()) ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
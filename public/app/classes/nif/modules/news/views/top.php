<?php
/**
 * @var \vakata\views\View $this
 * @var callable (string, array<string,scalar>=): string $upload
 * @var \vakata\http\Uri $url
 * @var \vakata\collection\Collection<int,\schema\NewsEntity> $news
 * @var \webpublic\components\Page $page
 * @var int $count
 * @var ?string $title
 * @var ?string $link
 * @var \vakata\intl\Intl $intl
 */
?>
<section class="news bg-light">
    <div class="container">
        <div class="row mb-5">
            <div class="col-sm-8 col-md-9">
                <?php if (isset($title) && $title) : ?>
                    <h1 class="title"><?= $this->e($title) ?></h1>
                <?php endif; ?>
            </div>            
            <div class="col-sm-4 col-md-3 text-md-end text-sm-left">
                <?php if (isset($link) && $link) : ?>
                    <a href="<?= $this->e($url($link)) ?>" class="btn btn-outline-primary">
                        <?= $this->e($intl->get('news.all')) ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="row gy-4">
            <?php foreach ($news as $k => $item) : ?>
                <?php
                if ($k === 3) {
                    break;
                }
                ?>
                <div class="col-md-6 col-lg-4" data-group="top_news">
                    <div
                        class="card h-100"
                        data-animation="fadeIn"
                        data-duration="500"
                        data-delay="<?= 150 * $k ?>">
                        <figure class="card-img-top">
                            <?php if ($image = $item->file()) : ?>
                                <img src="<?= $this->e($url($upload($image->id()))) ?>" class="img-fluid">
                            <?php endif; ?>
                        </figure>
                        <div class="card-body p-4">
                            <p class="text-secondary mb-2">
                                <?= date('d.m.Y', $item->getDate()) ?>
                            </p>
                            <a
                                href="<?= $this->e($url($page->language()->code() . '/news/' . $item->getUrl())) ?>"
                                class="card-text stretched-link text-decoration-none fs-5">
                                <?= $this->e($item->title()) ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php if ($count > 3) : ?>
    <section class="news bg-white">
        <div class="container">
            <div class="row gy-4">
                <?php foreach ($news as $k => $item) : ?>
                    <?php
                    if ($k < 3) {
                        continue;
                    }
                    ?>
                    <div class="col-md-6 col-lg-4" data-group="top_news">
                        <div
                            class="card h-100"
                            data-animation="fadeIn"
                            data-duration="500"
                            data-delay="<?= 150 * $k ?>">
                            <figure class="card-img-top">
                                <?php if ($image = $item->file()) : ?>
                                    <img src="<?= $this->e($url($upload($image->id()))) ?>" class="img-fluid">
                                <?php endif; ?>
                            </figure>
                            <div class="card-body p-4">
                                <p class="text-secondary mb-2">
                                    <?= date('d.m.Y', $item->getDate()) ?>
                                </p>
                                <a
                                    href="<?= $this->e($url($page->language()->code() . '/news/' . $item->getUrl())) ?>"
                                    class="card-text stretched-link text-decoration-none fs-5">
                                    <?= $this->e($item->title()) ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
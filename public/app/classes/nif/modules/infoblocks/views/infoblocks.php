<?php
/**
 * @var \vakata\views\View $this
 * @var \vakata\collection\Collection<int,\schema\InfoblocksEntity> $infoblocks
 * @var \vakata\http\Uri $url
 * @var callable (string, array<string,scalar>=): string $upload
 */
?>
<div class="container">
    <div class="row gy-4" data-group="infoblocks">
        <?php foreach ($infoblocks as $block) : ?>
            <div class="col-md-4">
                <div class="card bordered info-block h-100" data-animation="fadeInUp" data-duration="500">
                    <div class="card-body p-4">
                        <?php if ($image = $block->getFile()) : ?>
                            <figure class="card-img-top">
                                <img src="<?= $this->e($url($upload($image->id()))) ?>">
                            </figure>
                        <?php endif; ?>
                        <h3 class="card-title"><?= $this->e($block->getTitle()) ?></h3>
                        <p class="card-text">
                            <?= $this->e($block->getDescription()) ?>
                        </p>
                        <?= $block->url() ?
                        '<a href="' . $this->e($url($block->url())) .
                        '" class="stretched-link" title="' . $this->e($block->getTitle()) . '"></a>'
                        : '' ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
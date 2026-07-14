<?php
/**
 * @var \vakata\views\View $this
 * @var \vakata\http\Uri $url
 * @var callable (string, array<string,scalar>=): string $upload
 * @var \vakata\collection\Collection<int,\vakata\files\File> $images
 * @var string $cspNonce
 * @var callable (string, array<string,string>=, bool=): string $asset
 */
?>
<div class="position-relative">
    <div class="swiper" id="swiper-container">
        <div class="swiper-wrapper">
            <?php foreach ($images as $image) : ?>
                <?php if ($image) : ?>
                <div class="swiper-slide">
                    <img
                    src="<?= $this->e($url($upload($image->id(), [ 'w' => 250,  'h' => 250]))) ?>"
                    alt="<?= $this->e($image->name()) ?>"
                    data-src="<?= $this->e($url($upload($image->id()))) ?>"
                    data-sub-html="<h4><?= $this->e($image->name()) ?></h4>"
                    class="img-fluid">
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="swiper-navigation position-relative d-flex mt-2">
        <div class="btn btn-light rounded-0 button-prev m-0"><i class="fas fa-chevron-left"></i></div>
        <div class="btn btn-light rounded-0 button-next m-0"><i class="fas fa-chevron-right"></i></div>
    </div>
</div>
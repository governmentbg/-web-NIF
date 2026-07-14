<?php
/**
 * @var \vakata\views\View $this
 * @var string $text
 * @var string $link
 * @var string $colour
 * @var callable (string, array<string,scalar>=): string $upload
 * @var \vakata\http\Uri $url
 * @var \vakata\files\File $image
 */
?>
<div class="card <?= $colour === "info" ? 'info' : 'light' ?> bordered mb-4" data-animation="slideInRight">
    <div class="card-body p-4 <?= $image ? 'd-flex flex-column align-items-start' : '' ?>">
        <?php if ($text) : ?>
            <h3 class="card-title mb-0 fw-bold"><?= $this->e($text) ?></h3>
        <?php endif; ?>
        <?php if ($image) : ?>
            <img src="<?= $this->e($url($upload($image->id()))) ?>">
        <?php endif; ?>
        <?php if ($link) : ?>
            <a href="<?= $this->e($url($link)) ?>" class="stretched-link"></a>
        <?php endif; ?>
    </div>
</div>
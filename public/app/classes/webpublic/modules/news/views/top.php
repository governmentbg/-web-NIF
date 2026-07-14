<?php

/**
 * @var \vakata\views\View $this
 * @var callable (string, array<string,scalar>=): string $upload
 * @var \vakata\http\Uri $url
 * @var \vakata\collection\Collection<int,\schema\NewsEntity> $news
 */
?>
WIDGET TOP NEWS
<?php foreach ($news as $item) : ?>
    <p>
        <a href="<?= $this->e($url('bg/news/' . $item->news)) ?>">
            <strong><?= $this->e($item->title) ?></strong>
        </a>
    </p>
    <p><small><?= $this->e($item->fordate) ?></small></p>
    <?php if ($item->file()) : ?>
        <img src="<?= $this->e($upload($item->file()->id(), [ 'w' => 200, 'h' => 100 ])) ?>" />
    <?php endif ?>
<?php endforeach ?>

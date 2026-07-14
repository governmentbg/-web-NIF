<?php
/**
 * @var \vakata\views\View $this
 * @var ?string $type
 * @var ?string $path
 * @var ?string $title
 * @var ?string $clss
 * @var ?string $image
 * @var ?array<string,string> $meta
 * @var \vakata\http\Uri $url
 * @var callable (string, array<string,string>=, bool=): string $asset
 * @var \vakata\intl\Intl $intl
 */
?>
<!DOCTYPE html>
<html lang="<?= $this->e($intl('_locale.code.short')) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->e($title ?? 'Title') ?></title>

    <meta property="og:locale" content="<?= $this->e($intl('_locale.code.long')) ?>" />
    <meta property="og:type"   content="<?= $this->e($meta['og:type'] ?? $type ?? 'website') ?>" />
    <meta property="og:title"  content="<?= $this->e($meta['og:title'] ?? $title ?? 'Title') ?>" />
    <meta property="og:url"    content="<?= $this->e($meta['og:url'] ?? $path ?? $url->self(true)) ?>" />
    <meta property="og:image"  content="<?= $this->e($meta['og:image'] ?? $asset('assets/ogimage.png', [], true)) ?>" />
    <?php if (isset($meta)) : ?>
        <?php foreach ($meta as $tag => $value) : ?>
            <?php if (!in_array($tag, [ 'og:locale', 'og:type', 'og:title', 'og:url', 'og:image' ]) && $tag) : ?>
                <meta property="<?= $this->e($tag) ?>" content="<?= $this->e($value) ?>" />
            <?php endif ?>
        <?php endforeach ?>
    <?php endif ?>

    <link rel="stylesheet" href="<?= $asset('assets/main.css') ?>">

    <?= $this->section('head'); ?>
</head>
<body class="<?= $this->e($clss ?? '') ?>">

<?= $this->section('content'); ?>

</body>
</html>

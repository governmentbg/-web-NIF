<?php
/**
 * @var \vakata\views\View $this;
 * @var \vakata\intl\Intl $intl;
 * @var \vakata\http\Uri $url;
 * @var \webpublic\components\Menu $menu
 */
?>
<ul>
<?php foreach ($menu as $item) : ?>
    <li>
        <a href="<?= $this->e(strlen(trim($item->url())) && $item->url() !== '#' ? $url($item->url()) : '') ?>">
            <?= $this->e($item->text()) ?>
        </a>
        <?php if ($item->hasChildren()) : ?>
            <?= $this->insert('webpublic::_menu', [ 'menu' => $item->children() ]); ?>
        <?php endif ?>
    </li>
<?php endforeach ?>
</ul>

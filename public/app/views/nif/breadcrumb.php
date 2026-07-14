<?php
/**
 * @var \vakata\views\View $this
 * @var \vakata\http\Uri $url
 * @var \webpublic\components\Menu $breadcrumb
 * @var ?string $singlePageTitle
 */
?>
<?php if ($breadcrumb->count() > 0) :?>
    <nav>
        <ol class="breadcrumb">
            <?php foreach ($breadcrumb as $key => $item) : ?>
                <?php if (!isset($singlePageTitle) && $key === $breadcrumb->count() - 1) : ?>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?=$this->e($item->text());?>
                    </li>
                <?php else : ?>
                    <li class="breadcrumb-item">
                        <a href="<?=$this->e($url($item->url()))?>">
                            <?=$this->e($item->text());?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php if (isset($singlePageTitle)) : ?>
                <li class="breadcrumb-item active" aria-current="page">
                    <?=$this->e($singlePageTitle);?>
                </li>
            <?php endif; ?>
        </ol>
    </nav>
<?php endif; ?>

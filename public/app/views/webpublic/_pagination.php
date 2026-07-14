<?php
/**
 * @var \vakata\views\View $this;
 * @var \vakata\intl\Intl $intl
 * @var \vakata\http\Request $req;
 * @var \vakata\http\Uri $url
 * @var \webpublic\components\Pagination $pagination
 */
?>
<?php
$params = $pagination->getParams();
$path = ltrim($pagination->getPath(), '/');
?>

<div class="page-pagination">
    <nav class="pagination" aria-label="pagination nav">
        <ul class="pagination__list">
            <?php if ($pagination->hasFirst()) : ?>
                <li>
                    <a href="<?= $this->e($url($path, array_merge($params, [ 'p' => $pagination->getFirst() ]))); ?>"
                        class="pagination__link pagination__link--first">
                        <span class="visually-hidden"><?= $this->e($intl('pagination.first')); ?></span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($pagination->hasPrev()) : ?>
                <li>
                    <a href="<?= $this->e($url($path, array_merge($params, [ 'p' => $pagination->getPrev() ]))); ?>"
                        class="pagination__link pagination__link--prev">
                        <span class="visually-hidden"><?= $this->e($intl('pagination.prev')); ?></span>
                    </a>
                </li>
            <?php endif; ?>
            <?php foreach ($pagination as $item) : ?>
                <li>
                    <a class="pagination__link<?= $item === $pagination->getCurrentPage() ? ' active' : ''; ?>"
                        href="<?= $this->e($url($path, array_merge($params, [ 'p' => $item ]))); ?>">
                        <?= $this->e((string) $item); ?>
                    </a>
                </li>
            <?php endforeach; ?>
            <?php if ($pagination->hasNext()) : ?>
                <li>
                    <a href="<?= $this->e($url($path, array_merge($params, [ 'p' => $pagination->getNext()]))); ?>"
                        class="pagination__link pagination__link--next">
                        <span class="visually-hidden"><?= $this->e($intl('pagination.next')); ?></span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($pagination->hasLast()) : ?>
                <li>
                    <a href="<?= $this->e($url($path, array_merge($params, [ 'p' => $pagination->getLast() ]))); ?>"
                        class="pagination__link pagination__link--last">
                        <span class="visually-hidden"><?= $this->e($intl('pagination.laxt')); ?></span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

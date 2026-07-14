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
<div class="row mt-4">
    <div class="col-12">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php if ($pagination->hasPrev()) : ?>
                    <li class="page-item">
                        <a href="<?= $this->e($url($path, array_merge($params, [ 'p' => $pagination->getPrev() ]))); ?>"
                            class="page-link">
                            <i class="fa-solid fa-chevron-left"></i>
                        </a>
                    </li>
                <?php endif; ?>
                <?php foreach ($pagination as $item) : ?>
                    <li class="page-item">
                        <a class="page-link <?= $item === $pagination->getCurrentPage() ? ' active' : ''; ?>"
                            href="<?= $this->e($url($path, array_merge($params, [ 'p' => $item ]))); ?>">
                            <?= $this->e((string) $item); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
                <?php if ($pagination->hasNext()) : ?>
                    <li class="page-item">
                        <a href="<?= $this->e($url($path, array_merge($params, [ 'p' => $pagination->getNext()]))); ?>"
                            class="page-link">
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</div>
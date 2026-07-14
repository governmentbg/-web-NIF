<?php
/**
 * @var \vakata\views\View $this
 * @var callable(\vakata\files\File, int=, int=): string $upload
 * @var \vakata\http\Uri $url
 * @var \vakata\collection\Collection<int,\schema\DocumentsEntity> $documents
 * @var \vakata\intl\Intl $intl
 * @var ?string $title
 */
?>
<?php if ($documents->count() !== 0) : ?>
    <?php foreach ($documents as $doc) : ?>
        <div class="mb-4">
            <h4 class="mb-4"><?= $this->e($doc->getName()); ?></h4>
            <div class="download-files list-group list-group-flush">
                <p><?= $this->e($doc->getDescription()) ?></p>
                <?php foreach ($doc->getFiles() as $item) : ?>
                    <?php if ($file = $item->getFile()) : ?>
                        <a href="<?= $this->e($url($upload($file->id()))) ?>"
                            class="list-group-item list-group-item-action d-flex flex-row">
                            <div class="d-flex align-items-center p-4">
                                <i class="fas fa-cloud-arrow-down fa-xl"></i>
                            </div>
                            <div class="d-flex w-100 flex-column">
                                <span class="pb-2">
                                    <?=
                                    $this->e(strlen($file->setting('name')) ?
                                    $file->setting('name') :
                                    $file->name())
                                    ?>
                                </span>
                                <span class="text-secondary">
                                    <?= $file->ext() ?>,
                                    <?= round($file->size() / 1024, 2) . 'KB' ?>,
                                    <?=
                                    $this->e($intl->get('documents.documents.published')) .
                                    ' ' .
                                    date('d.m.Y', $doc->getDate())
                                    ?>
                                </span>
                            </div>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
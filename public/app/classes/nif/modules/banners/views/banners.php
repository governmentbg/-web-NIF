<?php
/**
 * @var \vakata\views\View $this
 * @var \vakata\intl\Intl $intl
 * @var callable (string, array<string,scalar>=): string $upload
 * @var \vakata\http\Uri $url
 * @var \vakata\collection\Collection<int,\schema\BannersEntity> $banners
 */
?>
<?php if (count($banners)) : ?>
    <section class="partners bg-light">
        <div class="container">
            <div class="row gy-1">
                <?php foreach ($banners as $k => $item) : ?>
                    <?php if ($file = $item->getImage()) : ?>
                        <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                            <figure
                                class="partner-logo"
                                data-animation="zoomIn" 
                                data-duration="500"
                                data-delay="<?= $k * 150 ?>">
                                <a href="<?= $this->e($url($item->link)); ?>" target="_blank">
                                    <img
                                        src="<?= $this->e($url($upload($file->id(), ['w' => 450]))); ?>"
                                        class="img-fluid"
                                        alt="<?= $this->e($item->getAlt()); ?>">
                                </a>
                            </figure>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
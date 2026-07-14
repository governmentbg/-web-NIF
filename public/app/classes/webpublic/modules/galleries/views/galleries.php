<?php
/**
 * @var \vakata\views\View $this
 * @var \webpublic\components\Page $page
 * @var \vakata\http\Uri $url
 * @var callable (string, array<string,string>=, bool=): string $asset
 * @var callable (string, array<string,scalar>=): string $upload
 * @var \vakata\intl\Intl $intl
 * @var \webpublic\components\Pagination $pagination
 * @var array<string,array<\webpublic\modules\WidgetInterface>> $widgets
 * @var \vakata\collection\Collection<int,\schema\GalleriesEntity> $galleries
 */
?>
<?php
$this->layout(
    'webpublic::html',
    [ 'title' => $page->title(), 'meta' => $page->getMeta(), 'clss' => $page->getSetting('clss') ]
);
?>

<h1><?= $this->e($intl($page->site()->name())) ?></h1>
<hr />
<hr />

<h2>MENUS</h2>
TRANSLATIONS
<?= $this->insert('webpublic::_menu', [ 'menu' => $page->translations() ]) ?>
<hr />
MENU
<?= $this->insert('webpublic::_menu', [ 'menu' => $page->menu() ]) ?>
<hr />
BREADCRUMB
<?= $this->insert('webpublic::_menu', [ 'menu' => $page->breadcrumb() ]) ?>
<hr />
CHILDREN
<?= $this->insert('webpublic::_menu', [ 'menu' => $page->children() ]) ?>
<hr />
SIBLINGS
<?= $this->insert('webpublic::_menu', [ 'menu' => $page->siblings() ]) ?>
<hr />
<hr />

<h2>CONTENT</h2>
<h3>before</h3>
<?php foreach ($widgets['before-main'] ?? [] as $widget) : ?>
    <?= $widget->render() ?>
<?php endforeach ?>

<?php foreach ($galleries as $item) : ?>
    <p>
        <strong><?= $this->e($item->title) ?></strong>
    </p>
    <p><small><?= $this->e($item->fordate) ?></small></p>
    <?php foreach ($item->images() as $image) : ?>
        <img src="<?= $this->e($upload($image->id(), [ 'w' => 200, 'h' => 100 ])) ?>" />
    <?php endforeach ?>
<?php endforeach ?>

<p>PAGING:</p>
<?= $this->insert('webpublic::_pagination', [ 'pagination' => $pagination ]) ?>

<h3>after</h3>
<?php foreach ($widgets['after-main'] ?? [] as $widget) : ?>
    <?= $widget->render() ?>
<?php endforeach ?>

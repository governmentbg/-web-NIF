<?php
/**
 * @var \vakata\views\View $this
 * @var \webpublic\components\Page $page
 * @var string $content
 * @var \webpublic\components\Pagination $pagination
 * @var string $q
 * @var array<string,array<\webpublic\modules\WidgetInterface>> $widgets
 * @var ?\vakata\collection\Collection<int,\schema\SearchIndexEntity> $results
 * @var \vakata\http\Uri $url
 * @var \vakata\intl\Intl $intl
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
<h3>main</h3>

<form>
    <input type="search" name="q" value="<?= $this->e($q) ?>" />
    <input type="hidden" name="p" value="1" />
    <button><?= $this->e($intl('search')) ?></button>
</form>

<?php if (!isset($results)) : ?>
    <?= $this->e($intl('search.noresult')) ?>
<?php endif ?>

<?php foreach ($results ?? [] as $result) : ?>
    <p><a href="<?= $this->e($url(ltrim($result->url, '/'))) ?>"><?= $this->e($result->title) ?></a></p>
<?php endforeach ?>

<p>PAGING:</p>
<?= $this->insert('webpublic::_pagination', [ 'pagination' => $pagination ]) ?>

<h3>after</h3>
<?php foreach ($widgets['after-main'] ?? [] as $widget) : ?>
    <?= $widget->render() ?>
<?php endforeach ?>

<?php
/**
 * @var \vakata\views\View $this
 * @var \webpublic\components\Page $page
 * @var string $content
 * @var \vakata\intl\Intl $intl
 * @var array<string,array<\webpublic\modules\WidgetInterface>> $widgets
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
<?= $content ?>
<h3>after</h3>
<?php foreach ($widgets['after-main'] ?? [] as $widget) : ?>
    <?= $widget->render() ?>
<?php endforeach ?>

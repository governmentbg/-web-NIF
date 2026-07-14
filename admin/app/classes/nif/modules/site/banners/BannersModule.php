<?php

declare(strict_types=1);

namespace nif\modules\site\banners;

use RuntimeException;
use vakata\di\DIContainer;
use webadmin\components\html\Field;
use webadmin\components\html\Form;
use webadmin\components\html\Table;
use webadmin\modules\common\crud\CRUDController;
use webadmin\modules\common\crud\CRUDModule;
use webadmin\modules\site\WidgetInterface;
use webadmin\modules\site\WidgetProviderInterface;

/** @extends CRUDModule<\schema\BannersEntity,BannersService> */
class BannersModule extends CRUDModule implements WidgetProviderInterface
{
    public const string NAME = 'banners';
    public function __construct(DIContainer $container, string $slug = '')
    {
        parent::__construct(
            $container,
            self::NAME,
            $slug,
            'blog',
            'orange',
            'cms',
            'banners',
            CRUDController::class,
            namespace\BannersService::class
        );
    }
    public function getWidgets(): array
    {
        return [ 'banners' ];
    }
    public function getWidget(string $name): WidgetInterface
    {
        switch ($name) {
            case 'banners':
                return new BannersWidget();
            default:
                throw new RuntimeException();
        }
    }
    public function listingCallback(Table $table): Table
    {
        $table = parent::listingCallback($table);
        $langs = $this->getService()->getLanguages();

        $table->getColumn('lang')
            ->setMap(function (mixed $v) use ($langs) {
                return $langs[$v] ?? '';
            })->setFilter(
                (new Form())
                    ->addField(
                        new Field(
                            "select",
                            [ 'name' => 'lang' ],
                            [ 'label' => $this->name . '.filters.lang', 'values' => $langs]
                        )
                    )
            );
        $table
            ->removeColumn('alt')
            ->removeColumn('image')
            ->removeColumn('link');

        return $table->setOrder([ 'title', 'lang', 'pos' ]);
    }
    public function formCallback(Form $form): Form
    {
        $form = parent::formCallback($form);
        $service = $this->getService();

        $form->getField('pos')
            ->setType('number');
        $form->getField('lang')
            ->setType('select')
            ->setOption('values', $service->getLanguages());

        $form->setLayout([
            [ 'lang', 'title', 'alt' ],
            [ 'link', 'pos' ],
            [ 'image' ]
        ]);

        return $form;
    }
    public function onDashboard(): bool
    {
        return true;
    }
    public function inMenu(): bool
    {
        return true;
    }
    public function canCreate(): bool
    {
        return true;
    }
    public function canRead(): bool
    {
        return true;
    }
    public function canUpdate(): bool
    {
        return true;
    }
    public function canDelete(): bool
    {
        return true;
    }
}

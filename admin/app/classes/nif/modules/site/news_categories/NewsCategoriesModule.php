<?php

declare(strict_types=1);

namespace nif\modules\site\news_categories;

use vakata\di\DIContainer;
use webadmin\components\html\Field;
use webadmin\components\html\Form;
use webadmin\components\html\Table;
use webadmin\modules\common\crud\CRUDController;
use webadmin\modules\common\crud\CRUDModule;

/** @extends CRUDModule<\schema\NewsCategoriesEntity,NewsCategoriesService> */
class NewsCategoriesModule extends CRUDModule
{
    public const string NAME = 'news_categories';
    public function __construct(DIContainer $container, string $slug = '')
    {
        parent::__construct(
            $container,
            self::NAME,
            $slug,
            'calendar alternate',
            'orange',
            'cms',
            'news_categories',
            CRUDController::class,
            namespace\NewsCategoriesService::class
        );
    }
    public function listingCallback(Table $table): Table
    {
        $table = parent::listingCallback($table);
        $table->removeColumn('category');
        $langs = $this->getService()->languages();
        $table->getColumn('name')
            ->setMap(function (mixed $v) {
                if (strlen($v) > 50) {
                    return mb_substr($v, 0, 50) . '...';
                }
                return $v;
            });
        $table->getColumn('url')
            ->setMap(function (mixed $v) {
                if (strlen($v) > 100) {
                    return mb_substr($v, 0, 100) . '...';
                }
                return $v;
            });
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
        return $table;
    }
    public function formCallback(Form $form): Form
    {
        $form = parent::formCallback($form);
        $intl = $this->getService()->intl();
        $form
            ->removeField('category')
            ->getField('url')
            ->setType('text');
        $form
            ->getField('lang')
            ->setType('select')
            ->setOption('values', $this->getService()->languages());
        if ($form->hasValidator()) {
            $validator = $form->getValidator();
            $validator
                ->required('name', $intl->get($this->getName() . '.name.required'))
                ->maxLength(255, $intl->get($this->getName() . '.name.maxLength'))
                ->required('url', $this->getName() . '.url.required')
                ->maxLength(1000, $this->getName() . '.url.maxLength');
        }
        return $form;
    }
}

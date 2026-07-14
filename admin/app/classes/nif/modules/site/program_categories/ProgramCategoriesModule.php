<?php

declare(strict_types=1);

namespace nif\modules\site\program_categories;

use vakata\di\DIContainer;
use webadmin\components\html\Field;
use webadmin\modules\common\crud\CRUDModule;
use webadmin\components\html\Form;
use webadmin\components\html\HTML;
use webadmin\components\html\Table;
use webadmin\modules\common\crud\CRUDController;

/** @extends CRUDModule<\schema\ProgramCategoriesEntity,ProgramCategoriesService> */
class ProgramCategoriesModule extends CRUDModule
{
    public const string NAME = 'program_categories';
    public function __construct(DIContainer $container, string $slug = '')
    {
        parent::__construct(
            $container,
            self::NAME,
            $slug,
            'building',
            'blue',
            'cms',
            'program_categories',
            CRUDController::class,
            namespace\ProgramCategoriesService::class
        );
    }
    public function listingCallback(Table $table): Table
    {
        $table = parent::listingCallback($table);
        $service = $this->getService();
        $langs = $service->languages();
        $table
            ->removeColumn('sort_order')
            ->removeColumn('category')
            ->getColumn('lang')
            ->setMap(function (mixed $v) use ($langs) {
                return $langs[$v] ?? '';
            })
            ->setFilter(
                (new Form())
                ->addField(
                    new Field(
                        'select',
                        ['name' => 'lang'],
                        [
                            'label'  => $this->getName() . '.filter.lang',
                            'values' => $langs
                        ]
                    )
                )
            );
        $table
            ->getColumn('is_active')
            ->setMap(function (mixed $v) {
                return new HTML(
                    '<button
                        data-value="1"
                        data-field="is_active"
                        class="state-button ui mini basic icon button ' . ($v ? 'hide' : '') . '">
                            <i class="ui times icon"></i></button>' .
                    '<button
                        data-value="0"
                        data-field="is_active"
                        class="state-button ui mini basic icon button ' . (!$v ? 'hide' : '') . '">
                            <i class="ui check icon"></i></button>'
                );
            });
        return $table->setOrder(['lang', 'name', 'is_active']);
    }
    public function formCallback(Form $form): Form
    {
        $form = parent::formCallback($form);
        $service = $this->getService();
        $intl = $service->intl();
        $form
            ->removeField('category')
            ->getField('lang')
            ->setType('select')
            ->setOption('values', $service->languages());
        $form
            ->getField('name')
            ->show();
        $form
            ->getField('is_active')
            ->setType('checkbox');
        $form
            ->getField('sort_order')
            ->setType('select')
            ->setOption('values', [ 0 => 'DESC',  1 => "ASC"]);
        if ($form->hasValidator()) {
            $validator = $form->getValidator();
            $validator
                ->required('name', $intl->get($this->getName() . '.required.name'))
                ->maxLength(255, $intl->get($this->getName() . '.maxLength.name'));
        }
        return $form->setLayout([
            [ 'lang', 'name' ],
            [ 'sort_order', 'is_active' ]
        ]);
    }
    public function canRead(): bool
    {
        return true;
    }
}

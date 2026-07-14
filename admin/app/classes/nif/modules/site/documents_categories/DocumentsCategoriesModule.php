<?php

declare(strict_types=1);

namespace nif\modules\site\documents_categories;

use vakata\di\DIContainer;
use webadmin\modules\common\crud\CRUDModule;
use webadmin\components\html\Field;
use webadmin\components\html\Form;
use webadmin\components\html\Table;
use webadmin\modules\common\crud\CRUDController;

/** @extends CRUDModule<\schema\DocumentsCategoriesEntity,DocumentsCategoriesService> */
class DocumentsCategoriesModule extends CRUDModule
{
    public const string NAME = "documents_categories";
    public function __construct(DIContainer $container, string $slug = '')
    {
        parent::__construct(
            $container,
            self::NAME,
            $slug,
            'folder',
            'orange',
            'cms',
            'documents_categories',
            CRUDController::class,
            namespace\DocumentsCategoriesService::class
        );
    }
    public function listingCallback(Table $table): Table
    {
        $table = parent::listingCallback($table);
        $langs = $this->getService()
            ->languages();
        $table->getColumn('name')
            ->setMap(function (mixed $v) {
                if (strlen($v) > 50) {
                    return mb_substr($v, 0, 50) . '...';
                }
                return $v;
            });
        $table->getColumn('lang')
            ->setMap(function (mixed $v) use ($langs) {
                return $langs[$v] ?? '';
            })
            ->setFilter(
                (new Form())
                ->addField(
                    new Field(
                        'select',
                        [ 'name' => 'lang' ],
                        [ 'label' => $this->name . '.filters.lang', 'values' => $langs ]
                    )
                )
            );
        return $table;
    }
    public function formCallback(Form $form): Form
    {
        $form = parent::formCallback($form);
        $service = $this->getService();
        $intl = $service->intl();

        $form
            ->removeField('category')
            ->getField('name')
            ->setType('text')
            ->setOption('maxLength', 255);
        $form
            ->getField('ord')
            ->setType('number')
            ->setValue(0)
            ->setAttr('min', 0);
        $form
            ->getField('lang')
            ->setType('select')
            ->setOption('values', $service->languages());

        if ($form->hasValidator()) {
            $validator = $form->getValidator();
            $validator
                ->required('name', $intl->get($this->name . '.name.required'))
                ->maxLength(255, $intl->get($this->name . '.name.maxlength'));
            $validator
                ->required('ord')
                ->min(0, $intl->get($this->name . '.ord.required'));

            $form->setValidator($validator);
        }

        $form->setLayout([
            [ 'lang', 'name', 'ord' ]
        ]);

        return $form;
    }
}

<?php

declare(strict_types=1);

namespace nif\modules\site\infoblocks;

use RuntimeException;
use vakata\di\DIContainer;
use webadmin\components\html\Form;
use webadmin\components\html\Field;
use webadmin\components\html\Table;
use webadmin\modules\common\crud\CRUDModule;
use webadmin\modules\site\WidgetProviderInterface;
use webadmin\modules\common\crud\CRUDController;
use webadmin\modules\site\WidgetInterface;

/**
 * @extends CRUDModule<\schema\InfoblocksEntity,InfoblocksService>
 */
class InfoblocksModule extends CRUDModule implements WidgetProviderInterface
{
    public const string NAME = "infoblocks";
    public function __construct(DIContainer $container, string $slug = '')
    {
        parent::__construct(
            $container,
            self::NAME,
            $slug,
            'info circle icon',
            'green',
            'cms',
            'infoblocks',
            CRUDController::class,
            namespace\InfoblocksService::class
        );
    }
    public function listingCallback(Table $table): Table
    {
        $table = parent::listingCallback($table);
        $table
            ->removeColumn('page')
            ->removeColumn('icon');
        $langs = $this->getService()->getLanguages();
        $table
            ->getColumn('lang')
                ->setMap(function (mixed $v) use ($langs) {
                    return $langs[$v] ?? '';
                })->setFilter(
                    (new Form())
                        ->addField(new Field(
                            "select",
                            [ 'name' => 'lang' ],
                            [
                                'label' => $this->name . '.filters.lang',
                                'values' => $this->getService()->getLanguages()
                            ]
                        ))
                );
        $table->setOrder(['lang', 'title', 'description']);
        return $table;
    }
    public function formCallback(Form $form): Form
    {
        $form = parent::formCallback($form);
        $service = $this->getService();
        $intl = $service->intl();
        $form
            ->removeField('infoblock')
            ->getField('description')
            ->setType('textarea');
        $form
            ->getField('icon')
            ->setType("image");
        $form
            ->getField('lang')
            ->setType('select')
            ->setOption('values', $service->getLanguages())
            ->setAttr('data-redraw', '1');
        $form
            ->getField('hidden')
            ->setType('checkbox');
        $form
            ->getField('page_url')
            ->setType('text');
        if ($form->hasValidator()) {
            $validator = $form->getValidator();
            $validator
                ->required('title', $intl->get($this->name . '.title.required'))
                ->maxLength(1000, $intl->get($this->name . '.title.maxLength'))
                ->required('description', $intl->get($this->name . '.description.required'))
                ->maxLength(2000, $intl->get($this->name . '.description.maxLength'))
                ->optional('page_url')
                ->url(['http', 'https'], $intl->get($this->name . '.page_url.url'));
            $form->setValidator($validator);
        }
        $form->setLayout([
            [ 'title', 'lang'],
            [ 'page_url:12', 'hidden:4'],
            [ 'description' ],
            [ 'icon' ]
        ]);
        return $form;
    }
    public function canCopy(): bool
    {
        return false;
    }
    public function canCreate(): bool
    {
        return true;
    }
    public function canDelete(): bool
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
    public function getWidget(string $name): WidgetInterface
    {
        if ($name !== 'infoblocks') {
            throw new RuntimeException();
        }
        return $this->container->instance(InfoblocksWidget::class);
    }
    public function getWidgets(): array
    {
        return ['infoblocks'];
    }
}

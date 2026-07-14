<?php

declare(strict_types=1);

namespace nif\modules\site\news;

use RuntimeException;
use schema\NewsEntity;
use vakata\di\DIContainer;
use webadmin\components\html\Field;
use webadmin\components\html\Form;
use webadmin\components\html\HTML;
use webadmin\components\html\Table;
use webadmin\components\html\TableColumn;
use webadmin\modules\common\crud\CRUDController;
use webadmin\modules\common\crud\CRUDModule;
use webadmin\modules\site\news\NewsModule as WebadminNewsModule;
use webadmin\modules\site\TemplateInterface;
use webadmin\modules\site\WidgetInterface;

class NewsModule extends WebadminNewsModule
{
    public function __construct(DIContainer $container, string $slug = '')
    {
        /** @psalm-suppress InvalidArgument */
        CRUDModule::__construct(
            $container,
            self::NAME,
            $slug,
            'calendar',
            'olive',
            'cms',
            'news',
            CRUDController::class,
            namespace\NewsService::class
        );
    }
    public function listingCallback(Table $table): Table
    {
        $table = parent::listingCallback($table);
        /** @var NewsService $service */
        $service = $this->getService();
        $langs = $service->getLanguages();
        $table
            ->removeColumn('leading_news')
            ->removeColumn('status')
            ->removeColumn('description')
            ->removeColumn('content')
            ->removeColumn('image');
        $table
            ->getColumn('lang')
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
        $table
            ->getColumn('title')
            ->setMap(function (mixed $v) {
                if (strlen($v) > 50) {
                    return mb_substr($v, 0, 50) . '...';
                }
                return $v;
            });
        $categories = $service->getTypes();
        $table->addColumn(
            (new TableColumn('news_types.type'))
                ->setMap(function (mixed $k, NewsEntity $row) use ($categories) {
                    $tags = [];
                    foreach ($row->news_types as $type) {
                        if ($type && isset($categories[$type->type])) {
                            $tags[] = '<span class="ui horizontal label">' . $categories[$type->type] . '</span>';
                        }
                    }
                    return new HTML(implode(', ', $tags));
                })
                ->setSortable(false)
                ->setFilter(
                    (new Form())
                        ->addField(new Field(
                            'multipleselect',
                            ['name' => 'news_types.type[]'],
                            [
                                'label'  => $this->name . '.filters.category',
                                'values' => $categories
                            ]
                        ))
                )
        );
        return $table;
    }
    public function formCallback(Form $form): Form
    {
        $form = parent::formCallback($form);
        /** @var NewsService $service*/
        $service = $this->getService();
        $intl = $service->intl();
        $form->getField('tags[]')
            ->show();
        $form
            ->getField('leading_news')
            ->setType('checkbox');
        $form
            ->getField('description')
            ->setType('textarea');
        $form
            ->getField('status')
            ->setType('select')
            ->setOption('values', $service->statuses());
        $form->addField(
            new Field(
                'multipleselect',
                [ 'name' => 'categories[]' ],
                [
                    'label'  => $this->name . '.columns.categories',
                    'values' => $service->getTypes()
                ]
            )
        );
        $form->addField(
            new Field(
                'images',
                ['name' => 'images'],
                ['label' => $this->name . '.columns.images']
            )
        );
        $form->addField(
            new Field(
                'files',
                [ 'name'    => 'files' ],
                [
                    'label'   => $this->getName() . '.columns.files',
                    'form'      => (new Form())
                        ->addField(
                            new Field(
                                'text',
                                [ 'name'    => 'name' ],
                                [ 'label'   => $this->getName() . '.columns.files.name' ]
                            )
                        )
                ]
            )
        );
        if ($form->hasValidator()) {
            $validator = $form->getValidator();
            $validator
                ->required('title', $intl->get($this->name . '.title.required'))
                ->maxLength(1000, $intl->get($this->name . '.title.maxLength'))
                ->required('visible_beg', $intl->get($this->name . '.visible_from.required'))
                ->optional('files.*.fordate')
                ->date('d.m.Y', $this->name . '.fordate.date');
        }
        $entity = $form->getContext('entity', null);
        if ($entity) {
            $form->populate($service->toArray($entity, true));
        }
        if ($form->getContext('type') === 'delete' || $form->getContext('type') === 'read') {
            $form->getField('images')->disable();
            $form->getField('files')->disable();
            $form->getField('categories[]')->disable();
        }
        return $form->setLayout([
            [ 'lang', 'hidden', 'leading_news' ],
            [ 'fordate', 'visible_beg', 'visible_end' ],
            [ 'tags[]', 'categories[]' ],
            [ 'title' ],
            [ 'description' ],
            [ 'content' ],
            [ 'image' ],
            [ 'images' ],
            [ 'files' ]
        ]);
    }
    public function getTemplates(): array
    {
        return [ 'news' ];
    }
    public function getTemplate(string $name): TemplateInterface
    {
        if ($name !== 'news') {
            throw new RuntimeException();
        }
        return $this->container->instance(NewsTemplate::class, [ 'service' => $this->getService() ]);
    }
    public function getWidgets(): array
    {
        return [ 'news_top' ];
    }
    public function getWidget(string $name): WidgetInterface
    {
        if ($name !== 'news_top') {
            throw new RuntimeException();
        }
        return $this->container->instance(TopWidget::class, [ 'service' => $this->getService() ]);
    }
}

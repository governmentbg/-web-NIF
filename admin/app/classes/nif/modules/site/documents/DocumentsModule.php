<?php

declare(strict_types=1);

namespace nif\modules\site\documents;

use RuntimeException;
use schema\DocumentsEntity;
use vakata\di\DIContainer;
use webadmin\components\html\Field;
use webadmin\components\html\Form;
use webadmin\components\html\HTML;
use webadmin\components\html\Table;
use webadmin\components\html\TableColumn;
use webadmin\modules\common\crud\CRUDController;
use webadmin\modules\common\crud\CRUDModule;
use webadmin\modules\site\TemplateInterface;
use webadmin\modules\site\TemplateProviderInterface;
use webadmin\modules\site\WidgetInterface;
use webadmin\modules\site\WidgetProviderInterface;

/**
 * @extends CRUDModule<\schema\DocumentsEntity,DocumentsService>
 */
class DocumentsModule extends CRUDModule implements TemplateProviderInterface, WidgetProviderInterface
{
    public const string NAME = 'documents';
    public function __construct(DIContainer $container, string $slug)
    {
        parent::__construct(
            $container,
            self::NAME,
            $slug,
            'file alternate',
            'olive',
            'cms',
            'documents',
            CRUDController::class,
            DocumentsService::class
        );
    }
    public function listingCallback(Table $table): Table
    {
        $table = parent::listingCallback($table);
        $intl = $this->getService()->intl();
        $table
            ->removeColumn('description')
            ->removeColumn('document');
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
        $table
            ->getColumn('hidden')
                ->setMap(function (mixed $v) {
                    return new HTML(
                        '<button
                            data-value="1"
                            data-field="hidden"
                            class="state-button ui mini basic icon button ' . ($v ? 'hide' : '') . '">
                                <i class="ui eye icon"></i></button>' .
                        '<button
                            data-value="0"
                            data-field="hidden"
                            class="state-button ui mini basic icon button ' . (!$v ? 'hide' : '') . '">
                                <i class="ui eye slash icon"></i></button>'
                    );
                })
            ->setFilter(
                (new Form())
                    ->addField(new Field(
                        'select',
                        [ 'name' => 'hidden' ],
                        [
                            'label' => $this->name . '.filters.hidden',
                            'values' => [
                                1 => $intl->get($this->name . '.filter.value.hidden'),
                                0 => $intl->get($this->name . '.filter.value.not_hidden')
                            ]
                        ]
                    ))
            );
        $categories = $this->getService()->getTypes();
        $table
            ->addColumn(
                (new TableColumn('documents_categories.type'))
                    ->setMap(function (mixed $k, DocumentsEntity $row) use ($categories) {
                        $tags = [];
                        foreach ($row->documents_categories as $type) {
                            if ($type && isset($categories[$type->category])) {
                                $tags[] = '<span class="ui horizontal label">' .
                                $categories[$type->category] .
                                '</span>';
                            }
                        }
                        return new HTML(implode(', ', $tags));
                    })
                    ->setSortable(false)
                    ->setFilter(
                        (new Form())
                            ->addField(new Field(
                                "multipleselect",
                                [ 'name' => 'documents_categories.type[]' ],
                                [ 'label' => $this->name . '.filters.category', 'values' => $categories ]
                            ))
                    )
            );
        return $table;
    }
    public function formCallback(Form $form): Form
    {
        $form = parent::formCallback($form);
        $service = $this->getService();
        $form
            ->removeField('document')
            ->getField('lang')
            ->setType('select')
            ->setOption('values', $service->languages());
        $form
            ->getField('name')
            ->setType('text')
            ->setOption('maxLength', 255);
        $form
            ->getField('hidden')
            ->setType('checkbox')
            ->setValue(0);
        $form
            ->getField('description')
            ->setType('textarea');
        $form
            ->getField('fordate')
            ->setType('date');

        $form->getField('documents_categories[]')->show();
        $intl = $service->intl();
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
                ->required('name', $intl->get($this->name . '.name.required'))
                ->maxLength(255, $intl->get($this->name . '.name.maxLength'));
            $form->setValidator($validator);
        }

        $form->setLayout(
            [
                [ 'lang', 'name', 'fordate', 'hidden' ],
                [ 'documents_categories[]' ],
                [ 'description' ],
                [ 'files' ]
            ]
        );
        $entity = $form->getContext('entity', null);
        if ($entity) {
            $form->populate($service->toArray($entity));
        }
        if ($form->getContext('type') === 'delete' || $form->getContext('type') === 'read') {
            $form->disable();
        }
        return $form;
    }
    public function getTemplates(): array
    {
        return [ 'documents' ];
    }
    public function getTemplate(string $name): TemplateInterface
    {
        if ($name !== 'documents') {
            throw new RuntimeException();
        }
        return $this->container->instance(DocumentsTemplate::class, [ 'service' => $this->getService() ]);
    }
    public function getWidgets(): array
    {
        return [ 'documentschosen', 'documentsgroup' ];
    }
    public function getWidget(string $name): WidgetInterface
    {
        switch ($name) {
            case 'documentschosen':
                return $this->container->instance(DocumentsChosenWidget::class, [ 'service' => $this->getService() ]);
            case 'documentsgroup':
                return $this->container->instance(DocumentsGroupWidget::class, [ 'service' => $this->getService() ]);
            default:
                throw new RuntimeException();
        }
    }
}

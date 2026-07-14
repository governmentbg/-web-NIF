<?php

declare(strict_types=1);

namespace nif\modules\site\programs;

use RuntimeException;
use schema\ProgramsEntity;
use vakata\di\DIContainer;
use webadmin\components\html\Button;
use webadmin\components\html\Field;
use webadmin\components\html\Form;
use webadmin\components\html\HTML;
use webadmin\components\html\Table;
use webadmin\modules\common\crud\CRUDModule;
use webadmin\modules\site\TemplateInterface;
use webadmin\modules\site\TemplateProviderInterface;
use webadmin\modules\site\WidgetInterface;
use webadmin\modules\site\WidgetProviderInterface;

/** @extends CRUDModule<\schema\ProgramsEntity,ProgramsService> */
class ProgramsModule extends CRUDModule implements TemplateProviderInterface, WidgetProviderInterface
{
    public const string NAME = 'programs';
    public function __construct(DIContainer $container, string $slug = '')
    {
        parent::__construct(
            $container,
            self::NAME,
            $slug,
            'parking',
            'purple',
            'cms',
            'programs',
            namespace\ProgramsController::class,
            namespace\ProgramsService::class
        );
    }
    public function listingCallback(Table $table): Table
    {
        $table = parent::listingCallback($table);
        $service = $this->getService();
        $statuses = $service->statuses();
        $langs = $service->languages();
        $types = $service->getTypes();
        $intl = $service->intl();
        $table
            ->removeColumn('description')
            ->removeColumn('m_duration')
            ->removeColumn('budget')
            ->removeColumn('header_img')
            ->removeColumn('content')
            ->removeColumn('redirect_url')
            ->removeColumn('created')
            ->removeColumn('updated')
            ->removeColumn('created_by')
            ->removeColumn('updated_by');
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
        $table
            ->getColumn('status')
            ->setMap(function (mixed $v) use ($statuses) {
                return $statuses[$v] ?? '';
            })
            ->setFilter(
                (new Form())
                    ->addField(new Field(
                        'select',
                        ['name' => 'status'],
                        [
                            'label' => $this->getName() . '.filters.status',
                            'values' => $statuses
                        ]
                    ))
            );
        $table->getColumn('type')
            ->setMap(function (mixed $k, ProgramsEntity $row) use ($types): string {
                    $type = $row->type ?? 1;
                    return $types[$type];
            })
            ->setSortable(false)
            ->setFilter(
                (new Form())
                    ->addField(new Field(
                        'select',
                        ['name' => 'programs.type'],
                        [
                            'label'  => $this->name . '.filters.category',
                            'values' => $types
                        ]
                    ))
            );
        $table
            ->getColumn('is_leading')
            ->setMap(function (mixed $v) {
                return new HTML(
                    '<button
                        data-value="1"
                        data-field="is_leading"
                        class="state-button ui mini basic icon button ' . ($v ? 'hide' : '') . '">
                            <i class="ui times icon"></i></button>' .
                    '<button
                        data-value="0"
                        data-field="is_leading"
                        class="state-button ui mini basic icon button ' . (!$v ? 'hide' : '') . '">
                            <i class="ui check icon"></i></button>'
                );
            });
        $table
            ->getColumn('publish_status')
            ->setMap(function (mixed $v): string {
                return $this->getService()->publishStatus()[$v];
            });
        foreach ($table->getRows() as $v) {
            $operations = $v->getOperations(true);
            $temp = [];
            $temp['update'] = $operations['update'];
            $temp['read'] = $operations['read'];
            $temp['history'] = $operations['history']->show();
            /** @var \schema\ProgramsEntity $data */
            $data = $v->getData();
            $curr_publish_status = $service->checkPublishStatus($data->program);
            if ($curr_publish_status !== 2) {
                $temp['archive'] = (new Button('archive'))
                    ->setLabel($intl->get($this->name . '.operations.archive'))
                    ->setIcon('book')
                    ->setClass('skip mini olive icon button')
                    ->setAttr('href', $this->slug . '/archive/' . $v->getAttr('id'));
            }
            if ($curr_publish_status !== 1) {
                $temp['publish'] = (new Button('publish'))
                    ->setLabel($intl->get($this->name . '.operations.publish'))
                    ->setIcon('arrow up')
                    ->setClass('skip mini green icon button')
                    ->setAttr('href', $this->slug . '/publish/' . $v->getAttr('id'));
            }
            $v->setOperations($temp);
            if ($v->getData()->disabled) {
                $v->addClass('error');
            }
        }
        return $table->setOrder(
            [
                'lang',
                'title',
                'status',
                'programs_types.type',
                'p_beg',
                'p_end',
                'is_leading',
                'publish_status'
            ]
        );
    }
    public function formCallback(Form $form): Form
    {
        $form = parent::formCallback($form);
        $service = $this->getService();
        $intl = $service->intl();
        $form
            ->removeField('created')
            ->removeField('updated')
            ->removeField('created_by')
            ->removeField('updated_by');
        $form
            ->removeField('program')
            ->getField('lang')
            ->setType('select')
            ->setOption('values', $service->languages());
        $form
            ->getField('description')
            ->setType('textarea');
        $form
            ->getField('status')
            ->setType('select')
            ->setOption('values', $service->statuses());
        $form
            ->getField('m_duration')
            ->setType('number')
            ->setAttr('min', 1)
            ->setAttr('max', 36);
        $form
            ->getField('p_beg')
            ->setType('datetime')
            ->setAttr('date-redraw', '1');
        $form
            ->getField('p_end')
            ->setType('datetime');
        $form
            ->getField('is_leading')
            ->setType('checkbox');
        $form
            ->getField('header_img')
            ->setType('image');
        $form
            ->getField('content')
            ->setType('richtext');
        $form
            ->getField('redirect_url')
            ->setType('text');
        $form
            ->getField('publish_status')
            ->setType('select')
            ->setOption('values', $service->publishStatus());
        $form
            ->getField('type')
            ->setType('select')
            ->setOption('values', $service->getTypes());
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
                ->maxLength(2000, $intl->get($this->name . '.title.maxLength'))
                ->required('description', $intl->get($this->name . '.description.required'))
                ->required('type', $intl->get($this->name . '.type.required'))
                ->optional('m_duration')
                ->min(1, $intl->get($this->name . '.m_duration.min'))
                ->max(36, $intl->get($this->name . '.m_duration.max'))
                ->required('p_beg', $intl->get($this->name . '.p_beg.required'))
                ->required('p_end', $intl->get($this->name . '.p_end.required'))
                ->minDateRelation('p_beg', 'd.m.Y H:i', $intl->get($this->name . 'p_end.min.date.relation'))
                ->key('budget')
                ->maxLength(2000, $intl->get($this->name . '.budget.maxLength'))
                ->key('redirect_url')
                ->maxLength(2000, $intl->get($this->name . '.redirect_url.maxLength'));
        }
        $entity = $form->getContext('entity', null);
        if ($entity) {
            $form->populate($service->toArray($entity));
        }
        if ($form->getContext('type') === 'create') {
            $form->getField('p_beg')->setValue(date('Y-m-d H:i:s'));
        }
        if ($form->getContext('type') === 'delete' || $form->getContext('type') === 'read') {
            $form->getField('images')->disable();
            $form->getField('files')->disable();
        }
        return $form->setLayout([
            [ 'lang', 'status', 'publish_status' ],
            [ 'm_duration', 'p_beg', 'p_end' ],
            [ 'is_leading', 'redirect_url', 'type' ],
            [ 'title' ],
            [ 'budget' ],
            [ 'description' ],
            [ 'content' ],
            [ 'header_img' ],
            [ 'images'],
            [ 'files' ]
        ]);
    }
    public function hasHistory(): bool
    {
        return true;
    }
    public function canRead(): bool
    {
        return true;
    }
    public function canDelete(): bool
    {
        return false;
    }
    public function getTemplate(string $name): TemplateInterface
    {
        if ($name !== 'programs') {
            throw new RuntimeException();
        }
        return $this->container->instance(ProgramsTemplate::class);
    }
    public function getTemplates(): array
    {
        return ['programs'];
    }
    public function getWidget(string $name): WidgetInterface
    {
        if ($name !== 'activeprograms') {
            throw new RuntimeException();
        }
        return $this->container->instance(ActiveProgramsWidget::class);
    }
    public function getWidgets(): array
    {
        return ['activeprograms'];
    }
}

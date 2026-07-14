<?php

declare(strict_types=1);

namespace nif\modules\site\program_categories;

use vakata\database\DBInterface;
use vakata\database\schema\TableQueryMapped;
use vakata\intl\Intl;
use vakata\user\User;
use webadmin\modules\common\crud\CRUDService;
use webadmin\modules\common\crud\CRUDModuleInterface;
use webadmin\modules\common\crud\CRUDServiceInterface;

/** @extends CRUDService<\schema\ProgramCategoriesEntity> */
class ProgramCategoriesService extends CRUDService
{
    protected Intl $intl;
    /** @param CRUDModuleInterface<\schema\ProgramCategoriesEntity,
     * CRUDServiceInterface<\schema\ProgramCategoriesEntity>> $module*/
    public function __construct(CRUDModuleInterface $module, DBInterface $db, User $user, Intl $intl)
    {
        parent::__construct($module, $db, $user);
        $this->intl = $intl;
    }
    public function listQuery(): TableQueryMapped
    {
        /** @var TableQueryMapped<\schema\ProgramCategoriesEntity> */
        return parent::listQuery()
            ->sort('sort_order', true)
            ->columns(['lang', 'name', 'is_active']);
    }
    public function intl(): Intl
    {
        return $this->intl;
    }
    /**
     * @return array<int,string>
     */
    public function languages(): array
    {
        return $this->user->languages;
    }
}

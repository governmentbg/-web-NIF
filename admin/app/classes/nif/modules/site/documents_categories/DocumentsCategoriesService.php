<?php

declare(strict_types=1);

namespace nif\modules\site\documents_categories;

use webadmin\modules\common\crud\CRUDModuleInterface;
use webadmin\modules\common\crud\CRUDServiceInterface;
use vakata\database\DBInterface;
use vakata\intl\Intl;
use vakata\user\User;
use webadmin\modules\common\crud\CRUDService;
use vakata\database\schema\TableQueryMapped;

/** @extends CRUDService<\schema\DocumentsCategoriesEntity> */
class DocumentsCategoriesService extends CRUDService
{
    protected Intl $intl;
    /** @param CRUDModuleInterface<\schema\DocumentsCategoriesEntity,
     * CRUDServiceInterface<\schema\DocumentsCategoriesEntity>> $module*/
    public function __construct(CRUDModuleInterface $module, DBInterface $db, User $user, Intl $intl)
    {
        parent::__construct($module, $db, $user);
        $this->intl = $intl;
    }
    public function listQuery(): TableQueryMapped
    {
        /** @var TableQueryMapped<\schema\DocumentsCategoriesEntity> */
        return parent::listQuery()
            ->columns(['lang', 'name', 'ord']);
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

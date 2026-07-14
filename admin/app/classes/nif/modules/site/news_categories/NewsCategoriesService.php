<?php

declare(strict_types=1);

namespace nif\modules\site\news_categories;

use vakata\database\DBInterface;
use vakata\intl\Intl;
use vakata\user\User;
use webadmin\modules\common\crud\CRUDModuleInterface;
use webadmin\modules\common\crud\CRUDService;
use webadmin\modules\common\crud\CRUDServiceInterface;

/** @extends CRUDService<\schema\NewsCategoriesEntity> */
class NewsCategoriesService extends CRUDService
{
    protected Intl $intl;
    /**
     * @param CRUDModuleInterface<\schema\NewsCategoriesEntity,
     * CRUDServiceInterface<\schema\NewsCategoriesEntity>> $module
     * @param DBInterface $db
     * @param User $user
     * @param Intl $intl
     */
    public function __construct(CRUDModuleInterface $module, DBInterface $db, User $user, Intl $intl)
    {
        parent::__construct($module, $db, $user);
        $this->intl = $intl;
    }
    public function intl(): Intl
    {
        return $this->intl;
    }
    public function languages(): array
    {
        return $this->user->languages;
    }
}

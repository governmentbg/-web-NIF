<?php

declare(strict_types=1);

namespace nif\modules\site\infoblocks;

use vakata\database\DBInterface;
use vakata\intl\Intl;
use vakata\user\User;
use webadmin\modules\common\crud\CRUDModuleInterface;
use webadmin\modules\common\crud\CRUDService;
use webadmin\modules\common\crud\CRUDServiceInterface;

/** @extends CRUDService<\schema\InfoblocksEntity> */
class InfoblocksService extends CRUDService
{
    protected DBInterface $db;
    protected User $user;
    protected Intl $intl;
    /**
     * @param CRUDModuleInterface<\schema\InfoblocksEntity,CRUDServiceInterface<\schema\InfoblocksEntity>> $module
     */
    public function __construct(CRUDModuleInterface $module, DBInterface $db, User $user, Intl $intl)
    {
        parent::__construct($module, $db, $user);
        $this->db = $db;
        $this->user = $user;
        $this->intl = $intl;
    }
    /**
     * @return array<int,string>
     */
    public function getLanguages(): array
    {
        return $this->user->languages;
    }
    public function intl(): Intl
    {
        return $this->intl;
    }
}

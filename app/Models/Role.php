<?php

namespace App\Models;

use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
{
    public const ADMIN_ROLE = 'Administrador';
    public const MANAGER_ROLE = 'Gerente';
    public const TEAM_MEMBER_ROLE = 'Vendedor';

    public const ADMIN_ROLE_ID = 1;
    public const MANAGER_ROLE_ID = 2;
    public const TEAM_MEMBER_ROLE_ID = 3;
}

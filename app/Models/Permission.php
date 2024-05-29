<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as ModelsPermission;

class Permission extends ModelsPermission
{
    use HasFactory;

    public const ADMIN_PERMISSIONS = [
        'Add User',
        'Edit User',
        'Delete User',
        'Add Role',
        'Edit Role',
        'Delete Role',
        'View Reporting',
        'Manage Brand Settings',
    ];

    public const MANAGER_PERMISSIONS = [
        'Add User',
        'Edit User',
        'Delete User',
        'Add Client',
        'Edit Client',
        'Delete Client',
        'Add Product',
        'Edit Product',
        'Delete Product',
        'Add Sale',
        'Edit Sale',
        'Cancel Sale',
    ];

    public const TEAM_MEMBER_PERMISSIONS = [
        'Add Client',
        'Edit Client',
        'Delete Client',
        'Add Product',
        'Edit Product',
        'Delete Product',
        'Add Sale',
        'Edit Sale',
        'Cancel Sale',
    ];
}

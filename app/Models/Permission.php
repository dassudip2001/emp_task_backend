<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as PermissionAlias;

class Permission extends PermissionAlias
{

    protected $hidden = [
        'pivot',
        'guard_name',
        'updated_at',
        'userId'

    ];
}

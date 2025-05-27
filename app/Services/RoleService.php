<?php

namespace App\Services;

use App\DTOs\RoleDto;
use App\Models\Role;

class RoleService
{
    public function create(RoleDto $roleDto): Role
    {
        return Role::create($roleDto->toArray());
    }
}

<?php

namespace App\Models\Traits;

use App\Enums\RoleEnum;

trait RoleTrait
{
    public function isAdmin(): bool
    {
        return auth()->user()->hasRole(RoleEnum::ADMIN);
    }

    public function isAuthor(): bool
    {
        return auth()->user()->hasRole(RoleEnum::AUTHOR);
    }
}

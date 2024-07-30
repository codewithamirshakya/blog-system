<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::where('email', 'admin@blog.com')->first()->assignRole(RoleEnum::ADMIN);
        User::where('email', 'author@blog.com')->first()->assignRole(RoleEnum::AUTHOR);

        Role::where(['name' => RoleEnum::AUTHOR])->first()->syncPermissions(PermissionSeeder::$permissions);
        Role::where(['name' => RoleEnum::AUTHOR])->first()->syncPermissions(PermissionSeeder::$authorPermissions);

    }
}

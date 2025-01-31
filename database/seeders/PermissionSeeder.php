<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public static array $permissions = [
        'create-users',
        'edit-users',
        'delete-users',
        'list-users',
        'view-users',
        'create-posts',
        'edit-posts',
        'delete-posts',
        'list-posts',
        'view-posts',
        'create-category',
        'edit-category',
        'delete-category',
        'list-category',
        'view-category',
        'create-comments',
        'edit-comments',
        'delete-comments',
        'list-comments',
        'view-comments',
    ];

    public static array $authorPermissions = [
        'list-posts',
        'view-posts',
        'create-posts',
        'edit-posts',
        'delete-posts',
        'list-category',
        'view-category',
        'create-category',
        'edit-category',
        'delete-category',
        'create-comments',
        'edit-comments',
        'delete-comments',
        'list-comments',
        'view-comments',
    ];

    /**
     * - **Admin Role:** Users with admin privileges have access to administrative
     * features and can perform actions such as managing users, posts, categories,
     * tags and comment. Such as  ability to delete any users, posts, categories, tags and comments.
     *
     * - **Author Role:** All users registering within the application are assigned the author
     * role by default. Authors can create, edit, and delete their own posts and comments but
     * cannot perform administrative tasks.
     */
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions

        foreach (self::$permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}

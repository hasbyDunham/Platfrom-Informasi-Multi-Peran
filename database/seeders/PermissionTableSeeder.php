<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'categorie-list',
            'categorie-create',
            'categorie-edit',
            'categorie-delete',
            'information-list',
            'information-create',
            'information-edit',
            'information-delete',
            'information-approve',
            'information-reject',
            'comment-list',
            'comment-create',
            'comment-edit',
            'comment-delete',
         ];

         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }

    }
}

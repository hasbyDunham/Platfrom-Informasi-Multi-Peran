<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class WriterRoleSeeder extends Seeder
{
    public function run()
    {
        // Buat role Writer
        $role = Role::create(['name' => 'Writer']);

        // Daftar permission yang akan diberikan ke Writer
        $permissions = [
            'information-list',
            'information-create',
            'information-edit',
            'information-delete',
        ];

        // Buat permission jika belum ada, lalu ambil ID-nya
        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName]);
        }

        // Sinkronisasi permission ke role Writer
        $role->syncPermissions($permissions);

        // (Opsional) Assign role ke user tertentu, misalnya user pertama
        // $user = User::find(1); // Ganti sesuai kebutuhan
        // if ($user) {
        //     $user->assignRole([$role->name]);
        // }
    }
}


<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Permission::create(['name' => 'profile.index']);
        Permission::create(['name' => 'profile.view']);
        Permission::create(['name' => 'profile.create']);
        Permission::create(['name' => 'profile.edit']);
        Permission::create(['name' => 'profile.permissions.edit']);
        Permission::create(['name' => 'profile.destroy']);
        Permission::create(['name' => 'permission.index']);
        Permission::create(['name' => 'permission.view']);
        Permission::create(['name' => 'permission.create']);
        Permission::create(['name' => 'permission.edit']);
        Permission::create(['name' => 'permission.destroy']);
        Permission::create(['name' => 'user.index']);
        Permission::create(['name' => 'user.view']);
        Permission::create(['name' => 'user.create']);
        Permission::create(['name' => 'user.edit']);
        Permission::create(['name' => 'user.edit.password']);
        Permission::create(['name' => 'user.profiles.edit']);
        Permission::create(['name' => 'user.destroy']);
        Permission::create(['name' => 'pdf.index']);
        Permission::create(['name' => 'pdf.view']);
        Permission::create(['name' => 'pdf.create']);
        Permission::create(['name' => 'pdf.edit']);
        Permission::create(['name' => 'pdf.destroy']);
        Permission::create(['name' => 'txt.index']);
        Permission::create(['name' => 'txt.view']);
        Permission::create(['name' => 'txt.create']);
        Permission::create(['name' => 'txt.edit']);
        Permission::create(['name' => 'txt.destroy']);
        Permission::create(['name' => 'request.index']);
        Permission::create(['name' => 'request.view']);
        Permission::create(['name' => 'request.create']);
        Permission::create(['name' => 'request.edit']);
        Permission::create(['name' => 'request.destroy']);
    }
}
